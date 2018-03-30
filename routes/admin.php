<?php

Route::get("/", function () {
    return "hello admin";
})->name("admin.index");