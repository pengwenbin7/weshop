<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;

class ServerController extends Controller
{
    public function serve()
    {
        Log::info("request arrived.");
        $app = EasyWeChat::officialAccount();
        $app->server->push(function($message){
            switch ($message["MsgType"]) {
            case "text":
                $url = url("/wechat/search/{$message['Content']}");
                $items = [
                    new NewsItem([
                        'title'       => "测试标题",
                        'description' => "图文测试$url",
                        'url'         => $url,
                        'image'       => "",
                    ]),
                ];
                $news = new News($items);
                return $news;
                break;
            case "event":
                switch ($message["Event"]) {
                case "subscribe":
                    return new Text("感谢关注！");
                    break;
                }
                break;
            default:
                return json_encode($message, JSON_UNESCAPED_UNICODE);
                break;
            }
        });
        return $app->server->serve();
    }
}
