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


use App\Models\Escuela;
use App\Models\Referencia;
use App\Models\Empleado;
use App\Models\User;

class ContabilidadReferenciasController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:referencias',['except' => ['index','show','list','getReferencias']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('procesos/contabilidad.show-list-referencias');
    }

    /**
     * Show user list.
     *
     */
    public function list(Request $request)
    {

$referencias = DB::table('view_referencias')->select('view_referencias.aluClave','view_referencias.refNum','view_referencias.refAnioPer','view_referencias.progClave','view_referencias.refConcPago'
,'view_referencias.refFechaVenc','view_referencias.refImpTotal','view_referencias.refImpConc','view_referencias.refImpBeca','view_referencias.refImpPP','view_referencias.refImpAntCred'
,'view_referencias.refImpRecar','view_referencias.usu_gen_ref','view_referencias.fecha_imp','view_referencias.hora_imp','view_referencias.refUsuarioAplico',
'view_referencias.refFechaAplico','view_referencias.refHoraAplico','view_referencias.refEstado')
->where(function($query) use($request)
{
    if(!empty($request->fecha_inicial))
    {
            $query->whereNotNull('view_referencias.refFechaAplico')->whereBetween('view_referencias.refFechaAplico',[$request->fecha_inicial,$request->fecha_final]);
    }
    else {
            $query->whereNotNull('view_referencias.refFechaAplico')->where('view_referencias.refFechaAplico','>=','2019-10-01');
    }
});


        return Datatables::of($referencias)->make(true);
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
