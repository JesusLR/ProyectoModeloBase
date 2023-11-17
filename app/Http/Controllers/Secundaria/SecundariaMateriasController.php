<?php

namespace App\Http\Controllers\Secundaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Plan;
use App\Http\Models\Prerequisito;
use App\Http\Models\Secundaria\Secundaria_grupos;
use App\Http\Models\Secundaria\Secundaria_materias;
use App\Http\Models\Secundaria\Secundaria_materias_acd;
use App\Http\Models\Ubicacion;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Auth;

class SecundariaMateriasController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('secundaria.materias.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $materias = Secundaria_materias::select('secundaria_materias.id as materia_id',
        'secundaria_materias.matClave',
        'secundaria_materias.matNombre', 
        'secundaria_materias.matSemestre', 
        'secundaria_materias.matPrerequisitos',
        'secundaria_materias.matVigentePlanPeriodoActual',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.depNombre',
        'ubicacion.ubiNombre')
        ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return DataTables::of($materias)->addColumn('action',function($query) {
            /*
            $btnPrerequisitos = '<a href="#" class="disabled button button--icon js-button js-ripple-effect" title="Pre-requisitos" style="color: gray; cursor: default;">
                <i class="material-icons">playlist_add_check</i>
            </a>';
            
            if ($query->matSemestre > 1) {
                $btnPrerequisitos = '<a href="secundaria_materia/prerequisitos/'.$query->materia_id.'" class="button button--icon js-button js-ripple-effect" title="Pre-requisitos">
                    <i class="material-icons">playlist_add_check</i>
                </a>';
            } 
            

            return '<div class="row">'
                . $btnPrerequisitos .
                '<a href="secundaria_materia/'.$query->materia_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                </a>
                <a href="secundaria_materia/'.$query->materia_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                <form id="delete_'.$query->materia_id.'" action="secundaria_materia/'.$query->materia_id.'" method="POST" style="display:inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <a href="#" data-id="'.$query->materia_id.'" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar ma">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
                */

                if (Auth::user()->departamento_sistemas == 1 )
                {
                        $btnPermisos = '<a href="secundaria_materia/'.$query->materia_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        <form id="delete_'.$query->materia_id.'" action="secundaria_materia/'.$query->materia_id.'" method="POST" style="display:inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <a href="#" data-id="'.$query->materia_id.'" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar ma">
                                <i class="material-icons">delete</i>
                            </a>
                        </form>';
                }
                else
                {
                        $btnPermisos = '';
                }

                $btnMateriasACD = "";

                

                $secundaria_materias_acd = Secundaria_materias_acd::where('secundaria_materia_id', $query->materia_id)
                ->whereNull('deleted_at')
                ->get();
                $totalacd = count($secundaria_materias_acd);

                if($totalacd > 0){
                    $btnMateriasACD = '<a href="' . route('secundaria.secundaria_materia.index_acd', ['materia_id' => $query->materia_id, 'plan_id' => $query->plan_id]) . '" class="button button--icon js-button js-ripple-effect" title="Materias ACD '.$totalacd.' (Agregar, Editar)">
                    <i class="material-icons">archive</i>
                    </a>';
                }else{
                    $btnMateriasACD = '<a href="' . route('secundaria.secundaria_materia.index_acd', ['materia_id' => $query->materia_id, 'plan_id' => $query->plan_id]) . '" class="button button--icon js-button js-ripple-effect" title="Agregar Materias ACD">
                    <i class="material-icons">archive</i>
                    </a>';
                }


             return '<div class="row">
                <a href="secundaria_materia/'.$query->materia_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                </a>'. $btnPermisos
                .$btnMateriasACD;
            })
        ->make(true);
    }

    public function listACD($materia_id, $plan_id = null)
    {
        $materias = Secundaria_materias_acd::select('secundaria_materias_acd.id',
        'secundaria_materias_acd.gpoGrado',
        'secundaria_materias_acd.gpoMatComplementaria',
        'secundaria_materias.matClave',
        'secundaria_materias.matNombre', 
        'secundaria_materias.matSemestre', 
        'secundaria_materias.matPrerequisitos',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.depNombre',
        'ubicacion.ubiNombre',
        'secundaria_materias.matVigentePlanPeriodoActual',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnio',
        'periodos.perAnioPago')
        ->join('secundaria_materias', 'secundaria_materias_acd.secundaria_materia_id', '=', 'secundaria_materias.id')
        ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'secundaria_materias_acd.periodo_id', '=', 'periodos.id')
        ->where('secundaria_materias_acd.secundaria_materia_id', '=', $materia_id)
        ->where('planes.id', '=', $plan_id)
        ->orderBy('secundaria_materias_acd.id', 'DESC');

        return DataTables::of($materias)
        

            // ->filterColumn('numero_periodo', function($query, $keyword) {
            //     $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
               
            //   })
            //   ->addColumn('numero_periodo',function($query) {
            //       return $query->perNumero;
            //   })

              ->filterColumn('anio', function($query, $keyword) {
                $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
               
              })
              ->addColumn('anio',function($query) {
                  return $query->perAnioPago;
              })

              ->filterColumn('materiaComplementaria', function($query, $keyword) {
                $query->whereRaw("CONCAT(gpoMatComplementaria) like ?", ["%{$keyword}%"]);
               
              })
              ->addColumn('materiaComplementaria',function($query) {
                  return $query->gpoMatComplementaria;
              })

              ->addColumn('action', function($query) {

                $btnBorrar = "";

                $departamento_sistemas = auth()->user()->departamento_sistemas;

                if($departamento_sistemas == 1){
                    $btnBorrar = '<form id="delete_' . $query->id . '" action="' . route('secundaria.secundaria_materia_acd.destroy_acd', ['id' => $query->id]) . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                }else{
                    $btnBorrar = "";
                }
  
                return '<a href="' . route('secundaria.secundaria_materia.show_acd', ['id' => $query->id]) . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="' . route('secundaria.secundaria_materia.edit_acd', ['id' => $query->id]) . '" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>'.$btnBorrar;
            })
         
        ->make(true);
    }

    public function create_acd($materia_id)
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $secundaria_materia = Secundaria_materias::select('secundaria_materias.id as materia_id',
        'secundaria_materias.matClave',
        'secundaria_materias.matNombre', 
        'secundaria_materias.matSemestre', 
        'secundaria_materias.matPrerequisitos',
        'secundaria_materias.plan_id',
        'planes.planClave',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiNombre',
        'ubicacion.ubiClave',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre',
        'secundaria_materias.matVigentePlanPeriodoActual')
        ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('secundaria_materias.id', $materia_id)
        ->first();

        return view('secundaria.materias.create_acd', [
            'ubicaciones' => $ubicaciones,
            'secundaria_materia' => $secundaria_materia
        ]);
    }

    public function store_acd(Request $request)
    {

        // return $request->periodo_id2;
       


        DB::beginTransaction();
        try {
            
            $materias = $request->materias_acd;

            foreach ($materias as $key => $materia) {
                $materia = explode('~',$materia);

                $existeClaveMateria = Secundaria_materias_acd::where("secundaria_materia_id", "=", $request->secundaria_materia_id)
                ->where("plan_id", "=", $request->plan_id)
                ->where("periodo_id", "=", $request->periodo_id2)
                ->where("gpoMatComplementaria", "=", $materia[6])
                ->first();
                if ($existeClaveMateria) {
                    alert()->error('Ups...', "La materia ACD $materia[6] ya existe. Favor de capturar otra clave de materia")->autoClose(9000)->showConfirmButton();
                    return back()->withInput();
                }

                Secundaria_materias_acd::create([
                    'secundaria_materia_id' => $materia[2],
                    'plan_id' => $materia[0],
                    'periodo_id' => $materia[1],
                    'gpoGrado' => $materia[7],
                    'gpoMatComplementaria' => $materia[6],
                ]);
            }


        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La Materia ACD se ha creado con éxito','success')->showConfirmButton()->autoClose(5000);
        return redirect()->back();
    }

    public function show_acd($id)
    {
        $materia_acd = Secundaria_materias_acd::select('secundaria_materias_acd.id',
        'secundaria_materias_acd.gpoGrado',
        'secundaria_materias_acd.gpoMatComplementaria',
        'secundaria_materias.matClave',
        'secundaria_materias.matNombre', 
        'secundaria_materias.matSemestre', 
        'secundaria_materias.matPrerequisitos',
        'secundaria_materias.id as secundaria_materia_id',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'secundaria_materias.matVigentePlanPeriodoActual',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnio',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre')
        ->join('secundaria_materias', 'secundaria_materias_acd.secundaria_materia_id', '=', 'secundaria_materias.id')
        ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'secundaria_materias_acd.periodo_id', '=', 'periodos.id')
        ->where('secundaria_materias_acd.id', '=', $id)
        ->first();

        return view('secundaria.materias.show_acd', [
            "materia_acd" => $materia_acd
        ]);
    }

    public function edit_acd($id)
    {
        $materia_acd = Secundaria_materias_acd::select('secundaria_materias_acd.id',
        'secundaria_materias_acd.gpoGrado',
        'secundaria_materias_acd.gpoMatComplementaria',
        'secundaria_materias.matClave',
        'secundaria_materias.matNombre', 
        'secundaria_materias.matSemestre', 
        'secundaria_materias.matPrerequisitos',
        'secundaria_materias.id as secundaria_materia_id',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'secundaria_materias.matVigentePlanPeriodoActual',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnio',
        'periodos.perAnioPago',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre')
        ->join('secundaria_materias', 'secundaria_materias_acd.secundaria_materia_id', '=', 'secundaria_materias.id')
        ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'secundaria_materias_acd.periodo_id', '=', 'periodos.id')
        ->where('secundaria_materias_acd.id', '=', $id)
        ->first();

        return view('secundaria.materias.edit_acd', [
            "materia_acd" => $materia_acd
        ]);
    }

    public function update_acd(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'periodo_id'       => 'required',
                'gpoMatComplementaria'       => 'required',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // if(intval($request->matPorcentajeParcial + $request->matPorcentajeOrdinario) > 100) {
        //     alert('Error', 'La suma de los porcentajes no debe ser mayor a 100%. Favor de verificar.', 'error')->showConfirmButton();
        //     return back()->withInput();
        // }

        
        $existeClaveMateria = Secundaria_materias_acd::where("secundaria_materia_id", "=", $request->secundaria_materia_id)
        ->where("plan_id", "=", $request->plan_id)
        ->where("periodo_id", "=", $request->periodo_id)
        ->where("gpoMatComplementaria", "=", $request->gpoMatComplementaria)
        ->first();

        if ($existeClaveMateria != "") {
            if ($existeClaveMateria->id != $id) {
                if ($existeClaveMateria) {
                    alert()->error('Ups...', "La materia complementaria $request->gpoMatComplementaria ya existe.")->autoClose(5000)->showConfirmButton();
                    return back()->withInput();
                }
            }
        }

        


        try {
            $materia = Secundaria_materias_acd::findOrFail($id);
            $materia->secundaria_materia_id                  = $request->secundaria_materia_id;
            $materia->plan_id                               = $request->plan_id;
            $materia->periodo_id                            = $request->periodo_id;
            $materia->gpoGrado                              = $request->gpoGrado;
            $materia->gpoMatComplementaria                  = $request->gpoMatComplementaria;
            $materia->save();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('secundaria_materia_acd/' . $id . '/edit')->withInput();
        }
        alert('Escuela Modelo', 'La Materia se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
    }
   
    public function destroy_acd($id)
    {
        if (User::permiso("materia") == "A" || User::permiso("materia") == "B") {

            $materia = Secundaria_materias_acd::select(
                'secundaria_materias_acd.id',
                'secundaria_materias_acd.gpoGrado',
                'secundaria_materias_acd.gpoMatComplementaria',
                'secundaria_materias.matClave',
                'secundaria_materias.matNombre',
                'secundaria_materias.matSemestre',
                'secundaria_materias.matPrerequisitos',
                'secundaria_materias.id as secundaria_materia_id',
                'planes.id as plan_id',
                'planes.planClave',
                'programas.id as programa_id',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.escNombre',
                'departamentos.id as departamento_id',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.id as ubicacion_id',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'secundaria_materias.matVigentePlanPeriodoActual',
                'periodos.id as periodo_id',
                'periodos.perNumero',
                'periodos.perAnio',
                'escuelas.id as escuela_id',
                'escuelas.escClave',
                'escuelas.escNombre'
            )
            ->join('secundaria_materias', 'secundaria_materias_acd.secundaria_materia_id', '=', 'secundaria_materias.id')
            ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('periodos', 'secundaria_materias_acd.periodo_id', '=', 'periodos.id')
            ->where('secundaria_materias_acd.id', '=', $id)
            ->first();

            $materia_acd = Secundaria_materias_acd::find($id);

            

            
            try {
                $programa_id = $materia->plan->programa_id;
                if (Utils::validaPermiso('materia', $programa_id)) {
                    alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                }

                $secundaria_grupos = Secundaria_grupos::where('secundaria_materia_acd_id', $materia->id)->first();
                if($secundaria_grupos == ""){

                    if ($materia_acd->delete()) {
                        alert('Escuela Modelo', 'La materia complementaria se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose(5000);
                    } else {
                        alert()->error('Error...', 'No se puedo eliminar la materia complementaria')->showConfirmButton();
                    }
                }else{
                    alert()->error('Ups...' . 'No se puede eliminar este registro debido que hay grupos cargados a esta materia complementaria')->showConfirmButton();

                }
    
               
                
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            }
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }

        return back();
    }
     /**
     * Show prerequisitos.
     *
     * @return \Illuminate\Http\Response
     */
    public function prerequisitos($id)
    {
        $materia = Secundaria_materias::where('id', $id)->with('plan.programa')->first();
        $materias = Secundaria_materias::where('plan_id', $materia->plan_id)->where('matSemestre', '<', $materia->matSemestre)->with('plan.programa')->get();

        return view('secundaria.materias.prerequisitos', [
            'materias' => $materias,
            'materia' => $materia
        ]);
    }

    public function index_acd($materia_id, $plan_id)
    {
        $materias_acd = Secundaria_materias::select(
        'secundaria_materias.id as secundaria_materia_id',
        'secundaria_materias.matClave',
        'secundaria_materias.matNombre', 
        'secundaria_materias.matSemestre', 
        'secundaria_materias.matPrerequisitos',
        'planes.id as plan_id',
        'planes.planClave',
        'programas.progNombre',
        'escuelas.escNombre',
        'departamentos.depNombre',
        'ubicacion.ubiNombre',
        'secundaria_materias.matVigentePlanPeriodoActual'
        )
        ->join('planes', 'secundaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('secundaria_materias.id', '=', $materia_id)
        ->where('planes.id', '=', $plan_id)
        ->first();

        return view('secundaria.materias.show-list-acd', [
            "materia_id" => $materia_id,
            "plan_id" => $plan_id,
            "materias_acd" => $materias_acd
        ]);
    }

    /**
     * Show user list.
     *
     */
    public function listPreRequisitos($id)
    {
        $prerequisito = Prerequisito::leftJoin("secundaria_materias", 'prerequisitos.materia_prerequisito_id', "=", "secundaria_materias.id")
            ->where('materia_id', $id)
            ->select('prerequisitos.id as id', 'secundaria_materias.matClave as matClave', 'secundaria_materias.matNombre as matNombre', 'secundaria_materias.id as materiaId');

        return Datatables::of($prerequisito)
            ->addColumn('action', function($prerequisito) {
                return '<div class="row">
                    <div class="col s1">
                        <a href="'.url('secundaria_materia/eliminarPrerequisito/'.$prerequisito->id.'/'.$prerequisito->materiaId).'" class="button button--icon js-button js-ripple-effect" title="Eliminar prerequisito">
                            <i class="material-icons">delete</i>
                        </a>
                    </div>
                </div>';
            })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agregarPreRequisitos(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'materia_id'    => 'required',
                'materia'       => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect ('secundaria_materia')->withErrors($validator)->withInput();
        } else {
            $materia_id = $request->materia_id;
            $materia = Secundaria_materias::where('id', $materia_id)->with('plan.programa')->first();




            if (Utils::validaPermiso('materia', $materia->plan->programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);

                return redirect('secundaria_materia/prerequisitos/'.$materia_id);
            }


            try {
                //INSERTA LOS PRE-REQUISITOS DE UNA MATERIA
                $prerequisito = $request->materia;
                Prerequisito::create([
                    'materia_id'                => $materia_id,
                    'materia_prerequisito_id'   => $prerequisito
                ]);

                $materia->matPrerequisitos  = $materia->matPrerequisitos + 1;
                $materia->save();


                alert('Escuela Modelo', 'Los Pre-requisitos se ha creado con éxito','success')->autoClose(1000);
                return back();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();

                return back()->withInput();
            }
        }
    }

     /**
     * Delete prerequisito.
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminarPrerequisito($id, $materia_id)
    {
        $prerequisito = Prerequisito::findOrFail($id);

        if ($prerequisito->delete()) {
            $materia = Secundaria_materias::where('id', $prerequisito->materia_id)->first();

            if ($materia->matPrerequisitos == 0) {
                $materia->matPrerequisitos = 0;
            }

            if ($materia->matPrerequisitos > 0) {
                $materia->matPrerequisitos  = $materia->matPrerequisitos - 1;
            }

            $materia->save();
        }
        alert('Escuela Modelo', 'El prerequisito se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose(5000);
        return back();
    }

    /**
     * Show materias.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMaterias(Request $request, $semestre, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Secundaria_materias::where([
                ['plan_id', '=', $plan_id],
                ['matSemestre', '=', $semestre]
            ])->get();

            return response()->json($materias);
        }
    }

        /**
     * Show materias.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMateriasByPlan(Request $request, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Secundaria_materias::where([
                ['plan_id', '=', $plan_id]
            ])->get();

            return response()->json($materias);
        }
    }

    /**
     * Show materias optativas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMateriasOptativas(Request $request, $plan_id)
    {
        if ($request->ajax()) {
            $materias = Secundaria_materias::where('plan_id',$plan_id)->where('matClasificacion','O')->get();
            return response()->json($materias);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (User::permiso("materia") == "A" || User::permiso("materia") == "B") {
            $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
            return view('secundaria.materias.create', [
                'ubicaciones' => $ubicaciones
            ]);
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);

            return redirect('secundaria_materia');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(),
        //     [
        //         'plan_id'           => 'required',
        //         'matClave'          => 'required',
        //         'matNombre'         => 'required',
        //         'matNombreCorto'    => 'required',
        //         'matSemestre'       => 'required'
        //     ]
        // );

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }

        $existeClaveMateria = Secundaria_materias::where("plan_id", "=", $request->plan_id)->where("matClave", "=", $request->matClave)->first();
        if ($existeClaveMateria) {
            alert()->error('Ups...', "La clave de materia ya existe. Favor de capturar otra clave de materia")->autoClose(5000);
            return back()->withInput();
        }


        DB::beginTransaction();
        try {
            
            $materias = $request->materias;

            foreach ($materias as $key => $materia) {
                $materia = explode('~',$materia);

                Secundaria_materias::create([
                    'plan_id'                   => $materia[0],
                    'matClave'                  => $materia[2],
                    'matNombre'                 => $materia[3],
                    'matNombreCorto'            => $materia[4],
                    'matVigentePlanPeriodoActual' => $materia[5],
                    'matSemestre'               => $materia[6],
                    'matCreditos'               => Utils::validaEmpty($materia[7]),
                    'matClasificacion'          => $materia[8] ? $materia[8] : null,
                    'matEspecialidad'           => $materia[9] ? $materia[9] : null,
                    'matTipoAcreditacion'       => $materia[10] ? $materia[10] : null,
                    'matPorcentajeParcial'      => Utils::validaEmpty($materia[11]),
                    'matPorcentajeOrdinario'    => Utils::validaEmpty($materia[12]),
                    'matNombreOficial'          => $materia[13] ? $materia[13] : null,
                    'matOrdenVisual'            => $materia[14] ? $materia[14] : null,
                    'matClaveEquivalente'       => null
                ]);
            }

            // $materia = Materia::create([
            //     'plan_id'                   => $request->plan_id,
            //     'matClave'                  => $request->matClave,
            //     'matNombre'                 => $request->matNombre,
            //     'matNombreCorto'            => $request->matNombreCorto,
            //     'matSemestre'               => $request->matSemestre,
            //     'matCreditos'               => Utils::validaEmpty($request->matCreditos),
            //     'matClasificacion'          => $request->matClasificacion,
            //     'matEspecialidad'           => $request->matEspecialidad,
            //     'matTipoAcreditacion'       => $request->matTipoAcreditacion,
            //     'matPorcentajeParcial'      => Utils::validaEmpty($request->matPorcentajeParcial),
            //     'matPorcentajeOrdinario'    => Utils::validaEmpty($request->matPorcentajeOrdinario),
            //     'matNombreOficial'          => $request->matNombreOficial,
            //     'matOrdenVisual'            => $request->matOrdenVisual,
            //     'matClaveEquivalente'       => $request->matClaveEquivalente
            // ]);

            
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La Materia se ha creado con éxito','success')->showConfirmButton()->autoClose(5000);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $materia = Secundaria_materias::with('plan')->findOrFail($id);

        return view('secundaria.materias.show', [
            'materia' => $materia
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (User::permiso("materia") == "A" || User::permiso("materia") == "B") {
            $materia = Secundaria_materias::with('plan')->findOrFail($id);
            $plan = Plan::where('id', '=', $materia->plan->id)->first();
            
            return view('secundaria.materias.edit', [
                'materia' => $materia,
                'plan' => $plan
            ]);
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('secundaria_materia');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'matClave'          => 'required',
                'matNombre'         => 'required',
                'matNombreCorto'    => 'required',
                'matSemestre'       => 'required'
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if(intval($request->matPorcentajeParcial + $request->matPorcentajeOrdinario) > 100) {
            alert('Error', 'La suma de los porcentajes no debe ser mayor a 100%. Favor de verificar.', 'error')->showConfirmButton();
            return back()->withInput();
        }

        
        $existeClaveMateria = Secundaria_materias::where("plan_id", "=", $request->plan_id)->where("matClave", "=", $request->matClave)->first();


        if (($request->matClaveAnterior != $request->matClave) && $existeClaveMateria) {
            alert()->error('Ups...', "La clave de materia ya existe. Favor de capturar otra clave de materia")->autoClose(5000);
            return back()->withInput();
        }

        try {
            $materia = Secundaria_materias::findOrFail($id);
            $materia->matClave                  = $request->matClave;
            $materia->matNombre                 = $request->matNombre;
            $materia->matNombreCorto            = $request->matNombreCorto;
            $materia->matSemestre               = $request->matSemestre;
            $materia->matCreditos               = Utils::validaEmpty($request->matCreditos);
            $materia->matClasificacion          = $request->matClasificacion;
            $materia->matEspecialidad           = $request->matEspecialidad;
            $materia->matTipoAcreditacion       = $request->matTipoAcreditacion;
            $materia->matPorcentajeParcial      = Utils::validaEmpty($request->matPorcentajeParcial);
            $materia->matPorcentajeOrdinario    = Utils::validaEmpty($request->matPorcentajeOrdinario);
            $materia->matNombreOficial          = $request->matNombreOficial;
            $materia->matOrdenVisual            = $request->matOrdenVisual;
            $materia->matClaveEquivalente       = $request->matClaveEquivalente;
            $materia->matVigentePlanPeriodoActual = $request->matVigentePlanPeriodoActual;
            $materia->save();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
            return redirect('secundaria_materia/' . $id . '/edit')->withInput();
        }
        alert('Escuela Modelo', 'La Materia se ha actualizado con éxito','success')->showConfirmButton();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::permiso("materia") == "A" || User::permiso("materia") == "B") {
            $materia = Secundaria_materias::findOrFail($id);
            try {
                $programa_id = $materia->plan->programa_id;
                if (Utils::validaPermiso('materia',$programa_id)) {
                    alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                }
                if ($materia->delete()) {
                    alert('Escuela Modelo', 'La materia se ha eliminado con éxito','success')->showConfirmButton()->autoClose(5000);
                } else {
                    alert()->error('Error...', 'No se puedo eliminar la materia')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            }
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        }

        return redirect('secundaria_materia');
    }
}
