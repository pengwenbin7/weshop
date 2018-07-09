<?php

namespace App\WeChat\MessageHandlers;

use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;

class Event
{
    public function handle(array $message)
    {
        $cname = __NAMESPACE__ . "\\EventHandlers\\" . ucfirst(strtolower($message["MsgType"]));
        if (class_exists($cname)) {
            return (new $cname())->handle($message);
        }
    }
}