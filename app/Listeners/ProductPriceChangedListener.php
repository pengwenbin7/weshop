<?php

namespace App\Listeners;

use App\Events\ProductPriceChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use EasyWeChat;
use App\Models\User;
use App\WeChat\SpreadQR;
use App\Models\ProductVariable;
use App\Models\Brand;

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
        $Variable = ProductVariable::where(['product_id' => $event->product->id])
            ->orderBy("id", "desc")
            ->first();
        $Variable_max = ProductVariable::where(['product_id' => $event->product->id])
            ->where('id', '<>', $Variable->id)
            ->orderBy("id", "desc")
            ->first();
        $Brand = Brand::find($event->product->brand_id);
        $price = round($Variable->unit_price * 1000 / $event->content,2);
        $price_max = round($Variable_max->unit_price * 1000 / $event->content,2);
        $mypeice = '';
        if($price > $price_max){
            $mypeice = "价格上调".round($price - $price_max,2)."元/吨";
        }else{
            $mypeice = "价格下跌".round($price_max - $price,2)."元/吨";
        }
        $app = EasyWeChat::officialAccount();
         //查询分组推送用户openid
        $myuser = $app->user_tag->usersOfTag(109, $nextOpenId = '');
        if (isset($myuser['data']['openid'])) {
            foreach ($myuser['data']['openid'] as $item) {
                $app->template_message->send([
                    'touser' => $item,
                    'template_id' => 'PNgBiNoPOvZvQSnU5vl984bRKo08oAhDV24ftnssbzo',
                    'url' => route("wechat.product.show",$event->product->id),
                    'data' => [
                        'first' => $event->product->model."+".$event->product->name."价格调整。",  //蓝色
                        'keyword1' =>  $Brand->name,//科幕钛白
                        'keyword2' => $mypeice,//吨价 价格上调   价格下跌
                        'keyword3' =>"最新报价".$price."元/吨",//最新报价 1000元/吨
                        'keyword4' => $event->product->updated_at,//
                        'remark' => '',
                    ],
                ]);
            }
        }
    }

}
