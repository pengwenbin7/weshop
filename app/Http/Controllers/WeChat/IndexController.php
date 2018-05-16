<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariable;

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
        $products = ProductVariable::with("product")->orderBy("buy","desc")->limit(10)->get();
        return view("wechat.index", [
            "user" => auth()->user(),
            "interfaces" => $interfaces,
            "products" => $products,
            "title" => "首页",
        ]);
    }
}
