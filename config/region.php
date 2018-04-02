<?php

return [
    "api_url" => env('REGION_API_URL', "http://restapi.amap.com/v3/config/district"),
    "api_key" => env("LBS_AMAP_COM_KEY", ""),
    "query_root" => env("LBS_AMAP_COM_ROOT", "中华人民共和国"),
    "query_depth" => env("LBS_AMAP_COM_DEPTH", 3),
];
