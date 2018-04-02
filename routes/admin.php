<?php

Route::get("/", function () {
    return view("admin.index");
})->name("admin.index");

Route::get("/wechat/menu", "WeChat\MenuController@index")->name("admin.wechat.menu.index");
Route::post("/wechat/menu", "WeChat\MenuController@store")->name("admin.wechat.menu.store");

Route::resource("category", "Admin\CategoryController", [
    "names" => [
        "index" => "admin.category.index",
        "show" => "admin.category.show",
        "create" => "admin.category.create",
        "edit" => "admin.category.edit",
        "store" => "admin.category.store",
        "update" => "admin.category.update",
        "destroy" => "admin.category.destroy",
    ],
]);

Route::resource("product", "Admin\ProductController", [
    "names" => [
        "index" => "admin.product.index",
        "show" => "admin.product.show",
        "create" => "admin.product.create",
        "edit" => "admin.product.edit",
        "store" => "admin.product.store",
        "update" => "admin.product.update",
        "destroy" => "admin.product.destroy",
    ],
]);

Route::resource("brand", "Admin\BrandController", [
    "names" => [
        "index" => "admin.brand.index",
        "create" => "admin.brand.create",
        "store" => "admin.brand.store",
        "edit" => "admin.brand.edit",
        "update" => "admin.brand.update",
        "destroy" => "admin.brand.destroy",
        "show" => "admin.brand.show",
    ],
]);