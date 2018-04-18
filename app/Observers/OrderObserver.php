<?php

namespace App\Observers;

use App\Models\Order;
use Carbon\Carbon;
use App\Events\OrderCreatedEvent;

class OrderObserver
{
    public function created(Order $order)
    {
        $carbon = new Carbon();
        $order->no = sprintf("%s%010d", $carbon->format("Ymd"), $order->id);
        $order->expire = $carbon->addSeconds(Order::ORDER_EXPIRE_IDL);
        $order->save();
        event(new OrderCreatedEvent($order));
    }
}