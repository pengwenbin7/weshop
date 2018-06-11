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
            if($star->is_ton){
                $star->price = $star->variable->unit_price * 1000 / $star->content;
                $star->stock = $star->variable->stock * $star->content /1000;
            }else{
                $star->price = floatval($star->variable->unit_price);
                $star->stock = $star->variable->stock;
            }
            $star->brand_name = $star->brand->name;
            $star->address = str_replace(array('省', '市'), array('', ''), $star->storage->address->province);

        }
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
