<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
use Debugbar;

use App\Models\Permission;
use App\Models\Modules;
use App\Models\Permission_module_user;

class PermisoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();
        Permission::create([
            'name'        => 'A',
            'slug'        => 'super',
            'description' => 'Administrador del sistema',
        ]);

        Permission::create([
            'name'        => 'B',
            'slug'        => 'master',
            'description' => 'Administrador del datos',
        ]);

        Permission::create([
            'name'        => 'C',
            'slug'        => 'admin',
            'description' => 'Coordinadores y Directores',
        ]);

        Permission::create([
            'name'        => 'D',
            'slug'        => 'user',
            'description' => 'Consultas',
        ]);
        Permission::create([
            'name'        => 'E',
            'slug'        => 'especial',
            'description' => 'Especial',
        ]);
        Permission::create([
            'name'        => 'P',
            'slug'        => 'pagos',
            'description' => 'Pagos',
        ]);

        alert('Escuela Modelo', 'Permisos creados correctamente','success')->showConfirmButton()->autoClose(3000);
        return redirect('usuario');
    }

    public function modulos()
    {
        $permisos = Permission_module_user::get()->groupBy("user_id");
        $modules = Modules::get()->pluck("id")->all();


        foreach ($permisos as $userId => $permiso) {
            $permisoIds = $permiso->pluck("module_id")->all();
            $permisoIds = array_map('intval', $permisoIds);


            $modulosFaltantes = array_diff($modules, $permisoIds);


            if (count($modulosFaltantes) > 0) {
                foreach ($modulosFaltantes as $modulo) {
                    echo 'Modulo faltante' . $modulo . ' UsuarioId ' . $userId . "<br>";

                    Permission_module_user::create([
                        'permission_id' => 4,
                        'module_id' => $modulo,
                        'user_id'    => $userId
                    ]);
                }

            } else  {
                echo 'No hay modulos faltantes para usuario ' . $userId . "<br>";
            }
        }





        


        //$permisos = Permission_module_user::where('user_id',2)->get();
        // Schema::disableForeignKeyConstraints();
        // Permission_module_user::truncate();
        // Schema::enableForeignKeyConstraints();

        // echo '<a href="/usuario"><button>Regresar a usuarios</button></a> <br>';

        // $modules = Modules::get();
        // foreach($modules as $module){
        //     Permission_module_user::create([
        //         'permission_id' => 1,
        //         'module_id' => $module->id,
        //         'user_id'    => 1
        //     ]);

        //     echo "Usuario 1 ahora tiene permisos para módulo " . $module->name . "<br>";
        // }
    }

}