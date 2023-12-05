<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_cch_inscritos;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Ubicacion;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerListaDeAsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        // Mostrar el conmbo solo las ubicaciones correspondientes 
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();

        $bachiller_empleados = Bachiller_empleados::where('empEstado', '!=', 'B')->get();

        return view('bachiller.reportes.lista_de_asistencia.create', [
            'ubicaciones' => $ubicaciones,
            'bachiller_empleados' => $bachiller_empleados
        ]);
    }

    public function imprimir(Request $request)
    {
        $gpoGrado = $request->matSemestre;
        $gpoGrupo = $request->gpoGrupo;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;
        $perAnioPago = $request->periodo_id;
        $periodo_id = $request->periodo_id;
        $bachiller_materia_id = $request->bachiller_materia_id;
        $bachiller_materia_acd_id = $request->bachiller_materia_acd_id;

        $tipoVista = $request->tipoVista; //variable que define el tipo de vista del pdf

        

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
         
        // Para Yucatán 
        if($request->ubicacion_id == 1 || $request->ubicacion_id == 2){
            if ($tipoVista == "listaVacia") {
               

                if($request->tipoVistaLista == "grupo-materia"){
                    
                     // Todos los grupos materias 
                    if($request->bachiller_materia_id == ""){
                        // llamada procedure 
                        $resultado_array =  DB::select("call procBachillerListaAsistenciaGrupoMateriaConClaveYucatan(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.", '".$gpoGrupo."')");
                        $grupo_collection = collect($resultado_array);
                    }

                    // Cuando se selecciona la materia sin materia complementaria 
                    if($request->bachiller_materia_id != "" && $request->bachiller_materia_acd_id == ""){
                        // llamada procedure 
                        $resultado_array =  DB::select("call procBachillerListaAsistenciaGrupoMateriaYucatan(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.", '".$gpoGrupo."', ".$bachiller_materia_id.")");
                        $grupo_collection = collect($resultado_array);
                    }

                    // Cuando se selecciona la materia con materia complementaria 
                    if($request->bachiller_materia_id != "" && $request->bachiller_materia_acd_id != ""){
                        // llamada procedure 
                        $resultado_array =  DB::select("call procBachillerListaAsistenciaGrupoMateriaACDYucatan(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.", '".$gpoGrupo."', ".$bachiller_materia_id.", ".$bachiller_materia_acd_id.")");
                        $grupo_collection = collect($resultado_array);
                    }

                    if ($grupo_collection->isEmpty()) {
                        alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                        return back()->withInput();
                    }
    
                    $agrupamos_por_id_grupo = $grupo_collection->groupBy('bachiller_grupo_id');
                    $periodoI = \Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('Y');
                    $periodoF = \Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('Y');
                    $periodoVigente = $periodoI.' al '.$periodoF.' ('.$grupo_collection[0]->perNumero.'-'.$grupo_collection[0]->perAnio.')';
    
                    $parametro_NombreArchivo = "pdf_bachiller_lista_de_asistencia_ciclo";
                    // view('reportes.pdf.bachiller.lista_de_asistencia.pdf_bachiller_lista_de_asistencia_ciclo');
                    $pdf = PDF::loadView('reportes.pdf.bachiller.lista_de_asistencia.' . $parametro_NombreArchivo, [
                        "fechaActual" => $fechaActual->format('d/m/Y'),
                        "horaActual" => $fechaActual->format('H:i:s'),
                        "parametro_NombreArchivo" => $parametro_NombreArchivo,
                        "grupos" => $agrupamos_por_id_grupo,
                        "periodoVigente" => $periodoVigente
                    ]);
    
    
                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';
    
                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }
    
                if($request->tipoVistaLista == "grupo"){                    
    
                     // Todos los grupos materias 
                    if($request->gpoGrupo != ""){
                        // dd($programa_id,$periodo_id,$plan_id,$gpoGrado,$gpoGrupo);
                        // llamada procedure 
                        // $resultado_array =  DB::select("call procBachillerListaAsistenciaGrupoMateriaConClaveYucatan(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.", '".$gpoGrupo."')");
                        $resultado_array =  DB::select("call procBachillerListaAsistenciaGrupalYucatan(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.", '".$gpoGrupo."')");

                        $grupo_collection2 = collect($resultado_array);
                    }else{
                        $resultado_array =  DB::select("call procBachillerListaAsistenciaGrupalTodosYucatan(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.")");

                        $grupo_collection2 = collect($resultado_array);
                    }


                    if ($grupo_collection2->isEmpty()) {
                        alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                        return back()->withInput();
                    }
    
                    $agrupamos_por_gpoClave = $grupo_collection2->groupBy('cgtGrupo');
                    $agrupamos_por_aluClave = $grupo_collection2->groupBy('aluClave');
    
                    $periodoI = \Carbon\Carbon::parse($grupo_collection2[0]->perFechaInicial)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection2[0]->perFechaInicial)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection2[0]->perFechaInicial)->format('Y');
                    $periodoF = \Carbon\Carbon::parse($grupo_collection2[0]->perFechaFinal)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection2[0]->perFechaFinal)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection2[0]->perFechaFinal)->format('Y');
                    $periodoVigente = $periodoI.' al '.$periodoF.' ('.$grupo_collection2[0]->perNumero.'-'.$grupo_collection2[0]->perAnio.')';
    
                    $parametro_NombreArchivo = "pdf_bachiller_lista_de_asistencia_grupo";
                    // view('reportes.pdf.bachiller.lista_de_asistencia.pdf_bachiller_lista_de_asistencia_grupo');
                    $pdf = PDF::loadView('reportes.pdf.bachiller.lista_de_asistencia.' . $parametro_NombreArchivo, [
                        "fechaActual" => $fechaActual->format('d/m/Y'),
                        "horaActual" => $fechaActual->format('H:i:s'),
                        "parametro_NombreArchivo" => $parametro_NombreArchivo,
                        "grupos" => $agrupamos_por_gpoClave,
                        "periodoVigente" => $periodoVigente,
                        "grupoAluClave" => $agrupamos_por_aluClave
                    ]);
    
    
                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';
    
                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }


                if($request->tipoVistaLista == "docente"){
                    
                    if($request->tipoVistaLista == "docente"){

                        
                        // Cuando se selecciona la materia sin materia complementaria 
                        if($request->bachiller_empleado != "" && $request->gpoGrupo != ""){
                            // llamada procedure 
                            $resultado_array =  DB::select("call procBachillerListaAsistenciaGrupoMateriaDocenteYucatan(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.", '".$gpoGrupo."', ".$request->bachiller_empleado.")");
                            $grupo_collection = collect($resultado_array);
                        }

                        if($request->bachiller_empleado != "" && $request->gpoGrupo == ""){
                            // llamada procedure 
                            $resultado_array =  DB::select("call procBachillerListaAsistenciaSinGrupoMateriaDocenteYucatan(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.",".$request->bachiller_empleado.")");
                            $grupo_collection = collect($resultado_array);
                        }
                    }
                    
                    if ($grupo_collection->isEmpty()) {
                        alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                        return back()->withInput();
                    }

                    $agrupamos_por_id_grupo = $grupo_collection->groupBy('bachiller_grupo_id');
                    $periodoI = \Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('Y');
                    $periodoF = \Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('Y');
                    $periodoVigente = $periodoI.' al '.$periodoF.' ('.$grupo_collection[0]->perNumero.'-'.$grupo_collection[0]->perAnio.')';
    
                    $parametro_NombreArchivo = "pdf_bachiller_lista_de_asistencia_ciclo";
                    // view('reportes.pdf.bachiller.lista_de_asistencia.pdf_bachiller_lista_de_asistencia_ciclo');
                    $pdf = PDF::loadView('reportes.pdf.bachiller.lista_de_asistencia.' . $parametro_NombreArchivo, [
                        "fechaActual" => $fechaActual->format('d/m/Y'),
                        "horaActual" => $fechaActual->format('H:i:s'),
                        "parametro_NombreArchivo" => $parametro_NombreArchivo,
                        "grupos" => $agrupamos_por_id_grupo,
                        "periodoVigente" => $periodoVigente
                    ]);
    
    
                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';
    
                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }
                
            } 
        }

        // Para Quintana Roo 
        if($request->ubicacion_id == 3){
            if ($tipoVista == "listaVacia") {

                // llamada procedure 
                $resultado_array =  DB::select("call procBachillerListaAsistenciaGrupoMateriaConClaveChetumal(" . $programa_id . "," . $periodo_id . "," . $plan_id . ", ".$gpoGrado.", '".$gpoGrupo."')");
                $grupo_collection = collect($resultado_array);

                if ($grupo_collection->isEmpty()) {
                    alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                    return back()->withInput();
                }

                if($request->tipoVistaLista == "grupo-materia"){
                    
    
                    $agrupamos_por_id_grupo = $grupo_collection->groupBy('bachiller_grupo_id');
                    $periodoI = \Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('Y');
                    $periodoF = \Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('Y');
                    $periodoVigente = $periodoI.' al '.$periodoF.' ('.$grupo_collection[0]->perNumero.'-'.$grupo_collection[0]->perAnio.')';
    
                    $parametro_NombreArchivo = "pdf_bachiller_lista_de_asistencia_ciclo";
                    // view('reportes.pdf.bachiller.lista_de_asistencia.pdf_bachiller_lista_de_asistencia_ciclo');
                    $pdf = PDF::loadView('reportes.pdf.bachiller.lista_de_asistencia.' . $parametro_NombreArchivo, [
                        "fechaActual" => $fechaActual->format('d/m/Y'),
                        "horaActual" => $fechaActual->format('H:i:s'),
                        "parametro_NombreArchivo" => $parametro_NombreArchivo,
                        "grupos" => $agrupamos_por_id_grupo,
                        "periodoVigente" => $periodoVigente
                    ]);
    
    
                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';
    
                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }
    
                if($request->tipoVistaLista == "grupo"){                    
    
                    $agrupamos_por_gpoClave = $grupo_collection->groupBy('gpoClave');
                    $agrupamos_por_aluClave = $grupo_collection->groupBy('aluClave');
    
                    $periodoI = \Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection[0]->perFechaInicial)->format('Y');
                    $periodoF = \Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('d').'/'.Utils::num_meses_corto_string(\Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('m')).'/'.\Carbon\Carbon::parse($grupo_collection[0]->perFechaFinal)->format('Y');
                    $periodoVigente = $periodoI.' al '.$periodoF.' ('.$grupo_collection[0]->perNumero.'-'.$grupo_collection[0]->perAnio.')';
    
                    $parametro_NombreArchivo = "pdf_bachiller_lista_de_asistencia_grupo";
                    // view('reportes.pdf.bachiller.lista_de_asistencia.pdf_bachiller_lista_de_asistencia_grupo');
                    $pdf = PDF::loadView('reportes.pdf.bachiller.lista_de_asistencia.' . $parametro_NombreArchivo, [
                        "fechaActual" => $fechaActual->format('d/m/Y'),
                        "horaActual" => $fechaActual->format('H:i:s'),
                        "parametro_NombreArchivo" => $parametro_NombreArchivo,
                        "grupos" => $agrupamos_por_gpoClave,
                        "periodoVigente" => $periodoVigente,
                        "grupoAluClave" => $agrupamos_por_aluClave
                    ]);
    
    
                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';
    
                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }
                
            } 
        }
        
    }

    public function imprimirListaAsistenciaYuc($grupo_id)
    {
        $alumnos_grupo =  Bachiller_inscritos::select(
            'bachiller_inscritos.id',
            'bachiller_inscritos.inscCalificacionSep as septiembre',
            'bachiller_inscritos.inscCalificacionOct as octubre',
            'bachiller_inscritos.inscCalificacionNov as noviembre',
            'bachiller_inscritos.inscCalificacionDic as diciembre',
            'bachiller_inscritos.inscCalificacionEne as enero',
            'bachiller_inscritos.inscCalificacionFeb as febrero',
            'bachiller_inscritos.inscCalificacionMar as marzo',
            'bachiller_inscritos.inscCalificacionAbr as abril',
            'bachiller_inscritos.inscCalificacionMay as mayo',
            'bachiller_inscritos.inscCalificacionJun as junio',
            // 'bachiller_inscritos.inscPromedioBimestre1 as bimestre1',
            // 'bachiller_inscritos.inscPromedioBimestre2 as bimestre2',
            // 'bachiller_inscritos.inscPromedioBimestre3 as bimestre3',
            // 'bachiller_inscritos.inscPromedioBimestre4 as bimestre4',
            // 'bachiller_inscritos.inscPromedioBimestre5 as bimestre5',
            // 'bachiller_inscritos.inscTrimestre1 as trimestre1',
            // 'bachiller_inscritos.inscTrimestre2 as trimestre2',
            // 'bachiller_inscritos.inscTrimestre3 as trimestre3',
            'bachiller_grupos.id as bachiller_grupo_id',
            'bachiller_grupos.gpoGrado',
            'bachiller_grupos.gpoClave',
            'cursos.id as curso_id',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_materias.matNombreCorto',
            'periodos.id as periodo_id',
            'periodos.perAnioPago',
            'periodos.perFechaInicial as fecha_inicio',
            'periodos.perFechaFinal as fecha_fin',
            'alumnos.id as alumno_id',
            'alumnos.aluClave as clavePago',
            'personas.id as persona_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'bachiller_empleados.id as empleados_id',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empNombre',
            'bachiller_empleados.empSexo',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.id as departamento_id',
            'planes.id as plan_id',
            'planes.planClave',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
        ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
        ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
        ->join('planes', 'bachiller_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_inscritos.bachiller_grupo_id', $grupo_id)
        ->where('cursos.curEstado', '=', 'R')
        ->whereNull('bachiller_grupos.deleted_at')
        ->whereNull('cursos.deleted_at')
        ->whereNull('bachiller_materias.deleted_at')
        ->whereNull('periodos.deleted_at')
        ->whereNull('alumnos.deleted_at')
        ->whereNull('personas.deleted_at')
        ->whereNull('bachiller_empleados.deleted_at')
        ->whereNull('planes.deleted_at')
        ->whereNull('programas.deleted_at')
        ->whereNull('escuelas.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->whereNull('ubicacion.deleted_at')
        ->orderBy('personas.perApellido1', 'ASC')
        ->orderBy('personas.perApellido2', 'ASC')
        ->get();

        if(count($alumnos_grupo) < 1){
            alert()->warning('Sin coincidencias', 'Los alumnos se deben encontrar en estado de curso REGULAR')->showConfirmButton();
            return back();
        }
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');



        $parametro_NombreArchivo = "pdf_bachiller_lista_de_asistencia";
        // view('reportes.pdf.bachiller.lista_de_asistencia.pdf_bachiller_lista_de_asistencia');
        $pdf = PDF::loadView('reportes.pdf.bachiller.lista_de_asistencia.' . $parametro_NombreArchivo, [
            "inscritos" => $alumnos_grupo,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "parametro_NombreArchivo" => $parametro_NombreArchivo,

        ]);


        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    public function imprimirListaAsistenciaChe($grupo_id)
    {
        $alumnos_grupo =  Bachiller_cch_inscritos::select(
            'bachiller_cch_inscritos.id',
            // 'bachiller_cch_inscritos.inscCalificacionSep as septiembre',
            // 'bachiller_cch_inscritos.inscCalificacionOct as octubre',
            // 'bachiller_cch_inscritos.inscCalificacionNov as noviembre',
            // 'bachiller_cch_inscritos.inscCalificacionDic as diciembre',
            // 'bachiller_cch_inscritos.inscCalificacionEne as enero',
            // 'bachiller_cch_inscritos.inscCalificacionFeb as febrero',
            // 'bachiller_cch_inscritos.inscCalificacionMar as marzo',
            // 'bachiller_cch_inscritos.inscCalificacionAbr as abril',
            // 'bachiller_cch_inscritos.inscCalificacionMay as mayo',
            // 'bachiller_cch_inscritos.inscCalificacionJun as junio',
            // 'bachiller_cch_inscritos.inscPromedioBimestre1 as bimestre1',
            // 'bachiller_cch_inscritos.inscPromedioBimestre2 as bimestre2',
            // 'bachiller_cch_inscritos.inscPromedioBimestre3 as bimestre3',
            // 'bachiller_cch_inscritos.inscPromedioBimestre4 as bimestre4',
            // 'bachiller_cch_inscritos.inscPromedioBimestre5 as bimestre5',
            // 'bachiller_cch_inscritos.inscTrimestre1 as trimestre1',
            // 'bachiller_cch_inscritos.inscTrimestre2 as trimestre2',
            // 'bachiller_cch_inscritos.inscTrimestre3 as trimestre3',
            'bachiller_cch_grupos.id as bachiller_grupo_id',
            'bachiller_cch_grupos.gpoGrado',
            'bachiller_cch_grupos.gpoClave',
            'cursos.id as curso_id',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_materias.matNombreCorto',
            'periodos.id as periodo_id',
            'periodos.perAnioPago',
            'periodos.perFechaInicial as fecha_inicio',
            'periodos.perFechaFinal as fecha_fin',
            'alumnos.id as alumno_id',
            'alumnos.aluClave as clavePago',
            'personas.id as persona_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'bachiller_empleados.id as empleados_id',
            'bachiller_empleados.empApellido1',
            'bachiller_empleados.empApellido2',
            'bachiller_empleados.empNombre',
            'bachiller_empleados.empSexo',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.id as departamento_id',
            'planes.id as plan_id',
            'planes.planClave',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('bachiller_cch_grupos', 'bachiller_cch_inscritos.bachiller_grupo_id', '=', 'bachiller_cch_grupos.id')
        ->join('cursos', 'bachiller_cch_inscritos.curso_id', '=', 'cursos.id')
        ->join('bachiller_materias', 'bachiller_cch_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
        ->join('periodos', 'bachiller_cch_grupos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('bachiller_empleados', 'bachiller_cch_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
        ->join('planes', 'bachiller_cch_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_cch_inscritos.bachiller_grupo_id', $grupo_id)
        ->where('cursos.curEstado', '=', 'R')
        ->orderBy('personas.perApellido1', 'ASC')
        ->orderBy('personas.perApellido2', 'ASC')
        ->get();

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');



        $parametro_NombreArchivo = "pdf_bachiller_lista_de_asistencia";
        $pdf = PDF::loadView('reportes.pdf.bachiller.lista_de_asistencia.' . $parametro_NombreArchivo, [
            "inscritos" => $alumnos_grupo,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "parametro_NombreArchivo" => $parametro_NombreArchivo,

        ]);


        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    public function reporteACD()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->sedes()->get();
        return view('secundaria.reportes.lista_de_asistencia.createACD', [
            'ubicaciones' => $ubicaciones
        ]);
    }



    // ajax para recuperar grupos de ACD
    public function getGruposACD(Request $request, $programa_id, $plan_id, $id_periodo, $grado)
    {
        if($request->ajax()){

         // llama al procedure de los alumnos a buscar 
         $resultado_array =  DB::select("call procSecundariaClavesGruposACDConGrado(".$id_periodo.", ".$programa_id.", ".$plan_id.", ".$grado.")");

         $grupos = collect($resultado_array);

            return response()->json($grupos);
        }
    }

    public function getMateriasComplementarias(Request $request, $programa_id, $plan_id, $perAniopPago)
    {
        if ($request->ajax()) {


            $resultado_array = DB::select("SELECT DISTINCT secundaria_grupos.gpoMatComplementaria FROM secundaria_grupos AS secundaria_grupos 
         INNER JOIN periodos on periodos.id = secundaria_grupos.periodo_id
         INNER JOIN planes on planes.id = secundaria_grupos.plan_id
         INNER JOIN programas on programas.id = planes.programa_id
         WHERE secundaria_grupos.gpoMatComplementaria IS NOT NULL
         AND programas.id = $programa_id
         AND planes.id = $plan_id
         AND periodos.perAnioPago = $perAniopPago
         ORDER BY secundaria_grupos.gpoMatComplementaria ASC");


            return response()->json($resultado_array);
        }
    }




    public function imprimirACD(Request $request)
    {
        $gpoGrado = $request->gpoGrado;
        $gpoGrupo = $request->gpoGrupo;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;
        $perAnioPago = $request->periodo_id;
        $tipoReporte = $request->tipoReporte;

        // Obtiene todos los grupos con el mismo grado 
        if($tipoReporte == "1"){
            $resultado_array =  DB::select("call procSecundariaListaAlumnosACDCualquierGrado(" . $perAnioPago . "," . $gpoGrado . ", ".$programa_id.", ".$plan_id.")");
            $grupo_collection = collect($resultado_array);

            if ($grupo_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay grupos capturados con la información proporcionada. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
         
            $materia_complemenataria = $grupo_collection->groupBy('gpoMatComplementaria');

            $gpoClave = $grupo_collection->groupBy('gpoClave');

            //view('reportes.pdf.secundaria.lista_de_asistencia.pdf_secundaria_lista_de_asistencia_ACD_sin_clavegrupo');

            $parametro_NombreArchivo = "pdf_secundaria_lista_de_asistencia_ACD_sin_clavegrupo";
            $pdf = PDF::loadView('reportes.pdf.secundaria.lista_de_asistencia.' . $parametro_NombreArchivo, [
                "inscritos" => $grupo_collection,            
                "parametro_NombreArchivo" => $parametro_NombreArchivo,
                "gpoGrupo" => $gpoGrupo,
                "materia_complemenataria" => $materia_complemenataria,
                "gpoClave" => $gpoClave
            ]);

            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');

        }

        if($tipoReporte == "3"){
            // llamada procedure 
            $resultado_array =  DB::select("call procSecundariaListaAlumnosACD(" . $perAnioPago . "," . $gpoGrado . ",'" . $gpoGrupo . "', ".$programa_id.", ".$plan_id.")");
            $grupo_collection = collect($resultado_array);

            if ($grupo_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay grupos capturados con la información proporcionada. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
            $parametro_NombreArchivo = "pdf_secundaria_lista_de_asistencia_ACD";
            $pdf = PDF::loadView('reportes.pdf.secundaria.lista_de_asistencia.' . $parametro_NombreArchivo, [
                "inscritos" => $grupo_collection,
            
                "parametro_NombreArchivo" => $parametro_NombreArchivo,
                
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }

     
        if($tipoReporte == "2"){
            // llamada procedure 
            $resultado_array =  DB::select("call procSecundariaListaAlumnosACD_MatComplementaria(" . $programa_id . "," . $plan_id . "," . $perAnioPago . ", '".$request->gpoMatComplementaria."')");
            $grupo_collection = collect($resultado_array);

            $gpoClave = $grupo_collection->groupBy('gpoClave');



            if ($grupo_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay grupos capturados con la información proporcionada. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
            $parametro_NombreArchivo = "pdf_secundaria_lista_de_asistencia_ACD_matComplentaria";
            $pdf = PDF::loadView('reportes.pdf.secundaria.lista_de_asistencia.' . $parametro_NombreArchivo, [
                "inscritos" => $grupo_collection,
                "gpoClave" => $gpoClave            
                
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
 


    }
}
