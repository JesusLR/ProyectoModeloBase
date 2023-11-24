<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_horarios;
use App\Models\Bachiller\Bachiller_horariosadmivos;
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

use App\Models\User;

use App\Models\Empleado;
use App\Models\HorarioAdmivo;
use App\Models\Periodo;
use App\Models\Horario;
use App\Models\Ubicacion;
use Doctrine\DBAL\Driver\PDOConnection;

class BachillerHorariosAdministrativosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:horarios_administrativos', ['except' => ['index','show','list']]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();
        $periodos = Periodo::get();
        $empleados = Bachiller_empleados::where('empEstado', '!=', 'B')->get();

        return view('bachiller.horarios_administrativos_merida.show-list', [

            "ubicaciones" => $ubicaciones,
            "periodos" => $periodos,
            "empleados" => $empleados
        ]);
    }


    /**
     * Show empleado list.
     *
     */

    public function list()
    {
        // $horariosAdmivos = HorarioAdmivo::select(DB::raw("CONCAT(departamentos.id, '-', periodos.id, '-', empleados.id) as id"),
        //     "periodos.perNumero as perNumero", "periodos.perAnio as perAnio",
        //     "empleados.id as empleadoId",  "personas.perNombre as perNombre", "periodos.id as periodoId",
        //     "departamentos.id as departamentoId", "ubicacion.id as ubicacionId",
        //     "personas.perApellido1 as perApellido1", "personas.perApellido2 as perApellido2")

        //     ->leftJoin('periodos', 'periodos.id', '=', 'horariosadmivos.periodo_id')
        //     ->leftJoin('departamentos', 'departamentos.id', '=', 'periodos.departamento_id')
        //     ->leftJoin('ubicacion', 'ubicacion.id', '=', 'departamentos.ubicacion_id')

        //     ->leftJoin("empleados", "empleados.id", "=", "horariosadmivos.empleado_id")
        //     ->leftJoin("personas", "empleados.persona_id", "=", "personas.id")
        //     ->distinct(DB::raw("CONCAT(departamentos.id, '-', periodos.id, '-', empleados.id)"));

        // $horariosAdmivos = DB::table("vw_horasadmin_dep_per_emp");


        $horariosAdmivos = DB::table("view_bachiller_lista_horario_admivo_merida");




        return Datatables::of($horariosAdmivos)
            ->filterColumn('nombreCompleto', function($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombreCompleto', function($query) {
                return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
            })


            ->addColumn('action', function($query) {
                return '<div class="row">
                    <div class="col s1">
                        <a href="bachiller_horarios_administrativos/' . $query->empleado_id . '/' . $query->periodo_id . '/calendario" class="button button--icon js-button js-ripple-effect" title="calendario">
                            <i class="material-icons">calendar_today</i>
                        </a>
                    </div>
                </div>';
            })
        ->make(true);
    }



    /**
     * Show horario administrativo list.
     *
     */
    public function listHorario(Request $request)
    {
        $horario = Bachiller_horariosadmivos::where('periodo_id', $request->periodoId)->where('empleado_id', $request->claveMaestro)
            ->select("bachiller_horariosadmivos.id", "bachiller_horariosadmivos.hadmDia", "bachiller_horariosadmivos.hadmHoraInicio",
                "bachiller_horariosadmivos.hadmFinal", "bachiller_horariosadmivos.gMinInicio", "bachiller_horariosadmivos.gMinFinal",
                DB::raw('CONCAT(bachiller_horariosadmivos.hadmDia, "-", bachiller_horariosadmivos.hadmHoraInicio, "-", bachiller_horariosadmivos.hadmFinal) AS sortByDiaHInicioHFinal'))
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

            ->addColumn('action', function($horario) {
                return '<div class="row">
                    <div class="col s1">
                        <a href="' . url('bachiller_horarios_administrativos/eliminarHorario/' . $horario->id) . '" class="button button--icon js-button js-ripple-effect" title="Eliminar horario">
                            <i class="material-icons">delete</i>
                        </a>
                    </div>
                </div>';
            })
        ->make(true);
    }

    public function listHorarioGpo(Request $request)
    {
        $claveMaestro = $request->claveMaestro;
        $periodoId = $request->periodoId;

        $horariosGrupo = Bachiller_horarios::leftJoin("bachiller_grupos", "bachiller_horarios.grupo_id", "=", "bachiller_grupos.id")
            ->leftJoin("bachiller_materias", "bachiller_grupos.bachiller_materia_id", "=", "bachiller_materias.id")
            ->select("bachiller_horarios.ghDia", "bachiller_horarios.ghInicio", "bachiller_horarios.ghFinal", "bachiller_horarios.gMinInicio", "bachiller_horarios.gMinFinal",
                DB::raw('CONCAT(bachiller_horarios.ghDia, "-", bachiller_horarios.ghInicio, "-", bachiller_horarios.ghFinal) AS sortByDiaHInicioHFinal'),
                "bachiller_materias.matClave","bachiller_materias.matNombreOficial as matNombre")
            ->where('bachiller_grupos.empleado_id_docente', '=', $claveMaestro)
            ->whereNull('grupo_equivalente_id')
            ->where('bachiller_grupos.periodo_id', '=', $periodoId)->orderBy("sortByDiaHInicioHFinal");

            
        return Datatables::of($horariosGrupo)
            ->addColumn('dia', function($horariosGrupo) {
                return Utils::diaSemana($horariosGrupo->ghDia);
            })

            ->addColumn('horaInicio', function($horario) {
                return $horario->ghInicio . " : " . $horario->gMinInicio;
            })
            ->addColumn('horaFinal', function($horario) {
                return $horario->ghFinal . " : " . $horario->gMinFinal;
            })
            ->addColumn('materia', function($horario) {
                return $horario->matClave . "-" . $horario->matNombre;
            })
        ->make(true);
    }

    public function horariosAdministrativos(Request $request)
    {
        $claveMaestro = $request->claveMaestro;
        $periodoId = $request->periodoId;

        $horariosGrupo = Bachiller_horarios::leftJoin("bachiller_grupos", "bachiller_horarios.grupo_id", "=", "bachiller_grupos.id")
            ->where('bachiller_grupos.empleado_id_docente', '=', $claveMaestro)
            ->whereNull('grupo_equivalente_id')
            ->where('bachiller_grupos.periodo_id', '=', $periodoId)
        ->get();

        $ghInicio = $horariosGrupo->sum("ghInicio");
        $ghFinal = $horariosGrupo->sum("ghFinal");
        $totalHorasMaestro = $ghFinal - $ghInicio;

        $horariosAdmin = Bachiller_horariosadmivos::where("periodo_id", $periodoId)->where("empleado_id", $claveMaestro)->get();
        $ghInicioAdmin = $horariosAdmin->sum("hadmHoraInicio");
        $ghFinalAdmin = $horariosAdmin->sum("hadmFinal");
        $totalHorasAdmivo = $ghFinalAdmin - $ghInicioAdmin;

        $totalHorasLaborales = $totalHorasMaestro + $totalHorasAdmivo;

        $maestro = Bachiller_empleados::where("bachiller_empleados.id", "=", $claveMaestro)->first();
        $periodo = Periodo::with("departamento.ubicacion")->where("id", "=", $periodoId)->first();
        // $grupo = Grupo::with("plan.programa.escuela")->where("id", "=", $grupoId)->first();

        return view("bachiller.horarios_administrativos_merida.horarios", [
            "claveMaestro" => $claveMaestro,
            "periodoId"    => $periodoId,
            "maestro"      => $maestro,
            "periodo"      => $periodo,
            // "grupo"        => $grupo,
            "totalHorasMaestro"   => $totalHorasMaestro,
            "totalHorasAdmivo"    => $totalHorasAdmivo,
            "totalHorasLaborales" => $totalHorasLaborales
        ]);
    }



    //POST EDIT
    public function agregarHorarios(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'empleado_id' => 'required',
            'periodo_id'  => 'required',
            'ghDia'       => 'required|max:1',
            'ghInicio'    => 'required|max:2',
            'ghFinal'     => 'required|max:2',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $empleadoId = $request->empleado_id;
        $periodoId = $request->periodo_id;
        $ghDia = $request->ghDia;

        $ghInicio   = $request->ghInicio;
        $gMinInicio = $request->gMinInicio;

        $ghFinal   = $request->ghFinal;
        $gMinFinal = $request->gMinFinal;

        $horaMinInicio = $ghInicio . $gMinInicio;
        $horaMinFinal  = $ghFinal . $gMinFinal;

        if ($horaMinFinal <= $horaMinInicio) {
            alert()->error('Ups...', "Horario no valido")->showConfirmButton();
            return back()->withInput();
        }

        //VALIDA SI ESTA DENTRO DE LA FECHA INICIO Y FECHA FINAL DE UN MAESTRO
        $maestroOcupadoAdmin = Bachiller_horariosadmivos::where('empleado_id', '=', $empleadoId)
            ->select("periodo_id", "hadmDia", "hadmHoraInicio", "hadmFinal")
            ->where('periodo_id', '=', $periodoId)
            ->where('hadmDia', '=', $ghDia)
            ->where(DB::raw('CONVERT(CONCAT(hadmFinal, gMinFinal), SIGNED)'), '>', (int) $horaMinInicio)
            ->where(DB::raw('CONVERT(CONCAT(hadmHoraInicio, gMinInicio), SIGNED)'), '<', (int) $horaMinFinal)
        ->first();


        //VALIDA SI ESTA DENTRO DE LA FECHA INICIO Y FECHA FINAL DE UN MAESTRO
        $maestroOcupadoGpo = Bachiller_horarios::leftJoin("bachiller_grupos", "bachiller_horarios.grupo_id", "=", "bachiller_grupos.id")
            ->where('bachiller_grupos.empleado_id_docente', '=', $empleadoId)
            ->where('bachiller_grupos.periodo_id', '=', $periodoId)
            ->where('bachiller_horarios.ghDia', '=', $ghDia)
            // ->where('ghFinal', '>', $ghInicio)
            // ->where('ghInicio', '<', $ghFinal)
            ->where(DB::raw('CONVERT(CONCAT(ghFinal, gMinFinal), SIGNED)'), '>', (int) $horaMinInicio)
            ->where(DB::raw('CONVERT(CONCAT(ghInicio, gMinInicio), SIGNED)'), '<', (int) $horaMinFinal)
        ->first();



        if ($maestroOcupadoAdmin || $maestroOcupadoGpo) {
            alert()->error('Ups...', "Horario de maestro no disponible")->showConfirmButton();
            return back()->withInput();
        }

        try {
            Bachiller_horariosadmivos::create([
                'periodo_id'     => $periodoId,
                'empleado_id'    => $empleadoId,
                'hadmDia'        => $ghDia,

                'hadmHoraInicio' => $ghInicio,
                'gMinInicio'     => (int) $gMinInicio,

                'hadmFinal'      => $ghFinal,
                'gMinFinal'      => (int) $gMinFinal

            ]);

            return back()->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();

            return back()->withInput();
        }
    }

    /**
     * Delete horario.
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminarHorario(Request $request)
    {
        $id = $request->id;
        $horario = Bachiller_horariosadmivos::findOrFail($id);
        $horario->delete();

        return back();
    }
}
