<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use PDF;

class BachillerResumenCalificacionGrupoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.resumen_calificacion_grupo.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {

        $periodo = Periodo::find($request->periodo_id);

        if($request->tamanio == "carta"){
            $tipo_hoja = "letter";
        }
        if($request->tamanio == "oficio"){
            $tipo_hoja = "legal";
        }

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
                'bachiller_inscritos.insPuntosObtenidosFinal as calificacionFinal',
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
                'bachiller_grupos.gpoMatComplementaria',
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
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'cursos.curEstado',
                'programas.progNombre',
                'departamentos.depClave',
                'departamentos.depCalMinAprob',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'bachiller_materias.matClasificacion',
                'bachiller_grupos.bachiller_materia_acd_id',
                'bachiller_materias.matTipoGrupoMateria'

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
                ->whereNull('bachiller_grupos.bachiller_materia_acd_id')
                ->where(static function ($query) use ($request) {

                    if ($request->cgtGradoSemestreBuscar) {
                        $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestreBuscar);
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


                $bachiller_inscritos_acd = Bachiller_inscritos::select(
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
                    'bachiller_inscritos.insPuntosObtenidosFinal as calificacionFinal',
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
                    'bachiller_grupos.gpoMatComplementaria',
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
                    'cgt.cgtGradoSemestre',
                    'cgt.cgtGrupo',
                    'cursos.curEstado',
                    'programas.progNombre',
                    'departamentos.depClave',
                    'departamentos.depCalMinAprob',
                    'ubicacion.ubiClave',
                    'ubicacion.ubiNombre',
                    'bachiller_materias.matClasificacion',
                    'bachiller_grupos.bachiller_materia_acd_id',
                    'bachiller_materias.matTipoGrupoMateria'

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
                    ->whereNotNull('bachiller_grupos.bachiller_materia_acd_id')
                    ->where(static function ($query) use ($request) {

                        if ($request->cgtGradoSemestreBuscar) {
                            $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestreBuscar);
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

            if (count($bachiller_inscritos) < 1 || count($bachiller_inscritos_acd) < 1) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            // Parametros
            $parametro_nivel = $bachiller_inscritos[0]->depClave.' ('.$bachiller_inscritos[0]->planClave.') '.$bachiller_inscritos[0]->progNombre;
            $parametroSemestreGrupo = 'Sem: '.$bachiller_inscritos[0]->cgtGradoSemestre.' Grupo: '.$bachiller_inscritos[0]->cgtGrupo;
            $parametro_ubicacion = $bachiller_inscritos[0]->ubiClave.' '.$bachiller_inscritos[0]->ubiNombre;
            $aprobatorio = $bachiller_inscritos[0]->depCalMinAprob;

            $alumno = $bachiller_inscritos->groupBy('aluClave');
            $bachiller_materias = $bachiller_inscritos->groupBy('bachiller_materia_id');
            $grupos_actuales_existentes = $bachiller_inscritos->groupBy('gpoClave');


            #para meterias acd
            $alumno_acd = $bachiller_inscritos_acd->groupBy('aluClave');
            $bachiller_materias_acd = $bachiller_inscritos_acd->groupBy('bachiller_materia_acd_id');

            $tablaBody = $this->generarTablaBody2022($bachiller_materias, $alumno);

            $tablaBodyAcd = $this->generarTablaBodyACD2022($bachiller_materias_acd, $alumno_acd);


            $parametro_NombreArchivo = "pdf_resumen_calificacion_grupo_2023";
            // view('reportes.pdf.bachiller.resumen_calificacion_grupo.pdf_resumen_calificacion_grupo_2023')
            $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_calificacion_grupo.' . $parametro_NombreArchivo, [
                "cicloEscolar" => Utils::fecha_string($bachiller_inscritos[0]->perFechaInicial, 'mesCorto') . '-' . Utils::fecha_string($bachiller_inscritos[0]->perFechaFinal, 'mesCorto'),
                "alumno" => $alumno,
                "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
                "bachiller_materias" => $bachiller_materias,
                "nivel" => $parametro_nivel,
                "grupo" => $parametroSemestreGrupo,
                "ubicacion" => $parametro_ubicacion,
                "bachiller_inscritos" => $bachiller_inscritos->groupBy('aluClave'),
                "aprobatorio" => $aprobatorio,
                "tablaBody" => $tablaBody,
                "bachiller_materias_acd" => $bachiller_materias_acd,
                "tablaBodyAcd" => $tablaBodyAcd
            ]);

            $pdf->setPaper($tipo_hoja, 'landscape');


            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }

        // Materias del 2021 hacia abajo
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
                'bachiller_inscritos.insCalificacionFinal as calificacionFinal',
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
                'planes.planClave',
                'ubicacion.ubiClave',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'cursos.curEstado',
                'programas.progNombre',
                'departamentos.depClave',
                'departamentos.depCalMinAprob',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'bachiller_materias.matClasificacion',
                'bachiller_materias.matTipoGrupoMateria'

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

                    if ($request->cgtGradoSemestreBuscar) {
                        $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestreBuscar);
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

                    if($request->TipoMateria){
                        $query->where('bachiller_materias.matTipoGrupoMateria', $request->TipoMateria);
                    }
                })
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

            // Parametros
            $parametro_nivel = $bachiller_inscritos[0]->depClave.' ('.$bachiller_inscritos[0]->planClave.') '.$bachiller_inscritos[0]->progNombre;
            $parametroSemestreGrupo = 'Sem: '.$bachiller_inscritos[0]->cgtGradoSemestre.' Grupo: '.$bachiller_inscritos[0]->cgtGrupo;
            $parametro_ubicacion = $bachiller_inscritos[0]->ubiClave.' '.$bachiller_inscritos[0]->ubiNombre;
            $aprobatorio = $bachiller_inscritos[0]->depCalMinAprob;

            $alumno = $bachiller_inscritos->groupBy('aluClave');
            $bachiller_materias = $bachiller_inscritos->groupBy('matClave');
            $grupos_actuales_existentes = $bachiller_inscritos->groupBy('gpoClave');

            $tablaBody = $this->generarTablaBody2021($bachiller_materias, $alumno);

            $parametro_NombreArchivo = "pdf_resumen_calificacion_grupo";
            // view('reportes.pdf.bachiller.resumen_calificacion_grupo.pdf_resumen_calificacion_grupo')
            $pdf = PDF::loadView('reportes.pdf.bachiller.resumen_calificacion_grupo.' . $parametro_NombreArchivo, [
                "cicloEscolar" => Utils::fecha_string($bachiller_inscritos[0]->perFechaInicial, 'mesCorto') . '-' . Utils::fecha_string($bachiller_inscritos[0]->perFechaFinal, 'mesCorto'),
                "alumno" => $alumno,
                "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto'),
                "bachiller_materias" => $bachiller_materias,
                "nivel" => $parametro_nivel,
                "grupo" => $parametroSemestreGrupo,
                "ubicacion" => $parametro_ubicacion,
                "bachiller_inscritos" => $bachiller_inscritos->groupBy('aluClave'),
                "aprobatorio" => $aprobatorio,
                "tablaBody" => $tablaBody
            ]);

            $pdf->setPaper($tipo_hoja, 'landscape');


            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }



    public function generarTablaBody2021($materias_actuales_existentes, $alumno)
    {

        $pos = 1;

        $res = [];
        $modelo = [];


        foreach ($alumno as $aluClave => $vol){
            $modelo = $this->createGrupos($materias_actuales_existentes, $aluClave);


            foreach ($vol as $valores){


                if($aluClave == $valores->aluClave && $pos++ == 1){

                    $grp = $valores->cgtGrupo;
                    // $modelo[$grp.'_calif'] = $valores->calificacionFinal;

                    // $modelo['matClave'] = $valores->matClave;
                    $modelo['aluClave'] = $valores->aluClave;

                    array_push($res, $modelo);
                    $modelo = $this->createGrupos($materias_actuales_existentes, $valores->aluClave);
                }
            }


            $pos = 1;

        }



        return $res;
    }

    public function generarTablaBody2022($materias_actuales_existentes, $alumno)
    {

        $pos = 1;

        $res = [];
        $modelo = [];


        foreach ($alumno as $aluClave => $vol){
            $modelo = $this->createGrupos2022($materias_actuales_existentes, $aluClave);


            foreach ($vol as $valores){


                if($aluClave == $valores->aluClave && $pos++ == 1){

                    $grp = $valores->cgtGrupo;
                    // $modelo[$grp.'_calif'] = $valores->calificacionFinal;

                    // $modelo['matClave'] = $valores->matClave;
                    $modelo['aluClave'] = $valores->aluClave;

                    array_push($res, $modelo);
                    $modelo = $this->createGrupos2022($materias_actuales_existentes, $valores->aluClave);
                }
            }


            $pos = 1;

        }



        return $res;
    }

    public function generarTablaBodyACD2022($materias_actuales_existentes_acd, $alumno)
    {

        $pos = 1;

        $res = [];
        $modelo = [];


        foreach ($alumno as $aluClave => $vol){
            $modelo = $this->createGruposACD2022($materias_actuales_existentes_acd, $aluClave);


            foreach ($vol as $valores){


                if($aluClave == $valores->aluClave && $pos++ == 1){

                    $grp = $valores->cgtGrupo;
                    // $modelo[$grp.'_calif'] = $valores->calificacionFinal;

                    // $modelo['matClave'] = $valores->matClave;
                    $modelo['aluClave'] = $valores->aluClave;

                    array_push($res, $modelo);
                    $modelo = $this->createGruposACD2022($materias_actuales_existentes_acd, $valores->aluClave);
                }
            }


            $pos = 1;

        }



        return $res;
    }

    public function createGrupos($materias_actuales_existentes, $alumno)
    {
        $modelo = [];
        $pos2 = 1;
        foreach ($materias_actuales_existentes as $matactuales => $valores_grupos) {
            foreach($valores_grupos as $vsl){
                if($vsl->aluClave == $alumno && $matactuales == $vsl->matClave){
                    $modelo[$matactuales.'_calif'] = $vsl->calificacionFinal;
                    $modelo['matClave'] = $vsl->matClave;
                    $modelo['alumno'] = $vsl->perApellido1.' '.$vsl->perApellido2.' '.$vsl->perNombre;
                    $modelo[$matactuales.'_matClave'] = $vsl->matClave;

                }
            }

            $modelo['matClave'] = $vsl->matClave;
            // $modelo[$matactuales.'_calif'] = $pos2++;
        }


        return $modelo;
    }


    // funciones para materias acd
    public function createGrupos2022($materias_actuales_existentes, $alumno)
    {
        $modelo = [];
        $pos2 = 1;
        foreach ($materias_actuales_existentes as $matactuales_id => $valores_grupos) {
            foreach($valores_grupos as $vsl){
                if($vsl->aluClave == $alumno && $matactuales_id == $vsl->bachiller_materia_id){
                    $modelo[$matactuales_id.'_calif'] = $vsl->calificacionFinal;
                    $modelo[$matactuales_id.'_materia_id'] = $vsl->bachiller_materia_id;
                    $modelo['matClave'] = $vsl->matClave;
                    $modelo['alumno'] = $vsl->perApellido1.' '.$vsl->perApellido2.' '.$vsl->perNombre;
                    $modelo[$matactuales_id.'_matClave'] = $vsl->matClave;

                }
            }

            $modelo['matClave'] = $vsl->matClave;
            // $modelo[$matactuales.'_calif'] = $pos2++;
        }


        return $modelo;
    }

    public function createGruposACD2022($materias_actuales_existentes, $alumno)
    {
        $modelo = [];
        $pos2 = 1;
        foreach ($materias_actuales_existentes as $matactuales_acd_id => $valores_grupos) {
            foreach($valores_grupos as $vsl){
                if($vsl->aluClave == $alumno && $matactuales_acd_id == $vsl->bachiller_materia_acd_id){
                    $modelo[$matactuales_acd_id.'_calif'] = $vsl->calificacionFinal;
                    $modelo[$matactuales_acd_id.'_materia_id'] = $vsl->bachiller_materia_id;
                    $modelo[$matactuales_acd_id.'_materia_acd_id'] = $vsl->bachiller_materia_acd_id;
                    $modelo['matClave'] = $vsl->matClave;
                    $modelo['alumno'] = $vsl->perApellido1.' '.$vsl->perApellido2.' '.$vsl->perNombre;
                    $modelo[$matactuales_acd_id.'_matClave'] = $vsl->matClave;

                }
            }

            $modelo['matClave'] = $vsl->matClave;
            // $modelo[$matactuales.'_calif'] = $pos2++;
        }


        return $modelo;
    }
}
