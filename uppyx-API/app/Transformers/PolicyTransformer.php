<?php
/**
 * Created by PhpStorm.
 * User: lagonzalez
 * Date: 11/14/16
 * Time: 03:20 PM
 */

namespace App\Transformers;


class PolicyTransformer
{
    static function transformCollection($policies){
        $response = [];

        foreach($policies as $policy){
            $response [] = [
                'id' => $policy->id,
                'name' => $policy->title,
                'description' => $policy->description,
            ];
        }
        return ['data'=>$response];
    }
}