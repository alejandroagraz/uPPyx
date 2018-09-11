<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckRoleRentAdmin
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
        if (! $user->hasRole('rent-admin')){

            return redirect('/');
        }
        return $next($request);
    }
}
