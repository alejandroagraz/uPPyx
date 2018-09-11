<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'super-admin',
                'display_name' => 'Admin uPPyx',
                'description' => 'Test Super Admin',
            ],
            [
                'id' => 2,
                'name' => 'rent-admin',
                'display_name' => 'Gerente',
                'description' => 'Test Rent a Car Admin'
            ],
            [
                'id' => 3,
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Test User'
            ],
            [
                'id' => 4,
                'name' => 'agent',
                'display_name' => 'Rental Agent',
                'description' => 'Test Rental Agent'
            ]
        ];
        list($roles, $i) = [Role::all(), 0];
        foreach ($data as $row) {
            $role = $roles->filter(function ($object) use ($row) {
                if ($object->name == $row['name']) return true;
            })->first();
            if (count($role) <= 0) {
                DB::table('roles')->insert($row);
                $i++;
            }
        }
        $this->command->info($i . ' Rol(es) were seeded');
    }
}