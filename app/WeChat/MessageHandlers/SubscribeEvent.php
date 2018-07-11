<?php

namespace App\WeChat\MessageHandlers;

use EasyWeChat\Kernel\Messages\Text;
use App\Models\User;

/**
 * 处理关注事件
 */
class SubscribeEvent implements HandlerInterface
{
    public function run(array $message)
    {
        $openid = $message["FromUserName"];
        
        $users = User::where("openid", "=", $openid)->get();
        // 判断用户是否存在
        if ($users->isEmpty()) {
            // 获取推广来源
            $from = null;
            $key = $message["EventKey"];
            if ($key && starts_with($key, "qrscene_")) {
                $from = str_after($key, "_");
            }
            // 注册用户
            $user = User::subRegister($openid, $from);
        } else {
            // 重复关注
            $user = $users->first();
            $user->is_subscribe = 1;
            $user->subscribe_count += 1;
            $user->save();
            return new Text("感谢您再次关注");
        }
    }
}