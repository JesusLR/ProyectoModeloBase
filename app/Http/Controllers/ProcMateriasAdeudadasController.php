<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Alumno;
use DB;
use Yajra\DataTables\Facades\DataTables;

class ProcMateriasAdeudadasController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function vista() {
    	return view('procMateriasAdeudadas.show-alumnos');
    }

    public function alumno(Alumno $alumno) {
    	return view('procMateriasAdeudadas.show-list', compact('alumno'));
    }

    public function alumnos()
    {
    	$alumnos = Alumno::with('persona')->select('alumnos.*')
    	->where('aluEstado', 'R')
    	->latest('alumnos.created_at');

    	return DataTables::of($alumnos)
    	->addColumn('action', static function($alumno) {
    		return '<div class="row">
    					<a href="procMateriasAdeudadas/alumnos/' . $alumno->id . '" class="button button--icon js-button js-ripple-effect" title="Materias adeudadas">
		                    <i class="material-icons">visibility</i>
		                </a>
    				</div>';
    	})
    	->make(true);
    }

    public function list(Alumno $alumno) {

    	// $aluClave = 13113151;
	    $reprobadas = DB::select("call procMateriasAdeudadas('', '', '', '', '', '',
	    '{$alumno->aluClave}', '', '', '', '', '', '', '', '', 'N')");

	    return DataTables::of($reprobadas)->make(true);
    }
}
