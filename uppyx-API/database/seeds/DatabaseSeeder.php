<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CarClassificationsTableSeeder::class);
        $this->call(PoliciesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);
        $this->call(PolilinesTableSeeder::class);
        $this->call(ChargesTableSeeder::class);
        $this->call(RatesTableSeeder::class);
        $this->call(BoundsCountriesTableSeeder::class);
        $this->call(LogsTypeTableSeeder::class);
        $this->call(DiscountCodesTableSeeder::class);
        $this->call(RentalAgenciesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
//        $this->call(UsersTableSeeder::class);
//        $this->call(Users2TableSeeder::class);
//        $this->call(RentalRequestsTableSeeder::class);
//        $this->call(LogsTableSeeder::class);
    }
}
