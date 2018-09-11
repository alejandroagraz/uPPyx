<?php

namespace App\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Configuration;

class RentalRequestTransformer
{
    /**
     * @param $rentalRequests
     * @return array
     */
    public static function transformCollection($rentalRequests)
    {
        list($response, $originalRequest, $lang) = [[], Request::capture(), "en"];
        if (count($originalRequest) > 0 || $originalRequest != null) {
            $lang = (isset($originalRequest->lang)) ? $originalRequest->lang : "en";
        }
        $configuration = self::getConfigurations();
        $pagination = self::getPagination($rentalRequests);
        foreach ($rentalRequests as $req) {
            $arrPickUp = self::getCoordinates($req, 'pickup_address_coordinates');
            $arrDropOff = self::getCoordinates($req, 'dropoff_address_coordinates');
            $diffNowPickUpDate = Carbon::now()->diffInMinutes(Carbon::parse($req->pickup_date), false);
            $canAssign = (($diffNowPickUpDate <= (int)$configuration['assign_planned_request_time']
                    && $req->type == 'planned') || $req->type == 'standard') ? true : false;
            $canDropOff = self::verifyCanDropOff($req, $configuration);
            list($countryName, $cityName, $similarMessage) = self::getRegionParams($req, $lang);
            $requestOwner = self::getRelationshipName($req, 'requestedBy');
            $takenByManager = self::getRelationshipName($req, 'takenByManager');
            $takenByAgency = self::getRelationshipName($req, 'takenByAgency');
            $takenByUser = self::getRelationshipName($req, 'takenByUser');
            $takenByUserDropOff = self::getRelationshipName($req, 'takenByUserDropOff');
            $classification = self::getRelationshipName($req, 'classification', $similarMessage);
            $cancellationReason = self::getRelationshipName($req, 'cancellationRequestReasons');
            $rentalRequestExtensions = self::getRelationshipName($req, 'rentalRequestExtensions');
            $discountCodes = self::getRelationshipName($req, 'discountCodes');
            $rentalRequestRates = self::getRelationshipName($req, 'rentalRequestRates');
            $response [] = self::getResponseArray($req, $arrPickUp, $arrDropOff, $requestOwner, $takenByAgency,
                $takenByUser, $takenByManager, $takenByUserDropOff, $classification,
                $cancellationReason, $rentalRequestExtensions, $configuration, $canDropOff,
                $canAssign, $cityName, $countryName, $discountCodes, $rentalRequestRates);
        }
        return ['data' => $response, 'pagination' => $pagination];
    }

    /**
     * @param $rentalRequests
     * @param $isPickup
     * @return array
     */
    public static function transformFilterCollection($rentalRequests, $isPickup)
    {
        list($response, $originalRequest, $lang) = [[], Request::capture(), "en"];
        if (count($originalRequest) > 0 || $originalRequest != null) {
            $lang = (isset($originalRequest->lang)) ? $originalRequest->lang : "en";
        }
        $configuration = self::getConfigurations();
        foreach ($rentalRequests as $req) {
            $arrPickUp = self::getCoordinates($req, 'pickup_address_coordinates');
            $arrDropOff = self::getCoordinates($req, 'dropoff_address_coordinates');
            $diffNowPickUpDate = Carbon::now()->diffInMinutes(Carbon::parse($req->pickup_date), false);
            $canAssign = (($diffNowPickUpDate <= (int)$configuration['assign_planned_request_time']
                    && $req->type == 'planned') || $req->type == 'standard') ? true : false;
            $canDropOff = self::verifyCanDropOff($req, $configuration);
            list($countryName, $cityName, $similarMessage) = self::getRegionParams($req, $lang);
            $requestOwner = self::getRelationshipName($req, 'requestedBy');
            $takenByManager = self::getRelationshipName($req, 'takenByManager');
            $takenByAgency = self::getRelationshipName($req, 'takenByAgency');
            $takenByUser = self::getRelationshipName($req, 'takenByUser');
            $takenByUserDropOff = self::getRelationshipName($req, 'takenByUserDropOff');
            $classification = self::getRelationshipName($req, 'classification', $similarMessage);
            $cancellationReason = self::getRelationshipName($req, 'cancellationRequestReasons');
            $rentalRequestExtensions = self::getRelationshipName($req, 'rentalRequestExtensions');
            $discountCodes = self::getRelationshipName($req, 'discountCodes');
            $rentalRequestRates = self::getRelationshipName($req, 'rentalRequestRates');
            $response [] = self::getResponseArray($req, $arrPickUp, $arrDropOff, $requestOwner, $takenByAgency,
                $takenByUser, $takenByManager, $takenByUserDropOff, $classification,
                $cancellationReason, $rentalRequestExtensions, $configuration, $canDropOff,
                $canAssign, $cityName, $countryName, $discountCodes, $rentalRequestRates);
        }
        $collectionRequests = collect($response);
        if ($isPickup === true) {
            $pendingToAssign = self::getRequestsByStatus($collectionRequests, 'taken-manager');
            $assigned = self::getRequestsByStatus($collectionRequests, 'taken-user');
            $onWay = self::getRequestsByStatus($collectionRequests, 'on-way');
            $checking = self::getRequestsByStatus($collectionRequests, 'checking');
            $onBoard = self::getRequestsByStatus($collectionRequests, 'on-board');
            $cancelled = self::getRequestsByStatus($collectionRequests, 'cancelled');
            $data = ['taken-manager' => $pendingToAssign, 'taken-user' => $assigned, 'on-way' => $onWay,
                'checking' => $checking, 'on-board' => $onBoard, 'cancelled' => $cancelled];
        } else {
            $onBoardDropOff = $collectionRequests->filter(function ($rentalRequest) {
//                $diffHourDropOffDate = Carbon::now()->diffInHours(Carbon::parse($rentalRequest['dropoff_date']), false);
                if ($rentalRequest['status'] === 'on-board') { /* && $diffHourDropOffDate <= 24 */
                    return true;
                }
            })->sortByDesc('returned_car')->sortBy('dropoff_date')->toArray();
            list($keys, $onBoardDropOff) = array_divide($onBoardDropOff);
//            $onBoardDropOff = self::getRequestsByStatus($collectionRequests, 'on-board', 'sortBy', 'dropoff_date');
            $takenUserDropOff = self::getRequestsByStatus($collectionRequests, 'taken-user-dropoff', 'sortBy', 'dropoff_date');
            $returnedCar = self::getRequestsByStatus($collectionRequests, 'returned-car', 'sortBy', 'dropoff_date');
            $finished = self::getRequestsByStatus($collectionRequests, 'finished', 'sortBy', 'dropoff_date');
            $data = ['on-board' => $onBoardDropOff, 'taken-user-dropoff' => $takenUserDropOff,
                'returned-car' => $returnedCar, 'finished' => $finished];
        }
        return ['data' => $data];
    }

    /**
     * @param $model
     * @param bool $withMessage
     * @return array
     */
    public static function transformItem($model, $withMessage = false)
    {
        list($arrayResponse, $originalRequest, $lang) = [[], Request::capture(), "en"];
        if (count($originalRequest) > 0 || $originalRequest != null) {
            $lang = (isset($originalRequest->lang)) ? $originalRequest->lang : "en";
        }
        $configuration = self::getConfigurations($model->city_id);
        $diffNowPickUpDate = Carbon::now()->diffInMinutes(Carbon::parse($model->pickup_date), false);
        $canAssign = (($diffNowPickUpDate <= (int)$configuration['assign_planned_request_time']
                && $model->type == 'planned') || $model->type == 'standard') ? true : false;
        $canDropOff = self::verifyCanDropOff($model, $configuration);
        $arrPickUp = self::getCoordinates($model, 'pickup_address_coordinates');
        $arrDropOff = self::getCoordinates($model, 'dropoff_address_coordinates');
        list($countryName, $cityName, $similarMessage) = self::getRegionParams($model, $lang);
        $requestOwner = self::getRelationshipName($model, 'requestedBy');
        $takenByManager = self::getRelationshipName($model, 'takenByManager');
        $takenByAgency = self::getRelationshipName($model, 'takenByAgency');
        $takenByUser = self::getRelationshipName($model, 'takenByUser');
        $takenByUserDropOff = self::getRelationshipName($model, 'takenByUserDropOff');
        $classification = self::getRelationshipName($model, 'classification', $similarMessage);
        $cancellationReason = self::getRelationshipName($model, 'cancellationRequestReasons');
        $rentalRequestExtensions = self::getRelationshipName($model, 'rentalRequestExtensions');
        $discountCodes = self::getRelationshipName($model, 'discountCodes');
        $rentalRequestRates = self::getRelationshipName($model, 'rentalRequestRates');
        $response [] = self::getResponseArray($model, $arrPickUp, $arrDropOff, $requestOwner, $takenByAgency,
            $takenByUser, $takenByManager, $takenByUserDropOff, $classification,
            $cancellationReason, $rentalRequestExtensions, $configuration, $canDropOff,
            $canAssign, $cityName, $countryName, $discountCodes, $rentalRequestRates);

        $arrayResponse['data'] = $response;
        if ($withMessage) {
            $arrayResponse['message'] = trans('messages.' . self::getRequestMessage($model));
        }
        return $arrayResponse;
    }

    /**
     * @param $model
     * @param bool $withMessage
     * @return array
     */
    public static function transformItemPushIos($model, $withMessage = false)
    {
        list($response, $originalRequest, $lang) = [[], Request::capture(), "en"];
        if (count($originalRequest) > 0 || $originalRequest != null) {
            $lang = (isset($originalRequest->lang)) ? $originalRequest->lang : "en";
        }
        $configuration = self::getConfigurations($model->city_id);
        $diffNowPickUpDate = Carbon::now()->diffInMinutes(Carbon::parse($model->pickup_date), false);
        $canAssign = (($diffNowPickUpDate <= (int)$configuration['assign_planned_request_time'] && $model->type == 'planned')
            || $model->type == 'standard') ? true : false;
        $canDropOff = self::verifyCanDropOff($model, $configuration);
        $arrPickUp = self::getCoordinates($model, 'pickup_address_coordinates');
        $arrDropOff = self::getCoordinates($model, 'dropoff_address_coordinates');
        list($countryName, $cityName, $similarMessage) = self::getRegionParams($model, $lang);
        $takenByAgency = self::getPushRelationshipName($model, 'takenByAgency');

        $response [] = [
            'id' => $model->uuid,
            'total_cost' => $model->total_cost,
            'total_days' => $model->total_days,
            'pickup_address' => $model->pickup_address,
            'pickup_address_coordinates' => (count($arrPickUp) > 0) ? $arrPickUp : null,
            'pickup_date' => $model->pickup_date,
            'dropoff_address' => $model->dropoff_address,
            'dropoff_address_coordinates' => (count($arrDropOff) > 0) ? $arrDropOff : null,
            'dropoff_date' => $model->dropoff_date,
            'type' => $model->type,
            'last_agent_coordinate' => (!is_null($model->last_agent_coordinate)) ? json_decode($model->last_agent_coordinate)
                : $model->last_agent_coordinate,
            'status' => $model->status,
            'returned_car' => (boolean)$model->returned_car,
            'time_zone' => $model->time_zone,
            'agency' => $takenByAgency,
            'can_assign' => (in_array($model->status, ['on-way', 'checking'])) ? false : $canAssign,
            'can_dropoff' => $canDropOff,
            'city' => $cityName,
            'country' => $countryName
        ];
        $arrayResponse = [];
        $arrayResponse['data'] = $response;
        if ($withMessage) {
            $arrayResponse['message'] = trans('messages.' . self::getRequestMessage($model));
        }
        return $arrayResponse;
    }

    /**
     * @param $model
     * @param bool $withMessage
     * @return array
     */
    public static function transformItemPushAndroid($model, $withMessage = false)
    {
        list($response, $originalRequest, $lang) = [[], Request::capture(), "en"];
        if (count($originalRequest) > 0 || $originalRequest != null) {
            $lang = (isset($originalRequest->lang)) ? $originalRequest->lang : "en";
        }
        $configuration = self::getConfigurations($model->city_id);
        $diffNowPickUpDate = Carbon::now()->diffInMinutes(Carbon::parse($model->pickup_date), false);
        $canAssign = (($diffNowPickUpDate <= (int)$configuration['assign_planned_request_time']
                && $model->type == 'planned') || $model->type == 'standard') ? true : false;
        $canDropOff = self::verifyCanDropOff($model, $configuration);
        $arrPickUp = self::getCoordinates($model, 'pickup_address_coordinates');
        $arrDropOff = self::getCoordinates($model, 'dropoff_address_coordinates');
        list($countryName, $cityName, $similarMessage) = self::getRegionParams($model, $lang);
        $takenByManager = self::getPushRelationshipName($model, 'takenByManager');
        $takenByAgency = self::getPushRelationshipName($model, 'takenByAgency');
        $takenByUser = self::getPushRelationshipName($model, 'takenByUser');
        $takenByUserDropOff = self::getPushRelationshipName($model, 'takenByUserDropOff');
        $classification = self::getPushRelationshipName($model, 'classification', $similarMessage);
        $cancellationReason = self::getPushRelationshipName($model, 'cancellationRequestReasons');
        $rentalRequestExtensions = self::getPushRelationshipName($model, 'rentalRequestExtensions');

        $dropOffDate = (count($rentalRequestExtensions) > 0) ? $rentalRequestExtensions['dropoff_date'] : $model->dropoff_date;
        $diffNowDropOffDate = Carbon::now()->diffInHours(Carbon::parse($dropOffDate), false);
        $canExtend = (($diffNowDropOffDate >= (int)$configuration['extends_request_time'])) ? true : false;

        $response [] = [
            'id' => $model->uuid,
            'total_cost' => $model->total_cost,
            'total_days' => $model->total_days,
            'pickup_address' => $model->pickup_address,
            'pickup_address_coordinates' => (count($arrPickUp) > 0) ? $arrPickUp : null,
            'pickup_date' => $model->pickup_date,
            'dropoff_address' => $model->dropoff_address,
            'dropoff_address_coordinates' => (count($arrDropOff) > 0) ? $arrDropOff : null,
            'dropoff_date' => $model->dropoff_date,
            'type' => $model->type,
            'last_agent_coordinate' => (!is_null($model->last_agent_coordinate)) ? json_decode($model->last_agent_coordinate)
                : $model->last_agent_coordinate,
            'status' => $model->status,
            'returned_car' => (boolean)$model->returned_car,
            'time_zone' => $model->time_zone,
            'agency' => $takenByAgency,
            'takenByUser' => $takenByUser,
            'takenByManager' => $takenByManager,
            'takenByUserDropoff' => $takenByUserDropOff,
            'classification' => $classification,
            'cancelationReason' => $cancellationReason,
            'can_assign' => (in_array($model->status, ['on-way', 'checking'])) ? false : $canAssign,
            'can_dropoff' => $canDropOff,
            'can_extend' => $canExtend,
            'city' => $cityName,
            'country' => $countryName
        ];
        $arrayResponse = [];
        $arrayResponse['data'] = $response;
        if ($withMessage) {
            $arrayResponse['message'] = trans('messages.' . self::getRequestMessage($model));
        }
        return $arrayResponse;
    }

    /**
     * @param $object
     * @return string
     */
    public static function getRequestMessage($object)
    {
        switch ($object->status) {
            case "sent":
                $messageKey = "ProcessingRequest";
                break;
            case "cancelled":
                $messageKey = "RequestCancelledMsg";
                break;
            case "cancelled-app":
                $messageKey = "RequestCancelledMsg";
                break;
            case "cancelled-system":
                $messageKey = "RequestCancelledMsg";
                break;
            case "taken-user":
                $messageKey = "RequestTakenByAgency";
                break;
            case "taken-manager":
                $messageKey = "RequestTakenByAgency";
                break;
            case "on-way":
                $messageKey = "RequestTakenByAgency";
                break;
            case "on-board":
                $messageKey = "RequestDelivered";
                break;
            default:
                $messageKey = "ProcessingRequest";
        }
        return $messageKey;
    }

    /**
     * @param $collectionRequests
     * @param $status
     * @param string $method
     * @param string $sortField
     * @return mixed
     */
    public static function getRequestsByStatus($collectionRequests, $status, $method = "sortBy", $sortField = "pickup_date")
    {
        $rentalRequests = $collectionRequests->filter(function ($rentalRequest) use ($status) {
            if ($rentalRequest['status'] === $status) {
                if ($status == 'cancelled') {
                    $diffNowCreatedAtDate = Carbon::now()->diffInHours(Carbon::parse($rentalRequest['created_at']));
                    return ($diffNowCreatedAtDate <= 48) ? true : false;
                }
                return true;
            }
        })->$method($sortField)->toArray();
        list($keys, $rentalRequests) = array_divide($rentalRequests);
        return $rentalRequests;
    }

    /**
     * @param null $cityId
     * @return array
     */
    public static function getConfigurations($cityId = null)
    {
        $configurations = Configuration::getAllConfigurations($cityId);

        $configuration = [
            'assign_planned_request_time' => (int)$configurations['assign_planned_request_time']['value'],
            'max_time_refresh_map' => (int)$configurations['max_days_refresh_map']['value'],
            'request_type_time' => (int)$configurations['request_type_time']['value'],
            'max_days_by_rental' => (int)$configurations['max_days_by_rental']['value'],
            'extends_request_time' => (int)$configurations['extends_request_time']['value'],
            'assign_dropoff_request_time' => (int)$configurations['assign_dropoff_request_time']['value']
        ];
        return $configuration;
    }

    /**
     * @param $rentalRequest
     * @param $relationName
     * @param string $similarMessage
     * @return array|null
     */
    public static function getRelationshipName($rentalRequest, $relationName, $similarMessage = "")
    {
        if (count($rentalRequest->$relationName) > 0) {
            if ($relationName === 'takenByAgency') {
                $object = [
                    'id' => $rentalRequest->$relationName->uuid,
                    'name' => $rentalRequest->$relationName->name,
                    'phone' => $rentalRequest->$relationName->phone,
                    'address' => $rentalRequest->$relationName->address,
                    'description' => $rentalRequest->$relationName->description,
                    'status' => $rentalRequest->$relationName->status,
                ];
            } elseif ($relationName === 'classification') {
                $object = [
                    'id' => $rentalRequest->$relationName->uuid,
                    'description' => $rentalRequest->$relationName->title . $similarMessage,
                    'category' => $rentalRequest->$relationName->category,
                    'type' => $rentalRequest->$relationName->type,
                    'price_low_season' => $rentalRequest->$relationName->price_low_season,
                    'price_high_season' => $rentalRequest->$relationName->price_high_season,
                    'photo' => $rentalRequest->$relationName->photo,
                ];
            } elseif ($relationName === 'cancellationRequestReasons') {
                if (count($rentalRequest->$relationName->first()) > 0) {
                    $object = [
                        'id' => $rentalRequest->$relationName->first()->uuid,
                        'reason' => $rentalRequest->$relationName->first()->reason,
                        'comment' => $rentalRequest->$relationName->first()->comment,
                    ];
                } else {
                    $object = null;
                }
            } elseif ($relationName === 'rentalRequestExtensions') {
                $extensions = $rentalRequest->$relationName;
                $lastExtension = $extensions->sortByDesc('created_at')->first();
                if (count($lastExtension) > 0) {
                    $dropOffAddressCoordinates = self::getCoordinates($lastExtension, 'dropoff_address_coordinates');
                    $object = [
                        'id' => $lastExtension->uuid,
                        'total_days' => $lastExtension->total_days,
                        'total_cost' => $lastExtension->total_cost,
                        'dropoff_address' => $lastExtension->dropoff_address,
                        'dropoff_date' => $lastExtension->dropoff_date,
                        'dropoff_address_coordinates' => (count($dropOffAddressCoordinates) > 0) ? $dropOffAddressCoordinates : null,
                    ];
                } else {
                    $object = null;
                }
            } elseif ($relationName === 'discountCodes') {
                $discount = $rentalRequest->$relationName->first();
                if (count($discount) > 0) {
                    $object = [
                        'id' => $discount->uuid,
                        'discount_operation' => $discount->discount_operation,
                        'discount_unit' => $discount->discount_unit,
                        'discount_amount' => $discount->discount_amount,
                    ];
                } else {
                    $object = null;
                }
            } elseif ($relationName === 'rentalRequestRates') {
                $rate = $rentalRequest->$relationName->first();
                if (count($rate) > 0) {
                    $object = [
                        'id' => $rate->uuid,
                        'rate' => $rate->rate,
                        'comment' => $rate->comment,
                    ];
                } else {
                    $object = null;
                }
            } else {
                $object = [
                    'id' => $rentalRequest->$relationName->uuid,
                    'name' => $rentalRequest->$relationName->name,
                    'phone' => $rentalRequest->$relationName->phone,
                    'address' => $rentalRequest->$relationName->address,
                    'email' => $rentalRequest->$relationName->email,
                    'license_picture' => $rentalRequest->$relationName->license_picture,
                    'profile_picture' => $rentalRequest->$relationName->profile_picture,
                    'facebook_id' => $rentalRequest->$relationName->facebook_id,
                    'facebook_profile_picture' => $rentalRequest->$relationName->facebook_profile_picture,
                    'google_id' => $rentalRequest->$relationName->google_id,
                    'google_profile_picture' => $rentalRequest->$relationName->google_profile_picture,
                    'stripe_customer_id' => $rentalRequest->$relationName->stripe_customer_id,
                    'birth_of_date' => $rentalRequest->$relationName->birth_of_date,
                    'country' => $rentalRequest->$relationName->country
                ];
            }
        } else {
            $object = null;
        }
        return $object;
    }

    /**
     * @param $rentalRequest
     * @param $relationName
     * @param string $similarMessage
     * @return array|null
     */
    public static function getPushRelationshipName($rentalRequest, $relationName, $similarMessage = "")
    {
        if (count($rentalRequest->$relationName) > 0) {
            if ($relationName === 'takenByAgency') {
                $object = [
                    'name' => $rentalRequest->$relationName->name,
                    'phone' => $rentalRequest->$relationName->phone,
                    'address' => $rentalRequest->$relationName->address,
                    'address' => $rentalRequest->$relationName->description,
                ];
            } elseif ($relationName === 'classification') {
                $object = [
                    'description' => $rentalRequest->$relationName->title . $similarMessage,
                    'category' => $rentalRequest->$relationName->category,
                    'type' => $rentalRequest->$relationName->type,
                ];
            } elseif ($relationName === 'cancellationRequestReasons') {
                if (count($rentalRequest->$relationName->first()) > 0) {
                    $object = [
                        'id' => $rentalRequest->$relationName->first()->uuid,
                        'reason' => $rentalRequest->$relationName->first()->reason,
                        'comment' => $rentalRequest->$relationName->first()->comment,
                    ];
                } else {
                    $object = null;
                }
            } elseif ($relationName === 'rentalRequestExtensions') {
                $extensions = $rentalRequest->$relationName;
                $lastExtension = $extensions->sortByDesc('created_at')->first();
                if (count($lastExtension) > 0) {
                    $dropOffAddressCoordinates = self::getCoordinates($lastExtension, 'dropoff_address_coordinates');
                    $object = [
                        'id' => $lastExtension->uuid,
                        'total_days' => $lastExtension->total_days,
                        'total_cost' => $lastExtension->total_cost,
                        'dropoff_address' => $lastExtension->dropoff_address,
                        'dropoff_date' => $lastExtension->dropoff_date,
                        'dropoff_address_coordinates' => (count($dropOffAddressCoordinates) > 0) ? $dropOffAddressCoordinates : null,
                    ];
                } else {
                    $object = null;
                }
            } else {
                $object = [
                    'name' => $rentalRequest->$relationName->name,
                    'email' => $rentalRequest->$relationName->email,
                    'phone' => $rentalRequest->$relationName->phone,
                    'profile_picture' => $rentalRequest->$relationName->profile_picture,
                ];
            }
        } else {
            $object = null;
        }
        return $object;
    }

    /**
     * @param $object
     * @param $key
     * @return array
     */
    public static function getCoordinates($object, $key)
    {
        list($coordinates, $arrayOfCoordinates) = [explode(',', $object->$key), []];
        if (count($coordinates) == 2) {
            $arrayOfCoordinates = [
                'latitude' => trim($coordinates[0]),
                'longitude' => trim($coordinates[1])
            ];
        }
        return $arrayOfCoordinates;
    }

    /**
     * @param $object
     * @param $arrPickUp
     * @param $arrDropOff
     * @param $requestOwner
     * @param $takenByAgency
     * @param $takenByUser
     * @param $takenByManager
     * @param $takenByUserDropOff
     * @param $classification
     * @param $cancellationReason
     * @param $rentalRequestExtensions
     * @param $configuration
     * @param $canDropOff
     * @param $canAssign
     * @param $cityName
     * @param $countryName
     * @param $discountCodes
     * @param $rentalRequestRates
     * @return array
     */
    public static function getResponseArray($object, $arrPickUp, $arrDropOff, $requestOwner, $takenByAgency,
                                            $takenByUser, $takenByManager, $takenByUserDropOff, $classification,
                                            $cancellationReason, $rentalRequestExtensions, $configuration, $canDropOff,
                                            $canAssign, $cityName, $countryName, $discountCodes, $rentalRequestRates)
    {
        if (count($rentalRequestExtensions) > 0) {
            $extension = $rentalRequestExtensions;
            list($totalCost, $totalDays, $dropOffAddress, $dropOffDate, $dropOffCoordinates, $isExtended) =
                [$extension['total_cost'], $extension['total_days'], $extension['dropoff_address'], $extension['dropoff_date'],
                    $extension['dropoff_address_coordinates'], true];
        } else {
            list($totalCost, $totalDays, $dropOffAddress, $dropOffDate, $dropOffCoordinates, $isExtended) =
                [$object->total_cost, $object->total_days, $object->dropoff_address, $object->dropoff_date,
                    $arrDropOff, false];
        }

        $diffNowDropOffDate = Carbon::now()->diffInHours(Carbon::parse($dropOffDate), false);
        $canExtend = (($diffNowDropOffDate >= (int)$configuration['extends_request_time'])) ? true : false;

        $response = [
            'id' => $object->uuid,
            'total_cost' => $totalCost,
            'total_days' => $totalDays,
            'pickup_address' => $object->pickup_address,
            'pickup_address_coordinates' => (count($arrPickUp) > 0) ? $arrPickUp : null,
            'pickup_date' => $object->pickup_date,
            'dropoff_address' => $dropOffAddress,
            'dropoff_address_coordinates' => (count($dropOffCoordinates) > 0) ? $dropOffCoordinates : null,
            'dropoff_date' => $dropOffDate,
            'type' => $object->type,
            'status' => $object->status,
            'last_agent_coordinate' => (!is_null($object->last_agent_coordinate)) ? json_decode($object->last_agent_coordinate)
                : $object->last_agent_coordinate,
            'gate' => $object->gate,
            'blocked_amount' => $object->blocked_amount,
            'credit_card_id' => $object->credit_card_token,
            'created_at' => $object->created_at,
            'returned_car' => (boolean)$object->returned_car,
            'time_zone' => $object->time_zone,
            'requestOwner' => $requestOwner,
            'agency' => $takenByAgency,
            'takenByManager' => $takenByManager,
            'takenByUser' => $takenByUser,
            'takenByUserDropoff' => $takenByUserDropOff,
            'cancelationReason' => $cancellationReason,
            'classification' => $classification,
            'configurations' => $configuration,
            'discountCodes' => $discountCodes,
            'rate' => $rentalRequestRates,
            'can_assign' => (in_array($object->status,
                ['sent', 'on-way', 'checking', 'finished', 'cancelled', 'cancelled-app', 'cancelled-system'])) ? false : $canAssign,
            'can_dropoff' => $canDropOff,
            'can_extend' => $canExtend,
            'is_extended' => $isExtended,
            'city' => $cityName,
            'country' => $countryName
        ];
        return $response;
    }

    /**
     * @param $rentalRequests
     * @return array|null
     */
    public static function getPagination($rentalRequests)
    {
        if ($rentalRequests instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $pagination = [
                'total' => $rentalRequests->total(),
                'per_page' => intval($rentalRequests->perPage()),
                'current_page' => $rentalRequests->currentPage(),
                'last_page' => $rentalRequests->lastPage(),
                'next_page_url' => $rentalRequests->nextPageUrl(),
                'next_page_number' => (!is_null($rentalRequests->nextPageUrl())) ?
                    (int)substr($rentalRequests->nextPageUrl(), -1) : null,
                'prev_page_url' => $rentalRequests->previousPageUrl(),
            ];
        } else {
            $pagination = null;
        }
        return $pagination;
    }

    /**
     * @param $object
     * @param $lang
     * @return array
     */
    public static function getRegionParams($object, $lang)
    {
        $cityName = (count($object->requestCity) > 0) ? $object->requestCity->name : "";
        if ($lang === "es") {
            $similarMessage = " O SIMILAR";
            $countryName = (count($object->requestCity->country) > 0) ? $object->requestCity->country->name : "";
        } else {
            $similarMessage = " OR SIMILAR";
            $countryName = (count($object->requestCity->country) > 0) ? $object->requestCity->country->name_en : "";
        }
        return [$countryName, $cityName, $similarMessage];
    }

    /**
     * @param $object
     * @param $configuration
     * @return bool
     */
    public static function verifyCanDropOff($object, $configuration)
    {
        $rentalRequestExtensions = self::getRelationshipName($object, 'rentalRequestExtensions');
        if (count($rentalRequestExtensions) > 0) {
            $dropOffDate = $rentalRequestExtensions['dropoff_date'];
        } else {
            $dropOffDate = $object->dropoff_date;
        }
        $diffNowDropOffDate = Carbon::now()->diffInMinutes(Carbon::parse($dropOffDate), false);
        $canDropOff = ($diffNowDropOffDate <= (int)$configuration['assign_dropoff_request_time']
            && in_array($object->status, ['on-board', 'taken-user-dropoff'])) ? true : false;
        return $canDropOff;
    }

}