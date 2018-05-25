<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $key = $request->input("key", '');
        if (!$key) {
            return Product::with(["brand", "variable"])->all();
        }
        $arr = explode("\W", $key);
        $products = Product::where("name", "like", "%{$request->key}%")->get();
        return view("wechat.search",["products" => $products]);
    }
}
