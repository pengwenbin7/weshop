<?php

namespace App\Observers;

use App\Models\User;
use App\Utils\RecommendCode;

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
        $code = RecommendCode::generate($user, $user->id);
        $user->rec_code = $code;
        $user->save();
    }
}