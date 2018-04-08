<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

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
        
        // fetch product
        foreach ($request->products as $p) {
            // create order items
            $item = new OrderItem();
            $product = Product::find($p->id);
            $item->order_id = $order->id;
            $item->product_id = $product->id;
            $item->is_ton = $p->is_ton;
            $item->number = $p->number;
            $item->price = $product->price()->unit_price;
            $item->product_name = $product->name;
            $item->model = $prodcut->model;
            $item->brand_name = $product->brand->name;
            $res = $res & $item->save();
        }
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
