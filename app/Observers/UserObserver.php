<?php

namespace App\Observers;

use App\Models\User;

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
        $code = dechex(sprintf("%u", crc32($user->id)));
        $user->rec_code = $code;
        $user->save();
    }
}