<?php

namespace App\Observers;

use App\Events\OrderCreatedEvent;
use App\Models\Payment;
use Log;

class PaymentObserver
{
    public function saved(Payment $payment)
    {
        if (!$payment->pay) {
            $payment->pay =
                         $payment->total + $payment->tax +
                         $payment->freight - $payment->coupon_discount -
                         $payment->share_discount - $payment->pay_discount;
            Log::info($payment);
            $payment->save();
        }
    }
}