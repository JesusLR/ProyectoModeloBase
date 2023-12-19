<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Primaria\Primaria_campo_formativo_materias;
use App\Models\Primaria\Primaria_campo_formativo_observaciones;
use App\Models\Primaria\Primaria_campos_formativos;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PrimariaCamposFormativosMateriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('primaria.campos_formativos_materias.show-list');
    }

    public function list()
    {
        $primaria_campo_formativo_materias = Primaria_campo_formativo_materias::select(
            'primaria_campo_formativo_materias.id',
            'primaria_campo_formativo_materias.primaria_campo_formativo_id',
            'primaria_campo_formativo_materias.primaria_materia_id',
            'primaria_campos_formativos.camFormativos',
            'primaria_materias.plan_id',
            'primaria_materias.matClave',
            'primaria_materias.matNombre',
            'primaria_materias.matSemestre',
            'planes.planClave',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('primaria_campos_formativos', 'primaria_campo_formativo_materias.primaria_campo_formativo_id', '=', 'primaria_campos_formativos.id')
        ->join('primaria_materias', 'primaria_campo_formativo_materias.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('planes', 'primaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->whereNull('primaria_campos_formativos.deleted_at')
        ->whereNull('primaria_materias.deleted_at')
        ->whereNull('planes.deleted_at')
        ->whereNull('programas.deleted_at')
        ->whereNull('escuelas.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->whereNull('ubicacion.deleted_at')
        ->orderBy('primaria_campos_formativos.id', 'ASC');

        return DataTables::of($primaria_campo_formativo_materias)

        ->filterColumn('camFormativos', function ($query, $keyword) {
            $query->whereRaw("CONCAT(camFormativos) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('camFormativos', function ($query) {
            return $query->camFormativos;
        })

        ->filterColumn('matClave', function ($query, $keyword) {
            $query->whereRaw("CONCAT(matClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('matClave', function ($query) {
            return $query->matClave;
        })

        ->filterColumn('matNombre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('matNombre', function ($query) {
            return $query->matNombre;
        })

        ->filterColumn('matSemestre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(matSemestre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('matSemestre', function ($query) {
            return $query->matSemestre;
        })

        ->filterColumn('planClave', function ($query, $keyword) {
            $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('planClave', function ($query) {
            return $query->planClave;
        })

        ->filterColumn('progClave', function ($query, $keyword) {
            $query->whereRaw("CONCAT(progClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('progClave', function ($query) {
            return $query->progClave;
        })


        ->filterColumn('progNombre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('progNombre', function ($query) {
            return $query->progNombre;
        })

        ->filterColumn('escClave', function ($query, $keyword) {
            $query->whereRaw("CONCAT(escClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('escClave', function ($query) {
            return $query->escClave;
        })

        ->filterColumn('escNombre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(escNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('escNombre', function ($query) {
            return $query->escNombre;
        })

        ->filterColumn('depClave', function ($query, $keyword) {
            $query->whereRaw("CONCAT(depClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('depClave', function ($query) {
            return $query->depClave;
        })

        ->filterColumn('depNombre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(depNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('depNombre', function ($query) {
            return $query->depNombre;
        })

        ->filterColumn('ubiClave', function ($query, $keyword) {
            $query->whereRaw("CONCAT(ubiClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubiClave', function ($query) {
            return $query->ubiClave;
        })

        ->filterColumn('ubiNombre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubiNombre', function ($query) {
            return $query->ubiNombre;
        })
        ->addColumn('action', function ($query) {




            $btnVer = "";
            $btnEditar = "";
            $btnEliminar = "";


            $btnEditar = '<a href="primaria_campos_formativos_materias/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>';
            $btnEliminar = '<form id="delete_' . $query->id . '" action="primaria_campos_formativos_materias/' . $query->id . '" method="POST" style="display:inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';

            $btnVer = '<a href="primaria_campos_formativos_materias/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>';



            return '<div class="row">'
                . $btnVer
                . $btnEditar
                . $btnEliminar
                . '</div>';
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $primaria_campos_formativos = Primaria_campos_formativos::whereNull('deleted_at')->get();

        return view('primaria.campos_formativos_materias.create', [
            'ubicaciones' => $ubicaciones,
            'primaria_campos_formativos' => $primaria_campos_formativos
        ]);
    }

    public function obtenerMaterias(Request $request, $programa_id, $plan_id, $grado)
    {
        if($request->ajax())
        {
            $materias = DB::select("SELECT
            primaria_materias.matClave,
            primaria_materias.matNombre,
            primaria_materias.id
            FROM
                primaria_materias
                INNER JOIN
                planes
                ON
                    primaria_materias.plan_id = planes.id
            WHERE
            planes.programa_id = $programa_id AND
            primaria_materias.plan_id = $plan_id AND
            primaria_materias.matSemestre = $grado AND
            primaria_materias.matVigentePlanPeriodoActual = 'SI' ");

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
        $validator = Validator::make(
            $request->all(),
            [

                'primaria_campo_formativo_id' => 'required',
                'primaria_materia_id' => 'required',
            ],
            [
                'primaria_campo_formativo_id.required' => "El campo formativo es obligatorio",
                'primaria_materia_id.required' => 'El campo materia es obligatorio',
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect('primaria_campos_formativos_materias/create')->withErrors($validator)->withInput();
            }
        }


        try {
            $primaria_campo_formativo_materias = Primaria_campo_formativo_materias::create([
                'primaria_campo_formativo_id' => $request->primaria_campo_formativo_id,
                'primaria_materia_id' => $request->primaria_materia_id
            ]);

            alert('Escuela Modelo', 'El campo formativo materia se ha creado con éxito', 'success')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
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
        $primaria_campo_formativo_materias = Primaria_campo_formativo_materias::select(
            'primaria_campo_formativo_materias.id',
            'primaria_campo_formativo_materias.primaria_campo_formativo_id',
            'primaria_campo_formativo_materias.primaria_materia_id',
            'primaria_campos_formativos.camFormativos',
            'primaria_materias.plan_id',
            'primaria_materias.matClave',
            'primaria_materias.matNombre',
            'primaria_materias.matSemestre',
            'planes.planClave',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('primaria_campos_formativos', 'primaria_campo_formativo_materias.primaria_campo_formativo_id', '=', 'primaria_campos_formativos.id')
        ->join('primaria_materias', 'primaria_campo_formativo_materias.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('planes', 'primaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('primaria_campo_formativo_materias.id', $id)
        ->first();

        return view('primaria.campos_formativos_materias.show', [
            'primaria_campo_formativo_materias' => $primaria_campo_formativo_materias
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
        $primaria_campo_formativo_materias = Primaria_campo_formativo_materias::select(
            'primaria_campo_formativo_materias.id',
            'primaria_campo_formativo_materias.primaria_campo_formativo_id',
            'primaria_campo_formativo_materias.primaria_materia_id',
            'primaria_campos_formativos.camFormativos',
            'primaria_materias.plan_id',
            'primaria_materias.matClave',
            'primaria_materias.matNombre',
            'primaria_materias.matSemestre',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('primaria_campos_formativos', 'primaria_campo_formativo_materias.primaria_campo_formativo_id', '=', 'primaria_campos_formativos.id')
        ->join('primaria_materias', 'primaria_campo_formativo_materias.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('planes', 'primaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('primaria_campo_formativo_materias.id', $id)
        ->first();

        $primaria_campos_formativos = Primaria_campos_formativos::whereNull('deleted_at')->get();


        return view('primaria.campos_formativos_materias.edit', [
            'primaria_campo_formativo_materias' => $primaria_campo_formativo_materias,
            'primaria_campos_formativos' => $primaria_campos_formativos
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
        $validator = Validator::make(
            $request->all(),
            [

                'primaria_campo_formativo_id' => 'required',
                'primaria_materia_id' => 'required',
            ],
            [
                'primaria_campo_formativo_id.required' => "El campo formativo es obligatorio",
                'primaria_materia_id.required' => 'El campo materia es obligatorio',
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }


        try {
            $primaria_campo_formativo_materias = Primaria_campo_formativo_materias::find($id);

            $primaria_campo_formativo_materias->update([
                'primaria_campo_formativo_id' => $request->primaria_campo_formativo_id,
                'primaria_materia_id' => $request->primaria_materia_id
            ]);

            alert('Escuela Modelo', 'El campo formativo materia se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose(5000);
            return redirect()->back();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $primaria_campo_formativo_materias = Primaria_campo_formativo_materias::findOrFail($id);

        if ($primaria_campo_formativo_materias->delete()) {
        alert('Escuela Modelo', 'El campo formativo se ha eliminado con éxito','success')->showConfirmButton();;
        } else {
        alert()->error('Error...', 'No se pudo eliminar el campo formativo')->showConfirmButton();
        }

        return back();
    }
}
