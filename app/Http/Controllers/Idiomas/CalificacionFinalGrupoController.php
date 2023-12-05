<?php

namespace App\Http\Controllers\Idiomas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Periodo;
use App\Models\Programa;
use App\Models\Plan;
use App\Models\Idiomas\Idiomas_cursos;
use App\Models\Idiomas\Idiomas_grupos;

use App\Http\Helpers\Utils;
use Carbon\Carbon;
use DB;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class CalificacionFinalGrupoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // set_time_limit(8000000);
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::where('id', '<>', 0)->get();

        return View('idiomas.calificacion_final_grupo.create',compact('ubicaciones'));
    }

    public function imprimir(Request $request) {
        $fechaActual = Carbon::now('CDT');
        $alert_title = 'Sin registros';
        $alert_text = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';

        $cursos = Idiomas_cursos::select(
            'perFechaInicial',
            'perFechaFinal',
            'ubiClave',
            'ubiNombre',
            'perApellido1',
            'perApellido2',
            'perNombre',
            'progClave',
            'planClave',
            'progNombreCorto',
            'gpoGrado',
            'gpoDescripcion',
            'gpoClave',
            'aluClave',
            'curEstado',
            'rcFinalScore'
        )
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('idiomas_resumen_calificaciones', 'idiomas_cursos.id', '=', 'idiomas_resumen_calificaciones.idiomas_curso_id')
        ->where('escuela_id', $request->escuela_id)
        ->where('periodos.id', $request->periodo_id)
        ->where('curEstado', '<>', 'B')
        ->whereNull('idiomas_resumen_calificaciones.deleted_at');

        $periodo = Periodo::where('id', $request->periodo_id)->first();
        $ubicacion = Ubicacion::where('id', $request->ubicacion_id)->first();
        $departamento = Departamento::where('id', $request->departamento_id)->first();
        $escuela = Escuela::where('id', $request->escuela_id)->first();

        $progClave = '';
        if($request->programa_id) {
            $programa = Programa::where('id', $request->programa_id)->first();
            $progClave = $programa->progClave;
        }
        $planClave = '';
        if($request->plan_id) {
            $plan = Plan::where('id', $request->plan_id)->first();
            $planClave = $plan->planClave;
        }
        $grado = '';
        if($request->cgtGradoSemestre) {
            $grupo1 = Idiomas_grupos::where('gpoGrado', $request->cgtGradoSemestre)->first();
            $grado = $grupo1->gpoGrado;
        }
        $grupo = '';
        if($request->cgtGrupo) {
            $grupo2 = Idiomas_grupos::where('gpoClave', $request->cgtGrupo)->first();
            $grupo = $grupo2->gpoClave;
        }
        $aluClave = $request->aluClave ? $request->aluClave : '';

        $result =  DB::select("CALL procPromediosPlanIdiomas(
            $periodo->perNumero, 
            $periodo->perAnio, 
            '$ubicacion->ubiClave', 
            '$departamento->depClave', 
            '$escuela->escClave', 
            '$progClave', 
            '$planClave', 
            '$grado', 
            '$grupo', 
            '$aluClave')");

        $result = collect($result);

        if($request->programa_id) {
            $cursos = $cursos->where('programa_id', $request->programa_id);
        }
        if($request->plan_id) {
            $cursos = $cursos->where('idiomas_grupos.plan_id', $request->plan_id);
        }
        if($request->cgtGradoSemestre) {
            $cursos = $cursos->where('gpoGrado', $request->cgtGradoSemestre);
        }
        if($request->cgtGrupo) {
            $cursos = $cursos->where('gpoClave', $request->cgtGrupo);
        }
        if($request->aluClave) {
            $cursos = $cursos->where('aluClave', $request->aluClave);
        }
        if($request->perApellido1) {
            $cursos = $cursos->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
        }
        if($request->perApellido2) {
            $cursos = $cursos->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
        }
        if($request->perNombre) {
            $cursos = $cursos->where('perNombre', 'like', '%'.$request->perNombre.'%');
        }
        $cursos = $cursos->get();
        if($cursos->isEmpty()) {
            alert()->warning($alert_title, $alert_text)->showConfirmButton();
            return back()->withInput();
        }

        $curso = $cursos[0];
        $info = collect([
            'perFechaInicial' => Utils::fecha_string($curso->perFechaInicial, 'mesCorto'),
            'perFechaFinal' => Utils::fecha_string($curso->perFechaFinal, 'mesCorto'),
            'ubiClave' => $curso->ubiClave,
            'ubiNombre' => $curso->ubiNombre,
        ]);

        $datos = $cursos->map(function($curso, $key) use ($result) {
            $nombre = $curso->perApellido1.' '.$curso->perApellido2.' '.$curso->perNombre;
            $result = $result->where('progClave', $curso->progClave)
            ->where('cgtGradoSemestre', $curso->gpoGrado)
            ->where('cgtGrupo', $curso->gpoClave)
            ->where('aluClave', $curso->aluClave)
            ->first();

            return collect([
                'progClave' => $curso->progClave,
                'planClave' => $curso->planClave,
                'progNombreCorto' => $curso->progNombreCorto,
                'grado' => $curso->gpoGrado.' '.$curso->gpoDescripcion,
                'grupo' => $curso->gpoClave,
                'aluClave' => $curso->aluClave,
                'nombre' => $nombre,
                'curEstado' => $curso->curEstado,
                'orden' => $curso->progClave.'-'.$curso->gpoClave.'-'.$nombre,
                'calificacion0' => $result->calificacion0,
                'calificacion1' => $result->calificacion1,
                'promedio01' => $result->promedio01,
                'calificacion2' => $result->calificacion2,
                'calificacion3' => $result->calificacion3,
                'promedio23' => $result->promedio23,
            ]);
        })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);
        
        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $nombreArchivo = 'pdf_calificacion_final_grupo.pdf';

        $pdf = PDF::loadView('idiomas.calificacion_final_grupo.pdf_calificacion_final_grupo', [
            "datos" => $datos,
            "info" => $info,
            "totalCursos" => $cursos->count(),
            "nombreArchivo" => $nombreArchivo,
            "curEstado" => $request->curEstado,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
        ]);
        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
    }//imprimir.

}//Controller class.