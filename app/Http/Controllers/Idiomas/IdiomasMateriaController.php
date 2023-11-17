<?php

namespace App\Http\Controllers\Idiomas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Idiomas\Idiomas_materias;
use App\Http\Models\Programa;
use App\Http\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Auth;

class IdiomasMateriaController extends Controller
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
        return view('idiomas.materias.show-list');
    }

    /**
     * Show level list.
     *
     */
    public function list()
    {
        $materias = Idiomas_materias::select(
            'idiomas_materias.id AS id',
            'programas.progClave AS progClave',
            'planes.planClave AS planClave',
            'idiomas_materias.matClave AS matClave',
            'idiomas_materias.matNombre AS matNombre',
            'idiomas_materias.matNombreCorto AS matNombreCorto',
            'idiomas_materias.matSemestre AS matSemestre',
            'idiomas_materias.matCreditos AS matCreditos',
            'idiomas_materias.matClasificacion AS matClasificacion',
            'idiomas_materias.matTipoAcreditacion AS matTipoAcreditacion',
            'idiomas_materias.matPorcentajeParcial AS matPorcentajeParcial',
            'idiomas_materias.matPorcentajeOrdinario AS matPorcentajeOrdinario',
            'idiomas_materias.matPrerequisitos AS matPrerequisitos')
        ->join('planes', 'idiomas_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->where('plan_id', '!=', '0');


        return DataTables::of($materias)
        ->addColumn('action',function($query) {
            return '<a href="idiomas_materia/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="idiomas_materia/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            <form id="delete_' . $query->id . '" action="idiomas_materia/' . $query->id . '" method="POST" style="display:inline;">
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

            return view('idiomas.materias.create', compact('programas'));
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        //     return redirect('idiomas_materia');
        // }
    }

    public function getPlanes($id)
    {
        $planes = Plan::select('id', 'planClave')
            ->where('programa_id', $id)
            ->get();
        return response()->json($planes);
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
                'matClave'               => 'required',
                'matNombre'              => 'required',
                'matNombreCorto'         => 'required',
                'matSemestre'            => 'required',
                'matCreditos'            => 'required',
                'matClasificacion'       => 'required',
                'matTipoAcreditacion'    => 'required',
                'matPorcentajeParcial'   => 'required|min:0|numeric',
                'matPorcentajeOrdinario' => 'required|min:0|numeric',
            ]
        );

        if ($validator->fails()) {
            return redirect ('idiomas_materia/create')->withErrors($validator)->withInput();
        }

        try {
            Idiomas_materias::create([
                'plan_id'                => $request->input('plan_id'),
                'matClave'               => $request->input('matClave'),
                'matNombre'              => $request->input('matNombre'),
                'matNombreCorto'         => $request->input('matNombreCorto'),
                'matSemestre'            => $request->input('matSemestre'),
                'matCreditos'            => $request->input('matCreditos'),
                'matClasificacion'       => $request->input('matClasificacion'),
                'matTipoAcreditacion'    => $request->input('matTipoAcreditacion'),
                'matPorcentajeParcial'   => $request->input('matPorcentajeParcial'),
                'matPorcentajeOrdinario' => $request->input('matPorcentajeOrdinario')
            ]);
            alert('Escuela Modelo', 'La materia se ha creado con éxito','success')->showConfirmButton();
            return redirect('idiomas_materia');
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return redirect('idiomas_materia/create')->withInput();
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
        $materia = Idiomas_materias::select(
            'idiomas_materias.id AS id',
            'programas.progClave AS progClave',
            'planes.planClave AS planClave',
            'idiomas_materias.matClave AS matClave',
            'idiomas_materias.matNombre AS matNombre',
            'idiomas_materias.matNombreCorto AS matNombreCorto',
            'idiomas_materias.matSemestre AS matSemestre',
            'idiomas_materias.matCreditos AS matCreditos',
            'idiomas_materias.matClasificacion AS matClasificacion',
            'idiomas_materias.matTipoAcreditacion AS matTipoAcreditacion',
            'idiomas_materias.matPorcentajeParcial AS matPorcentajeParcial',
            'idiomas_materias.matPorcentajeOrdinario AS matPorcentajeOrdinario')
        ->join('planes', 'idiomas_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->where('idiomas_materias.id', $id)
        ->first();

        return view('idiomas.materias.show', [
            'materia' => $materia
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
            $materia = Idiomas_materias::select(
                'idiomas_materias.id AS id',
                'programas.id AS programa_id',
                'programas.progClave AS progClave',
                'planes.id AS plan_id',
                'planes.planClave AS planClave',
                'idiomas_materias.matClave AS matClave',
                'idiomas_materias.matNombre AS matNombre',
                'idiomas_materias.matNombreCorto AS matNombreCorto',
                'idiomas_materias.matSemestre AS matSemestre',
                'idiomas_materias.matCreditos AS matCreditos',
                'idiomas_materias.matClasificacion AS matClasificacion',
                'idiomas_materias.matTipoAcreditacion AS matTipoAcreditacion',
                'idiomas_materias.matPorcentajeParcial AS matPorcentajeParcial',
                'idiomas_materias.matPorcentajeOrdinario AS matPorcentajeOrdinario')
            ->join('planes', 'idiomas_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('idiomas_materias.id', $id)
            ->first();

            $programas = Programa::select('programas.id','programas.progNombre','programas.progClave')
                ->where('programas.progClave', 'ING')
                ->orWhere('programas.progClave', 'INI')
                ->get();

            $planes = Plan::select('id', 'planClave')
            ->where('programa_id', $materia->programa_id)
            ->get();

            // dd($materia->programa_id);

            return view('idiomas.materias.edit', [
                'materia' => $materia,
                'programas' => $programas,
                'planes' => $planes
            ]);
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        //     return redirect('idiomas_materia');
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
                'matClave'               => 'required',
                'matNombre'              => 'required',
                'matNombreCorto'         => 'required',
                'matSemestre'            => 'required',
                'matCreditos'            => 'required',
                'matClasificacion'       => 'required',
                'matTipoAcreditacion'    => 'required',
                'matPorcentajeParcial'   => 'required|min:0|numeric',
                'matPorcentajeOrdinario' => 'required|min:0|numeric',
            ]
        );

        if ($validator->fails()) {
            return redirect ('idiomas_materia/' . $id . '/edit')->withErrors($validator)->withInput();
        }

        try {
            
            $materia = Idiomas_materias::findOrFail($id);
            $materia->update([
                'plan_id'                => $request->input('plan_id'),
                'matClave'               => $request->input('matClave'),
                'matNombre'              => $request->input('matNombre'),
                'matNombreCorto'         => $request->input('matNombreCorto'),
                'matSemestre'            => $request->input('matSemestre'),
                'matCreditos'            => $request->input('matCreditos'),
                'matClasificacion'       => $request->input('matClasificacion'),
                'matTipoAcreditacion'    => $request->input('matTipoAcreditacion'),
                'matPorcentajeParcial'   => $request->input('matPorcentajeParcial'),
                'matPorcentajeOrdinario' => $request->input('matPorcentajeOrdinario')
            ]);
            alert('Escuela Modelo', 'La materia se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('idiomas_materia');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('idiomas_materia/' . $id . '/edit')->withInput();
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
            $materia = Idiomas_materias::findOrFail($id);
            try {
                if($materia->delete()){
                    alert('Escuela Modelo', 'La materia se ha eliminado con éxito','success')->showConfirmButton();
                }else{
                    alert()->error('Error...', 'No se puedo eliminar la materia')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
        // } else {
        //     alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        // }
        return redirect('idiomas_materia');
    }
}