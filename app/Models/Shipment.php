<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Shipment extends Model
{
    protected $fillable = [
        "order_id", "purchase",
        "status", "freight",
        "from_address", "to_address",
        "ship_no", "contact_name", 
        "contact_phone", "expect_arrive_date",
    ];

    public function order()
    {
        return $this->belongsTo("App\Models\Order");
    }
    
    public function shipmentItems()
    {
        return $this->hasMany("App\Models\ShipmentItem");
    }
}
