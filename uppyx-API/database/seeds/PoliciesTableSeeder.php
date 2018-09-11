<?php

use App\Models\Policy;
use Illuminate\Database\Seeder;

class PoliciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Rent-a-car', 'description' => 'Seguro del Rent-a-car'],
            ['name' => 'SSLI', 'description' => 'Seguro SSLI'],
            ['name' => 'Tarjeta de Crédito', 'description' => 'Seguro por tarjeta de cédito']
        ];
        foreach ($data as $row) {
            Policy::firstOrCreate($row);
        }
        $this->command->info('Policies were seeded');
    }
}
