<?php

namespace App\Http\Controllers\Alumnos;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Models\Extraordinario;
use App\Models\Departamento;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\PreinscritoExtraordinario;

use App\clases\personas\MetodosPersonas;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

use DB;
use Exception;

class InscribirseExtraordinarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('modulos_alumno.inscribir_extraordinario.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->extraordinarios_id);
        $alumno = Alumno::findOrFail($request->alumno_id);
        $extras = Extraordinario::whereIn('id', $request->extraordinarios_id)->get();

        DB::beginTransaction();
        try {

            $extras->each(static function($extraordinario) use ($alumno) {
                $aluPersona = $alumno->persona;
                $empleado = $extraordinario->empleado;
                $empPersona = $empleado->persona;
                $materia = $extraordinario->materia;
                $plan = $materia->plan;
                $programa = $plan->programa;
                PreinscritoExtraordinario::create([
                    'alumno_id' => $alumno->id,
                    'extraordinario_id' => $extraordinario->id,
                    'empleado_id' => $empleado->id,
                    'materia_id' => $materia->id,
                    'aluClave' => $alumno->aluClave,
                    'aluNombre' => MetodosPersonas::nombreCompleto($aluPersona),
                    'empNombre' => MetodosPersonas::nombreCompleto($empPersona),
                    'ubiClave' => $programa->escuela->departamento->ubicacion->ubiClave,
                    'ubiNombre' => $programa->escuela->departamento->ubicacion->ubiNombre,
                    'progClave' => $programa->progClave,
                    'progNombre' => $programa->progNombre,
                    'matClave' => $materia->matClave,
                    'matNombre' => $materia->matNombre,
                    'extFecha' => $extraordinario->extFecha,
                    'extHora' => $extraordinario->extHora,
                    'extPago' => $extraordinario->extPago,
                    'pexEstado' => 'A'
                ]);
            });
            
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Error', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert()->success('Realizado', 'Registro exitoso!')->showConfirmButton();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function view_datatable($alumno_id) {
        $alumno = Alumno::findOrFail($alumno_id);
        $reprobadas = $this->reprobadas_alumno($alumno)->pluck('materia_id');
        return view('modulos_alumno.inscribir_extraordinario.show-list', compact('alumno', 'reprobadas'));
    }//view_datatable.



    public function list($alumno_id) {
        $alumno = Alumno::findOrFail($alumno_id);
        $curso = $alumno->cursos()->latest()->first();
        $departamento = $curso->periodo->departamento;

        $extraordinarios = Extraordinario::with(['periodo', 'materia.plan.programa.escuela.departamento.ubicacion', 'empleado.persona'])
        ->where('periodo_id', $departamento->periodoActual->id)->get();

        $reprobadas = $this->reprobadas_alumno($alumno);

        if($reprobadas->isNotEmpty()) {
            $extraordinarios = $this->ordenar_reprobadas_primero($reprobadas, $extraordinarios);
        }

        return DataTables::of($extraordinarios)
        ->addIndexColumn()
        ->addColumn('nombreDocente', static function(Extraordinario $extraordinario) {
            $persona = $extraordinario->empleado->persona;
            return MetodosPersonas::nombreCompleto($persona);
        })
        ->addColumn('action', static function(Extraordinario $extraordinario) use ($reprobadas) {

            //Si se encuentra reprobada, se agrega la class "reprobada"
            $esReprobada = $reprobadas->where('materia_id', $extraordinario->materia_id)->first();
            $claseReprobada = $esReprobada ? 'reprobada' : '';

            $checkbox_id = 'extra-'.$extraordinario->id;

            return '<div class="row">
                        <div class="col s1">
                            <input type="checkbox" id="'.$checkbox_id.'" name="" value="'.$extraordinario->id.'" class="check_inscribir '.$claseReprobada.'" data-costo="'.$extraordinario->extPago.'" data-materia-id="'.$extraordinario->materia_id.'">
                            <label for="extra-'.$extraordinario->id.'">inscribirse</label>
                        </div>
                    </div>';
        })->toJson();
    }//list.



    /**
    * Ordena el DataTable para que aparezcan primero los extraordinarios de las materias reprobadas del alumno.
    *
    * @param  Collection  $reprobadas
    * @param Collection $extraordinarios
    * @return Collection
    */
    public function ordenar_reprobadas_primero($reprobadas, $extraordinarios) {

        $extras_ordenados = new Collection;
        $reprobadas->each(static function($item, $key) use ($extraordinarios, $extras_ordenados) {
            $extraordinario = $extraordinarios->where('materia_id', $item->materia_id)->first();
            if($extraordinario) {
                $extras_ordenados->push($extraordinario);
            }
        });

        $extraordinarios->each(static function($item, $key) use ($extras_ordenados) {
            //Si no ha sido agregado, lo agrega a la Collection.
            $agregado = $extras_ordenados->where('materia_id', $item->materia_id)
                    ->where('id', $item->id)->first();
            if(!$agregado) {
                $extras_ordenados->push($item);
            }
        });

        return $extras_ordenados;
    }//ordenar_reprobadas_primero.


    /**
    * devuelve las materias reprobadas del alumno.
    *
    * @param  App\Models\Alumno $alumno
    * @return Collection $reprobadas
    */
    public function reprobadas_alumno($alumno) {

        $aluClave = $alumno->aluClave;
        $reprobadas = DB::select('call procReprobadasAlumno(?)', array($aluClave));
        return collect($reprobadas);
    }//reprobadas_alumno.


}