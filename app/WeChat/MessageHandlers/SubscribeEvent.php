<?php

namespace App\WeChat\MessageHandlers;

use EasyWeChat\Kernel\Messages\Text;
use App\Models\User;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;

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

            $items = [
                new NewsItem([
                    'title'       => "想看想购的化工品，尽在太好买，2.0版商城让您采购省钱！分享赚钱，马上体验吧！",
                    'description' => "",
                    'url'         => 'http://admin.mafkj.com',
                    'image'       => '',
                    'image' => 'https://mmbiz.qpic.cn/mmbiz_jpg/5JF6zkib8Qfq6M0XibHrACZFR4ymoDmwqsKreJA15Rh9MefEoMVDCDFtWIbLsB5omXSwgqic4WibIyp2H4oUPQHUtA/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1',
                ]),
            ];
            $news = new News($items);
            return $news;

        } else {
            // 重复关注
            $user = $users->first();
            $user->is_subscribe = 1;
            $user->subscribe_count += 1;
            $user->save();
//            return new Text("感谢您再次关注");
            $items = [
                new NewsItem([
                    'title'       => "想看想购的化工品，尽在太好买，2.0版商城让您采购省钱！分享赚钱，马上体验吧！",
                    'description' => "",
                    'url'         => 'http://admin.mafkj.com',
                    'image'       => '',
                    'image' => 'https://mmbiz.qpic.cn/mmbiz_jpg/5JF6zkib8Qfq6M0XibHrACZFR4ymoDmwqsKreJA15Rh9MefEoMVDCDFtWIbLsB5omXSwgqic4WibIyp2H4oUPQHUtA/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1',
                ]),
            ];
            $news = new News($items);
            return $news;
        }
    }
}