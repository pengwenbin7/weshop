<?php

namespace App\WeChat\MessageHandlers\EventHandlers;

use App\Models\User;

/**
 * 处理'点击'事件
 */
class Click
{
    public function handle(array $message)
    {
        $openId = $message["FromUserName"];
        $users = User::where("openid", "=", $openid)->get();
        // 如果用户不存在，则注册之
        if ($users->isEmpty()) {
            $user = User::subRegister($openId, null);
        }
    }
}