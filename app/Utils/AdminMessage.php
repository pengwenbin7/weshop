<?php

namespace App\Utils;

use App\Models\User;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;

class AdminMessage
{
    /**
     * 客户注册通知
     * @param User $user
     * @return void
     */
    public static function userRegistered(User $user)
    {
        $admin = $user->admin;
        $items = [
            new NewsItem([
                'title'       => "客户注册",
                'description' => "你有一个新的客户【{$user->name}】",
                'url'         => "",
                //"url" => route("admin.user.show", ["id" => $user->id]),
                'image'       => "",
            ]),
        ];
        $msg = new News($items);
        $work = EasyWeChat::work();
        $work->messenger
            ->ofAgent(env("WECHAT_WORK_AGENT_ID"))
            ->message($msg)
            ->toUser($admin->wework_userid)
            ->send();
    }
}