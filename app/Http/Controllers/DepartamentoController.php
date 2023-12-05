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

use App\Models\Departamento;
use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\User;
use App\clases\departamentos\MetodosDepartamentos;

class DepartamentoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:departamento',['except' => ['index','show','list','getDepartamentos', 'getDepartamentosListaCompleta']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('departamento.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $departamentos = Departamento::select('departamentos.id as departamento_id','departamentos.depClave','departamentos.depNombre','ubicacion.ubiClave')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return Datatables::of($departamentos)->addColumn('action', function($query) {
            return '<a href="departamento/'.$query->departamento_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="departamento/'.$query->departamento_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        }) ->make(true);
    }

     /**
     * Show departamentos.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDepartamentos(Request $request, $id)
    {
        if($request->ajax()){
            // $departamentos = Departamento::with('ubicacion')->where('ubicacion_id','=',$id)
            // ->whereIn('depClave', ['SUP', 'POS'])->get();

            $depClaveUsuario = Auth::user()->empleado->escuela->departamento->depClave;
            $depMAT = 'XXX';
            $depPRE = 'XXX';
            $depPRI = 'XXX';
            $depSEC = 'XXX';
            $depBAC = 'XXX';
            $depSUP = 'XXX';
            $depPOS = 'XXX';
            $depDIP = 'XXX';
            $depIDI = 'XXX';

            if (   (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
                || (Auth::user()->educontinua == 1) )
            {
                $depSUP = 'SUP';
                $depPOS = 'POS';
                $depDIP = 'DIP';
                $depIDI = 'IDI';
            }

            if (Auth::user()->bachiller == 1)
            {
                $depBAC = 'BAC';
            }

            if (Auth::user()->secundaria == 1)
            {
                $depSEC = 'SEC';
            }

            if (Auth::user()->primaria == 1)
            {
                $depPRI = 'PRI';
            }

            if ( (Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1) )
            {
                $depMAT = 'MAT';
                $depPRE = 'PRE';
            }

            $departamentos = null;

            $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id,
                [$depMAT, $depPRE, $depPRI, $depSEC, $depBAC, $depSUP, $depPOS, $depDIP, $depIDI]);

            /*
            switch ($depClaveUsuario)
            {
                case "MAT":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['MAT','PRE']);
                    break;
                case "PRE":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['PRE', 'MAT']);
                    break;
                case "PRI":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['PRI']);
                    break;
                case "SEC":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['SEC']);
                    break;
                case "BAC":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['BAC']);
                    break;
                case "SUP":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['SUP', 'POS', 'DIP']);
                    break;
                case "POS":
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['POS', 'SUP', 'DIP']);
                    break;
                default:
                    $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id, ['DIP', 'POS', 'SUP']);
                    break;
            }
            */

            return response()->json($departamentos);
        }
    }

    /**
    * Muestra la lista completa de departamentos por ubicacion_id.
    */
    public function getDepartamentosListaCompleta(Request $request, $ubicacion_id)
    {
        $departamentos = Departamento::where('ubicacion_id', $ubicacion_id)->get();

        if($request->ajax())
            return response()->json($departamentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("departamento") == "A" || User::permiso("departamento") == "B") {
            $ubicaciones = Ubicacion::all();
            return View('departamento.create',compact('ubicaciones'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('departamento');
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
                'ubicacion_id'      => 'required',
                'depNivel'          => 'required',
                'depClave'          => 'required|unique:departamentos,depClave,NULL,id,ubicacion_id,'.$request->input('ubicacion_id').',deleted_at,NULL',
                'depNombre'         => 'required',
                'depNombreCorto'    => 'required'
            ],
            [
                'depClave.unique' => "El departamento ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('departamento/create')->withErrors($validator)->withInput();
        } else {
            try {
                $departamento = Departamento::create([
                    'ubicacion_id'      => $request->input('ubicacion_id'),
                    'depNivel'          => $request->input('depNivel'),
                    'depClave'          => $request->input('depClave'),
                    'depNombre'         => $request->input('depNombre'),
                    'depNombreCorto'    => $request->input('depNombreCorto'),
                    'depClaveOficial'   => $request->input('depClaveOficial'),
                    'depNombreOficial'  => $request->input('depNombreOficial'),
                    'perAnte'           => $request->input('perAnte'),
                    'perActual'         => $request->input('perActual'),
                    'perSig'            => $request->input('perSig'),
                    'depCalMinAprob'    => Utils::validaEmpty($request->input('depCalMinAprob')),
                    'depCupoGpo'        => Utils::validaEmpty($request->input('depCupoGpo')),
                    'depTituloDoc'      => $request->input('depTituloDoc'),
                    'depNombreDoc'      => $request->input('depNombreDoc'),
                    'depPuestoDoc'      => $request->input('depPuestoDoc'),
                    'depIncorporadoA'   => $request->input('depIncorporadoA')
                ]);
                alert('Escuela Modelo', 'El Departamento se ha creado con éxito','success');
                return redirect('departamento');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('departamento/create')->withInput();
            }
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
        $departamento = Departamento::with('ubicacion')->findOrFail($id);
        return view('departamento.show',compact('departamento'));
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
        if (User::permiso("departamento") == "A" || User::permiso("departamento") == "B") {
            $departamento = Departamento::with('ubicacion')->findOrFail($id);
            $periodos = $departamento->periodos()->latest('perFechaInicial')->get();
            return view('departamento.edit',compact('departamento','periodos'));
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
            return redirect('departamento');
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
                'depNivel'          => 'required',
                'depClave'          => 'required',
                'depNombre'         => 'required',
                'depNombreCorto'    => 'required',
            ],
            [
                'depClave.unique' => "El departamento ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('departamento/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $departamento = Departamento::findOrFail($id);
                $departamento->depNivel         = $request->input('depNivel');
                $departamento->depClave         = $request->input('depClave');
                $departamento->depNombre        = $request->input('depNombre');
                $departamento->depNombreCorto   = $request->input('depNombreCorto');
                $departamento->depClaveOficial  = $request->input('depClaveOficial');
                $departamento->depNombreOficial = $request->input('depNombreOficial');
                $departamento->perAnte          = $request->input('perAnte');
                $departamento->perActual        = $request->input('perActual');
                $departamento->perSig           = $request->input('perSig');
                $departamento->depCalMinAprob   = Utils::validaEmpty($request->input('depCalMinAprob'));
                $departamento->depCupoGpo       = Utils::validaEmpty($request->input('depCupoGpo'));
                $departamento->depTituloDoc     = $request->input('depTituloDoc');
                $departamento->depNombreDoc     = $request->input('depNombreDoc');
                $departamento->depPuestoDoc     = $request->input('depPuestoDoc');
                $departamento->depIncorporadoA  = $request->input('depIncorporadoA');
                $departamento->save();
                alert('Escuela Modelo', 'El Departamento se ha actualizado con éxito','success');
                return redirect('departamento');
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
                return redirect('departamento/'.$id.'/edit')->withInput();
            }
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
        if (User::permiso("departamento") == "A" || User::permiso("departamento") == "B") {
            $departamento = Departamento::findOrFail($id);
            try {
                if($departamento->delete()){
                    alert('Escuela Modelo', 'El departamento se ha eliminado con éxito','success');
                }else{
                    alert()
                    ->error('Error...', 'No se puedo eliminar el departamento')
                    ->showConfirmButton();
                }
            }catch (QueryException $e){
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                ->error('Ups...'.$errorCode,$errorMessage)
                ->showConfirmButton();
            }
        }else{
            alert()
            ->error('Ups...', 'Sin privilegios para esta acción!')
            ->showConfirmButton()
            ->autoClose(5000);
        }
        return redirect('departamento');
    }
}
