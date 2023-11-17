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

use App\Http\Models\MatriculaAnterior;

class MatriculaAnteriorController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:matricula_anterior',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('matricula_anterior.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $matricula = MatriculaAnterior::with('alumno.persona','programa','usuario.empleado.persona')->select('matriculasanteriores.*')->latest('matriculasanteriores.created_at');
        return Datatables::of($matricula)->addColumn('action',function($matricula){
            return '<div class="row">
                        <div class="col s1">
                            <a href="matricula_anterior/'.$matricula->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                                <i class="material-icons">visibility</i>
                            </a>
                        </div>
                    </div>';
            })
        ->make(true);
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
        $matricula = MatriculaAnterior::with('alumno.persona','programa','usuario.empleado.persona')->findOrFail($id);
        return view('matricula_anterior.show',compact('matricula'));
    }

}