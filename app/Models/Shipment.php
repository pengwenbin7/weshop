<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Jobs\ShipmentPurchased;
use App\Jobs\ShipmentShipped;

class Shipment extends Model
{
    protected $fillable = [
        "order_id", "purchase",
        "status", "freight", "cost",
        "from_address", "to_address",
        "ship_no", "contact_name", "license_plate",
        "contact_phone", "expect_arrive",
    ];

    protected $dates = [
        "expect_arrive", "ship_time", "arrive",
    ];

    public function order()
    {
        return $this->belongsTo("App\Models\Order");
    }
    
    public function shipmentItems()
    {
        return $this->hasMany("App\Models\ShipmentItem");
    }

    public function purchased($cost)
    {
        $this->cost = $cost;
        $this->purchase = true;
        dispatch(new ShipmentPurchased($this));
        return $this->save();
    }

    public function shipped($freight)
    {
        if (!$this->purchase) {
            return false;
        }
        $this->freight = $freight;
        $this->ship_time = Carbon::now();
        $this->status = true;
        dispatch(new ShipmentShipped($this));
        return $this->save();
    }
}
