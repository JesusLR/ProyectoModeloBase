<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_resumenacademico;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Ubicacion;
use App\Models\Escuela;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class BachillerRelacionExtraordinarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.relacion_extraordinarios.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '1024M');

        $ubi = Ubicacion::select('ubiClave')->where('id', $request->ubicacion_id)->first();
        $dep = Departamento::select('depCalMinAprob', 'depClave')->where('id', $request->departamento_id)->first();
        $esc = Escuela::select('escClave')->where('id', $request->escuela_id)->first();
        $plan = Plan::select('planClave', 'planNumCreditos')->where('id', $request->plan_id)->first();
        $prog = Programa::select('progNombre', 'progClave')->where('id', $request->programa_id)->first();
        $per = Periodo::select('perNumero', 'perAnio', 'perFechaInicial', 'perFechaFinal')->where('id', $request->periodo_id)->first();

        $grado = $request->cgtGradoSemestre ? $request->cgtGradoSemestre: 'null';
        $aluClave = $request->aluClave ? $request->aluClave: 'null';

        // CAMBIAR de NOMBRE con el NIVEL
        $result =  DB::select("call procBachillerRelacionExtras ('"
        .$per->perNumero."','" // número de periodo
        .$per->perAnio."','" // año de periodo
        .$ubi->ubiClave."','" // clave de ubicación
        .$dep->depClave."','" // clave departamento
        .$esc->escClave."','" // clave escuela
        .$prog->progClave."','" // clave programa
        .$plan->planClave."'," // clave del plan
        .$grado.",'" // semestre (opcional)
        .$request->cgtGrupo."'," // grupo (opcional)
        .$aluClave.",'" // clave del alumno (opcional)
        .$request->curEstado."','" // bajas
        .$request->cualesIncluir."','" // deudores
        .$request->numeroExtraordinarios // minimo
        ."')");

        if(count($result) < 1){
            alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $fechaActual = Carbon::now('CDT');

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $nombreArchivo = 'relacion_extraordinario.pdf';

        $array = [];
        foreach ($result as $value) {
            $array[$value->alumno_id] = (object) [
                'clavePago' => $value->clavePago,
                'apellido1' => $value->apellido1,
                'apellido2' => $value->apellido2,
                'nombre'    => $value->nombre,
                'grupo'     => $value->grupo,
                'semestre'  => $value->semestre,
            ];
        }

        $pdf = PDF::loadView('reportes.pdf.bachiller.relacion_extraordinario.relacion_extradorinario', [
            "alumnos" =>  $array,
            'historico' => $result,
            "nombreArchivo" => $nombreArchivo,
            "curEstado" => $request->curEstado,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cualesIncluir" => $request->cualesIncluir,
            "curEstado" => $request->curEstado,
            "numeroExtraordinarios" => $request->numeroExtraordinarios,
            "depClave" => $dep->depClave,
            "planClave" => $plan->planClave,
            "progNombre" => $prog->progNombre,
            "perFechaInicial" => Utils::fecha_string($per->perFechaInicial, 'mesCorto'),
            "perFechaFinal" => Utils::fecha_string($per->perFechaFinal, 'mesCorto'),
            'depCalMinAprob' => $dep->depCalMinAprob
        ]);
        $pdf->setPaper('letter', 'portrait');

        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
    }

    public function imprimir2(Request $request)
    {
        // dd($request->periodo_id, $request->plan_id);

        $bachiller_historico = Bachiller_historico::select(
            'bachiller_historico.alumno_id',
            'bachiller_historico.plan_id',
            'bachiller_historico.bachiller_materia_id',
            'bachiller_historico.periodo_id',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histFolio',
            'bachiller_historico.hisActa',
            'bachiller_historico.histLibro',
            'alumnos.aluClave',
            'planes.planClave',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'programas.progNombre'
        )
        ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
        ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
        ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->where('bachiller_historico.periodo_id', '=', $request->periodo_id)
        ->where('bachiller_historico.plan_id', '=', $request->plan_id)
        ->where('bachiller_historico.histCalificacion', '<', 70)
        ->where('bachiller_historico.histPeriodoAcreditacion', '=', 'PN')
        ->where('bachiller_historico.histTipoAcreditacion', '=', 'CI')
        // ->where('alumnos.aluEstado', '<>', 'B')
        ->where(static function($query) use ($request) {


            if($request->cgtGradoSemestre) {
                $query->where('bachiller_materias.matSemestre', '=', $request->cgtGradoSemestre);
            }

            // if($request->cgtGrupo) {
            //     $query->where('bachiller_materias.matSemestre', '=', $request->cgtGrupo);
            // }

            if($request->aluClave) {
                $query->where('alumnos.aluClave', '=', $request->aluClave);
            }


        })
        ->whereNull('alumnos.deleted_at')
        ->whereNull('planes.deleted_at')
        ->whereNull('bachiller_materias.deleted_at')
        ->whereNull('periodos.deleted_at')
        ->whereNull('personas.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->whereNull('ubicacion.deleted_at')
        ->get();

        if(count($bachiller_historico) < 1){
            alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $fechaActual = Carbon::now('CDT');

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $nombreArchivo = 'relacion_extraordinario.pdf';

        // view('reportes.pdf.bachiller.relacion_extraordinario.relacion_extradorinario');
        $pdf = PDF::loadView('reportes.pdf.bachiller.relacion_extraordinario.relacion_extradorinario', [
            "bachiller_historico" => $bachiller_historico,
            "alumnos" => $bachiller_historico->groupBy('aluClave'),
            "nombreArchivo" => $nombreArchivo,
            "curEstado" => $request->curEstado,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cualesIncluir" => $request->cualesIncluir,
            "curEstado" => $request->curEstado,
            "numeroExtraordinarios" => $request->numeroExtraordinarios,
            "depClave" => $bachiller_historico[0]->depClave,
            "planClave" => $bachiller_historico[0]->planClave,
            "progNombre" => $bachiller_historico[0]->progNombre,
            "perFechaInicial" => Utils::fecha_string($bachiller_historico[0]->perFechaInicial, 'mesCorto'),
            "perFechaFinal" => Utils::fecha_string($bachiller_historico[0]->perFechaFinal, 'mesCorto')
        ]);
        $pdf->setPaper('letter', 'portrait');
        // $pdf->setPaper('letter', 'landscape');

        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
    }
}
