<?php

namespace App\Http\Controllers\WeWork;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $app = EasyWeChat::work();

        $items = [
            new NewsItem([
                'title'       => "图文消息",
                'description' => "图文消息的描述",
                'url'         => "http://weshop.mafkj.com/wework",
                'image'       => "",
            ]),
        ];
        $msg = new News($items);
        
        return $app->messenger
            ->ofAgent(env("WECHAT_WORK_AGENT_ID"))
            ->message($msg)
            ->toParty(1)
            ->send();
    }
}
