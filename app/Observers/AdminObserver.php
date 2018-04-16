<?php

namespace App\Observers;

use App\Models\AdminUser;

class AdminObserver
{
    /**
     * 监听管理员创建的事件
     *
     * @param  Admin  $user
     * @return void
     */
    public function saved(AdminUser $user)
    {
        $code = dechex(sprintf("%u", crc32($user->id)));
        $user->rec_code = "A{$code}";
        $user->save();
    }
}