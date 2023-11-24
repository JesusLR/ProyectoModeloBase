<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Validator;
use Debugbar;

use App\Models\Beca;
use App\Models\Ubicacion;
use App\Models\User;

class BecaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('permisos:beca',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('beca.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $becas = Beca::select('becas.id as id','becas.bcaClave','becas.bcaNombre','becas.bcaNombreCorto','becas.bcaVigencia');

        return Datatables::of($becas)->addColumn('action',function($query) {
            return '<a href="beca/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="beca/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("beca") == "A" || User::permiso("beca") == "B") {
            $ubicaciones = Ubicacion::all();
            return View('beca.create',compact('ubicaciones'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('beca');
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

        if (!(User::permiso("beca") == "A" || User::permiso("beca") == "B")) {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('beca');
        }

        $validator = Validator::make($request->all(),
            [
                'bcaClave'       => 'required|unique:becas',
                'bcaNombre'      => 'required',
                'bcaNombreCorto' => 'required',
                'bcaVigencia'    => 'required'
            ],
            [
                'bcaClave.unique' => "La clave de Beca ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('beca/create')->withErrors($validator)->withInput();
        } else {
            // $programa_id = $request->input('programa_id');
            // if (Utils::validaPermiso('beca',$programa_id)) {
            //     alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            //     return redirect()->to('beca/create');
            // }

            try {
                $beca = Beca::create([
                    'bcaClave'       => $request->input('bcaClave'),
                    'bcaNombre'      => $request->input('bcaNombre'),
                    'bcaNombreCorto' => $request->input('bcaNombreCorto'),
                    'bcaVigencia'    => $request->input('bcaVigencia')
                ]);
                alert('Escuela Modelo', 'La Beca se ha creado con éxito','success')->showConfirmButton();
                return redirect('beca');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('beca/create')->withInput();
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

        if (!(User::permiso("beca") == "A" || User::permiso("beca") == "B")) {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('beca');
        }


        $beca = Beca::findOrFail($id);
        return view('beca.show',compact('beca'));
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
        if (User::permiso("beca") == "A" || User::permiso("beca") == "B") {
            $beca = Beca::findOrFail($id);
            return view('beca.edit', compact('beca'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('beca');
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

        
        if (!(User::permiso("beca") == "A" || User::permiso("beca") == "B")) {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('beca');
        }

        $validator = Validator::make($request->all(),
            [
                'bcaClave'       => 'required',
                'bcaNombre'      => 'required',
                'bcaNombreCorto' => 'required',
                'bcaVigencia'    => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect('beca/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            // $programa_id = $request->input('programa_id');
            // if (Utils::validaPermiso('beca',$programa_id)) {
            //     alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            //     return redirect()->to('beca/' . $id . '/edit');
            // }
            try {
                $beca = Beca::findOrFail($id);
                $beca->bcaClave       = $request->input('bcaClave');
                $beca->bcaNombre      = $request->input('bcaNombre');
                $beca->bcaNombreCorto = $request->input('bcaNombreCorto');
                $beca->bcaVigencia    = $request->input('bcaVigencia');
                $beca->save();
                alert('Escuela Modelo', 'La beca se ha actualizado con éxito','success')->showConfirmButton();
                return redirect('beca');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
                return redirect('beca/'.$id.'/edit')->withInput();
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
        if (User::permiso("beca") == "A" || User::permiso("beca") == "B") {
            $beca = Beca::findOrFail($id);

            try {
                if ($beca->delete()) {
                    alert('Escuela Modelo', 'La beca se ha eliminado con éxito','success');
                } else {
                    alert()->error('Error...', 'No se puedo eliminar la beca')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode    = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            }
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }
        return redirect('beca');
    }
}