<?php

namespace App\Http\Middleware;

use Closure;
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
    public function handle($request, Closure $next)
    {
        $agent = new Agent();
        $browser = $agent->browser();

        if ($agent->isRobot()) {
            return "success";
        }
        if (in_array(strtolower($browser), ["ie"])) {
            return "不支持 IE 浏览器";
        }
        if (auth("admin")->check()) {
            return $next($request);
        } else {
            return redirect()->route("admin.auth.login");
        }
    }
}
