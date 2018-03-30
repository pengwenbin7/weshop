<?php

Route::get("/", function () {
    return view("admin.index");
})->name("admin.index");

Route::get("/wechat/menu", "WeChat\MenuController@index")->name("admin.wechat.menu.index");
Route::post("/wechat/menu", "WeChat\MenuController@store")->name("admin.wechat.menu.store");
