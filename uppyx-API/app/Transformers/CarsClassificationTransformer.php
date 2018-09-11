<?php
/**
 * Created by PhpStorm.
 * User: vroldan
 * Date: 10/24/16
 * Time: 4:20 PM
 */

namespace App\Transformers;


class CarsClassificationTransformer
{
    static function transformCollection($cars){
        $response = [];

        foreach($cars as $car){
            $response [] = [
                'id' => $car->id,
                'title' => $car->title,
                'description' => $car->description,
                'category' => $car->category,
                'type' => $car->type,
                'price_low_season' => $car->price_low_season,
                'price_high_season' => $car->price_high_season,
                'photo' => $car->photo
            ];
        }
        return ['data'=>$response];
    }
}