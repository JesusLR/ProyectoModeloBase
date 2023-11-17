<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Bachiller\Bachiller_porcentajes;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use App\Models\User;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerPorcentajeController extends Controller
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
        return view('bachiller.porcentaje.show-list');
    }


    public function list()
    {
        $periodos = Bachiller_porcentajes::select(
            'bachiller_porcentajes.id',
            'departamentos.id as departamento_id',
            'departamentos.depNombre',
            'periodos.id as periodo_id',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'bachiller_porcentajes.porc_septiembre',
            'bachiller_porcentajes.porc_octubre',
            'bachiller_porcentajes.porc_noviembre',
            'bachiller_porcentajes.porc_periodo1',
            'bachiller_porcentajes.porc_diciembre',
            'bachiller_porcentajes.porc_enero',
            'bachiller_porcentajes.porc_febrero',
            'bachiller_porcentajes.porc_marzo',
            'bachiller_porcentajes.porc_periodo2',
            'bachiller_porcentajes.porc_abril',
            'bachiller_porcentajes.porc_mayo',
            'bachiller_porcentajes.porc_junio',
            'bachiller_porcentajes.porc_periodo3',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre'
        )
        ->join('departamentos', 'bachiller_porcentajes.departamento_id', '=', 'departamentos.id')
        ->join('periodos', 'bachiller_porcentajes.periodo_id', '=', 'periodos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return DataTables::of($periodos)

        ->filterColumn('ubicacion',function($query,$keyword){
            $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubicacion',function($query){
            return $query->ubiNombre;
        })

        ->filterColumn('anio',function($query,$keyword){
            $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('anio',function($query){
            return $query->perAnio;
        })
              
        
        ->addColumn('action',function($query){
            return '<a href="bachiller_porcentaje/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="bachiller_porcentaje/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            
            <form id="delete_' . $query->id . '" action="bachiller_porcentaje/' . $query->id . '" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                    <i class="material-icons">delete</i>
                </a>
            </form>';
        })->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2,3])->get();

        return view('bachiller.porcentaje.create', [
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

        $validator = Validator::make($request->all(),
            [
                'departamento_id' => 'required',
                'periodo_id' => 'required',
                'porc_septiembre' => 'required',
                'porc_octubre' => 'required',
                'porc_noviembre' => 'required',
                'porc_enero' => 'required',
                'porc_febrero' => 'required',
                'porc_marzo' => 'required',
                'porc_abril' => 'required',
                'porc_mayo' => 'required',
                'porc_junio' => 'required'

            ],
            [
                'departamento_id.required' => "El campo departamento es obligatorio",
                'periodo_id.required' => "El campo periodo es obligatorio",
                'porc_septiembre.required' => "El campo porcentaje septiembre es obligatorio",
                'porc_octubre.required' => "El campo porcentaje octubre es obligatorio",
                'porc_noviembre.required' => "El campo porcentaje noviembre es obligatorio",
                'porc_enero.required' => "El campo porcentaje enero es obligatorio",
                'porc_febrero.required' => "El campo porcentaje febrero es obligatorio",
                'porc_marzo.required' => "El campo porcentaje marzo es obligatorio",
                'porc_abril.required' => "El campo porcentaje abril es obligatorio",
                'porc_mayo.required' => "El campo porcentaje mayo es obligatorio",
                'porc_junio.required' => "El campo porcentaje junio es obligatorio"


            ]
        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            
            
            $porc_septiembre = $request->porc_septiembre;
            $porc_octubre = $request->porc_octubre;
            $porc_noviembre = $request->porc_noviembre;
            $porc_periodo1 = $porc_septiembre + $porc_octubre + $porc_noviembre;
            $porc_enero = $request->porc_enero;
            $porc_febrero = $request->porc_febrero;
            $porc_marzo = $request->porc_marzo;
            $porc_periodo2 = $porc_enero + $porc_febrero + $porc_marzo;
            $porc_abril = $request->porc_abril;
            $porc_mayo = $request->porc_mayo;
            $porc_junio = $request->porc_junio;
            $porc_periodo3 = $porc_abril + $porc_mayo + $porc_junio;


            // valida que el porcentaje total no sea mayor a 100
            if($porc_periodo1 > 100){
                alert('Escuela Modelo', 'El porcentaje del período 1 es mayor a 100','info')->showConfirmButton();
                return back()->withInput();
            }

            if($porc_periodo2 > 100){
                alert('Escuela Modelo', 'El porcentaje del período 1 es mayor a 100','info')->showConfirmButton();
                return back()->withInput();
            }


            if($porc_periodo3 > 100){
                alert('Escuela Modelo', 'El porcentaje del período 1 es mayor a 100','info')->showConfirmButton();
                return back()->withInput();
            }

            Bachiller_porcentajes::create([
                'departamento_id' => $request->departamento_id,
                'periodo_id' => $request->periodo_id,
                'porc_septiembre' => $porc_septiembre,
                'porc_octubre' => $porc_septiembre,
                'porc_noviembre' => $porc_noviembre,
                'porc_periodo1' => $porc_periodo1,
                'porc_diciembre' => 0,
                'porc_enero' => $porc_enero,
                'porc_febrero' => $porc_febrero,
                'porc_marzo' => $porc_marzo,
                'porc_periodo2' => $porc_periodo2,
                'porc_abril' => $porc_abril,
                'porc_mayo' => $porc_mayo,
                'porc_junio' => $porc_junio,
                'porc_periodo3' => $porc_periodo3
            ]);

            alert('Escuela Modelo', 'Los porcentajes han creado con éxito','success')->showConfirmButton();
            return redirect()->route('bachiller.bachiller_porcentaje.index');

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
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
        $porcentajes = Bachiller_porcentajes::where('id', $id)->first();
        $departamento = Departamento::where('id', $porcentajes->departamento_id)->first();
        $ubicacion = Ubicacion::where('id', $departamento->ubicacion_id)->first();
        $escuela = Escuela::where('departamento_id', $departamento->id)->first();
        $periodo = Periodo::where('id', $porcentajes->periodo_id)->first();


        return view('bachiller.porcentaje.show', [
            'ubicacion' => $ubicacion,
            'porcentajes' => $porcentajes,
            'departamento' => $departamento,
            'escuela' => $escuela,
            'periodo' => $periodo
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
        $porcentajes = Bachiller_porcentajes::where('id', $id)->first();
        $departamento = Departamento::where('id', $porcentajes->departamento_id)->first();
        $ubicacion = Ubicacion::where('id', $departamento->ubicacion_id)->first();


        return view('bachiller.porcentaje.edit', [
            'ubicacion' => $ubicacion,
            'porcentajes' => $porcentajes,
            'departamento' => $departamento
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
        
        $validator = Validator::make($request->all(),
            [
                'departamento_id' => 'required',
                'periodo_id' => 'required',
                'porc_septiembre' => 'required',
                'porc_octubre' => 'required',
                'porc_noviembre' => 'required',
                'porc_enero' => 'required',
                'porc_febrero' => 'required',
                'porc_marzo' => 'required',
                'porc_abril' => 'required',
                'porc_mayo' => 'required',
                'porc_junio' => 'required'

            ],
            [
                'departamento_id.required' => "El campo departamento es obligatorio",
                'periodo_id.required' => "El campo periodo es obligatorio",
                'porc_septiembre.required' => "El campo porcentaje septiembre es obligatorio",
                'porc_octubre.required' => "El campo porcentaje octubre es obligatorio",
                'porc_noviembre.required' => "El campo porcentaje noviembre es obligatorio",
                'porc_enero.required' => "El campo porcentaje enero es obligatorio",
                'porc_febrero.required' => "El campo porcentaje febrero es obligatorio",
                'porc_marzo.required' => "El campo porcentaje marzo es obligatorio",
                'porc_abril.required' => "El campo porcentaje abril es obligatorio",
                'porc_mayo.required' => "El campo porcentaje mayo es obligatorio",
                'porc_junio.required' => "El campo porcentaje junio es obligatorio"


            ]
        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            
            
            $porc_septiembre = $request->porc_septiembre;
            $porc_octubre = $request->porc_octubre;
            $porc_noviembre = $request->porc_noviembre;
            $porc_periodo1 = $porc_septiembre + $porc_octubre + $porc_noviembre;
            $porc_enero = $request->porc_enero;
            $porc_febrero = $request->porc_febrero;
            $porc_marzo = $request->porc_marzo;
            $porc_periodo2 = $porc_enero + $porc_febrero + $porc_marzo;
            $porc_abril = $request->porc_abril;
            $porc_mayo = $request->porc_mayo;
            $porc_junio = $request->porc_junio;
            $porc_periodo3 = $porc_abril + $porc_mayo + $porc_junio;


            // valida que el porcentaje total no sea mayor a 100
            if($porc_periodo1 > 100){
                alert('Escuela Modelo', 'El porcentaje del período 1 es mayor a 100','info')->showConfirmButton();
                return back()->withInput();
            }

            if($porc_periodo2 > 100){
                alert('Escuela Modelo', 'El porcentaje del período 1 es mayor a 100','info')->showConfirmButton();
                return back()->withInput();
            }


            if($porc_periodo3 > 100){
                alert('Escuela Modelo', 'El porcentaje del período 1 es mayor a 100','info')->showConfirmButton();
                return back()->withInput();
            }

            $porcentaje_edit = Bachiller_porcentajes::where('id', $id)->first();

            $porcentaje_edit->update([
                'departamento_id' => $request->departamento_id,
                'periodo_id' => $request->periodo_id,
                'porc_septiembre' => $porc_septiembre,
                'porc_octubre' => $porc_septiembre,
                'porc_noviembre' => $porc_noviembre,
                'porc_periodo1' => $porc_periodo1,
                'porc_diciembre' => 0,
                'porc_enero' => $porc_enero,
                'porc_febrero' => $porc_febrero,
                'porc_marzo' => $porc_marzo,
                'porc_periodo2' => $porc_periodo2,
                'porc_abril' => $porc_abril,
                'porc_mayo' => $porc_mayo,
                'porc_junio' => $porc_junio,
                'porc_periodo3' => $porc_periodo3
            ]);

            alert('Escuela Modelo', 'Los porcentajes han actualizado con éxito','success')->showConfirmButton();
            return redirect()->route('bachiller.bachiller_porcentaje.index');

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
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
        $empleado = Bachiller_porcentajes::findOrFail($id);
        try {
            if ($empleado->delete()) {
                alert('Escuela Modelo', 'Los porcentajes seleccionados se han eliminado con éxito', 'success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se pudieron eliminar los porcentajes seleccionados')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect()->route('bachiller.bachiller_porcentaje.index');
    }
}
