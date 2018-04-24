<?php

namespace App\Observers;

use App\Models\User;
use App\Models\AdminUser as Admin;
use App\Jobs\UserRegistered;

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
        $code = dechex(sprintf("%u", crc32($user->id)));
        $user->rec_code = $code;
        // 分配管理员
        $from = $user->rec_from;
        // 有人推广
        if ($from) {
            // 来自业务员的推广
            if ("A" == $from[0]) {
                $admins = Admin::where("rec_code", "=", $from)->get();
                // 此业务员已离职
                if ($admins->isEmpty()) {
                    $admin = Admin::all()->random();
                } else {
                    $admin = $admins->first();
                }
            } else { // 来自用户的推广
                $us = User::where("rec_code", "=", $from)->get();
                if ($us->isEmpty()) { // 不存在的推广码
                    $admin = Admin::all()->random();
                } else {
                    $u = $us->first();
                    $admin = $u->admin;
                }
            }
        } else {
            // 搜索关注的用户，随机分配一个
            $admin = Admin::all()->random();
        }
        
        $user->admin_id = $admin->id;
        $user->save();
        dispatch(new UserRegistered($user));
    }
}