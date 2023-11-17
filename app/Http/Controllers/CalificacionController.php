<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Modules;
use App\Http\Models\Curso;
use App\Http\Models\Grupo;
use App\Models\Permission;
use App\Http\Helpers\Utils;
use App\Http\Models\MatriculaAnterior;
use App\Http\Models\Portal_configuracion;
use Illuminate\Support\Str;

use App\Http\Models\Escuela;
use App\Http\Models\Materia;
use App\Http\Models\Optativa;
use Illuminate\Http\Request;
use App\Http\Models\Inscrito;
use App\Http\Models\Calificacion;
use Illuminate\Support\Facades\DB;
use App\Models\Permission_module_user;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\clases\Recolectores\AlumnosReprobadosParcialesRecolector;
use App\clases\calificaciones\NotificacionReprobadosParciales;
use App\clases\calificaciones\MetodosCalificaciones;

use App\Http\Models\Extraordinario;
use App\Http\Models\InscritoExtraordinario;

use Exception;


class CalificacionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:calificacion',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        //
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

    public function agregar($nivel,$grupo_id)
    {
        $configTercerParcial = Portal_configuracion::select('pcEstado')
        ->where('pcClave', 'TERCER_PARCIAL')
        ->where('pcPortal', 'D')
        ->first();
        $TERCER_PARCIAL = ($configTercerParcial->pcEstado == 'A');

        //OBTENER GRUPO SELECCIONADO
        $grupo    = Grupo::with('plan.programa','materia','empleado.persona')->find($grupo_id);
        //OBTENER PERMISO DE USUARIO
        $user     = Auth::user();
        $modulo   = Modules::where('slug','calificacion')->first();
        $permisos = Permission_module_user::where('user_id', $user->id)->where('module_id', $modulo->id)->first();
        $permiso  = Permission::find($permisos->permission_id)->name;
        //OBTENER PROMEDIO PONDERADO EN MATERIA
        $materia  = Materia::where('id',$grupo->materia_id)->first();


        if ($materia->matPorcentajeParcial != null) {
            $matPorcentajeParcial   = $materia->matPorcentajeParcial;
            //$matPorcentajeOrdinario = $materia->matPorcentajeOrdinario;
        } else {
            //OBTENER PROMEDIO PONDERADO EN ESCUELA SI NO TIENE EN MATERIA
            $escuela = Escuela::where('id',$grupo->plan->programa->escuela_id)->first();
            $matPorcentajeParcial = $escuela->escPorcExaPar;
        }


        if ($materia->matPorcentajeOrdinario != null) {
            $matPorcentajeOrdinario = $materia->matPorcentajeOrdinario;
        } else {
            $escuela = Escuela::where('id',$grupo->materia->plan->programa->escuela_id)->first();
            $matPorcentajeOrdinario = $escuela->escPorcExaOrd;
        }


        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('grupo', $grupo->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('grupo');
        } else {
            switch ($nivel) {
                case 'SUP':

                    //OBTENER INSCRITOS DE UNIVERSIDAD AL GRUPO
                    $inscritos = Inscrito::with('curso.cgt.periodo','curso.cgt.plan.programa','curso.alumno.persona','calificacion')
                        ->where('grupo_id',$grupo_id)
                    ->get();

                    $inscritos = $inscritos->map(function ($item, $key) {
                        $item->sortByNombres = $item->curso->alumno->persona->perApellido1 . "-" . 
                        $item->curso->alumno->persona->perApellido2  . "-" . 
                        $item->curso->alumno->persona->perNombre;

                        return $item;
                    })->sortBy("sortByNombres");

                    $motivosFalta = DB::table("motivosfalta")->get()->sortByDesc("id");

                    return view('calificacion.universidad.create',compact(
                        'grupo',
                        'inscritos',
                        'permiso',
                        'matPorcentajeParcial',
                        'matPorcentajeOrdinario',
                        'motivosFalta',
                        'TERCER_PARCIAL'
                    ));
                    break;
                default:
                    alert()->error('Ups...', 'Proximamente!')->showConfirmButton()->autoClose(5000);
                    return redirect('grupo');
                    break;
            }
        }
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
        $configTercerParcial = Portal_configuracion::select('pcEstado')
        ->where('pcClave', 'TERCER_PARCIAL')
        ->where('pcPortal', 'D')
        ->first();
        $TERCER_PARCIAL = ($configTercerParcial->pcEstado == 'A');

        $grupo_id = $request->grupo_id;
        //OBTENER GRUPO SELECCIONADO
        $grupo = Grupo::with('plan','materia','empleado.persona')->find($grupo_id);




        if ($grupo->estado_act == "B" && (User::permiso("calificacion") != "C" && User::permiso("calificacion") != "B" && User::permiso("calificacion") != "A") ) {

            alert('Escuela Modelo', 'El estado actual del grupo no permite modificación de calificaciones', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }

    
        if ($grupo->estado_act == "C") {
            alert('Escuela Modelo', 'El estado actual del grupo no permite modificación de calificaciones', 'warning')->showConfirmButton();
            return redirect()->back()->withInput();
        }


        try {
            $calificaciones = $request->calificaciones;


            $inscCalificacionParcial1Col  = $request->has("calificaciones.inscCalificacionParcial1")  ? collect($calificaciones["inscCalificacionParcial1"])  : collect();
            $inscFaltasParcial1Col        = $request->has("calificaciones.inscFaltasParcial1")        ? collect($calificaciones["inscFaltasParcial1"])        : collect();
            $inscCalificacionParcial2Col  = $request->has("calificaciones.inscCalificacionParcial2")  ? collect($calificaciones["inscCalificacionParcial2"])  : collect();
            $inscFaltasParcial2Col        = $request->has("calificaciones.inscFaltasParcial2")        ? collect($calificaciones["inscFaltasParcial2"])        : collect();
            if ($TERCER_PARCIAL) {
                $inscCalificacionParcial3Col  = $request->has("calificaciones.inscCalificacionParcial3")  ? collect($calificaciones["inscCalificacionParcial3"])  : collect();
                $inscFaltasParcial3Col        = $request->has("calificaciones.inscFaltasParcial3")        ? collect($calificaciones["inscFaltasParcial3"])        : collect();
            }
            $inscPromedioParcialesCol     = $request->has("calificaciones.inscPromedioParciales")     ? collect($calificaciones["inscPromedioParciales"])     : collect();
            $inscCalificacionOrdinarioCol = $request->has("calificaciones.inscCalificacionOrdinario") ? collect($calificaciones["inscCalificacionOrdinario"]) : collect();
            $incsCalificacionFinalCol     = $request->has("calificaciones.incsCalificacionFinal")     ? collect($calificaciones["incsCalificacionFinal"])     : collect();
            $inscMotivoFaltaCol           = $request->has("calificaciones.inscMotivoFalta")           ? collect($calificaciones["inscMotivoFalta"])           : collect();

            
            /**
             * Verificar que en los parciales:
             * - Si ponen faltas a un alumno, la calificacion es obligatoria.
             * - Si ponen faltas, que no excedan las 30, es el número máximo de faltas.
             */
            $datosIncorrectosParcial1 = $inscFaltasParcial1Col->filter(static function($faltas, $key) use ($inscCalificacionParcial1Col) {
                $calificacion = $inscCalificacionParcial1Col->get($key);
                return ($faltas && intval($faltas) > 30) || ($faltas && is_null($calificacion));
            });
            $datosIncorrectosParcial2 = $inscFaltasParcial2Col->filter(static function($faltas, $key) use ($inscCalificacionParcial2Col) {
                $calificacion = $inscCalificacionParcial2Col->get($key);
                return ($faltas && intval($faltas) > 30) || ($faltas && is_null($calificacion));
            });
            if ($TERCER_PARCIAL) {
                $datosIncorrectosParcial3 = $inscFaltasParcial3Col->filter(static function($faltas, $key) use ($inscCalificacionParcial3Col) {
                    $calificacion = $inscCalificacionParcial3Col->get($key);
                    return ($faltas && intval($faltas) > 30) || ($faltas && is_null($calificacion));
                });
            }
            
            $condicion = ($datosIncorrectosParcial1->isNotEmpty() || $datosIncorrectosParcial2->isNotEmpty());

            if ($TERCER_PARCIAL) {
                $condicion = ($datosIncorrectosParcial1->isNotEmpty() || $datosIncorrectosParcial2->isNotEmpty() || $datosIncorrectosParcial3->isNotEmpty());
            }

            if($condicion)
            {
                alert('No se puede proceder con la acción', 'No se puede registrar faltas para un alumno sin proporcionar una calificación. Un alumno no puede tener más de 30 faltas en un parcial.', 'warning')->showConfirmButton();
                return back()->withInput();
            }

            //OBTENER INSCRITOS DE UNIVERSIDAD AL GRUPO
            $inscritos = Inscrito::with('curso.cgt.periodo', 'curso.cgt.plan.programa', 'curso.alumno', 'calificacion')->where('grupo_id', $grupo_id)->get();




            foreach ($inscritos as $inscrito) {
                $calificacion = Calificacion::where('inscrito_id', $inscrito->id)->first();
                $calificacion_anterior = clone $calificacion;
 
                $inscCalificacionParcial1 = $inscCalificacionParcial1Col->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();
                $inscFaltasParcial1 = $inscFaltasParcial1Col->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();

                $inscCalificacionParcial2 = $inscCalificacionParcial2Col->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();
                $inscFaltasParcial2 = $inscFaltasParcial2Col->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();

                if ($TERCER_PARCIAL) {
                    $inscCalificacionParcial3 = $inscCalificacionParcial3Col->filter(function ($value, $key) use ($inscrito) {
                        return $key == $inscrito->id;
                    })->first();
                    $inscFaltasParcial3 = $inscFaltasParcial3Col->filter(function ($value, $key) use ($inscrito) {
                        return $key == $inscrito->id;
                    })->first();
                }

                $inscPromedioParciales = $inscPromedioParcialesCol->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();
                $inscCalificacionOrdinario = $inscCalificacionOrdinarioCol->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();
                $incsCalificacionFinal = $incsCalificacionFinalCol->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();
                $inscMotivoFalta = $inscMotivoFaltaCol->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();

                $motivoFalta = DB::table("motivosfalta")->where("id", "=", $inscMotivoFalta)->first();
                $motivoFalta = $motivoFalta ? $motivoFalta->mfAbreviatura: "";


                if ($calificacion) {
                    $calificacion->inscCalificacionParcial1  = $inscCalificacionParcial1  != null ? $inscCalificacionParcial1  : $calificacion->inscCalificacionParcial1;
                    $calificacion->inscFaltasParcial1        = $inscFaltasParcial1        != null ? $inscFaltasParcial1        : $calificacion->inscFaltasParcial1;
                    $calificacion->inscCalificacionParcial2  = $inscCalificacionParcial2  != null ? $inscCalificacionParcial2  : $calificacion->inscCalificacionParcial2;
                    $calificacion->inscFaltasParcial2        = $inscFaltasParcial2        != null ? $inscFaltasParcial2        : $calificacion->inscFaltasParcial2;
                    if ($TERCER_PARCIAL) {
                        $calificacion->inscCalificacionParcial3  = $inscCalificacionParcial3  != null ? $inscCalificacionParcial3  : $calificacion->inscCalificacionParcial3;
                        $calificacion->inscFaltasParcial3        = $inscFaltasParcial3        != null ? $inscFaltasParcial3        : $calificacion->inscFaltasParcial3;
                    }
                    $calificacion->inscPromedioParciales     = $inscPromedioParciales     != null ? $inscPromedioParciales     : $calificacion->inscPromedioParciales;
                    if (!in_array($motivoFalta, ['NPE', 'SDE'])) {
                        $calificacion->inscCalificacionOrdinario = $inscCalificacionOrdinario != null ? $inscCalificacionOrdinario : $calificacion->inscCalificacionOrdinario;
                        $calificacion->incsCalificacionFinal     = $incsCalificacionFinal     != null ? $incsCalificacionFinal     : $calificacion->incsCalificacionFinal;
                    } else {
                        $calificacion->inscCalificacionOrdinario = 0;
                        $calificacion->incsCalificacionFinal     = 0;
                    }
                    $calificacion->motivofalta_id           = $inscMotivoFalta           != null ? $inscMotivoFalta           : $calificacion->motivofalta_id;

                    /**
                     * Si el modelo sufrió cambios, registrará un App\Http\Models\CalificacionHistorial
                     */
                    if($calificacion->isDirty()) {
                        MetodosCalificaciones::crearHistorial($calificacion_anterior, $calificacion);
                    }

                    $calificacion->save();
                }

            }



            



            //VERIFICAR QUE TODOS LOS ALUMNOS TENGAN CAL1, CAL2, CAL3, CAL-ORDINARIO CAPTURADOS
            //SI ESTAN TODOS CAPTURADOS DE TODOS LOS ALUMNOS CAMBIAR ESTATUS DEL GRUPO A "B"
            $grupoCambiaEstatus = Calificacion::whereIn('inscrito_id', $inscritos->pluck('id'))
            ->where(static function($query) use($TERCER_PARCIAL) {
                $query->whereNull('inscCalificacionParcial1')
                ->orWhereNull('inscCalificacionParcial2')
                ->orWhereNull('inscCalificacionOrdinario')
                ->orWhereNull('incsCalificacionFinal');
                if ($TERCER_PARCIAL) $query->orWhereNull('inscCalificacionParcial3');
            })
            ->exists();

            //SI LA MATERIA ES ALFABETICA  REVISAR SOLO EL ORDINARIO Y LA CALIFICACION FINAL
            //PARA CAMBIAR EL ESTADO DEL GRUPO
            $esMateriaAlfa = $grupo->materia->matTipoAcreditacion == 'A' ? true : false;
            if ($esMateriaAlfa) {
                $grupoCambiaEstatus = Calificacion::whereIn('inscrito_id', $inscritos->pluck('id'))
                ->where(static function($query) {
                    $query->whereNull('inscCalificacionOrdinario')
                    ->orWhereNull('incsCalificacionFinal');
                })
                ->exists();
            }

            if (!$grupoCambiaEstatus) {
                $grupo->estado_act = "B";
                $grupo->save();
            }

            /**
             * Si el Recolector encuentra alumnos reprobados, envía una notificación a través de
             * la clase NotificacionReprobadosParciales.
             */
            $recolector = new AlumnosReprobadosParcialesRecolector([
                'periodo_id' => $grupo->periodo_id,
                'matClave' => $grupo->materia->matClave,
                'plan_id' => $grupo->plan_id,
                'semestre' => $grupo->gpoSemestre,
                'grupo' => $grupo->gpoClave,
                'etapa_calificacion' => $grupo->estado_act == 'B' ? 'Final' : null,
            ]);

            # en caso de estar haciendo test, poner la siguiente variable en false.
            $notificacion_activada = true;
            if($recolector->reprobados->isNotEmpty() && $notificacion_activada) {
                $recolector->generarExcel();
                $notificacion = new NotificacionReprobadosParciales($grupo, $recolector);
                $notificacion->enviar();
            }

        } catch (Exception $e) {
            alert()->error('Error...', $e->getMessage())->showConfirmButton();
            return redirect('calificacion/agregar/SUP/' . $grupo_id)->withInput();
        }

        alert('Escuela Modelo', 'Se registraron las calificaciones con éxito', 'success')->showConfirmButton();
        return redirect('calificacion/agregar/SUP/' . $grupo_id);
    }


    public function agregarExtra($extraordinario_id)
    {
        //OBTENER Extraordinario e inscritos
        $extraordinario  = Extraordinario::with('materia.plan.programa','periodo','empleado.persona')->find($extraordinario_id);
        $inscritoextra  = InscritoExtraordinario::with('alumno.persona')->where('extraordinario_id',$extraordinario_id)->where('iexEstado','!=','C')->get();
    
        $inscritos = $inscritoextra->map(function ($item, $key) {
            $item->sortByNombres = $item->alumno->persona->perApellido1 . "-" . 
            $item->alumno->persona->perApellido2  . "-" . 
            $item->alumno->persona->perNombre;
            $item->iexEstado;

            return $item;
        })->sortBy("sortByNombres");

        $motivosFalta = DB::table("motivosfalta")->get()->sortByDesc("id");



        return view('calificacion.extraordinario.create',compact('extraordinario','inscritos', 'motivosFalta'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function extraStore(Request $request)
    {
        $extraordinario_id = $request->extraordinario_id;
        //OBTENER Inscritos Extraordinarios
        $extraordinario  = Extraordinario::with('materia.plan.programa','periodo','empleado.persona')->find($extraordinario_id);
        $inscritoextra  = InscritoExtraordinario::with('alumno.persona')->where('extraordinario_id',$extraordinario_id)->where('iexEstado','!=','C')->get();

        $tipoMateria = $extraordinario->materia->matTipoAcreditacion;


        try {

            $calificacion = $request->calificacion;

            $inscEx  = $request->has("calificacion.inscEx")  ? collect($calificacion["inscEx"])  : collect();
            $asistencia = $request->has("calificacion.asistencia")  ? collect($calificacion["asistencia"])  : collect();
            
            foreach ($inscritoextra as $inscrito) {
                $inscritoEx  = InscritoExtraordinario::find($inscrito->id);
                $calificacionEx = $inscEx->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();

                $miAsistencia = $asistencia->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();


                     
                if ($miAsistencia != 10) {
                    #$calificacionEx = 0;
                    $calificacionEx = $tipoMateria == 'N' ? 0 : 1;
                }
               
                if ($inscritoEx) {
                    $inscritoEx->iexCalificacion  = !is_null($calificacionEx) ? $calificacionEx  : $inscritoEx->iexCalificacion;
                    $inscritoEx->motivofalta_id = $miAsistencia;
                    $inscritoEx->save(); 
                }
            }

            alert('Escuela Modelo', 'Se registraron las calificaciones con éxito', 'success')->showConfirmButton();
            return redirect('calificacion/agregarextra/' . $extraordinario_id)->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('calificacion/agregarextra/' . $extraordinario_id)->withInput();
        }
    }

    public function agregarMatricula($grupo_id)
    {
        //OBTENER Extraordinario e inscritos

        $grupo = Grupo::find($grupo_id);
        $inscritos = Inscrito::with('curso.cgt.periodo', 'curso.cgt.plan.programa', 'curso.alumno', 'calificacion')->where('grupo_id', $grupo_id)->get(); 

        $optativa = Optativa::where('materia_id',$grupo->materia->id)->first();
    
        $inscritos = $inscritos->map(function ($item, $key) {
            $item->nombreCompleto = $item->curso->alumno->persona->perApellido1 . "-" . 
            $item->curso->alumno->persona->perApellido2  . "-" . 
            $item->curso->alumno->persona->perNombre;
            $item->curso->alumno->aluMatricula;

            return $item;
        })->sortBy("nombreCompleto");


        return view('calificacion.matricula.create',compact('grupo','optativa','inscritos'));

    }

    

    public function storeMatricula(Request $request)
    {
        $grupo_id = $request->grupo_id;
        //OBTENER Inscritos
        $inscritos = Inscrito::with('curso.cgt.periodo', 'curso.cgt.plan.programa', 'curso.alumno', 'calificacion')
        ->where('grupo_id', $grupo_id)->get(); 

        try {

            $matricula = $request->matricula;


            $insc  = $request->has("matricula.insc")  ? collect($matricula["insc"])  : collect();

            $inscritos->each(function($inscrito) use ($insc){

                $alumno = $inscrito->curso->alumno;
                $programa = $inscrito->curso->cgt->plan->programa;

                $matriculaAnterior = MatriculaAnterior::where('alumno_id',$alumno->id)->where('programa_id',$programa->id)->first();
            
                $nuevaMatricula = $insc->filter(function ($value, $key) use ($inscrito) {
                    return $key == $inscrito->id;
                })->first();
                //Se busca matricula anterior para actualizar o crear
                if($nuevaMatricula){
                    if(!is_null($matriculaAnterior)){
                        $matricAnterior = $matriculaAnterior->matricNueva;
                        $matriculaAnterior->fill([
                            'matricNueva' => $nuevaMatricula,
                            'matricAnterior' => $matricAnterior
                        ]);
                        $matriculaAnterior->save();
                    }else{
                        MatriculaAnterior::create([
                            'alumno_id' => $alumno->id,
                            'matricNueva' => $nuevaMatricula,
                            'matricAnterior'=>$alumno->aluMatricula,
                            'programa_id'=>$programa->id
                        ]);
                    }
                }
                //Se actualiza la matricula del alumno
                if ($alumno) {
                    $alumno->aluMatricula  = $nuevaMatricula  != null ? $nuevaMatricula  : $alumno->aluMatricula;
                    $alumno->save(); 
                }
                
            });
            
            alert('Escuela Modelo', 'Se actualizaron las matriculas con éxito', 'success')->showConfirmButton();
            return redirect('calificacion/matricula/' . $grupo_id)->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return redirect('calificacion/matricula/' . $grupo_id)->withInput();
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
        //
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
        //
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
        //
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
        //
    }
}