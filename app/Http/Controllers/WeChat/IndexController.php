<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view("wechat.index", [
            "user" => auth()->user(),
            "interfaces" => $interfaces,
            "title" => "首页",
        ]);
    }
}
