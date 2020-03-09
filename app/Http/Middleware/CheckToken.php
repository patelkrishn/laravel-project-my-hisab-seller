<?php

namespace App\Http\Middleware;

use Cookie;
use Closure;
use AuthApi;

class CheckToken
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
        if (AuthApi::check() == 'Unauthenticated') {
            return redirect('/login');
        }
        return $next($request);
    }
}
