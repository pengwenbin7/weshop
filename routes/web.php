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

//Route::get("/", "WeChat\IndexController@index")->name("index");
Route::get("/", function () {
    return redirect()->route("wechat.index");
});
Route::get("/login/{id}", function ($id) {
    auth()->loginUsingId($id);
});

/* start: remembering move to wechat.php */
Route::get("product", "WeChat\ProductController@index")
    ->name("wechat.product.index");
Route::get("product/{product}", "WeChat\ProductController@show")
    ->name("wechat.product.show");
Route::get("cart", "WeChat\CartController@index")
    ->name("wechat.cart.index");
Route::post("cart", "WeChat\CartController@store")
    ->name("wechat.cart.store");
Route::put("cart/{cart}", "WeChat\CartController@update")
    ->name("wechat.cart.update");
/* end: remembering move to wechat.php */