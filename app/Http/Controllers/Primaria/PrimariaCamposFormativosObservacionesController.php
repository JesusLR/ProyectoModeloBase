<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Primaria\Primaria_campo_formativo_observaciones;
use App\Models\Primaria\Primaria_campos_formativos;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PrimariaCamposFormativosObservacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('primaria.campos_formativos_observaciones.show-list');
    }

    public function list()
    {
        $primaria_calificaciones_observaciones = Primaria_campo_formativo_observaciones::select(
            'primaria_campo_formativo_observaciones.id',
            'primaria_campo_formativo_observaciones.primaria_campo_formativo_id',
            'primaria_campo_formativo_observaciones.nivelCalificacion',
            'primaria_campo_formativo_observaciones.trimestre',
            'primaria_campo_formativo_observaciones.observaciones',
            'primaria_campos_formativos.camFormativos'
        )
        ->join('primaria_campos_formativos', 'primaria_campo_formativo_observaciones.primaria_campo_formativo_id', '=', 'primaria_campos_formativos.id')
        ->whereNull('primaria_campos_formativos.deleted_at')
        ->whereNull('primaria_campo_formativo_observaciones.deleted_at')
        ->orderBy('primaria_campos_formativos.id', 'ASC');

        return DataTables::of($primaria_calificaciones_observaciones)

        // ->filterColumn('camFormativos', function ($query, $keyword) {
        //     $query->whereRaw("CONCAT(camFormativos) like ?", ["%{$keyword}%"]);
        // })
        // ->addColumn('camFormativos', function ($query) {
        //     return $query->camFormativos;
        // })

        ->addColumn('action', function ($query) {




            $btnVer = "";
            $btnEditar = "";
            $btnEliminar = "";


            $btnEditar = '<a href="primaria_campos_formativos_observaciones/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>';
            $btnEliminar = '<form id="delete_' . $query->id . '" action="primaria_campos_formativos_observaciones/' . $query->id . '" method="POST" style="display:inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';

            $btnVer = '<a href="primaria_campos_formativos_observaciones/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
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

        return view('primaria.campos_formativos_observaciones.create', [
            'ubicaciones' => $ubicaciones,
            'primaria_campos_formativos' => $primaria_campos_formativos
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
        $validator = Validator::make(
            $request->all(),
            [

                'primaria_campo_formativo_id' => 'required',
                'nivelCalificacion' => 'required',
                'trimestre' => 'required',
                'observaciones' => 'required'
            ],
            [
                'primaria_campo_formativo_id.required' => "El campo formativo es obligatorio",
                'nivelCalificacion.required' => 'El campo nivel calificación es obligatorio',
                'trimestre.required' => 'El campo trimestre es obligatorio',
                'observaciones.required' => 'El campo observaciones es obligatorio',
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect('primaria_campos_formativos_observaciones/create')->withErrors($validator)->withInput();
            }
        }

        try {
            $primaria_calificaciones_observaciones = Primaria_campo_formativo_observaciones::create([
                'primaria_campo_formativo_id' => $request->input('primaria_campo_formativo_id'),
                'nivelCalificacion' => $request->input('nivelCalificacion'),
                'trimestre' => $request->input('trimestre'),
                'observaciones' => $request->input('observaciones')
            ]);

            alert('Escuela Modelo', 'La observación del campo formativo se ha creado con éxito', 'success')->showConfirmButton()->autoClose(5000);
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
        $primaria_campo_formativo_observaciones = Primaria_campo_formativo_observaciones::select(
            'primaria_campo_formativo_observaciones.id',
            'primaria_campo_formativo_observaciones.primaria_campo_formativo_id',
            'primaria_campo_formativo_observaciones.nivelCalificacion',
            'primaria_campo_formativo_observaciones.trimestre',
            'primaria_campo_formativo_observaciones.observaciones',
            'primaria_campos_formativos.camFormativos'
        )
        ->join('primaria_campos_formativos', 'primaria_campo_formativo_observaciones.primaria_campo_formativo_id', '=', 'primaria_campos_formativos.id')
        ->where('primaria_campo_formativo_observaciones.id', $id)
        ->first();

        return view('primaria.campos_formativos_observaciones.show', [
            'primaria_campo_formativo_observaciones' => $primaria_campo_formativo_observaciones
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
        $primaria_campo_formativo_observaciones = Primaria_campo_formativo_observaciones::where('id', '=', $id)->first();

        $primaria_campos_formativos = Primaria_campos_formativos::whereNull('deleted_at')->get();


        return view('primaria.campos_formativos_observaciones.edit', [
            'primaria_campo_formativo_observaciones' => $primaria_campo_formativo_observaciones,
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
                'nivelCalificacion' => 'required',
                'trimestre' => 'required',
                'observaciones' => 'required'
            ],
            [
                'primaria_campo_formativo_id.required' => "El campo formativo es obligatorio",
                'nivelCalificacion.required' => 'El campo nivel calificación es obligatorio',
                'trimestre.required' => 'El campo trimestre es obligatorio',
                'observaciones.required' => 'El campo observaciones es obligatorio',
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect('primaria_campos_formativos_observaciones/create')->withErrors($validator)->withInput();
            }
        }

        try {

            $primaria_calificaciones_observaciones = Primaria_campo_formativo_observaciones::find($id);

            $primaria_calificaciones_observaciones->update([
                'primaria_campo_formativo_id' => $request->input('primaria_campo_formativo_id'),
                'nivelCalificacion' => $request->input('nivelCalificacion'),
                'trimestre' => $request->input('trimestre'),
                'observaciones' => $request->input('observaciones')
            ]);

            alert('Escuela Modelo', 'La observación del campo formativo se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose(5000);
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
        $primaria_campo_formativo_observaciones = Primaria_campo_formativo_observaciones::findOrFail($id);

        if ($primaria_campo_formativo_observaciones->delete()) {
        alert('Escuela Modelo', 'El campo formativo se ha eliminado con éxito','success')->showConfirmButton();;
        } else {
        alert()->error('Error...', 'No se pudo eliminar el campo formativo')->showConfirmButton();
        }

        return back();
    }
}
