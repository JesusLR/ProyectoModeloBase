<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Curso;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use PDF;

class BachillerAlumnosFidelidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.alumnos_lealtad.create2', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir2(Request $request)
    {
        
        $cursos = Curso::select('cursos.*', 'planes.planClave',
        'programas.progClave', 'programas.progNombre',
        'escuelas.escClave',
        'escuelas.escNombre',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'periodos.perAnio',
        'periodos.perFechaInicial',
        'periodos.perFechaFinal',
        'alumnos.aluClave')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->where('cursos.periodo_id', $request->periodo_id)
        ->where('cgt.cgtGradoSemestre', '=', 6)
        ->where('planes.id', $request->plan_id)
        ->where('cursos.curEstado', '!=', 'B')
        ->where(static function ($query) use ($request) {

            if ($request->cgtGrupo != "") {
                $query->where('cgt.cgtGrupo', $request->cgtGrupo);
            }

            if ($request->aluClave != "") {
                $query->where('alumnos.aluClave', $request->aluClave);
            }

        })
        ->whereNull('cursos.deleted_at')
        ->orderBy('cgt.cgtGrupo', 'ASC')
        ->orderBy('personas.perApellido1', 'ASC')
        ->orderBy('personas.perApellido2', 'ASC')
        ->orderBy('personas.perNombre', 'ASC')
        ->get();

        if (count($cursos) < 1) {
            alert()->warning('Sin coincidencias', 'No se han encontrado alumnos con la información proporcionada')->showConfirmButton();
            return back()->withInput();
        }

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        $cicloEscolar = Utils::fecha_string($cursos[0]->perFechaInicial, $cursos[0]->perFechaInicial) . '-' . Utils::fecha_string($cursos[0]->perFechaFinal, $cursos[0]->perFechaFinal);

        $parametro_NombreArchivo = "pdf_alumnos_leales2";
        // view('reportes.pdf.bachiller.alumnos_leales.pdf_alumnos_leales')
        $pdf = PDF::loadView('reportes.pdf.bachiller.alumnos_leales.' . $parametro_NombreArchivo, [
            'fechaActual' => Utils::fecha_string($fechaActual, $fechaActual),
            'horaActual' => $fechaActual->format('H:i:s'),
            'cursos' => $cursos,
            'cicloEscolar' => $cicloEscolar
        ]);

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');

    }

    public function imprimir(Request $request) {

        $fechaActual = Carbon::now('CDT');
        $alert_title = 'Sin registros';
        $alert_text = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';
        
      

        $cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela'])
        ->whereHas('cgt.plan.programa.escuela', static function($query) use ($request) {
            $query->where('escuela_id', $request->escuela_id);
            if($request->programa_id) {
                $query->where('programa_id', $request->programa_id);
            }
            if($request->plan_id) {
                $query->where('plan_id', $request->plan_id);
            }
            $query->where('cgtGradoSemestre', 6);

            if($request->cgtGrupo) {
                $query->where('cgtGrupo', $request->cgtGrupo);
            }
        })
        ->whereHas('alumno.persona', static function($query) use ($request) {
            if($request->aluClave) {
                $query->where('aluClave', $request->aluClave);
            }
            if($request->perApellido1) {
                $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
            }
            if($request->perApellido2) {
                $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
            }
            if($request->perNombre) {
                $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
            }
        })
        ->where(static function($query) use ($request) {
            $query->where('periodo_id', $request->periodo_id);
            $query->where('curEstado', '<>', 'B');
            $query->whereNull('deleted_at');

            
        })->get();

        if($cursos->isEmpty()) {
            alert()->warning($alert_title, $alert_text)->showConfirmButton();
            return back()->withInput();
        }

        $periodo = $cursos->first()->periodo;
        $info = collect([
            'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
            'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
            'ubiClave' => $periodo->departamento->ubicacion->ubiClave,
            'ubiNombre' => $periodo->departamento->ubicacion->ubiNombre,
        ]);

        $datos = $cursos->map(function($curso, $key) {
            $persona = $curso->alumno->persona;
            $nombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
            $progClave = $curso->cgt->plan->programa->progClave;
            $grupo = $curso->cgt->cgtGrupo;
            $alumno_id = $curso->alumno->id;


            return collect([
                'progClave' => $progClave,
                'planClave' => $curso->cgt->plan->planClave,
                'progNombreCorto' => $curso->cgt->plan->programa->progNombreCorto,
                'grado' => $curso->cgt->cgtGradoSemestre,
                'grupo' => $grupo,
                'aluClave' => $curso->alumno->aluClave,
                'nombre' => $nombre,
                'curEstado' => $curso->curEstado,
                'orden' => $progClave.'-'.$grupo.'-'.$nombre,
                'alumno_id' => $alumno_id
            ]);
        })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');   
       

        $parametro_NombreArchivo = "pdf_alumnos_leales";
        // view('reportes.pdf.bachiller.alumnos_leales.pdf_alumnos_leales')
        $pdf = PDF::loadView('reportes.pdf.bachiller.alumnos_leales.' . $parametro_NombreArchivo, [
            "datos" => $datos,
            "info" => $info,
            "totalCursos" => $cursos->count(),
            "nombreArchivo" => $parametro_NombreArchivo,
            "curEstado" => $request->curEstado,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
        ]);

        $pdf->setPaper('letter', 'portrait');
        // $pdf->setPaper('letter', 'landscape');

        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }//imprimir.
}
