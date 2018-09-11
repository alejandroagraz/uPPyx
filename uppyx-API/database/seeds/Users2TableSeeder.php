<?php

use Illuminate\Database\Seeder;

class Users2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insert factory data
        factory(App\User::class, 500)->create()->each(function($user) {
            $user->roleUsers()->save(factory(App\Models\RoleUser::class)->make(['user_id'=>$user->id]));
        });
    }
}
