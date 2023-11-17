<?php

namespace App\Http\Controllers\Idiomas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use App\Http\Models\Calificacion;

use App\Http\Models\Idiomas\Idiomas_grupos;
use App\Http\Models\Idiomas\Idiomas_calificaciones_materia;

use App\Http\Models\Ubicacion;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class BoletaCalificacionesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        set_time_limit(8000000);
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::sedes()->get();
        return View('idiomas.boleta_calificaciones.create',compact('ubicaciones'));
    }

    public function imprimir(Request $request)
    {
        if(!Auth::check()) {
            return redirect('login');
        }

        $query = Idiomas_grupos::select(
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.id',
            'programas.progClave',
            'programas.progNombre',
            'planes.id',
            'planes.planClave',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'idiomas_resumen_calificaciones.id as idiomas_resumen_calificaciones',
            'idiomas_resumen_calificaciones.rcReporte1',
            'idiomas_resumen_calificaciones.rcReporte1Ponderado',
            'idiomas_resumen_calificaciones.rcReporte2',
            'idiomas_resumen_calificaciones.rcReporte2Ponderado',
            'idiomas_resumen_calificaciones.rcMidTerm',
            'idiomas_resumen_calificaciones.rcProject1',
            'idiomas_resumen_calificaciones.rcReporte3',
            'idiomas_resumen_calificaciones.rcReporte3Ponderado',
            'idiomas_resumen_calificaciones.rcReporte4',
            'idiomas_resumen_calificaciones.rcReporte4Ponderado',
            'idiomas_resumen_calificaciones.rcFinalExam',
            'idiomas_resumen_calificaciones.rcProject2',
            'idiomas_resumen_calificaciones.rcFinalScore',
            'idiomas_empleados.id AS empleado_id',
            'idiomas_empleados.empNombre',
            'idiomas_empleados.empApellido1',
            'idiomas_empleados.empApellido2',
            'idiomas_grupos.id as grupo_id',
            'idiomas_grupos.*'
        )
        ->join('periodos', 'idiomas_grupos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('idiomas_cursos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('idiomas_resumen_calificaciones', 'idiomas_resumen_calificaciones.idiomas_curso_id', '=', 'idiomas_cursos.id')
        ->join('idiomas_empleados', 'idiomas_grupos.idiomas_empleado_id', '=', 'idiomas_empleados.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
        ->where('idiomas_cursos.curEstado', '!=', 'B')
        ->where('periodos.id', $request->periodo_id)
        ->where('programas.id', $request->programa_id)
        ->where('planes.id', $request->plan_id)
        ->where('idiomas_grupos.gpoGrado', $request->gpoSemestre)
        ->where('idiomas_grupos.gpoClave', $request->gpoClave)
        ->whereNull('idiomas_cursos.deleted_at')
        ->whereNull('idiomas_resumen_calificaciones.deleted_at')
        ->orderBy('personas.perApellido1', 'asc')
        ->orderBy('personas.perApellido2', 'asc')
        ->orderBy('personas.perNombre', 'asc');
      
        if($request->aluClave)
            $query->where('alumnos.aluClave', $request->aluClave);
        if($request->perApellido1)
            $query->where('personas.perApellido1', $request->perApellido1);
        if ($request->perApellido2)
            $query->where('personas.perApellido2', $request->perApellido2);
        if ($request->perNombre)
            $query->where('personas.perNombre', $request->perNombre);
        $calificaciones = $query->get();

        if($calificaciones->isEmpty()) {
            alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
            return back()->withInput();
        }

        $datos = collect();
        $fechaActual = Carbon::now('America/Merida');

        //variables que se mandan a la vista fuera del array
        $registro1 = $calificaciones->first();
        $programa = $registro1->progClave;
        $ubicacion = $registro1->ubiClave;

        $periodo = Utils::fecha_string($registro1->perFechaInicial, 'mesCorto').' - '
            .Utils::fecha_string($registro1->perFechaFinal, 'mesCorto');

        $calificaciones->each(static function($alumno) use ($datos) {

            $datos->push([
                'alumno_id' => $alumno->id,
                'aluClave' => $alumno->aluClave,
                'nombreCompleto' => $alumno->perApellido1.' '.$alumno->perApellido2.' '.$alumno->perNombre,
                'nombreCompletoProf' => $alumno->empApellido1.' '.$alumno->empApellido2.' '.$alumno->empNombre,
                'calificaciones' => self::mapear_calificaciones($alumno),
                'gpoGrado' => $alumno->gpoGrado,
                'gpoClave' => $alumno->gpoClave,
                'rcReporte1' => $alumno->rcReporte1,
                'rcReporte1Ponderado' => $alumno->rcReporte1Ponderado,
                'rcReporte2' => $alumno->rcReporte2,
                'rcReporte2Ponderado' => $alumno->rcReporte2Ponderado,
                'rcMidTerm' => $alumno->rcMidTerm,
                'rcProject1' => $alumno->rcProject1,
                'rcReporte3' => $alumno->rcReporte3,
                'rcReporte3Ponderado' => $alumno->rcReporte3Ponderado,
                'rcReporte4' => $alumno->rcReporte4,
                'rcReporte4Ponderado' => $alumno->rcReporte4Ponderado,
                'rcFinalExam' => $alumno->rcFinalExam,
                'rcProject2' => $alumno->rcProject2,
                'rcFinalScore' => $alumno->rcFinalScore,
            ]);
        });

        $nombreArchivo = 'pdf_boleta_calificaciones';
            return PDF::loadView('idiomas.boleta_calificaciones.'. $nombreArchivo, [
            "datos" => $datos->sortBy('nombreCompleto'),
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo.'.pdf',
            "programa" => $registro1,
            "periodo" => $periodo,
            "ubicacion" => $registro1,
        ])->stream($nombreArchivo.'.pdf');

    }# imprimir

    /**
     * @param Collection
    */
    private static function mapear_calificaciones($alumno)
    {
        return Idiomas_calificaciones_materia::select(
            'matClave',
            'matNombre',
            'cmReporte1',
            'cmReporte2',
            'cmReporte3',
            'cmReporte4'
          )
          ->join('idiomas_materias', 'idiomas_calificaciones_materia.idiomas_materia_id', '=', 'idiomas_materias.id')
          ->where('idiomas_resumen_calificaciones_id', $alumno->idiomas_resumen_calificaciones)->get();
    }
}