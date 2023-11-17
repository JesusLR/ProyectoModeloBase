<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Carbon\Carbon;

use App\Models\User;
use App\Http\Models\Cgt;
use App\Http\Models\Aula;
use App\Http\Models\Plan;
use App\Http\Models\Curso;
use App\Http\Models\Grupo;
use App\Http\Helpers\Utils;
use App\Http\Models\Horario;
use App\Http\Models\Materia;
use App\Http\Models\Periodo;
use App\Http\Models\Empleado;
use App\Http\Models\Inscrito;
use App\Http\Models\Optativa;
use App\Http\Models\Programa;
use App\Http\Models\Historico;
use App\Http\Models\Ubicacion;
use App\Http\Models\HorarioAdmivo;
use App\Http\Models\Preescolar\Preescolar_grupo;
use App\Http\Models\Preescolar\Preescolar_inscrito;
use App\Http\Models\Preescolar\Preescolar_materia;
use App\Http\Models\Preescolar\Preescolar_calificacion;
use App\clases\horarios\MetodosHorarios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class GrupoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:grupo',['except' => ['index','show','list','getGrupo','getGrupos', 'getGruposExtracur']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*
        $perActual = Auth::user()->empleado->escuela->departamento->perActual;
        $grupos = Preescolar_grupo::with('preescolar_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')->select('preescolar_grupos.*')
            ->where('preescolar_grupos.periodo_id',$perActual)
            ->where('preescolar_grupos.gpoClave','<>','N');
        $registro = $grupos->first();
        dd($registro);
        */

        /*if ((Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1))
        {
            return View('grupo.show-list-preescolar');

        }
        else
        {*/
            return View('grupo.show-list');
        /*}*/

    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $empleado_id = Auth::user()->empleado->id;
        $perActual = Auth::user()->empleado->escuela->departamento->perActual;
        

        /*if ((Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1))
        {
            $grupos = Preescolar_grupo::with('preescolar_materia','periodo',
                'empleado.persona','plan.programa.escuela.departamento.ubicacion')->select('preescolar_grupos.*')
                ->where('preescolar_grupos.periodo_id',$perActual)
                ->where('preescolar_grupos.gpoClave','<>','N');
        }
        else
            {*/
            $grupos = Grupo::select('grupos.id as grupo_id', 'grupos.gpoSemestre', 'grupos.gpoClave', 'grupos.gpoTurno',
                'grupos.gpoFechaExamenOrdinario', 'grupos.gpoHoraExamenOrdinario', 'grupos.empleado_id',
                'grupos.estado_act',
                'materias.matClave', 'materias.matNombreOficial as matNombre', 'periodos.perNumero', 'periodos.perAnio', 'planes.planClave',
                'programas.id as programa_id', 'programas.progClave', 'programas.progNombre', 'escuelas.escNombre',
                'escuelas.escClave', 'escuelas.id as escuela_id', 'departamentos.depNombre',
                'ubicacion.ubiClave', 'ubicacion.ubiNombre',
                'personas.perApellido1', 'personas.perApellido2', 'personas.perNombre',
                'optativas.optNombre', 'grupos.optativa_id')
                ->join("empleados", "grupos.empleado_id", "=", "empleados.id")
                ->join("personas", "personas.id", "=", "empleados.persona_id")
                ->leftJoin('optativas', 'grupos.optativa_id', '=', 'optativas.id')
                ->join('materias', 'grupos.materia_id', '=', 'materias.id')
                ->join('periodos', 'grupos.periodo_id', '=', 'periodos.id')
                ->join('planes', 'grupos.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->orderBy("grupos.id", "desc");
        /*}*/

        $permisosCarreraId = [];
        if (User::permiso("grupo") == "C") {
            $permisosCarreraId =  Auth::user()->permisos()->get()->map(function ($item, $key) {
                return $item->programa_id;
            })->all();
        }


        /*
        if ((Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1))
        {
            $acciones = '';
            return Datatables::of($grupos)

                ->filterColumn('nombre', function($query, $keyword) {
                    $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
                })
                ->addColumn('nombre', function($query) {
                    return $query->perNombre;
                })
                ->filterColumn('apellido1', function($query, $keyword) {
                    $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
                })
                ->addColumn('apellido1', function($query) {
                    return $query->perApellido1;
                })
                ->filterColumn('apellido2', function($query, $keyword) {
                    $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
                })
                ->addColumn('apellido2', function($query) {
                    return $query->perApellido2;
                })
                ->addColumn('action', function($grupos)
                {
                    
                    $acciones = '<div class="row">
                    <a href="preescolarinscritos/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Alumnos" >
                        <i class="material-icons">assignment_turned_in</i>
                    </a>

                    <a href="preescolarinscritos/calificacionesgrupo/primerreporte/'. $grupos->id.'/1" target="_blank" class="button button--icon js-button js-ripple-effect" title="Primer trimestre" >
                    <i class="material-icons">picture_as_pdf</i>
                </a>
                    </div>';
                    return $acciones;
                })
                ->make(true);
        }
        else
            {*/

                return Datatables::of($grupos)

                    ->filterColumn('nombre', function($query, $keyword) {
                        $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
                    })
                    ->addColumn('nombre', function($query) {
                        return $query->perNombre;
                    })
                    ->filterColumn('apellido1', function($query, $keyword) {
                        $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
                    })
                    ->addColumn('apellido1', function($query) {
                        return $query->perApellido1;
                    })
                    ->filterColumn('apellido2', function($query, $keyword) {
                        $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
                    })
                    ->addColumn('apellido2', function($query) {
                        return $query->perApellido2;
                    })


                    ->addColumn('gpoFechaExamenOrdinario', function($query) {
                        return $query->gpoFechaExamenOrdinario ? Utils::fecha_string($query->gpoFechaExamenOrdinario, 'mesCorto') : '';
                    })
                    ->filterColumn('gpoFechaExamenOrdinario', function($query, $keyword) {
                        $query->whereRaw("DATE_FORMAT(gpoFechaExamenOrdinario,'%d-%m-%Y') like ?", ["%$keyword%"]);
                    })

                    ->addColumn('gpoHoraExamenOrdinario', function($query) {
                        return $query->gpoHoraExamenOrdinario;

                    })


                    ->addColumn('action', function($query) use ($permisosCarreraId) {
                        $btnModificarCalificaciones = "";
                        $btnListaEvalParcial   = "";
                        $btnListaEvalOrdinaria = "";
                        $permiso = User::permiso("grupo");

                        if (in_array($permiso, ['A', 'B']) || ($permiso == "C" && in_array($query->programa_id, $permisosCarreraId))) 
                        {


                                $btnListaEvalParcial = '<form style="display:inline-block;" action="'.url('reporte/listas_evaluacion_parcial/imprimir').'" method="POST" target="_blank">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input name="grupo_id" type="hidden" value="'.$query->grupo_id.'">
                                <button type="submit" style=" background: transparent;
                                border: 0px;
                                color: #0277bd;"  class="button button--icon js-button js-ripple-effect" title="Lista Evaluación Parcial">
                                    <i class="material-icons">picture_as_pdf</i>
                                </button>
                        </form>';
                                $btnListaEvalOrdinaria = '<form style="display:inline-block;" action="'.url('reporte/listas_evaluacion_ordinaria/imprimir').'" method="POST" target="_blank">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input name="grupo_id" type="hidden" value="'.$query->grupo_id.'">
                                <button type="submit" style=" background: transparent;
                                border: 0px;
                                color: #0277bd;"  class="button button--icon js-button js-ripple-effect" title="Lista Evaluación Ordinaria">
                                    <i class="material-icons">picture_as_pdf</i>
                                </button>
                        </form>';

                                $depClaveUsuario = 'SUP';
                                if (Auth::user()->departamento_control_escolar == 1)
                                {
                                   $depClaveUsuario = Auth::user()->empleado->escuela->departamento->depClave;
                                }

                                $btnModificarCalificaciones = '<a href="calificacion/agregar/'
                                    . $depClaveUsuario . '/' . $query->grupo_id . '" class="button button--icon js-button js-ripple-effect" title="Calificaciones">
                            <i class="material-icons">assignment_turned_in</i>
                        </a>';
                        }

                        $btnEditGrupo = "";
                        if ($query->estado_act == "A" || $query->estado_act == "B") {
                            $btnEditGrupo = '<a href="grupo/' . $query->grupo_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>';
                        }

                        return '<a href="grupo/' . $query->grupo_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'

                            .$btnModificarCalificaciones.
                            '<a href="grupo/horario/' . $query->grupo_id . '" class="button button--icon js-button js-ripple-effect" title="Horario">
                    <i class="material-icons">alarm_add</i>
                </a>'
                            . $btnListaEvalParcial
                            . $btnListaEvalOrdinaria
                            . '<form style="display:inline-block; action="reporte/grupo_materia/imprimir" method="POST" style="display:inline;" target="_blank">
                    <input type="hidden" name="grupo_id" value="'. $query->grupo_id .'">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <button type="submit" style=" background: transparent;
                        border: 0px;
                        color: #0277bd;"  class="button button--icon js-button js-ripple-effect" title="Lista asistencia por materia">
                            <i class="material-icons">picture_as_pdf</i>
                        </button>

                </form>'
                            . $btnEditGrupo
                            . '<a href="calificacion/matricula/'
                            . $query->grupo_id
                            . '" class="button button--icon js-button js-ripple-effect" title="Matrículas del grupo">
                    <i class="material-icons">assignment_ind</i>
                </a>
                <a href="#modalGrupoEstado" data-grupo-id="' . $query->grupo_id . '" class="modal-trigger btn-estado-grupo button button--icon js-button js-ripple-effect " title="Cambiar estado">
                        <i class="material-icons">settings</i>
                    </a>
                <form id="delete_' . $query->grupo_id . '" action="grupo/' . $query->grupo_id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $query->grupo_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
                    })
                    ->make(true);
        /* } */


    }

    /**
     * Show user list.
     *
     */
    public function listHorario(Request $request, $id)
    {
        $horario = Horario::with('grupo.materia','aula')->where('grupo_id', $id)->select('horarios.*');

        return Datatables::of($horario)->addColumn('dia', function($horario) {
            return Utils::diaSemana($horario->ghDia);
        })


        ->addColumn('horaInicio', function($horario) {
            return $horario->ghInicio . " : " . $horario->gMinInicio;
        })
        ->addColumn('horaFinal', function($horario) {
            return $horario->ghFinal . " : " . $horario->gMinFinal;
        })

        ->addColumn('materia', function($horario) {
            return $horario->grupo->materia->matClave ."-". $horario->grupo->materia->matNombreOficial;
        })

        ->addColumn('action', function($horario) use ($request) {
            $btnDelete = "";
            if (!$horario->grupo->grupo_equivalente_id) {
                if (!$request->ajax()) {
                    $btnDelete = '<div class="row">
                        <div class="col s1">
                            <a href="'.url('grupo/eliminarHorario/'.$horario->id.'/'.$horario->grupo_id).'" class="button button--icon js-button js-ripple-effect" title="Eliminar horario">
                                <i class="material-icons">delete</i>
                            </a>
                        </div>
                    </row>';
                }

                if ($request->ajax()) {
                    $btnDelete = '<div class="row">
                        <div class="col s1">
                            <a href="'.url('grupo/eliminarHorario/'.$horario->id.'/'.$horario->grupo_id).'" data-grupo-id="'.$horario->grupo_id.'" data-horario-id="'.$horario->id.'"  class="btn-delete-horario button button--icon js-button js-ripple-effect" title="Eliminar horario">
                                <i class="material-icons">delete</i>
                            </a>
                        </div>
                    </row>';
                }
            }

            return $btnDelete;
        })->make(true);
    }


    /**
     * Show user list.
     *
     */
    public function listHorarioAdmin(Request $request)
    {
        $horario = HorarioAdmivo::where('empleado_id', '=', $request->empleado_id)
            ->where('periodo_id', '=', $request->periodo_id)
            ->select("horariosadmivos.id", "horariosadmivos.hadmDia", "horariosadmivos.hadmHoraInicio", "horariosadmivos.hadmFinal", "horariosadmivos.gMinInicio", "horariosadmivos.gMinFinal",
                DB::raw('CONCAT(horariosadmivos.hadmDia, "-", horariosadmivos.hadmHoraInicio, "-", horariosadmivos.hadmFinal) AS sortByDiaHInicioHFinal'))
            ->orderBy("sortByDiaHInicioHFinal");

        return Datatables::of($horario)
            ->addColumn('dia', function($horario) {
                return Utils::diaSemana($horario->hadmDia);
            })

            ->addColumn('horaInicio', function($horario) {
                return $horario->hadmHoraInicio . " : " . $horario->gMinInicio;
            })
            ->addColumn('horaFinal', function($horario) {
                return $horario->hadmFinal . " : " . $horario->gMinFinal;
            })
        ->make(true);
    }

    /**
     * Show user list equivalente.
     *
     */
    public function listEquivalente(Request $request)
    {
        $periodo_id = $request->periodo_id;

        $grupo = Grupo::select("grupos.id as id", "planes.planClave as planClave", "programas.progClave as progClave",
            "materias.matClave as matClave", "materias.matNombreOficial as matNombre", "optativas.optNombre as optNombre",
            "grupos.gpoSemestre as gpoSemestre", "grupos.gpoClave as gpoClave", "grupos.gpoTurno as gpoTurno",
            "grupos.grupo_equivalente_id",
            "periodos.perNumero", "periodos.perAnio")
            ->join("materias", "materias.id", "=", "grupos.materia_id")
            ->join("periodos", "periodos.id", "=", "grupos.periodo_id")
            ->join("planes", "planes.id", "=", "grupos.plan_id")
                ->join("programas", "programas.id", "=", "planes.programa_id")
            ->leftJoin("optativas", "optativas.id", "=", "grupos.optativa_id", "optativas.optNombre")
            ->where("grupos.periodo_id", "=", $periodo_id)
            ->whereNull("grupos.grupo_equivalente_id");


        return Datatables::of($grupo)

            ->filterColumn('gpoSemestre', function($query, $keyword) {
                $query->whereRaw("CONCAT(gpoSemestre, gpoClave, gpoTurno) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('gpoSemestre', function($query) {
                return $query->gpoSemestre . $query->gpoClave . $query->gpoTurno;
            })

            ->addColumn('action', function($grupo) {
                return '<div class="row">
                    <div class="col s1">
                        <button class="btn modal-close" title="Ver" onclick="seleccionarGrupo(' . $grupo->id . ')">
                            <i class="material-icons">done</i>
                        </button>
                    </div>
                </div>';
            })
        ->make(true);
    }

    /**
     * Show grupo.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGrupo(Request $request, $id)
    {
        if ($request->ajax()) {
            $grupo = Grupo::with('materia','empleado.persona','plan.programa','periodo')
            ->find($id);
            return response()->json($grupo);
        }
    }

    /**
     * Show grupos.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGrupos(Request $request, $curso_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            $curso = Curso::with('cgt.periodo.departamento.ubicacion')->find($curso_id);
            $cgt = $curso->cgt;
            $ubicacion = $cgt->periodo->departamento->ubicacion;

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Grupo::select("grupos.id as id", "grupos.gpoSemestre", "grupos.gpoClave", "grupos.gpoTurno",
                "materias.matClave", "materias.matNombreOficial as matNombre", "empleados.id as empleadoId",
                "personas.perNombre", "personas.perApellido1", "personas.perApellido2",'optativas.optNombre')

                ->where('grupos.plan_id', $cgt->plan_id)
                ->where('grupos.periodo_id', $cgt->periodo_id)
                ->where('grupos.gpoExtraCurr', "=", "N")
                
                ->when($ubicacion->ubiClave != "CCH", static function($query) use ($cgt) {
                    return $query->where('gpoSemestre', $cgt->cgtGradoSemestre);
                })


                ->leftJoin("optativas", "optativas.id", "=", "grupos.optativa_id")
                ->join("materias", "materias.id", "=", "grupos.materia_id")

                ->join("empleados", "empleados.id", "=", "grupos.empleado_id")
                ->join("personas", "personas.id", "=", "empleados.persona_id")
            ->get();

            return response()->json($grupos);
        }
    }

    /**
     * Show grupos.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGruposExtracur(Request $request, $curso_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            $curso = Curso::find($curso_id);
            $cgt = Cgt::find($curso->cgt_id);

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Grupo::select("grupos.id as id", "grupos.gpoSemestre", "grupos.gpoClave", "grupos.gpoTurno",
                "materias.matClave", "materias.matNombreOficial as matNombre", "empleados.id as empleadoId",
                "personas.perNombre", "personas.perApellido1", "personas.perApellido2",'optativas.optNombre')

                ->where('grupos.plan_id', $cgt->plan_id)
                ->where('grupos.periodo_id', $cgt->periodo_id)
                ->where('grupos.gpoExtraCurr', "=", "S")

                ->leftJoin("optativas", "optativas.id", "=", "grupos.optativa_id")
                ->join("materias", "materias.id", "=", "grupos.materia_id")

                ->join("empleados", "empleados.id", "=", "grupos.empleado_id")
                ->join("personas", "personas.id", "=", "empleados.persona_id")
            ->get();

            return response()->json($grupos);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::all();
        $empleados = Empleado::with('persona')->where('empEstado','A')->get();
        return view('grupo.create',compact('ubicaciones','empleados'));
    }

    /**
     * Show create horario.
     *
     * @return \Illuminate\Http\Response
     */
    public function horario($id)
    {
        $grupo = Grupo::with('materia', 'empleado.persona', 'plan', 'periodo')->find($id);

        $ubicacion_id = $grupo->plan->programa->escuela->departamento->ubicacion_id;
        $aulas = Aula::where('ubicacion_id', $ubicacion_id)->get();
        $horarios = Horario::with('grupo')->where('grupo_id',$id);
        //VALIDA PERMISOS EN EL PROGRAMA
        // if (Utils::validaPermiso('grupo', $grupo->plan->programa_id)) {
        //     alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(2000);
        //     return redirect('grupo');
        // }



        return view('grupo.horario',compact('grupo','aulas','horarios'));
    }


    /**
     * Delete horario.
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminarHorario(Request $request,$id,$grupo_id)
    {
        $horario = Horario::findOrFail($id);
        $horarios_equivalentes = MetodosHorarios::buscarHorariosEquivalentes($horario);

        if($horarios_equivalentes->isNotEmpty()){
            $horarios_equivalentes->each(static function($horario) {
                $horario->delete();
            });
        }
        $horario->delete();

        if (!$request->ajax()) {
            alert('Escuela Modelo', 'El horario se ha eliminado con éxito','success')->showConfirmButton();
            return redirect('grupo/horario/'.$grupo_id);
        }

        if ($request->ajax()) {
            return response()->json([
                "res" => true
            ]);
        }
    }

    /**
     * Add horario.
     *
     * @return \Illuminate\Http\Response
     */
    public function agregarHorario(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'grupo_id' => 'required',
                'aula_id'  => 'required',
                'ghDia'    => 'required|max:1',
                'ghInicio' => 'required|max:2',
                'ghFinal'  => 'required|max:2',
            ]
        );

        if (!$request->ajax()) {
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }



        $grupo_id = $request->grupo_id;
        $empleado_id = $request->empleado_id;
        $aula_id = $request->aula_id;
        $ghDia = $request->ghDia;

        $ghInicio = $request->ghInicio;
        $gMinInicio = $request->gMinInicio;

        $ghFinal = $request->ghFinal;
        $gMinFinal = $request->gMinFinal;

        $horaMinInicio = $ghInicio . $gMinInicio;
        $horaMinFinal  = $ghFinal . $gMinFinal;

        $peridoId = DB::table("grupos")->select("periodo_id")->where("id", "=", $grupo_id)->first();
        $periodoId = $peridoId->periodo_id;



        if (!$request->ajax()) {
            if ($horaMinFinal <= $horaMinInicio) {
                alert()->error('Ups...', "Horario no valido")->showConfirmButton();
                return back()->withInput();
            }
        }

        if($request->ajax()) {
            if ($horaMinFinal <= $horaMinInicio) {

                return response()->json([
                    "res" => false,
                    "msg" => "Horario no valido"
                ]);
            }
        }


        try {



            Horario::create([
                'grupo_id'      => $grupo_id,
                'aula_id'       => $aula_id,
                'ghDia'         => $request->ghDia,

                'ghInicio'      => $ghInicio,
                'gMinInicio'    => (int) $gMinInicio,

                'ghFinal'       => $ghFinal,
                'gMinFinal'     => (int) $gMinFinal
            ]);


            //COPIAR LOS HORARIOS A LOS GRUPOS HIJOS
            if (!$request->ajax()) {
                $horariosPadre = Horario::where("grupo_id", "=", $grupo_id)->get();


                $gruposHijo = Grupo::where("grupo_equivalente_id", "=", $grupo_id)->get();
                $gruposHijoIds = $gruposHijo->map(function($item, $key) {
                    return $item->id;
                });


                if (count($gruposHijoIds) > 0) {
                    if (Horario::whereIn("grupo_id",  $gruposHijoIds)->first()) {
                        DB::table("horarios")->whereIn("grupo_id",  $gruposHijoIds)->delete();
                    }


                    foreach ($gruposHijoIds as $grupoId) {
                        $nuevosHorarios = collect();
                        foreach ($horariosPadre as $item) {
                            $nuevosHorarios->push([
                                "grupo_id"=> $grupoId,
                                "aula_id" => $item->aula_id,
                                "ghDia"   => $item->ghDia,
                                "ghInicio" => $item->ghInicio,
                                "ghFinal"  => $item->ghFinal,
                                "gMinFinal" => $item->gMinFinal,
                                "gMinInicio" => $item->gMinInicio,
                                "usuario_at" => Auth::user()->id
                            ]);
                        }

                        Horario::insert($nuevosHorarios->all());
                    }
                }
            }


            if($request->ajax()) {
                return response()->json([
                    "res" => true,
                    "msg" => "success"
                ]);
            }

            if (!$request->ajax()) {
                alert('Escuela Modelo', 'El horario se ha creado con éxito', 'success')->showConfirmButton();
                return redirect()->back()->withInput();
            }

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect()->back()->withInput();
        }

    }


    public function verificarHorasRepetidas(Request $request)
    {
        $grupo_id = $request->grupo_id;
        $empleado_id = $request->empleado_id;
        $aula_id = $request->aula_id;
        $ghDia = $request->ghDia;

        $ghInicio = $request->ghInicio;
        $gMinInicio = $request->gMinInicio;

        $ghFinal = $request->ghFinal;
        $gMinFinal = $request->gMinFinal;

        $horaMinInicio = $ghInicio . $gMinInicio;
        $horaMinFinal  = $ghFinal . $gMinFinal;

        $periodoId = Grupo::find($grupo_id)->periodo_id;

        if(!$request->ajax()) {
            if ($horaMinFinal <= $horaMinInicio) {
                alert()->error('Ups...', "Horario no valido")->showConfirmButton();
                return back()->withInput();
            }
        }

        if($request->ajax()) {
            if ($horaMinFinal <= $horaMinInicio) {

                return response()->json([
                    "res" => false,
                    "msg" => "Horario no valido"
                ]);
            }
        }


        //VALIDA SI ESTA DENTRO DE LA FECHA INICIO Y FECHA FINAL DE UN MAESTRO
        $maestroOcupadoAdmin = HorarioAdmivo::where('empleado_id', '=', $empleado_id)
            ->select("periodo_id", "hadmDia", "hadmHoraInicio", "hadmFinal")

            ->where('periodo_id', '=', $periodoId)
            ->where('hadmDia', '=', $ghDia)
            ->where(DB::raw('CONVERT(CONCAT(hadmFinal, gMinFinal), SIGNED)'), '>', (int) $horaMinInicio)
            ->where(DB::raw('CONVERT(CONCAT(hadmHoraInicio, gMinInicio), SIGNED)'), '<', (int) $horaMinFinal)
        ->first();


        //VALIDA SI ESTA DENTRO DE LA FECHA INICIO Y FECHA FINAL DE UN AULA
        $aulaOcupada = Horario::leftJoin("grupos", "horarios.grupo_id", "=", "grupos.id")
            ->leftJoin("aulas", "horarios.aula_id", "=", "aulas.id")
            ->where('grupos.periodo_id', '=', $periodoId)
            ->where('aulas.aula_categoria_id', '=', 1)
            ->where('aula_id', $aula_id)
            ->where('ghDia', '=', $ghDia)
            ->where(DB::raw('CONVERT(CONCAT(ghFinal, gMinFinal), SIGNED)'), '>', (int) $horaMinInicio)
            ->where(DB::raw('CONVERT(CONCAT(ghInicio, gMinInicio), SIGNED)'), '<', (int) $horaMinFinal)
        ->first();

        //VALIDA SI ESTA DENTRO DE LA FECHA INICIO Y FECHA FINAL DE UN MAESTRO
        $maestroOcupado = Horario::leftJoin("grupos", "horarios.grupo_id", "=", "grupos.id")
            ->leftJoin("aulas", "horarios.aula_id", "=", "aulas.id")
            ->where('aulas.aula_categoria_id', '=', 1)
            ->where('aula_id', $aula_id)
            ->where('grupos.empleado_id', '=', $empleado_id)
            ->where('grupos.periodo_id', '=', $periodoId)
            ->where('ghDia', '=', $ghDia)

            ->where(DB::raw('CONVERT(CONCAT(ghFinal, gMinFinal), SIGNED)'), '>', (int) $horaMinInicio)
            ->where(DB::raw('CONVERT(CONCAT(ghInicio, gMinInicio), SIGNED)'), '<', (int) $horaMinFinal)
        ->first();

        if ($aulaOcupada || $maestroOcupado || $maestroOcupadoAdmin) {
            return response()->json([
                "res" => false
            ]);
        }

        return response()->json([
            "res" => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empleadoRequired = 'required';

        $empleado_id                 = $request->empleado_id;
        $empleado_sinodal_id         = Utils::validaEmpty($request->empleado_sinodal_id);
        $gpoFechaExamenOrdinario     = Utils::validaEmpty($request->gpoFechaExamenOrdinario);
        $gpoHoraExamenOrdinario      = Utils::validaEmpty($request->gpoHoraExamenOrdinario);
        if($empleado_sinodal_id == 0 && $empleado_sinodal_id == $empleado_id) {
            $empleado_sinodal_id = null;
        }



        if ($request->grupo_equivalente_id) {
            $empleadoRequired = '';
            $grupoEq = Grupo::where("id", "=", $request->grupo_equivalente_id)->first();

            $empleado_id                 = $grupoEq->empleado_id;
            $empleado_sinodal_id         = Utils::validaEmpty($grupoEq->empleado_sinodal_id);
            $gpoFechaExamenOrdinario     = Utils::validaEmpty($grupoEq->gpoFechaExamenOrdinario);
            $gpoHoraExamenOrdinario      = Utils::validaEmpty($grupoEq->gpoHoraExamenOrdinario);
        }


        $validator = Validator::make($request->all(),
            [
                'periodo_id' => 'required|unique:grupos,periodo_id,NULL,id,materia_id,' .
                    $request->input('materia_id') . ',plan_id,' . $request->input('plan_id') .
                    ',gpoSemestre,' . $request->input('gpoSemestre') . ',gpoClave,' . $request->input('gpoClave') .
                    ',gpoTurno,' . $request->input('gpoTurno') . ',deleted_at,NULL',
                'materia_id'  => 'required',
                'empleado_id' => $empleadoRequired,
                'plan_id'     => 'required',
                'gpoSemestre' => 'required',
                'gpoClave'    => 'required',
                'gpoTurno'    => 'required',
                'gpoFechaExamenOrdinario' => 'required',
                'gpoHoraExamenOrdinario' => 'required',
                'gpoExtraCurr' => 'required',
            ],
            [
                'periodo_id.unique' => "El grupo ya existe",
                'gpoFechaExamenOrdinario.required' => 'El campo fecha de examen ordinario es obligatorio.',
                'gpoHoraExamenOrdinario.required' => 'El campo Hora de examen de ordinario es obligatorio.',
            ]
        );

        $esOptativa = $request->materia_id ? Optativa::where('materia_id', $request->materia_id)->first() : null;
        if($esOptativa && !$request->optativa_id) {
            return response()->json([
                'res' => false,
                'existeGrupo' => false,
                'msg' => [['Necesita elegir una materia optativa específica.']],
            ]);
        }


        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $request->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion ) {
            return response()->json([
                "res" => false,
                "existeGrupo" => false,
                "msg" => ['Por el momento, el módulo se encuentra deshabilitado para este período.']
            ]);
        }


        //VALIDAR SI YA EXISTE EL GRUPO QUE SE ESTA CREANDO
        $grupo = Grupo::with("plan", "periodo", "empleado.persona", "materia")
            ->where("materia_id", "=", $request->materia_id)
            ->where("plan_id", "=", $request->plan_id)
            ->where("gpoSemestre", "=", $request->gpoSemestre)
            ->where("gpoClave", "=", $request->gpoClave)
            ->where("gpoTurno", "=", $request->gpoTurno)
            ->where("periodo_id", "=", $request->periodo_id)
        ->first();



        if(!$request->ajax()) {
            if ($validator->fails()) {
                return redirect ('grupo/create')->withErrors($validator)->withInput();
            }
        }

        if($request->ajax()) {
            if ($validator->fails()) {
                if ($grupo) {
                    return response()->json([
                        "res" => false,
                        "existeGrupo" => true,
                        "msg" => $grupo
                    ]);
                } else {

                    return response()->json([
                        "res" => false,
                        "existeGrupo" => false,
                        "msg" => $validator->errors()->messages()
                    ]);
                }
            }
        }


        $programa_id = $request->input('programa_id');
        if (Utils::validaPermiso('grupo', $programa_id)) {
            return response()->json([
                "res" => false,
                "existeGrupo" => false,
                "msg" => [['No tiene permisos en el programa.']]
            ]);
        }

        DB::beginTransaction();
        try {
            $grupo = Grupo::create([
                'materia_id'                => $request->input('materia_id'),
                'plan_id'                   => $request->input('plan_id'),
                'periodo_id'                => $request->input('periodo_id'),
                'gpoSemestre'               => $request->input('gpoSemestre'),
                'gpoClave'                  => $request->input('gpoClave'),
                'gpoTurno'                  => $request->input('gpoTurno'),
                'empleado_id'               => $empleado_id,
                'empleado_sinodal_id'       => $empleado_sinodal_id,
                'gpoMatClaveComplementaria' => $request->input('gpoMatClaveComplementaria'),
                'gpoFechaExamenOrdinario'   => $gpoFechaExamenOrdinario,
                'gpoHoraExamenOrdinario'    => $gpoHoraExamenOrdinario,
                'gpoCupo'                   => Utils::validaEmpty($request->input('gpoCupo')),
                'gpoNumeroFolio'            => $request->input('gpoNumeroFolio'),
                'gpoNumeroActa'             => $request->input('gpoNumeroActa'),
                'gpoNumeroLibro'            => $request->input('gpoNumeroLibro'),
                'grupo_equivalente_id'      => Utils::validaEmpty($request->input('grupo_equivalente_id')),
                'optativa_id'               => Utils::validaEmpty($request->input('optativa_id')),
                'estado_act'                =>  'A',
                'fecha_mov_ord_act'         => null,
                'clave_actv'                => null,
                'inscritos_gpo'             => 0,
                'nombreAlternativo'         => $request->input('nombreAlternativo'),
                'gpoExtraCurr'              => $request->gpoExtraCurr
            ]);


            //COPIAR HORARIOS DEL GRUPO PADRE (EQUIVALENTE) AL NUEVO GRUPO
            if ($request->grupo_equivalente_id) {
                $horariosPadre = Horario::where("grupo_id", "=", $request->grupo_equivalente_id)->get();
                $nuevosHorarios = collect();
                foreach ($horariosPadre as $item) {
                    $nuevosHorarios->push([
                        "grupo_id"   => $grupo->id,
                        "aula_id"    => $item->aula_id,
                        "ghDia"      => $item->ghDia,
                        "ghInicio"   => $item->ghInicio,
                        "ghFinal"    => $item->ghFinal,
                        "gMinFinal"  => $item->gMinFinal,
                        "gMinInicio" => $item->gMinInicio,
                        "usuario_at" => Auth::user()->id
                    ]);
                }


                Horario::insert($nuevosHorarios->all());
            }

        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            return response()->json([
                "res" => false,
                "existeGrupo" => false,
                "msg" => [['Ha ocurrido un problema.'.$errorCode.'|'.$errorMessage]],
            ]);

        }
        DB::commit(); #TEST
        return response()->json([
            "res"  => true,
            "data" => $grupo
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grupo = Grupo::with('plan','optativa.materia','materia','empleado.persona')->findOrFail($id);
        $sinodal = Empleado::with('persona')->find($grupo->empleado_sinodal_id);
        $grupo_equivalente = Grupo::with('plan','optativa.materia','materia','empleado.persona')->find($grupo->grupo_equivalente_id);



        return view('grupo.show', compact('grupo','sinodal','grupo_equivalente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleados = Empleado::with('persona')->where('empEstado','A')->get();
        $grupo = Grupo::with('plan','optativa.materia','materia','empleado.persona')->findOrFail($id);
        $periodos = Periodo::where('departamento_id',$grupo->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado','escuela')->where('escuela_id',$grupo->plan->programa->escuela_id)->get();
        $planes = Plan::with('programa')->where('programa_id',$grupo->plan->programa->id)->get();


        if (!in_array($grupo->estado_act, ["A", "B"])) {
            alert()->error('Ups...', 'El grupo se encuentra cerrado, no se puede modificar')->showConfirmButton()->autoClose(5000);
            return redirect('grupo');
        }

        $grupo_equivalente = Grupo::with('plan','periodo','optativa.materia','materia','empleado.persona')->find($grupo->grupo_equivalente_id);



        $cgts = Cgt::where([['plan_id', $grupo->plan_id],['periodo_id', $grupo->periodo_id]])->get();
        $materias = Materia::where([['plan_id', '=', $grupo->plan_id],['matSemestre', '=', $grupo->gpoSemestre]])->get();
        $optativas = $grupo->materia->optativas;


        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('grupo',$grupo->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('grupo');
        }


        return view('grupo.edit',compact('grupo','empleados','periodos','programas',
            'planes','cgts','materias','optativas','grupo_equivalente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grupo $grupo)
    {
        $empleadoRequired = 'required';

        $empleado_id                 = $request->empleado_id;
        $empleado_sinodal_id         = $request->empleado_sinodal_id ?: NULL;
        $gpoFechaExamenOrdinario     = $request->gpoFechaExamenOrdinario ?: NULL;
        $gpoHoraExamenOrdinario      = $request->gpoHoraExamenOrdinario ?: NULL;
        if($empleado_sinodal_id == 0 && $empleado_sinodal_id == $empleado_id) {
            $empleado_sinodal_id = null;
        }

        $validator = Validator::make($request->all(),
            [
                'periodo_id'    => 'required',
                'materia_id'    => 'required',
                'empleado_id'   => $empleadoRequired,
                'plan_id'       => 'required',
                'gpoSemestre'   => 'required',
                'gpoClave'      => 'required',
                'gpoTurno'      => 'required'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $grupos_hijos = Grupo::where('grupo_equivalente_id', $grupo->id)->get();

        try {
            $existeRestriccionFecha3 = DB::table("control_estados")->where("periodo_id", "=", $grupo->periodo_id)->where("fecha3", "=", 1)->first();
            if ($existeRestriccionFecha3) {
                alert()->error('Error...', 'Por el momento, el módulo se encuentra deshabilitado para este período.')->showConfirmButton();
                return redirect('grupo');
            }


            //si existe restriccion de modulo
            $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $grupo->periodo_id)->where("fecha1", "=", 1)->first();
            if ($existeRestriccion) {
                $grupo->gpoFechaExamenOrdinario     = $gpoFechaExamenOrdinario;
                $grupo->gpoHoraExamenOrdinario      = $gpoHoraExamenOrdinario;
                $grupo->save();


                if ($grupos_hijos->isNotEmpty()) {
                    Grupo::whereIn("id", $grupos_hijos->pluck('id'))->update([
                        "gpoFechaExamenOrdinario" => $gpoFechaExamenOrdinario,
                        "gpoHoraExamenOrdinario"  => $gpoHoraExamenOrdinario,
                    ]);
                }
            }


            //si elimina equivalente, borrar horarios
            if ($grupo->grupo_equivalente_id && !$request->grupo_equivalente_id) {
                DB::table("horarios")->where("grupo_id", "=", $grupo->id)->delete();
            }

            // si cambia o crea equivalente, borrar horarios y crear los del nuevo padre
            if (($grupo->grupo_equivalente_id != $request->grupo_equivalente_id) && $request->grupo_equivalente_id) {
                DB::table("horarios")->where("grupo_id", "=", $grupo->id)->delete();
                $horariosPadre = Horario::where("grupo_id", "=", $request->grupo_equivalente_id)->get();
                $nuevosHorarios = collect();
                foreach ($horariosPadre as $item) {
                    $nuevosHorarios->push([
                        "grupo_id"   => $grupo->id,
                        "aula_id"    => $item->aula_id,
                        "ghDia"      => $item->ghDia,
                        "ghInicio"   => $item->ghInicio,
                        "ghFinal"    => $item->ghFinal,
                        "gMinFinal"  => $item->gMinFinal,
                        "gMinInicio" => $item->gMinInicio,
                        "usuario_at" => Auth::user()->id
                    ]);
                }
                Horario::insert($nuevosHorarios->all());
            }


            $grupo->empleado_id                 = $empleado_id;
            $grupo->empleado_sinodal_id         = $empleado_sinodal_id;
            $grupo->gpoFechaExamenOrdinario     = $gpoFechaExamenOrdinario;
            $grupo->gpoHoraExamenOrdinario      = $gpoHoraExamenOrdinario;

            $grupo->gpoMatClaveComplementaria   = $request->gpoMatClaveComplementaria;
            $grupo->gpoCupo                     = Utils::validaEmpty($request->gpoCupo);
            $grupo->gpoNumeroFolio              = $request->gpoNumeroFolio;
            $grupo->gpoNumeroActa               = $request->gpoNumeroActa;
            $grupo->gpoNumeroLibro              = $request->gpoNumeroLibro;
            $grupo->grupo_equivalente_id        = Utils::validaEmpty($request->grupo_equivalente_id);
            $grupo->optativa_id                 = Utils::validaEmpty($request->optativa_id);
            $grupo->nombreAlternativo           = $request->nombreAlternativo;
            $grupo->gpoExtraCurr                 = $request->gpoExtraCurr;

            $success = $grupo->save();

            if ($grupos_hijos->isNotEmpty()) {
                Grupo::whereIn("id", $grupos_hijos->pluck('id'))->update([
                    "gpoFechaExamenOrdinario" => $gpoFechaExamenOrdinario,
                    "gpoHoraExamenOrdinario"  => $gpoHoraExamenOrdinario,
                    "empleado_id"             => $empleado_id,
                    "empleado_sinodal_id"     => $empleado_sinodal_id
                ]);
            }

        }catch (QueryException $e){
            alert()->error('Error...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back()->withInput();
        }

        alert('Escuela Modelo', 'El grupo se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
    }

    public function cambiarEstado($id,$estado_act)
    {
        try {
            $grupo = Grupo::findOrFail($id);

            $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $grupo->periodo_id)->where("fecha4", "=", 1)->first();
            if ($existeRestriccion ) {
                alert()->error('Error...', 'Por el momento, el módulo se encuentra deshabilitado para este período.')->showConfirmButton();
                return redirect('grupo');
            }

            $inscritos = Inscrito::where("grupo_id", "=", $id)->get();
            $historicoIds = $inscritos->map(function ($item, $key) {
                return $item->historico_id;
            });


            Historico::whereIn("id", $historicoIds)->delete();
            Inscrito::where("grupo_id", "=", $id)->update([
                "historico_id" => null
            ]);


            $grupo->estado_act = $estado_act;
            $grupo->save();
            alert('Escuela Modelo', 'El grupo se abrio con éxito','success')->showConfirmButton();


            $depClaveUsuario = 'SUP';
            if (Auth::user()->departamento_control_escolar == 1)
            {
               $depClaveUsuario = Auth::user()->empleado->escuela->departamento->depClave;
            }

            return redirect('calificacion/agregar/'.$depClaveUsuario.'/'.$id)->withInput();
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();

            $depClaveUsuario = 'SUP';
            if (Auth::user()->departamento_control_escolar == 1)
            {
               $depClaveUsuario = Auth::user()->empleado->escuela->departamento->depClave;
            }

            return redirect('calificacion/agregar/'.$depClaveUsuario.'/'.$id)->withInput();
        }
    }

    public function infoEstado(Request $request)
    {
        $grupo_id = $request->grupo_id;
        $grupo = Grupo::with("materia", "periodo", "plan.programa")->where("id", $grupo_id)->first();

        return response()->json([
            'matClave'         => $grupo->materia->matClave,
            'matNombre'         => $grupo->materia->matNombreOficial,
            'progClave'         => $grupo->plan->programa->progClave,
            'progNombre'        => $grupo->plan->programa->progNombre,
            'perAnio'           => $grupo->periodo->perAnio,
            'perNumero'         => $grupo->periodo->perNumero,
            'estado_act'          => $grupo->estado_act
        ]);
    }

    public function estadoGrupo(Request $request)
    {
        try {
            $grupo = Grupo::findOrFail($request->grupo_id);
            $grupo->estado_act = $request->estado_act;
            $grupo->save();
            alert('Escuela Modelo', 'El estado del grupo se actualizo con exito','success')->showConfirmButton();

            return redirect('grupo')->withInput();
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();

            return redirect('grupo')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);

        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $grupo->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion ) {
            alert()->error('Error...', 'Por el momento, el módulo se encuentra deshabilitado para este período.')->showConfirmButton();
            return redirect('grupo');
        }


        $gruposHijo = Grupo::where("grupo_equivalente_id", "=", $grupo->id)->get();
        $html = "";

        foreach ($gruposHijo as $gpo) {
            $html .= "\n" . $gpo->materia->matNombreOficial . " " . $gpo->gpoSemestre . $gpo->gpoClave . $gpo->gpoTurno;
        }

        if($grupo->inscritos()->first()) {
            alert('Escuela Modelo', 'No se puede eliminar este grupo porque tiene inscritos.', 'warning')->showConfirmButton();
            return back()->withInput();
        }


        if ($gruposHijo->count() > 0) {
            alert('Escuela Modelo', "No se puede eliminar este grupo porque tiene grupos equivalentes". $html,'warning')->showConfirmButton();

            return redirect()->back()->withInput();
        }

        try {
            if(Utils::validaPermiso('grupo',$grupo->plan->programa_id)){
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                return redirect('grupo');
            }
            if($grupo->delete()){
                alert('Escuela Modelo', 'El grupo se ha eliminado con éxito','success')->showConfirmButton();
            }else{
                alert()->error('Error...', 'No se puedo eliminar el grupo')->showConfirmButton();
            }
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect('grupo');
    }
}
