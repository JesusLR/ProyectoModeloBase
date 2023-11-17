<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Estado;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add estado default
         *
         */
        Estado::create([
            'pais_id'     => 1,
            'edoNombre'  => 'YUCATÁN',
            'edoAbrevia' => 'YUC'
        ]);
    }
}