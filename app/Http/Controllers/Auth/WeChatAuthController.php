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
    public function __construct()
    {
    }

    public function oauth(Request $request)
    {
        $app = EasyWeChat::officialAccount();
        $user = $app->oauth->user();
        try {
            $shopUser = ShopUser::where("openid", "=", $user->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $shopUser = new ShopUser();
            $shopUser->openid = $user->id;
            $shopUser->subscribe_count = 1;
            $shopUser->save();
            $shopUser->rec_code = "U" . $shopUser->id;
            $shopUser->save();
        }

        session(["wechat_user" => $user]);
        Auth::login($shopUser, true);
        return redirect()->route("wechat.index");
    }
}
