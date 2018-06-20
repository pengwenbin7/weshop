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

// "/storage" is a using path
Route::get("st", "Admin\StorageController@index")
    ->name("admin.storage.index");
Route::get("st/create", "Admin\StorageController@create")
    ->name("admin.storage.create");
Route::post("st", "Admin\StorageController@store")
    ->name("admin.storage.store");
Route::put("st/{storage}", "Admin\StorageController@update")
    ->name("admin.storage.update");
Route::get("st/{storage}/edit", "Admin\StorageController@edit")
    ->name("admin.storage.edit");
Route::delete("st/{storage}", "Admin\StorageController@destroy")
    ->name("admin.storage.destroy");
Route::get("st/{storage", "Admin\StorageController@show")
    ->name("admin.storage.show");

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

Route::match(["get", "post"], "order/paid/{order}",
             "Admin\OrderController@paid")
    ->name("admin.order.paid");

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

Route::match(["get", "post"], "shipment/shipped/{shipment}",
             "Admin\ShipmentController@shipped")
    ->name("admin.shipment.shipped");
Route::match(["get", "post"], "shipment/purchased/{shipped}",
             "Admin\ShipmentController@purchased")
    ->name("admin.shipment.purchased");

Route::resource("invoice", "Admin\InvoiceController", [
    "names" => [
        "index" => "admin.invoice.index",
        "show" => "admin.invoice.show",
        "create" => "admin.invoice.create",
        "edit" => "admin.invoice.edit",
        "store" => "admin.invoice.store",
        "update" => "admin.invoice.update",
        "destroy" => "admin.invoice.destroy",
    ],
]);

Route::get('/logout', 'AdminAuth\LoginController@logout')->name("admin.logout");