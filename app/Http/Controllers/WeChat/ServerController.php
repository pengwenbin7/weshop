<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;
use App\WeChat\MessageHandler;

class ServerController extends Controller
{
    public function serve()
    {
        $app = EasyWeChat::officialAccount();
        $app->server->push(function ($message) {
            $handler = new MessageHandler($message);
            return $handler->run();
        });
        return $app->server->serve();
    }


}
