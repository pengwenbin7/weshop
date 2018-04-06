<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * create order from product
     */
    public function create(Request $request)
    {
        $data["user"] = auth()->user();
        $data["product"] = Product::find($request->product_id);
        $data["number"] = $request->number;
        $data["ton_sell"] = $request->ton_sell;
        return view("wechat.order.create", $data);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
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
        $order->payment_status = Order::PAY_STATUS_WAIT;
        $order->shipment_status = Order::SHIP_STATUS_WAIT;
        $order->status = Order::ORDER_STATUS_WAIT;
        $order->admin_id = $user->admin_id;
        $order->save();
        // create order items
        foreach ($request->product_ids as $product_id) {
            
        }
    }

    public function edit(Order $order)
    {
        
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if (!$order->active) {
            return ["destroy" => $order->delete()];
        } else {
            return ["err" => "Can't destroy the order."];
        }
    }
}
