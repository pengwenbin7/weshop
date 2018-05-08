<?php

namespace App\Observers;

use App\Models\Order;
use Carbon\Carbon;
use App\Events\OrderCreatedEvent;
use App\Models\Config;

class OrderObserver
{
    public function created(Order $order)
    {
        $carbon = new Carbon();
        $order->no = sprintf("%s%010d", $carbon->format("Ymd"), $order->id);
        $order->expire = $carbon->addSeconds(Config::get("order.pay.expire"));
        $order->save();
        // 下单减库存
        $order->orderItems->each(function ($item) {
            $variable = $item->product->variable;
            $variable->stock = $variable->stock - $item->number;
            $variable->save();
        });
        event(new OrderCreatedEvent($order));
    }
}