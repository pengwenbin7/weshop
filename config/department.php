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
        // 大管理
        3 => [
            "user", "order",
            "supplier", "report",
            "ship", "pay",
        ],
        // 小管理
        4 => [
            "order", "user",
            "supplier", "report",
        ],
        // 财务
        5 => [
            "user", "order", "pay",
        ],
        // 物流
        6 => [
            "user", "order", "ship",
        ],
        //　供应商
        7 => [
            "supplier",
        ],
    ],
];