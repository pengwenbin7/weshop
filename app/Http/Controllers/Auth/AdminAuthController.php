<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\AdminUser as Admin;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Cache;
use Log;
use EasyWeChat;
 
class AdminAuthController extends Controller
{
    use AuthenticatesUsers;
    
    public function showLoginForm(Request $request)
    {
        $appid = env("WECHAT_WORK_CORP_ID");
        $redirect = urlencode(route("admin.auth.callback"));
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect}&response_type=code&scope=snsapi_base#wechat_redirect";
        return view("admin.auth.login", ["url" => $url]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only("mobile", "password");
        if (Auth::guard("admin")->attempt($credentials)) {
            return redirect()->route("admin.index");
        } else {
            return "Error";
        }
    }
    
    public function callback(Request $request)
    {
     
    }
    
    public function logout()
    {
        auth("admin")->logout();
        return "You logout!";
    }

    protected function guard()
    {
        return auth()->guard('admin');
    }
}
