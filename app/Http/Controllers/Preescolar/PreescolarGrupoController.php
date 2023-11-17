<?php

namespace App\Http\Controllers\Preescolar;

use App\clases\departamentos\MetodosDepartamentos;
use App\Http\Models\Escuela;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Cgt;
use App\Http\Models\Empleado;
use App\Http\Models\Horario;
use App\Http\Models\Periodo;
use App\Http\Models\Departamento;
use App\Http\Models\Plan;
use App\Http\Models\Preescolar\Preescolar_grupo;
use App\Http\Models\Preescolar\Preescolar_materia;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PreescolarGrupoController extends Controller
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

        return view('preescolar.grupo.show-list-preescolar');

    }


    public function list()
    {
        //PREESCOLAR PERIODO ACTUAL
        $departamentoPre = Departamento::with('ubicacion')->findOrFail(13);
        $perActualPre =  $departamentoPre->perActual;
        $departamentoMat = Departamento::with('ubicacion')->findOrFail(11);
        $perActualMat = $departamentoMat->perActual;

        $grupos = Preescolar_grupo::with(
            'preescolar_materia',
            'periodo',
            'empleado.persona',
            'plan.programa.escuela.departamento.ubicacion'
        )
        ->select('preescolar_grupos.*')
        ->whereIn('preescolar_grupos.periodo_id', [$perActualPre, $perActualMat])
        ->where('preescolar_grupos.gpoClave', '<>', 'N')
        ->whereNull('preescolar_grupos.deleted_at')
        ->orderBy('preescolar_grupos.id', 'desc');

        //dd($grupos,$perActualPre, $perActualMat);


        $acciones = '';
        return Datatables::of($grupos)

            ->filterColumn('nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre', function ($query) {
                return $query->perNombre;
            })
            ->filterColumn('apellido1', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido1', function ($query) {
                return $query->perApellido1;
            })
            ->filterColumn('apellido2', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido2', function ($query) {
                return $query->perApellido2;
            })
            ->addColumn('action', function ($grupos) {
                $floatAnio = (float)$grupos->periodo->perAnio;

                if($floatAnio >= 2020)
                {
                $acciones = '<div class="row">

                    <a href="preescolarinscritos/' . $grupos->id . '/'.$grupos->preescolar_materia->id.'/'.$grupos->periodo->perAnioPago.'" class="button button--icon js-button js-ripple-effect" title="Alumnos" >
                        <i class="material-icons">assignment_turned_in</i>
                    </a>

                    <a href="' . route('preescolarinscritos.calificacionesgrupo.reporte', ['grupo_id' => $grupos->id, 'trimestre_a_evaluar' => '1']) . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Primer trimestre" >
                    <i class="material-icons">picture_as_pdf</i>
                    </a>

                    <a href="' . route('preescolarinscritos.calificacionesgrupo.reporte', ['grupo_id' => $grupos->id, 'trimestre_a_evaluar' => '2']) . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Segundo trimestre" >
                    <i class="material-icons">picture_as_pdf</i>
                    </a>

                    <a href="' . route('preescolarinscritos.calificacionesgrupo.reporte', ['grupo_id' => $grupos->id, 'trimestre_a_evaluar' => '3']) . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Tercer trimestre" >
                    <i class="material-icons">picture_as_pdf</i>
                    </a>

                    <a href="preescolar_grupo/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>

                    <a href="preescolar_grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>

                    <form id="delete_' . $grupos->id . '" action="preescolar_grupo/' . $grupos->id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $grupos->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    </form>

                    </div>';
                }else{
                    $acciones = '<div class="row">

                    <a href="preescolarinscritos/' . $grupos->id . '/'.$grupos->preescolar_materia->id.'/'.$grupos->periodo->perAnioPago.'" class="button button--icon js-button js-ripple-effect" title="Alumnos" >
                        <i class="material-icons">assignment_turned_in</i>
                    </a>


                    <a href="preescolar_grupo/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>

                    <a href="preescolar_grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>

                    <form id="delete_' . $grupos->id . '" action="preescolar_grupo/' . $grupos->id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $grupos->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    </form>

                    </div>';
                }
                return $acciones;
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
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $empleados = Empleado::with('persona')->where('empEstado','A')->get();
        return view('preescolar.grupo.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados
        ]);
    }


    public function getPreescolarMaterias(Request $request, $semestre, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Preescolar_materia::where([
                ['plan_id', '=', $plan_id],
                ['matSemestre', '=', null]
            ])->get();

            return response()->json($materias);
        }
    }

    public function getDepartamentos(Request $request, $id)
    {
        if($request->ajax()){
            if ((Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1)) {
                $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['PRE','MAT']);
            }

            return response()->json($departamentos);
        }
    }

    public function getEscuelas(Request $request)
    {
        if($request->ajax()){
            $escuelas = Escuela::where('departamento_id','=',$request->id)
                ->where(function($query) use ($request) {
                    $query->orWhere('escNombre', "like", "MATERNAL%");
                    $query->orWhere('escNombre', "like", "PRESCOLAR%");
                })
                ->get();

            return response()->json($escuelas);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empleadoRequired = 'required';

        $empleado_id_docente                 = $request->empleado_id;
        $empleado_id_auxiliar         = Utils::validaEmpty($request->empleado_id_auxiliar);


        if ($request->grupo_equivalente_id) {
            $empleadoRequired = '';
            $grupoEq = Preescolar_grupo::where("id", "=", $request->grupo_equivalente_id)->first();

            $empleado_id_docente                 = $grupoEq->empleado_id;
            $empleado_id_auxiliar         = Utils::validaEmpty($grupoEq->empleado_sinodal_id);
        }


        $validator = Validator::make($request->all(),
            [
                'periodo_id' => 'required|unique:preescolar_grupos,periodo_id,NULL,id,preescolar_materia_id,' .
                    $request->input('materia_id') . ',plan_id,' . $request->input('plan_id') .
                    ',gpoGrado,' . $request->input('gpoSemestre') . ',gpoClave,' . $request->input('gpoClave') .
                    ',gpoTurno,' . $request->input('gpoTurno') . ',deleted_at,NULL',
                'materia_id'  => 'required',
                'empleado_id' => $empleadoRequired,
                'plan_id'     => 'required',
                'gpoSemestre' => 'required',
                'gpoClave'    => 'required',
                'gpoTurno'    => 'required',
                'gpoExtraCurr' => 'required',
            ],
            [
                'periodo_id.unique' => "El grupo ya existe"
            ]
        );

        //VALIDAR SI YA EXISTE EL GRUPO QUE SE ESTA CREANDO
        $grupo = Preescolar_grupo::with("plan", "periodo", "empleado.persona", "preescolar_materia")
            ->where("preescolar_materia_id", "=", $request->materia_id)
            ->where("plan_id", "=", $request->plan_id)
            ->where("gpoGrado", "=", $request->gpoSemestre)
            ->where("gpoClave", "=", $request->gpoClave)
            ->where("gpoTurno", "=", $request->gpoTurno)
            ->where("periodo_id", "=", $request->periodo_id)
        ->first();



        if(!$request->ajax()) {
            if ($validator->fails()) {
                return redirect()->route('preescolar_grupo.create')->withErrors($validator)->withInput();
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


        DB::beginTransaction();
        try {
            $grupo = Preescolar_grupo::create([
                'preescolar_materia_id'                => $request->input('materia_id'),
                'plan_id'                   => $request->input('plan_id'),
                'periodo_id'                => $request->input('periodo_id'),
                'gpoGrado'                  => $request->input('gpoSemestre'),
                'gpoClave'                  => $request->input('gpoClave'),
                'gpoTurno'                  => $request->input('gpoTurno'),
                'empleado_id_docente'       => $empleado_id_docente,
                'empleado_id_auxiliar'      => $empleado_id_auxiliar,
                'gpoMatClaveComplementaria' => $request->input('gpoMatClaveComplementaria'),

                'gpoCupo'                   => Utils::validaEmpty($request->input('gpoCupo')),
                'gpoNumeroFolio'            => $request->input('gpoNumeroFolio'),
                'gpoNumeroActa'             => $request->input('gpoNumeroActa'),
                'gpoNumeroLibro'            => $request->input('gpoNumeroLibro'),
                'grupo_equivalente_id'      => Utils::validaEmpty($request->input('grupo_equivalente_id')),
                'optativa_id'               => null,
                'estado_act'                =>  'A',
                'fecha_mov_ord_act'         => null,
                'clave_actv'                => null,
                'inscritos_gpo'             => 0,
                'nombreAlternativo'         => $request->input('nombreAlternativo'),
                'gpoExtraCurr'              => $request->gpoExtraCurr
            ]);


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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $preescolar_grupo = Preescolar_grupo::with('plan','preescolar_materia','empleado.persona')->findOrFail($id);
        $docente_auxiliar = Empleado::with('persona')->find($preescolar_grupo->empleado_id_auxiliar);
        $grupo_equivalente = Preescolar_grupo::with('plan','preescolar_materia','empleado.persona')->find($preescolar_grupo->grupo_equivalente_id);

        return view('preescolar.grupo.show', [
            'preescolar_grupo' => $preescolar_grupo,
            'docente_auxiliar' => $docente_auxiliar,
            'grupo_equivalente' => $grupo_equivalente
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleados = Empleado::with('persona')->where('empEstado','A')->get();
        $grupo = Preescolar_grupo::with('plan','preescolar_materia','empleado.persona')->findOrFail($id);
        $periodos = Periodo::where('departamento_id',$grupo->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado','escuela')->where('escuela_id',$grupo->plan->programa->escuela_id)->get();
        $planes = Plan::with('programa')->where('programa_id',$grupo->plan->programa->id)->get();


        // if (!in_array($grupo->estado_act, ["A", "B"])) {
        //     alert()->error('Ups...', 'El grupo se encuentra cerrado, no se puede modificar')->showConfirmButton()->autoClose(5000);
        //     return redirect('grupo');
        // }

        $grupo_equivalente = Preescolar_grupo::with('plan','periodo','preescolar_materia','empleado.persona')->find($grupo->grupo_equivalente_id);



        $cgts = Cgt::where([['plan_id', $grupo->plan_id],['periodo_id', $grupo->periodo_id]])->get();
        $materias = Preescolar_materia::where([['plan_id', '=', $grupo->plan_id],['matSemestre', '=', $grupo->gpoGrado]])->get();
        // $optativas = Optativa::where('materia_id', '=', $grupo->materia_id)->get();




        return view('preescolar.grupo.edit',compact('grupo','empleados','periodos','programas',
            'planes','cgts','materias','optativas','grupo_equivalente'));
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
        $empleadoRequired = 'required';

        $empleado_id_docente                 = $request->empleado_id;
        $empleado_id_auxiliar         = Utils::validaEmpty($request->empleado_id_auxiliar);

        $validator = Validator::make($request->all(),
            [
                'periodo_id'    => 'required',
                'materia_id'    => 'required',
                'empleado_id'   => $empleadoRequired,
                'plan_id'       => 'required',
                'gpoSemestre'   => 'required',
                'gpoClave'      => 'required',
                'gpoTurno'      => 'required',
                'gpoCupo'       => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect('preescolar_grupo/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        try {
            $grupo = Preescolar_grupo::findOrFail($id);
            $grupo->empleado_id_docente                 = $empleado_id_docente;
            $grupo->empleado_id_auxiliar         = $empleado_id_auxiliar;
            $grupo->gpoFechaExamenOrdinario     = null;
            $grupo->gpoHoraExamenOrdinario      = null;
            $grupo->gpoMatClaveComplementaria   = $request->gpoMatClaveComplementaria;
            $grupo->gpoCupo                     = Utils::validaEmpty($request->gpoCupo);
            $grupo->gpoNumeroFolio              = $request->gpoNumeroFolio;
            $grupo->gpoNumeroActa               = $request->gpoNumeroActa;
            $grupo->gpoNumeroLibro              = $request->gpoNumeroLibro;
            $grupo->grupo_equivalente_id        = Utils::validaEmpty($request->grupo_equivalente_id);
            // $grupo->optativa_id                 = Utils::validaEmpty($request->optativa_id);
            $grupo->nombreAlternativo           = $request->nombreAlternativo;
            $grupo->gpoExtraCurr                 = $request->gpoExtraCurr;

            $success = $grupo->save();

            alert('Escuela Modelo', 'El grupo se ha actualizado con éxito','success')->showConfirmButton();
            return redirect()->back();
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
            return redirect('preescolar_grupo/'.$id.'/edit')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $preescolar_grupo = Preescolar_grupo::findOrFail($id);
        try {

            if ($preescolar_grupo->delete()) {
                alert('Escuela Modelo', 'El grupo se ha eliminado con éxito', 'success')->showConfirmButton();
                return redirect()->route('preescolar_grupo.index');
            } else {
                alert()->error('Error...', 'No se puedo eliminar el grupo')->showConfirmButton();
                return redirect()->route('preescolar_grupo.index');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }

    }
}
