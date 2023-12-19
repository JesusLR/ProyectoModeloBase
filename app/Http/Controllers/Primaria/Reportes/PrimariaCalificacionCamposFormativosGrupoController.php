<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Primaria\Primaria_campos_formativos;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PrimariaCamposFormativosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('primaria.campos_formativos.show-list');
    }

    public function list()
    {
        $primaria_campos_formativos = Primaria_campos_formativos::select('*')->whereNull('deleted_at');

        return DataTables::of($primaria_campos_formativos)->addColumn('action', function ($query) {

            $btnVer = "";
            $btnEditar = "";
            $btnEliminar = "";


            $btnEditar = '<a href="primaria_campos_formativos/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>';
            $btnEliminar = '<form id="delete_' . $query->id . '" action="primaria_campos_formativos/' . $query->id . '" method="POST" style="display:inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';

            $btnVer = '<a href="primaria_campos_formativos/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
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

        return view('primaria.campos_formativos.create', [
            'ubicaciones' => $ubicaciones
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

                'camFormativos' => 'required'
            ],
            [
                'camFormativos.required' => "Campo formativo es obligatorio",
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect('primaria_campos_formativos/create')->withErrors($validator)->withInput();
            }
        }

        try {
            $primaria_campos_formativos = Primaria_campos_formativos::create([
                'camFormativos'     => $request->input('camFormativos')
            ]);

            alert('Escuela Modelo', 'El campo formativo se ha creado con éxito', 'success')->showConfirmButton()->autoClose(5000);
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
        $primaria_campos_formativos = Primaria_campos_formativos::find($id);

        return view('primaria.campos_formativos.show', [
            'primaria_campos_formativos' => $primaria_campos_formativos
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
        $primaria_campos_formativos = Primaria_campos_formativos::where('id', '=', $id)->first();

        return view('primaria.campos_formativos.edit', [
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

                'camFormativos' => 'required'
            ],
            [
                'camFormativos.required' => "Campo formativo es obligatorio",
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect('primaria_campos_formativos/create')->withErrors($validator)->withInput();
            }
        }

        try {

            $primaria_campos_formativos = Primaria_campos_formativos::find($id);

            $primaria_campos_formativos->update([
                'camFormativos'     => $request->input('camFormativos')
            ]);

            alert('Escuela Modelo', 'El campo formativo se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose(5000);
            return redirect()->route('primaria.primaria_campos_formativos.index');
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
        $primaria_campos_formativos = Primaria_campos_formativos::findOrFail($id);

        if ($primaria_campos_formativos->delete()) {
        alert('Escuela Modelo', 'El campo formativo se ha eliminado con éxito','success')->showConfirmButton();;
        } else {
        alert()->error('Error...', 'No se pudo eliminar el campo formativo')->showConfirmButton();
        }

        return back();
    }
}
