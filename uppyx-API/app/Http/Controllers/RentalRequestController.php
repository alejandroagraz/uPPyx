<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Auth;
use App\User;
use Validator;
use Datatables;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Rate;
use App\Models\Charge;
use App\Libraries\Push;
use App\Models\Payment;
use Webpatser\Uuid\Uuid;
use App\Libraries\General;
use App\Models\ChargeReset;
use App\Models\DiscountCode;
use App\Models\RentalAgency;
use Illuminate\Http\Request;
use App\Models\RentalRequest;
use App\Models\Configuration;
use App\Jobs\SendSummaryEmail;
use App\Models\RequestLicense;
use App\Models\RentalTransaction;
use Illuminate\Support\Facades\Hash;
use App\Transformers\UserTransformer;
use App\Models\RentalRequestExtension;
use App\Validations\RentalRequestValidations;
use App\Transformers\RentalRequestTransformer;
use App\Mail\ReminderManagerAssignAgents as ManagerEmail;

/**
 * Class RentalRequestController
 * @package App\Http\Controllers
 */
class RentalRequestController extends Controller
{
    public $coordinates = [];

    /**
     * RentalRequestController constructor.
     */
    public function __construct()
    {
        $this->middleware('CheckDeviceLanguage')->only(['createRequest', 'changeStatusRequestById',
            'getAcceptedRequests', 'getAssignedRequests']);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createRequest(Request $request)
    {
        list($data, $user) = [$request->all(), Auth::user()];
        $validator = RentalRequestValidations::createRequestValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $existRequest = RentalRequest::whereIn('status', ['sent', 'taken-manager', 'taken-user', 'on-way', 'checking',
            'on-board'])->whereUserId($user->id)->get();
        if (count($existRequest) > 0) {
            // TODO: return active request object
            return General::responseErrorAPI(trans('messages.YouHaveRequestActive'), 'YouHaveRequestActive');
        }
        list($requestTypeTime, $enablePushLog, $enableResendPush) = Configuration::getCreateRequestConfiguration($data['city_id']);
        $rentalRequest = new RentalRequest();
        $rentalRequest->loadCreateData($data, $user, $requestTypeTime);
        $rentalRequest->fill($data);
        if ($rentalRequest->save()) {
            if ($request->has('image_id')) {
                $license = RequestLicense::whereId($request->image_id)->first();
                if (count($license) > 0) {
                    $license->rental_request_id = $rentalRequest->id;
                    $license->save();
                }
            }
            // Send push all manager
            PushLogsController::sendPushToManagers($rentalRequest, $enablePushLog, $enableResendPush);
            $this->createLog($rentalRequest);
            if (isset($data['discount_code_id'])) {
                $this->attachCode($rentalRequest, $data);
            }
            return response()->json(RentalRequestTransformer::transformItem($rentalRequest));
        } else {
            return General::responseErrorAPI(trans('messages.ErrorSavingData'), 'ErrorSavingData');
        }
    }

    /**
     * @param Request $request
     * @param $request_id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function updateRequest(Request $request, $request_id)
    {
        $user = Auth::user();
        if ($user->roles->first()->name != "user") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $request->merge(['rental_request_id' => $request_id]);
        $data = $request->all();
        $validator = RentalRequestValidations::updateRequestValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $rentalRequest = RentalRequest::whereUuid($request_id)
            ->with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments',
                'classification', 'requestCity', 'cancellationRequestReasons', 'discountCodes', 'rentalRequestExtensions',
                'rentalRequestRates'])->first();
        if (count($rentalRequest) > 0) {
            $configurations = Configuration::getAllConfigurations($rentalRequest->city_id);
            if (count($rentalRequest->rentalRequestExtensions) > 0) {
                $lastExtension = $rentalRequest->rentalRequestExtensions->sortByDesc('created_at')->first();
                $dropOffDate = $lastExtension->dropoff_date;
            } else {
                $dropOffDate = $rentalRequest->dropoff_date;
            }
            $diff = Carbon::now()->diffInHours(Carbon::parse($dropOffDate), false);
            if ($diff > $configurations['modify_request_max_time']['value']) {
                if (count($rentalRequest->rentalRequestExtensions) > 0) {
                    $lastExtension = $rentalRequest->rentalRequestExtensions->sortByDesc('created_at')->first();
                    $lastExtension->update(['dropoff_address' => $data['dropoff_address'],
                        'dropoff_address_coordinates' => $data['dropoff_address_coordinates']]);
                } else {
                    $rentalRequest->update(['dropoff_address' => $data['dropoff_address'],
                        'dropoff_address_coordinates' => $data['dropoff_address_coordinates']]);
                }
                return response()->json(RentalRequestTransformer::transformItem($rentalRequest));
            } else {
                return General::responseErrorAPI(trans('messages.RequestOutOfDateToModify'), 'RequestOutOfDateToModify', 400);
            }
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getRequests(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->roles->first()->name, ["user"])) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $data = $request->all();
        $validator = RentalRequestValidations::getRequestsValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $rentalRequests = RentalRequest::whereIn('status', ['finished'])->whereUserId($user->id)->with(['requestedBy',
            'takenByAgency', 'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments', 'classification',
            'requestCity', 'cancellationRequestReasons', 'discountCodes', 'rentalRequestExtensions',
            'rentalRequestRates'])->orderBy('pickup_date', 'asc')->paginate($data['limit']);
        if (count($rentalRequests) > 0) {
            return response()->json(RentalRequestTransformer::transformCollection($rentalRequests));
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function RentalRequestList()
    {
        $statuses = ['sent', 'taken-manager', 'taken-user', 'on-way', 'checking', 'on-board', 'taken-user-dropoff',
            'returned-car', 'finished', 'cancelled', 'cancelled-system', 'cancelled-app'];
        $agencies = RentalAgency::orderBy('name', 'asc')->get();
        $maxTotalCostRequests = (int)RentalRequest::max('total_cost');
        $maxTotalCostExtensions = (int)RentalRequestExtension::max('total_cost');
        $maxTotalCost = ($maxTotalCostRequests >= $maxTotalCostExtensions) ? $maxTotalCostRequests : $maxTotalCostExtensions;
        return view('request.request-list', ['statuses' => $statuses, 'agencies' => $agencies, 'maxTotalCost' => $maxTotalCost]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PendingRentalRequests()
    {
        $user = Auth::user();
        if (count($user->roles) < 0) {
            return redirect('/')->with('message_type', 'error')->with('status', trans('messages.DenyAccess'));
        }
        if (!in_array($user->roles->first()->name, ["super-admin", "rent-admin", "agent"])) {
            return redirect('/')->with('message_type', 'error')->with('status', trans('messages.DenyAccess'));
        }
        $data['rentalRequests'] = RentalRequest::whereIn('status', ['on-board', 'taken-user-dropoff', 'returned-car'])
            ->with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments',
                'classification', 'requestCity', 'cancellationRequestReasons', 'discountCodes',
                'rentalRequestExtensions', 'rentalRequestRates']);
        if ($user->roles->first()->name == 'super-admin') {
            $data['rentalRequests'] = $data['rentalRequests']->
            whereIn('status', ['on-board', 'taken-user-dropoff', 'returned-car'])->get();
        } elseif ($user->roles->first()->name == 'rent-admin') {
            $data['rentalRequests'] = $data['rentalRequests']->whereTakenByManager($user->id)
                ->orWhereHas('takenByAgency', function ($query) use ($user) {
                    $query->whereId($user->rental_agency_id);
                })->whereIn('status', ['on-board', 'taken-user-dropoff', 'returned-car'])->get();
        } else {
            $data['rentalRequests'] = $data['rentalRequests']->takenByUserDropOff($user->id)->get();
        }
        return view('request.pending-requests', $data);
    }

    /**
     * @param Request $request
     * @param $requestId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function EditRentalRequest(Request $request, $requestId)
    {
        $request->merge(['rental_request_id' => $requestId]);
        $data = $request->all();
        $validator = RentalRequestValidations::EditRentalRequestValidation($data);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['error' => ucfirst($validator->messages()->first())], 400);
            }
            return view('request.pending-requests', $data)->withErrors($validator->errors()->all());
        }
        $user = User::whereEmail($request->email)->first();
        $rentalRequest = RentalRequest::whereUuid($data['rental_request_id'])->whereUserId($user->id)->first();
        if (count($rentalRequest) <= 0) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Datos no encontrados'], 400);
            }
            return view('request.pending-requests', $data)->with('error', 'Datos no encontrados');
        }
        $user = Auth::user();
        if (!Hash::check($request->password, $user->password)) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Contraseña Incorrecta'], 400);
            }
            return view('request.pending-requests', $data)->with('error', 'Contraseña Incorrecta');
        }
        $rentalRequest->update(['status' => 'finished']);
        $this->sendPushNotification($rentalRequest, 'Finished', 'devicesManager');
        $this->sendPushNotification($rentalRequest, 'Finished', 'devicesAgentDropoff');
        $this->sendPushNotification($rentalRequest, 'Finished', 'devices', true);
        $this->createLog($rentalRequest);
        if ($request->ajax()) {
            return response()->json(['success' => 'Solicitud Finalizada'], 200);
        }
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function RentalRequestListData(Request $request)
    {
        $rentalRequests = RentalRequest::with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser',
            'takenByUserDropOff', 'payments', 'classification', 'requestCity', 'cancellationRequestReasons', 'discountCodes',
            'rentalRequestExtensions', 'rentalRequestRates'])->get();

        if ($request->agency_id > 0) {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                return ($rentalRequest->taken_by_agency == $request->agency_id) ? true : false;
            });
        }
        if ($request->statuses > 0) {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                return (in_array($rentalRequest->status, $request->statuses)) ? true : false;
            });
        }
        if ($request->from != "" && $request->to != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                list($from, $to) = [Carbon::parse($request->from), Carbon::parse($request->to)->addHours(23)
                    ->addMinutes(59)->addSeconds(59)];
                return (Carbon::parse($rentalRequest->full_created_at)->between($from, $to)) ? true : false;
            });
        }
        if ($request->pickup_date_from != "" && $request->pickup_date_to != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                list($from, $to) = [Carbon::parse($request->pickup_date_from), Carbon::parse($request->pickup_date_to)];
                return (Carbon::parse($rentalRequest->full_pickup_date)->between($from, $to)) ? true : false;
            });
        }
        if ($request->min != "" && $request->max != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                $object = self::getRequestObject($rentalRequest);
                return ($object->total_days >= $request->min && $object->total_days <= $request->max) ? true : false;
            });
        }
        if ($request->min_cost != "" && $request->min_cost != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                $object = self::getRequestObject($rentalRequest);
                return ($object->total_cost >= $request->min_cost && $object->total_cost <= $request->max_cost) ? true : false;
            });
        }
        if ($request->dropoff_date_from != "" && $request->dropoff_date_to != "") {
            $rentalRequests = $rentalRequests->filter(function ($rentalRequest) use ($request) {
                $object = self::getRequestObject($rentalRequest);
                list($from, $to) = [Carbon::parse($request->dropoff_date_from), Carbon::parse($request->dropoff_date_to)];
                return (Carbon::parse($object->full_dropoff_date)->between($from, $to)) ? true : false;
            });
        }
        return Datatables::of($rentalRequests)->make(true);
    }

    /**
     * @param $rentalRequest
     * @return mixed
     */
    public static function getRequestObject($rentalRequest)
    {
        $lastExtension = $rentalRequest->rentalRequestExtensions->sortByDesc('created_at')->first();
        return (count($lastExtension) > 0) ? $lastExtension : $rentalRequest;
    }

    /**
     * @param Request $request
     * @param $requestId
     * @return array|mixed
     */
    public function getRequest(Request $request, $requestId)
    {
        $request->merge(['request_id' => $requestId]);
        $data = $request->all();
        $validator = RentalRequestValidations::getRequestValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $request = RentalRequest::with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser',
            'takenByUserDropOff', 'payments', 'classification', 'requestCity', 'cancellationRequestReasons',
            'discountCodes', 'rentalRequestExtensions', 'rentalRequestRates'])->whereUuid($data['request_id'])->first();
        if (count($request) > 0) {
            return RentalRequestTransformer::transformItem($request);
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @return mixed
     * @description This method is called from Artisan CLI "command line interface" Delay Time for request
     */
    public function cancelRequest()
    {
        // TODO: get configuration by country and city
        $maxWaitTime = Configuration::whereAlias('max_wait_time')->first(); //->whereCountryId($request->country)->whereCityId($request->city)
        $maxWaitTime = (count($maxWaitTime) > 0) ? $maxWaitTime->value : 2;
        $requests = RentalRequest::with('requestedBy', 'devices')->whereIn('type', ['standard', 'planned'])
            ->whereStatus('sent')->whereNull('taken_by_user')->whereNull('taken_by_manager')->whereNull('taken_by_agency')
            ->where('created_at', '<', Carbon::now()->subMinutes((int)$maxWaitTime)->toDateTimeString())
            ->get();

        $countCancelledRequests = 0;
        if (count($requests) > 0) {
            foreach ($requests as $request) {
                if ($request->discountCodes()->count() > 0) {
                    $request->discountCodes()->detach();
                }
                $request->update(['status' => 'cancelled-system']);
                foreach ($request->devices as $device) {
                    $requestTransformed = RentalRequestTransformer::transformItem($request);
                    if (count($request->requestedBy) > 0) {
                        $locale = ($request->requestedBy->default_lang === 'en') ? 'en' : 'es';
                    } else {
                        $locale = null;
                    }
                    Push::sendPushNotification($device->token_device, trans('messages.RequestCancelled', [], 'messages', $locale),
                        $device->operative_system, ['view' => '1',
                            'body' => (isset($requestTransformed['data'])) ? array_first($requestTransformed['data']) : null]);
                }
                $this->createLog($request);
                $countCancelledRequests++;
            }
            return General::responseSuccessAPI(trans('messages.RequestsCancelled', ['request' => $countCancelledRequests]),
                'RequestsCancelled', 200);
        } else {
            return General::responseErrorAPI(trans('messages.RequestsNotCancelled'), 'RequestsNotCancelled', 200);
        }
    }

    /**
     * This method is called from Artisan CLI "command line interface"
     * Charge Planned Request
     * @return mixed
     */
    public function chargePlannedRequest()
    {
        // TODO: get configuration by country and city
        $chargeRequestTime = Configuration::whereAlias('charge_planned_request_time')->first(); //->whereCountryId($request->country)->whereCityId($request->city)
        $chargeRequestTime = (count($chargeRequestTime) > 0) ? (int)$chargeRequestTime->value : 24;
        $plannedRequests = RentalRequest::with(['requestedBy', 'takenByManager', 'takenByAgency', 'takenByUser', 'devices'])
            ->whereType('planned')->whereIn('status', ['taken-manager', 'taken-user'])
            ->whereRaw('TIMESTAMPDIFF(HOUR, ?, pickup_date) <= ' . $chargeRequestTime, [Carbon::now()->toDateTimeString()])
            ->doesntHave('payments')->get();
        $countChargeRequests = 0;
        if (count($plannedRequests) > 0) {
            foreach ($plannedRequests as $plannedRequest) {
                $request = new Request();
                $blockChargeResponse = $this->blockCharge($plannedRequest, $request);
                if ($blockChargeResponse !== true) {
                    return $blockChargeResponse;
                }
                $rentalTransaction = new RentalTransaction();
                $rentalTransaction->loadData($plannedRequest->user_id, $plannedRequest->id, "held", $plannedRequest->blocked_amount);
                $plannedRequest->rentalTransactions()->save($rentalTransaction);
                $countChargeRequests++;
            }
            return General::responseSuccessAPI(trans('messages.RequestsCharged', ['request' => $countChargeRequests]),
                'RequestsCharged', 200);
        } else {
            return General::responseErrorAPI(trans('messages.RequestsNotPreCharged'), 'RequestsNotPreCharged', 200);
        }
    }

    /**
     * This method is called from Artisan CLI "command line interface"
     * Remind Managers to assign planned requests
     * @return mixed
     */
    public function emailPlannedRequest()
    {
        // TODO: get configuration by country and city
        $sendMailTime = Configuration::whereAlias('send_mail_manager_time')->first(); //->whereCountryId($request->country)->whereCityId($request->city)
        $sendMailTime = (count($sendMailTime) > 0) ? (int)$sendMailTime->value : 24;
        $plannedRequests = RentalRequest::with(['requestedBy', 'takenByManager', 'takenByAgency', 'takenByUser', 'devices'])
            ->select(DB::raw('taken_by_manager, COUNT(1) AS total_request'))
            ->whereType('planned')->whereIn('status', ['taken-manager'])
            ->whereRaw('TIMESTAMPDIFF(HOUR, ?, pickup_date) <= ' . $sendMailTime, [Carbon::now()->toDateTimeString()])
            ->doesntHave('takenByUser')
            ->groupBy('taken_by_manager')
            ->get();

        $reminderEmails = 0;
        if (count($plannedRequests) > 0) {
            foreach ($plannedRequests as $plannedRequest) {
                if (count($plannedRequest->takenByManager) > 0) {
                    Mail::to($plannedRequest->takenByManager->email, $plannedRequest->takenByManager->name)
                        ->send(new ManagerEmail($plannedRequest));
                    $reminderEmails++;
                }
            }
            return General::responseSuccessAPI(trans('messages.ReminderSend', ['emails' => $reminderEmails]),
                'ReminderSend', 200);
        } else {
            return General::responseErrorAPI(trans('NothingToDo'), 'NothingToDo', 200);
        }
    }

    /**
     * @param Request $request
     * @param null $rentalRequestId
     * @return mixed
     */
    public function changeStatusRequestById(Request $request, $rentalRequestId)
    {
        $request->merge(['rental_request_id' => $rentalRequestId]);
        $data = $request->all();
        $validator = RentalRequestValidations::changeStatusRequestByIdValidation($data);

        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        list($rentalRequest, $user) = [RentalRequest::whereUuid($request->rental_request_id)->with(['requestedBy',
            'takenByAgency', 'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments', 'requestCity',
            'cancellationRequestReasons', 'discountCodes', 'rentalRequestExtensions', 'rentalRequestRates'])->first(), Auth::user()];
        if (count($rentalRequest) > 0) {
            $response = $this->verifyStatusAction($request, $rentalRequest, $user);
            return $response;
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getSentRequests(Request $request)
    {
        list($user, $data) = [Auth::user(), $request->all()];
        if (count($user->roles) < 0) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        if ($user->roles->first()->name != "rent-admin") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $validator = RentalRequestValidations::getSentRequestsValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }

        $requestsPending = RentalRequest::with(['requestedBy', 'takenByUser', 'takenByAgency', 'classification',
            'requestCity', 'takenByUserDropOff', 'cancellationRequestReasons'])
            ->whereStatus('sent')->orderBy('pickup_date', 'asc')->paginate($data['limit']);
        if (count($requestsPending) > 0) {
            return response()->json(RentalRequestTransformer::transformCollection($requestsPending));
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDropOffRequests(Request $request)
    {
        list($user, $data) = [Auth::user(), $request->all()];
        if (count($user->roles) < 0) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        if ($user->roles->first()->name != "rent-admin") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $validator = RentalRequestValidations::getDropOffRequestsValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $dropOffRequests = RentalRequest::with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser',
            'takenByUserDropOff', 'payments', 'classification', 'requestCity', 'cancellationRequestReasons',
            'discountCodes', 'rentalRequestExtensions', 'rentalRequestRates'])
            ->whereHas('takenByManager', function ($query) use ($user) {
                $query->whereId($user->id);
            })->orWhereHas('takenByAgency', function ($query) use ($user) {
                $query->whereId($user->rental_agency_id);
            })->whereIn('status', ['on-board', 'taken-user-dropoff', 'finished', 'returned-car'])
            ->orderBy('dropoff_date', 'asc')->get();
        if (count($dropOffRequests) > 0) {
            $isPickup = false;
            return response()->json(RentalRequestTransformer::transformFilterCollection($dropOffRequests, $isPickup));
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function getSummary(Request $request)
    {
        $data = $request->all();
        $validator = RentalRequestValidations::getSummaryValidation($data);

        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }

        if (Carbon::parse($data['dropoff_date'])->toDateString() <= Carbon::parse($data['pickup_date'])->toDateString()) {
            return General::responseErrorAPI(trans('messages.DropoffInvalid'), 'DropoffInvalid', 400);
        }

        list($pickup, $dropOff, $response) = [Carbon::parse($data['pickup_date']), Carbon::parse($data['dropoff_date']), []];
        $difference = $pickup->diff($dropOff);
        $days = $difference->days;

        $rates = Rate::with('carClassification')->whereRaw('? between valid_from and valid_to', [$data['pickup_date']])
            ->whereRaw('? between days_from and days_to', [$days])->whereCountryId($data['country'])
            ->whereCityId($data['city'])->get();

        $extras = Configuration::whereAlias('tax')->whereCountryId($data['country'])->whereCityId($data['city'])->first();
        if (count($rates) > 0) {
            foreach ($rates as $rate) {
                list($amount, $chargesArray, $chargeArrayResponse) = [$rate->amount, [], []];

                $charges = Charge::whereHas('configuration', function ($query) use ($rate) {
                    $query->whereCountryId($rate->country_id)->whereCityId($rate->city_id);
                })->whereCarClassificationId($rate->car_classification_id)->get();

                foreach ($charges as $charge) {
                    $chargesArray [] = [
                        'alias' => strtolower($charge->configuration->alias),
                        'value' => (float)$charge->configuration->value,
                        'description' => ($request->lang == 'en') ? $charge->configuration->name_en : $charge->configuration->name
                    ];
                }

                $tax = (count($extras) > 0 && $extras->alias == 'tax') ? $extras->value : 0;
                $totalCost = $amount * $days;
                $subtotal = $totalCost;

                foreach ($chargesArray as $chargeArray) {
                    $chargeArrayResponse [] = [
                        'alias' => $chargeArray['alias'],
                        'value' => ($chargeArray['value'] * $days),
                        'description' => $chargeArray['description'],
                    ];
                    $subtotal = $subtotal + ($chargeArray['value'] * $days);
                }
                $totalCostArray = ["alias" => "rental-day", "value" => $totalCost,
                    "description" => trans('messages.DaysOfRent') . " " . $days . "d"];
                $newChargeArrayResponse = array_prepend($chargeArrayResponse, $totalCostArray);
                $salesTax = $subtotal * ($tax / 100);
                $total = $subtotal + $salesTax;
                $similarMessage = ($request->lang == 'en') ? " OR SIMILAR" : " O SIMILAR";
                $carClassification = [
                    'id' => $rate->car_classification_id,
                    'uuid' => $rate->carClassification->uuid,
                    'description' => $rate->carClassification->title . $similarMessage,
                    'category' => $rate->carClassification->category,
                    'type' => $rate->carClassification->type,
                ];
                $dailyCostCar = ($total / $days);
                $response [] = [
                    'car_classification' => $carClassification,
                    'days' => (int)$days,
                    'daily_cost_car' => round($dailyCostCar, 2),
                    'daily_cost' => $chargesArray,
                    'total_charges' => $newChargeArrayResponse,
                    'subtotal' => round($subtotal, 2),
                    'tax' => $tax . '%',
                    'sales_tax' => round($salesTax, 2),
                    'total' => round($total, 2),
                    'valid_from' => (isset($rate->valid_from)) ? Carbon::parse($rate->valid_from)->format('Y-m-d H:i')
                        : Carbon::now()->format('Y-m-d H:i'),
                    'valid_to' => (isset($rate->valid_to)) ? Carbon::parse($rate->valid_to)->format('Y-m-d H:i')
                        : Carbon::now()->format('Y-m-d H:i'),
                    'city' => $rate->city_id
                ];
            }
            return response()->json(['data' => $response]);
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function currentRequestByUser(Request $request, $userId)
    {
        list($user, $rolesNames) = [Auth::user(), ["rent-admin", "user", "agent"]];
        if (count($user->roles) <= 0) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        if (!in_array($user->roles->first()->name, $rolesNames)) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        if ($user->uuid != $userId) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }

        $request->merge(['user_id' => $userId]);
        $data = $request->all();

        $validator = RentalRequestValidations::currentRequestByUserValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $rentalRequest = RentalRequest::whereHas('requestedBy', function ($query) use ($request) {
            $query->whereUuid($request->user_id);
        })->orWhereHas('takenByUser', function ($query) use ($request) {
            $query->whereUuid($request->user_id);
        })->orWhereHas('takenByUserDropOff', function ($query) use ($request) {
            $query->whereUuid($request->user_id);
        })->with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments',
            'requestCity', 'cancellationRequestReasons', 'discountCodes', 'rentalRequestExtensions', 'rentalRequestRates'])
            ->whereNotIn('status', ['finished'])
            ->orderBy('created_at', 'DESC')
            ->first();
        $withMessage = true;
        if (count($rentalRequest)) {
            return response()->json(RentalRequestTransformer::transformItem($rentalRequest, $withMessage));
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sendCurrentLocation(Request $request)
    {
        $data = $request->all();
        $validator = RentalRequestValidations::sendCurrentLocationValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $rentalRequest = RentalRequest::whereHas('requestedBy')->with(['devices', 'takenByUser', 'takenByAgency',
            'classification', 'requestCity'])->whereUuid($request->request_id)->first();
        if (count($rentalRequest)) {
            list($enablePushLog, $enableResendPush) = Configuration::getPushLogConfiguration($rentalRequest->city_id);
            $countPush = 0;
            if (count($rentalRequest->devices)) {
                foreach ($rentalRequest->devices as $device) {
                    $coordinates = ['latitude' => $request->latitude, 'longitude' => $request->longitude];
                    $rentalRequest->update(['last_agent_coordinate' => json_encode($coordinates)]);
                    // send push notification
                    list ($tokenDevice, $operativeSystem, $message, $arrayData) = [$device->token_device,
                        $device->operative_system, trans('messages.CurrentLocation'),
                        ['view' => '2', 'body' => $coordinates, 'content-available' => 1]];
                    $push = Push::sendPushNotification($tokenDevice, $message, $operativeSystem, $arrayData);
                    $pushLog = PushLogsController::createPushLog($push, $device, $message, $rentalRequest, $enablePushLog);
                    if ($push) {
                        $countPush++;
                    } else {
                        PushLogsController::resendPushNotification($device, $message, $arrayData, $pushLog, $enableResendPush);
                    }
                }
            }
            return ($countPush > 0) ? General::responseErrorAPI(trans('messages.LocationSent'), 'LocationSent', 200) :
                General::responseErrorAPI(trans('messages.DeviceNotFound'), 'DeviceNotFound', 200);
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getAcceptedRequests(Request $request)
    {
        $user = Auth::user();
        if ($user->roles->first()->name != "rent-admin") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $data = $request->all();

        $validator = RentalRequestValidations::getAcceptedRequestsValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $requestAccepted = RentalRequest::whereHas('takenByManager', function ($query) use ($user) {
            $query->whereUuid($user->uuid);
        })->orWhereHas('takenByAgency', function ($query) use ($user) {
            $query->whereId($user->rental_agency_id);
        })->with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments',
            'requestCity', 'cancellationRequestReasons', 'discountCodes', 'rentalRequestExtensions', 'rentalRequestRates'])
            ->whereIn('status', ['taken-manager', 'taken-user', 'on-way', 'on-board', 'cancelled', 'checking'])
            ->orderBy('type', 'DESC')->orderBy('pickup_date', 'ASC')->get();
        if (count($requestAccepted)) {
            $isPickup = true;
            return response()->json(RentalRequestTransformer::transformFilterCollection($requestAccepted, $isPickup));
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignRequest(Request $request)
    {
        list($userAdmin, $data) = [Auth::user(), $request->all()];
        if ($userAdmin->roles->first()->name != "rent-admin") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $validator = RentalRequestValidations::assignRequestValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $userAgent = User::whereUuid($data['user_id'])->first();
        $validationUserRol = $this->validateUserRol($userAgent, 'agent');
        if (array_first($validationUserRol) === false) {
            return General::responseErrorAPI(trans('messages.' . array_last($validationUserRol)), array_last($validationUserRol));
        }
        $validationUserAgency = $this->validateUserAgency($userAdmin, $userAgent);
        if (array_first($validationUserAgency) === false) {
            return General::responseErrorAPI(trans('messages.' . array_last($validationUserAgency)), array_last($validationUserAgency));
        }
        $rentalRequest = RentalRequest::whereUuid($request->rental_request_id)
            ->with(['requestedBy', 'takenByAgency', 'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments',
                'requestCity', 'cancellationRequestReasons', 'discountCodes', 'rentalRequestExtensions',
                'rentalRequestRates'])->first();
        if ($data['status'] === 'taken-user') {
            $config = Configuration::whereAlias('assign_planned_request_time')->whereCityId($rentalRequest->city_id)->first();
            $assignPlannedRequestTime = (count($config) > 0) ? $config->value : 120;
            $diffHourPickUpDate = Carbon::now()->diffInMinutes(Carbon::parse($rentalRequest->pickup_date), false);
            if ($diffHourPickUpDate > $assignPlannedRequestTime) {
                return General::responseErrorAPI(trans('messages.RequestOutOfDateToAssign',
                    ['hour' => round(($assignPlannedRequestTime / 60), 2)]), 'RequestOutOfDateToAssign');
            }
        }
        $response = $this->verifyStatusAction($request, $rentalRequest, $userAgent);
        return $response;
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse|mixed
     */
    public function getAgentsList(Request $request)
    {
        $userAdmin = Auth::user();
        if ($userAdmin->roles->first()->name != "rent-admin") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $request->merge(['rental_agency_id' => $userAdmin->rental_agency_id]);
        $data = $request->all();
        $validator = RentalRequestValidations::getAgentsListValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $totalAgents = User::whereRentalAgencyId($userAdmin->rental_agency_id)->whereHas('roles', function ($query) {
            $query->where("name", "=", "agent");
        })->get();
        if (count($totalAgents) <= 0) {
            return General::responseErrorAPI(trans('messages.UnavailableAgents'), 'UnavailableAgents', 404);
        }
        $agentsId = $totalAgents->map(function ($item) {
            return $item->id;
        });
        $availableAgents = $this->getAvailableAgents($totalAgents, $agentsId);
        if (count($availableAgents) <= 0) {
            return General::responseErrorAPI(trans('messages.UnavailableAgents'), 'UnavailableAgents', 404);
        }
        return response()->json(['data' => UserTransformer::transformCollection($availableAgents)]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getAssignedRequests(Request $request)
    {
        if (!isset($request->status)) {
            $request->merge(['status' => 'taken-user']);
        }
        list($user, $data) = [Auth::user(), $request->all()];
        if ($user->roles->first()->name != "agent") {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        $validator = RentalRequestValidations::getAssignedRequestsValidation($data);
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        if ($data['status'] === 'taken-user') {
            list($arrayStatus, $column) = [[$data['status']], 'taken_by_user'];
        } else {
            list($arrayStatus, $column) = [[$data['status'], 'returned-car'], 'taken_by_user_dropoff'];
        }
        $assignedRequest = RentalRequest::where($column, $user->id)->with(['requestedBy', 'takenByUser', 'takenByAgency',
            'classification', 'takenByManager', 'requestCity', 'takenByUserDropOff', 'cancellationRequestReasons'])
            ->whereIn('status', $arrayStatus)->get();
        if (count($assignedRequest) > 0) {
            return response()->json(RentalRequestTransformer::transformCollection($assignedRequest));
        } else {
            return General::responseErrorAPI(trans('messages.DataNotFound'), 'DataNotFound', 404);
        }
    }

    /**
     * @param $user
     * @param $rolName
     * @return array
     */
    public function validateUserRol($user, $rolName)
    {
        if (count($user->roles) > 0) {
            if ($user->roles->first()->name != $rolName) {
                return [false, 'UserWithoutRequiredRol'];
            } else {
                return [true, 'UserWithRol'];
            }
        } else {
            return [false, 'UserWithoutRol'];
        }
    }

    /**
     * @param $userAdmin
     * @param $userAgent
     * @return array
     */
    public function validateUserAgency($userAdmin, $userAgent)
    {
        if ($userAdmin->rental_agency_id === $userAgent->rental_agency_id) {
            $totalAgents = User::whereRentalAgencyId($userAdmin->rental_agency_id)->whereHas('roles', function ($query) {
                $query->where("name", "=", "agent");
            })->get();
            if (count($totalAgents) <= 0) {
                return [false, 'UnavailableAgents'];
            }
            $agentsId = $totalAgents->map(function ($item) {
                return $item->id;
            });
            $availableAgents = $this->getAvailableAgents($totalAgents, $agentsId);
            if (count($availableAgents) <= 0) {
                return [false, 'UnavailableAgents'];
            } else {
                $availableAgent = $availableAgents->filter(function ($object) use ($userAgent) {
                    return $object->id == $userAgent->id;
                })->first();
                return (count($availableAgent) > 0) ? [true, 'UserAvailable'] : [false, 'BusyAgent'];
            }

        } else {
            return [false, 'UserNotInAgency'];
        }
    }

    /**
     * @param $request
     * @param $rentalRequest
     * @param $user
     * @return mixed
     */
    public function verifyStatusAction($request, $rentalRequest, $user)
    {
        if (in_array($rentalRequest->status, ['checking', 'on-board', 'taken-user-dropoff', 'returned-car', 'finished'])
            && $user->roles->first()->name == "rent-admin" && $request->status == 'cancelled'
        ) {
            return General::responseErrorAPI(trans('messages.InvalidCancellation'), 'InvalidCancellation', 400);
        }
        // 1. SI EL USUARIO MANDA A CANCELAR EL REQUEST Y EL MISMO TENIA ESTATUS 'on-way | checking' SE COBRA PENALIDAD
        // 2. SI EL AGENTE MANDA A CANCELAR EL REQUEST Y EL MISMO TENIA ESTATUS 'on-way | checking' NO SE COBRA PENALIDAD (ON-HOLD)
        if (in_array($rentalRequest->status, ['on-way', 'checking']) && $request->status == 'cancelled') {
            if (count($rentalRequest->payments) <= 0) {
                return General::responseErrorAPI(trans('messages.RequestWithoutPayment'), 'RequestWithoutPayment', 400);
            }
            $refundChargeResponse = $this->refundCharge($rentalRequest, $request);
            if ($refundChargeResponse !== true) {
                return $refundChargeResponse;
            }
            if ($rentalRequest->user_id == $user->id) {
                if ($this->validatePenaltyCharge($rentalRequest) === true) {
                    $chargePenaltyResponse = $this->chargePenalty($rentalRequest, $request);
                    if ($chargePenaltyResponse !== true) {
                        return $chargePenaltyResponse;
                    }
                }
            } else {
                // TODO: verify agency penalty
            }
            if ($rentalRequest->discountCodes()->count() > 0) {
                $rentalRequest->discountCodes()->detach();
            }
            $rentalRequest->update(['status' => $request->status]);
            if ($rentalRequest->user_id == $user->id) {
                $this->sendPushNotification($rentalRequest, 'RequestCancelledForUser', 'devicesManager');
                $this->sendPushNotification($rentalRequest, 'RequestCancelledForUser', 'devicesAgent');
            } elseif ($rentalRequest->taken_by_manager == $user->id) {
                $this->sendPushNotification($rentalRequest, 'RequestCancelledForManager', 'devices');
                $this->sendPushNotification($rentalRequest, 'RequestCancelledForManager', 'devicesAgent');
            } else {
                $this->sendPushNotification($rentalRequest, 'RequestCancelledForAgent', 'devices');
                $this->sendPushNotification($rentalRequest, 'RequestCancelledForAgent', 'devicesManager');
            }
        } else if (in_array($rentalRequest->status, ['taken-manager', 'taken-user']) && $request->status == 'cancelled') {
            // 1. SI EL USUARIO MANDA A CANCELAR EL REQUEST Y EL MISMO TENIA ESTATUS 'taken-manager, taken-user' SE VERIFICA PENALIDAD
            // 2. SI EL AGENTE/GERENTE MANDA A CANCELAR EL REQUEST Y EL MISMO TENIA ESTATUS 'taken-manager, taken-user' SE DEVUELVE EL DINERO SIN PENALIDAD
            if (count($rentalRequest->payments) <= 0) {
                if ($rentalRequest->type === "standard") {
                    return General::responseErrorAPI(trans('messages.RequestWithoutPayment'), 'RequestWithoutPayment', 400);
                } else {
                    $plannedWithoutCharge = true;
                }
            }
            $previousStatus = $rentalRequest->status;
            if (!isset($plannedWithoutCharge)) {
                $undoChargeResponse = $this->refundCharge($rentalRequest, $request);
                if ($undoChargeResponse !== true) {
                    return $undoChargeResponse;
                }
            }
            if ($rentalRequest->type == "planned") {
                if ($this->validatePenaltyCharge($rentalRequest) === true && $rentalRequest->user_id == $user->id) {
                    $penaltyResponse = $this->chargePenalty($rentalRequest, $request);
                    if ($penaltyResponse !== true) {
                        return $penaltyResponse;
                    }
                }
            }
            if ($rentalRequest->discountCodes()->count() > 0) {
                $rentalRequest->discountCodes()->detach();
            }
            $rentalRequest->update(['status' => $request->status]);
            if ($previousStatus === 'taken-manager') {
                $this->sendPushNotification($rentalRequest, ($rentalRequest->user_id == $user->id) ? 'RequestCancelledForUser'
                    : 'RequestCancelledForManager', ($rentalRequest->user_id == $user->id) ? 'devicesManager' : 'devices');
            } else {
                if ($rentalRequest->user_id == $user->id) {
                    $this->sendPushNotification($rentalRequest, 'RequestCancelledForUser', 'devicesManager');
                    $this->sendPushNotification($rentalRequest, 'RequestCancelledForUser', 'devicesAgent');
                } elseif ($rentalRequest->taken_by_manager == $user->id) {
                    $this->sendPushNotification($rentalRequest, 'RequestCancelledForManager', 'devices');
                    $this->sendPushNotification($rentalRequest, 'RequestCancelledForManager', 'devicesAgent');
                } else {
                    $this->sendPushNotification($rentalRequest, 'RequestCancelledForAgent', 'devices');
                    $this->sendPushNotification($rentalRequest, 'RequestCancelledForAgent', 'devicesManager');
                }
            }
        } else if ($request->status == 'taken-manager') {
            // 3. SI EL GERENTE ACEPTA EL REQUEST SE BLOQUEA EL DINERO AL USUARIO CUANDO SEA STANDARD
            $chargeReset = ChargeReset::whereRentalRequestId($rentalRequest->id)->get();
            if(count($chargeReset) > 0) {
                return General::responseErrorAPI(trans('messages.RequestTaken'), 'RequestTaken', 400);
            }
            try {
                $validator = RentalRequestValidations::getChargeResetValidation(['rental_request_id' => $rentalRequest->id]);
                if ($validator->fails()) {
                    return General::responseErrorAPI(trans('messages.RequestTaken'), 'RequestTaken', 400);
                }
                $chargeReset = ChargeReset::create(['rental_request_id' => $rentalRequest->id]);
            } catch (\Exception $exception) {
                return General::responseErrorAPI(trans('messages.RequestTaken'), 'RequestTaken', 400);
            }
            // valida que el request sea aceptado por un gerente
            if ($user->roles->first()->name != "rent-admin") {
                $chargeReset->forceDelete();
                return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
            }
            // valida que el request no haya sido cancelado o aceptado por otro gerente
            if ($rentalRequest->status != 'sent') {
                $chargeReset->forceDelete();
                $messageKey = RentalRequest::getMessageKey($rentalRequest->status);
                return General::responseErrorAPI(trans('messages.' . $messageKey), $messageKey, 200);
            }
            // valida que el administrador pueda aceptar el request
            list($valid, $message) = $this->validateTakenManagerRequest($rentalRequest, $user);
            if ($valid != true) {
                $chargeReset->forceDelete();
                return General::responseErrorAPI(trans('messages.' . $message), $message, 400);
            }
            // valida que el request no tenga pagos asociados
            if (count($rentalRequest->payments) > 0) {
                if (!empty($rentalRequest->payments->first()->stripe_transaction_id)
                    || $rentalRequest->payments->first()->status !== 'failed'
                ) {
                    $chargeReset->forceDelete();
                    return General::responseErrorAPI(trans('messages.InvalidRequest'), 'InvalidRequest', 400);
                }
            }
            if ($rentalRequest->type === 'standard') {
                $blockChargeResponse = $this->blockCharge($rentalRequest, $request);
                if ($blockChargeResponse !== true) {
                    $chargeReset->forceDelete();
                    return $blockChargeResponse;
                }
                $rentalTransaction = new RentalTransaction();
                $rentalTransaction->loadData($user->id, $rentalRequest->id, "held", $rentalRequest->blocked_amount);
                $rentalRequest->rentalTransactions()->save($rentalTransaction);
            } else {
                $diffHourPickUpDate = Carbon::now()->diffInHours(Carbon::parse($rentalRequest->pickup_date), false);
                // TODO: get configuration by country and city
                $chargeRequestTime = Configuration::whereAlias('charge_planned_request_time')->first(); //->whereCountryId($request->country)->whereCityId($request->city)
                $chargeRequestTime = (count($chargeRequestTime) > 0) ? (int)$chargeRequestTime->value : 24;
                if ($diffHourPickUpDate >= 0 && $diffHourPickUpDate < $chargeRequestTime) {
                    $blockChargeResponse = $this->blockCharge($rentalRequest, $request);
                    if ($blockChargeResponse !== true) {
                        $chargeReset->forceDelete();
                        return $blockChargeResponse;
                    }
                    $rentalTransaction = new RentalTransaction();
                    $rentalTransaction->loadData($user->id, $rentalRequest->id, "held", $rentalRequest->blocked_amount);
                    $rentalRequest->rentalTransactions()->save($rentalTransaction);
                }
            }
            $rentalRequest->update(['status' => $request->status, 'taken_by_manager' => $user->id,
                'taken_by_agency' => $user->rental_agency_id]);
            $this->sendPushNotification($rentalRequest, 'AgencyHasTakenTheRequest', 'devices');
            $chargeReset->forceDelete();
            dispatch(new SendSummaryEmail($rentalRequest));
        } else if ($request->status == 'cancelled-app') {
            // 4. ESTE ESTATUS SE ENVÍA SI NO LE LLEGA EL PUSH DE CANCELACIÓN DE REQUEST POR TIEMPO DE ACEPTACIÓN
            if (in_array($rentalRequest->status, ['taken-manager', 'taken-user', 'on-way', 'checking', 'on-board', 'taken-user-dropoff'])) {
                return response()->json(RentalRequestTransformer::transformItem($rentalRequest));
            } else if ($rentalRequest->status == 'sent') {
                if ($rentalRequest->discountCodes()->count() > 0) {
                    $rentalRequest->discountCodes()->detach();
                }
                $rentalRequest->update(['status' => $request->status]);
            } else if (in_array($rentalRequest->status, ['cancelled', 'cancelled-system'])) {
                return General::responseErrorAPI(trans('messages.RequestCancelled'), 'RequestCancelled', 200);
            }
        } else if (in_array($rentalRequest->status, ['cancelled-system', 'cancelled-app', 'cancelled']) && $request->status == 'cancelled') {
            // 5. CUANDO EL ESTATUS ENVIADO ES "CANCELLED" Y EL REQUEST YA FUE CANCELADO "CANCELLED-SYSTEM O CANCELLED-APP"
            $this->sendPushNotification($rentalRequest, 'RequestCancelled', 'devicesManager');
            return General::responseErrorAPI(trans('messages.RequestCancelled'), 'RequestCancelled', 200);
        } else if (in_array($rentalRequest->status, ['sent']) && $request->status == 'cancelled') {
            // 6. CUANDO SE CANCELA UN REQUEST DESPUES DE ENVIAR
            $cancelledByUser = ($rentalRequest->user_id == $user->id) ? true : false;
            if ($rentalRequest->discountCodes()->count() > 0) {
                $rentalRequest->discountCodes()->detach();
            }
            $rentalRequest->update(['status' => $request->status]);
            $this->sendPushNotification($rentalRequest, ($cancelledByUser === true) ? 'RequestCancelledForUser' : 'RequestCancelledForManager',
                ($cancelledByUser === true) ? 'devicesManager' : 'devices', true);
        } else if ($request->status == 'taken-user') {
            // 7. CUANDO SE ASIGNA UN PICKUP REQUEST A UN AGENTE
            if (!in_array($rentalRequest->status, ['taken-manager', 'taken-user'])) {
                $messageKey = RentalRequest::getMessageKey($rentalRequest->status);
                return General::responseErrorAPI(trans('messages.' . $messageKey), $messageKey, 200);
            }
            if ($rentalRequest->status === 'taken-user') {
                list($deviceToken, $message, $operativeSystem) =
                    $this->getUnassignedPushParams($rentalRequest, 'RequestUnassignedByManager', 'devicesAgent');
            }
            $rentalRequest->update(['taken_by_user' => $user->id, 'status' => $request->status]);
            $rentalRequest = RentalRequest::whereId($rentalRequest->id)->with(['devicesAgent', 'devices', 'takenByUser'])->first();
            $this->sendPushNotification($rentalRequest, 'AgentHasTakenTheRequest', 'devices');
            $this->sendPushNotification($rentalRequest, 'RequestAssignedByManager', 'devicesAgent');
            if (!empty($deviceToken) && !empty($message) && !empty($operativeSystem)) {
                $this->sendUnassignedPush($deviceToken, $message, $operativeSystem);
            }
        } else if ($request->status == 'on-way') {
            // 8. CUANDO EL AGENTE INDICA QUE VA EN CAMINO
            if ($user->roles->first()->name != "agent") {
                return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
            }
            if (!in_array($rentalRequest->status, ['taken-user'])) {
                $messageKey = RentalRequest::getMessageKey($rentalRequest->status);
                return General::responseErrorAPI(trans('messages.' . $messageKey), $messageKey, 200);
            }
            $this->coordinates = ['latitude' => $request->latitude, 'longitude' => $request->longitude];
            $rentalRequest->update(['status' => $request->status, 'last_agent_coordinate' => json_encode($this->coordinates)]);
            $this->sendPushNotification($rentalRequest, 'CarOnWay', 'devices');
        } else if ($request->status == 'checking') {
            // 9. CUANDO EL AGENTE ESTA CHEQUEANDO LOS DOCUMENTOS DEL CLIENTE
            if ($user->roles->first()->name != "agent") {
                return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
            }
            if (!in_array($rentalRequest->status, ['on-way'])) {
                $messageKey = RentalRequest::getMessageKey($rentalRequest->status);
                return General::responseErrorAPI(trans('messages.' . $messageKey), $messageKey, 200);
            }
            $rentalRequest->update(['status' => $request->status]);
            $this->sendPushNotification($rentalRequest, 'ArrivedAgent', 'devices');
        } else if ($request->status == 'on-board') {
            // 10. CUANDO EL AGENTE ENTREGA EL CARRO AL CLIENTE SE HACE LA CAPTURA DEL PAGO
            if ($user->roles->first()->name != "agent") {
                return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
            }
            if (!in_array($rentalRequest->status, ['checking'])) {
                $messageKey = RentalRequest::getMessageKey($rentalRequest->status);
                return General::responseErrorAPI(trans('messages.' . $messageKey), $messageKey, 200);
            }
            if (count($rentalRequest->payments) > 0) {
                if (!empty($rentalRequest->payments->first()->stripe_transaction_id)) {
                    $captureChargeResponse = $this->captureCharge($rentalRequest, $request);
                    if ($captureChargeResponse !== true) {
                        return $captureChargeResponse;
                    }
//                    $rentalRequest->payments->first()->update(['description' => 'Captured Charge']);
                    $transaction = $rentalRequest->rentalTransactions->first();
                    if (count($transaction) > 0) {
                        $transaction->update(['type' => 'sum']);
                    }

                }
            }
            $rentalRequest->update(['status' => $request->status]);
            $this->sendPushNotification($rentalRequest, 'OnBoard', 'devices');
        } else if ($request->status == 'taken-user-dropoff') {
            // 11. CUANDO SE ASIGNA UN DROPOFF REQUEST A UN AGENTE
            if (!in_array($rentalRequest->status, ['on-board', 'taken-user-dropoff'])) {
                $messageKey = RentalRequest::getMessageKey($rentalRequest->status);
                return General::responseErrorAPI(trans('messages.' . $messageKey), $messageKey, 200);
            }
            if ($rentalRequest->status === 'taken-user-dropoff') {
                list($deviceToken, $message, $operativeSystem) =
                    $this->getUnassignedPushParams($rentalRequest, 'RequestUnassignedByManager', 'devicesAgentDropoff');
            }
            $rentalRequest->update(['taken_by_user_dropoff' => $user->id, 'status' => $request->status]);
            $rentalRequest = RentalRequest::whereId($rentalRequest->id)->with(['devices', 'devicesAgentDropoff', 'takenByUserDropOff'])->first();
            if ($rentalRequest->returned_car == false) {
                $this->sendPushNotification($rentalRequest, 'RequestTakenByAgent', 'devices');
            }
            $this->sendPushNotification($rentalRequest, 'RequestAssignedByManager', 'devicesAgentDropoff');
            if (!empty($deviceToken) && !empty($message) && !empty($operativeSystem)) {
                $this->sendUnassignedPush($deviceToken, $message, $operativeSystem);
            }
        } else if ($request->status == 'returned-car') {
            // 11. CUANDO EL USUARIO DEVUELVE EL CARRO
            if (!in_array($rentalRequest->status, ['on-board', 'taken-user-dropoff'])) {
                $messageKey = RentalRequest::getMessageKey($rentalRequest->status);
                return General::responseErrorAPI(trans('messages.' . $messageKey), $messageKey, 200);
            }
            if (count($rentalRequest->takenByUserDropOff) <= 0) {
                $rentalRequest->update(['returned_car' => true]);
            } else {
                $rentalRequest->update(['status' => $request->status, 'returned_car' => true]);
            }
            $this->sendPushNotification($rentalRequest, 'CarReturned', 'devicesManager');
            $this->sendPushNotification($rentalRequest, 'CarReturned', 'devicesAgentDropoff');
        } else if ($request->status == 'finished') {
            // 12. CUANDO EL AGENTE ENTREGA EL CARRO AL RENT-A-CAR
            if (!in_array($rentalRequest->status, ['taken-user-dropoff', 'returned-car'])) {
                $messageKey = RentalRequest::getMessageKey($rentalRequest->status);
                return General::responseErrorAPI(trans('messages.' . $messageKey), $messageKey, 200);
            }
            $this->sendPushNotification($rentalRequest, 'Finished', 'devices', true);
            $rentalRequest->update(['status' => $request->status]);
        } else {
            $rentalRequest->update(['status' => $request->status]);
        }
        $this->createLog($rentalRequest);
        return General::responseErrorAPI(trans('messages.RequestStatusChanged'), 'RequestStatusChanged', 200);

    }

    /**
     * @param $rentalRequest
     * @param $request
     * @return bool|mixed
     */
    public function blockCharge($rentalRequest, $request)
    {
        $paymentDescription = self::getPaymentDescription($rentalRequest, $request, 'charge');
        $request->merge(['amount' => $rentalRequest->blocked_amount, 'currency' => 'usd', 'description' => $paymentDescription,
            'capture' => false
        ]);
        $request->only(['amount', 'currency', 'description', 'capture']);
        $response = app('App\Http\Controllers\StripeController')->createCharge($request, $rentalRequest);
        if ($response->getStatusCode() != 200) {
            $jsonContent = json_decode($response->getContent());
            list($errorTittle, $errorMessage, $errorType, $errorCode, $errorDeclineCode) = $this->getJsonStripeError($jsonContent);
            if ($errorTittle === "StripeCardError" || $errorType === "card_error" || $errorCode === "card_declined") {
                $this->verifyCardErrorAction($rentalRequest, $rentalRequest->blocked_amount);
                return General::responseErrorAPI(trans('messages.PaymentMethodError'), $errorTittle);
            }
            return General::responseErrorAPI($jsonContent->message, $errorTittle);
        }
        return true;
    }

    /**
     * @param $rentalRequest
     * @param $request
     * @return bool|mixed
     */
    public function captureCharge($rentalRequest, $request)
    {
        $request->merge(['charge_id' => $rentalRequest->payments->first()->stripe_transaction_id]);
        $request->only(['charge_id']);
        $response = app('App\Http\Controllers\StripeController')
            ->captureCharge($request, $rentalRequest->payments->first()->stripe_transaction_id);
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
     * @param $rentalRequest
     * @param $request
     * @return bool|mixed
     */
    public function refundCharge($rentalRequest, $request)
    {
        if (count($rentalRequest->payments) > 1) {
            $payment = $rentalRequest->payments->filter(function ($object) {
                if ($object->stripe_transaction_id !== "" || $object->status !== "failed") {
                    return true;
                }
            })->first();
            $request->merge(['charge' => $payment->stripe_transaction_id]);
        } else {
            $request->merge(['charge' => $rentalRequest->payments->first()->stripe_transaction_id]);
        }
        $request->only(['charge']);
        $response = app('App\Http\Controllers\StripeController')->createRefund($request, $rentalRequest);
        if ($response->getStatusCode() != 200) {
            $jsonContent = json_decode($response->getContent());
            return General::responseErrorAPI($jsonContent->message, $jsonContent->title);
        }
        return true;
    }

    /**
     * @param $rentalRequest
     * @param $request
     * @return bool|mixed
     */
    public function chargePenalty($rentalRequest, $request)
    {
        $paymentDescription = self::getPaymentDescription($rentalRequest, $request, 'penalty');
        $penaltyCancelRequest = Configuration::whereAlias('penalty_cancel_request')
            ->whereCityId($rentalRequest->city_id)->first();
        $penaltyAmount = (count($penaltyCancelRequest) > 0) ? $penaltyCancelRequest->value : 20;
        $request->merge(['amount' => $penaltyAmount, 'currency' => 'usd', 'description' => $paymentDescription,
            'capture' => true
        ]);
        $request->only(['amount', 'currency', 'description', 'capture']);
        $response = app('App\Http\Controllers\StripeController')->createCharge($request, $rentalRequest);
        if ($response->getStatusCode() != 200) {
            $jsonContent = json_decode($response->getContent());
            list($errorTittle, $errorMessage, $errorType, $errorCode, $errorDeclineCode) = $this->getJsonStripeError($jsonContent);
            if ($errorTittle === "StripeCardError" && $errorType === "card_error" && $errorCode === "card_declined") {
                $this->verifyCardErrorAction($rentalRequest, $penaltyAmount);
                return General::responseErrorAPI($errorMessage, $errorTittle);
            }
            return General::responseErrorAPI($jsonContent->message, $errorTittle);
        }
        return true;
    }

    /**
     * @param $rentalRequest
     * @param $user
     * @return array
     */
    public function validateTakenManagerRequest($rentalRequest, $user)
    {
        list($valid, $message) = [true, ''];
        $availableAgents = User::whereRentalAgencyId($user->rental_agency_id)->whereHas('roles', function ($query) {
            $query->where("name", "=", "agent");
        })->whereDoesntHave('agentRentalRequests', function ($query) {
            $query->whereIn('status', ['taken-user', 'on-way', 'checking', 'taken-user-dropoff']);
        })->get();
        // Se valida que haya agentes disponibles para asginar
        if (count($availableAgents) <= 0) {
            list($valid, $message) = [false, 'AgencyWithoutAgents'];
            return [$valid, $message];
        }
        $agentUserIds = self::getArrayMap('id', $availableAgents->toArray());

        $rentalRequestsAccepted = RentalRequest::where(function ($query) use ($user) {
            $query->where('taken_by_manager', '=', $user->id)
                ->orWhere('taken_by_agency', '=', $user->rental_agency_id)
                ->where('status', '=', 'taken-manager');
        })->whereIn('status', ['taken-manager'])->get();

        if ((count($rentalRequestsAccepted) === count($agentUserIds))) {
            list($valid, $message) = [false, 'BusyAgents'];
        } else if ((count($rentalRequestsAccepted) < count($agentUserIds))) {
            if ($rentalRequest->type == 'standard') {
                $rentalRequestsPlanned = $rentalRequestsAccepted->filter(function ($object) use ($rentalRequest) {
                    $diff = Carbon::parse($rentalRequest->pickup_date)->diffInHours(Carbon::parse($object->pickup_date), false);
                    // TODO: add accept request time in backend configuration table
                    if ($object->type == 'planned' && $diff >= -1 && $diff <= 1) {
                        return true;
                    }
                })->count();

                if ($rentalRequestsPlanned > 0) {
                    list($valid, $message) = [false, 'UnassignedRequests'];
                }
            }
        } else {
            list($valid, $message) = [false, 'BusyAgents'];
        }

        return [$valid, $message];
    }

    /**
     * @param $column
     * @param $data
     * @return array
     */
    public static function getArrayMap($column, $data)
    {
        $array = array_map(function ($item) use ($column, $data) {
            return $item[$column];
        }, $data);
        return $array;
    }

    /**
     * @param $rentalRequest
     * @return bool
     */
    public function createLog($rentalRequest)
    {
        $log = Log::create(Log::getLogCreateData($rentalRequest));
        return (count($log) > 0) ? true : false;
    }

    /**
     * @param $rentalRequest
     * @param $data
     * @return bool
     */
    public function attachCode($rentalRequest, $data)
    {
        $discountCode = DiscountCode::whereUuid($data['discount_code_id'])->with('rentalRequests')->first();
        if (count($discountCode) < 0 || is_null($discountCode)) {
            return false;
        }
        $rentalRequests = RentalRequest::whereUserId($rentalRequest->user_id)->get();
        if (count($rentalRequests) > 0) {
            $rentalRequestWithCode = $rentalRequests->filter(function ($object) {
                if (count($object->discountCodes) > 0) {
                    return true;
                }
            })->count();
            $rentalRequestFinished = $rentalRequests->filter(function ($object) {
                if ($object->status === "finished") {
                    return true;
                }
            })->count();
            if ($rentalRequestWithCode > 0 || $rentalRequestFinished > 0) {
                return false;
            }
        }
//        list($discountCodeWithRentalRequests, $cont) = [$discountCode->rentalRequests(), 0];
//        if ($discountCodeWithRentalRequests->count() > 0) {
//            foreach ($discountCodeWithRentalRequests->get() as $rentalRequestWithCode) {
//                if (in_array($rentalRequestWithCode->status, ['cancelled', 'cancelled-app', 'cancelled'])
//                    && is_null($rentalRequestWithCode->taken_by_manager)
//                ) {
//                    $cont = $cont + 1;
//                    $rentalRequestWithCode->discountCodes()->detach();
//                }
//            }
//            if ($discountCodeWithRentalRequests->count() > $cont) {
//                return false;
//            }
//        }
        try {
            // TODO: disable the coupon by user
            // $discountCode->update(['active' => false, 'expiry' => Carbon::now()->toDateString()]);
            $rentalRequest->discountCodes()->attach($discountCode->id, DiscountCode::getCreateData());
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @param $rentalRequest
     * @param $messageKey
     * @param $relationshipName
     * @param bool $silent
     * @return bool
     */
    public function sendPushNotification($rentalRequest, $messageKey, $relationshipName, $silent = false)
    {
        $rentalRequest = RentalRequest::whereUuid($rentalRequest->uuid)->with(['classification', 'requestedBy',
            'takenByAgency', 'takenByManager', 'takenByUser', 'takenByUserDropOff', 'payments', 'requestCity',
            'cancellationRequestReasons', 'discountCodes', 'rentalRequestExtensions', 'rentalRequestRates'])->first();
        if (count($rentalRequest->$relationshipName) <= 0) {
            return false;
        }
        list($enablePushLog, $enableResendPush) = Configuration::getPushLogConfiguration($rentalRequest->city_id);
        list($countPush, $rentalRequestObject) = [0, $rentalRequest];
        foreach ($rentalRequest->$relationshipName as $device) {
            if ($device->operative_system === 'ios') {
                $requestTransformed = RentalRequestTransformer::transformItemPushIos($rentalRequest);
            } else {
                $requestTransformed = RentalRequestTransformer::transformItemPushAndroid($rentalRequest);
            }
            $message = $this->getPushMessage($rentalRequest, $messageKey, $device);
            if (isset($requestTransformed['data']) && $rentalRequest->status == 'on-way') {
                $rentalRequest = array_first($requestTransformed['data']);
                if ($rentalRequest['status']) {
                    $requestTransformed['coordinates'] = [
                        'latitude' => $this->coordinates['latitude'],
                        'longitude' => $this->coordinates['longitude']
                    ];
                }
            }
            if ($silent === false) {
                $arrayData = ['view' => '1',
                    'body' => (isset($requestTransformed['data'])) ? array_first($requestTransformed['data']) : null];
            } else {
                $arrayData = ['view' => '1', 'content-available' => 1,
                    'body' => (isset($requestTransformed['data'])) ? array_first($requestTransformed['data']) : null];
            }
            $push = Push::sendPushNotification($device->token_device, $message, $device->operative_system, $arrayData);
            $pushLog = PushLogsController::createPushLog($push, $device, $message, $rentalRequestObject, $enablePushLog);
            if ($push) {
                $countPush++;
            } else {
                PushLogsController::resendPushNotification($device, $message, $arrayData, $pushLog, $enableResendPush);
            }
        }
        return ($countPush > 0) ? true : false;
    }

    /**
     * @param $deviceToken
     * @param $message
     * @param $operativeSystem
     * @return bool
     */
    public function sendUnassignedPush($deviceToken, $message, $operativeSystem)
    {
        $arrayData = ['view' => '1', 'body' => null];
        $push = Push::sendPushNotification($deviceToken, $message, $operativeSystem, $arrayData);
        return ($push > 0) ? true : false;
    }

    /**
     * @param $rentalRequest
     * @param $messageKey
     * @param $relationshipName
     * @return array
     */
    public function getUnassignedPushParams($rentalRequest, $messageKey, $relationshipName)
    {
        if (count($rentalRequest->$relationshipName) <= 0) {
            return ["", "", ""];
        }
        $device = $rentalRequest->$relationshipName->first();
        if (count($device) <= 0) {
            return ["", "", ""];
        }
        $deviceToken = $device->token_device;
        $message = $this->getPushMessage($rentalRequest, $messageKey, $device);
        $operativeSystem = $device->operative_system;
        return [$deviceToken, $message, $operativeSystem];
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
     * @return bool
     */
    public function validatePenaltyCharge($rentalRequest)
    {
        if ($rentalRequest->type == "standard") {
            if ($rentalRequest->status == 'on-way') {
                $penaltyFault = true;
            } elseif (in_array($rentalRequest->status, ['taken-manager', 'taken-user'])) {
                $penaltyFault = false;
            } else {
                $penaltyFault = false;
            }
        } else {
            $diffHourPickUpDate = Carbon::now()->diffInHours(Carbon::parse($rentalRequest->pickup_date), false);
            if ($diffHourPickUpDate > 24) {
                $penaltyFault = false;
            } else if ($diffHourPickUpDate >= 0 && $diffHourPickUpDate <= 24) {
                $penaltyFault = true;
            } else {
                $penaltyFault = false;
            }
        }
        return $penaltyFault;
    }

    /**
     * @param $rentalRequest
     * @param $amount
     * @return bool
     */
    public function verifyCardErrorAction($rentalRequest, $amount)
    {
        $statusBefore = $rentalRequest->status;
        $description = ($statusBefore == 'sent') ? 'Blocked Charge Failed' : 'Penalty Charge Failed';
        if ($rentalRequest->type === "standard") {
            $this->cancelRequestByPaymentTrouble($rentalRequest, $amount, $description);
        } else {
            $canChangePayment = false;
            $diffHourPickUpDate = Carbon::now()->diffInHours(Carbon::parse($rentalRequest->pickup_date), false);
            $maxTimeChangePayment = Configuration::whereAlias('change_payment_max_time')
                ->whereCityId($rentalRequest->city_id)->first();
            $maxTimeChangePayment = (count($maxTimeChangePayment) > 0) ? $maxTimeChangePayment->value : 12;
            if ($diffHourPickUpDate > $maxTimeChangePayment) {
                $canChangePayment = true;
            }
            if ($canChangePayment === true) {
                $payment = Payment::whereStatus('failed')->whereRentalRequestId($rentalRequest->id)->first();
                if (count($payment) <= 0) {
                    Payment::create(['user_id' => $rentalRequest->user_id, 'amount' => $amount,
                        'uuid' => Uuid::generate(4)->string, 'stripe_transaction_id' => "",
                        'description' => $description, 'rental_request_id' => $rentalRequest->id, 'status' => 'failed'
                    ]);
                }
                $this->sendPushNotification($rentalRequest, 'ChangePaymentMethod', 'devices');
            } else {
                $this->cancelRequestByPaymentTrouble($rentalRequest, $amount, $description);
            }
        }
        return true;
    }

    /**
     * @param $rentalRequest
     * @param $amount
     * @param $description
     * @return bool
     */
    public function cancelRequestByPaymentTrouble($rentalRequest, $amount, $description)
    {
        $rentalRequest->update(['status' => "cancelled"]);
        $this->createLog($rentalRequest);
        $this->sendPushNotification($rentalRequest, 'RequestCancelledByPaymentMethod', 'devices');
//        $this->sendPushNotification($rentalRequest, 'RequestCancelled', 'devicesManager');
        $payment = Payment::create(['user_id' => $rentalRequest->user_id, 'amount' => $amount,
            'uuid' => Uuid::generate(4)->string, 'stripe_transaction_id' => "", 'description' => $description,
            'rental_request_id' => $rentalRequest->id, 'status' => 'failed'
        ]);
        return (count($payment) > 0) ? true : false;
    }

    /**
     * @param $rentalRequest
     * @param $messageKey
     * @param $device
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getPushMessage($rentalRequest, $messageKey, $device)
    {
        $user = User::whereId($device->user_id)->first();
        if (count($user) > 0) {
            if (!is_null($user->default_lang)) {
                $locale = ($user->default_lang === 'en') ? 'en' : 'es';
            } else {
                $locale = null;
            }
        } else {
            $locale = null;
        }
        if ($messageKey === 'AgencyHasTakenTheRequest') {
            $message = trans('messages.' . $messageKey,
                ['agency' => (count($rentalRequest->takenByAgency) > 0) ? $rentalRequest->takenByAgency->name : ""], 'messages', $locale);
        } elseif ($messageKey === 'AgentHasTakenTheRequest') {
            $message = trans('messages.' . $messageKey,
                ['agent' => (count($rentalRequest->takenByUser) > 0) ? $rentalRequest->takenByUser->name : ""], 'messages', $locale);
        } elseif ($messageKey === 'ArrivedAgent') {
            $message = trans('messages.' . $messageKey,
                ['agent' => (count($rentalRequest->takenByUser) > 0) ? $rentalRequest->takenByUser->name : ""], 'messages', $locale);
        } else {
            $message = trans('messages.' . $messageKey, [], 'messages', $locale);
        }

        return $message;
    }

    /**
     * @param $rentalRequest
     * @param $request
     * @param $type
     * @param null $days
     * @return string
     */
    public static function getPaymentDescription($rentalRequest, $request, $type, $days = null)
    {
        if ($request->lang == 'en') {
            list($daysMessage, $extraMessage) = [" day(s) of rent ", " (Cancellation Penalty)"];
        } else {
            list($daysMessage, $extraMessage) = [" día(s) de renta ", " (Penalidad por cancelación)"];
        }
        $days = ($days != null) ? $days : $rentalRequest->total_days;
        $vehicle = (count($rentalRequest->classification) > 0) ? $rentalRequest->classification->title : "";
        $extraMessage = ($type == 'penalty') ? $extraMessage : "";
        return $days . $daysMessage . $vehicle . $extraMessage;
    }

    /**
     * @param $totalAgents
     * @param $agentsId
     * @return mixed
     */
    public function getAvailableAgents($totalAgents, $agentsId)
    {
        $requestList = RentalRequest::whereIn('status', ['taken-user', 'on-way', 'checking', 'taken-user-dropoff', 'returned-car'])
            ->whereIn('taken_by_user', $agentsId->toArray())
            ->orWhereIn('taken_by_user_dropoff', $agentsId->toArray())->get();
        $pickupRequest = $requestList->filter(function ($object) {
            if (in_array($object->status, ['taken-user', 'on-way', 'checking'])) {
                return true;
            }
        });
        $dropOffRequest = $requestList->filter(function ($object) {
            if (in_array($object->status, ['taken-user-dropoff', 'returned-car'])) {
                return true;
            }
        });
        $pickupAgents = (count($pickupRequest) > 0) ? $pickupRequest->map(function ($item) {
            return $item->taken_by_user;
        }) : collect([]);
        $dropOffAgents = (count($dropOffRequest) > 0) ? $dropOffRequest->map(function ($item) {
            return $item->taken_by_user_dropoff;
        }) : collect([]);
        $availableAgentsId = $agentsId->diff($pickupAgents->merge($dropOffAgents));
        $availableAgents = $totalAgents->filter(function ($object) use ($availableAgentsId) {
            if (in_array($object->id, $availableAgentsId->toArray())) {
                return true;
            }
        });
        return $availableAgents;
    }

}