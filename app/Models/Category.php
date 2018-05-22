<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        "name", "locale_id", "parent_id",
        "sort_order", "description",
    ];
    
    public function products()
    {
        return $this->belongsToMany("App\Models\Product", "product_categories");
    }
}
