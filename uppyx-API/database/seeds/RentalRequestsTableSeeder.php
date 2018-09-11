<?php

use Illuminate\Database\Seeder;

class RentalRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\RentalRequest::class, 100)->create()->make();
    }
}
