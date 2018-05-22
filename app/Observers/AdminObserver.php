<?php

namespace App\Observers;

use App\Models\AdminUser;
use App\WeChat\SpreadQR;

class AdminObserver
{
    /**
     * 监听管理员-创建事件
     *
     * @param  Admin  $user
     * @return void
     */
    public function created(AdminUser $user)
    {
        // 设置默认密码
        if (!$user->password) {
            $user->password = bcrypt("123456");
            $user->save();
        }
        // 生成邀请码
        if (!$user->rec_code) {
            $code = dechex(sprintf("%u", crc32($user->userid)));
            $user->rec_code = "A{$code}";
            $user->save();
        }
        // 生成推广二维码
        if (!$user->spread_qr) {
            $user->spread_qr = SpreadQR::forever($user->rec_code);
            $user->save();
        }
    }
}