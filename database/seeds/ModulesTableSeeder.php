<?php

use Illuminate\Database\Seeder;
use App\Models\Modules;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
         * Add Modules
         *
         */
        Modules::create([
            'name'        => 'Usuarios',
            'slug'        => 'usuario',
            'class' => 'Administración',
        ]);
        Modules::create([
            'name'        => 'Campus',
            'slug'        => 'ubicacion',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Departamentos',
            'slug'        => 'departamento',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Escuelas',
            'slug'        => 'escuela',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Programas',
            'slug'        => 'programa',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Planes',
            'slug'        => 'plan',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Periodos',
            'slug'        => 'periodo',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Acuerdos',
            'slug'        => 'acuerdo',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Materias',
            'slug'        => 'materia',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Optativas',
            'slug'        => 'optativa',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Aulas',
            'slug'        => 'aula',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Paises',
            'slug'        => 'pais',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Estados',
            'slug'        => 'estado',
            'class' => 'Catálogos',
        ]);
        Modules::create([
            'name'        => 'Municipios',
            'slug'        => 'municipio',
            'class' => 'Catálogos',
        ]);

        Modules::create([
            'name'        => 'Empleados',
            'slug'        => 'empleado',
            'class' => 'Control-Escolar',
        ]);
        Modules::create([
            'name'        => 'Alumnos',
            'slug'        => 'alumno',
            'class' => 'Control-Escolar',
        ]);
        Modules::create([
            'name'        => 'Alumnos',
            'slug'        => 'alumnos',
            'class' => 'Control-Escolar',
        ]);
        Modules::create([
            'name'        => 'CGTS',
            'slug'        => 'cgt',
            'class' => 'Control-Escolar',
        ]);
        Modules::create([
            'name'        => 'Grupos',
            'slug'        => 'grupo',
            'class' => 'Control-Escolar',
        ]);
        Modules::create([
            'name'        => 'Paquetes',
            'slug'        => 'paquete',
            'class' => 'Control-Escolar',
        ]);
        Modules::create([
            'name'        => 'Preinscritos',
            'slug'        => 'curso',
            'class' => 'Control-Escolar',
        ]);
        Modules::create([
            'name'        => 'Inscritos',
            'slug'        => 'inscrito',
            'class' => 'Control-Escolar',
        ]);

    }
}
