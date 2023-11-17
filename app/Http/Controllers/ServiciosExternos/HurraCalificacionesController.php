<?php

namespace App\Http\Controllers\ServiciosExternos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Models\MotivosFalta;

use RealRashid\SweetAlert\Facades\Alert;

class HurraCalificacionesController extends Controller
{
    protected static $motivosFalta;

    public function __construct()
    {
        $this->middleware(['auth', 'permisos:servicios_externos', 'permisos:hurra_calificaciones']);
        self::$motivosFalta = MotivosFalta::get()->keyBy('id');
    }

    public function reporte() 
    {
        return view('hurra_calificaciones.create');
    }

    public function generar(Request $request) 
    {
        if(!self::buscarCalificaciones($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $file = fopen(storage_path('HurraCalificaciones.csv'), 'w');
        $columns = [
            'periodo', 'anio', 'cvecarrera', 'grupo', 'clave_ubi', 'cvepago', 'apepat', 'apemat',
            'nombres', 'cvemateria', 'materia', 'sem_carr_mat', 'parcial1', 'parcial2', 'parcial3', 'promedio', 'ordinario', 'califinal',
        ];
        $columns_string = implode(',', $columns);
        fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $columns_string) . "\r\n");

        self::buscarCalificaciones($request)
        ->chunk(200, static function($registros) use ($file) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($calificacion) use ($file) {
                $info = implode(',', self::info_esencial($calificacion));
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info) . "\r\n");
            });
        });
        fclose($file);
        DB::statement('DROP TEMPORARY TABLE `_temp_hurra_calificaciones`');

        return response()->download(storage_path('HurraCalificaciones.csv'));
    }

    private static function buscarCalificaciones($request) {

        DB::select("call procHurraCalificaciones(
            '', '',
            {$request->perNumero},
            {$request->perAnio},
            'ARQ', 'AXX', ''
        )");

        return DB::table('_temp_hurra_calificaciones')->orderBy('id');
    }

    /**
     * @param App\Http\Models\Calificacion
     */
    private static function info_esencial($calificacion): array {
        $motivo = $calificacion->motivofalta_id ? self::$motivosFalta->get($calificacion->motivofalta_id) : null;

        return [
            'perNumero' => $calificacion->perNumero,
            'perAnio' => $calificacion->perAnio,
            'progClave' => $calificacion->progClave,
            'gpoClave' => $calificacion->gpoClave,
            'ubiClave' => $calificacion->ubiClave,
            'aluClave' => $calificacion->aluClave,
            'perApellido1' => $calificacion->perApellido1,
            'perApellido2' => $calificacion->perApellido2,
            'perNombre' => $calificacion->perNombre,
            'matClave' => $calificacion->matClave,
            'matNombre' => str_replace(',', '', $calificacion->matNombre),
            'gpoSemestre' => $calificacion->gpoSemestre,
            'parcial1' => $calificacion->inscCalificacionParcial1,
            'parcial2' => $calificacion->inscCalificacionParcial2,
            'parcial3' => $calificacion->inscCalificacionParcial3,
            'promedio' => $calificacion->inscPromedioParciales,
            'ordinario' => $motivo && $motivo->id != 10 ? $motivo->mfAbreviatura : $calificacion->inscCalificacionOrdinario,
            'califinal' => $motivo && $motivo->id != 10 ? $motivo->mfAbreviatura : $calificacion->incsCalificacionFinal,
        ];
    }
}
