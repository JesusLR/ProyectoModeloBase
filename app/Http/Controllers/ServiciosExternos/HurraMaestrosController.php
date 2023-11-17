<?php

namespace App\Http\Controllers\ServiciosExternos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Empleado;

use RealRashid\SweetAlert\Facades\Alert;

class HurraMaestrosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:servicios_externos', 'permisos:hurra_maestros']);
    }

    public function reporte() 
    {
        return view('hurra_maestros.create');
    }

    public function generar(Request $request) {

        if(!self::buscarEmpleados()->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $file = fopen(storage_path('HurraMaestros.csv'), 'w');
        $columns = [
            'clave', 'password', 'nombre', 'apellido_paterno', 'apellido_materno', 'sexo', 
            'fecha_nac', 'telefono', 'email', 'num_cred', 'escuela'
        ];
        $columns_string = implode(',', $columns);
        fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $columns_string) . "\r\n");

        self::buscarEmpleados()
        ->chunk(200, static function($registros) use ($file) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($empleado) use ($file) {
                $info = implode(',', self::info_esencial($empleado));
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info) . "\r\n");
            });
        });
        fclose($file);

        return response()->download(storage_path('HurraMaestros.csv'));
    }

    private static function buscarEmpleados() 
    {
        return Empleado::with('persona')->activos()
        ->where('id', '>', 1);
    }

    /**
     * @param App\Http\Models\Empleado
     */
    private static function info_esencial($empleado): array 
    {
        $persona = $empleado->persona;
        $escuela = $empleado->escuela;
        return [
            'clave' => $empleado->id,
            'password' => $persona->perApellido1,
            'nombre' => $persona->perNombre,
            'perApellido1' => $persona->perApellido1,
            'perApellido2' => $persona->perApellido2,
            'sexo' => $persona->perSexo,
            'perFechaNac' => $persona->perFechaNac,
            'telefono' => str_replace(',', '', $persona->perTelefono1),
            'email' => str_replace(',', '', $persona->perCorreo1.' - '.$empleado->empCorreo1),
            // 'perCorreo' => str_replace(',', '', $persona->perCorreo1),
            // 'empCorreo' => str_replace(',', '', $empleado->empCorreo1),
            'empCredencial' => $empleado->empCredencial,
            'escNombre' => $escuela->escNombre
        ];
    }
}
