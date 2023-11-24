<?php

use Illuminate\Database\Seeder;
use App\Models\Empleado;

class EmpleadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add empleado default
         *
         */
        Empleado::create([
            'persona_id'    => 1
        ]);
    }
}