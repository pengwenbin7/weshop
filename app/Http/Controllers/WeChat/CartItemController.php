<?php

namespace App\Http\Controllers\WeChat;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartItemController extends Controller
{
    /**
     * Update the specified resource in storage.
     * Just allow to update number
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $cartItem->number = $request->number >= 1?
                         $request->number:
                         1;
        
        return ["update" => $cartItem->save()];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        return ["destroy" => $cartItem->delete()];
    }
}
