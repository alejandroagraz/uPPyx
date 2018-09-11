<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('older_than', function ($attribute, $value, $parameters, $validator) {
            $minAge = (count($parameters) > 0) ? (int)array_first($parameters) : 25;
//            return (new DateTime)->diff(new DateTime($value))->y >= $minAge;
            // or the same using Carbon:
            return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
        });
        if (\App::environment('prod')) {
            \URL::forceSchema('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
