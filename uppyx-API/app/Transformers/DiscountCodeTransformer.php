<?php

namespace App\Transformers;


class DiscountCodeTransformer
{
    public static function transformItem($discountCode)
    {
        $response = [
            'id' => $discountCode->uuid,
            'code' => $discountCode->code,
            'active' => $discountCode->active,
            'operation' => $discountCode->discount_operation,
            'unit' => $discountCode->discount_unit,
            'amount' => $discountCode->discount_amount,
            'uses' => $discountCode->num_uses,
            'expiry' => $discountCode->expiry,
        ];
        return ['data' => $response];
    }
}