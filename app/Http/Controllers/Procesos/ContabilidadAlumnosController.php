<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

use App\Models\Alumno;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\User;

class ContabilidadAlumnosController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:alumno',['except' => ['index','show','list','getAlumnos']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ultimaFechaPago = Carbon::parse(DB::table("view_fecha_ultimo_pago_aplicado")->first()->pagFechaPago)->format('Y-m-d');
        return View('procesos/contabilidad.show-list-alumnos', compact('ultimaFechaPago'));
    }

    /**
     * Show user list.
     *
     */
    public function list(Request $request)
    {
    //     $alumnos = DB::select("SELECT DISTINCT
    //     aluClave as ClavePago,
    //     CONCAT_WS(
    //         ' ',
    //         perApellido1,
    //         perApellido2,
    //         perNombre
    //     ) AS Nombre,
    //     ubiClave as Ubicacion,
    //     progClave as Programa
    // FROM
    //     cursos
    // INNER JOIN cgt ON cursos.cgt_id = cgt.id
    // AND cgt.deleted_at IS NULL
    // INNER JOIN planes ON cgt.plan_id = planes.id
    // AND planes.deleted_at IS NULL
    // INNER JOIN programas ON planes.programa_id = programas.id
    // AND programas.deleted_at IS NULL
    // INNER JOIN escuelas ON programas.escuela_id = escuelas.id
    // AND escuelas.deleted_at IS NULL
    // INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
    // AND departamentos.deleted_at IS NULL
    // INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
    // AND ubicacion.deleted_at IS NULL
    // INNER JOIN alumnos ON cursos.alumno_id = alumnos.id
    // AND alumnos.deleted_at IS NULL
    // INNER JOIN personas ON alumnos.persona_id = personas.id
    // AND personas.deleted_at IS NULL
    // WHERE
    //     cursos.deleted_at IS NULL
    // order by 1,2");
        $alumnos = DB::select("call procContabilidadAlumnos('{$request->fecha_inicial}', '{$request->fecha_final}')");

        return Datatables::of($alumnos)->make(true);
    }

    /**
     * Show escuelas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEscuelas(Request $request, $id)
    {
        if($request->ajax()){
            $escuelas = Escuela::where('departamento_id','=',$id)->get();
            return response()->json($escuelas);
        }
    }


}
