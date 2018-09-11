<?php

use App\Models\DiscountCode;
use Illuminate\Database\Seeder;

class DiscountCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local', 'dev', 'qa')) {
            $totalDiscountCodes = DiscountCode::count();
            if($totalDiscountCodes < 10) {
                factory(DiscountCode::class, 5)->create();
            }
        }
    }
}
