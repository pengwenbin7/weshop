<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductVariable;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input("limit", 15);
        $products = Product::with(["variable", "detail", "brand", "storage"])
                  ->orderBy("id", "desc")
                  ->paginate($limit);
        return view("admin.product.index", ["products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["categories"] = Category::all();
        $data["brands"] = Brand::all();
        $data["storages"] = Storage::all();
        return view("admin.product.create", $data);
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
        $product->storage_id = $request->storage_id;
        $product->content = $request->content;
        $product->measure_unit = $request->measure_unit;
        $product->packing_unit = $request->packing_unit;
        $product->sort_order = $request->input("sort_order", 1000);
        $product->active = $request->active;
        
        if (!$product->save()) {
            return ["err" => "save product error"];
        }

        // save product price
        ProductPrice::create([
            "product_id" => $product->id,
            "unit_price" => $request->unit_price,
        ]);
        
        // save product category
        ProductCategory::create([
            "product_id" => $product->id,
            "category_id" => $request->input("category_id"),
            "is_primary" => 1,
        ]);
        
        // save product variable
        ProductVariable::create([
            "product_id" => $product->id,
            "unit_price" => $request->unit_price,
            "stock" => $request->input("stock", 0),
        ]);
        
        $detail = $request->input("detail", false);
        if ($detail) {
            ProductDetail::create([
                "product_id" => $product->id,
                "content" => $detail,
            ]);
        }
        
        return redirect()->route("admin.product.index");
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
        return view("admin.product.edit", [
            "product" => $product,
            "categories" => Category::select("id", "name")->get(),
            "brands" => Brand::select("id", "name")->get(),
        ]);
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
        // update product
        $product->locale_id = $request->input("locale_id", 1);
        $product->name = $request->name;
        $product->brand_id = $request->brand_id;
        $product->model = $request->model;
        $product->storage_id = $request->storage_id;
        $product->content = $request->content;
        $product->measure_unit = $request->measure_unit;
        $product->packing_unit = $request->packing_unit;
        $product->active = $request->active;
        $product->sort_order = $request->input("sort_order", 1000);
        $product->save();

        // save product price
        if ($request->unit_price != $product->variable->unit_price) {
            $price = ProductPrice::create([
                "product_id" => $product->id,
                "unit_price" => $request->unit_price,
            ]);
            event(new ProductPriceChangedEvent($product));
        } 
        
        // 以下过程未做判断，有些是非必须的
        // save product primary category
        ProductCategory::firstOrCreate([
            "category_id" => $request->category_id,
            "product_id" => $product->id,
            "is_primary" => 1,
        ]);
        
        // save product variable
        $variable = $product->variable;
        $variable->stock = $request->stock;
        $variable->unit_price = $request->unit_price;
        $variable->save();
               
        // save product detail
        $detail = $product->detail;
        if ($request->has("detail")) {
            $detail = ProductDetail::firstOrCreate([
                "product_id" => $product->id,
            ]);
            $detail->content = $request->detail;
            $detail->save();
        }

        return redirect()->route("admin.product.show", $product);
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
