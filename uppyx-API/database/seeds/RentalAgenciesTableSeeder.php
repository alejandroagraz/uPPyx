<?php

use App\Models\RentalAgency;
use Illuminate\Database\Seeder;

class RentalAgenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local', 'dev', 'qa')) {
            $totalRentalAgencies = RentalAgency::count();
            if($totalRentalAgencies < 100) {
                factory(App\Models\RentalAgency::class, 50)->create()->make();
            }
        }
    }
}
