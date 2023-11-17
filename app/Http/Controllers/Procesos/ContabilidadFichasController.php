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

use App\Http\Models\Escuela;
use App\Http\Models\Ficha;
use App\Http\Models\Empleado;
use App\Models\User;

class ContabilidadFichasController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:fichas',['except' => ['index','show','list','getFichas']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('procesos/contabilidad.show-list-fichas');
    }

    /**
     * Show user list.
     *
     */
    public function list(Request $request)
    {

    $fichas = Ficha::select('fichas.fchNumPer','fichas.fchAnioPer','fichas.fchClaveAlu','fichas.fchClaveCarr','fichas.fchClaveProgAct','fichas.fchGradoSem','fichas.fchGrupo'
    ,'fichas.fchFechaImpr','fichas.fchHoraImpr','users.username','fichas.fchTipo','fichas.fchConc','fichas.fchFechaVenc1','fichas.fhcImp1','fichas.fhcImp1','fichas.fhcRef1'
    ,'fichas.fchFechaVenc2','fichas.fhcImp2','fichas.fhcRef2','fichas.fchEstado','fichas.id')->join('users','fichas.fchUsuaImpr','users.id')->whereNull('users.deleted_at')
    ->whereNull('fichas.deleted_at')
    ->where(function($query) use($request)
    {
        if (!empty($request->fecha_inicial))
        {
            $query->whereNotNull('fichas.fchFechaVenc1')->whereBetween('fichas.fchFechaVenc1',[$request->fecha_inicial,$request->fecha_final]);
        }
        else
        {
            $query->whereNotNull('fichas.fchFechaVenc1')->where('fichas.fchFechaVenc1','>=','2019-10-01');
        }
    });/*
    ->orWhere(function($query)
        {
            $query->whereNotNull('fichas.fchFechaVenc2')->where('fichas.fchFechaVenc2','>=','2019-10-01');
        }
        );*/


        return Datatables::of($fichas)->make(true);

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
