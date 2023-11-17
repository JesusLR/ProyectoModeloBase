<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use PDF;

class BachillerPuntosPerdidosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        return view('bachiller.reportes.puntos_perdidos.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        if($request->vistaDelReporte == 1){

            // dd($request->periodo_id, $request->plan_id, $request->matSemestreReporte, $request->claveGrupo);
            $llamar_procedimiento = DB::select("call procBachillerPuntosPerdidosYuc(
                " . $request->periodo_id . ",
                " . $request->plan_id . ",
                " . $request->matSemestreReporte . ",
                '" . $request->claveGrupo . "'
            )");
    
            $resultado_collection = collect($llamar_procedimiento);
    
                   // si no hay datos muestra alerta 
            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No puntos evidencias capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
    
            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');
            $fechaHoy = $fechaActual->format('Y-m-d');
            
    
    
            $periodo = Utils::fecha_string($resultado_collection[0]->fecha_inicio, $resultado_collection[0]->fecha_inicio) . ' al ' . Utils::fecha_string($resultado_collection[0]->fecha_final, $resultado_collection[0]->fecha_final) . ' (' . $resultado_collection[0]->perNumero . '-' . $resultado_collection[0]->perAnio . ')';
            $ubicacion = $resultado_collection[0]->ubiClave.'-'.$resultado_collection[0]->ubiNombre;
            $carrera = $resultado_collection[0]->depClave.' ('.$resultado_collection[0]->planClave.') '.$resultado_collection[0]->progNombre;
            $gradoGrupo = 'Semestre: '.$request->matSemestreReporte.'          Grupo: '.$request->claveGrupo;
    
            $clave_de_las_materias = $resultado_collection->groupBy('matClave');
            $clave_del_alumno = $resultado_collection->groupBy('aluClave');
            $materia_id = $resultado_collection->groupBy('bachiller_materia_id');


            $tableBody = $this->generarTableDeMaterias($materia_id, $resultado_collection, $clave_del_alumno);

            $nombre_pdf = "pdf_bachiller_puntos_perdidos_nocomplementarias";
            // view('reportes.pdf.bachiller.puntos_perdidos.pdf_bachiller_puntos_perdidos_nocomplementarias');
            $pdf = PDF::loadView('reportes.pdf.bachiller.puntos_perdidos.' . $nombre_pdf, [
                "fechaActual"       => $fechaHoy,
                "horaActual"        => $fechaActual->format('H:i:s'),
                "matSemestre"       => $request->matSemestreReporte,
                "periodo"           => $periodo,
                "ubicacion"         => $ubicacion,
                "carrera"           => $carrera,
                "gradoGrupo"          => $gradoGrupo,
                "resultado_collection"      => $resultado_collection,
                "PDF"   => $nombre_pdf,
                "clave_de_las_materias" => $clave_de_las_materias,
                "clave_del_alumno" => $clave_del_alumno,
                "materia_id" => $materia_id,
                "tableBody" => $tableBody
    
            ]);
        }      

        if($request->vistaDelReporte == 2){

            $llamar_procedimiento = DB::select("call procBachillerPuntosPerdidosComplementariasYuc(
                " . $request->periodo_id . ",
                " . $request->plan_id . ",
                " . $request->matSemestreReporte . ",
                '" . $request->claveGrupo . "'
            )");
    
            $resultado_collection = collect($llamar_procedimiento);
    
                   // si no hay datos muestra alerta 
            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No puntos evidencias capturadas para este grupo. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
    
            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');
            $fechaHoy = $fechaActual->format('Y-m-d');
            
    
    
            $periodo = Utils::fecha_string($resultado_collection[0]->fecha_inicio, $resultado_collection[0]->fecha_inicio) . ' al ' . Utils::fecha_string($resultado_collection[0]->fecha_final, $resultado_collection[0]->fecha_final) . ' (' . $resultado_collection[0]->perNumero . '-' . $resultado_collection[0]->perAnio . ')';
            $ubicacion = $resultado_collection[0]->ubiClave.'-'.$resultado_collection[0]->ubiNombre;
            $carrera = $resultado_collection[0]->depClave.' ('.$resultado_collection[0]->planClave.') '.$resultado_collection[0]->progNombre;
            $gradoGrupo = 'Semestre: '.$request->matSemestreReporte.'          Grupo: '.$request->claveGrupo;
    
            $bachiller_materia_acd_id = $resultado_collection->groupBy('bachiller_materia_acd_id');
            $clave_del_alumno = $resultado_collection->groupBy('aluClave');

            $tablaBody = $this->generarTableDeMateriasACD($bachiller_materia_acd_id, $resultado_collection, $clave_del_alumno);

            $nombre_pdf = "pdf_bachiller_puntos_perdidos_sicomplementarias";
            // view('reportes.pdf.bachiller.puntos_perdidos.pdf_bachiller_puntos_perdidos_sicomplementarias');
            $pdf = PDF::loadView('reportes.pdf.bachiller.puntos_perdidos.' . $nombre_pdf, [
                "fechaActual"       => $fechaHoy,
                "horaActual"        => $fechaActual->format('H:i:s'),
                "matSemestre"       => $request->matSemestreReporte,
                "periodo"           => $periodo,
                "ubicacion"         => $ubicacion,
                "carrera"           => $carrera,
                "gradoGrupo"          => $gradoGrupo,
                "resultado_collection"      => $resultado_collection,
                "PDF"   => $nombre_pdf,
                "clave_de_las_materias" => $bachiller_materia_acd_id,
                "clave_del_alumno" => $clave_del_alumno,
                "tablaBody" => $tablaBody
     
            ]);
        }     


        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($nombre_pdf . '.pdf');
        return $pdf->download($nombre_pdf  . '.pdf');
    }


    public function generarTableDeMateriasACD($grupos_bachiller_materia_acd_id, $resultado_collection, $alumnoGrupado)
    {
        $pos2 = 1;
        $res = [];
        $modelo = [];

        $sumaSeptiembre = 0;

        $modelo = $this->createMaterias($alumnoGrupado);

        foreach ($grupos_bachiller_materia_acd_id as $bachiller_materia_acd_id => $valores_materias_actuales) {
            foreach ($valores_materias_actuales as $mate_actuales) {
                if ($mate_actuales->bachiller_materia_acd_id == $bachiller_materia_acd_id && $pos2++ == 1) {

                    $modelo['matClave'] = $mate_actuales->matClave;
                    $modelo['bachiller_materia_acd_id'] = $mate_actuales->bachiller_materia_acd_id;

                    
                    foreach ($resultado_collection as $item) {
                        if ($mate_actuales->matClave == $item->matClave) {
                            $grp = $item->bachiller_materia_acd_id;


                            // CALIFICACIONES MENSUALES 
                            $modelo[$grp.'_grupo_alumno_'.$item->aluClave] = $item->bachiller_grupo_id;
                     
                            $modelo[$grp.'_grupo_materia_'.$item->aluClave] = $item->bachiller_materia_id;
                            $modelo[$grp.'_periodo_'.$item->aluClave] = $item->periodo_id;
                            $modelo[$grp.'_plan_'.$item->aluClave] = $item->plan_id;
                            $modelo[$grp.'_matComplementaria_'.$item->aluClave] = $item->gpoMatComplementaria;
                            $modelo[$grp.'_inscrito_id_'.$item->aluClave] = $item->bachiller_inscrito_id;

                                                     
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

    public function generarTableDeMaterias($bachiller_materia_id, $resultado_collection, $alumnoGrupado)
    {
        $pos2 = 1;
        $res = [];
        $modelo = [];

        $sumaSeptiembre = 0;

        $modelo = $this->createMaterias($alumnoGrupado);

        foreach ($bachiller_materia_id as $bachiller_materia_id => $valores_materias_actuales) {
            foreach ($valores_materias_actuales as $mate_actuales) {
                if ($mate_actuales->bachiller_materia_id == $bachiller_materia_id && $pos2++ == 1) {

                    $modelo['matClave'] = $mate_actuales->matClave;
                    $modelo['bachiller_materia_id'] = $mate_actuales->bachiller_materia_id;

                    
                    foreach ($resultado_collection as $item) {
                        if ($mate_actuales->matClave == $item->matClave) {
                            $grp = $item->bachiller_materia_id;


                            // CALIFICACIONES MENSUALES 
                            $modelo[$grp.'_grupo_alumno_'.$item->aluClave] = $item->bachiller_grupo_id;
                     
                            $modelo[$grp.'_periodo_'.$item->aluClave] = $item->periodo_id;
                            $modelo[$grp.'_plan_'.$item->aluClave] = $item->plan_id;
                            $modelo[$grp.'_inscrito_id_'.$item->aluClave] = $item->bachiller_inscrito_id;

                                                     
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
