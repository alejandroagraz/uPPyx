<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckRoleAdmin
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
        $user = Auth::user();
        if (!$user || !$user->hasRole('super-admin')){
            return redirect('/');
        }

        return $next($request);
    }
}
