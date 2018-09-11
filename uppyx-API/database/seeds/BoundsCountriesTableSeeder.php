<?php

use App\Models\City;
use App\Models\BoundsCountry;
use Illuminate\Database\Seeder;

class BoundsCountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = City::whereIn('name', ['Miami', 'Caracas'])->get();
        list($dataMiami, $dataCaracas) = [[], []];
        if (count($cities)) {
            $miami = $cities->filter(function ($object) {
                if ($object->name == 'Miami') return true;
            })->first();
            $caracas = $cities->filter(function ($object) {
                if ($object->name == 'Caracas') return true;
            })->first();
            if (count($miami) > 0) {
                $dataMiami = [
                    ['latitude' => '25.45567', 'longitude' => '-80.4721', 'city_id' => $miami->id],
                    ['latitude' => '26.94533', 'longitude' => '-80.07659', 'city_id' => $miami->id]
                ];
            }
            if (count($caracas) > 0) {
                $dataCaracas = [
                    ['latitude' => '10.42704', 'longitude' => '-67.04818', 'city_id' => $caracas->id],
                    ['latitude' => '10.60391', 'longitude' => '-66.92733', 'city_id' => $caracas->id]
                ];
            }
        }
        if (count($dataMiami) > 0) {
            foreach ($dataMiami as $row) {
                BoundsCountry::firstOrCreate($row);
            }
            $this->command->info('Miami Bounds were seeded');
        }
        if (count($dataCaracas) > 0) {
            foreach ($dataCaracas as $row) {
                BoundsCountry::firstOrCreate($row);
            }
            $this->command->info('Caracas Bounds were seeded');
        }
    }
}
