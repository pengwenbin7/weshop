<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use EasyWeChat;
use App\Models\ShopUser;

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
            if ($request->has("oauth_token")) {
                $openid = Cache::get($request->oauth_token);
                $user = ShopUser::where("openid",
                                        "=",
                                        $openid
                )->first();
                auth()->login($user);
                return $next($request);
            }
            
            $token = str_random(10) . time();
            $data["url"] = $request->url();
            $data["query"] = $request->query();
            Cache::put($token, $data, 5);
            $appid = env("WECHAT_OFFICIAL_ACCOUNT_APPID");
            $callback = urlencode(
                env("WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK") .
                "?oauth_token={$token}"
            );
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            return redirect($url);
        }
    }
}
