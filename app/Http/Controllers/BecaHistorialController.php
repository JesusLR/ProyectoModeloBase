<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Curso;
use App\Models\BecaHistorial;

use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class BecaHistorialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lista_cursos()
    {
        return view('becas_historial.show-list');
    }

    public function cursos(Request $request)
    {
        $cursos = Curso::select('cursos.id AS curso_id', 'alumnos.id AS alumno_id', 'alumnos.aluClave',
            DB::raw("CONCAT_WS(' ', personas.perApellido1, personas.perApellido2, personas.perNombre) AS nombreCompleto"),
            'cgt.cgtGradoSemestre', 'cgt.cgtGrupo', 'planes.planClave', 'programas.progClave', 
            'periodos.perNumero', 'periodos.perAnio', 'departamentos.depClave', 'ubicacion.ubiClave'
        )
        ->has('becas_historial')
        ->join('alumnos', 'alumnos.id', 'cursos.alumno_id')
        ->join('becas_historial', 'becas_historial.curso_id', 'cursos.id')
        ->join('personas', 'personas.id', 'alumnos.persona_id')
        ->join('cgt', 'cgt.id', 'cursos.cgt_id')
        ->join('planes', 'planes.id', 'cgt.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('periodos', 'periodos.id', 'cursos.periodo_id')
        ->join('departamentos', 'departamentos.id', 'periodos.departamento_id')
        ->join('ubicacion', 'ubicacion.id', 'departamentos.ubicacion_id');

        return DataTables::of($cursos)
        ->addColumn('action', static function($query) {

            return '<div class="row">
                        <div class="col s1">
                            <a href="' . url('becas_historial/cursos/' . $query->curso_id) . '" class="button button--icon js-button js-ripple-effect" title="Lista de cambios">
                            <i class="material-icons">assignment</i>
                            </a>
                        </div>
                    </div>';
        })->make(true);
    }

    public function historial(Curso $curso) 
    {
        return view('becas_historial.historial', compact('curso'));
    }

    public function list(Request $request)
    {
        $historial = BecaHistorial::with('usuario')
        ->where(static function($query) use ($request) {
            if($request->curso_id)
                $query->where('curso_id', $request->curso_id);
        })
        ->latest();

        return DataTables::of($historial)
        ->filterColumn('usuario', static function($query, $keyword) {
            return $query->whereHas('usuario', static function($query) use ($keyword) {
                return $query->where('username', $keyword);
            });
        })
        ->addColumn('usuario', static function(BecaHistorial $beca_historial) {
            return $beca_historial->usuario->username;
        })
        ->make(true);
    }
}
