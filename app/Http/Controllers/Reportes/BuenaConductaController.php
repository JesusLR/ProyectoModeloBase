<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Curso;
use App\Http\Models\Periodo;
use App\Http\Models\Pago;
use App\Http\Models\Minutario;
use App\Http\Models\Alumno;
use App\Http\Models\Departamento;
use App\Http\Models\Inscrito;

use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class BuenaConductaController extends Controller
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
    $anioActual = Carbon::now('America/Merida')->year;
    return View('reportes/buena_conducta.create',compact('anioActual'));
  }

  public function imprimir(Request $request)
  {
    $curso = Curso::with('alumno.persona', 'periodo', 'cgt.plan.programa.escuela.departamento.ubicacion.municipio.estado')
      ->whereHas('alumno.persona', function($query) use ($request)
      {
        if ($request->aluClave) {//CLAVE PAGO
          $query->where('aluClave', '=', $request->aluClave);
        }
        if ($request->aluMatricula) {
          $query->where('aluMatricula', '=', $request->aluMatricula);
        }
      })
      ->whereHas('cgt.plan.programa.escuela.departamento', function($query) use ($request) {

        if ($request->progClave) {
          $query->where('progClave', '=', $request->progClave);//
        }
      })
      ->whereHas('periodo', function($query) use ($request) {
        if ($request->perNumero) {
          $query->where('perNumero', $request->perNumero);//
        }

        if ($request->perAnio) {
          $query->where('perAnio', $request->perAnio);//
        }
      })
      ->whereHas('cgt', function($query) use ($request) {
        if ($request->cgtGradoSemestre) {
          $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);//
        }

        if ($request->cgtGrupo) {
          $query->where('cgtGrupo', $request->cgtGrupo);//
        }

      })->where("cursos.curEstado", "=", "R")->first();

      if (!$curso) {
        alert()->warning('Sin datos', "No hay regisros que cumplan con la información proporcionada. Favor de verificar")->showConfirmButton();
        return back()->withInput();
      }

    $alumno = Alumno::select('aluEstado')->where('aluClave',$request->aluClave)->first();

    if($alumno->aluEstado == 'B'){
      alert()->error('Error...', " El alumno esta dado de baja.")->showConfirmButton();
      return back()->withInput();
    }
    $periodo = Periodo::select('perAnioPago')->where('perAnio',$request->perAnio)->where('perNumero',$request->perNumero)->first();
    $pago = Pago::where('pagClaveAlu',$request->aluClave)->where('pagAnioPer',$periodo->perAnioPago)
    ->where(function($query){
      $query->where('pagConcPago','00')->orWhere('pagConcPago','99');
    })->first();

    if(!$pago){
      alert()->error('Error...', " El alumno no ha pagado su inscripción.")->showConfirmButton();
      return back()->withInput();
    }
    $minutario = Minutario::select('id')->where('minClavePago',$request->aluClave)->where('minTipo','CB')->first();
    $departamento = Departamento::select('depTituloDoc','depNombreDoc','depPuestoDoc','depNombreOficial')->where('id',$curso->periodo->departamento->id)->first();

    if($minutario ==  NULL)
    {
      $minutario = Minutario::create([
        "minAnio"         => $curso->periodo->perAnioPago,
        "minClavePago"    => $request->aluClave,
        "minDepartamento" => $curso->periodo->departamento->depClave,
        "minTipo"         => "CB",
        "minFecha"        => Carbon::now('America/Merida')->format("Y-m-d"),
    ]);
    }




    $fechaActual = Carbon::now('America/Merida');

    //variables que se mandan a la vista fuera del array


      $lugarCampus = $curso->periodo->departamento->ubicacion_id;
      $ubicacionEstado = "Yucatán";
      $ubicacionCiudad = "Mérida";

      if ($lugarCampus == 1)
      {
          $ubicacionEstado = "Yucatán";
          $ubicacionCiudad = "Mérida";
      }
      if ($lugarCampus == 2)
      {
          $ubicacionEstado = "Yucatán";
          $ubicacionCiudad = "Valladolid";
      }

      if ($lugarCampus == 3)
      {
          $ubicacionEstado = "Chetumal";
          $ubicacionCiudad = "Quintana Roo";
      }

    $nombreArchivo = 'pdf_buena_conducta';
    return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
          "curso" => $curso,
          "fechaActual" => $fechaActual,
          "nombreArchivo" => $nombreArchivo.'.pdf',
          "departamento" => $departamento,
          "minutario" => $minutario,
          "perAnio" => $request->perAnio,
          "ubicacionEstado" => $ubicacionEstado,
          "ubicacionCiudad" => $ubicacionCiudad
    ])->stream($nombreArchivo.'.pdf');

  }

}
