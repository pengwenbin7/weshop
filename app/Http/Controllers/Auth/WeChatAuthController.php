<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use EasyWeChat;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WeChatAuthController extends Controller
{
    public function oauth(Request $request)
    {
        $app = EasyWeChat::officialAccount();
        $user = $app->oauth->user();
        // auto register user
        try {
            $shopUser = ShopUser::where("openid", "=", $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $shopUser = new ShopUser();
            $shopUser->openid = $user->id;
            $shopUser->rec_code = "x"; // 这个值在监听事件中自动修改
            $shopUser->save();
        }
        // cache userinfo
        session(["wechat_user" => $user]);
        Auth::login($shopUser, true);
        return redirect()->route("wechat.index");
    }



}
