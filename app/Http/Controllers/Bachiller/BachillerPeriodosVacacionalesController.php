<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_periodos_vacaciones;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerPeriodosVacacionalesController extends Controller
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
        return view('bachiller.periodos_vacacionales.show-list');
    }

    public function list()
    {
        $bachiller_periodos_vacaciones = Bachiller_periodos_vacaciones::select(
            'bachiller_periodos_vacaciones.id',
            'bachiller_periodos_vacaciones.departamento_id',
            'bachiller_periodos_vacaciones.periodo_id',
            'bachiller_periodos_vacaciones.pvTipo',
            'bachiller_periodos_vacaciones.pvInicio',
            'bachiller_periodos_vacaciones.pvFinal',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.perAnio',
            'periodos.perNumero'
        )
        ->join('departamentos', 'bachiller_periodos_vacaciones.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'bachiller_periodos_vacaciones.periodo_id', '=', 'periodos.id')
        ->orderBy('bachiller_periodos_vacaciones.id', 'DESC');



        return DataTables::of($bachiller_periodos_vacaciones)
        ->filterColumn('ubicacion', function($query, $keyword) {
          $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
         
        })
        ->addColumn('ubicacion',function($query) {
            return $query->ubiNombre;
        })

        ->filterColumn('periodoAnio', function($query, $keyword) {
            $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
           
        })
        ->addColumn('periodoAnio',function($query) {
              return $query->perAnio;
        })

        ->filterColumn('periodoNumero', function($query, $keyword) {
            $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
           
        })
        ->addColumn('periodoNumero',function($query) {
              return $query->perNumero;
        })

        ->filterColumn('departamentoNombre', function($query, $keyword) {
            $query->whereRaw("CONCAT(depClave) like ?", ["%{$keyword}%"]);
           
        })
        ->addColumn('departamentoNombre',function($query) {
              return $query->depClave;
        })

        ->filterColumn('tipo', function($query, $keyword) {
            $query->whereRaw("CONCAT(pvTipo) like ?", ["%{$keyword}%"]);
           
        })

        ->addColumn('tipo',function($query) {
            if($query->pvTipo == "P"){
                return "Primavera";
            }
            if($query->pvTipo == "V"){
                return "Verano";
            }
            if($query->pvTipo == "I"){
                return "Invierno";
            }
        })

        ->filterColumn('fechaInicio', function($query, $keyword) {
            $query->whereRaw("CONCAT(pvInicio) like ?", ["%{$keyword}%"]);
           
        })
        ->addColumn('fechaInicio',function($query) {
            
            return Utils::fecha_string($query->pvInicio, $query->pvInicio);
        })

        ->filterColumn('fechaFin', function($query, $keyword) {
            $query->whereRaw("CONCAT(pvFinal) like ?", ["%{$keyword}%"]);
           
        })
        ->addColumn('fechaFin',function($query) {
            
            return Utils::fecha_string($query->pvFinal, $query->pvFinal);
        })
      
        
       
        ->addColumn('action', function($query) {

            $btnEditar = "";
            $btnEliminar = "";

            $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;
            $sistemas = Auth::user()->departamento_sistemas;

            if($ubicacion == $query->ubiClave || $sistemas == 1){
                $btnEditar = '<a href="/bachiller_periodos_vacacionales/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>';
                $btnEliminar = '<form id="delete_' . $query->id . '" action="bachiller_periodos_vacacionales/' . $query->id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';    
            }

            return '<a href="/bachiller_periodos_vacacionales/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>            
            '.$btnEditar
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();
        return view('bachiller.periodos_vacacionales.create', [
            'ubicaciones' => $ubicaciones
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
                'departamento_id'  => 'required',        
                'pvTipo'  => 'required',    
                'pvInicio'  => 'required',
                'pvFinal'  => 'required'               
               
           
       
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'periodo_id.required' => 'El campo Departamento es obligatorio.',
                'pvTipo.required' => 'El campo Tipo es obligatorio.',
                'pvInicio.required' => 'El campo Fecha inicio vacaciones es obligatorio.',
                'pvFinal.required' => 'El campo Fecha final vacaciones es obligatorio.'                
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_periodos_vacacionales/create')->withErrors($validator)->withInput();
        } else {
            try {

                Bachiller_periodos_vacaciones::create([
                    'departamento_id' => $request->departamento_id,
                    'periodo_id' => $request->periodo_id,
                    'pvTipo' => $request->pvTipo,
                    'pvInicio' => $request->pvInicio,
                    'pvFinal' => $request->pvFinal
                ]);


                alert('Escuela Modelo', 'El período vacacional se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('bachiller.bachiller_periodos_vacacionales.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('bachiller_periodos_vacacionales/create')->withInput();
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
        $bachiller_periodos_vacaciones = Bachiller_periodos_vacaciones::select(
            'bachiller_periodos_vacaciones.id',
            'bachiller_periodos_vacaciones.departamento_id',
            'bachiller_periodos_vacaciones.periodo_id',
            'bachiller_periodos_vacaciones.pvTipo',
            'bachiller_periodos_vacaciones.pvInicio',
            'bachiller_periodos_vacaciones.pvFinal',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.perAnio',
            'periodos.perNumero',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'ubicacion.id as ubicacion_id'
        )
        ->join('departamentos', 'bachiller_periodos_vacaciones.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'bachiller_periodos_vacaciones.periodo_id', '=', 'periodos.id')
        ->where('bachiller_periodos_vacaciones.id', $id)
        ->first();

        return view('bachiller.periodos_vacacionales.show', [
            'bachiller_periodos_vacaciones' => $bachiller_periodos_vacaciones
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
        $bachiller_periodos_vacaciones = Bachiller_periodos_vacaciones::select(
            'bachiller_periodos_vacaciones.id',
            'bachiller_periodos_vacaciones.departamento_id',
            'bachiller_periodos_vacaciones.periodo_id',
            'bachiller_periodos_vacaciones.pvTipo',
            'bachiller_periodos_vacaciones.pvInicio',
            'bachiller_periodos_vacaciones.pvFinal',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.perAnio',
            'periodos.perNumero',
            'ubicacion.id as ubicacion_id'
        )
        ->join('departamentos', 'bachiller_periodos_vacaciones.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('periodos', 'bachiller_periodos_vacaciones.periodo_id', '=', 'periodos.id')
        ->where('bachiller_periodos_vacaciones.id', $id)
        ->first();
        
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

        return view('bachiller.periodos_vacacionales.edit', [
            'bachiller_periodos_vacaciones' => $bachiller_periodos_vacaciones,
            "ubicaciones" => $ubicaciones
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
                'departamento_id'  => 'required',        
                'pvTipo'  => 'required',    
                'pvInicio'  => 'required',
                'pvFinal'  => 'required'               
               
           
       
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'periodo_id.required' => 'El campo Departamento es obligatorio.',
                'pvTipo.required' => 'El campo Tipo es obligatorio.',
                'pvInicio.required' => 'El campo Fecha inicio vacaciones es obligatorio.',
                'pvFinal.required' => 'El campo Fecha final vacaciones es obligatorio.'                
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_periodos_vacacionales/create')->withErrors($validator)->withInput();
        } else {
            try {

                $bachiller_periodos_vacaciones = Bachiller_periodos_vacaciones::where('bachiller_periodos_vacaciones.id', $id)->first();

                $bachiller_periodos_vacaciones->update([
                    'departamento_id' => $request->departamento_id,
                    'periodo_id' => $request->periodo_id,
                    'pvTipo' => $request->pvTipo,
                    'pvInicio' => $request->pvInicio,
                    'pvFinal' => $request->pvFinal
                ]);


                alert('Escuela Modelo', 'El período vacacional se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('bachiller.bachiller_periodos_vacacionales.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('bachiller_periodos_vacacionales/'.$id.'/edit')->withInput();
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
        $bachiller_periodos_vacaciones = Bachiller_periodos_vacaciones::findOrFail($id);
        try {
            if ($bachiller_periodos_vacaciones->delete()) {
                alert('Escuela Modelo', 'El periodo vacacional se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el periodo vacacional')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect('bachiller_periodos_vacacionales');
    }
}
