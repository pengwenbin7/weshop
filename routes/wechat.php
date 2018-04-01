<?php

Route::any('/server', 'WeChat\ServerController@serve');

Route::middleware("auth.wechat")->group(function () {
    Route::get('/', "WeChat\IndexController@index")
        ->name("wechat.index");
});

Route::get("oauth", "Auth\WeChatAuthController@oauth")
    ->name("wechat.oauth");

Route::get("qrcode", "WeChat\QrCodeController@index");