<?php

namespace App\Validations;


class RentalRequestValidations
{

    /**
     * @param $data
     * @return mixed
     */
    public static function createRequestValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'pickup_address' => 'required|string|max:255',
            'pickup_date' => 'required|date',
            'dropoff_address' => 'required|string|max:255',
            'dropoff_date' => 'required|date',
            'car_classification_id' => 'required|integer|exists:car_classifications,id,deleted_at,NULL',
            'total_days' => 'required|integer',
            'total_cost' => 'required|numeric',
            'city_id' => 'required|integer|exists:cities,id,deleted_at,NULL',
            'discount_code_id' => 'exists:discount_codes,uuid,deleted_at,NULL,active,1',
            'pickup_address_coordinates' => 'required|string|max:255',
            'dropoff_address_coordinates' => 'required|string|max:255',
            'credit_card_id' => 'required|string',
            'time_zone' => 'string|timezone',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function updateRequestValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'dropoff_address' => 'required|string|max:255',
            'dropoff_address_coordinates' => 'required|string|max:255',
            'rental_request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function extendRentalValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'rental_request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL',
            'dropoff_address' => 'required|string|max:255',
            'dropoff_date' => 'required|date',
            'total_days' => 'required|integer',
            'total_cost' => 'required|numeric',
            'dropoff_address_coordinates' => 'required|string|max:255',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getRequestValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getRequestsValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'limit' => 'required|integer|between:1,50'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function cancelRequestValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function changeStatusRequestByIdValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'rental_request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL',
            'status' => 'required|in:sent,cancelled,taken-manager,taken-user,finished,on-board,on-way,
            cancelled-system,cancelled-app,checking,returned-car',
            'latitude' => 'required_if:status,on-way|string',
            'longitude' => 'required_if:status,on-way|string'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getSentRequestsValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'limit' => 'required|integer|between:1,50'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getDropOffRequestsValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getAcceptedRequestsValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getAssignedRequestsValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'status' => 'required|in:taken-user,taken-user-dropoff'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function currentRequestByUserValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'user_id' => 'required|exists:users,uuid,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function sendCurrentLocationValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL',
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getSummaryValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'pickup_date' => 'required|date',
            'dropoff_date' => 'required|date',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function assignRequestValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'rental_request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL',
            'user_id' => 'required|exists:users,uuid,deleted_at,NULL',
            'status' => 'required|in:taken-user,taken-user-dropoff',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function assignDropOffRequestValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'rental_request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL',
            'user_id' => 'required|exists:users,uuid,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getAgentsListValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'rental_agency_id' => 'required|exists:rental_agencies,id,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function sendCancellationRequestReasonValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'rental_request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL,status,cancelled',
            'user_id' => 'required|exists:users,uuid,deleted_at,NULL',
            'reason' => 'required|string|max:255',
            'comment' => 'string|max:255',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getDiscountAmountValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'code' => 'required|exists:discount_codes,code,deleted_at,NULL,active,1',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function rateExperienceValidation($data)
    {
        $rules = [
            'lang' => 'required|in:en,es',
            'rental_request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL',
            'rate' => 'required|integer|between:1,5',
            'comment' => 'string|max:255'
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function EditRentalRequestValidation($data)
    {
        $rules = [
            'rental_request_id' => 'required|exists:rental_requests,uuid,deleted_at,NULL',
            'password' => 'required|string|min:6',
            'email' => 'required|exists:users,email,deleted_at,NULL',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getChargeResetValidation($data)
    {
        $rules = [
            'rental_request_id' => 'required|unique:charge_resets,rental_request_id',
        ];

        $validator = \Validator::make($data, $rules);
        return $validator;
    }

}
