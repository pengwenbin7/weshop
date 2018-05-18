<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;

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
    public function productStar()
    {
        $stars = auth()->user()->stars;
        foreach($stars as $star){
            $star->brand_name = $star->brand->name;
            $star->unit_price = $star->variable->unit_price;
        }
        return view("wechat.home.product_star", ["stars" => json_encode($stars), "title" => "我的收藏"]);
    }
    public function coupon(){
      $coupons = auth()->user()->coupons;
      return view("wechat.home.coupon", ["coupons" => $coupons, "title" => "优惠券"]);
    }

}
