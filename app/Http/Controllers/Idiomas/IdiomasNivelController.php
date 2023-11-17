<?php

namespace App\Http\Controllers\Idiomas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Idiomas\Idiomas_niveles;
use App\Http\Models\Programa;
use App\Http\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Auth;

class IdiomasNivelController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('idiomas.niveles.show-list');
    }

    /**
     * Show level list.
     *
     */
    public function list()
    {
        $niveles = Idiomas_niveles::select(
            'idiomas_niveles.id AS id',
            'programas.progClave AS progClave',
            'planes.planClave AS planClave',
            'idiomas_niveles.nivGrado AS nivGrado',
            'idiomas_niveles.nivDescripcion AS nivDescripcion',
            'idiomas_niveles.nivPorcentajeReporte1 AS nivPorcentajeReporte1',
            'idiomas_niveles.nivPorcentajeReporte2 AS nivPorcentajeReporte2',
            'idiomas_niveles.nivPorcentajeMidterm AS nivPorcentajeMidterm',
            'idiomas_niveles.nivPorcentajeProyecto1 AS nivPorcentajeProyecto1',
            'idiomas_niveles.nivPorcentajeReporte3 AS nivPorcentajeReporte3',
            'idiomas_niveles.nivPorcentajeReporte4 AS nivPorcentajeReporte4',
            'idiomas_niveles.nivPorcentajeFinal AS nivPorcentajeFinal',
            'idiomas_niveles.nivPorcentajeProyecto2 AS nivPorcentajeProyecto2')
        ->join('planes', 'idiomas_niveles.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id');


        return DataTables::of($niveles)
        ->addColumn('action',function($query) {
            return '<a href="idiomas_nivel/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="idiomas_nivel/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            <form id="delete_' . $query->id . '" action="idiomas_nivel/' . $query->id . '" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
            </form>';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $programas = Programa::select('programas.id','programas.progNombre','programas.progClave')
                ->where('programas.progClave', 'ING')
                ->orWhere('programas.progClave', 'INI')
                ->get();

            return view('idiomas.niveles.create', compact('programas'));
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        //     return redirect('idiomas_nivel');
        // }
    }

    public function getPlanes($id)
    {
        $planes = Plan::select('id', 'planClave')
            ->where('programa_id', $id)
            ->get();
        return response()->json($planes);
    }

    public function getNiveles($id)
    {
        $niveles = Idiomas_niveles::select('id', 'nivGrado', 'nivDescripcion')
            ->where('plan_id', $id)
            ->get();
        return response()->json($niveles);
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
                'plan_id'                => 'required',
                'nivGrado'               => 'required',
                'nivDescripcion'         => 'required',
                'nivPorcentajeReporte1'  => 'required|min:0|numeric',
                'nivPorcentajeReporte2'  => 'required|min:0|numeric',
                'nivPorcentajeMidterm'   => 'required|min:0|numeric',
                'nivPorcentajeProyecto1' => 'required|min:0|numeric',
                'nivPorcentajeReporte3'  => 'required|min:0|numeric',
                'nivPorcentajeReporte4'  => 'required|min:0|numeric',
                'nivPorcentajeFinal'     => 'required|min:0|numeric',
                'nivPorcentajeProyecto2' => 'required|min:0|numeric',
            ]
        );


        if ($validator->fails()) {
            return redirect ('idiomas_nivel/create')->withErrors($validator)->withInput();
        }

        if ($this->sum($request) > 100) {
            alert()->error('La suma de los campos debe ser menor a 100')->showConfirmButton();
            return redirect('idiomas_nivel/create')->withInput();
        }
        if ($this->sum($request) <= 0) {
            alert()->error('La suma de los campos debe ser mayor a 0')->showConfirmButton();
            return redirect('idiomas_nivel/create')->withInput();
        }


        try {
            Idiomas_niveles::create([
                'plan_id'                => $request->input('plan_id'),
                'nivGrado'               => $request->input('nivGrado'),
                'nivDescripcion'         => $request->input('nivDescripcion'),
                'nivPorcentajeReporte1'  => $request->input('nivPorcentajeReporte1'),
                'nivPorcentajeReporte2'  => $request->input('nivPorcentajeReporte2'),
                'nivPorcentajeMidterm'   => $request->input('nivPorcentajeMidterm'),
                'nivPorcentajeProyecto1' => $request->input('nivPorcentajeProyecto1'),
                'nivPorcentajeReporte3' => $request->input('nivPorcentajeReporte3'),
                'nivPorcentajeReporte4' => $request->input('nivPorcentajeReporte4'),
                'nivPorcentajeFinal' => $request->input('nivPorcentajeFinal'),
                'nivPorcentajeProyecto2' => $request->input('nivPorcentajeProyecto2')
            ]);
            alert('Escuela Modelo', 'El nivel se ha creado con éxito','success')->showConfirmButton();
            return redirect('idiomas_nivel');
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('idiomas_nivel/create')->withInput();
        }
    }

    public function sum ($request)
    {
        return $request->input('nivPorcentajeReporte1') + $request->input('nivPorcentajeReporte2') + $request->input('nivPorcentajeMidterm') + 
        $request->input('nivPorcentajeProyecto1') + $request->input('nivPorcentajeReporte3') + $request->input('nivPorcentajeReporte4') + 
        $request->input('nivPorcentajeFinal') + $request->input('nivPorcentajeProyecto2');
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
        $nivel = Idiomas_niveles::select(
            'idiomas_niveles.id AS id',
            'programas.progClave AS progClave',
            'planes.planClave AS planClave',
            'idiomas_niveles.nivGrado AS nivGrado',
            'idiomas_niveles.nivDescripcion AS nivDescripcion',
            'idiomas_niveles.nivPorcentajeReporte1 AS nivPorcentajeReporte1',
            'idiomas_niveles.nivPorcentajeReporte2 AS nivPorcentajeReporte2',
            'idiomas_niveles.nivPorcentajeMidterm AS nivPorcentajeMidterm',
            'idiomas_niveles.nivPorcentajeProyecto1 AS nivPorcentajeProyecto1',
            'idiomas_niveles.nivPorcentajeReporte3 AS nivPorcentajeReporte3',
            'idiomas_niveles.nivPorcentajeReporte4 AS nivPorcentajeReporte4',
            'idiomas_niveles.nivPorcentajeFinal AS nivPorcentajeFinal',
            'idiomas_niveles.nivPorcentajeProyecto2 AS nivPorcentajeProyecto2')
        ->join('planes', 'idiomas_niveles.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->where('idiomas_niveles.id', $id)
        ->first();

        return view('idiomas.niveles.show', [
            'nivel' => $nivel
        ]);
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
        // if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $nivel = Idiomas_niveles::select(
                'idiomas_niveles.id AS id',
                'programas.id AS programa_id',
                'programas.progClave AS progClave',
                'planes.id AS plan_id',
                'planes.planClave AS planClave',
                'idiomas_niveles.nivGrado AS nivGrado',
                'idiomas_niveles.nivDescripcion AS nivDescripcion',
                'idiomas_niveles.nivPorcentajeReporte1 AS nivPorcentajeReporte1',
                'idiomas_niveles.nivPorcentajeReporte2 AS nivPorcentajeReporte2',
                'idiomas_niveles.nivPorcentajeMidterm AS nivPorcentajeMidterm',
                'idiomas_niveles.nivPorcentajeProyecto1 AS nivPorcentajeProyecto1',
                'idiomas_niveles.nivPorcentajeReporte3 AS nivPorcentajeReporte3',
                'idiomas_niveles.nivPorcentajeReporte4 AS nivPorcentajeReporte4',
                'idiomas_niveles.nivPorcentajeFinal AS nivPorcentajeFinal',
                'idiomas_niveles.nivPorcentajeProyecto2 AS nivPorcentajeProyecto2')
            ->join('planes', 'idiomas_niveles.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('idiomas_niveles.id', $id)
            ->first();

            $programas = Programa::select('programas.id','programas.progNombre','programas.progClave')
                ->where('programas.progClave', 'ING')
                ->orWhere('programas.progClave', 'INI')
                ->get();

            $planes = Plan::select('id', 'planClave')
            ->where('programa_id', $nivel->programa_id)
            ->get();

            return view('idiomas.niveles.edit', [
                'nivel' => $nivel,
                'programas' => $programas,
                'planes' => $planes
            ]);
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        //     return redirect('idiomas_nivel');
        // }
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
                'plan_id'                => 'required',
                'nivGrado'               => 'required',
                'nivDescripcion'         => 'required',
                'nivPorcentajeReporte1'  => 'required|min:0|numeric',
                'nivPorcentajeReporte2'  => 'required|min:0|numeric',
                'nivPorcentajeMidterm'   => 'required|min:0|numeric',
                'nivPorcentajeProyecto1' => 'required|min:0|numeric',
                'nivPorcentajeReporte3'  => 'required|min:0|numeric',
                'nivPorcentajeReporte4'  => 'required|min:0|numeric',
                'nivPorcentajeFinal'     => 'required|min:0|numeric',
                'nivPorcentajeProyecto2' => 'required|min:0|numeric',
            ]
        );


        if ($validator->fails()) {
            return redirect ('idiomas_nivel/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        if ($this->sum($request) > 100) {
            alert()->error('La suma de los campos debe ser menor a 100')->showConfirmButton();
            return redirect('idiomas_nivel/' . $id . '/edit')->withInput();
        }
        if ($this->sum($request) <= 0) {
            alert()->error('La suma de los campos debe ser mayor a 0')->showConfirmButton();
            return redirect('idiomas_nivel/' . $id . '/edit')->withInput();
        }

        try {
            
            $nivel = Idiomas_niveles::findOrFail($id);
            $nivel->update([
                'plan_id'                => $request->input('plan_id'),
                'nivGrado'               => $request->input('nivGrado'),
                'nivDescripcion'         => $request->input('nivDescripcion'),
                'nivPorcentajeReporte1'  => $request->input('nivPorcentajeReporte1'),
                'nivPorcentajeReporte2'  => $request->input('nivPorcentajeReporte2'),
                'nivPorcentajeMidterm'   => $request->input('nivPorcentajeMidterm'),
                'nivPorcentajeProyecto1' => $request->input('nivPorcentajeProyecto1'),
                'nivPorcentajeReporte3' => $request->input('nivPorcentajeReporte3'),
                'nivPorcentajeReporte4' => $request->input('nivPorcentajeReporte4'),
                'nivPorcentajeFinal' => $request->input('nivPorcentajeFinal'),
                'nivPorcentajeProyecto2' => $request->input('nivPorcentajeProyecto2')
            ]);
            alert('Escuela Modelo', 'El nivel se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('idiomas_nivel');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('idiomas_nivel/' . $id . '/edit')->withInput();
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
        // if (User::permiso("periodo") == "A" || User::permiso("periodo") == "B") {
            $nivel = Idiomas_niveles::findOrFail($id);
            try {
                if($nivel->delete()){
                    alert('Escuela Modelo', 'El nivel se ha eliminado con éxito','success')->showConfirmButton();
                }else{
                    alert()->error('Error...', 'No se puedo eliminar el nivel')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        // }
        return redirect('idiomas_nivel');
    }
}