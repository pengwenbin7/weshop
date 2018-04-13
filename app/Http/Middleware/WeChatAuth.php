<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Log;

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
        /**
         * 因为　Laravel 不能直接缓存　Request,
         * oauth授权抛弃了　Request 携带的除了 GET 参数以外的信息
         */
        if (auth()->check()) {
            return $next($request);
        } elseif ($request->has("uid")) {
            Log::info("登录了一次");
            auth()->loginUsingId($request->uid, true);
            return $next($request);
        } elseif ($request->has("oauth_token")) {
            $user = Cache::get($request->oauth_token);
            auth()->login($user);
            return $next($request);
        } else {
            Log::info("登录了一次");
            $target = $request->fullUrl();
            $appid = env("WECHAT_OFFICIAL_ACCOUNT_APPID");
            $callback = urlencode(
                env("WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK") .
                "?target={$target}"
            );
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            return redirect($url);
        }
    }
}
