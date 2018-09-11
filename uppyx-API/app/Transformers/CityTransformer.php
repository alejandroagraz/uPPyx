<?php
/**
 * Created by PhpStorm.
 * User: lagonzalez
 * Date: 11/15/16
 * Time: 01:40 PM
 */

namespace App\Transformers;


use App\Models\Configuration;

class CityTransformer
{
    /**
     * @param $cities
     * @return array
     */
    static function transformCollection($cities){
        $response = [];
        $configurations = Configuration::all();
        $maxDays = $configurations->where('alias', '=', 'max_days')->first();
        $maxWaitTime = $configurations->where('alias', '=', 'max_wait_time')->first();
        foreach($cities as $city){
            $polilines = [];
            $bounds = [];

            foreach($city->polilines as $poliline){
                $polilines[] = [
                    'latitude' => $poliline->latitude,
                    'longitude' => $poliline->longitude,
                ];
            }

            foreach($city->bounds as $bound){
                $bounds[] = [
                    'latitude' => $bound->latitude,
                    'longitude' => $bound->longitude,
                ];
            }

            $response [] = [
                'id' => $city->id,
                'name' => $city->name,
                'country_id' => isset($city->country->id)?$city->country->id:null,
                'country' => isset($city->country->name)?$city->country->name:null,
                'region' => isset($city->country->region)?$city->country->region:null,
                'short_name' => isset($city->country->short_name)?$city->country->short_name:null,
                'pick_up_max_time' => ($maxDays)? (int)$maxDays->value : (int)0,
                'max_wait_time' => ($maxWaitTime)? (int)$maxWaitTime->value : (int)0,
                'location' => [
                    'latitude' => $city->latitude,
                    'longitude' => $city->longitude,
                ],
                'polilines' => count($polilines)>0?$polilines:null,
                'bounds' => count($polilines)>0?$bounds:null,
            ];
        }
        return ['data'=>$response];
    }

    /**
     * @param $cities
     * @return array
     */
    static function transformCountryCollection($countries){

        foreach($countries as $country){
            $response [] = [
                'id' => $country->id,
                'name' => $country->name,
                'name_en' => $country->name_en,
                'region' => $country->region,
                'short_name' => $country->short_name,
            ];
        }
        return ['data'=>$response];
    }
}