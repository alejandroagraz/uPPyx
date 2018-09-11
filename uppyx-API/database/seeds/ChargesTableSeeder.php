<?php

use App\Models\Charge;
use Illuminate\Database\Seeder;

class ChargesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['car_classification_id' => 1, 'configuration_id' => 4],
            ['car_classification_id' => 1, 'configuration_id' => 5],
            ['car_classification_id' => 2, 'configuration_id' => 4],
            ['car_classification_id' => 2, 'configuration_id' => 5],
            ['car_classification_id' => 3, 'configuration_id' => 4],
            ['car_classification_id' => 3, 'configuration_id' => 5],
            ['car_classification_id' => 4, 'configuration_id' => 4],
            ['car_classification_id' => 4, 'configuration_id' => 5],
            ['car_classification_id' => 5, 'configuration_id' => 4],
            ['car_classification_id' => 5, 'configuration_id' => 5],
            ['car_classification_id' => 6, 'configuration_id' => 4],
            ['car_classification_id' => 6, 'configuration_id' => 5],
        ];
        foreach ($data as $row) {
            Charge::firstOrCreate($row);
        }
        $this->command->info('Charges were seeded');

    }
}
