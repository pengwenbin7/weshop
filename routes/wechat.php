<?php

Route::get('/', "WeChat\IndexController@index")
    ->name("wechat.index");
Route::get("home", "WeChat\HomeController@index")
    ->name("wechat.home.index");
Route::get("logout", "Auth\WeChatAuthController@logout")
    ->name("wechat.logout");

Route::get("qrcode", "WeChat\QrCodeController@index")
    ->name("wechat.qrcode");

Route::get("product", "WeChat\ProductController@index")
    ->name("wechat.product.index");
Route::get("product/{product}", "WeChat\ProductController@show")
    ->name("wechat.product.show");

Route::get("search/{key}", "WeChat\SearchController@search")
    ->name("wechat.search");

Route::resource("address", "WeChat\AddressController", [
    "only" => ["store", "destory",],
    "names" => [
        "store" => "wechat.address.store",
        "destroy" => "wechat.address.destroy",
    ],
]);

Route::resource("cart", "WeChat\CartController", [
    "names" => [
        "index" => "wechat.cart.index",
        "create" => "wechat.cart.create",
        "store" => "wechat.cart.store",        
        "update" => "wechat.cart.update",
        "destroy" => "wechat.cart.destroy",
    ],
    "except" => ["edit", "show"],
]);

Route::resource("order", "WeChat\OrderController", [
    "names" => [
        "index" => "wechat.order.index",
        "create" => "wechat.order.create",
        "store" => "wechat.order.store",
        "edit" => "wechat.order.edit",
        "update" => "wechat.order.update",
        "destroy" => "wechat.order.destroy",
    ],
    "except" => ["show"],
]);
Route::post("order-freight",
            "WeChat\OrderController@countFreight"
)->name("wechat.order.count-freight");
