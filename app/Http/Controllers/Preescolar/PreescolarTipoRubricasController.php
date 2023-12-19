<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Preescolar\Preescolar_rubricas_tipo;
use App\Models\Programa;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class PreescolarTipoRubricasController extends Controller
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
        return view('preescolar.tipo_rubricas.show-list');

    }

    public function list()
    {
        $rubricas_tipo = Preescolar_rubricas_tipo::select(
            'preescolar_rubricas_tipo.id',
            'preescolar_rubricas_tipo.tipo',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('programas', 'preescolar_rubricas_tipo.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('departamentos.depClave', 'PRE')
        ->orWhere('departamentos.depClave', 'MAT')
        ->orderBy('preescolar_rubricas_tipo.id', 'ASC');

        return DataTables::of($rubricas_tipo)

        ->filterColumn('ubicacion', function($query, $keyword) {
            $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubicacion', function($query) {
            return $query->ubiNombre;
        })

        ->filterColumn('escuela', function($query, $keyword) {
            $query->whereRaw("CONCAT(escNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('escuela', function($query) {
            return $query->escNombre;
        })



        ->filterColumn('programa', function($query, $keyword) {
            $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('programa', function($query) {
            return $query->progNombre;
        })

        ->addColumn('action',function($query){
            return '<a href="preescolar_tipo_rubricas/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="preescolar_tipo_rubricas/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
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
        return view('preescolar.tipo_rubricas.create');

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
                'tipo'  => 'required',

            ],
            [
                'tipo.required' => 'El campo Tipo es obligatorio.',

            ]
        );

        if ($validator->fails()) {
            return redirect('preescolar_tipo_rubricas/create')->withErrors($validator)->withInput();
        } else {
            try {


                Preescolar_rubricas_tipo::create([
                    'programa_id' => 115,
                    'tipo' => $request->tipo
                ]);

                alert('Escuela Modelo', 'El tipo rúbrica se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('preescolar.preescolar_tipo_rubricas.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('preescolar_tipo_rubricas/create')->withInput();
            }
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
        $preescolar_rubricas_tipo = Preescolar_rubricas_tipo::findOrFail($id);
        $programa = Programa::findOrFail($preescolar_rubricas_tipo->programa_id);

        return view('preescolar.tipo_rubricas.show', [
            'preescolar_rubricas_tipo' => $preescolar_rubricas_tipo,
            'programa' => $programa
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
        $preescolar_rubricas_tipo = Preescolar_rubricas_tipo::findOrFail($id);
        $programa = Programa::findOrFail($preescolar_rubricas_tipo->programa_id);

        return view('preescolar.tipo_rubricas.edit', [
            'preescolar_rubricas_tipo' => $preescolar_rubricas_tipo,
            'programa' => $programa
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
        $preescolar_rubricas_tipo= Preescolar_rubricas_tipo::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'tipo'  => 'required',

            ],
            [
                'tipo.required' => 'El campo Tipo es obligatorio.',

            ]
        );

        if ($validator->fails()) {
            return redirect('preescolar_tipo_rubricas/'.$preescolar_rubricas_tipo->id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {


                $preescolar_rubricas_tipo->update([
                    'tipo' => $request->tipo
                ]);

                alert('Escuela Modelo', 'El tipo rúbrica se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('preescolar.preescolar_tipo_rubricas.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('preescolar_tipo_rubricas/'.$preescolar_rubricas_tipo->id.'/edit')->withInput();
            }
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
        //
    }
}
