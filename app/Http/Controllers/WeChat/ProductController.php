<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\PayChannel;
use App\Models\coupon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $condition = null;
        $categories = Category::all();
        $brands = Brand::all();
        $products = Product::with(["brand", "storage", "variable"])->paginate(10);
        return view("wechat.product.index", [
            "products" => $products,
            "categories" => json_encode($categories),
            "brands" => $brands,
            "title" => "分类",
        ]);
    }

    public function show(Product $product)
    {
        $v = $product->variable;
        $v->click += 1;
        $v->save();
        return view("wechat.product.show", ["product" => $product, "title" => $product->name,]);
    }

    public function buyMe(Request $request)
    {
        $data["products"] = Product::find($request->product_id);
        $data["products"]->number = $request->num;
        $data["payChannels"] = PayChannel::get();
        $data["user"] = auth()->user();
        $data["price"] = Product::find($request->product_id)->variable->unit_price*$request->num;
        $coupons = auth()->user()->coupons;
        foreach ($coupons as $key => $coupon) {
          $coupon->expire_time = date("Y-m-d", strtotime($coupon->expire) );
        }
        $data["coupons"] = json_encode($coupons);
        return view("wechat.order.create", $data);
    }
}
