<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $dates = ["deleted_at"];
    
    public function model()
    {
        return $this->belongsTo("App\Models\ProductModel");
    }

    public function brand()
    {
        return $this->belongsTo("App\Models\Brand");
    }

    public function storage()
    {
        return $this->belongsTo("App\Models\Storage");
    }

    public function locale()
    {
        return $this->belongsTo("App\Models\Locale");
    }

    public function categories()
    {
        return $this->hasMany("App\Models\Category");
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

    public function documents()
    {
        return $this->hasMany("App\Models\ProductDocument");
    }

    public function variable()
    {
        return $this->hasOne("App\Models\ProductVariable");
    }

    // 以下4个方法仅在单独使用时调用，使用variable()方法更省资源
    public function stock()
    {
        return $this->variable()->stock;
    }

    public function view()
    {
        return $this->variable()->view;
    }

    public function click()
    {
        return $this->variable()->click;
    }

    public function star()
    {
        return $this->variable()->star;
    }

}
