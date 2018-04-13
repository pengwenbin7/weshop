<?php

Route::get('/', "WeChat\IndexController@index")
    ->name("wechat.index");
Route::get("home", "WeChat\HomeController@index")
    ->name("wechat.home.index");

Route::get("qrcode", "WeChat\QrCodeController@index")
    ->name("wechat.qrcode");

Route::get("product", "WeChat\ProductController@index")
    ->name("wechat.product.index");
Route::get("product/{product}", "WeChat\ProductController@show")
    ->name("wechat.product.show");

Route::get("search/{key}", "WeChat\SearchController@search")
    ->name("wechat.search");

Route::resource("address", "WeChat\AddressController", [
    "names" => [
        "index" => "wechat.address.index",
        "create" => "wechat.address.create",
        "edit" => "wechat.address.edit",
        "store" => "wechat.address.store",
        "update" => "wechat.address.update",
        "destroy" => "wechat.address.destroy",
    ],
]);