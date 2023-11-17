<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Horario;
use App\Http\Models\Ubicacion;
use App\Http\Models\Curso;
use App\Http\Models\Cgt;

use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class ResumenGruposAlumnoController extends Controller
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
    $ubicaciones = Ubicacion::all();
    return View('reportes/resumen_grupos_alumno.create', compact('ubicaciones'));
  }

  
  public function resumenGruposAlumno($request)
  {
    // dd($request->all());
    $grupos = Curso::with('alumno.persona', 'cgt.plan.programa.escuela.departamento.ubicacion', 'periodo')
    ->whereIn('cursos.curEstado', ['P', 'C', 'R'])
      ->whereHas('alumno.persona', function($query) use ($request) {
        if ($request->aluClave) {
          $query->where('aluClave', '=', $request->aluClave);
        }
        if ($request->aluMatricula) {
          $query->where('aluMatricula', '=', $request->aluMatricula);
        }

        if ($request->perApellido1) {
          $query->where('perApellido1', '=', $request->perApellido1);
        }
        if ($request->perApellido2) {
          $query->where('perApellido2', '=', $request->perApellido2);
        }
        if ($request->perNombre) {
          $query->where('perNombre', '=', $request->perNombre);
        }
      })
      ->whereHas('periodo', function($query) use ($request) {
        if ($request->periodo_id) {
          $query->where('id', '=', $request->periodo_id);
        }
      })
      ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
        if ($request->cgtGradoSemestre) {
          $query->where('cgtGradoSemestre', '=', $request->cgtGradoSemestre);
        }
        if ($request->programa_id) {
          $query->where('programa_id', '=', $request->programa_id);
        }
        if ($request->ubicacion_id) {
          $query->where('ubicacion_id', '=', $request->ubicacion_id);
        }
      });


    if($grupos->get()->isEmpty()) {
      return false;
    }

    $grupos = $grupos->get()->toArray();

    // obtener inscritos por cada grupo (grupo_id)
    $cursoIds = collect($grupos)->map(function ($item, $key) {
      return $item["id"];
    })->all();

    $inscritosByCursoIds = DB::table('inscritos')->whereIn('curso_id', $cursoIds)
      ->leftJoin("grupos", "inscritos.grupo_id", "=", "grupos.id")
      ->leftJoin("materias", "grupos.materia_id", "=", "materias.id")
      ->get();

    //hacer merge de cantidad de alumnos a grupos
    $grupos = collect($grupos);
    $grupos = $grupos->map(function ($item, $key) use ($inscritosByCursoIds) {

      $inscritosByCursoId = $inscritosByCursoIds->filter(function ($value, $key) use ($item) {
          return $item["id"] == $value->curso_id;
      });

      $item["sortByNombres"] = str_slug($item["alumno"]["persona"]["perApellido1"]
        . '-' . $item["alumno"]["persona"]["perApellido2"]
        . '-' . $item["alumno"]["persona"]["perNombre"], '-');


      $item["materias"] = $inscritosByCursoId;

      return $item;
    });


    $inscritosByCursoIds = $inscritosByCursoIds->unique("matClave");


    $inscritosByCursoIdsGuion = $inscritosByCursoIds->filter(function ($item, $key) {
      return (str_contains($item->matClave, "-"));
    })->sortBy("matClave");


    $inscritosByCursoIds = $inscritosByCursoIds->filter(function ($item, $key) {
      return !(str_contains($item->matClave, "-"));
    })->sortBy("matClave");


    $materias = $inscritosByCursoIds->merge($inscritosByCursoIdsGuion);


    $grupos = (object) [
      'grupos' => $grupos->sortBy("sortByNombres"),
      'materias' => $materias //->sortBy("matClave")
    ];

    return $grupos;
  }



  public function imprimir(Request $request)
  {
    $resumenGruposAlumnos = $this->resumenGruposAlumno($request);

    if(!$resumenGruposAlumnos) {
      alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada.')->showConfirmButton();
      return back()->withInput();
    }

    $grupos = $resumenGruposAlumnos->grupos;
    $materias = $resumenGruposAlumnos->materias;


// dd($materias);


    // dd($grupos->slice(5,5));

    $fechaActual = Carbon::now();

    // Unix
    setlocale(LC_TIME, 'es_ES.UTF-8');
    // En windows
    setlocale(LC_TIME, 'spanish');



    $nombreArchivo = 'pdf_resumen_grupos_alumno.pdf';
    $pdf = PDF::loadView('reportes.pdf.pdf_resumen_grupos_alumno', [
      "grupos" => $grupos,
      "nombreArchivo" => $nombreArchivo,
      "curEstado" => $request->curEstado,
      "fechaActual" => $fechaActual->toDateString(),
      "horaActual" => $fechaActual->toTimeString(),
      "materias" => $materias,
    ]);


    $pdf->setPaper('letter', 'portrait');
    $pdf->defaultFont = 'Times Sans Serif';

    return $pdf->stream($nombreArchivo);
    return $pdf->download($nombreArchivo);

    // dd($curso);
    // return response()->json($curso);
  }

  //trae los grados disponible de ese periodo.
  public function getGrados(Request $request, $periodo_id) {
    $grados = Cgt::with(['periodo', 'plan.programa'])
    ->whereHas('periodo', static function($query) use ($periodo_id) {
      if($periodo_id) {
        $query->where('id', $periodo_id);
      }
    })
    ->whereHas('plan.programa', static function($query) use ($request) {
      if($request->plan_id) {
        $query->where('id', $request->plan_id);
      }
      if($request->programa_id) {
        $query->where('programa_id', $request->programa_id);
      }
    })->get()->pluck('cgtGradoSemestre')->unique()->sort();

    if($request->ajax()) {
      return json_encode($grados);
    } else {
      return $grados;
    }
  }//getGrados.

}