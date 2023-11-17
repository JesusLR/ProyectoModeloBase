<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Models\Cgt;
use App\Http\Models\Pais;
use App\Http\Models\Plan;
use App\Http\Models\Curso;
use App\Http\Models\Grupo;
use App\Http\Helpers\Utils;
use App\Http\Models\Estado;

use Illuminate\Support\Str;
use App\Http\Models\Periodo;
use Illuminate\Http\Request;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use App\Http\Models\Calificacion;
use App\Http\Models\Departamento;
use Illuminate\Support\Facades\DB;
use App\Http\Models\InscritoExtraCur;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Models\CalificacionExtraCur;


class ExtracurricularController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:estado',['except' => ['index','show','list','getEstados']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view("extracurricular.show-list");
    }

    /**
     * Show list.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
      $inscritos = InscritoExtraCur::select('inscritosextracur.id as inscrito_id','alumnos.aluClave',
        'personas.perNombre','personas.perApellido1','personas.perApellido2','periodos.perNumero',
        'periodos.perAnio','cgt.cgtGradoSemestre','grupos.gpoClave','materias.matNombreOficial as matNombre',
        'planes.planClave',
        'programas.progNombre','escuelas.escNombre','departamentos.depNombre','ubicacion.ubiNombre')
        ->join('cursos', 'inscritosextracur.curso_id', '=', 'cursos.id')
        ->join('grupos', 'inscritosextracur.grupo_id', '=', 'grupos.id')
        ->join('materias', 'grupos.materia_id', '=', 'materias.id')
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
        ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->latest('inscritosextracur.created_at');

      $permisoC = (User::permiso("inscrito") == "C" || User::permiso("inscrito") == "A");


      return Datatables::of($inscritos)
          ->filterColumn('nombreCompleto',function($query,$keyword) {
              return $query->whereHas('curso.alumno.persona', function($query) use($keyword) {
                  $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
              });
          })
          ->addColumn('nombreCompleto',function($query) {
              return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
          })
          ->addColumn('action',function($query) use ($permisoC) {
              $btnCambiarGrupo = "";

              // if ($permisoC) {
              //     $btnCambiarGrupo = '<a href="inscrito/cambiar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Cambiar grupo">
              //         <i class="material-icons">sync_alt</i>
              //     </a>';
              // }

              return '<a href="extracurricular/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                  <i class="material-icons">visibility</i>
              </a>
              <a href="extracurricular/' . $query->inscrito_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                  <i class="material-icons">edit</i>
              </a>
              <form id="delete_' . $query->inscrito_id . '" action="extracurricular/' . $query->inscrito_id . '" method="POST" style="display: inline;">
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="' . csrf_token() . '">
                  <a href="#" data-id="' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                      <i class="material-icons">delete</i>
                  </a>
              </form>'
              . $btnCambiarGrupo;
          })
          ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::get();
        return view('extracurricular.create',compact('ubicaciones'));
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

        $grupo = Grupo::where("id", "=", $request->grupo_id)->first();

        $validator = Validator::make($request->all(),
            [
                'curso_id' => 'required|unique:inscritosextracur,curso_id,NULL,id,grupo_id,'.$request->input('grupo_id').',deleted_at,NULL',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ('extracurricular/create')->withErrors($validator)->withInput();
        }

        try {

            // $programa_id = $request->input('programa_id');
            // if (Utils::validaPermiso('inscrito', $programa_id)) {
            //     alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(2000);
            //     return redirect()->to('extracurricular/create');
            // }


            //FILTRO EXISTE INSCRITO EN CURSO
            $grupo = Grupo::where("id", "=", $request->grupo_id)->first();

            $existeInscritoEnCurso = InscritoExtraCur::with("grupo")
                ->where("curso_id", "=", $request->curso_id)
                ->whereHas('grupo', function($query) use ($grupo) {
                    $query->where('materia_id', $grupo->materia_id);
                    $query->where('periodo_id', $grupo->periodo_id);
                })
            ->first();


            if (!$existeInscritoEnCurso) {
                $this->inscribirAlumno($request->curso_id, $request->grupo_id);
            }

            alert('Escuela Modelo', 'Se ha inscrito con éxito', 'success')->showConfirmButton();
            return back();


        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('inscrito/create')->withInput();
        }
    }

    private function inscribirAlumno($curso_id, $grupo_id) {
      $inscrito = InscritoExtraCur::create([
          'curso_id'      => $curso_id,
          'grupo_id'      => $grupo_id
      ]);


      if ($inscrito) {
          $grupo = Grupo::find($grupo_id);
          $grupo->inscritos_gpo = $grupo->inscritos_gpo + 1;
          $grupo->save();

          CalificacionExtraCur::create([
              'inscrito_id'   => $inscrito->id
          ]);
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
        $inscrito = InscritoExtraCur::with('curso.alumno.persona','grupo.materia')->findOrFail($id);
        return view('extracurricular.show',compact('inscrito'));
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
      $inscrito = InscritoExtraCur::with('curso.alumno.persona','grupo.materia')->findOrFail($id);
      $periodos = Periodo::where('departamento_id',$inscrito->curso->cgt->plan->programa->escuela->departamento_id)->get();
      $programas = Programa::with('empleado','escuela')->where('escuela_id',$inscrito->curso->cgt->plan->programa->escuela_id)->get();
      $planes = Plan::with('programa')->where('programa_id',$inscrito->curso->cgt->plan->programa->id)->get();
      $cgts = Cgt::where([['plan_id', $inscrito->curso->cgt->plan_id],['periodo_id', $inscrito->curso->cgt->periodo_id]])->get();
      $cursos = Curso::with('alumno.persona')->where('cgt_id', '=', $inscrito->curso->cgt->id)->get();
      $cgt = $inscrito->curso->cgt;
      $grupos = Grupo::with('materia', 'empleado.persona', 'plan.programa', 'periodo')
          ->where('gpoSemestre', $cgt->cgtGradoSemestre)->where('plan_id',$cgt->plan_id)
          ->where('periodo_id',$cgt->periodo_id)->get();
      //VALIDA PERMISOS EN EL PROGRAMA
      if(Utils::validaPermiso('inscrito',$inscrito->curso->cgt->plan->programa_id)){
          alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(2000);
          return redirect('inscrito');
      }else{
          return view('extracurricular.edit',compact('inscrito','periodos','programas','planes','cgts','cursos','grupos'));
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
                'curso_id' => 'required',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );
        if ($validator->fails()) {
            return redirect ('extracurricular/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $inscrito = InscritoExtraCur::findOrFail($id);
                $inscrito->curso_id = $request->input('curso_id');
                $inscrito->grupo_id = $request->input('grupo_id');
                $inscrito->save();


                alert('Escuela Modelo', 'El inscrito se ha actualizado con éxito','success')->showConfirmButton();
                return redirect('extracurricular');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
                return redirect('extracurricular/'.$id.'/edit')->withInput();
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
        $inscrito = InscritoExtraCur::findOrFail($id);

        $grupo = Grupo::find($inscrito->grupo_id);
        if ($grupo->inscritos_gpo > 0) {
            $grupo->inscritos_gpo = $grupo->inscritos_gpo - 1;
            $grupo->save();

            CalificacionExtraCur::where("inscrito_id", "=", $inscrito->id)->delete();
        }

        try {
            if(Utils::validaPermiso('inscrito',$inscrito->curso->cgt->plan->programa_id)){
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->showConfirmButton()->autoClose(2000);
                return redirect('extracurricular');
            }
            if ($inscrito->delete()) {
                alert('Escuela Modelo', 'El inscrito se ha eliminado con éxito','success');
            } else {
                alert()->error('Error...', 'No se puedo eliminar el inscrito')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect('extracurricular');
    }

}