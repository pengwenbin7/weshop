<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 数据库支持一个 Product 有多个分类，逻辑上未实现
 */
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
