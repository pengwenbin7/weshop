<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 关于购物车中产品失效的问题，直接在 Controller/View 里判断更方便
 * 此 Model 不做处理
 */
class Cart extends Model
{
    protected $fillable = [
        "user_id", "address_id",
    ];

    public function address()
    {
        return $this->belongsOne("App\Models\Address");
    }
    
    public function cartItems()
    {
        return $this->hasMany("App\Models\CartItem");
    }
}
