<?php
/**
 * Created by PhpStorm.
 * User: vroldan
 * Date: 12/9/16
 * Time: 6:17 PM
 */

namespace App\Transformers;
use Carbon\Carbon;

class RateTransformer
{
    /**
     * @param $rate
     * @return array
     */
    static function transformItem($rate){
        $city = ($rate->cityRate) ? $rate->cityRate : null;
        $carRate = ($rate->carRate) ? $rate->carRate : null;
        $country = ($rate->countryRate) ? $rate->countryRate : null;

        $from = Carbon::parse($rate->valid_from)->format('d-m-Y');
        $to = Carbon::parse($rate->valid_to)->format('d-m-Y');
        $response = [
            'id' => $rate->id,
            'valid_from' => $from,
            'valid_to' => $to,
            'days_from' => $rate->days_from,
            'days_to' => $rate->days_to,
            'amount' => $rate->amount,
            'country_id' => $rate->country_id,
            'city_id' => $rate->city_id,
            'car_classification_id' => $rate->car_classification_id,
            'city' => $city,
            'car_classification' => $carRate,
            'country' => $country,
        ];
        return $response;
    }

    /**
     * @param $rates
     * @return array
     */
    static function transformCollection($rates){
        $response = [];

        foreach($rates as $rate){
            $city = ($rate->cityRate) ? $rate->cityRate : null;
            $carRate = ($rate->carRate) ? $rate->carRate : null;
            $country = ($rate->countryRate) ? $rate->countryRate : null;

            $from = Carbon::parse($rate->valid_from)->format('d-m-Y');
            $to = Carbon::parse($rate->valid_to)->format('d-m-Y');

            $response [] = [
                'id' => $rate->id,
                'valid_from' => $from,
                'valid_to' => $to,
                'days_from' => $rate->days_from,
                'days_to' => $rate->days_to,
                'amount' => $rate->amount,
                'country_id' => $rate->country_id,
                'city_id' => $rate->city_id,
                'car_classification_id' => $rate->car_classification_id,
                'city' => $city,
                'car_classification' => $carRate,
                'country' => $country,
            ];
        }
        return $response;
    }


}