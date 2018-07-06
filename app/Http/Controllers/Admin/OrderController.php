<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Events\OrderPaidEvent;
use App\Jobs\ShipmentPurchased;
use App\Jobs\OrderShipped;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input("limit", 25);
        $name = $request->input("name", '');
        $page = $request->input("page", '');
        $condition = null;
        $orders = Order::with(["orderItems", "payment", "shipments"])
                ->where("admin_id", "like", "%$name%")
                ->orderBy("id", "desc")
                ->paginate($limit);
        $serial = 1;
        if(!empty($page) && $page != 1){
            $serial = $page * $limit - $limit + 1;
        }
        $line_num = $orders -> total();
        return view("admin.order.index", [
            "serial" => $serial,
            "line_num" => $line_num,
            'name' => $name,
            "orders" => $orders,
            'limit' => $limit
        ]);
    }

    public function mine(Request $request)
    {
        $limit = $request->input("limit", 25);
        $name = $request->input("name", '');
        $page = $request->input("page", '');
        $condition = null;
        $orders = Order::with(["orderItems", "payment", "shipments"])
                ->where("admin_id", "=", auth("admin")->user()->id)
                ->orderBy("updated_at", "desc")
                ->paginate($limit);
        $serial = 1;
        if(!empty($page) && $page != 1){
            $serial = $page * $limit - $limit + 1;
        }
        $line_num = $orders -> total();
        return view("admin.order.index", [
            "serial" => $serial,
            "line_num" => $line_num,
            'name' => $name,
            "orders" => $orders,
            'limit' => $limit
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view("admin.order.show", ["order" => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $orders = Order::with(["orderItems", "payment", "shipments"])
                ->find($order->id);
        return $orders;
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
        // return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function paid(Order $order)
    {
        $order->payment_status = Order::PAY_STATUS_DONE;
        $res = $order->save();
        if ($res) {
            event(new OrderPaidEvent($order)); // 触发监听事件
        }
        return ["res" => $res];
    }

}
