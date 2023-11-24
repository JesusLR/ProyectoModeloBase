<?php

namespace App\Http\Controllers\Idiomas;

use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
use Debugbar;
use PDF;


use App\Models\Grupo;
use App\Models\Curso;
use App\Models\Cgt;
use App\Models\Aula;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\Periodo;
use App\Models\Programa;
use App\Models\Plan;
use App\Models\Escuela;
use App\Models\Persona;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Primaria\Primaria_calificacione;
use App\Models\Primaria\Primaria_grupo;
use App\Models\Primaria\Primaria_grupos_evidencias;
use App\Models\Primaria\Primaria_inscrito;
use App\Models\Primaria\Primaria_mes_evaluaciones;

use App\Models\Idiomas\Idiomas_grupos;
use App\Models\Idiomas\Idiomas_niveles;
use App\Models\Idiomas\Idiomas_resumen_calificacion;
use App\Models\Idiomas\Idiomas_calificaciones_materia;

class IdiomasCalificacionesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:preescolarcalificaciones',['except' => ['index','reporteTrimestre', 'reporteTrimestretodos', 'imprimirListaAsistencia',
        // 'create', 'getAlumnos','getGrupos','getMaterias2', 'guardarCalificacion', 'getCalificacionesAlumnos', 'getMesEvidencias','edit_calificacion', 'update_calificacion']]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inscrito_id = $request->inscrito_id;
        $grupo_id = $request->grupo_id;
        $trimestre_a_evaluar = 1;

        $calificaciones = DB::table('primaria_calificaciones')
            ->where('primaria_calificaciones.primaria_inscrito_id',$inscrito_id)
            ->where('primaria_calificaciones.trimestre1',$trimestre_a_evaluar)
            ->where('primaria_calificaciones.aplica','SI')
            ->get();

        //OBTENER GRUPO SELECCIONADO
        //$grupo = Grupo::with('plan.programa', 'materia', 'empleado.persona')->find($grupo_id);
        //OBTENER PROMEDIO PONDERADO EN MATERIA
        //$materia = Preescolar_materia::where('id', $grupo->primaria_materia_id)->first();
        //$escuela = Escuela::where('id', $grupo->plan->programa->escuela_id)->first();

        $grupo = Primaria_grupo::with('primaria_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')
            ->find($grupo_id);

        $inscrito = Primaria_inscrito::find($inscrito_id);
        $inscrito_faltas = "";
        $inscrito_observaciones = "";
        if ($trimestre_a_evaluar == 1)
        {
            $inscrito_faltas = $inscrito->trimestre1_faltas;
            $inscrito_observaciones = $inscrito->trimestre1_observaciones;
        }
        if ($trimestre_a_evaluar == 2)
        {
            $inscrito_faltas = $inscrito->trimestre2_faltas;
            $inscrito_observaciones = $inscrito->trimestre2_observaciones;
        }
        if ($trimestre_a_evaluar == 3)
        {
            $inscrito_faltas = $inscrito->trimestre3_faltas;
            $inscrito_observaciones = $inscrito->trimestre3_observaciones;
        }
        $curso = Curso::with('alumno.persona')->find($inscrito->curso_id);
        $trimestre1_edicion = 'SI';
        $grupo_abierto = 'SI';
        //dd($empleado);
        /*
        $grupo = Preescolar_grupo::with('preescolar_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')
            ->select('preescolar_grupos.*')
            ->where('id',$grupo_id);
        */
        /*
        $data = DB::table('preescolar_calificaciones')
            ->select('preescolar_calificaciones.id',
                'preescolarpreescolar_calificaciones.tipo as categoria',
                'preescolar_calificaciones.trimestre1 as trimestre',
                'preescolar_calificaciones.rubrica as aprendizaje',
                'preescolar_calificaciones.trimestre1_nivel as nivel')
            ->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id);
            //->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id)
            //->orderBy("alumnos.id", "desc");
        */
        //return view('table_edit', compact('data'));
        return View('primaria.calendario.show-list',
            compact('calificaciones',
                'grupo',
                  'grupo_id',
                  'inscrito_id',
                  'inscrito_faltas',
                  'inscrito_observaciones',
                  'curso',
                  'trimestre_a_evaluar',
                  'trimestre1_edicion',
                  'grupo_abierto'));

    }



    public function create()
    {
        $departamento = Departamento::with('ubicacion')->findOrFail(14);
        $perActual = $departamento->perActual;

        $periodos = DB::table('primaria_inscritos')
        ->select('periodos.perAnioPago', DB::raw('count(*) as perAnioPago, periodos.perAnioPago'),
        'periodos.id', DB::raw('count(*) as id, periodos.id'),
        'periodos.perNumero', DB::raw('count(*) as perNumero, periodos.perNumero'))
        ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
        ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
        ->groupBy('periodos.perAnioPago')
        ->groupBy('periodos.id')
        ->groupBy('periodos.perNumero')
        ->orderBy('periodos.perAnioPago', 'desc')
        ->where('primaria_grupos.periodo_id',$perActual)
        ->get();

        return view('primaria.calificaciones.create', [
            'periodos' => $periodos,
        ]);
    }


    public function getAlumnos(Request $request, $id)
    {

        if($request->ajax()){

            $alumnos = Primaria_inscrito::select('primaria_inscritos.id', 'primaria_inscritos.curso_id', 'primaria_inscritos.primaria_grupo_id',
            'primaria_grupos.gpoGrado', 'primaria_grupos.gpoClave', 'programas.progClave', 'periodos.perAnio', 'primaria_materias.matNombre', 'planes.planClave',
            'planes.planPeriodos', 'periodos.id as periodo_id', 'periodos.perFechaInicial', 'periodos.perFechaFinal',
            'alumnos.aluClave','alumnos.id as alumno_id', 'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2')
            ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
            ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->leftJoin('primaria_materias_asignaturas', 'primaria_grupos.primaria_materia_asignatura_id', '=', 'primaria_materias_asignaturas.id')
            ->where('primaria_inscritos.primaria_grupo_id', '=', $id)
            ->orderBy('personas.perApellido1', 'ASC')
            ->get();

            // return response()->json($alumnos);
            return response()->json($alumnos);
        }
    }

    public function getGrupos(Request $request, $id)
    {

        $perActual = Auth::user()->primaria_empleado->escuela->departamento->perActual;


        if ($request->ajax()) {


            $gruposactuales = DB::table('primaria_inscritos')
            ->select(
                'primaria_inscritos.primaria_grupo_id',
                DB::raw('count(*) as primaria_grupo_id, primaria_inscritos.primaria_grupo_id'),
                'primaria_grupos.gpoGrado',
                DB::raw('count(*) as gpoGrado, primaria_grupos.gpoGrado'),
                'primaria_grupos.gpoClave',
                DB::raw('count(*) as gpoClave, primaria_grupos.gpoClave'),
                'periodos.perAnio',
                DB::raw('count(*) as perAnio, periodos.perAnio'),
                'periodos.id',
                DB::raw('count(*) as id, periodos.id'),
                'programas.progNombre',
                DB::raw('count(*) as progNombre, programas.progNombre'),
                'programas.progClave',
                DB::raw('count(*) as progClave, programas.progClave'),
                'primaria_materias.matClave',
                DB::raw('count(*) as matClave, primaria_materias.matClave'),
                'primaria_materias.matNombre',
                DB::raw('count(*) as matNombre, primaria_materias.matNombre'),
                'primaria_materias_asignaturas.matClaveAsignatura',
                DB::raw('count(*) as matClaveAsignatura, primaria_materias_asignaturas.matClaveAsignatura'),
                'primaria_materias_asignaturas.matNombreAsignatura',
                DB::raw('count(*) as matNombreAsignatura, primaria_materias_asignaturas.matNombreAsignatura')
            )
            ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
            ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
            ->leftJoin('primaria_materias_asignaturas', 'primaria_grupos.primaria_materia_asignatura_id', '=', 'primaria_materias_asignaturas.id')
            ->groupBy('primaria_inscritos.primaria_grupo_id')
            ->groupBy('primaria_grupos.gpoGrado')
            ->groupBy('primaria_grupos.gpoClave')
            ->groupBy('periodos.perAnio')
            ->groupBy('periodos.id')
            ->groupBy('programas.progNombre')
            ->groupBy('programas.progClave')
            ->groupBy('primaria_materias.matClave')
            ->groupBy('primaria_materias.matNombre')
            ->groupBy('primaria_materias_asignaturas.matClaveAsignatura')
            ->groupBy('primaria_materias_asignaturas.matNombreAsignatura')
            ->where('periodos.id', '=', $id)
            ->get();

            return response()->json($gruposactuales);
        }
    }

    public function getMaterias2(Request $request, $id)
    {

        if($request->ajax()){

            $materia2 = DB::table('primaria_inscritos')
            ->select('primaria_materias.matNombre', DB::raw('count(*) as matNombre, primaria_materias.matNombre'),
            'primaria_materias.id', DB::raw('count(*) as id, primaria_materias.id'),
            'primaria_inscritos.primaria_grupo_id', DB::raw('count(*) as primaria_grupo_id, primaria_inscritos.primaria_grupo_id'))
            ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
            ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
            ->groupBy('primaria_materias.matNombre')
            ->groupBy('primaria_materias.id')
            ->groupBy('primaria_inscritos.primaria_grupo_id')
            ->where('primaria_inscritos.primaria_grupo_id', '=', $id)
            ->get();

            return response()->json($materia2);
        }
    }

    public function guardarCalificacion(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'primaria_inscrito_id'  => 'required',

            ],
            [
                'primaria_inscrito_id.required' => 'El campo Alumno es obligatorio.',

            ]
        );
        $primaria_inscrito_id = $request->primaria_inscrito_id;
        $evidencia1 = $request->evidencia1;
        $evidencia2 = $request->evidencia2;
        $evidencia3 = $request->evidencia3;
        $evidencia4 = $request->evidencia4;
        $evidencia5 = $request->evidencia5;
        $evidencia6 = $request->evidencia6;
        $evidencia7 = $request->evidencia7;
        $evidencia8 = $request->evidencia8;
        $evidencia9 = $request->evidencia9;
        $evidencia10 = $request->evidencia10;
        $promedioTotal = $request->promedioTotal;
        $numero_evaluacion = $request->numero_evaluacion;
        $primaria_grupo_evidencia_id = $request->primaria_grupo_evidencia_id;
        $mes_evaluacion = $request->mes;


        $obtenerCalificaciones = Primaria_calificacione::select('primaria_inscrito_id','mes_evaluacion')
        ->where('primaria_inscrito_id', '=', $primaria_inscrito_id[0])
        ->where('mes_evaluacion', '=', $mes_evaluacion)
        ->first();

        if(!empty($obtenerCalificaciones)){
            alert('Escuela Modelo', 'Ya se registro calificaciones en el mes seleccionado, ingrese a editar para realizar cambios si así lo desea', 'info')->showConfirmButton();
            // return back();
            return redirect('primaria_calificacion/create')->withErrors($validator)->withInput();
        }

        if(!empty($primaria_inscrito_id)){
            for ($i=0; $i < count($primaria_inscrito_id) ; $i++) {

                $calificaciones = array();
                $calificaciones = new Primaria_calificacione();
                $calificaciones['primaria_inscrito_id'] = $primaria_inscrito_id[$i];
                $calificaciones['primaria_grupo_evidencia_id'] = $primaria_grupo_evidencia_id;
                $calificaciones['numero_evaluacion'] = $numero_evaluacion;
                $calificaciones['mes_evaluacion'] = $mes_evaluacion;
                $calificaciones['calificacion_evidencia1'] = $evidencia1[$i];
                $calificaciones['calificacion_evidencia2'] = $evidencia2[$i];
                $calificaciones['calificacion_evidencia3'] = $evidencia3[$i];
                $calificaciones['calificacion_evidencia4'] = $evidencia4[$i];
                $calificaciones['calificacion_evidencia5'] = $evidencia5[$i];
                $calificaciones['calificacion_evidencia6'] = $evidencia6[$i];
                $calificaciones['calificacion_evidencia7'] = $evidencia7[$i];
                $calificaciones['calificacion_evidencia8'] = $evidencia8[$i];
                $calificaciones['calificacion_evidencia9'] = $evidencia9[$i];
                $calificaciones['calificacion_evidencia10'] = $evidencia10[$i];
                $calificaciones['promedio_mes'] = $promedioTotal[$i];

                $calificaciones->save();
            }

            alert('Escuela Modelo', 'Las calificaciones de crearon con éxito', 'success')->showConfirmButton();
            return back();
        }else{
            alert('Escuela Modelo', 'No se ha seleccionado ningún grupo', 'info')->showConfirmButton();
            return back();
        }


    }

    // funcion para la vista de calificaciones del grupo seleccionado
    public function edit_calificacion($id)
    {
        $this->completar_calificacion($id);
        $grupo = Idiomas_grupos::select(
            'ubicacion.ubiClave',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perFechaInicial',
            'programas.progClave',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            // 'idiomas_niveles.nivPorcentajeMidterm',
            // 'idiomas_niveles.nivPorcentajeProyecto1',
            // 'idiomas_niveles.nivPorcentajeFinal',
            // 'idiomas_niveles.nivPorcentajeProyecto2',
            'idiomas_resumen_calificaciones.id as idiomas_resumen_calificaciones',
            'idiomas_resumen_calificaciones.rcReporte1',
            'idiomas_resumen_calificaciones.rcReporte1Ponderado',
            'idiomas_resumen_calificaciones.rcReporte2',
            'idiomas_resumen_calificaciones.rcReporte2Ponderado',
            'idiomas_resumen_calificaciones.rcMidTerm',
            'idiomas_resumen_calificaciones.rcMidTermPonderado',
            'idiomas_resumen_calificaciones.rcProject1',
            'idiomas_resumen_calificaciones.rcProject1Ponderado',
            'idiomas_resumen_calificaciones.rcReporte3',
            'idiomas_resumen_calificaciones.rcReporte3Ponderado',
            'idiomas_resumen_calificaciones.rcReporte4',
            'idiomas_resumen_calificaciones.rcReporte4Ponderado',
            'idiomas_resumen_calificaciones.rcFinalExam',
            'idiomas_resumen_calificaciones.rcFinalExamPonderado',
            'idiomas_resumen_calificaciones.rcProject2',
            'idiomas_resumen_calificaciones.rcProject2Ponderado',
            'idiomas_grupos.*'
        )
        ->join('periodos', 'idiomas_grupos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('idiomas_cursos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('idiomas_resumen_calificaciones', 'idiomas_resumen_calificaciones.idiomas_curso_id', '=', 'idiomas_cursos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
        // ->join('idiomas_niveles',function($join){
        //     $join->on('idiomas_grupos.plan_id','=','idiomas_niveles.plan_id')
        //         ->on('idiomas_grupos.gpoGrado','=','idiomas_niveles.nivGrado');
        // })
        ->where('idiomas_grupos.id', $id)
        ->where('idiomas_cursos.curEstado', '!=', 'B')
        ->whereNull('idiomas_cursos.deleted_at')
        ->whereNull('idiomas_resumen_calificaciones.deleted_at')
        ->orderBy('personas.perApellido1', 'asc')
        ->orderBy('personas.perApellido2', 'asc')
        ->orderBy('personas.perNombre', 'asc');
        if ($grupo->get()->isEmpty()) {
            alert()->error('Error...', 'No tiene alumnos')->showConfirmButton();
            return back();
        }
        $array = [];
        foreach ($grupo->get() as $key => $value) {
            array_push($array, $value->idiomas_resumen_calificaciones);
        }
        $tbody = Idiomas_calificaciones_materia::select(
            'idiomas_materias.id',
            'idiomas_calificaciones_materia.idiomas_resumen_calificaciones_id',
            'matClave',
            'matNombre',
            'cmReporte1',
            'cmReporte2',
            'cmMidTerm',
            'cmProject1',
            'cmReporte3',
            'cmReporte4',
            'cmFinalExam',
            'cmProject2'
        )
        ->join('idiomas_materias', 'idiomas_calificaciones_materia.idiomas_materia_id', '=', 'idiomas_materias.id')
        ->whereIn('idiomas_resumen_calificaciones_id', $array)
        ->get();
        if ($tbody->isEmpty()) {
            alert()->error('Error...', 'No tiene materias')->showConfirmButton();
            return back();
        }
        $cabecera = Idiomas_calificaciones_materia::select(
            'idiomas_materias.id',
            'idiomas_calificaciones_materia.idiomas_resumen_calificaciones_id',
            'matClave',
            'matNombre',
            'cmReporte1',
            'cmReporte2',
            'cmMidTerm',
            'cmProject1',
            'cmReporte3',
            'cmReporte4',
            'cmFinalExam',
            'cmProject2'
        )
        ->join('idiomas_materias', 'idiomas_calificaciones_materia.idiomas_materia_id', '=', 'idiomas_materias.id')
        ->where('idiomas_resumen_calificaciones_id', $tbody[0]->idiomas_resumen_calificaciones_id)
        ->get();

        return view('idiomas.calificaciones.calificaciones-edit', [
            'alumnos' => $grupo->get(),
            'grupo' => $grupo->first(),
            'cabecera' => $cabecera,
            'tbody' => $tbody
        ]);
    }

    // public function newCalificacionesAlumnos(Request $request, $id, $grupoId)
    // {
    //     $resultado_array =  DB::select("call procPrimariaCalificacionesInexistentesRepetidos("
    //         . $id . ",  " . $grupoId . ")");
    // }

    public function getCalificacionesAlumnos(Request $request, $id, $grupoId)
    {

        if($request->ajax()){

            $calificaciones = Primaria_calificacione::select(
                'primaria_calificaciones.id',
                'primaria_calificaciones.primaria_inscrito_id',
                'primaria_calificaciones.primaria_grupo_evidencia_id',
                'primaria_calificaciones.numero_evaluacion',
                'primaria_calificaciones.mes_evaluacion',
                'primaria_calificaciones.calificacion_evidencia1',
                'primaria_calificaciones.calificacion_evidencia2',
                'primaria_calificaciones.calificacion_evidencia3',
                'primaria_calificaciones.calificacion_evidencia4',
                'primaria_calificaciones.calificacion_evidencia5',
                'primaria_calificaciones.calificacion_evidencia6',
                'primaria_calificaciones.calificacion_evidencia7',
                'primaria_calificaciones.calificacion_evidencia8',
                'primaria_calificaciones.calificacion_evidencia9',
                'primaria_calificaciones.calificacion_evidencia10',
                'primaria_calificaciones.promedio_mes',

                'primaria_inscritos.primaria_grupo_id',

                'primaria_grupos.gpoGrado',
                'primaria_grupos.gpoClave',

                'primaria_materias.id as id_materia',
                'primaria_materias.matClave',
                'primaria_materias.matNombre',

                'planes.id as id_plan',
                'planes.planClave',

                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',

                'departamentos.depClave',
                'departamentos.depNombre',

                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',

                'programas.id as programa_id',
                'programas.progClave',
                'programas.progNombre'
            )
            ->join('primaria_inscritos', 'primaria_calificaciones.primaria_inscrito_id', '=', 'primaria_inscritos.id')
            ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
            ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
            ->join('planes', 'primaria_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('cursos', 'primaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('primaria_calificaciones.primaria_grupo_evidencia_id', '=', $id)
            ->where('primaria_inscritos.primaria_grupo_id', '=', $grupoId)
            ->whereNull('primaria_inscritos.deleted_at')
            ->whereNull('primaria_calificaciones.deleted_at')
            ->orderBy('personas.perApellido1', 'ASC')
            ->orderBy('personas.perApellido2', 'ASC')
            ->orderBy('personas.perNombre', 'ASC')
            ->toSql();

            return response()->json([
                'calificaciones' => $calificaciones
            ]);

        }
    }

    // funcion para actualizar calificaciones del grupo seleccionado
    public function update_calificacion(Request $request)
    {
        $evidenciasConExcepcion = ['MidTerm', 'Project1', 'FinalExam', 'Project2'];
        $nivel = Idiomas_niveles::select('idiomas_niveles.*')
            // ->join('idiomas_grupos', 'idiomas_grupos.plan_id', '=', 'idiomas_niveles.plan_id')
            ->join('idiomas_grupos',function($join){
                $join->on('idiomas_grupos.plan_id','=','idiomas_niveles.plan_id')
                    ->on('idiomas_grupos.gpoGrado','=','idiomas_niveles.nivGrado');
            })
            ->where('idiomas_grupos.id', $request->idiomas_grupo_id)
            ->first();
        $calificaciones = 'calificaciones_'.$request->idiomas_grupo_evidencia_id;
        foreach ($request->$calificaciones as $idiomas_resumen_calificaciones => $materias) {
            $columna = 'nivPorcentaje'.$request->idiomas_grupo_evidencia_id; // esto es Reporte1 ej entonces quedaria como nivPorcentajeReporte1
            if ($columna == 'nivPorcentajeMidTerm') $columna = 'nivPorcentajeMidterm';
            if ($columna == 'nivPorcentajeProject1') $columna = 'nivPorcentajeProyecto1';
            if ($columna == 'nivPorcentajeFinalExam') $columna = 'nivPorcentajeFinal';
            if ($columna == 'nivPorcentajeProject2') $columna = 'nivPorcentajeProyecto2';
            $porcentaje = $nivel->$columna; // entonces quedaria como $nivel->nivPorcentajeReporte1 según sea el caso
            $total = collect($materias)->sum();

            if ($total > 100) {
                alert()->error('Error...', 'El total no debe exceder los 100 puntos')->showConfirmButton();
                return redirect('idiomas_calificacion/grupo/'.$request->idiomas_grupo_id.'/edit/' )->withInput();
            }
            if ($total == 0) {
                continue;
            }
            $pond = round(($total * (int)$porcentaje)/100);

            if (in_array($request->idiomas_grupo_evidencia_id, $evidenciasConExcepcion)) {
                if ($total > $porcentaje) {
                    alert()->error('Error...', 'La calificación con valor: '.$total.' no debe exceder: '.$porcentaje)->showConfirmButton();
                    return redirect('idiomas_calificacion/grupo/'.$request->idiomas_grupo_id.'/edit/' )->withInput();
                }
                Idiomas_resumen_calificacion::where('id', $idiomas_resumen_calificaciones)->update([
                    'rc'.$request->idiomas_grupo_evidencia_id => $total,
                    'rc'.$request->idiomas_grupo_evidencia_id.'Ponderado' => $total,
                ]);
            } else {
                // if ($total > $porcentaje) {
                //     alert()->error('Error...', 'La calificación con valor: '.$total.' no debe exceder: '.$porcentaje)->showConfirmButton();
                //     return redirect('idiomas_calificacion/grupo/'.$request->idiomas_grupo_id.'/edit/' )->withInput();
                // }
                Idiomas_resumen_calificacion::where('id', $idiomas_resumen_calificaciones)->update([
                    'rc'.$request->idiomas_grupo_evidencia_id => $total,
                    'rc'.$request->idiomas_grupo_evidencia_id.'Ponderado' => $pond,
                ]);
    
                foreach ($materias as $id => $calificacion) {
                    // if ($calificacion > $porcentaje) {
                    //     alert()->error('Error...', 'La calificación con valor: '.$calificacion.' no debe exceder: '.$porcentaje)->showConfirmButton();
                    //     return redirect('idiomas_calificacion/grupo/'.$request->idiomas_grupo_id.'/edit/' )->withInput();
                    // }
                    Idiomas_calificaciones_materia::where('idiomas_materia_id', $id)
                    ->where('idiomas_resumen_calificaciones_id', $idiomas_resumen_calificaciones)
                    ->update([
                        'cm'.$request->idiomas_grupo_evidencia_id => $calificacion
                    ]);
                }
            }

            // calcular final score
            $finalScore = 0;
            $irc = Idiomas_resumen_calificacion::where('id', $idiomas_resumen_calificaciones)->first();
            if ($irc->rcReporte1Ponderado) $finalScore += $irc->rcReporte1Ponderado;
            if ($irc->rcReporte2Ponderado) $finalScore += $irc->rcReporte2Ponderado;
            if ($irc->rcMidTerm) $finalScore += $irc->rcMidTerm;
            if ($irc->rcProject1) $finalScore += $irc->rcProject1;
            if ($irc->rcReporte3Ponderado) $finalScore += $irc->rcReporte3Ponderado;
            if ($irc->rcReporte4Ponderado) $finalScore += $irc->rcReporte4Ponderado;
            if ($irc->rcFinalExam) $finalScore += $irc->rcFinalExam;
            if ($irc->rcProject2) $finalScore += $irc->rcProject2;

            if ($finalScore != 0) {
                Idiomas_resumen_calificacion::where('id', $idiomas_resumen_calificaciones)->update([
                    'rcFinalScore' => $finalScore,
                ]);
            }

        }

        alert('Escuela Modelo', 'Las calificaciones se actualizaron con éxito', 'success')->showConfirmButton();
        return back();
    }

    public function update(Request $request, $id)
    {

    }

    public function store(Request $request)
    {
        $grupo_id = $request->grupo_id;
        $trimestre1_edicion = $request->trimestre1_edicion;
        $inscrito_id = $request->inscrito_id;
        $trimestre_a_evaluar = $request->trimestre_a_evaluar;
        $trimestre1_faltas = 0;
        $trimestre1_observaciones = "";


        try {

            $rubricas = DB::table('primaria_calificaciones')
                ->where('primaria_calificaciones.primaria_inscrito_id',$inscrito_id)
                ->where('primaria_calificaciones.trimestre1',$trimestre_a_evaluar)
                ->where('primaria_calificaciones.aplica','SI')
                ->get();

            $calificaciones = $request->calificaciones;


            if ($trimestre_a_evaluar == 1)
            {
                $trimestre1Col  = $request->has("calificaciones.trimestre1")  ? collect($calificaciones["trimestre1"])  : collect();
                $trimestre1_faltas = $request->trimestreFaltas;
                $trimestre1_observaciones = $request->trimestreObservaciones;
            }



            // dd($inscritos->map(function ($item, $key) {
            //     return $item->id;
            // })->all());

            foreach ($rubricas as $rubrica) {
                $calificacion = Primaria_calificacione::where('id', $rubrica->id)->first();

                if ($trimestre_a_evaluar == 1)
                {
                    $inscCalificacionRubrica = $trimestre1Col->filter(function ($value, $key) use ($rubrica) {
                        return $key == $rubrica->id;
                    })->first();

                    if ($calificacion) {
                        $calificacion->trimestre1_nivel = $inscCalificacionRubrica != null ? $inscCalificacionRubrica : $calificacion->trimestre1_nivel;
                        $calificacion->save();

                        //$result =  DB::select("call procInscritoPromedioParcial("." ".$inscrito->id." )");
                    }
                }
            }

            $inscritofaltas = Primaria_inscrito::where('id', $inscrito_id)->first();
            if ($inscritofaltas) {
                if ($trimestre_a_evaluar == 1)
                {
                    $inscritofaltas->trimestre1_faltas = $trimestre1_faltas != null ? $trimestre1_faltas : $inscritofaltas->trimestre1_faltas;
                    $inscritofaltas->trimestre1_observaciones = $trimestre1_observaciones != null ? $trimestre1_observaciones : $inscritofaltas->trimestre1_observaciones;
                }

                $inscritofaltas->save();
            }


            alert('Escuela Modelo', 'Se registraron las calificaciones con éxito', 'success')->showConfirmButton()->autoClose(3000);
            return redirect('primaria_inscritos/'.$grupo_id);

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('primaria_inscritos/'.$grupo_id )->withInput();
        }
    }

    public function boletadesdecurso($curso_id)
    {

        $parametro_Titulo = "BOLETA DE CALIFICACIONES DEL ALUMNO(A)";

        $cursos = Curso::select('cursos.id', 'periodos.id as periodo_id', 'periodos.departamento_id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->where('cursos.id', '=', $curso_id)
            ->first();

        $periodoEscolar = Periodo::where('id', $cursos->periodo_id)->first();

        if ($periodoEscolar->perAnioPago >= 2021) {

            $parametro_NombreArchivo = 'pdf_primaria_boleta_calificaciones_2021';


            $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesCurso("
            . $curso_id
                . ")");
            $resultado_collection = collect($resultado_array);

            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno(a). Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
            $resultado_registro = $resultado_array[0];


            $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');


            //dd($pagos_deudores_collection);
            $parametro_Alumno = $resultado_registro->nombres . " " . $resultado_registro->ape_paterno .
                " " . $resultado_registro->ape_materno;
            $parametro_Clave = $resultado_registro->clave_pago;
            $parametro_Grupo = $resultado_registro->gpoGrado . "" . $resultado_registro->gpoClave;
            $parametro_Curp = $resultado_registro->curp;
            $parametro_Ciclo = $resultado_registro->ciclo_escolar;
            $parametro_tipo = $resultado_registro->carrera; //PRB


            //$fechaActual = Carbon::now();
            $fechaActual = Carbon::now('America/Merida');

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');


            $pdf = PDF::loadView('reportes.pdf.primaria.boleta_de_calificaciones.' . $parametro_NombreArchivo, [
                "calificaciones" => $resultado_collection,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $parametro_Ciclo,
                "curp" => $parametro_Curp,
                "nombreAlumno" => $parametro_Alumno,
                "clavepago" => $parametro_Clave,
                "gradogrupo" => $parametro_Grupo,
                "titulo" => $parametro_Titulo,
                "alumnoAgrupado" => $alumnoAgrupado,
                "parametro_tipo" => $parametro_tipo
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        } else {
            $parametro_NombreArchivo = 'pdf_primaria_boleta_calificaciones';

            $resultado_array =  DB::select("call procPrimariaBoletaCalificacionesCurso("
            . $curso_id
                . ")");
            $resultado_collection = collect($resultado_array);

            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno(a). Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
            $resultado_registro = $resultado_array[0];


            $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');


            //dd($pagos_deudores_collection);
            $parametro_Alumno = $resultado_registro->nombres . " " . $resultado_registro->ape_paterno .
                " " . $resultado_registro->ape_materno;
            $parametro_Clave = $resultado_registro->clave_pago;
            $parametro_Grupo = $resultado_registro->gpoGrado . "" . $resultado_registro->gpoClave;
            $parametro_Curp = $resultado_registro->curp;
            $parametro_Ciclo = $resultado_registro->ciclo_escolar;
            $parametro_tipo = $resultado_registro->carrera; //PRB


            //$fechaActual = Carbon::now();
            $fechaActual = Carbon::now('America/Merida');

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');


            $pdf = PDF::loadView('reportes.pdf.primaria.boleta_de_calificaciones.' . $parametro_NombreArchivo, [
                "calificaciones" => $resultado_collection,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $parametro_Ciclo,
                "curp" => $parametro_Curp,
                "nombreAlumno" => $parametro_Alumno,
                "clavepago" => $parametro_Clave,
                "gradogrupo" => $parametro_Grupo,
                "titulo" => $parametro_Titulo,
                "alumnoAgrupado" => $alumnoAgrupado,
                "parametro_tipo" => $parametro_tipo
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }

    public function reporteTrimestretodos($grupo_id, $trimestre_a_evaluar)
    {

        $cursos_grupo = Curso::select(
            'cursos.id as curso_id',
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'alumnos.aluMatricula',
            'personas.perNombre',
            'personas.id as personas_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'cursos.curEstado',
            'cursos.curTipoIngreso',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progNombre',
            'programas.progClave',
            'escuelas.escNombre',
            'escuelas.escClave',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiNombre',
            'ubicacion.ubiClave',
            'primaria_grupos.gpoGrado',
            'primaria_inscritos.id as inscrito_id',
            'primaria_inscritos.primaria_grupo_id',
            'primaria_grupos.gpoClave',
            'primaria_inscritos.trimestre1_faltas',
            'primaria_inscritos.trimestre1_observaciones'
        )
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('primaria_inscritos', 'cursos.id', '=', 'primaria_inscritos.curso_id')
        ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('primaria_inscritos.primaria_grupo_id', $grupo_id)
            ->whereIn('depClave', ['PRI'])
            ->orderBy("personas.perApellido1", "asc")
            ->get();

        /*foreach ($cursos_grupo as $curso_grupo) {*/
            /*
            $calificaciones_array = DB::table('preescolar_calificaciones')
                ->join('preescolar_inscritos', 'preescolar_inscritos.id', '=', 'preescolar_calificaciones.preescolar_inscrito_id')
                ->where('preescolar_inscritos.preescolar_grupo_id', $grupo_id)
                ->where('preescolar_calificaciones.trimestre1', $trimestre_a_evaluar)
                ->where('preescolar_calificaciones.aplica', 'SI')
                ->orderBy('preescolar_inscritos.id','asc')
                ->orderBy('preescolar_calificaciones.rubrica_id', 'asc')
                ->get();

            if (!$calificaciones_array) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar')->showConfirmButton();
                return back()->withInput();
            }
                        $calificaciones_collection = collect($calificaciones_array);
            */

            //dd($calificaciones_array);

            $grupos_collection = collect($cursos_grupo);

            if($grupos_collection->isEmpty()) {
              alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
              return back();
            }


            $persona = Persona::findOrFail($cursos_grupo[0]->personas_id);
            //$inscritos = Preescolar_inscrito::findOrFail($cursos_grupo->inscrito_id);
            $grupos = Primaria_grupo::findOrFail($cursos_grupo[0]->primaria_grupo_id);
            $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
            $personaDocente = Persona::findOrFail($empleado->persona_id);
            //$trimestre_faltas = $inscritos->trimestre1_faltas;
           // $trimestre_observaciones = $inscritos->trimestre1_observaciones;

            $fechaActual = Carbon::now();

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $cicloEscolar = "CICLO 2020 – 2021";

            // valida que trimestre es para asginar un nombre de reporte
            if($trimestre_a_evaluar == 1){
                $numeroReporte = "Primer Reporte";
            }
            elseif($trimestre_a_evaluar == 2){
                $numeroReporte = "Segundo Reporte";
            }
            elseif($trimestre_a_evaluar == 3){
                $numeroReporte = "Tercer Reporte";
            }else{
                $numeroReporte = "";
            }

            $kinderGradoTrimestre = "KINDER " . $cursos_grupo[0]->gpoGrado . $cursos_grupo[0]->gpoClave . " - ". $numeroReporte;
            $nombreAlumno = $persona->perNombre . " " . $persona->perApellido1 . " " . $persona->perApellido2;
            $nombreDocente = $personaDocente->perNombre . " " . $personaDocente->perApellido1 . " " . $personaDocente->perApellido2;

            $nombreArchivo = 'pdf_primaria_reporte_general_aprovechamiento';


            $pdf = PDF::loadView('reportes.pdf.primaria.' . $nombreArchivo, [
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $cicloEscolar,
                "kinderGradoTrimestre" => $kinderGradoTrimestre,
                "nombreDocente" => $nombreDocente,
                "nombreArchivo" => $nombreArchivo,
                "trimestre" => $trimestre_a_evaluar,
                "cursos_grupo" => $cursos_grupo

            ]);

            $pdf->setPaper('letter', 'portrait');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($nombreAlumno . '_' . $nombreArchivo . '.pdf');
            return $pdf->download($nombreAlumno . '_' . $nombreArchivo  . '.pdf');
        /*}*/
    }

    public function imprimirListaAsistencia($grupo_id)
    {

        $cursos_grupo = Curso::select(
            'cursos.id as curso_id',
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'alumnos.aluMatricula',
            'personas.perNombre',
            'personas.id as personas_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'cursos.curEstado',
            'cursos.curTipoIngreso',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progNombre',
            'programas.progClave',
            'escuelas.escNombre',
            'escuelas.escClave',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiNombre',
            'ubicacion.ubiClave',
            'primaria_grupos.gpoGrado',
            'primaria_inscritos.id as inscrito_id',
            'primaria_inscritos.primaria_grupo_id',
            'primaria_grupos.gpoClave',
            'primaria_inscritos.trimestre1_faltas',
            'primaria_inscritos.trimestre2_faltas',
            'primaria_inscritos.trimestre3_faltas',
            'primaria_inscritos.trimestre1_observaciones',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'primaria_materias.matNombre'
        )
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('primaria_inscritos', 'cursos.id', '=', 'primaria_inscritos.curso_id')
        ->join('primaria_grupos', 'primaria_inscritos.primaria_grupo_id', '=', 'primaria_grupos.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
        ->where('primaria_inscritos.primaria_grupo_id', $grupo_id)
            ->whereIn('depClave', ['PRE'])
            ->orderBy("personas.perApellido1", "asc")
            ->get();
        $fechaActual = Carbon::now('CDT');


        foreach($cursos_grupo as $item){
            $persona = Persona::findOrFail($item->personas_id);
            $inscritos = Primaria_inscrito::findOrFail($item->inscrito_id);
            $grupos = Primaria_grupo::findOrFail($inscritos->primaria_grupo_id);
            $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
            $personaDocente = Persona::findOrFail($empleado->persona_id);
            $periodo = Periodo::findOrFail($item->periodo_id);
            $programa = Programa::findOrFail($item->programa_id);
            $plan = Plan::findOrFail($item->plan_id);

            // ubicacion
            $ubiClave = $item->ubiClave;
            $ubiNombre = $item->ubiNombre;
            $primaria_materia = $item->matNombre;
        }



        $info = collect([
            'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
            'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
            'ubicacion' => $ubiClave.' '.$ubiNombre,

            // grupo y grado
            'gradoAlumno' => $grupos->gpoGrado,
            'grupoAlumno' => $grupos->gpoClave,
            // maestro
            'nombreDocente' => $personaDocente->perNombre . ' ' . $personaDocente->perApellido1 . ' ' . $personaDocente->perApellido2,

             // programa
             'progClave' => $programa->progClave,
             'progNombre' => $programa->progNombre,
             'progNombreCorto' => $programa->progNombreCorto,

              // plan
            'planClave' => $plan->planClave,

            //materia
            'primaria_materia' => $primaria_materia

        ]);




        // echo '<br>';
        // echo 'plan id ' . $grupos->plan_id;
        // echo '<br>';
        // echo 'turno ' .$grupos->gpoTurno;

      // Unix
      setlocale(LC_TIME, 'es_ES.UTF-8');
      // En windows
      setlocale(LC_TIME, 'spanish');

        $nombreArchivo = 'Lista primaria';
        $pdf = PDF::loadView('reportes.pdf.primaria.pdf_primaria_lista_asistencia', [
            "info" => $info,
            "cursos_grupo" => $cursos_grupo,
            "nombreArchivo" => $nombreArchivo,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
        ]);

        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($info['gradoAlumno'].$info['grupoAlumno']."_".$nombreArchivo);
        return $pdf->download($info['gradoAlumno'].$info['grupoAlumno']."_".$nombreArchivo);
    }

    public function destroy($id)
    {

    }


    private function completar_calificacion($grupo_id)
    {
        $grupos = Idiomas_grupos::select(
            'idiomas_resumen_calificaciones.id'
        )
        ->join('periodos', 'idiomas_grupos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('idiomas_cursos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('idiomas_resumen_calificaciones', 'idiomas_resumen_calificaciones.idiomas_curso_id', '=', 'idiomas_cursos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
        ->where('idiomas_grupos.id', $grupo_id)
        ->get();

        $array_ids = [];
        $materias_ids = [];
        foreach ($grupos as $grupo) {
            $calificaciones_materia = Idiomas_calificaciones_materia::select(
                'idiomas_calificaciones_materia.idiomas_materia_id'
            )
            ->where('idiomas_resumen_calificaciones_id', $grupo->id)->get();
            if ($calificaciones_materia->isEmpty()) {
                array_push($array_ids, $grupo->id);
            } else {
                if (!count($materias_ids)>0) {
                    foreach ($calificaciones_materia as $idiomas_materia_id) {
                        array_push($materias_ids, $idiomas_materia_id->idiomas_materia_id);
                    }
                }
            }
        }

        if (count($array_ids)>0) {
            foreach ($array_ids as $id) {
                foreach ($materias_ids as $materia) {
                    Idiomas_calificaciones_materia::create([
                        'idiomas_materia_id' => $materia,
                        'idiomas_resumen_calificaciones_id' => $id
                    ]);
                }
            }
        }
    }
}
