<?php

namespace App\WeChat\MessageHandlers\EventHandlers;

use App\Models\User;

/**
 * 处理'取消关注'事件
 */
class UnSubscribeEvent implements HandlerInterface
{
    public function run(array $message)
    {
        $openid = $message["FromUserName"];
        $users = User::where("openid", "=", $openid)->get();
        if ($users->isNotEmpty()) {
            $user = $users->first();
            $user->is_subscribe = 0;
            $user->save();
        }
    }
}