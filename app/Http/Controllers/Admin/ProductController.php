<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.product.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->locale_id = $request->input("locale_id", 1);
        $product->name = $request->name;
        $product->brand_id = $request->brand_id;
        $product->model = $request->model;
        $product->content = $request->content;
        $product->measure_unit = $request->measure_unit;
        $product->packing_unit = $request->packing_unit;
        $product->ton_sell = $request->input("ton_sell", 1);
        $product->sort_order = $request->input("sort_order", 1000);
        $product->md5 = md5("{$product->locale_id}{$product->name}{$product->brand_id}{$product->model}{$product->content}{$product->measure_unit}{$product->packing_unit}");
        if ($product->save()) {
            $detail = new ProductDetail();
            $detail->fill([
                "product_id" => $product->id,
                "content" => $request->input("detail", null),
            ]);
            $detail->save();
            return ["store" => $detail->save()];
        } else {
            return ["store" => false];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view("admin.product.show", ["product" => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view("admin.product.edit", ["product" => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->locale_id = $request->input("locale_id", 1);
        $product->name = $request->name;
        $product->brand_id = $request->brand_id;
        $product->model = $request->model;
        $product->content = $request->content;
        $product->measure_unit = $request->measure_unit;
        $product->packing_unit = $request->packing_unit;
        $product->ton_sell = $request->input("ton_sell", 1);
        $product->sort_order = $request->input("sort_order", 1000);
        $product->md5 = md5("{$product->locale_id}{$product->name}{$product->brand_id}{$product->model}{$product->content}{$product->measure_unit}{$product->packing_unit}");
        return ["update" => $product->save()];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
