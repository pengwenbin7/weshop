<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use Auth;

class WeChatAuthController extends Controller
{
    public function __construct()
    {
    }

    public function oauth(Request $request)
    {
        $app = EasyWeChat::officialAccount();
        $user = $app->oauth->user();
        return $user;
    }
}