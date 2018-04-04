<?php

namespace App\Observers;

use App\Models\Cart;
use App\Models\Product;

class CartObserver
{
    public function creating(Cart $cart)
    {
        $product = Product::find($cart->product_id);
        $cart->product_name = $product->name;
        $cart->product_model = $product->model;
        $cart->init_price = $cart->ton_sell ?
                         $product->price()->ton_price * $cart->number :
                         $product->price()->unit_price * $cart->number;
    }

    
}