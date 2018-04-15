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
    public function oauth(Request $request)
    {
        do {
            $openid = $this->getOpenid($request->code);
        } while (!$openid);

        // 自动注册
        try {
            $user = User::where("openid", "=", $openid)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $user = new User();
            $user->openid = $openid;
            $user->rec_code = "xyz"; // 这个值在监听事件中自动修改
            $user->rec_from = $request->input("state", null);
            $user->save();
        }
        $token = time() . str_random(20);
        Cache::put($token, $user, 2);
        $target = str_contains($request->target, "?") ?
                "{$request->target}&token={$token}" :
                "{$request->target}?token={$token}";
        return redirect($target);
    }

    public function logout()
    {
        auth()->logout();
        return "You logout!";
    }

    private function getOpenid($code)
    {
        if (!Cache::has($code)) {
            $appid = env("WECHAT_OFFICIAL_ACCOUNT_APPID");
            $secret = env("WECHAT_OFFICIAL_ACCOUNT_SECRET");
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?" .
                 "appid={$appid}&secret={$secret}" .
                 "&code={$code}" .
                 "&grant_type=authorization_code";
            $obj = json_decode(file_get_contents($url));
            if (property_exists($obj, "openid")) {
                cache([$code => $obj->openid], 5);
            } else {
                throw new \Exception("获取openid失败: {$obj->errmsg}");
            }
        }
        return cache($code, false);
    }
}
