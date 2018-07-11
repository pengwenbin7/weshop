<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = [
        "name", "brand_id", "address_id",
        "is_common", "description", "func",
    ];
    
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

}
