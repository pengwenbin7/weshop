<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ["product_id", "category_id", "is_primary"];

    public function product()
    {
        return $this->belongsTo("App\Models\Product");
    }

    public function category()
    {
        return $this->belongsTo("App\Models\Category");
    }
}
