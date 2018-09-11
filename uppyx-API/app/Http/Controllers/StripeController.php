<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Error\Base;
use Stripe\Error\Card;
use App\Models\Payment;
use Webpatser\Uuid\Uuid;
use App\Libraries\General;
use Stripe\Error\RateLimit;
use Illuminate\Http\Request;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\InvalidRequest;
use App\Validations\StripeValidations;

/**
 * Class StripeController
 * @package App\Http\Controllers
 */
class StripeController extends Controller
{
    // Tokens
    /**
     * @param Request $request
     * @return array|mixed
     */
    public function createCardToken(Request $request)
    {
        $validator = StripeValidations::createCardTokenValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = ["card" => $this->getCardAttributes($request)];
        $resultData = $this->handleStripeResponse('\Stripe\Token', 'create', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    // Customers
    /**
     * @param Request $request
     * @param null $user
     * @return mixed
     */
    public function createCustomer(Request $request, $user = null)
    {
        $user = ($user != null) ? $user : auth()->user();
        if (is_null($user) || empty($user)) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 400);
        }
        $request->merge(["email" => $user->email]);
        $validator = StripeValidations::createCustomerValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $only = ['account_balance', 'business_vat_id', 'created', 'currency', 'default_source', 'delinquent',
            'description', 'discount', 'email', 'livemode', 'metadata', 'shipping', 'source'];
        $requestData = $request->only($only);
        $processedData = ["metadata" => ["name" => $user->name, "uuid" => $user->uuid, "address" => $user->address]];
        $processedData = array_merge($requestData, $processedData);
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'create', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $user->update(['stripe_customer_id' => $resultData['result']->id]);
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }

    }

    /**
     * @param Request $request
     * @param $customer_id
     * @return mixed
     */
    public function retrieveCustomer(Request $request, $customer_id)
    {
        $request->merge(['customer_id' => $customer_id]);
        $validator = StripeValidations::retrieveCustomerValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->customer_id;
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $customer_id
     * @return mixed
     */
    public function updateCustomer(Request $request, $customer_id)
    {
        $request->merge(['customer_id' => $customer_id]);
        $validator = StripeValidations::updateCustomerValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $requestData = $request->except(['source', 'customer_id']);
        $processedData = $request->customer_id;
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            foreach ($requestData as $key => $value) {
                $resultData['result']->$key = $value;
            }
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['save'], null);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $customer_id
     * @return mixed
     */
    public function deleteCustomer(Request $request, $customer_id)
    {
        $request->merge(['customer_id' => $customer_id]);
        $validator = StripeValidations::deleteCustomerValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->customer_id;
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['delete'], null);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $limit
     * @return mixed
     */
    public function allCustomers(Request $request, $limit)
    {
        $request->merge(['limit' => $limit]);
        $validator = StripeValidations::allCustomersValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = ["limit" => $request->limit];
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'all', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    // Cards

    /**
     * @param Request $request
     * @return mixed
     */
    public function createCard(Request $request)
    {
        $user = auth()->user();
        if (is_null($user) || empty($user)) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 400);
        }
        if ($user->stripe_customer_id != $request->customer_id) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 400);
        }
        $request->merge(["customer_id" => $request->customer_id]);
        $validator = StripeValidations::createCardValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->customer_id;
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $processedData = ["source" => $request->source];
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['sources', 'create'], $processedData);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }

    }

    /**
     * @param Request $request
     * @param $customer_id
     * @param $card_id
     * @return mixed
     */
    public function retrieveCard(Request $request, $customer_id, $card_id)
    {
        $request->merge(['customer_id' => $customer_id, 'card_id' => $card_id]);
        $validator = StripeValidations::retrieveCardValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->customer_id;
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['sources', 'retrieve'], $request->card_id);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $customer_id
     * @param $card_id
     * @return mixed
     */
    public function updateCard(Request $request, $customer_id, $card_id)
    {
        $request->merge(['customer_id' => $customer_id, 'card_id' => $card_id]);
        $validator = StripeValidations::updateCardValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $requestData = $request->except(['source', 'customer_id', 'card_id']);
        $processedData = $request->customer_id;
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['sources', 'retrieve'], $request->card_id);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                foreach ($requestData as $key => $value) {
                    $resultData1['result']->$key = $value;
                }
                $resultData2 = $this->handleStripeResponse($resultData1['result'], ['save'], null);
                if (isset($resultData2['code']) && $resultData2['code'] === 200) {
                    return General::responseSuccessAPI($resultData2['title'], $resultData2['result'], $resultData2['code']);
                } else {
                    return General::responseErrorAPI($resultData2['message'], $resultData2['title'], $resultData2['code']);
                }
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $customer_id
     * @param $card_id
     * @return mixed
     */
    public function deleteCard(Request $request, $customer_id, $card_id)
    {
        $request->merge(['customer_id' => $customer_id, 'card_id' => $card_id]);
        $validator = StripeValidations::deleteCardValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->customer_id;
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['sources', 'retrieve'], $request->card_id);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                $resultData2 = $this->handleStripeResponse($resultData1['result'], ['delete'], null);
                if (isset($resultData2['code']) && $resultData2['code'] === 200) {
                    return General::responseSuccessAPI($resultData2['title'], $resultData2['result'], $resultData2['code']);
                } else {
                    return General::responseErrorAPI($resultData2['message'], $resultData2['title'], $resultData2['code']);
                }
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $customer_id
     * @param $limit
     * @return mixed
     */
    public function allCards(Request $request, $customer_id, $limit)
    {
        $request->merge(['customer_id' => $customer_id, 'limit' => $limit]);
        $validator = StripeValidations::allCardsValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->customer_id;
        $resultData = $this->handleStripeResponse('\Stripe\Customer', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $processedData = ['limit' => $request->limit, 'object' => 'card'];
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['sources', 'all'], $processedData);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    // Charges
    /**
     * @param Request $request
     * @return mixed
     */
    public function createCharge(Request $request, $rentalRequest = null)
    {
        $user = (!is_null($rentalRequest) && (count($rentalRequest->requestedBy) > 0)) ? $rentalRequest->requestedBy : auth()->user();
        if (is_null($user) || empty($user)) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 404);
        }
        if(!is_null($rentalRequest)){
            $request->merge(['rental_request_id' => $rentalRequest->uuid]);
        }
        $amount = $request->amount;
        $request->merge(["customer" => $user->stripe_customer_id, "amount" => ($amount * 100)]);
        $validator = StripeValidations::createChargeValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->only(['amount','currency','description','capture','customer']);
        $resultData = $this->handleStripeResponse('\Stripe\Charge', 'create', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            Payment::create(['user_id' => $user->id, 'amount' => $amount, 'uuid' => Uuid::generate(4)->string,
                'stripe_transaction_id' => $resultData['result']->id,
                'rental_request_id' => (!is_null($rentalRequest)) ? $rentalRequest->id : $rentalRequest,
                'description' => (!is_null($resultData['result']->description)) ? $resultData['result']->description : 'charge',
            ]);
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseSuccessAPI($resultData['message'], ['title' => $resultData['title'], 'body' => $resultData['body']],
                $resultData['code']);
        }

    }

    /**
     * @param Request $request
     * @param $charge_id
     * @return mixed
     */
    public function retrieveCharge(Request $request, $charge_id)
    {
        $request->merge(['charge_id' => $charge_id]);
        $validator = StripeValidations::retrieveChargeValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->charge_id;
        $resultData = $this->handleStripeResponse('\Stripe\Charge', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $charge_id
     * @return mixed
     */
    public function captureCharge(Request $request, $charge_id)
    {
        $request->merge(['charge_id' => $charge_id]);
        $validator = StripeValidations::retrieveChargeValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->charge_id;
        $resultData = $this->handleStripeResponse('\Stripe\Charge', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
//            $amount = (isset($request->amount)) ? ($request->amount * 100) :  $resultData['result']->amount;
//            $resultData1 = $this->handleStripeResponse($resultData['result'], ['capture'], ['amount' => $amount]);
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['capture'], null);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $charge_id
     * @return mixed
     */
    public function updateCharge(Request $request, $charge_id)
    {
        $request->merge(['charge_id' => $charge_id]);
        $validator = StripeValidations::updateChargeValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $requestData = $request->except(['charge_id']);
        $processedData = $request->charge_id;
        $resultData = $this->handleStripeResponse('\Stripe\Charge', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            foreach ($requestData as $key => $value) {
                $resultData['result']->$key = $value;
            }
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['save'], null);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $charge_id
     * @return mixed
     */
    public function deleteCharge(Request $request, $charge_id)
    {
        $request->merge(['charge_id' => $charge_id]);
        $validator = StripeValidations::deleteChargeValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->charge_id;
        $resultData = $this->handleStripeResponse('\Stripe\Charge', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['delete'], null);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $limit
     * @return mixed
     */
    public function allCharges(Request $request, $limit)
    {
        $request->merge(['limit' => $limit]);
        $validator = StripeValidations::allChargesValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = ["limit" => $request->limit];
        $resultData = $this->handleStripeResponse('\Stripe\Charge', 'all', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param null $rentalRequest
     * @return mixed
     */
    public function createRefund(Request $request, $rentalRequest = null)
    {
        $user = (!is_null($rentalRequest) && (count($rentalRequest->requestedBy) > 0)) ? $rentalRequest->requestedBy : auth()->user();
        if (is_null($user) || empty($user)) {
            return General::responseErrorAPI(trans('messages.DenyAccess'), 'DenyAccess', 400);
        }
        if(!is_null($rentalRequest)){
            $request->merge(['rental_request_id' => $rentalRequest->uuid]);
        }
        $validator = StripeValidations::createRefundValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->only(['charge']);
        $resultData = $this->handleStripeResponse('\Stripe\Refund', 'create', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            $charge = Payment::whereStripeTransactionId($resultData['result']->charge)->first();
            $amount = (count($charge) > 0) ? $charge->amount : (round(($resultData['result']->amount / 100), 2));
            $requestId = (!is_null($rentalRequest)) ? $rentalRequest->id : "";
            Payment::create(['user_id' => $user->id, 'amount' => $amount, 'uuid' => Uuid::generate(4)->string,
                'stripe_transaction_id' => $resultData['result']->id,
                'description' => 'Refund of request N° ' . $requestId,
                'rental_request_id' => (!is_null($rentalRequest)) ? $rentalRequest->id : null
            ]);
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $refund
     * @return mixed
     */
    public function retrieveRefund(Request $request, $refund)
    {
        $request->merge(['refund' => $refund]);
        $validator = StripeValidations::retrieveRefundValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = $request->refund;
        $resultData = $this->handleStripeResponse('\Stripe\Refund', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $refund
     * @return mixed
     */
    public function updateRefund(Request $request, $refund)
    {
        $request->merge(['refund' => $refund]);
        $validator = StripeValidations::updateRefundValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $requestData = $request->except(['refund']);
        $processedData = $request->refund;
        $resultData = $this->handleStripeResponse('\Stripe\Refund', 'retrieve', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            foreach ($requestData as $key => $value) {
                $resultData['result']->$key = $value;
            }
            $resultData1 = $this->handleStripeResponse($resultData['result'], ['save'], null);
            if (isset($resultData1['code']) && $resultData1['code'] === 200) {
                return General::responseSuccessAPI($resultData1['title'], $resultData1['result'], $resultData1['code']);
            } else {
                return General::responseErrorAPI($resultData1['message'], $resultData1['title'], $resultData1['code']);
            }
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param Request $request
     * @param $limit
     * @return mixed
     */
    public function allRefunds(Request $request, $limit)
    {
        $request->merge(['limit' => $limit]);
        $validator = StripeValidations::allRefundsValidation($request->all());
        if ($validator->fails()) {
            return General::responseErrorAPI($validator->messages()->first(), 'Validation Failed');
        }
        $processedData = ["limit" => $request->limit];
        $resultData = $this->handleStripeResponse('\Stripe\Refund', 'all', $processedData);
        if (isset($resultData['code']) && $resultData['code'] === 200) {
            return General::responseSuccessAPI($resultData['title'], $resultData['result'], $resultData['code']);
        } else {
            return General::responseErrorAPI($resultData['message'], $resultData['title'], $resultData['code']);
        }
    }

    /**
     * @param $class
     * @param $methods
     * @param $processedData
     * @return array
     */
    public function handleStripeResponse($class, $methods, $processedData)
    {
        try {
            // Use Stripe's library to make requests...
            Stripe::setApiKey(env('STRIPE_API_KEY'));
            if (is_string($class)) {
                $methodResult = $class::$methods($processedData);
            } else {
                $numberOfMethods = count($methods);
                if ($numberOfMethods <= 1) {
                    $firstMethod = array_first($methods);
                    if ($processedData === null) {
                        $methodResult = $class->$firstMethod();
                    } else {
                        $methodResult = $class->$firstMethod($processedData);
                    }
                } else {
                    if ($processedData != null) {
                        $firstMethod = array_first($methods);
                        $secondMethod = array_last($methods);
                        $methodResult = $class->$firstMethod->$secondMethod($processedData);
                    }
                }
            }
            return ["result" => $methodResult, "code" => 200, "title" => 'StripeResponse'];
        } catch (Card $e) {
//            // Since it's a decline, \Stripe\Error\Card will be caught | $body = $e->getJsonBody(); $err = $body['error'];
            return ["message" => $e->getMessage(), "code" => 400, "title" => "StripeCardError", "body" => $e->getJsonBody()];
//            print('Status is:' . $e->getHttpStatus() . "\n"); print('Type is:' . $err['type'] . "\n"); print('Code is:' . $err['code'] . "\n");
//            // param is '' in this case | print('Param is:' . $err['param'] . "\n"); print('Message is:' . $err['message'] . "\n");
        } catch (RateLimit $e) {
            // Too many requests made to the API too quickly
            return ["message" => $e->getMessage(), "code" => 400, "title" => "StripeRateLimitError", "body" => $e->getJsonBody()];
        } catch (InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return ["message" => $e->getMessage(), "code" => 400, "title" => "StripeInvalidRequestError", "body" => $e->getJsonBody()];
        } catch (Authentication $e) {
            // Authentication with Stripe's API failed (maybe you changed API keys recently)
            return ["message" => $e->getMessage(), "code" => 400, "title" => "StripeAuthenticationError", "body" => $e->getJsonBody()];
        } catch (ApiConnection $e) {
            // Network communication with Stripe failed
            return ["message" => $e->getMessage(), "code" => 400, "title" => "StripeApiConnectionError", "body" => $e->getJsonBody()];
        } catch (Base $e) {
            // Display a very generic error to the user, and maybe send yourself an email
            return ["message" => $e->getMessage(), "code" => 400, "title" => "StripeBaseError", "body" => $e->getJsonBody()];
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return ["message" => $e->getMessage(), "code" => 400, "title" => "GeneralError"];
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function getCardAttributes($request)
    {
        $data = [
            "number" => $request->number, "exp_month" => $request->exp_month,  "exp_year" => $request->exp_year, "cvc" => $request->cvc
        ];
        return $data;
    }


}
