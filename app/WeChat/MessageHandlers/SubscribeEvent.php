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
                    'title'       => "太好买2.0版本已正式上线，您有了解过吗?",
                    'description' => "",
                    'url'         => '',
                    'image'       => '',
                    'image' => 'https://mmbiz.qpic.cn/mmbiz_jpg/5JF6zkib8QfqIcOHicJL3pN4lGZez82ofpGUDxwibPAicUfDdZeDPwNyMGecUIf2bmavWGb7Mb0Ipf9ibEv4SXhO7yA/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1',
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
                    'title'       => "太好买2.0版本已正式上线，您有了解过吗?",
                    'description' => "",
                    'url'         => '',
                    'image'       => '',
                    'image' => 'https://mmbiz.qpic.cn/mmbiz_jpg/5JF6zkib8QfqIcOHicJL3pN4lGZez82ofpGUDxwibPAicUfDdZeDPwNyMGecUIf2bmavWGb7Mb0Ipf9ibEv4SXhO7yA/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1',
                ]),
            ];
            $news = new News($items);
            return $news;
        }
    }
}