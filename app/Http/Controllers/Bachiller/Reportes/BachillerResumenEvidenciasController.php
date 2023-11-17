<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BachillerResumenEvidenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        // Mostrar el conmbo solo las ubicaciones correspondientes 
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.resumen_de_evidencias.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function getMateriaGradoPlan(Request $request, $plan_id, $grado)
    {
        if ($request->ajax()) {

            $materias = DB::table("bachiller_materias")
                ->select('bachiller_materias.*')
                ->where('bachiller_materias.plan_id', '=', $plan_id)
                ->where('bachiller_materias.matSemestre', '=', $grado)
                ->orderBy("bachiller_materias.matOrdenVisual", "ASC")
                ->get();

            return response()->json($materias);
        }
    }

    public function getMateriasACD(Request $request, $periodo_id, $plan_id, $bachiller_materia_id)
    {
        if ($request->ajax()) {

            $bachiller_materias_acd = DB::select("SELECT acd.* FROM bachiller_materias_acd acd
            INNER JOIN bachiller_materias bm ON (bm.id = acd.bachiller_materia_id)
            AND acd.deleted_at IS NULL
            WHERE bm.deleted_at IS NULL
            AND acd.periodo_id=$periodo_id
            AND acd.plan_id=$plan_id
            AND bachiller_materia_id=$bachiller_materia_id");

            return response()->json($bachiller_materias_acd);
        }
    }

    public function imprimir(Request $request)
    {
        // dd($request->periodo_id, $request->programa_id, $request->plan_id, $request->matSemestre);

        if ($request->tipoDevista == "1") {

            $evidencias =  DB::select("SELECT 
            bachiller_evidencias.id,
            bachiller_evidencias.periodo_id,
            bachiller_evidencias.bachiller_materia_id,
            bachiller_evidencias.eviNumero,
            bachiller_evidencias.eviDescripcion,
            bachiller_evidencias.eviFechaEntrega,
            bachiller_evidencias.eviPuntos AS puntosMaximos,
            bachiller_evidencias.eviTipo,
            bachiller_evidencias.eviFaltas,
            bachiller_materias.matClave,
            bachiller_materias.matNombre,
            bachiller_materias.matSemestre,
            bachiller_materias.matNombreOficial,
            periodos.perFechaInicial AS inicioPeriodo,
            periodos.perFechaFinal AS finalPeriodo,
            departamentos.depClave,
            ubicacion.ubiClave,
            ubicacion.ubiNombre,
            planes.id as plan_id,
            planes.planClave,
            programas.id as programa_id,
            programas.progNombre,
            bachiller_evidencias.bachiller_materia_acd_id,
			bachiller_materias_acd.gpoMatComplementaria
            FROM bachiller_evidencias AS bachiller_evidencias
            INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
            INNER JOIN periodos AS periodos ON periodos.id = bachiller_evidencias.periodo_id
            INNER JOIN departamentos AS departamentos ON departamentos.id = periodos.departamento_id
            INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
            INNER JOIN planes AS planes ON planes.id = bachiller_materias.plan_id
            INNER JOIN programas AS programas ON programas.id = planes.programa_id
            INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
            LEFT JOIN bachiller_materias_acd AS bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_evidencias.bachiller_materia_acd_id
            WHERE bachiller_evidencias.periodo_id = $request->periodo_id
            AND programas.id = $request->programa_id
            AND planes.id = $request->plan_id
            AND bachiller_materias.matSemestre = $request->matSemestreBuscar
            AND bachiller_evidencias.deleted_at IS NULL
            AND bachiller_evidencias.bachiller_materia_acd_id IS NULL
            ORDER BY bachiller_materias.matOrdenVisual ASC");

            $evidencias2 =  DB::select("SELECT 
            bachiller_evidencias.id,
            bachiller_evidencias.periodo_id,
            bachiller_evidencias.bachiller_materia_id,
            bachiller_evidencias.eviNumero,
            bachiller_evidencias.eviDescripcion,
            bachiller_evidencias.eviFechaEntrega,
            bachiller_evidencias.eviPuntos AS puntosMaximos,
            bachiller_evidencias.eviTipo,
            bachiller_evidencias.eviFaltas,
            bachiller_materias.matClave,
            bachiller_materias.matNombre,
            bachiller_materias.matSemestre,
            bachiller_materias.matNombreOficial,
            periodos.perFechaInicial AS inicioPeriodo,
            periodos.perFechaFinal AS finalPeriodo,
            departamentos.depClave,
            ubicacion.ubiClave,
            ubicacion.ubiNombre,
            planes.id as plan_id,
            planes.planClave,
            programas.id as programa_id,
            programas.progNombre,
            bachiller_evidencias.bachiller_materia_acd_id,
			bachiller_materias_acd.gpoMatComplementaria
            FROM bachiller_evidencias AS bachiller_evidencias
            INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
            INNER JOIN periodos AS periodos ON periodos.id = bachiller_evidencias.periodo_id
            INNER JOIN departamentos AS departamentos ON departamentos.id = periodos.departamento_id
            INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
            INNER JOIN planes AS planes ON planes.id = bachiller_materias.plan_id
            INNER JOIN programas AS programas ON programas.id = planes.programa_id
            INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
            LEFT JOIN bachiller_materias_acd AS bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_evidencias.bachiller_materia_acd_id
            WHERE bachiller_evidencias.periodo_id = $request->periodo_id
            AND programas.id = $request->programa_id
            AND planes.id = $request->plan_id
            AND bachiller_materias.matSemestre = $request->matSemestreBuscar
            AND bachiller_evidencias.deleted_at IS NULL
            AND bachiller_evidencias.bachiller_materia_acd_id IS NOT NULL
            ORDER BY bachiller_materias.matOrdenVisual ASC");

            if (count($evidencias) == 0) {
                alert()->warning('Sin coincidencias', 'No hay evidencias capturadas con los datos proporcionados. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $materiasTotales = collect($evidencias)->groupBy('matClave');
            $materiasAcdTotales = collect($evidencias2)->groupBy('matClave');
            $materiasAcdTotalesId = collect($evidencias2)->groupBy('bachiller_materia_acd_id');

            // return count($materiasAcdTotales);



            //parametror 
            $ubicacion = $evidencias[0]->ubiClave . '-' . $evidencias[0]->ubiNombre;
            $departamento = $evidencias[0]->depClave;
            $plan = $evidencias[0]->planClave;
            $programa = $evidencias[0]->progNombre;
            $inicioPeriodo = $evidencias[0]->inicioPeriodo;
            $finalPeriodo = $evidencias[0]->finalPeriodo;

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');

            $parametro_NombreArchivo = 'pdf_bachiller_resumen_de_evidencias';
            $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_de_evidencias.' . $parametro_NombreArchivo, [
                "fechaActual"       => $fechaActual,
                "horaActual"        => $fechaActual->format('H:i:s'),
                "inicioPeriodo"     => $inicioPeriodo,
                "finalPeriodo"      => $finalPeriodo,
                "ubicacion"         => $ubicacion,
                "departamento"      => $departamento,
                "plan"              => $plan,
                "programa"          => $programa,
                "materiasTotales"   => $materiasTotales,
                "materiasAcdTotales" => $materiasAcdTotales,
                "materiasAcdTotalesId" => $materiasAcdTotalesId
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }

        // detalles 
        if ($request->tipoDevista == "2") {

            if ($request->bachiller_materia_id != "") {

                if ($request->bachiller_materia_acd_id == "") {
                    $evidencias =  DB::select("SELECT 
                    bachiller_evidencias.id,
                    bachiller_evidencias.periodo_id,
                    bachiller_evidencias.bachiller_materia_id,
                    bachiller_evidencias.eviNumero,
                    bachiller_evidencias.eviDescripcion,
                    bachiller_evidencias.eviFechaEntrega,
                    bachiller_evidencias.eviPuntos AS puntosMaximos,
                    bachiller_evidencias.eviTipo,
                    bachiller_evidencias.eviFaltas,
                    bachiller_materias.matClave,
                    bachiller_materias.matNombre,
                    bachiller_materias.matSemestre,
                    periodos.perFechaInicial AS inicioPeriodo,
                    periodos.perFechaFinal AS finalPeriodo,
                    departamentos.depClave,
                    ubicacion.ubiClave,
                    ubicacion.ubiNombre,
                    planes.id as plan_id,
                    planes.planClave,
                    programas.id as programa_id,
                    programas.progNombre,
                    bachiller_evidencias.bachiller_materia_acd_id,
                    bachiller_materias_acd.gpoMatComplementaria
                    FROM bachiller_evidencias AS bachiller_evidencias
                    INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
                    INNER JOIN periodos AS periodos ON periodos.id = bachiller_evidencias.periodo_id
                    INNER JOIN departamentos AS departamentos ON departamentos.id = periodos.departamento_id
                    INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
                    INNER JOIN planes AS planes ON planes.id = bachiller_materias.plan_id
                    INNER JOIN programas AS programas ON programas.id = planes.programa_id
                    INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
                    LEFT JOIN bachiller_materias_acd AS bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_evidencias.bachiller_materia_acd_id
                    WHERE bachiller_evidencias.periodo_id = $request->periodo_id
                    AND programas.id = $request->programa_id
                    AND planes.id = $request->plan_id
                    AND bachiller_materias.id = $request->bachiller_materia_id
                    AND bachiller_evidencias.deleted_at IS NULL
                    AND periodos.deleted_at IS NULL
                    AND departamentos.deleted_at IS NULL
                    AND ubicacion.deleted_at IS NULL
                    AND planes.deleted_at IS NULL
                    AND programas.deleted_at IS NULL
                    AND escuelas.deleted_at IS NULL
                    AND bachiller_materias_acd.deleted_at IS NULL
                    ORDER BY bachiller_materias.matOrdenVisual ASC, bachiller_evidencias.eviNumero");

                    if (count($evidencias) == 0) {
                        alert()->warning('Sin coincidencias', 'No hay evidencias capturadas con los datos proporcionados. Favor de verificar.')->showConfirmButton();
                        return back()->withInput();
                    }

                    $materiasTotales = collect($evidencias)->groupBy('matClave');            //parametror 
                    $ubicacion = $evidencias[0]->ubiClave . '-' . $evidencias[0]->ubiNombre;
                    $departamento = $evidencias[0]->depClave;
                    $plan = $evidencias[0]->planClave;
                    $programa = $evidencias[0]->progNombre;
                    $inicioPeriodo = $evidencias[0]->inicioPeriodo;
                    $finalPeriodo = $evidencias[0]->finalPeriodo;
                    $matSemestre = $evidencias[0]->matSemestre;
                    $materia = $evidencias[0]->matClave . ' - ' . $evidencias[0]->matNombre;
                    $puntosProc = collect($evidencias)->where('eviTipo', 'A')->sum('puntosMaximos');
                    $puntosProduc = collect($evidencias)->where('eviTipo', 'P')->sum('puntosMaximos');

                    $fechaActual = Carbon::now('America/Merida');
                    setlocale(LC_TIME, 'es_ES.UTF-8');
                    // En windows
                    setlocale(LC_ALL, 'es_MX', 'es', 'ES');

                    $parametro_NombreArchivo = 'pdf_bachiller_detalle_de_evidencias';
                    // view('reportes.pdf.bachiller.resumen_de_evidencias.pdf_bachiller_detalle_de_evidencias');
                    $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_de_evidencias.' . $parametro_NombreArchivo, [
                        "fechaActual"       => $fechaActual,
                        "horaActual"        => $fechaActual->format('H:i:s'),
                        "inicioPeriodo"     => $inicioPeriodo,
                        "finalPeriodo"      => $finalPeriodo,
                        "ubicacion"         => $ubicacion,
                        "departamento"      => $departamento,
                        "plan"              => $plan,
                        "programa"          => $programa,
                        "materiasTotales"   => $materiasTotales,
                        "matSemestre"       => $matSemestre,
                        "materia"           => $materia,
                        "puntosProc"        => $puntosProc,
                        "puntosProduc"      => $puntosProduc
                    ]);


                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';

                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }

                // Si tiene id materia acd 
                if ($request->bachiller_materia_acd_id != "") {
                    $evidencias =  DB::select("SELECT 
                    bachiller_evidencias.id,
                    bachiller_evidencias.periodo_id,
                    bachiller_evidencias.bachiller_materia_id,
                    bachiller_evidencias.eviNumero,
                    bachiller_evidencias.eviDescripcion,
                    bachiller_evidencias.eviFechaEntrega,
                    bachiller_evidencias.eviPuntos AS puntosMaximos,
                    bachiller_evidencias.eviTipo,
                    bachiller_evidencias.eviFaltas,
                    bachiller_materias.matClave,
                    bachiller_materias.matNombre,
                    bachiller_materias.matSemestre,
                    periodos.perFechaInicial AS inicioPeriodo,
                    periodos.perFechaFinal AS finalPeriodo,
                    departamentos.depClave,
                    ubicacion.ubiClave,
                    ubicacion.ubiNombre,
                    planes.id as plan_id,
                    planes.planClave,
                    programas.id as programa_id,
                    programas.progNombre,
                    bachiller_evidencias.bachiller_materia_acd_id,
                    bachiller_materias_acd.gpoMatComplementaria
                    FROM bachiller_evidencias AS bachiller_evidencias
                    INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
                    INNER JOIN periodos AS periodos ON periodos.id = bachiller_evidencias.periodo_id
                    INNER JOIN departamentos AS departamentos ON departamentos.id = periodos.departamento_id
                    INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
                    INNER JOIN planes AS planes ON planes.id = bachiller_materias.plan_id
                    INNER JOIN programas AS programas ON programas.id = planes.programa_id
                    INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
                    LEFT JOIN bachiller_materias_acd AS bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_evidencias.bachiller_materia_acd_id
                    WHERE bachiller_evidencias.periodo_id = $request->periodo_id
                    AND programas.id = $request->programa_id
                    AND planes.id = $request->plan_id
                    AND bachiller_materias.id = $request->bachiller_materia_id                    
                    AND bachiller_evidencias.bachiller_materia_acd_id = $request->bachiller_materia_acd_id
                    AND bachiller_evidencias.deleted_at IS NULL
                    AND periodos.deleted_at IS NULL
                    AND departamentos.deleted_at IS NULL
                    AND ubicacion.deleted_at IS NULL
                    AND planes.deleted_at IS NULL
                    AND programas.deleted_at IS NULL
                    AND escuelas.deleted_at IS NULL
                    AND bachiller_materias_acd.deleted_at IS NULL
                    ORDER BY bachiller_materias.matOrdenVisual ASC, bachiller_evidencias.eviNumero");

                    if (count($evidencias) == 0) {
                        alert()->warning('Sin coincidencias', 'No hay evidencias capturadas con los datos proporcionados. Favor de verificar.')->showConfirmButton();
                        return back()->withInput();
                    }

                    $materiasTotales = collect($evidencias)->groupBy('bachiller_materia_acd_id');            //parametror 
                    $ubicacion = $evidencias[0]->ubiClave . '-' . $evidencias[0]->ubiNombre;
                    $departamento = $evidencias[0]->depClave;
                    $plan = $evidencias[0]->planClave;
                    $programa = $evidencias[0]->progNombre;
                    $inicioPeriodo = $evidencias[0]->inicioPeriodo;
                    $finalPeriodo = $evidencias[0]->finalPeriodo;
                    $matSemestre = $evidencias[0]->matSemestre;
                    $materia = $evidencias[0]->matClave . ' - ' . $evidencias[0]->matNombre;
                    $puntosProc = collect($evidencias)->where('eviTipo', 'A')->sum('puntosMaximos');
                    $puntosProduc = collect($evidencias)->where('eviTipo', 'P')->sum('puntosMaximos');
                    $materiaACD = $evidencias[0]->gpoMatComplementaria;

                    $fechaActual = Carbon::now('America/Merida');
                    setlocale(LC_TIME, 'es_ES.UTF-8');
                    // En windows
                    setlocale(LC_ALL, 'es_MX', 'es', 'ES');

                    $parametro_NombreArchivo = 'pdf_bachiller_detalle_de_evidencias_acd';
                    // view('reportes.pdf.bachiller.resumen_de_evidencias.pdf_bachiller_detalle_de_evidencias_acd');
                    $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_de_evidencias.' . $parametro_NombreArchivo, [
                        "fechaActual"       => $fechaActual,
                        "horaActual"        => $fechaActual->format('H:i:s'),
                        "inicioPeriodo"     => $inicioPeriodo,
                        "finalPeriodo"      => $finalPeriodo,
                        "ubicacion"         => $ubicacion,
                        "departamento"      => $departamento,
                        "plan"              => $plan,
                        "programa"          => $programa,
                        "materiasTotales"   => $materiasTotales,
                        "matSemestre"       => $matSemestre,
                        "materia"           => $materia,
                        "puntosProc"        => $puntosProc,
                        "puntosProduc"      => $puntosProduc,
                        "materiaACD"        => $materiaACD
                    ]);


                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';

                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }
            }

            if ($request->bachiller_materia_id == "") {
                // cuando es sin ACD 
                if ($request->bachiller_sin_con_acd == "SIN") {

                    $evidencias =  DB::select("SELECT 
                    bachiller_evidencias.id,
                    bachiller_evidencias.periodo_id,
                    bachiller_evidencias.bachiller_materia_id,
                    bachiller_evidencias.eviNumero,
                    bachiller_evidencias.eviDescripcion,
                    bachiller_evidencias.eviFechaEntrega,
                    bachiller_evidencias.eviPuntos AS puntosMaximos,
                    bachiller_evidencias.eviTipo,
                    bachiller_evidencias.eviFaltas,
                    bachiller_materias.matClave,
                    bachiller_materias.matNombre,
                    bachiller_materias.matSemestre,
                    periodos.perFechaInicial AS inicioPeriodo,
                    periodos.perFechaFinal AS finalPeriodo,
                    departamentos.depClave,
                    ubicacion.ubiClave,
                    ubicacion.ubiNombre,
                    planes.id as plan_id,
                    planes.planClave,
                    programas.id as programa_id,
                    programas.progNombre,
                    bachiller_evidencias.bachiller_materia_acd_id,
                    bachiller_materias_acd.gpoMatComplementaria
                    FROM bachiller_evidencias AS bachiller_evidencias
                    INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
                    INNER JOIN periodos AS periodos ON periodos.id = bachiller_evidencias.periodo_id
                    INNER JOIN departamentos AS departamentos ON departamentos.id = periodos.departamento_id
                    INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
                    INNER JOIN planes AS planes ON planes.id = bachiller_materias.plan_id
                    INNER JOIN programas AS programas ON programas.id = planes.programa_id
                    INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
                    LEFT JOIN bachiller_materias_acd AS bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_evidencias.bachiller_materia_acd_id
                    WHERE bachiller_evidencias.periodo_id = $request->periodo_id
                    AND programas.id = $request->programa_id
                    AND planes.id = $request->plan_id
                    AND bachiller_materias.matSemestre = $request->matSemestreBuscar
                    AND bachiller_evidencias.deleted_at IS NULL
                    AND periodos.deleted_at IS NULL
                    AND departamentos.deleted_at IS NULL
                    AND ubicacion.deleted_at IS NULL
                    AND planes.deleted_at IS NULL
                    AND programas.deleted_at IS NULL
                    AND escuelas.deleted_at IS NULL
                    AND bachiller_materias_acd.deleted_at IS NULL
                    AND bachiller_evidencias.bachiller_materia_acd_id IS NULL
                    ORDER BY bachiller_materias.matOrdenVisual ASC, bachiller_evidencias.eviNumero");


                    if (count($evidencias) == 0) {
                        alert()->warning('Sin coincidencias', 'No hay evidencias capturadas con los datos proporcionados. Favor de verificar.')->showConfirmButton();
                        return back()->withInput();
                    }

                    $materiasTotales = collect($evidencias)->groupBy('matClave');            //parametror 
                    $ubicacion = $evidencias[0]->ubiClave . '-' . $evidencias[0]->ubiNombre;
                    $departamento = $evidencias[0]->depClave;
                    $plan = $evidencias[0]->planClave;
                    $programa = $evidencias[0]->progNombre;
                    $inicioPeriodo = $evidencias[0]->inicioPeriodo;
                    $finalPeriodo = $evidencias[0]->finalPeriodo;
                    $matSemestre = $evidencias[0]->matSemestre;
                    $materia = $evidencias[0]->matClave . ' - ' . $evidencias[0]->matNombre;

                    $fechaActual = Carbon::now('America/Merida');
                    setlocale(LC_TIME, 'es_ES.UTF-8');
                    // En windows
                    setlocale(LC_ALL, 'es_MX', 'es', 'ES');

                    $parametro_NombreArchivo = 'pdf_bachiller_detalle_de_evidencias_grado';
                    $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_de_evidencias.' . $parametro_NombreArchivo, [
                        "fechaActual"       => $fechaActual,
                        "horaActual"        => $fechaActual->format('H:i:s'),
                        "inicioPeriodo"     => $inicioPeriodo,
                        "finalPeriodo"      => $finalPeriodo,
                        "ubicacion"         => $ubicacion,
                        "departamento"      => $departamento,
                        "plan"              => $plan,
                        "programa"          => $programa,
                        "materiasTotales"   => $materiasTotales,
                        "matSemestre"       => $matSemestre,
                        "materia"           => $materia
                    ]);


                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';

                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }

                // cuando es con ACD 
                if ($request->bachiller_sin_con_acd == "CON") {

                    $evidencias =  DB::select("SELECT 
                    bachiller_evidencias.id,
                    bachiller_evidencias.periodo_id,
                    bachiller_evidencias.bachiller_materia_id,
                    bachiller_evidencias.eviNumero,
                    bachiller_evidencias.eviDescripcion,
                    bachiller_evidencias.eviFechaEntrega,
                    bachiller_evidencias.eviPuntos AS puntosMaximos,
                    bachiller_evidencias.eviTipo,
                    bachiller_evidencias.eviFaltas,
                    bachiller_materias.matClave,
                    bachiller_materias.matNombre,
                    bachiller_materias.matSemestre,
                    periodos.perFechaInicial AS inicioPeriodo,
                    periodos.perFechaFinal AS finalPeriodo,
                    departamentos.depClave,
                    ubicacion.ubiClave,
                    ubicacion.ubiNombre,
                    planes.id as plan_id,
                    planes.planClave,
                    programas.id as programa_id,
                    programas.progNombre,
                    bachiller_evidencias.bachiller_materia_acd_id,
                    bachiller_materias_acd.gpoMatComplementaria
                    FROM bachiller_evidencias AS bachiller_evidencias
                    INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
                    INNER JOIN periodos AS periodos ON periodos.id = bachiller_evidencias.periodo_id
                    INNER JOIN departamentos AS departamentos ON departamentos.id = periodos.departamento_id
                    INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
                    INNER JOIN planes AS planes ON planes.id = bachiller_materias.plan_id
                    INNER JOIN programas AS programas ON programas.id = planes.programa_id
                    INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
                    LEFT JOIN bachiller_materias_acd AS bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_evidencias.bachiller_materia_acd_id
                    WHERE bachiller_evidencias.periodo_id = $request->periodo_id
                    AND programas.id = $request->programa_id
                    AND planes.id = $request->plan_id
                    AND bachiller_materias.matSemestre = $request->matSemestreBuscar
                    AND bachiller_evidencias.deleted_at IS NULL
                    AND periodos.deleted_at IS NULL
                    AND departamentos.deleted_at IS NULL
                    AND ubicacion.deleted_at IS NULL
                    AND planes.deleted_at IS NULL
                    AND programas.deleted_at IS NULL
                    AND escuelas.deleted_at IS NULL
                    AND bachiller_materias_acd.deleted_at IS NULL
                    AND bachiller_evidencias.bachiller_materia_acd_id IS NOT NULL
                    ORDER BY bachiller_materias.matOrdenVisual ASC, bachiller_evidencias.eviNumero");


                    if (count($evidencias) == 0) {
                        alert()->warning('Sin coincidencias', 'No hay evidencias capturadas con los datos proporcionados. Favor de verificar.')->showConfirmButton();
                        return back()->withInput();
                    }

                    $materiasTotales = collect($evidencias)->groupBy('bachiller_materia_acd_id');            //parametror 
                    $ubicacion = $evidencias[0]->ubiClave . '-' . $evidencias[0]->ubiNombre;
                    $departamento = $evidencias[0]->depClave;
                    $plan = $evidencias[0]->planClave;
                    $programa = $evidencias[0]->progNombre;
                    $inicioPeriodo = $evidencias[0]->inicioPeriodo;
                    $finalPeriodo = $evidencias[0]->finalPeriodo;
                    $matSemestre = $evidencias[0]->matSemestre;
                    $materia = $evidencias[0]->matClave . ' - ' . $evidencias[0]->matNombre;

                    $fechaActual = Carbon::now('America/Merida');
                    setlocale(LC_TIME, 'es_ES.UTF-8');
                    // En windows
                    setlocale(LC_ALL, 'es_MX', 'es', 'ES');

                    $parametro_NombreArchivo = 'pdf_bachiller_detalle_de_evidencias_grado_acd';
                    $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_de_evidencias.' . $parametro_NombreArchivo, [
                        "fechaActual"       => $fechaActual,
                        "horaActual"        => $fechaActual->format('H:i:s'),
                        "inicioPeriodo"     => $inicioPeriodo,
                        "finalPeriodo"      => $finalPeriodo,
                        "ubicacion"         => $ubicacion,
                        "departamento"      => $departamento,
                        "plan"              => $plan,
                        "programa"          => $programa,
                        "materiasTotales"   => $materiasTotales,
                        "matSemestre"       => $matSemestre,
                        "materia"           => $materia
                    ]);


                    $pdf->setPaper('letter', 'landscape');
                    $pdf->defaultFont = 'Times Sans Serif';

                    return $pdf->stream($parametro_NombreArchivo . '.pdf');
                    return $pdf->download($parametro_NombreArchivo  . '.pdf');
                }
            }
        }

        if ($request->tipoDevista == "3") {

            $evidencias =  DB::select("SELECT 
            bachiller_evidencias.id,
            bachiller_evidencias.periodo_id,
            bachiller_evidencias.bachiller_materia_id,
            bachiller_evidencias.eviNumero,
            bachiller_evidencias.eviDescripcion,
            bachiller_evidencias.eviFechaEntrega,
            bachiller_evidencias.eviPuntos AS puntosMaximos,
            bachiller_evidencias.eviTipo,
            bachiller_evidencias.eviFaltas,
            bachiller_materias.matClave,
            bachiller_materias.matNombre,
            bachiller_materias.matSemestre,
            bachiller_materias.matNombreOficial,
            periodos.perFechaInicial AS inicioPeriodo,
            periodos.perFechaFinal AS finalPeriodo,
            departamentos.depClave,
            ubicacion.ubiClave,
            ubicacion.ubiNombre,
            planes.id as plan_id,
            planes.planClave,
            programas.id as programa_id,
            programas.progNombre,
            bachiller_evidencias.bachiller_materia_acd_id,
			bachiller_materias_acd.gpoMatComplementaria
            FROM bachiller_evidencias AS bachiller_evidencias
            INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
            INNER JOIN periodos AS periodos ON periodos.id = bachiller_evidencias.periodo_id
            INNER JOIN departamentos AS departamentos ON departamentos.id = periodos.departamento_id
            INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
            INNER JOIN planes AS planes ON planes.id = bachiller_materias.plan_id
            INNER JOIN programas AS programas ON programas.id = planes.programa_id
            INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
            LEFT JOIN bachiller_materias_acd AS bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_evidencias.bachiller_materia_acd_id
            WHERE bachiller_evidencias.periodo_id = $request->periodo_id
            AND programas.id = $request->programa_id
            AND planes.id = $request->plan_id
            AND bachiller_materias.matSemestre = $request->matSemestreBuscar
            AND bachiller_evidencias.deleted_at IS NULL
            AND periodos.deleted_at IS NULL
            AND departamentos.deleted_at IS NULL
            AND ubicacion.deleted_at IS NULL
            AND planes.deleted_at IS NULL
            AND programas.deleted_at IS NULL
            AND escuelas.deleted_at IS NULL
            AND bachiller_materias_acd.deleted_at IS NULL
            AND bachiller_evidencias.bachiller_materia_acd_id IS NULL
            ORDER BY bachiller_materias.matOrdenVisual ASC");

            $evidencias2 =  DB::select("SELECT 
            bachiller_evidencias.id,
            bachiller_evidencias.periodo_id,
            bachiller_evidencias.bachiller_materia_id,
            bachiller_evidencias.eviNumero,
            bachiller_evidencias.eviDescripcion,
            bachiller_evidencias.eviFechaEntrega,
            bachiller_evidencias.eviPuntos AS puntosMaximos,
            bachiller_evidencias.eviTipo,
            bachiller_evidencias.eviFaltas,
            bachiller_materias.matClave,
            bachiller_materias.matNombre,
            bachiller_materias.matSemestre,
            bachiller_materias.matNombreOficial,
            periodos.perFechaInicial AS inicioPeriodo,
            periodos.perFechaFinal AS finalPeriodo,
            departamentos.depClave,
            ubicacion.ubiClave,
            ubicacion.ubiNombre,
            planes.id as plan_id,
            planes.planClave,
            programas.id as programa_id,
            programas.progNombre,
            bachiller_evidencias.bachiller_materia_acd_id,
			bachiller_materias_acd.gpoMatComplementaria
            FROM bachiller_evidencias AS bachiller_evidencias
            INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
            INNER JOIN periodos AS periodos ON periodos.id = bachiller_evidencias.periodo_id
            INNER JOIN departamentos AS departamentos ON departamentos.id = periodos.departamento_id
            INNER JOIN ubicacion AS ubicacion ON ubicacion.id = departamentos.ubicacion_id
            INNER JOIN planes AS planes ON planes.id = bachiller_materias.plan_id
            INNER JOIN programas AS programas ON programas.id = planes.programa_id
            INNER JOIN escuelas AS escuelas ON escuelas.id = programas.escuela_id
            LEFT JOIN bachiller_materias_acd AS bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_evidencias.bachiller_materia_acd_id
            WHERE bachiller_evidencias.periodo_id = $request->periodo_id
            AND programas.id = $request->programa_id
            AND planes.id = $request->plan_id
            AND bachiller_materias.matSemestre = $request->matSemestreBuscar
            AND bachiller_evidencias.deleted_at IS NULL
            AND periodos.deleted_at IS NULL
            AND departamentos.deleted_at IS NULL
            AND ubicacion.deleted_at IS NULL
            AND planes.deleted_at IS NULL
            AND programas.deleted_at IS NULL
            AND escuelas.deleted_at IS NULL
            AND bachiller_materias_acd.deleted_at IS NULL
            AND bachiller_evidencias.bachiller_materia_acd_id IS NOT NULL
            ORDER BY bachiller_materias.matOrdenVisual ASC");

            if (count($evidencias) == 0) {
                alert()->warning('Sin coincidencias', 'No hay evidencias capturadas con los datos proporcionados. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $materiasTotales = collect($evidencias)->groupBy('matClave');
            $materiasAcdTotales = collect($evidencias2)->groupBy('matClave');
            $materiasAcdTotalesId = collect($evidencias2)->groupBy('bachiller_materia_acd_id');

            // return count($materiasAcdTotales);



            //parametror 
            $ubicacion = $evidencias[0]->ubiClave . '-' . $evidencias[0]->ubiNombre;
            $departamento = $evidencias[0]->depClave;
            $plan = $evidencias[0]->planClave;
            $programa = $evidencias[0]->progNombre;
            $inicioPeriodo = $evidencias[0]->inicioPeriodo;
            $finalPeriodo = $evidencias[0]->finalPeriodo;

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');

            $parametro_NombreArchivo = 'pdf_bachiller_resumen_de_evidencias_puntos_faltantes';
            // view('reportes.pdf.bachiller.resumen_de_evidencias.pdf_bachiller_resumen_de_evidencias');
            $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_de_evidencias.' . $parametro_NombreArchivo, [
                "fechaActual"       => $fechaActual,
                "horaActual"        => $fechaActual->format('H:i:s'),
                "inicioPeriodo"     => $inicioPeriodo,
                "finalPeriodo"      => $finalPeriodo,
                "ubicacion"         => $ubicacion,
                "departamento"      => $departamento,
                "plan"              => $plan,
                "programa"          => $programa,
                "materiasTotales"   => $materiasTotales,
                "materiasAcdTotales" => $materiasAcdTotales,
                "materiasAcdTotalesId" => $materiasAcdTotalesId
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }
}
