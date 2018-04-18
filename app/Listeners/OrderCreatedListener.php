<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
use App\Jobs\OrderExpire;

class OrderCreatedListener
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
     * @param  OrderCreatedEvent  $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
        $order = $event->order;
        dispatch(new OrderExpire($order))
            ->delay(now()->addSeconds(Order::ORDER_EXPIRE_IDL));
    }
}
