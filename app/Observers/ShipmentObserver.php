<?php

namespace App\Observers;

use App\Models\Shipment;
use App\Jobs\ShipmentCreated;

class ShipmentObserver
{
    public function saved(Shipment $shipment)
    {
        dispatch(new ShipmentCreated($shipment));
    }
}