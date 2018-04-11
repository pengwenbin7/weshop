<?php

Route::get('/', "WeChat\IndexController@index")
    ->name("wechat.index");

Route::get("qrcode", "WeChat\QrCodeController@index")
    ->name("wechat.qrcode");

Route::get("product", "WeChat\ProductController@index")
    ->name("wechat.product");

Route::get("search/{key}", "WeChat\SearchController@search")
    ->name("wechat.search");