<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat;

class ServerController extends Controller
{
    public function serve()
    {
        Log::info('request arrived.');
        $app = EasyWeChat::officialAccount();
        $app->server->push(function($message){
            return date("h:m:s", time()) . "@欢迎关注@" . json_encode($message);
        });
        return $app->server->serve();
    }
}
