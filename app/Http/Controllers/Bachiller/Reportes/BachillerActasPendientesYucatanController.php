<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Bachiller\Bachiller_extraordinarios;
use App\Models\Bachiller\Bachiller_grupos;
use DB;
use PDF;
use Carbon\Carbon;


use Illuminate\Http\Request;
use App\Models\Ubicacion;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerActasPendientesYucatanController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    ini_set('memory_limit', '-1');
    $this->middleware('auth');
    // $this->middleware('permisos:r_actas_pendientes');
    // set_time_limit(8000000);

  }

  public function reporte()
  {
    $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
    return view('bachiller.reportes.actas_pendientes.create', compact('ubicaciones'));
  }


  public function actasPendientesOrd($request)
  {

    $bachiller_grupos = Bachiller_grupos::with('bachiller_materia', 'plan.programa.escuela', 'bachiller_empleado')
      ->where('periodo_id', $request->periodo_id)
      ->whereHas('plan.programa.escuela.departamento.ubicacion', function ($query) use ($request) {
        if ($request->departamento_id) {
          $query->where('departamento_id', $request->departamento_id);
        }
        if ($request->escuela_id) {
          $query->where('escuela_id', $request->escuela_id);
        }
        if ($request->programa_id) {
          $query->where('programa_id', $request->programa_id);
        }
        if ($request->plan_id) {
          $query->where('plan_id', $request->plan_id);
        }
      })
      ->whereHas('bachiller_materia', function ($query) use ($request) {
        if ($request->matClave) {
          $query->where('matClave', '=', $request->matClave);
        }
      });


    if ($request->cgtGradoSemestre) {
      $bachiller_grupos = $bachiller_grupos->where('gpoGrado', '=', $request->cgtGradoSemestre);
    }
    if ($request->cgtGrupo) {
      $bachiller_grupos = $bachiller_grupos->where('gpoClave', '=', $request->cgtGrupo);
    }
    if ($request->empleado_id) {
      $bachiller_grupos = $bachiller_grupos->where("empleado_id_docente", "=", $request->empleado_id);
    }


    if ($request->actasPendientes == "pendientesCerrar" && $request->chckincluirpendientes) {
      $bachiller_grupos = $bachiller_grupos->whereIn("estado_act", ["A", "B"]);
    }
    if ($request->actasPendientes == "pendientesCapturar") {
      $bachiller_grupos = $bachiller_grupos->where("estado_act", "=", "A");
    }
    if ($request->actasPendientes == "pendientesCerrar"  && !$request->chckincluirpendientes) {
      $bachiller_grupos = $bachiller_grupos->where("estado_act", "=", "B");
    }
    if ($request->actasPendientes == "cerradas") {
      $bachiller_grupos = $bachiller_grupos->where("estado_act", "=", "C");
    }

    if ($request->grupos_con_inscritos) {
      $bachiller_grupos = $bachiller_grupos->has('bachiller_inscrito');
    }

    $bachiller_grupos = $bachiller_grupos->get();

    if ($bachiller_grupos->isEmpty()) {
      alert()->warning('Sin datos', 'No hay datos que coincidan con la información 
         proporcionada. Favor de verificar')->showConfirmButton();
      return back()->withInput();
    }

    /*
   * Ordenar por carrera|grado|grupo.
   */
    $ordenado = $bachiller_grupos->sortBy(function ($item) {
      $car = $item->plan->programa->progClave;
      $GG = $item->gpoGrado . $item->gpoClave;
      return  $car . $GG;
    });
    /*
   * Agrupar por:
   * -> Carrera.
   *   -> Grado.
   */
    $bachiller_grupos = $ordenado->groupBy([function ($item) {
      $car = $item->plan->programa->progClave;
      return $car;
    }, function ($item) {
      $grado = $item->gpoGrado;
      return $grado;
    }]);

    $fechaActual = Carbon::now();
    $grupo1 = $bachiller_grupos->first()->first()->first();

    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');


    if ($request->actasPendientes == "pendientesCapturar") {
      $nombreArchivo = 'pdf_actas_pendientes_capturar.pdf';

      $pdf = PDF::loadView('reportes.pdf.bachiller.actas_pendientes.pdf_actas_pendientes_capturar', [
        "grupos" => $bachiller_grupos,
        "grupo1" => $grupo1,
        "nombreArchivo" => $nombreArchivo,
        "curEstado" => $request->curEstado,
        "fechaActual" => $fechaActual->toDateString(),
        "horaActual" => $fechaActual->toTimeString(),
      ]);
    }
    if ($request->actasPendientes == "pendientesCerrar") {
      $nombreArchivo = 'pdf_actas_pendientes_cerrar.pdf';

      $pdf = PDF::loadView('reportes.pdf.bachiller.actas_pendientes.pdf_actas_pendientes_cerrar', [
        "grupos" => $bachiller_grupos,
        "grupo1" => $grupo1,
        "nombreArchivo" => $nombreArchivo,
        'tituloHead' => $t = 'ACTAS DE EXAMEN ORDINARIO PENDIENTES POR CERRAR 
                       Y CAPTURAR',
        "curEstado" => $request->curEstado,
        "fechaActual" => $fechaActual->toDateString(),
        "horaActual" => $fechaActual->toTimeString(),
      ]);
    }

    if ($request->actasPendientes == "cerradas") {
      $nombreArchivo = 'pdf_actas_pendientes_cerrar.pdf';
      $pdf = PDF::loadView('reportes.pdf.bachiller.actas_pendientes.pdf_actas_pendientes_cerrar', [
        'grupos' => $bachiller_grupos,
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

    if ($request->actasPendientesExtras == "pendientesPorCalificarNombre") {

      $bachiller_extraordinarios = Bachiller_extraordinarios::with('bachiller_inscritos.alumno.persona', 'periodo', 'bachiller_materia', 'bachiller_empleado')
        ->whereHas('periodo', function ($query) use ($request) {
          $query->where('periodo_id', $request->periodo_id);
        })
        ->whereHas('bachiller_materia.plan.programa', function ($query) use ($request) {
          if ($request->matClave) {
            $query->where('matClave', '=', $request->matClave);
          }
          if ($request->plan_id) {
            $query->where('plan_id', $request->plan_id);
          }
          if ($request->programa_id) {
            $query->where('programa_id', $request->programa_id);
          }
          if ($request->escuela_id) {
            $query->where('escuela_id', $request->escuela_id);
          }
        })
        ->whereHas('bachiller_empleado', function ($query) use ($request) {
          if ($request->empleado_id) {
            $query->where("empleado_id", "=", $request->empleado_id);
          }
        })
        ->where(static function ($query) use ($request) {
          if ($request->grupos_con_inscritos) {
            $query->has('bachiller_inscritos');
          }
        })

        ->where(static function ($query) use ($request) {
          if ($request->extFecha != "") {
            $query->where("extFecha", "=", $request->extFecha);
          }
        })

        ->whereHas('bachiller_inscritos', function ($query) use ($request) {
          if ($request->empleado_id) {
            $query->whereNull("iexCalificacion");
          }
        })      

        ->get();

      if ($bachiller_extraordinarios->isEmpty()) {
        alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
        return back()->withInput();
      }

      // foreach ($bachiller_extraordinarios as $key => $value) {
      //   print_r( $value->bachiller_inscritos[0]->alumno->id . "<br>");
      // }

      // die();
      // return $bachiller_extraordinarios[0]->bachiller_inscritos[0]->alumno->id;

      $periodo = $bachiller_extraordinarios[0]->periodo->perNumero . "/" . $bachiller_extraordinarios[0]->periodo->perAnio;
      $nivel = $bachiller_extraordinarios[0]->bachiller_materia->plan->programa->progClave;
      $plan = $bachiller_extraordinarios[0]->bachiller_materia->plan->planClave;

      // aqui 
      $bachiller_extraordinarios = $bachiller_extraordinarios->map(function ($item, $key) use ($request) {
        $item->bachiller_inscritos = $item->bachiller_inscritos()->get()
          ->where('iexEstado', "!=", "C")          
          // ->whereNull('iexCalificacion')
          ->filter(function ($value, $key) use ($request) {
            $campo_busqueda = $request->actasPendientesExtras == 'pendientesPorCalificarNombre' ? 'iexCalificacion' : 'iexFolioHistorico';
            return is_null($value->{$campo_busqueda});
          });

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');
        $item->fechaExtra =  Carbon::parse($item->extFecha)->day
          . '/' . Carbon::parse($item->extFecha)->formatLocalized('%b')
          . '/' . Carbon::parse($item->extFecha)->year;

        $item->horaExtra = Carbon::parse($item->extHora)->format("h:i");

        return $item;
      })->filter(static function ($bachiller_extraordinario) {
        return $bachiller_extraordinario->bachiller_inscritos->isNotEmpty();
      });


      // return $bachiller_extraordinarios;
    } else {

      $bachiller_extraordinarios = Bachiller_extraordinarios::with('periodo', 'bachiller_materia', 'bachiller_empleado', 'bachiller_inscritos.alumno.persona')
        ->whereHas('periodo', function ($query) use ($request) {
          $query->where('periodo_id', $request->periodo_id);
        })
        ->whereHas('bachiller_materia.plan.programa', function ($query) use ($request) {
          if ($request->matClave) {
            $query->where('matClave', '=', $request->matClave);
          }
          if ($request->plan_id) {
            $query->where('plan_id', $request->plan_id);
          }
          if ($request->programa_id) {
            $query->where('programa_id', $request->programa_id);
          }
          if ($request->escuela_id) {
            $query->where('escuela_id', $request->escuela_id);
          }
        })
        ->whereHas('bachiller_empleado', function ($query) use ($request) {
          if ($request->empleado_id) {
            $query->where("empleado_id", "=", $request->empleado_id);
          }
        })
        ->where(static function ($query) use ($request) {
          if ($request->grupos_con_inscritos) {
            $query->has('bachiller_inscritos');
          }
        })

        ->where(static function ($query) use ($request) {
          if ($request->extFecha != "") {
            $query->where("extFecha", "=", $request->extFecha);
          }
        })


        ->get();

      if ($bachiller_extraordinarios->isEmpty()) {
        alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
        return back()->withInput();
      }

      $periodo = $bachiller_extraordinarios[0]->periodo->perNumero . "/" . $bachiller_extraordinarios[0]->periodo->perAnio;
      $nivel = $bachiller_extraordinarios[0]->bachiller_materia->plan->programa->progClave;
      $plan = $bachiller_extraordinarios[0]->bachiller_materia->plan->planClave;
      // aqui 
      $bachiller_extraordinarios = $bachiller_extraordinarios->map(function ($item, $key) use ($request) {
        $item->bachiller_inscritos = $item->bachiller_inscritos()->get()
          ->where('iexEstado', "!=", "C")
          // ->whereNull('iexCalificacion')
          ->filter(function ($value, $key) use ($request) {
            $campo_busqueda = $request->actasPendientesExtras == 'pendientesPorCalificar' ? 'iexCalificacion' : 'iexFolioHistorico';
            return is_null($value->{$campo_busqueda});
          });

        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');
        $item->fechaExtra =  Carbon::parse($item->extFecha)->day
          . '/' . Carbon::parse($item->extFecha)->formatLocalized('%b')
          . '/' . Carbon::parse($item->extFecha)->year;

        $item->horaExtra = Carbon::parse($item->extHora)->format("h:i");

        return $item;
      })->filter(static function ($bachiller_extraordinario) {
        return $bachiller_extraordinario->bachiller_inscritos->isNotEmpty();
      });
    }

    if ($bachiller_extraordinarios->isEmpty()) {
      alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
      return back()->withInput();
    }

    $fechaActual = Carbon::now('America/Merida');


    if ($request->actasPendientesExtras == "pendientesPorCalificarNombre") {
      $nombreArchivo = 'pdf_actas_pendientes_cerrar_extra_alumnos';
    } else {
      $nombreArchivo = 'pdf_actas_pendientes_cerrar_extra';
    }

    // view('reportes.pdf.bachiller.actas_pendientes.pdf_actas_pendientes_cerrar_extra');
    return PDF::loadView('reportes.pdf.bachiller.actas_pendientes.' . $nombreArchivo, [
      'extraordinarios' => $bachiller_extraordinarios,
      'nombreArchivo' => $nombreArchivo,
      'fechaActual' => $fechaActual->toDateString(),
      'horaActual' => $fechaActual->toTimeString(),
      'titulo' => $request->actasPendientesExtras,
      'periodo' => $periodo,
      'nivel' => $nivel,
      'plan' => $plan
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
