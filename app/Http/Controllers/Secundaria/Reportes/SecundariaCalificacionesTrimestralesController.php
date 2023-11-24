<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Conceptoscursoestado;
use App\Models\Periodo;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaCalificacionesTrimestralesController extends Controller
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
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->sedes()->get();
        $conceptos = Conceptoscursoestado::get();

        return view('secundaria.reportes.resumen_de_calificaciones_trimestre.create', [
            "ubicaciones" => $ubicaciones,
            "conceptos" => $conceptos
        ]);
    }

    public function reporteResumenCalificacion(Request $request)
    {
        $periodo = Periodo::find($request->periodo_id);
        $perAnioPago = $periodo->perAnioPago;

        // filtra las calificaciones de acuerdo al mes que el usuario indique
        $conceptos = $request->conceptos;
        $gpoGrado = $request->gpoGrado;
        $gpoClave = $request->gpoClave;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        // llama al procedure de los alumnos a buscar
        $datosDelosAlumnos =  DB::select("call procSecundariaCalificacionesGrupoTrim(" . $perAnioPago . ", " . $gpoGrado . ", '" . $gpoClave . "', '" . $conceptos . "'," . $programa_id . "," . $plan_id . ")");

        $datosAlumnos = collect($datosDelosAlumnos);

        // si no hay datos muestra alerta
        if ($datosAlumnos->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        // // solo trimestre 1 
        // if($request->tipoReporte == "1"){

        //     $resultado_array =  DB::select("call procSecundariaPromediosTrimestres(" . $request->periodo_id . ")");
        //     $parametro_Titulo = NULL;

        // }

        // // solo trimestre 1 y 2 
        // if($request->tipoReporte == "1-2"){

        //     $resultado_array =  DB::select("call procSecundariaPromediosTrimestres(" . $request->periodo_id . ")");
        //     $parametro_Titulo = NULL;

        // }

        // // solo trimestre 1, 2 y 3 
        // if($request->tipoReporte == "1-2-3"){

        //     $resultado_array =  DB::select("call procSecundariaPromediosTrimestres(" . $request->periodo_id . ")");
        //     $parametro_Titulo = NULL;

        // }


        $matAgrupado = $datosAlumnos->groupBy('matClave');


        $resultado_registro = $datosAlumnos[0];
        $parametro_Grado = $resultado_registro->grado;
        $parametro_Grupo = $resultado_registro->grupo;
        $parametro_CGTGrupo = $resultado_registro->grupo;
        $parametro_Ciclo = $resultado_registro->ciclo_escolar;
        $parametro_progClave = $resultado_registro->progClave;
        $parametro_planClave = $resultado_registro->planClave;
        $parametro_progNombre = $resultado_registro->progNombre;    

        if($conceptos != "T"){
            // obtiene las materias que se relacionan con el alumno en curso
            $materia_alumos =  DB::select("SELECT DISTINCT
            sm.matClave,
            sm.matNombre,
            sm.matNombreCorto
            FROM
            cursos
            INNER JOIN periodos ON cursos.periodo_id = periodos.id
            AND periodos.deleted_at IS NULL
            INNER JOIN cgt ON cursos.cgt_id = cgt.id
            AND cgt.deleted_at IS NULL
            INNER JOIN planes ON cgt.plan_id = planes.id
            AND planes.deleted_at IS NULL
            INNER JOIN programas ON planes.programa_id = programas.id
            AND programas.deleted_at IS NULL
            INNER JOIN escuelas ON programas.escuela_id = escuelas.id
            AND escuelas.deleted_at IS NULL
            INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
            AND departamentos.deleted_at IS NULL
            INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
            AND ubicacion.deleted_at IS NULL
            INNER JOIN secundaria_inscritos pi ON pi.curso_id = cursos.id
            AND pi.deleted_at IS NULL
            INNER JOIN secundaria_grupos sg ON sg.id = pi.grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN secundaria_materias sm ON sm.id = sg.secundaria_materia_id
            AND sg.deleted_at IS NULL
            WHERE
            cursos.deleted_at IS NULL
                AND departamentos.depClave = 'SEC'
            AND cgt.cgtGradoSemestre = '" . $request->gpoGrado . "'
            AND	cgt.cgtGrupo = '" . $request->gpoClave . "'
            AND periodos.perAnioPago = '" . $perAnioPago . "'
            AND cursos.curEstado = '".$conceptos."'
            AND programas.id = $programa_id
            AND planes.id = $plan_id
            ORDER BY sm.matClave asc");
        }else{
             // obtiene las materias que se relacionan con el alumno en curso
            $materia_alumos =  DB::select("SELECT DISTINCT
            sm.matClave,
            sm.matNombre,
            sm.matNombreCorto
            FROM
            cursos
            INNER JOIN periodos ON cursos.periodo_id = periodos.id
            AND periodos.deleted_at IS NULL
            INNER JOIN cgt ON cursos.cgt_id = cgt.id
            AND cgt.deleted_at IS NULL
            INNER JOIN planes ON cgt.plan_id = planes.id
            AND planes.deleted_at IS NULL
            INNER JOIN programas ON planes.programa_id = programas.id
            AND programas.deleted_at IS NULL
            INNER JOIN escuelas ON programas.escuela_id = escuelas.id
            AND escuelas.deleted_at IS NULL
            INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
            AND departamentos.deleted_at IS NULL
            INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
            AND ubicacion.deleted_at IS NULL
            INNER JOIN secundaria_inscritos pi ON pi.curso_id = cursos.id
            AND pi.deleted_at IS NULL
            INNER JOIN secundaria_grupos sg ON sg.id = pi.grupo_id
            AND sg.deleted_at IS NULL
            INNER JOIN secundaria_materias sm ON sm.id = sg.secundaria_materia_id
            AND sg.deleted_at IS NULL
            WHERE
            cursos.deleted_at IS NULL
                AND departamentos.depClave = 'SEC'
            AND cgt.cgtGradoSemestre = '" . $request->gpoGrado . "'
            AND	cgt.cgtGrupo = '" . $request->gpoClave . "'
            AND periodos.perAnioPago = '" . $perAnioPago . "'
            AND programas.id = $programa_id
            AND planes.id = $plan_id
            ORDER BY sm.matClave asc");
        }
       


        // Parametro
        $parametro_ubicacion_clave = $datosAlumnos[0]->ubicacion;



        $totalMaterias = count($materia_alumos);


        $alumnoGrupado = $datosAlumnos->groupBy('clave_pago');
        $totalDeAlumnos = count($alumnoGrupado);


        $parametro_NombreArchivo = 'pdf_secundaria_resumen_de_calificaciones_trim_cme'; //nombre del archivo blade

        
        $tablaBody = $this->generarTableTodasMaterias($matAgrupado, $datosAlumnos, $alumnoGrupado);

        $parametro_Titulo = "REPORTE DE PROMEDIOS TRIMESTRALES";
      

        // die();
        // view('reportes.pdf.secundaria.res_calificaciones_trim.pdf_secundaria_resumen_de_calificaciones_trim_cme');
        $pdf = PDF::loadView('reportes.pdf.secundaria.res_calificaciones_trim.' . $parametro_NombreArchivo, [
            "materia_alumos" => $materia_alumos,
            "calificaciones" => $datosAlumnos,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cicloEscolar" => $parametro_Ciclo,
            "grado" => $parametro_Grado,
            'grupo' => $parametro_Grupo,
            "parametro_CGTGrupo" => $parametro_CGTGrupo,
            'parametro_Titulo' => $parametro_Titulo,
            'parametro_NombreArchivo' => $parametro_NombreArchivo,
            'parametro_progClave' => $parametro_progClave,
            'parametro_planClave' => $parametro_planClave,
            'parametro_progNombre' => $parametro_progNombre,
            "conceptos" => $conceptos,        
            "totalDeAlumnos" => $totalDeAlumnos,
            "totalMaterias" => $totalMaterias,
            "alumnoGrupado" => $alumnoGrupado,
            "matAgrupado" => $matAgrupado,
            "tablaBody" => $tablaBody,
            "tipoReporte" => $request->tipoReporte
        ]);

        $pdf->setPaper('letter', 'landscape');
        // $pdf->setPaper('legal', 'landscape');

        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream('Resumen_de_calificaciones.pdf');
        return $pdf->download('Resumen_de_calificaciones.pdf');
    }

    public function generarTableTodasMaterias($matAgrupado, $resultado_collection, $alumnoGrupado)
    {
        $pos2 = 1;
        $res = [];
        $modelo = [];

        $sumaSeptiembre = 0;

        $modelo = $this->createMaterias($alumnoGrupado);

        foreach ($matAgrupado as $matClave => $valores_materias_actuales) {
            foreach ($valores_materias_actuales as $mate_actuales) {
                if ($mate_actuales->matClave == $matClave && $pos2++ == 1) {

                    $modelo['matClave'] = $mate_actuales->matClave;
                    
                    foreach ($resultado_collection as $item) {
                        if ($mate_actuales->matClave == $item->matClave) {
                            $grp = $item->matClave;



                            // CALIFICACIONES TRIMESTRALES 
                            $modelo[$grp.'_trimestre1_'.$item->clave_pago] = $item->inscTrimestre1;
                            $modelo[$grp.'_trimestre2_'.$item->clave_pago] = $item->inscTrimestre2;
                            $modelo[$grp.'_trimestre3_'.$item->clave_pago] = $item->inscTrimestre3;


                            // CALIFICACIONES DE RECUPERATIVOS 
                            $modelo[$grp.'_recuperativosTrimestre1_'.$item->clave_pago] = $item->trimestre1Sep;
                            $modelo[$grp.'_recuperativosTrimestre2_'.$item->clave_pago] = $item->trimestre2Sep;
                            $modelo[$grp.'_recuperativosTrimestre3_'.$item->clave_pago] = $item->trimestre3Sep;


                            // CALIFICACIONES FINALES MODELO(REAL) Y SEP 
                            $modelo[$grp.'_inscCalificacionFinalModelo_'.$item->clave_pago] = $item->inscCalificacionFinalModelo;                            
                            $modelo[$grp.'_inscCalificacionFinalSEP_'.$item->clave_pago] = $item->inscCalificacionFinalSEP;
                                                     
                        }                        
                    }

                    array_push($res, $modelo);
                    $modelo = $this->createMaterias($alumnoGrupado);
                }
            }
            $pos2 = 1;
        }

        return $res;
    }

    public function createMaterias($alumnoGrupado)
    {
        $contador = 1;
        $modelo = [];


        foreach($alumnoGrupado as $aluClave => $valoresalumno){
            foreach($valoresalumno as $valoresAlumno){
                // $modelo[$valoresAlumno->matClave.'_septiembre_'.$valoresAlumno->matClave] = $valoresAlumno->inscCalificacionSep;
            }
        }


        return $modelo;
    }
}
