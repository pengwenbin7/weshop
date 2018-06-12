<?php

namespace App\Observers;

use App\Models\Coupon;

class CouponObserver
{
    public function created(Coupon $coupon)
    {
        $coupon->user->sendMessage('<a href="http://weshop.mafkj.com/coupon">你获得了一张优惠券,点击查看详情</a>');
    }
}