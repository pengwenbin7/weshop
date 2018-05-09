<?php

namespace App\Observers;

use App\Events\OrderCreatedEvent;
use App\Models\Payment;

class OrderObserver
{
    public function saved(Payment $payment)
    {
        $payment->pay =
                     $payment->total + $payment->tax +
                     $payment->freight - $payment->coupon_discount -
                     $payment->share_discount - $payment->pay_discount;
        $payment->save();
    }
}