<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PayChannel;
use App\Models\Payment;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Storage;
use App\Utils\Count;
use Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $orders = Order::with(["orderItems", "shipments"])
                ->where("user_id", "=", $user->id)
                ->orderBy("created_at", "desc")
                ->get();
        return $orders;
    }

    /**
     * Create order from product
     * Except request:
     * products:
     *     [{id: id, number: number},
     *      {id: id, number: number}]
     */
    public function create(Request $request)
    {
        $data["user"] = auth()->user();
        
        $data["products"] = [];
        $ps = $request->products;
        foreach ($ps as $p) {
            $product = Product::with([
                "brand", "category", "storage",
                "detail", "variable",
            ])->find($p["id"]);
            $num = $p["number"];
            $data["products"][] = [
                "id" => $product,
                "number" => $num,
            ];
        }
        
        $data["payChannels"] = PayChannel::get();
        return view("wechat.order.create", $data);
    }

    /**
     * Add one product to order
     * @param  \Illuminate\Http\Request  $request
     * Except request format:
     * address_id, coupon_id, tax_id, products => [
     *   {product_id, number}, {product_id, number}
     * ]
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create order
        $user = auth()->user();
        $order = new Order();
        $order->user_id = $user->id;
        $order->address_id = $request->address_id;
        $order->coupon_id = $request->input("coupon_id", null);
        $order->tax_id = $request->input("tax_id", null);
        $order->status = Order::ORDER_STATUS_WAIT;
        $order->payment_status = Order::PAY_STATUS_WAIT;
        $order->shipment_status = Order::SHIP_STATUS_WAIT;
        $order->refund_status = Order::REFUND_STATUS_NULL;
        $order->admin_id = $user->admin_id;
        $res = $order->save();

        // create payment
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->channel_id = $request->channel_id;
        $payment->total = 0;
        $coupon = Coupon::find($request->coupon_id);
        
        // fetch product
        foreach ($request->products as $p) {
            // create order items
            $item = new OrderItem();
            $product = Product::find($p["id"]);
            $item->order_id = $order->id;
            $item->product_id = $product->id;
            $item->number = $p["number"];
            $item->price = $product->variable->unit_price;
            $item->storage_id = $product->storage_id;
            $payment->total += $p["number"] * $item->price;
            $item->product_name = $product->name;
            $item->model = $product->model;
            $item->brand_name = $product->brand->name;
            $res = $res & $item->save();
        }
        if ($coupon && $coupon->valid($user, $payment)) {
            $payment->coupon_id = $coupon->id;
            $discount = $coupon->discount;
        } else {
            $discount = 0;
        }
        $payment->freight = $order->countFreight();
        $payment->pay = $payment->total + $payment->freight -
                     $discount;
        $res = $res & $payment->save();
        if ($res) {
            return ["store" => $order->id];
        } else {
            return ["err" => "failed to create order"];
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $res = $order->address->delete();
        $res = $res & $order->delete();
        return ["destroy" => $res];
    }

    /**
     * count freight
     * 此计算结果仅仅用于前端展示
     * request format:
     *     int address_id
     *     array products:
     *               int id (product_id)
     *               int number (product number)
     */
    public function countFreight(Request $request)
    {
        $address = Address::find($request->address_id);
        // 按发货仓库分组
        $ss = [];
        foreach ($request->products as $p) {
            $product = Product::with("storage")->find($p["id"]);
            if (strtolower($product->measure_unit) != "kg") {
                return -1;
            }
            if (array_key_exists($product->storage->id, $ss)) {
                $ss[$p->storage->id] += $product->content * $p["number"];
            } else {
                $ss[$product->storage->id] = $product->content * $p["number"];
            }
        }
        
        // 分组计算运费
        $total = [];
        foreach ($ss as $storage_id => $weight) {
            $storage = Storage::with("address")->find($storage_id);
            $distance = Count::distance($address->id, $storage->address->id);
            $total[$storage_id] = Count::freight($storage_id, $weight, $distance);
        }
        return $total;
    }
}
