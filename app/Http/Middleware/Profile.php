<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Profile
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
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        /*elseif (Auth::user()->last_known_ip != $request->ip() && Auth::user()->email != 'torres@gmail.com')
        {
            Auth::logout();
            return redirect('/auth/login');
        }*/

        return $next($request);
    }
}
