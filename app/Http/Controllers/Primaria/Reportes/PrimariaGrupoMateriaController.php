<?php

namespace App\Http\Controllers\Primaria\Reportes;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Primaria\Primaria_empleado;
use App\Models\Primaria\Primaria_grupo;
use App\Models\Primaria\Primaria_inscrito;
use Illuminate\Http\Request;

use App\Models\Ubicacion;

use Carbon\Carbon;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;


// use Codedge\Fpdf\Fpdf\Fpdf;

class PrimariaGrupoMateriaController extends Controller
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

    public function reporte(){
     
    
        $espaciado = array(
            '1' => 'SENCILLO',
            '2' => 'DOBLE',
            // '' => 'SELECCIONE UNA OPCIÓN',
        );

        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $primaria_empleados = Primaria_empleado::where('empEstado', '<>', 'B')->get();

        return view('primaria.reportes.grupo_materia.create', compact('espaciado', 'ubicaciones', 'primaria_empleados'));
    }


    public function imprimir(Request $request) {

      $fechaActual = Carbon::now('CDT');
      $swal_title = 'Sin registros';
      $swal_text = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';



      // ---------- FILTRO 1 - GRUPOS
      $grupos = Primaria_grupo::with(['periodo', 'plan.programa.escuela', 'primaria_materia', 'primaria_empleado'])
      ->whereHas('plan.programa.escuela', static function($query) use ($request) {
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
      ->whereHas('primaria_materia', static function($query) use ($request) {
        if($request->matClave) {
          $query->where('matClave', $request->matClave);
        }
      })
      ->where(static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        if($request->gpoSemestre) {
          $query->where('gpoGrado', $request->gpoSemestre);
        }
        if($request->gpoClave) {
          $query->where('gpoClave', $request->gpoClave);
        }
        if($request->empleado_id) {
          $query->where('empleado_id_docente', $request->empleado_id);
        }
      });

      if ($request->grupo_id) {
        $grupos->where('id', $request->grupo_id);
      }

      $grupos = $grupos->get()->sortBy(function($item, $key) {
        return intval($item->plan->planClave) + $item->gpoGrado;
      });

      if($grupos->isEmpty()) {
        alert()->warning($swal_title, $swal_text)->showConfirmButton();
        return back()->withInput();
      }

      $periodo = $grupos->first()->periodo;
      $ubicacion = $periodo->departamento->ubicacion;
      $info = collect([
        'perFechaInicial' => Utils::fecha_string($periodo->perFechaInicial, 'mesCorto'),
        'perFechaFinal' => Utils::fecha_string($periodo->perFechaFinal, 'mesCorto'),
        'ubicacion' => $ubicacion->ubiClave.' '.$ubicacion->ubiNombre
      ]);



      //--- FILTRO 2 - INSCRITOS EN LOS GRUPOS
      $inscritos = Primaria_inscrito::with('curso.alumno.persona')
      ->where(static function ($query) use ($request) {

        if ($request->tipoDeModalidad != "") {
          $query->where('inscTipoAsistencia', $request->tipoDeModalidad);
        }
      })
      ->whereIn('primaria_grupo_id', $grupos->pluck('id'))->get();

      if ($inscritos->isEmpty()) {
        alert()->warning($swal_title, $swal_text)->showConfirmButton();
        return back()->withInput();
      }



      // ---------------- PROCESO -----------------------------------
      $inscritos = $inscritos->map(function($inscrito, $key) {
        $alumno = $inscrito->curso->alumno;
        $persona = $alumno->persona;
        $nombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
        return collect([
          'grupo_id' => $inscrito->primaria_grupo_id,
          'curEstado' => $inscrito->curso->curEstado,
          'aluClave' => $alumno->aluClave,
          'nombre' => $nombre
        ]);
      })->sortBy('nombre')->groupBy('grupo_id');

      $grupos = $grupos->map(function($grupo, $key) use ($inscritos) {
        $empleado = $grupo->primaria_empleado;
        $persona = $empleado;
        $maestroNombre = $persona->empApellido1.' '.$persona->empApellido2.' '.$persona->empNombre;
        $optNombre = $grupo->optativa_id ? $grupo->optativa->optNombre : '';
        $matNombre = $grupo->primaria_materia->matNombre.' '.$optNombre;

        if($grupo->nombreAlternativo == "" || $grupo->nombreAlternativo == "nombreAlternativo"){
          $gpoMatComplementaria = "";
        }else{
          $gpoMatComplementaria = $grupo->nombreAlternativo;
        }
        

        return collect([
          'grupo_id' => $grupo->id,
          'progClave' => $grupo->plan->programa->progClave,
          'planClave' => $grupo->plan->planClave,
          'progNombreCorto' => $grupo->plan->programa->progNombre,
          'grado' => $grupo->gpoGrado,
          'grupo' => $grupo->gpoClave,
          'materia' => $grupo->primaria_materia->matClave.' '.$matNombre,
          'materiaACD' => $gpoMatComplementaria,
          'maestro' =>  $maestroNombre.' ('.$empleado->id.')',
          'inscritos' => $inscritos->pull($grupo->id)
        ]);
      })->sortBy('progClave');


      // Unix
      setlocale(LC_TIME, 'es_ES.UTF-8');
      // En windows
      setlocale(LC_TIME, 'spanish');

      // return $grupos;
      $nombreArchivo = 'pdf_grupo_materia.pdf';
      // view('reportes.pdf.primaria.lista_de_asistencia.pdf_grupo_materia');
      $pdf = PDF::loadView('reportes.pdf.primaria.lista_de_asistencia.pdf_grupo_materia', [
          "info" => $info,
          "grupos" => $grupos,
          "nombreArchivo" => $nombreArchivo,
          "curEstado" => $request->curEstado,
          "fechaActual" => $fechaActual->format('d/m/Y'),
          "horaActual" => $fechaActual->format('H:i:s'),
      ]);

      // $pdf->setPaper('letter', 'portrait');
      $pdf->setPaper('letter', 'landscape');

      $pdf->defaultFont = 'Times Sans Serif';
      return $pdf->stream($nombreArchivo);
      return $pdf->download($nombreArchivo);
    }//imprimir.
}
