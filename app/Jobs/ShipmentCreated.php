<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Shipment;
use App\Models\Department;
use EasyWeChat;

class ShipmentCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $shipment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = route("admin.shipment.show", ["id" => $this->shipment->id]);
        $msg = '待处理的发货单【<a href="' . $url . '">查看</a>】';
        $ids = [];
        Department::permission("ship")
            ->select("id")
            ->get()
            ->each(function ($d) use (&$ids) {
                $ids[] = $d->id;
            });
        $work = EasyWeChat::work();
        $work->messenger
            ->ofAgent(env("WECHAT_WORK_AGENT_ID"))
            ->message($message)
            ->toParty($ids)
            ->send();
    }
}
