<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;

class ServerController extends Controller
{
    public function serve()
    {
        Log::info('request arrived.');
        $app = EasyWeChat::officialAccount();
        $app->server->push(function($message){
            switch ($message->MsgType) {
            case "text":
                $items = [
                    new NewsItem([
                        'title'       => "测试标题",
                        'description' => "图文测试http://weshop.mafkj.com/search/" . $message->Content,
                        'url'         => "http://weshop.mafkj.com/search/" . $message->Content,
                        'image'       => "",
                    ]),
                ];
                $news = new News($items);
                break;
            default:
                return json_encode($message, JSON_UNESCAPED_UNICODE);
                break;
            }
        });
        return $app->server->serve();
    }
}
