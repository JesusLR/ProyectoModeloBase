<?php

namespace App\Http\Controllers\Tutorias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tutorias\Tutorias_alumnos;
use App\Models\Tutorias\Tutorias_pregunta_respuestas;
use App\Models\Tutorias\Tutorias_respuestas;
use App\Models\Tutorias\Tutorias_tutores;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\SimpleType\Zoom;
use Yajra\DataTables\Facades\DataTables;

class TutoriasFactoresDeRiesgoController extends Controller
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
    public function index(Request $request)
    {
        $ubicacion = Ubicacion::get();

        return view('tutorias.factoresDeRiesgo.show-list', [
            'ubicacion' => $ubicacion
        ]);
    }

    public function list()
    {
        // $pregunta_respuesta = DB::table('tutorias_pregunta_respuestas')
        // ->select('tutorias_pregunta_respuestas.AlumnoID', DB::raw('count(*) as AlumnoID, tutorias_pregunta_respuestas.AlumnoID'), 
        // 'tutorias_pregunta_respuestas.Carrera', DB::raw('count(*) as Carrera, tutorias_pregunta_respuestas.Carrera'),
        // 'tutorias_pregunta_respuestas.Porcentaje', DB::raw('count(*) as Porcentaje, tutorias_pregunta_respuestas.Porcentaje'),
        // 'tutorias_pregunta_respuestas.Escuela', DB::raw('count(*) as Escuela, tutorias_pregunta_respuestas.Escuela'),
        // 'tutorias_pregunta_respuestas.Parcial', DB::raw('count(*) as Parcial, tutorias_pregunta_respuestas.Parcial'),
        // 'tutorias_pregunta_respuestas.Universidad', DB::raw('count(*) as Universidad, tutorias_pregunta_respuestas.Universidad'),
        // 'tutorias_alumnos.Matricula', DB::raw('count(*) as Matricula, tutorias_alumnos.Matricula'),
        // 'tutorias_alumnos.Nombre', DB::raw('count(*) as Nombre, tutorias_alumnos.Nombre'),
        // 'tutorias_alumnos.ApellidoPaterno', DB::raw('count(*) as ApellidoPaterno, tutorias_alumnos.ApellidoPaterno'),
        // 'tutorias_alumnos.ApellidoMaterno', DB::raw('count(*) as ApellidoMaterno, tutorias_alumnos.ApellidoMaterno'))
        // ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        // ->groupBy('tutorias_pregunta_respuestas.AlumnoID')
        // ->groupBy('tutorias_pregunta_respuestas.Carrera')
        // ->groupBy('tutorias_pregunta_respuestas.Porcentaje')
        // ->groupBy('tutorias_pregunta_respuestas.Escuela')
        // ->groupBy('tutorias_pregunta_respuestas.Parcial')
        // ->groupBy('tutorias_pregunta_respuestas.Universidad')
        // ->groupBy('tutorias_alumnos.Matricula')
        // ->groupBy('tutorias_alumnos.Nombre')
        // ->groupBy('tutorias_alumnos.ApellidoPaterno')
        // ->groupBy('tutorias_alumnos.ApellidoMaterno')
        // ->get();

        $pregunta_respuesta = Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.AlumnoID',
        'tutorias_pregunta_respuestas.Carrera',
        'tutorias_pregunta_respuestas.Porcentaje',
        'tutorias_pregunta_respuestas.Escuela',
        'tutorias_pregunta_respuestas.Parcial',
        'tutorias_pregunta_respuestas.Universidad',
        'tutorias_alumnos.Matricula',
        'tutorias_alumnos.Nombre',
        'tutorias_alumnos.ApellidoPaterno',
        'tutorias_alumnos.ApellidoMaterno',
        'periodos.perAnioPago',
        'tutorias_pregunta_respuestas.Semaforizacion as Colorsemaforo')
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->leftJoin('cursos', 'tutorias_alumnos.CursoID', '=', 'cursos.id')
        ->leftJoin('periodos', 'cursos.periodo_id', '=', 'periodos.id')
        ->orderBy('periodos.perAnioPago', 'DESC');




        return DataTables::of($pregunta_respuesta)

        ->filterColumn('periodo', function ($query, $keyword) {
            $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('periodo', function ($query) {
            return $query->perAnioPago;
        })

        ->filterColumn('NombreAlumno', function ($query, $keyword) {
            $query->whereRaw("CONCAT(Nombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('NombreAlumno', function ($query) {
            return $query->Nombre;
        })

        ->filterColumn('ApellidoPaterno', function ($query, $keyword) {
            $query->whereRaw("CONCAT(ApellidoPaterno) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ApellidoPaterno', function ($query) {
            return $query->ApellidoPaterno;
        })

        ->filterColumn('ApellidoMaterno', function ($query, $keyword) {
            $query->whereRaw("CONCAT(ApellidoMaterno) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ApellidoMaterno', function ($query) {
            return $query->ApellidoMaterno;
        })

        ->filterColumn('Universidad', function ($query, $keyword) {
            $query->whereRaw("CONCAT(tutorias_pregunta_respuestas.Universidad) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('Universidad', function ($query) {
            return $query->Universidad;
        })

        ->filterColumn('Escuela', function ($query, $keyword) {
            $query->whereRaw("CONCAT(tutorias_pregunta_respuestas.Escuela) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('Escuela', function ($query) {
            return $query->Escuela;
        })


        ->filterColumn('carrera', function ($query, $keyword) {
            $query->whereRaw("CONCAT(tutorias_pregunta_respuestas.Carrera) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('carrera', function ($query) {
            return $query->Carrera;
        })

        ->filterColumn('Matricula', function ($query, $keyword) {
            $query->whereRaw("CONCAT(Matricula) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('Matricula', function ($query) {
            return $query->Matricula;
        })


        ->filterColumn('semaforo', function ($query, $keyword) {

            if($keyword == "NO APLICA"){

                $keyword = "0";
                $query->whereRaw("CONCAT(tutorias_pregunta_respuestas.Semaforizacion) like ?", ["%{$keyword}%"]);
            }

            if($keyword == "VERDE"){

                $keyword = "1";
                $query->whereRaw("CONCAT(tutorias_pregunta_respuestas.Semaforizacion) like ?", ["%{$keyword}%"]);
            }

            if($keyword == "ROJO"){

                $keyword = "2";
                $query->whereRaw("CONCAT(tutorias_pregunta_respuestas.Semaforizacion) like ?", ["%{$keyword}%"]);
            }

            if($keyword == "AMARILLO"){

                $keyword = "3";
                $query->whereRaw("CONCAT(tutorias_pregunta_respuestas.Semaforizacion) like ?", ["%{$keyword}%"]);
            }
        })
        ->addColumn('semaforo', function ($query) {
            if($query->Colorsemaforo == 0){
                return 'No Aplica';
            }
            elseif($query->Colorsemaforo == 1){
                return 'Verde';
            }
            elseif($query->Colorsemaforo == 2){
                return 'Rojo';
            }
            elseif($query->Colorsemaforo == 3){
                return 'Amarillo';
            }
        })
    
    
        // ->addColumn('Semaforizacion', function ($query) {
            
        //     if($query->Semaforizacion == 0){
        //         return 'No Aplica';
        //     }
        //     elseif($query->Semaforizacion == 1){
        //         return 'Verde';
        //     }
        //     elseif($query->Semaforizacion == 2){
        //         rRojo';
        //     }
        //     elseif($query->Semaforizacion == 3){
        //         return 'Rojo';
        //     }
        // })
      
        
            ->addColumn('action', function ($pregunta_respuesta) {
                $acciones = '';

                $acciones = '<div class="row">
                
                  
                    <a href="/tutorias_tutorias/'.$pregunta_respuesta->AlumnoID.'/create" class="button button--icon js-button js-ripple-effect" title="Asignar tutor">
                    <i class="material-icons">person_add</i>
                    </a>

                    <a href="/tutorias_factores_riesgo/'.$pregunta_respuesta->AlumnoID.'/respuestas" class="button button--icon js-button js-ripple-effect" title="Ver respuestas">
                    <i class="material-icons">visibility</i>
                    </a>

                    <script>
                    $("#'.$pregunta_respuesta->AlumnoID.'").on( "click", function() {
                        if( $(this).is(":checked") ){
                            // Hacer algo si el checkbox ha sido seleccionado
                            console.log("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
                                                      
                        } else {
                            // Hacer algo si el checkbox ha sido deseleccionado
                            alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
                        }
                    });                   

                    
                    </script>

                </div>';

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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showRespuestas($AlumnoID)
    {
        // retorna datos para poner en el emcabezado 
        $respuestas_datos_alumno = Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.*',
        'tutorias_alumnos.*', 'tutorias_formularios.Nombre as NombreFormulario',
        'tutorias_formularios.FechaInicioVigencia',
        'tutorias_formularios.FechaFinVigencia')
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)->firstOrFail();

        // retorna las categorias de manera agrupada, que fueron respondidas por cada alumno
        $categoria_respuestas = DB::table('tutorias_pregunta_respuestas')
        ->select('tutorias_pregunta_respuestas.CategoriaID', DB::raw('count(*) as CategoriaID, tutorias_pregunta_respuestas.CategoriaID'),
        'tutorias_pregunta_respuestas.NombreCategoria', DB::raw('count(*) as NombreCategoria, tutorias_pregunta_respuestas.NombreCategoria'))        
        ->join('tutorias_alumnos', 'tutorias_pregunta_respuestas.AlumnoID', '=', 'tutorias_alumnos.AlumnoID')
        ->join('tutorias_formularios', 'tutorias_pregunta_respuestas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->groupBy('tutorias_pregunta_respuestas.CategoriaID')
        ->groupBy('tutorias_pregunta_respuestas.NombreCategoria')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->get();

        // retorna las respuestas que el alumno selecciono o respondio 
        $respuestas_alumno = Tutorias_pregunta_respuestas::select('tutorias_pregunta_respuestas.*', 'tutorias_preguntas.*')
        ->join('tutorias_preguntas', 'tutorias_pregunta_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->get();
        

        $respuestas_agrupadas = DB::table('tutorias_respuestas') 
        ->select('tutorias_respuestas.PreguntaID', DB::raw('count(*) as PreguntaID, tutorias_respuestas.PreguntaID'))
        ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $respuestas_datos_alumno->FormularioID)
        ->groupBy('tutorias_respuestas.PreguntaID')
        ->get();

        // retorna las respuestas disponibles que se encuentran en la tabla "tutorias_respuestas"
        $respuestasTable = Tutorias_respuestas::select('tutorias_respuestas.*')
        ->join('tutorias_preguntas', 'tutorias_respuestas.PreguntaID', '=', 'tutorias_preguntas.PreguntaID')
        ->join('tutorias_formularios', 'tutorias_preguntas.FormularioID', '=', 'tutorias_formularios.FormularioID')
        ->where('tutorias_preguntas.FormularioID', '=', $respuestas_datos_alumno->FormularioID)->get();


        /* -------------------------------------------------------------------------- */
        /*              retorna cantidad de datos de cada Semaforizacion              */
        /* -------------------------------------------------------------------------- */
        $SemaforizacionVerde = Tutorias_pregunta_respuestas::where('Semaforizacion', 1)
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->get();
        $totalVerde = count($SemaforizacionVerde);

        $SemaforizacionAmarillo = Tutorias_pregunta_respuestas::where('Semaforizacion', 2)
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->get();
        $totalAmarillo = count($SemaforizacionAmarillo);

        $SemaforizacionRojo = Tutorias_pregunta_respuestas::where('Semaforizacion', 3)
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->get();
        $totalRojo = count($SemaforizacionRojo);

        $SemaforizacionNoAplica = Tutorias_pregunta_respuestas::where('Semaforizacion', 0)
        ->where('tutorias_pregunta_respuestas.AlumnoID', '=', $AlumnoID)
        ->get();
        $totalNoAplica = count($SemaforizacionNoAplica);

        $totalRespuestas = $totalVerde + $totalAmarillo + $totalRojo + $totalNoAplica;
        /* -------------------------------------------------------------------------- */
        /*            fin retorna cantidad de datos de cada Semaforizacion            */
        /* -------------------------------------------------------------------------- */

       

        return view('tutorias.factoresDeRiesgo.respuestas', [
            'respuestas_datos_alumno' => $respuestas_datos_alumno,
            'categoria_respuestas' => $categoria_respuestas,
            'respuestas_alumno' => $respuestas_alumno,
            'totalVerde' => $totalVerde,
            'totalAmarillo' => $totalAmarillo,
            'totalRojo' => $totalRojo,
            'totalNoAplica' => $totalNoAplica,
            'totalRespuestas' => $totalRespuestas,
            'respuestasTable' => $respuestasTable
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $PreguntaRespuestaID)
    {
        $pregunta_respuesta = Tutorias_pregunta_respuestas::find($PreguntaRespuestaID);

        $pregunta_respuesta->fill($request->all());
        $pregunta_respuesta->save();

        return response()->json([
            "mesnsaje" => "Listo"
        ]);
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
