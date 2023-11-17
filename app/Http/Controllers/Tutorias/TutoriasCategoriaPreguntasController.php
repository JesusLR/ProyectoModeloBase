<?php

namespace App\Http\Controllers\Tutorias;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Tutorias\Tutorias_categoria_preguntas;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class TutoriasCategoriaPreguntasController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('permisos:tutoriasroles',['except' => ['index', 'list', 'create', 'store', 'edit', 'update', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tutorias.categoria_preguntas.show-list');
    }


    public function list()
    {


        $categoria_pregunta = Tutorias_categoria_preguntas::select('tutorias_categoria_preguntas.*')->orderBy('orden_visual_categoria', 'ASC');

        return DataTables::of($categoria_pregunta)

            ->addColumn('action', function ($categoria_pregunta) {
                $acciones = '';

                $acciones = '<a href="/tutorias_categoria_pregunta/'.$categoria_pregunta->CategoriaPreguntaID.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
                </a>
                
                <a href="/tutorias_categoria_pregunta/' . $categoria_pregunta->CategoriaPreguntaID . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                    
                <form id="delete_' . $categoria_pregunta->CategoriaPreguntaID . '" action="tutorias_categoria_pregunta/' . $categoria_pregunta->CategoriaPreguntaID . '" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="'  . $categoria_pregunta->CategoriaPreguntaID . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
                </form>
                    ';
                return $acciones;
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
        return view('tutorias.categoria_preguntas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'Nombre' => 'required|unique:tutorias_categoria_preguntas,Nombre',
            'Descripcion' => 'required',
            'orden_visual_categoria' => 'required'      
   
        ],
        [
            'Nombre.unique' => "La categoría pregunta ya existe"
        ]
        );

        if ($validator->fails()) {
            return redirect ()->route('tutorias_categoria_pregunta.create')->withErrors($validator)->withInput();
        }{
            try {

                Tutorias_categoria_preguntas::create([
                    'Nombre' => $request->Nombre,
                    'Descripcion' => $request->Descripcion,
                    'Estatus' => 0,
                    'Eliminado' => 0,
                    'orden_visual_categoria' => $request->orden_visual_categoria
                ]);      
        
 

                alert('Escuela Modelo', 'La categoría pregunta se creo con éxito', 'success')->showConfirmButton();
                return redirect('tutorias_categoria_pregunta');
            }
            catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
    
                return redirect()->route('tutorias_categoria_pregunta.create')->withInput();
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
        $categoria_pregunta = Tutorias_categoria_preguntas::where('CategoriaPreguntaID', '=', $id)->firstOrFail();

        return view('tutorias.categoria_preguntas.show', [
            'categoria_pregunta' => $categoria_pregunta
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

        $categoria_pregunta = Tutorias_categoria_preguntas::where('CategoriaPreguntaID', '=', $id)->firstOrFail();

        return view('tutorias.categoria_preguntas.edit', [
            'categoria_pregunta' => $categoria_pregunta
        ]);

       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $CategoriaPreguntaID)
    {
        $validator = Validator::make($request->all(),
        [
            'Nombre' => 'required',
            'Descripcion' => 'required',
            'orden_visual_categoria' => 'required'      
        ]
        );

        if ($validator->fails()) {
            return redirect ('tutorias_categoria_pregunta/'.$CategoriaPreguntaID.'/edit')->withErrors($validator)->withInput();
        }{
            try {

                $categoria_pregunta = Tutorias_categoria_preguntas::where('CategoriaPreguntaID', '=', $CategoriaPreguntaID)->firstOrFail();

                $categoria_pregunta->update([
                    'Nombre' => $request->Nombre,
                    'Descripcion' => $request->Descripcion,
                    'orden_visual_categoria' => $request->orden_visual_categoria
                ]);
        
                alert('Escuela Modelo', 'La categoría pregunta se actualizo con éxito', 'success')->showConfirmButton();
                return redirect('tutorias_categoria_pregunta');
            }
            catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
    
                return redirect()->route('tutorias_categoria_pregunta.edit')->withInput();
            }

        }

       
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($CategoriaPreguntaID)
    {
        $categoria_pregunta = Tutorias_categoria_preguntas::findOrFail($CategoriaPreguntaID);
        try {
            
            if ($categoria_pregunta->delete()) {
                alert('Escuela Modelo', 'La categoría pregunta se ha eliminado con éxito', 'success')->showConfirmButton();
                return redirect()->route('tutorias_categoria_pregunta.index');
            } else {
                alert()->error('Error...', 'No se puedo eliminar la categoría pregunta')->showConfirmButton();
                return redirect()->route('tutorias_categoria_pregunta.index');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
    }
}