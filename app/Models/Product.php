<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * NOTICE:
 * You should always use this model to create/edit product info.
 * If you have to create/update product info with SQL sentence directly,
 * remembering to keep unique code correctly.
 * Seeing \App\Observers\ProductObserver for unique code regulation.
 */
class Product extends Model
{
    use SoftDeletes;

    protected $dates = ["deleted_at"];
    protected $fillable = [
        "locale_id", "name", "brand_id",
        "storage_id", "model", "content",
        "measure_unit", "packing_unit",
        "active", "sort_order", "keyword",
    ];

    public function pack()
    {
        return "{$this->content} {$this->measure_unit} / {$this->packing_unit}";
    }
    
    public function brand()
    {
        return $this->belongsTo("App\Models\Brand");
    }

    public function locale()
    {
        return $this->belongsTo("App\Models\Locale");
    }

    public function categories()
    {
        return $this->belongsToMany("App\Models\Category", "product_categories");
    }

    public function category()
    {
        return $this->categories()->where("is_primary", "=", 1)->first();
    }

    public function storage()
    {
        return $this->belongsTo("App\Models\Storage");
    }

    public function prices()
    {
        return $this->hasMany("App\Models\ProductPrice");
    }

    public function detail()
    {
        return $this->hasOne("App\Models\ProductDetail");
    }

    public function variable()
    {
        return $this->hasOne("App\Models\ProductVariable");
    }

    public function updateKeyword()
    {
        $cs = null;
        // 考虑到分类不会太多，直接拼接字符串
        foreach ($this->categories as $c) {
            $cs .= "{$c->name} ";
        }
        $keyword = sprintf("%s %s %s %s",
                           $this->name,
                           $this->model,
                           $this->brand->name,
                           $cs);
        if ($this->keyword != $keyword) {
            $this->keyword = $keyword;
            $this->save();
        }
    }

    /**
     * If you have called "variable" method,
     * or you'll use more than one of following method,
     * don't use the following method.
     */
    public function stock()
    {
        return $this->variable()->stock;
    }

    public function click()
    {
        return $this->variable()->click;
    }

    public function star()
    {
        return $this->variable()->star;
    }

    public function buy()
    {
        return $this->variable()->buy;
    }

    public function back()
    {
        return $this->variable()->back;
    }

}
