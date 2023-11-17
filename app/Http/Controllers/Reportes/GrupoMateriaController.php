<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use Illuminate\Http\Request;

use App\Http\Models\Grupo;
use App\Http\Models\Inscrito;
use App\Http\Models\Ubicacion;

use Carbon\Carbon;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;


// use Codedge\Fpdf\Fpdf\Fpdf;

class GrupoMateriaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:r_inscrito_preinscrito');
        set_time_limit(8000000);

    }

    public function reporte(){
        $tiposIngreso = array(
            'NI' => 'NUEVO INGRESO',
            'PI' => 'PRIMER INGRESO',
            'RO' => 'REPETIDOR',
            'RI' => 'REINSCRIPCIÓN',
            'RE' => 'REINGRESO',
            'EQ' => 'REVALIDACIÓN',
            'OY' => 'OYENTE',
            'XX' => 'OTRO',
            '' => 'TODOS'
        );
        $alumnos_curso = array(
            'P' => 'PREINSCRITOS',
            'R' => 'INSCRITOS',
            'C' => 'CONDICIONADO',
            'A' => 'CONDICIONADO 2',
            '' => 'TODOS',
        );
        $alumnos_estado = array(
            'N' => 'NUEVO INGRESO',
            'R' => 'REINGRESO',
            '' => 'TODOS',
        );
        $tipo_reporte = array(
            'H' => 'HORARIOS',
            'F' => 'FOLIOS',
            'M' => 'MAESTROS',
            // '' => 'SELECCIONE UNA OPCIÓN',
        );
        $orden_reporte = array(
            'N' => 'NOMBRE(EMPEZANDO POR APELLIDOS)',
            'F' => 'FECHA DE INSCRIPCIÓN(SE ACTIVA SÓLO SI ELIGE TIPO DE REPORTE NORMAL)',
            // '' => 'SELECCIONE UNA OPCIÓN',
        );
        $espaciado = array(
            '1' => 'SENCILLO',
            '2' => 'DOBLE',
            // '' => 'SELECCIONE UNA OPCIÓN',
        );

        $ubicaciones = Ubicacion::where('id', '<>', 0)->get();

        return View('reportes/grupo_materia.create', compact('tiposIngreso','alumnos_curso','alumnos_estado','tipo_reporte','orden_reporte','espaciado', 'ubicaciones'));
    }


    public function imprimir(Request $request) {

      $fechaActual = Carbon::now('CDT');
      $swal_title = 'Sin registros';
      $swal_text = 'No hay datos que coincidan con la información proporcionada. Favor de verificar.';



      // ---------- FILTRO 1 - GRUPOS
      $grupos = Grupo::with(['periodo', 'plan.programa.escuela', 'materia', 'empleado.persona', 'optativa'])
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
      ->whereHas('materia', static function($query) use ($request) {
        if($request->matClave) {
          $query->where('matClave', $request->matClave);
        }
      })
      ->where(static function($query) use ($request) {
        $query->where('periodo_id', $request->periodo_id);
        if($request->gpoSemestre) {
          $query->where('gpoSemestre', $request->gpoSemestre);
        }
        if($request->gpoClave) {
          $query->where('gpoClave', $request->gpoClave);
        }
        if($request->empleado_id) {
          $query->where('empleado_id', $request->empleado_id);
        }
      });

      if ($request->grupo_id) {
        $grupos->where('id', $request->grupo_id);
      }

      $grupos = $grupos->get()->sortBy(function($item, $key) {
        return intval($item->plan->planClave) + $item->gpoSemestre;
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
      $inscritos = Inscrito::with('curso.alumno.persona')
      ->whereIn('grupo_id', $grupos->pluck('id'))->get();

      if($inscritos->isEmpty()) {
        alert()->warning($swal_title, $swal_text)->showConfirmButton();
        return back()->withInput();
      }



      // ---------------- PROCESO -----------------------------------
      $inscritos = $inscritos->map(function($inscrito, $key) {
        $alumno = $inscrito->curso->alumno;
        $persona = $alumno->persona;
        $nombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
        return collect([
          'grupo_id' => $inscrito->grupo_id,
          'curEstado' => $inscrito->curso->curEstado,
          'aluClave' => $alumno->aluClave,
          'nombre' => $nombre
        ]);
      })->sortBy('nombre')->groupBy('grupo_id');

      $grupos = $grupos->map(function($grupo, $key) use ($inscritos) {
        $empleado = $grupo->empleado;
        $persona = $empleado->persona;
        $maestroNombre = $persona->perApellido1.' '.$persona->perApellido2.' '.$persona->perNombre;
        $optNombre = $grupo->optativa_id ? $grupo->optativa->optNombre : '';
        $matNombre = $grupo->materia->matNombreOficial.' '.$optNombre;

        return collect([
          'grupo_id' => $grupo->id,
          'progClave' => $grupo->plan->programa->progClave,
          'planClave' => $grupo->plan->planClave,
          'progNombreCorto' => $grupo->plan->programa->progNombreCorto,
          'grado' => $grupo->gpoSemestre,
          'grupo' => $grupo->gpoClave,
          'materia' => $grupo->materia->matClave.' '.$matNombre,
          'maestro' =>  $maestroNombre.' ('.$empleado->id.')',
          'inscritos' => $inscritos->pull($grupo->id)
        ]);
      })->sortBy('progClave');


      // Unix
      setlocale(LC_TIME, 'es_ES.UTF-8');
      // En windows
      setlocale(LC_TIME, 'spanish');

      $nombreArchivo = 'pdf_grupo_materia.pdf';
      $pdf = PDF::loadView('reportes.pdf.pdf_grupo_materia', [
          "info" => $info,
          "grupos" => $grupos,
          "nombreArchivo" => $nombreArchivo,
          "curEstado" => $request->curEstado,
          "fechaActual" => $fechaActual->format('d/m/Y'),
          "horaActual" => $fechaActual->format('H:i:s'),
      ]);

      $pdf->setPaper('letter', 'portrait');
      $pdf->defaultFont = 'Times Sans Serif';
      return $pdf->stream($nombreArchivo);
      return $pdf->download($nombreArchivo);
    }//imprimir.
}
