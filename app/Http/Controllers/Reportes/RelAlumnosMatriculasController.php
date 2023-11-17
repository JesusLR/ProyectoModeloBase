<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Horario;
use App\Http\Models\Curso;
use App\Http\Models\Ubicacion;
use App\clases\personas\MetodosPersonas;

use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class RelAlumnosMatriculasController extends Controller
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
  }

  public function reporte()
  {

    $tiposIngresoSegey = [
      'NI' => 'NUEVO INGRESO',
      'PI' => 'PRIMER INGRESO',
      'RO' => 'REPETIDOR',
      'RI' => 'REINSCRIPCIÓN',
      'RE' => 'REINGRESO',
      'EQ' => 'REVALIDACIÓN',
      'OY' => 'OYENTE',
      'XX' => 'OTRO',
  ];

  $aluEstado = [
      'P' => 'PREINSCRITOS',
      'R' => 'INSCRITOS',
      'C' => 'CONDICIONADO',
      'A' => 'CONDICIONADO 2',
      'R+P' => 'SALON',
      '' => 'TODOS',
  ];

  $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();

    return View('reportes/rel_alumnos_matriculas.create', [
      "aluEstado" => $aluEstado,
      'tiposIngresoSegey' => $tiposIngresoSegey,
      'ubicaciones' => $ubicaciones
    ]);
  }

  
  public function relAlumnosMatriculas($request)
  {
    //falta añoCurso
    $alumnos = Curso::with('alumno.persona', 'periodo', 'cgt.plan.programa.escuela')

      ->whereHas('periodo', function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
      })
      ->whereHas('alumno.persona', function($query) use ($request) {
        if ($request->aluClave) {//CLAVE PAGO
          $query->where('aluClave', '=', $request->aluClave);//
        }
        if ($request->aluEstado) {//CLAVE PAGO
          $query->where('aluEstado', '=', $request->aluEstado);//
        }
        if ($request->aluMatricula) {
          $query->where('aluMatricula', '=', $request->aluMatricula);//
        }
        if ($request->perApellido1) {
          $query->where('perApellido1', '=', $request->perApellido1);//
        }
        if ($request->perApellido2) {
          $query->where('perApellido2', '=', $request->perApellido2);//
        }
        if ($request->perNombre) {
          $query->where('perNombre', '=', $request->perNombre);//
        }
      })
      ->whereHas('cgt.plan.programa.escuela', function($query) use ($request) {
        if($request->escuela_id) {
          $query->where('escuela_id', $request->escuela_id);
        }
        if($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
        if($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }
        if ($request->cgtGradoSemestre) {//BAC,SUP -------------------------
          $query->where('cgtGradoSemestre', '=', $request->cgtGradoSemestre);//
        }
        if ($request->cgtGrupo) {
          $query->where('cgtGrupo', '=', $request->cgtGrupo);//
        }
      });

      if ($request->curTipoIngreso) {
        $alumnos = $alumnos->where('curTipoIngreso', '=', $request->curTipoIngreso);//
      }

    $alumnos = $alumnos->get();

    if($alumnos->isEmpty()) {
      return false;
    }


    $aluClaves = $alumnos->map(function ($item) {
      return $item->alumno->aluClave;
    })->all();


    $perAnioPago = $alumnos->map(function ($item) {
      return $item->periodo->perAnioPago;
    })->unique()->all();

    $pagos = DB::table('pagos')
      ->whereIn('pagClaveAlu', $aluClaves)->whereIn('pagAnioPer', $perAnioPago)
      ->where('pagConcPago', 99)->get();//99 es periodo 3, osea primera inscripcion


    //fix duplicidad de registros
    $pagos = $pagos->groupBy('pagClaveAlu')->map(function ($item) {
      return $item->sortBy("pagFechaPago")->first();
    });


    $alumnos = $alumnos->map(function ($obj) use ($pagos) {

      $aluClave = $obj->alumno->aluClave;
      $pago = $pagos->filter(function ($value, $key) use($aluClave) {
        return $aluClave == $key;
      })->first();

      $obj->pagFechaPago = $pago ? $pago->pagFechaPago: "";


      //nuevo campo para ordenar por apellido1, apellido2, nombre
      $obj->sortByNombre = MetodosPersonas::nombreCompleto($obj->alumno->persona, true);


      return $obj;
    });


    return $alumnos;
  }



  public function imprimir(Request $request)
  {
    $alumnos = $this->relAlumnosMatriculas($request);
    // dd($request->all());

    if(!$alumnos) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    if ($request->ordernarPor == "nombre") {
      $alumnos = $alumnos->sortBy("sortByNombre");
    }
    if ($request->ordernarPor == "grado") {
      $alumnos = $alumnos->sortBy("cgt.cgtGradoSemestre");
    }

    if ($request->tipoReporte == "normal") {
      $nombreArchivo = 'pdf_rel_alumnos_matriculas';
    }
    if ($request->tipoReporte == "rayas") {
      $nombreArchivo = 'pdf_rel_alumnos_matriculas_rayas';
    }
 
    // dd($alumnos->first());

    // dd($grupos->slice(5,5));

    $fechaActual = Carbon::now();
    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');



    $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
      "alumnos" => $alumnos,
      "nombreArchivo" => $nombreArchivo,
      "curEstado" => $request->curEstado,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      "tipoEspacio" => $request->tipoEspacio,
      "ordenarPor" => $request->ordernarPor,
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo.'.pdf');
    return $pdf->download($nombreArchivo.'.pdf');

    // dd($curso);
    // return response()->json($curso);
  }
}