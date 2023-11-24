<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Models\Cgt;
use App\Models\Grupo;
use App\Http\Helpers\Utils;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Inscrito;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CopiarGrupoController extends Controller
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


  public function index(){
    return view('copiargrupo.create');
  }



  public function copiarGrupoAlumnos(Request $request)
  {

    // dd($request->list_grupos, $request->list_grupos_copia);
    $inscritosGrupo = Inscrito::with("curso.cgt")->where("grupo_id", "=", $request->list_grupos)->get();

    $grupoCopia = Grupo::where("id", "=", $request->list_grupos_copia)->first();
    $inscritosGrupoCopia = Inscrito::where("grupo_id", "=", $request->list_grupos_copia)->first();


    $cgtGrupoCopia = Cgt::where("plan_id", "=", $grupoCopia->plan_id)
      ->where("periodo_id", "=", $grupoCopia->periodo_id)
      ->where("cgtGradoSemestre", "=", $grupoCopia->gpoSemestre)
      ->where("cgtTurno", "=", $grupoCopia->gpoTurno)
    ->first();




    if (!$inscritosGrupoCopia) {
      foreach ($inscritosGrupo as $inscrito) {
        if ($inscrito->curso->cgt->id == $cgtGrupoCopia->id) {
          $inscrito = Inscrito::create([
            "curso_id" => $inscrito->curso->id,
            "grupo_id" => $cgtGrupoCopia->id
          ]);
        }
      }
  
      alert('Escuela Modelo', 'Alumnos copiados correctamente','success');
      return redirect()->back()->withInput();
    } else {
      alert()->error('Error...', "El grupo de destino ya tiene inscritos")->showConfirmButton();
      return redirect()->back()->withInput();
    }



  }


  public function listGruposCopiar(Request $request)
  {
    $grupo = Grupo::with("materia", "plan", "periodo")
      ->whereHas('periodo', function($query) use ($request) {
        if ($request->perNumero) {
          $query->where('perNumero', $request->perNumero);//
        }
        if ($request->perAnio) {
          $query->where('perAnio', $request->perAnio);//
        }
      })
      ->whereHas('plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
        if ($request->ubiClave) {
          $query->where('ubiClave', $request->ubiClave);//
        }
        if ($request->progClave) {
          $query->where('progClave', $request->progClave);//
        }
        if ($request->planClave) {
          $query->where('planClave', $request->planClave);//
        }
      })
      ->whereHas('materia', function($query) use ($request) {
        if ($request->matClave) {
          $query->where('matClave', $request->matClave);//
        }
        if ($request->matNombre) {
          $query->where('matNombre', 'like', "%" . $request->matClave . "%");//
        }
      });

      if ($request->gpoClave) {
        $grupo = $grupo->where("gpoClave", "=", $request->gpoClave);
      }
      $grupo = $grupo->where("estado_act", "=", "A");

    $grupo = $grupo->get();


    return response()->json($grupo);
  }

  public function listGruposCopia(Request $request)
  {
    $grupo = Grupo::where("id", "=", $request->grupoId)->first();


    $grupos = Grupo::with("materia", "plan", "periodo")
      ->where("plan_id", "=", $grupo->plan_id)
      ->where("id", "<>", $grupo->id)
      ->where("estado_act", "=", "A")
    ->get();

    return response()->json($grupos);
  }
}