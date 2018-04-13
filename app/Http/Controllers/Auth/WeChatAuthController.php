<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Cache;
use Log;

class WeChatAuthController extends Controller
{
    public function login(Request $request)
    {
        
    }
    
    public function oauth(Request $request)
    {
        if (Cache::add("oauth_code", $request->code, 5)) {
            $openid = $this->getOpenid($request->code);
        } else {
            $openid = Cache::get("openid");
        }

        // 自动注册
        try {
            $shopUser = User::where("openid", "=", $openid)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $shopUser = new User();
            $shopUser->openid = $openid;
            $shopUser->rec_code = "x"; // 这个值在监听事件中自动修改
            $shopUser->save();
        }

        $token = str_random(40);        
        Cache::put($token, $shopUser, 2);
        $url = $request->target;
        $url = str_contains($url, "?") ?
             "{$url}&oauth_token={$token}":
             "{$url}?oauth_token={$token}";
        return redirect($url);
    }

    private function getOpenid($code)
    {
        $appid = env("WECHAT_OFFICIAL_ACCOUNT_APPID");
        $secret = env("WECHAT_OFFICIAL_ACCOUNT_SECRET");
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?" .
             "appid={$appid}&secret={$secret}" .
             "&code={$code}" .
             "&grant_type=authorization_code";
        $obj = json_decode(file_get_contents($url));
        if (property_exists($obj, "openid")) {
            Cache::put("openid", $obj->openid, 5);
            return $obj->openid;
        } else {
            Log::error("{$obj->errcode}: {$obj->errmsg}");
            throw new \Exception("获取openid失败: {$obj->errmsg}");
        }
    }
}
