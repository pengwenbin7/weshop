<?php

namespace App\Http\Middleware;

use Closure;
use EasyWeChat;
use Illuminate\Support\Facades\Log;

class WeChatAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth($guard)->check()) {
            return $next($request);
        } else {
            $app = EasyWeChat::officialAccount();
            $response = $app->oauth
                      ->setRequest($request)
                      ->redirect();
            Log::debug($response);
            return $response;
        }
    }
}
