<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /*
    public function supplier()
    {
        return $this->belongsTo("App\Models\SupplierUser");
    }
    */

    public function products()
    {
        return $this->hasMany("App\Models\Product");
    }

    public function primaryProduct()
    {
        return $this->belongsTo("App\Models\Category", "id", "primary_category_id");
    }

    public function storages()
    {
        return $this->hasMany("App\Models\Storage");
    }

}
