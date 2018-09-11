<?php

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Seeder;
use App\Models\CarClassification;

class CarClassificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            //standard
            ['title' => 'TOYOTA COROLLA', 'description' => 'Estándar Corolla', 'category' => 'car', 'type' => 'standard'],
            ['title' => 'RAV4', 'description' => 'Estándar Rav 4', 'category' => 'suv', 'type' => 'standard'],
            ['title' => 'MINI VAN', 'description' => 'Estándar Mini Van', 'category' => 'van', 'type' => 'standard'],
            //plus
            ['title' => 'CAMRY', 'description' => 'Lux Camry', 'category' => 'car', 'type' => 'plus'],
            ['title' => '4RUNNER', 'description' => 'Lux 4Runner', 'category' => 'suv', 'type' => 'plus'],
            ['title' => 'VAN', 'description' => 'Lux Van', 'category' => 'van', 'type' => 'plus'],
        ];
        list($carClassifications, $i, $j) = [CarClassification::all(), 1, 0];

        foreach ($data as $row) {
            $carClassification = $carClassifications->filter(function ($object) use ($row) {
                if ($object->title == $row['title']) return true;
            })->first();
            if (count($carClassification) <= 0) {
                $model = new CarClassification();
                $model->title = $row['title'];
                $model->description = $row['description'];
                $model->category = $row['category'];
                $model->type = $row['type'];
                $model->photo = 'photo' . $i . '.jpg';
                $model->uuid = Uuid::generate(4)->string;
                $model->save();
                $i++;
                $j++;
            }
        }
        $this->command->info($j . ' Cars Classification(s) were seeded');
    }
}
