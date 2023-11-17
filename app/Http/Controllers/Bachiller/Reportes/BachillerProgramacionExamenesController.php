<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\clases\personas\MetodosPersonas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

use App\Http\Models\InscritoExtraordinario;
use App\Http\Models\Bachiller\Bachiller_inscritosextraordinarios;
use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\Programa;
use App\Http\Models\Aula;
use App\Http\Models\Bachiller\Bachiller_extraordinarios;
use App\Http\Models\Optativa;
use App\Http\Models\Plan;
use Carbon\Carbon;
use Validator;
use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerProgramacionExamenesController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
    $this->middleware('auth');
  }

  public function reporte()
  {
    $ubicaciones = Ubicacion::whereIn('id', [1,2, 3])->get();

    return view('bachiller.reportes.programacion_examenes.create', [
      'ubicaciones' => $ubicaciones
    ]);
  }

  public function imprimir(Request $request)
  {

    $validator = Validator::make($request->all(),
    [
        'extFecha'      => 'date_format:Y-m-d|nullable',
        'extHora'         => 'date_format:H:i|nullable'
    ],
    [
        'extFecha.date_format' => "La fecha no tiene el formato correcto",
        'extHora.date_format' => "La hora no tiene el formato correcto"
    ]
    );
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $periodo = Periodo::findOrFail($request->periodo_id);

    $progExamenes = new Collection;
    self::buscarExtraordinarios($request)
    ->chunk(150, static function($registros) use ($progExamenes) {
      if($registros->isEmpty())
        return false;

      $registros->each(static function($bachiller_extraordinario) use ($progExamenes) {
        $progExamenes->push(self::info_esencial($bachiller_extraordinario));
      });
    });
     
    if($progExamenes->isEmpty()){
      alert()->warning('Sin coincidencias', 'No existen registros con la información proporcionada. Favor de verificar.')->showConfirmButton();
          return back()->withInput();
    }


    $fechaActual = Carbon::now('America/Merida');

    //variables que se mandan a la vista fuera del array
    $programaNombre = $request->programa_id ? Programa::findOrFail($request->programa_id) : null;
    $ubicacionNombre = $periodo->departamento->ubicacion;
    $perFechas = $periodo->perFechaInicial.' al '.$periodo->perFechaFinal.' ('.$periodo->perNumero.'/'.$periodo->perAnio.')';
    $tipoInscrip = '';
    
    switch ($request->regular) {
      case 'P':
      $tipoInscrip = 'Solo pagadas';
      break;
      case 'N':
      $tipoInscrip = 'Solo no pagadas';
      break;
      case 'T':
      $tipoInscrip = 'Pagadas y no pagadas';
      break;      
    }

    $plan = Plan::find($request->plan_id);
   
    // return $progExamenes->sortBy('ordenar')->unique('extraId')->groupBy(['agrupacion', 'gdo']);
    // view('reportes.pdf.bachiller.programacion_examen.pdf_programacion_examenes')
    $parametro_NombreArchivo = 'pdf_programacion_examenes';
            $pdf = PDF::loadView('reportes.pdf.bachiller.programacion_examen.'. $parametro_NombreArchivo, [
              "progExamenes" => $progExamenes->sortBy('ordenar')->unique('extraId')->groupBy(['agrupacion', 'gdo']),
              "fechaActual" => $fechaActual->format('Y-m-d'),
              "horaActual" => $fechaActual->format('H:i:s'),
              "nombreArchivo" => $parametro_NombreArchivo.'.pdf',
              "programaNombre" => $programaNombre,
              "ubicacionNombre" => $ubicacionNombre,
              "tipoInscrip" => $tipoInscrip,
              "periodo" => $perFechas,
              "plan" => $plan,
              "traer" => $request->regular,
              "extTipo" => $request->extTipo
            ]);
    
            $pdf->setPaper('letter', 'landscape');
            $pdf->defaultFont = 'Times Sans Serif';
    
            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
  }

  /**
   * @param App\Http\Models\Extraordinario
   */
  private static function info_esencial($bachiller_extraordinario) {
    $bachiller_materia = $bachiller_extraordinario->bachiller_materia;
    $plan = $bachiller_materia->plan;
    $programa = $plan->programa;

    return [  
        'extraId' => $bachiller_extraordinario->id,
        'planClave' => $plan->planClave,
        'matClave' => $bachiller_materia->matClave,
        'matNombre' => $bachiller_materia->matNombre,
        // 'optNombre' => ($bachiller_extraordinario->optativa_id != 0 && $bachiller_extraordinario->optativa) ? $bachiller_extraordinario->optativa->optNombre : '',
        'empleadoNombre' => MetodosPersonas::BachillerNombreCompleto($bachiller_extraordinario->bachiller_empleado),
        // 'sinodalNombre' => $bachiller_extraordinario->empleado_sinodal_id ? $bachiller_extraordinario->empleadoSinodal->persona->nombreCompleto(true) : '',
        'sinodalNombre' => $bachiller_extraordinario->empleado_sinodal_id ? $bachiller_extraordinario->bachiller_empleadoSinodal->BachillerNombreCompleto(true) : '',
        'gdo' => $bachiller_materia->matSemestre,
        'gpo' => $bachiller_extraordinario->extGrupo,
        'extFecha' => $bachiller_extraordinario->extFecha,
        'extHora' => $bachiller_extraordinario->extHora,
        'costo' => $bachiller_extraordinario->extPago,
        'sol' => $bachiller_extraordinario->extAlumnosInscritos,
        'progClave' => $programa->progClave,
        'progNombre' => $programa->progNombre,
        'ordenar' => $programa->progClave.$plan->planClave.str_pad($bachiller_materia->matSemestre, 2, "0", STR_PAD_LEFT).$bachiller_materia->matNombre,
        'agrupacion' => $programa->progClave.$plan->planClave,
        'estado' => $bachiller_extraordinario->bachiller_inscritos
      ];
  }

  /**
   * @param Illuminate\Http\Request
   */
  private static function buscarExtraordinarios($request) {

    return Bachiller_extraordinarios::with(['bachiller_materia.plan.programa.escuela', 'bachiller_inscritos', 'bachiller_empleado', 'bachiller_empleadoSinodal'])
    ->whereHas('bachiller_materia.plan.programa.escuela', static function($query) use ($request) {
      if($request->matClave)
        $query->where('matClave', $request->matClave);
      if($request->plan_id)
        $query->where('plan_id', $request->plan_id);
      if($request->programa_id)
        $query->where('programa_id', $request->programa_id);
      if($request->escuela_id)
        $query->where('escuela_id', $request->escuela_id);
      if($request->departamento_id)
        $query->where('departamento_id', $request->departamento_id);
    })
    ->where(static function($query) use ($request) {
      $query->where('periodo_id', $request->periodo_id);
      if($request->examenId)
        $query->where('id', $request->examenId);
      if($request->empleado_sinodal_id)
        $query->where('empleado_sinodal_id', $request->empleado_sinodal_id);
      if($request->extGrupo)
        $query->where('extGrupo', $request->extGrupo);
      if($request->extFecha)
        $query->where('extFecha', $request->extFecha);
      if($request->extHora)
        $query->where('extHora', $request->extHora);
      if($request->extPago)
        $query->where('extPago', $request->extPago);
      if($request->inscritos == 'si')
        $query->where('extAlumnosInscritos', '>', 0);
      if($request->inscritos == 'no')
        $query->where('extAlumnosInscritos', '=', 0);

      if(in_array($request->regular, ['p', 't']) && $request->inscritos == 'si') {
        $query->whereHas('bachiller_inscritos', static function($query) use ($request) {
          $request->regular == 'p' ? $query->where('iexEstado', 'P') : $query->where('iexEstado', '!=', 'C');
        });
      } elseif ($request->regular == 'n' && $request->inscritos == 'si') {
        $query->whereHas('bachiller_inscritos', static function($query) {
          $query->where('iexEstado', '!=', 'A');
        });
      }

      if($request->extTipo != ""){
        $query->where('extTipo', '=', $request->extTipo);
      }

    });
  }
}