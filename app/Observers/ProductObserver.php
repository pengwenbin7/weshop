<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function saving(Product $product)
    {
        if ($product->content <= 0) {
            throw new \Exception("product content must more than 0");
        }
        $product->is_ton = (strtolower($product->measure_unit) == "kg") &&
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
        $code = dechex(sprintf("%u", crc32(implode("", $arr))));
        
        if (Product::where("unique_code", "=", $code)->get()->isNotEmpty()) {
            return false;
        } else {
            $product->unique_code = $code;
        }
                           
    }

    public function saved(Product $product)
    {
        $product->updateKeyword();
    }
}