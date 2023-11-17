<?php

namespace App\Http\Controllers;

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

use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use App\Http\Models\Departamento;
use App\Models\User;

class PeriodoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:periodo',['except' => ['index','show','list','getPeriodos','getPeriodo','getPeriodosByDepartamento','getPeriodos_afterDate']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('periodo.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $periodos = Periodo::select('periodos.id as periodo_id','periodos.perNumero',
            'periodos.perAnio','periodos.perFechaInicial','periodos.perFechaFinal','periodos.perEstado',
            'departamentos.depClave','ubicacion.ubiClave')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return Datatables::of($periodos)
        ->addColumn('action',function($query) {
            return '<a href="periodo/' . $query->periodo_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="periodo/' . $query->periodo_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
    }

    /**
     * Show periodos.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPeriodos(Request $request, $departamento_id)
    {   
        $fecha = Carbon::now('CDT');

        $departamento = Departamento::where("id", "=", $departamento_id)->first();
        if ($departamento->depClave == "PRE" || 
            $departamento->depClave == "PRI" || 
            $departamento->depClave == "SEC")
        {
                $periodos = Periodo::where('departamento_id',$departamento_id)
                ->where('perAnio', '<=', $fecha->year + 1)
                ->where('perNumero', '=', 0)
                ->orderBy('id', 'desc')->get();
        }
        else
        {
                $periodos = Periodo::where('departamento_id',$departamento_id)
                ->where('perAnio', '<=', $fecha->year + 1)
                ->orderBy('id', 'desc')->get();
        }



        /*
        * Si $request posee una variable llamada 'field'. 
        * retorna un "distinct" de los valores.
        * (creada para selects perNumero o perAnio).
        */
        if($request->field && $request->field == 'perNumero') {
            $periodos = $periodos->sortBy('perNumero')->pluck('perNumero')->unique();
        } elseif ($request->field && $request->field == 'perAnio') {
            $periodos = $periodos->pluck('perAnio')->unique();
        }

        if ($request->ajax()) {
            return response()->json($periodos);
        }
    }

     /**
     * Show periodo.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPeriodo(Request $request, $id)
    {
        $periodo = Periodo::where('id','=',$id)->first();

        if ($request->ajax()) {
            return response()->json($periodo);
        }
    }

    /*
    * Por defecto busca todos los periodos que comienzan después de la fechaActual.
    * Pero se puede especificar una fecha como parámetro en el $request.
    * 
    * Funciona con AJAX Request.
    */
    public function getPeriodos_afterDate(Request $request, $departamento_id) {
        $fecha = Carbon::now('CDT')->format('Y-m-d');

        $departamento = Departamento::find($departamento_id);
        $periodoActual = $departamento->periodoActual;

        if($request->fecha && $request->fecha == 'perActual') {
            $fecha = $periodoActual->perFechaInicial;
        }elseif ($request->fecha) {
            $fecha = Carbon::parse($request->fecha)->format('Y-m-d');
        }

        $periodos = Periodo::where('departamento_id', $departamento_id)
            ->whereDate('perFechaInicial', '>=', $fecha)->get();

        if($request->ajax()) {
            return json_encode($periodos);
        }
    }//getPeriodos_afterDate.


    public function getPeriodosByDepartamento(Request $request)
    {
        // dd($request->departamentoId);
        if ($request->ajax()) {
            $periodos = Periodo::where('departamento_id', '=', $request->departamentoId)->get();
            return response()->json($periodos);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $ubicaciones = Ubicacion::all();
         

            return View('periodo.create',compact('ubicaciones'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('periodo');
        }
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

        $validator = Validator::make($request->all(),
            [
                'departamento_id'   => 'required',
                'perNumero'         => 'required|unique:periodos,perNumero,NULL,id,departamento_id,'.$request->input('departamento_id').',perAnio,'.$request->input('perAnio').',deleted_at,NULL',
                'perAnio'           => 'required',
                'perFechaInicial'   => 'required',
                'perFechaFinal'     => 'required',
                'perAnioPago'       => 'required',
                'perEstado'         => 'required'
            ],
            [
                'perNumero.unique' => "El periodo ya existe",
            ]
        );


        if ($validator->fails()) {
            return redirect ('periodo/create')->withErrors($validator)->withInput();
        }


        try {
            $periodo = Periodo::create([
                'departamento_id'   => $request->input('departamento_id'),
                'perNumero'         => Utils::validaEmpty($request->input('perNumero')),
                'perAnio'           => Utils::validaEmpty($request->input('perAnio')),
                'perFechaInicial'   => $request->input('perFechaInicial'),
                'perFechaFinal'     => $request->input('perFechaFinal'),
                'perEstado'         => $request->input('perEstado'),
                'perAnioPago'       => $request->input('perAnioPago')
            ]);
            alert('Escuela Modelo', 'El Periodo se ha creado con éxito','success')->showConfirmButton();
            return redirect('periodo');
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('periodo/create')->withInput();
        }
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
        $periodo = Periodo::with('departamento')->findOrFail($id);
        return view('periodo.show',compact('periodo'));
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
        if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $periodo = Periodo::with('departamento')->findOrFail($id);
            return view('periodo.edit', compact('periodo'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('periodo');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'perNumero'         => 'required',
                'perAnio'           => 'required',
                'perFechaInicial'   => 'required',
                'perFechaFinal'     => 'required',
                'perEstado'         => 'required',
                'perAnioPago'       => 'required'
            ],
            [
                'perNumero.unique' => "El departamento ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $periodo = Periodo::findOrFail($id);
            $periodo->perNumero         = Utils::validaEmpty($request->input('perNumero'));
            $periodo->perAnio           = Utils::validaEmpty($request->input('perAnio'));
            $periodo->perFechaInicial   = $request->input('perFechaInicial');
            $periodo->perFechaFinal     = $request->input('perFechaFinal');
            $periodo->perEstado         = $request->input('perEstado');
            $periodo->perAnioPago       = $request->input('perAnioPago');

            
            $periodo->save();
            alert('Escuela Modelo', 'El Periodo se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('periodo');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('periodo/' . $id . '/edit')->withInput();
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
        if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $periodo = Periodo::findOrFail($id);
            try {
                if($periodo->delete()){
                    alert('Escuela Modelo', 'El periodo se ha eliminado con éxito','success')->showConfirmButton();
                }else{
                    alert()->error('Error...', 'No se puedo eliminar el periodo')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }
        return redirect('periodo');
    }
}