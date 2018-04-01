<?php

namespace App\Observers;

use App\Models\ShopUser;
use App\Utils\RecommendCode;

class ShopUserObserver
{
    /**
     * 监听用户创建的事件。
     *
     * @param  ShopUser  $user
     * @return void
     */
    public function created(ShopUser $user)
    {
        $code = RecommendCode::generate($user, $user->id);
        $user->rec_code = $code;
        $user->save();
    }
}