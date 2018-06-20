<?php

Route::get('/', "WeChat\IndexController@index")
    ->name("wechat.index");
Route::get("home", "WeChat\HomeController@index")
    ->name("wechat.home.index");
Route::get("waiter", "WeChat\HomeController@waiter")
    ->name("wechat.home.waiter");
Route::get("product_star", "WeChat\HomeController@productStar")
    ->name("wechat.home.product_star");
Route::get("coupon", "WeChat\HomeController@coupon")
    ->name("wechat.home.coupon");

Route::resource("company", "WeChat\CompanyController", [
    "names" => [
        "index" => "wechat.company.index",
        "create" => "wechat.company.create",
        "show" => "wechat.company.show",
        "store" => "wechat.company.store",
        "update" => "wechat.company.update",
        "edit" => "wechat.company.edit",
        "destroy" => "wechat.company.destroy",
    ],
]);
Route::match(["get", "post"], "company-fetch", "WeChat\CompanyController@fetch")
    ->name("wechat.company.fetch");

Route::get("logout", "Auth\WeChatAuthController@logout")
    ->name("wechat.logout");

Route::get("qrcode", "WeChat\QrCodeController@index")
    ->name("wechat.qrcode");

Route::get("product", "WeChat\ProductController@index")
    ->name("wechat.product.index");
Route::get("product/{product}", "WeChat\ProductController@show")
    ->name("wechat.product.show");
Route::get("product_buyme", "WeChat\ProductController@buyMe")
    ->name("wechat.product.buyme");

Route::get("search", "WeChat\SearchController@search")
    ->name("wechat.search");

Route::resource("address", "WeChat\AddressController", [
    "only" => ["store", "destory",],
    "names" => [
        "store" => "wechat.address.store",
        "destroy" => "wechat.address.destroy",
    ],
]);

Route::get("cart_buyall", "WeChat\CartController@buyAll")
    ->name("wechat.cart.buyall");
Route::resource("cart", "WeChat\CartController", [
    "names" => [
        "index" => "wechat.cart.index",
        "create" => "wechat.cart.create",
        "store" => "wechat.cart.store",
        "destroy" => "wechat.cart.destroy",
        "show" => "wechat.cart.show",
    ],
    "except" => ["edit", "update"],
]);
Route::post("cart_add", "WeChat\CartController@addProduct")
    ->name("wechat.cart.add_product");

Route::resource("cart_item", "WeChat\CartItemController", [
    "names" => [
        "index" => "wechat.cart_item.index",
        "update" => "wechat.cart_item.update",
        "destroy" => "wechat.cart_item.destroy",
    ],
    "except" => ["store", "create", "edit", "show"],
]);

Route::resource("order", "WeChat\OrderController", [
    "names" => [
        "index" => "wechat.order.index",
        "show" => "wechat.order.show",
        "create" => "wechat.order.create",
        "store" => "wechat.order.store",
        "edit" => "wechat.order.edit",
        "update" => "wechat.order.update",
        "destroy" => "wechat.order.destroy",
    ],
]);
Route::post("order-freight",
            "WeChat\OrderController@countFreight"
)->name("wechat.order.count-freight");
Route::get("contract/{order}", "WeChat\OrderController@contract")
    ->name("wechat.contract");
Route::match(["get", "post"], "order/share/{order}",
             "WeChat\OrderController@share")
    ->name("wechat.order.share");

Route::resource("invoice", "WeChat\InvoiceController", [
    "names" => [
        "create" => "wechat.invoice.create",
        "store" => "wechat.invoice.store",
    ],
    "except" => [
        "index", "edit", "show", "destroy", "update",
    ],
]);

Route::get("pay", "WeChat\PaymentController@pay")
    ->name("wechat.pay");
Route::get("offline", "WeChat\PaymentController@payOffline")
        ->name("wechat.pay.offline");

Route::match(["get", "post"], "distance", "WeChat\ToolController@distance")
    ->name("wechat.tool.distance");

Route::get("star", "WeChat\StarController@all")
    ->name("wechat.star.all");
Route::match(["get", "post"], "star/{id}", "WeChat\StarController@star")
    ->name("wechat.star");
Route::match(["get", "post"], "unstar/{id}", "WeChat\StarController@unstar")
    ->name("wechat.unstar");
