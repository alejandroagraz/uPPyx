<?php

namespace App\Http\Controllers;

use App\Transformers\CarsClassificationTransformer;
use DB;
use Validator;
use App\Models;
use App\Libraries\General;
use Illuminate\Http\Request;
use App\Models\CarClassification;
use App\Validations\CarsClassificationValidations;

class CarsClassificationController extends Controller
{
    public function getCars(Request $request)
    {
        $data = $request->all();
        $validator = CarsClassificationValidations::getCarsValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $cars = CarClassification::all();
        
        if ($cars) {
            return CarsClassificationTransformer::transformCollection($cars);

        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }
}
