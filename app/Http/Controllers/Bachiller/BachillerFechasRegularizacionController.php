<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_extraordinarios;
use App\Http\Models\Bachiller\Bachiller_fechas_regularizacion;
use App\Http\Models\Ubicacion;
use Hamcrest\Util;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerFechasRegularizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bachiller.fechas_regularizacion.show-list');
    }

    public function list()
    {
        $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::select(
            'bachiller_fechas_regularizacion.id',
            'bachiller_fechas_regularizacion.plan_id',
            'bachiller_fechas_regularizacion.periodo_id',
            'bachiller_fechas_regularizacion.frImporteAcomp',
            'bachiller_fechas_regularizacion.frImporteRecursamiento',
            'bachiller_fechas_regularizacion.frMaximoAcomp',
            'bachiller_fechas_regularizacion.frMaximoRecursamiento',
            'bachiller_fechas_regularizacion.frFechaInicioInscripcion',
            'bachiller_fechas_regularizacion.frFechaFinInscripcion',
            'bachiller_fechas_regularizacion.frFechaInicioCursos',
            'bachiller_fechas_regularizacion.frFechaFinCursos',
            'bachiller_fechas_regularizacion.frEstado',        
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'planes.planClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'programas.progClave'
        )
        ->join('periodos', 'bachiller_fechas_regularizacion.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_fechas_regularizacion.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

  
        return DataTables::of($bachiller_fechas_regularizacion)
            ->filterColumn('numero_periodo', function($query, $keyword) {
              $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
             
            })
            ->addColumn('numero_periodo',function($query) {
                return $query->perNumero;
            })

            ->filterColumn('anio_periodo', function($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('anio_periodo',function($query) {
                  return $query->perAnio;
            })

       
            ->filterColumn('ubicacion', function($query, $keyword) {
                $query->whereRaw("CONCAT(ubiClave) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('ubicacion',function($query) {
                  return $query->ubiClave;
            })

            ->filterColumn('departamento', function($query, $keyword) {
                $query->whereRaw("CONCAT(depClave) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('departamento',function($query) {
                  return $query->depClave;
            })

            ->filterColumn('escuela', function($query, $keyword) {
                $query->whereRaw("CONCAT(escClave) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('escuela',function($query) {
                  return $query->escClave;
            })

            ->filterColumn('programa_', function($query, $keyword) {
                $query->whereRaw("CONCAT(progClave) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('programa_',function($query) {
                  return $query->progClave;
            })

            ->filterColumn('plan', function($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('plan',function($query) {
                  return $query->planClave;
            })

            ->filterColumn('frFechaInicioInscripcion', function($query, $keyword) {
                $query->whereRaw("CONCAT(frFechaInicioInscripcion) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('frFechaInicioInscripcion',function($query) {
                $dia= \Carbon\Carbon::parse($query->frFechaInicioInscripcion)->format('d');
                $meses= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->frFechaInicioInscripcion)->format('m'));
                $year= \Carbon\Carbon::parse($query->frFechaInicioInscripcion)->format('Y');

                return $dia.'-'.$meses.'-'.$year;
                  
            })

            ->filterColumn('frFechaFinInscripcion', function($query, $keyword) {
                $query->whereRaw("CONCAT(frFechaFinInscripcion) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('frFechaFinInscripcion',function($query) {
                $dia2= \Carbon\Carbon::parse($query->frFechaFinInscripcion)->format('d');
                $meses2= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->frFechaFinInscripcion)->format('m'));
                $year2= \Carbon\Carbon::parse($query->frFechaFinInscripcion)->format('Y');

                return $dia2.'-'.$meses2.'-'.$year2;
                  
            })

            ->filterColumn('frFechaInicioCursos', function($query, $keyword) {
                $query->whereRaw("CONCAT(frFechaInicioCursos) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('frFechaInicioCursos',function($query) {
                $dia3= \Carbon\Carbon::parse($query->frFechaInicioCursos)->format('d');
                $meses3= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->frFechaInicioCursos)->format('m'));
                $year3= \Carbon\Carbon::parse($query->frFechaInicioCursos)->format('Y');

                return $dia3.'-'.$meses3.'-'.$year3;
                  
            })

            ->filterColumn('frFechaFinCursos', function($query, $keyword) {
                $query->whereRaw("CONCAT(frFechaFinCursos) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('frFechaFinCursos',function($query) {
                $dia4= \Carbon\Carbon::parse($query->frFechaFinCursos)->format('d');
                $meses4= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->frFechaFinCursos)->format('m'));
                $year4= \Carbon\Carbon::parse($query->frFechaFinCursos)->format('Y');

                return $dia4.'-'.$meses4.'-'.$year4;
                  
            })
           
            ->addColumn('action', function($query) {
  
                $btnEliminar = "";
                $btnEditar = "";

                if(Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave == $query->ubiClave || Auth::user()->departamento_sistemas == 1){
                    $btnEliminar = '<form id="delete_' . $query->id . '" action="/bachiller_fechas_regularizacion/' . $query->id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                    $btnEditar = '<a href="/bachiller_fechas_regularizacion/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
                }

                return '<a href="/bachiller_fechas_regularizacion/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                .$btnEditar
                .$btnEliminar;
            })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         // Mostrar el conmbo solo las ubicaciones correspondientes 
        if(auth()->user()->campus_cme == 1 || auth()->user()->campus_cva == 1){
            $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();
        }
    
        if(auth()->user()->campus_cch == 1){
            $ubicaciones = Ubicacion::where('id', 3)->get();
        }
        return view('bachiller.fechas_regularizacion.create', [
            "ubicaciones" => $ubicaciones
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id'  => 'required',
                'plan_id'  => 'required',                
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',                
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_fechas_regularizacion/create')->withErrors($validator)->withInput();
        } else {
            try {

                $Bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::where('plan_id', '=', $request->plan_id)
                ->where('periodo_id', '=', $request->periodo_id)
                ->where('frImporteAcomp', '=', $request->frImporteAcomp)
                ->where('frImporteRecursamiento', '=', $request->frImporteRecursamiento)
                ->where('frFechaInicioInscripcion', '=', $request->frFechaInicioInscripcion)
                ->where('frFechaFinInscripcion', '=', $request->frFechaFinInscripcion)
                ->where('frFechaInicioCursos', '=', $request->frFechaInicioCursos)
                ->where('frFechaFinCursos', '=', $request->frFechaFinCursos)
                ->first();

                if (!empty($Bachiller_fechas_regularizacion)) 
                {
                    alert()->error('Error...', 'La información proporcioanda ya se encuentra registrada')->showConfirmButton();
                    return redirect('bachiller_fechas_regularizacion/create')->withInput();
                }

                Bachiller_fechas_regularizacion::create([
                    'plan_id' => $request->plan_id,
                    'periodo_id' => $request->periodo_id,
                    'frImporteAcomp' => $request->frImporteAcomp,
                    'frImporteRecursamiento' => $request->frImporteRecursamiento,
                    'frMaximoAcomp' => $request->frMaximoAcomp,
                    'frMaximoRecursamiento' => $request->frMaximoRecursamiento,
                    'frFechaInicioInscripcion' => $request->frFechaInicioInscripcion,
                    'frFechaFinInscripcion' => $request->frFechaFinInscripcion,
                    'frFechaInicioCursos' => $request->frFechaInicioCursos,
                    'frFechaFinCursos' => $request->frFechaFinCursos,
                    'frEstado' => $request->frEstado
                ]);

                alert('Escuela Modelo', 'Las fechas de regularización se han creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('bachiller.bachiller_fechas_regularizacion.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('bachiller_fechas_regularizacion/create')->withInput();
            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::select(
            'bachiller_fechas_regularizacion.id',
            'bachiller_fechas_regularizacion.plan_id',
            'bachiller_fechas_regularizacion.periodo_id',
            'bachiller_fechas_regularizacion.frImporteAcomp',
            'bachiller_fechas_regularizacion.frImporteRecursamiento',
            'bachiller_fechas_regularizacion.frMaximoAcomp',
            'bachiller_fechas_regularizacion.frMaximoRecursamiento',
            'bachiller_fechas_regularizacion.frFechaInicioInscripcion',
            'bachiller_fechas_regularizacion.frFechaFinInscripcion',
            'bachiller_fechas_regularizacion.frFechaInicioCursos',
            'bachiller_fechas_regularizacion.frFechaFinCursos',
            'bachiller_fechas_regularizacion.frEstado',        
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'planes.planClave',
            'ubicacion_id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre'
        )
        ->join('periodos', 'bachiller_fechas_regularizacion.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_fechas_regularizacion.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_fechas_regularizacion.id', $id)
        ->first();

        return view('bachiller.fechas_regularizacion.show', [
            "bachiller_fechas_regularizacion" => $bachiller_fechas_regularizacion
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::select(
            'bachiller_fechas_regularizacion.id',
            'bachiller_fechas_regularizacion.plan_id',
            'bachiller_fechas_regularizacion.periodo_id',
            'bachiller_fechas_regularizacion.frImporteAcomp',
            'bachiller_fechas_regularizacion.frImporteRecursamiento',
            'bachiller_fechas_regularizacion.frMaximoAcomp',
            'bachiller_fechas_regularizacion.frMaximoRecursamiento',
            'bachiller_fechas_regularizacion.frFechaInicioInscripcion',
            'bachiller_fechas_regularizacion.frFechaFinInscripcion',
            'bachiller_fechas_regularizacion.frFechaInicioCursos',
            'bachiller_fechas_regularizacion.frFechaFinCursos',
            'bachiller_fechas_regularizacion.frEstado',        
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'planes.planClave',
            'ubicacion_id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre'
        )
        ->join('periodos', 'bachiller_fechas_regularizacion.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_fechas_regularizacion.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_fechas_regularizacion.id', $id)
        ->first();

        return view('bachiller.fechas_regularizacion.edit', [
            "bachiller_fechas_regularizacion" => $bachiller_fechas_regularizacion
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id'  => 'required',
                'plan_id'  => 'required',
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_fechas_regularizacion/create')->withErrors($validator)->withInput();
        } else {
            try {

                $Bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::where('plan_id', '=', $request->plan_id)
                ->where('periodo_id', '=', $request->periodo_id)
                ->where('frImporteAcomp', '=', $request->frImporteAcomp)
                ->where('frImporteRecursamiento', '=', $request->frImporteRecursamiento)
                ->where('frFechaInicioInscripcion', '=', $request->frFechaInicioInscripcion)
                ->where('frFechaFinInscripcion', '=', $request->frFechaFinInscripcion)
                ->where('frFechaInicioCursos', '=', $request->frFechaInicioCursos)
                ->where('frFechaFinCursos', '=', $request->frFechaFinCursos)
                ->first();

                

                if (!empty($Bachiller_fechas_regularizacion)) 
                {
                    if($Bachiller_fechas_regularizacion->id != $id){
                        alert()->error('Error...', 'La información proporcioanda ya se encuentra registrada')->showConfirmButton();
                        return redirect('bachiller_fechas_regularizacion/create')->withInput();
                    }
                    
                }

                $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::findOrFail($id);
                $bachiller_fechas_regularizacion->update([
                    'plan_id' => $request->plan_id,
                    'periodo_id' => $request->periodo_id,
                    'frImporteAcomp' => $request->frImporteAcomp,
                    'frImporteRecursamiento' => $request->frImporteRecursamiento,
                    'frMaximoAcomp' => $request->frMaximoAcomp,
                    'frMaximoRecursamiento' => $request->frMaximoRecursamiento,
                    'frFechaInicioInscripcion' => $request->frFechaInicioInscripcion,
                    'frFechaFinInscripcion' => $request->frFechaFinInscripcion,
                    'frFechaInicioCursos' => $request->frFechaInicioCursos,
                    'frFechaFinCursos' => $request->frFechaFinCursos,
                    'frEstado' => $request->frEstado
                ]);


                $bachiller_extraordinarios = Bachiller_extraordinarios::where('bachiller_fecha_regularizacion_id', $bachiller_fechas_regularizacion->id)
                ->whereNull('deleted_at')
                ->get();

                if(count($bachiller_extraordinarios) > 0){
                    $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::findOrFail($id);
                    $costoRecursamiento = $bachiller_fechas_regularizacion->frImporteRecursamiento;
                    $costoAcompa = $bachiller_fechas_regularizacion->frImporteAcomp;
    
                    foreach($bachiller_extraordinarios as $bachiller_extraordinario){
    
                        if($bachiller_extraordinario->extTipo == "RECURSAMIENTO"){
                            DB::update("UPDATE bachiller_extraordinarios SET extPago=$costoRecursamiento WHERE id=$bachiller_extraordinario->id");
                        }
    
                        if($bachiller_extraordinario->extTipo == "ACOMPAÑAMIENTO"){
                            DB::update("UPDATE bachiller_extraordinarios SET extPago=$costoAcompa WHERE id=$bachiller_extraordinario->id");
                        }
                        
                    }
                }

                

                // "extTipo": "RECURSAMIENTO",

                alert('Escuela Modelo', 'Las fechas de recursamiento se han actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return back();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return back();
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $bachiller_fechas_regularizacion = Bachiller_fechas_regularizacion::findOrFail($id);

       $bachiller_extraordinarios = Bachiller_extraordinarios::where('bachiller_fecha_regularizacion_id', $bachiller_fechas_regularizacion->id)
       ->whereNull('deleted_at')
       ->get();

       if(count($bachiller_extraordinarios) > 0){
            alert()->warning('Error...', 'No se puedo eliminar las fechas de regularización debido que hay recuperativos relacionados')->showConfirmButton();
            return back();
       }

        try {
            if ($bachiller_fechas_regularizacion->delete()) {
                alert('Escuela Modelo', 'Las fechas de regularización se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose(5000);
            } else {
                alert()->error('Error...', 'No se puedo eliminar las fechas de regularización')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }


        return redirect('bachiller_fechas_regularizacion');
    }
}
