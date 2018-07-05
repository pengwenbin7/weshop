<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class WeChatRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            return $next($request);
        } else {
            $user = session("wechat.oauth_user")["default"];
            $us = User::where("openid", $user->getId())->get();
            if ($us->isEmpty()) {
                // web register
                $u = User::webRegister($user, $request->input("rec", null));
            } else {
                $u = $us->first();
            }
            auth()->login($u);
            return $next($request);
        }
    }
}
