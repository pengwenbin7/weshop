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
        $app = EasyWeChat::officialAccount();
         //查询分组推送用户openid
        $myuser = $app->user_tag->usersOfTag(109, $nextOpenId = '');
        if (isset($myuser['data']['openid'])) {
            foreach ($myuser['data']['openid'] as $item) {
                $app->template_message->send([
                    'touser' => $item,
                    'template_id' => 'dkre4KgP3XtbMIEzv62Q3LestflHWmBYD1F4Rh8mZ2g',
                    'url' => route("wechat.product.show",$event->product->id),
                    'data' => [
                        'first' => '',
                        'keyword3' => $Variable->unit_price,
//                        'keyword2' => '',
                        'keyword2' => $event->product->model,
                        'keyword1' => $event->product->name,// $event->product->updated_at
                        'remark' => '',
                    ],
                ]);
            }
        }
    }

}
