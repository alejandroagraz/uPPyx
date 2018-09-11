<?php

use App\User;
use App\Models\Role;
use App\Models\Country;
use Webpatser\Uuid\Uuid;
use App\Models\RoleUser;
use App\Models\RentalAgency;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $systemUsers = [
            0 => ['name' => 'Admin User', 'email' => 'admin@tera.com', 'rol' => 'super-admin', 'gender' => 'M'],
            1 => ['name' => 'Rental Admin', 'email' => 'rental@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            2 => ['name' => 'User', 'email' => 'user@tera.com', 'rol' => 'user', 'gender' => 'M'],
            3 => ['name' => 'Agent User', 'email' => 'agent@tera.com', 'rol' => 'agent', 'gender' => 'M'],
        ];
        $commonUsers = [
            4 => ['name' => 'Ailicec Gerente', 'email' => 'atovar_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'F'],
            5 => ['name' => 'Ailicec Agente Uno', 'email' => 'atovar_ag@tera.com', 'rol' => 'agent', 'gender' => 'F'],
            6 => ['name' => 'Ailicec Agente Dos', 'email' => 'atovar_ag1@tera.com', 'rol' => 'agent', 'gender' => 'F'],

            7 => ['name' => 'Oswaldo Gerente', 'email' => 'ogarcia_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            8 => ['name' => 'Oswaldo Agente Uno', 'email' => 'ogarcia_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            9 => ['name' => 'Oswaldo Agente Dos', 'email' => 'ogarcia_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            10 => ['name' => 'Victor Gerente', 'email' => 'vroldan_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            11 => ['name' => 'Victor Agente Uno', 'email' => 'vroldan_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            12 => ['name' => 'Victor Agente Dos', 'email' => 'vroldan_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            13 => ['name' => 'Salvador Gerente', 'email' => 'samartinez_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            14 => ['name' => 'Salvador Agente Uno', 'email' => 'samartinez_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            15 => ['name' => 'Salvador Agente Dos', 'email' => 'samartinez_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            16 => ['name' => 'Reinaldo Gerente', 'email' => 'rverdugo_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            17 => ['name' => 'Reinaldo Agente Uno', 'email' => 'rverdugo_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            18 => ['name' => 'Reinaldo Agente Dos', 'email' => 'rverdugo_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            19 => ['name' => 'Alejandro Gerente', 'email' => 'aolivar_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            20 => ['name' => 'Alejandro Agente Uno', 'email' => 'aolivar_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            21 => ['name' => 'Alejandro Agente Dos', 'email' => 'aolivar_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            22 => ['name' => 'Reysmer Gerente', 'email' => 'rvalle_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            23 => ['name' => 'Reysmer Agente Uno', 'email' => 'rvalle_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            24 => ['name' => 'Reysmer Agente Dos', 'email' => 'rvalle_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            25 => ['name' => 'Sergio Gerente', 'email' => 'scardenas_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            26 => ['name' => 'Sergio Agente Uno', 'email' => 'scardenas_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            27 => ['name' => 'Sergio Agente Dos', 'email' => 'scardenas_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            28 => ['name' => 'Javier Gerente', 'email' => 'jdiaz_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            29 => ['name' => 'Javier Agente Uno', 'email' => 'jdiaz_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            30 => ['name' => 'Javier Agente Dos', 'email' => 'jdiaz_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            31 => ['name' => 'Edgar Gerente', 'email' => 'erendon_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            32 => ['name' => 'Edgar Agente Uno', 'email' => 'erendon_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            33 => ['name' => 'Edgar Agente Dos', 'email' => 'erendon_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            34 => ['name' => 'Shirley Gerente', 'email' => 'sperez_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'F'],
            35 => ['name' => 'Shirley Agente Uno', 'email' => 'sperez_ag@tera.com', 'rol' => 'agent', 'gender' => 'F'],
            36 => ['name' => 'Shirley Agente Dos', 'email' => 'sperez_ag1@tera.com', 'rol' => 'agent', 'gender' => 'F'],

            37 => ['name' => 'Jhonny Gerente', 'email' => 'jsolarte_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            38 => ['name' => 'Jhonny Agente Uno', 'email' => 'jsolarte_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            39 => ['name' => 'Jhonny Agente Dos', 'email' => 'jsolarte_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            40 => ['name' => 'Paolo Gerente', 'email' => 'pguarisco_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            41 => ['name' => 'Paolo Agente Uno', 'email' => 'pguarisco_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            42 => ['name' => 'Paolo Agente Dos', 'email' => 'pguarisco_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            43 => ['name' => 'Brayam Gerente', 'email' => 'bmartinez_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'M'],
            44 => ['name' => 'Brayam Agente Uno', 'email' => 'bmartinez_ag@tera.com', 'rol' => 'agent', 'gender' => 'M'],
            45 => ['name' => 'Brayam Agente Dos', 'email' => 'bmartinez_ag1@tera.com', 'rol' => 'agent', 'gender' => 'M'],

            46 => ['name' => 'Genesis Gerente', 'email' => 'gfalcon_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'F'],
            47 => ['name' => 'Genesis Agente Uno', 'email' => 'gfalcon_ag@tera.com', 'rol' => 'agent', 'gender' => 'F'],
            48 => ['name' => 'Genesis Agente Dos', 'email' => 'gfalcon_ag1@tera.com', 'rol' => 'agent', 'gender' => 'F'],

            49 => ['name' => 'Andreine Gerente', 'email' => 'arincon_ge@tera.com', 'rol' => 'rent-admin', 'gender' => 'F'],
            50 => ['name' => 'Andreine Agente Uno', 'email' => 'arincon_ag@tera.com', 'rol' => 'agent', 'gender' => 'F'],
            51 => ['name' => 'Andreine Agente Dos', 'email' => 'arincon_ag1@tera.com', 'rol' => 'agent', 'gender' => 'F'],
        ];

        if (App::environment('local', 'dev', 'qa')) {
            $systemUsersCollection = collect($systemUsers);
            $userUnion = $systemUsersCollection->union($commonUsers);
            $systemUsers = $userUnion->toArray();
        } else {
            $systemUsers = $systemUsers;
        }
        $country = Country::whereId(1)->first();
        $rentalAgency = RentalAgency::whereId(1)->first();
        $countryName = (count($country) > 0) ? $country->name_en : null;
        $cityName = (count($country) > 0) ? $country->cities->first()->name : null;
        list($roles, $i) = [Role::all(), 0];
        foreach ($systemUsers as $systemUser) {
            $userExist = User::whereEmail($systemUser['email'])->first();
            if (count($userExist) <= 0) {
                list($user, $faker) = [new User(), \Faker\Factory::create()];
                $user->name = $systemUser['name'];
                $user->email = $systemUser['email'];
                $user->password = bcrypt('secret');
                $user->license_picture = $faker->imageUrl;
                $user->country = $countryName;
                $user->city = $cityName;
                $user->gender = 'M';
                $user->birth_of_date = $faker->date('Y-m-d', $max = '-30 years');
                $user->default_lang = 'en';
                $user->license_picture = $faker->imageUrl;
                $user->uuid = Uuid::generate(4)->string;
                $user->phone = $faker->e164PhoneNumber;
                $user->address = $faker->address;
                if (in_array($systemUser['rol'], ['rent-admin', 'agent'])) {
                    $user->rental_agency_id = (count($rentalAgency) > 0) ? $rentalAgency->id : null;
                }
                $user->status = 1;
                if ($user->save()) {
                    $rol = $roles->filter(function ($rol) use ($systemUser) {
                        if ($rol->name == $systemUser['rol']) {
                            return true;
                        }
                    })->first();
                    if (count($rol) > 0) {
                        $roleUser = new RoleUser();
                        $roleUser->user_id = $user->id;
                        $roleUser->role_id = $rol->id;
                        $roleUser->save();
                    }
                    $i++;
                }
            }
        }
        $this->command->info($i . ' User(s) were seeded');
    }
}
