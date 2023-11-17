<?php

namespace App\Http\Controllers\Reportes;

use DB;
use Auth;
use Carbon\Carbon;
use App\Http\Models\Cgt;
use App\Http\Models\Pago;
use App\Http\Models\Grupo;
use App\Http\Helpers\Utils;
use App\Http\Models\Periodo;
use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\AcreditacionesExport;
use Yajra\DataTables\Facades\DataTables;

class AcreditacionesController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    //obtener año actual para el filtro que genera el reporte del año de periodo
    $anioActual = Carbon::now();
    $ubicacion = Ubicacion::where('ubiClave','<>','000')->get();
    return View('reportes/acreditaciones.create',compact('anioActual','ubicacion'));
  }

  public function datosParciales($request, $tipoParcial)
  {
    // dd($request->all());
    $cgt = Cgt::find($request->cgt_id);
    $periodo = Periodo::find($cgt->periodo_id);

    $procDesAcaGrupos      = DB::select("call procDesAcaGrupos(".$request->cgt_id.")");
    $procDesAcaAlumnos     = DB::select("call procDesAcaAlumnos(".$request->cgt_id.")");
    $procDesAcaParcialProm = DB::select("call procDesAcaParcialProm(".$request->cgt_id. "," . $tipoParcial . ")");
    $procDesAcaTotal       = DB::select("call procDesAcaTotal(" . $request->cgt_id . "," . $tipoParcial . ")");


    $datos = collect();

    $datos->push([
      'row'=>''
    ]);

    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'ANÁLISIS DE DESEMPEÑO ACADÉMICO',
    ]);
   
    // procDesAcaAlumnos
    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>$cgt->cgtGradoSemestre.'º'.$cgt->cgtGrupo.' PRIMER PARCIAL '.
      'CURSO ESCOLAR '.Carbon::parse($periodo->perFechaInicial)->format('Y').'-'.Carbon::parse($periodo->perFechaFinal)->format('Y').
      ' SEMESTRE '.ucwords(Utils::num_meses_string(Carbon::parse($periodo->perFechaInicial)->format('m'))).' - '.
      ucwords(Utils::num_meses_string(Carbon::parse($periodo->perFechaInicial)->format('m'))).' '.$periodo->perAnio,
    ]);
    //Proceso para manejar procDesAcaTotales



    $calificacionesPorGrupo = collect();
    for ($i=0;$i < count($procDesAcaGrupos); $i++) {
      $procDesAcaParciales = DB::select("call procDesAcaParciales(".$request->cgt_id . "," . $procDesAcaGrupos[$i]->id . "," . $tipoParcial . ")");

      // dd($procDesAcaGrupos[$i]);
      $calificacionesPorGrupo->push((Object) [
        "grupo" => $procDesAcaGrupos[$i],
        "calificaciones" => $procDesAcaParciales
      ]);
    }


    $miArray = [];


    $numColumna2 = 1;

    $miArray["columna".$numColumna2] = "";
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "";
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "";
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "";
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "";


    for ($j=0;$j < count($calificacionesPorGrupo); $j++) {
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = $calificacionesPorGrupo[$j]->grupo->matClave;
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "CALIFICACIÓN";
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "FALTAS";
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "PROMEDIO ACUMULADO";
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "FALTAS ACUMULADAS";
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "";
    }
    $miArray["columna".$numColumna2] = '';
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = 'FALTAS';
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = 'NO APROBADAS';
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "PROM. FINAL";
    $numColumna2 = $numColumna2+1;

    $datos->push($miArray);




    for ($i=0;$i < count($procDesAcaAlumnos); $i++) {
      $numColumna = 1;


      $miArray["columna".$numColumna] = "";
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = "";
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaAlumnos[$i]->nombre;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaAlumnos[$i]->aluClave;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = "";


      for ($j=0;$j < count($calificacionesPorGrupo); $j++) {

        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = "";
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = $calificacionesPorGrupo[$j]->calificaciones[$i]->calificacion;
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = $calificacionesPorGrupo[$j]->calificaciones[$i]->faltas;
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = $calificacionesPorGrupo[$j]->calificaciones[$i]->promedioAcumulado;
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = $calificacionesPorGrupo[$j]->calificaciones[$i]->faltasAcumuladas;
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = "";
      }
      
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaParcialProm[$i]->faltas;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaParcialProm[$i]->noAprobadas;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaParcialProm[$i]->promedio;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = "";
      $datos->push($miArray);

    }//Fin for procDesAcaTotales


    $miArray = [];
    $numColumna = 1;
    for ($i=0;$i < count($calificacionesPorGrupo); $i++) {

    }
    $datos->push($miArray);



    //Se puso un máximo de 20 materias pero se pueden agregar más copiando código

    $datos->push([
      'row'=>''
    ]);


    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'DATOS POR ASIGNATURAS'
    ]);

    $colDatosAsignatura = 1;
    $arrDatosAsignatura = collect();




    $materias = [];
    $numInscritos = [];
    $faltas = [];
    $promedioFaltas = [];
    $promedioCalificacion = [];
    $porcentajeAprobados = [];
    $promedioAprobacion = [];
    $promedioReprobacion = [];
    $numColumna = 1;

    $materias["columna".$numColumna]             = "";
    $numInscritos["columna".$numColumna]         = "";
    $faltas["columna".$numColumna]               = "";
    $promedioFaltas["columna".$numColumna]       = "";
    $promedioCalificacion["columna".$numColumna] = "";
    $porcentajeAprobados["columna".$numColumna]  = "";
    $promedioAprobacion["columna".$numColumna]   = "";
    $promedioReprobacion["columna".$numColumna]  = "";
    $numColumna = $numColumna + 1;

    $materias["columna".$numColumna]             = "";
    $numInscritos["columna".$numColumna]         = "";
    $faltas["columna".$numColumna]               = "";
    $promedioFaltas["columna".$numColumna]       = "";
    $promedioCalificacion["columna".$numColumna] = "";
    $porcentajeAprobados["columna".$numColumna]  = "";
    $promedioAprobacion["columna".$numColumna]   = "";
    $promedioReprobacion["columna".$numColumna]  = "";
    $numColumna = $numColumna + 1;

    $materias["columna".$numColumna]             = "";
    $numInscritos["columna".$numColumna]         = "ALUMNOS EN LISTA";
    $faltas["columna".$numColumna]               = "FALTAS";
    $promedioFaltas["columna".$numColumna]       = "PROM. DE FALTAS X ALUMNO X ASIGNATURA";
    $promedioCalificacion["columna".$numColumna] = "PROMEDIO";
    $porcentajeAprobados["columna".$numColumna]  = "PORCENTAJE DE APROBACIÓN";
    $promedioAprobacion["columna".$numColumna]   = "PROMEDIO APROBATORIO";
    $promedioReprobacion["columna".$numColumna]  = "PROMEDIO REPROBATORIO";
    $numColumna = $numColumna + 1;

    $materias["columna".$numColumna]             = "";
    $numInscritos["columna".$numColumna]         = "";
    $faltas["columna".$numColumna]               = "";
    $promedioFaltas["columna".$numColumna]       = "";
    $promedioCalificacion["columna".$numColumna] = "";
    $porcentajeAprobados["columna".$numColumna]  = "";
    $promedioAprobacion["columna".$numColumna]   = "";
    $promedioReprobacion["columna".$numColumna]  = "";
    $numColumna = $numColumna + 1;
    
    $materias["columna".$numColumna]             = "";
    $numInscritos["columna".$numColumna]         = "";
    $faltas["columna".$numColumna]               = "";
    $promedioFaltas["columna".$numColumna]       = "";
    $promedioCalificacion["columna".$numColumna] = "";
    $porcentajeAprobados["columna".$numColumna]  = "";
    $promedioAprobacion["columna".$numColumna]   = "";
    $promedioReprobacion["columna".$numColumna]  = "";
    $numColumna = $numColumna + 1;

    for($i=0;$i < count($procDesAcaGrupos);$i++) {
      $procDesAcaTotalGrupo = DB::select("call procDesAcaTotalGrupo(".$request->cgt_id . "," . $procDesAcaGrupos[$i]->id . "," . $tipoParcial . ")");
      $info = collect($procDesAcaTotalGrupo)->first();

      $materias["columna".$numColumna]             = $procDesAcaGrupos[$i]->matClave . " - " . $procDesAcaGrupos[$i]->matNombre;
      $numInscritos["columna".$numColumna]         = $info->numeroInscritos;
      $faltas["columna".$numColumna]               = $info->faltas;
      $promedioFaltas["columna".$numColumna]       = $info->promedioFaltas;
      $promedioCalificacion["columna".$numColumna] = $info->promedioCalificacion;
      $porcentajeAprobados["columna".$numColumna]  = $info->porcentajeAprobados;
      $promedioAprobacion["columna".$numColumna]   = $info->promedioAprobacion;
   
      $numColumna = $numColumna + 1;

      $materias["columna".$numColumna]             = "";
      $numInscritos["columna".$numColumna]         = "";
      $faltas["columna".$numColumna]               = "";
      $promedioFaltas["columna".$numColumna]       = "";
      $promedioCalificacion["columna".$numColumna] = "";
      $porcentajeAprobados["columna".$numColumna]  = "";
      $promedioAprobacion["columna".$numColumna]   = "";
      $promedioReprobacion["columna".$numColumna]  = "";
      $numColumna = $numColumna + 1;

      $materias["columna".$numColumna]             = "";
      $numInscritos["columna".$numColumna]         = "";
      $faltas["columna".$numColumna]               = "";
      $promedioFaltas["columna".$numColumna]       = "";
      $promedioCalificacion["columna".$numColumna] = "";
      $porcentajeAprobados["columna".$numColumna]  = "";
      $promedioAprobacion["columna".$numColumna]   = "";
      $promedioReprobacion["columna".$numColumna]  = "";
      $numColumna = $numColumna + 1;

      
      $materias["columna".$numColumna]             = "";
      $numInscritos["columna".$numColumna]         = "";
      $faltas["columna".$numColumna]               = "";
      $promedioFaltas["columna".$numColumna]       = "";
      $promedioCalificacion["columna".$numColumna] = "";
      $porcentajeAprobados["columna".$numColumna]  = "";
      $promedioAprobacion["columna".$numColumna]   = "";
      $promedioReprobacion["columna".$numColumna]  = "";
      $numColumna = $numColumna + 1;

      
      $materias["columna".$numColumna]             = "";
      $numInscritos["columna".$numColumna]         = "";
      $faltas["columna".$numColumna]               = "";
      $promedioFaltas["columna".$numColumna]       = "";
      $promedioCalificacion["columna".$numColumna] = "";
      $porcentajeAprobados["columna".$numColumna]  = "";
      $promedioAprobacion["columna".$numColumna]   = "";
      $promedioReprobacion["columna".$numColumna]  = "";
      $numColumna = $numColumna + 1;
      
      $materias["columna".$numColumna]             = "";
      $numInscritos["columna".$numColumna]         = "";
      $faltas["columna".$numColumna]               = "";
      $promedioFaltas["columna".$numColumna]       = "";
      $promedioCalificacion["columna".$numColumna] = "";
      $porcentajeAprobados["columna".$numColumna]  = "";
      $promedioAprobacion["columna".$numColumna]   = "";
      $promedioReprobacion["columna".$numColumna]  = "";
      $numColumna = $numColumna + 1;
    }

    $datos->push($materias);
    $datos->push($numInscritos);
    $datos->push($faltas);
    $datos->push($promedioFaltas);
    $datos->push($promedioCalificacion);
    $datos->push($porcentajeAprobados);
    $datos->push($promedioAprobacion);
    $datos->push($promedioReprobacion);



    $datos->push([]);
    $datos->push([]);
    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'DATOS POR GRUPO'
    ]);

    
    $procDesAcaTotalCollect = collect($procDesAcaTotal)->first();

    $datosPorGrupo = [];
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "TOTAL DE FALTAS DEL GRUPO";//
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->faltas;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO GENERAL DE FALTAS POR ALUMNO";//
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->promedioFaltas;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO GENERAL DEL GRUPO";//
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->promedioCalificacion;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PORCENTAJE GENERAL DE APROBACIÓN DEL GRUPO";//
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->porcentajeAprobados;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO APROBATORIO GENERAL";
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->promedioAprobacion;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO REPROBATORIO GENERAL";
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->promedioReprobacion;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO DE MATERIAS REPROBADAS POR ALUMNO";
    $datosPorGrupo["columna4"] = "";
    $datos->push($datosPorGrupo);


    // dd($datosPorGrupo);



    $datos->push([]);
    $datos->push([]);
    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'ASIGNATURAS'
    ]);

    for($i=0;$i < count($procDesAcaGrupos);$i++){
      $matClave = $procDesAcaGrupos[$i]->matClave;
      $matNombre = $procDesAcaGrupos[$i]->matNombre;
 
      $datos->push([
        'columnaA'=>'',
        'columnaB'=>'',
        'columnaC'=>$matClave.'-'.$matNombre
      ]);
    }   

    $datos->push([]);
    $datos->push([]);
    
    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'DOCENTES'
    ]);

    for($i=0;$i < count($procDesAcaGrupos);$i++){
      $matClave = $procDesAcaGrupos[$i]->matClave;
      $empleado = $procDesAcaGrupos[$i]->empleado;
     
      $datos->push([
        'columnaA'=>'',
        'columnaB'=>'',
        'columnaC'=>$matClave.'-'.$empleado
      ]);
    }  

    $datosParcial1 = $datos;


    return $datosParcial1;
  }


  public function datosOrdinario(Request $request)
  {
    //ORDINARIO
    $tipoParcial = "4";

    $cgt = Cgt::find($request->cgt_id);
    $periodo = Periodo::find($cgt->periodo_id);

    $procDesAcaGrupos      = DB::select("call procDesAcaGrupos(".$request->cgt_id.")");
    $procDesAcaAlumnos     = DB::select("call procDesAcaAlumnos(".$request->cgt_id.")");
    $procDesAcaParcialProm = DB::select("call procDesAcaParcialProm(".$request->cgt_id. "," . $tipoParcial . ")");
    $procDesAcaTotal       = DB::select("call procDesAcaTotal(" . $request->cgt_id . "," . $tipoParcial . ")");



    $datos = collect();

    $datos->push([
      'row'=>''
    ]);

    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'ANÁLISIS DE DESEMPEÑO ACADÉMICO',
    ]);
   
    // procDesAcaAlumnos
    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>$cgt->cgtGradoSemestre.'º'.$cgt->cgtGrupo.' PRIMER PARCIAL '.
      'CURSO ESCOLAR '.Carbon::parse($periodo->perFechaInicial)->format('Y').'-'.Carbon::parse($periodo->perFechaFinal)->format('Y').
      ' SEMESTRE '.ucwords(Utils::num_meses_string(Carbon::parse($periodo->perFechaInicial)->format('m'))).' - '.
      ucwords(Utils::num_meses_string(Carbon::parse($periodo->perFechaInicial)->format('m'))).' '.$periodo->perAnio,
    ]);
    //Proceso para manejar procDesAcaTotales



    $calificacionesPorGrupo = collect();
    for ($i=0;$i < count($procDesAcaGrupos); $i++) {
      $procDesAcaParciales = DB::select("call procDesAcaParciales(".$request->cgt_id . "," . $procDesAcaGrupos[$i]->id . "," . $tipoParcial . ")");

      // dd($procDesAcaGrupos[$i]);
      $calificacionesPorGrupo->push((Object) [
        "grupo" => $procDesAcaGrupos[$i],
        "calificaciones" => $procDesAcaParciales
      ]);
    }


    $miArray = [];


    $numColumna2 = 1;

    $miArray["columna".$numColumna2] = "";
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "";
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "";
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "";
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "";


    for ($j=0;$j < count($calificacionesPorGrupo); $j++) {
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = $calificacionesPorGrupo[$j]->grupo->matClave;

      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "FALTAS";
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "PROMEDIO ACUMULADO";
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "EXAMEN";
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "CALIFICACIÓN FINAL";
      $numColumna2 = $numColumna2+1;
      $miArray["columna".$numColumna2] = "";
    }
    $miArray["columna".$numColumna2] = '';
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = 'FALTAS';
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = 'NO APROBADAS';
    $numColumna2 = $numColumna2+1;
    $miArray["columna".$numColumna2] = "PROM. FINAL";
    $numColumna2 = $numColumna2+1;

    $datos->push($miArray);




    for ($i=0;$i < count($procDesAcaAlumnos); $i++) {
      $numColumna = 1;


      $miArray["columna".$numColumna] = "";
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = "";
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaAlumnos[$i]->nombre;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaAlumnos[$i]->aluClave;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = "";


      for ($j=0;$j < count($calificacionesPorGrupo); $j++) {

        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = "";

        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = $calificacionesPorGrupo[$j]->calificaciones[$i]->faltas;
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = $calificacionesPorGrupo[$j]->calificaciones[$i]->promedioAcumulado;
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = $calificacionesPorGrupo[$j]->calificaciones[$i]->calificacionFinal;
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = $calificacionesPorGrupo[$j]->calificaciones[$i]->calificacion;
        $numColumna = $numColumna+1;
        $miArray["columna".$numColumna] = "";
      }
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaParcialProm[$i]->faltas;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaParcialProm[$i]->noAprobadas;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = $procDesAcaParcialProm[$i]->promedio;
      $numColumna = $numColumna+1;
      $miArray["columna".$numColumna] = "";
      $datos->push($miArray);

    }//Fin for procDesAcaTotales


    $miArray = [];
    $numColumna = 1;
    for ($i=0;$i < count($calificacionesPorGrupo); $i++) {

    }
    $datos->push($miArray);



    //Se puso un máximo de 20 materias pero se pueden agregar más copiando código

    $datos->push([
      'row'=>''
    ]);


    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'DATOS POR ASIGNATURAS'
    ]);

    $colDatosAsignatura = 1;
    $arrDatosAsignatura = collect();




    $materias = [];
    $numInscritos = [];
    $faltas = [];
    $promedioFaltas = [];
    $promedioCalificacion = [];
    $porcentajeAprobados = [];
    $promedioAprobacion = [];
    $promedioReprobacion = [];
    $numColumna = 1;

    $materias["columna".$numColumna]             = "";
    $numInscritos["columna".$numColumna]         = "";
    $faltas["columna".$numColumna]               = "";
    $promedioFaltas["columna".$numColumna]       = "";
    $promedioCalificacion["columna".$numColumna] = "";
    $porcentajeAprobados["columna".$numColumna]  = "";
    $promedioAprobacion["columna".$numColumna]   = "";
    $promedioReprobacion["columna".$numColumna]  = "";
    $numColumna = $numColumna + 1;

    $materias["columna".$numColumna]             = "";
    $numInscritos["columna".$numColumna]         = "";
    $faltas["columna".$numColumna]               = "";
    $promedioFaltas["columna".$numColumna]       = "";
    $promedioCalificacion["columna".$numColumna] = "";
    $porcentajeAprobados["columna".$numColumna]  = "";
    $promedioAprobacion["columna".$numColumna]   = "";
    $promedioReprobacion["columna".$numColumna]  = "";
    $numColumna = $numColumna + 1;

    $materias["columna".$numColumna]             = "";
    $numInscritos["columna".$numColumna]         = "ALUMNOS EN LISTA";
    $faltas["columna".$numColumna]               = "FALTAS";
    $promedioFaltas["columna".$numColumna]       = "PROM. DE FALTAS X ALUMNO X ASIGNATURA";
    $promedioCalificacion["columna".$numColumna] = "PROMEDIO (SOLO ORDINARIO)";
    $promedioCalificacion["columna".$numColumna] = "PROMEDIO (CALIF. FINAL)";
    $porcentajeAprobados["columna".$numColumna]  = "PORCENTAJE DE APROBACIÓN";
    $promedioAprobacion["columna".$numColumna]   = "PROMEDIO APROBATORIO";
    $promedioReprobacion["columna".$numColumna]  = "PROMEDIO REPROBATORIO";
    $promedioReprobacion["columna".$numColumna]  = "ALUMNOS CON CALIFICACIÒN DE 35 O MENOR";
    $numColumna = $numColumna + 1;

    for($i=0;$i < count($procDesAcaGrupos);$i++) {
      $procDesAcaTotalGrupo = DB::select("call procDesAcaTotalGrupo(".$request->cgt_id . "," . $procDesAcaGrupos[$i]->id . "," . $tipoParcial . ")");
      $info = collect($procDesAcaTotalGrupo)->first();


      $materias["columna".$numColumna]             = $procDesAcaGrupos[$i]->matClave . " - " . $procDesAcaGrupos[$i]->matNombre;
      $numInscritos["columna".$numColumna]         = $info->numeroInscritos;
      $faltas["columna".$numColumna]               = $info->faltas;
      $promedioFaltas["columna".$numColumna]       = $info->promedioFaltas;
      $promedioCalificacion["columna".$numColumna] = $info->promedioOrdinario;
      $promedioCalificacion["columna".$numColumna] = $info->promedioCalificacion;
      $porcentajeAprobados["columna".$numColumna]  = $info->porcentajeAprobados;
      $promedioAprobacion["columna".$numColumna]   = $info->promedioAprobacion;
      $promedioReprobacion["columna".$numColumna]  = $info->promedioReprobacion;
      $promedioReprobacion["columna".$numColumna]  = $info->totalReprobados35;
      
      $numColumna = $numColumna + 1;
    }

    $datos->push($materias);
    $datos->push($numInscritos);
    $datos->push($faltas);
    $datos->push($promedioFaltas);
    $datos->push($promedioCalificacion);
    $datos->push($porcentajeAprobados);
    $datos->push($promedioAprobacion);
    $datos->push($promedioReprobacion);



    $datos->push([]);
    $datos->push([]);
    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'DATOS POR GRUPO'
    ]);

    
    $procDesAcaTotalCollect = collect($procDesAcaTotal)->first();

    // dd($procDesAcaTotalCollect);

    $datosPorGrupo = [];
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "TOTAL DE FALTAS DEL GRUPO";//
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->faltas;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO GENERAL DE FALTAS POR ALUMNO";//
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->promedioFaltas;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO GENERAL DEL GRUPO";//
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->promedioCalificacion;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PORCENTAJE GENERAL DE APROBACIÓN DEL GRUPO";//
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->porcentajeAprobados;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO APROBATORIO GENERAL";
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->promedioAprobacion;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO REPROBATORIO GENERAL";
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->promedioReprobacion;
    $datos->push($datosPorGrupo);
    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "PROMEDIO DE MATERIAS REPROBADAS POR ALUMNO";
    $datosPorGrupo["columna4"] = "";
    $datos->push($datosPorGrupo);

    $datosPorGrupo["columna1"] = "";
    $datosPorGrupo["columna2"] = "";
    $datosPorGrupo["columna3"] = "TOTAL DE REPROBADOS CON 35 O MENOS";
    $datosPorGrupo["columna4"] = $procDesAcaTotalCollect->totalReprobados35;
    $datos->push($datosPorGrupo);


    // dd($datosPorGrupo);



    $datos->push([]);
    $datos->push([]);
    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'ASIGNATURAS'
    ]);

    for($i=0;$i < count($procDesAcaGrupos);$i++){
      $matClave = $procDesAcaGrupos[$i]->matClave;
      $matNombre = $procDesAcaGrupos[$i]->matNombre;
 
      $datos->push([
        'columnaA'=>'',
        'columnaB'=>'',
        'columnaC'=>$matClave.'-'.$matNombre
      ]);
    }   

    $datos->push([
      'row'=>''
    ]);
    
    $datos->push([
      'columnaA'=>'',
      'columnaB'=>'',
      'columnaC'=>'DOCENTES'
    ]);

    for($i=0;$i < count($procDesAcaGrupos);$i++){
      $matClave = $procDesAcaGrupos[$i]->matClave;
      $empleado = $procDesAcaGrupos[$i]->empleado;
     
      $datos->push([
        'columnaA'=>'',
        'columnaB'=>'',
        'columnaC'=>$matClave.'-'.$empleado
      ]);
    }  

    $datosOrdinario = $datos;

    return $datosOrdinario;
  }


  public function descargarExcel($datosParcial1, $datosParcial2,$datosParcial3,$datosOrdinario)
  {
    return Excel::download(new AcreditacionesExport($datosParcial1, $datosParcial2,$datosParcial3,$datosOrdinario), 'Desempeño Académico.xlsx');
  }


  public function exportarExcel(Request $request)
  {
    
    $datosParcial1 = $this->datosParciales($request, "1");
    $datosParcial2 = $this->datosParciales($request,"2");
    $datosParcial3 = $this->datosParciales($request, "3");
    $datosOrdinario = $this->datosOrdinario($request);

    if ($datosParcial1->isEmpty() && $datosParcial2->isEmpty() && $datosParcial3->isEmpty() && $datosOrdinario->isEmpty()) {
    alert()->error('Error...', " No hay registros que coincidan con la
    información proporcionada. Favor de verificar.")->showConfirmButton();
    return back()->withInput();
  }
    
    return $this->descargarExcel($datosParcial1, $datosParcial2,$datosParcial3,$datosOrdinario);
  }
}
