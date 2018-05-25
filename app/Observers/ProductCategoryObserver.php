<?php

namespace App\Observers;

use App\Models\ProductCategory;

class ProductCategoryObserver
{
    public function saved(ProductCategory $pc)
    {
        $pc->product->updateKeyword();
    }
}