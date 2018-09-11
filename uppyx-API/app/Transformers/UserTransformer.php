<?php
/**
 * Created by PhpStorm.
 * User: vroldan
 * Date: 10/24/16
 * Time: 4:20 PM
 */

namespace App\Transformers;

use App\User;
use Carbon\Carbon;

class UserTransformer
{
    /**
     * @param $user
     * @return array
     */
    public static function transformItem($user)
    {
        $agency = User::find($user->id)->rentalAgencies;
        $response = [
            'id' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'country' => $user->country,
            'city' => $user->city,
            'gender' => $user->gender,
            'birth_of_date' => $user->birth_of_date,
            'phone' => $user->phone,
            'role' => $user->roles,
            'access_token' => $user->access_token,
            'license_picture' => $user->license_picture,
            'profile_picture' => $user->profile_picture,
            'rental_agency_id' => $user->rental_agency_id,
            'rental_agency_name' => isset($agency) ? $agency->name : null,
            'stripe_customer_id' => isset($user->stripe_customer_id) ? $user->stripe_customer_id : null,
            'facebook_id' => isset($user->facebook_id) ? $user->facebook_id : null,
            'facebook_profile_picture' => isset($user->facebook_profile_picture) ? $user->facebook_profile_picture : null,
            'google_id' => isset($user->google_id) ? $user->google_id : null,
            'google_profile_picture' => isset($user->google_profile_picture) ? $user->google_profile_picture : null,
            'configuration' => RentalRequestTransformer::getConfigurations(),
        ];
        if (empty($user->access_token)) {
            unset($response['access_token']);
        }
        return ['data' => $response];
    }

    /**
     * @param $users
     * @return array
     */
    public static function transformCollection($users)
    {
        $response = [];
        $configuration = RentalRequestTransformer::getConfigurations();
        foreach ($users as $user) {
            $agency = User::find($user->id)->rentalAgencies;
            $response [] = [
                'id' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'country' => $user->country,
                'city' => $user->city,
                'gender' => $user->gender,
                'birth_of_date' => $user->birth_of_date,
                'phone' => $user->phone,
                'access_token' => $user->access_token,
                'license_picture' => $user->license_picture,
                'profile_picture' => $user->profile_picture,
                'rental_agency_id' => $user->rental_agency_id,
                'rental_agency_name' => isset($agency) ? $agency->name : null,
                'stripe_customer_id' => isset($user->stripe_customer_id) ? $user->stripe_customer_id : null,
                'facebook_id' => isset($user->facebook_id) ? $user->facebook_id : null,
                'facebook_profile_picture' => isset($user->facebook_profile_picture) ? $user->facebook_profile_picture : null,
                'google_id' => isset($user->google_id) ? $user->google_id : null,
                'google_profile_picture' => isset($user->google_profile_picture) ? $user->google_profile_picture : null,
                'created_at' => Carbon::parse($user->created_at)->toDateString(),
                'updated_at' => Carbon::parse($user->updated_at)->toDateString(),
                'configuration' => $configuration,
            ];
        }
        return $response;
    }
}