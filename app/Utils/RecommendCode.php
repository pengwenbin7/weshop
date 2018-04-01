<?php

namespace App\Utils;

class RecommendCode
{
    public static function generate($instance, $id)
    {
        $clsName = get_class($instance);
        return base64_encode("{$clsName}+{$id}");
    }
}