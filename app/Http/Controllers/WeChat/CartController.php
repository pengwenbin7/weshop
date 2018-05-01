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
        $carts = auth()->user->carts;
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
        
        return ["store" => $cart->id];
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
     * Update the cart in storage.
     * 仅允许修改数量(number)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function updateItem(Request $request)
    {
        $cartItem = CartItem::find($request->cart_item_id);
        $cartItem->number = $request->number;
        return ["update" => $cartItem->save()];
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
