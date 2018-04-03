<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Storage;
use App\Models\Address;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Storage::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.storage.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storage = new Storage();
        $address = new Address();
        $address->fill([
            "contact_name" => $request->input("contact_name"),
            "contact_tel" => $request->input("contact_tel"),
            "province" => $request->province,
            "city" => $request->city,
            "city_adcode" => $request->city_adcode,
            "detail" => $request->detail,
        ]);
        $address->save();
        $storage->fill([
            "name" => $request->name,
            "brand_id" => $request->brand_id,
            "address_id" => $address->id,
            "description" => $request->input("description", null),
        ]);
        $storage->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function show(Storage $storage)
    {
        $data["storage"] = $storage;
        $data["address"] = $storage->address;
        $data["brand"] = $storage->brand;
        $data["products"] = $storage->products;
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function edit(Storage $storage)
    {
        $data["storage"] = $storage;
        return view("admin.storage.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Storage $storage)
    {
        // update storage's address
        $address = $storage->address();
        $address->contact_name = $request->input("contact_name");
        $address->contact_tel = $request->input("contact_tel");
        $address->province = $request->province;
        $address->city = $request->city;
        $address->city_adcode = $request->city_adcode;
        $address->detail = $request->detail;
        $address->save();
        
        $storage->name = $request->name;
        $storage->brand_id = $request->brand_id;
        $storage->active = $request->input("active", 1);
        $storage->description = $request->input("description", null);
        $storage->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Storage $storage)
    {
        $storage->delete();
    }
}
