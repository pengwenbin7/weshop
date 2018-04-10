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

Route::resource("storage", "Admin\StorageController", [
    "names" => [
        "index" => "admin.storage.index",
        "create" => "admin.storage.create",
        "store" => "admin.storage.store",
        "edit" => "admin.storage.edit",
        "update" => "admin.storage.update",
        "destroy" => "admin.storage.destroy",
        "show" => "admin.storage.show",
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

Route::resource("order", "Admin\OrderController", [
    "names" => [
        "index" => "admin.order.index",
        "show" => "admin.order.show",
        "create" => "admin.order.create",
        "edit" => "admin.order.edit",
        "store" => "admin.order.store",
        "update" => "admin.order.update",
        "destroy" => "admin.order.destroy",
    ],
]);
    