<?php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
use App\Jobs\OrderPaid;
    
class OrderPaidListener
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
    public function handle(OrderPaidEvent $event)
    {
        $order = $event->order;
        $order->status = Order::ORDER_STATUS_DOING;
        $order->save();
        dispatch(new OrderPaid($order));
        if ($order->payment_status == Order::PAY_STATUS_DONE) {
            $order->createShipments();
        }
    }
}
