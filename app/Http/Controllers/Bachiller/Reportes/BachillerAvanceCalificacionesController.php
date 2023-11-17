<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_calendarioexamen;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Departamento;
use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerAvanceCalificacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reporte()
    {
        // Mostrar el conmbo solo las ubicaciones correspondientes
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();


        return view('bachiller.reportes.avance_calificaciones.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {

        // Para obtener las fechas del periodo seleccionado
        $periodo = Periodo::findOrFail($request->periodo_id);
        $perFechaInicialMes = Utils::num_meses_corto_string(\Carbon\Carbon::parse($periodo->perFechaInicial)->format('m'));
        $perFechaFinalMes = Utils::num_meses_corto_string(\Carbon\Carbon::parse($periodo->perFechaFinal)->format('m'));
        $cicloEscolar = $perFechaInicialMes.'/'.\Carbon\Carbon::parse($periodo->perFechaInicial)->format('Y').'-'.$perFechaFinalMes.'/'.\Carbon\Carbon::parse($periodo->perFechaFinal)->format('Y');

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $mesCorto = Utils::num_meses_corto_string($fechaActual->format('m'));
        $fechaHoy = $fechaActual->format('d').'/'.$mesCorto.'/'.$fechaActual->format('Y');


        $bachiller_calendario_examenes = Bachiller_calendarioexamen::where('plan_id', '=', $request->plan_id)
        ->where('periodo_id', '=', $request->periodo_id)
        ->first();

        $periodo = Periodo::find($request->periodo_id);

        if ($request->aluClave != "") {
            // dd($request->programa_id, $request->plan_id, $request->periodo_id, $request->gpoGrado, $request->aluClave);
            if($periodo->perAnio >= 2022){
                // $resultado_array =  DB::select("call procBachillerCalificacionesAlumnoYucatan(" . $request->programa_id . ",
                // " . $request->plan_id . ",
                // " . $request->periodo_id . ",
                // " . $request->gpoGrado . ",
                // " . $request->aluClave . ")");
                // $resultado_collection = collect($resultado_array);


                // if ($resultado_collection->isEmpty()) {
                //     alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                //     return back()->withInput();
                // }

                // $resultado_array_acd =  DB::select("call procBachillerCalificacionesACDAlumnoYucatan(" . $request->programa_id . ",
                // " . $request->plan_id . ",
                // " . $request->periodo_id . ",
                // " . $request->gpoGrado . ",
                // " . $request->aluClave . ")");
                // $resultado_collection_acd = collect($resultado_array_acd);

                $parametro_NombreArchivo = "pdf_avance_de_calificaciones_alumno_modi";

                $bachiller_inscritos_recalcultar = Bachiller_inscritos::select(
                    'alumnos.aluClave',
                    'ubicacion.ubiClave'

                )
                ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
                ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->leftJoin('bachiller_materias_acd', 'bachiller_grupos.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
                ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
                ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->where('alumnos.aluClave', $request->aluClave)
                ->whereIn('periodos.id', [$request->periodo_id])
                ->whereNull('bachiller_inscritos.deleted_at')
                ->whereNull('cursos.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->orderBy('bachiller_materias.matOrdenVisual', 'ASC')
                ->get();

                 if (count($bachiller_inscritos_recalcultar) < 1) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }


                $recalcular_alumno = $bachiller_inscritos_recalcultar->groupBy('aluClave');
                foreach($recalcular_alumno as $aluClave => $datos){

                    if($bachiller_inscritos_recalcultar[0]->ubiClave == "CME"){
                        $ejecutar_sp = DB::select("call procBachillerEvidenciasAcumuladoAdmin(".$request->periodo_id.", ".$aluClave.")");
                        $nombreParcial = "3er Corte";
                    }

                    if($bachiller_inscritos_recalcultar[0]->ubiClave == "CVA"){
                        $ejecutar_sp = DB::select("call procBachillerEvidenciasAcumuladoAdminCVA(".$request->periodo_id.", ".$aluClave.")");
                        $nombreParcial = "Ordinario";
                    }
                }


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
                    DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte1," de ",bachiller_inscritos.insPuntosMaximosCorte1) AS primerCorte'),
                    DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte2," de ",bachiller_inscritos.insPuntosMaximosCorte2) AS segundoCorte'),
                    DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte3," de ",bachiller_inscritos.insPuntosMaximosCorte3) AS tercerCorte'),
                    DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosAcumulados," de ",bachiller_inscritos.insPuntosMaximosAcumulados) AS acumuladoCorte'),
                    DB::raw('CONCAT(ROUND((bachiller_inscritos.insPuntosObtenidosAcumulados * 100)/bachiller_inscritos.insPuntosMaximosAcumulados, 1),"%") AS acumuladoAprovechamiento'),
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
                    'bachiller_materias.matClave',
                    'bachiller_materias.matNombre',
                    'periodos.id as periodo_id',
                    'periodos.perAnio',
                    'periodos.perNumero',
                    'bachiller_empleados.empApellido1',
                    'bachiller_empleados.empApellido2',
                    'bachiller_empleados.empNombre',
                    'planes.planClave',
                    'ubicacion.ubiClave',
                    'cgt.cgtGradoSemestre as semestre',
                    'cgt.cgtGrupo as grupo'

                )
                ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
                ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->leftJoin('bachiller_materias_acd', 'bachiller_grupos.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
                ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
                ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->where('alumnos.aluClave', $request->aluClave)
                ->whereIn('periodos.id', [$request->periodo_id])
                ->whereNull('bachiller_inscritos.deleted_at')
                ->whereNull('cursos.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->orderBy('bachiller_materias.matOrdenVisual', 'ASC')
                ->get();


                // return $resultado_collection->groupBy('matClave');
                // view('reportes.pdf.bachiller.avance_de_calificaciones.pdf_avance_de_calificaciones_alumno')
                $pdf = PDF::loadView('reportes.pdf.bachiller.avance_de_calificaciones.' . $parametro_NombreArchivo, [
                    "fechaActual" => $fechaHoy,
                    "horaActual" => $fechaActual->format('H:i:s'),
                    "cicloEscolar" => $cicloEscolar,
                    // "alumno" => $resultado_collection,
                    "bachiller_calendario_examenes" => $bachiller_calendario_examenes,
                    // "alumno_acd" => $resultado_collection_acd,
                    // "materias_alumno" => $resultado_collection->groupBy('matClave'),
                    "bachiller_inscritos" => $bachiller_inscritos,
                    "nombreParcial" => $nombreParcial,
                    "ubiClave" => $bachiller_inscritos_recalcultar[0]->ubiClave
                ]);



                // $pdf->setPaper('letter', 'landscape');
                $pdf->defaultFont = 'Times Sans Serif';

                return $pdf->stream($parametro_NombreArchivo . '.pdf');
                return $pdf->download($parametro_NombreArchivo  . '.pdf');
                // $resultado_registro = $resultado_array[0];
                // $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
            }

            if($periodo->perAnio < 2022){
                $resultado_array =  DB::select("call procBachillerCalificacionesAlumnoYucatan(" . $request->programa_id . ",
                " . $request->plan_id . ",
                " . $request->periodo_id . ",
                " . $request->gpoGrado . ",
                " . $request->aluClave . ")");
                $resultado_collection = collect($resultado_array);


                if ($resultado_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }

                $resultado_array_acd =  DB::select("call procBachillerCalificacionesACDAlumnoYucatan(" . $request->programa_id . ",
                " . $request->plan_id . ",
                " . $request->periodo_id . ",
                " . $request->gpoGrado . ",
                " . $request->aluClave . ")");
                $resultado_collection_acd = collect($resultado_array_acd);

                $materias_alumno = $resultado_collection->groupBy('matClave');


                $parametro_NombreArchivo = "pdf_avance_de_calificaciones_alumno_2021";
                // view('reportes.pdf.bachiller.avance_de_calificaciones.pdf_avance_de_calificaciones_alumno_2021')
                $pdf = PDF::loadView('reportes.pdf.bachiller.avance_de_calificaciones.' . $parametro_NombreArchivo, [
                    "fechaActual" => $fechaHoy,
                    "horaActual" => $fechaActual->format('H:i:s'),
                    "cicloEscolar" => $cicloEscolar,
                    "alumno" => $resultado_collection,
                    "bachiller_calendario_examenes" => $bachiller_calendario_examenes,
                    "alumno_acd" => $resultado_collection_acd,
                    "materias_alumno" => $materias_alumno
                ]);



                $pdf->setPaper('letter', 'landscape');
                $pdf->defaultFont = 'Times Sans Serif';

                return $pdf->stream($parametro_NombreArchivo . '.pdf');
                return $pdf->download($parametro_NombreArchivo  . '.pdf');
                // $resultado_registro = $resultado_array[0];
                // $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
            }
        }

        if ($request->aluClave == "") {

            if($periodo->perAnio >= 2022){
                // dd($request->programa_id, $request->plan_id, $request->periodo_id, $request->gpoGrado, $request->aluClave);

                // $resultado_array =  DB::select("call procBachillerAvanceCalificacionesGradoGrupoYucatan(" . $request->programa_id . ",
                // " . $request->plan_id . ",
                // " . $request->periodo_id . ",
                // " . $request->gpoGrado . ",
                // '" . $request->gpoClave . "')");
                // $resultado_collection = collect($resultado_array);


                // if ($resultado_collection->isEmpty()) {
                //     alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                //     return back()->withInput();
                // }

                // $resultado_array_acd =  DB::select("call procBachillerAvanceCalificacionesGradoGrupoACDYucatan(" . $request->programa_id . ",
                // " . $request->plan_id . ",
                // " . $request->periodo_id . ",
                // " . $request->gpoGrado . ",
                // '" . $request->gpoClave . "')");
                // $resultado_collection_acd = collect($resultado_array_acd);

                // $alumnoAgrupado_acd = $resultado_collection_acd->groupBy('clave_pago');

                $bachiller_inscritos_recalcultar = Bachiller_inscritos::select(
                    'alumnos.aluClave',
                    'periodos.id as periodo_id',
                    'ubicacion.ubiClave'
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
                ->where('programas.id', $request->programa_id)
                ->where('planes.id', $request->plan_id)
                ->where('periodos.id', $request->periodo_id)
                ->where('cgt.cgtGradoSemestre', $request->gpoGrado)
                ->where('cgt.cgtGrupo', $request->gpoClave)
                ->whereNull('bachiller_inscritos.deleted_at')
                ->whereNull('cursos.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->orderBy('personas.perApellido1', 'ASC')
                ->orderBy('personas.perApellido2', 'ASC')
                ->orderBy('personas.perNombre', 'ASC')
                ->orderBy('bachiller_materias.matOrdenVisual', 'ASC')
                ->get();

                if (count($bachiller_inscritos_recalcultar) < 1) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }

                $recalcular_alumno = $bachiller_inscritos_recalcultar->groupBy('aluClave');
                foreach($recalcular_alumno as $aluClave => $datos){

                    if($bachiller_inscritos_recalcultar[0]->ubiClave == "CME"){
                        $ejecutar_sp = DB::select("call procBachillerEvidenciasAcumuladoAdmin(".$request->periodo_id.", ".$aluClave.")");
                        $nombreParcial = "3er Corte";
                    }

                    if($bachiller_inscritos_recalcultar[0]->ubiClave == "CVA"){
                        $ejecutar_sp = DB::select("call procBachillerEvidenciasAcumuladoAdminCVA(".$request->periodo_id.", ".$aluClave.")");
                        $nombreParcial = "Ordinario";
                    }
                }


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
                    'bachiller_inscritos.insPuntosObtenidosOrdinario',
                    'bachiller_inscritos.insPuntosMaximosOrdinario',
                    DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte1," de ",bachiller_inscritos.insPuntosMaximosCorte1) AS primerCorte'),
                    DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte2," de ",bachiller_inscritos.insPuntosMaximosCorte2) AS segundoCorte'),
                    DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosCorte3," de ",bachiller_inscritos.insPuntosMaximosCorte3) AS tercerCorte'),
                    DB::raw('CONCAT(bachiller_inscritos.insPuntosObtenidosAcumulados," de ",bachiller_inscritos.insPuntosMaximosAcumulados) AS acumuladoCorte'),
                    DB::raw('CONCAT(ROUND((bachiller_inscritos.insPuntosObtenidosAcumulados * 100)/bachiller_inscritos.insPuntosMaximosAcumulados, 1),"%") AS acumuladoAprovechamiento'),
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
                    'bachiller_materias.matClave',
                    'bachiller_materias.matNombre',
                    'periodos.id as periodo_id',
                    'periodos.perAnio',
                    'periodos.perNumero',
                    'bachiller_empleados.empApellido1',
                    'bachiller_empleados.empApellido2',
                    'bachiller_empleados.empNombre',
                    'planes.planClave',
                    'ubicacion.ubiClave',
                    'cgt.cgtGradoSemestre as semestre',
                    'cgt.cgtGrupo as grupo'
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
                ->where('programas.id', $request->programa_id)
                ->where('planes.id', $request->plan_id)
                ->where('periodos.id', $request->periodo_id)
                ->where('cgt.cgtGradoSemestre', $request->gpoGrado)
                ->where('cgt.cgtGrupo', $request->gpoClave)
                ->whereNull('bachiller_inscritos.deleted_at')
                ->whereNull('cursos.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->whereNull('bachiller_grupos.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->orderBy('personas.perApellido1', 'ASC')
                ->orderBy('personas.perApellido2', 'ASC')
                ->orderBy('personas.perNombre', 'ASC')
                ->orderBy('bachiller_materias.matOrdenVisual', 'ASC')
                ->get();
                $alumnoAgrupado = $bachiller_inscritos->groupBy('aluClave');



                $parametro_NombreArchivo = "pdf_avance_de_calificaciones_grupo_modi";
                // view('reportes.pdf.bachiller.avance_de_calificaciones.pdf_avance_de_calificaciones_grupo')
                $pdf = PDF::loadView('reportes.pdf.bachiller.avance_de_calificaciones.' . $parametro_NombreArchivo, [
                    "fechaActual" => $fechaHoy,
                    "horaActual" => $fechaActual->format('H:i:s'),
                    "cicloEscolar" => $cicloEscolar,
                    // "alumno" => $resultado_collection,
                    "alumnoAgrupado" => $alumnoAgrupado,
                    "bachiller_calendario_examenes" => $bachiller_calendario_examenes,
                    // "alumno_acd" => $alumnoAgrupado_acd,
                    // "materias_alumno" => $resultado_collection->groupBy('matClave')
                    "nombreParcial" => $nombreParcial,
                    "ubiClave" => $bachiller_inscritos_recalcultar[0]->ubiClave
                ]);



                // $pdf->setPaper('letter', 'landscape');
                $pdf->defaultFont = 'Times Sans Serif';

                return $pdf->stream($parametro_NombreArchivo . '.pdf');
                return $pdf->download($parametro_NombreArchivo  . '.pdf');
                // $resultado_registro = $resultado_array[0];
                // $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
            }

            if($periodo->perAnio < 2022){
                // dd($request->programa_id, $request->plan_id, $request->periodo_id, $request->gpoGrado, $request->aluClave);

                $resultado_array =  DB::select("call procBachillerAvanceCalificacionesGradoGrupoYucatan(" . $request->programa_id . ",
                " . $request->plan_id . ",
                " . $request->periodo_id . ",
                " . $request->gpoGrado . ",
                '" . $request->gpoClave . "')");
                $resultado_collection = collect($resultado_array);


                if ($resultado_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }

                $resultado_array_acd =  DB::select("call procBachillerAvanceCalificacionesGradoGrupoACDYucatan(" . $request->programa_id . ",
                " . $request->plan_id . ",
                " . $request->periodo_id . ",
                " . $request->gpoGrado . ",
                '" . $request->gpoClave . "')");
                $resultado_collection_acd = collect($resultado_array_acd);

                $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
                $alumnoAgrupado_acd = $resultado_collection_acd->groupBy('clave_pago');

                $materias_alumno = $resultado_collection->groupBy('matClave');


                $parametro_NombreArchivo = "pdf_avance_de_calificaciones_grupo_2021";
                // view('reportes.pdf.bachiller.avance_de_calificaciones.pdf_avance_de_calificaciones_grupo_2021')
                $pdf = PDF::loadView('reportes.pdf.bachiller.avance_de_calificaciones.' . $parametro_NombreArchivo, [
                    "fechaActual" => $fechaHoy,
                    "horaActual" => $fechaActual->format('H:i:s'),
                    "cicloEscolar" => $cicloEscolar,
                    "alumno" => $resultado_collection,
                    "alumnoAgrupado" => $alumnoAgrupado,
                    "bachiller_calendario_examenes" => $bachiller_calendario_examenes,
                    "alumno_acd" => $alumnoAgrupado_acd,
                    "materias_alumno" => $materias_alumno
                ]);



                $pdf->setPaper('letter', 'landscape');
                $pdf->defaultFont = 'Times Sans Serif';

                return $pdf->stream($parametro_NombreArchivo . '.pdf');
                return $pdf->download($parametro_NombreArchivo  . '.pdf');
                // $resultado_registro = $resultado_array[0];
                // $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');
            }

        }



    }

}
