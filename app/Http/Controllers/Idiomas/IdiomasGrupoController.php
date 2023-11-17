<?php

namespace App\Http\Controllers\Idiomas;

use App\clases\departamentos\MetodosDepartamentos;
use App\Http\Models\Escuela;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Cgt;
use App\Http\Models\Idiomas\Idiomas_empleados;
use App\Http\Models\Horario;
use App\Http\Models\Periodo;
use App\Http\Models\Departamento;
use App\Http\Models\Plan;
use App\Http\Models\Idiomas\Idiomas_grupos;
use App\Http\Models\Idiomas\Idiomas_niveles;
use App\Http\Models\Preescolar\Preescolar_materia;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IdiomasGrupoController extends Controller
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
        return view('idiomas.grupos.show-list');
    }


    public function list()
    {
        $grupos = Idiomas_grupos::select(
            'ubicacion.ubiClave',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.progClave',
            'planes.planClave',
            'idiomas_empleados.id AS empleado_id',
            'idiomas_empleados.empNombre AS nombre',
            'idiomas_empleados.empApellido1 AS apellido1',
            'idiomas_empleados.empApellido2 AS apellido2',
            // 'idiomas_niveles.nivGrado',
            'idiomas_grupos.*'
        )
        ->join('idiomas_empleados', 'idiomas_grupos.idiomas_empleado_id', '=', 'idiomas_empleados.id')
        ->join('periodos', 'idiomas_grupos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        // ->join('idiomas_niveles', 'idiomas_grupos.gpoGrado', '=', 'idiomas_niveles.id')
        ->orderBy('idiomas_grupos.id', 'desc');

        $acciones = '';
        return Datatables::of($grupos)
            ->addColumn('action', function ($grupos) {
                $floatAnio = (float)$grupos->periodo->perAnio;

                if($floatAnio >= 2020)
                {
                    // <a href="idiomas_inscritos/calificacionesgrupo/reporte/' . $grupos->id . '/1" target="_blank" class="button button--icon js-button js-ripple-effect" title="Primer trimestre" >
                    // <i class="material-icons">picture_as_pdf</i>
                    // </a>

                    // <a href="idiomas_inscritos/calificacionesgrupo/reporte/' . $grupos->id . '/2" target="_blank" class="button button--icon js-button js-ripple-effect" title="Segundo trimestre" >
                    // <i class="material-icons">picture_as_pdf</i>
                    // </a>

                    // <a href="idiomas_inscritos/calificacionesgrupo/reporte/' . $grupos->id . '/3" target="_blank" class="button button--icon js-button js-ripple-effect" title="Tercer trimestre" >
                    // <i class="material-icons">picture_as_pdf</i>
                    // </a>
                $acciones = '<div class="row">

                    <a href="idiomas_calificacion/grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Ver/Editar calificaciones" >
                    <i class="material-icons">playlist_add_check</i>
                    </a>

                    <a href="idiomas_grupo/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>

                    <a href="idiomas_grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>

                    <form id="delete_' . $grupos->id . '" action="idiomas_grupo/' . $grupos->id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $grupos->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    </form>

                    </div>';
                }else{
                    $acciones = '<div class="row">
                    
                    <a href="idiomas_calificacion/grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Ver calificaciones" >
                    <i class="material-icons">playlist_add_check</i>
                    </a>

                    <a href="idiomas_grupo/' . $grupos->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>

                    <a href="idiomas_grupo/' . $grupos->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>

                    <form id="delete_' . $grupos->id . '" action="idiomas_grupo/' . $grupos->id . '" method="POST" style="display:inline;">
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
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();
        $empleados = Idiomas_empleados::where('empEstado','A')->get();
        $niveles = Idiomas_niveles::get();
        return view('idiomas.grupos.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados,
            'niveles' => $niveles
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
            if (Auth::user()->idiomas == 1 ) {
                $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['IDI']);
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
        $validator = Validator::make($request->all(),
            [
                'plan_id'        => 'required',
                'periodo_id'     => 'required',
                'nivel_id'       => 'required',
                'gpoClave'       => 'required',
                'gpoDescripcion' => 'required',
                'gpoCupo'        => 'required',
                'empleado_id'    => 'required',
            ]
        );

        //VALIDAR SI YA EXISTE EL GRUPO QUE SE ESTA CREANDO
        $grupo = Idiomas_grupos::where("plan_id", "=", $request->plan_id)
            ->where("periodo_id", "=", $request->periodo_id)
            ->where("gpoGrado", "=", $request->nivel_id)
            ->where("gpoClave", "=", $request->gpoClave)
        ->first();

        if ($grupo) {
            alert('Escuela Modelo', 'El grupo ya ha sido creado anteriormente','warning')->showConfirmButton();
            return redirect()->back();
        }

        if ($validator->fails()) {
            return redirect()->route('idiomas.idiomas_grupo.create')->withErrors($validator)->withInput();
        }

        try {
            Idiomas_grupos::create([
                'plan_id'                => $request->plan_id,
                'periodo_id'             => $request->periodo_id,
                'gpoGrado'               => $request->nivel_id,
                'gpoClave'               => $request->gpoClave,
                'gpoDescripcion'         => $request->gpoDescripcion,
                'gpoCupo'                => $request->gpoCupo,
                'idiomas_empleado_id'    => $request->empleado_id,

                'gpoHoraInicioLunes'     => $request->gpoHoraInicioLunes,
                'gpoHoraFinLunes'        => $request->gpoHoraFinLunes,
                'gpoHoraAulaLunes'       => $request->gpoHoraAulaLunes,

                'gpoHoraInicioMartes'    => $request->gpoHoraInicioMartes,
                'gpoHoraFinMartes'       => $request->gpoHoraFinMartes,
                'gpoHoraAulaMartes'      => $request->gpoHoraAulaMartes,

                'gpoHoraInicioMiercoles' => $request->gpoHoraInicioMiercoles,
                'gpoHoraFinMiercoles'    => $request->gpoHoraFinMiercoles,
                'gpoHoraAulaMiercoles'   => $request->gpoHoraAulaMiercoles,

                'gpoHoraInicioJueves'    => $request->gpoHoraInicioJueves,
                'gpoHoraFinJueves'       => $request->gpoHoraFinJueves,
                'gpoHoraAulaJueves'      => $request->gpoHoraAulaJueves,

                'gpoHoraInicioViernes'   => $request->gpoHoraInicioViernes,
                'gpoHoraFinViernes'      => $request->gpoHoraFinViernes,
                'gpoHoraAulaViernes'     => $request->gpoHoraAulaViernes,

                'gpoHoraInicioSabado'    => $request->gpoHoraInicioSabado,
                'gpoHoraFinSabado'       => $request->gpoHoraFinSabado,
                'gpoHoraAulaSabado'      => $request->gpoHoraAulaSabado,
            ]);

            alert('Escuela Modelo', 'El grupo se ha creado con éxito','success')->showConfirmButton();
            return redirect('idiomas_grupo');

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('idiomas_grupo/create')->withInput();
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
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();
        $empleado = Idiomas_grupos::join('idiomas_empleados', 'idiomas_grupos.idiomas_empleado_id', '=', 'idiomas_empleados.id')->where('idiomas_grupos.id', $id)->first();
        $nivel = Idiomas_grupos::join('idiomas_niveles', 'idiomas_grupos.gpoGrado', '=', 'idiomas_niveles.id')->where('idiomas_grupos.id', $id)->first();
        $grupo = Idiomas_grupos::findOrFail($id);

        return view('idiomas.grupos.show', [
            'ubicaciones' => $ubicaciones,
            'empleado' => $empleado,
            'nivel' => $nivel,
            'grupo' => $grupo
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
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();
        $empleado = Idiomas_grupos::join('idiomas_empleados', 'idiomas_grupos.idiomas_empleado_id', '=', 'idiomas_empleados.id')->where('idiomas_grupos.id', $id)->first();
        $nivel = Idiomas_grupos::leftJoin('idiomas_niveles', 'idiomas_grupos.gpoGrado', '=', 'idiomas_niveles.id')->where('idiomas_grupos.id', $id)->first();
        $grupo = Idiomas_grupos::findOrFail($id);
        $empleados = Idiomas_empleados::where('empEstado','A')->get();

        return view('idiomas.grupos.edit', [
            'ubicaciones' => $ubicaciones,
            'empleado' => $empleado,
            'empleados' => $empleados,
            'nivel' => $nivel,
            'grupo' => $grupo
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
        $validator = Validator::make($request->all(),
            [
                'plan_id'        => 'required',
                'periodo_id'     => 'required',
                'nivel_id'       => 'required',
                'gpoClave'       => 'required',
                'gpoDescripcion' => 'required',
                'gpoCupo'        => 'required',
                'empleado_id'    => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect('idiomas_grupo/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        try {
            $grupo = Idiomas_grupos::findOrFail($id);
            $grupo->update([
                'plan_id'                => $request->plan_id,
                'periodo_id'             => $request->periodo_id,
                'gpoGrado'               => $request->nivel_id,
                'gpoClave'               => $request->gpoClave,
                'gpoDescripcion'         => $request->gpoDescripcion,
                'gpoCupo'                => $request->gpoCupo,
                'idiomas_empleado_id'    => $request->empleado_id,

                'gpoHoraInicioLunes'     => $request->gpoHoraInicioLunes,
                'gpoHoraFinLunes'        => $request->gpoHoraFinLunes,
                'gpoHoraAulaLunes'       => $request->gpoHoraAulaLunes,

                'gpoHoraInicioMartes'    => $request->gpoHoraInicioMartes,
                'gpoHoraFinMartes'       => $request->gpoHoraFinMartes,
                'gpoHoraAulaMartes'      => $request->gpoHoraAulaMartes,

                'gpoHoraInicioMiercoles' => $request->gpoHoraInicioMiercoles,
                'gpoHoraFinMiercoles'    => $request->gpoHoraFinMiercoles,
                'gpoHoraAulaMiercoles'   => $request->gpoHoraAulaMiercoles,

                'gpoHoraInicioJueves'    => $request->gpoHoraInicioJueves,
                'gpoHoraFinJueves'       => $request->gpoHoraFinJueves,
                'gpoHoraAulaJueves'      => $request->gpoHoraAulaJueves,

                'gpoHoraInicioViernes'   => $request->gpoHoraInicioViernes,
                'gpoHoraFinViernes'      => $request->gpoHoraFinViernes,
                'gpoHoraAulaViernes'     => $request->gpoHoraAulaViernes,

                'gpoHoraInicioSabado'    => $request->gpoHoraInicioSabado,
                'gpoHoraFinSabado'       => $request->gpoHoraFinSabado,
                'gpoHoraAulaSabado'      => $request->gpoHoraAulaSabado,
            ]);

            alert('Escuela Modelo', 'El grupo se ha actualizado con éxito','success')->showConfirmButton();
            return redirect()->back();
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
            return redirect('idiomas_grupo/'.$id.'/edit')->withInput();
        }
    }

    public function getGrupos(Request $request, $plan_id,$periodo_id)
    {
        if ($request->ajax()) {
            $grupos = Idiomas_grupos::select('idiomas_grupos.*')
            // ->join('idiomas_niveles', 'idiomas_grupos.gpoGrado', '=', 'idiomas_niveles.id')
            ->where([
                ['idiomas_grupos.plan_id', $plan_id],
                ['idiomas_grupos.periodo_id', $periodo_id]
            ])->get();
            return response()->json($grupos);
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

        $grupo = Idiomas_grupos::findOrFail($id);
        try {

            if ($grupo->delete()) {
                alert('Escuela Modelo', 'El grupo se ha eliminado con éxito', 'success')->showConfirmButton();
                return redirect()->route('idiomas.idiomas_grupo.index');
            } else {
                alert()->error('Error...', 'No se puedo eliminar el grupo')->showConfirmButton();
                return redirect()->route('idiomas.idiomas_grupo.index');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }

    }
}
