<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Storage;
use App\Models\Address;
use App\Models\Config;
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
        return Storage::with(["address", "brand"])->get();
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
        $func = $request->func ??
              Config::where("key", "=", "storage.func")->first()->value;
        
        $address = Address::create([
            "contact_name" => $request->input("contact_name", null),
            "contact_tel" => $request->input("contact_tel", null),
            "province" => $request->province,
            "city" => $request->city,
            "district" => $request->district,
            "code" => $request->code,
            "detail" => $request->detail,
        ]);
        $storage = Storage::create([
            "name" => $request->name,
            "brand_id" => $request->brand_id,
            "address_id" => $address->id,
            "func" => $func,
            "description" => $request->input("description", null),
        ]);
        return ["save" => $storage->save()];
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
        $address = $storage->address;
        $address->contact_name = $request->input("contact_name", null);
        $address->contact_tel = $request->input("contact_tel", null);
        $address->province = $request->province;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->code = $request->code;
        $address->detail = $request->detail;
        $res = $address->save();
        
        $storage->name = $request->name;
        $storage->brand_id = $request->brand_id;
        $storage->active = $request->input("active", true);
        $storage->description = $request->input("description", null);
        $res = $res && $storage->save();
        return ["update" => $res];
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
