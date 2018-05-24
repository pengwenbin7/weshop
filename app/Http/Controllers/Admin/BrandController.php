<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
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
        $key = $request->input("key", "");
        $brands = Brand::where("name", "like", "%$key%")->paginate($limit);
        return view("admin.brand.index", [
            "brands" => $brands,
            "key" => $key,
            "limit" => $limit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.brand.create", ["error" => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Brand::where("name", "=", $request->name)->get()->isNotEmpty()) {
            return view("admin.brand.create", ["error" => "名字不能重复"]);
        }
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->logo = $request->input("logo", null);
        $brand->sort_order = $request->input("sort_order", 100);
        $brand->active = $request->input("active", 1);
        $brand->locale_id = $request->input("locale_id", 1);
        $brand->save();
        return redirect()->route("admin.brand.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view("admin.brand.show", ["brand" => $brand]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view("admin.brand.edit", ["brand" => $brand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $brand->name = $request->name;
        $brand->logo = $request->input("logo", null);
        $brand->sort_order = $request->input("sort_order", 100);
        $brand->active = $request->input("active", 1);
        $brand->locale_id = $request->input("locale_id", 1);
        $brand->save();
        return redirect()->route("admin.brand.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
