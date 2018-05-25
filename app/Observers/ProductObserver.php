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
        $product->unique_code = dechex(sprintf("%u", crc32(implode("", $arr))));
    }

    public function saved(Product $product)
    {
        $cs = '';
        foreach ($product->categories as $c) {
            $cs .= "{$c->name} ";
        }
        $keyword = sprintf("%s %s %s %s",
                           $product->name,
                           $product->model,
                           $product->brand->name,
                           $cs);
        if ($product->keyword != $keyword) {
            $product->keyword = $keyword;
            $product->save();
        }
    }
}