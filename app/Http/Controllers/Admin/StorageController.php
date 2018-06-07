<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Storage;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Config;
use App\Models\Region;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input("limit", 15);
        $brand_id = $request->input("brand_id", false);
        $key = $request->input("key", false);
        $storages = Storage::
                  when($brand_id, function ($query) use ($brand_id) {
                          return $query->where("brand_id", "=", $brand_id);
                      })
                  ->when($key, function ($query) use ($key) {
                          return $query->where("name", "like", "%$key%");
                      })
                  ->paginate($limit);
        $brands = Brand::select("id", "name")->get();
        return $request->has("api")?
            $storages->items():
            view("admin.storage.index", [
                "storages" => $storages,
                "brand_id" => $brand_id,
                "key" => $key,
                "limit" => $limit,
                "brands" => $brands,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $brands = Brand::all();
        $region = new Region();
        return view("admin.storage.create", [
            "brands" => $brands,
            "region" => $region,
        ]);
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

        $district = $request->has("district")?
                  Region::find($request->district)->fullname:
                  null;
        $address = Address::create([
            "contact_name" => $request->input("contact_name", null),
            "contact_tel" => $request->input("contact_tel", null),
            "province" => Region::find($request->province)->fullname,
            "city" => Region::find($request->city)->fullname,
            "district" => $district,
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
        $storage->save();
        return redirect()->route("admin.storage.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function show(Storage $storage)
    {
        $s = Storage::with(["brand", "products", "address"])
           ->find($storage->id);
        return $s;
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
        $data["brands"] = Brand::select("id", "name")->get();
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
        return redirect()->route("admin.storage.index");
    }
}
