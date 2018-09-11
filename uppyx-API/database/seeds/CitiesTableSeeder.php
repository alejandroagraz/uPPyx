<?php

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitedStates = Country::where('name', 'LIKE', '%Estados Unidos%')->first();
        $venezuela = Country::where('name', 'LIKE', '%Venezuela%')->first();
        $panama = Country::where('name', 'LIKE', '%Panamá%')->first();
        $colombia = Country::where('name', 'LIKE', '%Colombia%')->first();

        $data = [
            //standard
            ['name' => 'Miami', 'latitude' => '25.76155', 'longitude' => '-80.20156',
                'country_id' => (count($unitedStates) > 0) ? $unitedStates->id : null],
            ['name' => 'Ciudad de Panamá', 'latitude' => '8°59′36″ N', 'longitude' => '79°31′11″ O',
                'country_id' => (count($panama) > 0) ? $panama->id : null],
            ['name' => 'Bogotá', 'latitude' => '4°36′34″ N', 'longitude' => '4°04′54″ O',
                'country_id' => (count($colombia) > 0) ? $colombia->id : null],
            ['name' => 'Caracas', 'latitude' => '10.47903', 'longitude' => '-66.90399',
                'country_id' => (count($venezuela) > 0) ? $venezuela->id : null]
        ];

        list($cities, $i) = [City::all(), 0];
        foreach ($data as $row) {
            $city = $cities->filter(function ($object) use($row) {
                if($object->name == $row['name']) return true;
            })->first();
            if (count($city) <= 0 && !is_null($row['country_id'])) {
                $model = new City();
                $model->name = $row['name'];
                $model->latitude = $row['latitude'];
                $model->longitude = $row['longitude'];
                $model->country_id = $row['country_id'];
                $model->save();
                $i++;
            }
        }
        $this->command->info($i. ' City(ies) were seeded');
    }
}
