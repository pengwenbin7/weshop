<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("version", function () {
    if (auth()->check()) {
        echo auth()->user()->openid;
    }
    return app()->version();
});

Route::get("/login/{id}", function ($id) {
    auth()->loginUsingId($id);
    return "user id: " . auth()->user()->id;
});

/* start: remembering move to wechat.php */
/*
Route::get("product", "WeChat\ProductController@index")
    ->name("wechat.product.index");
Route::get("product/{product}", "WeChat\ProductController@show")
    ->name("wechat.product.show");
*/

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

/* end: remembering move to wechat.php */