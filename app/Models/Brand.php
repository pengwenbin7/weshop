<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function supplier()
    {
        return $this->belongsTo("App\Models\SupplierUser");
    }

    public function products()
    {
        return $this->hasMany("App\Models\Product");
    }

    public function models()
    {
        return $this->hasMany("App\Models\ProductModel");
    }
}
