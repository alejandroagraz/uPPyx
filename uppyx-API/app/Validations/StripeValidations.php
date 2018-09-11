<?php

namespace App\Validations;

use Carbon\Carbon;
use Illuminate\Http\Request;

class StripeValidations
{

    public static function createCardTokenValidation($data)
    {
        $year = (int)Carbon::now()->format('Y');
        $min = $year;
        $max = $year + 10;
        $rules = [
            'number' => 'required|numeric|digits_between:14,16',
            'exp_month' => 'required|integer|min:1|max:12',
            'exp_year' => 'required|numeric|digits:4|min:' . $min . '|max:' . $max . '',
            'cvc' => 'required|numeric|digits_between:3,3',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }
    // Customer
    public static function createCustomerValidation($data)
    {
        $rules = [
            'account_balance' => 'integer', // current balance
            'business_vat_id' => 'string', // identification number
            'created' => 'date', // created_at
            'currency' => 'string', // currency
            'default_source' => 'string', // id of the default source attached to this customer
            'delinquent' => 'boolean', // whether or not the latest charge for the customer’s latest invoice has failed
            'description' => 'string|max:100', // description
            'discount' => 'array', // describes the current discount active on the customer, if there is one.
            'email' => 'required|email|exists:users,email,deleted_at,NULL', // email
            'livemode' => 'boolean', // livemode
            'metadata' => 'array', // user's extra data
            'shipping' => 'array', // shipping information associated with the customer
            'source' => 'string',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function retrieveCustomerValidation($data)
    {
        $rules = [
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function updateCustomerValidation($data)
    {
        $rules = [
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
            'account_balance' => 'integer', // current balance
            'business_vat_id' => 'string', // identification number
            'created' => 'date', // created_at
            'currency' => 'string', // currency
            'default_source' => 'string', // id of the default source attached to this customer
            'delinquent' => 'boolean', // whether or not the latest charge for the customer’s latest invoice has failed
            'description' => 'string|max:100', // description
            'discount' => 'array', // describes the current discount active on the customer, if there is one.
            'email' => 'email|exists:users,email,deleted_at,NULL', // email
            'livemode' => 'boolean', // livemode
            'metadata' => 'array', // user's extra data
            'shipping' => 'array', // shipping information associated with the customer
            'source' => 'string',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function allCustomersValidation($data)
    {
        $rules = [
            'limit' => 'required|integer|min:1|max:50'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function deleteCustomerValidation($data)
    {
        $rules = [
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }
    // Cards
    public static function createCardValidation($data)
    {
        $rules = [
            'source' => 'required|string',
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
//            'object' => 'required|string|in:card',
            'account' => 'string',
            'address_city' => 'string',
            'address_country' => 'string',
            'address_line1' => 'string',
            'address_line1_check' => 'string',
            'address_line2' => 'string|max:100',
            'address_state' => 'string',
            'address_zip' => 'string',
            'address_zip_check' => 'string',
            'brand' => 'string|in:Visa,American Express,MasterCard,Discover,JCB, Diners Club,Unknown',
            'currency' => 'string',
            'customer' => 'string',
            'cvc_check' => 'string',
            'default_for_currency' => 'boolean',
//            'exp_month' => 'required|integer|min:1|max:12',
//            'exp_year' => 'required|numeric|digits:4,
//            'number' => 'required|numeric|digits_between:16,16',
//            'cvc' => 'required|numeric|digits_between:3,3',
            'fingerprint' => 'string',
            'funding' => 'string|in:credit,debit,prepaid,unknown',
            'last4 ' => 'string',
            'metadata  ' => 'array',
            'name' => 'string',
            'recipient' => 'string',
            'tokenization_method' => 'string',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function retrieveCardValidation($data)
    {
        $rules = [
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
            'card_id' => 'required|string'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function updateCardValidation($data)
    {
        $rules = [
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
            'card_id' => 'required|string',
//            'object' => 'required|string|in:card',
            'account' => 'string',
            'address_city' => 'string',
            'address_country' => 'string',
            'address_line1' => 'string',
            'address_line1_check' => 'string',
            'address_line2' => 'string|max:100',
            'address_state' => 'string',
            'address_zip' => 'string',
            'address_zip_check' => 'string',
            'brand' => 'string|in:Visa,American Express,MasterCard,Discover,JCB, Diners Club,Unknown',
            'currency' => 'string',
            'customer' => 'string',
            'cvc_check' => 'string',
            'default_for_currency' => 'boolean',
//            'exp_month' => 'required|integer|min:1|max:12',
//            'exp_year' => 'required|numeric|digits:4,
//            'number' => 'required|numeric|digits_between:16,16',
//            'cvc' => 'required|numeric|digits_between:3,3',
            'fingerprint' => 'string',
            'funding' => 'string|in:credit,debit,prepaid,unknown',
            'last4 ' => 'string',
            'metadata  ' => 'array',
            'name' => 'string',
            'recipient' => 'string',
            'tokenization_method' => 'string',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function allCardsValidation($data)
    {
        $rules = [
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
            'limit' => 'required|integer|min:1|max:10'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function deleteCardValidation($data)
    {
        $rules = [
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    // Charges
    public static function createChargeValidation($data)
    {
        $rules = [
            'amount' => 'required|numeric',
            'currency' => 'required|string|min:3|max:3',
            'customer' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
            'description' => 'string|max:100',
            'rental_request_id' => 'exists:rental_requests,uuid,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function retrieveChargeValidation($data)
    {
        $rules = [
            'charge_id' => 'required|string|exists:payments,stripe_transaction_id',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function updateChargeValidation($data)
    {
        $rules = [
            'charge_id' => 'string|exists:payments,stripe_transaction_id',
            'description' => 'string|max:100',
            'fraud_details' => 'array',
            'metadata' => 'array',
            'receipt_email' => 'email',

        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function allChargesValidation($data)
    {
        $rules = [
            'limit' => 'required|integer|min:1|max:50'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function deleteChargeValidation($data)
    {
        $rules = [
            'customer_id' => 'required|string|exists:users,stripe_customer_id,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    // Refund
    public static function createRefundValidation($data)
    {
        $rules = [
            'charge' => 'required|string|exists:payments,stripe_transaction_id',
            'rental_request_id' => 'exists:rental_requests,uuid,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function retrieveRefundValidation($data)
    {
        $rules = [
            'refund' => 'required|string|exists:payments,stripe_transaction_id',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function updateRefundValidation($data)
    {
        $rules = [
            'refund' => 'required|string|exists:payments,stripe_transaction_id',
            'metadata' => 'array',

        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    public static function allRefundsValidation($data)
    {
        $rules = [
            'limit' => 'required|integer|min:1|max:10'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }



}
