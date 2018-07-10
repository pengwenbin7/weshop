<?php

namespace App\WeChat\MessageHandlers\EventHandlers;

use App\Models\User;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Image;

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
        } else {
            $user = $users->first();
        }
        switch($message["EventKey"]) {
        case "share":
            $url = "http://mp.weixin.qq.com/s?__biz=MzIzODY1MjUyNA==&mid=100000699&idx=1&sn=aed691ad9bae87df98f30d818d5b947f&chksm=69375eb85e40d7ae812971ce445dbe6a146ff824322e2e815dee9dd0002d2875b23bda67fc6b#rd";
            $items = [
                new NewsItem([
                    'title'       => "分享下方二维码，邀请好友下单领取现金奖励！",
                    'description' => "点击查看详情→→→",
                    'url'         => $url,
                    'image'       => '',
                ]),
            ];
            $user->sendMessage(new News($items));
            $user->sendMessage(new Image($user->getShareImg()));
            break;
        default:
            return "success";
            break;
        }
    }
}