<?php

namespace App\Http\Controllers\Secundaria;

use Lang;
use App\clases\alumno_expediente\ExpedienteAlumno;
use App\clases\alumnos\MetodosAlumnos;
use App\clases\cuotas\MetodosCuotas;
use App\clases\cursos\MetodosCursos;
use App\clases\cursos\NotificacionSecundaria;
use App\Http\Helpers\ClubdePanchito;
use App\Http\Helpers\SuperUsuario;
use App\Models\CuotaDescuento;
use PDF;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Beca;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\CursoObservaciones;
use App\Models\Pago;
use App\Models\Modules;
use App\Models\Permission;
use App\Models\Permission_module_user;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Baja;
use App\Models\Plan;
use App\Models\Cuota;
use App\Models\Ficha;
use App\Models\Grupo;
use App\Models\Alumno;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Materia;
use App\Models\Periodo;
use App\Models\Inscrito;
use App\Models\Historico;
use App\Models\Ubicacion;
use App\Models\Calificacion;
use App\Models\ConceptoBaja;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Http\Helpers\GenerarReferencia;
use App\Http\Controllers\Reportes\ColegiaturasController;
use App\Models\Programa;
use App\Models\Departamento;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_actividades;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_conducta;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_desarrollo;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_familiares;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_habitos;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_heredo;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_medica;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_nacimiento;
use App\Models\Secundaria\Secundaria_alumnos_historia_clinica_sociales;
use App\Models\Secundaria\Secundaria_calificaciones;
use App\Models\Secundaria\Secundaria_inscritos;
use App\Models\Secundaria\Secundaria_materias;
use App\Models\User_docente;

class SecundariaCursoController extends Controller
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
        $registroUltimoPago = Pago::select(DB::raw('MAX(pagFechaPago)'))->where("pagFormaAplico", "=", "A")->latest()->first();


        $registroUltimoPago = Carbon::parse($registroUltimoPago->pagFechaPago)->day
            . "/" . Utils::num_meses_corto_string(Carbon::parse($registroUltimoPago->pagFechaPago)->month)
            . "/" . Carbon::parse($registroUltimoPago->pagFechaPago)->year;

        return view('secundaria.cursos.show-list', [
            "registroUltimoPago" => $registroUltimoPago

        ]);
    }

    public function list()
    {
        if (Auth::user()->secundaria == 1) {
            $cursos = Curso::select(
                'cursos.id as curso_id',
                'cursos.curTipoBeca',
                'cursos.curPorcentajeBeca',
                'cursos.curPlanPago',
                'alumnos.aluClave',
                'alumnos.id as alumno_id',
                'alumnos.aluMatricula',
                'alumnos.aluEstado',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'periodos.id as periodo_id',
                'periodos.perNumero',
                'periodos.perAnio',
                'personas.perSexo',
                'periodos.perAnioPago',
                'cursos.curEstado',
                'cursos.curTipoIngreso',
                'cursos.curFechaBaja',
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
                'ubicacion.ubiClave'
            )
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->whereIn('depClave', ['SEC'])
                // ->orderBy("cursos.id", "desc");
                ->latest('cursos.id');
        }

        $permisos = (User::permiso("curso") == "A" || User::permiso("curso") == "B");
        $permisoA = (User::permiso("curso") == "A");

        return Datatables::of($cursos)

            ->filterColumn('periodo_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_pago', function ($query) {
                return $query->perAnioPago;
            })

            ->filterColumn('clave_alumno', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_alumno', function ($query) {
                return $query->aluClave;
            })

            ->filterColumn('matricula_alumno', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluMatricula) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('matricula_alumno', function ($query) {
                return $query->aluMatricula;
            })


            ->filterColumn('plan_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(curPlanPago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('plan_pago', function ($query) {
                return $query->curPlanPago;
            })


            ->filterColumn('nombre_alumno', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_alumno', function ($query) {
                return $query->perNombre;
            })
            ->filterColumn('apellido_paterno', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido_paterno', function ($query) {
                return $query->perApellido1;
            })
            ->filterColumn('apellido_materno', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido_materno', function ($query) {
                return $query->perApellido2;
            })

            ->filterColumn('estado_curso', function ($query, $keyword) {
                $query->whereRaw("CONCAT(curEstado) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('estado_curso', function ($query) {
                return $query->curEstado;
            })

            ->filterColumn('grado_alumno', function ($query, $keyword) {
                $query->whereRaw("CONCAT(cgtGradoSemestre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('grado_alumno', function ($query) {
                return $query->cgtGradoSemestre;
            })

            ->filterColumn('grupo_alumno', function ($query, $keyword) {
                $query->whereRaw("CONCAT(cgtGrupo) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('grupo_alumno', function ($query) {
                return $query->cgtGrupo;
            })


            ->filterColumn('beca', function ($query, $keyword) {
                return $query->whereRaw("CONCAT(curTipoBeca, curPorcentajeBeca) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('beca', function ($query) {
                return $query->curTipoBeca . $query->curPorcentajeBeca;
            })

            ->filterColumn('clave_ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_ubicacion', function ($query) {
                return $query->ubiClave;
            })

            ->filterColumn('clave_departamento', function ($query, $keyword) {
                $query->whereRaw("CONCAT(depClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_departamento', function ($query) {
                return $query->depClave;
            })

            ->filterColumn('clave_escuela', function ($query, $keyword) {
                $query->whereRaw("CONCAT(escClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_escuela', function ($query) {
                return $query->escClave;
            })


            ->filterColumn('clave_programa', function ($query, $keyword) {
                $query->whereRaw("CONCAT(progClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_programa', function ($query) {
                return $query->progClave;
            })

            ->filterColumn('clave_plan', function ($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_plan', function ($query) {
                return $query->planClave;
            })

            ->filterColumn('estado_alummo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluEstado) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('estado_alummo', function ($query) {
                return $query->aluEstado;
            })


            ->filterColumn('genero', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perSexo) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('genero', function ($query) {
                return $query->perSexo;
            })

            ->addColumn('action', function ($query) use ($permisos, $permisoA) {

                $pedirConfirmacion = 'NO';
                if ($query->ubiClave == 'CME' && $query->depClave == 'SUP' && $query->cgtGradoSemestre == 1) {
                    $pedirConfirmacion = 'SI';
                }

                // Obtener las personas autorizadas
                $expediente = ExpedienteAlumno::buscaPersonasAutirizadas($query->depClave, $query->alumno_id);
                // Obtener la IP de la maquina local
                $localIP = getHostByName(getHostName());

                $user_id = Auth::id();

                $btnMostrarAcciones = '';
                if (Auth::user()->secundaria == 1) {
                    $userDepClave = "SEC";
                    $userClave = Auth::user()->username;

                    $btnFichaPagoBBVA = "";
                    $btnFichaPagoHSBC = "";

                    if ($expediente[0] == "" && $expediente[1] == "") {
                        $btnFichaPagoBBVA = '<a href="#modalFichaPago" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="' . $pedirConfirmacion . '"  class=" btn-modal-ficha-pago-sin-validar button button--icon js-button js-ripple-effect" title="Ficha BBVA">
                        <i class="material-icons">local_atm</i>
                        </a>';
                        $btnFichaPagoHSBC = '<a href="#modalFichaPago" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="' . $pedirConfirmacion . '"  class=" btn-modal-ficha-pago-hsbc-sin-validar button button--icon js-button js-ripple-effect" title="Ficha HSBC">
                        <i class="material-icons">description</i>
                        </a>';
                    } else {

                        $btnFichaPagoBBVA = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '">
                        <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA FICHA BBVA" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="' . $pedirConfirmacion . '" class="btn-modal-ficha-pago button button--icon js-button js-ripple-effect confirm-autorizado" title="Ficha BBVA">
                            <i class="material-icons">local_atm</i>
                        </a>
                        </form>';

                        $btnFichaPagoHSBC = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '">
                        <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA FICHA HSBC" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" data-curso-id="' . $query->curso_id . '" data-pedir-confirmacion="' . $pedirConfirmacion . '" class="btn-modal-ficha-pago-hsbc button button--icon js-button js-ripple-effect confirm-autorizado" title="Ficha HSBC">
                            <i class="material-icons">description</i>
                        </a>
                        </form>';
                    }


                    if ($query->curEstado == "B" || $query->curEstado == "R" || $query->curEstado == "X") {
                        $btnFichaPagoBBVA = "";
                        $btnFichaPagoHSBC = "";
                    }

                    $btnTarjetaPagoBBVA = "";
                    $btnTarjetaPagoHSBC = "";
                    if ($query->curEstado == "R") {
                        if ((SuperUsuario::tieneSuperPoder($userDepClave, $userClave))
                            || ClubdePanchito::esAmigo($userDepClave, $userClave)
                            || ($userClave == "ALENOVELO")
                            || ($userClave == "LOLHACG")
                        ) {
                            if ($expediente[0] == "" && $expediente[1] == "") {
                                $btnTarjetaPagoBBVA = '<a target="_blank" href="tarjetaPagoAlumno/' . $query->curso_id .
                                    '/BBVA" class="button modal-trigger button--icon js-button js-ripple-effect" title="BBVA">
                                    <i class="material-icons">format_bold</i>
                                </a>';

                                $btnTarjetaPagoHSBC = '<a target="_blank" href="tarjetaPagoAlumno/' . $query->curso_id .
                                    '/HSBC" class="button modal-trigger button--icon js-button js-ripple-effect" title="HSBC">
                                    <i class="material-icons">strikethrough_s</i>
                                    </a>';
                            } else {
                                $btnTarjetaPagoBBVA = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="tarjetaPagoAlumno/' . $query->curso_id . '/BBVA">
                                <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA TARJETA PAGO BBVA PREINSCRITO" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="BBVA">
                                    <i class="material-icons">format_bold</i>
                                </a>
                                </form>';

                                $btnTarjetaPagoHSBC = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="tarjetaPagoAlumno/' . $query->curso_id . '/HSBC">
                                <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA TARJETA PAGO HSBC PREINSCRITO" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="HSBC">
                                    <i class="material-icons">strikethrough_s</i>
                                </a>
                                </form>';
                            }
                        }
                    }

                    $btnEditar = "";
                    $btnBajaARegular = "";
                    $btnCambiarEstado = "";
                    $btnEliminarCurso = "";
                    $btnConstanciaEstudio = "";
                    $btnConstanciaNoAdeudo = "";
                    $btnConstanciaDeCupo = "";
                    $btnBoletaACD = "";
                    $btnBoleta = "";
                    $btnGruposAlumnos = "";
                    $btnConstanciaDeCupoDigital = "";
                    $btnContanciaPromedioFinal = "";
                    $btnContanciaArtesTaller = "";
                    $btnContanciaInscripcion = "";
                    $btnContanciaEscolaridad = "";
                    $btnCartaConducta = "";

                    $perActual =  DB::select("select perAnioPago FROM periodos where periodos.id IN (SELECT perActual FROM departamentos WHERE depClave IN ('SEC'))");
                    $perSelec =  DB::select("select perAnioPago FROM periodos where periodos.id = " . $query->periodo_id);

                    $perAnioPagoCursoSeleccionado = (int) $perSelec[0]->perAnioPago;
                    $perAnioPagoActual = (int) $perActual[0]->perAnioPago;

                    if ($query->curEstado != "B") {
                        $btnBajaARegular = '<a href="#modalBajaCursoSecundaria" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-baja-curso-secundaria button button--icon js-button js-ripple-effect " title="Baja curso">
                                        <i class="material-icons">archive</i> </a>';
                    }

                    if ($perAnioPagoCursoSeleccionado >= $perAnioPagoActual) {
                        if (
                            SuperUsuario::tieneSuperPoder($userDepClave, $userClave)
                            || ClubdePanchito::esAmigo($userDepClave, $userClave)
                        ) {
                            $btnEditar = '<a href="/secundaria_curso/' . $query->curso_id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i> </a>';
                        }


                        if (SuperUsuario::tieneSuperPoder($userDepClave, $userClave)) {
                            if ($permisoA) {
                                $btnCambiarEstado = '<a href="#modalBajaARegularCurso" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-baja-a-regular button button--icon js-button js-ripple-effect " title="Cambiar Estado">
                                                <i class="material-icons">unarchive</i> </a>';
                            }
                        }
                    }


                    if ($query->curEstado == "B") {
                        $btnEliminarCurso = '<form style="display: inline-block;" id="delete_' . $query->curso_id . '" action="secundaria_curso/delete/' . $query->curso_id . '" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <a href="#" data-id="' . $query->curso_id . '" class="button button--icon js-button js-ripple-effect confirm-delete-curso" title="Eliminar">
                                        <i class="material-icons">delete</i>
                                    </a>
                                </form>';
                    }



                    $verAlumnoDetalle = "";
                    $btnVer = "";
                    $btnHistorialPagos = "";
                    $btnObservaciones =  "";
                    $btnContanciaEstidioConFoto = "";


                    if ($expediente[0] == "" && $expediente[1] == "") {

                        $verAlumnoDetalle = '<a href="#modalAlumnoDetalle-secundaria" data-alumno-id="' . $query->alumno_id . '" class="modal-trigger btn-modal-alumno-detalle-secundaria button button--icon js-button js-ripple-effect " title="Ver Alumno Detalle">
                            <i class="material-icons">face</i>
                        </a>';

                        // ver curso
                        $btnVer = '<a href="/secundaria_curso/' . $query->curso_id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                            <i class="material-icons">visibility</i>
                        </a>';

                        // historial pagos
                        $btnHistorialPagos = '<a href="#modalHistorialPagosAluSecundaria" data-nombres="' . $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2 .
                            '" data-aluclave="' . $query->aluClave . '" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-historial-pagos-secundaria button button--icon js-button js-ripple-effect" title="Historial Pagos">
                            <i class="material-icons">attach_money</i>
                        </a>';

                        // / observaciones
                        $btnObservaciones = '<a href="/secundaria_curso/observaciones/' . $query->curso_id . '" class="button button--icon js-button js-ripple-effect" title="Observaciones">
                            <i class="material-icons">subtitles</i>
                        </a>';


                        if ($query->curEstado == "R") {

                            // boleta
                            $btnBoleta = '<a target="_blank" href="secundaria/boletaAlumnoCurso/' . $query->curso_id . '" class="button button--icon js-button js-ripple-effect" title="Boleta">
                                        <i class="material-icons">assignment_ind</i>
                                        </a>';


                            $btnGruposAlumnos = '<a href="secundaria_curso/grupos_alumno/' . $query->curso_id . '" class="button button--icon js-button js-ripple-effect" title="Grupo Calificaciones">
                                        <i class="material-icons">assignment_turned_in</i>
                                    </a>';

                            $btnBoletaACD = '<a href="reporte/secundaria_boleta_de_calificaciones_acd/' . $query->curso_id . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Boleta ACD" >
                                    <i class="material-icons">picture_as_pdf</i>
                                    </a>';



                            if ($query->ubiClave == "CME") {
                                $btnConstanciaEstudio = '<a href="secundaria_reporte/constancia_estudio/imprimir/' . $query->curso_id . '/sin_foto" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de estudio" >
                                <i class="material-icons">picture_as_pdf</i>
                                </a>';
                            }


                            if ($query->ubiClave == "CVA") {

                                $btnConstanciaEstudio = '<a href="secundaria_reporte/constancia_estudio/imprimir/' . $query->curso_id . '/sin_foto" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de estudio sin foto" >
                                <i class="material-icons">picture_as_pdf</i>
                                </a>';

                                $btnContanciaEstidioConFoto = '<a href="secundaria_reporte/constancia_estudio/imprimir/' . $query->curso_id . '/con_foto" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de estudio con foto" >
                                <i class="material-icons">picture_as_pdf</i>
                                </a>';
                            }



                            $btnCartaConducta = '<a href="secundaria_reporte/carta_conducta/imprimir/' . $query->curso_id . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Carta conducta" >
                            <i class="material-icons">picture_as_pdf</i>
                            </a>';

                            $btnContanciaPromedioFinal = '<a href="secundaria_reporte/constancia_de_promedio_final/imprimir/' . $query->curso_id . '/digital" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de promedio final" >
                            <i class="material-icons">picture_as_pdf</i>
                            </a>';

                            $btnContanciaArtesTaller = '<a href="secundaria_reporte/constancia_de_artes_talleres/imprimir/' . $query->curso_id . '/digital" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de artes y talleres" >
                            <i class="material-icons">picture_as_pdf</i>
                            </a>';

                            $btnContanciaInscripcion = '<a href="secundaria_reporte/constancia_de_inscripcion/imprimir/' . $query->curso_id . '/membretada" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de inscripción" >
                            <i class="material-icons">picture_as_pdf</i>
                            </a>';

                            $btnContanciaEscolaridad = '<a href="secundaria_reporte/constancia_de_escolaridad/imprimir/' . $query->curso_id . '/digital" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de escolaridad" >
                            <i class="material-icons">picture_as_pdf</i>
                            </a>';
                        }

                        if ($query->curEstado == "R" && $query->cgtGradoSemestre != 3) {
                            $btnConstanciaDeCupo = '<a href="secundaria_reporte/constancia_de_cupo/imprimir/' . $query->curso_id . '/membretada" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de cupo membretada" >
                            <i class="material-icons">picture_as_pdf</i>
                            </a>';

                            $btnConstanciaDeCupoDigital = '<a href="secundaria_reporte/constancia_de_cupo/imprimir/' . $query->curso_id . '/digital" target="_blank" class="button button--icon js-button js-ripple-effect" title="Constancia de cupo digital" >
                            <i class="material-icons">picture_as_pdf</i>
                            </a>';
                        }


                        //constancia no adeudo
                        $esDeudor = MetodosAlumnos::esDeudorSecundariaCOVID($query->alumno_id, $query->perAnioPago);
                        if (!$esDeudor) {
                            $btnConstanciaNoAdeudo = '<a href="secundaria_reporte/constancia_no_adeudo/imprimir/' . $query->curso_id . '" target="_blank" id="deudor" class="button button--icon js-button js-ripple-effect" title="Constancia no adeudo" >
                            <i class="material-icons">picture_as_pdf</i>
                            </a>';
                        }
                    } else {


                        $verAlumnoDetalle = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '">
                        <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA VER ALUMNO DETALLE" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" data-alumno-id="' . $query->alumno_id . '" class="modal-trigger btn-modal-alumno-detalle-secundaria button button--icon js-button js-ripple-effect confirm-autorizado" title="Ver Alumno Detalle">
                            <i class="material-icons">face</i>
                        </a>
                        </form>';

                        // ver curso
                        $btnVer = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="/secundaria_curso/' . $query->curso_id . '">
                        <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA VER PREINSCRITO" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Ver">
                            <i class="material-icons">visibility</i>
                        </a>
                        </form>';

                        // historial pagos
                        $btnHistorialPagos = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '">
                        <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA HISTORIAL PAGOS" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" data-nombres="' . $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2 . '" data-aluclave="' . $query->aluClave . '" data-curso-id="' . $query->curso_id . '" class="modal-trigger btn-modal-historial-pagos-secundaria button button--icon js-button js-ripple-effect confirm-autorizado" title="Historial Pagos">
                            <i class="material-icons">attach_money</i>
                        </a>
                        </form>';

                        // observaciones
                        $btnObservaciones = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="/secundaria_curso/observaciones/' . $query->curso_id . '">
                        <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA OBSERVACIONES" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Observaciones">
                            <i class="material-icons">subtitles</i>
                        </a>
                        </form>';

                        $btnGruposAlumnos = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_curso/grupos_alumno/' . $query->curso_id . '">
                        <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA GRUPOS CALIFICACIONES" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Grupos Calificaciones">
                            <i class="material-icons">assignment_turned_in</i>
                        </a>
                        </form>';

                        if ($query->curEstado == "R") {
                            $btnBoleta = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria/boletaAlumnoCurso/' . $query->curso_id . '">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA BOLETA" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Boleta">
                                <i class="material-icons">assignment_ind</i>
                            </a>
                            </form>';

                            $btnBoletaACD = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="reporte/secundaria_boleta_de_calificaciones_acd/' . $query->curso_id . '">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA BOLETA ACD" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Boleta ACD">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';

                            $btnConstanciaEstudio = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_estudio/imprimir/' . $query->curso_id . '">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA CONSTANCIA DE ESTUDIO" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia de estudio">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';

                            $btnContanciaEstidioConFoto = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_estudio/imprimir/' . $query->curso_id . '">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA CONSTANCIA DE ESTUDIO" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia de estudio con foto">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';


                            $btnCartaConducta = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="primaria_reporte/carta_conducta/imprimir/' . $query->curso_id . '">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA CARTA CONDUCTA" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Carta conducta">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';

                            $btnContanciaPromedioFinal = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_de_promedio_final/imprimir/' . $query->curso_id . '/digital">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA CONSTANCIA DE PROMEDIO FINAL" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia de promedio final">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';

                            $btnContanciaArtesTaller = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_de_artes_talleres/imprimir/' . $query->curso_id . '/digital">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA CONSTANCIA DE ARTES Y TALLERES" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia de artes y talleres">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';

                            $btnContanciaInscripcion = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_de_inscripcion/imprimir/' . $query->curso_id . '/membretada">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA DE INSCRIPCION" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia de inscripción">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';

                            $btnContanciaEscolaridad = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_de_escolaridad/imprimir/' . $query->curso_id . '/digital">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA DE ESCOLARIDAD" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia de escolaridad">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';
                        }

                        $esDeudor = MetodosAlumnos::esDeudorSecundariaCOVID($query->alumno_id, $query->perAnioPago);
                        if (!$esDeudor) {

                            $btnConstanciaNoAdeudo = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_no_adeudo/imprimir/' . $query->curso_id . '">
                                <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA CONSTANCIA NO ADEUDO" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia no adeudo">
                                    <i class="material-icons">picture_as_pdf</i>
                                </a>
                            </form>';
                        }

                        if ($query->curEstado == "R" && $query->cgtGradoSemestre != 3) {
                            $btnConstanciaDeCupo = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_de_cupo/imprimir/' . $query->curso_id . '/membretada">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA CONSTANCIA DE CUPO MEMBRETADA" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia de cupo membretada">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';

                            $btnConstanciaDeCupoDigital = '<form style="display: inline-block;" id="autorizado_' . $query->curso_id . '" action="secundaria_reporte/constancia_de_cupo/imprimir/' . $query->curso_id . '/digital">
                            <a href="#" data-alumno_id="' . $query->alumno_id . '" data-persona1="' . $expediente[0] . '" data-persona2="' . $expediente[1] . '" data-curso_id="' . $query->curso_id . '" data-movimiento="SECUNDARIA CONSTANCIA DE CUPO DIGITAL" data-ip="' . $localIP . '" data-usuario_at="' . $user_id . '" data-departamento="' . $query->depClave . '" class="button button--icon js-button js-ripple-effect confirm-autorizado" title="Constancia de cupo digital">
                                <i class="material-icons">picture_as_pdf</i>
                            </a>
                            </form>';
                        }
                    }

                    $btnMostrarAcciones = $verAlumnoDetalle . $btnVer
                        . $btnFichaPagoBBVA
                        . $btnFichaPagoHSBC
                        . $btnHistorialPagos
                        . $btnTarjetaPagoBBVA
                        . $btnTarjetaPagoHSBC
                        . $btnEditar
                        . $btnBajaARegular
                        . $btnCambiarEstado
                        . $btnObservaciones

                        . $btnBoleta . $btnGruposAlumnos
                        . $btnCartaConducta
                        . $btnConstanciaEstudio
                        . $btnContanciaEstidioConFoto
                        . $btnConstanciaNoAdeudo
                        . $btnConstanciaDeCupo
                        . $btnConstanciaDeCupoDigital
                        . $btnContanciaPromedioFinal
                        . $btnContanciaArtesTaller
                        . $btnContanciaInscripcion
                        . $btnContanciaEscolaridad
                        . $btnBoletaACD
                        . $btnEliminarCurso;
                }


                return
                    $btnMostrarAcciones;
            })
            ->make(true);
    }

    public function getDepartamentosListaCompleta(Request $request, $ubicacion_id)
    {
        $departamentos = Departamento::where('ubicacion_id', $ubicacion_id)->get();

        if ($request->ajax())
            return response()->json($departamentos);
    }

    public function observaciones(Request $request)
    {
        $curso = Curso::find($request->curso_id);
        $cursoObservaciones = DB::table("cursos_observaciones")->where("cursos_id", "=", $request->curso_id)->first();

        return view("secundaria.cursos.observaciones", [
            "curso" => $curso,
            "cursoObservaciones" => $cursoObservaciones
        ]);
    }

    public function getMateriasByPlan(Request $request, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Secundaria_materias::where([
                ['plan_id', '=', $plan_id]
            ])->get();

            return response()->json($materias);
        }
    }

    public function getMaterias(Request $request, $semestre, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Secundaria_materias::where([
                ['plan_id', '=', $plan_id],
                ['matSemestre', '=', $semestre]
            ])->get();

            return response()->json($materias);
        }
    }

    public function storeObservaciones(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
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

        $imageName = "";
        if ($request->image) {
            $imageName = $request->curso_id . "-" . time() . '.' . request()->image->getClientOriginalExtension();
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

                if (file_exists(storage_path(env("OBSERVACIONES_PAGO_PATH") . $existeObservacionCurso->curPagoArchivo))) {
                    File::delete(storage_path(env("OBSERVACIONES_PAGO_PATH") . $existeObservacionCurso->curPagoArchivo));
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


            alert('Escuela Modelo', 'Se ha creado con éxito', 'success')->showConfirmButton();
            return redirect()->back()->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
    }

    public function cursoArchivoObservaciones(Request $request)
    {
        $existeObservacionCurso = CursoObservaciones::where("cursos_id", "=", $request->curso_id)->first();

        //return response()->file("app/cursos/observaciones/pagos/".$existeObservacionCurso->curPagoArchivo);
        //return response()->download("app/cursos/observaciones/pagos/".$existeObservacionCurso->curPagoArchivo);
        return response()->download(storage_path(env("OBSERVACIONES_PAGO_PATH") . $existeObservacionCurso->curPagoArchivo));
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

        $pdf = PDF::loadView('secundaria.curso.archivos.pdf_constancia_beca', [
            "curso" => $curso,
            "fechaActual" => $fechaActual->toDateString(),
        ]);

        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream('secundaria.cursos.archivos.pdf_constancia_beca');
        return $pdf->download('secundaria.cursos.archivos.pdf_constancia_beca');
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
        $cursoId = $request->curso_id;
        $estatusBajBajaTotal = "";

        $curso = Curso::with("alumno.persona")->where("id", "=", $cursoId)->first(); //

        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $curso->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion) {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.', 'error')->showConfirmButton();
            return redirect()->back();
        }

        $estadoCursoAntesDeBaja = $curso->curEstado;

        // dd( $curso->id);
        // 1) cargar todos las INSCRITOS grupos - materias de este alumno
        $inscritosObj = Secundaria_inscritos::where("curso_id", "=", $curso->id);
        $inscritos = $inscritosObj->get();

        // 1.5) BORRAR CALIFICACIONES
        $inscritoIds = $inscritos->map(function ($item, $key) {
            return $item->id;
        })->all();
        // $borrarCalificaciones = Secundaria_calificaciones::whereIn("secundaria_inscrito_id", $inscritoIds)->delete();

        // 1.8) borrar todos las INSCRITOS grupos - materias de este alumno
        $inscritosDelete = $inscritosObj->delete();


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
                'bajTipoBeca'          => $curso->curTipoBeca ? $curso->curTipoBeca : "",
                'bajPorcentajeBeca'    => $curso->curPorcentajeBeca,
                'bajObservacionesBeca' => $curso->curObservacionesBeca,
                'bajFechaRegistro'     => $curso->curFechaRegistro,
                'bajFechaBaja'         => $request->fechaBaja,
                'bajEstadoCurso'       => $estadoCursoAntesDeBaja,
                'bajBajaTotal'         => $estatusBajBajaTotal,
                'bajRazonBaja'         => $request->conceptosBaja,
                'bajObservaciones'     => $request->bajObservaciones,
            ]);

            $resultado_array =  DB::select("call procSecundariaAlumnoBajaInscritos(" . $cursoId . ")");

            $envio_notificacion = new NotificacionSecundaria($curso);
            $envio_notificacion->baja_realizada($baja);


            alert('Escuela Modelo', 'Alumno dado de baja con éxito', 'success')->showConfirmButton();
            return back();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();

            return back()->withInput();
        }
    }

    public function altaCurso(Request $request)
    {
        $cursoId = $request->curso_id;
        $inscritosEliminados = $request->inscritosEliminados ? $request->inscritosEliminados : [];

        $bajaCurso = Curso::find($request->curso_id);

        // dd($bajaCurso);

        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $bajaCurso->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion && $bajaCurso->curEstado == "B") {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.', 'error')->showConfirmButton();
            return redirect()->back();
        }

        if (count($inscritosEliminados) > 0) {
            $eliminadosInscritos = Inscrito::onlyTrashed()->whereIn("id", $request->inscritosEliminados)->restore();
            $eliminadosCalif = Calificacion::onlyTrashed()->whereIn("inscrito_id", $request->inscritosEliminados)->restore();
        }

        $bajaCurso->curEstado = $request->curEstado;
        $bajaCurso->curFechaBaja = null;
        $bajaCurso->save();

        $resultado_array =  DB::select("call procSecundariaAlumnoAltaInscritos(" . $cursoId . ")");

        alert('Escuela Modelo', 'Alumno dado de alta con éxito', 'success')->showConfirmButton();
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
                ->whereHas('persona', function ($query) use ($curso) {
                    $query->where("perApellido1", "=", $curso->alumno->persona->perApellido1);
                    $query->where("perApellido2", "=", $curso->alumno->persona->perApellido2);
                })
                ->get();
        }

        return Datatables::of($posiblesHermanos)
            ->addColumn('nombreCompleto', function ($query) {
                return $query->persona->perNombre . " " . $query->persona->perApellido1 . " " . $query->persona->perApellido2;
            })
            ->make(true);
    }

    public function infoBaja(Request $request)
    {
        $cursoId = $request->curso_id;
        $curso = Curso::with("alumno.persona", "periodo", "cgt.plan.programa")->where("id", $cursoId)->first();

        $inscritos = Inscrito::with("curso")->where("curso_id", "=", $curso->id)
            ->whereHas('curso', function ($query) {
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
        $modulo = Modules::where('slug', 'curso')->first();
        $permisos = Permission_module_user::where('user_id', $user->id)->where('module_id', $modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;

        // Mostrar solo Mérida y valladolid
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $tiposIngreso =  [
            'PI' => 'PRIMER INGRESO',
            // 'RO' => 'REPETIDOR',
            'RI' => 'REINSCRIPCIÓN',
            'RE' => 'REINGRESO'
            // 'EQ' => 'REVALIDACIÓN',
            // 'OY' => 'OYENTE',
            // 'XX' => 'OTRO',
        ];

        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $opcionTitulo = SI_NO;
        $tiposBeca = Beca::get();
        $alumno = null;



        return view('secundaria.cursos.create', compact('ubicaciones', 'planesPago', 'tiposIngreso', 'tiposBeca', 'estadoCurso', 'permiso', 'alumno'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'alumno_id' => 'required|unique:cursos,alumno_id,NULL,id,periodo_id,' . $request->input('periodo_id') . ',deleted_at,NULL',
                'cgt_id'    => 'required',
                'image' => 'mimes:jpeg,jpg,png,pdf|file|max:10000',

            ],
            [
                'alumno_id.unique' => "El alumno ya existe en el curso",
                'image.mimes' => "El archivo solo puede ser de tipo jpeg, jpg, png y pdf",
                'image.max'   => "El archivo no debe de pesar más de 10 Megas"
            ]
        );


        $cgt = CGT::where("id", "=", $request->cgt_id)->first();
        $curso_anterior = $request->curso_id ? Curso::find($request->curso_id) : null;

        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $request->periodo_id)->where("fecha2", "=", 1)->first();
        if ($existeRestriccion) {
            alert('Escuela Modelo', 'Por el momento, el módulo se encuentra deshabilitado para este período.', 'error')->showConfirmButton();
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
            return redirect('secundaria_curso/create')->withInput();
        }

        if ($validator->fails()) {
            return redirect('secundaria_curso/create')->withErrors($validator)->withInput();
        }

        $plan = Plan::with('programa')->findOrFail($request->plan_id);
        $programa = $plan->programa;
        if (Utils::validaPermiso('curso', $programa->id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->to('secundaria_curso/create');
        }


        // obtener el programa = "SEC"
        $laclavedelprograma = $programa->progClave;

        $alumno = Alumno::where("id", "=", $request->alumno_id)->first();
        if ($alumno && $alumno->aluEstado == "E") {
            Alumno::where("id", "=", $request->alumno_id)->update(["aluEstado" => "R"]);
        }

        $eliddelalumno = $request->alumno_id;
        $alumnoAluEstado = $alumno->aluEstado;


        $imageName = "";
        //si viene de la vista candidatos
        if ($request->es_candidato_tiene_foto) {
            $imageName =  $alumno->candidato->perCurp . "-" . $alumno->candidato->perFoto;
            $path = File::copy(
                storage_path(env("SECUNDARIA_IMAGEN_CURSO_PATH") . $alumno->candidato->perFoto),
                storage_path(env("SECUNDARIA_IMAGEN_CURSO_PATH") . $imageName)
            );
        }


        if ($ubicacion->id == 1) {
            $campus = "CampusCME";
        }

        if ($ubicacion->id == 2) {
            $campus = "CampusCVA";
        }

        //si no viene de la vista candidatos
        if (!$request->es_candidato_tiene_foto) {
            if ($request->curSecundariaFoto) {
                $imageName = $alumno->aluClave . "-" . time() . '.' . request()->curSecundariaFoto->getClientOriginalExtension();
                $path = $request->curSecundariaFoto->move(
                    storage_path(env("SECUNDARIA_IMAGEN_CURSO_PATH") . "app/public/secundaria/cursos/fotos/" . $periodo->perAnioPago . "/" . $campus),
                    $imageName
                );
            }
        }

        //-----------------------
        //REVISAMOS SI HABIA PAGADO LA INSCRIPCION POR CAMBIO DE CARRERA
        $esMismoPlan = $curso_anterior ? ($curso_anterior->cgt->plan->id === $request->plan_id) : false;
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
        $curTipoBeca  = $request->curTipoBeca;
        $curPorcentajeBeca = $request->curPorcentajeBeca;
        $curObservacionesBeca = $request->curObservacionesBeca;
        $curImporteInscripcion = $request->curImporteInscripcion;
        $curImporteMensualidad = $request->curImporteMensualidad;
        $curImporteVencimiento = $request->curImporteVencimiento;
        $curImporteDescuento = $request->curImporteDescuento;
        $curDiasProntoPago = $request->curDiasProntoPago;
        $curAnioCuotas = $request->curAnioCuotas;
        $curPlanPago = $curso_anterior ? $curso_anterior->curPlanPago : "N";

        if ($periodo->iniciaEnAgosto()) {
            $curPlanPago = "N";
            if ($ubicacion->ubiClave == 'CCH')
                $curPlanPago = $programa->progClave == 'CDX' ? 'N' : 'O';
            if ($ubicacion->ubiClave == 'CVA')
                $curPlanPago = 'O';
        }


        if ($curso_anterior) {
            if ($curso_anterior->curTipoBeca) {
                $beca = Beca::where('bcaClave', $curso_anterior->curTipoBeca)->first();
                if ($beca && $beca->bcaVigencia == 'S') $esBecaSemestral = true;
            }
            if (!$periodo->iniciaEnAgosto()) {
                $curTipoBeca = $esBecaSemestral ? null : $curso_anterior->curTipoBeca;
                $curPorcentajeBeca = $esBecaSemestral ? null : $curso_anterior->curPorcentajeBeca;
                $curObservacionesBeca = $esBecaSemestral ? "Tuvo beca semestral {$curso_anterior->curTipoBeca}{$curso_anterior->curPorcentajeBeca}" : $curso_anterior->curObservacionesBeca;
                $curImporteInscripcion = null;
                $curImporteMensualidad = null;
                $curImporteVencimiento = null;
                $curImporteDescuento = null;
                $curDiasProntoPago = null;
            }

            if (!$esMismoPlan) $curAnioCuotas = null;
        }

        //-----------------------
        // validamos antes de guardar el curso si los datos de historia clinica estan actualizados
        $secundaria_alumnos_historia_clinica = Secundaria_alumnos_historia_clinica::where('alumno_id', $request->alumno_id)->first();

        if ($secundaria_alumnos_historia_clinica == "") {
            $resultado_array =  DB::select("call procPrimerCursoIngreso(" . $request->alumno_id . ")");
            $resultado_collection = collect($resultado_array);

            if ($resultado_collection->isEmpty()) {

                //CHECAR SI ES UN NUEVO ALUMNO DE SECUNDARIA
                if ($laclavedelprograma == "SEC") {
                    $historia = Secundaria_alumnos_historia_clinica::where('alumno_id', '=', $eliddelalumno)->first();

                    if ($historia === null) {
                        $historia_id = Secundaria_alumnos_historia_clinica::create([
                            'alumno_id' => $eliddelalumno,
                            'estatus_edicion' => 1
                        ]);

                        Secundaria_alumnos_historia_clinica_familiares::create([
                            'historia_id' => $historia_id->id,
                            'municipioMadre_id' => 0,
                            'municipioPadre_id' => 0
                        ]);

                        Secundaria_alumnos_historia_clinica_actividades::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_conducta::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_desarrollo::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_habitos::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_heredo::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_medica::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_nacimiento::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_sociales::create([
                            'historia_id' => $historia_id->id
                        ]);
                    }
                }
            } else {
                //CHECAR SI ES UN NUEVO ALUMNO DE SECUNDARIA
                if ($laclavedelprograma == "SEC") {
                    $historia = Secundaria_alumnos_historia_clinica::where('alumno_id', '=', $eliddelalumno)->first();

                    if ($historia === null) {
                        $historia_id = Secundaria_alumnos_historia_clinica::create([
                            'alumno_id' => $eliddelalumno,
                            'estatus_edicion' => 1
                        ]);

                        Secundaria_alumnos_historia_clinica_familiares::create([
                            'historia_id' => $historia_id->id,
                            'municipioMadre_id' => 0,
                            'municipioPadre_id' => 0
                        ]);

                        Secundaria_alumnos_historia_clinica_actividades::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_conducta::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_desarrollo::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_habitos::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_heredo::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_medica::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_nacimiento::create([
                            'historia_id' => $historia_id->id
                        ]);

                        Secundaria_alumnos_historia_clinica_sociales::create([
                            'historia_id' => $historia_id->id
                        ]);
                    }
                }
            }
        } else {
            if ($secundaria_alumnos_historia_clinica->estatus_edicion == 0) {
                alert('Upss', 'No se puede realizar el registro, debido que aun no sea actualizado los datos del expediente del alumno', 'warning')->showConfirmButton()->autoClose('6000');
                return redirect('secundaria_curso/create')->withInput();
            }
        }


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
                'curSecundariaFoto'      => $imageName,
            ]);

            if($curso_anterior && MetodosCursos::hayCambioDeBeca($laNuevaPreinscripcion, $curso_anterior)) {
                $beca_historial = MetodosCursos::crearHistorialDeBeca($laNuevaPreinscripcion);
            }

            //VERIFICAR SI TIENE MAS DE UN CURSO EN DIFERENTES PERIODOS
            // Y SI ALUESTADO ESTA EN N
            if ($alumnoAluEstado == "N") {
                $resultado = DB::select('call procCursosAlumnosN(' . $eliddelalumno . ')');
                if ($resultado) {
                    if (count($resultado) > 1) {
                        Alumno::where("id", "=", $eliddelalumno)->update(["aluEstado" => "R"]);
                    }
                }
            }

            $obtenerCursoNuevo = Curso::find($laNuevaPreinscripcion->id);

            $alum = Alumno::find($request->alumno_id);

            $obtenerCursoNuevo->update([
                'curSecundariaFoto' => $alum->aluClave . '.jpg'
            ]);





            alert('Escuela Modelo', 'El curso se ha creado con éxito', 'success')->showConfirmButton();
            return redirect()->route('secundaria.secundaria_curso.index');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('secundaria_curso/create')->withInput();
        }
    }

    // INSCRIPCION POR PAQUETES, GRUPO, POR MATERIA, EDIT DE INSCRITOS
    public function getCursos(Request $request, $cgt_id)
    {
        if ($request->ajax()) {
            $cursos = Curso::with('alumno.persona')->where('cgt_id', $cgt_id)->whereIn("curEstado", ["R", "C", "A", "P"])->get();
            return response()->json($cursos);
        }
    }

    /**
     * Show alumno curso.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCursoAlumno(Request $request, $aluClave, $cuoAnio)
    {
        if ($request->ajax()) {
            $curso = Curso::with('alumno.persona', 'cgt.plan.programa', 'cgt.periodo.departamento.ubicacion')
                ->whereHas('cgt.periodo', function ($query) use ($cuoAnio) {
                    $query->where('perAnioPago', $cuoAnio)->orderBy('perNumero', 'desc');
                })
                ->whereHas('alumno', function ($query) use ($aluClave) {
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
        $curso = Curso::with('alumno.persona', 'cgt')->findOrFail($id);
        $tiposIngreso = TIPOS_INGRESO_PREES_PRI_SEC;
        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $tiposBeca = Beca::get();
        $opcionTitulo = SI_NO;
        $periodo = Periodo::findOrFail($curso->periodo_id);

        $ubicacion = $periodo->departamento->ubicacion->id;

        if ($ubicacion == 1) {
            $campus = "CampusCME";
        }

        if ($ubicacion == 2) {
            $campus = "CampusCVA";
        }

        // fechas de la tabla cursos
        $fecha_creacion = $curso->created_at;
        $fecha_update = $curso->updated_at;
        $lafechabuena = "";
        $quemostrar = "";

        if ($fecha_creacion < $fecha_update) {
            $lafechabuena = $fecha_update;
            $quemostrar = "Fecha de actulización";
        } else {
            $lafechabuena = $fecha_creacion;
            $quemostrar = "Fecha de creación";
        }

        $usuario_at = User::with('empleado.persona')->where('id', $curso->usuario_at)->first();


        return view('secundaria.cursos.show', compact(
            'curso',
            'tiposIngreso',
            'planesPago',
            'estadoCurso',
            'tiposBeca',
            'opcionTitulo',
            'periodo',
            'usuario_at',
            'lafechabuena',
            'quemostrar',
            'campus'
        ));
    }

    public function listHistorialPagos(Request $request)
    {

        $curso = Curso::find($request->curso_id)->load(['periodo', 'alumno']);

        $pagos = Pago::with('concepto')->where('pagClaveAlu', $curso->alumno->aluClave)
            ->where('pagAnioPer', $curso->periodo->perAnioPago)
            ->where('pagEstado', 'A')
            ->whereIn('pagConcPago', ["99", "01", "02", "03", "04", "05", "00", "06", "07", "08", "09", "10", "11", "12"])
            ->get()
            ->sortByDesc(static function ($pago, $key) {
                return $pago->pagAnioPer . '-' . $pago->concepto->ordenReportes;
            });

        return Datatables::of($pagos)
            ->addColumn('pagImpPago', static function (Pago $pago) {
                return '$' . $pago->pagImpPago;
            })
            ->addColumn('pagFechaPago', static function (Pago $pago) {
                return Utils::fecha_string($pago->pagFechaPago, 'mesCorto');
            })->toJson();
    } //listHistorialPagos.

    public function listPreinscritoDetalle(Request $request)
    {
        $cursoId = $request->curso_id;
        $curso = Curso::with('alumno.persona', 'cgt.plan.programa.escuela.departamento.ubicacion', 'cgt.periodo')->findOrFail($cursoId);
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
            "curTipoBeca"     => $curTipoBeca ? $curTipoBeca->bcaNombre : "",
        ]);
    }

    public function historialCalificacionesAlumno(Request $request)
    {
        $curso = Curso::where("id", "=", $request->curso_id)->first();

        return view("secundaria.cursos.historialCalificacionesAlumno", [
            "curso" => $curso
        ]);
    }

    public function listHistorialCalifAlumnos(Request $request)
    {
        $curso = Curso::where("id", "=", $request->curso_id)->first();

        $calificaciones = Calificacion::select(
            "cursos.id as cursoId",
            "periodos.perNumero",
            "periodos.perAnio",
            "planes.planClave",
            "programas.progClave",
            "materias.matClave",
            "materias.matNombre",
            "calificaciones.inscCalificacionParcial1",
            "calificaciones.inscCalificacionParcial2",
            "calificaciones.inscCalificacionParcial3",
            "calificaciones.inscPromedioParciales",
            "calificaciones.inscCalificacionOrdinario",
            "calificaciones.incsCalificacionFinal"
        )
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

        return view("secundaria.alumnos.materiasFaltantes", [
            "curso" => $curso
        ]);
    }

    public function listMateriasFaltantes(Request $request)
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
        $curso = Curso::with('alumno.persona', 'cgt', 'periodo')->findOrFail($id);
        $cgts = Cgt::where([
            ['plan_id', $curso->cgt->plan_id],
            ['periodo_id', $curso->cgt->periodo_id],
            ['cgtGradoSemestre', $curso->cgt->cgtGradoSemestre]
        ])->get();

        $perActual =  DB::select("select perAnioPago FROM periodos where periodos.id IN (SELECT perActual FROM departamentos WHERE depClave IN ('SEC'))");
        $perSelec =  DB::select("select perAnioPago FROM periodos where periodos.id = " . $curso->periodo_id);

        $perAnioPagoCursoSeleccionado = (int) $perSelec[0]->perAnioPago;
        $perAnioPagoActual = (int) $perActual[0]->perAnioPago;
        //dd($perActual, $perSelec, $curso->periodo_id, $perAnioPagoActual, $perAnioPagoCursoSeleccionado);
        if ($perAnioPagoCursoSeleccionado < $perAnioPagoActual) {
            alert()->error('Cancelado', 'No puede editar la inscripción de un alumno(a) de un ciclo escolar que ya ha terminado.')->showConfirmButton()->autoClose(5000);
            return redirect()->route('secundaria.secundaria_curso.index');
        }


        //OBTENER PERMISO DE USUARIO
        $user = Auth::user();
        $modulo = Modules::where('slug', 'curso')->first();
        $permisos = Permission_module_user::where('user_id', $user->id)->where('module_id', $modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;
        $tiposIngreso = TIPOS_INGRESO_PREES_PRI_SEC;
        $planesPago = PLANES_PAGO;
        $estadoCurso = ESTADO_CURSO;
        $opcionTitulo = SI_NO;
        $tiposBeca = Beca::get();


        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('curso', $curso->cgt->plan->programa_id, "editar")) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);

            return redirect()->route('secundaria.secundaria_curso.index');
        } else {
            return view('secundaria.cursos.edit', compact('curso', 'cgts', 'tiposIngreso', 'planesPago', 'tiposBeca', 'estadoCurso', 'opcionTitulo', 'permiso'));
        }
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

        $user = Auth::user();

        $modulo = Modules::where('slug', 'curso')->first();
        $permisos = Permission_module_user::where('user_id', $user->id)->where('module_id', $modulo->id)->first();
        $permiso = Permission::find($permisos->permission_id)->name;

        // dd($request->curTipoIngreso);
        try {
            $curso = Curso::with('alumno.persona', 'cgt')->findOrFail($id);
            $periodo = Periodo::findOrFail($curso->periodo_id);
            $curso_anterior = clone $curso; # Clon para luego revisar si cambió.

            $ubicacion = $periodo->departamento->ubicacion->id;

            if ($ubicacion == 1) {
                $campus = "CampusCME";
            }

            if ($ubicacion == 2) {
                $campus = "CampusCVA";
            }


            $imageName = "";
            if ($request->curSecundariaFoto) {
                //$imageName = time().'.'.request()->curSecundariaFoto->getClientOriginalExtension();
                //$path = $request->curSecundariaFoto->move(storage_path("/app/public/cursos/exani"), $imageName);
                $imageName = $curso->alumno->aluClave . "-" . time() . '.' . request()->curSecundariaFoto->getClientOriginalExtension();
                $path = $request->curSecundariaFoto->move(
                    storage_path(env("SECUNDARIA_IMAGEN_CURSO_PATH") . $periodo->perAnioPago . "/" . $campus),
                    $imageName
                );
            }

            if (User::permiso("curso") != "P") {
                $curso->cgt_id                  = $request->cgt_id;
                if ($permiso == "A" || $permiso == "B") {
                    $curso->curEstado               = $request->curEstado;
                }
                $curso->curTipoIngreso          = $request->curTipoIngreso;
                $curso->curOpcionTitulo         = $request->curOpcionTitulo;
                $curso->curExani                = $request->curExani;
                if ($request->curSecundariaFoto) {
                    $curso->curSecundariaFoto = $imageName;
                }
            }




            if (User::permiso("curso") == "A" || User::permiso("curso") == "E" || User::permiso("curso") == "P") {
                $curso->curAnioCuotas           = Utils::validaEmpty($request->curAnioCuotas);
                $curso->curImporteInscripcion   = Utils::validaEmpty($request->curImporteInscripcion);
                $curso->curImporteMensualidad   = Utils::validaEmpty($request->curImporteMensualidad);
                $curso->curImporteVencimiento   = Utils::validaEmpty($request->curImporteVencimiento);
                $curso->curImporteDescuento     = Utils::validaEmpty($request->curImporteDescuento);
                $curso->curDiasProntoPago       = Utils::validaEmpty($request->curDiasProntoPago);
                $curso->curPlanPago             = $request->curPlanPago;
                $curso->curTipoBeca             = $request->curTipoBeca;
                $curso->curPorcentajeBeca       = Utils::validaEmpty($request->curPorcentajeBeca);
                $curso->curObservacionesBeca    = $request->curObservacionesBeca;
            }


            $curso->save();

            if($curso_anterior && MetodosCursos::hayCambioDeBeca($curso, $curso_anterior)) {
                $beca_historial = MetodosCursos::crearHistorialDeBeca($curso);
            }

            // $userId = Auth::id();
            // $resultUpdate =  DB::select("call procInscritosExaniPago99PorCurso("
            //     .$userId
            //     .",".$id
            //     .",'CME"
            //     ."','SUP"
            //     ."','I"
            //     ."')");

            alert('Escuela Modelo', 'El curso se ha actualizado con éxito', 'success')->showConfirmButton();
            return redirect()->route('secundaria.secundaria_curso.index');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('secundaria_curso/' . $id . '/edit')->withInput();
        }
    }

    /* -------------------------------------------------------------------------- */
    /*          retorna la vista de los grupos donde el alumno pertenece          */
    /* -------------------------------------------------------------------------- */
    public function viewCalificaciones($id)
    {


        $curso = Curso::select(
            'cursos.*',
            'alumnos.aluClave',
            'personas.id as persona_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre'
        )
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('cursos.id', '=', $id)->first();

        if (empty($curso)) {
            alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
            return back();
        }

        return view('secundaria.cursos.show-grupo-calificaciones', [
            'curso' => $curso
        ]);
    }

    public function listGruposAlumno($aluClave)
    {

        $grupos = Secundaria_inscritos::select(
            'secundaria_inscritos.id',
            'cursos.id as curso_id',
            'secundaria_grupos.id as grupo_id',
            'secundaria_grupos.gpoGrado',
            'secundaria_grupos.gpoClave',
            'secundaria_grupos.gpoTurno',
            'secundaria_materias.id as materia_id',
            'secundaria_materias.matClave',
            'secundaria_materias.matNombre',
            'secundaria_materias.matNombreCorto',
            'planes.id as plan_id',
            'planes.planClave',
            'planes.planPeriodos',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'periodos.perEstado',
            'departamentos.id as departamento_id',
            'departamentos.depNivel',
            'departamentos.depClave',
            'departamentos.depNombre',
            'departamentos.depNombreCorto',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'ubicacion.ubiCalle',
            'secundaria_empleados.id as empleado_id',
            'secundaria_empleados.empApellido1',
            'secundaria_empleados.empApellido2',
            'secundaria_empleados.empNombre',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'programas.progNombreCorto',
            'alumnos.id as alumno',
            'alumnos.aluClave',
            'p.perNombre as nombreAlumno',
            'p.perApellido1 as apellidoAlumno1',
            'p.perApellido2 as apellidoAlumno2'
        )
            ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
            ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->join('planes', 'secundaria_grupos.plan_id', '=', 'planes.id')
            ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->leftJoin('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('secundaria_empleados', 'secundaria_grupos.empleado_id_docente', '=', 'secundaria_empleados.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas as p', 'alumnos.persona_id', '=', 'p.id')
            ->where('alumnos.aluClave', '=', $aluClave)
            ->orderBy('periodos.perAnio', 'desc');






        $acciones = '';
        return Datatables::of($grupos)

            ->filterColumn('clavepago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clavepago', function ($query) {
                return $query->aluClave;
            })

            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiNombre;
            })

            ->filterColumn('nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre', function ($query) {
                return $query->empNombre;
            })
            ->filterColumn('apellido1', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido1', function ($query) {
                return $query->empApellido1;
            })
            ->filterColumn('apellido2', function ($query, $keyword) {
                $query->whereRaw("CONCAT(empApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido2', function ($query) {
                return $query->empApellido2;
            })

            ->filterColumn('peraniopago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('peraniopago', function ($query) {
                return $query->perAnioPago;
            })

            ->filterColumn('planclave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('planclave', function ($query) {
                return $query->planClave;
            })

            ->filterColumn('programa', function ($query, $keyword) {
                $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('programa', function ($query) {
                return $query->progNombre;
            })

            ->filterColumn('clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave', function ($query) {
                return $query->matClave;
            })

            ->filterColumn('matName', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('matName', function ($query) {
                return $query->matNombre;
            })
            ->addColumn('action', function ($grupos) {
                $acciones = '<div class="row">


                    <a href="ajustar_calificacion/' . $grupos->grupo_id . '/' . $grupos->aluClave . '/' . $grupos->curso_id . '" class="button button--icon js-button js-ripple-effect" title="Ajustar calificación">
                    <i class="material-icons">edit</i>
                    </a>


                    </div>';
                return $acciones;
            })
            ->make(true);
    }

    public function ajustar_calificacion($grupo_id, $aluClave, $curso_id)
    {

        $calificaciones = Secundaria_calificaciones::select(
            'secundaria_calificaciones.id',
            'secundaria_calificaciones.secundaria_inscrito_id',
            'secundaria_calificaciones.numero_evaluacion',
            'secundaria_calificaciones.mes_evaluacion',
            'secundaria_calificaciones.calificacion_evidencia1',
            'secundaria_calificaciones.calificacion_evidencia2',
            'secundaria_calificaciones.calificacion_evidencia3',
            'secundaria_calificaciones.calificacion_evidencia4',
            'secundaria_calificaciones.calificacion_evidencia5',
            'secundaria_calificaciones.calificacion_evidencia6',
            'secundaria_calificaciones.calificacion_evidencia7',
            'secundaria_calificaciones.calificacion_evidencia8',
            'secundaria_calificaciones.calificacion_evidencia9',
            'secundaria_calificaciones.calificacion_evidencia10',
            'secundaria_calificaciones.promedio_mes',
            'secundaria_inscritos.grupo_id',
            'secundaria_grupos.gpoGrado',
            'secundaria_grupos.gpoClave',
            'secundaria_materias.id as id_materia',
            'secundaria_materias.matClave',
            'secundaria_materias.matNombre',
            'planes.id as id_plan',
            'planes.planClave',
            'periodos.id as periodo_id',
            'periodos.perAnio',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'departamentos.depClave',
            'departamentos.depNombre',
            'alumnos.id as alumno_id',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'alumnos.id as alumno_id',
            'secundaria_mes_evaluaciones.id as mes_id',
            'secundaria_mes_evaluaciones.mes'
        )
            ->join('secundaria_inscritos', 'secundaria_calificaciones.secundaria_inscrito_id', '=', 'secundaria_inscritos.id')
            ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
            ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->join('planes', 'secundaria_grupos.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('secundaria_mes_evaluaciones', 'secundaria_calificaciones.numero_evaluacion', '=', 'secundaria_mes_evaluaciones.id')
            ->where('secundaria_inscritos.grupo_id', '=', $grupo_id)
            ->where('alumnos.aluClave', '=', $aluClave)
            ->first();

        if (empty($calificaciones)) {
            alert()->warning('Sin coincidencias', 'No hay datos para mostrar.')->showConfirmButton();
            return back();
        }

        return view('secundaria.cursos.ajustar-calificacion', [
            'calificaciones' => $calificaciones,
            'curso_id' => $curso_id
        ]);
    }

    public function getCalificacionUnicoAlumno(Request $request, $id, $grupoId, $aluClave)
    {
        if ($request->ajax()) {


            $calificaciones = Secundaria_calificaciones::select(
                'secundaria_calificaciones.id',
                'secundaria_calificaciones.secundaria_inscrito_id',
                'secundaria_calificaciones.secundaria_grupo_evidencia_id',
                'secundaria_calificaciones.numero_evaluacion',
                'secundaria_calificaciones.mes_evaluacion',
                'secundaria_calificaciones.calificacion_evidencia1',
                'secundaria_calificaciones.calificacion_evidencia2',
                'secundaria_calificaciones.calificacion_evidencia3',
                'secundaria_calificaciones.calificacion_evidencia4',
                'secundaria_calificaciones.calificacion_evidencia5',
                'secundaria_calificaciones.calificacion_evidencia6',
                'secundaria_calificaciones.calificacion_evidencia7',
                'secundaria_calificaciones.calificacion_evidencia8',
                'secundaria_calificaciones.calificacion_evidencia9',
                'secundaria_calificaciones.calificacion_evidencia10',
                'secundaria_calificaciones.promedio_mes',
                'secundaria_inscritos.grupo_id',
                'secundaria_grupos.gpoGrado',
                'secundaria_grupos.gpoClave',
                'secundaria_materias.id as id_materia',
                'secundaria_materias.matClave',
                'secundaria_materias.matNombre',
                'planes.id as id_plan',
                'planes.planClave',
                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.depClave',
                'departamentos.depNombre',
                'personas.perNombre',
                'personas.perApellido1',
                'personas.perApellido2',
                'programas.id as programa_id',
                'programas.progClave',
                'programas.progNombre',
                'alumnos.aluClave'
            )
                ->join('secundaria_inscritos', 'secundaria_calificaciones.secundaria_inscrito_id', '=', 'secundaria_inscritos.id')
                ->join('secundaria_grupos', 'secundaria_inscritos.grupo_id', '=', 'secundaria_grupos.id')
                ->join('secundaria_materias', 'secundaria_grupos.secundaria_materia_id', '=', 'secundaria_materias.id')
                ->join('planes', 'secundaria_grupos.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('periodos', 'secundaria_grupos.periodo_id', '=', 'periodos.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('cursos', 'secundaria_inscritos.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->where('secundaria_calificaciones.secundaria_grupo_evidencia_id', '=', $id)
                ->where('secundaria_inscritos.grupo_id', '=', $grupoId)
                ->where('alumnos.aluClave', '=', $aluClave)

                ->get();

            return response()->json($calificaciones);
        }
    }

    public function ajustar_calificacion_update(Request $request)
    {
        $id = $request->id;
        $secundaria_inscrito_id = $request->secundaria_inscrito_id;
        $secundaria_grupo_evidencia_id = $request->secundaria_grupo_evidencia_id;
        $evidencia1 = $request->evidencia1;
        $evidencia2 = $request->evidencia2;
        $evidencia3 = $request->evidencia3;
        $evidencia4 = $request->evidencia4;
        $evidencia5 = $request->evidencia5;
        $evidencia6 = $request->evidencia6;
        $evidencia7 = $request->evidencia7;
        $evidencia8 = $request->evidencia8;
        $evidencia9 = $request->evidencia9;
        $evidencia10 = $request->evidencia10;
        $promedioTotal = $request->promedioTotal;
        $numero_evaluacion = $request->numero_evaluacion;
        $mes_evaluacion = $request->mes;

        DB::table('secundaria_calificaciones')
            ->where('id', $id)
            ->update([

                'secundaria_inscrito_id' => $secundaria_inscrito_id,
                'secundaria_grupo_evidencia_id' => $secundaria_grupo_evidencia_id,
                'numero_evaluacion' => $numero_evaluacion,
                'mes_evaluacion' => $mes_evaluacion,
                'calificacion_evidencia1' => $evidencia1,
                'calificacion_evidencia2' => $evidencia2,
                'calificacion_evidencia3' => $evidencia3,
                'calificacion_evidencia4' => $evidencia4,
                'calificacion_evidencia5' => $evidencia5,
                'calificacion_evidencia6' => $evidencia6,
                'calificacion_evidencia7' => $evidencia7,
                'calificacion_evidencia8' => $evidencia8,
                'calificacion_evidencia9' => $evidencia9,
                'calificacion_evidencia10' => $evidencia10,
                'promedio_mes' => $promedioTotal

            ]);

        alert('Escuela Modelo', 'Las calificaciones se actualizarón con éxito', 'success')->showConfirmButton()->autoClose(5000);;
        return back();
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

        if ($curso->inscritos->isNotEmpty()) {
            alert('Ups!...', 'El alumno tiene materias cargadas, no puede borrar este registro. Favor de contactar al administrador del sistema.', 'warning')->showConfirmButton();
            return redirect('secundaria_curso')->withInput();
        }

        try {
            if (Utils::validaPermiso('curso', $curso->cgt->plan->programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);

                return redirect('secundaria_curso')->withInput();
            }
            if ($curso->delete()) {
                alert('Escuela Modelo', 'El curso se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el curso')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect('secundaria_curso')->withInput();
    }

    /**
     * Show the application reference.
     *
     * @return \Illuminate\Http\Response
     */
    public function referencia()
    {
        return view('secundaria.alumnos.referencia');
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

        $curso = Curso::with('cgt.periodo', 'cgt.plan.programa.escuela.departamento.ubicacion', 'alumno.persona')->find($curso_id);
        $clave_pago = $curso->alumno->aluClave;

        $programa_id = $curso->cgt->plan->programa->id;
        $escuela_id = $curso->cgt->plan->programa->escuela->id;
        $departamento_id = $curso->cgt->plan->programa->escuela->departamento->id;
        $perNumero = $curso->cgt->periodo->perNumero;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $cuoConcepto = "99";

        $alumno_ingreso = $curso->alumno->aluEstado;
        $alumno_cgtGrado = $curso->cgt->cgtGradoSemestre;

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        if ($departamento_clave == "SEC") {
            $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
            $diasLimite = 15;
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
            ['cuoTipo', 'P'],
            ['dep_esc_prog_id', $programa_id],
            ['cuoAnio', $perAnioPago]
        ])->first();
        //2.- Escuela
        if (!$cuota) {
            $cuota = Cuota::where([
                ['cuoTipo', 'E'],
                ['dep_esc_prog_id', $escuela_id],
                ['cuoAnio', $perAnioPago]
            ])->first();
            //3.- Departamento
            if (!$cuota) {
                $cuota = Cuota::where([
                    ['cuoTipo', 'D'],
                    ['dep_esc_prog_id', $departamento_id],
                    ['cuoAnio', $perAnioPago]
                ])->first();
            }
        }
        if ($cuota) {

            $cuoAnio = $cuota->cuoAnio;
            $cuota_descuento = CuotaDescuento::where('cuota_id', $cuota->id)->first();
            if ($cuota_descuento) {
                //2022: solo 1er año ó si son primer ingreso (clave de pago nueva)
                if ($alumno_ingreso == "N") {
                    $cuota = $cuota_descuento;
                } else {
                    if ($alumno_cgtGrado == 1) {
                        $cuota = $cuota_descuento;
                    }
                }
            }


            $cuoConcepto = ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "SEC") {
                $cuoImporteInscripcion1 = (float)$cuota->cuoImporteInscripcion1 + (float)$cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (float)$cuota->cuoImporteInscripcion2 + (float)$cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (float)$cuota->cuoImporteInscripcion3 + (float)$cuota->cuoImportePadresFamilia;
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
                    $cuoImporteInscripcion1 = (float)$curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion2 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 = (float)$curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion3 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 = (float)$curso->curImporteInscripcion - 500;
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
            $importe1 = null;
            $importe2 = null;
            $importe3 = null;

            if ($cuoFechaLimiteInscripcion1 != null) {
                $fechaLimite1 = ($cuoFechaLimiteInscripcion1);
                $referencia1 = $generarReferencia->crear($concepto, $cuoFechaLimiteInscripcion1, $cuoImporteInscripcion1);
                $importe1 = Utils::convertMoney($cuoImporteInscripcion1);
            }

            if ($cuoFechaLimiteInscripcion2 != null) {
                $fechaLimite2 = ($cuoFechaLimiteInscripcion2);
                $referencia2 = $generarReferencia->crear($concepto, $cuoFechaLimiteInscripcion2, $cuoImporteInscripcion2);

                $importe2 = Utils::convertMoney($cuoImporteInscripcion2);
            }

            if ($cuoFechaLimiteInscripcion3 != null) {
                $fechaLimite3 = ($cuoFechaLimiteInscripcion3);
                $referencia3 = $generarReferencia->crear($concepto, $cuoFechaLimiteInscripcion3, $cuoImporteInscripcion3);
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
            if (!$tieneDescuento) {
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
            if (!$tieneDescuento) {
                if ($cuoFechaLimiteInscripcion1 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite1);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha1";
                    }
                } else {
                    //POR ALGUNA RAZON , NO HAY CAPTURADO FECHALIMITE1
                    $tieneDescuento = false;
                }
            }

            $ficha['tieneDescuento'] = $tieneDescuento;

            //dd($tieneDescuento,$cualFechaDescuento);

            $ficha['fechaLimite15Dias'] = Carbon::parse($fechaLimite15Dias)->day
                . '/' . ucfirst(Carbon::parse($fechaLimite15Dias)->formatLocalized('%b'))
                . '/' . Carbon::parse($fechaLimite15Dias)->year;
            $ficha['fechaLimite15DiasDB'] = $fechaLimite15Dias;

            // dd($fechaLimite15Dias,$fechaLimite2);
            //dd($cuoFechaLimiteInscripcion1, $fechaLimite15Dias);


            //INFORMACIÓN PARA GENERAR FICHA
            $ficha['clave_pago'] = $clave_pago;
            $ficha['curso'] = $curso;
            $ficha['nombreAlumno'] = $curso->alumno->persona->perApellido1 . ' ' . $curso->alumno->persona->perApellido2 . ' ' . $curso->alumno->persona->perNombre;
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
            if ($tieneDescuento) {
                if ($cualFechaDescuento == "fecha3") {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    //dd($diferencia,$diferencia->invert);

                    if ($diferencia->invert)  //HAY DIAS ANTES DEL LIMITE
                    {
                        if ($diferencia->format('%a') < $diasLimite) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2)) {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);

                                $referencia2 = $generarReferencia->crear($concepto, $fechaReferencia, $cuoImporteInscripcion2);
                                $ficha['referencia2'] = $referencia2;
                            }
                        } else {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $referencia3 = $generarReferencia->crear($concepto, $fechaReferencia, $cuoImporteInscripcion3);
                            $ficha['referencia1'] = $referencia3;
                        }

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    } else {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                        $dateLimite = $dateLimite->endOfDay();
                        if ($fechaLimiteHoy->lte($dateLimite)) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2)) {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);

                                $referencia2 = $generarReferencia->crear($concepto, $fechaReferencia, $cuoImporteInscripcion2);
                                $ficha['referencia2'] = $referencia2;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha2") {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert) {
                        if ($diferencia->format('%a') < $diasLimite) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1)) {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia1 = $generarReferencia->crear($concepto, $fechaReferencia, $cuoImporteInscripcion1);
                                $ficha['referencia2'] = $referencia1;
                            }
                        } else {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $referencia2 = $generarReferencia->crear($concepto, $fechaReferencia, $cuoImporteInscripcion2);
                            $ficha['referencia1'] = $referencia2;
                        }

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    } else {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                        $dateLimite = $dateLimite->endOfDay();
                        if ($fechaLimiteHoy->lte($dateLimite)) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1)) {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $referencia1 = $generarReferencia->crear($concepto, $fechaReferencia, $cuoImporteInscripcion1);
                                $ficha['referencia2'] = $referencia1;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha1") {
                    //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                    //ESA YA NO TIENE DESCUENTO
                    $cuantasFechasSeImprimen = 1;

                    //fecha actual menor que la fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe1;
                    $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                    $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                        . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                        . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                    $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                    $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                        . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                        . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                    $referencia1 = $generarReferencia->crear($concepto, $fechaReferencia, $cuoImporteInscripcion1);
                    $ficha['referencia1'] = $referencia1;

                    /*
                    $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                    $fechaVencimiento->add(new \DateInterval("P1D"));
                    $vencimiento = $fechaVencimiento->format("Y-m-d");
                    */

                    $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                }
            } else {
                //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                //ESA YA NO TIENE DESCUENTO
                $cuantasFechasSeImprimen = 1;

                //fecha actual menor que la fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                $referencia1 = $generarReferencia->crear($concepto, $fechaReferencia, $cuoImporteInscripcion1);
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
                "fchFechaVenc1"   => $ficha['cuoFechaLimiteInscripcion1DB'],
                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"], "", $ficha['cuoImporteInscripcion1']->format()) : NULL,
                "fhcRef1"         => $ficha['referencia1'],
                "fchFechaVenc2"   => $ficha['cuoFechaLimiteInscripcion2DB'],
                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"], "", $ficha['cuoImporteInscripcion2']->format()) : NULL,
                "fhcRef2"         => $ficha['referencia2'],
                "fchEstado"       => "P"
            ]);

            //sobreescribiendo vencimiento
            $vencimiento = Carbon::now()->addDays($diasLimite + 1)->format("Y-m-d");
            $ficha['vencimiento'] = Carbon::parse($vencimiento)->day
                . '/' . ucfirst(Carbon::parse($vencimiento)->formatLocalized('%b'))
                . '/' . Carbon::parse($vencimiento)->year;


            $ficha['impresion'] = date("d/m/Y H:i");
            return $this->generatePDF($ficha);
        } else {
            alert()->error('Error...', "No hay cuotas disponibles")->showConfirmButton();

            return redirect('secundaria_curso')->withInput();
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

        $curso = Curso::with('cgt.periodo', 'cgt.plan.programa.escuela.departamento.ubicacion', 'alumno.persona')->find($curso_id);
        $clave_pago = $curso->alumno->aluClave;
        $alumno_id = $curso->alumno->id;
        $programa_id = $curso->cgt->plan->programa->id;

        $alumno_ingreso = $curso->alumno->aluEstado;
        $alumno_cgtGrado = $curso->cgt->cgtGradoSemestre;

        $escuela_id = $curso->cgt->plan->programa->escuela->id;
        $departamento_id = $curso->cgt->plan->programa->escuela->departamento->id;
        $perNumero = $curso->cgt->periodo->perNumero;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $cuoConcepto = "99";

        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '" .
            $ubiClave . "' AND depClave = '" . $depClave . "' AND escClave = '" . $escClave . "'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        if (MetodosAlumnos::esAlumnoDeudorNivelActual(
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

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        if ($departamento_clave == "SEC") {
            $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
            $diasLimite = 15;
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
            ['cuoTipo', 'P'],
            ['dep_esc_prog_id', $programa_id],
            ['cuoAnio', $perAnioPago]
        ])->first();
        //2.- Escuela
        if (!$cuota) {
            $cuota = Cuota::where([
                ['cuoTipo', 'E'],
                ['dep_esc_prog_id', $escuela_id],
                ['cuoAnio', $perAnioPago]
            ])->first();
            //3.- Departamento
            if (!$cuota) {
                $cuota = Cuota::where([
                    ['cuoTipo', 'D'],
                    ['dep_esc_prog_id', $departamento_id],
                    ['cuoAnio', $perAnioPago]
                ])->first();
            }
        }
        if ($cuota) {
            $cuoAnio = $cuota->cuoAnio;
            $cuota_descuento = CuotaDescuento::where('cuota_id', $cuota->id)->first();
            if ($cuota_descuento) {
                //2022: solo 1er año ó si son primer ingreso (clave de pago nueva)
                if ($alumno_ingreso == "N") {
                    $cuota = $cuota_descuento;
                } else {
                    if ($alumno_cgtGrado == 1) {
                        $cuota = $cuota_descuento;
                    }
                }
            }

            $cuoConcepto =  ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "SEC") {
                $cuoImporteInscripcion1 = (float) $cuota->cuoImporteInscripcion1 + (float) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (float) $cuota->cuoImporteInscripcion2 + (float) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (float) $cuota->cuoImporteInscripcion3 + (float) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaLimiteInscripcion3;
            }


            $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
            $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
            $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");
            //$cuoAnio = $cuota->cuoAnio;

            //SI EL ALUMNO TIENE CUOTA ESPECIAL, SE LE COBRA LA DEL CURSO, NO DE LA CUOTA
            if ($curso->curImporteInscripcion != "" || $curso->curImporteInscripcion != NULL) {
                $cuoImporteInscripcion1 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 = (float) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion2 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 = (float) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion3 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 = (float) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
                $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
                $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");
            }

            $concepto = $clave_pago . $cuoConcepto;
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
                    $alumno_id,
                    $programa_id,
                    $cuoAnio,
                    $cuoConceptoRef,
                    $cuoFechaLimiteInscripcion1,
                    $cuoImporteInscripcion1,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "P"
                );
                $referencia1 = $generarReferencia->crearBBVA(
                    $concepto,
                    $cuoFechaLimiteInscripcion1,
                    $cuoImporteInscripcion1,
                    $conpRefClave,
                    $refNum
                );

                $importe1 = Utils::convertMoney($cuoImporteInscripcion1);
            }

            if ($cuoFechaLimiteInscripcion2 != null) {
                $fechaLimite2 = ($cuoFechaLimiteInscripcion2);

                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                    $alumno_id,
                    $programa_id,
                    $cuoAnio,
                    $cuoConceptoRef,
                    $cuoFechaLimiteInscripcion2,
                    $cuoImporteInscripcion2,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "P"
                );
                $referencia2 = $generarReferencia->crearBBVA(
                    $concepto,
                    $cuoFechaLimiteInscripcion2,
                    $cuoImporteInscripcion2,
                    $conpRefClave,
                    $refNum
                );

                $importe2 = Utils::convertMoney($cuoImporteInscripcion2);
            }

            if ($cuoFechaLimiteInscripcion3 != null) {
                $fechaLimite3 = ($cuoFechaLimiteInscripcion3);

                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                    $alumno_id,
                    $programa_id,
                    $cuoAnio,
                    $cuoConceptoRef,
                    $cuoFechaLimiteInscripcion3,
                    $cuoImporteInscripcion3,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "P"
                );
                $referencia3 = $generarReferencia->crearBBVA(
                    $concepto,
                    $cuoFechaLimiteInscripcion3,
                    $cuoImporteInscripcion3,
                    $conpRefClave,
                    $refNum
                );

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
            if (!$tieneDescuento) {
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
            if (!$tieneDescuento) {
                if ($cuoFechaLimiteInscripcion1 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite1);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha1";
                    }
                } else {
                    //POR ALGUNA RAZON , NO HAY CAPTURADO FECHALIMITE1
                    $tieneDescuento = false;
                }
            }

            $ficha['tieneDescuento'] = $tieneDescuento;

            $ficha['fechaLimite15Dias'] = Carbon::parse($fechaLimite15Dias)->day
                . '/' . ucfirst(Carbon::parse($fechaLimite15Dias)->formatLocalized('%b'))
                . '/' . Carbon::parse($fechaLimite15Dias)->year;
            $ficha['fechaLimite15DiasDB'] = $fechaLimite15Dias;

            // dd($fechaLimite15Dias,$fechaLimite2);
            //dd($cuoFechaLimiteInscripcion1, $fechaLimite15Dias);

            //INFORMACIÓN PARA GENERAR FICHA
            $ficha['clave_pago'] = $clave_pago;
            $ficha['curso'] = $curso;
            $ficha['nombreAlumno'] = $curso->alumno->persona->perApellido1 . ' ' . $curso->alumno->persona->perApellido2 . ' ' . $curso->alumno->persona->perNombre;
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
            if ($tieneDescuento) {
                if ($cualFechaDescuento == "fecha3") {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert) {
                        if ($diferencia->format('%a') < $diasLimite) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2)) {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);
                                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                    $alumno_id,
                                    $programa_id,
                                    $cuoAnio,
                                    $cuoConceptoRef,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion2,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    "P"
                                );

                                $referencia2 = $generarReferencia->crearBBVA(
                                    $concepto,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion2,
                                    $conpRefClave,
                                    $refNum
                                );
                                $ficha['referencia2'] = $referencia2;
                            }
                        } else {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $alumno_id,
                                $programa_id,
                                $cuoAnio,
                                $cuoConceptoRef,
                                $fechaReferencia,
                                $cuoImporteInscripcion3,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                "P"
                            );

                            $referencia3 = $generarReferencia->crearBBVA(
                                $concepto,
                                $fechaReferencia,
                                $cuoImporteInscripcion3,
                                $conpRefClave,
                                $refNum
                            );
                            $ficha['referencia1'] = $referencia3;
                        }

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    } else {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                        $dateLimite = $dateLimite->endOfDay();
                        if ($fechaLimiteHoy->lte($dateLimite)) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2)) {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);
                                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                    $alumno_id,
                                    $programa_id,
                                    $cuoAnio,
                                    $cuoConceptoRef,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion2,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    "P"
                                );
                                $referencia2 = $generarReferencia->crearBBVA(
                                    $concepto,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion2,
                                    $conpRefClave,
                                    $refNum
                                );
                                $ficha['referencia2'] = $referencia2;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha2") {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert) {
                        if ($diferencia->format('%a') < $diasLimite) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1)) {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                    $alumno_id,
                                    $programa_id,
                                    $cuoAnio,
                                    $cuoConceptoRef,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion1,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    "P"
                                );

                                $referencia1 = $generarReferencia->crearBBVA(
                                    $concepto,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion1,
                                    $conpRefClave,
                                    $refNum
                                );

                                $ficha['referencia2'] = $referencia1;
                            }
                        } else {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                $alumno_id,
                                $programa_id,
                                $cuoAnio,
                                $cuoConceptoRef,
                                $fechaReferencia,
                                $cuoImporteInscripcion2,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                "P"
                            );

                            $referencia2 = $generarReferencia->crearBBVA(
                                $concepto,
                                $fechaReferencia,
                                $cuoImporteInscripcion2,
                                $conpRefClave,
                                $refNum
                            );
                            $ficha['referencia1'] = $referencia2;
                        }

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    } else {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                        $dateLimite = $dateLimite->endOfDay();
                        if ($fechaLimiteHoy->lte($dateLimite)) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1)) {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                                    $alumno_id,
                                    $programa_id,
                                    $cuoAnio,
                                    $cuoConceptoRef,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion1,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    "P"
                                );

                                $referencia1 = $generarReferencia->crearBBVA(
                                    $concepto,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion1,
                                    $conpRefClave,
                                    $refNum
                                );
                                $ficha['referencia2'] = $referencia1;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha1") {
                    //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                    //ESA YA NO TIENE DESCUENTO
                    $cuantasFechasSeImprimen = 1;

                    //fecha actual menor que la fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe1;
                    $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                    $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                        . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                        . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                    $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                    $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                        . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                        . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                    $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                        $alumno_id,
                        $programa_id,
                        $cuoAnio,
                        $cuoConceptoRef,
                        $fechaReferencia,
                        $cuoImporteInscripcion1,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        "P"
                    );

                    $referencia1 = $generarReferencia->crearBBVA(
                        $concepto,
                        $fechaReferencia,
                        $cuoImporteInscripcion1,
                        $conpRefClave,
                        $refNum
                    );
                    $ficha['referencia1'] = $referencia1;

                    /*
                    $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                    $fechaVencimiento->add(new \DateInterval("P1D"));
                    $vencimiento = $fechaVencimiento->format("Y-m-d");
                    */

                    $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                }
            } else {
                //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                //ESA YA NO TIENE DESCUENTO
                $cuantasFechasSeImprimen = 1;

                //fecha actual menor que la fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                    $alumno_id,
                    $programa_id,
                    $cuoAnio,
                    $cuoConceptoRef,
                    $fechaReferencia,
                    $cuoImporteInscripcion1,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "P"
                );
                $referencia1 = $generarReferencia->crearBBVA(
                    $concepto,
                    $fechaReferencia,
                    $cuoImporteInscripcion1,
                    $conpRefClave,
                    $refNum
                );

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
                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"], "", $ficha['cuoImporteInscripcion1']->format()) : NULL,
                "fhcRef1"         => $ficha['referencia1'],
                "fchFechaVenc2"   => $ficha['cuoFechaLimiteInscripcion2DB'],
                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"], "", $ficha['cuoImporteInscripcion2']->format()) : NULL,
                "fhcRef2"         => $ficha['referencia2'],
                "fchEstado"       => "P"
            ]);

            //sobreescribiendo vencimiento
            $vencimiento = Carbon::now()->addDays($diasLimite + 1)->format("Y-m-d");
            $ficha['vencimiento'] = Carbon::parse($vencimiento)->day
                . '/' . ucfirst(Carbon::parse($vencimiento)->formatLocalized('%b'))
                . '/' . Carbon::parse($vencimiento)->year;


            $ficha['impresion'] = date("d/m/Y H:i");
            return $this->generatePDF_BBVA($ficha);
        } else {
            alert()->error('Error...', "No hay cuotas disponibles")->showConfirmButton();

            return redirect('secundaria_curso')->withInput();
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

        $curso = Curso::with('cgt.periodo', 'cgt.plan.programa.escuela.departamento.ubicacion', 'alumno.persona')->find($curso_id);
        $clave_pago = $curso->alumno->aluClave;
        $alumno_id = $curso->alumno->id;
        $programa_id = $curso->cgt->plan->programa->id;

        $alumno_ingreso = $curso->alumno->aluEstado;
        $alumno_cgtGrado = $curso->cgt->cgtGradoSemestre;

        $escuela_id = $curso->cgt->plan->programa->escuela->id;
        $departamento_id = $curso->cgt->plan->programa->escuela->departamento->id;
        $perNumero = $curso->cgt->periodo->perNumero;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;
        $cuoConcepto = "99";

        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '" .
            $ubiClave . "' AND depClave = '" . $depClave . "' AND escClave = '" . $escClave . "'");
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        if (MetodosAlumnos::esAlumnoDeudorNivelActual(
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

        //VERIFICA EL NIVEL EDUCATIVO DEL CURSO
        $departamento_clave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        if ($departamento_clave == "SEC") {
            $fechaLimite15Dias = Carbon::now()->addDays(15)->hour(0)->minute(0)->second(0);
            $diasLimite = 15;
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
            ['cuoTipo', 'P'],
            ['dep_esc_prog_id', $programa_id],
            ['cuoAnio', $perAnioPago]
        ])->first();
        //2.- Escuela
        if (!$cuota) {
            $cuota = Cuota::where([
                ['cuoTipo', 'E'],
                ['dep_esc_prog_id', $escuela_id],
                ['cuoAnio', $perAnioPago]
            ])->first();
            //3.- Departamento
            if (!$cuota) {
                $cuota = Cuota::where([
                    ['cuoTipo', 'D'],
                    ['dep_esc_prog_id', $departamento_id],
                    ['cuoAnio', $perAnioPago]
                ])->first();
            }
        }
        if ($cuota) {
            $cuoAnio = $cuota->cuoAnio;
            $cuota_descuento = CuotaDescuento::where('cuota_id', $cuota->id)->first();
            if ($cuota_descuento) {
                //2022: solo 1er año ó si son primer ingreso (clave de pago nueva)
                if ($alumno_ingreso == "N") {
                    $cuota = $cuota_descuento;
                } else {
                    if ($alumno_cgtGrado == 1) {
                        $cuota = $cuota_descuento;
                    }
                }
            }


            $cuoConcepto =  ($perAnio % 100) . $cuoConcepto;

            if ($departamento_clave == "SEC") {
                $cuoImporteInscripcion1 = (float) $cuota->cuoImporteInscripcion1 + (float) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion1 = $cuota->cuoFechaLimiteInscripcion1;

                $cuoImporteInscripcion2 = (float) $cuota->cuoImporteInscripcion2 + (float) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion2 = $cuota->cuoFechaLimiteInscripcion2;

                $cuoImporteInscripcion3 = (float) $cuota->cuoImporteInscripcion3 + (float) $cuota->cuoImportePadresFamilia;
                $cuoFechaLimiteInscripcion3 = $cuota->cuoFechaLimiteInscripcion3;
            }


            $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
            $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
            $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");
            //$cuoAnio = $cuota->cuoAnio;

            //SI EL ALUMNO TIENE CUOTA ESPECIAL, SE LE COBRA LA DEL CURSO, NO DE LA CUOTA
            if ($curso->curImporteInscripcion != "" || $curso->curImporteInscripcion != NULL) {
                $cuoImporteInscripcion1 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion1 = (float) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion2 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion2 = (float) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion3 = $curso->curImporteInscripcion;
                if ($tienePagoCeneval == "si") {
                    $cuoImporteInscripcion3 = (float) $curso->curImporteInscripcion - 500;
                }

                $cuoImporteInscripcion1 = (string) number_format($cuoImporteInscripcion1, 2, ".", "");
                $cuoImporteInscripcion2 = (string) number_format($cuoImporteInscripcion2, 2, ".", "");
                $cuoImporteInscripcion3 = (string) number_format($cuoImporteInscripcion3, 2, ".", "");
            }

            $concepto = $clave_pago . $cuoConcepto;
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
                    $alumno_id,
                    $programa_id,
                    $cuoAnio,
                    $cuoConceptoRef,
                    $cuoFechaLimiteInscripcion1,
                    $cuoImporteInscripcion1,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "P"
                );
                $referencia1 = $generarReferencia->crearHSBC(
                    $concepto,
                    $cuoFechaLimiteInscripcion1,
                    $cuoImporteInscripcion1,
                    $conpRefClave,
                    $refNum
                );

                $importe1 = Utils::convertMoney($cuoImporteInscripcion1);
            }

            if ($cuoFechaLimiteInscripcion2 != null) {
                $fechaLimite2 = ($cuoFechaLimiteInscripcion2);

                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                    $alumno_id,
                    $programa_id,
                    $cuoAnio,
                    $cuoConceptoRef,
                    $cuoFechaLimiteInscripcion2,
                    $cuoImporteInscripcion2,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "P"
                );
                $referencia2 = $generarReferencia->crearHSBC(
                    $concepto,
                    $cuoFechaLimiteInscripcion2,
                    $cuoImporteInscripcion2,
                    $conpRefClave,
                    $refNum
                );

                $importe2 = Utils::convertMoney($cuoImporteInscripcion2);
            }

            if ($cuoFechaLimiteInscripcion3 != null) {
                $fechaLimite3 = ($cuoFechaLimiteInscripcion3);

                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                    $alumno_id,
                    $programa_id,
                    $cuoAnio,
                    $cuoConceptoRef,
                    $cuoFechaLimiteInscripcion3,
                    $cuoImporteInscripcion3,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "P"
                );
                $referencia3 = $generarReferencia->crearHSBC(
                    $concepto,
                    $cuoFechaLimiteInscripcion3,
                    $cuoImporteInscripcion3,
                    $conpRefClave,
                    $refNum
                );

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
            if (!$tieneDescuento) {
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
            if (!$tieneDescuento) {
                if ($cuoFechaLimiteInscripcion1 != null) {

                    $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite1);
                    $dateLimite = $dateLimite->endOfDay();

                    if ($fechaLimiteHoy->lte($dateLimite)) {
                        $tieneDescuento = true;
                        $cualFechaDescuento = "fecha1";
                    }
                } else {
                    //POR ALGUNA RAZON , NO HAY CAPTURADO FECHALIMITE1
                    $tieneDescuento = false;
                }
            }

            $ficha['tieneDescuento'] = $tieneDescuento;

            $ficha['fechaLimite15Dias'] = Carbon::parse($fechaLimite15Dias)->day
                . '/' . ucfirst(Carbon::parse($fechaLimite15Dias)->formatLocalized('%b'))
                . '/' . Carbon::parse($fechaLimite15Dias)->year;
            $ficha['fechaLimite15DiasDB'] = $fechaLimite15Dias;

            // dd($fechaLimite15Dias,$fechaLimite2);
            //dd($cuoFechaLimiteInscripcion1, $fechaLimite15Dias);

            //INFORMACIÓN PARA GENERAR FICHA
            $ficha['clave_pago'] = $clave_pago;
            $ficha['curso'] = $curso;
            $ficha['nombreAlumno'] = $curso->alumno->persona->perApellido1 . ' ' . $curso->alumno->persona->perApellido2 . ' ' . $curso->alumno->persona->perNombre;
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
            if ($tieneDescuento) {
                if ($cualFechaDescuento == "fecha3") {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion3);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert) {
                        if ($diferencia->format('%a') < $diasLimite) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2)) {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);
                                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                    $alumno_id,
                                    $programa_id,
                                    $cuoAnio,
                                    $cuoConceptoRef,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion2,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    "P"
                                );

                                $referencia2 = $generarReferencia->crearHSBC(
                                    $concepto,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion2,
                                    $conpRefClave,
                                    $refNum
                                );
                                $ficha['referencia2'] = $referencia2;
                            }
                        } else {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $alumno_id,
                                $programa_id,
                                $cuoAnio,
                                $cuoConceptoRef,
                                $fechaReferencia,
                                $cuoImporteInscripcion3,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                "P"
                            );

                            $referencia3 = $generarReferencia->crearHSBC(
                                $concepto,
                                $fechaReferencia,
                                $cuoImporteInscripcion3,
                                $conpRefClave,
                                $refNum
                            );
                            $ficha['referencia1'] = $referencia3;
                        }

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    } else {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite3);
                        $dateLimite = $dateLimite->endOfDay();
                        if ($fechaLimiteHoy->lte($dateLimite)) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe3;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite3)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite3)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite3)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite3;
                            $ficha['referencia1'] = $referencia3;

                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite2)) {
                                $cuantasFechasSeImprimen = 2;
                                $ficha['cuoImporteInscripcion2'] = $importe2;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;
                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                //dd($cuoFechaLimiteInscripcion1,$fechaReferencia);
                                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                    $alumno_id,
                                    $programa_id,
                                    $cuoAnio,
                                    $cuoConceptoRef,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion2,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    "P"
                                );
                                $referencia2 = $generarReferencia->crearHSBC(
                                    $concepto,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion2,
                                    $conpRefClave,
                                    $refNum
                                );
                                $ficha['referencia2'] = $referencia2;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha2") {
                    $fechaPago = new \DateTime($cuoFechaLimiteInscripcion2);
                    $diferencia = $fechaPago->diff($fechaHoy);
                    if ($diferencia->invert) {
                        if ($diferencia->format('%a') < $diasLimite) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1)) {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                    $alumno_id,
                                    $programa_id,
                                    $cuoAnio,
                                    $cuoConceptoRef,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion1,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    "P"
                                );

                                $referencia1 = $generarReferencia->crearHSBC(
                                    $concepto,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion1,
                                    $conpRefClave,
                                    $refNum
                                );

                                $ficha['referencia2'] = $referencia1;
                            }
                        } else {
                            //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ESTA DENTRO DEL PERIODO LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                            $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                            $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                $alumno_id,
                                $programa_id,
                                $cuoAnio,
                                $cuoConceptoRef,
                                $fechaReferencia,
                                $cuoImporteInscripcion2,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                "P"
                            );

                            $referencia2 = $generarReferencia->crearHSBC(
                                $concepto,
                                $fechaReferencia,
                                $cuoImporteInscripcion2,
                                $conpRefClave,
                                $refNum
                            );
                            $ficha['referencia1'] = $referencia2;
                        }

                        /*
                        $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                        $fechaVencimiento->add(new \DateInterval("P1D"));
                        $vencimiento = $fechaVencimiento->format("Y-m-d");
                        */

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    } else {
                        //ES EL MERO DIA (diferencia en tiempo)
                        $dateLimite = Carbon::createFromFormat('Y-m-d', $fechaLimite2);
                        $dateLimite = $dateLimite->endOfDay();
                        if ($fechaLimiteHoy->lte($dateLimite)) {
                            //SE TIENEN QUE IMPRIMIR 2 FECHAS DE PAGO PARA CUBRIR EL LIMITE
                            $cuantasFechasSeImprimen = 1;

                            //fecha actual menor que la fecha límite
                            $ficha['cuoImporteInscripcion1'] = $importe2;
                            $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimite2)->day
                                . '/' . ucfirst(Carbon::parse($fechaLimite2)->formatLocalized('%b'))
                                . '/' . Carbon::parse($fechaLimite2)->year;
                            $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimite2;
                            $ficha['referencia1'] = $referencia2;


                            $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                            if ($fechaLimiteDiasRestantes->lte($fechaLimite1)) {
                                $cuantasFechasSeImprimen = 2;

                                $ficha['cuoImporteInscripcion2'] = $importe1;
                                $ficha['cuoFechaLimiteInscripcion2'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                                $ficha['cuoFechaLimiteInscripcion2DB'] = $fechaLimiteDiasRestantes;

                                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                                    $alumno_id,
                                    $programa_id,
                                    $cuoAnio,
                                    $cuoConceptoRef,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion1,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    "P"
                                );

                                $referencia1 = $generarReferencia->crearHSBC(
                                    $concepto,
                                    $fechaReferencia,
                                    $cuoImporteInscripcion1,
                                    $conpRefClave,
                                    $refNum
                                );
                                $ficha['referencia2'] = $referencia1;
                            }
                        }

                        $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                    }
                }

                if ($cualFechaDescuento == "fecha1") {
                    //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                    //ESA YA NO TIENE DESCUENTO
                    $cuantasFechasSeImprimen = 1;

                    //fecha actual menor que la fecha límite
                    $ficha['cuoImporteInscripcion1'] = $importe1;
                    $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                    $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                        . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                        . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                    $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                    $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                        . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                        . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                    $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                        $alumno_id,
                        $programa_id,
                        $cuoAnio,
                        $cuoConceptoRef,
                        $fechaReferencia,
                        $cuoImporteInscripcion1,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        "P"
                    );

                    $referencia1 = $generarReferencia->crearHSBC(
                        $concepto,
                        $fechaReferencia,
                        $cuoImporteInscripcion1,
                        $conpRefClave,
                        $refNum
                    );
                    $ficha['referencia1'] = $referencia1;

                    /*
                    $fechaVencimiento = new \DateTime($fechaLimiteDiasRestantes);
                    $fechaVencimiento->add(new \DateInterval("P1D"));
                    $vencimiento = $fechaVencimiento->format("Y-m-d");
                    */

                    $ficha['cuantasFechasSeImprimen'] = $cuantasFechasSeImprimen;
                }
            } else {
                //SOLO SE IMPRIME UNA FECHA DE PAGO PORQUE ES LA FECHA1, LA MAS LEJANA Y
                //ESA YA NO TIENE DESCUENTO
                $cuantasFechasSeImprimen = 1;

                //fecha actual menor que la fecha límite
                $ficha['cuoImporteInscripcion1'] = $importe1;
                $fechaLimiteDiasRestantes = Carbon::now()->addDays($diasLimite)->hour(0)->minute(0)->second(0);
                $ficha['cuoFechaLimiteInscripcion1'] = Carbon::parse($fechaLimiteDiasRestantes)->day
                    . '/' . ucfirst(Carbon::parse($fechaLimiteDiasRestantes)->formatLocalized('%b'))
                    . '/' . Carbon::parse($fechaLimiteDiasRestantes)->year;
                $ficha['cuoFechaLimiteInscripcion1DB'] = $fechaLimiteDiasRestantes;

                $fechaReferencia = Carbon::parse($fechaLimiteDiasRestantes)->year
                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->month
                    . '-' . Carbon::parse($fechaLimiteDiasRestantes)->day;

                $refNum = $generarReferencia->generarRegistroReferenciaHSBC(
                    $alumno_id,
                    $programa_id,
                    $cuoAnio,
                    $cuoConceptoRef,
                    $fechaReferencia,
                    $cuoImporteInscripcion1,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "P"
                );
                $referencia1 = $generarReferencia->crearHSBC(
                    $concepto,
                    $fechaReferencia,
                    $cuoImporteInscripcion1,
                    $conpRefClave,
                    $refNum
                );

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
                "fhcImp1"         => $ficha['cuoImporteInscripcion1'] ? str_replace([",", "$"], "", $ficha['cuoImporteInscripcion1']->format()) : NULL,
                "fhcRef1"         => $ficha['referencia1'],
                "fchFechaVenc2"   => $ficha['cuoFechaLimiteInscripcion2DB'],
                "fhcImp2"         => $ficha['cuoImporteInscripcion2'] ? str_replace([",", "$"], "", $ficha['cuoImporteInscripcion2']->format()) : NULL,
                "fhcRef2"         => $ficha['referencia2'],
                "fchEstado"       => "P"
            ]);

            //sobreescribiendo vencimiento
            $vencimiento = Carbon::now()->addDays($diasLimite + 1)->format("Y-m-d");
            $ficha['vencimiento'] = Carbon::parse($vencimiento)->day
                . '/' . ucfirst(Carbon::parse($vencimiento)->formatLocalized('%b'))
                . '/' . Carbon::parse($vencimiento)->year;


            $ficha['impresion'] = date("d/m/Y H:i");
            return $this->generatePDF_HSBC($ficha);
        } else {
            alert()->error('Error...', "No hay cuotas disponibles")->showConfirmButton();

            return redirect('secundaria_curso')->withInput();
        }
    }

    private function generatePDF($ficha)
    {
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
        $pdf = new EFEPDF('P', 'mm', 'Letter');
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


            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, 'CURSO ESCOLAR: ' . $ficha['cursoEscolar'], 0, 0, 'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "FICHA DE DEPOSITO", 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', '', 30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "BBVA", 0, 0, "C");



            $pdf->SetFont('Arial', '', 10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, $ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, $ficha['cuoNumeroCuenta'], 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $nombreC, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $ubicacionC, 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);

            $ultimaFecha = "";

            if ($cuantasFechas == 1) {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1);

                $pdf->SetX($columna1);
            }

            if ($cuantasFechas == 2) {
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

    private function generatePDF_HSBC($ficha)
    {
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
        $pdf = new EFEPDF('P', 'mm', 'Letter');
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


            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, 'CURSO ESCOLAR: ' . $ficha['cursoEscolar'], 0, 0, 'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO POR TRANSFERENCIA ELECTRÓNICA SPEI"), 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', '', 30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "HSBC", 0, 0, "C");



            $pdf->SetFont('Arial', '', 10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, $ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "021180550300090224", 1, 0, 'C');
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $nombreC, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $ubicacionC, 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);

            $ultimaFecha = "";

            if ($cuantasFechas == 1) {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0, 'C');
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0, 'C');
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1, 'C');

                $pdf->SetX($columna1);
            }

            if ($cuantasFechas == 2) {
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

    private function generatePDF_BBVA($ficha)
    {
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
        $pdf = new EFEPDF('P', 'mm', 'Letter');
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


            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, 'CURSO ESCOLAR: ' . $ficha['cursoEscolar'], 0, 0, 'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO CON REFERENCIA BANCARIA"), 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', '', 30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "BBVA", 0, 0, "C");



            $pdf->SetFont('Arial', '', 10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, $ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "012914002018521323", 1, 0, 'C');
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $nombreC, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $ubicacionC, 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);

            $ultimaFecha = "";

            if ($cuantasFechas == 1) {
                $pdf->SetX($columna1);

                /* FORZAMOS A QUE LA FECHA LIMITE SEA DE 15 DIAS DESPUES DE GENERAR LA FICHA */
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0, 'C');
                /*------------------------------------------------------------------------------*/
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0, 'C');
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1, 'C');

                $pdf->SetX($columna1);
            }

            if ($cuantasFechas == 2) {
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

class EFEPDF extends Fpdf
{
    public function Header()
    {
        //$this->SetFont('Arial','B',15);
        //$this->Cell(80);
        //$this->Cell(30,10,'Title',1,0,'C');
        //$this->Ln(20);
    }
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
