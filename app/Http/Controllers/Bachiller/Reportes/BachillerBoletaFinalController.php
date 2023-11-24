<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Periodo;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerBoletaFinalController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

        return view('bachiller.reportes.boleta_final.create', [
            "ubicaciones" => $ubicaciones,
            "ubicacion_id" => $ubicacion_id
        ]);
    }

    public function imprimir(Request $request)
    {

        $periodo = Periodo::find($request->periodo_id);

        // Para boletas del 2022
        if ($periodo->perAnio >= 2022) {
            $bachiller_inscritos = Bachiller_inscritos::select(
                'bachiller_inscritos.id',
                'bachiller_inscritos.curso_id',
                'bachiller_inscritos.bachiller_grupo_id',
                'bachiller_inscritos.insCalificacionParcial1',
                'bachiller_inscritos.insFaltasParcial1',
                'bachiller_inscritos.insCalificacionParcial2',
                'bachiller_inscritos.insFaltasParcial2',
                'bachiller_inscritos.insCalificacionParcial3',
                'bachiller_inscritos.insFaltasParcial3',
                'bachiller_inscritos.insCalificacionFinal',
                'bachiller_inscritos.insPromedioParcial',
                'bachiller_inscritos.insPuntosObtenidosCorte1',
                'bachiller_inscritos.insPuntosObtenidosCorte2',
                'bachiller_inscritos.insPuntosObtenidosCorte3',
                'bachiller_inscritos.insPuntosMaximosCorte1',
                'bachiller_inscritos.insPuntosMaximosCorte2',
                'bachiller_inscritos.insPuntosMaximosCorte3',
                'bachiller_inscritos.insPuntosObtenidosAcumulados',
                'bachiller_inscritos.insPuntosMaximosAcumulados',                
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
                'planes.id as plan_id',
                'planes.planClave',
                'ubicacion.ubiClave',
                'cgt.cgtGradoSemestre as semestre',
                'cgt.cgtGrupo as grupo',
                'cursos.curEstado'

            )
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

                    if ($request->cgtGradoSemestre) {
                        $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestre);
                    }

                    if ($request->cgtGrupo) {
                        $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                    }

                    if ($request->aluClave) {
                        $query->where('alumnos.aluClave', $request->aluClave);
                    }

                    if ($request->perApellido1) {
                        $query->where('personas.perApellido1', $request->perApellido1);
                    }
                    if ($request->perApellido2) {
                        $query->where('personas.perApellido2', $request->perApellido2);
                    }
                    if ($request->perNombre) {
                        $query->where('personas.perNombre', $request->perNombre);
                    }
                })
                ->where('cursos.curEstado', '!=', 'B')
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
                ->orderBy('bachiller_materias.matClave', 'ASC')
                ->get();


            if (count($bachiller_inscritos) < 1) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');


            $alumno = $bachiller_inscritos->groupBy('aluClave');
            $bachiller_materias = $bachiller_inscritos->groupBy('bachiller_materia_id');

            $parametro_NombreArchivo = "pdf_boleta_final";
            // view('reportes.pdf.bachiller.boleta_final.pdf_boleta_final')
            $pdf = PDF::loadView('reportes.pdf.bachiller.boleta_final.' . $parametro_NombreArchivo, [
                "cicloEscolar" => Utils::num_meses_corto_string(\Carbon\Carbon::parse($bachiller_inscritos[0]->perFechaInicial)->format('m')) . '/' . $bachiller_inscritos[0]->perAnio . '-' . Utils::num_meses_corto_string(\Carbon\Carbon::parse($bachiller_inscritos[0]->perFechaFinal)->format('m')) . '/' . $bachiller_inscritos[0]->perAnio,
                "alumno" => $alumno,
                "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
                "bachiller_materias" => $bachiller_materias
            ]);

            return $pdf->stream('Boleta_'.$bachiller_inscritos[0]->perAnio.'.pdf');
            return $pdf->download('Boleta_'.$bachiller_inscritos[0]->perAnio. '.pdf');
        }

        if($periodo->perAnio < 2022){

            $bachiller_inscritos = Bachiller_inscritos::select(
                'bachiller_inscritos.id',
                'bachiller_inscritos.curso_id',
                'bachiller_inscritos.bachiller_grupo_id',
                'bachiller_inscritos.insCalificacionParcial1',
                'bachiller_inscritos.insFaltasParcial1',
                'bachiller_inscritos.insCalificacionParcial2',
                'bachiller_inscritos.insFaltasParcial2',
                'bachiller_inscritos.insCalificacionParcial3',
                'bachiller_inscritos.insFaltasParcial3',
                'bachiller_inscritos.insCalificacionFinal',
                'bachiller_inscritos.insPromedioParcial',
                'bachiller_inscritos.insPuntosObtenidosCorte1',
                'bachiller_inscritos.insPuntosObtenidosCorte2',
                'bachiller_inscritos.insPuntosObtenidosCorte3',
                'bachiller_inscritos.insPuntosMaximosCorte1',
                'bachiller_inscritos.insPuntosMaximosCorte2',
                'bachiller_inscritos.insPuntosMaximosCorte3',
                'bachiller_inscritos.insPuntosObtenidosAcumulados',
                'bachiller_inscritos.insPuntosMaximosAcumulados',      
                'bachiller_inscritos.insCalificacionOrdinario',          
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
                'bachiller_materias.matClaveTELNET',
                'bachiller_materias.matNombre',
                'bachiller_materias.matNombreCorto',
                'bachiller_materias.matComplementaria',
                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perNumero',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre',
                'planes.id as plan_id',
                'planes.planClave',
                'ubicacion.ubiClave',
                'cgt.cgtGradoSemestre as semestre',
                'cgt.cgtGrupo as grupo',
                'cursos.curEstado'

            )
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

                    if ($request->cgtGradoSemestre) {
                        $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestre);
                    }

                    if ($request->cgtGrupo) {
                        $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                    }

                    if ($request->aluClave) {
                        $query->where('alumnos.aluClave', $request->aluClave);
                    }

                    if ($request->perApellido1) {
                        $query->where('personas.perApellido1', $request->perApellido1);
                    }
                    if ($request->perApellido2) {
                        $query->where('personas.perApellido2', $request->perApellido2);
                    }
                    if ($request->perNombre) {
                        $query->where('personas.perNombre', $request->perNombre);
                    }
                })
                ->whereIn('bachiller_materias.matClasificacion', ['B', 'U', 'O'])
                ->where('cursos.curEstado', '!=', 'B')
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
                ->orderBy('bachiller_materias.matOrdenVisual', 'ASC')
                ->get();


                 if (count($bachiller_inscritos) < 1) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');


            $alumno = $bachiller_inscritos->groupBy('aluClave');
            $bachiller_materias = $bachiller_inscritos->groupBy('bachiller_materia_id');

            $parametro_NombreArchivo = "pdf_boleta_final_2021";
            // view('reportes.pdf.bachiller.boleta_final.pdf_boleta_final_2021')
            $pdf = PDF::loadView('reportes.pdf.bachiller.boleta_final.' . $parametro_NombreArchivo, [
                "cicloEscolar" => Utils::num_meses_corto_string(\Carbon\Carbon::parse($bachiller_inscritos[0]->perFechaInicial)->format('m')) . '/' . $bachiller_inscritos[0]->perAnio . '-' . Utils::num_meses_corto_string(\Carbon\Carbon::parse($bachiller_inscritos[0]->perFechaFinal)->format('m')) . '/' . $bachiller_inscritos[0]->perAnio,
                "alumno" => $alumno,
                "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
                "bachiller_materias" => $bachiller_materias
            ]);

            return $pdf->stream('Boleta_'.$bachiller_inscritos[0]->perAnio.'.pdf');
            return $pdf->download('Boleta_'.$bachiller_inscritos[0]->perAnio. '.pdf');

        }
    }
}
