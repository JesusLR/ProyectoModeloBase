<?php

namespace App\Http\Controllers\Reportes;

use DB;
use PDF;
use Carbon\Carbon;

use App\Models\Grupo;
use App\Models\Extraordinario;
use App\Models\Ubicacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ActasPendientesController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    ini_set('memory_limit','-1');
    $this->middleware('auth');
    $this->middleware('permisos:r_actas_pendientes');
    set_time_limit(8000000);
    
  }

  public function reporte()
  {
    $ubicaciones = Ubicacion::sedes()->get();
    return View('reportes/actas_pendientes.create', compact('ubicaciones'));
  }


  public function actasPendientesOrd($request)
  {

     $grupos = Grupo::with('materia', 'plan.programa.escuela', 'empleado.persona')
     ->where('periodo_id', $request->periodo_id)
     ->whereHas('plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
       if($request->departamento_id) {
        $query->where('departamento_id', $request->departamento_id);
       }
       if($request->escuela_id) {
        $query->where('escuela_id', $request->escuela_id);
       }
       if($request->programa_id) {
        $query->where('programa_id', $request->programa_id);
       }
       if($request->plan_id) {
        $query->where('plan_id', $request->plan_id);
       }
     })
     ->whereHas('materia', function($query) use ($request) {
       if ($request->matClave) {
         $query->where('matClave', '=', $request->matClave);
       }
     });


   if ($request->cgtGradoSemestre) {
     $grupos = $grupos->where('gpoSemestre', '=', $request->cgtGradoSemestre);
   }
   if ($request->cgtGrupo) {
     $grupos = $grupos->where('gpoClave', '=', $request->cgtGrupo);
   }
   if ($request->empleado_id) {
     $grupos = $grupos->where("empleado_id", "=", $request->empleado_id);
   }


   if ($request->actasPendientes == "pendientesCerrar" && $request->chckincluirpendientes) {
     $grupos = $grupos->whereIn("estado_act", ["A", "B"]);
   }
   if ($request->actasPendientes == "pendientesCapturar") {
     $grupos = $grupos->where("estado_act", "=", "A");
   }
   if ($request->actasPendientes == "pendientesCerrar"  && !$request->chckincluirpendientes) {
     $grupos = $grupos->where("estado_act", "=", "B");
   }
   if($request->actasPendientes == "cerradas"){
     $grupos = $grupos->where("estado_act","=","C");
   }

   if($request->grupos_con_inscritos) {
    $grupos = $grupos->has('inscritos');
   }

   $grupos = $grupos->get();

   if($grupos->isEmpty()){
     alert()->warning('Sin datos','No hay datos que coincidan con la información 
         proporcionada. Favor de verificar')->showConfirmButton();
     return back()->withInput();
   }

   /*
   * Ordenar por carrera|grado|grupo.
   */
   $ordenado = $grupos->sortBy(function($item){
     $car = $item->plan->programa->progClave;
     $GG = $item->gpoSemestre.$item->gpoClave;
     return  $car.$GG;
   });
   /*
   * Agrupar por:
   * -> Carrera.
   *   -> Grado.
   */
   $grupos = $ordenado->groupBy([function($item){
         $car = $item->plan->programa->progClave;
         return $car;
       },function($item){
         $grado = $item->gpoSemestre;
         return $grado;
       }]);

   $fechaActual = Carbon::now();
   $grupo1 = $grupos->first()->first()->first();

   // Unix
   setlocale(LC_TIME, 'es_ES.UTF-8');
   // En windows
   setlocale(LC_TIME, 'spanish');

   
   if ($request->actasPendientes == "pendientesCapturar") {
     $nombreArchivo = 'pdf_actas_pendientes_capturar.pdf';
     
     $pdf = PDF::loadView('reportes.pdf.pdf_actas_pendientes_capturar', [
       "grupos" => $grupos,
       "grupo1" => $grupo1,
       "nombreArchivo" => $nombreArchivo,
       "curEstado" => $request->curEstado,
       "fechaActual" => $fechaActual->toDateString(),
       "horaActual" => $fechaActual->toTimeString(),
     ]);

   }
   if ($request->actasPendientes == "pendientesCerrar") {
     $nombreArchivo = 'pdf_actas_pendientes_cerrar.pdf';

     $pdf = PDF::loadView('reportes.pdf.pdf_actas_pendientes_cerrar', [
       "grupos" => $grupos,
       "grupo1" => $grupo1,
       "nombreArchivo" => $nombreArchivo,
       'tituloHead' => $t = 'ACTAS DE EXAMEN ORDINARIO PENDIENTES POR CERRAR 
                       Y CAPTURAR',
       "curEstado" => $request->curEstado,
       "fechaActual" => $fechaActual->toDateString(),
       "horaActual" => $fechaActual->toTimeString(),
     ]);
   }

   if($request->actasPendientes == "cerradas"){
     $nombreArchivo = 'pdf_actas_pendientes_cerrar.pdf';
     $pdf = PDF::loadView('reportes.pdf.pdf_actas_pendientes_cerrar',[
       'grupos' => $grupos,
       "grupo1" => $grupo1,
       'nombreArchivo' => $nombreArchivo,
       'tituloHead' => $t = 'ACTAS DE EXAMEN ORDINARIO CERRADAS',
       'curEstado' => $request->curEstado,
       'fechaActual' => $fechaActual->toDateString(),
       'horaActual' => $fechaActual->toTimeString(),
     ]);
   }


   $pdf->setPaper('letter', 'portrait');
   $pdf->defaultFont = 'Times Sans Serif';
   return $pdf->stream($nombreArchivo);
   return $pdf->download($nombreArchivo);
  }

  public function actasPendientesExtra($request)
  {
    $extraordinarios = Extraordinario::with('aula','periodo','materia','empleado')
      ->whereHas('periodo', function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
      })
      ->whereHas('materia.plan.programa', function($query) use ($request) {
        if ($request->matClave) {
          $query->where('matClave', '=', $request->matClave);
        }
        if($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }
        if($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
        if($request->escuela_id) {
          $query->where('escuela_id', $request->escuela_id);
        }
      })
      ->whereHas('empleado', function($query) use ($request) {
        if ($request->empleado_id) {
          $query->where("empleado_id", "=", $request->empleado_id);
        }
      })
      ->where(static function($query) use ($request) {
        if($request->grupos_con_inscritos) {
          $query->has('inscritos');
        }
      })

    ->get();

    if($extraordinarios->isEmpty()) {
      alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }


    $extraordinarios = $extraordinarios->map(function ($item, $key) use ($request) {
      $item->inscritos = $item->inscritos()->get()
        ->where('iexEstado', "!=", "C")
        ->filter(function ($value, $key) use ($request) {
          $campo_busqueda = $request->actasPendientesExtras == 'pendientesPorCalificar' ? 'iexCalificacion' : 'iexFolioHistorico';
          return is_null($value->{$campo_busqueda});
        });

      $item->fechaExtra =  Carbon::parse($item->extFecha)->day
      .'/'. Carbon::parse($item->extFecha)->formatLocalized('%b')
      .'/'. Carbon::parse($item->extFecha)->year;

      $item->horaExtra = Carbon::parse($item->extHora)->format("h:i");

      return $item;
    })->filter(static function($extraordinario) {
      return $extraordinario->inscritos->isNotEmpty();
    });

    if($extraordinarios->isEmpty()) {
      alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
      return back()->withInput();
    }

    $fechaActual = Carbon::now('America/Merida');

    $nombreArchivo = 'pdf_actas_pendientes_cerrar_extra.pdf';
    return PDF::loadView('reportes.pdf.pdf_actas_pendientes_cerrar_extra',[
      'extraordinarios' => $extraordinarios,
      'nombreArchivo' => $nombreArchivo,
      'fechaActual' => $fechaActual->toDateString(),
      'horaActual' => $fechaActual->toTimeString(),
    ])->stream($nombreArchivo);
  }


  public function imprimir(Request $request)
  {
    if ($request->tipoActa == "ORDINARIO") {
      return $this->actasPendientesOrd($request);
    }
    if ($request->tipoActa == "EXTRAORDINARIO") {
      return $this->actasPendientesExtra($request);
    }
  }
}