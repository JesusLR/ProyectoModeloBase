<?php

namespace App\Http\Controllers\Bachiller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Bachiller\Bachiller_paquetes;
use App\Models\Bachiller\Bachiller_paquete_detalle;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_materias;
use App\Models\Bachiller\Bachiller_materias_acd;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Ubicacion;
use App\Models\Alumno;
use PHPMailer\PHPMailer\PHPMailer;

class BachillerPaquetesInscritosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.paquete_inscrito.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function obtenerListaAlumnosCurso(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::findOrFail($cgt_id);

            /*
            $gruposClave = Curso::select(
                'cursos.id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'periodos.id as periodo_id',
                'planes.id as plan_id',
                'programas.id as programa_id',
                'alumnos.id as alumno_id',
                'alumnos.aluClave',
                'personas.id as persona_id',
                'personas.perApellido1 as apellido_paterno',
                'personas.perApellido2 as apellido_materno',
                'personas.perNombre as nombres')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->where('departamentos.depClave', 'BAC')
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.id', $cgt->id)
            ->whereIn('cursos.curEstado', ['R', 'A', 'C', 'P'])
            ->orderBy('personas.perApellido1', 'asc')
            ->orderBy('personas.perApellido2', 'asc')
            ->get();


            return response()->json($gruposClave);*/

            $resultado_array =  DB::select("call procBachillerAlumnosNoInscritos(".
                $periodo_id.", ".
                $programa_id.", ".
                $plan_id.", ".
                $cgt->id.")");
            $resultado_collection = collect($resultado_array);

            return response()->json($resultado_collection);
        }
    }

    public static function FunctionName($curso_id)
    {
        return Bachiller_inscritos::where('curso_id', '=', $curso_id)->get();
    }
    public function validarSiExisteInscrito(Request $request, $curso_id)
    {
        if($request->ajax()){

            $existeInscrito = DB::select("SELECT DISTINCT curso_id FROM bachiller_inscritos WHERE curso_id=$curso_id");


            return response()->json($existeInscrito);
        }
    }

    public function obtenerPaquetes(Request $request, $periodo_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::findOrFail($cgt_id);

            $paquetes = Bachiller_paquetes::where('periodo_id', $periodo_id)
            ->where('plan_id', $plan_id)
            ->where('semestre', $cgt->cgtGradoSemestre)
            ->orderBy('consecutivo', 'ASC')
            ->get();


            return response()->json($paquetes);
        }
    }


    public function store(Request $request)
    {
        // dd($request->periodo_id, $request->programa_id, $request->plan_id, $request->cgt_id);

        //Aqui viene los parametros de curso_id y paquete_id que fueron checkiados
        $collectionPaquete = collect($request->paquete_id);

        //Parametros
        $periodo_id = $request->periodo_id;
        $cgt_id = $request->cgt_id;
        $plan_id = $request->plan_id;
        $bachiller_paquete_id = $collectionPaquete->values();
        //$curso_id = $collectionPaquete->keys();
        $clave_alumno = $collectionPaquete->keys();


        // solo entra se si checkeo alguno
        if(count($clave_alumno) > 0){
            for ($i=0; $i < count($clave_alumno); $i++) {

                $alumno = Alumno::with('persona')
                    ->where('aluClave', $clave_alumno[$i])->first();
                $alumno_id = $alumno->id;
                $curso = Curso::with(['cgt.plan.programa.escuela.departamento.ubicacion', 'periodo'])
                    ->where('alumno_id', $alumno_id)
                    ->where('periodo_id', $periodo_id)
                    ->where('cgt_id', $cgt_id)
                    ->whereNull('deleted_at')
                    ->first();
                $curso_id = $curso->id;
                /*
                dd(
                    //$clave_alumno,
                    $curso_id,
                    $clave_alumno[$i],
                    //$bachiller_paquete_id,
                    $bachiller_paquete_id[$i],
                    $cgt_id,
                    $periodo_id,
                    $plan_id,
                    $alumno_id);


                                inscribeEnPaquete(
                    $curso_id,
                    $bachiller_paquete_id[$i],
                    $cgt_id,
                    $periodo_id,
                    $plan_id
                );
                */

                # aqui llamas al SP...
                /*
                 */
                $resultado =  DB::select("call procBachillerInscribePorPaquetes(".
                    $curso_id.", ".
                    $bachiller_paquete_id[$i].", ".
                    $cgt_id.", ".
                    $periodo_id.", ".
                    $plan_id.", ".
                    $alumno_id.", ".
                    $clave_alumno[$i].")");


            }

            alert('Escuela Modelo', 'Se asignó el paquete con éxito', 'success')->showConfirmButton();
            return back();
        }else{
            alert('Escuela Modelo', 'No se selecciono ningún paquete', 'info')->showConfirmButton();
            return back()->withInput();
        }




    }



    public function inscribeEnPaquete($cursoid,
                                      $bachiller_paquete_id,
                                      $cgt_id,
                                      $periodo_id,
                                      $plan_id)
    {
        try {

            $paquete_id = $bachiller_paquete_id;
            $curso_id = $cursoid;

            //$curso = Curso::with('alumno.persona')
            $curso = Curso::with('alumno.persona', 'periodo',
                'cgt.plan.programa.escuela.departamento.ubicacion.municipio.estado')
                ->where("id", "=", $curso_id)
                ->whereNotIn("curEstado", ["B"])->first();

            if ($curso) {
                //FILTRO TIENE DERECHO A INSCRIBIRSE A GRUPOS
                $ubicacion = Ubicacion::where("id", "=", $curso->cgt->plan->programa->escuela->departamento->ubicacion->id)->first();
                $departamento = Departamento::where("id", "=", $curso->cgt->plan->programa->escuela->departamento->id)->first();
                $programa = Programa::where("id", "=", $curso->cgt->plan->programa->id)->first();
                //$cgt_id = $curso->cgt->id;

                //HISTORICO DE ALUMNOS REPROBADOS
                $historicoList = self::buscarHistoricos($curso_id, $cgt_id);


                //INSCRIBE AL ALUMNO POR PAQUETE
                $paquetes = Bachiller_paquete_detalle::with("bachiller_grupos")
                    ->where('bachiller_paquete_id', $paquete_id)->get();

                $alumnosSinDerechos = collect();

                foreach ($paquetes as $paq) {
                    $existeInscritoEnCurso = Bachiller_inscritos::with("bachiller_grupos")
                        ->where("curso_id", "=", $curso_id)
                        ->whereHas('bachiller_grupos', function($query) use ($paq) {
                            $query->where('bachiller_materia_id', $paq->bachiller_grupos->bachiller_materia_id);
                            $query->where('periodo_id', $paq->bachiller_grupos->periodo_id);
                        })
                        ->first();


                    // $cursos = [$curso->id];

                    $alumnosSinDerecho = $this->postDesinscribirReprobados($curso->id, $historicoList, $paq->grupo_id);
                    $alumnosSinDerecho = $alumnosSinDerecho->unique();
                    $alumnosSinDerechos->push($alumnosSinDerecho);


                    $cursoSinDerecho = $alumnosSinDerecho->filter(function ($value, $key) use ($curso_id) {
                        return $value->curso->id ==  $curso_id;
                    });
                    //FIN FILTRO TIENE DERECHO A INSCRIBIRSE A CURSOS


                    if (!$existeInscritoEnCurso && $cursoSinDerecho->count() == 0) {
                        $this->inscribirBachillerAlumno($curso_id, $paq->grupo_id);
                    }
                }

                $this->correoNoPermitidos($alumnosSinDerechos->flatten());


                // return view("inscrito.inscritosSinDerecho", $cursoSinDerecho);
            }

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
            return redirect('create/paquete')->withInput();
        }

        alert('Escuela Modelo', 'Se ha inscrito con éxito','success')->showConfirmButton();
        return back()->with(compact('cursoSinDerecho'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }


    private static function buscarHistoricos($curso_id, $cgt_id) {
        $bachillerinscritos = Bachiller_inscritos::with('curso')
            ->where(static function($query) use ($curso_id) {
                if($curso_id)
                    $query->where('curso_id', $curso_id);
            })
            ->whereHas('curso.cgt', static function($query) use ($cgt_id) {
                if($cgt_id)
                    $query->where('cgt_id', $cgt_id);
            })->get();

        return Bachiller_historico::with(['alumno', 'materia', 'plan'])
            ->whereIn('alumno_id', $bachillerinscritos->pluck('curso.alumno_id'))
            ->get();
    }

    public function postDesinscribirReprobados($curso_id, $historicoList, $grupoId)
    {
        $cursos = Curso::with('cgt.plan.programa.escuela.departamento.ubicacion', 'periodo', 'alumno.persona')
            ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion',function($query) {

                $query->where('cgtGradoSemestre', ">=", 4);
            })
            // EXCLUYE ALUMNOS DADOS DE BAJA
            ->where('curEstado', '<>', "B")
            ->where('id', $curso_id)
            ->get();
        // dd($cursos, $curso_id);
        $planIds = $historicoList->pluck('plan_id')->unique();
        $listMaterias = Materia::whereIn("plan_id", $planIds)->get();


        $alumnosSinDerecho = collect();

        foreach ($cursos as $key => $curso) {
            $departamento = $curso->cgt->plan->programa->escuela->departamento;
            $planID = $curso->cgt->plan->id;

            //Obtener el primer curTipoIngreso del alumno.
            $resumenAcademicoAlumno = DB::table('resumenacademico')
                ->where('alumno_id', $curso->alumno->id)->where('plan_id', $planID)
                ->first();



            if ($resumenAcademicoAlumno) {


                //SI ES CURSO REVALIDADOR, BUSCAR SU SEMESTRE DE INGRESO Y ACEPTAR MATERIAS DE DOS AÑOS ANTES

                $esCursoEsRevalidador = Curso::where("alumno_id", "=", $curso->alumno_id)
                    // ->where("periodo_id", "=", $curso->periodo_id)
                    ->whereHas('cgt.plan', function($query) use ($curso) {
                        $query->where('id', $curso->cgt->plan_id);
                    })
                    ->where("curTipoIngreso", "=", "EQ")
                    ->first();


                $materiasPermitidas = collect();

                if ($esCursoEsRevalidador) {
                    $planID = $curso->cgt->plan->id;


                    $resumenAcademicoAlumno = DB::table('resumenacademico')
                        ->where('alumno_id', $curso->alumno->id)->where('plan_id', $planID)
                        ->first();


                    $cursoDeIngreso = Curso::with("cgt")
                        ->where("alumno_id", "=", $resumenAcademicoAlumno->alumno_id)
                        ->where("periodo_id", "=", $resumenAcademicoAlumno->resPeriodoIngreso)
                        ->first();


                    $materiasPermitidas = Materia::where("plan_id", "=", $planID)
                        ->where("matSemestre", "<", $cursoDeIngreso->cgt->cgtGradoSemestre)
                        ->where("matSemestre", ">=", $cursoDeIngreso->cgt->cgtGradoSemestre - 4)
                        ->get();


                    $materiasPermitidas = $materiasPermitidas->map(function($item, $key) {
                        return $item->id;
                    });
                }










                //BUSCAR SI EL ALUMNO DEBE MATERIAS DE 3 SEMESTRES ANTERIORES
                $existeMateriasReprobadas = $historicoList
                    ->where("materia.matSemestre", "=", $curso->cgt->cgtGradoSemestre - 3)
                    ->where("alumno_id", "=", $curso->alumno_id)
                    ->sortByDesc('histFechaExamen')
                    ->unique('materia_id')
                    ->filter(static function($historico) use ($departamento) {
                        $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $historico->materia);
                        return MetodosHistoricos::es_reprobada($calificacion, $departamento->depCalMinAprob);
                    });


                if ($existeMateriasReprobadas->isNotEmpty()) {
                    //ALUMNO SIN DERECHO A INSCRIPCION

                    //si es curso revalidador excluir materias
                    if ($esCursoEsRevalidador) {
                        $existeMateriasReprobadas = $existeMateriasReprobadas->whereNotIn("materia_id", $materiasPermitidas);
                    }

                    if ($existeMateriasReprobadas->count() > 0) {

                        $curso->razon = "ALUMNO DEBE MATERIAS DE MAS DE UN AÑO";
                        $alumnosSinDerecho->push((Object) [
                            "curso" => $curso
                        ]);
                    }
                }



                //BUSCAR SI EL ALUMNO NO CURSÓ MATERIAS DE 3 SEMESTRES ANTERIORES
                $listMateriaAlumno = $historicoList
                    ->where("materia.matSemestre", "=", $curso->cgt->cgtGradoSemestre - 3)
                    ->where("alumno_id", $curso->alumno->id)
                    ->where("plan_id", $planID);

                $materiasNoCursadas = $listMaterias->filter(function ($item, $key) use ($curso, $listMateriaAlumno, $planID) {
                    return $item->matSemestre == $curso->cgt->cgtGradoSemestre - 3
                        && !in_array($item->id, $listMateriaAlumno->pluck('materia_id')->toArray())
                        && $item->plan_id == $planID;
                });


                //si es curso revalidador excluir materias
                if ($materiasNoCursadas->isNotEmpty()) {
                    $materiasNoCursadas = $materiasNoCursadas->whereNotIn("id", $materiasPermitidas);
                }


                if ($materiasNoCursadas->count() > 0) {

                    $curso->razon = "ALUMNO NO CURSÓ MATERIAS DE MAS DE UN AÑO";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);

                }
                // FIN ----------------------------------------------------------------------------------




                //BUSCAR SI EL ALUMNO DEBE/NO HA CURSADO MAS DE 3 MATERIAS EN LO QUE LLEVA DEL PLAN

                //materias reprobadas en lo que va del plan
                $materiasReprobadasPlan = $historicoList
                    ->where("alumno_id", "=", $curso->alumno_id)
                    ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                    ->sortByDesc("histFechaExamen")
                    ->unique("materia_id")
                    // ->where("aprobado", ["R", "A"]) #esto está basado en la vista SQL 'vwhistoricoaprobados'
                    ->where("plan_id", "=", $curso->cgt->plan->id)
                    ->filter(static function($historico) use ($departamento) {
                        $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $historico->materia);
                        return MetodosHistoricos::es_reprobada($calificacion, $departamento->depCalMinAprob);
                    });


                //si es curso revalidador excluir materias
                if ($materiasNoCursadas->isNotEmpty()) {
                    $materiasReprobadasPlan = $materiasReprobadasPlan->whereNotIn("materia_id", $materiasPermitidas);
                }
                if ($materiasReprobadasPlan->count() > 0) {

                    $curso->razon = "ALUMNO REPROBO MATERIAS EN LO QUE VA DEL PLAN";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);

                }



                //materias no cursadas en lo que va del plan
                $listMateriaAlumnoPlan = $historicoList
                    ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                    ->where("alumno_id", $curso->alumno->id)
                    ->where("plan_id", $planID);

                $materiasNoCursadasPlan = $listMaterias->filter(function ($item, $key) use ($curso, $listMateriaAlumnoPlan, $planID) {
                    return $item->matSemestre < $curso->cgt->cgtGradoSemestre
                        // return $item->matSemestre == $curso->cgt->cgtGradoSemestre
                        && !in_array($item->id, $listMateriaAlumnoPlan->pluck('materia_id')->toArray())
                        && $item->plan_id == $planID;
                });


                //si es curso revalidador excluir materias
                if ($materiasNoCursadas->isNotEmpty()) {
                    $materiasNoCursadasPlan = $materiasNoCursadasPlan->whereNotIn("id", $materiasPermitidas);
                }


                if ($materiasNoCursadasPlan->count() > 0) {

                    $curso->razon = "ALUMNO NO CURSÓ MATERIAS EN LO QUE VA DEL PLAN";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);
                }

                $cantMateriasReprobadasPlan = $materiasReprobadasPlan->count();
                $cantMateriasNoCursadasPlan = $materiasNoCursadasPlan->count();
                $totalMateriasDeuda = $cantMateriasReprobadasPlan + $cantMateriasNoCursadasPlan;

                if ($totalMateriasDeuda > 3) {

                    $curso->razon = "TOTAL DEBE / NO CURSÓ MATERIAS EN LO QUE VA DEL PLAN";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);

                }
                // FIN ----------------------------------------------------------------------------------






                //falta filtro con grupo->materia_id





                $grupo = Grupo::where("id", "=", $grupoId)->first();

                //BUSCAR MATERIAS CON PREREQUISITOS REPROBADOS/NO CURSADOS
                $materiasPlanSemestre = $listMaterias
                    ->where("plan_id", "=", $planID)
                    ->where("matSemestre", "=", $curso->cgt->cgtGradoSemestre)
                    ->where("matPrerequisitos", "=", "1")
                    ->where("id", "=", $grupo->materia->id);

                $materiasPlanSemestreIds = $materiasPlanSemestre->map(function ($item, $key) {
                    return $item->id;
                })->all();





                $materiasPrerequisito = Prerequisito::whereIn("materia_id", $materiasPlanSemestreIds)->get();


                if ($materiasPrerequisito->count() > 0) {
                    foreach ($materiasPrerequisito as $key => $value) {

                        //materias reprobadas en lo que va del plan
                        $materiasReprobadasPrereq = $historicoList
                            ->where("alumno_id", "=", $curso->alumno_id)
                            ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                            ->sortByDesc("histFechaExamen")
                            ->where("materia_id", "=", $value->materia_prerequisito_id)
                            ->unique("materia_id")
                            // ->where("aprobado", "=", "R"); # Esto se basa en la vista SQL 'vwhistoricoaprobados'
                            ->filter(static function($historico) use ($departamento) {
                                $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $historico->materia);
                                return MetodosHistoricos::es_reprobada($calificacion, $departamento->depCalMinAprob);
                            });

                        if ($materiasReprobadasPrereq->count() > 0) {

                            $curso->razon = "PREREQUISITO REPROBADO";
                            $alumnosSinDerecho->push((Object) [
                                "curso" => $curso
                            ]);
                            //el prerequisito de la materia esta reprobada -> desinscribir de la materia
                        }



                        //materias no cursadas en lo que va del plan
                        $listMateriaAlumnoPrereq = $historicoList
                            ->where("alumno_id", $curso->alumno->id)
                            ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                            ->where("plan_id", $planID)
                            ->where("materia_id", "=", $value->materia_prerequisito_id);

                        if ($listMateriaAlumnoPrereq->count() == 0) {
                            //el prerequisito de la materia esta no cursada -> desinscribir de la materia

                            $curso->razon = "PREREQUISITO NO CURSADO";
                            $alumnosSinDerecho->push((Object) [
                                "curso" => $curso
                            ]);
                        }
                        // FIN ----------------------------------------------------------------------------------
                    }
                }



                //SI LA MATERIA ESTA APROBADA, NO INSCRIBIR
                $listMateriasAprobadas = $historicoList
                    // ->where("matSemestre", "=", $curso->cgt->cgtGradoSemestre)
                    ->where("materia.matSemestre", "<", $curso->cgt->cgtGradoSemestre)
                    ->where("alumno_id", $curso->alumno->id)
                    ->where("plan_id", $planID)
                    ->sortByDesc("histFechaExamen")
                    ->unique("materia_id")
                    // ->where("aprobado", "=", "A") # Esto se basa en la vista SQL 'vwhistoricoaprobados'
                    ->filter(static function($historico) use ($departamento) {
                        $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $historico->materia);
                        return MetodosHistoricos::es_aprobada($calificacion, $departamento->depCalMinAprob);
                    })
                    ->where("materia_id", "=", $grupo->materia->id);


                if ($listMateriasAprobadas->count() > 0) {

                    $curso->razon = "MATERIA APROBADA";
                    $alumnosSinDerecho->push((Object) [
                        "curso" => $curso
                    ]);
                }


            }
        }



        if ($alumnosSinDerecho->count() > 0) {

            $grupoAInscribir = Grupo::with("materia.plan")->where("id", "=", $grupoId)->first();
            // dd($grupoAInscribir);
            $alumnosSinDerecho = $alumnosSinDerecho->map(function ($item, $key) use ($grupoId, $grupoAInscribir) {

                ($item->grupoId = $grupoId);

                $item->grupoId = $grupoId;
                $item->grupoAInscribir = $grupoAInscribir;
                $item->alumnoCursoGrupo = $item->curso->alumno->id
                    . "-" . $item->curso->id
                    . "-" . $grupoId;
                return $item;
            })->unique("alumnoCursoGrupo");


            foreach ($alumnosSinDerecho as $alumno) {
                if (!InscritosRechazados::where("alumno_id", "=", $alumno->curso->alumno->id)
                    ->where("curso_id", "=", $alumno->curso->id)
                    ->where("grupo_id", "=", $grupoId)
                    ->exists()) {

                    // dd($alumno->curso->periodo_id);

                    InscritosRechazados::create([
                        'alumno_id' => $alumno->curso->alumno->id,
                        'aluClave' => $alumno->curso->alumno->aluClave,
                        'perNombre' => $alumno->curso->alumno->persona->perNombre,
                        'perApellido1' => $alumno->curso->alumno->persona->perApellido1,
                        'perApellido2' => $alumno->curso->alumno->persona->perApellido2,
                        'curso_id' => $alumno->curso->id,
                        'ubicacion_id' => $alumno->curso->cgt->plan->programa->escuela->departamento->ubicacion->id,
                        'ubiClave' =>  $alumno->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave,
                        'ubiNombre' => $alumno->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre,
                        'departamento_id' => $alumno->curso->cgt->plan->programa->escuela->departamento->id,
                        'depNivel' => $alumno->curso->cgt->plan->programa->escuela->departamento->depNivel,
                        'depClave' => $alumno->curso->cgt->plan->programa->escuela->departamento->depClave,
                        'depNombre' => $alumno->curso->cgt->plan->programa->escuela->departamento->depNombre,
                        'escuela_id' => $alumno->curso->cgt->plan->programa->escuela->id,
                        'escNombre' => $alumno->curso->cgt->plan->programa->escuela->escNombre,
                        'programa_id' => $alumno->curso->cgt->plan->programa->id,
                        'progNombre' => $alumno->curso->cgt->plan->programa->progNombre,
                        'periodo_id' => $alumno->curso->periodo_id,
                        'perNumero' => $alumno->curso->periodo->perNumero,
                        'perAnio' => $alumno->curso->periodo->perAnio,
                        'cgt_id' => $alumno->curso->cgt->id,
                        'grupo_id' => $grupoId,
                        'materia_id' => $grupoAInscribir->materia->id,
                        'matClave' => $grupoAInscribir->materia->matClave,
                        'matNombre' => $grupoAInscribir->materia->matNombreOficial,
                        'plan_id' => $grupoAInscribir->materia->plan->id,
                        'planClave' => $grupoAInscribir->materia->plan->planClave,
                        'gpoSemestre' => $grupoAInscribir->gpoSemestre,
                        'gpoClave' => $grupoAInscribir->gpoClave,
                        'gpoTurno' => $grupoAInscribir->gpoTurno,
                        'rechazadoInscrito' => "NO"
                    ]);
                }
            }
        }

        // dd($alumnosSinDerecho);




        return $alumnosSinDerecho;
    }

    public function correoNoPermitidos($alumnosSinDerecho)
    {

        if ($alumnosSinDerecho->count() > 0) {

            //envio de correo
            $to_name = Auth::user()->empleado->persona->perNombre
                . " " . Auth::user()->empleado->persona->perApellido1
                . " ". Auth::user()->empleado->persona->perApellido2;

            // dd(Auth::user()->empleado->persona->id);
            $mailSeguimiento = DB::table("empleadosseguimiento")
                ->where("persona_id", "=",  Auth::user()->empleado->persona->id)
                ->first();


            if ($mailSeguimiento) {
                $to_email = $mailSeguimiento->empCorreo1;
            } else {
                $to_email = 'aosorio@modelo.edu.mx';
            }



            $mail = new PHPMailer(true);
            // Server settings
            $mail->CharSet = "UTF-8";
            $mail->Encoding = 'base64';

            $mail->SMTPDebug = 0; //3;                         // Enable verbose debug output
            $mail->isSMTP();                              // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com'; //'mail.unimodelo.com';           // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                       // Enable SMTP authentication
            $mail->Username = 'inscripciones@modelo.edu.mx'; // 'inscripciones@unimodelo.com'; // SMTP username
            $mail->Password = 'nUUg106J95bV'; // 'i7X6nFLrfghu5ua';                 // SMTP password
            $mail->SMTPSecure = 'tls'; //'ssl';                    // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // 465;                            // TCP port to connect to
            $mail->setFrom('inscripciones@modelo.edu.mx', 'Universidad Modelo');
            // $mail->setFrom('inscripciones@unimodelo.com', 'Universidad Modelo');

            $mail->addAddress($to_email, $to_name);

            $mail->isHTML(true);  // Set email format to HTML

            $mail->Subject = "Inscritos Rechazados";

            $body = "";

            foreach ($alumnosSinDerecho as $alumno) {
                $body .= "<p>Clave del alumno: " . $alumno->curso->alumno->aluClave . "</p>
                <p>Nombre: " . $alumno->curso->alumno->persona->perNombre
                    . " " . $alumno->curso->alumno->persona->perApellido1
                    . " " . $alumno->curso->alumno->persona->perApellido2 . "</p>
                <p>Materia a inscribir: ". $alumno->grupoAInscribir->materia->matClave . " ". $alumno->grupoAInscribir->materia->matNombre ."</p>" .
                    "<p>Grupo a inscribir: ". $alumno->grupoAInscribir->gpoSemestre .$alumno->grupoAInscribir->gpoClave . $alumno->grupoAInscribir->gpoTurno."</p>" .
                    "<p>Plan: " . "(" .  $alumno->grupoAInscribir->materia->plan->planClave  . ")". " " . $alumno->curso->periodo->perNumero ."-". $alumno->curso->periodo->perAnio ."</p>" .
                    "<p>Ubicacion: " .$alumno->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre . "</p>" .
                    "<p>Escuela: " . $alumno->curso->cgt->plan->programa->escuela->escNombre . "</p>" .
                    "<p>Programa: " . $alumno->curso->cgt->plan->programa->progNombre . "</p>" .
                    "<p>Motivo: " . $alumno->curso->razon . "</p>" .
                    "<hr>";
            }

            $body .= "<p><b><i>Este es un correo automatizado, favor de no responder a esta cuenta de correo electrónico.</i></b></p>";

            $mail->Body  = $body;
            $mail->send();

        }
    }

    private function inscribirBachillerAlumno($curso_id, $grupo_id) {
        $curso = Curso::with('periodo.departamento')->find($curso_id);
        $grupo = Bachiller_grupos::with('bachiller_materias')->find($grupo_id);
        $historicos = new Collection;
        if($curso && $grupo) {
            #Si ya aprobó la materia, se ignora y no procede a la inscripción.
            $departamento = $curso->periodo->departamento;
            $historicos = Bachiller_historico::where('alumno_id', $curso->alumno_id)
                ->where('bachiller_materia_id', $grupo->materia_id)
                ->get()
                ->filter(static function($historico) use ($grupo, $departamento) {
                    $calificacion = MetodosHistoricos::definirCalificacionInscritos($historico, $grupo->materia);
                    return MetodosHistoricos::es_aprobada($calificacion, $departamento->depCalMinAprob);
                });
        }

        $inscrito = null;

        if($historicos->isEmpty()) {
            $inscrito = Bachiller_inscritos::create([
                'curso_id'      => $curso_id,
                'grupo_id'      => $grupo_id
            ]);
        }


        if ($inscrito) {
            $grupo->inscritos_gpo = $grupo->inscritos_gpo + 1;
            $grupo->save();

            $resultado =  DB::select("call procBachillerAgregaGruposInscritos(".$inscrito->id.", ".$grupo_id.")");
            /*
            Calificacion::create([
                'inscrito_id'   => $inscrito->id
            ]);
            */
        }
    }

}
