<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;

class AdminController extends Controller
{
    public function server(Request $request)
    {
        $app = EasyWeChat::work();
        return $app->server->serve();
    }
}
