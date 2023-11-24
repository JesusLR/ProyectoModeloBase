<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_inscritos_evidencias;
use App\Models\Periodo;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerEvidenciasFaltantesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.evidencias_faltantes.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function getMateriasVigentes(Request $request, $periodo_id, $plan_id, $semestre = null)
    {
      if($request->ajax()){

        if($semestre == null){
            
            $semestres = DB::select("SELECT cgtGradoSemestre FROM cgt 
            WHERE periodo_id=$periodo_id 
            AND plan_id=$plan_id 
            AND deleted_at IS NULL
            GROUP BY cgtGradoSemestre");
    
            $uno = $semestres[0]->cgtGradoSemestre;
            $dos = $semestres[1]->cgtGradoSemestre;
            $tres = $semestres[2]->cgtGradoSemestre;

            $gruposMaterias = DB::select("SELECT matClave, matNombre, matSemestre 
            FROM bachiller_materias WHERE plan_id=$plan_id 
            AND matVigentePlanPeriodoActual='SI'
            AND matSemestre IN($uno, $dos, $tres)
            GROUP BY matClave, matNombre, matSemestre
            ORDER BY matSemestre, matClave");

        }else{            

            $gruposMaterias = DB::select("SELECT matClave, matNombre, matSemestre 
            FROM bachiller_materias WHERE plan_id=$plan_id 
            AND matVigentePlanPeriodoActual='SI'
            AND matSemestre IN($semestre)
            GROUP BY matClave, matNombre, matSemestre
            ORDER BY matSemestre, matClave");
        }
        


        

        return response()->json($gruposMaterias);
      }
    }

    public function imprimir(Request $request)
    {

        $bachiller_inscritos = Bachiller_inscritos_evidencias::select(
            'bachiller_inscritos_evidencias.id',
            'bachiller_inscritos_evidencias.ievPuntos',
            'bachiller_inscritos.id as bachiller_inscrito_id',
            'bachiller_inscritos.curso_id',
            'bachiller_inscritos.bachiller_grupo_id',
            'alumnos.id AS alumno_id',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'bachiller_grupos.gpoClave',
            'bachiller_grupos.gpoGrado',
            'bachiller_grupos.gpoMatComplementaria',
            'bachiller_grupos.bachiller_materia_acd_id',
            'bachiller_grupos.bachiller_materia_id',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_materias.matNombreCorto',
            'periodos.id as periodo_id',
            'periodos.perAnio',
            'periodos.perNumero',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empNombre',
            'planes.planClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'cgt.cgtGradoSemestre as semestre',
            'cgt.cgtGrupo as grupo',
            'cursos.curEstado',
            'bachiller_evidencias.eviNumero',
            'departamentos.depClave',
            'programas.progNombre'

        )
            ->join('bachiller_evidencias', 'bachiller_inscritos_evidencias.evidencia_id', '=', 'bachiller_evidencias.id')
            ->join('bachiller_inscritos', 'bachiller_inscritos_evidencias.bachiller_inscrito_id', '=', 'bachiller_inscritos.id')
            ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
            ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_grupos.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
            ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('periodos.id', $request->periodo_id)
            ->where(static function ($query) use ($request) {

                if ($request->cgtGradoSemestreBuscar) {
                    $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestreBuscar);
                }

                if ($request->cgtGrupo) {
                    $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                }

                if ($request->matClave) {
                    $query->where('bachiller_materias.matClave', $request->matClave);
                }

                if ($request->docente_id) {
                    $query->where('bachiller_empleados.id', $request->docente_id);
                }
            })
            ->whereNull('bachiller_inscritos_evidencias.ievPuntos')
            ->whereNull('bachiller_evidencias.deleted_at')
            ->whereNull('bachiller_inscritos_evidencias.deleted_at')
            ->whereNull('bachiller_inscritos.deleted_at')
            ->whereNull('cursos.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->whereNull('bachiller_grupos.deleted_at')
            ->whereNull('bachiller_materias.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('bachiller_empleados.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('cgt.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->orderBy('personas.perApellido1')
            ->orderBy('personas.perApellido2')
            ->orderBy('personas.perNombre')
            ->orderBy('bachiller_grupos.gpoGrado', 'ASC')
            ->orderBy('bachiller_grupos.gpoClave', 'ASC')
            ->orderBy('bachiller_materias.matClave', 'ASC')
            ->orderBy('bachiller_evidencias.eviNumero', 'ASC')
            ->orderBy('personas.perApellido1', 'ASC')
            ->orderBy('personas.perApellido2', 'ASC')
            ->orderBy('personas.perNombre', 'ASC')
            ->get();


        if (count($bachiller_inscritos) < 1) {
            alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');



        $parametro_NombreArchivo = "pdf_evidencias_faltantes";
        // view('reportes.pdf.bachiller.evidencias_faltantes.pdf_evidencias_faltantes')
        $pdf = PDF::loadView('reportes.pdf.bachiller.evidencias_faltantes.' . $parametro_NombreArchivo, [
            "cicloEscolar" => Utils::fecha_string($bachiller_inscritos[0]->perFechaInicial, 'mesCorto') . ' - ' . Utils::fecha_string($bachiller_inscritos[0]->perFechaFinal, 'mesCorto'). ' ('.$bachiller_inscritos[0]->perNumero.'-'.$bachiller_inscritos[0]->perAnio.')',
            "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "bachiller_inscritos" => $bachiller_inscritos
        ]);

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}
