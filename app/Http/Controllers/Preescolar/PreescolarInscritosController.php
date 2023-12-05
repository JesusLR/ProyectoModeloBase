<?php

namespace App\Http\Controllers\Preescolar;

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

use App\Models\Grupo;
use App\Models\Curso;
use App\Models\Cgt;
use App\Models\Aula;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\Horario;
use App\Models\Periodo;
use App\Models\Programa;
use App\Models\Plan;
use App\Models\Materia;
use App\Models\Optativa;
use App\Models\Preescolar\Preescolar_grupo;
use App\Models\Preescolar\Preescolar_inscrito;
use App\Models\Preescolar\Preescolar_materia;
use App\Models\Preescolar\Preescolar_calificacion;

class PreescolarInscritosController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permisos:preescolarinscritos',['except' => ['index','list']]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grupo_id = $request->grupo_id;
        $materia_id = $request->materia_id;
        $peraniopago = $request->peraniopago;

        $grupo = Preescolar_grupo::findOrFail($grupo_id);
        $materia = Preescolar_materia::findOrFail($materia_id);


        return View('preescolar.show-list-inscritos', compact('grupo_id', 'materia_id',
            'grupo','materia','peraniopago'));

    }

    /**
     * Show user list.
     *
     */
    public function list($grupo_id)
    {
        $cursos = Curso::select('cursos.id as curso_id',
            'alumnos.aluClave', 'alumnos.id as alumno_id', 'alumnos.aluMatricula', 'personas.perNombre',
            'personas.id as personas_id',
            'personas.perApellido1', 'personas.perApellido2', 'periodos.id as periodo_id',
            'periodos.perNumero', 'periodos.perAnio', 'periodos.perAnioPago','cursos.curEstado',
            'cursos.curTipoIngreso',
            'cgt.cgtGradoSemestre', 'cgt.cgtGrupo', 'planes.id as plan_id', 'planes.planClave',
            'programas.id as programa_id',
            'programas.progNombre', 'programas.progClave',
            'escuelas.escNombre', 'escuelas.escClave',
            'departamentos.depNombre', 'departamentos.depClave',
            'ubicacion.ubiNombre', 'ubicacion.ubiClave',
            'preescolar_grupos.gpoGrado','preescolar_grupos.preescolar_materia_id',
            'preescolar_inscritos.id as inscrito_id',
            'preescolar_inscritos.preescolar_grupo_id',
            'preescolar_grupos.gpoClave')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('preescolar_inscritos', 'cursos.id', '=', 'preescolar_inscritos.curso_id')
            ->join('preescolar_grupos', 'preescolar_inscritos.preescolar_grupo_id', '=', 'preescolar_grupos.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('preescolar_inscritos.preescolar_grupo_id',$grupo_id)
            ->whereIn('departamentos.depClave', ['PRE', 'MAT'])
            ->whereIn('cursos.curEstado', ['R'])
            ->whereNull('preescolar_inscritos.deleted_at')
            ->orderBy("personas.perApellido1", "asc");
            //->latest('cgt.created_at');


        return Datatables::of($cursos)
            ->addColumn('action', function($cursos)
            {

                    /*
                    $acciones = '<div class="row">
                    <a href="preescolarcalificaciones/' . $cursos->inscrito_id . '/'.$cursos->preescolar_grupo_id.'" class="button button--icon js-button js-ripple-effect" title="1er Trimestre" >
                        <i class="material-icons">assignment_turned_in</i>
                    </a>
                    <a href="calificaciones/primerreporte/'.$cursos->inscrito_id.'/'.$cursos->personas_id.'/'.$cursos->gpoGrado.'/'.$cursos->gpoClave.'" target="_blank" class="button button--icon js-button js-ripple-effect" title="1er Trimestre" >
                        <i class="material-icons">picture_as_pdf</i>
                    </a>
                    </div>';
                    */

                if((Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1))
                {
                    $userClave = Auth::user()->username;
                    //HAY QUE QUITARLO PARA QUE SEA CUALQUIER USUARIO DE PREESCOLAR
                    //if( $userClave == "DESARROLLO")
                    //{
                        $acciones = '<div class="row">
                                    <a href="/preescolarcalificaciones/' . $cursos->inscrito_id . '/'.$cursos->preescolar_grupo_id.'/'.$cursos->preescolar_materia_id.'/'.$cursos->perAnioPago.'/1" class="button button--icon js-button js-ripple-effect" title="1er Trimestre" >
                                        <i class="material-icons">looks_one</i>
                                    </a>
                                    <a href="/preescolarinscritos/calificaciones/reporte/'.$cursos->inscrito_id.'/'.$cursos->personas_id.'/'.$cursos->gpoGrado.'/'.$cursos->gpoClave.'/'.$cursos->perAnioPago.'/1" target="_blank" class="button button--icon js-button js-ripple-effect" title="1er Reporte" >
                                        <i class="material-icons">picture_as_pdf</i>
                                    </a>
                                    <a href="/preescolarcalificaciones/' . $cursos->inscrito_id . '/'.$cursos->preescolar_grupo_id.'/'.$cursos->preescolar_materia_id.'/'.$cursos->perAnioPago.'/2" class="button button--icon js-button js-ripple-effect" title="2do Trimestre" >
                                        <i class="material-icons">looks_two</i>
                                    </a>
                                    <a href="/preescolarinscritos/calificaciones/reporte/'.$cursos->inscrito_id.'/'.$cursos->personas_id.'/'.$cursos->gpoGrado.'/'.$cursos->gpoClave.'/'.$cursos->perAnioPago.'/2" target="_blank" class="button button--icon js-button js-ripple-effect" title="2do Reporte" >
                                        <i class="material-icons">picture_as_pdf</i>
                                    </a>
                                    <a href="/preescolarcalificaciones/' . $cursos->inscrito_id . '/'.$cursos->preescolar_grupo_id.'/'.$cursos->preescolar_materia_id.'/'.$cursos->perAnioPago.'/3" class="button button--icon js-button js-ripple-effect" title="3er Trimestre" >
                                        <i class="material-icons">looks_3</i>
                                    </a>
                                    <a href="/preescolarinscritos/calificaciones/reporte/'.$cursos->inscrito_id.'/'.$cursos->personas_id.'/'.$cursos->gpoGrado.'/'.$cursos->gpoClave.'/'.$cursos->perAnioPago.'/3" target="_blank" class="button button--icon js-button js-ripple-effect" title="3er Reporte" >
                                        <i class="material-icons">picture_as_pdf</i>
                                    </a>
                                    </div>';
                    /*
                    }
                    else
                    {
                        $acciones = '<div class="row">
                                    <a href="/preescolarinscritos/calificaciones/reporte/'.$cursos->inscrito_id.'/'.$cursos->personas_id.'/'.$cursos->gpoGrado.'/'.$cursos->gpoClave.'/'.$cursos->perAnioPago.'/1" target="_blank" class="button button--icon js-button js-ripple-effect" title="1er Reporte" >
                                        <i class="material-icons">picture_as_pdf</i>
                                    </a>
                                    <a href="/preescolarinscritos/calificaciones/reporte/'.$cursos->inscrito_id.'/'.$cursos->personas_id.'/'.$cursos->gpoGrado.'/'.$cursos->gpoClave.'/'.$cursos->perAnioPago.'/2" target="_blank" class="button button--icon js-button js-ripple-effect" title="2do Reporte" >
                                        <i class="material-icons">picture_as_pdf</i>
                                    </a>
                                    <a href="/preescolarinscritos/calificaciones/reporte/'.$cursos->inscrito_id.'/'.$cursos->personas_id.'/'.$cursos->gpoGrado.'/'.$cursos->gpoClave.'/'.$cursos->perAnioPago.'/3" target="_blank" class="button button--icon js-button js-ripple-effect" title="3er Reporte" >
                                        <i class="material-icons">picture_as_pdf</i>
                                    </a>
                                    </div>';
                    }
                    */
                }

                return $acciones;
            })
        ->make(true);
    }

}
