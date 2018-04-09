<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $condition = null;
        $products = Product::with(["brand", "storage", "variable"])->paginate(2);
        return view("wechat.product.index", ["products" => $products]);
    }

    public function show(Product $product)
    {
        return view("wechat.product.show", ["product" => $product]);
    }
}
