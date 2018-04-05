<?php

namespace App\Listeners;

use App\Events\OrderPayedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPayedListener
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
     * @param  OrderPayedEvent  $event
     * @return void
     */
    public function handle(OrderPayedEvent $event)
    {
        //
    }
}
