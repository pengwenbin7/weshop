<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat;

class MenuController extends Controller
{
    private $app;
    public function __construct()
    {
        $this->app = EasyWeChat::officialAccount();
    }
    
    public function index()
    {
        Log::info("Get current menus");
        $list = $this->app->menu->list();
        print_r($list);
        return view("wechat.menu");
    }

    public function store(Request $request)
    {
        $buttons = $request->input("buttons");
        return $this->app->menu->create(json_decode($buttons));
    }
}
