<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add user default
         *
         */
        User::create([
            'empleado_id'                    => 1,
            'username'                       => 'ISMAEL',
            'password'                       => Hash::make('12345678'),
            'token'                          => str_random(64),
        ]);
    }
}
