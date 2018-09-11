<?php

namespace App\Http\Middleware;

use Closure;
use App\Libraries\General;
use App\Models\OauthClient;
use App\Validations\UppyxClientCredentialsValidations;

class UppyxClientCredentials
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

        if(!self::publicEndpointsMiddleware($request)){
            return General::responseErrorAPI('Failed to authenticate because of bad credentials or an invalid authorization header.', "Validation Failed", 401);
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function publicEndpointsMiddleware($request){
        $data = $request->all();
        $validator = UppyxClientCredentialsValidations::publicEndpointsMiddlewareValidation($data);
        if ($validator->fails()) {
            return false;
        }

        //find auth client
        $OAuth = OauthClient::whereId($request->client_id)->whereSecret($request->client_secret)->first();
        if($OAuth){
            return true;
        }else{
            return false;
        }
    }
}
