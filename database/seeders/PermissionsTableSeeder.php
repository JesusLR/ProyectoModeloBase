<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
         * Add Permissions
         *
         */
        if (Permission::where('name', '=', 'A')->first() === null) {
            Permission::create([
                'name'        => 'A',
                'slug'        => 'super',
                'description' => 'Administrador del sistema',
            ]);
        }

        if (Permission::where('name', '=', 'B')->first() === null) {
            Permission::create([
                'name'        => 'B',
                'slug'        => 'master',
                'description' => 'Administrador del datos',
            ]);
        }

        if (Permission::where('name', '=', 'C')->first() === null) {
            Permission::create([
                'name'        => 'C',
                'slug'        => 'admin',
                'description' => 'Coordinadores y Directores',
            ]);
        }

        if (Permission::where('name', '=', 'D')->first() === null) {
            Permission::create([
                'name'        => 'D',
                'slug'        => 'user',
                'description' => 'Consultas',
            ]);
        }
    }
}
