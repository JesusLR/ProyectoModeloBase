<?php

use Illuminate\Database\Seeder;
use App\Models\Municipio;

class MunicipiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add municipio default
         *
         */
        Municipio::create([
            'estado_id'     => 1,
            'munNombre'  => 'MÉRIDA'
        ]);
    }
}