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
        return $carts;
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
    public function addProduct(Request $request) {
        $cart = Cart::find($request->cart_id);
        
        // 重复添加的行为，会改变数量
        $item = $cart->cartItems()
              ->where("product_id", "=", $request->product_id)
              ->get();
        if ($item->isEmpty()) {
            $item = CartItem::create([
                "cart_id" => $cart->id,
                "product_id" => $request->product_id,
                "number" => $request->number,
            ]);
        } else {
            $item = $item->first();
            $item->number += $request->number;
            $item->save();
        }
        
        return ["add" => $item->id];
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
