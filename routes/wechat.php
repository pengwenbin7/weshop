<?php

Route::middleware("auth.wechat")->group(function () {
    Route::get('/', function () {
        return "nice";
    })->name("wechat.index");
});

Route::get("oauth", "Auth\WeChatAuthController@oauth")->name("wechat.oauth");
