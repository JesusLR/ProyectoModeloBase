<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_calendarioexamen;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerFechasCalendariaExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bachiller.calendaria_examen.show-list');
    }

    public function list()
    {
        $bachiller_calendarioexamen = Bachiller_calendarioexamen::select(
            'bachiller_calendarioexamen.id',
            'bachiller_calendarioexamen.plan_id',
            'bachiller_calendarioexamen.periodo_id',
            'bachiller_calendarioexamen.calexInicioParcial1',
            'bachiller_calendarioexamen.calexFinParcial1',
            'bachiller_calendarioexamen.calexInicioParcial2',
            'bachiller_calendarioexamen.calexFinParcial2',
            'bachiller_calendarioexamen.calexInicioParcial3',
            'bachiller_calendarioexamen.calexFinParcial3',
            'bachiller_calendarioexamen.calexInicioOrdinario',
            'bachiller_calendarioexamen.calexFinOrdinario',
            'bachiller_calendarioexamen.calBoletaPublicacion',
            'bachiller_calendarioexamen.calexInicioExtraordinario', 
            'bachiller_calendarioexamen.calexFinExtraordinario',               
            'periodos.perNumero',
            'periodos.perAnioPago',
            'periodos.perAnio',
            'planes.planClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'programas.progClave'
        )
        ->join('periodos', 'bachiller_calendarioexamen.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_calendarioexamen.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

  
        return DataTables::of($bachiller_calendarioexamen)
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

            ->filterColumn('calexInicioParcial1', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioParcial1) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioParcial1',function($query) {

                if($query->calexInicioParcial1 != ""){
                    return Utils::fecha_string($query->calexInicioParcial1, 'mesCorto');
                }else{
                    return "";
                }               
                  
            })

            ->filterColumn('calexFinParcial1', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinParcial1) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinParcial1',function($query) {

                if($query->calexFinParcial1 != ""){                    
    
                    return Utils::fecha_string($query->calexFinParcial1, 'mesCorto');
                }else{
                    return "";
                }
                
                  
            })

            ->filterColumn('calexInicioParcial2', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioParcial2) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioParcial2',function($query) {

                if($query->calexInicioParcial2 != ""){
                    return Utils::fecha_string($query->calexInicioParcial2, 'mesCorto');
                }else{
                    return "";
                }
               
                  
            })

            ->filterColumn('calexFinParcial2', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinParcial2) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinParcial2',function($query) {

                if($query->calexFinParcial2 != ""){
                    return Utils::fecha_string($query->calexFinParcial2, 'mesCorto');
                }else{
                    return "";
                }
                
                  
            })


            ->filterColumn('calexInicioParcial3', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioParcial3) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioParcial3',function($query) {
                if($query->calexInicioParcial3 != ""){
                    return Utils::fecha_string($query->calexInicioParcial3, 'mesCorto');
                }else{
                    return "";
                }
                  
            })


            ->filterColumn('calexFinParcial3', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinParcial3) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinParcial3',function($query) {
                if($query->calexFinParcial3 != ""){                   

                    return Utils::fecha_string($query->calexFinParcial3, 'mesCorto');
                }else{
                    return "";
                }
                  
            })
           

            ->filterColumn('calexInicioOrdinario', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioOrdinario) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioOrdinario',function($query) {

                if($query->calexInicioOrdinario != ""){
                    return Utils::fecha_string($query->calexInicioOrdinario, 'mesCorto');
                }else{
                    return "";
                }
                
                  
            })

            ->filterColumn('calexFinOrdinario', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinOrdinario) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinOrdinario',function($query) {

                if($query->calexFinOrdinario != ""){
                    return Utils::fecha_string($query->calexFinOrdinario, 'mesCorto');
                }else{
                    return "";
                }
                
                  
            })

            ->filterColumn('calexInicioExtraordinario', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioExtraordinario) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioExtraordinario',function($query) {

                if($query->calexInicioExtraordinario != ""){
                    return Utils::fecha_string($query->calexInicioExtraordinario, 'mesCorto');
                }else{
                    return "";
                }
                
                  
            })

            ->filterColumn('calexFinExtraordinario', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinExtraordinario) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinExtraordinario',function($query) {

                if($query->calexFinExtraordinario != ""){
                    return Utils::fecha_string($query->calexFinExtraordinario, 'mesCorto');
                }else{
                    return "";
                }
               
                  
            })

            ->filterColumn('calBoletaPublicacion', function($query, $keyword) {
                $query->whereRaw("CONCAT(calBoletaPublicacion) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calBoletaPublicacion',function($query) {

                if($query->calBoletaPublicacion != ""){
                    return Utils::fecha_string($query->calBoletaPublicacion, 'mesCorto');
                }else{
                    return "";
                }
               
                  
            })
            ->addColumn('action', function($query) {

                $btnEditar = "";
                $btnEliminar = "";

                $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;
                $sistemas = Auth::user()->departamento_sistemas;

                if($ubicacion == $query->ubiClave || $sistemas == 1){
                    $btnEditar = '<a href="/bachiller_calendario_examen/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
                    $btnEliminar = '<form id="delete_' . $query->id . '" action="/bachiller_calendario_examen/' . $query->id . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                }
  
                return '<a href="/bachiller_calendario_examen/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
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

        $campus_cva = auth()->user()->campus_cva;

        return view('bachiller.calendaria_examen.create', [
            "ubicaciones" => $ubicaciones,
            "campus_cva" => $campus_cva
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
                'calexInicioParcial1' => 'nullable'               
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',                
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_calendario_examen/create')->withErrors($validator)->withInput();
        } else {
            try {


                $fechaActual = Carbon::now('America/Merida');        
                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');


                Bachiller_calendarioexamen::create([
                    'plan_id' => $request->plan_id,
                    'periodo_id' => $request->periodo_id,
                    'eviIniciaCapturaDocentes1' => $request->eviIniciaCapturaDocentes1,
                    'eviFinalizaCapturaDocentes1' => $request->eviFinalizaCapturaDocentes1,
                    'calexInicioParcial1' => $request->calexInicioParcial1,
                    'calexFinParcial1' => $request->calexFinParcial1,
                    'calexInicioParcial2' => $request->calexInicioParcial2,
                    'calexFinParcial2' => $request->calexFinParcial2,
                    'calexInicioParcial3' => $request->calexInicioParcial3,
                    'calexFinParcial3' => $request->calexFinParcial3,
                    'calexInicioOrdinario' => $request->calexInicioOrdinario,
                    'calexFinOrdinario' => $request->calexFinOrdinario,
                    'calBoletaPublicacion' => $request->calBoletaPublicacion,
                    'calexInicioExtraordinario' => $request->calexInicioExtraordinario,
                    'calexFinExtraordinario' => $request->calexFinExtraordinario,
                    'calexUsuarioMod' => Auth::user()->id,
                    'calexFechaMod' => $fechaActual->format('Y-m-d'),
                    'calexHoraMod' => $fechaActual->format('H:i:s')
                ]);

                alert('Escuela Modelo', 'Las fechas de calendario examen se han creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('bachiller.bachiller_calendario_examen.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('bachiller_calendario_examen/create')->withInput();
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
        $bachiller_calendarioexamen = Bachiller_calendarioexamen::select(
            'bachiller_calendarioexamen.id',
            'bachiller_calendarioexamen.plan_id',
            'bachiller_calendarioexamen.periodo_id',
            'bachiller_calendarioexamen.calexInicioParcial1',
            'bachiller_calendarioexamen.calexFinParcial1',
            'bachiller_calendarioexamen.calexInicioParcial2',
            'bachiller_calendarioexamen.calexFinParcial2',
            'bachiller_calendarioexamen.calexInicioParcial3',
            'bachiller_calendarioexamen.calexFinParcial3',
            'bachiller_calendarioexamen.calexInicioOrdinario',
            'bachiller_calendarioexamen.calexFinOrdinario',
            'bachiller_calendarioexamen.calexInicioExtraordinario', 
            'bachiller_calendarioexamen.calexFinExtraordinario',  
            'bachiller_calendarioexamen.eviIniciaCapturaDocentes1',
            'bachiller_calendarioexamen.eviFinalizaCapturaDocentes1',             
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'planes.planClave',
            'ubicacion.id as ubicacion_id',
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
        ->join('periodos', 'bachiller_calendarioexamen.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_calendarioexamen.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_calendarioexamen.id', $id)
        ->first();

        $campus_cva = auth()->user()->campus_cva;

        return view('bachiller.calendaria_examen.show', [
            "bachiller_calendarioexamen" => $bachiller_calendarioexamen,
            "campus_cva" => $campus_cva
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
        $bachiller_calendarioexamen = Bachiller_calendarioexamen::select(
            'bachiller_calendarioexamen.id',
            'bachiller_calendarioexamen.plan_id',
            'bachiller_calendarioexamen.periodo_id',
            'bachiller_calendarioexamen.calexInicioParcial1',
            'bachiller_calendarioexamen.calexFinParcial1',
            'bachiller_calendarioexamen.calexInicioParcial2',
            'bachiller_calendarioexamen.calexFinParcial2',
            'bachiller_calendarioexamen.calexInicioParcial3',
            'bachiller_calendarioexamen.calexFinParcial3',
            'bachiller_calendarioexamen.calexInicioOrdinario',
            'bachiller_calendarioexamen.calexFinOrdinario',
            'bachiller_calendarioexamen.calexInicioExtraordinario', 
            'bachiller_calendarioexamen.calexFinExtraordinario',    
            'bachiller_calendarioexamen.calBoletaPublicacion',    
            'bachiller_calendarioexamen.eviIniciaCapturaDocentes1',  
            'bachiller_calendarioexamen.eviFinalizaCapturaDocentes1',          
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'planes.planClave',
            'ubicacion.id as ubicacion_id',
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
        ->join('periodos', 'bachiller_calendarioexamen.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_calendarioexamen.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_calendarioexamen.id', $id)
        ->first();

        $campus_cva = auth()->user()->campus_cva;

        return view('bachiller.calendaria_examen.edit', [
            "bachiller_calendarioexamen" => $bachiller_calendarioexamen,
            "campus_cva" => $campus_cva
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
                'calexInicioParcial1' => 'nullable'               
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',                
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            try {


                $fechaActual = Carbon::now('America/Merida');        
                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');


                $bachiller_calendarioexamen = Bachiller_calendarioexamen::findOrFail($id);
                $bachiller_calendarioexamen->update([
                    'plan_id' => $request->plan_id,
                    'periodo_id' => $request->periodo_id,
                    'eviIniciaCapturaDocentes1' => $request->eviIniciaCapturaDocentes1,
                    'eviFinalizaCapturaDocentes1' => $request->eviFinalizaCapturaDocentes1,
                    'calexInicioParcial1' => $request->calexInicioParcial1,
                    'calexFinParcial1' => $request->calexFinParcial1,
                    'calexInicioParcial2' => $request->calexInicioParcial2,
                    'calexFinParcial2' => $request->calexFinParcial2,
                    'calexInicioParcial3' => $request->calexInicioParcial3,
                    'calexFinParcial3' => $request->calexFinParcial3,
                    'calexInicioOrdinario' => $request->calexInicioOrdinario,
                    'calexFinOrdinario' => $request->calexFinOrdinario,
                    'calBoletaPublicacion' => $request->calBoletaPublicacion,
                    'calexInicioExtraordinario' => $request->calexInicioExtraordinario,
                    'calexFinExtraordinario' => $request->calexFinExtraordinario,
                    'calexUsuarioMod' => Auth::user()->id,
                    'calexFechaMod' => $fechaActual->format('Y-m-d'),
                    'calexHoraMod' => $fechaActual->format('H:i:s')
                ]);

                alert('Escuela Modelo', 'Las fechas de calendario examen se han actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return back();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return back()->withInput();
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
        $bachiller_calendarioexamen = Bachiller_calendarioexamen::findOrFail($id);
 
         try {
             if ($bachiller_calendarioexamen->delete()) {
                 alert('Escuela Modelo', 'Las fechas calendario examen se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose(5000);
             } else {
                 alert()->error('Error...', 'No se puedo eliminar las fechas de calendario examen')->showConfirmButton();
             }
         } catch (QueryException $e) {
             $errorCode = $e->errorInfo[1];
             $errorMessage = $e->errorInfo[2];
             alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
         }
 
 
         return redirect('bachiller_calendario_examen');
     }
}
