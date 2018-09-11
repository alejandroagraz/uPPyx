<?php

namespace App\Validations;

use Illuminate\Http\Request;

class RatesValidations
{

    static function validateDateRangesValidation(Request $request){
        $rules = [
            'car'       => 'required',
            'from'      => 'required|date',
            'to'        => 'required|date',
            'min'       => 'required|Integer|between:1,21',
            'max'       => 'required|Integer|between:1,21',
            'country_id'=> 'required',
            'city_id'   => 'required',
        ];

        $validator = \Validator::make($request->toArray(), $rules);
        return $validator;
    }


}
