<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Curso;

use App\Http\Helpers\Utils;
use Carbon\Carbon;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerAsistenciaGrupoController extends Controller
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

        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

        return view('bachiller.reportes.asistencia_grupo.create',compact('tiposIngreso', 'alumnos_curso', 'ubicaciones'));
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
            if($request->cgtGradoSemestre) {
                $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
            }
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
            if($request->curEstado) {
                if($request->curEstado == 'R+P') {
                    $query->whereIn('curEstado', ['R', 'P']);
                } else {
                    $query->where('curEstado', $request->curEstado);
                }
            }

            if($request->curTipoIngreso) {
                $query->where('curTipoIngreso', $request->curTipoIngreso);
            }
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

            return collect([
                'progClave' => $progClave,
                'planClave' => $curso->cgt->plan->planClave,
                'progNombreCorto' => $curso->cgt->plan->programa->progNombreCorto,
                'grado' => $curso->cgt->cgtGradoSemestre,
                'grupo' => $grupo,
                'aluClave' => $curso->alumno->aluClave,
                'nombre' => $nombre,
                'curEstado' => $curso->curEstado,
                'orden' => $progClave.'-'.$grupo.'-'.$nombre
            ]);
        })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $nombreArchivo = 'pdf_asistencia_grupo.pdf';

        // view('reportes.pdf.bachiller.lista_de_asistencia.pdf_asistencia_grupo');
        $pdf = PDF::loadView('reportes.pdf.bachiller.lista_de_asistencia.pdf_asistencia_grupo', [
            "datos" => $datos,
            "info" => $info,
            "totalCursos" => $cursos->count(),
            "nombreArchivo" => $nombreArchivo,
            "curEstado" => $request->curEstado,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
        ]);
        // $pdf->setPaper('letter', 'portrait');
        $pdf->setPaper('letter', 'landscape');

        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
    }//imprimir.

}//Controller class.