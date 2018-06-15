<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PayChannel;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Storage;
use App\Utils\Count;
use App\Models\Payment;
use App\Jobs\SendContract;
use Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $status = $request->order_status;
        // return $status;
        $orders = Order::with(["orderItems", "shipments"])
                ->where("user_id", "=", $user->id)
                ->when($status!=null,function ($query) use ($status) {
                    return $query->where('payment_status', '=', $status);
                })
                ->orderBy("created_at", "desc")
                ->get();
        return view("wechat.order.index",["orders"=>$orders, "title" => "我的订单"]);
    }

    public function show(Order $order)
    {
        return view("wechat.order.show",["order" => $order, "title" => "订单详情"]);
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
        return view("wechat.order.create", ["date" => $data, "title" => "提交订单"]);
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
        // save order
        $order->save();
        $order = Order::find($order->id);
        // fetch product
        $totalPrice = 0;
        foreach ($request->products as $p) {
            // create order items
            $product = Product::find($p["id"]);
            $item = OrderItem::create([
                "order_id" => $order->id,
                "product_id" => $product->id,
                "number" => $p["number"],
                "price" => $product->variable->unit_price,
                "storage_id" => $product->storage_id,
                "product_name" => $product->name,
                "model" => $product->model,
                "brand_name" => $product->brand->name,
                "packing_unit" => $product->packing_unit,
            ]);
            $totalPrice += $item->price * $item->number;
        }
        // create payment
        $payment = Payment::create([
            "order_id" => $order->id,
            "channel_id" => PayChannel::all()->first()->id,
            "total" => $totalPrice,
            "freight" => $order->countFreight(),
        ]);
        if ($request->input("coupon_id", false)) {
            $coupon = Coupon::find($request->coupon_id);
            if ($coupon && $coupon->valid($user, $payment)) {
                $payment->coupon_discount = $coupon->discount;
            } else {
                Log::info("payment: {$payment->id}, fail coupon: {$coupon->id}");
            }
        }
        $payment->save();
        return ["store" => $order->id];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if ($order->canRemove()) {
            $res = $order->address->delete();
            $res = $res & $order->delete();
            return ["destroy" => $res];
        } else {
            return ["err" => "Don't allow"];
        }
    }
    
    public function contract(Order $order)
    {
        $user = auth()->user();
        if (!$user->company) {
            // 公司认证
            return redirect()->route("wechat.company.create");
        } else {
            // 下载合同
            dispatch(new SendContract($user, $order));
        }
    }

}
