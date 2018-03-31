<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $user = session("wechat_user");
        return [
            "openid" => $user->id,
            "nikename" => $user->nickname,
        ];
    }
}
