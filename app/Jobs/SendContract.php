<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use App\Models\Order;

class SendContract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $order;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $html = view("wechat.print.contract", [
            "user" => $this->user,
            "order" => $this->order,
        ])->render();
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $pdf = new \Mpdf\Mpdf([
            "fontDir" => array_merge($fontDirs, [
                public_path("storage/fonts/")
            ]),
            "fontdata" => $fontData + [
                "msyh" => [
                    "R" => "msyh.ttf",
                ],
                "msyhbd" => [
                    "R" => "msyhbd.ttf",
                ],
            ],
            "default_font" => "msyh",
        ]);
        $pdf->WriteHTML($html);
        $file = storage_path("pdfs/{$order->no}.pdf");
        $pdf->Output($file, \Mpdf\Output\Destination::FILE);
    }
}
