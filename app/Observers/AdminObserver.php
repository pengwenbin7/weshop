<?php

namespace App\Observers;

use App\Models\AdminUser;
use App\Jobs\UpdateAdminPermission;

class AdminObserver
{
    /**
     * 监听管理员 创建/更新 事件
     *
     * @param  Admin  $user
     * @return void
     */
    public function saved(AdminUser $user)
    {
        // 设置默认密码
        if (!$user->password) {
            $user->password = bcrypt("123456");
        }
        // 生成邀请码
        if (!$user->rec_code) {
            $code = dechex(sprintf("%u", crc32($user->id)));
            $user->rec_code = "A{$code}";
            $user->save();
        }

        /* 更新权限
         * 更新权限是耗时操作，而存在并发更新用户操作，
         * 所以需要用 Job 实现
         */
        UpdateAdminPermission::dispatch($user);
    }
}