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
     * product_id, number, is_ton
     */
    public function create(Request $request)
    {
        $data["user"] = auth()->user();
        $data["product"] = Product::find($request->product_id);
        $data["number"] = $request->number;
        $data["is_ton"] = $request->is_ton;
        $data["payChannels"] = PayChannel::get();
        return view("wechat.order.create", $data);
    }

    /**
     * Add one product to order
     * @param  \Illuminate\Http\Request  $request
     * Except request format:
     * address_id, coupon_id, tax_id, products => [
     *   {product_id, is_ton, number}, {product_id, is_ton, number}
     * ]
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create order
        $user = auth()->user;
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
            $product = Product::find($p->id);
            $item->order_id = $order->id;
            $item->product_id = $product->id;
            $item->is_ton = $p->is_ton;
            $item->number = $p->number;
            $item->price = $product->variable->unit_price;
            // count total price
            if ($item->iston) {
                $payment->total += $p->number * 1000 /
                                $product->content *
                                $item->price;
            } else {
                $payment->total += $p->number * $item->price;
            }
            $item->product_name = $product->name;
            $item->model = $prodcut->model;
            $item->brand_name = $product->brand->name;
            $res = $res & $item->save();
        }
        if ($coupon->valid($user, $payment)) {
            $payment->coupon_id = $coupon->id;
            $discount = $coupon->discount;
        } else {
            $discount = 0;
        }
        $payment->freight = $order->countFreight();
        $payment->pay = $payment->total + $payment->freight -
                     $discount;
        $res = $res & $payment->save();
        
        return ["store" => $res];
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        return ["destroy" => $order->delete()];
    }
}
