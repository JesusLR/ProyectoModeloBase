<?php

namespace App\Http\Controllers;

use App\clases\alumnos\MetodosAlumnos;
use Lang;
use PDF;
use Auth;
use Validator;
use Carbon\Carbon;
use App\Models\Modules;
use App\Models\User;
use App\Models\Permission;
use App\Models\Permission_module_user;
use App\Models\Alumno;
use App\Models\Baja;
use App\Models\Beca;
use App\Models\Calificacion;
use App\Models\Cgt;
use App\Models\ConceptoBaja;
use App\Models\Cuota;
use App\Models\CuotaDescuento;
use App\Models\Curso;
use App\Models\CursoObservaciones;
use App\Models\Departamento;
use App\Models\Ficha;
use App\Models\Grupo;
use App\Models\Historico;
use App\Models\Inscrito;
use App\Models\Materia;
use App\Models\Pago;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Ubicacion;
use App\Http\Helpers\GenerarReferencia;
use App\Http\Helpers\Utils;
use App\clases\cursos\MetodosCursos;
use App\clases\cuotas\MetodosCuotas;
use App\Http\Controllers\Reportes\ColegiaturasController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\clases\cursos\Notificacion as CursoNotificacion;
use Codedge\Fpdf\Fpdf\Fpdf;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Preescolar\Preescolar_alumnos_historia_clinica;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_actividades;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_conducta;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_desarrollo;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_familiares;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_habitos;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_heredo;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_medica;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_nacimiento;
use App\Models\Preescolar\Preescolar_alumnos_historia_clinica_sociales;


class CursoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:curso',['except' => ['index','show','list','getCursos','getCursoAlumno']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registroUltimoPago = Pago::select(DB::raw('MAX(pagFechaPago)'))->where("pagFormaAplico", "=", "A")->latest()->first();


        $registroUltimoPago = Carbon::parse($registroUltimoPago->pagFechaPago)->day
        . "/" . Utils::num_meses_corto_string(Carbon::parse($registroUltimoPago->pagFechaPago)->month)
        . "/" . Carbon::parse($registroUltimoPago->pagFechaPago)->year;

        return View('curso.show-list', [
            "registroUltimoPago" => $registroUltimoPago

        ]);
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {

                $cursos = Curso::select('cursos.id as curso_id', 'cursos.curTipoBeca', 'cursos.curPorcentajeBeca',
                    'alumnos.aluClave', 'alumnos.id as alumno_id', 'alumnos.aluMatricula', 'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2', 'periodos.id as periodo_id',
                    'periodos.perNumero', 'periodos.perAnio', 'cursos.curEstado', 'cursos.curTipoIngreso', 'cursos.curFechaBaja', 'cursos.curPlanPago',
                    'cgt.cgtGradoSemestre', 'cgt.cgtGrupo', 'planes.id as plan_id', 'planes.planClave', 'programas.id as programa_id',
                    'programas.progNombre', 'programas.progClave',
                    'escuelas.escNombre', 'escuelas.escClave',
                    'departamentos.depNombre', 'departamentos.depClave',
                    'departamentos.perActual as periodo_actual', 'departamentos.perSig as periodo_siguiente',
                    'ubicacion.ubiNombre', 'ubicacion.ubiClave')
                    ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                    ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                    ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                    ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                    ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                    ->join('programas', 'planes.programa_id', '=', 'programas.id')
                    ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                    ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                    ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                    ->whereIn('depClave', ['SUP', 'POS', 'DIP'])
                    // ->orderBy("cursos.id", "desc");
                    ->latest('cgt.created_at');



        $permisos = (User::permiso("curso") == "A" || User::permiso("curso") == "B");
        $permisoA = (User::permiso("curso") == "A");

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

            ->addColumn('action', function($query) use ($permisos, $permisoA) {

                $pedirConfirmacion = 'NO';
                if($query->ubiClave == 'CME' && $query->depClave == 'SUP' && $query->cgtGradoSemestre == 1) {
                    $pedirConfirmacion = 'SI';
                }

                $btnTarjetaPagoBBVA = "";
                $btnTarjetaPagoHSBC = "";

                $btnFichaPagoBBVA = "";
                $btnFichaPagoHSBC = "";

                $btnCambiarCarrera = "";
                if($permisos && in_array($query->periodo_id, [$query->periodo_actual, $query->periodo_siguiente])) {
                    $btnCambiarCarrera = '<a href="'.url("cambiar_carrera/{$query->curso_id}").'" class="button button--icon js-button js-ripple-effect" title="Cambiar carrera o Cgt">
                        <i class="material-icons">autorenew</i>
                    </a>';
                }

                $btnFichaPagoBBVA = '<a href="#modalFichaPago" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="'.$pedirConfirmacion.'"  class=" btn-modal-ficha-pago button button--icon js-button js-ripple-effect" title="Ficha BBVA">
                    <i class="material-icons">local_atm</i>
                </a>';
                $btnFichaPagoHSBC = '<a href="#modalFichaPago" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="'.$pedirConfirmacion.'"  class=" btn-modal-ficha-pago-hsbc button button--icon js-button js-ripple-effect" title="Ficha HSBC">
                    <i class="material-icons">description</i>
                </a>';


                $btnBajaARegular = "";
                if ($permisoA) {
                    $btnBajaARegular = '<a href="#modalBajaARegularCurso" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-baja-a-regular button button--icon js-button js-ripple-effect " title="Cambiar Estado">
                        <i class="material-icons">unarchive</i>
                    </a>';
                }


                if ($query->curEstado == "B" || $query->curEstado == "R" || $query->curEstado == "X") {
                    $btnFichaPagoBBVA = "";
                    $btnFichaPagoHSBC = "";
                }

                //quitar las fichas de semestres avanzados 3 2022
                //comentado para que ya no filtre nada
                /*
                if ($query->perAnio == 2022 && $query->perNumero == 3 && $query->cgtGradoSemestre > 1) {
                    $btnFichaPagoBBVA = "";
                    $btnFichaPagoHSBC = "";
                }
                */
                if ($permisos) {
                    $btnTarjetaPagoBBVA = '<a target="_blank" href="tarjetaPagoAlumno/'.$query->curso_id.'/BBVA" class="button modal-trigger button--icon js-button js-ripple-effect" title="BBVA">
                        <i class="material-icons">format_bold</i>
                    </a>';
                }

                if ($permisos) {
                    $btnTarjetaPagoHSBC = '<a target="_blank" href="tarjetaPagoAlumno/'.$query->curso_id.'/HSBC" class="button modal-trigger button--icon js-button js-ripple-effect" title="HSBC">
                        <i class="material-icons">strikethrough_s</i>
                    </a>';
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

                    $btnMostrarAcciones = '<a href="#modalPreinscritoDetalle" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-preinscrito-detalle button button--icon js-button js-ripple-effect " title="Ver Detalle">
                        <i class="material-icons">account_balance</i>
                    </a>
                    <a href="#modalAlumnoDetalle" data-alumno-id="' . $query->alumno_id . '" class="modal-trigger btn-modal-alumno-detalle button button--icon js-button js-ripple-effect " title="Ver Alumno Detalle">
                        <i class="material-icons">face</i>
                    </a>

                    <a href="/curso/'.$query->curso_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                    </a>'

                    . $btnFichaPagoBBVA . $btnFichaPagoHSBC .

                    '<a href="#modalHistorialPagos" data-nombres="' . $query->perNombre." ".$query->perApellido1." ".$query->perApellido2 .
                    '" data-aluclave="'. $query->aluClave .'" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-historial-pagos button button--icon js-button js-ripple-effect" title="Historial Pagos">
                        <i class="material-icons">attach_money</i>
                    </a>'

                    . $btnTarjetaPagoBBVA . $btnTarjetaPagoHSBC .


                    '<a href="/curso/'. $query->curso_id .'/historial_calificaciones_alumno/" class="button button--icon js-button js-ripple-effect" title="Historial Calificaciones Alumno">
                        <i class="material-icons">library_books</i>
                    </a>' .

                    '<a href="/curso/' . $query->curso_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>'
                    .
                    '<a href="/curso/materiasFaltantes/'. $query->curso_id .'" class="button button--icon js-button js-ripple-effect" title="Materias Faltantes">
                    <i class="material-icons">book</i>
                    </a>'


                    .'<a target="_blank" href="curso/'.$query->curso_id.'/constancia_beca" class="button button--icon js-button js-ripple-effect" title="Constancia Beca">
                        <i class="material-icons">card_giftcard</i>
                    </a>'.


                    '<a href="#modalBajaCurso" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-baja-curso button button--icon js-button js-ripple-effect " title="Baja curso">
                        <i class="material-icons">archive</i>
                    </a>'


                    . $btnBajaARegular .

                    '<form style="display: inline-block;" action="reporte/boleta_calificaciones/imprimir" method="POST" target="_blank">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="aluClave" value="' . $query->aluClave . '">
                        <input type="hidden" name="periodo_id" value="' . $query->periodo_id . '">
                        <input type="hidden" name="programa_id" value="' . $query->programa_id . '">
                        <input type="hidden" name="plan_id" value="' . $query->plan_id . '">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" style=" background: transparent;
                        border: 0px;
                        color: #0277bd;"  class="button button--icon js-button js-ripple-effect" title="Boleta de calificaciones">
                            <i class="material-icons">folder_shared</i>
                        </button>
                    </form>'.
                    '<a href="/curso/observaciones/'.$query->curso_id.'" class="button button--icon js-button js-ripple-effect" title="Observaciones">
                        <i class="material-icons">subtitles</i>
                    </a>'.

                    $btnEliminarCurso .
                    $btnCambiarCarrera;


                return
                    $btnMostrarAcciones;
                })
            ->make(true);
    }


    public function observaciones(Request $request)
    {
        $curso = Curso::find($request->curso_id);
        $cursoObservaciones = DB::table("cursos_observaciones")->where("cursos_id", "=", $request->curso_id)->first();

        return view("curso.observaciones", [
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
            //$path = $request->image->move("app/cursos/observaciones/pagos", $imageName);
            $path = $request->image->move(storage_path(env("OBSERVACIONES_PAGO_PATH")), $imageName);
        }



        $existeObservacionCurso = CursoObservaciones::where("cursos_id", "=", $request->curso_id)->first();

        try {
            if ($existeObservacionCurso) {

                /*
                if(file_exists("app/cursos/observaciones/pagos/".$existeObservacionCurso->curPagoArchivo)) {
                    File::delete("app/cursos/observaciones/pagos/".$existeObservacionCurso->curPagoArchivo);
                }
                */

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

        //return response()->file("app/cursos/observaciones/pagos/".$existeObservacionCurso->curPagoArchivo);
        //return response()->download("app/cursos/observaciones/pagos/".$existeObservacionCurso->curPagoArchivo);
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
        $inscritos = $curso->inscritos;
        return response()->json([
            'tiene_materias_cargadas' => $inscritos->isNotEmpty(),
            'inscritos' => $inscritos,
        ]);
    }


    public function bajaCurso(Request $request)
    {
        if(!$request->conceptosBaja) {
            alert('Campo requerido', 'Necesita especificar un motivo de baja.', 'warning')->showConfirmButton();
            return back()->withInput();
        }


        $cursoId = $request->curso_id;
        $estatusBajBajaTotal = "";


        $curso = Curso::with("alumno.persona")->where("id", "=",$cursoId)->first();//


        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $curso->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion) {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.','error')->showConfirmButton();
            return redirect()->back();
        }


        $estadoCursoAntesDeBaja = $curso->curEstado;

        // dd( $curso->id);
        // 1) borrar todos las grupos - materias de este alumno
        $inscritosObj = Inscrito::where("curso_id", "=", $curso->id);
        $inscritos = $inscritosObj->get();
        $inscritosDelete = $inscritosObj->delete();


        // 1.5) BORRAR CALIFICACIONES
        $inscritoIds = $inscritos->map(function ($item, $key) {
            return $item->id;
        })->all();
        $borrarCalificaciones = Calificacion::whereIn("inscrito_id", $inscritoIds)->delete();



        // 2) cambiar estado del curso a B)aja de este alumno
        $bajaCurso = Curso::find($request->curso_id);
        $bajaCurso->curEstado = "B";
        $bajaCurso->curFechaBaja = $request->fechaBaja;
        $bajaCurso->save();


        // 3) verificar si usuario pidio baja total y cambiar estadoAlu de alumnos a B)aja
        if ($request->bajBajaTotal == "SI") {
            $alumno = Alumno::where("aluClave", "=", $curso->alumno->aluClave)->update(["aluEstado" => "B"]);
            $estatusBajBajaTotal = "C";
        }

        try {
            $baja = Baja::create([
                'curso_id'             => $cursoId,
                'bajTipoBeca'          => $curso->curTipoBeca ? $curso->curTipoBeca: "",
                'bajPorcentajeBeca'    => $curso->curPorcentajeBeca,
                'bajObservacionesBeca' => $curso->curObservacionesBeca,
                'bajFechaRegistro'     => $curso->curFechaRegistro,
                'bajFechaBaja'         => $request->fechaBaja,
                'bajEstadoCurso'       => $estadoCursoAntesDeBaja,
                'bajBajaTotal'         => $estatusBajBajaTotal,
                'bajRazonBaja'         => $request->conceptosBaja,
                'bajObservaciones'     => $request->bajObservaciones,
            ]);

            $envio_notificacion = new CursoNotificacion($curso);
            $envio_notificacion->baja_realizada($baja);

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();

            return back()->withInput();
        }
        alert('Escuela Modelo', 'Alumno dado de baja con éxito','success')->showConfirmButton();
        return back();

    }


    public function altaCurso(Request $request)
    {
        $cursoId = $request->curso_id;
        $inscritosEliminados = $request->inscritosEliminados ? $request->inscritosEliminados: [];

        $bajaCurso = Curso::find($request->curso_id);

        // dd($bajaCurso);

        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $bajaCurso->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion && $bajaCurso->curEstado == "B") {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.','error')->showConfirmButton();
            return redirect()->back();
        }

        if (count($inscritosEliminados) > 0) {
            $eliminadosInscritos = Inscrito::onlyTrashed()->whereIn("id", $request->inscritosEliminados)->restore();
            $eliminadosCalif = Calificacion::onlyTrashed()->whereIn("inscrito_id", $request->inscritosEliminados)->restore();
        }

        //buscamos el alumno con el curso alumno id en alumnos
        $alumnoDadoDeBaja = Alumno::where('id', $bajaCurso->alumno_id)->first();
        if ($alumnoDadoDeBaja) {
            // checamos el estado del alumno sea solo B
            if ($alumnoDadoDeBaja->aluEstado == 'B') {
                $alumnoDadoDeBaja->update([
                    'aluEstado' => 'R'
                ]);
            }
        }


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
        $cursoId = $request->curso_id;
        $curso = Curso::with("alumno.persona", "periodo", "cgt.plan.programa")->where("id", $cursoId)->first();

        $inscritos = Inscrito::with("curso")->where("curso_id", "=", $curso->id)
            ->whereHas('curso', function($query) {
                $query->where('curEstado', "<>", "B");
            })
        ->count();

        $inscritosEliminados = Inscrito::with("grupo.materia")->where("curso_id", "=", $request->curso_id)->onlyTrashed()->get();

        // dd($gruposEliminados);


        return response()->json([
            'cantidadInscritos' => $inscritos,
            'progClave'         => $curso->cgt->plan->programa->progClave,
            'progNombre'        => $curso->cgt->plan->programa->progNombre,
            'perAnio'           => $curso->periodo->perAnio,
            'perNumero'         => $curso->periodo->perNumero,
            'alumno'            => strtoupper($curso->alumno->persona->perNombre . " " .
                                    $curso->alumno->persona->perApellido1 . " " .
                                    $curso->alumno->persona->perApellido2),
            'aluClave'          => $curso->alumno->aluClave,
            'inscritosEliminados' => $inscritosEliminados
        ]);
    }

    public function conceptosBaja(Request $request)
    {
        $conceptoBaja = ConceptoBaja::all()->except(6);
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


        $ubicaciones = Ubicacion::all();

        $tiposIngreso =  MetodosCursos::tiposDeIngreso();

        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $opcionTitulo = SI_NO;
        $tiposBeca = Beca::get();
        $alumno = null;



        return view('curso.create',compact('ubicaciones','planesPago','tiposIngreso','tiposBeca', 'estadoCurso', 'permiso','alumno'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),
            [
                'alumno_id' => 'required|unique:cursos,alumno_id,NULL,id,periodo_id,' . $request->input('periodo_id').',deleted_at,NULL',
                'cgt_id'    => 'required',
                'image' => 'mimes:jpeg,jpg,png,pdf|file|max:10000',

            ],
            [
                'alumno_id.unique' => "El alumno ya existe en el curso",
                'image.mimes' => "El archivo solo puede ser de tipo jpeg, jpg, png y pdf",
                'image.max'   => "El archivo no debe de pesar más de 10 Megas"
            ]
        );


        $cgt = Cgt::where("id", "=", $request->cgt_id)->first();
        $curso_anterior = $request->curso_id ? Curso::find($request->curso_id) : null;

        // $semestre_inmediato_anterior es para obtener el curso anterior pero sin saltar de semestre
        $semestre_inmediato_anterior = null;
        if ($curso_anterior) {
            $perEstado = $curso_anterior->periodo->perEstado;
            //aqui va la logica si es semestral o cuatrimestral
            if ($perEstado == 'S') {
                // 3 2022, 1 2023
                $perNumero = $curso_anterior->periodo->perNumero == 3 ? 1 : 3;
                $perAnio = $curso_anterior->periodo->perNumero == 3 ? $curso_anterior->periodo->perAnio : ($curso_anterior->periodo->perAnio-1);
            } elseif ($perEstado == 'C') {
                // 6 2022, 4 2023 y 5 2023
                if ($curso_anterior->periodo->perNumero == 5) {
                    $perNumero = 4;
                    $perAnio = $curso_anterior->periodo->perAnio;
                } elseif ($curso_anterior->periodo->perNumero == 4) {
                    $perNumero = 6;
                    $perAnio = ($curso_anterior->periodo->perAnio-1);
                } else {
                    $perNumero = 5;
                    $perAnio = $curso_anterior->periodo->perAnio;
                }
            }
            if ($perEstado == 'S' || $perEstado == 'C') {
                // entonces obtenemos el curso anterior
                $semestre_inmediato_anterior = Curso::with('cgt', 'alumno', 'periodo')
                ->whereHas('periodo', function ($query) use ($perNumero, $perAnio) {
                    $query->where('perNumero', $perNumero);
                    $query->where('perAnio', $perAnio);
                })
                ->where('alumno_id', $curso_anterior->alumno->id)
                ->first();
            }
        }
        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $request->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion) {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.','error')->showConfirmButton();
            return redirect()->back();
        }


        // // dd($request->curPlanPago);
        // $curTipoIngreso = "";
        // if (((int) $cgt->cgtGradoSemestre) > 1) {
        //     $curTipoIngreso = "RI";
        // }
        // if (((int) $cgt->cgtGradoSemestre) == 1) {
        //     $curTipoIngreso = "NI";
        // }

        //
        //checar periodo y año
        //preinscritos
        //checar que no exista alumno con otro periodo que coincida con perNumero y perAnio

        $periodo = Periodo::findOrFail($request->periodo_id);
        $departamento = $periodo->departamento;
        $ubicacion = $departamento->ubicacion;
        $curso = Curso::with(["periodo", "cgt.plan"])
            ->where("alumno_id", "=", $request->alumno_id)
            ->where('curEstado', '<>', 'B')
            ->whereHas('periodo', static function ($query) use ($periodo) {
                $query->where("perNumero", "=", $periodo->perNumero);
                $query->where("perAnio", "=", $periodo->perAnio);
            })->first();

        if ($curso) {
            alert()->error('Error...', 'El alumno ya esta preinscrito a un curso para este periodo')->showConfirmButton();
            return redirect('curso/create')->withInput();
        }

        if ($validator->fails()) {
            return redirect ('curso/create')->withErrors($validator)->withInput();
        }

        $plan = Plan::with('programa')->findOrFail($request->plan_id);
        $programa = $plan->programa;
        if (Utils::validaPermiso('curso', $programa->id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->to('curso/create');
        }
        // obtener el programa = "PRE"
        $laclavedelprograma = $programa->progClave;


        $alumno = Alumno::where("id", "=", $request->alumno_id)->first();
        if ($alumno && $alumno->aluEstado == "E") {
            Alumno::where("id", "=", $request->alumno_id)->update(["aluEstado" => "R"]);
        }

        $eliddelalumno = $request->alumno_id;


        $imageName = "";
        //si viene de la vista candidatos
        if ($request->es_candidato_tiene_foto) {
            $imageName =  $alumno->candidato->perCurp . "-" . $alumno->candidato->perFoto;
            $path = File::copy(env("PROJECT_PATH") . $alumno->candidato->perFoto, env("PROJECT_PATH") . $imageName);
        }

        //si no viene de la vista candidatos
        if (!$request->es_candidato_tiene_foto) {
            if ($request->curExaniFoto) {
                $imageName = $alumno->persona->perCurp . "-" . time() . '.' .request()->curExaniFoto->getClientOriginalExtension();
                $path = $request->curExaniFoto->move(env("PROJECT_PATH"), $imageName);
            }
        }

        //-----------------------
        //REVISAMOS SI HABIA PAGADO LA INSCRIPCION POR CAMBIO DE CARRERA
        $esMismoPlan = $curso_anterior ? ($curso_anterior->cgt->plan->id == $request->plan_id) : false;
        $elCursoEstado = "P";
        $elConceptodePago = $periodo->iniciaEnAgosto() ? "99" : "00";
        $elAniodePago = $periodo->perAnioPago;
        $laAluClave = $alumno->aluClave;
        $existePagodeInscripcion = DB::table("pagos")->where('pagClaveAlu', $laAluClave)
        ->where("pagConcPago", "=", $elConceptodePago)
        ->where("pagAnioPer", "=", $elAniodePago)
        ->first();
        if ($existePagodeInscripcion) {
                $elCursoEstado = "R";
        }

        $esBecaSemestral = false;
        $curTipoBeca  = null;
        $curPorcentajeBeca = null;
        $curObservacionesBeca = null;
        $curImporteInscripcion = null;
        $curImporteMensualidad = null;
        $curImporteVencimiento = null;
        $curImporteDescuento = null;
        $curDiasProntoPago = null;
        $curAnioCuotas = $curso_anterior ? $curso_anterior->curAnioCuotas : null;
        $curPlanPago = $semestre_inmediato_anterior ? $semestre_inmediato_anterior->curPlanPago : "N";

        if($periodo->iniciaEnAgosto()) {
            $curPlanPago = "N";
            if($ubicacion->ubiClave == 'CCH')
                $curPlanPago = $programa->progClave == 'CDX' ? 'N' : 'O';
            if($ubicacion->ubiClave == 'CVA')
                $curPlanPago = 'O';
        }


        // plan cuatrimestral
        if($periodo->perNumero == 4 || $periodo->perNumero == 5 || $periodo->perNumero == 6){
            $curPlanPago = 'C';
        }


        if($semestre_inmediato_anterior) {
            if($semestre_inmediato_anterior->curTipoBeca) {
                $beca = Beca::where('bcaClave', $semestre_inmediato_anterior->curTipoBeca)->first();
                if($beca && $beca->bcaVigencia == 'S') $esBecaSemestral = true;
            }
            if(!$periodo->iniciaEnAgosto()) {
                $curTipoBeca = $esBecaSemestral ? null : $semestre_inmediato_anterior->curTipoBeca;
                $curPorcentajeBeca = $esBecaSemestral ? null : $semestre_inmediato_anterior->curPorcentajeBeca;
                $curObservacionesBeca = $esBecaSemestral ? "Tuvo beca semestral {$semestre_inmediato_anterior->curTipoBeca}{$semestre_inmediato_anterior->curPorcentajeBeca}" : $semestre_inmediato_anterior->curObservacionesBeca;
                $curImporteInscripcion = null;
                $curImporteMensualidad = null;
                $curImporteVencimiento = null;
                $curImporteDescuento = null;
                $curDiasProntoPago = null;
            }

            if(!$esMismoPlan) $curAnioCuotas = null;
        }

        //-----------------------

        try {
            $laNuevaPreinscripcion = Curso::create([
                'alumno_id'             => $request->alumno_id,
                'cgt_id'                => $request->cgt_id,
                'periodo_id'            => $request->periodo_id,
                'curTipoBeca'           => $curTipoBeca,
                'curPorcentajeBeca'     => Utils::validaEmpty($curPorcentajeBeca),
                'curObservacionesBeca'  => $curObservacionesBeca,
                'curTipoIngreso'        => $request->curTipoIngreso,
                'curImporteInscripcion' => Utils::validaEmpty($curImporteInscripcion),
                'curImporteMensualidad' => Utils::validaEmpty($curImporteMensualidad),
                'curImporteVencimiento' => Utils::validaEmpty($curImporteVencimiento),
                'curImporteDescuento'   => Utils::validaEmpty($curImporteDescuento),
                'curDiasProntoPago'     => Utils::validaEmpty($curDiasProntoPago),
                'curPlanPago'           => $curPlanPago,
                'curOpcionTitulo'       => $request->curOpcionTitulo,
                'curAnioCuotas'         => Utils::validaEmpty($curAnioCuotas),
                'curFechaRegistro'      => Carbon::now()->format("Y-m-d"),
                'curEstado'             => $elCursoEstado,
                'curExani'              => $request->curExani,
                'curExaniFoto'          => $imageName,
            ]);

            if($curso_anterior && MetodosCursos::hayCambioDeBeca($laNuevaPreinscripcion, $curso_anterior)) {
                $beca_historial = MetodosCursos::crearHistorialDeBeca($laNuevaPreinscripcion);
            }

            //HAY QUE VOLVER A CHECAR SI NO ES UN FULANO DE MERIDA, PRIMER INGRESO Y QUE YA TIENE EXANI
            if ($cgt->cgtGradoSemestre == 1)
            {
                if ($laNuevaPreinscripcion)
                {
                    $userId = Auth::id();
                    $resultUpdate =  DB::select("call procInscritosExaniPago99PorCurso("
                        .$userId
                        .",".$laNuevaPreinscripcion->id
                        .",'CME"
                        ."','SUP"
                        ."','I"
                        ."')");
                }

            }


              //CHECAR SI ES UN NUEVO ALUMNO DE KINDER O MATERNAL

            if($laclavedelprograma == "PRE" || $laclavedelprograma == "MAT")
            {

                $historia = Preescolar_alumnos_historia_clinica::where('alumno_id', '=', $eliddelalumno)->first();

                if ($historia === null) {
                    $historia_id = Preescolar_alumnos_historia_clinica::create([
                        'alumno_id' => $eliddelalumno
                    ]);

                    Preescolar_alumnos_historia_clinica_familiares::create([
                        'historia_id' => $historia_id->id,
                        'municipioMadre_id' => 0,
                        'municipioPadre_id' => 0
                    ]);

                    Preescolar_alumnos_historia_clinica_actividades::create([
                        'historia_id' => $historia_id->id
                    ]);

                    Preescolar_alumnos_historia_clinica_conducta::create([
                        'historia_id' => $historia_id->id
                    ]);

                    Preescolar_alumnos_historia_clinica_desarrollo::create([
                        'historia_id' => $historia_id->id
                    ]);

                    Preescolar_alumnos_historia_clinica_habitos::create([
                        'historia_id' => $historia_id->id
                    ]);

                    Preescolar_alumnos_historia_clinica_heredo::create([
                        'historia_id' => $historia_id->id
                    ]);

                    Preescolar_alumnos_historia_clinica_medica::create([
                        'historia_id' => $historia_id->id
                    ]);

                    Preescolar_alumnos_historia_clinica_nacimiento::create([
                        'historia_id' => $historia_id->id
                    ]);

                    Preescolar_alumnos_historia_clinica_sociales::create([
                        'historia_id' => $historia_id->id
                    ]);

                }

            }



            return redirect('curso');

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('curso/create')->withInput();
        }

        alert('Escuela Modelo', 'El curso se ha creado con éxito','success')->showConfirmButton();
        return redirect('curso');
    }

     /**
     * Show cursos.
     *
     * @return \Illuminate\Http\Response
     */
    // INSCRIPCION POR PAQUETES, GRUPO, POR MATERIA, EDIT DE INSCRITOS
    public function getCursos(Request $request, $cgt_id)
    {
        $cursos = Curso::with('alumno.persona')->where('cgt_id', $cgt_id)->whereIn("curEstado", ["R", "C", "A", "P"])->get();
        return response()->json($cursos);
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = Curso::with('alumno.persona','cgt')->findOrFail($id);
        $tiposIngreso = TIPOS_INGRESO;
        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $tiposBeca = Beca::get();
        $opcionTitulo = SI_NO;

        return view('curso.show', compact('curso','tiposIngreso','planesPago','estadoCurso','tiposBeca','opcionTitulo'));
    }

    public function listHistorialPagos(Request $request) {

        $curso = Curso::find($request->curso_id)->load(['periodo','alumno']);

        $pagos = Pago::with('concepto')->where('pagClaveAlu', $curso->alumno->aluClave)
            ->where('pagAnioPer', $curso->periodo->perAnioPago)
            ->where('pagEstado', 'A')
            ->whereIn('pagConcPago', ["99", "01", "02", "03", "04", "05", "00", "06", "07", "08", "09", "10", "11", "12"])
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


    public function listPreinscritoDetalle(Request $request)
    {
        $cursoId = $request->curso_id;
        $curso = Curso::with('alumno.persona','cgt.plan.programa.escuela.departamento.ubicacion', 'cgt.periodo')->findOrFail($cursoId);
        $estadoCurso  = ESTADO_CURSO;
        $tiposIngreso = TIPOS_INGRESO;
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
        $curso = Curso::where("id", "=", $request->curso_id)->first();

        return view("curso.historialCalificacionesAlumno", [
            "curso" => $curso
        ]);
    }


    public function listHistorialCalifAlumnos (Request $request)
    {
        $curso = Curso::where("id", "=", $request->curso_id)->first();

        $calificaciones = Calificacion::select("cursos.id as cursoId",
            "periodos.perNumero", "periodos.perAnio",
            "planes.planClave", "programas.progClave",
            "materias.matClave", "materias.matNombreOficial as matNombre",
            "calificaciones.inscCalificacionParcial1", "calificaciones.inscCalificacionParcial2",
            "calificaciones.inscCalificacionParcial3", "calificaciones.inscPromedioParciales",
            "calificaciones.inscCalificacionOrdinario", "calificaciones.incsCalificacionFinal")
            ->join("inscritos", "inscritos.id", "=", "calificaciones.inscrito_id")
            ->join("grupos", "grupos.id", "=", "inscritos.grupo_id")
            ->join("materias", "materias.id", "=", "grupos.materia_id")

            ->join("cursos", "cursos.id", "=", "inscritos.curso_id")
                ->join("cgt", "cgt.id", "=", "cursos.cgt_id")
                ->join("planes", "planes.id", "=", "cgt.plan_id")
                ->join("programas", "programas.id", "=", "planes.programa_id")

                ->join("periodos", "periodos.id", "=", "cursos.periodo_id")

                ->join("alumnos", "alumnos.id", "=", "cursos.alumno_id")

            ->where("cursos.id", "=", $curso->id);


        return Datatables::of($calificaciones)->make(true);
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

        $resultado = DB::select('call procMateriasFaltantes('.$curso->cgt->plan->id.','.
        $curso->alumno->id.','.$curso->cgt->plan->programa->escuela->departamento->depCalMinAprob.','.
        $curso->cgt->cgtGradoSemestre.')');

        $datos = new Collection();

        for($i = 0;$i < count($resultado);$i++){
        $matClave = $resultado[$i]->matClave;
        $matNombre = $resultado[$i]->matNombre;
        $matSemestre = $resultado[$i]->matSemestre;
        $matClasificacion = $resultado[$i]->matClasificacion;

        if($matClasificacion == 'B'){
        $matClasificacion = 'Bas';
        }elseif($matClasificacion == 'O'){
        $matClasificacion = 'Opt';
        }
        $histFechaExamen = $resultado[$i]->histFechaExamen;
        $histFechaExamen = Utils::fecha_string($histFechaExamen,true);

        if($histFechaExamen == NULL){
        $histFechaExamen = 'No ha sido cursada';
        }

        $histCalificacion = $resultado[$i]->histCalificacion;
        $histTipoAcreditacion = $resultado[$i]->histTipoAcreditacion;

        $matTipoAcreditacion = $resultado[$i]->matTipoAcreditacion;

        if($matTipoAcreditacion == 'A'){
            if($histCalificacion == 1){
                $histCalificacion = 'No Apr';
            }
        }
        if($histCalificacion == -1){
            $histCalificacion = 'No presentó';
        }

        $datos->push([
            'matClave'=>$matClave,
            'matNombre'=>$matNombre,
            'matSemestre'=>$matSemestre,
            'matClasificacion'=>$matClasificacion,
            'histFechaExamen'=>$histFechaExamen,
            'histCalificacion'=>$histCalificacion,
            'histTipoAcreditacion'=>$histTipoAcreditacion,
        ]);
        }

        return Datatables::of($datos)->make(true);
        }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curso = Curso::with('alumno.persona','cgt','periodo')->findOrFail($id);
        $cgts = Cgt::where([
            ['plan_id', $curso->cgt->plan_id],
            ['periodo_id', $curso->cgt->periodo_id],
            ['cgtGradoSemestre', $curso->cgt->cgtGradoSemestre]
        ])->get();




        //OBTENER PERMISO DE USUARIO
        $user = Auth::user();
        $modulo = Modules::where('slug','curso')->first();
        $permisos = Permission_module_user::where('user_id',$user->id)->where('module_id',$modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;
        $tiposIngreso = MetodosCursos::tiposDeIngreso();
        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $opcionTitulo = SI_NO;
        $tiposBeca = Beca::get();

        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('curso', $curso->cgt->plan->programa_id,"editar")) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);

            return redirect('curso');
        } else {
            return view('curso.edit', compact('curso', 'cgts', 'tiposIngreso', 'planesPago', 'tiposBeca', 'estadoCurso', 'opcionTitulo', 'permiso'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = Auth::user();

        $modulo = Modules::where('slug','curso')->first();
        $permisos = Permission_module_user::where('user_id',$user->id)->where('module_id',$modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;

        // dd($request->curTipoIngreso);
        try {
            $curso = Curso::with('alumno.persona','cgt')->findOrFail($id);
            $curso_anterior = clone $curso; # Clon para luego revisar si cambió.

            $imageName = "";
            if ($request->curExaniFoto) {
                //$imageName = time().'.'.request()->curExaniFoto->getClientOriginalExtension();
                //$path = $request->curExaniFoto->move(storage_path("/app/public/cursos/exani"), $imageName);
                $imageName = $curso->alumno->persona->perCurp . "-" . time(). '.' . request()->curExaniFoto->getClientOriginalExtension();
                $path = $request->curExaniFoto->move(env("PROJECT_PATH"), $imageName);
            }

            if (User::permiso("curso") != "P") {
                $curso->cgt_id                  = $request->cgt_id;
                if ($permiso == "A" || $permiso == "B") {
                    $curso->curEstado               = $request->curEstado;
                }
                $curso->curTipoIngreso          = $request->curTipoIngreso;
                $curso->curOpcionTitulo         = $request->curOpcionTitulo;
                $curso->curExani                = $request->curExani;
                if ($request->curExaniFoto) {
                    $curso->curExaniFoto = $imageName;
                }

            }

            $curTipoBeca = $request->curTipoBeca;
            $curPorcentajeBeca = $request->curTipoBeca ? $request->curPorcentajeBeca : null;
            $curObservacionesBeca = $request->curTipoBeca ? $request->curObservacionesBeca : null;




            if (User::permiso("curso") == "A" || User::permiso("curso") == "E" || User::permiso("curso") == "P") {
                $curso->curAnioCuotas           = Utils::validaEmpty($request->curAnioCuotas);
                $curso->curImporteInscripcion   = Utils::validaEmpty($request->curImporteInscripcion);
                $curso->curImporteMensualidad   = Utils::validaEmpty($request->curImporteMensualidad);
                $curso->curImporteVencimiento   = Utils::validaEmpty($request->curImporteVencimiento);
                $curso->curImporteDescuento     = Utils::validaEmpty($request->curImporteDescuento);
                $curso->curDiasProntoPago       = Utils::validaEmpty($request->curDiasProntoPago);
                $curso->curPlanPago             = $request->curPlanPago;
                $curso->curTipoBeca             = $curTipoBeca;
                $curso->curPorcentajeBeca       = Utils::validaEmpty($curPorcentajeBeca);
                $curso->curObservacionesBeca    = $curObservacionesBeca;
            }


            $curso->save();

            if($curso_anterior && MetodosCursos::hayCambioDeBeca($curso, $curso_anterior)) {
                $beca_historial = MetodosCursos::crearHistorialDeBeca($curso);
            }

            $userId = Auth::id();
            $resultUpdate =  DB::select("call procInscritosExaniPago99PorCurso("
                .$userId
                .",".$id
                .",'CME"
                ."','SUP"
                ."','I"
                ."')");

            alert('Escuela Modelo', 'El curso se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('curso');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...'.$errorCode, $errorMessage)->showConfirmButton();
            return redirect('curso/'.$id.'/edit')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curso = Curso::with('periodo')->findOrFail($id);
        $alumno = $curso->alumno;
        $periodo = $curso->periodo;

        if($curso->inscritos->isNotEmpty()) {
            alert('Ups!...', 'El alumno tiene materias cargadas, no puede borrar este registro. Favor de contactar al administrador del sistema.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        if($curso->curEstado != 'B') {
            alert('Ups!...', 'No se puede borrar este curso debido al estado en el que se encuentra.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        if (Utils::validaPermiso('curso',$curso->cgt->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return back()->withInput();
        }

        if(Pago::where('pagAnioPer', $periodo->perAnioPago)->where('pagClaveAlu', $alumno->aluClave)->exists()) {
            alert('Ups!...', 'El alumno tiene pagos aplicados en este ciclo escolar. No se puede borrar este registro.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        if($alumno->resumenesAcademicos()
            ->where('resPeriodoIngreso', $periodo->id)
            ->orWhere('resPeriodoUltimo', $periodo->id)
            ->orWhere('resPeriodoEgreso', $periodo->id)
            ->exists()
        ) {
            alert('Ups!...', 'El alumno tiene resumen académico registrado en este ciclo escolar. No se puede borrar este registro.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        try {
            $curso->delete();
        }catch (QueryException $e){
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back()->withInput();
        }

        alert('Escuela Modelo', 'El curso se ha eliminado con éxito', 'success')->showConfirmButton();
        return redirect('curso');
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

        $esDeudor = DB::select("call procValidaDeudorCOVIDFichaInscripcion({$periodoActual->perAnioPago}, {$curso->alumno->id})");

        if($esDeudor[0]->_return_esdeudor == "SI") {
          alert('Escuela Modelo', 'No se puede generar la Ficha de pago debido a que el alumno aparece como deudor. Favor de verificar en el departamento de cobros.', 'warning')->showConfirmButton();
          return back()->withInput();
        }

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        if ($departamento_clave == "PRE")
        {
            $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
            $diasLimite = 15;
        }
        if ($departamento_clave == "SUP" || $departamento_clave == "POS" || $departamento_clave == "DIP")
        {
            if ($curso->cgt->cgtGradoSemestre == 1)
            {
                $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
                $diasLimite = 15;
            }
            else
            {
                //ALUMNOS QUE NO SON PRIMER SEMESTRE, SE LES COBRA 7 DIAS
                $fechaLimite15Dias = Carbon::now()->addDays(7)->hour(0)->minute(0)->second(0);
                $diasLimite = 7;
            }
            $anioLimiteActual = $perAnioPago + 1;
            $fechaLimitePeriodo1 = Carbon::createFromFormat("Y-m-d", "$anioLimiteActual-01-20");
            dd($anioLimiteActual);
            $fechaLimiteHoy = Carbon::now();
            if ($fechaLimiteHoy->gt($fechaLimitePeriodo1)) {
                $fechaLimite15Dias = Carbon::now()->addDays(3)->hour(0)->minute(0)->second(0);
                $diasLimite = 3;
            }


        }


        $fechaLimiteHoy = Carbon::now();




        //dd($fechaLimiteHoy,$fechaLimite15Dias);


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
            if($cuota_descuento && MetodosCuotas::aplicaDescuento($curso, $cuota_descuento))
                $cuota = $cuota_descuento;


            $cuoConcepto = ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "PRE") {
                $cuoImporteInscripcion1 = (double)$cuota->cuoImporteInscripcion1 + (double)$cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (double)$cuota->cuoImporteInscripcion2 + (double)$cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (double)$cuota->cuoImporteInscripcion3 + (double)$cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaLimiteInscripcion3;
            }

            if ($departamento_clave == "SUP" || $departamento_clave == "POS" || $departamento_clave == "DIP") {
                $cuoImporteInscripcion1 = (double)$cuota->cuoImporteInscripcion1;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 = (double)$cuota->cuoImporteInscripcion1 - 500;
                }
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (double)$cuota->cuoImporteInscripcion2;
                // dd($cuota);
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 = (double)$cuota->cuoImporteInscripcion2 - 500;
                }
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (double)$cuota->cuoImporteInscripcion3;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 = (double)$cuota->cuoImporteInscripcion3 - 500;
                }
                $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaLimiteInscripcion3;
            }

            $cuoImporteInscripcion1 = (string)number_format($cuoImporteInscripcion1, 2, ".", "");
            $cuoImporteInscripcion2 = (string)number_format($cuoImporteInscripcion2, 2, ".", "");
            $cuoImporteInscripcion3 = (string)number_format($cuoImporteInscripcion3, 2, ".", "");

            //dd($cuoImporteInscripcion1, $cuoImporteInscripcion2, $cuoImporteInscripcion3);

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

            //dd($cuoImporteInscripcion1, $cuoImporteInscripcion2, $cuoImporteInscripcion3);

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

            /*
            $datelimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
            $datelimite = $datelimite->endOfDay();
            dd($fechaLimiteHoy, $datelimite, $fechaLimite3, $fechaLimite2, $fechaLimite1,
                $fechaLimiteHoy->lte($datelimite),
                $fechaLimiteHoy->lte($fechaLimite3),
                $fechaLimiteHoy->lte($fechaLimite2),
                $fechaLimiteHoy->lte($fechaLimite1)); */




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

            //dd($tieneDescuento,$cualFechaDescuento);

            $ficha['fechaLimite15Dias'] = Carbon::parse($fechaLimite15Dias)->day
            .'/'. ucfirst(Carbon::parse($fechaLimite15Dias)->formatLocalized('%b'))
            .'/'. Carbon::parse($fechaLimite15Dias)->year;
            $ficha['fechaLimite15DiasDB'] =$fechaLimite15Dias;

            // dd($fechaLimite15Dias,$fechaLimite2);
            //dd($cuoFechaLimiteInscripcion1, $fechaLimite15Dias);


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
                    //dd($diferencia,$diferencia->invert);

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

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);

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

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

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

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

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

                    /*
                    $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                    $fechaVencimiento->add(new \DateInterval("P1D"));
                    $vencimiento = $fechaVencimiento->format("Y-m-d");
                    */

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

                /*
                $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                $fechaVencimiento->add(new \DateInterval("P1D"));
                $vencimiento = $fechaVencimiento->format("Y-m-d");
                */

                $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
            }


            /*
            $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
            $diferencia = $fechaPago->diff($fechaHoy);
            if ($diferencia->invert)
            {
                //fecha actual menor que la primera fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite1)->day
                .'/'. ucfirst(Carbon::parse($fechaLimite1)->formatLocalized('%b'))
                .'/'. Carbon::parse($fechaLimite1)->year;
                $ficha['referencia1'] = $referencia1;
                $ficha['cuoImporteInscripcion2'] = $importe2;

                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimite2)->day
                    .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaLimite2)->year;
                $ficha['referencia2'] = $referencia2;
                $fechaVencimiento = new \DateTime($cuoFechaLimiteInscripcion2);
                $fechaVencimiento->add(new \DateInterval("P1D"));
                $vencimiento = $fechaVencimiento->format("Y-m-d");
            }
            else
            {
                $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                $diferencia = $fechaPago->diff($fechaHoy);
                if ($diferencia->invert)
                {
                    //fecha actual menor que la segunda fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe2;
                    $ficha['cuoFechaLimiteInscripcion1'] =  Carbon::parse($fechaLimite2)->day
                        .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                        .'/'. Carbon::parse($fechaLimite2)->year;
                    $ficha['referencia1'] = $referencia2;
                    $ficha['cuoImporteInscripcion2'] = $importe1;

                    $ficha['cuoFechaLimiteInscripcion2'] =  Carbon::parse($fechaLimite1)->day
                    .'/'. ucfirst(Carbon::parse($fechaLimite1)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaLimite1)->year;
                    $ficha['referencia2'] = $referencia1;
                    $fechaVencimiento = new \DateTime($cuoFechaLimiteInscripcion1);
                    $fechaVencimiento->add(new \DateInterval("P1D"));
                    $vencimiento = $fechaVencimiento->format("Y-m-d");
                }
                else
                {
                    $semanaEntera = new \DateInterval("P7D");
                    $fechaHoy->add($semanaEntera);
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion1);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert) {
                        // fecha actual menor que una semana antes de la fecha límite
                        $ficha['cuoImporteInscripcion1'] = $importe1;
                        $ficha['cuoFechaLimiteInscripcion1'] =  Carbon::parse($fechaLimite1)->day
                            .'/'. ucfirst(Carbon::parse($fechaLimite1)->formatLocalized('%b'))
                            .'/'. Carbon::parse($fechaLimite1)->year;
                        $ficha['referencia1'] = $referencia1;
                        $fechaVencimiento = new \DateTime($cuoFechaLimiteInscripcion1);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                    }
                    else
                    {
                        $fechaPago = new \DateTime("+7 days");
                        $diferencia = $fechaPago->diff($fechaHoy);
                        if ($diferencia->invert) {
                            //fecha actual antes de una semana previa al fin de mes
                            $ficha['cuoImporteInscripcion1'] = $importe1;
                            $fechaLimiteMes = $fechaPago->format("Y-m-d");

                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteMes)->day
                            .'/'. ucfirst(Carbon::parse($fechaLimiteMes)->formatLocalized('%b'))
                            .'/'. Carbon::parse($fechaLimiteMes)->year;


                            $ficha['referencia1'] = $generarReferencia->crear($concepto, $fechaLimiteMes, $cuoImporteInscripcion1);
                            $fechaVencimiento =$fechaPago;
                            $fechaVencimiento->add(new \DateInterval("P1D"));
                            $vencimiento = $fechaVencimiento->format("Y-m-d");

                            $fchFechaVenc1 = new \DateTime("+7 days");
                            $fchFechaVenc1 = $fchFechaVenc1->format("Y-m-d");


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

                                "fchConc"         => $cuoConceptoRef,

                                "fchFechaVenc1"   => $fchFechaVenc1,
                                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion1']->format()): NULL,
                                "fhcRef1"         => $ficha['referencia1'],

                                "fchFechaVenc2"   => $cuoFechaLimiteInscripcion2,
                                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion2']->format()): NULL,
                                "fhcRef2"         => $ficha['referencia2'],

                                "fchEstado"       => "P"
                            ]);

                        }
                        else
                        {
                            //fecha actual a una semana o menos de fin de mes
                            $ficha['cuoImporteInscripcion1'] = $importe1;
                            $fechaPago = new \DateTime("last day of next month");
                            $fechaLimiteMes = $fechaPago->format("Y-m-d");
                            $ficha['cuoFechaLimiteInscripcion1'] =  Carbon::parse($fechaLimiteMes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteMes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteMes)->year;
                            $ficha['referencia1'] = $generarReferencia->crear($concepto, $fechaLimiteMes, $cuoImporteInscripcion1);
                            $fechaVencimiento = $fechaPago;
                            $fechaVencimiento->add(new \DateInterval("P1D"));
                            $vencimiento = $fechaVencimiento->format("Y-m-d");
                        }
                    }
                }
            }
            */

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
                "fchFechaVenc1"   => $curso->cgt->cgtGradoSemestre < 2 ? Carbon::now()->addDays(15) : Carbon::now()->addDays(7),
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

            return redirect('curso')->withInput();
        }
    }

    public function crearReferenciaHSBC_SINREFERENCIA($curso_id, $tienePagoCeneval)
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
        if ($departamento_clave == "PRE")
        {
            $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
            $diasLimite = 15;
        }
        if ($departamento_clave == "SUP" || $departamento_clave == "POS" || $departamento_clave == "DIP")
        {
            if ($curso->cgt->cgtGradoSemestre == 1)
            {
                $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
                $diasLimite = 15;
            }
            else
            {
                //ALUMNOS QUE NO SON PRIMER SEMESTRE, SE LES COBRA 7 DIAS
                $fechaLimite15Dias = Carbon::now()->addDays(7)->hour(0)->minute(0)->second(0);
                $diasLimite = 7;
            }
        }

        $fechaLimiteHoy = Carbon::now();



        //dd($fechaLimiteHoy,$fechaLimite15Dias);


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
            if($cuota_descuento && MetodosCuotas::aplicaDescuento($curso, $cuota_descuento))
                $cuota = $cuota_descuento;


            $cuoConcepto =  ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "PRE")
            {
                $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1 + (double) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2 + (double) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3 + (double) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaLimiteInscripcion3;
            }

            if ($departamento_clave == "SUP" || $departamento_clave == "POS" || $departamento_clave == "DIP")
            {
                $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1 - 500;
                }
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2;
                // dd($cuota);
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2 - 500;
                }
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3 - 500;
                }
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

            // dd($fechaLimite15Dias,$fechaLimite2);
            //dd($cuoFechaLimiteInscripcion1, $fechaLimite15Dias);


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

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

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

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

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

                $referencia1 = $generarReferencia->crearHSBC($concepto,$fechaReferencia,$cuoImporteInscripcion1, $conpRefClave, "0000");
                $this->insertarReferencia($referencia1);
                $ficha['referencia1'] = $referencia1;

                /*
                $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                $fechaVencimiento->add(new \DateInterval("P1D"));
                $vencimiento = $fechaVencimiento->format("Y-m-d");
                */

                $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
            }


            /*
            $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
            $diferencia = $fechaPago->diff($fechaHoy);
            if ($diferencia->invert)
            {
                //fecha actual menor que la primera fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite1)->day
                .'/'. ucfirst(Carbon::parse($fechaLimite1)->formatLocalized('%b'))
                .'/'. Carbon::parse($fechaLimite1)->year;
                $ficha['referencia1'] = $referencia1;
                $ficha['cuoImporteInscripcion2'] = $importe2;

                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimite2)->day
                    .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaLimite2)->year;
                $ficha['referencia2'] = $referencia2;
                $fechaVencimiento = new \DateTime($cuoFechaLimiteInscripcion2);
                $fechaVencimiento->add(new \DateInterval("P1D"));
                $vencimiento = $fechaVencimiento->format("Y-m-d");
            }
            else
            {
                $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                $diferencia = $fechaPago->diff($fechaHoy);
                if ($diferencia->invert)
                {
                    //fecha actual menor que la segunda fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe2;
                    $ficha['cuoFechaLimiteInscripcion1'] =  Carbon::parse($fechaLimite2)->day
                        .'/'. ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                        .'/'. Carbon::parse($fechaLimite2)->year;
                    $ficha['referencia1'] = $referencia2;
                    $ficha['cuoImporteInscripcion2'] = $importe1;

                    $ficha['cuoFechaLimiteInscripcion2'] =  Carbon::parse($fechaLimite1)->day
                    .'/'. ucfirst(Carbon::parse($fechaLimite1)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaLimite1)->year;
                    $ficha['referencia2'] = $referencia1;
                    $fechaVencimiento = new \DateTime($cuoFechaLimiteInscripcion1);
                    $fechaVencimiento->add(new \DateInterval("P1D"));
                    $vencimiento = $fechaVencimiento->format("Y-m-d");
                }
                else
                {
                    $semanaEntera = new \DateInterval("P7D");
                    $fechaHoy->add($semanaEntera);
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion1);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert) {
                        // fecha actual menor que una semana antes de la fecha límite
                        $ficha['cuoImporteInscripcion1'] = $importe1;
                        $ficha['cuoFechaLimiteInscripcion1'] =  Carbon::parse($fechaLimite1)->day
                            .'/'. ucfirst(Carbon::parse($fechaLimite1)->formatLocalized('%b'))
                            .'/'. Carbon::parse($fechaLimite1)->year;
                        $ficha['referencia1'] = $referencia1;
                        $fechaVencimiento = new \DateTime($cuoFechaLimiteInscripcion1);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                    }
                    else
                    {
                        $fechaPago = new \DateTime("+7 days");
                        $diferencia = $fechaPago->diff($fechaHoy);
                        if ($diferencia->invert) {
                            //fecha actual antes de una semana previa al fin de mes
                            $ficha['cuoImporteInscripcion1'] = $importe1;
                            $fechaLimiteMes = $fechaPago->format("Y-m-d");

                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteMes)->day
                            .'/'. ucfirst(Carbon::parse($fechaLimiteMes)->formatLocalized('%b'))
                            .'/'. Carbon::parse($fechaLimiteMes)->year;


                            $ficha['referencia1'] = $generarReferencia->crearHSBC($concepto, $fechaLimiteMes, $cuoImporteInscripcion1);
                            $fechaVencimiento =$fechaPago;
                            $fechaVencimiento->add(new \DateInterval("P1D"));
                            $vencimiento = $fechaVencimiento->format("Y-m-d");

                            $fchFechaVenc1 = new \DateTime("+7 days");
                            $fchFechaVenc1 = $fchFechaVenc1->format("Y-m-d");


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

                                "fchConc"         => $cuoConceptoRef,

                                "fchFechaVenc1"   => $fchFechaVenc1,
                                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion1']->format()): NULL,
                                "fhcRef1"         => $ficha['referencia1'],

                                "fchFechaVenc2"   => $cuoFechaLimiteInscripcion2,
                                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"],"",$ficha['cuoImporteInscripcion2']->format()): NULL,
                                "fhcRef2"         => $ficha['referencia2'],

                                "fchEstado"       => "P"
                            ]);

                        }
                        else
                        {
                            //fecha actual a una semana o menos de fin de mes
                            $ficha['cuoImporteInscripcion1'] = $importe1;
                            $fechaPago = new \DateTime("last day of next month");
                            $fechaLimiteMes = $fechaPago->format("Y-m-d");
                            $ficha['cuoFechaLimiteInscripcion1'] =  Carbon::parse($fechaLimiteMes)->day
                                .'/'. ucfirst(Carbon::parse($fechaLimiteMes)->formatLocalized('%b'))
                                .'/'. Carbon::parse($fechaLimiteMes)->year;
                            $ficha['referencia1'] = $generarReferencia->crearHSBC($concepto, $fechaLimiteMes, $cuoImporteInscripcion1);
                            $fechaVencimiento = $fechaPago;
                            $fechaVencimiento->add(new \DateInterval("P1D"));
                            $vencimiento = $fechaVencimiento->format("Y-m-d");
                        }
                    }
                }
            }
            */

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
                "fchFechaVenc1"   => $curso->cgt->cgtGradoSemestre < 2 ? Carbon::now()->addDays(15) : Carbon::now()->addDays(7),
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

            return redirect('curso')->withInput();
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

        $curso = Curso::with('cgt.periodo','cgt.plan.programa.escuela.departamento.ubicacion','alumno.persona')->find($curso_id);
        $clave_pago = $curso->alumno->aluClave;
        $alumno_id = $curso->alumno->id;
        $programa_id = $curso->cgt->plan->programa->id;

        $escuela_id = $curso->cgt->plan->programa->escuela->id;
        $departamento_id = $curso->cgt->plan->programa->escuela->departamento->id;
        $perNumero = $curso->cgt->periodo->perNumero;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $cuoConcepto = "99";

        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        if(MetodosAlumnos::esAlumnoDeudorNivelActual(
            $curso->alumno->aluClave,
            $ubiClave,
            $depClave,
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela. Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if(MetodosAlumnos::esAlumnoDeudorNivelMAT(
            $curso->alumno->aluClave,
            $ubiClave,
            $depClave,
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Maternal). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }


        if(MetodosAlumnos::esAlumnoDeudorNivelPRE(
            $curso->alumno->aluClave,
            $ubiClave,
            $depClave,
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Preescolar). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if(MetodosAlumnos::esAlumnoDeudorNivelPRI(
            $curso->alumno->aluClave,
            $ubiClave,
            $depClave,
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Primaria). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if(MetodosAlumnos::esAlumnoDeudorNivelSEC(
            $curso->alumno->aluClave,
            $ubiClave,
            'SEC',
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Secundaria). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if(MetodosAlumnos::esAlumnoDeudorNivelBAC(
            $curso->alumno->aluClave,
            $ubiClave,
            'SEC',
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Bachiller). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if($depClave == "POS"){
            if(MetodosAlumnos::esAlumnoDeudorNivelSUP(
                $curso->alumno->aluClave,
                $ubiClave,
                'SUP',
                $cuoConcepto,
                $perAnioPago
            )) {
                alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Superior). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
                return redirect()->back()->withInput();
            }
        }

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        if ($departamento_clave == "SUP" || $departamento_clave == "POS" || $departamento_clave == "DIP")
        {
            $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
            $diasLimite = 15;
            //Se dan sólo tres días de gracia si ya pasó el 20 de enero
            $anioLimiteActual = $perAnioPago + 1;
            $fechaLimitePeriodo1 = Carbon::createFromFormat("Y-m-d", "$anioLimiteActual-01-20");
            $fechaLimiteHoy = Carbon::now();
            if ($fechaLimiteHoy->gt($fechaLimitePeriodo1)) {
                $fechaLimite15Dias = Carbon::now()->addDays(3)->hour(0)->minute(0)->second(0);
                $diasLimite = 3;
            }
        }

        $fechaLimiteHoy = Carbon::now();
        //dd($fechaLimiteHoy,$fechaLimite15Dias);

        $perAnio = $perAnioPago;
        $periodoConcepto = [
            0 => '99',
            1 => '00',
            3 => '99',
            4 => '00',
            6 => '99',
        ];
        if (array_key_exists($perNumero, $periodoConcepto)) {
            $cuoConcepto = $periodoConcepto[$perNumero];
        }

        // if ($perNumero != 3 && $perNumero != 0) {
        //     $perAnio = $perAnio - 1;
        //     $cuoConcepto = "00";
        // }

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
            if($cuota_descuento && MetodosCuotas::aplicaDescuento($curso, $cuota_descuento))
                $cuota = $cuota_descuento;


            $cuoConcepto =  ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "SUP" || $departamento_clave == "POS" || $departamento_clave == "DIP")
            {
                $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1 + (double) $cuota->cuoImportePadresFamilia;
                if($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 -= 500;
                }
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2 + (double) $cuota->cuoImportePadresFamilia;
                if($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 -= 500;
                }
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3 + (double) $cuota->cuoImportePadresFamilia;
                if($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 -= 500;
                }
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

            // dd($fechaLimite15Dias,$fechaLimite2);
            //dd($cuoFechaLimiteInscripcion1, $fechaLimite15Dias);

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

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

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

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

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

                    /*
                    $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                    $fechaVencimiento->add(new \DateInterval("P1D"));
                    $vencimiento = $fechaVencimiento->format("Y-m-d");
                    */

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
                "fchEstado"       => "A"
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

            return redirect('curso')->withInput();
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

        $curso = Curso::with('cgt.periodo','cgt.plan.programa.escuela.departamento.ubicacion','alumno.persona')->find($curso_id);
        $clave_pago = $curso->alumno->aluClave;
        $alumno_id = $curso->alumno->id;
        $programa_id = $curso->cgt->plan->programa->id;

        $escuela_id = $curso->cgt->plan->programa->escuela->id;
        $departamento_id = $curso->cgt->plan->programa->escuela->departamento->id;
        $perNumero = $curso->cgt->periodo->perNumero;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $cuoConcepto = "99";

        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        if(MetodosAlumnos::esAlumnoDeudorNivelActual(
            $curso->alumno->aluClave,
            $ubiClave,
            $depClave,
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela. Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if(MetodosAlumnos::esAlumnoDeudorNivelMAT(
            $curso->alumno->aluClave,
            $ubiClave,
            $depClave,
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Maternal). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }


        if(MetodosAlumnos::esAlumnoDeudorNivelPRE(
            $curso->alumno->aluClave,
            $ubiClave,
            $depClave,
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Preescolar). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if(MetodosAlumnos::esAlumnoDeudorNivelPRI(
            $curso->alumno->aluClave,
            $ubiClave,
            $depClave,
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Primaria). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if(MetodosAlumnos::esAlumnoDeudorNivelSEC(
            $curso->alumno->aluClave,
            $ubiClave,
            'SEC',
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Secundaria). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if(MetodosAlumnos::esAlumnoDeudorNivelBAC(
            $curso->alumno->aluClave,
            $ubiClave,
            'SEC',
            $cuoConcepto,
            $perAnioPago
        )) {
            alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Bachiller). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

        if($depClave == "POS"){
            if(MetodosAlumnos::esAlumnoDeudorNivelSUP(
                $curso->alumno->aluClave,
                $ubiClave,
                'SUP',
                $cuoConcepto,
                $perAnioPago
            )) {
                alert('Escuela Modelo', 'El alumno tiene una deuda de pago con la Escuela (Superior). Favor de remitirlo al departamento correspondiente para regularizar sus pagos.', 'warning')->showConfirmButton();
                return redirect()->back()->withInput();
            }
        }

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        if ($departamento_clave == "SUP" || $departamento_clave == "POS" || $departamento_clave == "DIP")
        {
            $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
            $diasLimite = 15;
            //Se dan sólo tres días de gracia si ya pasó el 20 de enero
            $anioLimiteActual = $perAnioPago + 1;
            $fechaLimitePeriodo1 = Carbon::createFromFormat("Y-m-d", "$anioLimiteActual-01-20");
            $fechaLimiteHoy = Carbon::now();
            if ($fechaLimiteHoy->gt($fechaLimitePeriodo1)) {
                $fechaLimite15Dias = Carbon::now()->addDays(3)->hour(0)->minute(0)->second(0);
                $diasLimite = 3;
            }
        }

        $fechaLimiteHoy = Carbon::now();
        //dd($fechaLimiteHoy,$fechaLimite15Dias);

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
            if($cuota_descuento && MetodosCuotas::aplicaDescuento($curso, $cuota_descuento))
                $cuota = $cuota_descuento;


            $cuoConcepto =  ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "SUP" || $departamento_clave == "POS" || $departamento_clave == "DIP")
            {
                $cuoImporteInscripcion1 = (double) $cuota->cuoImporteInscripcion1 + (double) $cuota->cuoImportePadresFamilia;
                if($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 -= 500;
                }
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (double) $cuota->cuoImporteInscripcion2 + (double) $cuota->cuoImportePadresFamilia;
                if($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 -= 500;
                }
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (double) $cuota->cuoImporteInscripcion3 + (double) $cuota->cuoImportePadresFamilia;
                if($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 -= 500;
                }
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

            // dd($fechaLimite15Dias,$fechaLimite2);
            //dd($cuoFechaLimiteInscripcion1, $fechaLimite15Dias);

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

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

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

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

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

                    /*
                    $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                    $fechaVencimiento->add(new \DateInterval("P1D"));
                    $vencimiento = $fechaVencimiento->format("Y-m-d");
                    */

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

            return redirect('curso')->withInput();
        }
    }

    private function generatePDF($ficha) {
        //valores de celdas
        //curso escolar
        // $talonarios = ['banco', 'alumno'];
        $talonarios = ['banco'];
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
        $anchoLargo1 = 175;

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
        $conceptoC = "INSCRIPCIÓN AL SEMESTRE $ficha[gradoSemestre] DE $ficha[progNombre]";
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
                if($pago1Fecha != $pago2Fecha) {
                    $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
                    /*------------------------------------------------------------------------------*/

                    $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                    $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);
                }
            }

            /*
            if ($ficha['curso']->curTipoIngreso == "PI")
            {

                $fechaPago1PI = $ficha['cuoFechaLimiteInscripcion1DB'];
                $fechaPago1FormatPI = "";
                $esAtrasoPI = false;
                //se paso de la fecha
                if (Carbon::now()->gt($ficha['cuoFechaLimiteInscripcion1DB'])) {
                    $fechaPago1PI = Carbon::now()->addDays(15);

                    $fechaPago1FormatPI = Carbon::parse($fechaPago1PI)->day
                    .'/'. ucfirst(Carbon::parse($fechaPago1PI)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaPago1PI)->year;
                    $esAtrasoPI = true;
                }

                //faltan menos de 15 dias
                if (Carbon::now()->lt($ficha['cuoFechaLimiteInscripcion1DB'])
                && Carbon::now()->diffInDays($ficha['cuoFechaLimiteInscripcion1DB']) < 15) {

                    $fechaPago1PI = Carbon::now()->addDays(15);
                    $fechaPago1FormatPI = Carbon::parse($fechaPago1PI)->day
                    .'/'. ucfirst(Carbon::parse($fechaPago1PI)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaPago1PI)->year;
                    $esAtrasoPI = true;
                }


                // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA

                $fechaFila15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
                $fechaPago15DiasFormatPI = Carbon::parse($fechaFila15Dias)->day
                    .'/'. ucfirst(Carbon::parse($fechaFila15Dias)->formatLocalized('%b'))
                    .'/'. Carbon::parse($fechaFila15Dias)->year;
                $fechaFila15Dias = $fechaFila15Dias->format("Y-m-d");


                if (Carbon::now()->lte($ficha['cuoFechaLimiteInscripcion2DB']))
                {

                    $importeRef = str_replace ("$", "",$pago2Importe->format());
                    $importeRef = str_replace (",", "",$importeRef);

                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$referencia  = $generarReferencia->crear($ficha["concepto"],$ficha['cuoFechaLimiteInscripcion2DB'],$importeRef);
                    $referencia  = $generarReferencia->crear($ficha["concepto"],$fechaFila15Dias,$importeRef);


                    $this->insertarReferencia($referencia);

                    $pdf->SetX($columna1);

                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
                    $pdf->Cell($anchoCorto, $filaH, $fechaPago15DiasFormatPI, 1, 0);
                    //------------------------------------------------------------------------------

                    $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                    $pdf->Cell($anchoMedio, $filaH, $referencia, 1, 1);


                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$ultimaFecha = $ficha['cuoFechaLimiteInscripcion2DB'];
                    //$ultimaFecha = $fechaFila15Dias;
                    //------------------------------------------------------------------------------

                     // Ficha::create([
                    //     "fchNumPer"       => $ficha["curso"]->cgt->periodo->perNumero,
                    //     "fchAnioPer"      => $ficha["curso"]->cgt->periodo->perAnio,
                    //     "fchClaveAlu"     => $ficha["curso"]->alumno->aluClave,
                    //     "fchClaveCarr"    => $ficha["curso"]->cgt->plan->programa->progClave,
                    //     "fchClaveProgAct" => NULL,
                    //     "fchGradoSem"     => $ficha["curso"]->cgt->cgtGradoSemestre,
                    //     "fchGrupo"        => $ficha["curso"]->cgt->cgtGrupo,
                    //     "fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
                    //     "fchHoraImpr"     => Carbon::now()->format("h:i:s"),
                    //     "fchUsuaImpr"     => auth()->user()->id,
                    //     "fchTipo"         => $ficha["curso"]->alumno->aluEstado,

                    //     "fchConc"         => $ficha["cuoConceptoRef"],

                    //     "fchFechaVenc1"   => $ficha['cuoFechaLimiteInscripcion2DB'],
                    //     "fhcImp1"         => str_replace(["$", ","], "",$pago2Importe->format()),
                    //     "fhcRef1"         => $referencia,

                    //     "fchFechaVenc2"   => null,
                    //     "fhcImp2"         => null,
                    //     "fhcRef2"         => null,

                    //     "fchEstado"       => "P"
                    // ]);


                }
                $pdf->SetX($columna1);


                if ($esAtrasoPI)
                {
                    $importeRef = str_replace ("$", "",$pago1Importe->format());
                    $importeRef = str_replace (",", "",$importeRef);

                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$referencia  = $generarReferencia->crear($ficha["concepto"],$fechaPago1PI->format("Y-m-d"),$importeRef);
                    $referencia  = $generarReferencia->crear($ficha["concepto"],$fechaFila15Dias,$importeRef);
                    //------------------------------------------------------------------------------

                    $this->insertarReferencia($referencia);

                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$pdf->Cell($anchoCorto, $filaH, $fechaPago1FormatPI, 1, 0);
                    $pdf->Cell($anchoCorto, $filaH, $fechaPago15DiasFormatPI, 1, 0);
                    //------------------------------------------------------------------------------

                    $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                    $pdf->Cell($anchoMedio, $filaH, $referencia, 1, 1);

                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$ultimaFecha = $fechaPago1PI->format("Y-m-d");
                    $ultimaFecha = $fechaFila15Dias;
                    //------------------------------------------------------------------------------

                }
                else
                    {
                    $importeRef = str_replace ("$", "",$pago1Importe->format());
                    $importeRef = str_replace (",", "",$importeRef);

                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$referencia  = $generarReferencia->crear($ficha["concepto"],$ficha['cuoFechaLimiteInscripcion1DB'],$importeRef);
                    $referencia  = $generarReferencia->crear($ficha["concepto"],$fechaFila15Dias,$importeRef);
                    //------------------------------------------------------------------------------

                    $this->insertarReferencia($referencia);
                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
                    $pdf->Cell($anchoCorto, $filaH, $fechaPago15DiasFormatPI, 1, 0);
                    //------------------------------------------------------------------------------

                    $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                    $pdf->Cell($anchoMedio, $filaH, $referencia, 1, 1);

                    // FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA
                    //$ultimaFecha = $ficha['cuoFechaLimiteInscripcion1DB'];
                    $ultimaFecha = $fechaFila15Dias;
                   //------------------------------------------------------------------------------
                }
            }

            if ($ficha['curso']->curTipoIngreso != "PI")
            {

                if (!$ficha['tieneDescuento']) {
                    $fechaFila1 = $pago2Fecha;
                    $filareffecha1 =   $ficha['cuoFechaLimiteInscripcion2DB'];

                    $fechaFila2 = $ficha['fechaLimite15Dias'];
                } else {
                    $fechaFila1 = $ficha['fechaLimite15Dias'];
                    $filareffecha1   = $ficha['fechaLimite15DiasDB']->format("Y-m-d");

                    $fechaFila2 = $pago1Fecha;
                }

                // dd($fechaFila1, $ficha['fechaLimite15DiasDB']->format("Y-m-d"));

                    $importeRef = str_replace ("$", "",$pago2Importe->format());
                    $importeRef = str_replace (",", "",$importeRef);
                    $referencia  = $generarReferencia->crear($ficha["concepto"],$filareffecha1,$importeRef);
                    $this->insertarReferencia($referencia);

                    $pdf->SetX($columna1);
                if ($fechaFila1) {
                    $pdf->Cell($anchoCorto, $filaH, $fechaFila1, 1, 0);
                    $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                    $pdf->Cell($anchoMedio, $filaH, $referencia, 1, 1);

                    $ultimaFecha = $filareffecha1;
                } else {
                    $pdf->Cell($anchoCorto, $filaH, "", 1, 0);
                    $pdf->Cell($anchoCorto, $filaH, "", 1, 0);
                    $pdf->Cell($anchoMedio, $filaH, "", 1, 1);
                }

                //ficha no tiene descuento y muestra la cantidad sin descuento
                if (!$ficha['tieneDescuento']) {
                    $importeRef = str_replace ("$", "",$pago1Importe->format());
                    $importeRef = str_replace (",", "",$importeRef);
                    $referencia  = $generarReferencia->crear($ficha["concepto"],$ficha['fechaLimite15DiasDB']->format("Y-m-d"),$importeRef);
                    $this->insertarReferencia($referencia);

                    $pdf->SetX($columna1);
                    $pdf->Cell($anchoCorto, $filaH, $fechaFila2, 1, 0);
                    $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                    $pdf->Cell($anchoMedio, $filaH, $referencia, 1, 1);

                    $ultimaFecha = $ficha['fechaLimite15DiasDB']->format("Y-m-d");
                }
            }
            */


            /*
            if (Carbon::now()->lte($ultimaFecha)) {
                $fecha = Carbon::parse($ultimaFecha)->addDays(1);
                $vencimiento = Carbon::parse($fecha)->day
                .'/'. ucfirst(Carbon::parse($fecha)->formatLocalized('%b'))
                .'/'. Carbon::parse($fecha)->year;
            }
            */

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

            $pdf->SetY(100);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell($anchoLargo1, $filaH, "*** PARA PAGO EXCLUSIVO EN CAJA Y CAJERO BBVA ***", 0, 0, 'C');

            $pdf->SetY(110);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoLargo1, $filaH, "PAGAR USANDO LA CLAVE DE CONVENIO {$ficha['cuoNumeroCuenta']}", 0, 0, 'C');

            $pdf->SetY(116);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoLargo1, $filaH, "NO EFECTUAR TRANSFERENCIAS EN BBVA PORQUE NO SE REGISTRAN", 0, 0, 'C');

            // if ($ficha['cuoFechaLimiteInscripcion3'] != null) {
            //     $pdf->SetX($columna1);
            //     $pdf->Cell($anchoCorto, $filaH, $pago3Fecha, 0, 0);
            //     $pdf->Cell($anchoCorto, $filaH, $pago3Importe, 0, 0);
            //     $pdf->Cell($anchoCorto, $filaH, $pago3Referencia, 0, 1);
            // }

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    private function generatePDF_HSBC_SINREFERENCIA($ficha) {
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
        $conceptoC = "INSCRIPCIÓN AL SEMESTRE $ficha[gradoSemestre] DE $ficha[progNombre]";
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
            $pdf->Cell($cursoW, $cursoH, "PAGO POR TRANSFERENCIA ELECTRONICA SPEI", 0, 0, 'C');


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
            $pdf->Cell($anchoCorto, $filaH,"021180550300090224", 1, 0);
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
                if($pago1Fecha != $pago2Fecha) {
                    $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
                    /*------------------------------------------------------------------------------*/

                    $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                    $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);
                }
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
        $conceptoC = "INSCRIPCIÓN AL SEMESTRE $ficha[gradoSemestre] DE $ficha[progNombre]";
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
            $pdf->Cell($anchoCorto, $filaH,"021180550300090224", 1, 0,'C');
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
            // $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0); // título de la invalidación
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->SetX($columna2);
            // $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0); // fecha de invalidación

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
        $conceptoC = "INSCRIPCIÓN AL SEMESTRE $ficha[gradoSemestre] DE $ficha[progNombre]";
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
            // $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0); // título de la invalidación
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->SetX($columna2);
            // $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0); // fecha de invalidación

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
