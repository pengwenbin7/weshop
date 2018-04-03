<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = ["name", "brand_id", "address_id", "description"];

    public function products()
    {
        return $this->hasMany("App\Models\Product");
    }
    
    public function address()
    {
        return $this->belongsTo("App\Models\Address");
    }

    public function brand()
    {
        return $this->belongsTo("App\Models\Brand");
    }

    /**
     * 在已经调用 address() 的情况下，不要再使用此方法
     */
    public function center()
    {
        return $this->address()->center;
    }
}
