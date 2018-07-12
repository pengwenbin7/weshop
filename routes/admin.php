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

Route::match(["get", "post"], "product/modifying",
    "Admin\ProductController@modifying")
    ->name("admin.product.modifying");

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

Route::post("order/paid/{order}",
             "Admin\OrderController@paid")
    ->name("admin.order.paid");

Route::post("shipment/purchased/{shipment}",
             "Admin\ShipmentController@purchased")
    ->name("admin.shipment.purchased");

Route::post("shipment/shipped/{shipment}",
            "Admin\ShipmentController@shipped")
    ->name("admin.shipment.shipped");

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
//我的用户
Route::get('/meuser', 'Admin\MeuserController@index')->name("admin.meuser.index");

//所有用户资源路由
Route::resource("shopuser", "Admin\ShopuserController", [
    "names" => [
        "index" => "admin.shopuser.index",
        "create" => "admin.shopuser.create",
    ],
]);
Route::match(["get", "post"], "shopuser/modifying",
    "Admin\ShopuserController@modifying")
    ->name("admin.shopuser.modifying");
//系统设置
Route::get("/system", "Admin\SystemController@index")->name("admin.system.index");
Route::POST("/system/create", "Admin\SystemController@create")->name("admin.system.create");
//营销设置
Route::resource("marketing", "Admin\MarketingController", [
    "names" => [
        "index" => "admin.marketing.index",
        "create" => "admin.marketing.create",
        "store" => "admin.marketing.store",
        "edit" => "admin.marketing.edit",
        "show" => "admin.marketing.show",
    ],
]);
Route::any("/marketing/update", "Admin\MarketingController@update")->name("admin.marketing.update");
Route::get("/marketing/delete", "Admin\MarketingController@delete")->name("admin.marketing.delete");
//测试
Route::get("/ceshi", "Admin\CeshiController@index")->name("admin.ceshi.index");

Route::get('/logout', 'AdminAuth\LoginController@logout')->name("admin.logout");