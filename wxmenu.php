<?php

$buttons = [
    [
        "type" => "view",
        "name" => "home",
        "url"  => "http://weshop.mafkj.com/wechat"

    ],
    [
        "name"       => "菜单",
        "sub_button" => [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "type" => "view",
                "name" => "视频",
                "url"  => "http://v.qq.com/"
            ],
            [
                "type" => "click",
                "name" => "赞一下我们",
                "key" => "V1001_GOOD"
            ],
        ],
    ],
];

file_put_contents("wxmenu.json", json_encode($buttons));
