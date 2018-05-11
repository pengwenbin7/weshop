<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminUser as Admin;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Cache;
use Log;
use EasyWeChat;
 
class AdminAuthController extends Controller
{    
    public function showLoginForm(Request $request)
    {
        return view("admin.auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->only("mobile", "password");
        if (Auth::guard("admin")->attempt($credentials)) {
            return redirect()->route("admin.index");
        } else {
            return "Error";
        }
    }
    
    public function callback(Request $request)
    {
        
    }
    
    public function logout()
    {
        auth("admin")->logout();
        return "You logout!";
    }
}
