<?php

namespace App\Listeners;

use App\Events\ProductPriceChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


use Log;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Voice;
use App\Models\User;
use App\WeChat\SpreadQR;
use EasyWeChat\Kernel\Messages\Image;

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
//        $app = EasyWeChat::officialAccount();
//        //通过模板消息发送降价信息
//        $app->template_message->sendSubscription([
//            'touser' => 'user-openid',
//            'template_id' => 'template-id',
//            'url' => 'https://easywechat.org',
//            'scene' => 1000,
//            'data' => [
//                'key1' => 'VALUE',
//                'key2' => 'VALUE2',
//               ],
//         ]);
//
//        // 至少两个用户的 openid，必须是数组。
//        $app->broadcasting->sendText("大家好！欢迎使用 EasyWeChat。");
//        return "success";
//
//        Log::error("我是");//$event->product
        /* do something
        $product = $event->product;
        $prices = $product->prices->orderBy("created_at", "desc")->get();
        */
    }

}
