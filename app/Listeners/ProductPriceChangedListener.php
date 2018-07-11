<?php

namespace App\Listeners;

use App\Events\ProductPriceChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Jobs\ProductPirce;
use EasyWeChat;
use App\Models\User;
use App\WeChat\SpreadQR;
use App\Models\ProductVariable;
use App\Models\ProductPrice;
use App\Models\Brand;
use App\Models\System;

class ProductPriceChangedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  ProductPriceChangedEvent  $event
     * @return void
     */
    public function handle(ProductPriceChangedEvent $event)
    {
        ProductPirce::dispatch($event->product);
        return;
//        $Variable = ProductVariable::where(['product_id' => $event->product->id])
//            ->orderBy("id", "desc")
//            ->first();
//        $Variable_max = ProductPrice::where(['product_id' => $event->product->id])
//            ->orderBy("id", "desc")
//            ->first();
//        $system = System::where('status','=',1) -> first();
//        if (!isset($system->setup_id)) {
//            return;
//        } else if ($system->setup_id == 10086) {
//            return;
//        }
//        $Brand = Brand::find($event->product->brand_id);
//        $price = round($Variable->unit_price * 1000 / $event->product->content,2);
//        $price_max = round($Variable_max->unit_price * 1000 / $event->product->content,2);
//        $mypeice = '';
//        $color = '';
//        if($price > $price_max){
//            $mypeice = "价格上调".round($price - $price_max,2)."元/吨";
//            $color = '#E80000';
//        }else{
//            $mypeice = "价格下跌".round($price_max - $price,2)."元/吨";
//            $color = '#00BF00';
//        }
//        $app = EasyWeChat::officialAccount();
//         //查询分组推送用户openid
//        $myuser = $app->user_tag->usersOfTag($system->setup_id, $nextOpenId = '');
//        if (isset($myuser['data']['openid'])) {
//            foreach ($myuser['data']['openid'] as $item) {
//                $app->template_message->send([
//                    'touser' => $item,
//                    'template_id' => 'PNgBiNoPOvZvQSnU5vl984bRKo08oAhDV24ftnssbzo',
//                    'url' => route("wechat.product.show",$event->product->id),
//                    'data' => [
//                        'first' => $event->product->name.$event->product->model."价格调整。",
//                        'keyword1' => [
//                            "value" => $Brand->name,
//                            "color" => "#2030A0",
//                        ],
//                        'keyword2' => [
//                            "value" => $mypeice,
//                            "color" => $color,
//                        ],
//                        'keyword3' => [
//                            "value" => "最新报价".$price."元/吨",
//                            "color" => $color,//"#2030A0",
//                        ],
//                        'keyword4' => date('Y-m-d',time()),
//                        'remark' => '',
//                    ],
//                ]);
//            }
//        }
//        return;
    }

}
