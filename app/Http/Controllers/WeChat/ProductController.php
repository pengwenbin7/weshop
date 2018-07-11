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
use App\Models\Address;
use App\Utils\Count;

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
            ->get();

        $ids = [];

        foreach ($pcs as $i) {
            $ids[] = $i["product_id"];
        }
        $products = Product::whereIn("id", $ids)
            ->where("active", "=", 1)
            ->paginate($limit);
//        $products = $arr->toArray()["data"];
        foreach ($products as  $product) {
            $product->brand_name = $product->brand->name;
            if($product->is_ton){
                $product->stock = $product->variable->stock * $product->content /1000 . "吨";
                $product->price = $product->variable->unit_price * 1000 / $product->content ."/吨";
            }else{
                $product->stock = $product->variable->stock . $product->packing_unit;
                $product->price = floatval($product->variable->unit_price) . "/" . $product->packing_unit;
            }
            $product->address = str_replace(array('省', '市'), array('', ''), $product->storage->address->province);
        }
        $pcs = $products ->lastPage();
        $products = $products->toArray()["data"];

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
        $product->address = str_replace(array('省', '市'), array('', ''), $product->storage->address->province);
        if($product->is_ton){
            $product->stock = $product->variable->stock * $product->content /1000 . "吨";
            $product->price = $product->variable->unit_price * 1000 / $product->content . "/吨";
        }else{
            $product->stock = $product->variable->stock .  $product->packing_unit;
            $product->price = floatval($product->variable->unit_price);
        }
        $product->prices=json_encode($product->prices);
        return view("wechat.product.show", ["product" => $product, "title" => $product->name,]);
    }

    public function buyMe(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->number = $request->num;
        if($product->is_ton ){
            $product->price = $product->variable->unit_price * 1000 / $product->content . "/吨";
        }else{
            $product->price = $product->variable->unit_price . "/" . $product->packing_unit;
        }
        $coupons = auth()->user()->coupons;
        $address = null;
        $distance = null;
        if(auth()->user()->last_address){
            $address = Address::find(auth()->user()->last_address);
            $distance = Count::distance(auth()->user()->last_address,$product->storage->address_id);
        }
        foreach ($coupons as $key => $coupon) {
            $coupon->expire_time = $coupon->expire->toDateString();
        }
        $data["product"] = $product;
        $data["distance"] = $distance;
        $data["coupons"] = json_encode($coupons);
        $data["address"] = $address;
        $data["interfaces"] = ["getLocation"];
        $data["title"] = "创建订单";
        return view("wechat.order.create", $data);
    }
}
