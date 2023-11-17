<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Persona;

class PersonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add persona default
         *
         */
        Persona::create([
            'perNombre'     => 'ISMAEL',
            'perApellido1'  => 'PAREDES',
            'perApellido2'  => 'MORENO',
            'perCurp'       => 'PAMI870806HYNRRS07',
            'perFechaNac'   => '1987-08-06',
            'municipio_id'  => '1',
            'perSexo'       => 'M',
            'perDirCP'      => '97130',
            'perDirCalle'   => '1',
            'perDirNumExt'  => '359',
            'perDirColonia' => 'VISTA ALEGRE NORTE'
        ]);
    }
}