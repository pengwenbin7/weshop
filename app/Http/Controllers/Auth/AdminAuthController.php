<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminUser as Admin;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Cache;
use Log;
use EasyWeChat;

class AdminAuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        $app = EasyWeChat::work();
        $config = $app->jssdk->buildConfig(["scanQRCode"], false);
        $target = $app->oauth->redirect()->getTargetUrl();
        $agent = $app->agent->get(1000005);
        dd($agent);
        
        return view("admin.auth.login", [
            "config" => $config,
            "target" => $target,
        ]);
    }

    public function callback(Request $request)
    {
        return $request->getContent();
    }
    
    public function logout()
    {
        auth("admin")->logout();
        return "You logout!";
    }
}
