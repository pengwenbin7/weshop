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
        $cart->init_price = $product->variable->unit_price * $cart->number;
    }

    
}