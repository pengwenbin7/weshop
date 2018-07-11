<?php

// wechat message handler

return [
    "text" => App\WeChat\MessageHandlers\Text::class,
    "image" => App\WeChat\MessageHandlers\Image::class,
    "voice" => null,
    "event" => [
        "subscribe" => App\WeChat\MessageHandlers\SubscribeEvent::class,
        "unsubscribe" => App\WeChat\MessageHandlers\UnsubscribeEvent::class,
        "click" => [
            "share" => App\WeChat\MessageHandlers\ClickShareEvent::class,
        ],
    ],
];
