<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Storage;
use App\Models\CartItem;
use App\Models\PayChannel;
use App\Models\Product;
use App\Utils\Count;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the cart,
     * and generate order.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $carts = Cart::with(["address", "cartItems"])
               ->where("user_id", "=", $user->id)
               ->orderBy("id")
               ->get();
        return view("wechat.cart.index", [
            "user" => $user,
            "carts" => $carts,
            "title" => "选购单",
            "interfaces" => ["getLocation"],
        ]);
    }

    /**
     * store a new cart
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = Cart::create([
            "user_id" => auth()->user()->id,
            "address_id" => $request->address_id,
        ]);

        return ["cart_id" => $cart->id];
    }

    /**
     * Add a product to a cart
     */
    public function addProduct(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        $item = CartItem::where("cart_id", "=", $request->cart_id)
                  ->where("product_id", "=", $request->product_id)
                  ->get();
        if ($item->isEmpty()) {
            $item = CartItem::create([
                "cart_id" => $cart->id,
                "product_id" => $request->product_id,
                "number" => $request->num,
            ]);
        } else {
            $item = $item->first();
            $item->number = $request->num;
            $item->save();
        }

        return ["add" => $item->id];
    }

    public function show(Cart $cart)
    {
        $items = CartItem::where("cart_id", "=", $cart->id)
               ->with("product")->get();
        $products = [];
        foreach ($items as $item)
        {
            $products[$item->product->storage_id][] = $item;
            $item->brand_name = $item->product->brand->name;
            $item->stock = $item->product->variable->stock;
             $item->unit_price = $item->product->variable->unit_price;
            if($item->product->is_ton){
                $item->price = $item->product->variable->unit_price * 1000 / $item->product->content;
            }else {
                $item->price = $item->product->variable->unit_price;
            }

            $item->func = $item->product->storage->func;
            $item->distance = Count::distance($cart->address->id,$item->product->storage->address_id);
        }
        return view("wechat.cart.show", [
            "cart" => $cart,
            "items" => json_encode($items),
            "products" => json_encode($products),
            "title" => "选购单",
        ]);
    }
    public function buyAll(Request $request)
    {

        $products = [];
        $varia = json_decode($request->products);
        $cart = Cart::find($request->cart_id);
        foreach ($varia as $key => $item) {
            $items[] = Product::find($item->id);
            $items[$key]->number = $item->number;
        }
        foreach ($items as $item) {
            $products[$item->storage_id][] = $item;
            $item->brand_name = $item->brand->name;
            if($item->is_ton){
                $item->price = $item->variable->unit_price * 1000 / $item->content;
            }else{
                $item->price = $item->variable->unit_price;
            }

        }
        $freight = 0;
        $totalPrice = 0;
        foreach ($products as $key => $item) {
            $weight=0;
            $distance =0 ;
            $distance=Count::distance($cart->address->id, Storage::find($key)->address_id);
            foreach ($item as $product) {
                $weight += $product->content * $product->number;
                $totalPrice += $product->number * $product->variable->unit_price;
            }
            $freight += Count::freight($key,$weight,$distance);
        }
        
        $coupons = auth()->user()->coupons;
        foreach ($coupons as $key => $coupon) {
            $coupon->expire_time = $coupon->expire->toDateString();
        }
        $data["products"] = $products;
        $data["payChannels"] = PayChannel::get();
        $data["user"] = auth()->user();
        $data["varia"] = json_encode($varia);
        $data["coupons"] = $coupons;
        $data["freight"] = $freight;
        $data["totalPrice"] = $totalPrice;
        $data["cart"] = Cart::find($request->cart_id);
        $data["title"] = "创建订单";
        return view("wechat.order.creates",   $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->cartItems()->delete();
        return ["delete" => $cart->delete()];
    }
}
