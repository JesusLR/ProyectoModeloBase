<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Bachiller\Bachiller_inscritos_evidencias;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerADASFaltantesCalificarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $docentes = Bachiller_empleados::where('empEstado', '!=', 'B')
            ->orderBy('empApellido1', 'ASC')
            ->orderBy('empApellido2', 'ASC')
            ->orderBy('empNombre', 'ASC')
            ->get();

        return view('bachiller.reportes.ADAS_faltantes.create', [
            'ubicaciones' => $ubicaciones,
            'docentes' => $docentes
        ]);
    }

    public function imprimir(Request $request)
    {
 
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');

        $bachiller_inscritos_evidencias = Bachiller_inscritos_evidencias::select('bachiller_grupos.id')
            ->join('bachiller_inscritos', 'bachiller_inscritos_evidencias.bachiller_inscrito_id', '=', 'bachiller_inscritos.id')
            ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
            ->join('bachiller_evidencias', 'bachiller_inscritos_evidencias.evidencia_id', '=', 'bachiller_evidencias.id')
            ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')            
            ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
            ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('periodos.id', $request->periodo_id)
            ->where('planes.id', $request->plan_id)
            ->where(static function ($query) use ($request) {

                if ($request->gpoSemestre) {
                    $query->where('bachiller_grupos.gpoGrado', $request->gpoSemestre);
                }

                if ($request->gpoClave) {
                    $query->where('bachiller_grupos.gpoClave', $request->gpoClave);
                }

                if ($request->bachiller_empleado_id) {
                    $query->where('bachiller_empleados.id', $request->bachiller_empleado_id);
                }

            })
            ->where('bachiller_evidencias.eviFechaEntrega', '<=', $fechaActual->format('Y-m-d'))
            ->whereNull('bachiller_inscritos_evidencias.ievPuntos')
            ->whereNull('bachiller_inscritos.deleted_at')
            ->whereNull('bachiller_grupos.deleted_at')
            ->whereNull('bachiller_materias.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('bachiller_empleados.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->groupBy('bachiller_grupos.id')
            ->orderBy('bachiller_grupos.gpoGrado', 'ASC')
            ->orderBy('bachiller_grupos.gpoClave', 'ASC')
            ->orderBy('bachiller_materias.matNombre', 'ASC')
            ->get();

        if (count($bachiller_inscritos_evidencias) <= 0) {
            alert()->warning('Sin coincidencias', 'No hay evidencias sin calificar, tomando en cuenta las fechas de entreha a la fecha actual')->showConfirmButton();
            return back()->withInput();
        }


        

        $parametro_NombreArchivo = 'pdf_bachiller_adas_por_calificar';
        // view('reportes.pdf.bachiller.ADAS_faltantes.pdf_bachiller_adas_por_calificar')
        $pdf = PDF::loadView('reportes.pdf.bachiller.ADAS_faltantes.' . $parametro_NombreArchivo, [
            "bachiller_inscritos_evidencias" => $bachiller_inscritos_evidencias,
            "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), $fechaActual->format('Y-m-d')),
            "horaActual" => $fechaActual->format('H:i:s'),
            "vistaReporte" => $request->vistaReporte
        ]);

        // $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}
