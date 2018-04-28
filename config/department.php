<?php

return [
    // 部门权限
    "permission" => [
        // 公司
        1 => [
        ],
        // 系统管理
        2 => [
            "user", "order", "pay",
            "ship", "system",
        ],
        // 用户管理
        3 => [
            "user",
        ],
        // 订单管理
        4 => [
            "order",
        ],
        // 财务
        5 => [
            "pay",
        ],
        // 物流
        6 => [
            "ship",
        ],
        //　业务
        7 => [
            // none
        ],
    ],
];