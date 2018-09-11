<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\User;

class CheckDeviceLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (isset($request->lang) && !is_null($request->lang) && array_key_exists($request->lang, config('app.languages'))) {
            if (count($user) > 0) {
                if ($user->default_lang != $request->lang) {
                    User::whereId($user->id)->update(['default_lang' => $request->lang]);
                }
            }
        } else {
            if (count($user) > 0) {
                if (is_null($user->default_lang)) {
                    User::whereId($user->id)->update(['default_lang' => 'en']);
                }
            }
        }
        return $next($request);
    }
}
