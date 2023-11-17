<?php

namespace App\Http\Controllers\Idiomas;

use Lang;
use App\clases\cuotas\MetodosCuotas;
use App\Http\Models\CuotaDescuento;
use App\Http\Models\Departamento;
// use App\Http\Models\Preescolar\Preescolar_materia;
use App\Http\Models\Idiomas\Idiomas_materias;
use PDF;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Helpers\ClubdePanchito;
use App\Http\Helpers\SuperUsuario;
use App\Http\Models\Beca;
use App\Http\Models\Cgt;
use App\Http\Models\Curso;
use App\Http\Models\Idiomas\Idiomas_cursos;
use App\Http\Models\CursoObservaciones;
use App\Http\Models\Pago;
use App\Models\Modules;
use App\Models\Permission;
use App\Models\Permission_module_user;
use App\Models\User;
use App\Http\Models\Escuela;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Models\Baja;
use App\Http\Models\Plan;
// use App\Http\Models\Cuota;
use App\Http\Models\Idiomas\Idiomas_cuotas;
use App\Http\Models\Idiomas\Idiomas_resumen_calificacion;
use App\Http\Models\Idiomas\Idiomas_calificaciones_materia;
use App\Http\Models\Idiomas\Idiomas_grupos;
use App\Http\Models\Ficha;
use App\Http\Models\Grupo;
use App\Http\Models\Alumno;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Models\Periodo;
use App\Http\Models\Inscrito;
use App\Http\Models\Historico;
use App\Http\Models\Ubicacion;
use App\Http\Models\Calificacion;
use App\Http\Models\ConceptoBaja;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Http\Helpers\GenerarReferencia;
use App\Http\Controllers\Reportes\ColegiaturasController;
use App\Http\Models\Programa;
use App\clases\cgts\MetodosCgt;

class IdiomasCursoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:curso',['except' => ['index','show','list','getCursos','getCursoAlumno']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registroUltimoPago = Pago::select(DB::raw('MAX(pagFechaPago)'))->where("pagFormaAplico", "=", "A")->latest()->first();
        $registroUltimoPago = Carbon::parse($registroUltimoPago->pagFechaPago)->day
        . "/" . Utils::num_meses_corto_string(Carbon::parse($registroUltimoPago->pagFechaPago)->month)
        . "/" . Carbon::parse($registroUltimoPago->pagFechaPago)->year;

        return View('idiomas.curso_preinscrito.show-list', [
            "registroUltimoPago" => $registroUltimoPago

        ]);
    }

    public function list()
    {
        $cursos = Idiomas_cursos::select(
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',

            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'alumnos.aluMatricula',
            'alumnos.aluEstado',

            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',

            'idiomas_grupos.gpoGrado',
            'idiomas_grupos.gpoClave',
            'idiomas_grupos.gpoDescripcion',

            'idiomas_cursos.id as curso_id',
            'idiomas_cursos.curFechaRegistro',
            'idiomas_cursos.curFechaBaja',
            'idiomas_cursos.curEstado',
            'idiomas_cursos.curImporteInscripcion',
            'idiomas_cursos.curImporteMensualidad',
            'idiomas_cursos.curFechaCuota',
            
            'planes.planClave',
            'programas.progNombre',
            'programas.progClave',
            'escuelas.escNombre',
            'escuelas.escClave',
            'departamentos.depNombre',
            'departamentos.depClave',
            'ubicacion.ubiNombre',
            'idiomas_resumen_calificaciones.rcFinalScore',
            'ubicacion.ubiClave')
            ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
            ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
            ->leftJoin('idiomas_resumen_calificaciones', 'idiomas_cursos.id', '=', 'idiomas_resumen_calificaciones.idiomas_curso_id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->whereNull('idiomas_resumen_calificaciones.deleted_at')
            ->whereIn('depClave', ['IDI']);

        return Datatables::of($cursos)
            ->filterColumn('perNombre', function($query, $keyword) {
                return $query->whereHas('persona', function($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('perNombre', function($query) {
                return $query->perNombre;
            })
            ->filterColumn('perApellido1', function($query, $keyword) {
                return $query->whereHas('persona', function($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('perApellido1', function($query) {
                return $query->perApellido1;
            })
            ->filterColumn('perApellido2', function($query, $keyword) {
                return $query->whereHas('persona', function($query) use ($keyword) {
                    $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
                });
            })
            ->addColumn('perApellido2', function($query) {
                return $query->perApellido2;
            })
            ->filterColumn('beca',function($query,$keyword) {
                return $query->whereRaw("CONCAT(curTipoBeca, curPorcentajeBeca) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('beca', function($query){
                return $query->curTipoBeca . $query->curPorcentajeBeca;
            })
            ->addColumn('action', function($query) {

                $pedirConfirmacion = 'NO';

                $userDepClave = "IDI";
                $userClave = Auth::user()->username;

                $btnTarjetaPagoBBVA = "";
                $btnTarjetaPagoHSBC = "";

                $btnFichaPagoBBVA = "";
                $btnFichaPagoHSBC = "";

                $btnFichaPagoBBVA = '<a href="#modalFichaPago" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="'.$pedirConfirmacion.'"  class=" btn-modal-ficha-pago button button--icon js-button js-ripple-effect" title="Ficha BBVA">
                    <i class="material-icons">local_atm</i>
                </a>';
                $btnFichaPagoHSBC = '<a href="#modalFichaPago" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="'.$pedirConfirmacion.'"  class=" btn-modal-ficha-pago-hsbc button button--icon js-button js-ripple-effect" title="Ficha HSBC">
                    <i class="material-icons">description</i>
                </a>';

                $btnBajaARegular = '<a href="#modalBajaARegularCurso" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-baja-a-regular button button--icon js-button js-ripple-effect " title="Cambiar Estado">
                    <i class="material-icons">unarchive</i>
                </a>';

                $btnCambiarCarrera = '<a href="'.url("idiomas_cambiar_carrera/{$query->curso_id}").'" class="button button--icon js-button js-ripple-effect" title="Cambiar grupos">
                    <i class="material-icons">autorenew</i>
                </a>';

                if ($query->curEstado == "B" || $query->curEstado == "R" || $query->curEstado == "X") {
                    $btnFichaPagoBBVA = "";
                    $btnFichaPagoHSBC = "";
                }

                if ($query->curEstado == "R") {
                    if( ( SuperUsuario::tieneSuperPoder($userDepClave, $userClave) )
                        || ClubdePanchito::esAmigo($userDepClave, $userClave) )
                    {
                        $btnTarjetaPagoBBVA = '<a target="_blank" href="tarjetaPagoAlumno/'.$query->curso_id.'/BBVA" class="button modal-trigger button--icon js-button js-ripple-effect" title="BBVA">
                            <i class="material-icons">format_bold</i>
                        </a>';
                    }
                }

                if ($query->curEstado == "R") {
                    if( ( SuperUsuario::tieneSuperPoder($userDepClave, $userClave) )
                        || ClubdePanchito::esAmigo($userDepClave, $userClave) )
                    {
                        $btnTarjetaPagoHSBC = '<a target="_blank" href="tarjetaPagoAlumno/'.$query->curso_id.'/HSBC" class="button modal-trigger button--icon js-button js-ripple-effect" title="HSBC">
                            <i class="material-icons">strikethrough_s</i>
                        </a>';
                    }
                }

                $btnEliminarCurso = "";
                if ($query->curEstado == "B") {
                    $btnEliminarCurso = '<form style="display: inline-block;" id="delete_'.$query->curso_id.'" action="curso/'.$query->curso_id.'" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <a href="#" data-id="'.$query->curso_id.'" class="button button--icon js-button js-ripple-effect confirm-delete-curso" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                }

                $btnMostrarAcciones = '';
                if (Auth::user()->idiomas == 1)
                {
                    $userDepClave = "IDI";
                    $userClave = Auth::user()->username;

                    $btnFichaPagoBBVA = "";
                    $btnFichaPagoHSBC = "";

                    if ($query->curEstado == "P") {
                        $btnFichaPagoBBVA = '<a href="#modalFichaPago" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="'.$pedirConfirmacion.'"  class=" btn-modal-ficha-pago button button--icon js-button js-ripple-effect" title="Ficha BBVA">
                        <i class="material-icons">local_atm</i>
                        </a>';
                        $btnFichaPagoHSBC = '<a href="#modalFichaPago" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="'.$pedirConfirmacion.'"  class=" btn-modal-ficha-pago-hsbc button button--icon js-button js-ripple-effect" title="Ficha HSBC">
                        <i class="material-icons">description</i>
                        </a>';
                    }

                    $btnTarjetaPagoBBVA = "";
                    $btnTarjetaPagoHSBC = "";
                    if ($query->curEstado == "R") {
                                $btnTarjetaPagoBBVA = '<a target="_blank" href="tarjetaPagoAlumnoIdi/' . $query->curso_id .
                                    '/BBVA" class="button modal-trigger button--icon js-button js-ripple-effect" title="BBVA">
                                        <i class="material-icons">format_bold</i>
                                    </a>';

                                $btnTarjetaPagoHSBC = '<a target="_blank" href="tarjetaPagoAlumnoIdi/' . $query->curso_id .
                                    '/HSBC" class="button modal-trigger button--icon js-button js-ripple-effect" title="HSBC">
                                    <i class="material-icons">strikethrough_s</i>
                                    </a>';

                        
                    }

                    $btnEditarCurso = "";

                    $btnEditarCurso = '<a href="/idiomas_curso/' . $query->curso_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';

                    $btnMostrarAcciones = '<a href="#modalAlumnoDetalle-idiomas" data-alumno-id="' . $query->alumno_id . '" class="modal-trigger btn-modal-alumno-detalle-idiomas button button--icon js-button js-ripple-effect " title="Ver Alumno Detalle">
                        <i class="material-icons">face</i>
                    </a>
                    <a href="/idiomas_curso/'.$query->curso_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                    </a>'
                        . $btnFichaPagoBBVA . $btnFichaPagoHSBC .
                    '<a href="#modalHistorialPagosIdiomas" data-nombres="' . $query->perNombre." ".$query->perApellido1." ".$query->perApellido2 .
                        '" data-aluclave="'. $query->aluClave .'" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-historial-pagos-idiomas button button--icon js-button js-ripple-effect" title="Historial Pagos">
                        <i class="material-icons">attach_money</i>
                    </a>'
                        . $btnTarjetaPagoBBVA . $btnTarjetaPagoHSBC . $btnEditarCurso .
                    '<a href="#modalBajaCursoIdiomas" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-baja-curso button button--icon js-button js-ripple-effect " title="Baja curso">
                        <i class="material-icons">archive</i>
                    </a>
                    <a href="/idiomas_curso/'. $query->curso_id .'/historial_calificaciones_alumno/" class="button button--icon js-button js-ripple-effect" title="Historial Calificaciones Alumno">
                        <i class="material-icons">library_books</i>
                    </a>'
                        . $btnBajaARegular //.
                        . $btnCambiarCarrera;
                    // '<a href="/idiomas_curso/observaciones/'.$query->curso_id.'" class="button button--icon js-button js-ripple-effect" title="Observaciones">
                    //     <i class="material-icons">subtitles</i>
                    // </a>';
                }

                return
                    $btnMostrarAcciones;
                })
            ->make(true);
    }

    public function getDepartamentosListaCompleta(Request $request, $ubicacion_id)
    {
        $departamentos = Departamento::where('ubicacion_id', $ubicacion_id)->get();

        if($request->ajax())
            return response()->json($departamentos);
    }

    public function getEscuelas(Request $request)
    {

        if($request->ajax()){
            $escuelas = Escuela::where('departamento_id','=',$request->id)
                ->where(function($query) use ($request) {
                    $query->where("escNombre", "like", "ACADEMIA%");

                    if ($request->otro == "diplomados") {
                        $query->orWhere('escNombre', "like", "DIPLOMADOS%");
                    }
                })
            ->get();

            return response()->json($escuelas);
        }
    }

    public function getMateriasByPlan(Request $request, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Idiomas_materias::where([
                ['plan_id', '=', $plan_id]
            ])->get();

            return response()->json($materias);
        }
    }

    public function observaciones(Request $request)
    {
        $curso = Idiomas_cursos::find($request->curso_id);
        $cursoObservaciones = DB::table("cursos_observaciones")->where("cursos_id", "=", $request->curso_id)->first();

        return view("idiomas.curso_preinscrito.observaciones", [
            "curso" => $curso,
            "cursoObservaciones" => $cursoObservaciones
        ]);
    }

    public function storeObservaciones(Request $request)
    {


        $validator = Validator::make($request->all(),
            [
                'image' => 'mimes:pdf|file|max:10000',
            ],
            [
                'image.mimes' => "El archivo solo puede ser de tipo PDF",
                'image.max'   => "El archivo no debe de pesar más de 10 Megas"
            ]
        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imageName ="";
        if ($request->image) {
            $imageName = $request->curso_id . "-" . time() . '.' .request()->image->getClientOriginalExtension();
            $path = $request->image->move(storage_path(env("OBSERVACIONES_PAGO_PATH")), $imageName);
        }


        $existeObservacionCurso = CursoObservaciones::where("cursos_id", "=", $request->curso_id)->first();

        try {
            if ($existeObservacionCurso) {

                if(file_exists(storage_path(env("OBSERVACIONES_PAGO_PATH").$existeObservacionCurso->curPagoArchivo))) {
                    File::delete(storage_path(env("OBSERVACIONES_PAGO_PATH").$existeObservacionCurso->curPagoArchivo));
                }

                CursoObservaciones::where("cursos_id", "=", $request->curso_id)->update([
                    "curPagoObservaciones" => $request->curPagoObservaciones,
                    "curPagoArchivo" => $imageName
                ]);
            } else {
                CursoObservaciones::create([
                    "cursos_id" => $request->curso_id,
                    "curPagoObservaciones" => $request->curPagoObservaciones,
                    "curPagoArchivo" => $imageName
                ]);
            }


            alert('Escuela Modelo', 'Se ha creado con éxito','success')->showConfirmButton();
            return redirect()->back()->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }


    }

    public function cursoArchivoObservaciones (Request $request) {
        $existeObservacionCurso = CursoObservaciones::where("cursos_id", "=", $request->curso_id)->first();
        return response()->download(storage_path(env("OBSERVACIONES_PAGO_PATH").$existeObservacionCurso->curPagoArchivo));
    }


    public function constanciaBeca(Request $request)
    {
        $curso = Curso::with("alumno.persona", "periodo.departamento.ubicacion", "cgt.plan.programa")
            ->where("id", $request->curso_id)->where("curTipoBeca", "<>", null)->first();

        if (!$curso) {
            alert()->error('Ups...', 'El alumno no cuenta con una beca')->showConfirmButton()->autoClose(5000);
            return back();
        }


        $fechaActual = Carbon::now();

        $pdf = PDF::loadView('curso.archivos.pdf_constancia_beca', [
            "curso" => $curso,
            "fechaActual" => $fechaActual->toDateString(),
        ]);

        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream('curso.archivos.pdf_constancia_beca');
        return $pdf->download('curso.archivos.pdf_constancia_beca');
    }

        /**
    * Verifica si el curso tiene inscritos, para notificar al usuario que está intentando
    * dar de baja el curso.
    */
    public function verificar_materias_cargadas(Request $request, Curso $curso)
    {
        $check = Idiomas_cursos::join('idiomas_resumen_calificaciones', 'idiomas_resumen_calificaciones.idiomas_curso_id', '=', 'idiomas_cursos.id')
        ->join('idiomas_calificaciones_materia', 'idiomas_calificaciones_materia.idiomas_resumen_calificaciones_id', '=', 'idiomas_resumen_calificaciones.id')
        ->join('idiomas_materias', 'idiomas_materias.id', '=', 'idiomas_calificaciones_materia.idiomas_materia_id')
        ->where('idiomas_cursos.id', $curso->id)
        ->get();
        return response()->json([
            'tiene_materias_cargadas' => $check->isNotEmpty(),
            'inscritos' => $check,
        ]);
    }

    public function bajaCurso(Request $request)
    {
        $cursoId = $request->curso_id;
        $estatusBajBajaTotal = "";

        $curso = Idiomas_cursos::join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('idiomas_cursos.id',$cursoId)
        ->first();

        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $curso->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion) {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.','error')->showConfirmButton();
            return redirect()->back();
        }

        $estadoCursoAntesDeBaja = $curso->curEstado;

        // 1) borrar todos las grupos - materias de este alumno
        $grupo = Idiomas_grupos::where('id', $curso->grupo_id);
        $grupos = $grupo->get();
        // $gruposDelete = $grupo->delete();

        // 1.5) BORRAR CALIFICACIONES
        $rc = Idiomas_resumen_calificacion::where('idiomas_curso_id', $cursoId);
        $resumen = $rc->first();
        if ($resumen) {
            $rc->delete();
            Idiomas_calificaciones_materia::where('idiomas_resumen_calificaciones_id', $resumen->id)->delete();
        }

        // 2) cambiar estado del curso a B)aja de este alumno
        $bajaCurso = Idiomas_cursos::find($request->curso_id);
        $bajaCurso->curEstado = "B";
        $bajaCurso->curFechaBaja = $request->fechaBaja;
        $bajaCurso->save();


        // 3) verificar si usuario pidio baja total y cambiar estadoAlu de alumnos a B)aja
        if ($request->bajBajaTotal == "SI") {
            $alumno = Alumno::where("aluClave", "=", $curso->aluClave)->update(["aluEstado" => "B"]);
            $estatusBajBajaTotal = "C";
        }

        try {
            Baja::create([
                'curso_id'             => $cursoId,
                'bajTipoBeca'          => $curso->curTipoBeca ? $curso->curTipoBeca: "", // hay tipos de beca en idiomas?
                'bajPorcentajeBeca'    => $curso->curPorcentajeBeca ? $curso->curPorcentajeBeca: 0,// hay tipos de beca en idiomas?
                'bajObservacionesBeca' => $curso->curObservacionesBeca ? $curso->curObservacionesBeca: "",// hay tipos de beca en idiomas?
                'bajFechaRegistro'     => $curso->curFechaRegistro,
                'bajFechaBaja'         => $request->fechaBaja,
                'bajEstadoCurso'       => $estadoCursoAntesDeBaja,
                'bajBajaTotal'         => $estatusBajBajaTotal,
                'bajRazonBaja'         => $request->conceptosBaja,
                'bajObservaciones'     => $request->bajObservaciones,
            ]);

            alert('Escuela Modelo', 'Alumno dado de baja con éxito','success')->showConfirmButton();
            return back();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();

            return back()->withInput();
        }

    }


    public function altaCurso(Request $request)
    {
        $cursoId = $request->curso_id;
        $inscritosEliminados = $request->inscritosEliminados ? $request->inscritosEliminados: [];

        $bajaCurso = Idiomas_cursos::find($request->curso_id);

        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $bajaCurso->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion && $bajaCurso->curEstado == "B") {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.','error')->showConfirmButton();
            return redirect()->back();
        }

        Idiomas_grupos::onlyTrashed()->where('id', $bajaCurso->grupo_id)->restore();
        $rc = Idiomas_resumen_calificacion::onlyTrashed()->where('idiomas_curso_id', $cursoId);
        $resumen = $rc->first();
        $rc->restore();
        if (!$resumen) {
            $rc = Idiomas_resumen_calificacion::where('idiomas_curso_id', $cursoId);
            $resumen = $rc->first();
        }
        Idiomas_calificaciones_materia::onlyTrashed()->where('idiomas_resumen_calificaciones_id', $resumen->id)->restore();

        $bajaCurso->curEstado = $request->curEstado;
        $bajaCurso->curFechaBaja = null;
        $bajaCurso->save();

        alert('Escuela Modelo', 'Alumno dado de alta con éxito','success')->showConfirmButton();
        return back()->withInput();
    }


    public function listPosiblesHermanos(Request $request)
    {
        $cursoId = $request->curso_id;
        $curso = Curso::with("alumno.persona")->where("id", $cursoId)->first();
        $posiblesHermanos = collect();

        if ($curso->curTipoBeca == "H") {
            $posiblesHermanos = Alumno::with("persona")
                ->where("aluClave", "<>", $curso->alumno->aluClave)
                ->where("aluEstado", "<>", "B")
                ->whereHas('persona', function($query) use ($curso) {
                    $query->where("perApellido1", "=", $curso->alumno->persona->perApellido1);
                    $query->where("perApellido2", "=", $curso->alumno->persona->perApellido2);
                })
            ->get();
        }

        return Datatables::of($posiblesHermanos)
            ->addColumn('nombreCompleto', function($query) {
                return $query->persona->perNombre . " " . $query->persona->perApellido1 . " " . $query->persona->perApellido2;
            })
        ->make(true);
    }

    public function infoBaja(Request $request)
    {
        // $curso = Curso::with("alumno.persona", "periodo", "cgt.plan.programa")->where("id", $request->curso_id)->first();
        $curso = Idiomas_cursos::select(
            'idiomas_cursos.id AS curso_id',
            'programas.progClave',
            'programas.progNombre',
            'periodos.perAnio',
            'periodos.perNumero',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'alumnos.aluClave'
        )
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->where("idiomas_cursos.id", $request->curso_id)->first();

        $count = Idiomas_cursos::join('idiomas_resumen_calificaciones', 'idiomas_resumen_calificaciones.idiomas_curso_id', '=', 'idiomas_cursos.id')
        ->join('idiomas_calificaciones_materia', 'idiomas_calificaciones_materia.idiomas_resumen_calificaciones_id', '=', 'idiomas_resumen_calificaciones.id')
        ->join('idiomas_materias', 'idiomas_materias.id', '=', 'idiomas_calificaciones_materia.idiomas_materia_id')
        ->where('idiomas_cursos.id', $request->curso_id)
        ->where('idiomas_cursos.curEstado', "!=", "B")
        ->count();

        $inscritosEliminados = Inscrito::with("grupo.materia")->where("curso_id", "=", $request->curso_id)->onlyTrashed()->get();

        return response()->json([
            'cantidadInscritos' => $count,
            'progClave'         => $curso->progClave,
            'progNombre'        => $curso->progNombre,
            'perAnio'           => $curso->perAnio,
            'perNumero'         => $curso->perNumero,
            'alumno'            => strtoupper($curso->perNombre . " " .
                                    $curso->perApellido1 . " " .
                                    $curso->perApellido2),
            'aluClave'          => $curso->aluClave,
            'inscritosEliminados' => $inscritosEliminados
        ]);
    }

    public function conceptosBaja(Request $request)
    {
        $conceptoBaja = ConceptoBaja::all();
        return response()->json($conceptoBaja);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //OBTENER PERMISO DE USUARIO
        $user = Auth::user();
        $modulo = Modules::where('slug','curso')->first();
        $permisos = Permission_module_user::where('user_id',$user->id)->where('module_id',$modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;

        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $tiposIngreso =  [
            'PI' => 'PRIMER INGRESO',
            'RI' => 'REINSCRIPCIÓN',
            'RE' => 'REINGRESO',
        ];

        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $opcionTitulo = SI_NO;
        $tiposBeca = Beca::get();
        $alumno = null;



        return view('idiomas.curso_preinscrito.create',compact('ubicaciones','planesPago','tiposIngreso','tiposBeca', 'estadoCurso', 'permiso','alumno'));
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
                'alumno_id' => 'required|unique:idiomas_cursos,alumno_id,NULL,id,periodo_id,' . $request->input('periodo_id').',deleted_at,NULL',
                'grupo_id'    => 'required',

            ],
            [
                'alumno_id.unique' => "El alumno ya existe en el curso",
            ]
        );

        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $request->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion) {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.','error')->showConfirmButton();
            return redirect()->back();
        }

        $periodo = Periodo::findOrFail($request->periodo_id);

        $curso = Idiomas_cursos::select('idiomas_cursos.*')
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->where('alumno_id', $request->alumno_id)
        ->where('periodos.perNumero', $periodo->perNumero)
        ->where('periodos.perAnio', $periodo->perAnio)
        ->where('curEstado', '<>', 'B')
        ->first();

        if ($curso) {
            alert()->error('Error...', 'El alumno ya esta preinscrito a un curso para este periodo')->showConfirmButton();
            return redirect('idiomas_curso/create')->withInput();
        }

        if ($validator->fails()) {
            return redirect ('idiomas_curso/create')->withErrors($validator)->withInput();
        }

        $alumno = Alumno::where("id", "=", $request->alumno_id)->first();

        $alumnoAluEstado = $alumno->aluEstado;
        $eliddelalumno = $request->alumno_id;

        $elCursoEstado = "P";
        $elConceptodePago = $periodo->iniciaEnAgosto() ? "49" : "50";
        $elAniodePago = $periodo->perAnioPago;
        $laAluClave = $alumno->aluClave;
        $existePagodeInscripcion = DB::table("pagos")->where('pagClaveAlu', $laAluClave)
        ->where("pagConcPago", "=", $elConceptodePago)
        ->where("pagAnioPer", "=", $elAniodePago)
        ->first();
        if ($existePagodeInscripcion) {
                $elCursoEstado = "R";
        }

        try {
            $curso = Idiomas_cursos::create([
                'periodo_id'            => $request->periodo_id,
                'alumno_id'             => $request->alumno_id,
                'grupo_id'                => $request->grupo_id,
                'curFechaRegistro'      => Carbon::now()->format("Y-m-d"),
                'curEstado'             => $elCursoEstado,
                'curImporteInscripcion' => Utils::validaEmpty($request->curImporteInscripcion),
                'curImporteMensualidad' => Utils::validaEmpty($request->curImporteMensualidad),
                'cuota_user_id'         => auth()->user()->id,
                'curFechaCuota'         => $request->curFechaCuota
            ]);

            $resumen = Idiomas_resumen_calificacion::create([
                'idiomas_curso_id' => $curso->id
            ]);

            $materias = Idiomas_materias::select('idiomas_materias.id')
            ->join('idiomas_grupos', 'idiomas_materias.matSemestre', '=', 'idiomas_grupos.gpoGrado')
            ->where('idiomas_materias.plan_id', $request->plan_id)
            ->where('idiomas_grupos.id', $request->grupo_id)
            ->get();

            foreach ($materias as $materia) {
                Idiomas_calificaciones_materia::create([
                    'idiomas_resumen_calificaciones_id' => $resumen->id,
                    'idiomas_materia_id' => $materia->id
                ]);
            }

            alert('Escuela Modelo', 'El curso se ha creado con éxito','success')->showConfirmButton();
            return redirect()->route('curso_idiomas.index');

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('idiomas_curso/create')->withInput();
        }
    }

    public function getMultipleAlumnosByFilter(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        if($request->ajax()){
            $alumnos = Alumno::with("persona")
                ->where('aluEstado', '!=', 'B')
                ->whereIn('aluEstado', ['E','R', 'N'])
                ->whereHas('persona', function($query) use ($request) {
                    $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$request->nombreAlumno}%"]);
                });

            if ($request->aluClave) {
                $alumnos = $alumnos->where('aluClave', '=', $request->aluClave);
            }

            $alumnos = $alumnos->get();


            //$alumnos = Alumno::with('persona:id,perNombre,perApellido1,perApellido2')->where('aluEstado','!=','B')->where('aluEstado','!=','E')->get();
            return response()->json($alumnos);
        }
    }

    /*
    * Creada para la vista curso.create.
    * retorna si el alumno tiene últimoCurso.
    */
    public function ultimoCurso(Request $request, $alumno_id) {

        $curso = Idiomas_cursos::select(
            'idiomas_cursos.id AS idiomas_curso_id',
			'alumnos.aluClave',
			'personas.perNombre',
			'personas.perApellido1',
			'personas.perApellido2',
            'idiomas_grupos.id AS idiomas_grupo_id',
			'idiomas_grupos.gpoGrado',
			'idiomas_grupos.gpoClave',
			'idiomas_grupos.gpoDescripcion',
            'planes.id AS plan_id',
			'planes.planClave',
            'programas.id AS programa_id',
			'programas.progClave',
			'programas.progNombre',
            'escuelas.id AS escuela_id',
			'escuelas.escClave',
			'escuelas.escNombre',
            'ubicacion.id AS ubicacion_id',
			'ubicacion.ubiClave',
			'ubicacion.ubiNombre',
            'periodos.id AS periodo_id',
			'periodos.perNumero',
            'periodos.perEstado',
			'periodos.perAnio',
            'periodos.perFechaInicial',
            'departamentos.id AS departamento_id',
            'departamentos.perSig'
		)
		->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
		->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
		->join('programas', 'planes.programa_id', '=', 'programas.id')
		->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
		->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
		->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
		->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
		->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
		->join('personas', 'alumnos.persona_id', '=', 'personas.id')
		->where('alumnos.id', $alumno_id)
        ->where('idiomas_cursos.curEstado', '<>', 'B')
		->first();

         $data = null;
         if($curso) {

            $grupo_siguiente = $this->grupo_siguiente($curso);

            $data = [
                'curso' => $curso,
                'idiomas_grupo_id' => $curso->idiomas_grupo_id,
                'plan_id' => $curso->plan_id,
                'programa_id' => $curso->programa_id,
                'escuela_id' => $curso->escuela_id,
                'departamento_id' => $curso->departamento_id,
                'ubicacion_id' => $curso->ubicacion_id,
                'periodo_id' => $curso->periodo_id,
                'periodoSiguiente' => $curso->perSig,
                'grupo_siguiente' => "$grupo_siguiente->id"
            ];
         }
         return json_encode($data);
    }//ultimocCurso.

    public function grupo_siguiente($curso) {
        $grupo_siguiente = null;

        $periodoSiguiente = Periodo::where('departamento_id', $curso->departamento_id)
            ->where('perEstado', $curso->perEstado)
            ->whereDate('perFechaInicial','>', $curso->perFechaInicial)
            ->first();

        if(!$periodoSiguiente) {
            $periodoSiguiente->id = $curso->perSig;
        }

        $idiomas_grupos = Idiomas_grupos::where('plan_id', $curso->plan_id)
            ->where('periodo_id', $periodoSiguiente->id)
            ->where('gpoGrado',$curso->gpoGrado + 1)->get();
        if($idiomas_grupos) {
            $grupo_siguiente = $idiomas_grupos->where('gpoGrado', $curso->gpoGrado)->first();
            if(!$grupo_siguiente) {
                $grupo_siguiente = $idiomas_grupos->sortBy('gpoGrado')->first();
            }
        }
        return $grupo_siguiente;
    } //grupo_siguiente.

    // INSCRIPCION POR PAQUETES, GRUPO, POR MATERIA, EDIT DE INSCRITOS
    public function getCursos(Request $request, $cgt_id)
    {
        if($request->ajax()){
            $cursos = Curso::with('alumno.persona')->where('cgt_id', $cgt_id)->whereIn("curEstado", ["R", "C", "A", "P"])->get();
            return response()->json($cursos);
        }
    }

         /**
     * Show alumno curso.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCursoAlumno(Request $request,$aluClave, $cuoAnio)
    {
        if ($request->ajax()) {
            $curso = Curso::with('alumno.persona','cgt.plan.programa','cgt.periodo.departamento.ubicacion')
                ->whereHas('cgt.periodo', function($query) use ($cuoAnio) {
                    $query->where('perAnioPago', $cuoAnio)->orderBy('perNumero', 'desc');
                })
                ->whereHas('alumno', function($query) use ($aluClave) {
                    $query->where('aluClave', $aluClave);
                })->get()->sortBy("cgt.periodo.perAnio")->last();


            return response()->json($curso);
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
        $curso = Idiomas_cursos::select(
            'idiomas_cursos.*',
            'ubicacion.ubiNombre',
            'departamentos.depNombre',
            'escuelas.escNombre',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.progNombre',
            'planes.planClave',
            'idiomas_grupos.gpoGrado',
            'idiomas_grupos.gpoClave',
            'idiomas_grupos.gpoDescripcion',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2'
        )
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('idiomas_cursos.id', $id)
        ->first();
        $tiposIngreso = TIPOS_INGRESO_PREES_PRI_SEC;
        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $tiposBeca = Beca::get();
        $opcionTitulo = SI_NO;

        // fechas de la tabla cursos
        $fecha_creacion = $curso->created_at;
        $fecha_update = $curso->updated_at;
        $lafechabuena = "";
        $quemostrar= "";

        if($fecha_creacion < $fecha_update){
            $lafechabuena = $fecha_update;
            $quemostrar = "Fecha de actulización";
        }else{
            $lafechabuena = $fecha_creacion;
            $quemostrar = "Fecha de creación";

        }

        $usuario_at = User::with('empleado.persona')->where('id', $curso->usuario_at)->first();

        $esAlumnoMensaje = 'No es alumno registrado en la Esc.Modelo en el curso actual';
        $esAlumno = DB::select("call procIdiomasEsAlumno({$id})");
        if(count($esAlumno)>0) {
            if($esAlumno[0]->esAlumno == 'S') {
                $curso_id = $esAlumno[0]->cursoAcademicoId;
                $cursoModelo = Curso::select('programas.progNombre', 'cgt.cgtGradoSemestre', 'cgt.cgtGrupo')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->where('cursos.id', $curso_id)->first();
                $esAlumnoMensaje = 'Alumno inscrito en: '.$cursoModelo->progNombre.' '.$cursoModelo->cgtGradoSemestre.' '.$cursoModelo->cgtGrupo.' en el curso actual';
            }
        }

        return view('idiomas.curso_preinscrito.show', compact(
            'curso',
            'tiposIngreso',
            'planesPago',
            'estadoCurso',
            'tiposBeca',
            'opcionTitulo',
            'usuario_at',
            'lafechabuena',
            'quemostrar',
            'esAlumnoMensaje'
            )
        );
    }


    public function listHistorialPagos(Request $request)
    {
        $curso = Idiomas_cursos::select(
            'alumnos.aluClave AS aluClave',
            'periodos.perAnioPago AS perAnioPago'
        )
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->where('idiomas_cursos.id', $request->curso_id)
        ->first();

        $pagos = Pago::with('concepto')->where('pagClaveAlu', $curso->aluClave)
            ->where('pagAnioPer', $curso->perAnioPago)
            ->where('pagEstado', 'A')
            ->whereIn('pagConcPago', ['49','50','51','52','53','54','55','56','57','58','59','60'])
            ->get()
            ->sortByDesc(static function($pago, $key) {
                return $pago->pagAnioPer.'-'.$pago->concepto->ordenReportes;
            });

        return Datatables::of($pagos)
            ->addColumn('pagImpPago', static function(Pago $pago) {
                return '$'.$pago->pagImpPago;
            })
            ->addColumn('pagFechaPago', static function(Pago $pago) {
                return Utils::fecha_string($pago->pagFechaPago, 'mesCorto');
            })->toJson();
    }//listHistorialPagos.

    public function listHistorialPagosAluclave(Request $request)
    {
        $pagos = Pago::with('concepto')
        ->where('pagClaveAlu', $request->aluClave)->where('pagEstado', 'A')
        ->whereIn('pagConcPago', ['49','50','51','52','53','54','55','56','57','58','59','60'])->get()
        ->sortByDesc(static function($pago, $key) {
            return $pago->pagAnioPer.' '.$pago->concepto->ordenReportes;
        });

        return DataTables::of($pagos)
        ->addColumn('conpNombre', static function(Pago $pago) {
            return $pago->pagConcPago.' '.$pago->concepto->conpNombre;
        })
        ->addColumn('pagImpPago', static function(Pago $pago) {
            return '$'.$pago->pagImpPago;
        })
        ->addColumn('pagFechaPago', static function(Pago $pago) {
            return Utils::fecha_string($pago->pagFechaPago, 'mesCorto');
        })->toJson();
    }


    public function listPreinscritoDetalle(Request $request)
    {
        $cursoId = $request->curso_id;
        $curso = Curso::with('alumno.persona','cgt.plan.programa.escuela.departamento.ubicacion', 'cgt.periodo')->findOrFail($cursoId);
        $estadoCurso  = ESTADO_CURSO;
        $tiposIngreso = TIPOS_INGRESO_PREES_PRI_SEC;
        $opcionTitulo = SI_NO;
        $planesPago   = PLANES_PAGO;

        $tiposBeca = Beca::get();


        $curEstado = collect($estadoCurso)->filter(function ($value, $key) use ($curso) {
            return $key == $curso->curEstado;
        })->first();

        $curTipoIngreso = collect($tiposIngreso)->filter(function ($value, $key) use ($curso) {
            return $key == $curso->curTipoIngreso;
        })->first();

        $curOpcionTitulo = collect($opcionTitulo)->filter(function ($value, $key) use ($curso) {
            return $key == $curso->curOpcionTitulo;
        })->first();

        $curPlanPago = collect($planesPago)->filter(function ($value, $key) use ($curso) {
            return $key == $curso->curPlanPago;
        })->first();

        $curTipoBeca = collect($tiposBeca)->filter(function ($value, $key) use ($curso) {
            return $value->bcaClave == $curso->curTipoBeca;
        })->first();

        return response()->json([
            "curso"           => $curso,
            "curEstado"       => $curEstado,
            "curTipoIngreso"  => $curTipoIngreso,
            "curOpcionTitulo" => $curOpcionTitulo,
            "curPlanPago"     => $curPlanPago,
            "curTipoBeca"     => $curTipoBeca ? $curTipoBeca->bcaNombre: "",
        ]);
    }

    public function historialCalificacionesAlumno(Request $request)
    {
        $curso = Idiomas_cursos::select(
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.progClave',
            'programas.progNombre',
            'idiomas_cursos.id AS curso_id',
            'alumnos.aluClave',
            'personas.*'
        )
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where("idiomas_cursos.id", "=", $request->curso_id)->first();

        return view("idiomas.curso_preinscrito.historialCalificacionesAlumno", [
            "curso" => $curso
        ]);
    }


    public function listHistorialCalifAlumnos (Request $request)
    {
        $calificaciones = Idiomas_resumen_calificacion::select(
            'idiomas_resumen_calificaciones.idiomas_curso_id AS cursoId',
            'planes.planClave',
            'idiomas_materias.matClave',
            'idiomas_materias.matNombre',
            'idiomas_calificaciones_materia.cmReporte1',
            'idiomas_calificaciones_materia.cmReporte2',
            'idiomas_calificaciones_materia.cmReporte3',
            'idiomas_calificaciones_materia.cmReporte4',
            'idiomas_resumen_calificaciones.rcMidTerm',
            'idiomas_resumen_calificaciones.rcFinalExam',
            'idiomas_resumen_calificaciones.rcFinalScore',
            'idiomas_resumen_calificaciones.rcProject1',
            'idiomas_resumen_calificaciones.rcProject2'
        )
        ->join('idiomas_cursos', 'idiomas_resumen_calificaciones.idiomas_curso_id', '=', 'idiomas_cursos.id')
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('idiomas_calificaciones_materia', 'idiomas_resumen_calificaciones.id', '=', 'idiomas_calificaciones_materia.idiomas_resumen_calificaciones_id')
        ->join('idiomas_materias', 'idiomas_materias.id', '=', 'idiomas_calificaciones_materia.idiomas_materia_id')
        ->where('idiomas_curso_id', $request->curso_id);

        return Datatables::of($calificaciones)->make(true);
    }

    public function listHistorialCalifAlumnosResumen (Request $request)
    {
        $calificacion = Idiomas_resumen_calificacion::select(
            'idiomas_resumen_calificaciones.rcReporte1',
            'idiomas_resumen_calificaciones.rcReporte1Ponderado',
            'idiomas_resumen_calificaciones.rcReporte2',
            'idiomas_resumen_calificaciones.rcReporte2Ponderado',
            'idiomas_resumen_calificaciones.rcMidTerm',
            'idiomas_resumen_calificaciones.rcMidTermPonderado',
            'idiomas_resumen_calificaciones.rcProject1',
            'idiomas_resumen_calificaciones.rcProject1Ponderado',
            'idiomas_resumen_calificaciones.rcReporte3',
            'idiomas_resumen_calificaciones.rcReporte3Ponderado',
            'idiomas_resumen_calificaciones.rcReporte4',
            'idiomas_resumen_calificaciones.rcReporte4Ponderado',
            'idiomas_resumen_calificaciones.rcFinalExam',
            'idiomas_resumen_calificaciones.rcFinalExamPonderado',
            'idiomas_resumen_calificaciones.rcProject2',
            'idiomas_resumen_calificaciones.rcProject2Ponderado',
            'idiomas_resumen_calificaciones.rcFinalScore'
        )
        ->join('idiomas_cursos', 'idiomas_resumen_calificaciones.idiomas_curso_id', '=', 'idiomas_cursos.id')
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('idiomas_calificaciones_materia', 'idiomas_resumen_calificaciones.id', '=', 'idiomas_calificaciones_materia.idiomas_resumen_calificaciones_id')
        ->join('idiomas_materias', 'idiomas_materias.id', '=', 'idiomas_calificaciones_materia.idiomas_materia_id')
        ->where('idiomas_curso_id', $request->curso_id)->first();
        $info = [
            0 => [
                'evaluacion' => 'Reporte 1',
                'calificacion' => $calificacion->rcReporte1,
                'ponderado' => $calificacion->rcReporte1Ponderado,
            ],
            1 => [
                'evaluacion' => 'Reporte 2',
                'calificacion' => $calificacion->rcReporte2,
                'ponderado' => $calificacion->rcReporte2Ponderado,
            ],
            2 => [
                'evaluacion' => 'MidTerm',
                'calificacion' => null,
                'ponderado' => $calificacion->rcMidTermPonderado,
            ],
            3 => [
                'evaluacion' => 'Proyecto 1',
                'calificacion' => null,
                'ponderado' => $calificacion->rcProject1Ponderado,
            ],
            4 => [
                'evaluacion' => 'Reporte 3',
                'calificacion' => $calificacion->rcReporte3,
                'ponderado' => $calificacion->rcReporte3Ponderado,
            ],
            5 => [
                'evaluacion' => 'Reporte 4',
                'calificacion' => $calificacion->rcReporte4,
                'ponderado' => $calificacion->rcReporte4Ponderado,
            ],
            6 => [
                'evaluacion' => 'Final Exam',
                'calificacion' => null,
                'ponderado' => $calificacion->rcFinalExamPonderado,
            ],
            7 => [
                'evaluacion' => 'Proyecto 2',
                'calificacion' => null,
                'ponderado' => $calificacion->rcProject2Ponderado,
            ],
            8 => [
                'evaluacion' => 'Final Score',
                'calificacion' => null,
                'ponderado' => $calificacion->rcFinalScore,
            ],
        ];
        $data = collect($info);
        return Datatables::of($data)->make(true);
    }

    public function materiasFaltantes(Request $request)
    {
        $curso = Curso::findOrFail($request->curso_id);

        return view("curso.materiasFaltantes", [
            "curso" => $curso
        ]);
    }


    public function listMateriasFaltantes (Request $request)
    {
        $curso = Curso::findOrFail($request->curso_id);

        $resultado = DB::select('call procMateriasFaltantes(' . $curso->cgt->plan->id . ',' .
            $curso->alumno->id . ',' . $curso->cgt->plan->programa->escuela->departamento->depCalMinAprob . ',' .
            $curso->cgt->cgtGradoSemestre . ')');

        $datos = new Collection();

        for ($i = 0; $i < count($resultado); $i++) {
            $matClave = $resultado[$i]->matClave;
            $matNombre = $resultado[$i]->matNombre;
            $matSemestre = $resultado[$i]->matSemestre;
            $matClasificacion = $resultado[$i]->matClasificacion;

            if ($matClasificacion == 'B') {
                $matClasificacion = 'Bas';
            } elseif ($matClasificacion == 'O') {
                $matClasificacion = 'Opt';
            }
            $histFechaExamen = $resultado[$i]->histFechaExamen;
            $histFechaExamen = Utils::fecha_string($histFechaExamen, true);

            if ($histFechaExamen == NULL) {
                $histFechaExamen = 'No ha sido cursada';
            }

            $histCalificacion = $resultado[$i]->histCalificacion;
            $histTipoAcreditacion = $resultado[$i]->histTipoAcreditacion;

            $matTipoAcreditacion = $resultado[$i]->matTipoAcreditacion;

            if ($matTipoAcreditacion == 'A') {
                if ($histCalificacion == 1) {
                    $histCalificacion = 'No Apr';
                }
            }
            if ($histCalificacion == -1) {
                $histCalificacion = 'No presentó';
            }

            $datos->push([
                'matClave' => $matClave,
                'matNombre' => $matNombre,
                'matSemestre' => $matSemestre,
                'matClasificacion' => $matClasificacion,
                'histFechaExamen' => $histFechaExamen,
                'histCalificacion' => $histCalificacion,
                'histTipoAcreditacion' => $histTipoAcreditacion,
            ]);
        }

        return Datatables::of($datos)->make(true);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curso = Idiomas_cursos::select(
            'idiomas_cursos.*',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiNombre',
            'departamentos.id as departamento_id',
            'departamentos.depNombre',
            'escuelas.id as escuela_id',
            'escuelas.escNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.id as programa_id',
            'programas.progNombre',
            'planes.id as plan_id',
            'planes.planClave',
            // 'idiomas_niveles.nivGrado',
            'idiomas_grupos.gpoGrado',
            'idiomas_grupos.gpoClave',
            'idiomas_grupos.gpoDescripcion',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2'
        )
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        // ->join('idiomas_niveles', 'idiomas_grupos.gpoGrado', '=', 'idiomas_niveles.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('idiomas_cursos.id', $id)
        ->first();
        $tiposIngreso = TIPOS_INGRESO_PREES_PRI_SEC;
        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $tiposBeca = Beca::get();
        $opcionTitulo = SI_NO;

        // fechas de la tabla cursos
        $fecha_creacion = $curso->created_at;
        $fecha_update = $curso->updated_at;
        $lafechabuena = "";
        $quemostrar= "";

        if($fecha_creacion < $fecha_update){
            $lafechabuena = $fecha_update;
            $quemostrar = "Fecha de actulización";
        }else{
            $lafechabuena = $fecha_creacion;
            $quemostrar = "Fecha de creación";

        }

        $usuario_at = User::with('empleado.persona')->where('id', $curso->usuario_at)->first();

        $esAlumnoMensaje = 'No es alumno registrado en la Esc.Modelo en el curso actual';
        $esAlumno = DB::select("call procIdiomasEsAlumno({$id})");
        if(count($esAlumno)>0) {
            if($esAlumno[0]->esAlumno == 'S') {
                $curso_id = $esAlumno[0]->cursoAcademicoId;
                $cursoModelo = Curso::select('programas.progNombre', 'cgt.cgtGradoSemestre', 'cgt.cgtGrupo')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->where('cursos.id', $curso_id)->first();
                $esAlumnoMensaje = 'Alumno inscrito en: '.$cursoModelo->progNombre.' '.$cursoModelo->cgtGradoSemestre.' '.$cursoModelo->cgtGrupo.' en el curso actual';
            }
        }

        return view('idiomas.curso_preinscrito.edit', compact(
            'curso',
            'tiposIngreso',
            'planesPago',
            'estadoCurso',
            'tiposBeca',
            'opcionTitulo',
            'usuario_at',
            'lafechabuena',
            'quemostrar',
            'esAlumnoMensaje'
            )
        );
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
        // dd($request->all(), $id);
        try {
            $curso = Idiomas_cursos::findOrFail($id);

            // $curso->cgt_id          = $request->cgt_id;
            $curso->curEstado               = $request->curEstado;
            $curso->curImporteInscripcion   = Utils::validaEmpty($request->curImporteInscripcion);
            $curso->curImporteMensualidad   = Utils::validaEmpty($request->curImporteMensualidad);
            $curso->curEstado               = $request->curEstado;
            // $curso->curImporteVencimiento   = Utils::validaEmpty($request->curImporteVencimiento);
            // $curso->curImporteDescuento     = Utils::validaEmpty($request->curImporteDescuento);
            // $curso->curDiasProntoPago       = Utils::validaEmpty($request->curDiasProntoPago);
            // $curso->curPlanPago             = $request->curPlanPago;
            // $curso->curTipoBeca             = $request->curTipoBeca;
            // $curso->curPorcentajeBeca       = Utils::validaEmpty($request->curPorcentajeBeca);
            // $curso->curObservacionesBeca    = $request->curObservacionesBeca;

            $curso->save();

            alert('Escuela Modelo', 'El curso se ha actualizado con éxito','success')->showConfirmButton();
            return redirect()->route('curso_idiomas.index');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
            return redirect('curso_idiomas')->withInput();
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
        $curso = Curso::findOrFail($id);

        if($curso->inscritos->isNotEmpty()) {
            alert('Ups!...', 'El alumno tiene materias cargadas, no puede borrar este registro. Favor de contactar al administrador del sistema.', 'warning')->showConfirmButton();
            return redirect('idiomas_curso')->withInput();
        }

        try {
            if (Utils::validaPermiso('curso',$curso->cgt->plan->programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);

                return redirect('idiomas_curso')->withInput();
            }
            if($curso->delete()) {
                alert('Escuela Modelo', 'El curso se ha eliminado con éxito','success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el curso')->showConfirmButton();
            }
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect('idiomas_curso')->withInput();
    }

    /**
     * Show the application reference.
     *
     * @return \Illuminate\Http\Response
     */
    public function referencia()
    {
        return View('curso.referencia');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function crearReferencia($curso_id, $tienePagoCeneval)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $generarReferencia = new GenerarReferencia;


        $ficha = [];
        $referencia1 = "";
        $referencia2 = "";

        $curso = Curso::with('cgt.periodo','cgt.plan.programa.escuela.departamento.ubicacion','alumno.persona')->find($curso_id);
        $clave_pago = $curso->alumno->aluClave;
        $programa_id = $curso->cgt->plan->programa->id;
        $escuela_id = $curso->cgt->plan->programa->escuela->id;
        $departamento_id = $curso->cgt->plan->programa->escuela->departamento->id;
        $perNumero = $curso->cgt->periodo->perNumero;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $cuoConcepto = "99";
        $periodoActual = $curso->cgt->plan->programa->escuela->departamento->periodoActual;

        $alumno_ingreso = $curso->alumno->aluEstado;
        $alumno_cgtGrado = $curso->cgt->cgtGradoSemestre;

        $esDeudor = DB::select("call procValidaDeudorCOVIDFichaInscripcion({$periodoActual->perAnioPago}, {$curso->alumno->id})");

        if($esDeudor[0]->_return_esdeudor == "SI") {
            alert('Escuela Modelo', 'No se puede generar la Ficha de pago debido a que el alumno aparece como deudor. Favor de verificar en el departamento de cobros.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;

        $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
        $diasLimite = 15;


        $fechaLimiteHoy = Carbon::now();

        if ($perNumero != 3 && $perNumero != 0) {
            $perAnio = $perAnio - 1;
            $cuoConcepto = "00";
        }

        $cuoConceptoRef = $cuoConcepto;
        $ficha["cuoConceptoRef"] = $cuoConceptoRef;
        //3 consultas para consultar la cuota actual
        //1.- Programa
        $cuota = Cuota::where([
            ['cuoTipo','P'],
            ['dep_esc_prog_id',$programa_id],
            ['cuoAnio',$perAnioPago]
        ])->first();
        //2.- Escuela
        if(!$cuota){
            $cuota = Cuota::where([
                ['cuoTipo','E'],
                ['dep_esc_prog_id',$escuela_id],
                ['cuoAnio',$perAnioPago]
            ])->first();
            //3.- Departamento
            if(!$cuota){
                $cuota = Cuota::where([
                    ['cuoTipo','D'],
                    ['dep_esc_prog_id',$departamento_id],
                    ['cuoAnio',$perAnioPago]
                ])->first();
            }
        }
        if ($cuota) {

            $cuoAnio = $cuota->cuoAnio;
            $cuota_descuento = CuotaDescuento::where('cuota_id', $cuota->id)->first();
            if($cuota_descuento)
            {
                //2022: solo 1er año ó si son primer ingreso (clave de pago nueva)
                if ($alumno_ingreso == "N")
                {
                    $cuota = $cuota_descuento;
                }
                else
                {
                    if ($alumno_cgtGrado == 1) {
                        $cuota = $cuota_descuento;
                    }
                }
            }

            $cuoConcepto = ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "IDI") {
                $cuoImporteInscripcion1 = (double)$cuota->cuoImporteInscripcion1 + (double)$cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (double)$cuota->cuoImporteInscripcion2 + (double)$cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (double)$cuota->cuoImporteInscripcion3 + (double)$cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaLimiteInscripcion3;
            }

            $cuoImporteInscripcion1 = (string)number_format($cuoImporteInscripcion1, 2, ".", "");
            $cuoImporteInscripcion2 = (string)number_format($cuoImporteInscripcion2, 2, ".", "");
            $cuoImporteInscripcion3 = (string)number_format($cuoImporteInscripcion3, 2, ".", "");

            //SI EL ALUMNO TIENE CUOTA ESPECIAL, SE LE COBRA LA DEL CURSO, NO DE LA CUOTA
            if ($curso->curImporteInscripcion != "" || $curso->curImporteInscripcion != NULL) {
                $cuoImporteInscripcion1 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 = (double)$curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion2 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 = (double)$curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion3 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 = (double)$curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion1 = (string)number_format($cuoImporteInscripcion1, 2, ".", "");
                $cuoImporteInscripcion2 = (string)number_format($cuoImporteInscripcion2, 2, ".", "");
                $cuoImporteInscripcion3 = (string)number_format($cuoImporteInscripcion3, 2, ".", "");

            }

            $concepto = $clave_pago . $cuoConcepto;
            $ficha["concepto"] = $concepto;
            $fechaLimite1 = null;
            $fechaLimite2 = null;
            $fechaLimite3 = null;

            if ($cuoFechaLimiteInscripcion1 != null) {
                $fechaLimite1 = ($cuoFechaLimiteInscripcion1);
                $referencia1 = $generarReferencia->crear($concepto, $cuoFechaLimiteInscripcion1, $cuoImporteInscripcion1);
                $this->insertarReferencia($referencia1);
                $importe1 = Utils::convertMoney($cuoImporteInscripcion1);
            }

            if ($cuoFechaLimiteInscripcion2 != null) {
                $fechaLimite2 = ($cuoFechaLimiteInscripcion2);
                $referencia2 = $generarReferencia->crear($concepto, $cuoFechaLimiteInscripcion2, $cuoImporteInscripcion2);
                $this->insertarReferencia($referencia2);
                $importe2 = Utils::convertMoney($cuoImporteInscripcion2);
            }

            if ($cuoFechaLimiteInscripcion3 != null) {
                $fechaLimite3 = ($cuoFechaLimiteInscripcion3);
                $referencia3 = $generarReferencia->crear($concepto, $cuoFechaLimiteInscripcion3, $cuoImporteInscripcion3);
                $this->insertarReferencia($referencia3);
                $importe3 = Utils::convertMoney($cuoImporteInscripcion3);
            }

            $tieneDescuento = false;
            $cualFechaDescuento = null;

            if ($cuoFechaLimiteInscripcion3 != null) {

                $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                $dateLimite = $dateLimite->endOfDay();

                if ($fechaLimiteHoy->lte($dateLimite)) {
                    $tieneDescuento = true;
                    $cualFechaDescuento = "fecha3";
                }
            }

            //SI NO APLICO DESCUENTO EN FECHA3 O NO HABIA FECHA3
            if (!$tieneDescuento)
            {
                //pregunto por FECHA2
                if ($cuoFechaLimiteInscripcion2 != null) {
                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha2";
                    }
                }
            }

            //SI NO APLICO DESCUENTO EN FECHA2 O NO HABIA FECHA2
            if (!$tieneDescuento)
            {
                if ($cuoFechaLimiteInscripcion1 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite1);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha1";
                    }
                }
                else
                {
                    //POR ALGUNA RAZON , NO HAY CAPTURADO FECHALIMITE1
                    $tieneDescuento = false;
                }
            }

            $ficha['tieneDescuento'] = $tieneDescuento;

            $ficha['fechaLimite15Dias'] = Carbon::parse($fechaLimite15Dias)->day
                .'/'. ucfirst(Carbon::parse($fechaLimite15Dias)->formatLocalized('%b'))
                .'/'. Carbon::parse($fechaLimite15Dias)->year;
            $ficha['fechaLimite15DiasDB'] =$fechaLimite15Dias;


            //INFORMACIÓN PARA GENERAR FICHA
            $ficha['clave_pago'] = $clave_pago;
            $ficha['curso'] = $curso;
            $ficha['nombreAlumno'] = $curso->alumno->persona->perApellido1 .' '. $curso->alumno->persona->perApellido2 .' '. $curso->alumno->persona->perNombre;
            $ficha['progNombre'] = $curso->cgt->plan->programa->progNombre;
            $ficha['gradoSemestre'] = $curso->cgt->cgtGradoSemestre;
            $ficha['ubicacion'] = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
            $ficha['cuoNumeroCuenta'] = sprintf("%07s\n", $cuota->cuoNumeroCuenta);
            $ficha['cursoEscolar'] = $perAnio . "-" . ($perAnio + 1);
            //iniciar en vacío
            $ficha['cuoImporteInscripcion1'] = "";
            $ficha['cuoFechaLimiteInscripcion1'] = "";
            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite1;
            $ficha['referencia1'] = "";
            $ficha['cuoImporteInscripcion2'] = $importe2;
            $ficha['cuoFechaLimiteInscripcion2'] = "";
            $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimite2;
            $ficha['referencia2'] = "";
            $ficha['cuoImporteInscripcion3'] = $importe3;
            $ficha['cuoFechaLimiteInscripcion3'] = "";
            $ficha['cuoFechaLimiteInscripcion3DB'] = $fechaLimite3;
            $ficha['referencia3'] = "";


            // validar las fechas
            $fechaHoy = new \DateTime();
            $cuantasFechasSeImprimen = 1;


            //SI ALCANZO UNA FECHA LIMITE, CALCULAMOS
            if ($tieneDescuento)
            {
                if ($cualFechaDescuento == "fecha3")
                {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
                    $diferencia = $fechaPago->diff($fechaHoy);

                    if ($diferencia->invert)  //HAY DIAS ANTES DEL LIMITE
                    {
                        if ($diferencia->format('%a') < $diasLimite)
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2))
                            {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia2 = $generarReferencia->crear($concepto,$fechaReferencia,$cuoImporteInscripcion2);
                                $this->insertarReferencia($referencia2);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }
                        else
                        {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $referencia3 = $generarReferencia->crear($concepto,$fechaReferencia,$cuoImporteInscripcion3);
                            $this->insertarReferencia($referencia3);
                            $ficha['referencia1'] = $referencia3;
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                    else
                    {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                        $dateLimite = $dateLimite->endOfDay();
                        if ( $fechaLimiteHoy->lte($dateLimite) )
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2))
                            {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia2 = $generarReferencia->crear($concepto,$fechaReferencia,$cuoImporteInscripcion2);
                                $this->insertarReferencia($referencia2);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }


                }

                if ($cualFechaDescuento == "fecha2")
                {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert)
                    {
                        if ($diferencia->format('%a') < $diasLimite)
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1))
                            {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia1 = $generarReferencia->crear($concepto,$fechaReferencia,$cuoImporteInscripcion1);
                                $this->insertarReferencia($referencia1);
                                $ficha['referencia2'] = $referencia1;

                            }
                        }
                        else
                        {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $referencia2 = $generarReferencia->crear($concepto,$fechaReferencia,$cuoImporteInscripcion2);
                            $this->insertarReferencia($referencia2);
                            $ficha['referencia1'] = $referencia2;

                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                    else
                    {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                        $dateLimite = $dateLimite->endOfDay();
                        if ( $fechaLimiteHoy->lte($dateLimite) )
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1))
                            {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia1 = $generarReferencia->crear($concepto,$fechaReferencia,$cuoImporteInscripcion1);
                                $this->insertarReferencia($referencia1);
                                $ficha['referencia2'] = $referencia1;

                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha1")
                {
                    //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                    //ESA YA NO TIENE DESCUENTO
                    $cuantasFechasSeImprimen = 1;

                    //fecha actual menor que la fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe1;
                    $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                    $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                        .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                        .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                    $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                    $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                        .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                        .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                    $referencia1 = $generarReferencia->crear($concepto,$fechaReferencia,$cuoImporteInscripcion1);
                    $this->insertarReferencia($referencia1);
                    $ficha['referencia1'] = $referencia1;

                    $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;

                }

            }
            else
            {
                //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                //ESA YA NO TIENE DESCUENTO
                $cuantasFechasSeImprimen = 1;

                //fecha actual menor que la fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                $referencia1 = $generarReferencia->crear($concepto,$fechaReferencia,$cuoImporteInscripcion1);
                $this->insertarReferencia($referencia1);
                $ficha['referencia1'] = $referencia1;

                $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
            }

            Ficha::create([
                "fchNumPer"       => $perNumero,
                "fchAnioPer"      => $perAnio,
                "fchClaveAlu"     => $clave_pago,
                "fchClaveCarr"    => $curso->cgt->plan->programa->progClave,
                "fchClaveProgAct" => NULL,
                "fchGradoSem"     => $curso->cgt->cgtGradoSemestre,
                "fchGrupo"        => $curso->cgt->cgtGrupo,
                "fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
                "fchHoraImpr"     => Carbon::now()->format("h:i:s"),
                "fchUsuaImpr"     => auth()->user()->id,
                "fchTipo"         => $curso->alumno->aluEstado,
                "fchConc"         => $ficha["cuoConceptoRef"],
                "fchFechaVenc1"   => $ficha['cuoFechaLimiteInscripcion1DB'],
                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion1']->format()): NULL,
                "fhcRef1"         => $ficha['referencia1'],
                "fchFechaVenc2"   => $ficha['cuoFechaLimiteInscripcion2DB'],
                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion2']->format()): NULL,
                "fhcRef2"         => $ficha['referencia2'],
                "fchEstado"       => "P"
            ]);

            //sobreescribiendo vencimiento
            $vencimiento = Carbon::now()->addDays($diasLimite + 1)->format("Y-m-d");
            $ficha['vencimiento'] = Carbon::parse($vencimiento)->day
                .'/'. ucfirst(Carbon::parse($vencimiento)->formatLocalized('%b'))
                .'/'. Carbon::parse($vencimiento)->year;


            $ficha['impresion'] = date("d/m/Y H:i");
            return $this->generatePDF($ficha);
        }else{
            alert()->error('Error...', "No hay cuotas disponibles")->showConfirmButton();

            return redirect('idiomas_curso')->withInput();
        }
    }

    public function crearReferenciaHSBC_SinReferencias($curso_id, $tienePagoCeneval)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $generarReferencia = new GenerarReferencia;


        $ficha = [];
        $referencia1 = "";
        $referencia2 = "";

        $curso = Curso::with('cgt.periodo','cgt.plan.programa.escuela.departamento.ubicacion','alumno.persona')->find($curso_id);
        $clave_pago = $curso->alumno->aluClave;
        $programa_id = $curso->cgt->plan->programa->id;
        $escuela_id = $curso->cgt->plan->programa->escuela->id;
        $departamento_id = $curso->cgt->plan->programa->escuela->departamento->id;
        $perNumero = $curso->cgt->periodo->perNumero;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $cuoConcepto = "99";
        $periodoActual = $curso->cgt->plan->programa->escuela->departamento->periodoActual;

        $alumno_ingreso = $curso->alumno->aluEstado;
        $alumno_cgtGrado = $curso->cgt->cgtGradoSemestre;

        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        $esDeudor = DB::select("call procValidaDeudorCOVIDFichaInscripcion({$periodoActual->perAnioPago}, {$curso->alumno->id})");

        if($esDeudor[0]->_return_esdeudor == "SI") {
            alert('Escuela Modelo', 'No se puede generar la Ficha de pago debido a que el alumno aparece como deudor. Favor de verificar en el departamento de cobros.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        if ($departamento_clave == "IDI")
        {
            $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
            $diasLimite = 15;
        }

        $fechaLimiteHoy = Carbon::now();

        if ($perNumero != 3 && $perNumero != 0) {
            $perAnio = $perAnio - 1;
            $cuoConcepto = "00";
        }

        $cuoConceptoRef = $cuoConcepto;
        $ficha["cuoConceptoRef"] = $cuoConceptoRef;
        //3 consultas para consultar la cuota actual
        //1.- Programa
        $cuota = Cuota::where([
            ['cuoTipo','P'],
            ['dep_esc_prog_id',$programa_id],
            ['cuoAnio',$perAnioPago]
        ])->first();
        //2.- Escuela
        if(!$cuota){
            $cuota = Cuota::where([
                ['cuoTipo','E'],
                ['dep_esc_prog_id',$escuela_id],
                ['cuoAnio',$perAnioPago]
            ])->first();
            //3.- Departamento
            if(!$cuota){
                $cuota = Cuota::where([
                    ['cuoTipo','D'],
                    ['dep_esc_prog_id',$departamento_id],
                    ['cuoAnio',$perAnioPago]
                ])->first();
            }
        }
        if ($cuota)
        {
            $cuoAnio = $cuota->cuoAnio;
            $cuota_descuento = CuotaDescuento::where('cuota_id', $cuota->id)->first();
            if($cuota_descuento)
            {
                //2022: solo 1er año ó si son primer ingreso (clave de pago nueva)
                if ($alumno_ingreso == "N")
                {
                    $cuota = $cuota_descuento;
                }
                else
                {
                    if ($alumno_cgtGrado == 1) {
                        $cuota = $cuota_descuento;
                    }
                }
            }

            $cuoConcepto =  ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "IDI")
            {
                $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1 + (double) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2 + (double) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3 + (double) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaLimiteInscripcion3;
            }

            $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
            $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
            $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");


            //SI EL ALUMNO TIENE CUOTA ESPECIAL, SE LE COBRA LA DEL CURSO, NO DE LA CUOTA
            if ($curso->curImporteInscripcion != "" || $curso->curImporteInscripcion != NULL) {
                $cuoImporteInscripcion1 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 = (double) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion2 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 = (double) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion3 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 = (double) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
                $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
                $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");

            }

            $concepto = $clave_pago.$cuoConcepto;
            $ficha["concepto"] = $concepto;
            $fechaLimite1 = null;
            $fechaLimite2 = null;
            $fechaLimite3 = null;

            if ($cuoFechaLimiteInscripcion1 != null) {
                $fechaLimite1 = ($cuoFechaLimiteInscripcion1);
                $referencia1 = $generarReferencia->crearHSBC($concepto,$cuoFechaLimiteInscripcion1,$cuoImporteInscripcion1, $conpRefClave, "0000");
                $this->insertarReferencia($referencia1);
                $importe1 = Utils::convertMoney($cuoImporteInscripcion1);
            }

            if ($cuoFechaLimiteInscripcion2 != null) {
                $fechaLimite2 = ($cuoFechaLimiteInscripcion2);
                $referencia2 = $generarReferencia->crearHSBC($concepto,$cuoFechaLimiteInscripcion2,$cuoImporteInscripcion2, $conpRefClave, "0000");
                $this->insertarReferencia($referencia2);
                $importe2 = Utils::convertMoney($cuoImporteInscripcion2);
            }

            if ($cuoFechaLimiteInscripcion3 != null) {
                $fechaLimite3 = ($cuoFechaLimiteInscripcion3);
                $referencia3 = $generarReferencia->crearHSBC($concepto,$cuoFechaLimiteInscripcion3,$cuoImporteInscripcion3, $conpRefClave, "0000");
                $this->insertarReferencia($referencia3);
                $importe3 = Utils::convertMoney($cuoImporteInscripcion3);
            }


            $tieneDescuento = false;
            $cualFechaDescuento = null;

            if ($cuoFechaLimiteInscripcion3 != null) {

                $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                $dateLimite = $dateLimite->endOfDay();

                if ($fechaLimiteHoy->lte($dateLimite)) {
                    $tieneDescuento = true;
                    $cualFechaDescuento = "fecha3";
                }
            }

            //SI NO APLICO DESCUENTO EN FECHA3 O NO HABIA FECHA3
            if (!$tieneDescuento)
            {
                //pregunto por FECHA2
                if ($cuoFechaLimiteInscripcion2 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha2";
                    }
                }
            }

            //SI NO APLICO DESCUENTO EN FECHA2 O NO HABIA FECHA2
            if (!$tieneDescuento)
            {
                if ($cuoFechaLimiteInscripcion1 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite1);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha1";
                    }
                }
                else
                {
                    //POR ALGUNA RAZON , NO HAY CAPTURADO FECHALIMITE1
                    $tieneDescuento = false;

                }
            }

            $ficha['tieneDescuento'] = $tieneDescuento;

            $ficha['fechaLimite15Dias'] = Carbon::parse($fechaLimite15Dias)->day
                .'/'. ucfirst(Carbon::parse($fechaLimite15Dias)->formatLocalized('%b'))
                .'/'. Carbon::parse($fechaLimite15Dias)->year;
            $ficha['fechaLimite15DiasDB'] =$fechaLimite15Dias;

            //INFORMACIÓN PARA GENERAR FICHA
            $ficha['clave_pago'] = $clave_pago;
            $ficha['curso'] = $curso;
            $ficha['nombreAlumno'] = $curso->alumno->persona->perApellido1 .' '. $curso->alumno->persona->perApellido2 .' '. $curso->alumno->persona->perNombre;
            $ficha['progNombre'] = $curso->cgt->plan->programa->progNombre;
            $ficha['gradoSemestre'] = $curso->cgt->cgtGradoSemestre;
            $ficha['ubicacion'] = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
            $ficha['cuoNumeroCuenta'] = sprintf("%07s\n", $cuota->cuoNumeroCuenta);
            $ficha['cursoEscolar'] = $perAnio . "-" . ($perAnio + 1);
            //iniciar en vacío
            $ficha['cuoImporteInscripcion1'] = "";
            $ficha['cuoFechaLimiteInscripcion1'] = "";
            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite1;
            $ficha['referencia1'] = "";
            $ficha['cuoImporteInscripcion2'] = $importe2;
            $ficha['cuoFechaLimiteInscripcion2'] = "";
            $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimite2;
            $ficha['referencia2'] = "";
            $ficha['cuoImporteInscripcion3'] = $importe3;
            $ficha['cuoFechaLimiteInscripcion3'] = "";
            $ficha['cuoFechaLimiteInscripcion3DB'] = $fechaLimite3;
            $ficha['referencia3'] = "";


            // validar las fechas
            $fechaHoy = new \DateTime();
            // $fechaHoy = new \DateTime("2018-7-8");
            $cuantasFechasSeImprimen = 1;


            //SI ALCANZO UNA FECHA LIMITE, CALCULAMOS
            if ($tieneDescuento)
            {
                if ($cualFechaDescuento == "fecha3")
                {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert)
                    {
                        if ($diferencia->format('%a') < $diasLimite)
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2))
                            {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);

                                $referencia2 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion2, $conpRefClave, "0000");
                                $this->insertarReferencia($referencia2);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }
                        else
                        {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $referencia3 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion3, $conpRefClave, "0000");
                            $this->insertarReferencia($referencia3);
                            $ficha['referencia1'] = $referencia3;
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                    else
                    {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                        $dateLimite = $dateLimite->endOfDay();
                        if ( $fechaLimiteHoy->lte($dateLimite) )
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2))
                            {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia2 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion2, $conpRefClave, "0000");
                                $this->insertarReferencia($referencia2);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }

                }

                if ($cualFechaDescuento == "fecha2")
                {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert)
                    {
                        if ($diferencia->format('%a') < $diasLimite)
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1))
                            {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1, $conpRefClave, "0000");
                                $this->insertarReferencia($referencia1);
                                $ficha['referencia2'] = $referencia1;

                            }
                        }
                        else
                        {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $referencia2 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion2, $conpRefClave, "0000");
                            $this->insertarReferencia($referencia2);
                            $ficha['referencia1'] = $referencia2;

                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                    else
                    {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                        $dateLimite = $dateLimite->endOfDay();
                        if ( $fechaLimiteHoy->lte($dateLimite) )
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1))
                            {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1, $conpRefClave, "0000");
                                $this->insertarReferencia($referencia1);
                                $ficha['referencia2'] = $referencia1;

                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha1")
                {
                    //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                    //ESA YA NO TIENE DESCUENTO
                    $cuantasFechasSeImprimen = 1;

                    //fecha actual menor que la fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe1;
                    $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                    $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                        .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                        .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                    $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                    $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                        .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                        .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                    $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1, $conpRefClave, "0000");
                    $this->insertarReferencia($referencia1);
                    $ficha['referencia1'] = $referencia1;

                    $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;

                }

            }
            else
            {
                //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                //ESA YA NO TIENE DESCUENTO
                $cuantasFechasSeImprimen = 1;

                //fecha actual menor que la fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1, $conpRefClave);
                $this->insertarReferencia($referencia1);
                $ficha['referencia1'] = $referencia1;

                /*
                $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                $fechaVencimiento->add(new \DateInterval("P1D"));
                $vencimiento = $fechaVencimiento->format("Y-m-d");
                */

                $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
            }

            Ficha::create([
                "fchNumPer"       => $perNumero,
                "fchAnioPer"      => $perAnio,
                "fchClaveAlu"     => $clave_pago,
                "fchClaveCarr"    => $curso->cgt->plan->programa->progClave,
                "fchClaveProgAct" => NULL,
                "fchGradoSem"     => $curso->cgt->cgtGradoSemestre,
                "fchGrupo"        => $curso->cgt->cgtGrupo,
                "fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
                "fchHoraImpr"     => Carbon::now()->format("h:i:s"),
                "fchUsuaImpr"     => auth()->user()->id,
                "fchTipo"         => $curso->alumno->aluEstado,
                "fchConc"         => $ficha["cuoConceptoRef"],
                "fchFechaVenc1"   => $ficha['cuoFechaLimiteInscripcion1DB'],
                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion1']->format()): NULL,
                "fhcRef1"         => $ficha['referencia1'],
                "fchFechaVenc2"   => $ficha['cuoFechaLimiteInscripcion2DB'],
                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion2']->format()): NULL,
                "fhcRef2"         => $ficha['referencia2'],
                "fchEstado"       => "P"
            ]);

            //sobreescribiendo vencimiento
            $vencimiento = Carbon::now()->addDays($diasLimite + 1)->format("Y-m-d");
            $ficha['vencimiento'] = Carbon::parse($vencimiento)->day
                .'/'. ucfirst(Carbon::parse($vencimiento)->formatLocalized('%b'))
                .'/'. Carbon::parse($vencimiento)->year;


            $ficha['impresion'] = date("d/m/Y H:i");
            return $this->generatePDF_HSBC($ficha);
        }else{
            alert()->error('Error...', "No hay cuotas disponibles")->showConfirmButton();

            return redirect('idiomas_curso')->withInput();
        }
    }

    public function crearReferenciaBBVA($curso_id, $tienePagoCeneval)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $generarReferencia = new GenerarReferencia;


        $ficha = [];
        $referencia1 = "";
        $referencia2 = "";

        $curso = Idiomas_cursos::select(
            'idiomas_cursos.*',
            'ubicacion.ubiNombre',
            'ubicacion.ubiClave',
            'departamentos.id AS departamento_id',
            'departamentos.depNombre',
            'departamentos.depClave',
            'escuelas.id AS escuela_id',
            'escuelas.escNombre',
            'escuelas.escClave',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.id AS programa_id',
            'programas.progNombre',
            'planes.planClave',
            'idiomas_grupos.gpoGrado',
            'idiomas_grupos.gpoClave',
            'idiomas_grupos.gpoDescripcion',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'alumnos.aluClave',
            'alumnos.id AS alumno_id'
        )
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('idiomas_cursos.id', $curso_id)
        ->first();

        if ($curso->perAnioPago < 2014) {
            alert()->error('Error...', "El año de la cuota debe ser despues del 2014")->showConfirmButton();
            return redirect('idiomas_curso')->withInput();
        }

        $clave_pago = $curso->aluClave;
        $alumno_id = $curso->alumno_id;
        $programa_id = $curso->programa_id;

        $escuela_id = $curso->escuela_id;
        $departamento_id = $curso->departamento_id;
        $perNumero = $curso->perNumero;
        $perAnio = $curso->perAnio;
        $perAnioPago = $curso->perAnioPago;
        $cuoConcepto = "49";

        $ubiClave = $curso->ubiClave;
        $depClave = $curso->depClave;
        $escClave = $curso->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $depClave;
        if ( $departamento_clave == "IDI")
        {
            $fechaLimite15Dias = Carbon::now()->addDays(7)->hour(0)->minute(0)->second(0);
            $diasLimite = 7;
        }

        $fechaLimiteHoy = Carbon::now();

        if ($perNumero != 3 && $perNumero != 0) {
            $perAnio = $perAnio - 1;
            $cuoConcepto = "50";
        }

        $cuoConceptoRef = $cuoConcepto;
        $ficha["cuoConceptoRef"] = $cuoConceptoRef;
        //3 consultas para consultar la cuota actual
        //1.- Programa
        $cuota = Idiomas_cuotas::where([
            ['programa_id',$programa_id],
            ['cuoAnioPago',$perAnioPago]
        ])->first();

        if ($cuota)
        {
            $cuoAnio = $cuota->cuoAnioPago;

            $cuoConcepto =  ($perAnio % 100) . $cuoConcepto;

            // inscripcion 1
            $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1;
            $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaInscripcion1;

            // inscripcion 2
            $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2;
            $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaInscripcion2;

            // inscripcion 3
            $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3;
            $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaInscripcion3;

            $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
            $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
            $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");

            $procIdiomasEsAlumno = DB::select("call procIdiomasEsAlumno({$curso_id})");
            if(count($procIdiomasEsAlumno)>0) {
                if($procIdiomasEsAlumno[0]->esAlumno == 'S') {
                    // inscripcion 1
                    $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1 - (double) $cuota->cuoDescuentoInscripcion;
                    $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaInscripcion1;

                    // inscripcion 2
                    $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2 - (double) $cuota->cuoDescuentoInscripcion;
                    $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaInscripcion2;

                    // inscripcion 3
                    $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3 - (double) $cuota->cuoDescuentoInscripcion;
                    $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaInscripcion3;

                    $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
                    $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
                    $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");
                }
            }

            //SI EL ALUMNO TIENE CUOTA ESPECIAL, SE LE COBRA LA DEL CURSO, NO DE LA CUOTA
            if ($curso->curImporteInscripcion != "" || $curso->curImporteInscripcion != NULL) {
                $cuoImporteInscripcion1 = $curso->curImporteInscripcion;
                $cuoImporteInscripcion2 = $curso->curImporteInscripcion;
                $cuoImporteInscripcion3 = $curso->curImporteInscripcion;

                $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
                $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
                $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");

            }

            $concepto = $clave_pago.$cuoConcepto;
            $ficha["concepto"] = $concepto;
            $fechaLimite1 = null;
            $fechaLimite2 = null;
            $fechaLimite3 = null;
            $importe1 = null;
            $importe2 = null;
            $importe3 = null;

            if ($cuoFechaLimiteInscripcion1 != null) {
                $fechaLimite1 = ($cuoFechaLimiteInscripcion1);

                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                    $alumno_id, $programa_id, $cuoAnio,
                    $cuoConceptoRef, $cuoFechaLimiteInscripcion1, $cuoImporteInscripcion1, null,
                    null, null, null, null, null,
                    null, "P");
                $referencia1 = $generarReferencia->crearBBVA($concepto,$cuoFechaLimiteInscripcion1,$cuoImporteInscripcion1,
                    $conpRefClave, $refNum);

                $importe1 = Utils::convertMoney($cuoImporteInscripcion1);
            }

            if ($cuoFechaLimiteInscripcion2 != null) {
                $fechaLimite2 = ($cuoFechaLimiteInscripcion2);

                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                    $alumno_id, $programa_id, $cuoAnio,
                    $cuoConceptoRef, $cuoFechaLimiteInscripcion2, $cuoImporteInscripcion2, null,
                    null, null, null, null, null,
                    null, "P");
                $referencia2 = $generarReferencia->crearBBVA($concepto,$cuoFechaLimiteInscripcion2,$cuoImporteInscripcion2,
                    $conpRefClave, $refNum);

                $importe2 = Utils::convertMoney($cuoImporteInscripcion2);
            }

            if ($cuoFechaLimiteInscripcion3 != null) {
                $fechaLimite3 = ($cuoFechaLimiteInscripcion3);

                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                    $alumno_id, $programa_id, $cuoAnio,
                    $cuoConceptoRef, $cuoFechaLimiteInscripcion3, $cuoImporteInscripcion3, null,
                    null, null, null, null, null,
                    null, "P");
                $referencia3 = $generarReferencia->crearBBVA($concepto,$cuoFechaLimiteInscripcion3,$cuoImporteInscripcion3,
                    $conpRefClave, $refNum);

                $importe3 = Utils::convertMoney($cuoImporteInscripcion3);
            }


            $tieneDescuento = false;
            $cualFechaDescuento = null;

            if ($cuoFechaLimiteInscripcion3 != null) {

                $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                $dateLimite = $dateLimite->endOfDay();

                if ($fechaLimiteHoy->lte($dateLimite)) {
                    $tieneDescuento = true;
                    $cualFechaDescuento = "fecha3";
                }
            }

            //SI NO APLICO DESCUENTO EN FECHA3 O NO HABIA FECHA3
            if (!$tieneDescuento)
            {
                //pregunto por FECHA2
                if ($cuoFechaLimiteInscripcion2 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha2";
                    }
                }
            }

            //SI NO APLICO DESCUENTO EN FECHA2 O NO HABIA FECHA2
            if (!$tieneDescuento)
            {
                if ($cuoFechaLimiteInscripcion1 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite1);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha1";
                    }
                }
                else
                {
                    //POR ALGUNA RAZON , NO HAY CAPTURADO FECHALIMITE1
                    $tieneDescuento = false;

                }
            }

            $ficha['tieneDescuento'] = $tieneDescuento;

            $ficha['fechaLimite15Dias'] = Carbon::parse($fechaLimite15Dias)->day
                .'/'. ucfirst(Carbon::parse($fechaLimite15Dias)->formatLocalized('%b'))
                .'/'. Carbon::parse($fechaLimite15Dias)->year;
            $ficha['fechaLimite15DiasDB'] =$fechaLimite15Dias;

            //INFORMACIÓN PARA GENERAR FICHA
            $ficha['clave_pago'] = $clave_pago;
            $ficha['curso'] = $curso;
            $ficha['nombreAlumno'] = $curso->perApellido1 .' '. $curso->perApellido2 .' '. $curso->perNombre;
            $ficha['progNombre'] = $curso->progNombre;
            $ficha['gradoSemestre'] = $curso->gpoDescripcion;
            $ficha['ubicacion'] = $curso->ubiClave;
            $ficha['cuoNumeroCuenta'] = sprintf("%07s\n", $cuota->cuoNumeroCuenta);
            $ficha['cursoEscolar'] = $perAnio . "-" . ($perAnio + 1);
            //iniciar en vacío
            $ficha['cuoImporteInscripcion1'] = "";
            $ficha['cuoFechaLimiteInscripcion1'] = "";
            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite1;
            $ficha['referencia1'] = "";
            $ficha['cuoImporteInscripcion2'] = $importe2;
            $ficha['cuoFechaLimiteInscripcion2'] = "";
            $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimite2;
            $ficha['referencia2'] = "";
            $ficha['cuoImporteInscripcion3'] = $importe3;
            $ficha['cuoFechaLimiteInscripcion3'] = "";
            $ficha['cuoFechaLimiteInscripcion3DB'] = $fechaLimite3;
            $ficha['referencia3'] = "";


            // validar las fechas
            $fechaHoy = new \DateTime();
            // $fechaHoy = new \DateTime("2018-7-8");
            $cuantasFechasSeImprimen = 1;


            //SI ALCANZO UNA FECHA LIMITE, CALCULAMOS
            if ($tieneDescuento)
            {
                if ($cualFechaDescuento == "fecha3")
                {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert)
                    {
                        if ($diferencia->format('%a') < $diasLimite)
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2))
                            {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);
                                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                    $alumno_id, $programa_id, $cuoAnio,
                                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion2, null,
                                    null, null, null, null, null,
                                    null, "P");

                                $referencia2 = $generarReferencia->crearBBVA($concepto,$fechaReferencia,$cuoImporteInscripcion2,
                                    $conpRefClave, $refNum);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }
                        else
                        {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $alumno_id, $programa_id, $cuoAnio,
                                $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion3, null,
                                null, null, null, null, null,
                                null, "P");

                            $referencia3 = $generarReferencia->crearBBVA($concepto, $fechaReferencia,$cuoImporteInscripcion3,
                                $conpRefClave, $refNum);
                            $ficha['referencia1'] = $referencia3;
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                    else
                    {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                        $dateLimite = $dateLimite->endOfDay();
                        if ( $fechaLimiteHoy->lte($dateLimite) )
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2))
                            {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);
                                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                    $alumno_id, $programa_id, $cuoAnio,
                                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion2, null,
                                    null, null, null, null, null,
                                    null, "P");
                                $referencia2 = $generarReferencia->crearBBVA($concepto,$fechaReferencia,$cuoImporteInscripcion2,
                                    $conpRefClave, $refNum);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }

                }

                if ($cualFechaDescuento == "fecha2")
                {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert)
                    {
                        if ($diferencia->format('%a') < $diasLimite)
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1))
                            {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                    $alumno_id, $programa_id, $cuoAnio,
                                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion1, null,
                                    null, null, null, null, null,
                                    null, "P");

                                $referencia1 = $generarReferencia->crearBBVA($concepto,$fechaReferencia,$cuoImporteInscripcion1,
                                    $conpRefClave, $refNum);

                                $ficha['referencia2'] = $referencia1;

                            }
                        }
                        else
                        {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $alumno_id, $programa_id, $cuoAnio,
                                $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion2, null,
                                null, null, null, null, null,
                                null, "P");

                            $referencia2 = $generarReferencia->crearBBVA($concepto,$fechaReferencia,$cuoImporteInscripcion2,
                                $conpRefClave, $refNum);
                            $ficha['referencia1'] = $referencia2;

                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                    else
                    {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                        $dateLimite = $dateLimite->endOfDay();
                        if ( $fechaLimiteHoy->lte($dateLimite) )
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1))
                            {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                    $alumno_id, $programa_id, $cuoAnio,
                                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion1, null,
                                    null, null, null, null, null,
                                    null, "P");

                                $referencia1 = $generarReferencia->crearBBVA($concepto,$fechaReferencia,$cuoImporteInscripcion1,
                                    $conpRefClave, $refNum);
                                $ficha['referencia2'] = $referencia1;

                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha1")
                {
                    //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                    //ESA YA NO TIENE DESCUENTO
                    $cuantasFechasSeImprimen = 1;

                    //fecha actual menor que la fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe1;
                    $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                    $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                        .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                        .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                    $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                    $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                        .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                        .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                    $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                        $alumno_id, $programa_id, $cuoAnio,
                        $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion1, null,
                        null, null, null, null, null,
                        null, "P");

                    $referencia1 = $generarReferencia->crearBBVA($concepto,$fechaReferencia,$cuoImporteInscripcion1,
                        $conpRefClave, $refNum);
                    $ficha['referencia1'] = $referencia1;

                    $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;

                }

            }
            else
            {
                //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                //ESA YA NO TIENE DESCUENTO
                $cuantasFechasSeImprimen = 1;

                //fecha actual menor que la fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                    $alumno_id, $programa_id, $cuoAnio,
                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion1, null,
                    null, null, null, null, null,
                    null, "P");
                $referencia1 = $generarReferencia->crearBBVA($concepto,$fechaReferencia,$cuoImporteInscripcion1,
                    $conpRefClave, $refNum);

                $ficha['referencia1'] = $referencia1;

                $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
            }


            Ficha::create([
                "fchNumPer"       => $perNumero,
                "fchAnioPer"      => $perAnio,
                "fchClaveAlu"     => $clave_pago,
                "fchClaveCarr"    => $curso->progClave,
                "fchClaveProgAct" => NULL,
                "fchGradoSem"     => $curso->gpoGrado,
                "fchGrupo"        => $curso->gpoGrupo,
                "fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
                "fchHoraImpr"     => Carbon::now()->format("h:i:s"),
                "fchUsuaImpr"     => auth()->user()->id,
                "fchTipo"         => $curso->aluEstado,
                "fchConc"         => $ficha["cuoConceptoRef"],
                "fchFechaVenc1"   => $ficha['cuoFechaLimiteInscripcion1DB'],
                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion1']->format()): NULL,
                "fhcRef1"         => $ficha['referencia1'],
                "fchFechaVenc2"   => $ficha['cuoFechaLimiteInscripcion2DB'],
                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion2']->format()): NULL,
                "fhcRef2"         => $ficha['referencia2'],
                "fchEstado"       => "P"
            ]);

            //sobreescribiendo vencimiento
            $vencimiento = Carbon::now()->addDays($diasLimite + 1)->format("Y-m-d");
            $ficha['vencimiento'] = Carbon::parse($vencimiento)->day
                .'/'. ucfirst(Carbon::parse($vencimiento)->formatLocalized('%b'))
                .'/'. Carbon::parse($vencimiento)->year;


            $ficha['impresion'] = date("d/m/Y H:i");
            return $this->generatePDF_BBVA($ficha);
        }else{
            alert()->error('Error...', "No hay cuotas disponibles")->showConfirmButton();

            return redirect('idiomas_curso')->withInput();
        }
    }

    public function crearReferenciaHSBC($curso_id, $tienePagoCeneval)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $generarReferencia = new GenerarReferencia;


        $ficha = [];
        $referencia1 = "";
        $referencia2 = "";

        // $curso = Curso::with('cgt.periodo','cgt.plan.programa.escuela.departamento.ubicacion','alumno.persona')->find($curso_id);
        $curso = Idiomas_cursos::select(
            'idiomas_cursos.*',
            'ubicacion.ubiNombre',
            'ubicacion.ubiClave',
            'departamentos.id AS departamento_id',
            'departamentos.depNombre',
            'departamentos.depClave',
            'escuelas.id AS escuela_id',
            'escuelas.escNombre',
            'escuelas.escClave',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.id AS programa_id',
            'programas.progNombre',
            'planes.planClave',
            'idiomas_grupos.gpoGrado',
            'idiomas_grupos.gpoClave',
            'idiomas_grupos.gpoDescripcion',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'alumnos.aluClave',
            'alumnos.id AS alumno_id'
        )
        ->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
        ->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
        ->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('idiomas_cursos.id', $curso_id)
        ->first();

        if ($curso->perAnioPago < 2014) {
            alert()->error('Error...', "El año de la cuota debe ser despues del 2014")->showConfirmButton();
            return redirect('idiomas_curso')->withInput();
        }

        $clave_pago = $curso->aluClave;
        $alumno_id = $curso->alumno_id;
        $programa_id = $curso->programa_id;

        $escuela_id = $curso->escuela_id;
        $departamento_id = $curso->departamento_id;
        $perNumero = $curso->perNumero;
        $perAnio = $curso->perAnio;
        $perAnioPago = $curso->perAnioPago;
        $cuoConcepto = "49";

        $ubiClave = $curso->ubiClave;
        $depClave = $curso->depClave;
        $escClave = $curso->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $depClave;
        if  ($departamento_clave == "IDI")
        {
            $fechaLimite15Dias = Carbon::now()->addDays(7)->hour(0)->minute(0)->second(0);
            $diasLimite = 7;
        }

        $fechaLimiteHoy = Carbon::now();

        if ($perNumero != 3 && $perNumero != 0) {
            $perAnio = $perAnio - 1;
            $cuoConcepto = "50";
        }

        $cuoConceptoRef = $cuoConcepto;
        $ficha["cuoConceptoRef"] = $cuoConceptoRef;
        //3 consultas para consultar la cuota actual
        //1.- Programa
        $cuota = Idiomas_cuotas::where([
            ['programa_id',$programa_id],
            ['cuoAnioPago',$perAnioPago]
        ])->first();

        if ($cuota)
        {
            $cuoAnio = $cuota->cuoAnioPago;

            $cuoConcepto =  ($perAnio % 100) . $cuoConcepto;

            // inscripcion 1
            $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1;
            $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaInscripcion1;

            // inscripcion 2
            $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2;
            $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaInscripcion2;

            // inscripcion 3
            $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3;
            $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaInscripcion3;


            $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
            $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
            $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");

            //SI EL ALUMNO TIENE CUOTA ESPECIAL, SE LE COBRA LA DEL CURSO, NO DE LA CUOTA
            if ($curso->curImporteInscripcion != "" || $curso->curImporteInscripcion != NULL) {
                $cuoImporteInscripcion1 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 = (double) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion2 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 = (double) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion3 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 = (double) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
                $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
                $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");

            }

            $concepto = $clave_pago.$cuoConcepto;
            $ficha["concepto"] = $concepto;
            $fechaLimite1 = null;
            $fechaLimite2 = null;
            $fechaLimite3 = null;
            $importe1 = null;
            $importe2 = null;
            $importe3 = null;

            if ($cuoFechaLimiteInscripcion1 != null) {
                $fechaLimite1 = ($cuoFechaLimiteInscripcion1);

                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                    $alumno_id, $programa_id, $cuoAnio,
                    $cuoConceptoRef, $cuoFechaLimiteInscripcion1, $cuoImporteInscripcion1, null,
                    null, null, null, null, null,
                    null, "P");
                $referencia1 = $generarReferencia->crearHSBC($concepto,$cuoFechaLimiteInscripcion1,$cuoImporteInscripcion1,
                    $conpRefClave, $refNum);

                $importe1 = Utils::convertMoney($cuoImporteInscripcion1);
            }

            if ($cuoFechaLimiteInscripcion2 != null) {
                $fechaLimite2 = ($cuoFechaLimiteInscripcion2);

                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                    $alumno_id, $programa_id, $cuoAnio,
                    $cuoConceptoRef, $cuoFechaLimiteInscripcion2, $cuoImporteInscripcion2, null,
                    null, null, null, null, null,
                    null, "P");
                $referencia2 = $generarReferencia->crearHSBC($concepto,$cuoFechaLimiteInscripcion2,$cuoImporteInscripcion2,
                    $conpRefClave, $refNum);

                $importe2 = Utils::convertMoney($cuoImporteInscripcion2);
            }

            if ($cuoFechaLimiteInscripcion3 != null) {
                $fechaLimite3 = ($cuoFechaLimiteInscripcion3);

                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                    $alumno_id, $programa_id, $cuoAnio,
                    $cuoConceptoRef, $cuoFechaLimiteInscripcion3, $cuoImporteInscripcion3, null,
                    null, null, null, null, null,
                    null, "P");
                $referencia3 = $generarReferencia->crearHSBC($concepto,$cuoFechaLimiteInscripcion3,$cuoImporteInscripcion3,
                    $conpRefClave, $refNum);

                $importe3 = Utils::convertMoney($cuoImporteInscripcion3);
            }


            $tieneDescuento = false;
            $cualFechaDescuento = null;

            if ($cuoFechaLimiteInscripcion3 != null) {

                $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                $dateLimite = $dateLimite->endOfDay();

                if ($fechaLimiteHoy->lte($dateLimite)) {
                    $tieneDescuento = true;
                    $cualFechaDescuento = "fecha3";
                }
            }

            //SI NO APLICO DESCUENTO EN FECHA3 O NO HABIA FECHA3
            if (!$tieneDescuento)
            {
                //pregunto por FECHA2
                if ($cuoFechaLimiteInscripcion2 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha2";
                    }
                }
            }

            //SI NO APLICO DESCUENTO EN FECHA2 O NO HABIA FECHA2
            if (!$tieneDescuento)
            {
                if ($cuoFechaLimiteInscripcion1 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite1);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha1";
                    }
                }
                else
                {
                    //POR ALGUNA RAZON , NO HAY CAPTURADO FECHALIMITE1
                    $tieneDescuento = false;

                }
            }

            $ficha['tieneDescuento'] = $tieneDescuento;

            $ficha['fechaLimite15Dias'] = Carbon::parse($fechaLimite15Dias)->day
                .'/'. ucfirst(Carbon::parse($fechaLimite15Dias)->formatLocalized('%b'))
                .'/'. Carbon::parse($fechaLimite15Dias)->year;
            $ficha['fechaLimite15DiasDB'] =$fechaLimite15Dias;

            //INFORMACIÓN PARA GENERAR FICHA
            $ficha['clave_pago'] = $clave_pago;
            $ficha['curso'] = $curso;
            $ficha['nombreAlumno'] = $curso->perApellido1 .' '. $curso->perApellido2 .' '. $curso->perNombre;
            $ficha['progNombre'] = $curso->progNombre;
            $ficha['gradoSemestre'] = $curso->gpoDescripcion;
            $ficha['ubicacion'] = $curso->ubiClave;
            $ficha['cuoNumeroCuenta'] = sprintf("%07s\n", $cuota->cuoNumeroCuenta);
            $ficha['cursoEscolar'] = $perAnio . "-" . ($perAnio + 1);
            //iniciar en vacío
            $ficha['cuoImporteInscripcion1'] = "";
            $ficha['cuoFechaLimiteInscripcion1'] = "";
            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite1;
            $ficha['referencia1'] = "";
            $ficha['cuoImporteInscripcion2'] = $importe2;
            $ficha['cuoFechaLimiteInscripcion2'] = "";
            $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimite2;
            $ficha['referencia2'] = "";
            $ficha['cuoImporteInscripcion3'] = $importe3;
            $ficha['cuoFechaLimiteInscripcion3'] = "";
            $ficha['cuoFechaLimiteInscripcion3DB'] = $fechaLimite3;
            $ficha['referencia3'] = "";


            // validar las fechas
            $fechaHoy = new \DateTime();
            // $fechaHoy = new \DateTime("2018-7-8");
            $cuantasFechasSeImprimen = 1;


            //SI ALCANZO UNA FECHA LIMITE, CALCULAMOS
            if ($tieneDescuento)
            {
                if ($cualFechaDescuento == "fecha3")
                {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert)
                    {
                        if ($diferencia->format('%a') < $diasLimite)
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2))
                            {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);
                                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                    $alumno_id, $programa_id, $cuoAnio,
                                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion2, null,
                                    null, null, null, null, null,
                                    null, "P");

                                $referencia2 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion2,
                                    $conpRefClave, $refNum);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }
                        else
                        {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $alumno_id, $programa_id, $cuoAnio,
                                $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion3, null,
                                null, null, null, null, null,
                                null, "P");

                            $referencia3 = $generarReferencia->crearHSBC($concepto, $fechaReferencia,$cuoImporteInscripcion3,
                                $conpRefClave, $refNum);
                            $ficha['referencia1'] = $referencia3;
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                    else
                    {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                        $dateLimite = $dateLimite->endOfDay();
                        if ( $fechaLimiteHoy->lte($dateLimite) )
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2))
                            {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                    $alumno_id, $programa_id, $cuoAnio,
                                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion2, null,
                                    null, null, null, null, null,
                                    null, "P");
                                $referencia2 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion2,
                                    $conpRefClave, $refNum);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }

                }

                if ($cualFechaDescuento == "fecha2")
                {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert)
                    {
                        if ($diferencia->format('%a') < $diasLimite)
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1))
                            {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                    $alumno_id, $programa_id, $cuoAnio,
                                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion1, null,
                                    null, null, null, null, null,
                                    null, "P");

                                $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1,
                                    $conpRefClave, $refNum);

                                $ficha['referencia2'] = $referencia1;

                            }
                        }
                        else
                        {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $alumno_id, $programa_id, $cuoAnio,
                                $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion2, null,
                                null, null, null, null, null,
                                null, "P");

                            $referencia2 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion2,
                                $conpRefClave, $refNum);
                            $ficha['referencia1'] = $referencia2;

                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                    else
                    {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                        $dateLimite = $dateLimite->endOfDay();
                        if ( $fechaLimiteHoy->lte($dateLimite) )
                        {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1))
                            {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                    $alumno_id, $programa_id, $cuoAnio,
                                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion1, null,
                                    null, null, null, null, null,
                                    null, "P");

                                $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1,
                                    $conpRefClave, $refNum);
                                $ficha['referencia2'] = $referencia1;

                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha1")
                {
                    //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                    //ESA YA NO TIENE DESCUENTO
                    $cuantasFechasSeImprimen = 1;

                    //fecha actual menor que la fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe1;
                    $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                    $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                        .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                        .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                    $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                    $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                        .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                        .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                    $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                        $alumno_id, $programa_id, $cuoAnio,
                        $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion1, null,
                        null, null, null, null, null,
                        null, "P");

                    $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1,
                        $conpRefClave, $refNum);
                    $ficha['referencia1'] = $referencia1;

                    $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;

                }

            }
            else
            {
                //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                //ESA YA NO TIENE DESCUENTO
                $cuantasFechasSeImprimen = 1;

                //fecha actual menor que la fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                    .'/'. ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaLimiteDiasRestantes)->year;
                $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->month
                    .'-'. Carbon::parse($fechaLimiteDiasRestantes)->day;

                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                    $alumno_id, $programa_id, $cuoAnio,
                    $cuoConceptoRef, $fechaReferencia, $cuoImporteInscripcion1, null,
                    null, null, null, null, null,
                    null, "P");
                $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1,
                    $conpRefClave, $refNum);

                $ficha['referencia1'] = $referencia1;

                $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
            }


            Ficha::create([
                "fchNumPer"       => $perNumero,
                "fchAnioPer"      => $perAnio,
                "fchClaveAlu"     => $clave_pago,
                "fchClaveCarr"    => $curso->progClave,
                "fchClaveProgAct" => NULL,
                "fchGradoSem"     => $curso->gpoGrado,
                "fchGrupo"        => $curso->gpoGrupo,
                "fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
                "fchHoraImpr"     => Carbon::now()->format("h:i:s"),
                "fchUsuaImpr"     => auth()->user()->id,
                "fchTipo"         => $curso->aluEstado,
                "fchConc"         => $ficha["cuoConceptoRef"],
                "fchFechaVenc1"   => $ficha['cuoFechaLimiteInscripcion1DB'],
                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion1']->format()): NULL,
                "fhcRef1"         => $ficha['referencia1'],
                "fchFechaVenc2"   => $ficha['cuoFechaLimiteInscripcion2DB'],
                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion2']->format()): NULL,
                "fhcRef2"         => $ficha['referencia2'],
                "fchEstado"       => "P"
            ]);

            //sobreescribiendo vencimiento
            $vencimiento = Carbon::now()->addDays($diasLimite + 1)->format("Y-m-d");
            $ficha['vencimiento'] = Carbon::parse($vencimiento)->day
                .'/'. ucfirst(Carbon::parse($vencimiento)->formatLocalized('%b'))
                .'/'. Carbon::parse($vencimiento)->year;


            $ficha['impresion'] = date("d/m/Y H:i");
            return $this->generatePDF_HSBC($ficha);
        }else{
            alert()->error('Error...', "No hay cuotas disponibles")->showConfirmButton();

            return redirect('idiomas_curso')->withInput();
        }
    }

    private function generatePDF($ficha) {
        //valores de celdas
        //curso escolar
        $talonarios = ['banco', 'alumno'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
        $logoY['alumno'] = 105;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['banco'] = 20;
        $cursoY['alumno'] = 112;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['banco'] = 15;
        $escuelaModeloY['alumno'] = 107;

        //Ficha de Deposito
        $fichaDepositoY['banco'] = 25;
        $fichaDepositoY['alumno'] = 117;

        //alto de filas
        $filaH = 9;
        $filaMedia = 5;

        //inicio de filas
        $columna1 = 24;
        $columna2 = 69;
        $columna3 = 114;
        $columna4 = 159;
        //ancho de filas
        $anchoCorto = 45;
        $anchoMedio = 90;
        $anchoLargo = 135;

        //fila1
        $fila1['banco'] = 35;
        $fila1['alumno'] = 128;

        //fila2
        $fila2['banco'] = 44;
        $fila2['alumno'] = 137;

        //fila3
        $fila3['banco'] = 53;
        $fila3['alumno'] = 146;

        //fila3.5
        $fila35['banco'] = 65;
        $fila35['alumno'] = 158;

        //fila4
        $fila4['banco'] = 70;
        $fila4['alumno'] = 163;

        //fila5
        $fila5['banco'] = 79;
        $fila5['alumno'] = 172;


        //Clave de pago

        //Número de convenio

        //Nombre del Alumno
        $nombreC = utf8_decode($ficha['nombreAlumno']);
        $nombreC = strtoupper($nombreC);

        //ubicación
        $ubicacionC = "($ficha[ubicacion])";
        //concepto
        $conceptoC = "INSCRIPCIÓN AL $ficha[gradoSemestre] DE $ficha[progNombre]";
        $conceptoC = utf8_decode($conceptoC);
        $cuantasFechas = (int) $ficha['cuantasFechasSeImprimen'];

        //pago1
        $pago1Fecha = "";
        $pago1Importe = "";
        $pago1Referencia = "";
        $pago1Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago1Importe = $ficha['cuoImporteInscripcion1'];
        $pago1Referencia = $ficha['referencia1'];

        //pago2
        $pago2Fecha = "";
        $pago2Importe = "";
        $pago2Referencia = "";
        $pago2Fecha = $ficha['cuoFechaLimiteInscripcion2'];
        $pago2Importe = $ficha['cuoImporteInscripcion2'];
        $pago2Referencia = $ficha['referencia2'];

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimiento'];

        $generarReferencia = new GenerarReferencia;


        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: $ficha[impresion]");
        $pdf = new EFEPDF('P','mm','Letter');
        $pdf->SetTitle("Ficha de pago | SCEM");
        $pdf->AliasNbPages();
        $pdf->AddPage();
        foreach ($talonarios as $talonarioInd) {
            //$pdf->Image(URL::to('images/bbva.png'),$logoX, $logoY[$talonarioInd]);
            //imprimir encabezados
            $pdf->SetFillColor(180, 190, 210);
            $pdf->SetFont('Arial', '', 10);

            //clave del alumno
            $pdf->SetXY($columna1, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, Lang::get('fichas/FichaPago.aluclave'), 1, 0, 'L', 1);

            //convenio
            $pdf->SetXY($columna3, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("Número de Convenio"), 1, 0, 'L', 1);

            //Nombre del alumno
            $pdf->SetXY($columna1, $fila2[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "Nombre del Alumno", 1, 0, 'L', 1);

            //Concepto de pago
            $pdf->SetXY($columna1, $fila3[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("Descripción"), 1, 0, 'L', 1);

            //Fecha límite
            $pdf->SetXY($columna1, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);

            //Importe
            $pdf->SetXY($columna2, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

            //Referencia
            $pdf->SetXY($columna3, $fila35[$talonarioInd]);
            $pdf->Cell($anchoMedio, $filaMedia, Lang::get('fichas/FichaPago.referencia'), 1, 0, 'C', 1);


            $pdf->SetXY(0,  $fila1[$talonarioInd]);
            $pdf->Cell(60, -25,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, "C");


            $pdf->SetFont('Arial','B', 12);
            $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "FICHA DE DEPOSITO", 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "BBVA", 0, 0, "C");



            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['cuoNumeroCuenta'], 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$nombreC, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$ubicacionC, 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);

            $ultimaFecha = "";

            if ($cuantasFechas == 1)
            {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1);

                $pdf->SetX($columna1);
            }

            if ($cuantasFechas == 2)
            {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1);

                $pdf->SetX($columna1);

                $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
                /*------------------------------------------------------------------------------*/

                $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);
            }

            //fecha de vencimiento y fecha de impresión

            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, "Esta ficha se invalida a partir del:", 0, 0);
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->SetX($columna2);
            $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0);

            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    private function generatePDF_HSBC($ficha) {
        //valores de celdas
        //curso escolar
        $talonarios = ['banco'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['banco'] = 20;
        //$cursoY['alumno'] = 112;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['banco'] = 15;
        //$escuelaModeloY['alumno'] = 107;

        //Ficha de Deposito
        $fichaDepositoY['banco'] = 25;
        //$fichaDepositoY['alumno'] = 117;

        //alto de filas
        $filaH = 9;
        $filaMedia = 5;

        //inicio de filas
        $columna1 = 24;
        $columna2 = 69;
        $columna3 = 114;
        $columna4 = 159;
        //ancho de filas
        $anchoCorto = 45;
        $anchoMedio = 90;
        $anchoLargo = 135;

        //fila1
        $fila1['banco'] = 35;
        //$fila1['alumno'] = 128;

        //fila2
        $fila2['banco'] = 44;
        //$fila2['alumno'] = 137;

        //fila3
        $fila3['banco'] = 53;
        //$fila3['alumno'] = 146;

        //fila3.5
        $fila35['banco'] = 65;
        //$fila35['alumno'] = 158;

        //fila4
        $fila4['banco'] = 70;
        //$fila4['alumno'] = 163;

        //fila5
        $fila5['banco'] = 79;
        //$fila5['alumno'] = 172;


        //Clave de pago

        //Número de convenio

        //Nombre del Alumno
        $nombreC = utf8_decode($ficha['nombreAlumno']);
        $nombreC = strtoupper($nombreC);

        //ubicación
        $ubicacionC = "($ficha[ubicacion])";
        //concepto
        $conceptoC = "INSCRIPCIÓN AL $ficha[gradoSemestre] DE $ficha[progNombre]";
        $conceptoC = utf8_decode($conceptoC);

        $cuantasFechas = (int) $ficha['cuantasFechasSeImprimen'];

        //pago1
        $pago1Fecha = "";
        $pago1Importe = "";
        $pago1Referencia = "";

        $pago1Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago1Importe = $ficha['cuoImporteInscripcion1'];
        $pago1Referencia = $ficha['referencia1'];

        //pago2
        $pago2Fecha = "";
        $pago2Importe = "";
        $pago2Referencia = "";

        $pago2Fecha = $ficha['cuoFechaLimiteInscripcion2'];
        $pago2Importe = $ficha['cuoImporteInscripcion2'];
        $pago2Referencia = $ficha['referencia2'];

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimiento'];

        $generarReferencia = new GenerarReferencia;


        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: $ficha[impresion]");
        $pdf = new EFEPDF('P','mm','Letter');
        $pdf->SetTitle("Datos de pago SPEI | SCEM");
        $pdf->AliasNbPages();
        $pdf->AddPage();
        foreach ($talonarios as $talonarioInd) {
            //$pdf->Image(URL::to('images/bbva.png'),$logoX, $logoY[$talonarioInd]);
            //imprimir encabezados
            $pdf->SetFillColor(180, 190, 210);
            $pdf->SetFont('Arial', '', 10);

            //clave del alumno
            $pdf->SetXY($columna1, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, Lang::get('fichas/FichaPago.aluclave'), 1, 0, 'L', 1);

            //convenio
            $pdf->SetXY($columna3, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("CLABE INTERBANCARIA"), 1, 0, 'L', 1);

            //Nombre del alumno
            $pdf->SetXY($columna1, $fila2[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "Nombre del Alumno", 1, 0, 'L', 1);

            //Concepto de pago
            $pdf->SetXY($columna1, $fila3[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("Descripción"), 1, 0, 'L', 1);

            //Fecha límite
            $pdf->SetXY($columna1, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);

            //Importe
            $pdf->SetXY($columna2, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

            //Referencia
            $pdf->SetXY($columna3, $fila35[$talonarioInd]);
            $pdf->Cell($anchoMedio, $filaMedia, Lang::get('fichas/FichaPago.referencia'), 1, 0, 'C', 1);


            $pdf->SetXY(0,  $fila1[$talonarioInd]);
            $pdf->Cell(60, -25,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, "C");


            $pdf->SetFont('Arial','B', 12);
            $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO POR TRANSFERENCIA ELECTRÓNICA SPEI"), 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "HSBC", 0, 0, "C");



            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,"021180550300090224", 1, 0, 'C');
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$nombreC, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$ubicacionC, 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);

            $ultimaFecha = "";

            if ($cuantasFechas == 1)
            {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0, 'C');
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0, 'C');
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1, 'C');

                $pdf->SetX($columna1);
            }

            if ($cuantasFechas == 2)
            {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0, 'C');
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0, 'C');
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1, 'C');

                $pdf->SetX($columna1);

                $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0, 'C');
                /*------------------------------------------------------------------------------*/

                $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0, 'C');
                $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1, 'C');
            }

            //fecha de vencimiento y fecha de impresión

            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0);
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->SetX($columna2);
            $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0);

            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

            $pdf->SetY(100);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell($anchoMedio, $filaH, "         *** PARA PAGO EXCLUSIVO POR TRANSFERENCIA EN HSBC ***", 0, 0);

            $pdf->SetY(110);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoMedio, $filaH, "SI PAGA DE HSBC A HSBC, PAGAR COMO SERVICIO 9022", 0, 0);

            $pdf->SetY(116);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoMedio, $filaH, "DESDE OTRO BANCO A HSBC (SPEI), USAR LA CLABE INTERBANCARIA 021180550300090224", 0, 0);

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    private function generatePDF_BBVA($ficha) {
        //valores de celdas
        //curso escolar
        $talonarios = ['banco'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['banco'] = 20;
        //$cursoY['alumno'] = 112;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['banco'] = 15;
        //$escuelaModeloY['alumno'] = 107;

        //Ficha de Deposito
        $fichaDepositoY['banco'] = 25;
        //$fichaDepositoY['alumno'] = 117;

        //alto de filas
        $filaH = 9;
        $filaMedia = 5;

        //inicio de filas
        $columna1 = 24;
        $columna2 = 69;
        $columna3 = 114;
        $columna4 = 159;
        //ancho de filas
        $anchoCorto = 45;
        $anchoMedio = 90;
        $anchoLargo = 135;

        //fila1
        $fila1['banco'] = 35;
        //$fila1['alumno'] = 128;

        //fila2
        $fila2['banco'] = 44;
        //$fila2['alumno'] = 137;

        //fila3
        $fila3['banco'] = 53;
        //$fila3['alumno'] = 146;

        //fila3.5
        $fila35['banco'] = 65;
        //$fila35['alumno'] = 158;

        //fila4
        $fila4['banco'] = 70;
        //$fila4['alumno'] = 163;

        //fila5
        $fila5['banco'] = 79;
        //$fila5['alumno'] = 172;


        //Clave de pago

        //Número de convenio

        //Nombre del Alumno
        $nombreC = utf8_decode($ficha['nombreAlumno']);
        $nombreC = strtoupper($nombreC);

        //ubicación
        $ubicacionC = "($ficha[ubicacion])";
        //concepto
        $conceptoC = "INSCRIPCIÓN AL $ficha[gradoSemestre] DE $ficha[progNombre]";
        $conceptoC = utf8_decode($conceptoC);

        $cuantasFechas = (int) $ficha['cuantasFechasSeImprimen'];

        //pago1
        $pago1Fecha = "";
        $pago1Importe = "";
        $pago1Referencia = "";

        $pago1Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago1Importe = $ficha['cuoImporteInscripcion1'];
        $pago1Referencia = $ficha['referencia1'];

        //pago2
        $pago2Fecha = "";
        $pago2Importe = "";
        $pago2Referencia = "";

        $pago2Fecha = $ficha['cuoFechaLimiteInscripcion2'];
        $pago2Importe = $ficha['cuoImporteInscripcion2'];
        $pago2Referencia = $ficha['referencia2'];

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimiento'];

        $generarReferencia = new GenerarReferencia;

        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: $ficha[impresion]");
        $pdf = new EFEPDF('P','mm','Letter');
        $pdf->SetTitle("Datos de pago SPEI | SCEM");
        $pdf->AliasNbPages();
        $pdf->AddPage();
        foreach ($talonarios as $talonarioInd) {
            //$pdf->Image(URL::to('images/bbva.png'),$logoX, $logoY[$talonarioInd]);
            //imprimir encabezados
            $pdf->SetFillColor(180, 190, 210);
            $pdf->SetFont('Arial', '', 10);

            //clave del alumno
            $pdf->SetXY($columna1, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, Lang::get('fichas/FichaPago.aluclave'), 1, 0, 'L', 1);

            //convenio
            $pdf->SetXY($columna3, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("CLABE INTERBANCARIA"), 1, 0, 'L', 1);

            //Nombre del alumno
            $pdf->SetXY($columna1, $fila2[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "Nombre del Alumno", 1, 0, 'L', 1);

            //Concepto de pago
            $pdf->SetXY($columna1, $fila3[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("Descripción"), 1, 0, 'L', 1);

            //Fecha límite
            $pdf->SetXY($columna1, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);

            //Importe
            $pdf->SetXY($columna2, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

            //Referencia
            $pdf->SetXY($columna3, $fila35[$talonarioInd]);
            $pdf->Cell($anchoMedio, $filaMedia, Lang::get('fichas/FichaPago.referencia'), 1, 0, 'C', 1);


            $pdf->SetXY(0,  $fila1[$talonarioInd]);
            $pdf->Cell(60, -25,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, "C");


            $pdf->SetFont('Arial','B', 12);
            $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO CON REFERENCIA BANCARIA"), 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "BBVA", 0, 0, "C");



            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,"012914002018521323", 1, 0, 'C');
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$nombreC, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$ubicacionC, 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);

            $ultimaFecha = "";

            if ($cuantasFechas == 1)
            {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0, 'C');
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0, 'C');
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1, 'C');

                $pdf->SetX($columna1);
            }

            if ($cuantasFechas == 2)
            {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0, 'C');
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0, 'C');
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1, 'C');

                $pdf->SetX($columna1);

                $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0, 'C');
                /*------------------------------------------------------------------------------*/

                $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0, 'C');
                $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1, 'C');
            }

            //fecha de vencimiento y fecha de impresión

            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0);
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->SetX($columna2);
            $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0);

            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

            $pdf->SetY(93);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell($anchoMedio, $filaH, "INSTRUCCIONES DE PAGO:", 0, 0);

            $pdf->SetY(100);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, "I. PAGO DIRECTO EN SUCURSAL BANCARIA BBVA:", 0, 0);

            $pdf->SetY(105);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, "1-SI PAGA EN VENTANILLA DE SUCURSAL BANCARIA BBVA, UTILICE EL CONVENIO 1852132", 0, 0);

            $pdf->SetY(110);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("2-SI PAGA EN CAJERO AUTOMÁTICO BBVA, SELECCIONE PAGO DE SERVICIO CON EL CONVENIO 1852132"), 0, 0);

            $pdf->SetY(120);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("II. PAGO EN LÍNEA (APLICACIÓN ó PORTAL WEB BANCARIO):"), 0, 0);

            $pdf->SetY(125);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("A) SI PAGA DE BBVA A BBVA (DESDE SU PORTAL BANCARIO BBVA), UTILICE PAGO DE SERVICIO"), 0, 0);

            $pdf->SetY(130);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("    CON EL CONVENIO 1852132"), 0, 0);

            $pdf->SetY(135);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, "B) DESDE OTRO BANCO A BBVA (SPEI), USAR LA CLABE INTERBANCARIA 012914002018521323", 0, 0);

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

}

class EFEPDF extends Fpdf {
    public function Header() {
        //$this->SetFont('Arial','B',15);
        //$this->Cell(80);
        //$this->Cell(30,10,'Title',1,0,'C');
        //$this->Ln(20);
    }
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
