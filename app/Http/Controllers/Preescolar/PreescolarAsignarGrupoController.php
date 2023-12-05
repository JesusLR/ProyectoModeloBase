<?php

namespace App\Http\Controllers\Preescolar;

use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Inscrito;
use App\Models\InscritosRechazados;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Preescolar\Preescolar_grupo;
use App\Models\Preescolar\Preescolar_inscrito;
use App\Models\Prerequisito;
use App\Models\Programa;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PreescolarAsignarGrupoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('preescolar.inscritos.show-list');
    }

    public function list()
    {
        $departamento_sistemas = auth()->user()->departamento_sistemas;

        //PREESCOLAR PERIODO ACTUAL
        $departamentoPre = Departamento::with('ubicacion')->findOrFail(13);
        $perActualPre =  $departamentoPre->perActual;
        $departamentoMat = Departamento::with('ubicacion')->findOrFail(11);
        $perActualMat = $departamentoMat->perActual;

        $inscritos = Preescolar_inscrito::select('preescolar_inscritos.id as inscrito_id', 'alumnos.aluClave', 'personas.perNombre',
        'personas.perApellido1', 'personas.perApellido2', 'preescolar_inscritos.curso_id', 'preescolar_inscritos.preescolar_grupo_id',
        'preescolar_grupos.gpoClave', 'preescolar_grupos.gpoGrado', 'preescolar_grupos.gpoTurno', 'preescolar_materias.matNombre',
        'planes.planClave', 'periodos.perNumero', 'periodos.perAnio', 'programas.progNombre','escuelas.escNombre', 'departamentos.depNombre',
        'departamentos.depClave', 'ubicacion.ubiClave', 'ubicacion.ubiNombre')
        ->join('cursos', 'preescolar_inscritos.curso_id', '=', 'cursos.id')  
        ->join('preescolar_grupos', 'preescolar_inscritos.preescolar_grupo_id', '=', 'preescolar_grupos.id') 
        ->join('preescolar_materias', 'preescolar_grupos.preescolar_materia_id', '=', 'preescolar_materias.id') 
        ->join('planes', 'preescolar_materias.plan_id', '=', 'planes.id')
        ->join('periodos', 'preescolar_grupos.periodo_id', '=', 'periodos.id') 
        ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id') 
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id') 
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id') 
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id') 
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where(static function ($query) use ($departamento_sistemas, $perActualPre, $perActualMat) {

            if ($departamento_sistemas != 1) {
                $query->whereIn('periodos.id', [$perActualPre, $perActualMat]);
            }

        })
        ->latest('preescolar_inscritos.created_at');


        $permisoC = (User::permiso("inscrito") == "C" || User::permiso("inscrito") == "A");
     


        return DataTables::of($inscritos)
            ->filterColumn('nombreCompleto',function($query,$keyword) {
                return $query->whereHas('curso.alumno.persona', function($query) use($keyword) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('nombreCompleto',function($query) {
                return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
            })
            ->addColumn('action',function($query) use ($permisoC) {

                $btnEditar = "";
                $btnCambiarGrupo = "";
                if(auth()->user()->departamento_sistemas == 1){
                    $btnEditar = '<a href="inscritosMateria/' . $query->inscrito_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>';
                }

                if ($permisoC) {
                    $btnCambiarGrupo = '<a href="inscritosMateria/cambiar_grupo/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Cambiar grupo">
                        <i class="material-icons">sync_alt</i>
                    </a>';
                }

                return '<a href="inscritosMateria/' . $query->inscrito_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                .$btnEditar.
                '<form id="delete_' . $query->inscrito_id . '" action="inscritosMateria/' . $query->inscrito_id . '" method="POST" style="display: inline;">
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
        // $ubicaciones = Ubicacion::get();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $departamento = Departamento::select()->findOrFail(13);
        return view('preescolar.inscritos.create',[
            'ubicaciones' => $ubicaciones,
            'departamento' => $departamento
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $grupo = Preescolar_grupo::where("id", "=", $request->grupo_id)->first();

        $validator = Validator::make(
            $request->all(),
            [
                'curso_id' => 'required|unique:preescolar_inscritos,curso_id,NULL,id,preescolar_grupo_id,'.$request->input('grupo_id').',deleted_at,NULL',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );

        if ($validator->fails()) {
            return redirect ()->route('PreescolarInscritos.create')->withErrors($validator)->withInput();
        }

        try {

            $programa_id = $request->input('programa_id');

           //FILTRO EXISTE INSCRITO EN CURSO
            $preescolar_grupo = Preescolar_grupo::where("id", "=", $request->grupo_id)->first();
            // $existeInscritoEnCurso = Preescolar_inscrito::with("preescolar_grupo")
            // ->where("curso_id", "=", $request->curso_id)
            //     ->whereHas('preescolar_grupo', function ($query) use ($preescolar_grupo) {
            //         $query->where('preescolar_materia_id', $preescolar_grupo->preescolar_materia_id);
            //         $query->where('periodo_id', $preescolar_grupo->periodo_id);
            //     })
            //     ->first();

                // if ($existeInscritoEnCurso->IsNotEmpty())
                // {
                    
                //     alert()->error('El alumno ya esta inscrito a ese grupo. Favor de verificar.' )->showConfirmButton();
        
                //     return redirect()->route('inscritos.create')->withInput();
                // }

            //FILTRO TIENE DERECHO A INSCRIBIRSE A GRUPOS
            $ubicacion = Ubicacion::where("id", "=", $request->ubicacion_id)->first();
            $departamento = Departamento::where("id", "=", $request->departamento_id)->first();
            $programa = Programa::where("id", "=", $request->programa_id)->first();
            $cursos = [$request->curso_id];
            $grupo  = $request->grupo_id;

            return $this->inscribirAlumnoPreescolar($request->curso_id, $request->grupo_id);

         
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect()->route('PreescolarInscritos.create')->withInput();
        }

        
    }

    private function inscribirAlumnoPreescolar($curso_id, $grupo_id) {
        $preescolar_inscrito = Preescolar_inscrito::create([
            'curso_id'      => $curso_id,
            'preescolar_grupo_id'      => $grupo_id
        ]);


        if ($preescolar_inscrito) {
            $grupo = Preescolar_grupo::find($grupo_id);
            $grupo->inscritos_gpo = $grupo->inscritos_gpo + 1;
            $grupo->save();

            /*
            Preescolar_calificacion::create([
                'preescolar_inscrito_id'   => $preescolar_inscrito->id
            ]);
            */
        }

        alert('Escuela Modelo', 'Se ha inscrito con éxito', 'success')->showConfirmButton();
        return back();
    }





    // obtener los grupos de preescolar 
    public function getGrupos(Request $request, $curso_id)
    {
        if ($request->ajax()) {
            //CURSO SELECCIONADO
            $curso = Curso::find($curso_id);
            $cgt = Cgt::find($curso->cgt_id);

            //VALIDA EL SEMESTRE DEL CGT Y EL GRUPO
            $grupos = Preescolar_grupo::select("preescolar_grupos.id as id", "preescolar_grupos.gpoGrado", "preescolar_grupos.gpoClave", "preescolar_grupos.gpoTurno",
                "preescolar_materias.matClave", "preescolar_materias.matNombre", "empleados.id as empleadoId",
                "personas.perNombre", "personas.perApellido1", "personas.perApellido2")

                ->where('preescolar_grupos.plan_id', $cgt->plan_id)
                ->where('preescolar_grupos.periodo_id', $cgt->periodo_id)
                ->where('preescolar_grupos.gpoExtraCurr', "=", "N")


                ->join("preescolar_materias", "preescolar_materias.id", "=", "preescolar_grupos.preescolar_materia_id")

                ->join("empleados", "empleados.id", "=", "preescolar_grupos.empleado_id_docente")
                ->join("personas", "personas.id", "=", "empleados.persona_id")
            ->get();

            return response()->json($grupos);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inscrito = Preescolar_inscrito::with('curso.alumno.persona','preescolar_grupo.preescolar_materia')->findOrFail($id);
        return view('preescolar.inscritos.show',compact('inscrito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return $inscrito = Preescolar_inscrito::with('curso.alumno.persona','grupo.materia')->findOrFail($id);
        $inscrito = Preescolar_inscrito::select()->findOrFail($id);
        $periodos = Periodo::where('departamento_id',$inscrito->curso->cgt->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('empleado','escuela')->where('escuela_id',$inscrito->curso->cgt->plan->programa->escuela_id)->get();
        $planes = Plan::with('programa')->where('programa_id',$inscrito->curso->cgt->plan->programa->id)->get();
        $cgts = Cgt::where([['plan_id', $inscrito->curso->cgt->plan_id],['periodo_id', $inscrito->curso->cgt->periodo_id]])->get();
        $cursos = Curso::with('alumno.persona')->where('cgt_id', '=', $inscrito->curso->cgt->id)->get();
        $cgt = $inscrito->curso->cgt;
        $grupos = Preescolar_grupo::with('preescolar_materia', 'empleado.persona', 'plan.programa', 'periodo')
            ->where('gpoGrado', $cgt->cgtGradoSemestre)->where('plan_id',$cgt->plan_id)
            ->where('periodo_id',$cgt->periodo_id)->get();
        // //VALIDA PERMISOS EN EL PROGRAMA

            return view('preescolar.inscritos.edit',compact('inscrito','periodos','programas','planes','cgts','cursos','grupos'));
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'curso_id' => 'required',
                'grupo_id' => 'required'
            ],
            [
                'curso_id.unique' => "El inscrito ya existe",
            ]
        );
        if ($validator->fails()) {
            return redirect('inscritosMateria/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $inscrito = Preescolar_inscrito::findOrFail($id);
                $inscrito->curso_id = $request->input('curso_id');
                $inscrito->preescolar_grupo_id = $request->input('grupo_id');
                $inscrito->save();


                alert('Escuela Modelo', 'El inscrito se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect()->route('PreescolarInscritos.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('inscritosMateria/' . $id . '/edit')->withInput();
            }
        }
    }

    public function cambiarGrupo(Request $request)
    {
        $inscritoId = $request->inscritoId;
        $inscrito = Preescolar_inscrito::where("id", "=", $inscritoId)->first();


        $grupos = Preescolar_grupo::with("preescolar_materia")
            ->where('preescolar_materia_id', "=", $inscrito->preescolar_grupo->preescolar_materia_id)
            ->where("periodo_id", "=", $inscrito->preescolar_grupo->periodo_id)
        ->get();



        return view('preescolar.inscritos.cambiar-grupo', [
            "inscrito" => $inscrito,
            "grupos"   => $grupos
        ]);
    }

    public function postCambiarGrupo (Request $request)
    {
        //grupo nuevo
        $grupoId = $request->gpoId;
        $inscritoId = $request->inscritoId;

        $inscritoActual = Preescolar_inscrito::where("id", "=", $inscritoId)->first();
        $grupoAnteriorId = $inscritoActual->preescolar_grupo->id;


        $inscrito = Preescolar_inscrito::findOrFail($inscritoId);
        $inscrito->preescolar_grupo_id = $request->gpoId;
        
        if ($inscrito->save()) {
            $grupoAnterior = Preescolar_grupo::findOrFail($grupoAnteriorId);
            $grupoAnterior->inscritos_gpo = $grupoAnterior->inscritos_gpo -1;
            $grupoAnterior->save();


            $grupoNuevo = Preescolar_grupo::findOrFail($request->gpoId);
            $grupoNuevo->inscritos_gpo = $grupoNuevo->inscritos_gpo +1;
            $grupoNuevo->save();
        }

        alert('Escuela Modelo', 'El inscrito materia se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prescolar_inscrito = Preescolar_inscrito::findOrFail($id);

        $preescolar_grupo = Preescolar_grupo::find($prescolar_inscrito->preescolar_grupo_id);
        if ($preescolar_grupo->inscritos_gpo > 0) {
            $preescolar_grupo->inscritos_gpo = $preescolar_grupo->inscritos_gpo - 1;
            $preescolar_grupo->save();
        }

        try {
            if ($prescolar_inscrito->delete()) {
                alert('Escuela Modelo', 'El inscrito materia se ha eliminado con éxito','success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el inscrito materia')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect()->route('PreescolarInscritos.index');
    }
}