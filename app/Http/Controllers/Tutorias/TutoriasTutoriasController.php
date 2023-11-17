<?php

namespace App\Http\Controllers\Tutorias;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Tutorias\Tutorias_alumnos;
use App\Http\Models\Tutorias\Tutorias_detalle_tutorias;
use App\Http\Models\Tutorias\Tutorias_pregunta_respuestas;
use App\Http\Models\Tutorias\Tutorias_tutores;
use App\Http\Models\Tutorias\Tutorias_tutorias;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class TutoriasTutoriasController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($AlumnoID)
    {
        $tutorias_alumno = Tutorias_alumnos::where('AlumnoID', $AlumnoID)->first(); 

        $tutores = Tutorias_tutores::where('UniversidadID', $tutorias_alumno->UniversidadID)->where('EscuelaID', $tutorias_alumno->EscuelaID)->get();

        $alumno = Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.*', 'tutorias_alumnos.*',
            'tutorias_formularios.Nombre as nombreFormulario')
            ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
            ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
            ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)->first();

        
        $categorias = DB::table('tutorias_pregunta_respuestas') 
        ->select('CategoriaID', DB::raw('count(*) as CategoriaID, CategoriaID'),
        'NombreCategoria', DB::raw('count(*) as NombreCategoria, NombreCategoria'),
        'DescripcionCategoria', DB::raw('count(*) as DescripcionCategoria, DescripcionCategoria'))        
        ->where('AlumnoID', '=', $AlumnoID)
        ->groupBy('CategoriaID')
        ->groupBy('NombreCategoria')
        ->groupBy('DescripcionCategoria')

        ->get();

        return view('tutorias.factoresDeRiesgo.tutorias', [
            'tutores' => $tutores,
            'alumno' => $alumno,
            'categorias' => $categorias
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
        $AlumnoID = $request->AlumnoID;
        $validator = Validator::make(
            $request->all(),
            [
                'Titulo' => 'required',
                'TutorID' => 'required',
                'FechaInicio' => 'required',
                'FechaFin' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect('tutorias_tutorias/'.$AlumnoID.'/create')->withErrors($validator)->withInput();
        } else {
            try {
                
                $tutoria = Tutorias_tutorias::create([
                    'Titulo' => $request->Titulo,
                    'FormularioID' => $request->FormularioID,
                    'TutorID' => $request->TutorID,
                    'FechaInicio' => $request->FechaInicio,
                    'FechaFin' => $request->FechaFin,
                    'Estatus' => 0,
                    'Eliminado' => 0
                ]);

                $CategoriaID = $request->CategoriaID;
                $NombreCategoria = $request->NombreCategoria;
                $DescripcionCategoria = $request->DescripcionCategoria; 
    
                for ($i = 0; $i < count($CategoriaID); $i++) {
            
                    $detalle_tuturia = array();
                    $detalle_tuturia = new Tutorias_detalle_tutorias();
                    $detalle_tuturia['TutoriaID'] = $tutoria->TutoriaID;
                    $detalle_tuturia['AlumnoID'] = $AlumnoID;
                    $detalle_tuturia['CategoriaID'] = $CategoriaID[$i];
                    $detalle_tuturia['NombreCategoria'] = $NombreCategoria[$i];
                    $detalle_tuturia['DescripcionCategoria'] = $DescripcionCategoria[$i];
                    $detalle_tuturia['Semaforizacion'] = 0;
                    $detalle_tuturia['Comentario'] = null;
                    $detalle_tuturia['Conclucion'] = null;

                    $detalle_tuturia->save();
                }

                alert('Escuela Modelo', 'Se asigno el tutor con éxito', 'success')->showConfirmButton();
                return redirect('tutorias_factores_riesgo');
                
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

                return redirect('tutorias_tutorias/'.$AlumnoID.'/create')->withInput();
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
}
