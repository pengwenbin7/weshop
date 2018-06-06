<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AdminUser;

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
        } elseif ($request->has("uid")) {
            auth("admin")->loginUsingId($request->uid);
            return $next($request);
        } else {
            return redirect()->route("admin.login");
        }
    }
}
