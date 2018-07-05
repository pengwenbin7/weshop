<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;
use Cache;

class WeChatAuth
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
        if (!Auth::check()) {
            // remember to delete me ////////////////////////||
            if ($request->has("uid")) {                      //
                auth()->loginUsingId($request->uid, true);   //
                if (!$request->has("rec")) {                //
                    $request->query->add([                   //
                        "rec" => auth()->user()->rec_code,   //
                    ]);                                     //
                }                                           //
                return $next($request);                     //
            }                                               //
            //////////////////////////////////////////////////
            if ($request->has("token")) {
                auth()->login(Cache::pull($request->token), true);
            } else {
                $appid = env("WECHAT_OFFICIAL_ACCOUNT_APPID");
                $state = $request->input("rec", null);
                $target = urlencode($request->fullUrl());
                $callback = env("WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK");
                $scope = env("WECHAT_OFFICIAL_ACCOUNT_OAUTH_SCOPES");
                $redirect = urlencode("{$callback}?target={$target}");
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize" .
                     "?appid={$appid}&redirect_uri={$redirect}" .
                     "&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
                return redirect($url);
            }
        }
        return $next($request);
    }
}
