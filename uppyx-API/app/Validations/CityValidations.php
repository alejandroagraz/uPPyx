<?php
/**
 * Created by PhpStorm.
 * User: lagonzalez
 * Date: 11/15/16
 * Time: 01:35 PM
 */

namespace App\Validations;


/**
 * Class CityValidations
 * @package App\Models\Validations
 */
class CityValidations
{

    /**
     * @param $data
     * @return mixed
     */
    static function getCitiesValidation($data)
    {
        $rules = [];
        $rules['lang']      = 'required|string|in:en,es';
        $rules['city']      = 'required|string';

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    static function getCountriesValidation($data)
    {
        $rules = [];
        $rules['lang']      = 'required|string|in:en,es';

        $validator = \Validator::make($data, $rules);
        return $validator;
    }
    
}
