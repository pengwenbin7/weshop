<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentItem extends Model
{
    protected $fillable = [
        "shipment_id", "product_id", 
        "number", "price", "storage_id",
        "product_name", "model", "brand_name",
        "packing_unit",
    ];

    public function shipment()
    {
        return $this->belongsTo("App\Models\Shipment");
    }
}
