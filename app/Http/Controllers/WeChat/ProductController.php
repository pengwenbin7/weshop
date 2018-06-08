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
use App\Models\ProductCategory;
use App\Models\ProductStar;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $firstCategoryId = $categories->first()->id;
        $id = $request->input("id", $firstCategoryId);

        $limit = $request->input("limit", 15);

        // get products' id of the category
        $pcs = ProductCategory::where("category_id", "=", $id)
             ->where("is_primary", "=", 1)
             ->select("product_id")
             ->paginate($limit);
        $ids = [];
        $arr = $pcs->toArray()["data"];
        foreach ($arr as $i) {
            $ids[] = $i["product_id"];
        }
        $products = Product::whereIn("id", $ids)
                  ->where("active", "=", 1)
                  ->get();
        foreach ($products as  $product) {
          $product->unit_price = $product->variable->unit_price;
          $product->brand_name = $product->brand->name;
          $product->city = $product->storage->address->city;
        }
        if ($request->has("id")) {
            return [
                "products" => $products,
                "pcs" => $pcs,
            ];
        } else {
            return view("wechat.product.index", [
                "products" => json_encode($products),
                "categories" => json_encode($categories),
                "pcs" => $pcs,
                "title" => "分类",
            ]);

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
        $star = ProductStar::where("user_id", "=", auth()->user()->id)
          ->where("product_id","=",$product->id)
          ->get()
          ->isEmpty();

          $prices = $product->prices;
          foreach ($prices as $price) {
            $price->updated = $price->updated_at->toDateString();
          }
          $product->star = !$star;
          $product->prices=json_encode($product->prices);
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
