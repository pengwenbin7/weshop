<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Cache;

class ShipmentController extends Controller
{
    public function __construct()
    {
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input("limit", 15);
        $shipments = Shipment::orderBy("id", "desc")->paginate($limit);
        return view("admin.shipment.index", [
            "shipments" => $shipments,
            "limit" => $limit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function show(Shipment $shipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipment $shipment)
    {
        return view("admin.shipment.edit", ["shipment" => $shipment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipment $shipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        //
    }

    public function purchased(Request $request, Shipment $shipment)
    {
        $shipment->purchased($request->cost);
        return redirect()->route("admin.shipment.edit", $shipment);
    }

    public function shipped(Request $request, Shipment $shipment)
    {
        $shipment->shipped($request->freight);
        return redirect()->route("admin.shipment.edit", $shipment);
    }

    public function trian(Request $request)
    {
        if(Cache::has($request->id)){
            $span = '';
            foreach (Cache::get($request->id) as $item) {
                $span.= $item->product_name."-".$item->model."<br>";
            }
            return ['status' => 'ok', 'info' => $span];
        }else{
            $spitem = OrderItem::where('order_id', '=' ,$request->id)->get();
            Cache::put($request->id,$spitem,10);
            $span = '';
            foreach ($spitem as $item) {
                $span.= $item->product_name."-".$item->model."<br>";
            }
            return ['status' => 'ok', 'info' => $span];
        }

    }
}
