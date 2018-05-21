<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;
use App\Models\AdminUser as Admin;

class AdminController extends Controller
{
    public function server(Request $request)
    {
        $app = EasyWeChat::work();
        return $app->server->serve();
    }

    // 管理员转移
    public function moveUserTo(Admin $to, Admin $from = null)
    {
        $admin = $from?
               $from:
               auth("admin")->user();
        return $admin->moveUserTo($to);
    }
}
