<?php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\OrderPaid;
use App\Models\Order;
use App\Models\UserAction;
    
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
        // 记录用户购买行为
        $items = $order->orderItems;
        foreach ($items as $item) {
            $item->product->variable->buy += $item->number;
            UserAction::create([
                "user_id" => $order->user_id,
                "product_id" => $item->product_id,
                "action" => "buy",
            ]);
        }

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
