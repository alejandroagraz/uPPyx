<?php
/**
 * Created by PhpStorm.
 * User: vroldan
 * Date: 9/21/16
 * Time: 11:01 AM
 */

namespace App\Validations;


/**
 * Class UserValidations
 * @package App\Models\Validations
 */
class UppyxClientCredentialsValidations
{

    /**
     * @param $data
     * @return mixed
     */
    static function publicEndpointsMiddlewareValidation($data)
    {
        $rules = [
            'grant_type'        => 'required|in:password,client_credentials,refresh_token',
            'client_id'         => 'required',
            'client_secret'     => 'required',
        ];
        $validator = \Validator::make($data, $rules);
        return $validator;
    }

}
