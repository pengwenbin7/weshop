<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use App\Models\Order;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\Image;
use Log;

class SendContract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $order;
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
                "simhei" => [
                    "R" => "simhei.ttf",
                ],
            ],
            "default_font" => "msyh",
        ]);
        $pdf->WriteHTML($html);
        $dir = storage_path("tmp/" . str_random(20));
        // 没必要检测目录是否存在
        mkdir($dir); 
        $file = "{$dir}/{$this->order->no}.pdf";
        $save = $pdf->Output($file, \Mpdf\Output\Destination::FILE);
        $pdf = new \Spatie\PdfToImage\Pdf($file);
        $imgs = $pdf
              ->setOutputFormat('jpg')
              ->setCompressionQuality(100)
              ->saveAllPagesAsImages($dir);
        // 图片上传到微信临时素材
        $app = EasyWeChat::officialAccount();
        foreach ($imgs as $img) {
            $up = $app->media->uploadImage($img);
            $image = new Image($up["media_id"]);
            $this->user->sendMessage($image);
        }
        // 删除目录
        exec("rm -rf $dir");
    }
}
