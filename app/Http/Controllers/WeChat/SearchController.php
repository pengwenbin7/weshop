<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserAction;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $key = $request->input("keyword", '');
        if (!$key) {
            $products = Product::with(["brand", "variable", "categories"])
                      ->where("active", "=", 1)
                      ->get();
            return view("wechat.search",["products" => $products]);
        }
        $arr = preg_split("/[\s]+/", $key);
        $pobj = new Product();
        foreach ($arr as $k) {
            UserAction::create([
                "user_id" => auth()->user()->id,
                "keyword" => $k,
                "action" => "search",
            ]);
            $pobj = $pobj->where(
                function ($query) use ($k) {
                    return $query->where("keyword", "like", "%$k%");
                });
        }
        $products = $pobj->with(["brand", "variable", "categories"])
                  ->where("active", "=", 1)
                  ->paginate(20);
        return view("wechat.search",["products" => $products]);
    }
}
