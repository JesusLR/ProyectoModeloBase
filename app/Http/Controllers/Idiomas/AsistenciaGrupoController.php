<?php

namespace App\Http\Controllers\Idiomas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Curso;
use App\Models\Idiomas\Idiomas_cursos;

use App\Http\Helpers\Utils;
use Carbon\Carbon;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class AsistenciaGrupoController extends Controller
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
        $tiposIngreso = [
            'NI' => 'NUEVO INGRESO',
            'PI' => 'PRIMER INGRESO',
            'RO' => 'REPETIDOR',
            'RI' => 'REINSCRIPCIÓN',
            'RE' => 'REINGRESO',
            'EQ' => 'REVALIDACIÓN',
            'OY' => 'OYENTE',
            'XX' => 'OTRO',
        ];

        $alumnos_curso = [
            'P'   => 'PREINSCRITOS',
            'R'   => 'INSCRITOS',
            'C'   => 'CONDICIONADO',
            'A'   => 'CONDICIONADO 2',
            'R+P' => 'SALON',
            ''    => 'TODOS',
        ];

        $ubicaciones = Ubicacion::where('id', '<>', 0)->get();

        return View('idiomas/asistencia_grupo.create',compact('tiposIngreso', 'alumnos_curso', 'ubicaciones'));
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
            'curEstado'
        )
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        // ->join('idiomas_niveles', 'idiomas_grupos.plan_id', '=', 'idiomas_niveles.plan_id')
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('escuela_id', $request->escuela_id)
        ->where('periodos.id', $request->periodo_id)
        ->where('curEstado', '<>', 'B');

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

        $datos = $cursos->map(function($curso, $key) {
            $nombre = $curso->perApellido1.' '.$curso->perApellido2.' '.$curso->perNombre;

            return collect([
                'progClave' => $curso->progClave,
                'planClave' => $curso->planClave,
                'progNombreCorto' => $curso->progNombreCorto,
                'grado' => $curso->gpoGrado.' '.$curso->gpoDescripcion,
                'grupo' => $curso->gpoClave,
                'aluClave' => $curso->aluClave,
                'nombre' => $nombre,
                'curEstado' => $curso->curEstado,
                'orden' => $curso->progClave.'-'.$curso->gpoClave.'-'.$nombre
            ]);
        })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);
        
        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $nombreArchivo = 'pdf_asistencia_grupo.pdf';

        $pdf = PDF::loadView('reportes.pdf.pdf_asistencia_grupo', [
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