<?php
/**
 * Created by PhpStorm.
 * User: lagonzalez
 * Date: 11/14/16
 * Time: 03:28 PM
 */

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\City;
use App\Models\Country;
use App\Libraries\General;
use Illuminate\Http\Request;
use App\Validations\CityValidations;
use App\Transformers\CityTransformer;

class CityController extends Controller
{
    /**
     * @param Request $request
     * @return array|mixed
     */
    public function getCities(Request $request)
    {
        $data = $request->all();
        $validator = CityValidations::getCitiesValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }

        $cities = City::with('country', 'polilines', 'bounds')->where('name', 'LIKE', '%'.strtolower($data['city']).'%')->get();

        if ($cities && (count($cities) > 0)) {
            return CityTransformer::transformCollection($cities);

        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @return string
     */
    public function getCountries(Request $request)
    {
        $data = $request->all();
        $validator = CityValidations::getCountriesValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $countries = Country::all();
        if ((count($countries) > 0)) {
            return response()->json(CityTransformer::transformCountryCollection($countries));
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }
}
