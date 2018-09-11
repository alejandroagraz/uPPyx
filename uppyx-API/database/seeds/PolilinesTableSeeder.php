<?php

use App\Models\City;
use App\Models\Poliline;
use Illuminate\Database\Seeder;

class PolilinesTableSeeder extends Seeder
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
                    ['latitude' => '26.93186', 'longitude' => '-80.01617', 'city_id' => $miami->id],
                    ['latitude' => '25.73558', 'longitude' => '-80.08758', 'city_id' => $miami->id],
                    ['latitude' => '25.15025', 'longitude' => '-80.28533', 'city_id' => $miami->id],
                    ['latitude' => '25.51765', 'longitude' => '-80.76599', 'city_id' => $miami->id],
                    ['latitude' => '26.68672', 'longitude' => '-80.73852', 'city_id' => $miami->id],
                    ['latitude' => '26.98082', 'longitude' => '-80.49133', 'city_id' => $miami->id],
                    ['latitude' => '26.93186', 'longitude' => '-80.01617', 'city_id' => $miami->id],
                ];
            }
            if (count($caracas) > 0) {
                $dataCaracas = [
                    ['latitude' => '10.54317', 'longitude' => '-66.90193', 'city_id' => $caracas->id],
                    ['latitude' => '10.49996', 'longitude' => '-66.77764', 'city_id' => $caracas->id],
                    ['latitude' => '10.43176', 'longitude' => '-66.78039', 'city_id' => $caracas->id],
                    ['latitude' => '10.42298', 'longitude' => '-66.92321', 'city_id' => $caracas->id],
                    ['latitude' => '10.40407', 'longitude' => '-66.98089', 'city_id' => $caracas->id],
                    ['latitude' => '10.48038', 'longitude' => '-67.03788', 'city_id' => $caracas->id],
                    ['latitude' => '10.58974', 'longitude' => '-67.06707', 'city_id' => $caracas->id],
                    ['latitude' => '10.61643', 'longitude' => '-67.0253', 'city_id' => $caracas->id],
                    ['latitude' => '10.60884', 'longitude' => '-66.96841', 'city_id' => $caracas->id],
                    ['latitude' => '10.54317', 'longitude' => '-66.90193', 'city_id' => $caracas->id],
                ];
            }
        }
        if (count($dataMiami) > 0) {
            foreach ($dataMiami as $row) {
                Poliline::firstOrCreate($row);
            }
            $this->command->info('Miami Polilines were seeded');
        }
        if (count($dataCaracas) > 0) {
            foreach ($dataCaracas as $row) {
                Poliline::firstOrCreate($row);
            }
            $this->command->info('Caracas Polilines were seeded');
        }
    }
}
