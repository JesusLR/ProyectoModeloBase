<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Conceptoscursoestado;
use App\Models\Periodo;
use App\Models\Secundaria\Secundaria_inscritos;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class SecundariaResumenDeCalificacionesController extends Controller
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

        return view('secundaria.reportes.resumen_de_calificaciones.create', [
            "ubicaciones" => $ubicaciones,
            "conceptos" => $conceptos
        ]);
    }

    public function reporteResumenCalificacion(Request $request)
    {

        $periodo = Periodo::find($request->periodo_id);
        $perAnioPago = $periodo->perAnioPago;



        // filtra las calificaciones de acuerdo al mes que el usuario indique
        $mesEvaluar = $request->mesEvaluar;
        $conceptos = $request->conceptos;
        $gpoGrado = $request->gpoGrado;
        $gpoClave = $request->gpoClave;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;
        $tipoReporte = $request->tipoReporte;
        $bimestreEvaluar = $request->bimestreEvaluar;
        $trimestreEvaluar = $request->trimestreEvaluar;
        $tipoCalificacionVista = $request->tipoCalificacionVista;
        $tipoFinal = $request->tipoFinal;
        $modoCalificacion = $request->modoCalificacion;
        $tipoRecuperativo = $request->tipoRecuperativo;

        if ($tipoReporte == "porMes") {
            $parametro_Titulo = "RESUMEN DE CALIFICACIONES MENSUALES";
        }
        if ($tipoReporte == "porBimestre") {
            $parametro_Titulo = "RESUMEN DE CALIFICACIONES BIMESTRAL";
        }
        if ($tipoReporte == "porTrimestre") {
            $parametro_Titulo = "RESUMEN DE CALIFICACIONES TRIMESTRAL";
        }

        if ($tipoReporte == "califFinales") {

            if ($tipoFinal == "finaLModelo") {
                $parametro_Titulo = "RESUMEN DE CALIFICACIONES FINALES MODELO";
            }
            if ($tipoFinal == "finalSep") {
                $parametro_Titulo = "RESUMEN DE CALIFICACIONES FINALES SEP";
            }

            if ($tipoFinal == "finalAmbos") {
                $parametro_Titulo = "RESUMEN DE CALIFICACIONES FINALES";
            }
        }

        if ($tipoReporte == "califRecuperativos") {

            if ($tipoRecuperativo == "recuperativosTrimestre1") {
                $parametro_Titulo = "RESUMEN DE CALIFICACION RECUPERATIVO TRIMESTRE 1";
            }
            if ($tipoRecuperativo == "recuperativosTrimestre2") {
                $parametro_Titulo = "RESUMEN DE CALIFICACION RECUPERATIVO TRIMESTRE 2";
            }

            if ($tipoRecuperativo == "recuperativosTrimestre3") {
                $parametro_Titulo = "RESUMEN DE CALIFICACION RECUPERATIVO TRIMESTRE 3";
            }

            if ($tipoRecuperativo == "recuperativosTrimestreTodos") {
                $parametro_Titulo = "RESUMEN DE CALIFICACIONES RECUPERATIVO TRIMESTRES";
            }
        }

        $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

        if ($tipoCalificacionVista == "todasLasMaterias") {

            // llama al procedure de los alumnos a buscar
            $resultado_array =  DB::select("call procSecundariaCalificacionesGrupo(" . $perAnioPago . ", " . $gpoGrado . ", '" . $gpoClave . "', '" . $conceptos . "'," . $programa_id . "," . $plan_id . ")");

            $resultado_collection = collect($resultado_array);

            // si no hay datos muestra alerta
            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }


            $matAgrupado = $resultado_collection->groupBy('matClave');


            $resultado_registro = $resultado_array[0];
            $parametro_Grado = $resultado_registro->grado;
            $parametro_Grupo = $resultado_registro->grupo;
            $parametro_CGTGrupo = $resultado_registro->grupo;
            $parametro_Ciclo = $resultado_registro->ciclo_escolar;
            $parametro_progClave = $resultado_registro->progClave;
            $parametro_planClave = $resultado_registro->planClave;
            $parametro_progNombre = $resultado_registro->progNombre;
            $porcentajeSeptiembre = $resultado_registro->porc_septiembre / 10;
            $porcentajeOctubre = $resultado_registro->porc_octubre / 10;
            $porcentajeNoviembre = $resultado_registro->porc_noviembre / 10;
            $porcentajeDiciembre = $resultado_registro->porc_diciembre / 10;
            $porcentajeEnero = $resultado_registro->porc_enero / 10;
            $porcentajeFebrero = $resultado_registro->porc_febrero / 10;
            $porcentajeMarzo = $resultado_registro->porc_marzo / 10;
            $porcentajeAbril = $resultado_registro->porc_abril / 10;
            $porcentajeMayo = $resultado_registro->porc_mayo / 10;
            $porcentajeJunio = $resultado_registro->porc_junio / 10;

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
            $parametro_ubicacion_clave = $resultado_collection[0]->ubicacion;



            $totalMaterias = count($materia_alumos);


            $alumnoGrupado = $resultado_collection->groupBy('clave_pago');
            $totalDeAlumnos = count($alumnoGrupado);


            $parametro_NombreArchivo = 'pdf_secundaria_resumen_de_calificaciones_mes_cme2'; //nombre del archivo blade

            
            $tablaBody = $this->generarTableTodasMaterias($matAgrupado, $resultado_collection, $alumnoGrupado);

            // foreach($tablaBody as $value){
            //     return $value['DVE3_septiembre_11125343'];
            // }

            // view('reportes.pdf.secundaria.resumen_de_calificaciones.pdf_secundaria_resumen_de_calificaciones');
            $pdf = PDF::loadView('reportes.pdf.secundaria.resumen_de_calificaciones.' . $parametro_NombreArchivo, [
                "materia_alumos" => $materia_alumos,
                "calificaciones" => $resultado_collection,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $parametro_Ciclo,
                "grado" => $parametro_Grado,
                'grupo' => $parametro_Grupo,
                "parametro_CGTGrupo" => $parametro_CGTGrupo,
                "titulo" => $parametro_Titulo,
                'parametro_Titulo' => $parametro_Titulo,
                'parametro_NombreArchivo' => $parametro_NombreArchivo,
                'parametro_progClave' => $parametro_progClave,
                'parametro_planClave' => $parametro_planClave,
                'parametro_progNombre' => $parametro_progNombre,
                // 'calificacionesInscritos' => $calificacionesInscritos,
                "mesEvaluar" => $mesEvaluar,
                // "datos_cabecera" => $datos_cabecera,
                "conceptos" => $conceptos,
                "tipoReporte" => $tipoReporte,
                "bimestreEvaluar" => $bimestreEvaluar,
                "trimestreEvaluar" => $trimestreEvaluar,
                "tipoCalificacionVista" => $tipoCalificacionVista,
                "tipoFinal" => $tipoFinal,
                "modoCalificacion" => $modoCalificacion,
                "porcentajeSeptiembre" => $porcentajeSeptiembre,
                "porcentajeOctubre" => $porcentajeOctubre,
                "porcentajeNoviembre" => $porcentajeNoviembre,
                "porcentajeDiciembre" => $porcentajeDiciembre,
                "porcentajeEnero" => $porcentajeEnero,
                "porcentajeFebrero" => $porcentajeFebrero,
                "porcentajeMarzo" => $porcentajeMarzo,
                "porcentajeAbril" => $porcentajeAbril,
                "porcentajeMayo" => $porcentajeMayo,
                "porcentajeJunio" => $porcentajeJunio,
                "totalDeAlumnos" => $totalDeAlumnos,
                "totalMaterias" => $totalMaterias,
                "tipoRecuperativo" => $tipoRecuperativo,
                "alumnoGrupado" => $alumnoGrupado,
                "matAgrupado" => $matAgrupado,
                "tablaBody" => $tablaBody
            ]);

            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream('Resumen_de_calificaciones.pdf');
            return $pdf->download('Resumen_de_calificaciones.pdf');
        }

        if ($tipoCalificacionVista == "matOficialesSep") {

            $materiaNombreSep =  DB::select("call procSecundariaCalificacionesSEPGrupo(" . $perAnioPago . ", " . $gpoGrado . ", '" . $gpoClave . "', '" . $conceptos . "'," . $programa_id . "," . $plan_id . ")");
            $resultadoMatSep_collection = collect($materiaNombreSep);

            // si no hay datos muestra alerta
            if ($resultadoMatSep_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $alumnosInscritos = $resultadoMatSep_collection->groupBy('clave_pago');
            $totalDeAlumnos = count($alumnosInscritos);



            $matNombreColumna = $resultadoMatSep_collection->groupBy('matNombreColumna');
            $matClave = $resultadoMatSep_collection->groupBy('matClave');

            $totalMaterias = count($matClave);

            $resultado_registro = $resultadoMatSep_collection[0];
            $porcentajeSeptiembre = $resultado_registro->porc_septiembre / 10;
            $porcentajeOctubre = $resultado_registro->porc_octubre / 10;
            $porcentajeNoviembre = $resultado_registro->porc_noviembre / 10;
            $porcentajeDiciembre = $resultado_registro->porc_diciembre / 10;
            $porcentajeEnero = $resultado_registro->porc_enero / 10;
            $porcentajeFebrero = $resultado_registro->porc_febrero / 10;
            $porcentajeMarzo = $resultado_registro->porc_marzo / 10;
            $porcentajeAbril = $resultado_registro->porc_abril / 10;
            $porcentajeMayo = $resultado_registro->porc_mayo / 10;
            $porcentajeJunio = $resultado_registro->porc_junio / 10;

            $parametro_Grado = $resultado_registro->grado;
            $parametro_Grupo = $resultado_registro->grupo;
            $parametro_CGTGrupo = $resultado_registro->grupo;
            $parametro_Ciclo = $resultado_registro->ciclo_escolar;
            $parametro_progClave = $resultado_registro->progClave;
            $parametro_planClave = $resultado_registro->planClave;
            $parametro_progNombre = $resultado_registro->progNombre;
          

            if ($resultadoMatSep_collection[0]->ubicacion == 'CME') {
                
                if ($tipoReporte == "porMes" || $tipoReporte == "porBimestre") {
                    // view('reportes.pdf.secundaria.resumen_de_calificaciones.pdf_secundaria_resumen_de_calificaciones_sep_mes_cme_nuevo2');
                    $parametro_NombreArchivo = 'pdf_secundaria_resumen_de_calificaciones_sep_mes_cme_nuevo2'; //nombre del archivo blade
                }

                if ($tipoReporte == "porTrimestre" || $tipoReporte == "califRecuperativos" || $tipoReporte == "califFinales") {
                    $parametro_NombreArchivo = 'pdf_secundaria_resumen_de_calificaciones_tri_cme_sep_nuevo2'; //nombre del archivo blade 
                    // view('reportes.pdf.secundaria.resumen_de_calificaciones.pdf_secundaria_resumen_de_calificaciones_tri_cme_sep_nuevo2');
                } 

                // if ($tipoReporte == "califRecuperativos") {
                //     if ($request->tipoRecuperativo == "recuperativosTrimestre1" || $request->tipoRecuperativo == "recuperativosTrimestre2" || $request->tipoRecuperativo == "recuperativosTrimestre3") {
                //         $parametro_NombreArchivo = 'pdf_secundaria_resumen_de_calificaciones_tri_sep_recuperativos'; //nombre del archivo blade    
                //     }
                // }


                // if ($tipoReporte == "califFinales") {
                //     if ($tipoFinal == "finaLModelo" || $tipoFinal == "finalSep") {
                //         // view('reportes.pdf.secundaria.resumen_de_calificaciones.pdf_secundaria_resumen_de_calificaciones_finales_sep');
                //         $parametro_NombreArchivo = 'pdf_secundaria_resumen_de_calificaciones_finales_sep'; //nombre del archivo blade

                //     } else {
                //         $parametro_NombreArchivo = 'pdf_secundaria_resumen_de_calificaciones_ambos'; //nombre del archivo blade

                //     }
                // }
            }

            if ($resultadoMatSep_collection[0]->ubicacion == 'CVA') {
              
                $parametro_NombreArchivo = 'pdf_secundaria_resumen_de_calificaciones_sep_cva'; //nombre del archivo blade
                // view('reportes.pdf.secundaria.resumen_de_calificaciones.pdf_secundaria_resumen_de_calificaciones_sep_cva');
            }

            $tablaBody = $this->generarTableMateriasSEP($matNombreColumna, $resultadoMatSep_collection, $alumnosInscritos);


            $tablaBody2 = $this->generarTableMateriasSEPTrimestral($matNombreColumna, $resultadoMatSep_collection, $alumnosInscritos);



            $pdf = PDF::loadView('reportes.pdf.secundaria.resumen_de_calificaciones.' . $parametro_NombreArchivo, [
                // "materia_alumos" => $materia_alumos,
                "calificaciones" => $resultadoMatSep_collection,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $parametro_Ciclo,
                "grado" => $parametro_Grado,
                'grupo' => $parametro_Grupo,
                "titulo" => $parametro_Titulo,
                'parametro_Titulo' => $parametro_Titulo,
                'parametro_NombreArchivo' => $parametro_NombreArchivo,
                'parametro_progClave' => $parametro_progClave,
                'parametro_planClave' => $parametro_planClave,
                'parametro_progNombre' => $parametro_progNombre,
                // 'calificacionesInscritos' => $calificacionesInscritos,
                "mesEvaluar" => $mesEvaluar,
                // "datos_cabecera" => $datos_cabecera,
                "conceptos" => $conceptos,
                "tipoReporte" => $tipoReporte,
                "bimestreEvaluar" => $bimestreEvaluar,
                "trimestreEvaluar" => $trimestreEvaluar,
                "tipoCalificacionVista" => $tipoCalificacionVista,
                "matNombreColumna" => $matNombreColumna,
                "matClave" => $matClave,
                "tipoFinal" => $tipoFinal,
                "modoCalificacion" => $modoCalificacion,
                "porcentajeSeptiembre" => $porcentajeSeptiembre,
                "porcentajeOctubre" => $porcentajeOctubre,
                "porcentajeNoviembre" => $porcentajeNoviembre,
                "porcentajeDiciembre" => $porcentajeDiciembre,
                "porcentajeEnero" => $porcentajeEnero,
                "porcentajeFebrero" => $porcentajeFebrero,
                "porcentajeMarzo" => $porcentajeMarzo,
                "porcentajeAbril" => $porcentajeAbril,
                "porcentajeMayo" => $porcentajeMayo,
                "porcentajeJunio" => $porcentajeJunio,
                "totalMaterias" => $totalMaterias,
                "totalDeAlumnos" => $totalDeAlumnos,
                "parametro_ubicacion_clave" => $resultadoMatSep_collection[0]->ubicacion,
                "tipoRecuperativo" => $request->tipoRecuperativo,
                "alumnosInscritos" => $alumnosInscritos,
                "tablaBody" => $tablaBody,
                "tablaBody2" => $tablaBody2
            ]);

            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream('Resumen_de_calificaciones.pdf');
            return $pdf->download('Resumen_de_calificaciones.pdf');
        }
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


                            // CALIFICACIONES MENSUALES 
                            $modelo[$grp.'_septiembre_'.$item->clave_pago] = $item->inscCalificacionSep;
                            $modelo[$grp.'_octubre_'.$item->clave_pago] = $item->inscCalificacionOct;
                            $modelo[$grp.'_noviembre_'.$item->clave_pago] = $item->inscCalificacionNov;
                            $modelo[$grp.'_diciembre_'.$item->clave_pago] = $item->inscCalificacionDic;
                            $modelo[$grp.'_enero_'.$item->clave_pago] = $item->inscCalificacionEne;
                            $modelo[$grp.'_febrero_'.$item->clave_pago] = $item->inscCalificacionFeb;
                            $modelo[$grp.'_marzo_'.$item->clave_pago] = $item->inscCalificacionMar;
                            $modelo[$grp.'_abril_'.$item->clave_pago] = $item->inscCalificacionAbr;
                            $modelo[$grp.'_mayo_'.$item->clave_pago] = $item->inscCalificacionMay;
                            $modelo[$grp.'_junio_'.$item->clave_pago] = $item->inscCalificacionJun;

                            // CALIFICACIONES BIMESTRALES 
                            $modelo[$grp.'_bimestre1_'.$item->clave_pago] = $item->inscPromedioBimestre1;
                            $modelo[$grp.'_bimestre2_'.$item->clave_pago] = $item->inscPromedioBimestre2;
                            $modelo[$grp.'_bimestre3_'.$item->clave_pago] = $item->inscPromedioBimestre3;
                            $modelo[$grp.'_bimestre4_'.$item->clave_pago] = $item->inscPromedioBimestre4;
                            $modelo[$grp.'_bimestre5_'.$item->clave_pago] = $item->inscPromedioBimestre5;

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



                            // BASE PORCENTAJE 
                            $modelo[$grp.'_septiembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeSep;
                            $modelo[$grp.'_octubre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeOct;
                            $modelo[$grp.'_noviembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeNov;
                            $modelo[$grp.'_diciembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeDic;
                            $modelo[$grp.'_enero_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeEne;
                            $modelo[$grp.'_febrero_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeFeb;
                            $modelo[$grp.'_marzo_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeMar;
                            $modelo[$grp.'_abril_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeAbr;
                            $modelo[$grp.'_mayo_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeMay;
                            $modelo[$grp.'_junio_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeJun;


                                                     
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


    public function generarTableMateriasSEP($matNombreColumna, $resultadoMatSep_collection, $alumnosInscritos)
    {
        $pos2 = 1;
        $res = [];
        $modelo = [];

        $sumaSeptiembre = 0;

        $modelo = $this->createMaterias($alumnosInscritos);

        foreach ($matNombreColumna as $matNombreColumna => $valores_materias_actuales) {
            foreach ($valores_materias_actuales as $mate_actuales) {
                if ($mate_actuales->matNombreColumna == $matNombreColumna && $pos2++ == 1) {

                    $modelo['matNombreColumna'] = $mate_actuales->matNombreColumna;
                    
                    foreach ($resultadoMatSep_collection as $item) {
                        if ($mate_actuales->matNombreColumna == $item->matNombreColumna) {
                            $grp = $item->matNombreColumna;


                            // CALIFICACIONES MENSUALES 
                            $modelo[$grp.'_septiembre_'.$item->clave_pago] = $item->inscCalificacionSep;
                            $modelo[$grp.'_octubre_'.$item->clave_pago] = $item->inscCalificacionOct;
                            $modelo[$grp.'_noviembre_'.$item->clave_pago] = $item->inscCalificacionNov;
                            $modelo[$grp.'_diciembre_'.$item->clave_pago] = $item->inscCalificacionDic;
                            $modelo[$grp.'_enero_'.$item->clave_pago] = $item->inscCalificacionEne;
                            $modelo[$grp.'_febrero_'.$item->clave_pago] = $item->inscCalificacionFeb;
                            $modelo[$grp.'_marzo_'.$item->clave_pago] = $item->inscCalificacionMar;
                            $modelo[$grp.'_abril_'.$item->clave_pago] = $item->inscCalificacionAbr;
                            $modelo[$grp.'_mayo_'.$item->clave_pago] = $item->inscCalificacionMay;
                            $modelo[$grp.'_junio_'.$item->clave_pago] = $item->inscCalificacionJun;

                            // CALIFICACIONES BIMESTRALES 
                            $modelo[$grp.'_bimestre1_'.$item->clave_pago] = $item->inscPromedioBimestre1;
                            $modelo[$grp.'_bimestre2_'.$item->clave_pago] = $item->inscPromedioBimestre2;
                            $modelo[$grp.'_bimestre3_'.$item->clave_pago] = $item->inscPromedioBimestre3;
                            $modelo[$grp.'_bimestre4_'.$item->clave_pago] = $item->inscPromedioBimestre4;
                            $modelo[$grp.'_bimestre5_'.$item->clave_pago] = $item->inscPromedioBimestre5;

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



                            // BASE PORCENTAJE 
                            $modelo[$grp.'_septiembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeSep;
                            $modelo[$grp.'_octubre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeOct;
                            $modelo[$grp.'_noviembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeNov;
                            $modelo[$grp.'_diciembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeDic;
                            $modelo[$grp.'_enero_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeEne;
                            $modelo[$grp.'_febrero_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeFeb;
                            $modelo[$grp.'_marzo_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeMar;
                            $modelo[$grp.'_abril_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeAbr;
                            $modelo[$grp.'_mayo_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeMay;
                            $modelo[$grp.'_junio_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeJun;


                            // sep a nov 
                            $modelo[$grp.'_puntosobtenidos_Sep_'.$item->clave_pago] = $item->puntosobtenidos_Sep_;
                            $modelo[$grp.'_puntosREPROBAR_Sep_'.$item->clave_pago] = $item->puntosREPROBAR_Sep_;

                            $modelo[$grp.'_puntosobtenidos_Oct_'.$item->clave_pago] = $item->puntosobtenidos_Oct_;
                            $modelo[$grp.'_puntosREPROBAR_Oct_'.$item->clave_pago] = $item->puntosREPROBAR_Oct_;

                            $modelo[$grp.'_puntosobtenidos_Nov_'.$item->clave_pago] = $item->puntosobtenidos_Nov_;
                            $modelo[$grp.'_puntosREPROBAR_Nov_'.$item->clave_pago] = $item->puntosREPROBAR_Nov_;

                            // ene a mar
                            $modelo[$grp.'_puntosREPROBAR_Ene_'.$item->clave_pago] = $item->puntosREPROBAR_Ene_;
                            $modelo[$grp.'_puntosREPROBAR_Ene_'.$item->clave_pago] = $item->puntosREPROBAR_Ene_;

                            $modelo[$grp.'_puntosobtenidos_Feb_'.$item->clave_pago] = $item->puntosobtenidos_Feb_;
                            $modelo[$grp.'_puntosREPROBAR_Feb_'.$item->clave_pago] = $item->puntosREPROBAR_Feb_;

                            $modelo[$grp.'_puntosobtenidos_Mar_'.$item->clave_pago] = $item->puntosobtenidos_Mar_;
                            $modelo[$grp.'_puntosREPROBAR_Mar_'.$item->clave_pago] = $item->puntosREPROBAR_Mar_;

                            // abr a jun 
                            $modelo[$grp.'_puntosobtenidos_Abr_'.$item->clave_pago] = $item->puntosobtenidos_Abr_;
                            $modelo[$grp.'_puntosREPROBAR_Abr_'.$item->clave_pago] = $item->puntosREPROBAR_Abr_;

                            $modelo[$grp.'_puntosobtenidos_May_'.$item->clave_pago] = $item->puntosobtenidos_May_;
                            $modelo[$grp.'_puntosREPROBAR_May_'.$item->clave_pago] = $item->puntosREPROBAR_May_;

                            $modelo[$grp.'_puntosobtenidos_Jun_'.$item->clave_pago] = $item->puntosobtenidos_Jun_;
                            $modelo[$grp.'_puntosREPROBAR_Jun_'.$item->clave_pago] = $item->puntosREPROBAR_Jun_;




                                                     
                        }                        
                    }

                    array_push($res, $modelo);
                    $modelo = $this->createMaterias($alumnosInscritos);
                }
            }
            $pos2 = 1;
        }

        return $res;
    }

    public function generarTableMateriasSEPTrimestral($matNombreColumna, $resultadoMatSep_collection, $alumnosInscritos)
    {
        $pos2 = 1;
        $res = [];
        $modelo = [];

        $sumaSeptiembre = 0;

        $modelo = $this->createMaterias($alumnosInscritos);

        foreach ($matNombreColumna as $matNombreColumna => $valores_materias_actuales) {
            foreach ($valores_materias_actuales as $mate_actuales) {
                if ($mate_actuales->matNombreColumna == $matNombreColumna && $pos2++ == 1) {

                    $modelo['matNombreColumna'] = $mate_actuales->matNombreColumna;
                    
                    foreach ($resultadoMatSep_collection as $item) {
                        if ($mate_actuales->matNombreColumna == $item->matNombreColumna) {
                            $grp = $item->matNombreColumna;

                            // if($grp != "EF.VESP" && $grp != "EDU.FIS" && $grp != "ARTES"){
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



                                // BASE PORCENTAJE 
                                $modelo[$grp.'_septiembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeSep;
                                $modelo[$grp.'_octubre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeOct;
                                $modelo[$grp.'_noviembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeNov;
                                $modelo[$grp.'_diciembre_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeDic;
                                $modelo[$grp.'_enero_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeEne;
                                $modelo[$grp.'_febrero_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeFeb;
                                $modelo[$grp.'_marzo_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeMar;
                                $modelo[$grp.'_abril_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeAbr;
                                $modelo[$grp.'_mayo_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeMay;
                                $modelo[$grp.'_junio_porcentaje_'.$item->clave_pago] = $item->Telnet_inscCalificacionPorcentajeJun;
                            // }

                            


                                                     
                        }                        
                    }

                    array_push($res, $modelo);
                    $modelo = $this->createMaterias($alumnosInscritos);
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