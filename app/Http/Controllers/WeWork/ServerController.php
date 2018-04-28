<?php

namespace App\Http\Controllers\WeWork;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WeChat\Work\Events\ContactEvent;
use EasyWeChat;

class ServerController extends Controller
{
    protected $app;
    public function __construct()
    {
        $this->app = EasyWeChat::work();
    }
    
    public function server(Request $request)
    {
        $app = $this->app;
        $app->server->push(function ($message) use($app) {
            $app->messenger
                ->ofAgent(env("WECHAT_WORK_AGENT_ID"))
                ->message(json_encode($message, JSON_UNESCAPED_UNICODE))
                ->toUser("PengWenBin")
                ->send();
        });
        return $app->server->serve();
    }

    /**
     * 企业微信，通讯录修改回调
     */
    public function contact(Request $request)
    {
        $app = $this->app;
        $app->server->push(function ($message) {
            // 正常情况下，以下判断是满足的
            if ($message["MsgType"] == "event" &&
                $message["Event"] == "change_contact") {
                $event = new ContactEvent($message);
                $event->handle();
            } 
            return "success";
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
