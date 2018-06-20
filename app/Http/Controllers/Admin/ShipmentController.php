<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Jobs\ShipmentPurchased;
use App\Jobs\ShipmentShipped;

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
        //
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

    public function purchased(Shipment $shipment)
    {
        $shipment->purchase = 1;
        $res = $shipment->save();
        if ($res) {
            dispatch(new ShipmentPurchased($shipment));
        }
        return ["res" => $res];
    }

    public function shipped(Shipment $shipment)
    {
        $shipment->status = Shipment::SHIPMENT_STATUS_DONE;
        $res = $shipment->save();
        if ($res) {
            dispatch(new ShipmentShipped($shipment));
        }
        return ["res" => $res];
    }
}
