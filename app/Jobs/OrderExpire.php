<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;

class OrderExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->order->payment_status == Order::PAY_STATUS_WAIT) {
            $this->order->active = false;
            $this->order->save();
            // 恢复库存
            $this->order->orderItems->each(function ($item) {
                $variable = $item->product->variable;
                $variable->stock = $variable->stock + $item->number;
                $variable->save();
            });
        }
    }
}
