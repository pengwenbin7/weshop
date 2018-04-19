<?php

namespace App\Http\Controllers\WeWork;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;
use Log;

class ServerController extends Controller
{
    public function server(Request $request)
    {
        $app = EasyWeChat::work();
        $app->server->push(function ($message) use($app) {
            Log::info($message);
            $app->messenger
                ->ofAgent(env("WECHAT_WORK_AGENT_ID"))
                ->message("是你的二维码")
                ->toUser($message["FromUserName"])
                ->send();
        });
        return $app->server->serve();
    }

    public function menu()
    {
        $app = EasyWeChat::work();
        $menus = [
            'button' => [
                [
                    'name' => "首页",
                    'type' => 'view',
                    'url' => route("admin.index"),
                ],
                [
                    'name' => '待办',
                    'type' => 'view',
                    'url' => route("admin.todo"),
                ],
                [
                    'name' => '我的二维码',
                    'type' => 'click',
                    'key' => "requestMyQrCode",
                ],
            ],
        ];

        return $app->menu->create($menus);
    }
}
