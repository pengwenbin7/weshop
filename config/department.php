<?php

return [
    // 部门权限
    "permission" => [
        // 公司
        1 => [
        ],
        // 系统管理
        2 => [
            "system",
        ],
        // 公司管理
        3 => [
            "user", "order",
            "supplier", "report",
            "ship", "pay",
        ],
        // 业务
        4 => [
            "cs",
        ],
        // 财务
        5 => [
            "user", "order", "pay",
        ],
        // 采购
        6 => [
            "purchase", "user", "order",
        ],
        // 物流
        7 => [
            "user", "order", "ship",
        ],
        //　VIP
        8 => [
            "user", "vip",
        ],
        // 产品管理
        9 => [
            "product",
        ],
    ],
];