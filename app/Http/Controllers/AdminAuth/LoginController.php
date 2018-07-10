<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use EasyWeChat;
use App\Models\AdminUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        return view("admin.auth.login");
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function login(Request $request)
    {
        $credentials = $request->only("mobile", "password");
        if (Auth::guard("admin")->attempt($credentials)) {
            return redirect()->to(session("auth.target.url", route("admin.index")));
        } else {
            return view('admin.auth.login', ["error" => "账号密码错误"]);
        }
    }

    public function callback(Request $request)
    {
        $code = $request->code;
        $app = EasyWeChat::work();
        $accessToken = $app->access_token;
        $token = $accessToken->getToken()["access_token"];
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$token}&code={$code}";
        $info = json_decode(file_get_contents($url));
        $us = AdminUser::where("userid", "=", $info->UserId)->get();
        if ($us->isNotEmpty()) {
            $user = $us->first();
            auth("admin")->login($user);
            return redirect()->to(session("auth.target.url", route("admin.index")));
        } else {
            return "尚未完成注册";
        }
    }
}
