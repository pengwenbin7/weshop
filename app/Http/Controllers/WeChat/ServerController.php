<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Voice;
use App\Models\User;
use App\WeChat\SpreadQR;
use EasyWeChat\Kernel\Messages\Image;
use App\WeChat\MessageHandler;

class ServerController extends Controller
{
    public function serve()
    {
        $app = EasyWeChat::officialAccount();
        $app->server->push(function ($message) {
            $handler = new MessageHandler($message);
            $handler->handle();
        });
        return $app->server->serve();
    }


}
