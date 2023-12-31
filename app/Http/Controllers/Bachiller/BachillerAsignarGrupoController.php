<?php

namespace App\Http\Controllers\Bachiller;

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
use App\Models\Alumno;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Bachiller\Bachiller_inscritos;
use App\Models\Bachiller\Bachiller_inscritos_evidencias;
use App\Models\Bachiller\Bachiller_mes_evaluaciones;
use App\Models\Escuela;


class BachillerAsignarGrupoController extends Controller
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

        return view('bachiller.asignar_grupo.show-index');
    }

    public function list()
    {

        //BACHILLER PERIODO ACTUAL (MERIDA Y VALLADOLID)
        $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion;

        $departamentoCME = Departamento::with('ubicacion')->findOrFail(7);
        $perActualCME = $departamentoCME->perActual;
        $perAnteCME = $departamentoCME->perAnte;


        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(17);
        $perActualCVA = $departamentoCVA->perActual;
        $perAnteCVA = $departamentoCVA->perAnte;




        if ((Auth::user()->departamento_sistemas == 1)) {
            $ubicacionClave = "CME";
            $ubicacionClave2 = "CVA";

            $inscritos = Bachiller_inscritos::select(
                'bachiller_inscritos.id as inscrito_id',
                'alumnos.aluClave',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'bachiller_inscritos.curso_id',
                'bachiller_inscritos.bachiller_grupo_id',
                'bachiller_grupos.gpoClave',
                'bachiller_grupos.gpoGrado',
                'bachiller_grupos.gpoTurno',
                'bachiller_materias.matNombre',
                'bachiller_grupos.gpoMatComplementaria',
                'planes.planClave',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.id as periodo_id',
                'programas.progNombre',
                'escuelas.escNombre',
                'departamentos.depNombre',
                'departamentos.depClave',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre'
            )
                ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
                ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
                ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
                ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
                ->whereIn('ubicacion.ubiClave', [$ubicacionClave, $ubicacionClave2])
                ->latest('bachiller_inscritos.created_at');
        } else {
            if ($ubicacion->ubiClave == "CME") {
                $ubicacionClave = "CME";
            } else {
                $ubicacionClave = "CVA";
            }

            $inscritos = Bachiller_inscritos::select(
                'bachiller_inscritos.id as inscrito_id',
                'alumnos.aluClave',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'bachiller_inscritos.curso_id',
                'bachiller_inscritos.bachiller_grupo_id',
                'bachiller_grupos.gpoClave',
                'bachiller_grupos.gpoGrado',
                'bachiller_grupos.gpoTurno',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'bachiller_grupos.gpoMatComplementaria',
                'planes.planClave',
                'periodos.perNumero',
                'periodos.perAnio',
                'periodos.id as periodo_id',
                'programas.progNombre',
                'escuelas.escNombre',
                'departamentos.depNombre',
                'departamentos.depClave',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'bachiller_empleados.empApellido1',
                'bachiller_empleados.empApellido2',
                'bachiller_empleados.empNombre'
            )
                ->join('cursos', 'bachiller_inscritos.curso_id', '=', 'cursos.id')
                ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
                ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
                ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->leftJoin('bachiller_empleados', 'bachiller_grupos.empleado_id_docente', '=', 'bachiller_empleados.id')
                ->where('ubicacion.ubiClave', $ubicacionClave)
                // ->whereIn('periodos.id', [$perAnteCME, $perActualCME, $perAnteCVA, $perActualCVA, 1975])
                ->latest('bachiller_inscritos.created_at');
        }




        $permisoC = (User::permiso("inscrito") == "C" || User::permiso("inscrito") == "A");



        return DataTables::of($inscritos)
            ->filterColumn('nombreCompleto', function ($query, $keyword) {
                return $query->whereHas('curso.alumno.persona', function ($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombreCompleto', function ($query) {
                return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
            })


            ->filterColumn('NombreDocente', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('NombreDocente', function ($query) {
                return $query->empNombre;
            })

            ->filterColumn('apellidoPaternoDocente', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellidoPaternoDocente', function ($query) {
                return $query->empApellido1;
            })

            ->filterColumn('apellidoMaternoDocente', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellidoMaternoDocente', function ($query) {
                return $query->empApellido2;
            })

            ->filterColumn('periodo_numero', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_numero', function ($query) {
                return $query->perNumero;
            })

            ->filterColumn('clave_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_materia', function ($query) {
                return $query->matClave;
            })


            ->filterColumn('nombre_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_materia', function ($query) {
                return $query->matNombre;
            })

            ->filterColumn('complementaria', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoMatComplementaria) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('complementaria', function ($query) {
                return $query->gpoMatComplementaria;
            })


            ->filterColumn('semestre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoGrado) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('semestre', function ($query) {
                return $query->gpoGrado;
            })

            ->filterColumn('grupo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('grupo', function ($query) {
                return $query->gpoClave;
            })

            ->filterColumn('ubicacion_nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion_nombre', function ($query) {
                return $query->ubiNombre;
            })

            ->filterColumn('programa_nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('programa_nombre', function ($query) {
                return $query->progNombre;
            })

            ->filterColumn('periodo_anio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_anio', function ($query) {
                return $query->perAnio;
            })

            ->filterColumn('plan_clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('plan_clave', function ($query) {
                return $query->planClave;
            })

            ->filterColumn('clave_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_pago', function ($query) {
                return $query->aluClave;
            })

            ->addColumn('action', function ($query) use ($permisoC) {

                $user_log = auth()->user()->departamento_sistemas;

                $btnCambiarGrupo = "";
                $btnEditar = "";
                $btnEliminar = "";

                $departamentoCME = Departamento::with('ubicacion')->findOrFail(7);
                $perActualCME = $departamentoCME->perActual;

                $departamentoCVA = Departamento::with('ubicacion')->findOrFail(17);
                $perActualCVA = $departamentoCVA->perActual;

                if ((Auth::user()->departamento_sistemas == 1)) {
                    $btnEliminar = '<form id="delete_' . $query->inscrito_id . '" action="bachiller_asignar_grupo/' . $query->inscrito_id . '" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    </form>';
                } else {
                    if ($perActualCME == $query->periodo_id || $perActualCVA == $query->periodo_id) {
                        $btnEliminar = '<form id="delete_' . $query->inscrito_id . '" action="bachiller_asignar_grupo/' . $query->inscrito_id . '" method="POST" style="display: inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                    } else {
                        $btnEliminar = "";
                    }
                }



                if ($user_log == 1) {
                    if ($permisoC) {
                        $btnCambiarGrupo = '<a href="bachiller_asignar_grupo/cambiar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Cambiar grupo">
                            <i class="material-icons">sync_alt</i>
                        </a>';
                    }

                    $btnEditar = '<a href="bachiller_asignar_grupo/' . $query->inscrito_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>';
                }


                return '<a href="bachiller_asignar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                    . $btnEditar
                    . $btnEliminar
                    . $btnCambiarGrupo;
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
        $departamento = Departamento::whereIn('id', [7, 17])->get();
        return view('bachiller.asignar_grupo.create', [
            'ubicaciones' => $ubicaciones,
            'departamento' => $departamento
        ]);
    }


    public function create_por_grupo()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        return view('bachiller.asignar_grupo.create_por_grupo', [
            'ubicaciones' => $ubicaciones
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
        $curso_id = $request->curso_id;
        $grupo_id = $request->grupo_id;
        $cgt_id = $request->cgt_id;
        $periodo_id = $request->periodo_id;
        $plan_id = $request->plan_id;
        $obtiene_alumno_id = Curso::where('id', $curso_id)->first();
        $alumno_id = $obtiene_alumno_id->alumno_id;
        $obtiene_alu_clave = Alumno::where('id', $alumno_id)->first();
        $aluClave = $obtiene_alu_clave->aluClave;

        $grupo = Bachiller_grupos::where("id", "=", $request->grupo_id)->first();

        $validator = Validator::make(
            $request->all(),
            [
                'curso_id' => 'required|unique:bachiller_inscritos,curso_id,NULL,id,bachiller_grupo_id,' . $request->input('grupo_id') . ',deleted_at,NULL',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('bachiller.bachiller_asignar_grupo.create')->withErrors($validator)->withInput();
        }

        try {

            $resultado_array =  DB::select("call procBachillerInscribePorMateria(" . $curso_id . ", 
            " . $grupo_id . ",
            " . $cgt_id . ",
            " . $periodo_id . ",
            " . $plan_id . ",
            " . $alumno_id . ",
            " . $aluClave . ")");
            $resultado_collection = collect($resultado_array);

            if ($resultado_collection) {
                alert('Escuela Modelo', 'Se ha inscrito con éxito', 'success')->showConfirmButton();
                return back();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect()->route('bachiller.bachiller_asignar_grupo.create')->withInput();
        }
    }


    public function getCgtsDestino(Request $request, $plan_id,$periodo_id, $semestre)
    {
        if ($request->ajax()) {
            $cgts = Cgt::where('plan_id', $plan_id)
            ->where('periodo_id', $periodo_id)
            ->where('cgtGradoSemestre', $semestre)
            // ->orderBy('cgtGradoSemestre', 'ASC')
            ->orderBy('cgtGrupo', 'ASC')
            ->get();
            return response()->json($cgts);
        }
    }

    // buscar alumnos cursos 
    public function getCursosSemestre(Request $request, $periodo, $gpoSemestreC)
    {
        if($request->ajax()){
            $cursos = Curso::with('cgt','alumno.persona')->where('periodo_id', $periodo)->whereIn("curEstado", ["R", "C", "A", "P"])
            ->whereHas('cgt', function($query) use ($gpoSemestreC) {
                $query->where('cgtGradoSemestre', $gpoSemestreC);                
            })
            ->get();
            return response()->json($cursos);
        }
    }

    public function store_por_grupo(Request $request)
    {
        if ($request->ajax()) {

            $curso_id = $request->input('curso_id');
            $grupo_id = $request->input('grupo_id');
            $cgt_id2 = $request->input('cgt_id2');
            $periodo_id = $request->input('periodo_id');
            $plan_id = $request->input('plan_id');

            $obtiene_alumno_id = Curso::where('id', $curso_id)->first();
            $alumno_id = $obtiene_alumno_id->alumno_id;
            $obtiene_alu_clave = Alumno::where('id', $alumno_id)->first();
            $aluClave = $obtiene_alu_clave->aluClave;

            $curso_del_alumno = Curso::find($curso_id);

            // actualizar el CGT
            $curso_del_alumno->update([
                "cgt_id" => $cgt_id2
            ]);

            if ($grupo_id != "") {
                for ($i = 0; $i < count($grupo_id); $i++) {     
                    $bachiller_inscrito =  Bachiller_inscritos::where('curso_id', $curso_id)
                    ->where('bachiller_grupo_id', $grupo_id[$i])
                    ->get();          

                    if ($bachiller_inscrito->isEmpty()) {

                        
                        // Bachiller_inscritos::create([
                        //     'curso_id' => $curso_id,
                        //     'bachiller_grupo_id' => $grupo_id[$i],
    
                        // ]);

                        
                        $resultado_array =  DB::select("call procBachillerInscribePorMateria(" . $curso_id . ", 
                        " . $grupo_id[$i] . ",
                        " . $cgt_id2 . ",
                        " . $periodo_id . ",
                        " . $plan_id . ",
                        " . $alumno_id . ",
                        " . $aluClave . ")");
                        $resultado_collection = collect($resultado_array); 
                    }
                    
                }

                return response()->json([
                    "respuesta" => "true"
                ]);

                
            }else{
                return response()->json([
                    "respuesta" => "false"
                ]);
            }

            
        }
    }
    // public function store(Request $request)
    // {

    //     $grupo = Bachiller_grupos::where("id", "=", $request->grupo_id)->first();

    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'curso_id' => 'required|unique:bachiller_inscritos,curso_id,NULL,id,bachiller_grupo_id,'.$request->input('grupo_id').',deleted_at,NULL',
    //             'grupo_id' => 'required'
    //         ],
    //         [
    //             'curso_id.unique' => "El inscrito ya existe",
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return redirect ()->route('bachiller.bachiller_asignar_grupo.create')->withErrors($validator)->withInput();
    //     }

    //     try {

    //         $programa_id = $request->input('programa_id');

    //        //FILTRO EXISTE INSCRITO EN CURSO
    //         $bachiller_grupo = Bachiller_grupos::where("id", "=", $request->grupo_id)->first();
    //         // $existeInscritoEnCurso = Preescolar_inscrito::with("preescolar_grupo")
    //         // ->where("curso_id", "=", $request->curso_id)
    //         //     ->whereHas('preescolar_grupo', function ($query) use ($preescolar_grupo) {
    //         //         $query->where('preescolar_materia_id', $preescolar_grupo->preescolar_materia_id);
    //         //         $query->where('periodo_id', $preescolar_grupo->periodo_id);
    //         //     })
    //         //     ->first();

    //             // if ($existeInscritoEnCurso->IsNotEmpty())
    //             // {

    //             //     alert()->error('El alumno ya esta inscrito a ese grupo. Favor de verificar.' )->showConfirmButton();

    //             //     return redirect()->route('inscritos.create')->withInput();
    //             // }

    //         //FILTRO TIENE DERECHO A INSCRIBIRSE A GRUPOS
    //         $ubicacion = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
    //         $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
    //         $programa = Programa::where("id", "=", $request->programa_id)->first();
    //         $cursos = [$request->curso_id];
    //         $grupo  = $request->grupo_id;

    //         return $this->inscribirAlumnoBachiller($request->curso_id, $request->grupo_id);


    //     } catch (QueryException $e) {
    //         $errorCode = $e->errorInfo[1];
    //         $errorMessage = $e->errorInfo[2];
    //         alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

    //         return redirect()->route('bachiller.bachiller_asignar_grupo.create')->withInput();
    //     }


    // }

    private function inscribirAlumnoBachiller($curso_id, $grupo_id)
    {
        $bachiller_inscrito = Bachiller_inscritos::create([
            'curso_id'      => $curso_id,
            'bachiller_grupo_id'      => $grupo_id,
            'insCalificacionParcial1' => 0,
            'insFaltasParcial1' => 0,
            'insCalificacionParcial2' => 0,
            'insFaltasParcial2' => 0,
            'insCalificacionParcial3' => 0,
            'insFaltasParcial3' => 0,
            'insPromedioParcial' => 0,
            'insCalificacionOrdinario' => 0,
            'insCalificacionFinal' => 0,
            'preparatoria_historico_id' => 0

        ]);


        if ($bachiller_inscrito) {
            $grupo = Bachiller_grupos::find($grupo_id);
            $grupo->inscritos_gpo = $grupo->inscritos_gpo + 1;
            $grupo->save();

            // obtenemos el ID del departamento segunn donde pertenezca el grupo
            $id_departamento = Bachiller_grupos::select('periodos.departamento_id')
                ->join('periodos', 'bachiller_grupos.periodo_id', '=', 'periodos.id')
                ->where('bachiller_grupos.periodo_id', $grupo->periodo_id)
                ->first();

            // treamos los meses evidencias
            // $bachiller_mes_evaluaciones = Bachiller_mes_evaluaciones::select('bachiller_mes_evaluaciones.*')->where('departamento_id', '=', $id_departamento->departamento_id)->get();


            // $validar_si_hay_registro_evidencias = Bachiller_grupos_evidencias::where('bachiller_grupo_id', '=', $grupo_id)->get();

            // if(count($validar_si_hay_registro_evidencias) == 0){
            //     // agregamos datos de acuerdo al ID departamento
            //     foreach ($bachiller_mes_evaluaciones as $value) {

            //         if($value->mes != "DICIEMBRE"){
            //             Bachiller_grupos_evidencias::create([
            //                 'bachiller_grupo_id' => $grupo_id,
            //                 'bachiller_mes_evaluacion_id' => $value->id,
            //                 'numero_evidencias' => 1,
            //                 'concepto_evidencia1' => "CALIFICACIÓN",
            //                 'porcentaje_evidencia1' => 100
            //             ]);
            //         }


            //     }

            // }

            // // seleccionamos las evidencias creadas anteriormente para el grupo
            // $data = Bachiller_grupos_evidencias::select('bachiller_grupos_evidencias.*', 'bachiller_mes_evaluaciones.numero_evaluacion')
            // ->join('bachiller_mes_evaluaciones', 'bachiller_grupos_evidencias.bachiller_mes_evaluacion_id', '=', 'bachiller_mes_evaluaciones.id')
            // ->where('bachiller_grupo_id', '=', $grupo_id)->get();

            // // agregamos en la tabla de calificaciones todos los meses
            // foreach ($data as $value) {
            //     Bachiller_calificaciones::create([
            //         'bachiller_inscrito_id'   => $bachiller_inscrito->id,
            //         'bachiller_grupo_evidencia_id' => $value->id,
            //         'numero_evaluacion' => $value->numero_evaluacion
            //     ]);
            // }



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
            $grupos = Bachiller_grupos::select(
                "bachiller_grupos.id",
                "bachiller_grupos.gpoGrado",
                "bachiller_grupos.gpoClave",
                "bachiller_grupos.gpoTurno",
                "bachiller_grupos.gpoMatComplementaria",
                "bachiller_materias.matClave",
                "bachiller_materias.matNombre",
                "bachiller_empleados.id as empleadoId",
                "bachiller_empleados.empNombre",
                "bachiller_empleados.empApellido1",
                "bachiller_empleados.empApellido2",
                "optativas.optNombre"
            )

                ->where('bachiller_grupos.plan_id', $cgt->plan_id)
                ->where('bachiller_grupos.periodo_id', $cgt->periodo_id)
                // ->where('bachiller_grupos.gpoExtraCurr', "=", "N")

                ->when($ubicacion->ubiClave != "BAC", static function ($query) use ($cgt) {
                    return $query->where('gpoGrado', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "bachiller_grupos.optativa_id")
                ->join("bachiller_materias", "bachiller_materias.id", "=", "bachiller_grupos.bachiller_materia_id")
                ->join("bachiller_empleados", "bachiller_empleados.id", "=", "bachiller_grupos.empleado_id_docente")
                ->get();

            return response()->json($grupos);
        }
    }

    public function ObtenerGruposMaterias(Request $request, $cgt_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            // $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            // $cgt = $curso->cgt;
            $cgt = Cgt::find($cgt_id);

            $ubicacion = $cgt->periodo->departamento->ubicacion;

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Bachiller_grupos::select(
                "bachiller_grupos.id",
                "bachiller_grupos.gpoGrado",
                "bachiller_grupos.gpoClave",
                "bachiller_grupos.gpoTurno",
                "bachiller_grupos.gpoMatComplementaria",
                "bachiller_materias.matClave",
                "bachiller_materias.matNombre",
                "bachiller_materias.matClasificacion",
                "bachiller_empleados.id as empleadoId",
                "bachiller_empleados.empNombre",
                "bachiller_empleados.empApellido1",
                "bachiller_empleados.empApellido2",
                "optativas.optNombre",
                "bachiller_materias.matTipoGrupoMateria"
            )

                ->where('bachiller_grupos.plan_id', $cgt->plan_id)
                ->where('bachiller_grupos.periodo_id', $cgt->periodo_id)
                ->where('bachiller_grupos.gpoClave', $cgt->cgtGrupo)
                ->where('bachiller_materias.matTipoGrupoMateria', 'BASICA')

                // ->where('bachiller_grupos.gpoExtraCurr', "=", "N")

                ->when($ubicacion->ubiClave != "BAC", static function ($query) use ($cgt) {
                    return $query->where('gpoGrado', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "bachiller_grupos.optativa_id")
                ->join("bachiller_materias", "bachiller_materias.id", "=", "bachiller_grupos.bachiller_materia_id")
                ->join("bachiller_empleados", "bachiller_empleados.id", "=", "bachiller_grupos.empleado_id_docente")
                ->get();

            return response()->json($grupos);
        }
    }

    public function ObtenerGruposMateriasOptativas(Request $request, $cgt_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            // $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            // $cgt = $curso->cgt;
            $cgt = Cgt::find($cgt_id);
            $ubicacion = $cgt->periodo->departamento->ubicacion;

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Bachiller_grupos::select(
                "bachiller_grupos.id",
                "bachiller_grupos.gpoGrado",
                "bachiller_grupos.gpoClave",
                "bachiller_grupos.gpoTurno",
                "bachiller_grupos.gpoMatComplementaria",
                "bachiller_materias.matClave",
                "bachiller_materias.matNombre",
                "bachiller_materias.matClasificacion",
                "bachiller_empleados.id as empleadoId",
                "bachiller_empleados.empNombre",
                "bachiller_empleados.empApellido1",
                "bachiller_empleados.empApellido2",
                "optativas.optNombre",
                "bachiller_materias.matTipoGrupoMateria"
            )

                ->where('bachiller_grupos.plan_id', $cgt->plan_id)
                ->where('bachiller_grupos.periodo_id', $cgt->periodo_id)
                ->where('bachiller_materias.matTipoGrupoMateria', 'OPTATIVA')

                // ->where('bachiller_grupos.gpoExtraCurr', "=", "N")

                ->when($ubicacion->ubiClave != "BAC", static function ($query) use ($cgt) {
                    return $query->where('gpoGrado', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "bachiller_grupos.optativa_id")
                ->join("bachiller_materias", "bachiller_materias.id", "=", "bachiller_grupos.bachiller_materia_id")
                ->join("bachiller_empleados", "bachiller_empleados.id", "=", "bachiller_grupos.empleado_id_docente")
                ->get();

            return response()->json($grupos);
        }
    }

    public function ObtenerGruposMateriasOcupacinales(Request $request, $cgt_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            // $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            // $cgt = $curso->cgt;
            $cgt = Cgt::find($cgt_id);
            $ubicacion = $cgt->periodo->departamento->ubicacion;

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Bachiller_grupos::select(
                "bachiller_grupos.id",
                "bachiller_grupos.gpoGrado",
                "bachiller_grupos.gpoClave",
                "bachiller_grupos.gpoTurno",
                "bachiller_grupos.gpoMatComplementaria",
                "bachiller_materias.matClave",
                "bachiller_materias.matNombre",
                "bachiller_materias.matClasificacion",
                "bachiller_empleados.id as empleadoId",
                "bachiller_empleados.empNombre",
                "bachiller_empleados.empApellido1",
                "bachiller_empleados.empApellido2",
                "optativas.optNombre",
                "bachiller_materias.matTipoGrupoMateria"
            )

                ->where('bachiller_grupos.plan_id', $cgt->plan_id)
                ->where('bachiller_grupos.periodo_id', $cgt->periodo_id)
                ->where('bachiller_materias.matTipoGrupoMateria', 'OCUPACIONAL')

                // ->where('bachiller_grupos.gpoExtraCurr', "=", "N")

                ->when($ubicacion->ubiClave != "BAC", static function ($query) use ($cgt) {
                    return $query->where('gpoGrado', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "bachiller_grupos.optativa_id")
                ->join("bachiller_materias", "bachiller_materias.id", "=", "bachiller_grupos.bachiller_materia_id")
                ->join("bachiller_empleados", "bachiller_empleados.id", "=", "bachiller_grupos.empleado_id_docente")
                ->get();

            return response()->json($grupos);
        }
    }

    public function ObtenerGruposMateriasComplementaria(Request $request, $cgt_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            // $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            // $cgt = $curso->cgt;
            $cgt = Cgt::find($cgt_id);
            $ubicacion = $cgt->periodo->departamento->ubicacion;

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Bachiller_grupos::select(
                "bachiller_grupos.id",
                "bachiller_grupos.gpoGrado",
                "bachiller_grupos.gpoClave",
                "bachiller_grupos.gpoTurno",
                "bachiller_grupos.gpoMatComplementaria",
                "bachiller_materias.matClave",
                "bachiller_materias.matNombre",
                "bachiller_materias.matClasificacion",
                "bachiller_empleados.id as empleadoId",
                "bachiller_empleados.empNombre",
                "bachiller_empleados.empApellido1",
                "bachiller_empleados.empApellido2",
                "optativas.optNombre",
                "bachiller_materias.matTipoGrupoMateria"
            )

                ->where('bachiller_grupos.plan_id', $cgt->plan_id)
                ->where('bachiller_grupos.periodo_id', $cgt->periodo_id)
                ->where('bachiller_materias.matTipoGrupoMateria', 'COMPLEMENTARIA')

                // ->where('bachiller_grupos.gpoExtraCurr', "=", "N")

                ->when($ubicacion->ubiClave != "BAC", static function ($query) use ($cgt) {
                    return $query->where('gpoGrado', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "bachiller_grupos.optativa_id")
                ->join("bachiller_materias", "bachiller_materias.id", "=", "bachiller_grupos.bachiller_materia_id")
                ->join("bachiller_empleados", "bachiller_empleados.id", "=", "bachiller_grupos.empleado_id_docente")
                ->get();

            return response()->json($grupos);
        }
    }

    
    public function ObtenerGruposMateriasExtra(Request $request, $cgt_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            // $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            // $cgt = $curso->cgt;
            $cgt = Cgt::find($cgt_id);
            $ubicacion = $cgt->periodo->departamento->ubicacion;

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Bachiller_grupos::select(
                "bachiller_grupos.id",
                "bachiller_grupos.gpoGrado",
                "bachiller_grupos.gpoClave",
                "bachiller_grupos.gpoTurno",
                "bachiller_grupos.gpoMatComplementaria",
                "bachiller_materias.matClave",
                "bachiller_materias.matNombre",
                "bachiller_materias.matClasificacion",
                "bachiller_empleados.id as empleadoId",
                "bachiller_empleados.empNombre",
                "bachiller_empleados.empApellido1",
                "bachiller_empleados.empApellido2",
                "optativas.optNombre",
                "bachiller_materias.matTipoGrupoMateria"
            )

                ->where('bachiller_grupos.plan_id', $cgt->plan_id)
                ->where('bachiller_grupos.periodo_id', $cgt->periodo_id)
                ->where('bachiller_materias.matTipoGrupoMateria', 'EXTRA')

                // ->where('bachiller_grupos.gpoExtraCurr', "=", "N")

                ->when($ubicacion->ubiClave != "BAC", static function ($query) use ($cgt) {
                    return $query->where('gpoGrado', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "bachiller_grupos.optativa_id")
                ->join("bachiller_materias", "bachiller_materias.id", "=", "bachiller_grupos.bachiller_materia_id")
                ->join("bachiller_empleados", "bachiller_empleados.id", "=", "bachiller_grupos.empleado_id_docente")
                ->get();

            return response()->json($grupos);
        }
    }

    public function ObtenerGruposMateriasACDIngles(Request $request, $cgt_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            // $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            // $cgt = $curso->cgt;
            $cgt = Cgt::find($cgt_id);

            $ubicacion = $cgt->periodo->departamento->ubicacion;

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Bachiller_grupos::select(
                "bachiller_grupos.id",
                "bachiller_grupos.gpoGrado",
                "bachiller_grupos.gpoClave",
                "bachiller_grupos.gpoTurno",
                "bachiller_grupos.gpoMatComplementaria",
                "bachiller_materias.matClave",
                "bachiller_materias.matNombre",
                "bachiller_materias.matClasificacion",
                "bachiller_empleados.id as empleadoId",
                "bachiller_empleados.empNombre",
                "bachiller_empleados.empApellido1",
                "bachiller_empleados.empApellido2",
                "optativas.optNombre",
                "bachiller_materias.matTipoGrupoMateria"
            )

                ->where('bachiller_grupos.plan_id', $cgt->plan_id)
                ->where('bachiller_grupos.periodo_id', $cgt->periodo_id)
                // ->where('bachiller_grupos.gpoClave', '!=', $cgt->cgtGrupo)
                ->where('bachiller_materias.matTipoGrupoMateria', 'BASICA INGLES')

                // ->where('bachiller_grupos.gpoExtraCurr', "=", "N")

                ->when($ubicacion->ubiClave != "BAC", static function ($query) use ($cgt) {
                    return $query->where('gpoGrado', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "bachiller_grupos.optativa_id")
                ->join("bachiller_materias", "bachiller_materias.id", "=", "bachiller_grupos.bachiller_materia_id")
                ->join("bachiller_empleados", "bachiller_empleados.id", "=", "bachiller_grupos.empleado_id_docente")
                ->get();

            return response()->json($grupos);
        }
    }

    public function cargaCGTActual(Request $request, $curso_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            $semestre = $curso->cgt->cgtGradoSemestre;
            $periodo_id = $curso->periodo_id;
            $plan_id = $curso->cgt->plan_id;

            $cgt_actual = $curso->cgt->id;
            $cgt = Cgt::where('plan_id', $plan_id)
            ->where('periodo_id', $periodo_id)
            ->where('cgtGradoSemestre', $semestre)
            ->get();
           
            return response()->json([
                "cgt" => $cgt,
                "cgt_actual" => $cgt_actual
            ]);
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
    //         $grupos = Bachiller_grupos::select("bachiller_grupos.id as id", "bachiller_grupos.gpoGrado", "bachiller_grupos.gpoClave", "bachiller_grupos.gpoTurno",
    //             "bachiller_materias.matClave", "bachiller_materias.matNombre",
    //             "bachiller_empleados.id as empleadoId",
    //             "bachiller_empleados.empNombre as perNombre", "bachiller_empleados.empApellido1 as perApellido1", "bachiller_empleados.empApellido2 as perApellido2")
    //             ->where('bachiller_grupos.plan_id', $cgt->plan_id)
    //             ->where('bachiller_grupos.periodo_id', $cgt->periodo_id)
    //             ->where('bachiller_grupos.gpoExtraCurr', "=", "g")
    //             ->join("bachiller_materias", "bachiller_materias.id", "=", "bachiller_grupos.bachiller_materia_id")
    //             ->join("bachiller_empleados", "bachiller_empleados.id", "=", "bachiller_grupos.empleado_id_docente")
    //         ->get();

    //         return response()->json($grupos);
    //     }
    // }


    public function getDepartamentos(Request $request, $id)
    {
        if ($request->ajax()) {
            // $departamentos = Departamento::with('ubicacion')->where('ubicacion_id','=',$id)
            // ->whereIn('depClave', ['SUP', 'POS'])->get();

            if (Auth::user()->bachiller == 1) {
                $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['BAC']);
            }
            //$departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['POS', 'SUP', 'PRE']);
            return response()->json($departamentos);
        }
    }

    public function getEscuelas(Request $request)
    {

        if ($request->ajax()) {
            $escuelas = Escuela::where('departamento_id', '=', $request->id)
                ->where(function ($query) use ($request) {
                    $query->where("escNombre", "like", "ESCUELA%");
                    $query->orWhere('escNombre', "like", "POSGRADOS%");
                    $query->orWhere('escNombre', "like", "MAESTRIAS%");
                    $query->orWhere('escNombre', "like", "ESPECIALIDADES%");
                    $query->orWhere('escNombre', "like", "DOCTORADOS%");
                    $query->orWhere('escNombre', "like", "PRESCOLAR%");
                    $query->orWhere('escNombre', "like", "PRIMARIA%");
                    $query->orWhere('escNombre', "like", "SECUNDARIA%");
                    $query->orWhere('escNombre', "like", "BACHILLER%");



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
        $inscrito = Bachiller_inscritos::with('bachiller_grupo', 'curso.alumno.persona')->findOrFail($id);
        return view('bachiller.asignar_grupo.show', compact('inscrito'));
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
        $inscrito = Bachiller_inscritos::select()->findOrFail($id);
        $periodos = Periodo::where('departamento_id', $inscrito->curso->cgt->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado', 'escuela')->where('escuela_id', $inscrito->curso->cgt->plan->programa->escuela_id)->get();
        $planes = Plan::with('programa')->where('programa_id', $inscrito->curso->cgt->plan->programa->id)->get();
        $cgts = Cgt::where([['plan_id', $inscrito->curso->cgt->plan_id], ['periodo_id', $inscrito->curso->cgt->periodo_id]])->get();
        $cursos = Curso::with('alumno.persona')->where('cgt_id', '=', $inscrito->curso->cgt->id)->get();
        $cgt = $inscrito->curso->cgt;
        $grupos = Bachiller_grupos::with('bachiller_materia', 'bachiller_empleado', 'plan.programa', 'periodo')
            ->where('gpoGrado', $cgt->cgtGradoSemestre)->where('plan_id', $cgt->plan_id)
            ->where('periodo_id', $cgt->periodo_id)->get();
        // //VALIDA PERMISOS EN EL PROGRAMA

        return view('bachiller.asignar_grupo.edit', [
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
            return redirect('bachiller_asignar_grupo/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $inscrito = Bachiller_inscritos::findOrFail($id);
                $inscrito->curso_id = $request->input('curso_id');
                $inscrito->bachiller_grupo_id = $request->input('grupo_id');
                $inscrito->save();

                // $resultado_array =  DB::select("call procBachillerAlumnoEditaInscrito(" . $id . ")");


                alert('Escuela Modelo', 'El inscrito se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect()->route('bachiller.bachiller_asignar_grupo.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('bachiller_asignar_grupo/' . $id . '/edit')->withInput();
            }
        }
    }

    public function cambiarGrupo(Request $request)
    {
        $inscritoId = $request->inscritoId;
        $inscrito = Bachiller_inscritos::where("id", "=", $inscritoId)->first();


        $grupos = Bachiller_grupos::with("bachiller_materia")
            ->where('bachiller_materia_id', "=", $inscrito->bachiller_grupo->bachiller_materia_id)
            ->where("periodo_id", "=", $inscrito->bachiller_grupo->periodo_id)
            ->get();



        return view('bachiller.asignar_grupo.cambiar-grupo', [
            "inscrito" => $inscrito,
            "grupos"   => $grupos
        ]);
    }

    public function postCambiarGrupo(Request $request)
    {
        //grupo nuevo
        $grupoId = $request->gpoId;
        $inscritoId = $request->inscritoId;

        $inscritoActual = Bachiller_inscritos::where("id", "=", $inscritoId)->first();
        $grupoAnteriorId = $inscritoActual->bachiller_grupo->id;


        $inscrito = Bachiller_inscritos::findOrFail($inscritoId);
        $inscrito->grupo_id = $request->gpoId;

        if ($inscrito->save()) {
            $grupoAnterior = Bachiller_grupos::findOrFail($grupoAnteriorId);
            $grupoAnterior->inscritos_gpo = $grupoAnterior->inscritos_gpo - 1;
            $grupoAnterior->save();


            $grupoNuevo = Bachiller_grupos::findOrFail($request->gpoId);
            $grupoNuevo->inscritos_gpo = $grupoNuevo->inscritos_gpo + 1;
            $grupoNuevo->save();
        }

        alert('Escuela Modelo', 'El inscrito materia se ha actualizado con éxito', 'success')->showConfirmButton();
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

        //    return $bachiller_evidencia_inscrito = Bachiller_inscritos_evidencias::where('bachiller_inscrito_id', '=', $id)->get();

        $bachiller_inscrito = Bachiller_inscritos::findOrFail($id);

        $bachiller_grupo = Bachiller_grupos::find($bachiller_inscrito->bachiller_grupo_id);
        if ($bachiller_grupo->inscritos_gpo > 0) {
            $bachiller_grupo->inscritos_gpo = $bachiller_grupo->inscritos_gpo - 1;
            $bachiller_grupo->save();
        }

        try {
            if ($bachiller_inscrito->delete()) {
                // Eliminamos las evidencias de ese alumno 
                Bachiller_inscritos_evidencias::where('bachiller_inscrito_id', $id)->delete();

                // $resultado_array =  DB::select("call procBachillerAlumnoEditaInscrito(" . $id . ")");
                alert('Escuela Modelo', 'El inscrito materia se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el inscrito materia')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect()->route('bachiller.bachiller_asignar_grupo.index');
    }
}
