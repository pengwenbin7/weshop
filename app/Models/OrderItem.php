<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        "order_id", "product_id", "number",
        "price", "storage_id", "product_name",
        "model", "brand_name", "packing_unit",
    ];
    
    public function product()
    {
        return $this->belongsTo("App\Models\Product");
    }

    public function storage()
    {
        return $this->belongsTo("App\Models\Storage");
    }
}
