<?php

$buttons = [
    [
        "type" => "view",
        "name" => "找货",
        "url"  => "http://weshop.mafkj.com/wechat"

    ],
    [
	    "type" => "view",
	    "name" => "订单",
	    "url" => "http://weshop.mafkj.com/wechat/order",
    ],
    [
	    "type" => "click",
	    "name" => "分享",
	    "key" => "share",
    ],
];

file_put_contents("wxmenu.json", json_encode($buttons));
