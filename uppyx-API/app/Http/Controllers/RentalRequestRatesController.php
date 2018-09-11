<?php

namespace App\Http\Controllers;

use Auth;
use App\Libraries\General;
use Illuminate\Http\Request;
use App\Models\RentalRequest;
use App\Models\RentalRequestRate;
use App\Validations\RentalRequestValidations;
use App\Transformers\RentalRequestTransformer;

class RentalRequestRatesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function rateExperience(Request $request)
    {
        $user = Auth::user();
        if ($user->roles->first()->name != "user") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $data = $request->all();
        $validator = RentalRequestValidations::rateExperienceValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $rentalRequest = RentalRequest::whereUuid($data['rental_request_id'])->with(['takenByManager', 'takenByAgency',
            'takenByUser', 'classification', 'requestCity', 'takenByUserDropOff', 'cancellationRequestReasons',
            'rentalRequestExtensions', 'rentalRequestRates'])->first();
        if (count($rentalRequest) > 0) {
//            if (!in_array($rentalRequest->status, ['returned-car','finished'])) {
//                return General::responseErrorAPI(trans('messages.RequestOutOfStatusToRate'),
//                    'RequestOutOfStatusToRate', 400);
//            }
            if (count($rentalRequest->rentalRequestRates) > 0) {
                return General::responseErrorAPI(trans('messages.RequestWithRate'),
                    'RequestWithRate', 400);
            }
            $rentalRequestRate = new RentalRequestRate();
            $rentalRequestRate->loadData($rentalRequest, $data, $user);
            $rateResult = $rentalRequest->rentalRequestRates()->save($rentalRequestRate);
            if ($rateResult) {
                $rentalRequest = RentalRequest::whereUuid($data['rental_request_id'])
                    ->with(['takenByManager', 'takenByAgency', 'takenByUser', 'classification', 'requestCity',
                        'cancellationRequestReasons', 'rentalRequestExtensions', 'rentalRequestRates'])->first();
                return response()->json(RentalRequestTransformer::transformItem($rentalRequest, true));
            } else {
                return General::responseErrorAPI(trans('messages.ErrorSavingData'), 'ErrorSavingData', 400);
            }
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }

    }
}
