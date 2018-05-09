<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;

class OrderCreated implements ShouldQueue
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
        // 下单计数
        $this->order->orderItems->each(function ($item) {
            $variable = $item->product->variable;
            $variable->stock = $variable->stock - $item->number;
            $variable->save();
        });
        $url = route("admin.order.show", ["id" => $this->order->id]);
        $msg = sprintf(
            "你的客户【%s】创建了一个新订单【%s】",
            $this->order->user->name ?? "匿名",
            '<a href="'. $url . '">查看</a>'
        );
        $this->order->adminUser->sendMessage($msg);
    }
}
