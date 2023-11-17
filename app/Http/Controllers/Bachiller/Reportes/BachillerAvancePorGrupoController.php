<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\clases\bachiller\Actualiza_inscritos_gpo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerAvancePorGrupoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        // $para_actualizar_el_total = Actualiza_inscritos_gpo::total_inscritos();

        // Mostrar el conmbo solo las ubicaciones correspondientes 
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();
        
        return view('bachiller.reportes.avance_por_grupo.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {

        // dd($request->periodo_id, $request->programa_id, $request->plan_id, $request->matSemestreBac);

        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');

     
        //Recoleccion de parametros
        $periodo = Periodo::findOrFail($request->periodo_id);
        $ubicacion1 = Ubicacion::findOrFail($request->ubicacion_id);
        $departamento1 = Departamento::findOrFail($request->departamento_id);
        $plan1 = Plan::findOrFail($request->plan_id);
        $programa1 = Programa::findOrFail($request->programa_id);
        $tipo_hoja = $request->tipo_hoja;
        
        
        if($periodo->perAnio >= 2022){
            // return $request->plan_id;
            $resultado_array =  DB::select("call procBachillerAvanceGradoYucatan( 
                " . $request->periodo_id . ",
                " . $request->matSemestreBac . ",
                " . $request->programa_id . ",
                " . $request->plan_id . ")");
            $resultado_collection = collect($resultado_array);


            // actualizamos la cantidad de inscritos 
            $grupos = $resultado_collection->groupBy('grupo_id');
            foreach($grupos as $grupo_id => $valores){
                $sp = DB::select("call procBachillerActualizaTotalInscritos(".$grupo_id.")");
            }
    
    
            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
    
            $ubicacion = $ubicacion1->ubiClave . '-' . $ubicacion1->ubiNombre;
            $departamento = $departamento1->depClave;
            $plan = $plan1->planClave;
            $programa = $programa1->progNombre;
            $inicioPeriodo = $periodo->perFechaInicial;
            $finalPeriodo = $periodo->perFechaFinal;
    
            $grupos_actuales_existentes = $resultado_collection->groupBy('cgtGrupo');
            $materias_actuales_existentes = $resultado_collection->groupBy('matClave');
            $tablaBody = $this->generarTablaBody2022($materias_actuales_existentes, $resultado_collection, $grupos_actuales_existentes);


             // para materias ACD 
            $resultado_array_acd =  DB::select("call procBachillerAvanceGradoYucatanSoloACD( 
                " . $request->periodo_id . ",
                " . $request->matSemestreBac . ",
                " . $request->programa_id . ",
                " . $request->plan_id . ")");
            $resultado_collection_acd = collect($resultado_array_acd);

             // actualizamos la cantidad de inscritos 
             $gruposACD = $resultado_collection_acd->groupBy('grupo_id');
             foreach($gruposACD as $grupo_id => $valores){
                 $sps = DB::select("call procBachillerActualizaTotalInscritos(".$grupo_id.")");
             }

            $materiasComplementarias_actuales_existentes = $resultado_collection_acd->groupBy('gpoMatComplementaria');
            $bachiller_materia_acd_id = $resultado_collection_acd->groupBy('bachiller_materia_acd_id');

            $grupos_actuales_acd = $resultado_collection_acd->groupBy('gpoClave');
            $grupos_id_actuales = $resultado_collection_acd->groupBy('grupo_id');



            
            $tablaBodyACD = $this->generarTablaBodyACD2022($bachiller_materia_acd_id, $resultado_collection_acd, $grupos_actuales_acd);

            $parametro_NombreArchivo = 'pdf_bachiller_avance_por_grupo_2022_2';
            // view('reportes.pdf.bachiller.avance_por_grupo.pdf_bachiller_avance_por_grupo_2022_2')
            $pdf = PDF::loadView('reportes.pdf.bachiller.avance_por_grupo.' . $parametro_NombreArchivo, [
                "fechaActual"       => $fechaActual,
                "horaActual"        => $fechaActual->format('H:i:s'),
                "matSemestre"       => $request->matSemestreBac,
                // "materias"          => $materias,
                // "bachiller_grupos"  => $bachiller_grupos,
                // "bachiller_mate"    => $bachiller_mate,
                "fechaHoy"       => $fechaActual->format('Y-m-d'),
                "inicioPeriodo"     => $inicioPeriodo,
                "finalPeriodo"      => $finalPeriodo,
                "ubicacion"         => $ubicacion,
                "departamento"      => $departamento,
                "plan"              => $plan,
                "programa"          => $programa,
                "grupos_actuales_existentes"    => $grupos_actuales_existentes,
                "materias_actuales_existentes"  => $materias_actuales_existentes,
                "resultado_collection"      => $resultado_collection,
                "tablaBody"   => $tablaBody,
                "tablaBodyACD"   => $tablaBodyACD,
                "bachiller_materia_acd_id" => $bachiller_materia_acd_id,
                "grupos_actuales_acd" => $grupos_actuales_acd,
                "resultado_collection_acd" => $resultado_collection_acd,
                "tipo_acd" => $request->tipo_acd
    
            ]);
            
        }else{

            $resultado_array =  DB::select("call procBachillerAvanceGradoYucatan( 
                " . $request->periodo_id . ",
                " . $request->matSemestreBac . ",
                " . $request->programa_id . ",
                " . $request->plan_id . ")");
            $resultado_collection = collect($resultado_array);
    
    
            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
    
            $ubicacion = $ubicacion1->ubiClave . '-' . $ubicacion1->ubiNombre;
            $departamento = $departamento1->depClave;
            $plan = $plan1->planClave;
            $programa = $programa1->progNombre;
            $inicioPeriodo = $periodo->perFechaInicial;
            $finalPeriodo = $periodo->perFechaFinal;
    
            $grupos_actuales_existentes = $resultado_collection->groupBy('gpoClave');
            $materias_actuales_existentes = $resultado_collection->groupBy('matClave');
            $materiasComplementarias_actuales_existentes = $resultado_collection->groupBy('gpoMatComplementaria');
            $tablaBody = $this->generarTablaBody2021($materias_actuales_existentes, $resultado_collection, $grupos_actuales_existentes);

            $parametro_NombreArchivo = 'pdf_bachiller_avance_por_grupo';
            // view('reportes.pdf.bachiller.avance_por_grupo.pdf_bachiller_avance_por_grupo')
            $pdf = PDF::loadView('reportes.pdf.bachiller.avance_por_grupo.' . $parametro_NombreArchivo, [
                "fechaActual"       => $fechaActual,
                "horaActual"        => $fechaActual->format('H:i:s'),
                "matSemestre"       => $request->matSemestreBac,
                // "materias"          => $materias,
                // "bachiller_grupos"  => $bachiller_grupos,
                // "bachiller_mate"    => $bachiller_mate,
                "fechaHoy"       => $fechaActual->format('Y-m-d'),
                "inicioPeriodo"     => $inicioPeriodo,
                "finalPeriodo"      => $finalPeriodo,
                "ubicacion"         => $ubicacion,
                "departamento"      => $departamento,
                "plan"              => $plan,
                "programa"          => $programa,
                "grupos_actuales_existentes"    => $grupos_actuales_existentes,
                "materias_actuales_existentes"  => $materias_actuales_existentes,
                "resultado_collection"      => $resultado_collection,
                "tablaBody"   => $tablaBody
    
            ]);
        }
        

        $pdf->setPaper($tipo_hoja, 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    public function generarTablaBody2021($materias_actuales_existentes, $resultado_collection, $grupos_actuales_existentes)
    {
        $pos = 0;
        $res = [];
        $modelo = [];

        $modelo = $this->createGrupos($grupos_actuales_existentes);

        foreach ($materias_actuales_existentes as $materias_actuales => $valores_materias_actuales) {
            foreach ($valores_materias_actuales as $mate_actuales) {
                if ($mate_actuales->matClave == $materias_actuales && $pos++ == 1) {

                    $modelo['matClave'] = $mate_actuales->matClave;
                    $modelo['matNombre'] = $mate_actuales->matNombre;
                    // $modelo['gpoMatComplementaria'] = $mate_actuales->gpoMatComplementaria;
                    
                    foreach ($resultado_collection as $item) {
                        if ($mate_actuales->matClave == $item->matClave) {
                            $grp = $item->cgtGrupo;
                            $modelo[$grp.'_prog'] = $item->puntos_programados;
                            $modelo[$grp.'_real'] = $item->puntos_reales;
                            // $modelo[$grp.'materia_acd'] = $item->bachiller_materia_acd_id;

                        }
                    }

                    array_push($res, $modelo);
                    $modelo = $this->createGrupos($grupos_actuales_existentes);
                }
            }
            $pos = 0;
        }

        return $res;
    }

    public function generarTablaBody2022($materias_actuales_existentes, $resultado_collection, $grupos_actuales_existentes)
    {
        $pos = 0;
        $res = [];
        $modelo2 = [];

        $modelo2 = $this->createGrupos($grupos_actuales_existentes);

        foreach ($materias_actuales_existentes as $materias_actuales => $valores_materias_actuales) {
            foreach ($valores_materias_actuales as $mate_actuales) {
                if ($mate_actuales->matClave == $materias_actuales && $pos++ == 1) {

                    $modelo2['matClave'] = $mate_actuales->matClave;
                    $modelo2['matNombre'] = $mate_actuales->matNombre;
                    $modelo2['gpoMatComplementaria'] = $mate_actuales->gpoMatComplementaria;
                    
                    foreach ($resultado_collection as $item) {
                        if ($mate_actuales->matClave == $item->matClave) {
                            $grp = $item->cgtGrupo;
                            $modelo2[$grp.'_prog'] = $item->puntos_programados;
                            $modelo2[$grp.'_real'] = $item->puntos_reales;
                            $modelo2[$grp.'materia_acd'] = $item->bachiller_materia_acd_id;

                        }
                    }

                    array_push($res, $modelo2);
                    $modelo2 = $this->createGrupos($grupos_actuales_existentes);
                }else{
                    if ($mate_actuales->matClave == $materias_actuales && $pos++ == 1) {

                        $modelo2['matClave'] = $mate_actuales->matClave;
                        $modelo2['matNombre'] = $mate_actuales->matNombre;
                        $modelo2['gpoMatComplementaria'] = $mate_actuales->gpoMatComplementaria;
                        
                        foreach ($resultado_collection as $item) {
                            if ($mate_actuales->matClave == $item->matClave) {
                                $grp = $item->cgtGrupo;
                                $modelo2[$grp.'_prog'] = $item->puntos_programados;
                                $modelo2[$grp.'_real'] = $item->puntos_reales;
                                $modelo2[$grp.'materia_acd'] = $item->bachiller_materia_acd_id;
    
                            }
                        }
    
                        array_push($res, $modelo2);
                        $modelo2 = $this->createGrupos($grupos_actuales_existentes);
                    }
                }
            }
            $pos = 0;
        }

        return $res;
    }
    public function generarTablaBodyACD2022($bachiller_materia_acd_id, $resultado_collection_acd, $grupos_actuales_acd)
    {
        $pos2 = 0;
        $res = [];
        $modelo = [];

        $modelo = $this->createGrupos($grupos_actuales_acd);

        foreach ($bachiller_materia_acd_id as $bachiller_materia_acd_id => $valores_materias_actuales) {
            foreach ($valores_materias_actuales as $mate_actuales) {
                if ($mate_actuales->bachiller_materia_acd_id == $bachiller_materia_acd_id && $pos2++ == 1) {

                    $modelo['matClave'] = $mate_actuales->matClave;
                    $modelo['matNombre'] = $mate_actuales->matNombre;
                    $modelo['gpoMatComplementaria'] = $mate_actuales->gpoMatComplementaria;
                    
                    foreach ($resultado_collection_acd as $item) {
                        if ($mate_actuales->bachiller_materia_acd_id == $item->bachiller_materia_acd_id) {
                            $grp = $item->gpoClave;
                            $modelo[$grp.'_prog'] = $item->puntos_programados;
                            $modelo[$grp.'_real'] = $item->puntos_reales;
                            $modelo[$grp.'materia_acd'] = $item->bachiller_materia_acd_id;

                        }
                    }

                    array_push($res, $modelo);
                    $modelo = $this->createGrupos($grupos_actuales_acd);
                }
                else{
                    if ($mate_actuales->bachiller_materia_acd_id == $bachiller_materia_acd_id && $pos2++ == 1) {

                        $modelo['matClave'] = $mate_actuales->matClave;
                        $modelo['matNombre'] = $mate_actuales->matNombre;
                        $modelo['gpoMatComplementaria'] = $mate_actuales->gpoMatComplementaria;
                        
                        foreach ($resultado_collection_acd as $item) {
                            if ($mate_actuales->bachiller_materia_acd_id == $item->bachiller_materia_acd_id) {
                                $grp = $item->cgtGrupo;
                                $modelo[$grp.'_prog'] = $item->puntos_programados;
                                $modelo[$grp.'_real'] = $item->puntos_reales;
                                $modelo[$grp.'materia_acd'] = $item->bachiller_materia_acd_id;
    
                            }
                        }
    
                        array_push($res, $modelo);
                        $modelo = $this->createGrupos($grupos_actuales_acd);
                    }
                }
            }
            $pos2 = 0;
        }

        return $res;
    }

    public function createGrupos($grupos_actuales_acd)
    {
        $modelo = [];
        foreach ($grupos_actuales_acd as $grupo_actuales => $valores_grupos) {
            $modelo[$grupo_actuales.'_prog'] = '';
            $modelo[$grupo_actuales.'_real'] = '';
        }
        return $modelo;
    }


}
