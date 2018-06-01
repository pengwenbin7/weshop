<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductStar as Star;
use App\Models\Product;

class StarController extends Controller
{
    public function all(Request $request)
    {
      $stars = auth()->user()->stars;
      foreach($stars as $star){
          $star->brand_name = $star->brand->name;
          $star->unit_price = $star->variable->unit_price;
      }
               // return $stars;
         return view("wechat.home.product_star", ["stars" => $stars, "title" => "我的收藏"]);
    }

    public function star($id)
    {
        return Star::firstOrCreate([
            "user_id" => auth()->user()->id,
            "product_id" => $id,
        ]);
    }

    public function unstar($id)
    {
        $star = Star::where("product_id", "=", $id)
              ->where("user_id", "=", auth()->user()->id)
              ->get();
        if ($star->isNotEmpty()) {
            return ["unstar" => $star->first()->delete()];
        } else {
            return ["unstar" => null];
        }
    }
}
