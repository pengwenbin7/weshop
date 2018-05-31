<?php

namespace App\Listeners;

use App\Events\ShipmentCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\ShipmentCreated;
use Log;

class ShipmentCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ShipmentCreatedEvent  $event
     * @return void
     */
    public function handle(ShipmentCreatedEvent $event)
    {
        dispatch(new ShipmentCreated($event->shipment));
    }
}
