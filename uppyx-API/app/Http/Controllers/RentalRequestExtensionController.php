<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\LogType;
use Webpatser\Uuid\Uuid;
use App\Libraries\General;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\RentalRequest;
use App\Models\RentalTransaction;
use App\Models\RentalRequestExtension;
use App\Validations\RentalRequestValidations;
use App\Transformers\RentalRequestTransformer;

class RentalRequestExtensionController extends Controller
{
    /**
     * @param Request $request
     * @param $request_id
     * @return mixed
     */
    public function extendRental(Request $request, $request_id)
    {
        $user = Auth::user();
        if ($user->roles->first()->name != "user") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $request->merge(['rental_request_id' => $request_id]);
        $data = $request->all();
        $validator = RentalRequestValidations::extendRentalValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $rentalRequest = RentalRequest::whereUuid($request_id)
            ->with(['takenByManager', 'takenByAgency', 'takenByUser', 'classification', 'requestCity', 'takenByUserDropOff',
                'cancellationRequestReasons', 'rentalRequestExtensions'])->first();
        if (count($rentalRequest) > 0) {
            if (!in_array($rentalRequest->status, ['on-board'])) {
                return General::responseErrorAPI(trans('messages.RequestOutOfStatusToExtend'),
                    'RequestOutOfStatusToExtend', 400);
            }
            if (count($rentalRequest->rentalRequestExtensions) > 0) {
                $extensions = $rentalRequest->rentalRequestExtensions;
                $lastExtension = $extensions->sortByDesc('created_at')->first();
                $dropOffLastDate = $lastExtension->dropoff_date;
            } else {
                $dropOffLastDate = $rentalRequest->dropoff_date;
            }
            $configurations = Configuration::getAllConfigurations($rentalRequest->city_id);
            list($oldDropOffDate, $newDropOffDate) = [Carbon::parse($dropOffLastDate), Carbon::parse($data['dropoff_date'])];
            $diff = $oldDropOffDate->diffInDays($newDropOffDate, false);
            if ($diff > $configurations['max_days_by_rental']['value']) {
                return General::responseErrorAPI(trans('messages.RequestOutOfDaysToExtend',
                    ['days' => $configurations['max_days_by_rental']['value']]), 'RequestOutOfDaysToExtend', 400);
            }
            $diff = Carbon::now()->diffInHours($oldDropOffDate, false);
            if ($diff < $configurations['extends_request_time']['value']) {
                return General::responseErrorAPI(trans('messages.RequestUnavailableToExtend',
                    ['hours' => $configurations['extends_request_time']['value']]), 'RequestUnavailableToExtend', 400);
            }
            $transactionResponse = DB::transaction(function () use ($rentalRequest, $data, $user, $request) {
                list($rentalRequestExtension, $rentalTransaction) = [new RentalRequestExtension(), new RentalTransaction()];
                $rentalRequestExtension->loadData($rentalRequest, $data, $user);
                $extensionResult = $rentalRequest->rentalRequestExtensions()->save($rentalRequestExtension);
                $rentalTransaction->loadData($user->id, $rentalRequest->id, "sum", $data['total_cost']);
                $transactionResult = $rentalRequest->rentalTransactions()->save($rentalTransaction);
                if ($extensionResult && $transactionResult) {
                    $saveExtensionChargeResponse = $this->saveExtensionCharge($rentalRequest, $request);
                    if ($saveExtensionChargeResponse !== true) {
                        DB::rollBack();
                        return $saveExtensionChargeResponse;
                    }
                } else {
                    return General::responseErrorAPI(trans('messages.ErrorSavingData'), 'ErrorSavingData', 400);
                }
                return true;
            });
            if($transactionResponse !== true) {
                return $transactionResponse;
            }
            $rentalRequest = RentalRequest::whereUuid($request_id)
                ->with(['takenByManager', 'takenByAgency', 'takenByUser', 'classification', 'requestCity',
                    'cancellationRequestReasons', 'rentalRequestExtensions'])->first();
            $this->createLog($rentalRequest);
            return response()->json(RentalRequestTransformer::transformItem($rentalRequest, true));
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }

    }

    /**
     * @param $rentalRequest
     * @param $request
     * @return bool|mixed
     */
    public function saveExtensionCharge($rentalRequest, $request)
    {
        $paymentDescription = RentalRequestController::getPaymentDescription($rentalRequest, $request, 'charge', $request['total_days']);
        $request->merge(['amount' => $request['total_cost'], 'currency' => 'usd', 'description' => $paymentDescription,
            'capture' => true
        ]);
        $request->only(['amount', 'currency', 'description', 'capture']);
        $response = app('App\Http\Controllers\StripeController')->createCharge($request, $rentalRequest);
        if ($response->getStatusCode() != 200) {
            $jsonContent = json_decode($response->getContent());
            list($errorTittle, $errorMessage, $errorType, $errorCode, $errorDeclineCode) = $this->getJsonStripeError($jsonContent);
            if ($errorTittle === "StripeCardError" || $errorType === "card_error" || $errorCode === "card_declined") {
                return General::responseErrorAPI(trans('messages.PaymentMethodError'), $errorTittle);
            }
            return General::responseErrorAPI($jsonContent->message, $errorTittle);
        }
        return true;
    }

    /**
     * @param $jsonContent
     * @return array
     */
    public function getJsonStripeError($jsonContent)
    {
        $title = (isset($jsonContent->data->title)) ? $jsonContent->data->title : "";
        $message = (isset($jsonContent->data->body->error->message)) ? $jsonContent->data->body->error->message : "";
        $type = (isset($jsonContent->data->body->error->type)) ? $jsonContent->data->body->error->type : "";
        $code = (isset($jsonContent->data->body->error->code)) ? $jsonContent->data->body->error->code : "";
        $decline_code = (isset($jsonContent->data->body->error->decline_code)) ? $jsonContent->data->body->error->decline_code : "";
        return [$title, $message, $type, $code, $decline_code];
    }

    /**
     * @param $rentalRequest
     * @return bool|static
     */
    public function createLog($rentalRequest){
        $logType = LogType::whereName('extended_request')->first();
        if(count($logType) > 0) {
            $logTypeId = $logType->id;
        } else {
            $logTypeId = null;
        }
        if($logTypeId != null) {
            $data = [
                'uuid' => Uuid::generate(4)->string,
                'log_type_id' => $logTypeId,
                'user_id' => (count(Auth::user()) > 0) ? Auth::user()->id : $rentalRequest->user_id,
                'rental_request_id' => $rentalRequest->id,
                'rental_agencies_id' => $rentalRequest->taken_by_agency,
                'message' => $rentalRequest->status // TODO Modify Message
            ];
            $log = Log::create($data);
        } else {
            $log = false;
        }
        return $log;
    }


}
