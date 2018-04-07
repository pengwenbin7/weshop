<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function saving(Product $product)
    {
        if ($product->content <= 0) {
            throw new \Exception("product content can't less than 0");
        }
        $product->ton_sell = ($product->measure_unit == "kg") &&
                          (1000 % $product->content == 0);
        $arr = [
            $product->locale_id,
            $product->name,
            $product->brand_id,
            $product->storage_id,
            $product->model,
            $product->content,
            $product->measure_unit,
            $product->packing_unit,
        ];
        $product->unique_code = crc32(implode("", $arr));
    }
}