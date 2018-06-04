<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
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

        $item = CartItem::firstOrCreate([
                "cart_id" => $cart->id,
                "product_id" => $request->product_id,
                "number" => $request->num,
        ]);

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
            $item->price = $item->product->variable->unit_price;
            $item->func = $item->product->storage->func;
            $item->distance = Count::distance($cart->address->id,$item->product->storage->id);
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
          $products[$item->storage_id][]=$item;
          $item->brand_name = $item->brand->name;
          $item->price = $item->variable->unit_price;
          $item->total = 0;//加运费价格
          $item->func = $item->storage->func;
          $item->distance = Count::distance($cart->address->id,$item->storage->id);
          // code...
        }
        $coupons = auth()->user()->coupons;
        foreach ($coupons as $key => $coupon) {
            $coupon->expire_time = $coupon->expire->toDateString();
        }
        $data["products"] = json_encode($products);
        $data["payChannels"] = PayChannel::get();
        $data["user"] = auth()->user();
        $data["varia"] = json_encode($varia);
        $data["coupons"] = json_encode($coupons);
        $data["cart"] = Cart::find($request->cart_id);
        return view("wechat.order.creates", $data);
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
