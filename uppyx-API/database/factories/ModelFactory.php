<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//this factory creates new users
$factory->define(App\User::class, function (Faker\Generator $faker) {
    $rand = rand(1,10000);
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->name,
        'email' => $rand.'.'.$faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'phone' => $faker->e164PhoneNumber,
        'address' => $faker->address,
        'status' => 1,
        'rental_agency_id' => App\Models\RentalAgency::inRandomOrder()->whereStatus(1)->first()->id,
    ];
});

//this factory generates one role by each user created
$factory->define(App\Models\RoleUser::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'role_id' => $faker->numberBetween($min = 2, $max = 4),
    ];
});

//this factory generates new rental request.
$factory->define(App\Models\RentalRequest::class, function (Faker\Generator $faker) {
    $userId = App\User::inRandomOrder()->whereStatus(1)->first()->id;
    $totalDays = $faker->numberBetween($min = 1, $max = 20);
    $costPerDay = $faker->numberBetween($min = 3, $max = 120);
    $beforeDays = $faker->numberBetween($min = 1, $max = 10);

    $status = $faker->randomElement(['finished', 'on-board','taken-user','taken-manager','sent','cancelled','on-way',
        'cancelled-system', 'arrived-agent', 'checking']);
    $takenByUser = ($status=='sent' || $status=='cancelled') ? null : App\User::inRandomOrder()->whereNotIn('id',[$userId])->first()->id;
    $takenByAgency = ($status=='sent' || $status=='cancelled') ? null : App\Models\RentalAgency::inRandomOrder()->whereStatus(1)->first()->id;
    $takenByMannager = ($status=='sent' || $status=='cancelled') ? null : App\User::inRandomOrder()->whereHas('roleUsers',function($query){
        $query->whereRoleId(2);
    })->whereNotIn('id',[$userId])->first()->id;
    return [
        'uuid' => $faker->uuid,
        'user_id' => $userId,
        'taken_by_agency' => $takenByAgency,
        'taken_by_user' => $takenByUser,
        'taken_by_manager' => $takenByMannager,
        'city_id' => $faker->numberBetween(1, 4),
        'total_days' => $totalDays,
        'total_cost' => ($totalDays * $costPerDay),
        'blocked_amount' => ($totalDays * $costPerDay),
        'pickup_address' => $faker->city. ''.$faker->country,
        'dropoff_address' =>$faker->city. ''.$faker->country,

        'pickup_date' =>$faker->dateTimeBetween($startDate = '-'.$beforeDays.' days', $endDate = 'now'),
        'dropoff_date' =>$faker->dateTimeBetween($startDate = 'now', $endDate = '+'.$beforeDays.' days'),

        'pickup_address_coordinates' =>$faker->streetAddress,
        'dropoff_address_coordinates' =>$faker->streetAddress,
        'car_classification_id' =>App\Models\CarClassification::inRandomOrder()->first()->id,
        'type' =>$faker->randomElement(['standard', 'planned']),
        'status' =>$status
    ];
});

//this factory generates new rental agencies.
$factory->define(App\Models\RentalAgency::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'user_id' => null,
        'name' => $faker->company,
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'description' => $faker->text,
        'status' => 1,
    ];
});

//this factory generates new Logs
$factory->define(App\Models\Log::class, function (Faker\Generator $faker) {
    $user_id = App\User::inRandomOrder()->first()->id;
    $logType = App\Models\LogType::inRandomOrder()->first()->id;
    $agencies = App\Models\RentalAgency::inRandomOrder()->first()->id;

    $notIn = ['system_cancelled_request','sent_request','user_cancelled_request'];
    $in = ['taken','on-board','finished'];
    if(in_array($logType, $notIn)){
        $rentalRequest = NULL;
    }else{
        $rentalRequest = App\Models\RentalRequest::inRandomOrder()->whereIn('status',$in)->first()->id;
    }

    return [
        'uuid' => $faker->uuid,
        'log_type_id' => $logType,
        'user_id' => $user_id,
        'rental_request_id' => $rentalRequest,
        'rental_agencies_id' => $agencies,
        'message' => $faker->text(30)
    ];
});

//this factory generates new Discount Code
$factory->define(App\Models\DiscountCode::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'code' => 'code'.$faker->unique()->numberBetween(1 , 20),
        'active' => true,
        'discount_operation' => '-',
        'discount_unit' => '$',
        'discount_amount' => $faker->numberBetween(1, 20),
        'num_uses' => $faker->numberBetween(1, 1),
        'expiry' => Carbon\Carbon::now()->addYears(3)->format('Y-m-d'),
    ];
});
