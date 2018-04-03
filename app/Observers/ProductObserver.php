<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function saving(Product $product)
    {
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