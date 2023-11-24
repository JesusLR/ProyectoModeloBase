<?php

namespace App\Http\Controllers\Archivos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

use App\Models\Cgt;
use App\Models\Grupo;
use App\Models\Inscrito;
use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\ClaveProfesor;
use App\Models\Extraordinario;
use App\Models\InscritoExtraordinario;

use Carbon\Carbon;

class AextraordinarioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:a_extraordinario');

        set_time_limit(8000000);

    }

    public function generar(){
        $ubicaciones = Ubicacion::all();
        $tipos = array(
            'S' => 'olicitud',
            'I' => 'nscripción',
            'C' => 'alificación',
        );
        $oportunidades = [1,2];
        return View('archivo/extraordinario.create',compact('ubicaciones','tipos', 'oportunidades'));
    }




    public function _archivoSolicitud($request)
    {
        // $planes = Grupo::with("periodo")
        //     ->whereHas('periodo', function($query) use ($request) {
        //         $query->where("id", "=", $request->periodo_id);
        //     })
        // ->get();
        $planes = Extraordinario::with('materia.plan')
        ->whereHas('materia.plan', function ($query) use ($request) {
            $query->where('planRegistro', $request->tipo_registro);
        })
        ->where('periodo_id', $request->periodo_id);
        // ->get()
        if (!is_null($request->oportunidad)) {
            $planes->where('extraordinarios.extOportunidad_DentroDelPeriodo', $request->oportunidad);
        }
        $planes = $planes->get()
        ->pluck('materia.plan')->unique();

        $ubicacion = $planes->first()->programa->escuela->departamento->ubicacion;

        $periodo = Periodo::findOrFail($request->periodo_id);


        foreach ($planes as $key => $plan) {
            // $ordinarios = Grupo::with('plan.programa.escuela.departamento.ubicacion','empleado.persona','materia','empleado.persona')
            //     ->where('periodo_id', $request->input('periodo_id'))
            //     ->where('plan_id', $plan->plan_id)
            // ->get()
            // ->sortBy('plan.programa.progClave');

            $inscritosExtra = InscritoExtraordinario::with("extraordinario.materia")
                ->whereHas('extraordinario.materia.plan', function($query) use ($request, $plan) {
                    $query->where("id", "=", $plan->id);
                    $query->where('planRegistro', $request->tipo_registro);
                })
                ->whereHas('extraordinario.periodo', function($query) use ($request, $periodo) {
                    $query->where("id", "=", $periodo->id);
                });
            // ->get();
            if (!is_null($request->oportunidad)) {
                $inscritosExtra->where('extOportunidad_DentroDelPeriodo', $request->oportunidad);
            }
            $inscritosExtra = $inscritosExtra->get();

            $inscritosExtra = $inscritosExtra->unique("extraordinario.id");

            // 1_sol_ext_$periodo_$año_Ene_$ubiClave_$progClave_$planClave.csv

            $fileName = "1_sol_ext_"
                . $periodo->perNumero."_".$periodo->perAnio . "_Ene_"
                . $plan->programa->escuela->departamento->ubicacion->ubiClave . "_"
                . $plan->programa->progClave . "_" . $plan->planClave . ".csv";


            $columns = [
                'CLAVE_ASIGNATURA',
                'CLAVE_ASIGNATURA_OPT',
                'ESCUELA',
                'PERIODO_LECTIVO',
                'TIPO_SOLICITUD',
                'ASIGNATURA',
                'MAESTRO',
                'CURSO',
                'GRUPO',
                'FECHA_EXAMEN',
                'HORA_EXAMEN'
            ];



            $file = fopen(base_path().'/temp/13_Sol_Extra/Pendientes/' . $fileName, 'w');



            fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $columns)) . PHP_EOL);


                foreach ($inscritosExtra as $key => $inscrito) {

                    $matClave = $inscrito->extraordinario->materia->matClave;
                    if ($inscrito->extraordinario->materia->matClaveEquivalente !== null) {
                        $matClave = $inscrito->extraordinario->materia->matClaveEquivalente;
                    }



                    $matClaveOpt = "";
                    $matNombreOptativa = "";
                    if ($inscrito->extraordinario->optativa_id > 0) {

                        $matNombreOptativa =  " - " . $inscrito->extraordinario->optativa->optNombre ;
                        $matClaveOpt       = $inscrito->extraordinario->optativa->optClaveEspecifica;

                    }


                    $nombreAsignatura =   $inscrito->extraordinario->materia->matNombre  . $matNombreOptativa;
                    $nombreAsignatura = $nombreAsignatura;

                    $sinodal_id = $inscrito->extraordinario->empleado_sinodal_id;
                    $maestro = ($sinodal_id && $sinodal_id > 0) ? $sinodal_id : $inscrito->extraordinario->empleado_id;
                    $clave_profesor = ClaveProfesor::deEmpleado($maestro)->deUbicacion($ubicacion->id)->first();



                    $curso = $inscrito->extraordinario->materia->matSemestre;
                


                    $fechaExamen = Carbon::parse($inscrito->extraordinario->extFecha)->format('d/m/Y');
                    $horaExamen = $inscrito->extraordinario->extHora;

                    $grupo = ($inscrito->extraordinario->extGrupo != null) ?
                        $inscrito->extraordinario->extGrupo
                    : "SIN";

                    $row_info = $matClave
                        . "," . $matClaveOpt
                        . "," . ""
                        . "," . ""
                        . "," . "RE"
                        . "," . str_replace(',',' ',$nombreAsignatura)
                        . "," . ($clave_profesor instanceof ClaveProfesor ? $clave_profesor->cpClaveSegey : "")
                        . "," . $curso
                        . "," . str_replace(',',' ',$grupo)
                        . "," .$fechaExamen
                        . "," .$horaExamen;

                    fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $row_info) . PHP_EOL);

                }

            fclose($file);
        }
    }



    public function _archivoInscripcion($request)
    {
        $grados = InscritoExtraordinario::with("extraordinario")
            ->whereHas('extraordinario.materia.plan', function($query) use ($request) {
                $query->where('planRegistro', $request->tipo_registro);
            })
            ->whereHas('extraordinario', function($query) use ($request) {
                $query->where("periodo_id", "=", $request->periodo_id);
            });
        // ->get();
        if (!is_null($request->oportunidad)) {
            $grados->where('extOportunidad_DentroDelPeriodo', $request->oportunidad);
        }
        $grados = $grados->get();




        $grados = $grados->unique(function ($item) {
            return $item->extraordinario->materia->plan->programa->progClave
                . "-" . $item->extraordinario->materia->plan->planClave;
        });





        foreach ($grados as $key => $value) {
            // $ordinarios = Grupo::with('plan.programa.escuela.departamento.ubicacion','empleado.persona','materia','empleado.persona')
            //     ->where('periodo_id', $request->input('periodo_id'))
            //     ->where('plan_id', $value->plan_id)
            // ->get()
            // ->sortBy('plan.programa.progClave');


            $inscritosExtra = InscritoExtraordinario::with("extraordinario.materia")
                ->whereHas('extraordinario.materia.plan', function($query) use ($request, $value) {
                    $query->where("id", "=", $value->extraordinario->materia->plan->id);
                    $query->where('planRegistro', $request->tipo_registro);
                })
                ->whereHas('extraordinario.periodo', function($query) use ($request, $value) {
                    $query->where("id", "=", $value->extraordinario->periodo_id);
                })
                ->where("iexEstado", "<>", "C");
            // ->get();
            if (!is_null($request->oportunidad)) {
                $inscritosExtra->where('extOportunidad_DentroDelPeriodo', $request->oportunidad);
            }
            $inscritosExtra = $inscritosExtra->get();




            // 1_sol_ext_$periodo_$año_Ene_$ubiClave_$progClave_$planClave.csv

            $fileName = "2_ins_ext_"
                . $value->extraordinario->periodo->perNumero
                . "_" . $value->extraordinario->periodo->perAnio
                . "_Ene_" . $value->extraordinario->materia->plan->programa->escuela->departamento->ubicacion->ubiClave
                . "_" . $value->extraordinario->materia->plan->programa->progClave
                . "_" . $value->extraordinario->materia->plan->planClave . ".csv";


            $columns = [
                'ClaveIES',
                'ClaveIESOpt',
                'Tipo_Examen',
                'Fecha_Examen',
                'Hora_Examen',
                'Grupo',
                'Matricula',
                'Derecho',
                'Observaciones',
                'Asignatura',
                'Turno',
                'Estado'
            ];



            $file = fopen(base_path().'/temp/14_Ins_Extra/Pendientes/' . $fileName, 'w');


            fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $columns)) . PHP_EOL);


                foreach ($inscritosExtra as $key => $inscrito) {

                    $matClave = $inscrito->extraordinario->materia->matClave;
                    if ($inscrito->extraordinario->materia->matClaveEquivalente !== null) {
                        $matClave = $inscrito->extraordinario->materia->matClaveEquivalente;
                    }



                    $matClaveOpt = "";
                    $matNombreOptativa = "";
                    if ($inscrito->extraordinario->optativa_id > 0) {

                        $matNombreOptativa =  " - " . $inscrito->extraordinario->optativa->optNombre ;
                        $matClaveOpt       = $inscrito->extraordinario->optativa->optClaveEspecifica;

                    }


                    $nombreAsignatura =   $inscrito->extraordinario->materia->matNombre  . $matNombreOptativa;
                    $nombreAsignatura = $nombreAsignatura;


                    $maestro = $inscrito->extraordinario->empleado_id;



                

                    $fechaExamen = Carbon::parse($inscrito->extraordinario->extFecha)->format('d/m/Y');
                    $horaExamen = $inscrito->extraordinario->extHora;

                    $grupo = ($inscrito->extraordinario->extGrupo != null) ?
                        $inscrito->extraordinario->extGrupo
                    : "SIN";


                    $matricula = $inscrito->alumno->aluMatricula;

                    $row_info = $matClave
                        . "," . $matClaveOpt
                        . "," . "RE"
                        . "," .$fechaExamen
                        . "," .$horaExamen
                        . "," . str_replace(',',' ',$grupo)
                        . "," . $matricula
                        . "," . "SI"
                        . "," . ""
                        . "," . str_replace(',',' ',$nombreAsignatura)
                        . "," . ""
                        . "," . "I";

                    fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $row_info) . PHP_EOL);

                }

            fclose($file);
        }
    }



    public function _archivoCalificacion($request)
    {
        $grados = InscritoExtraordinario::with("extraordinario.materia")
            ->whereHas('extraordinario.materia.plan', function($query) use ($request) {
                $query->where('planRegistro', $request->tipo_registro);
            })
            ->whereHas('extraordinario.materia', function($query) use ($request) {
                if ($request->tipo_acreditacion != 'T') {
                    $query->where('matTipoAcreditacion', $request->tipo_acreditacion);
                }
            })
            ->whereHas('extraordinario', function($query) use ($request) {
                $query->where("periodo_id", "=", $request->periodo_id);
            });
        // ->get();
        if (!is_null($request->oportunidad)) {
            $grados->where('extOportunidad_DentroDelPeriodo', $request->oportunidad);
        }
        $grados = $grados->get();





        $grados = $grados->unique(function ($item) {
            return $item->extraordinario->materia->plan->programa->progClave
                . "-" . $item->extraordinario->materia->plan->planClave;
        });





        foreach ($grados as $key => $value) {
            // $ordinarios = Grupo::with('plan.programa.escuela.departamento.ubicacion','empleado.persona','materia','empleado.persona')
            //     ->where('periodo_id', $request->input('periodo_id'))
            //     ->where('plan_id', $value->plan_id)
            // ->get()
            // ->sortBy('plan.programa.progClave');


            $inscritosExtra = InscritoExtraordinario::with("extraordinario.materia")
                ->whereHas('extraordinario.materia', function($query) use ($request) {
                    if ($request->tipo_acreditacion != 'T') {
                        $query->where('matTipoAcreditacion', $request->tipo_acreditacion);
                    }
                })
                ->whereHas('extraordinario.materia.plan', function($query) use ($request, $value) {
                    $query->where("id", "=", $value->extraordinario->materia->plan->id);
                    $query->where('planRegistro', $request->tipo_registro);
                })
                ->whereHas('extraordinario.periodo', function($query) use ($request, $value) {
                    $query->where("id", "=", $value->extraordinario->periodo_id);
                })
                ->where("iexEstado", "<>", "C");
            // ->get();
            if (!is_null($request->oportunidad)) {
                $inscritosExtra->where('extOportunidad_DentroDelPeriodo', $request->oportunidad);
            }
            $inscritosExtra = $inscritosExtra->get()
            ->sortBy("extraordinario.materia.matClave");




            // 1_sol_ext_$periodo_$año_Ene_$ubiClave_$progClave_$planClave.csv

            $fileName = "3_cal_ext_"
                . $value->extraordinario->periodo->perNumero
                . "_" . $value->extraordinario->periodo->perAnio
                . "_Ene_" . $value->extraordinario->materia->plan->programa->escuela->departamento->ubicacion->ubiClave
                . "_" . $value->extraordinario->materia->plan->programa->progClave
                . "_" . $value->extraordinario->materia->plan->planClave . ".csv";


            $columns = [
                'CLAVE_ASIGNATURA',
                'TIPO_SOLICITUD',
                'ASIGNATURA',
                'GRUPO',
                'MATRICULA',
                'ALUMNO',
                'CALIFICACION',
                'FECHA',
                'HORA',
            ];



            $file = fopen(base_path().'/temp/15_Cal_Extra/Pendientes/' . $fileName, 'w');
            fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $columns)) . PHP_EOL);



                foreach ($inscritosExtra as $key => $inscrito) {

                    $matClave = $inscrito->extraordinario->materia->matClave;
                    if ($inscrito->extraordinario->materia->matClaveEquivalente !== null) {
                        $matClave = $inscrito->extraordinario->materia->matClaveEquivalente;
                    }



                    $matNombreOptativa = "";
                    if ($inscrito->extraordinario->optativa_id > 0) {

                        $matNombreOptativa =  " - " . $inscrito->extraordinario->optativa->optNombre ;
                        $matClave = $inscrito->extraordinario->optativa->optClaveEspecifica;

                    }


                    $nombreAsignatura =   $inscrito->extraordinario->materia->matNombre  . $matNombreOptativa;
                    $nombreAsignatura = $nombreAsignatura;


                    $maestro = $inscrito->extraordinario->empleado_id;


                

                    $fechaExamen = Carbon::parse($inscrito->extraordinario->extFecha)->format('d/m/Y');
                    $horaExamen = $inscrito->extraordinario->extHora;

                    $grupo = ($inscrito->extraordinario->extGrupo != null) ?
                        $inscrito->extraordinario->extGrupo
                    : "SIN";


                    $matricula = $inscrito->alumno->aluMatricula;
                    $alumno = $inscrito->alumno->persona->perApellido1
                        . " " . $inscrito->alumno->persona->perApellido2
                        . " " . $inscrito->alumno->persona->perNombre;

                    $calificacion = $inscrito->iexCalificacion;

                    if ($calificacion < 0) {
                        $calificacion = 0;
                    }

                    $row_info = $matClave
                        . "," . "RE"
                        . "," . str_replace(',',' ',$nombreAsignatura)
                        . "," . str_replace(',',' ',$grupo)
                        . "," . $matricula
                        . "," . $alumno
                        . "," .$calificacion
                        . "," .$fechaExamen
                        . "," .$horaExamen;
                        
                    fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $row_info) . PHP_EOL);

                }

            fclose($file);
        }
    }




    
    public function descargar (Request $request)
    {
        if ($request->tipo == "S") {
            $this->_archivoSolicitud($request);
        }

        if ($request->tipo == "I") {
            $this->_archivoInscripcion($request);
        }

        if ($request->tipo == "C") {
            $this->_archivoCalificacion($request);
        }

        return redirect()->back()->withInput();
    }




    // public function descargar_old(Request $request){
    //     $ubicaciones = Ubicacion::all();
    //     $tipos = array(
    //         'S' => 'olicitud',
    //         'I' => 'nscripción',
    //         'C' => 'alificación',
    //     );

    //     if($request->input('tipo') == "S"){//SOLICITUD
    //         $ordinarios = Grupo::with('plan.programa.escuela.departamento.ubicacion','empleado.persona','materia','empleado.persona')
    //         ->where('periodo_id', $request->input('periodo_id'))
    //         ->when($request->input('escuela_id') != '', function($query) use($request){
    //             return $query->whereHas('plan.programa', function($query) use($request){
    //                 $query->where('escuela_id', $request->input('escuela_id'));
    //             });
    //         })
    //         ->get()->sortBy('plan.programa.progClave');
    //     }else{//INSCRIPCIÓN Y CALIFICACIÓN
    //         $ordinarios = Inscrito::with('grupo.plan.programa.escuela.departamento.ubicacion','curso.cgt.periodo','curso.cgt.plan.programa','curso.alumno')
    //         ->whereHas('grupo', function($query) use($request){
    //             $query->where('periodo_id', $request->input('periodo_id'));
    //         })
    //         ->when($request->input('escuela_id') != '', function($query) use($request){
    //             return $query->whereHas('grupo.plan.programa', function($query) use($request){
    //                 $query->where('escuela_id', $request->input('escuela_id'));
    //             });
    //         })
    //         ->get()->sortBy('grupo.plan.programa.progClave');
    //     }

    //     $progClave = "";
    //     $progClaveBD = "";
    //     foreach($ordinarios as $ordinario) {
    //         if($progClave == ""){

    //             if($request->input('tipo') == "S"){//SOLICITUD
    //                 $fileName = "sol_ord_".$ordinario->periodo->perNumero."_".$ordinario->periodo->perAnio."_". $ordinario->plan->programa->escuela->departamento->ubicacion->ubiClave."_".$ordinario->plan->programa->progClave."_".$ordinario->plan->planClave.".csv";

    //                 if($ordinario->plan->programa->escuela->departamento->depClave == "SUP"){
    //                     $file = fopen(base_path().'/temp/07_Sol_Ord_Sup/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else if($ordinario->plan->programa->escuela->departamento->depClave == "POS"){
    //                     $file = fopen(base_path().'/temp/09_Sol_Ord_Pos/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else{
    //                     $file = fopen(base_path().'/temp/'.$fileName, 'w');
    //                 }
    //                 $columns = array('CLAVE_ASIGNATURA','ESCUELA', 'PERIODO_LECTIVO','TIPO_SOLICITUD','ASIGNATURA','MAESTRO','GRUPO','TURNO','FECHA_EXAMEN','HORA_EXAMEN');
    //                 fputcsv($file, $columns);

    //                 $gpoTurno = ($ordinario->gpoTurno  ? $ordinario->gpoTurno : '');
    //                 $fecha_examen = ($ordinario->gpoFechaExamenOrdinario  ? $ordinario->gpoFechaExamenOrdinario : '');
    //                 $hora_examen = ($ordinario->gpoHoraExamenOrdinario  ? $ordinario->gpoHoraExamenOrdinario : '');
    //                 fputcsv($file, array($ordinario->materia->matClave,"","","OR",$ordinario->materia->matNombre,$ordinario->empleado->persona->perApellido1." ".$ordinario->empleado->persona->perApellido2." ".$ordinario->empleado->persona->perNombre,$ordinario->gpoClave,$gpoTurno,$fecha_examen,$hora_examen));

    //                 $progClaveBD = $ordinario->plan->programa->progClave;
    //             }else if($request->input('tipo') == "I"){//INSCRIPCIÓN
    //                 $fileName = "ins_ord_".$ordinario->grupo->periodo->perNumero."_".$ordinario->grupo->periodo->perAnio."_". $ordinario->grupo->plan->programa->escuela->departamento->ubicacion->ubiClave."_".$ordinario->grupo->plan->programa->progClave."_".$ordinario->grupo->plan->planClave.".csv";

    //                 if($ordinario->grupo->plan->programa->escuela->departamento->depClave == "SUP"){
    //                     $file = fopen(base_path().'/temp/08_Ins_Ord_Sup/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else if($ordinario->grupo->plan->programa->escuela->departamento->depClave == "POS"){
    //                     $file = fopen(base_path().'/temp/10_Ins_Ord_Pos/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else{
    //                     $file = fopen(base_path().'/temp/'.$fileName, 'w');
    //                 }
    //                 $columns = array('CLAVE_ASIGNATURA','ESCUELA', 'PERIODO_LECTIVO','TIPO_SOLICITUD','ASIGNATURA','MAESTRO','GRUPO','TURNO','FECHA_EXAMEN','HORA_EXAMEN');
    //                 fputcsv($file, $columns);

    //                 $gpoTurno = ($ordinario->grupo->gpoTurno  ? $ordinario->grupo->gpoTurno : '');
    //                 $fecha_examen = ($ordinario->grupo->gpoFechaExamenOrdinario  ? $ordinario->grupo->gpoFechaExamenOrdinario : '');
    //                 $hora_examen = ($ordinario->grupo->gpoHoraExamenOrdinario  ? $ordinario->grupo->gpoHoraExamenOrdinario : '');
    //                 fputcsv($file, array($ordinario->grupo->materia->matClave,"","","OR",$ordinario->grupo->materia->matNombre,$ordinario->grupo->empleado->persona->perApellido1." ".$ordinario->grupo->empleado->persona->perApellido2." ".$ordinario->grupo->empleado->persona->perNombre,$ordinario->grupo->gpoClave,$gpoTurno,$fecha_examen,$hora_examen));

    //                 $progClaveBD = $ordinario->grupo->plan->programa->progClave;
    //             }else{//CALIFICACIÓN
    //                 $fileName = "cal_ord_".$ordinario->grupo->periodo->perNumero."_".$ordinario->grupo->periodo->perAnio."_". $ordinario->grupo->plan->programa->escuela->departamento->ubicacion->ubiClave."_".$ordinario->grupo->plan->programa->progClave."_".$ordinario->grupo->plan->planClave.".csv";

    //                 if($ordinario->grupo->plan->programa->escuela->departamento->depClave == "SUP"){
    //                     $file = fopen(base_path().'/temp/11_Cal_Ord_Sup/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else if($ordinario->grupo->plan->programa->escuela->departamento->depClave == "POS"){
    //                     $file = fopen(base_path().'/temp/12_Cal_Ord_Pos/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else{
    //                     $file = fopen(base_path().'/temp/'.$fileName, 'w');
    //                 }

    //                 $columns = array('CLAVE_ASIGNATURA','ESCUELA', 'PERIODO_LECTIVO','TIPO_SOLICITUD','ASIGNATURA','MAESTRO','GRUPO','TURNO','FECHA_EXAMEN','HORA_EXAMEN');
    //                 fputcsv($file, $columns);

    //                 $gpoTurno = ($ordinario->grupo->gpoTurno  ? $ordinario->grupo->gpoTurno : '');
    //                 $fecha_examen = ($ordinario->grupo->gpoFechaExamenOrdinario  ? $ordinario->grupo->gpoFechaExamenOrdinario : '');
    //                 $hora_examen = ($ordinario->grupo->gpoHoraExamenOrdinario  ? $ordinario->grupo->gpoHoraExamenOrdinario : '');
    //                 fputcsv($file, array($ordinario->grupo->materia->matClave,"","","OR",$ordinario->grupo->materia->matNombre,$ordinario->grupo->empleado->persona->perApellido1." ".$ordinario->grupo->empleado->persona->perApellido2." ".$ordinario->grupo->empleado->persona->perNombre,$ordinario->grupo->gpoClave,$gpoTurno,$fecha_examen,$hora_examen));

    //                 $progClaveBD = $ordinario->grupo->plan->programa->progClave;
    //             }
    //             $progClave = $progClaveBD;
    //         }
    //         if($request->input('tipo') == "S"){//SOLICITUD
    //             $progClaveBD = $ordinario->plan->programa->progClave;
    //         }else{
    //             $progClaveBD = $ordinario->grupo->plan->programa->progClave;
    //         }
    //         if($progClave != $progClaveBD){

    //             fclose($file);
    //             $progClave = $progClaveBD;

    //             if($request->input('tipo') == "S"){//SOLICITUD
    //                 $fileName = "sol_ord_".$ordinario->periodo->perNumero."_".$ordinario->periodo->perAnio."_". $ordinario->plan->programa->escuela->departamento->ubicacion->ubiClave."_".$ordinario->plan->programa->progClave."_".$ordinario->plan->planClave.".csv";

    //                 if($ordinario->plan->programa->escuela->departamento->depClave == "SUP"){
    //                     $file = fopen(base_path().'/temp/07_Sol_Ord_Sup/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else if($ordinario->plan->programa->escuela->departamento->depClave == "POS"){
    //                     $file = fopen(base_path().'/temp/09_Sol_Ord_Pos/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else{
    //                     $file = fopen(base_path().'/temp/'.$fileName, 'w');
    //                 }
    //             }else if($request->input('tipo') == "I"){//INSCRIPCIÓN
    //                 $fileName = "ins_ord_".$ordinario->grupo->periodo->perNumero."_".$ordinario->grupo->periodo->perAnio."_". $ordinario->grupo->plan->programa->escuela->departamento->ubicacion->ubiClave."_".$ordinario->grupo->plan->programa->progClave."_".$ordinario->grupo->plan->planClave.".csv";

    //                 if($ordinario->grupo->plan->programa->escuela->departamento->depClave == "SUP"){
    //                     $file = fopen(base_path().'/temp/08_Ins_Ord_Sup/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else if($ordinario->grupo->plan->programa->escuela->departamento->depClave == "POS"){
    //                     $file = fopen(base_path().'/temp/10_Ins_Ord_Pos/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else{
    //                     $file = fopen(base_path().'/temp/'.$fileName, 'w');
    //                 }
    //             }else{//CALIFICACIÓN
    //                 $fileName = "cal_ord_".$ordinario->grupo->periodo->perNumero."_".$ordinario->grupo->periodo->perAnio."_". $ordinario->grupo->plan->programa->escuela->departamento->ubicacion->ubiClave."_".$ordinario->grupo->plan->programa->progClave."_".$ordinario->grupo->plan->planClave.".csv";

    //                 if($ordinario->grupo->plan->programa->escuela->departamento->depClave == "SUP"){
    //                     $file = fopen(base_path().'/temp/11_Cal_Ord_Sup/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else if($ordinario->grupo->plan->programa->escuela->departamento->depClave == "POS"){
    //                     $file = fopen(base_path().'/temp/12_Cal_Ord_Pos/Pendientes/'.$fileName, 'w');
    //                 }
    //                 else{
    //                     $file = fopen(base_path().'/temp/'.$fileName, 'w');
    //                 }
    //             }

    //             $columns = array('CLAVE_ASIGNATURA','ESCUELA', 'PERIODO_LECTIVO','TIPO_SOLICITUD','ASIGNATURA','MAESTRO','GRUPO','TURNO','FECHA_EXAMEN','HORA_EXAMEN');
    //             fputcsv($file, $columns);
    //         }else{
    //             if($request->input('tipo') == "S"){//SOLICITUD
    //                 $gpoTurno = ($ordinario->gpoTurno  ? $ordinario->gpoTurno : '');
    //                 $fecha_examen = ($ordinario->gpoFechaExamenOrdinario  ? $ordinario->gpoFechaExamenOrdinario : '');
    //                 $hora_examen = ($ordinario->gpoHoraExamenOrdinario  ? $ordinario->gpoHoraExamenOrdinario : '');
    //                 fputcsv($file, array($ordinario->materia->matClave,"","","OR",$ordinario->materia->matNombre,$ordinario->empleado->persona->perApellido1." ".$ordinario->empleado->persona->perApellido2." ".$ordinario->empleado->persona->perNombre,$ordinario->gpoClave,$gpoTurno,$fecha_examen,$hora_examen));
    //             }else{
    //                 $gpoTurno = ($ordinario->grupo->gpoTurno  ? $ordinario->grupo->gpoTurno : '');
    //                 $fecha_examen = ($ordinario->grupo->gpoFechaExamenOrdinario  ? $ordinario->grupo->gpoFechaExamenOrdinario : '');
    //                 $hora_examen = ($ordinario->grupo->gpoHoraExamenOrdinario  ? $ordinario->grupo->gpoHoraExamenOrdinario : '');
    //                 fputcsv($file, array($ordinario->grupo->materia->matClave,"","","OR",$ordinario->grupo->materia->matNombre,$ordinario->grupo->empleado->persona->perApellido1." ".$ordinario->grupo->empleado->persona->perApellido2." ".$ordinario->grupo->empleado->persona->perNombre,$ordinario->grupo->gpoClave,$gpoTurno,$fecha_examen,$hora_examen));
    //             }
    //         }
    //     }
    //     return View('archivo/extraordinario.create',compact('ubicaciones','tipos'));
    // }
}