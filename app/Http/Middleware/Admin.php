<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AdminUser;
use Jenssegers\Agent\Agent;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = "admin")
    {
        if (auth($guard)->check()) {
            return $next($request);
        } else {
            session(["auth.target.url" => $request->fullUrl()]);
            $agent = new Agent();
            if ($agent->isDesktop()) {
                // 桌面设备登录
                return view("admin.auth.login");
                //return redirect()->route("admin.login");
            } else {
                // 移动设备登录
                $scopes = ['snsapi_userinfo'];
                $app = \EasyWeChat::work();
                $response = $app->oauth->scopes($scopes)
                          ->setAgentId(config("wechat.work.default.agent_id"))
                          ->setRequest($request)
                          ->redirect(route("admin.auth.callback"));
                return $response;
            }
        }
    }
}
