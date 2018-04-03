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
        return $this->belongsToMany("App\Models\Category", "product_category");
    }

    public function storage()
    {
        return $this->belongsTo("App\Models\Storage");
    }

    public function prices()
    {
        return $this->hasMany("App\Models\ProductPrice");
    }

    public function price()
    {
        return $this->prices()->orderBy("created_at", "desc")->first();
    }

    public function detail()
    {
        return $this->hasOne("App\Models\ProductDetail");
    }

    public function variable()
    {
        return $this->hasOne("App\Models\ProductVariable");
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
