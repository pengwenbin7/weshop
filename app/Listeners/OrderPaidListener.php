<?php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\OrderPaid;
use App\Models\Order;
    
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
        $canShip = [Order::PAY_STATUS_DONE, Order::PAY_STATUS_AFTER,
                    Order::PAY_STATUS_PART];
        if (in_array($order->payment_status, $canShip)) {
            $order->createShipments();
        }
        dispatch(new OrderPaid($order));
    }
}
