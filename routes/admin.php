<?php

Route::get("/", function () {
    return view("admin.index");
})->name("admin.index");

Route::get("/wechat/menu", "WeChat\MenuController@index")->name("admin.wechat.menu.index");
Route::post("/wechat/menu", "WeChat\MenuController@store")->name("admin.wechat.menu.store");

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

Route::resource("supplier", "Admin\SupplierUserController", [
    "names" => [
        "index" => "admin.supplier.index",
        "create" => "admin.supplier.create",
        "show" => "admin.supplier.show",
        "store" => "admin.supplier.store",
        "update" => "admin.supplier.update",
        "edit" => "admin.supplier.edit",
        "destroy" => "admin.supplier.destroy",
    ], "parameters" => [
        "supplier" => "supplierUser",
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