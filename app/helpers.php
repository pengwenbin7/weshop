<?php

function sys_config(string $key, $default = null)
{
    $fetch = App\Models\Config::where("key", "=", $key)->get();
    return $fetch->isEmpty()?
        $default:
        $fetch->first()->value;
}