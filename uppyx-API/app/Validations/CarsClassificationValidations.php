<?php
/**
 * Created by PhpStorm.
 * User: lagonzalez
 * Date: 11/08/16
 * Time: 04:28 PM
 */

namespace App\Validations;


/**
 * Class CarsClassificationValidations
 * @package App\Models\Validations
 */
class CarsClassificationValidations
{

    /**
     * @param $data
     * @return mixed
     */
    static function getCarsValidation($data)
    {
        $rules = [];
        $rules['lang']      = 'required';

        $validator = \Validator::make($data, $rules);
        return $validator;
    }
    
}
