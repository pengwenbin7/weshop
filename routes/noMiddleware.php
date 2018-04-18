<?php

Route::any('/wechat/server', 'WeChat\ServerController@serve');

Route::get("/wechat/oauth", "Auth\WeChatAuthController@oauth")
    ->name("wechat.oauth");

Route::any("/wework/server", "WeWork\ServerController@server");

Route::get("/wework/", function () {
    return "Hello wework!";
});
