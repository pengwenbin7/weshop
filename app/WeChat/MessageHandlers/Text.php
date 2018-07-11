<?php

namespace App\WeChat\MessageHandlers;

use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;

class Text implements HandlerInterface
{
    public function run(array $message)
    {
        $key = $message['Content'];
        $url = route("wechat.search", ["keyword" => $key]);
        $items = [
            new NewsItem([
                'title'       => "【$key】搜索结果-太好买",
                'description' => "点击查看搜索结果",
                'url'         => $url,
                'image'       => '',
                //'image' => asset("assets/img/search.jpg"),
            ]),
        ];
        $news = new News($items);
        return $news;
    }
}