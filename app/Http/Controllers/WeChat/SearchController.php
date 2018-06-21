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
            foreach ($products as $product) {
                  $product->address = str_replace(array('省', '市'), array('', ''), $product->storage->address->province);
                  if($product->is_ton){
                      $product->stock = $product->variable->stock * $product->content /1000 . "吨";
                      $product->price = $product->variable->unit_price * 1000 / $product->content . "/吨";
                  }else{
                      $product->stock = $product->variable->stock .  $product->packing_unit;
                      $product->price = floatval($product->variable->unit_price) . "/" . $product->packing_unit;
                  }
            }
            return view("wechat.search",["products" => $products, "title" => "搜索"]);
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
        foreach ($products as $product) {
              $product->address = str_replace(array('省', '市'), array('', ''), $product->storage->address->province);
              if($product->is_ton){
                  $product->stock = $product->variable->stock * $product->content /1000 . "吨";
                  $product->price = $product->variable->unit_price * 1000 / $product->content . "/吨";
              }else{
                  $product->stock = $product->variable->stock .  $product->packing_unit;
                  $product->price = floatval($product->variable->unit_price) . "/" . $product->packing_unit;
              }
        }
        return view("wechat.search",["products" => $products, "title" => $key."-搜索结果" ]);
    }
}
