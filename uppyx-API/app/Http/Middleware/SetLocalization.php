<?php

namespace App\Http\Middleware;

use Closure;

class SetLocalization
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
        if (isset($request->lang) && !is_null($request->lang) && array_key_exists($request->lang, config('app.languages'))) {
            app()->setLocale($request->lang);
        } else {
            app()->setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}
