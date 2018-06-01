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

Route::match(["get", "post"],
             "region/children/{region?}",
             "RegionController@children")
    ->name("region.children");

Route::domain("admin.mafkj.com")->group(function () {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name("admin.login");
    Route::post('/login', 'AdminAuth\LoginController@login')->name("admin.login");
});
