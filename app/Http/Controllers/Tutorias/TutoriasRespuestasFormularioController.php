<?php

namespace App\Http\Controllers\Tutorias;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tutorias\Tutorias_categoria_preguntas;
use App\Models\Tutorias\Tutorias_formularios;
use App\Models\Tutorias\Tutorias_preguntas;
use App\Models\Tutorias\Tutorias_respuestas;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Collection;


class TutoriasRespuestasFormularioController extends Controller
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
    public function index($FormularioID)
    {
        $pregunta_formulario = Tutorias_preguntas::select('tutorias_preguntas.Nombre', 'tutorias_preguntas.TipoRespuesta','tutorias_preguntas.FormularioID', 
        'tutorias_categoria_preguntas.Nombre as nombreCategoria', 'tutorias_formularios.Nombre as nombreFormulario')
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.PreguntaID', '!=', 0)
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)->get();

        $pregunta_formulario_collection = collect($pregunta_formulario);

        $formulario = Tutorias_formularios::find($FormularioID);

        // if($pregunta_formulario->isEmpty()) {
        //     alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
        //     return back();
        // }

        return view('tutorias.formularioRespuestas.show-list', [
            'pregunta_formulario' => $pregunta_formulario,
            'formulario' => $formulario
        ]);
    }

    public function lista_preguntas($FormularioID)
    {

        $pregunta_formulario = Tutorias_preguntas::select('tutorias_preguntas.PreguntaID','tutorias_preguntas.Nombre', 'tutorias_preguntas.TipoRespuesta', 'tutorias_preguntas.Estatus as Estatus', 
        'tutorias_categoria_preguntas.Nombre as nombreCategoria', 'tutorias_formularios.Nombre as nombreForumario', 'tutorias_preguntas.totalRespuestas', 
        'tutorias_preguntas.orden_visual_pregunta',
        'tutorias_formularios.FormularioID')
        ->join('tutorias_categoria_preguntas', 'tutorias_preguntas.CategoriaPreguntaID', '=', 'tutorias_categoria_preguntas.CategoriaPreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
        // ->where('tutorias_preguntas.TipoRespuesta', '=', 0)
        ->orderBy('tutorias_categoria_preguntas.orden_visual_categoria', 'ASC')
        ->orderBy('tutorias_preguntas.orden_visual_pregunta', 'ASC');


        return DataTables::of($pregunta_formulario)


            ->filterColumn('estatusRespuesta', function($query, $keyword) {
                $query->whereRaw("CONCAT(Estatus) like ?", ["%{$keyword}%"]);
            
            })
            ->addColumn('estatusRespuesta',function($query) {
                if($query->Estatus == 1){
                    return "ACTIVO";
                }else{
                    return "INACTIVO";
                }
            })

            ->filterColumn('orden_visual_pregunta', function($query, $keyword) {
                $query->whereRaw("CONCAT(orden_visual_pregunta) like ?", ["%{$keyword}%"]);
            
            })
            ->addColumn('orden_visual_pregunta',function($query) {
                return $query->orden_visual_pregunta;
            })

            ->filterColumn('nombre_categoria', function($query, $keyword) {
                $query->whereRaw("CONCAT(tutorias_categoria_preguntas.Nombre) like ?", ["%{$keyword}%"]);
            
            })
            ->addColumn('nombre_categoria',function($query) {
                return $query->nombreCategoria;
            })

            ->addColumn('action',function($pregunta_formulario) {



                $acciones = '';

                if($pregunta_formulario->TipoRespuesta == 0 || $pregunta_formulario->TipoRespuesta == 1){
                    $acciones = '

                    <a href="#modalRespuestas" data-pregunta-id="' . $pregunta_formulario->PreguntaID . '" data-nombre-id="' . $pregunta_formulario->Nombre . '" dismissible="false"  class="modal-trigger btn-modal-respuestas-tuto button button--icon js-button js-ripple-effect" title="Ver respuestas">
                            <i class="material-icons">visibility</i>
                    </a>

                    <a href="/tutorias_formulario_preguntas/' . $pregunta_formulario->PreguntaID . '/crear_respuesta" class="button button--icon js-button js-ripple-effect" title="Agregar respuestas">
                    <i class="material-icons">add</i>
                    </a>

                    <a href="/tutorias_formulario_preguntas/' . $pregunta_formulario->PreguntaID . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar pregunta">
                    <i class="material-icons">edit</i>
                    </a>

                    <form id="delete_' . $pregunta_formulario->PreguntaID . '" action="delete/' . $pregunta_formulario->PreguntaID . '/'.$pregunta_formulario->FormularioID.'" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $pregunta_formulario->PreguntaID . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    </form>
                                  
                   
                    ';
                   
                }else{
                    $acciones = '

                    <a href="/tutorias_formulario_preguntas/' . $pregunta_formulario->PreguntaID . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar pregunta">
                    <i class="material-icons">edit</i>
                    </a>

                    <form id="delete_' . $pregunta_formulario->PreguntaID . '" action="delete/' . $pregunta_formulario->PreguntaID . '/'.$pregunta_formulario->FormularioID.'" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $pregunta_formulario->PreguntaID . '"  class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                                  
                   
                    ';
                    
                }


                return $acciones;
                
            })
            ->make(true);


    }

    public function getPreguntaID(Request $request)
    {
        if($request->ajax()){
            $respuestas = Tutorias_respuestas::select('tutorias_respuestas.*', 'tutorias_preguntas.Nombre AS nombrePregunta')
            ->leftJoin('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
            ->where('tutorias_preguntas.PreguntaID', '=', $request->PreguntaID)
            ->get();
            return response()->json($respuestas);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($PreguntaID)
    {
        $pregunta_formulario = Tutorias_preguntas::select()->where('PreguntaID', '=', $PreguntaID)->firstOrFail();
        $respuestas = Tutorias_respuestas::where('PreguntaID', '=', $PreguntaID)->get();

        return view('tutorias.formularioRespuestas.create', [
            'pregunta_formulario' => $pregunta_formulario,
            'respuestas' => $respuestas
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $PreguntaID)
    {
        

        $validator = Validator::make($request->all(),
        [
            'NombreRespuesta' => 'required',
            'Semaforizacion' => 'required'                    
        ]);

        if ($validator->fails()) {
            return redirect ('tutorias_formulario_preguntas/'.$PreguntaID. '/crear_respuesta')->withErrors($validator)->withInput();
        }
        else{
            try {


                $PreguntaID = $request->PreguntaID;
                $NombreRespuesta = $request->NombreRespuesta;
                $TipoRespuesta = $request->TipoRespuesta;
                $Semaforizacion = $request->Semaforizacion;

                if(!empty($NombreRespuesta)) {
                    $totalRespuesta = count($NombreRespuesta);

                    for ($i = 0; $i < $totalRespuesta; $i++) {
        
                        $respuesta = array();
                        $respuesta = new Tutorias_respuestas();
                        $respuesta['Nombre'] = $NombreRespuesta[$i];
                        $respuesta['Tipo'] = $TipoRespuesta[$i];
                        $respuesta['Semaforizacion'] = $Semaforizacion[$i];
                        $respuesta['PreguntaID'] = $PreguntaID;
                          
            
                        $respuesta->save();
                    }

                    $totalRespuestasActivas = $request->totalRespuestasActivas;
                    $sumaRespuestas = $totalRespuesta + $totalRespuestasActivas;

                    $totalRespuestasTable = Tutorias_preguntas::where('PreguntaID', '=', $PreguntaID)->firstOrFail();


                    $totalRespuestasTable->update([
                        'totalRespuestas' => $sumaRespuestas
                    ]);
                }  
                
                alert('Escuela Modelo', 'Las respuestas se ha crearón con éxito', 'success')->showConfirmButton();
                // return redirect('tutorias_formulario_preguntas/'.$request->FormularioID);
                return back();


            }
            catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
    
                return redirect()->route('tutorias_formulario.create')->withInput();
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($PreguntaID)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($PreguntaID)
    {
        $pregunta_formulario = Tutorias_preguntas::select()->where('PreguntaID', '=', $PreguntaID)->firstOrFail();
        $respuestas = Tutorias_respuestas::where('PreguntaID', '=', $PreguntaID)->get();
        return view('tutorias.formularioRespuestas.edit', [
            'pregunta_formulario' => $pregunta_formulario,
            'respuestas' => $respuestas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $PreguntaID)
    {
        

        $validator = Validator::make($request->all(),
        [
            'Nombre' => 'required',
            'orden_visual_pregunta' => 'required'
                           
        ]);

        if ($validator->fails()) {
            return redirect ('tutorias_formulario_preguntas/'.$PreguntaID. '/edit')->withErrors($validator)->withInput();
        }
        else{
            try {

                $pregunta = Tutorias_preguntas::where('PreguntaID', '=', $PreguntaID)->firstOrFail();

                $pregunta->update([
                    'Nombre' => $request->Nombre,
                    'orden_visual_pregunta' => $request->orden_visual_pregunta,
                    'Estatus' => $request->estatusPregunta
                ]);


                $RespuestaID = $request->RespuestaID;
                $NombreRespuesta = $request->NombreRespuesta;
                $TipoRespuesta = $request->TipoRespuesta;
                $Semaforizacion = $request->Semaforizacion;
                $estatus = $request->estatus;

                $collection_estatus = collect($estatus);
                $respuesta_estatus = $collection_estatus->values(); //este el el valor
                // $PreguntaID = $collection_estatus->keys();

              
                if(!empty($RespuestaID))
                {
                    $contar = count($RespuestaID);
                    for ($i=0; $i< $contar; $i++) {

                        DB::table('tutorias_respuestas')
                            ->where('RespuestaID',$RespuestaID[$i])
                            ->update([
                                'RespuestaID' => $RespuestaID[$i],
                                'Nombre' => $NombreRespuesta[$i],
                                'Semaforizacion' => $Semaforizacion[$i],
                                'estatus' => $respuesta_estatus[$i]                                
                
                        ]);
                
                    } 
                }
                
                alert('Escuela Modelo', 'Las respuestas se actualizo con éxito', 'success')->showConfirmButton();
                return redirect('tutorias_formulario_preguntas/'.$request->FormularioID);


            }
            catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
    
                return redirect()->route('tutorias_formulario.create')->withInput();
            }

        }
    }

    public function crearPregunta($FormularioID)
    {
        $categoriaPregunta = Tutorias_categoria_preguntas::orderby('orden_visual_categoria', 'ASC')->get();

        return view('tutorias.formularioRespuestas.create-pregunta', [
            'categoriaPregunta' => $categoriaPregunta,
            'FormularioID' => $FormularioID
        ]);
    }

    public function guardarPregunta(Request $request)
    {

        $NombrePregunta = $request->NombrePregunta;
        $CategoriaPreguntaID = $request->CategoriaPreguntaID;
        $TipoRespuesta = $request->TipoRespuesta;
        $FormularioID = $request->FormularioID;
        $orden_visual_pregunta = $request->orden_visual_pregunta;

        if (!empty($NombrePregunta)) {
            for ($i = 0; $i < count($NombrePregunta); $i++) {

                $pregunta = array();
                $pregunta = new Tutorias_preguntas();
                $pregunta['Nombre'] = $NombrePregunta[$i];
                $pregunta['CategoriaPreguntaID'] = $CategoriaPreguntaID[$i];
                $pregunta['TipoRespuesta'] = $TipoRespuesta[$i];
                $pregunta['FormularioID'] = $FormularioID;
                $pregunta['Porcentaje'] = 0;
                $pregunta['AtributoWS'] = null;
                $pregunta['Estatus'] = 1;
                $pregunta['Eliminado'] = 0;

                if ($TipoRespuesta[$i] == 0) {
                    $pregunta['totalRespuestas'] = 0;
                } else {
                    $pregunta['totalRespuestas'] = 'Pregunta abierta';
                }
                $pregunta['orden_visual_pregunta'] = $orden_visual_pregunta[$i];

                $pregunta->save();
            }
        }


        // selecciona todas las preguntas que cuya respuesta sea tipo texto para poder guardar la respuesta en la tabla Tutorias_respuestas 
        $preguntasTipoTexto = Tutorias_preguntas::select('tutorias_preguntas.PreguntaID', 'tutorias_formularios.FormularioID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
            ->where('tutorias_preguntas.TipoRespuesta', '=', 2)
            ->get();

        $arrayPreguntasNuevas = $preguntasTipoTexto->pluck('PreguntaID')->toArray();


        $respuestas = Tutorias_respuestas::select('tutorias_respuestas.RespuestaID', 'tutorias_respuestas.PreguntaID')
        ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
            ->get();

        // seleccionar solo PreguntaID
        $valoresPreguntaID = $respuestas->pluck('PreguntaID')->toArray();

        // se compara los valores para extraer los ID que no se encuentren en la tabla tutorias_respuestas
        foreach ($valoresPreguntaID as $valor) {
            foreach ($arrayPreguntasNuevas as $valor2) {
                if ($valor == $valor2) {
                    $borrar = array_search($valor, $arrayPreguntasNuevas);
                    unset($arrayPreguntasNuevas[$borrar]);
                }
            }
        }

        // validar que no este vacio para ejucutar
        if (!empty($arrayPreguntasNuevas)) {


            $collection = collect($arrayPreguntasNuevas);
            $keysPreguntaID = $collection->values(); //extrae unicamente el valor - el ID


            for ($i = 0; $i < count($arrayPreguntasNuevas); $i++) {

                $respuesta = array();
                $respuesta = new Tutorias_respuestas();
                $respuesta['Nombre'] = null;
                $respuesta['Tipo'] = 2;
                $respuesta['Semaforizacion'] = 0;
                $respuesta['PreguntaID'] = $keysPreguntaID[$i];



                $respuesta->save();
            }
        }

        $preguntasTipoFecha = Tutorias_preguntas::select('tutorias_preguntas.PreguntaID', 'tutorias_formularios.FormularioID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $FormularioID)
            ->where('tutorias_preguntas.TipoRespuesta', '=', 4)
            ->get();

            // seleccionar solo PreguntaID 
        $arrayPreguntasNuevasFecha = $preguntasTipoFecha->pluck('PreguntaID')->toArray();

        // se compara los valores para extraer los ID que no se encuentren en la tabla tutorias_respuestas
        foreach ($valoresPreguntaID as $valor) {
            foreach ($arrayPreguntasNuevasFecha as $valor2) {
                if ($valor == $valor2) {
                    $borrar = array_search($valor, $arrayPreguntasNuevasFecha);
                    unset($arrayPreguntasNuevasFecha[$borrar]);
                }
            }
        }


        // validar que no este vacio para ejucutar
        if (!empty($arrayPreguntasNuevasFecha)) {

            $collection2 = collect($arrayPreguntasNuevasFecha);
            $keysPreguntaID2 = $collection2->values();//extrae unicamente el valor - el ID


            for ($i = 0; $i < count($arrayPreguntasNuevasFecha); $i++) {

                $respuestaTipoFecha = array();
                $respuestaTipoFecha = new Tutorias_respuestas();
                $respuestaTipoFecha['Nombre'] = null;
                $respuestaTipoFecha['Tipo'] = 4;
                $respuestaTipoFecha['Semaforizacion'] = 0;
                $respuestaTipoFecha['PreguntaID'] = $keysPreguntaID2[$i];

                $respuestaTipoFecha->save();
            }
        }

        alert('Escuela Modelo', 'La pregunta se guardo con éxito', 'success')->showConfirmButton();
        return redirect('tutorias_formulario_preguntas/' . $FormularioID);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($PreguntaID, $FormularioID)
    {
        $pregunta = Tutorias_preguntas::findOrFail($PreguntaID);
        try {
            if ($pregunta->delete()) {
                alert('Escuela Modelo', 'La pregunta se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puede eliminar la pregunta')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect('tutorias_formulario_preguntas/'. $FormularioID);
    }
        

    public function AjaxGuardarCategoria(Request $request)
    {
        if ($request->ajax()) {

            $NombreCategoria = $request->input("NombreCategoria");
            $DescripcionCategoria = $request->input("DescripcionCategoria");
            $orden_visual_categoria = $request->input("orden_visual_categoria");

            Tutorias_categoria_preguntas::create([
                'Nombre' => $NombreCategoria,
                'Descripcion' => $DescripcionCategoria,
                'Estatus' => 0,
                'Eliminado' => 0,
                'orden_visual_categoria' => $orden_visual_categoria
            ]);
          

            return response()->json([
                'res' => "true",
            ]);

        }
    }
}
