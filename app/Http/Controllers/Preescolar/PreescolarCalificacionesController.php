<?php

namespace App\Http\Controllers\Preescolar;


use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
use Debugbar;
use PDF;


use App\Http\Models\Grupo;
use App\Http\Models\Curso;
use App\Http\Models\Cgt;
use App\Http\Models\Aula;
use App\Http\Models\Ubicacion;
use App\Http\Models\Empleado;
use App\Http\Models\Periodo;
use App\Http\Models\Programa;
use App\Http\Models\Plan;
use App\Http\Models\Escuela;
use App\Http\Models\Persona;
use App\Http\Models\Preescolar\Preescolar_grupo; //rutas prescolar
use App\Http\Models\Preescolar\Preescolar_inscrito; //rutas prescolar
use App\Http\Models\Preescolar\Preescolar_materia; //rutas prescolar
use App\Http\Models\Preescolar\Preescolar_calificacion; //rutas prescolar

use App\Http\Controllers\Controller;

class PreescolarCalificacionesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:preescolarcalificaciones',['except' => ['index','reporteTrimestre', 'reporteTrimestretodos', 'imprimirListaAsistencia']]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inscrito_id = $request->inscrito_id;
        $grupo_id = $request->grupo_id;
        $trimestre_a_evaluar = (int)$request->trimestre;
        $materia_id = $request->materia_id;
        $peraniopago = $request->peraniopago;

        $strWhereTrimestre = "";
        if ($trimestre_a_evaluar == 1) {
            $strWhereTrimestre = 'preescolar_calificaciones.trimestre1';
        }
        if ($trimestre_a_evaluar == 2) {
            $strWhereTrimestre = 'preescolar_calificaciones.trimestre2';
        }
        if ($trimestre_a_evaluar == 3) {
            $strWhereTrimestre = 'preescolar_calificaciones.trimestre3';
        }


        $calificaciones = DB::table('preescolar_calificaciones')
            ->where('preescolar_calificaciones.preescolar_inscrito_id', $inscrito_id)
            ->where($strWhereTrimestre, $trimestre_a_evaluar)
            ->where('preescolar_calificaciones.aplica', 'SI')
            ->whereNull('preescolar_calificaciones.deleted_at')
            ->orderBy('preescolar_calificaciones.orden_impresion', 'ASC')
            ->get();

        //OBTENER GRUPO SELECCIONADO
        //$grupo = Grupo::with('plan.programa', 'materia', 'empleado.persona')->find($grupo_id);
        //OBTENER PROMEDIO PONDERADO EN MATERIA
        //$materia = Preescolar_materia::where('id', $grupo->preescolar_materia_id)->first();
        //$escuela = Escuela::where('id', $grupo->plan->programa->escuela_id)->first();

        $grupo = Preescolar_grupo::with(
            'preescolar_materia',
            'periodo',
            'empleado.persona',
            'plan.programa.escuela.departamento.ubicacion'
        )
            ->find($grupo_id);

        $programas = $grupo->plan->programa;

        $depClave = $grupo->plan->programa->escuela->departamento->depClave;

        $inscrito = Preescolar_inscrito::find($inscrito_id);
        $inscrito_faltas = "";
        $inscrito_observaciones = "";
        if ($trimestre_a_evaluar == 1) {
            $inscrito_faltas = $inscrito->trimestre1_faltas;
            $inscrito_observaciones = $inscrito->trimestre1_observaciones;
        }
        if ($trimestre_a_evaluar == 2) {
            $inscrito_faltas = $inscrito->trimestre2_faltas;
            $inscrito_observaciones = $inscrito->trimestre2_observaciones;
        }
        if ($trimestre_a_evaluar == 3) {
            $inscrito_faltas = $inscrito->trimestre3_faltas;
            $inscrito_observaciones = $inscrito->trimestre3_observaciones;
        }
        $curso = Curso::with('alumno.persona')->find($inscrito->curso_id);
        $trimestre_edicion = 'SI';
        $grupo_abierto = 'SI';

        //dd($empleado);
        /*
        $grupo = Preescolar_grupo::with('preescolar_materia','periodo',
            'empleado.persona','plan.programa.escuela.departamento.ubicacion')
            ->select('preescolar_grupos.*')
            ->where('id',$grupo_id);
        */
        /*
        $data = DB::table('preescolar_calificaciones')
            ->select('preescolar_calificaciones.id',
                'preescolarpreescolar_calificaciones.tipo as categoria',
                'preescolar_calificaciones.trimestre1 as trimestre',
                'preescolar_calificaciones.rubrica as aprendizaje',
                'preescolar_calificaciones.trimestre1_nivel as nivel')
            ->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id);
            //->where('preescolar_calificaciones.preescolar_inscrito_id',$inscrito_id)
            //->orderBy("alumnos.id", "desc");
        */
        //return view('table_edit', compact('data'));

        $view_calificaciones = 'preescolar.show-list-calificaciones';
        if ($programas->progClave == 'PRE') {
            $view_calificaciones = 'preescolar.show-list-calificaciones';
            // view('preescolar.show-list-calificaciones');
        }
        if ($programas->progClave == 'MAT') {
            $view_calificaciones = 'preescolar.show-list-calificaciones-maternal';
        }

        // return View($view_calificaciones,

        return View(
            'preescolar.show-list-calificaciones',
            compact(
                'calificaciones',
                'grupo',
                'grupo_id',
                'inscrito_id',
                'inscrito_faltas',
                'inscrito_observaciones',
                'curso',
                'trimestre_a_evaluar',
                'trimestre_edicion',
                'grupo_abierto',
                'materia_id',
                'peraniopago',
                'depClave'
            )
        );
    }



    public function create()
    {
    }


    public function update(Request $request, $id)
    {
    }

    public function store(Request $request)
    {
        $materia_id = $request->materia_id;
        $peraniopago = $request->peraniopago;

        $grupo_id = $request->grupo_id;
        $trimestre_edicion = $request->trimestre_edicion;
        $inscrito_id = $request->inscrito_id;
        //$trimestre_a_evaluar = $request->trimestre_a_evaluar;
        $trimestre_faltas = 0;
        $trimestre_observaciones = "";

        $trimestre_faltas = $request->trimestreFaltas;
        $trimestre_observaciones = $request->trimestreObservaciones;

        $trimestre_a_evaluar = (int)$request->trimestre_a_evaluar;

        $strWhereTrimestre = "";
        if ($trimestre_a_evaluar == 1) {
            $strWhereTrimestre = 'preescolar_calificaciones.trimestre1';
        }
        if ($trimestre_a_evaluar == 2) {
            $strWhereTrimestre = 'preescolar_calificaciones.trimestre2';
        }
        if ($trimestre_a_evaluar == 3) {
            $strWhereTrimestre = 'preescolar_calificaciones.trimestre3';
        }

        try {

            $rubricas = DB::table('preescolar_calificaciones')
                ->where('preescolar_calificaciones.preescolar_inscrito_id', $inscrito_id)
                ->where($strWhereTrimestre, $trimestre_a_evaluar)
                ->where('preescolar_calificaciones.aplica', 'SI')
                ->get();

            $calificaciones = $request->calificaciones;

            //dd($rubricas, $calificaciones);


            if ($trimestre_a_evaluar == 1) {
                $trimestre1Col  = $request->has("calificaciones.trimestre1")  ? collect($calificaciones["trimestre1"])  : collect();
            }

            if ($trimestre_a_evaluar == 2) {
                $trimestre2Col  = $request->has("calificaciones.trimestre2")  ? collect($calificaciones["trimestre2"])  : collect();
            }

            if ($trimestre_a_evaluar == 3) {
                $trimestre3Col  = $request->has("calificaciones.trimestre3")  ? collect($calificaciones["trimestre3"])  : collect();
            }



            // dd($inscritos->map(function ($item, $key) {
            //     return $item->id;
            // })->all());

            foreach ($rubricas as $rubrica) {
                $calificacion = Preescolar_calificacion::where('id', $rubrica->id)->first();

                if ($trimestre_a_evaluar == 1) {
                    $inscCalificacionRubrica = $trimestre1Col->filter(function ($value, $key) use ($rubrica) {
                        return $key == $rubrica->id;
                    })->first();

                    if ($calificacion) {
                        $calificacion->trimestre1_nivel = $inscCalificacionRubrica != null ? $inscCalificacionRubrica : $calificacion->trimestre1_nivel;
                        $calificacion->save();

                        //$result =  DB::select("call procInscritoPromedioParcial("." ".$inscrito->id." )");
                    }
                }

                if ($trimestre_a_evaluar == 2) {
                    $inscCalificacionRubrica = $trimestre2Col->filter(function ($value, $key) use ($rubrica) {
                        return $key == $rubrica->id;
                    })->first();

                    if ($calificacion) {
                        $calificacion->trimestre2_nivel = $inscCalificacionRubrica != null ? $inscCalificacionRubrica : $calificacion->trimestre2_nivel;
                        $calificacion->save();
                        //$result =  DB::select("call procInscritoPromedioParcial("." ".$inscrito->id." )");
                    }
                }

                if ($trimestre_a_evaluar == 3) {
                    $inscCalificacionRubrica = $trimestre3Col->filter(function ($value, $key) use ($rubrica) {
                        return $key == $rubrica->id;
                    })->first();

                    if ($calificacion) {
                        $calificacion->trimestre3_nivel = $inscCalificacionRubrica != null ? $inscCalificacionRubrica : $calificacion->trimestre3_nivel;
                        $calificacion->save();
                        //$result =  DB::select("call procInscritoPromedioParcial("." ".$inscrito->id." )");
                    }
                }
            }

            $inscritofaltas = Preescolar_inscrito::where('id', $inscrito_id)->first();
            if ($inscritofaltas) {
                if ($trimestre_a_evaluar == 1) {
                    $inscritofaltas->trimestre1_faltas = $trimestre_faltas != null ? $trimestre_faltas : $inscritofaltas->trimestre1_faltas;
                    $inscritofaltas->trimestre1_observaciones = $trimestre_observaciones != null ? $trimestre_observaciones : $inscritofaltas->trimestre1_observaciones;
                }

                if ($trimestre_a_evaluar == 2) {
                    $inscritofaltas->trimestre2_faltas = $trimestre_faltas != null ? $trimestre_faltas : $inscritofaltas->trimestre2_faltas;
                    $inscritofaltas->trimestre2_observaciones = $trimestre_observaciones != null ? $trimestre_observaciones : $inscritofaltas->trimestre2_observaciones;
                }

                if ($trimestre_a_evaluar == 3) {
                    $inscritofaltas->trimestre3_faltas = $trimestre_faltas != null ? $trimestre_faltas : $inscritofaltas->trimestre3_faltas;
                    $inscritofaltas->trimestre3_observaciones = $trimestre_observaciones != null ? $trimestre_observaciones : $inscritofaltas->trimestre3_observaciones;
                }

                $inscritofaltas->save();
            }


            alert('Escuela Modelo', 'Se registraron las calificaciones con éxito', 'success')->showConfirmButton()->autoClose(3000);
            return redirect('preescolarinscritos/' . $grupo_id . '/' . $materia_id . '/' . $peraniopago);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return redirect('preescolarinscritos/' . $grupo_id . '/' . $materia_id . '/' . $peraniopago)->withInput();
        }
    }

    public function reporteTrimestre($inscrito_id, $personas_id, $gpoGrado, $gpoClave, $peraniopago, $trimestre_a_evaluar)
    {

        if ($trimestre_a_evaluar == 1) {
            $calificaciones_array = DB::table('preescolar_calificaciones')
                ->where('preescolar_calificaciones.preescolar_inscrito_id', $inscrito_id)
                ->where('preescolar_calificaciones.trimestre1', $trimestre_a_evaluar)
                ->where('preescolar_calificaciones.aplica', 'SI')
                ->whereNull('preescolar_calificaciones.deleted_at')
                ->orderBy('preescolar_calificaciones.orden_impresion', 'asc')
                ->get();


            
        } elseif ($trimestre_a_evaluar == 2) {
            $calificaciones_array = DB::table('preescolar_calificaciones')
                ->where('preescolar_calificaciones.preescolar_inscrito_id', $inscrito_id)
                ->where('preescolar_calificaciones.trimestre2', $trimestre_a_evaluar)
                ->where('preescolar_calificaciones.aplica', 'SI')
                ->whereNull('preescolar_calificaciones.deleted_at')
                ->orderBy('preescolar_calificaciones.orden_impresion', 'asc')
                ->get();
        } else {
            $calificaciones_array = DB::table('preescolar_calificaciones')
                ->where('preescolar_calificaciones.preescolar_inscrito_id', $inscrito_id)
                ->where('preescolar_calificaciones.trimestre3', $trimestre_a_evaluar)
                ->where('preescolar_calificaciones.aplica', 'SI')
                ->whereNull('preescolar_calificaciones.deleted_at')
                ->orderBy('preescolar_calificaciones.orden_impresion', 'asc')
                ->get();
        }



        if (!$calificaciones_array) {
            alert()->warning('Sin coincidencias', 'No hay calificaciones capturadas para este alumno. Favor de verificar')->showConfirmButton();
            return back()->withInput();
        }

        $calificaciones_collection = collect($calificaciones_array);

        $persona = Persona::findOrFail($personas_id);
        $inscritos = Preescolar_inscrito::findOrFail($inscrito_id);
        if ($trimestre_a_evaluar == 1) {
            $trimestre_faltas = $inscritos->trimestre1_faltas;
            $trimestre_observaciones = $inscritos->trimestre1_observaciones;
        }
        if ($trimestre_a_evaluar == 2) {
            $trimestre_faltas = $inscritos->trimestre2_faltas;
            $trimestre_observaciones = $inscritos->trimestre2_observaciones;
        }
        if ($trimestre_a_evaluar == 3) {
            $trimestre_faltas = $inscritos->trimestre3_faltas;
            $trimestre_observaciones = $inscritos->trimestre3_observaciones;
        }

        $grupos = Preescolar_grupo::findOrFail($inscritos->preescolar_grupo_id);
        $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
        $personaDocente = Persona::findOrFail($empleado->persona_id);

        $grupo = Preescolar_grupo::with(
            'preescolar_materia',
            'periodo',
            'empleado.persona',
            'plan.programa.escuela.departamento.ubicacion'
        )
            ->findOrFail($inscritos->preescolar_grupo_id);
        $programas = $grupo->plan->programa;

        $fechaActual = Carbon::now();

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $anioSiguiente = (int)$peraniopago;
        $anioSiguiente = $anioSiguiente + 1;
        $cicloEscolar = "CICLO " . $peraniopago . " – " . (string)$anioSiguiente;

        if ($trimestre_a_evaluar == 1) {
            $numeroReporte = "Primer Reporte";
        } elseif ($trimestre_a_evaluar == 2) {
            $numeroReporte = "Segundo Reporte";
        } elseif ($trimestre_a_evaluar == 3) {
            $numeroReporte = "Tercer Reporte";
        } else {
            $numeroReporte = "";
        }

        $kinderGradoTrimestre = "KINDER " . $gpoGrado . $gpoClave . " - " . $numeroReporte;
        $nombreAlumno = $persona->perNombre . " " . $persona->perApellido1 . " " . $persona->perApellido2;
        $nombreDocente = $personaDocente->perNombre . " " . $personaDocente->perApellido1 . " " . $personaDocente->perApellido2;

        $nombreArchivo = 'pdf_preescolar_reporte_aprovechamiento';
        if ($programas->progClave == 'PRE') {
            $nombreArchivo = 'pdf_preescolar_reporte_aprovechamiento';
            $kinderGradoTrimestre = "KINDER " . $gpoGrado . $gpoClave . " - " . $numeroReporte;
        }
        if ($programas->progClave == 'MAT') {
            if ($trimestre_a_evaluar == 1) {
                $nombreArchivo = 'pdf_maternal_primer_reporte';
            } elseif ($trimestre_a_evaluar == 2) {
                $nombreArchivo = 'pdf_maternal_segundo_reporte';
            } elseif ($trimestre_a_evaluar == 3) {
                $nombreArchivo = 'pdf_maternal_tercer_reporte';
            } else {
                $nombreArchivo = 'pdf_maternal_primer_reporte';
            }

            $kinderGradoTrimestre = "MATERNAL " . $gpoGrado . $gpoClave . " - " . $numeroReporte;
        }

        // return $calificaciones_collection;
        // view('reportes.pdf.preescolar.calificaciones.pdf_preescolar_reporte_aprovechamiento');
        // view('reportes.pdf.pdf_preescolar_reporte_aprovechamiento');
                // view('reportes.pdf.pdf_maternal_primer_reporte');

        $pdf = PDF::loadView('reportes.pdf..preescolar.calificaciones.' . $nombreArchivo, [
            "calificaciones" => $calificaciones_collection,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cicloEscolar" => $cicloEscolar,
            "kinderGradoTrimestre" => $kinderGradoTrimestre,
            "nombreAlumno" => $nombreAlumno,
            "nombreDocente" => $nombreDocente,
            "trimestre_faltas" => $trimestre_faltas,
            "trimestre_observaciones" => $trimestre_observaciones,
            "trimestre_a_evaluar" => $trimestre_a_evaluar,
            "nombreArchivo" => $nombreArchivo
        ]);


        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($nombreArchivo . '.pdf');
        return $pdf->download($nombreArchivo  . '.pdf');
    }

    public function reporteTrimestretodos($grupo_id, $trimestre_a_evaluar)
    {

        $cursos_grupo = Preescolar_inscrito::select(
            'cursos.id as curso_id',
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'alumnos.aluMatricula',
            'personas.perNombre',
            'personas.id as personas_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'cursos.curEstado',
            'cursos.curTipoIngreso',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progNombre',
            'programas.progClave',
            'escuelas.escNombre',
            'escuelas.escClave',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiNombre',
            'ubicacion.ubiClave',
            'preescolar_grupos.gpoGrado',
            'preescolar_inscritos.id as inscrito_id',
            'preescolar_inscritos.preescolar_grupo_id',
            'preescolar_grupos.gpoClave',
            'preescolar_inscritos.trimestre1_faltas',
            'preescolar_inscritos.trimestre1_observaciones',
            'preescolar_inscritos.trimestre2_faltas',
            'preescolar_inscritos.trimestre2_observaciones',
            'preescolar_inscritos.trimestre3_faltas',
            'preescolar_inscritos.trimestre3_observaciones',
            'periodos.perAnioPago',
            'empleadoDocente.perApellido1 as empApellido1',
            'empleadoDocente.perApellido2 as empApellido2',
            'empleadoDocente.perNombre as empNombre'
        )
            ->join('cursos', 'preescolar_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('preescolar_grupos', 'preescolar_inscritos.preescolar_grupo_id', '=', 'preescolar_grupos.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('empleados', 'preescolar_grupos.empleado_id_docente', '=', 'empleados.id')
            ->leftJoin('personas as empleadoDocente', 'empleados.persona_id', '=', 'empleadoDocente.id')
            ->where('preescolar_grupos.id', $grupo_id)
            ->whereNull('preescolar_inscritos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->whereNull('cgt.deleted_at')
            ->whereNull('preescolar_grupos.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereIn('depClave', ['PRE', 'MAT'])
            ->orderBy("personas.perApellido1", "asc")
            ->orderBy("personas.perApellido2", "asc")
            ->orderBy("personas.perNombre", "asc")
            ->get();

        //dd($calificaciones_array);

        $grupos_collection = collect($cursos_grupo);

        // return count($grupos_collection);

        if ($grupos_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
            return back();
        }


        $persona = Persona::findOrFail($cursos_grupo[0]->personas_id);
        //$inscritos = Preescolar_inscrito::findOrFail($cursos_grupo->inscrito_id);
        $grupos = Preescolar_grupo::findOrFail($cursos_grupo[0]->preescolar_grupo_id);
        $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
        $personaDocente = Persona::findOrFail($empleado->persona_id);
        //$trimestre_faltas = $inscritos->trimestre1_faltas;
        // $trimestre_observaciones = $inscritos->trimestre1_observaciones;

        $grupo = Preescolar_grupo::with(
            'preescolar_materia',
            'periodo',
            'empleado.persona',
            'plan.programa.escuela.departamento.ubicacion'
        )
            ->findOrFail($cursos_grupo[0]->preescolar_grupo_id);
        $programas = $grupo->plan->programa;

        $fechaActual = Carbon::now();

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $anioSiguiente = (int)$cursos_grupo[0]->perAnioPago;
        $anioSiguiente = $anioSiguiente + 1;
        $cicloEscolar = "CICLO " . $cursos_grupo[0]->perAnioPago . " – " . (string)$anioSiguiente;

        // valida que trimestre es para asginar un nombre de reporte
        if ($trimestre_a_evaluar == 1) {
            $numeroReporte = "Primer Reporte";
        } elseif ($trimestre_a_evaluar == 2) {
            $numeroReporte = "Segundo Reporte";
        } elseif ($trimestre_a_evaluar == 3) {
            $numeroReporte = "Tercer Reporte";
        } else {
            $numeroReporte = "";
        }

        $kinderGradoTrimestre = "KINDER " . $cursos_grupo[0]->gpoGrado . $cursos_grupo[0]->gpoClave . " - " . $numeroReporte;
        $nombreAlumno = $persona->perNombre . " " . $persona->perApellido1 . " " . $persona->perApellido2;
        $nombreDocente = $personaDocente->perNombre . " " . $personaDocente->perApellido1 . " " . $personaDocente->perApellido2;



        $nombreArchivo = 'pdf_preescolar_reporte_general_aprovechamiento';
        if ($programas->progClave == 'PRE') {
            $nombreArchivo = 'pdf_preescolar_reporte_general_aprovechamiento';
            $kinderGradoTrimestre = "KINDER " . $cursos_grupo[0]->gpoGrado . $cursos_grupo[0]->gpoClave . " - " . $numeroReporte;
        }
        if ($programas->progClave == 'MAT') {
            // FALTA IMPLEMENTAR LA VISTA DEL REPORTE DE MATERNAL DE TODO EL GRUPO
            $nombreArchivo = 'pdf_maternal_reporte_general_aprovechamiento';
            $kinderGradoTrimestre = "MATERNAL " . $cursos_grupo[0]->gpoGrado . $cursos_grupo[0]->gpoClave . " - " . $numeroReporte;
        }

        // view('reportes.pdf.pdf_preescolar_reporte_general_aprovechamiento');
        // view('reportes.pdf.pdf_maternal_reporte_general_aprovechamiento');


        $pdf = PDF::loadView('reportes.pdf.' . $nombreArchivo, [
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "cicloEscolar" => $cicloEscolar,
            "kinderGradoTrimestre" => $kinderGradoTrimestre,
            "nombreDocente" => $nombreDocente,
            "nombreArchivo" => $nombreArchivo,
            "trimestre" => $trimestre_a_evaluar,
            "trimestre_a_evaluar" => $trimestre_a_evaluar,
            "cursos_grupo" => $grupos_collection

        ]);

        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($nombreAlumno . '_' . $nombreArchivo . '.pdf');
        return $pdf->download($nombreAlumno . '_' . $nombreArchivo  . '.pdf');
        /*}*/
    }

    public function imprimirListaAsistencia($grupo_id)
    {

        $cursos_grupo = Curso::select(
            'cursos.id as curso_id',
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'alumnos.aluMatricula',
            'personas.perNombre',
            'personas.id as personas_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'cursos.curEstado',
            'cursos.curTipoIngreso',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progNombre',
            'programas.progClave',
            'escuelas.escNombre',
            'escuelas.escClave',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiNombre',
            'ubicacion.ubiClave',
            'preescolar_grupos.gpoGrado',
            'preescolar_inscritos.id as inscrito_id',
            'preescolar_inscritos.preescolar_grupo_id',
            'preescolar_grupos.gpoClave',
            'preescolar_inscritos.trimestre1_faltas',
            'preescolar_inscritos.trimestre2_faltas',
            'preescolar_inscritos.trimestre3_faltas',
            'preescolar_inscritos.trimestre1_observaciones',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'preescolar_materias.matNombre'
        )
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('preescolar_inscritos', 'cursos.id', '=', 'preescolar_inscritos.curso_id')
            ->join('preescolar_grupos', 'preescolar_inscritos.preescolar_grupo_id', '=', 'preescolar_grupos.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('preescolar_materias', 'preescolar_grupos.preescolar_materia_id', '=', 'preescolar_materias.id')
            ->where('preescolar_inscritos.preescolar_grupo_id', $grupo_id)
            ->whereIn('depClave', ['PRE'])
            ->orderBy("personas.perApellido1", "asc")
            ->orderBy("personas.perApellido2", "asc")
            ->orderBy("personas.perNombre", "asc")
            ->get();
        $fechaActual = Carbon::now('CDT');


        foreach ($cursos_grupo as $item) {
            $persona = Persona::findOrFail($item->personas_id);
            $inscritos = Preescolar_inscrito::findOrFail($item->inscrito_id);
            $grupos = Preescolar_grupo::findOrFail($inscritos->preescolar_grupo_id);
            $empleado = Empleado::findOrFail($grupos->empleado_id_docente);
            $personaDocente = Persona::findOrFail($empleado->persona_id);
            $periodo = Periodo::findOrFail($item->periodo_id);
            $programa = Programa::findOrFail($item->programa_id);
            $plan = Plan::findOrFail($item->plan_id);

            // ubicacion
            $ubiClave = $item->ubiClave;
            $ubiNombre = $item->ubiNombre;
            $preescolar_materia = $item->matNombre;
        }



        $info = collect([
            'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
            'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
            'ubicacion' => $ubiClave . ' ' . $ubiNombre,

            // grupo y grado
            'gradoAlumno' => $grupos->gpoGrado,
            'grupoAlumno' => $grupos->gpoClave,
            // maestro
            'nombreDocente' => $personaDocente->perNombre . ' ' . $personaDocente->perApellido1 . ' ' . $personaDocente->perApellido2,

            // programa
            'progClave' => $programa->progClave,
            'progNombre' => $programa->progNombre,
            'progNombreCorto' => $programa->progNombreCorto,

            // plan
            'planClave' => $plan->planClave,

            //materia
            'preescolar_materia' => $preescolar_materia

        ]);




        // echo '<br>';
        // echo 'plan id ' . $grupos->plan_id;
        // echo '<br>';
        // echo 'turno ' .$grupos->gpoTurno;

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $nombreArchivo = 'Lista preescolar';
        $pdf = PDF::loadView('reportes.pdf.pdf_preescolar_lista_asistencia', [
            "info" => $info,
            "cursos_grupo" => $cursos_grupo,
            "nombreArchivo" => $nombreArchivo,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
        ]);

        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($info['gradoAlumno'] . $info['grupoAlumno'] . "_" . $nombreArchivo);
        return $pdf->download($info['gradoAlumno'] . $info['grupoAlumno'] . "_" . $nombreArchivo);
    }
    public function destroy($id)
    {
    }
}
