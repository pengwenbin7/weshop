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
        $products = ProductVariable::with("product")->orderBy("buy","desc")->limit(10)->get();
        $hot_search =new UserAction();
        return view("wechat.index", [
            "user" => auth()->user(),
            "interfaces" => $interfaces,
            "products" => $products,
            "hot_search" => $hot_search->hotSearch(),
            "title" => "首页",
        ]);
    }
}
