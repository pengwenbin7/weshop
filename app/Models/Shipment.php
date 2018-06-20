<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Shipment extends Model
{
    const SHIPMENT_STATUS_WAIT = 0;
    const SHIPMENT_STATUS_DOING = 1;
    const SHIPMENT_STATUS_DONE = 2;
    const SHIPMENT_STATUS_CANCEL = 3;

    protected $fillable = [
        "order_id", "freight", "status",
        "from_address", "to_address",
        "ship_no", "contact_name", "contact_phone",
        "expect_arrive_date",
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
