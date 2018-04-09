<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    // 判断用户此订单是否可以用此优惠券
    public function valid(ShopUser $user, Payment $payment)
    {
        return false;
    }
}
