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

// remember to delete me /////////////////////////
Route::get("/login/{id}", function ($id) {      //
    auth()->loginUsingId($id, true);            //
    return "user id: " . auth()->user()->id;    //
});                                            //
/////////////////////////////////////////////////

Route::get("login", "Auth\WeChatAuthController@login")->name("login");
