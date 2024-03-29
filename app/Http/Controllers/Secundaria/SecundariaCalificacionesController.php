<?php

namespace App\Http\Controllers\Secundaria;

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
use App\Models\Secundaria\Secundaria_calificaciones;
use App\Models\Secundaria\Secundaria_empleados;
use App\Models\Secundaria\Secundaria_grupos;
use App\Models\Secundaria\Secundaria_grupos_evidencias;
use App\Models\Secundaria\Secundaria_inscritos;
use App\Models\Secundaria\Secundaria_mes_evaluaciones;
use App\Models\Secundaria\Secundaria_porcentajes;

class SecundariaCalificacionesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

        $calificaciones = DB::table('secundaria_calificaciones')
            ->where('secundaria_calificaciones.secundaria_inscrito_id', $inscrito_id)
            ->where('secundaria_calificaciones.trimestre1', $trimestre_a_evaluar)
            ->where('secundaria_calificaciones.aplica', 'SI')
            ->get();

        //OBTENER GRUPO SELECCIONADO
        //$grupo = Grupo::with('plan.programa', 'materia', 'empleado.persona')->find($grupo_id);
        //OBTENER PROMEDIO PONDERADO EN MATERIA
        //$materia = Preescolar_materia::where('id', $grupo->secundaria_materia_id)->first();
        //$escuela = Escuela::where('id', $grupo->plan->programa->escuela_id)->first();

        $grupo = Secundaria_grupos::with(
            'secundaria_materia',
            'periodo',
            'secundaria_empleado',
            'plan.programa.escuela.departamento.ubicacion'
        )
            ->find($grupo_id);

        $inscrito = Secundaria_inscritos::find($inscrito_id);
        $inscrito_faltas = "";
        $inscrito_observaciones = "";
        if ($trimestre_a_evaluar == 1) {
            $inscrito_faltas = $inscrito->trimestre1_faltas;
            $inscrito_observaciones = $inscrito->trimestre1_observaciones;
        }
        if ($trimestre_a_evaluar == 2) {
            $inscrito_faltas = $inscrito->trimestre2_faltas;
            $inscrito_observaciones = $inscrito->trimestre2_observaciones;
        }
        if ($trimestre_a_evaluar == 3) {
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
        return view(
            'secundaria.calendario.show-list',
            compact(
                'calificaciones',
                'grupo',
                'grupo_id',
                'inscrito_id',
                'inscrito_faltas',
                'inscrito_observaciones',
                'curso',
                'trimestre_a_evaluar',
                'trimestre1_edicion',
                'grupo_abierto'
            )
        );
    }



    public function create()
    {
        $usuarioLogueado = auth()->user()->username;

        $EMPLEADO = auth()->user()->empleado_id;

        $periodos = DB::table('secundaria_inscritos')
            ->select(
                'periodos.perAnioPago',
                DB::raw('count(*) as perAnioPago, periodos.perAnioPago'),
                'periodos.id',
                DB::raw('count(*) as id, periodos.id'),
                'periodos.perNumero',
                DB::raw('count(*) as perNumero, periodos.perNumero')
            )
            ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
            ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->groupBy('periodos.perAnioPago')
            ->groupBy('periodos.id')
            ->groupBy('periodos.perNumero')
            ->orderBy('periodos.perAnioPago', 'desc')
            ->get();

        return view('secundaria.calificaciones.create', [
            'periodos' => $periodos,
        ]);
    }


    public function getAlumnos(Request $request, $id)
    {
        if ($request->ajax()) {

            $alumnos = Secundaria_inscritos::select(
                'secundaria_inscritos.id',
                'secundaria_inscritos.curso_id',
                'secundaria_inscritos.grupo_id',
                'secundaria_grupos.gpoGrado',
                'secundaria_grupos.gpoClave',
                'programas.progClave',
                'periodos.perAnio',
                'secundaria_materias.matNombre',
                'planes.planClave',
                'planes.planPeriodos',
                'periodos.id as periodo_id',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'alumnos.aluClave',
                'alumnos.id as alumno_id',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2'
            )
                ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
                ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->where('secundaria_inscritos.grupo_id', '=', $id)
                ->get();

            // return response()->json($alumnos);
            return response()->json($alumnos);
        }
    }

    public function getGrupos(Request $request, $id)
    {

        $usuarioLogueado = auth()->user()->username;

        $EMPLEADO = auth()->user()->empleado_id;


        if ($request->ajax()) {

            $gruposactuales = DB::table('secundaria_inscritos')
                ->select(
                    'secundaria_inscritos.grupo_id',
                    DB::raw('count(*) as grupo_id, secundaria_inscritos.grupo_id'),
                    'secundaria_grupos.gpoGrado',
                    DB::raw('count(*) as gpoGrado, secundaria_grupos.gpoGrado'),
                    'secundaria_grupos.gpoClave',
                    DB::raw('count(*) as gpoClave, secundaria_grupos.gpoClave'),
                    'periodos.perAnio',
                    DB::raw('count(*) as perAnio, periodos.perAnio'),
                    'periodos.id',
                    DB::raw('count(*) as id, periodos.id'),
                    'programas.progNombre',
                    DB::raw('count(*) as progNombre, programas.progNombre'),
                    'secundaria_materias.matClave',
                    DB::raw('count(*) as matClave, secundaria_materias.matClave')
                )
                ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
                ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                ->groupBy('secundaria_inscritos.grupo_id')
                ->groupBy('secundaria_grupos.gpoGrado')
                ->groupBy('secundaria_grupos.gpoClave')
                ->groupBy('periodos.perAnio')
                ->groupBy('periodos.id')
                ->groupBy('programas.progNombre')
                ->groupBy('secundaria_materias.matClave')
                ->where('periodos.id', '=', $id)
                ->get();

            return response()->json($gruposactuales);
        }
    }

    public function getMaterias2(Request $request, $id)
    {
        $usuarioLogueado = auth()->user()->username;

        $EMPLEADO = auth()->user()->empleado_id;


        if ($request->ajax()) {

            $materia2 = DB::table('secundaria_inscritos')
                ->select(
                    'secundaria_materias.matNombre',
                    DB::raw('count(*) as matNombre, secundaria_materias.matNombre'),
                    'secundaria_materias.id',
                    DB::raw('count(*) as id, secundaria_materias.id'),
                    'secundaria_inscritos.grupo_id',
                    DB::raw('count(*) as grupo_id, secundaria_inscritos.grupo_id')
                )
                ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
                ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                ->groupBy('secundaria_materias.matNombre')
                ->groupBy('secundaria_materias.id')
                ->groupBy('secundaria_inscritos.grupo_id')
                ->where('secundaria_inscritos.grupo_id', '=', $id)
                ->get();

            return response()->json($materia2);
        }
    }

    public function guardarCalificacion(Request $request)
    {
        $secundaria_inscrito_id = $request->secundaria_inscrito_id;
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
        $secundaria_grupo_evidencia_id = $request->secundaria_grupo_evidencia_id;
        $mes_evaluacion = $request->mes;


        $obtenerCalificaciones = Secundaria_calificaciones::select('secundaria_inscrito_id', 'mes_evaluacion')
            ->where('secundaria_inscrito_id', '=', $secundaria_inscrito_id[0])
            ->where('mes_evaluacion', '=', $mes_evaluacion)
            ->first();

        if (!empty($obtenerCalificaciones)) {
            alert('Escuela Modelo', 'Ya se registro calificaciones en el mes seleccionado, ingrese a editar para realizar cambios si así lo desea', 'info')->showConfirmButton();
            return back();
        }

        if (!empty($secundaria_inscrito_id)) {
            for ($i = 0; $i < count($secundaria_inscrito_id); $i++) {

                $calificaciones = array();
                $calificaciones = new Secundaria_calificaciones();
                $calificaciones['secundaria_inscrito_id'] = $secundaria_inscrito_id[$i];
                $calificaciones['secundaria_grupo_evidencia_id'] = $secundaria_grupo_evidencia_id;
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
        } else {
            alert('Escuela Modelo', 'No se ha seleccionado ningún grupo', 'info')->showConfirmButton();
            return back();
        }
    }


    // funcion para la vista de calificaciones del grupo seleccionado
    public function edit_calificacion($id)
    {
        $validar_si_esta_activo_cva = Auth::user()->campus_cva;

        $validar_si_esta_activo_cme = Auth::user()->campus_cme;

        $calificaciones = Secundaria_calificaciones::select(
            'secundaria_calificaciones.id',
            'secundaria_calificaciones.secundaria_inscrito_id',
            'secundaria_calificaciones.numero_evaluacion',
            'secundaria_calificaciones.mes_evaluacion',
            'secundaria_calificaciones.calificacion_evidencia1',
            'secundaria_calificaciones.calificacion_evidencia2',
            'secundaria_calificaciones.calificacion_evidencia3',
            'secundaria_calificaciones.calificacion_evidencia4',
            'secundaria_calificaciones.calificacion_evidencia5',
            'secundaria_calificaciones.calificacion_evidencia6',
            'secundaria_calificaciones.calificacion_evidencia7',
            'secundaria_calificaciones.calificacion_evidencia8',
            'secundaria_calificaciones.calificacion_evidencia9',
            'secundaria_calificaciones.calificacion_evidencia10',
            'secundaria_calificaciones.promedio_mes',
            'secundaria_inscritos.grupo_id',
            'secundaria_grupos.gpoGrado',
            'secundaria_grupos.gpoClave',
            'secundaria_grupos.gpoMatComplementaria',
            'secundaria_materias.id as id_materia',
            'secundaria_materias.matClave',
            'secundaria_materias.matNombre',
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
            'programas.progNombre',
            'alumnos.id as alumno_id',
            'secundaria_mes_evaluaciones.id as mes_id',
            'secundaria_mes_evaluaciones.mes',
            'ubicacion.ubiClave'
        )
            ->join('secundaria_inscritos', 'secundaria_calificaciones.secundaria_inscrito_id', '=', 'secundaria_inscritos.id')
            ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
            ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->join('planes', 'secundaria_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('secundaria_mes_evaluaciones', 'secundaria_calificaciones.numero_evaluacion', '=', 'secundaria_mes_evaluaciones.id')
            ->where('secundaria_inscritos.grupo_id', '=', $id)
            ->whereNull('secundaria_inscritos.deleted_at')
            ->whereNull('secundaria_grupos.deleted_at')
            ->whereNull('cursos.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->orderBy('personas.perApellido1')
            ->orderBy('personas.perApellido2')
            ->orderBy('personas.perNombre')
            ->get();




        $grupos_calificaciones = collect($calificaciones);

        if ($grupos_calificaciones->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
            return back();
        }

        $secundaria_inscritos = Secundaria_inscritos::where('grupo_id',$id)
        ->whereNull('deleted_at')
        ->get();

        if (count($secundaria_inscritos) < 1) {
            alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
            return back();
        }

        $sp_actualiza_grupo_evidencia_id = DB::select("call procSecundariaActualizaGrupoEvidencia(".$id.")");


        $secundaria_grupos_evidencias = Secundaria_grupos_evidencias::select('secundaria_grupos_evidencias.*','secundaria_mes_evaluaciones.numero_evaluacion')
        ->where('secundaria_grupo_id',$id)
        ->join('secundaria_mes_evaluaciones', 'secundaria_mes_evaluaciones.id', '=', 'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id')
        ->whereNull('secundaria_grupos_evidencias.deleted_at')
        ->orderBy('secundaria_grupos_evidencias.secundaria_mes_evaluacion_id', 'ASC')
        ->get();


        if(count($secundaria_grupos_evidencias) > 0){

            if(count($secundaria_inscritos) > 0){

                foreach($secundaria_grupos_evidencias as $evidencia){
                    foreach($secundaria_inscritos as $inscrito){
                        $califica = Secundaria_calificaciones::where('secundaria_inscrito_id', $inscrito->id)
                        ->where('secundaria_grupo_evidencia_id', $evidencia->id)
                        ->whereNull('deleted_at')
                        ->get();

                        if(count($califica) < 1){

                            Secundaria_calificaciones::create([
                                'secundaria_inscrito_id' => $inscrito->id,
                                'secundaria_grupo_evidencia_id' => $evidencia->id,
                                'numero_evaluacion' => $evidencia->numero_evaluacion,
                                'mes_evaluacion' => $evidencia->mes,
                                'usuario_at' => auth()->user()->id
                            ]);


                        }

                        $califica = [];
                    }
                }

            }

        }



        $mes_evaluacion = Secundaria_mes_evaluaciones::get();

        return view('secundaria.calificaciones.calificaciones-edit', [
            'calificaciones' => $calificaciones,
            'mes_evaluacion' => $mes_evaluacion,
            'validar_si_esta_activo_cva' => $validar_si_esta_activo_cva,
            'validar_si_esta_activo_cme' => $validar_si_esta_activo_cme
        ]);
    }

    public function recuperativos($id)
    {

        $secundaria_inscritos = Secundaria_inscritos::select(
            'secundaria_inscritos.id',
            'secundaria_inscritos.curso_id',
            'secundaria_inscritos.grupo_id',
            'secundaria_inscritos.inscCalificacionSep',
            'secundaria_inscritos.inscCalificacionOct',
            'secundaria_inscritos.inscCalificacionNov',
            'secundaria_inscritos.inscCalificacionDic',
            'secundaria_inscritos.inscCalificacionEne',
            'secundaria_inscritos.inscCalificacionFeb',
            'secundaria_inscritos.inscCalificacionMar',
            'secundaria_inscritos.inscCalificacionAbr',
            'secundaria_inscritos.inscCalificacionMay',
            'secundaria_inscritos.inscCalificacionJun',
            'secundaria_inscritos.inscPromedioPorMeses',
            'secundaria_inscritos.inscPromedioBimestre1',
            'secundaria_inscritos.inscPromedioBimestre2',
            'secundaria_inscritos.inscPromedioBimestre3',
            'secundaria_inscritos.inscPromedioBimestre4',
            'secundaria_inscritos.inscPromedioBimestre5',
            'secundaria_inscritos.inscPromedioPorBimestre',
            'secundaria_inscritos.inscTrimestre1',
            'secundaria_inscritos.inscTrimestre2',
            'secundaria_inscritos.inscTrimestre3',
            'secundaria_inscritos.inscRecuperativoTrimestre1',
            'secundaria_inscritos.inscRecuperativoTrimestre2',
            'secundaria_inscritos.inscRecuperativoTrimestre3',
            'secundaria_inscritos.inscPromedioTrim',
            'secundaria_inscritos.inscCalificacionFinalModelo',
            'secundaria_inscritos.inscCalificacionFinalSEP',
            'secundaria_inscritos.inscFaltasInjSep',
            'secundaria_inscritos.inscFaltasInjOct',
            'secundaria_inscritos.inscFaltasInjNov',
            'secundaria_inscritos.inscFaltasInjDic',
            'secundaria_inscritos.inscFaltasInjEne',
            'secundaria_inscritos.inscFaltasInjFeb',
            'secundaria_inscritos.inscFaltasInjMar',
            'secundaria_inscritos.inscFaltasInjAbr',
            'secundaria_inscritos.inscFaltasInjMay',
            'secundaria_inscritos.inscFaltasInjJun',
            'secundaria_inscritos.inscFaltasJusSep',
            'secundaria_inscritos.inscFaltasJusOct',
            'secundaria_inscritos.inscFaltasJusNov',
            'secundaria_inscritos.inscFaltasJusDic',
            'secundaria_inscritos.inscFaltasJusEne',
            'secundaria_inscritos.inscFaltasJusFeb',
            'secundaria_inscritos.inscFaltasJusMar',
            'secundaria_inscritos.inscFaltasJusAbr',
            'secundaria_inscritos.inscFaltasJusMay',
            'secundaria_inscritos.inscFaltasJusJun',
            'secundaria_inscritos.inscConductaSep',
            'secundaria_inscritos.inscConductaOct',
            'secundaria_inscritos.inscConductaNov',
            'secundaria_inscritos.inscConductaDic',
            'secundaria_inscritos.inscConductaEne',
            'secundaria_inscritos.inscConductaFeb',
            'secundaria_inscritos.inscConductaMar',
            'secundaria_inscritos.inscConductaAbr',
            'secundaria_inscritos.inscConductaMay',
            'secundaria_inscritos.inscConductaJun',
            'secundaria_inscritos.inscParticipacionSep',
            'secundaria_inscritos.inscParticipacionOct',
            'secundaria_inscritos.inscParticipacionNov',
            'secundaria_inscritos.inscParticipacionDic',
            'secundaria_inscritos.inscParticipacionEne',
            'secundaria_inscritos.inscParticipacionFeb',
            'secundaria_inscritos.inscParticipacionMar',
            'secundaria_inscritos.inscParticipacionAbr',
            'secundaria_inscritos.inscParticipacionMay',
            'secundaria_inscritos.inscParticipacionJun',
            'secundaria_inscritos.inscConvivenciaSep',
            'secundaria_inscritos.inscConvivenciaOct',
            'secundaria_inscritos.inscConvivenciaNov',
            'secundaria_inscritos.inscConvivenciaDic',
            'secundaria_inscritos.inscConvivenciaEne',
            'secundaria_inscritos.inscConvivenciaFeb',
            'secundaria_inscritos.inscConvivenciaMar',
            'secundaria_inscritos.inscConvivenciaAbr',
            'secundaria_inscritos.inscConvivenciaMay',
            'secundaria_inscritos.inscConvivenciaJun',
            'alumnos.id as alumno_id',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'secundaria_grupos.id as secundaria_grupo_id',
            'secundaria_grupos.gpoGrado',
            'secundaria_grupos.gpoClave',
            'secundaria_grupos.gpoTurno',
            'secundaria_grupos.gpoMatComplementaria',
            'secundaria_materias.matClave',
            'secundaria_materias.matNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'planes.id as plan_id',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'secundaria_empleados.empApellido1',
            'secundaria_empleados.empApellido2',
            'secundaria_empleados.empNombre'
        )
            ->leftJoin('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
            ->leftJoin('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->leftJoin('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->leftJoin('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
            ->leftJoin('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->leftJoin('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
            ->leftJoin('planes', 'secundaria_grupos.plan_id', '=', 'planes.id')
            ->leftJoin('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->leftJoin('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->leftJoin('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
            ->where('secundaria_inscritos.grupo_id', '=', $id)
            ->whereNull('cursos.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->whereNull('secundaria_grupos.deleted_at')
            ->whereNull('secundaria_materias.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->whereNull('cgt.deleted_at')
            ->orderBy('cgt.cgtGrupo', 'ASC')
            ->orderBy('personas.perApellido1', 'ASC')
            ->orderBy('personas.perApellido2', 'ASC')
            ->orderBy('personas.perNombre', 'ASC')
            ->get();


        if ($secundaria_inscritos->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
            return back();
        }


        return view('secundaria.calificaciones.recuperativos', [
            "secundaria_inscritos" => $secundaria_inscritos
        ]);
    }

    // FUNCION PARA CALIFICAR RECUPERATIVOS
    public function guardarCalificacionRecuperativo(Request $request)
    {
        $secundaria_inscrito_id = $request->secundaria_inscrito_id;
        $inscRecuperativoTrimestre1 = $request->inscRecuperativoTrimestre1;
        $inscRecuperativoTrimestre2 = $request->inscRecuperativoTrimestre2;
        $inscRecuperativoTrimestre3 = $request->inscRecuperativoTrimestre3;


        for ($i=0; $i < count($secundaria_inscrito_id) ; $i++) {

            DB::table('secundaria_inscritos')
            ->where('id', $secundaria_inscrito_id[$i])
            ->update([

                'inscRecuperativoTrimestre1' => $inscRecuperativoTrimestre1[$i],
                'inscRecuperativoTrimestre2' => $inscRecuperativoTrimestre2[$i],
                'inscRecuperativoTrimestre3' => $inscRecuperativoTrimestre3[$i]

            ]);
        }

        alert('Escuela Modelo', 'Las calificaciones de recuperativo se actualizarón con éxito', 'success')->showConfirmButton()->autoClose(5000);;
        return back();
    }

    // FUNCION PARA CALIFICAR EXTRAORDINARIOS
    public function guardarCalificacionExtraordinario(Request $request)
    {
        return $secundaria_inscrito_id = $request->secundaria_inscrito_id;
        $inscRecuperativoTrimestre1 = $request->inscRecuperativoTrimestre1;
        $inscRecuperativoTrimestre2 = $request->inscRecuperativoTrimestre2;

        for ($i=0; $i < count($secundaria_inscrito_id) ; $i++) {

            DB::table('secundaria_inscritos')
            ->where('id', $secundaria_inscrito_id[$i])
            ->update([

                'inscRecuperativoTrimestre1' => $inscRecuperativoTrimestre1[$i],
                'inscRecuperativoTrimestre2' => $inscRecuperativoTrimestre2[$i]

            ]);
        }

        alert('Escuela Modelo', 'Las calificaciones de recuperativo se actualizarón con éxito', 'success')->showConfirmButton()->autoClose(5000);;
        return back();
    }

    public function getCalificacionesAlumnos(Request $request, $id, $grupoId)
    {
        if ($request->ajax()) {


            $calificaciones = Secundaria_calificaciones::select(
                'secundaria_calificaciones.id',
                'secundaria_calificaciones.secundaria_inscrito_id',
                'secundaria_calificaciones.secundaria_grupo_evidencia_id',
                'secundaria_calificaciones.numero_evaluacion',
                'secundaria_calificaciones.mes_evaluacion',
                'secundaria_calificaciones.calificacion_evidencia1',
                'secundaria_calificaciones.calificacion_evidencia2',
                'secundaria_calificaciones.calificacion_evidencia3',
                'secundaria_calificaciones.calificacion_evidencia4',
                'secundaria_calificaciones.calificacion_evidencia5',
                'secundaria_calificaciones.calificacion_evidencia6',
                'secundaria_calificaciones.calificacion_evidencia7',
                'secundaria_calificaciones.calificacion_evidencia8',
                'secundaria_calificaciones.calificacion_evidencia9',
                'secundaria_calificaciones.calificacion_evidencia10',
                'secundaria_calificaciones.promedio_mes',
                'secundaria_inscritos.grupo_id',
                'secundaria_grupos.gpoGrado',
                'secundaria_grupos.gpoClave',
                'secundaria_grupos.gpoACD',
                'secundaria_materias.id as id_materia',
                'secundaria_materias.matClave',
                'secundaria_materias.matNombre',
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
                'programas.progNombre',
                'secundaria_inscritos.inscFaltasInjSep',
                'secundaria_inscritos.inscFaltasInjOct',
                'secundaria_inscritos.inscFaltasInjNov',
                'secundaria_inscritos.inscFaltasInjDic',
                'secundaria_inscritos.inscFaltasInjEne',
                'secundaria_inscritos.inscFaltasInjFeb',
                'secundaria_inscritos.inscFaltasInjMar',
                'secundaria_inscritos.inscFaltasInjAbr',
                'secundaria_inscritos.inscFaltasInjMay',
                'secundaria_inscritos.inscFaltasInjJun',
                'secundaria_inscritos.inscConductaSep',
                'secundaria_inscritos.inscConductaOct',
                'secundaria_inscritos.inscConductaNov',
                'secundaria_inscritos.inscConductaDic',
                'secundaria_inscritos.inscConductaEne',
                'secundaria_inscritos.inscConductaFeb',
                'secundaria_inscritos.inscConductaMar',
                'secundaria_inscritos.inscConductaAbr',
                'secundaria_inscritos.inscConductaMay',
                'secundaria_inscritos.inscConductaJun',
                'alumnos.aluClave',
                'cgt.cgtGrupo'

            )
                ->join('secundaria_inscritos', 'secundaria_calificaciones.secundaria_inscrito_id', '=', 'secundaria_inscritos.id')
                ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
                ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                ->join('planes', 'secundaria_grupos.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->where('secundaria_calificaciones.secundaria_grupo_evidencia_id', '=', $id)
                ->where('secundaria_inscritos.grupo_id', '=', $grupoId)
                ->whereNull('secundaria_calificaciones.deleted_at')
                ->whereNull('secundaria_inscritos.deleted_at')
                ->whereNull('secundaria_grupos.deleted_at')
                ->whereNull('secundaria_materias.deleted_at')
                ->whereNull('planes.deleted_at')
                ->whereNull('programas.deleted_at')
                ->whereNull('periodos.deleted_at')
                ->whereNull('departamentos.deleted_at')
                ->whereNull('cursos.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->whereNull('cgt.deleted_at')
                ->orderBy('cgt.cgtGradoSemestre', 'ASC')
                ->orderBy('cgt.cgtGrupo', 'ASC')
                ->orderBy('personas.perApellido1', 'ASC')
                ->orderBy('personas.perApellido2', 'ASC')
                ->orderBy('personas.perNombre', 'ASC')
                ->get();

            return response()->json($calificaciones);
        }
    }

    // funcion para actualizar calificaciones del grupo seleccionado
    public function update_calificacion(Request $request)
    {

        $id = $request->id;
        $secundaria_inscrito_id = $request->secundaria_inscrito_id;
        $secundaria_grupo_evidencia_id = $request->secundaria_grupo_evidencia_id;
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

        $secundaria_grupos_evidencias = Secundaria_grupos_evidencias::select('secundaria_mes_evaluaciones.*')
        ->join('secundaria_mes_evaluaciones', 'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id', '=', 'secundaria_mes_evaluaciones.id')
        ->where('secundaria_grupos_evidencias.id',$secundaria_grupo_evidencia_id)
        ->first();
        $mes_evaluacion = $secundaria_grupos_evidencias->mes;
        $numero_evaluacion = $secundaria_grupos_evidencias->numero_evaluacion;


        $faltaSep = $request->faltaSep;
        $faltaOct = $request->faltaOct;
        $faltaNov = $request->faltaNov;
        $faltaDic = $request->faltaDic;
        $faltaEne = $request->faltaEne;
        $faltaFeb = $request->faltaFeb;
        $faltaMar = $request->faltaMar;
        $faltaAbr = $request->faltaAbr;
        $faltaMay = $request->faltaMay;
        $faltaJun = $request->faltaJun;

        // conducta
        $conductaSep = $request->conductaSep;
        $conductaOct = $request->conductaOct;
        $conductaNov = $request->conductaNov;
        $conductaDic = $request->conductaDic;
        $conductaEne = $request->conductaEne;
        $conductaFeb = $request->conductaFeb;
        $conductaMar = $request->conductaMar;
        $conductaAbr = $request->conductaAbr;
        $conductaMay = $request->conductaMay;
        $conductaJun = $request->conductaJun;


        $fechaActual = Carbon::now('America/Merida');

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');


        if (!empty($secundaria_inscrito_id)) {
            $contar = count($id);
            for (
                $i = 0;
                $i < $contar;
                $i++
            ) {

                DB::table('secundaria_calificaciones')
                    ->where('id', $id[$i])
                    ->update([
                        'numero_evaluacion' => $numero_evaluacion,
                        'mes_evaluacion' => $mes_evaluacion,
                        'calificacion_evidencia1' => (isset($evidencia1[$i])) ? $evidencia1[$i] : false,
                        'calificacion_evidencia2' => (isset($evidencia2[$i])) ? $evidencia2[$i] : false,
                        'calificacion_evidencia3' => (isset($evidencia3[$i])) ? $evidencia3[$i] : false,
                        'calificacion_evidencia4' => (isset($evidencia4[$i])) ? $evidencia4[$i] : false,
                        'calificacion_evidencia5' => (isset($evidencia5[$i])) ? $evidencia5[$i] : false,
                        'calificacion_evidencia6' => (isset($evidencia6[$i])) ? $evidencia6[$i] : false,
                        'calificacion_evidencia7' => (isset($evidencia7[$i])) ? $evidencia7[$i] : false,
                        'calificacion_evidencia8' => (isset($evidencia8[$i])) ? $evidencia8[$i] : false,
                        'calificacion_evidencia9' => (isset($evidencia9[$i])) ? $evidencia9[$i] : false,
                        'calificacion_evidencia10'=> (isset($evidencia10[$i])) ? $evidencia10[$i] : false,
                        'promedio_mes' => (isset($promedioTotal[$i])) ? $promedioTotal[$i]: false,
                        'usuario_at' => auth()->user()->id,
                        'updated_at' => $fechaActual->format('Y-m-d H:i:s')


                    ]);


                // SEPTIEMBRE
                if ($numero_evaluacion == "1") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionSep' => $evidencia1[$i],
                            'inscConductaSep' => $conductaSep[$i],
                            'inscFaltasInjSep' => $faltaSep[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //OCTUBRE
                if ($numero_evaluacion == "2") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionOct' => $evidencia1[$i],
                            'inscConductaOct' => $conductaOct[$i],
                            'inscFaltasInjOct' => $faltaOct[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //NOVIEMBRE
                if ($numero_evaluacion == "3") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionNov' => $evidencia1[$i],
                            'inscConductaNov' => $conductaNov[$i],
                            'inscFaltasInjNov' => $faltaNov[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //DICIEMBRE
                if ($numero_evaluacion == "4") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionDic' => $evidencia1[$i],
                            'inscConductaDic' => $conductaDic[$i],
                            'inscFaltasInjDic' => $faltaDic[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //ENERO
                if ($numero_evaluacion == "5") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionEne' => $evidencia1[$i],
                            'inscConductaEne' => $conductaEne[$i],
                            'inscFaltasInjEne' => $faltaEne[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //FEBRERO
                if ($numero_evaluacion == "6") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionFeb' => $evidencia1[$i],
                            'inscConductaFeb' => $conductaFeb[$i],
                            'inscFaltasInjFeb' => $faltaFeb[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //MARZO
                if ($numero_evaluacion == "7") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionMar' => $evidencia1[$i],
                            'inscConductaMar' => $conductaMar[$i],
                            'inscFaltasInjMar' => $faltaMar[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //ABRIL
                if ($numero_evaluacion == "8") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionAbr' => $evidencia1[$i],
                            'inscConductaAbr' => $conductaAbr[$i],
                            'inscFaltasInjAbr' => $faltaAbr[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //MAYO
                if ($numero_evaluacion == "9") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionMay' => $evidencia1[$i],
                            'inscConductaMay' => $conductaMay[$i],
                            'inscFaltasInjMay' => $faltaMay[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }

                //JUNIO
                if ($numero_evaluacion == "10") {
                    DB::table('secundaria_inscritos')
                        ->where('id', $secundaria_inscrito_id[$i])
                        ->update([
                            'inscCalificacionJun' => $evidencia1[$i],
                            'inscConductaJun' => $conductaJun[$i],
                            'inscFaltasInjJun' => $faltaJun[$i],
                            'usuario_at' => auth()->user()->id,
                            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
                        ]);
                }
            }

            alert('Escuela Modelo', 'Las calificaciones se actualizarón con éxito', 'success')->showConfirmButton()->autoClose(5000);;
            return back();
        } else {
            alert('Escuela Modelo', 'El mes seleccionado no cuenta con calificaciones registradas', 'info')->showConfirmButton()->autoClose(5000);;
            return back();
        }
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

            $rubricas = DB::table('secundaria_calificaciones')
                ->where('secundaria_calificaciones.secundaria_inscrito_id', $inscrito_id)
                ->where('secundaria_calificaciones.trimestre1', $trimestre_a_evaluar)
                ->where('secundaria_calificaciones.aplica', 'SI')
                ->get();

            $calificaciones = $request->calificaciones;


            if ($trimestre_a_evaluar == 1) {
                $trimestre1Col  = $request->has("calificaciones.trimestre1")  ? collect($calificaciones["trimestre1"])  : collect();
                $trimestre1_faltas = $request->trimestreFaltas;
                $trimestre1_observaciones = $request->trimestreObservaciones;
            }



            // dd($inscritos->map(function ($item, $key) {
            //     return $item->id;
            // })->all());

            foreach ($rubricas as $rubrica) {
                $calificacion = Secundaria_calificaciones::where('id', $rubrica->id)->first();

                if ($trimestre_a_evaluar == 1) {
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

            $inscritofaltas = Secundaria_inscritos::where('id', $inscrito_id)->first();
            if ($inscritofaltas) {
                if ($trimestre_a_evaluar == 1) {
                    $inscritofaltas->trimestre1_faltas = $trimestre1_faltas != null ? $trimestre1_faltas : $inscritofaltas->trimestre1_faltas;
                    $inscritofaltas->trimestre1_observaciones = $trimestre1_observaciones != null ? $trimestre1_observaciones : $inscritofaltas->trimestre1_observaciones;
                }

                $inscritofaltas->save();
            }


            alert('Escuela Modelo', 'Se registraron las calificaciones con éxito', 'success')->showConfirmButton()->autoClose(3000);
            return redirect('secundaria_inscritos/' . $grupo_id);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('secundaria_inscritos/' . $grupo_id)->withInput();
        }
    }

    public function boletadesdecurso($curso_id)
    {

        $cursos = Curso::select('cursos.id', 'periodos.id as periodo_id', 'periodos.departamento_id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->where('cursos.id', '=', $curso_id)
            ->first();

        $periodoEscolar = Periodo::where('id', $cursos->periodo_id)->first();

        if ($periodoEscolar->perAnioPago >= 2021) {

            $parametro_NombreArchivo = 'pdf_secundaria_boleta_calificaciones_2021';
            $parametro_Titulo = "BOLETA DE CALIFICACIONES DEL ALUMNO(A)";
            $resultado_array =  DB::select("call procSecundariaCalificacionesCurso("
                . $curso_id
                . ")");
            $resultado_collection = collect($resultado_array);

            if ($resultado_collection->isEmpty()) {
                alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno(a). Favor de verificar.')->showConfirmButton();
                return back()->withInput();
            }
            $resultado_registro = $resultado_array[0];



            // obtener los porcentajes
            $secundaria_porcentajes = Secundaria_porcentajes::where('departamento_id', '=', $cursos->departamento_id)
                ->where('periodo_id', '=', $cursos->periodo_id)
                ->whereNull('deleted_at')
                ->first();


            $alumnoAgrupado = $resultado_collection->groupBy('clave_pago');


            //dd($pagos_deudores_collection);
            $parametro_Alumno = $resultado_registro->nombres . " " . $resultado_registro->ape_paterno .
                " " . $resultado_registro->ape_materno;
            $parametro_Clave = $resultado_registro->clave_pago;
            $parametro_Grupo = $resultado_registro->gpoGrado . "" . $resultado_registro->gpoClave;
            $parametro_Curp = $resultado_registro->curp;
            $parametro_Ciclo = $resultado_registro->ciclo_escolar;
            $ubicacion =  $resultado_registro->ubicacion;
            if($ubicacion == "CME"){
                $campus = "CampusCME";
            }else{
                $campus = "CampusCVA";
            }
            //$fechaActual = Carbon::now();
            $fechaActual = Carbon::now('America/Merida');

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');


            $pdf = PDF::loadView('reportes.pdf.secundaria.boleta_de_calificaciones.' . $parametro_NombreArchivo, [
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
                "secundaria_porcentajes" => $secundaria_porcentajes,
                "campus" => $campus
            ]);


            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        } else {
            $parametro_NombreArchivo = 'pdf_secundaria_boleta_calificaciones2';
            $parametro_Titulo = "BOLETA DE CALIFICACIONES DEL ALUMNO(A)";
            $resultado_array =  DB::select("call procSecundariaCalificacionesCurso("
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

            //$fechaActual = Carbon::now();
            $fechaActual = Carbon::now('America/Merida');

            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');


            $pdf = PDF::loadView('reportes.pdf.secundaria.boleta_de_calificaciones.' . $parametro_NombreArchivo, [
                "calificaciones" => $resultado_collection,
                "fechaActual" => $fechaActual->format('d/m/Y'),
                "horaActual" => $fechaActual->format('H:i:s'),
                "cicloEscolar" => $parametro_Ciclo,
                "curp" => $parametro_Curp,
                "nombreAlumno" => $parametro_Alumno,
                "clavepago" => $parametro_Clave,
                "gradogrupo" => $parametro_Grupo,
                "titulo" => $parametro_Titulo,
                "alumnoAgrupado" => $alumnoAgrupado
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
            'secundaria_grupos.gpoGrado',
            'secundaria_inscritos.id as inscrito_id',
            'secundaria_inscritos.grupo_id',
            'secundaria_grupos.gpoClave',
            'secundaria_inscritos.trimestre1_faltas',
            'secundaria_inscritos.trimestre1_observaciones'
        )
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('secundaria_inscritos', 'cursos.id', '=', 'secundaria_inscritos.curso_id')
            ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('secundaria_inscritos.grupo_id', $grupo_id)
            ->whereIn('depClave', ['SEC'])
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

        if ($grupos_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
            return back();
        }


        $persona = Persona::findOrFail($cursos_grupo[0]->personas_id);
        //$inscritos = Preescolar_inscrito::findOrFail($cursos_grupo->inscrito_id);
        $grupos = Secundaria_grupos::findOrFail($cursos_grupo[0]->grupo_id);
        $empleado = Secundaria_empleados::findOrFail($grupos->empleado_id_docente);
        $personaDocente = Persona::findOrFail($empleado->persona_id);
        //$trimestre_faltas = $inscritos->trimestre1_faltas;
        // $trimestre_observaciones = $inscritos->trimestre1_observaciones;

        $fechaActual = Carbon::now();

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $cicloEscolar = "CICLO 2020 – 2021";

        // valida que trimestre es para asginar un nombre de reporte
        if ($trimestre_a_evaluar == 1) {
            $numeroReporte = "Primer Reporte";
        } elseif ($trimestre_a_evaluar == 2) {
            $numeroReporte = "Segundo Reporte";
        } elseif ($trimestre_a_evaluar == 3) {
            $numeroReporte = "Tercer Reporte";
        } else {
            $numeroReporte = "";
        }

        $kinderGradoTrimestre = "KINDER " . $cursos_grupo[0]->gpoGrado . $cursos_grupo[0]->gpoClave . " - " . $numeroReporte;
        $nombreAlumno = $persona->perNombre . " " . $persona->perApellido1 . " " . $persona->perApellido2;
        $nombreDocente = $personaDocente->perNombre . " " . $personaDocente->perApellido1 . " " . $personaDocente->perApellido2;

        $nombreArchivo = 'pdf_secundaria_reporte_general_aprovechamiento';


        $pdf = PDF::loadView('reportes.pdf.secundaria.' . $nombreArchivo, [
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
            'secundaria_grupos.gpoGrado',
            'secundaria_inscritos.id as inscrito_id',
            'secundaria_inscritos.grupo_id',
            'secundaria_grupos.gpoClave',
            'secundaria_inscritos.trimestre1_faltas',
            'secundaria_inscritos.trimestre2_faltas',
            'secundaria_inscritos.trimestre3_faltas',
            'secundaria_inscritos.trimestre1_observaciones',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'secundaria_materias.matNombre'
        )
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('secundaria_inscritos', 'cursos.id', '=', 'secundaria_inscritos.curso_id')
            ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->where('secundaria_inscritos.grupo_id', $grupo_id)
            ->whereNull('alumnos.deleted_at', 'ASC')
            ->whereNull('personas.deleted_at', 'ASC')
            ->whereNull('secundaria_inscritos.deleted_at', 'ASC')
            ->whereNull('secundaria_grupos.deleted_at', 'ASC')
            ->whereIn('depClave', ['SEC'])
            ->orderBy("personas.perApellido1", "ASC")
            ->orderBy("personas.perApellido2", "ASC")
            ->orderBy("personas.perNombre", "ASC")
            ->get();
        $fechaActual = Carbon::now('CDT');


        foreach ($cursos_grupo as $item) {
            $persona = Persona::findOrFail($item->personas_id);
            $inscritos = Secundaria_inscritos::findOrFail($item->inscrito_id);
            $grupos = Secundaria_grupos::findOrFail($inscritos->grupo_id);
            $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
            $personaDocente = Persona::findOrFail($empleado->persona_id);
            $periodo = Periodo::findOrFail($item->periodo_id);
            $programa = Programa::findOrFail($item->programa_id);
            $plan = Plan::findOrFail($item->plan_id);

            // ubicacion
            $ubiClave = $item->ubiClave;
            $ubiNombre = $item->ubiNombre;
            $secundaria_materia = $item->matNombre;
        }



        $info = collect([
            'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
            'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
            'ubicacion' => $ubiClave . ' ' . $ubiNombre,

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
            'secundaria_materia' => $secundaria_materia

        ]);




        // echo '<br>';
        // echo 'plan id ' . $grupos->plan_id;
        // echo '<br>';
        // echo 'turno ' .$grupos->gpoTurno;

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $nombreArchivo = 'Lista secundaria';
        $pdf = PDF::loadView('reportes.pdf.secundaria.pdf_secundaria_lista_asistencia', [
            "info" => $info,
            "cursos_grupo" => $cursos_grupo,
            "nombreArchivo" => $nombreArchivo,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
        ]);

        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($info['gradoAlumno'] . $info['grupoAlumno'] . "_" . $nombreArchivo);
        return $pdf->download($info['gradoAlumno'] . $info['grupoAlumno'] . "_" . $nombreArchivo);
    }

    public function destroy($id)
    {
    }
}
