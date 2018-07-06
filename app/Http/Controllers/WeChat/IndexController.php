<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariable;
use App\Models\UserAction;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $interfaces = [
            "onMenuShareTimeline", "onMenuShareAppMessage",
            "onMenuShareQQ", "scanQRCode",
            "chooseWXPay", "getLocation",
            "chooseImage", "previewImage",
            "uploadImage", "downloadImage",
        ];
        $products = ProductVariable::with("product")
                  ->orderBy("buy","desc")
                  ->limit(20)
                  ->get();
        foreach ($products as $product) {
          if($product->product->is_ton){
            $product->stock = $product->stock * $product->product->content/1000 . "吨";
            $product->product->price = $product->unit_price * 1000 / $product->product->content . "/吨";
          }else{
            $product->stock = $product->stock . $product->product->packing_unit;
            $product->product->price = floatval($product->unit_price) . "/" . $product->product->packing_unit;
          }
          $product->product->address = str_replace(array('省', '市'), array('', ''), $product->product->storage->address->province);
        }
        $hot_search =new UserAction();
        return view("wechat.index", [
            "user" => auth()->user(),
            "interfaces" => $interfaces,
            "products" => $products,
            "hot_search" => $hot_search->hotSearch(),
            "title" => "太好买－首页",
        ]);
    }
}
