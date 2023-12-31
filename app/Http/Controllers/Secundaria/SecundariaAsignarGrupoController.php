<?php

namespace App\Http\Controllers\Secundaria;

use App\clases\departamentos\MetodosDepartamentos;
use Validator;
use Auth;

use App\Http\Helpers\Utils;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Inscrito;
use App\Models\InscritosRechazados;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Prerequisito;
use App\Models\Programa;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Escuela;
use App\Models\Secundaria\Secundaria_calificaciones;
use App\Models\Secundaria\Secundaria_grupos;
use App\Models\Secundaria\Secundaria_grupos_evidencias;
use App\Models\Secundaria\Secundaria_inscritos;
use App\Models\Secundaria\Secundaria_mes_evaluaciones;

class SecundariaAsignarGrupoController extends Controller
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
        return view('secundaria.asignar_grupo.show-index');
    }

    public function list()
    {

        //SECUNDARIA PERIODO ACTUAL (MERIDA Y VALLADOLID)
        $perActualUser = Auth::user()->empleado->escuela->departamento->perActual;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(15);
        $perActualCME = $departamentoCME->perActual;
        $perSigCME = $departamentoCME->perSig;


        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(19);
        $perActualCVA = $departamentoCVA->perActual;
        $perSigCVA = $departamentoCVA->perSig;

        $sistemas = Auth::user()->username; 
        $campus = Auth::user()->campus_cme; 


        $inscritos = Secundaria_inscritos::select(
            'secundaria_inscritos.id as inscrito_id',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'secundaria_inscritos.curso_id',
            'secundaria_inscritos.grupo_id',
            'secundaria_grupos.gpoClave',
            'secundaria_grupos.gpoGrado',
            'secundaria_grupos.gpoTurno',
            'secundaria_materias.matNombre',
            'secundaria_materias.matClave',
            'secundaria_grupos.gpoMatComplementaria',
            'planes.planClave',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.progNombre',
            'escuelas.escNombre',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'secundaria_empleados.empApellido1',
            'secundaria_empleados.empApellido2',
            'secundaria_empleados.empNombre'
        )
        ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
        ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
        ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
        ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
        ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
        ->where(static function ($query) use ($sistemas, $perActualCME, $perActualCVA, $perSigCME, $perSigCVA, $campus) {

            if ($sistemas == "DESARROLLO.SECUNDARIA") {
                $query->where('departamentos.depClave', '=', 'SEC');
            }else{
                if($campus == 1){
                    $query->whereIn('periodos.id', [$perActualCME, $perSigCME]);
                }else{
                    $query->whereIn('periodos.id', [$perActualCVA, $perSigCVA]);
                }                
            }
        })   
        ->latest('secundaria_inscritos.created_at');

        //->where('periodos.id', $perActual)

        $permisoC = (User::permiso("inscrito") == "C" || User::permiso("inscrito") == "A");



        return DataTables::of($inscritos)
            ->filterColumn('nombreCompleto',function($query,$keyword) {
                return $query->whereHas('curso.alumno.persona', function($query) use($keyword) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
            })


            ->filterColumn('NombreDocente',function($query,$keyword) {
                $query->whereRaw("CONCAT(empNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('NombreDocente',function($query) {
                return $query->empNombre;
            })

            ->filterColumn('apellidoPaternoDocente',function($query,$keyword) {
                $query->whereRaw("CONCAT(empApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellidoPaternoDocente',function($query) {
                return $query->empApellido1;
            })

            ->filterColumn('apellidoMaternoDocente',function($query,$keyword) {
                $query->whereRaw("CONCAT(empApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellidoMaternoDocente',function($query) {
                return $query->empApellido2;
            })


            ->addColumn('action',function($query) use ($permisoC) {
                $btnCambiarGrupo = "";
                $btnEditar = "";

                $btnEditar = '<a href="secundaria_asignar_grupo/' . $query->inscrito_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
                </a>';

                if ($permisoC) {
                    $btnCambiarGrupo = '<a href="secundaria_asignar_grupo/cambiar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Cambiar grupo">
                        <i class="material-icons">sync_alt</i>
                    </a>';
                }

                return '<a href="secundaria_asignar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
            
                <form id="delete_' . $query->inscrito_id . '" action="secundaria_asignar_grupo/' . $query->inscrito_id . '" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        $departamento = Departamento::select()->findOrFail(13);
        return view('secundaria.asignar_grupo.create',[
            'ubicaciones' => $ubicaciones,
            'departamento' => $departamento
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $grupo = Secundaria_grupos::where("id", "=", $request->grupo_id)->first();

        $validator = Validator::make(
            $request->all(),
            [
                'curso_id' => 'required|unique:secundaria_inscritos,curso_id,NULL,id,grupo_id,'.$request->input('grupo_id').',deleted_at,NULL',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ()->route('secundaria.secundaria_asignar_grupo.create')->withErrors($validator)->withInput();
        }

        try {

            $programa_id = $request->input('programa_id');

           //FILTRO EXISTE INSCRITO EN CURSO
            $secundaria_grupo = Secundaria_grupos::where("id", "=", $request->grupo_id)->first();
            // $existeInscritoEnCurso = Preescolar_inscrito::with("preescolar_grupo")
            // ->where("curso_id", "=", $request->curso_id)
            //     ->whereHas('preescolar_grupo', function ($query) use ($preescolar_grupo) {
            //         $query->where('preescolar_materia_id', $preescolar_grupo->preescolar_materia_id);
            //         $query->where('periodo_id', $preescolar_grupo->periodo_id);
            //     })
            //     ->first();

                // if ($existeInscritoEnCurso->IsNotEmpty())
                // {

                //     alert()->error('El alumno ya esta inscrito a ese grupo. Favor de verificar.' )->showConfirmButton();

                //     return redirect()->route('inscritos.create')->withInput();
                // }

            //FILTRO TIENE DERECHO A INSCRIBIRSE A GRUPOS
            $ubicacion = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
            $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
            $programa = Programa::where("id", "=", $request->programa_id)->first();
            $cursos = [$request->curso_id];
            $grupo  = $request->grupo_id;

            return $this->inscribirAlumnoSecundaria($request->curso_id, $request->grupo_id);


        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect()->route('secundaria.secundaria_asignar_grupo.create')->withInput();
        }


    }

    private function inscribirAlumnoSecundaria($curso_id, $grupo_id) {
        $secundaria_inscrito = Secundaria_inscritos::create([
            'curso_id'      => $curso_id,
            'grupo_id'      => $grupo_id,
            'inscFaltasInjSep' => 0,
            'inscFaltasInjOct' => 0,
            'inscFaltasInjOct' => 0,
            'inscFaltasInjNov' => 0,
            'inscFaltasInjDic' => 0,
            'inscFaltasJusEne' => 0,
            'inscFaltasJusFeb' => 0,
            'inscFaltasJusMar' => 0,
            'inscFaltasJusAbr' => 0,
            'inscFaltasJusMay' => 0,
            'inscFaltasJusJun' => 0,
            'inscConductaSep' => 'B',
            'inscConductaOct' => 'B',
            'inscConductaNov' => 'B',
            'inscConductaNov' => 'B',
            'inscConductaDic' => 'B',
            'inscConductaEne' => 'B',
            'inscConductaFeb' => 'B',
            'inscConductaMar' => 'B',
            'inscConductaAbr' => 'B',
            'inscConductaMay' => 'B',
            'inscConductaJun' => 'B'
        ]);


        if ($secundaria_inscrito) {
            $grupo = Secundaria_grupos::find($grupo_id);
            $grupo->inscritos_gpo = $grupo->inscritos_gpo + 1;
            $grupo->save();

            // obtenemos el ID del departamento segunn donde pertenezca el grupo
            $id_departamento = Secundaria_grupos::select('periodos.departamento_id')
            ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
            ->where('secundaria_grupos.periodo_id', $grupo->periodo_id)
            ->first();

            // treamos los meses evidencias
            $secundaria_mes_evaluaciones = Secundaria_mes_evaluaciones::select('secundaria_mes_evaluaciones.*')->where('departamento_id', '=', $id_departamento->departamento_id)->get();


            $validar_si_hay_registro_evidencias = Secundaria_grupos_evidencias::where('secundaria_grupo_id', '=', $grupo_id)->get();

            if(count($validar_si_hay_registro_evidencias) == 0){
                // agregamos datos de acuerdo al ID departamento
                foreach ($secundaria_mes_evaluaciones as $value) {

                    if($value->mes != "DICIEMBRE"){
                        Secundaria_grupos_evidencias::create([
                            'secundaria_grupo_id' => $grupo_id,
                            'secundaria_mes_evaluacion_id' => $value->id,
                            'numero_evidencias' => 1,
                            'concepto_evidencia1' => "CALIFICACIÓN",
                            'porcentaje_evidencia1' => 100
                        ]);
                    }


                }

            }

            // seleccionamos las evidencias creadas anteriormente para el grupo
            $data = Secundaria_grupos_evidencias::select('secundaria_grupos_evidencias.*', 'secundaria_mes_evaluaciones.numero_evaluacion', 'secundaria_mes_evaluaciones.mes')
            ->join('secundaria_mes_evaluaciones', 'secundaria_grupos_evidencias.secundaria_mes_evaluacion_id', '=', 'secundaria_mes_evaluaciones.id')
            ->where('secundaria_grupo_id', '=', $grupo_id)->get();

            // agregamos en la tabla de calificaciones todos los meses
            foreach ($data as $value) {
                Secundaria_calificaciones::create([
                    'secundaria_inscrito_id'   => $secundaria_inscrito->id,
                    'secundaria_grupo_evidencia_id' => $value->id,
                    'numero_evaluacion' => $value->numero_evaluacion,
                    'mes_evaluacion' => $value->mes
                ]);
            }



        }

        alert('Escuela Modelo', 'Se ha inscrito con éxito', 'success')->showConfirmButton();
        return back();
    }


    public function ObtenerGrupos(Request $request, $curso_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            $cgt = $curso->cgt;
            $ubicacion = $cgt->periodo->departamento->ubicacion;

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Secundaria_grupos::select("secundaria_grupos.id", "secundaria_grupos.gpoGrado", "secundaria_grupos.gpoClave", "secundaria_grupos.gpoTurno",
            "secundaria_grupos.gpoMatComplementaria",
                "secundaria_materias.matClave", "secundaria_materias.matNombre", "secundaria_empleados.id as empleadoId",
                "secundaria_empleados.empNombre", "secundaria_empleados.empApellido1", "secundaria_empleados.empApellido2", "optativas.optNombre")

                ->where('secundaria_grupos.plan_id', $cgt->plan_id)
                ->where('secundaria_grupos.periodo_id', $cgt->periodo_id)
                // ->where('secundaria_grupos.gpoExtraCurr', "=", "N")

                ->when($ubicacion->ubiClave != "SEC", static function($query) use ($cgt) {
                    return $query->where('gpoGrado', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "secundaria_grupos.optativa_id")
                ->join("secundaria_materias", "secundaria_materias.id", "=", "secundaria_grupos.secundaria_materia_id")
                ->join("secundaria_empleados", "secundaria_empleados.id", "=", "secundaria_grupos.empleado_id_docente")
            ->get();

            return response()->json($grupos);
        }
    }

    // // obtener los grupos de
    // public function getGrupos(Request $request, $curso_id)
    // {
    //     if ($request->ajax()) {
    //         //CURSO SELECCIONADO
    //         $curso = Curso::find($curso_id);
    //         $cgt = Cgt::find($curso->cgt_id);

    //         //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
    //         $grupos = Secundaria_grupos::select("secundaria_grupos.id as id", "secundaria_grupos.gpoGrado", "secundaria_grupos.gpoClave", "secundaria_grupos.gpoTurno",
    //             "secundaria_materias.matClave", "secundaria_materias.matNombre",
    //             "secundaria_empleados.id as empleadoId",
    //             "secundaria_empleados.empNombre as perNombre", "secundaria_empleados.empApellido1 as perApellido1", "secundaria_empleados.empApellido2 as perApellido2")
    //             ->where('secundaria_grupos.plan_id', $cgt->plan_id)
    //             ->where('secundaria_grupos.periodo_id', $cgt->periodo_id)
    //             ->where('secundaria_grupos.gpoExtraCurr', "=", "g")
    //             ->join("secundaria_materias", "secundaria_materias.id", "=", "secundaria_grupos.secundaria_materia_id")
    //             ->join("secundaria_empleados", "secundaria_empleados.id", "=", "secundaria_grupos.empleado_id_docente")
    //         ->get();

    //         return response()->json($grupos);
    //     }
    // }


    public function getDepartamentos(Request $request, $id)
    {
        if($request->ajax()){
            // $departamentos = Departamento::with('ubicacion')->where('ubicacion_id','=',$id)
            // ->whereIn('depClave', ['SUP', 'POS'])->get();

            if (Auth::user()->secundaria == 1) {
                $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['SEC']);
            }
            //$departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['POS', 'SUP', 'PRE']);
            return response()->json($departamentos);
        }
    }

    public function getEscuelas(Request $request)
    {

        if($request->ajax()){
            $escuelas = Escuela::where('departamento_id','=',$request->id)
                ->where(function($query) use ($request) {
                    $query->where("escNombre", "like", "ESCUELA%");
                    $query->orWhere('escNombre', "like", "POSGRADOS%");
                    $query->orWhere('escNombre', "like", "MAESTRIAS%");
                    $query->orWhere('escNombre', "like", "ESPECIALIDADES%");
                    $query->orWhere('escNombre', "like", "DOCTORADOS%");
                    $query->orWhere('escNombre', "like", "PRESCOLAR%");
                    $query->orWhere('escNombre', "like", "PRIMARIA%");
                    $query->orWhere('escNombre', "like", "SECUNDARIA%");


                    if ($request->otro == "diplomados") {
                        $query->orWhere('escNombre', "like", "DIPLOMADOS%");
                    }
                })
            ->get();

            return response()->json($escuelas);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inscrito = Secundaria_inscritos::with('secundaria_grupo','curso.alumno.persona')->findOrFail($id);
        return view('secundaria.asignar_grupo.show',compact('inscrito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return $inscrito = Preescolar_inscrito::with('curso.alumno.persona','grupo.materia')->findOrFail($id);
        $inscrito = Secundaria_inscritos::select()->findOrFail($id);
        $periodos = Periodo::where('departamento_id',$inscrito->curso->cgt->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado','escuela')->where('escuela_id',$inscrito->curso->cgt->plan->programa->escuela_id)->get();
        $planes = Plan::with('programa')->where('programa_id',$inscrito->curso->cgt->plan->programa->id)->get();
        $cgts = Cgt::where([['plan_id', $inscrito->curso->cgt->plan_id],['periodo_id', $inscrito->curso->cgt->periodo_id]])->get();
        $cursos = Curso::with('alumno.persona')->where('cgt_id', '=', $inscrito->curso->cgt->id)->get();
        $cgt = $inscrito->curso->cgt;
        $grupos = Secundaria_grupos::with('secundaria_materia', 'secundaria_empleado', 'plan.programa', 'periodo')
            ->where('gpoGrado', $cgt->cgtGradoSemestre)->where('plan_id',$cgt->plan_id)
            ->where('periodo_id',$cgt->periodo_id)->get();
        // //VALIDA PERMISOS EN EL PROGRAMA

        return view('secundaria.asignar_grupo.edit', [
            "inscrito" => $inscrito,
            "periodos" => $periodos,
            "programas" => $programas,
            "planes" => $planes,
            "cgts" => $cgts,
            "cursos" => $cursos,
            "grupos" => $grupos
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'curso_id' => 'required',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );
        if ($validator->fails()) {
            return redirect('secundaria_asignar_grupo/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $inscrito = Secundaria_inscritos::findOrFail($id);
                $inscrito->curso_id = $request->input('curso_id');
                $inscrito->grupo_id = $request->input('grupo_id');
                $inscrito->save();

                $resultado_array =  DB::select("call procSecundariaAlumnoEditaInscrito(" . $id . ", ".$request->curso_id.")");


                alert('Escuela Modelo', 'El inscrito se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect()->route('secundaria.secundaria_asignar_grupo.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('secundaria_asignar_grupo/' . $id . '/edit')->withInput();
            }
        }
    }

    public function cambiarGrupo(Request $request)
    {
        $inscritoId = $request->inscritoId;
        $inscrito = Secundaria_inscritos::where("id", "=", $inscritoId)->first();


        $grupos = Secundaria_grupos::with("secundaria_materia")
            ->where('secundaria_materia_id', "=", $inscrito->secundaria_grupo->secundaria_materia_id)
            ->where("periodo_id", "=", $inscrito->secundaria_grupo->periodo_id)
        ->get();



        return view('secundaria.asignar_grupo.cambiar-grupo', [
            "inscrito" => $inscrito,
            "grupos"   => $grupos
        ]);
    }

    public function postCambiarGrupo (Request $request)
    {
        //grupo nuevo
        $grupoId = $request->gpoId;
        $inscritoId = $request->inscritoId;

        $inscritoActual = Secundaria_inscritos::where("id", "=", $inscritoId)->first();
        $grupoAnteriorId = $inscritoActual->secundaria_grupo->id;


        $inscrito = Secundaria_inscritos::findOrFail($inscritoId);
        $inscrito->grupo_id = $request->gpoId;

        if ($inscrito->save()) {
            $grupoAnterior = Secundaria_grupos::findOrFail($grupoAnteriorId);
            $grupoAnterior->inscritos_gpo = $grupoAnterior->inscritos_gpo -1;
            $grupoAnterior->save();


            $grupoNuevo = Secundaria_grupos::findOrFail($request->gpoId);
            $grupoNuevo->inscritos_gpo = $grupoNuevo->inscritos_gpo +1;
            $grupoNuevo->save();
        }

        alert('Escuela Modelo', 'El inscrito materia se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $secundaria_inscrito = Secundaria_inscritos::findOrFail($id);

        $curso_id = $secundaria_inscrito->curso_id;

        $secundaria_grupo = Secundaria_grupos::find($secundaria_inscrito->grupo_id);
        if ($secundaria_grupo->inscritos_gpo > 0) {
            $secundaria_grupo->inscritos_gpo = $secundaria_grupo->inscritos_gpo - 1;
            $secundaria_grupo->save();
        }

        try {
            if ($secundaria_inscrito->delete())
            {
                $resultado_array =  DB::select("call procSecundariaAlumnoEditaInscrito(" . $id . ", ".$curso_id.")");
                alert('Escuela Modelo', 'El inscrito materia se ha eliminado con éxito','success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el inscrito materia')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect()->route('secundaria.secundaria_asignar_grupo.index');
    }
}
