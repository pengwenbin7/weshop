<?php

return [
    "menu" => [
        'button' => [
            [
                'name' => "首页",
                'type' => 'view',
                'url' => "http://admin.mafkj.com",
            ],
            [
                'name' => '待办',
                'type' => 'view',
                'url' => "http://admin.mafkj.com/doto",
            ],
            [
                'name' => '我的二维码',
                'type' => 'click',
                'key' => "requestMyQrCode",
            ],
        ],
    ],
];