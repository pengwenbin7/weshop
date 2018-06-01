<?php

namespace App\Http\Middleware;

use Closure;

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
            return redirect()->route("admin.login", [
                "state" => $request->fullUrl(),
            ]);
        }
    }
}
