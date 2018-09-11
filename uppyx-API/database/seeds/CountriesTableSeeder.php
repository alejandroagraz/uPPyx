<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Estados Unidos', 'name_en' => 'United States', 'region' => 'us', 'short_name' => 'us'],
            ['name' => 'Panamá', 'name_en' => 'Panama', 'region' => 'pa', 'short_name' => 'pa'],
            ['name' => 'Colombia', 'name_en' => 'Colombia', 'region' => 'co', 'short_name' => 'co'],
            ['name' => 'Venezuela', 'name_en' => 'Venezuela', 'region' => 've', 'short_name' => 've']
        ];

        foreach ($data as $row) {
            Country::firstOrCreate($row);
        }
        $this->command->info('Countries were seeded');
    }
}
