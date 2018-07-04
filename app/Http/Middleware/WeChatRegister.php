<?php

namespace App\Http\Middleware;

use Closure;

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
        $user = session("wechat.oauth_user");
        dd($user);
        return $next($request);
    }
}
