<?php

Route::get("/", "Admin\IndexController@index")->name("admin.index");
Route::get("todo", function () {
    return "TODO LIST";
})->name("admin.todo");

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

Route::resource("st", "Admin\StorageController", [
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

Route::get("order/mine", "Admin\OrderController@mine")
    ->name("admin.order.mine");
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

Route::resource("shipment", "Admin\ShipmentController", [
    "names" => [
        "index" => "admin.shipment.index",
        "show" => "admin.shipment.show",
        "create" => "admin.shipment.create",
        "edit" => "admin.shipment.edit",
        "store" => "admin.shipment.store",
        "update" => "admin.shipment.update",
        "destroy" => "admin.shipment.destroy",
    ],
]);

Route::resource("purchase", "Admin\PurchaseController", [
    "names" => [
        "index" => "admin.purchase.index",
        "show" => "admin.purchase.show",
        "create" => "admin.purchase.create",
        "edit" => "admin.purchase.edit",
        "store" => "admin.purchase.store",
        "update" => "admin.purchase.update",
        "destroy" => "admin.purchase.destroy",
    ],
]);

Route::get('/logout', 'AdminAuth\LoginController@logout')->name("admin.logout");