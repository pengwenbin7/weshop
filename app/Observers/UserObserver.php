<?php

namespace App\Observers;

use App\Models\User;
use App\Models\AdminUser as Admin;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Jobs\UserRegistered;
use App\WeChat\SpreadQR;

class UserObserver
{
    /**
     * 监听用户创建的事件。
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        // 生成唯一推广码
        $user->rec_code = $user->generateCode();
        // 确定管理员
        $user->admin_id = $user->generateAdmin()->id;
        $user->save();
        // 送一张优惠券
        Coupon::create([
            "user_id" => $user->id,
            "discount" => 100,
            "amount" => 0,
            "expire" => Carbon::now()->addYear(1),
            "description" => "感谢关注",
        ]);
        dispatch(new UserRegistered(User::find($user->id)));
    }
}