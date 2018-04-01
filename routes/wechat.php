<?php

Route::any('/server', 'WeChat\ServerController@serve');

Route::middleware("auth.wechat")->group(function () {
    Route::get('/', "WeChat\IndexController@index")
        ->name("wechat.index");
});

Route::get("oauth", "Auth\WeChatAuthController@oauth")
    ->name("wechat.oauth");

Route::get("qrcode", "WeChat\QrCodeController@index")
    ->name("wechat.qrcode");

Route::get("product", "WeChat\ProductController@index")
    ->name("wechat.product");

Route::get("search/{key}", "WeChat\SearchController@search")
    ->name("wechat.search");