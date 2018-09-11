<?php
/**
 * Created by PhpStorm.
 * User: lagonzalez
 * Date: 11/14/16
 * Time: 03:35 PM
 */

namespace App\Validations;


/**
 * Class PolicyValidations
 * @package App\Models\Validations
 */
class PolicyValidations
{

    /**
     * @param $data
     * @return mixed
     */
    static function getPoliciesValidation($data)
    {
        $rules = [];
        $rules['lang']      = 'required';

        $validator = \Validator::make($data, $rules);
        return $validator;
    }
    
}
