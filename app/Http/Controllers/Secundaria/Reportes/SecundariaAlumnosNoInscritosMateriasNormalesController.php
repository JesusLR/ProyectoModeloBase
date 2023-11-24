<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ubicacion;
use App\Models\Curso;

use App\Http\Helpers\Utils;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class SecundariaAlumnosNoInscritosMateriasNormalesController extends Controller
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


        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.reportes.alumnos_no_inscritos.create', compact('alumnos_curso', 'ubicaciones'));
    }

    public function imprimir(Request $request)
    {
        $fechaActual = Carbon::now('CDT');
        $alert_title = 'Sin registros';
        $alert_text = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';

        $cursos = Curso::with(['alumno.persona', 'cgt.plan.programa.escuela'])
            ->whereHas('cgt.plan.programa.escuela', static function ($query) use ($request) {
                $query->where('escuela_id', $request->escuela_id);
                if ($request->programa_id) {
                    $query->where('programa_id', $request->programa_id);
                }
                if ($request->plan_id) {
                    $query->where('plan_id', $request->plan_id);
                }
                if ($request->cgtGradoSemestre) {
                    $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
                }
                if ($request->cgtGrupo) {
                    $query->where('cgtGrupo', $request->cgtGrupo);
                }
            })
            ->whereHas('alumno.persona', static function ($query) use ($request) {
                if ($request->aluClave) {
                    $query->where('aluClave', $request->aluClave);
                }
                if ($request->perApellido1) {
                    $query->where('perApellido1', 'like', '%' . $request->perApellido1 . '%');
                }
                if ($request->perApellido2) {
                    $query->where('perApellido2', 'like', '%' . $request->perApellido2 . '%');
                }
                if ($request->perNombre) {
                    $query->where('perNombre', 'like', '%' . $request->perNombre . '%');
                }
            })
            ->where(static function ($query) use ($request) {
                $query->where('periodo_id', $request->periodo_id);
                $query->where('curEstado', '<>', 'B');
                if ($request->curEstado) {
                    if ($request->curEstado == 'R+P') {
                        $query->whereIn('curEstado', ['R', 'P']);
                    } else {
                        $query->where('curEstado', $request->curEstado);
                    }
                }

                if ($request->curTipoIngreso) {
                    $query->where('curTipoIngreso', $request->curTipoIngreso);
                }
            })->get();

        if ($cursos->isEmpty()) {
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

        $datos = $cursos->map(function ($curso, $key) {
            $persona = $curso->alumno->persona;
            $nombre = $persona->perApellido1 . ' ' . $persona->perApellido2 . ' ' . $persona->perNombre;
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
                'orden' => $progClave . '-' . $grupo . '-' . $nombre,
                'periodo_id' => $curso->periodo_id,
                'curso_id' => $curso->id
            ]);
        })->sortBy('orden')->groupBy(['progClave', 'planClave', 'grado', 'grupo']);

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        $nombreArchivo = 'pdf_materia_faltante.pdf';

        $grupos_activos = DB::select("SELECT 
            secundaria_grupos.secundaria_materia_id,
            secundaria_grupos.gpoGrado,
            secundaria_materias.matClave
            FROM secundaria_grupos 
            INNER JOIN secundaria_materias ON secundaria_materias.id = secundaria_grupos.secundaria_materia_id
            WHERE secundaria_grupos.periodo_id=$request->periodo_id 
            AND secundaria_grupos.secundaria_materia_acd_id IS NULL
            AND secundaria_grupos.deleted_at IS NULL
            AND secundaria_materias.deleted_at IS NULL
            GROUP BY secundaria_grupos.secundaria_materia_id, secundaria_grupos.gpoGrado, secundaria_materias.matClave
            ORDER BY secundaria_materias.matClave ASC");

        // view('reportes.pdf.secundaria.alumnos_no_inscritos.pdf_materia_faltante');
        $pdf = PDF::loadView('reportes.pdf.secundaria.alumnos_no_inscritos.pdf_materia_faltante', [
            "datos" => $datos,
            "info" => $info,
            "totalCursos" => $cursos->count(),
            "nombreArchivo" => $nombreArchivo,
            "curEstado" => $request->curEstado,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "grupos_activos" => $grupos_activos
        ]);
        // $pdf->setPaper('letter', 'portrait');
        // $pdf->setPaper('letter', 'landscape');

        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
    } //imprimir.

}//Controller class.