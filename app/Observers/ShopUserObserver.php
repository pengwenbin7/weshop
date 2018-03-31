<?php

namespace App\Observers;

use App\Models\ShopUser;

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
        $user->rec_code = "U{$user->id}";
        $user->save();
    }
}