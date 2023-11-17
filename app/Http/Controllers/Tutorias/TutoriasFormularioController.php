<?php

namespace App\Http\Controllers\Tutorias;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Tutorias\Tutorias_categoria_preguntas;
use App\Http\Models\Tutorias\Tutorias_formularios;
use App\Http\Models\Tutorias\Tutorias_pregunta_respuestas;
use App\Http\Models\Tutorias\Tutorias_preguntas;
use App\Http\Models\Tutorias\Tutorias_respuestas;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class TutoriasFormularioController extends Controller
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
        return view('tutorias.formulario.show-list');
    }

    public function list()
    {


        $formulario = Tutorias_formularios::get();

        return DataTables::of($formulario)
            ->addColumn('FechaInicioVigencia', function ($query) {
                return Carbon::parse($query->FechaInicioVigencia)->format('d/m/Y');
            })

            ->addColumn('FechaFinVigencia', function ($query) {
                return Carbon::parse($query->FechaFinVigencia)->format('d/m/Y');
            })

            ->addColumn('Estatus', function ($query) {
                if($query->Estatus == 1){
                    return 'Activo';
                }else{
                    return 'Inactivo';
                }
            })

            ->addColumn('action', function ($formulario) {
                $acciones = '';

                $acciones = '<div class="row">

                    
                    <a href="/tutorias_formulario_preguntas/' . $formulario->FormularioID . '" class="button button--icon js-button js-ripple-effect" title="Ver preguntas">
                    <i class="material-icons">question_answer</i>
                    </a>
                                  
                    <a href="/tutorias_formulario/' . $formulario->FormularioID . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>
                    
                    <form id="delete_' . $formulario->FormularioID . '" action="tutorias_formulario/' . $formulario->FormularioID . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $formulario->FormularioID . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
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
        $categoriaPregunta = Tutorias_categoria_preguntas::orderBy('orden_visual_categoria', 'ASC')->get();
        return view('tutorias.formulario.create', [
            'categoriaPregunta' => $categoriaPregunta
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

        $validator = Validator::make($request->all(),
        [
            'Tipo' => 'required',
            'Nombre' => 'required|unique:tutorias_formularios,Nombre',
            'Descripcion' => 'required',
            'Instruccion' => 'required',
            'Parcial' => 'required',
            'FechaInicioVigencia' => 'required',
            'FechaFinVigencia' => 'required'

            
        ],
        [
            'Nombre.unique' => "El nombre de formulario ya existe"
        ]
        );

        if ($validator->fails()) {
            return redirect ()->route('tutorias_formulario.create')->withErrors($validator)->withInput();
        }
        else{
            try {


                $formulario = Tutorias_formularios::create([
                    'Nombre' => $request->Nombre,
                    'Descripcion' => $request->Descripcion,
                    'Instruccion' => $request->Instruccion,
                    'Parcial' => $request->Parcial,
                    'Tipo' => $request->Tipo,
                    'UniversidadID' => 0,
                    'EscuelaID' => 0,
                    'FechaInicioVigencia' => $request->FechaInicioVigencia,
                    'FechaFinVigencia' => $request->FechaFinVigencia,
                    'Estatus' => 1,
                    'Eliminado' => 0
                ]);

                $NombrePregunta = $request->NombrePregunta;
                $CategoriaPreguntaID = $request->CategoriaPreguntaID;
                $TipoRespuesta = $request->TipoRespuesta;
                $FormularioID = $formulario->FormularioID;
                $orden_visual_pregunta = $request->orden_visual_pregunta;

                

                if(!empty($NombrePregunta)) {
                    $totalPreguntas = count($NombrePregunta);

                    for ($i = 0; $i < $totalPreguntas; $i++) {
        
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

                        if($TipoRespuesta[$i] == 0){
                            $pregunta['totalRespuestas'] = 0;  
                        }else{
                            $pregunta['totalRespuestas'] = 'Pregunta abierta';
                        }
                        $pregunta['orden_visual_pregunta'] = $orden_visual_pregunta;
                        
    
            
                        $pregunta->save();
                    }
                }  

                $ultimo_formulario = Tutorias_formularios::latest('FormularioID')->first();
                $FormularioID = $ultimo_formulario->FormularioID;

                // selecciona todas las preguntas que cuya respuesta sea tipo texto para poder guardar la respuesta en la tabla Tutorias_respuestas 
                $preguntasTipoTexto = Tutorias_preguntas::select('PreguntaID', 
                'TipoRespuesta', 
                'FormularioID')
                ->where('FormularioID', '=', $FormularioID)
                ->where('TipoRespuesta', '=', 2)
                ->get();

                if(!empty($preguntasTipoTexto)) {
                    $collectionPreguntaID = collect($preguntasTipoTexto);
                
                    // valores guardados en la base de datos 
                    $valoresPreguntaID = $collectionPreguntaID->pluck('PreguntaID');
    
                    $totalIDs = count($valoresPreguntaID);
    
    
                    for ($i = 0; $i < $totalIDs; $i++) {
            
                        $respuesta = array();
                        $respuesta = new Tutorias_respuestas();
                        $respuesta['Nombre'] = null;
                        $respuesta['Tipo'] = 2;
                        $respuesta['Semaforizacion'] = 0;
                        $respuesta['PreguntaID'] = $valoresPreguntaID[$i];
                       
    
            
                        $respuesta->save();
                    }
    
                }

                $preguntasTipoFecha = Tutorias_preguntas::select('PreguntaID', 
                'TipoRespuesta', 
                'FormularioID')
                ->where('FormularioID', '=', $FormularioID)
                ->where('TipoRespuesta', '=', 4)
                ->get();

                if(!empty($preguntasTipoFecha)) {
                    $collectionPreguntaID = collect($preguntasTipoFecha);
                
                    // valores guardados en la base de datos 
                    $valoresPreguntaID2 = $collectionPreguntaID->pluck('PreguntaID');
    
                    $totalIDs = count($valoresPreguntaID2);
    
    
                    for ($i = 0; $i < $totalIDs; $i++) {
            
                        $respuestaTipoFecha = array();
                        $respuestaTipoFecha = new Tutorias_respuestas();
                        $respuestaTipoFecha['Nombre'] = null;
                        $respuestaTipoFecha['Tipo'] = 4;
                        $respuestaTipoFecha['Semaforizacion'] = 0;
                        $respuestaTipoFecha['PreguntaID'] = $valoresPreguntaID2[$i];
                       
    
            
                        $respuestaTipoFecha->save();
                    }
    
                }
      

                $preguntasFormulario = Tutorias_preguntas::where('FormularioID', '=', $FormularioID)               
                ->get();
                $collecFormulario = count($preguntasFormulario);

                
                if($collecFormulario != 0) {
                    alert('Escuela Modelo', 'El formulario se ha creado con éxito', 'success')->showConfirmButton();
                    return redirect('tutorias_formulario_preguntas/'.$FormularioID);  
                   
                }else{
                    alert('Escuela Modelo', 'El formulario se ha creado con éxito', 'success')->showConfirmButton();
                    return redirect()->route('tutorias_formulario.index');
                }
                
                            // alert('Escuela Modelo', 'El formulario se ha creado con éxito', 'success')->showConfirmButton();
                // return redirect('tutorias_formulario_preguntas/'.$FormularioID.);


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
    public function edit($FormularioID)
    {
        $formulario = Tutorias_formularios::where('FormularioID', '=', $FormularioID)->firstOrFail();
        $categoriaPregunta = Tutorias_categoria_preguntas::orderBy('orden_visual_categoria', 'ASC')->get();

        return view('tutorias.formulario.edit', [
            'formulario' => $formulario,
            'categoriaPregunta' => $categoriaPregunta
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $FormularioID)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'Tipo' => 'required',
                'Nombre' => 'required',
                'Descripcion' => 'required',
                'Instruccion' => 'required',
                'Parcial' => 'required',
                'FechaInicioVigencia' => 'required',
                'FechaFinVigencia' => 'required'


            ]
        );

        if ($validator->fails()) {
            return redirect('tutorias_formulario/' . $FormularioID . '/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $formulario = Tutorias_formularios::where('FormularioID', '=', $FormularioID)->firstOrFail();


                $formulario->update([
                    'Nombre' => $request->Nombre,
                    'Descripcion' => $request->Descripcion,
                    'Instruccion' => $request->Instruccion,
                    'Parcial' => $request->Parcial,
                    'Tipo' => $request->Tipo,
                    'UniversidadID' => 0,
                    'EscuelaID' => 0,
                    'FechaInicioVigencia' => $request->FechaInicioVigencia,
                    'FechaFinVigencia' => $request->FechaFinVigencia,
                    'Estatus' => $request->Estatus,
                ]);


                $NombrePregunta = $request->NombrePregunta;
                $CategoriaPreguntaID = $request->CategoriaPreguntaID;
                $TipoRespuesta = $request->TipoRespuesta;
                $FormularioID = $formulario->FormularioID;
                $orden_visual_pregunta = $request->orden_visual_pregunta;



                if (!empty($NombrePregunta)) {
                    $totalPreguntas = count($NombrePregunta);

                    for ($i = 0; $i < $totalPreguntas; $i++) {

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
                    $keysPreguntaID = $collection->values();//extrae unicamente el valor - el ID


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
                    $keysPreguntaID2 = $collection2->values(); //extrae unicamente el valor - el ID

                    $totalIDs = count($arrayPreguntasNuevasFecha);


                    for ($i = 0; $i < $totalIDs; $i++) {

                        $respuestaTipoFecha = array();
                        $respuestaTipoFecha = new Tutorias_respuestas();
                        $respuestaTipoFecha['Nombre'] = null;
                        $respuestaTipoFecha['Tipo'] = 4;
                        $respuestaTipoFecha['Semaforizacion'] = 0;
                        $respuestaTipoFecha['PreguntaID'] = $keysPreguntaID2[$i];



                        $respuestaTipoFecha->save();
                    }
                }

                alert('Escuela Modelo', 'El formulario se ha actualizado con éxito', 'success')->showConfirmButton();
                return redirect()->route('tutorias_formulario.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

                return redirect('tutorias_formulario/' . $FormularioID . '/edit')->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($FormularioID)
    {
        $formulario = Tutorias_formularios::findOrFail($FormularioID);

        $tutorias_pregunta_respuestas = Tutorias_pregunta_respuestas::where('FormularioID', '=', $FormularioID)->get();

        if(count($tutorias_pregunta_respuestas) <= 0){
            try {
                if($formulario->delete()){
                    alert('Escuela Modelo', 'El formulario se ha eliminado con éxito','success')->showConfirmButton();
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el formulario')->showConfirmButton();
                }
                
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
            return redirect()->route('tutorias_formulario.index');
        }else{
            alert()->warning('Escuela Modelo', 'No se puedo eliminar la información debido que hay encuestas relacionadas con el formulario seleccionado.')->showConfirmButton();
            return back();
        }

        
    }
}
