<?php

namespace App\Http\Controllers\WeWork;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;

class ServerController extends Controller
{
    public function server(Request $request)
    {
        $app = EasyWeChat::work();
        $app->server->push(function(){
            return 'Hello easywechat.';
        });
        
        return $app->server->serve();
    }
}
