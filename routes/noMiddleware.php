<?php

Route::any('/wechat/server', 'WeChat\ServerController@serve');

Route::get("/wechat/oauth", "Auth\WeChatAuthController@oauth")
    ->name("wechat.oauth");

Route::any("/wework/server", "WeWork\ServerController@server");
Route::any("/wework/menu", "WeWork\ServerController@menu");
Route::get("/wework/", function () {
    return "Hello wework!";
});
Route::get("wework/msg", "WeWork\MessageController@send");