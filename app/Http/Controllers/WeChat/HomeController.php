<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use App\Models\Company;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        return view("wechat.home", ["user" => $user, "title" => "用户中心"]);
    }
    public function waiter()
    {
        $user = auth()->user();
        return view("wechat.home.waiter", ["user" => $user, "title" => "客服"]);
    }

    public function coupon()
    {
      $coupons = auth()->user()->coupons;
      return view("wechat.home.coupon", ["coupons" => $coupons, "title" => "优惠券"]);
    }
}
