<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Primaria\Primaria_materia;
use App\Http\Models\Primaria\Primaria_materias_asignaturas;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PrimariaMateriasAsignaturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('primaria.materias_asignaturas.show-list');
    }

    public function list()
    {
        $primaria_materias_asignaturas = Primaria_materias_asignaturas::select(
            'primaria_materias_asignaturas.id',
            'primaria_materias.matNombre',
            'planes.planClave',
            'periodos.perAnioPago',
            'primaria_materias_asignaturas.matClaveAsignatura',
            'primaria_materias_asignaturas.matNombreAsignatura',
            'primaria_materias_asignaturas.matAsignaturaPorcentaje',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
        ->join('primaria_materias', 'primaria_materias_asignaturas.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('planes', 'primaria_materias_asignaturas.plan_id', '=', 'planes.id')
        ->join('periodos', 'primaria_materias_asignaturas.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id');



        return DataTables::of($primaria_materias_asignaturas)

        ->filterColumn('ubicacion_clave', function ($query, $keyword) {
            $query->whereRaw("CONCAT(ubiClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubicacion_clave', function ($query) {
            return $query->ubiClave;
        })

        ->filterColumn('departamento', function ($query, $keyword) {
            $query->whereRaw("CONCAT(depNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('departamento', function ($query) {
            return $query->depNombre;
        })

        ->filterColumn('escuela', function ($query, $keyword) {
            $query->whereRaw("CONCAT(escNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('escuela', function ($query) {
            return $query->escNombre;
        })

        ->filterColumn('programa', function ($query, $keyword) {
            $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('programa', function ($query) {
            return $query->progNombre;
        })

        ->filterColumn('materia', function ($query, $keyword) {
            $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('materia', function ($query) {
            return $query->matNombre;
        })

        ->filterColumn('plan', function ($query, $keyword) {
            $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('plan', function ($query) {
            return $query->planClave;
        })

        ->filterColumn('anio', function ($query, $keyword) {
            $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('anio', function ($query) {
            return $query->perAnioPago;
        })

        ->filterColumn('clave_asignatura', function ($query, $keyword) {
            $query->whereRaw("CONCAT(matClaveAsignatura) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('clave_asignatura', function ($query) {
            return $query->matClaveAsignatura;
        })

        ->filterColumn('nombre_asignatura', function ($query, $keyword) {
            $query->whereRaw("CONCAT(matNombreAsignatura) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('nombre_asignatura', function ($query) {
            return $query->matNombreAsignatura;
        })

        ->filterColumn('porcentaje', function ($query, $keyword) {
            $query->whereRaw("CONCAT(matAsignaturaPorcentaje) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('porcentaje', function ($query) {
            return $query->matAsignaturaPorcentaje;
        })


        ->addColumn('action', function ($query) {
            return '<a href="primaria_materias_asignaturas/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="primaria_materias_asignaturas/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>                
           ';
        })->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('primaria.materias_asignaturas.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function getMateriasConAsignatura(Request $request, $plan_id, $grado)
    {
        if ($request->ajax()) {
            $materias = Primaria_materia::where([
                ['plan_id', '=', $plan_id],
                ['matSemestre', '=', $grado],
                ['materia_tieneAsignaturas', '=', 'SI'],
                ['matVigentePlanPeriodoActual', '=', 'SI']
            ])->get();

            return response()->json($materias);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            
            $materias = $request->materias;


            // dd($materias);

            foreach ($materias as $key => $materia) {
                $materia = explode('~',$materia);

                $existeClaveMateria = Primaria_materias_asignaturas::select("primaria_materias_asignaturas.*")
                ->where('primaria_materia_id', "=", $materia[1])
                ->where("plan_id", "=", $materia[0])
                ->where("periodo_id", "=", $materia[2])
                ->where("matClaveAsignatura", "=", $materia[7])
                ->first();
        
                if ($existeClaveMateria) {
                    alert()->error('Ups...', "La clave $materia[7] de materia ya existe. Favor de capturar otra clave de materia")->autoClose(5000);
                    return back()->withInput();
                }
    
                
                Primaria_materias_asignaturas::create([
                    'primaria_materia_id'      => $materia[1],
                    'plan_id'                  => $materia[0],
                    'periodo_id'               => $materia[2],
                    'matClaveAsignatura'       => $materia[7],
                    'matNombreAsignatura'      => $materia[8],
                    'matAsignaturaPorcentaje'  => $materia[9]                   
                ]);
            }

            
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La Materia asignatura se ha creado con éxito','success')->showConfirmButton()->autoClose(5000);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $primaria_materias_asignaturas = Primaria_materias_asignaturas::select(
            'primaria_materias_asignaturas.id',
            'primaria_materias.id as primaria_materia_id',
            'primaria_materias.matClave',
            'primaria_materias.matNombre',
            'primaria_materias.matSemestre',
            'planes.id as plan_id',
            'planes.planClave',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnioPago',
            'primaria_materias_asignaturas.matClaveAsignatura',
            'primaria_materias_asignaturas.matNombreAsignatura',
            'primaria_materias_asignaturas.matAsignaturaPorcentaje',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
        ->join('primaria_materias', 'primaria_materias_asignaturas.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('planes', 'primaria_materias_asignaturas.plan_id', '=', 'planes.id')
        ->join('periodos', 'primaria_materias_asignaturas.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->where('primaria_materias_asignaturas.id', '=', $id)
        ->first();

        return view('primaria.materias_asignaturas.show', [
            "primaria_materias_asignaturas" => $primaria_materias_asignaturas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $primaria_materias_asignaturas = Primaria_materias_asignaturas::select(
            'primaria_materias_asignaturas.id',
            'primaria_materias.id as primaria_materia_id',
            'primaria_materias.matClave',
            'primaria_materias.matNombre',
            'primaria_materias.matSemestre',
            'planes.id as plan_id',
            'planes.planClave',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnioPago',
            'primaria_materias_asignaturas.matClaveAsignatura',
            'primaria_materias_asignaturas.matNombreAsignatura',
            'primaria_materias_asignaturas.matAsignaturaPorcentaje',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
        ->join('primaria_materias', 'primaria_materias_asignaturas.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('planes', 'primaria_materias_asignaturas.plan_id', '=', 'planes.id')
        ->join('periodos', 'primaria_materias_asignaturas.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->where('primaria_materias_asignaturas.id', '=', $id)
        ->first();

        return view('primaria.materias_asignaturas.edit', [
            "primaria_materias_asignaturas" => $primaria_materias_asignaturas
        ]);
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
        DB::beginTransaction();
        try {


            $existeClaveMateria = Primaria_materias_asignaturas::select("primaria_materias_asignaturas.*")
            ->where('primaria_materia_id', "=", $request->primaria_materia_id)
                ->where("plan_id", "=", $request->plan_id)
                ->where("periodo_id", "=", $request->periodo_id)
                ->where("matClaveAsignatura", "=", $request->matClaveAsignatura)
                ->first();

                // validamos si es el mismo ID para poder actualizar 
                if($request->asignatura_id == $existeClaveMateria->id){

                    $primaria_materias_asignaturas = Primaria_materias_asignaturas::findOrFail($id);

                    $primaria_materias_asignaturas->update([
                        'primaria_materia_id'      => $request->primaria_materia_id,
                        'plan_id'                  => $request->plan_id,
                        'periodo_id'               => $request->periodo_id,
                        'matClaveAsignatura'       => $request->matClaveAsignatura,
                        'matNombreAsignatura'      => $request->matNombreAsignatura,
                        'matAsignaturaPorcentaje'  => $request->matAsignaturaPorcentaje
                    ]);

                }else{
                    if ($existeClaveMateria) {
                        alert()->error('Ups...', "La clave $request->matClaveAsignatura de materia ya existe. Favor de capturar otra clave de materia")->autoClose(5000);
                        return back()->withInput();
                    }
                }
            
           
            
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La Materia asignatura se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose(5000);
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
        //
    }
}
