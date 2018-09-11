<?php

namespace App\Http\Controllers;

use Auth;
use App\Libraries\General;
use Illuminate\Http\Request;
use App\Models\RentalRequest;
use App\Models\CancellationRequestReason;
use App\Validations\RentalRequestValidations;

class CancellationRequestReasonsController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function sendCancellationRequestReason(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->roles->first()->name, ["user", "agent", "rent-admin"])) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $request->merge(['user_id' => $user->uuid]);
        $data = $request->all();
        $validator = RentalRequestValidations::sendCancellationRequestReasonValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $rentalRequest = RentalRequest::whereUuid($request->rental_request_id)
            ->with(['takenByAgency', 'takenByManager', 'requestedBy', 'payments', 'requestCity'])->first();
        if (count($rentalRequest) > 0) {
            list($data['rental_request_id'], $data['user_id']) = [$rentalRequest->id, $user->id];
            CancellationRequestReason::create(CancellationRequestReason::getCancellationCreateData($data));
            return General::responseErrorAPI(trans('messages.CancellationRequestReasonCreated'), 'CancellationRequestReasonCreated', 200);
        }
        return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);

    }

}
