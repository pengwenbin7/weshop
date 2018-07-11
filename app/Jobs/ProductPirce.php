<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use EasyWeChat;
use App\Models\User;
use App\WeChat\SpreadQR;
use App\Models\Product;
use App\Models\ProductVariable;
use App\Models\ProductPrice;
use App\Models\Brand;
use App\Models\System;
use Log;

class ProductPirce implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $product;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Variable = ProductVariable::where(['product_id' => $this->product->id])
            ->orderBy("id", "desc")
            ->first();
        $Variable_max = ProductPrice::where(['product_id' => $this->product->id])
            ->orderBy("id", "desc")
            ->first();
        $system = System::where('status','=',1) -> first();
        if (!isset($system->setup_id)) {
            return;
        } else if ($system->setup_id == 10086) {
            return;
        }
        $Brand = Brand::find($this->product->brand_id);
        $price = round($Variable->unit_price * 1000 / $this->product->content,2);
        $price_max = round($Variable_max->unit_price * 1000 / $this->product->content,2);
        $mypeice = '';
        $color = '';
        if($price > $price_max){
            $mypeice = "价格上调".round($price - $price_max,2)."元/吨";
            $color = '#E80000';
        }else{
            $mypeice = "价格下跌".round($price_max - $price,2)."元/吨";
            $color = '#00BF00';
        }
        $app = EasyWeChat::officialAccount();
         //查询分组推送用户openid
        $myuser = $app->user_tag->usersOfTag($system->setup_id, $nextOpenId = '');
        if (isset($myuser['data']['openid'])) {
            foreach ($myuser['data']['openid'] as $item) {
                $app->template_message->send([
                    'touser' => $item,
                    'template_id' => 'PNgBiNoPOvZvQSnU5vl984bRKo08oAhDV24ftnssbzo',
                    'url' => route("wechat.product.show",$this->product->id),
                    'data' => [
                        'first' => $this->product->name.$this->product->model."价格调整。",
                        'keyword1' => [
                            "value" => $Brand->name,
                            "color" => "#2030A0",
                        ],
                        'keyword2' => [
                            "value" => $mypeice,
                            "color" => $color,
                        ],
                        'keyword3' => [
                            "value" => "最新报价".$price."元/吨",
                            "color" => $color,//"#2030A0",
                        ],
                        'keyword4' => date('Y-m-d',time()),
                        'remark' => '',
                    ],
                ]);
            }
        }
        return;
    }
}
