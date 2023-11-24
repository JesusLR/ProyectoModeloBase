<?php

use Illuminate\Database\Seeder;
use App\Models\Pais;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add pais default
         *
         */
        Pais::create([
            'paisNombre'    => 'MÉXICO',
            'paisAbrevia'   => 'MEX'
        ]);
    }
}