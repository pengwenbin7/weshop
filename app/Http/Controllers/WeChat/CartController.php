<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
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
               ->orderBy("id", "desc")
               ->get();
        return view("wechat.cart.index", ["user" => $user, "carts" => $carts]);
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
        ]);
        
        return ["add" => $item->id];
    }

    public function show(Cart $cart)
    {
        $items = CartItem::where("cart_id", "=", $cart->id)
               ->with("product")->get();
           
        return view("wechat.cart.show", [
            "cart" => $cart,
            "items" => json_encode($items),
        ]);
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
