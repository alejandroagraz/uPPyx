<?php

use App\Models\Rate;
use Illuminate\Database\Seeder;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local', 'dev', 'qa')) {
            $data = [
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 70.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 1],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 70.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 1],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 80.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 2],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 80.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 2],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 90.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 3],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 90.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 3],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 100.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 4],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 100.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 4],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 110.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 5],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 110.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 5],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 120.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 6],
                ['valid_from' => '2017-01-01', 'valid_to' => '2017-06-30', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 120.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 6],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 75.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 1],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 75.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 1],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 85.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 2],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 85.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 2],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 95.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 3],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 95.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 3],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 105.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 4],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 105.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 4],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 115.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 5],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 115.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 5],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 125.00, 'country_id' => 1, 'city_id' => 1, 'car_classification_id' => 6],
                ['valid_from' => '2017-07-01', 'valid_to' => '2017-12-31', 'days_from' => 1, 'days_to' => 21,
                    'amount' => 125.00, 'country_id' => 4, 'city_id' => 4, 'car_classification_id' => 6],
            ];
            foreach ($data as $row) {
                Rate::firstOrCreate($row);
            }
            $this->command->info('Rates were seeded');
        }
    }
}
