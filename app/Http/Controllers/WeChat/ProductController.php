<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $condition = null;
        $categories = Category::all();
        $brands = Brand::all();
        $products = Product::with(["brand", "storage", "variable"])->paginate(2);
        return view("wechat.product.index", [
            "products" => $products,
            "categories" => $categories,
            "brands" => $brands,
        ]);
    }

    public function show(Product $product)
    {
        return view("wechat.product.show", ["product" => $product]);
    }
}
