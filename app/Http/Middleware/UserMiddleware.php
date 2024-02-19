<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            return $next($request);
        }
        return redirect()->route('login'); // Change 'user.login' to your user login route.
    }
}
