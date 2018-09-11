<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Libraries\General;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use App\Models\RentalRequest;
use App\Validations\RentalRequestValidations;
use App\Transformers\DiscountCodeTransformer;

class DiscountCodesController extends Controller
{

    public function getDiscountAmount(Request $request)
    {
        list($data, $user) = [$request->all(), Auth::user()];
        if (count($user->roles) < 0) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        if (!in_array($user->roles->first()->name, ["user", "agent", "rent-admin"])) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $validator = RentalRequestValidations::getDiscountAmountValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $rentalRequests = RentalRequest::whereUserId($user->id)->whereStatus('finished')->with('discountCodes')->get();
        if (count($rentalRequests) > 0) {
            $rentalRequestWithCode = $rentalRequests->filter(function ($object) {
                if (count($object->discountCodes) > 0) {
                    return true;
                }
            })->count();
            if($rentalRequestWithCode > 0){
                return General::responseErrorAPI(trans('messages.UserAppliedCode'), 'UserAppliedCode', 400);
            }
            return General::responseErrorAPI(trans('messages.YouHaveRequestFinished'), 'YouHaveRequestFinished', 400);
        }
        $discountCode = DiscountCode::whereCode($data['code'])->where('expiry', '>=', Carbon::now()->toDateString())->first();
        if (count($discountCode) < 0 || is_null($discountCode)) {
            return General::responseErrorAPI(trans('messages.InvalidDiscountCode'), 'InvalidDiscountCode', 400);
        }
        return response()->json(DiscountCodeTransformer::transformItem($discountCode));
    }
}
