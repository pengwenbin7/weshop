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
        
        if (!in_array(strtolower($browser), ["firefox", "chrome", "opera", "safari"])) {
            return "不支持当前浏览器,请使用 Firefox, Chrome, Opera, Safari";
        } else {
            return $next($request);
        }
    }
}
