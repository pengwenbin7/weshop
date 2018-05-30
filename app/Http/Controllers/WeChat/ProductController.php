<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\PayChannel;
use App\Models\coupon;
use App\Models\UserAction;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $page = 1;
        if($id==""){
        $condition = null;
        $categories = Category::all();
        $brands = Brand::all();
        $products = Category::find(1)->products;
        return view("wechat.product.index", [
            "products" => json_encode($products),
            "categories" => json_encode($categories),
            "brands" => $brands,
            "title" => "分类",
        ]);
      }else{
        $products = Category::find($id)->products;
        return $products;
      }
    }

    public function show(Product $product)
    {
        $v = $product->variable;
        $v->click += 1;
        $v->save();
        UserAction::create([
            "user_id" => auth()->user()->id,
            "product_id" => $product->id,
            "action" => "view",
        ]);
        return view("wechat.product.show", ["product" => $product, "title" => $product->name,]);
    }

    public function buyMe(Request $request)
    {
        $data["products"] = Product::find($request->product_id);
        $data["products"]->number = $request->num;
        $data["payChannels"] = PayChannel::get();
        $data["user"] = auth()->user();
        $data["price"] = Product::find($request->product_id)
                       ->variable
                       ->unit_price * $request->num;
        $coupons = auth()->user()->coupons;
        foreach ($coupons as $key => $coupon) {
            $coupon->expire_time = $coupon->expire->toDateString();
        }
        $data["coupons"] = json_encode($coupons);
        $data["interfaces"] = ["getLocation"];
        return view("wechat.order.create", $data);
    }
}
