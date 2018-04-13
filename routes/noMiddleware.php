<?php

Route::any('/wechat/server', 'WeChat\ServerController@serve');

Route::get("/wechat/oauth", "Auth\WeChatAuthController@oauth")
    ->name("wechat.oauth");
Route::get("/wechat/oauth/login", "Auth\WeChatAuthController@loginUsingOauthToken")
    ->name("wechat.oauth.login");