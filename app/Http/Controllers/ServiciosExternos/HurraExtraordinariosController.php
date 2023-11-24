<?php

namespace App\Http\Controllers\ServiciosExternos;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Historico;
use App\Models\Curso;

use RealRashid\SweetAlert\Facades\Alert;

class HurraExtraordinariosController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth', 'permisos:hurra_extraordinarios']);
    }

    public function reporte() {

        return view('hurra_extraordinarios.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function generar(Request $request) {
        if(!self::buscarExtraordinarios($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $planes = self::obtenerPlanesActivosEnPeriodo($request);
        $periodos = self::obtenerPeriodos($request);

        $file = fopen(storage_path('HurraExtraordinarios.csv'), 'w');
        $columns = [
            'periodo', 'anio', 'carrera', 'clave_ubi', 'cvePago', 'apepat', 'apemat', 'nombres', 'cvemateria', 'materia', 'califinal', 'extra1', 'extra2', 'extra3',
        ];
        $columns_string = implode(',', $columns);
        fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $columns_string) . "\r\n");

        self::buscarExtraordinarios($request)
        ->chunk(200, static function($registros) use ($file, $planes, $periodos) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($historico) use ($file, $planes, $periodos) {
                $info = implode(',', self::info_esencial($historico, $planes, $periodos));
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info) . "\r\n");
            });
        });
        fclose($file);

        return response()->download(storage_path('HurraExtraordinarios.csv'));
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarExtraordinarios($request) {
        $cursos_periodo = Curso::select('cursos.*', 'cgt.plan_id')
        ->join('cgt', 'cgt.id', 'cursos.cgt_id')
        ->whereHas('periodo.departamento', static function($query) use ($request) {
            $query->where('perNumero', $request->perNumero)
                ->where('perAnio', $request->perAnio)
                ->where('depClave', 'SUP');
            if($request->ubicacion_id)
                $query->where('ubicacion_id', $request->ubicacion_id);
        });

        return Historico::with(['alumno.persona', 'materia'])
        ->select('historico.*', 'cursos.plan_id AS cgt_plan_id', 'ordinarios.histCalificacion AS ordinario', 'extraordinarios2.histCalificacion AS extraordinario2', 'extraordinarios3.histCalificacion AS extraordinario3')
        ->joinSub($cursos_periodo, 'cursos', static function($join) {
            $join->on('cursos.alumno_id', 'historico.alumno_id')
                ->whereColumn('cursos.plan_id', 'historico.plan_id');
        })
        ->join('historico AS ordinarios', static function($join) {
            $join->on('ordinarios.alumno_id', 'historico.alumno_id')
                ->on('ordinarios.materia_id', 'historico.materia_id')
                ->where('ordinarios.histTipoAcreditacion', 'CI');
        })
        ->leftJoin('historico AS extraordinarios2', static function($join) {
            $join->on('extraordinarios2.alumno_id', 'historico.alumno_id')
                ->on('extraordinarios2.materia_id', 'historico.materia_id')
                ->where('extraordinarios2.histTipoAcreditacion', 'X2');
        })
        ->leftJoin('historico AS extraordinarios3', static function($join) {
            $join->on('extraordinarios3.alumno_id', 'historico.alumno_id')
                ->on('extraordinarios3.materia_id', 'historico.materia_id')
                ->where('extraordinarios3.histTipoAcreditacion', 'X3');
        })
        ->where('historico.histTipoAcreditacion', 'X1');
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerPlanesActivosEnPeriodo($request) {
        
        return Plan::with('programa.escuela.departamento.ubicacion')
        ->whereHas('cgts.periodo', static function($query) use ($request) {
            $query->where('perNumero', $request->perNumero)
                ->where('perAnio', $request->perAnio);
        })
        ->whereHas('programa.escuela.departamento', static function($query) use ($request) {
            $query->where('depClave', 'SUP');
            if($request->ubicacion_id)
                $query->where('ubicacion_id', $request->ubicacion_id);
        })
        ->get()
        ->map(static function($plan) {

            return [
                'plan_id' => $plan->id,
                'progClave' => $plan->programa->progClave,
                'ubiClave' => $plan->programa->escuela->departamento->ubicacion->ubiClave,
            ];
        })
        ->keyBy('plan_id');
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function obtenerPeriodos($request) {

        return Periodo::whereHas('departamento', static function($query) use ($request) {
            $query->where('depClave', 'SUP');
            if($request->ubicacion_id)
                $query->where('ubicacion_id', $request->ubicacion_id);
        })
        ->whereBetween('perAnio', [$request->perAnio - 9, $request->perAnio])
        ->get()
        ->map(static function($periodo) {

            return [
                'periodo_id' => $periodo->id,
                'perNumero' => $periodo->perNumero,
                'perAnio' => $periodo->perAnio,
            ];
        })
        ->keyBy('periodo_id');
    }

    /**
     * @param App\Models\Historico
     */
    private static function info_esencial($historico, $planes, $periodos): array {

        $plan = $planes->get($historico->plan_id);
        $periodo = $periodos->get($historico->periodo_id);
        $alumno = $historico->alumno;
        $persona = $alumno->persona;
        $materia = $historico->materia;

        return [
            'perNumero' => $periodo ? $periodo['perNumero'] : null,
            'perAnio' => $periodo ? $periodo['perAnio'] : null,
            'progClave' => $plan ? $plan['progClave'] : null,
            'ubiClave' => $plan ? $plan['ubiClave'] : null,
            'aluClave' => $alumno->aluClave,
            'perApellido1' => $persona->perApellido1,
            'perApellido2' => $persona->perApellido2,
            'perNombre' => $persona->perNombre,
            'matClave' => $materia->matClave, 
            'matNombre' => str_replace(',', '', $materia->matNombreOficial),
            'calificacionFinal' => $historico->ordinario,
            'extraordinario1' => $historico->histCalificacion,
            'extraordinario2' => $historico->extraordinario2,
            'extraordinario3' => $historico->extraordinario3,
        ];
    }
}
