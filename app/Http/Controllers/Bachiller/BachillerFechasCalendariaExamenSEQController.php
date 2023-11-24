<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_cch_calendario_calificaciones_docentes;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerFechasCalendariaExamenSEQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bachiller.calendaria_examen_cch.show-list');
    }

    public function list()
    {
        $bachiller_cch_calendario_calificaciones_docentes = Bachiller_cch_calendario_calificaciones_docentes::select(
            'bachiller_cch_calendario_calificaciones_docentes.id',
            'bachiller_cch_calendario_calificaciones_docentes.plan_id',
            'bachiller_cch_calendario_calificaciones_docentes.periodo_id',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial1',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial1',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial2',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial2',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial3',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial3',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial4',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial4',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioRecuperacion',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinRecuperacion',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioExtraordinario', 
            'bachiller_cch_calendario_calificaciones_docentes.calexFinExtraordinario',           
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioEspecial',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinEspecial',
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
        ->join('periodos', 'bachiller_cch_calendario_calificaciones_docentes.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_cch_calendario_calificaciones_docentes.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

  
        return DataTables::of($bachiller_cch_calendario_calificaciones_docentes)
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
                    $dia= \Carbon\Carbon::parse($query->calexInicioParcial1)->format('d');
                    $meses= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexInicioParcial1)->format('m'));
                    $year= \Carbon\Carbon::parse($query->calexInicioParcial1)->format('Y');
    
                    return $dia.'-'.$meses.'-'.$year;
                }else{
                    return "";
                }               
                  
            })

            ->filterColumn('calexFinParcial1', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinParcial1) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinParcial1',function($query) {

                if($query->calexFinParcial1 != ""){
                    $dia2= \Carbon\Carbon::parse($query->calexFinParcial1)->format('d');
                    $meses2= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexFinParcial1)->format('m'));
                    $year2= \Carbon\Carbon::parse($query->calexFinParcial1)->format('Y');
    
                    return $dia2.'-'.$meses2.'-'.$year2;
                }else{
                    return "";
                }
                
                  
            })

            ->filterColumn('calexInicioParcial2', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioParcial2) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioParcial2',function($query) {

                if($query->calexInicioParcial2 != ""){
                    $dia3= \Carbon\Carbon::parse($query->calexInicioParcial2)->format('d');
                    $meses3= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexInicioParcial2)->format('m'));
                    $year3= \Carbon\Carbon::parse($query->calexInicioParcial2)->format('Y');
    
                    return $dia3.'-'.$meses3.'-'.$year3;
                }else{
                    return "";
                }
               
                  
            })

            ->filterColumn('calexFinParcial2', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinParcial2) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinParcial2',function($query) {

                if($query->calexFinParcial2 != ""){
                    $dia4= \Carbon\Carbon::parse($query->calexFinParcial2)->format('d');
                    $meses4= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexFinParcial2)->format('m'));
                    $year4= \Carbon\Carbon::parse($query->calexFinParcial2)->format('Y');
    
                    return $dia4.'-'.$meses4.'-'.$year4;
                }else{
                    return "";
                }
                
                  
            })


            ->filterColumn('calexInicioParcial3', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioParcial3) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioParcial3',function($query) {
                if($query->calexInicioParcial3 != ""){
                    $dia5= \Carbon\Carbon::parse($query->calexInicioParcial3)->format('d');
                    $meses5= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexInicioParcial3)->format('m'));
                    $year5= \Carbon\Carbon::parse($query->calexInicioParcial3)->format('Y');

                    return $dia5.'-'.$meses5.'-'.$year5;
                }else{
                    return "";
                }
                  
            })
           
            ->filterColumn('calexInicioParcial4', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioParcial4) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioParcial4',function($query) {
                if($query->calexInicioParcial4 != ""){
                    $dia7= \Carbon\Carbon::parse($query->calexInicioParcial4)->format('d');
                    $meses7= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexInicioParcial4)->format('m'));
                    $year7= \Carbon\Carbon::parse($query->calexInicioParcial4)->format('Y');

                    return $dia7.'-'.$meses7.'-'.$year7;
                }else{
                    return "";
                }
                  
            })

            ->filterColumn('calexInicioRecuperacion', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioRecuperacion) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioRecuperacion',function($query) {

                if($query->calexInicioRecuperacion != ""){
                    $dia6= \Carbon\Carbon::parse($query->calexInicioRecuperacion)->format('d');
                    $meses6= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexInicioRecuperacion)->format('m'));
                    $year6= \Carbon\Carbon::parse($query->calexInicioRecuperacion)->format('Y');
    
                    return $dia6.'-'.$meses6.'-'.$year6;
                }else{
                    return "";
                }
                
                  
            })

            ->filterColumn('calexFinRecuperacion', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinRecuperacion) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinRecuperacion',function($query) {

                if($query->calexFinRecuperacion != ""){
                    $dia7= \Carbon\Carbon::parse($query->calexFinRecuperacion)->format('d');
                    $meses7= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexFinRecuperacion)->format('m'));
                    $year7= \Carbon\Carbon::parse($query->calexFinRecuperacion)->format('Y');

                    return $dia7.'-'.$meses7.'-'.$year7;
                }else{
                    return "";
                }
                
                  
            })

            ->filterColumn('calexInicioExtraordinario', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexInicioExtraordinario) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexInicioExtraordinario',function($query) {

                if($query->calexInicioExtraordinario != ""){
                    $dia8= \Carbon\Carbon::parse($query->calexInicioExtraordinario)->format('d');
                    $meses8= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexInicioExtraordinario)->format('m'));
                    $year8= \Carbon\Carbon::parse($query->calexInicioExtraordinario)->format('Y');
    
                    return $dia8.'-'.$meses8.'-'.$year8;
                }else{
                    return "";
                }
                
                  
            })

            ->filterColumn('calexFinExtraordinario', function($query, $keyword) {
                $query->whereRaw("CONCAT(calexFinExtraordinario) like ?", ["%{$keyword}%"]);
               
            })
            ->addColumn('calexFinExtraordinario',function($query) {

                if($query->calexFinExtraordinario != ""){
                    $dia9= \Carbon\Carbon::parse($query->calexFinExtraordinario)->format('d');
                    $meses9= Utils::num_meses_corto_string(\Carbon\Carbon::parse($query->calexFinExtraordinario)->format('m'));
                    $year9= \Carbon\Carbon::parse($query->calexFinExtraordinario)->format('Y');
    
                    return $dia9.'-'.$meses9.'-'.$year9;
                }else{
                    return "";
                }
               
                  
            })
            ->addColumn('action', function($query) {
  
                return '<a href="/bachiller_calendario_examen_cch/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="/bachiller_calendario_examen_cch/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                <form id="delete_' . $query->id . '" action="/bachiller_calendario_examen_cch/' . $query->id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
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
        return view('bachiller.calendaria_examen_cch.create', [
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
                'calexInicioParcial1' => 'nullable'               
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',                
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_calendario_examen_cch/create')->withErrors($validator)->withInput();
        } else {
            try {


                $fechaActual = Carbon::now('America/Merida');        
                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');


                Bachiller_cch_calendario_calificaciones_docentes::create([
                    'plan_id' => $request->plan_id,
                    'periodo_id' => $request->periodo_id,
                    'calexInicioParcial1' => $request->calexInicioParcial1,
                    'calexFinParcial1' => $request->calexFinParcial1,
                    'calexInicioParcial2' => $request->calexInicioParcial2,
                    'calexFinParcial2' => $request->calexFinParcial2,
                    'calexInicioParcial3' => $request->calexInicioParcial3,
                    'calexFinParcial3' => $request->calexFinParcial3,
                    'calexInicioParcial4' => $request->calexInicioParcial4,
                    'calexFinParcial4' => $request->calexFinParcial4,
                    'calexInicioRecuperacion' => $request->calexInicioRecuperacion,
                    'calexFinRecuperacion' => $request->calexFinRecuperacion,
                    'calexInicioExtraordinario' => $request->calexInicioExtraordinario,
                    'calexFinExtraordinario' => $request->calexFinExtraordinario,
                    'calexInicioEspecial' => $request->calexInicioEspecial,
                    'calexFinEspecial,' => $request->calexFinEspecial,
                    'calexUsuarioMod' => Auth::user()->id,
                    'calexFechaMod' => $fechaActual->format('Y-m-d'),
                    'calexHoraMod' => $fechaActual->format('H:i:s')
                ]);

                alert('Escuela Modelo', 'Las fechas de calendario examen se han creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('bachiller.bachiller_calendario_examen_cch.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('bachiller_calendario_examen_cch/create')->withInput();
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
        $bachiller_calendarioexamen = Bachiller_cch_calendario_calificaciones_docentes::select(
            'bachiller_cch_calendario_calificaciones_docentes.id',
            'bachiller_cch_calendario_calificaciones_docentes.plan_id',
            'bachiller_cch_calendario_calificaciones_docentes.periodo_id',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial1',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial1',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial2',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial2',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial3',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial3',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial4',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial4',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioRecuperacion',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinRecuperacion',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioExtraordinario', 
            'bachiller_cch_calendario_calificaciones_docentes.calexFinExtraordinario',      
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioEspecial',  
            'bachiller_cch_calendario_calificaciones_docentes.calexFinEspecial',                
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
        ->join('periodos', 'bachiller_cch_calendario_calificaciones_docentes.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_cch_calendario_calificaciones_docentes.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_cch_calendario_calificaciones_docentes.id', $id)
        ->first();

        return view('bachiller.calendaria_examen_cch.show', [
            "bachiller_calendarioexamen" => $bachiller_calendarioexamen
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
        $bachiller_cch_calendario_calificaciones_docentes = Bachiller_cch_calendario_calificaciones_docentes::select(
            'bachiller_cch_calendario_calificaciones_docentes.id',
            'bachiller_cch_calendario_calificaciones_docentes.plan_id',
            'bachiller_cch_calendario_calificaciones_docentes.periodo_id',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial1',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial1',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial2',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial2',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial3',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial3',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioParcial4',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinParcial4',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioRecuperacion',
            'bachiller_cch_calendario_calificaciones_docentes.calexFinRecuperacion',
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioExtraordinario', 
            'bachiller_cch_calendario_calificaciones_docentes.calexFinExtraordinario',      
            'bachiller_cch_calendario_calificaciones_docentes.calexInicioEspecial',  
            'bachiller_cch_calendario_calificaciones_docentes.calexFinEspecial',          
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
        ->join('periodos', 'bachiller_cch_calendario_calificaciones_docentes.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_cch_calendario_calificaciones_docentes.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('bachiller_cch_calendario_calificaciones_docentes.id', $id)
        ->first();

        return view('bachiller.calendaria_examen_cch.edit', [
            "bachiller_cch_calendario_calificaciones_docentes" => $bachiller_cch_calendario_calificaciones_docentes
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

                // return $request->calexInicioEspecial;

                $bachiller_cch_calendario_calificaciones_docentes = Bachiller_cch_calendario_calificaciones_docentes::findOrFail($id);
                $bachiller_cch_calendario_calificaciones_docentes->update([
                    'plan_id' => $request->plan_id,
                    'periodo_id' => $request->periodo_id,
                    'calexInicioParcial1' => $request->calexInicioParcial1,
                    'calexFinParcial1' => $request->calexFinParcial1,
                    'calexInicioParcial2' => $request->calexInicioParcial2,
                    'calexFinParcial2' => $request->calexFinParcial2,
                    'calexInicioParcial3' => $request->calexInicioParcial3,
                    'calexFinParcial3' => $request->calexFinParcial3,
                    'calexInicioParcial4' => $request->calexInicioParcial4,
                    'calexFinParcial4' => $request->calexFinParcial4,
                    'calexInicioRecuperacion' => $request->calexInicioRecuperacion,
                    'calexFinRecuperacion' => $request->calexFinRecuperacion,
                    'calexInicioExtraordinario' => $request->calexInicioExtraordinario,
                    'calexFinExtraordinario' => $request->calexFinExtraordinario,
                    'calexInicioEspecial' => $request->calexInicioEspecial,
                    'calexFinEspecial' => $request->calexFinEspecial,
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
        $bachiller_cch_calendario_calificaciones_docentes = Bachiller_cch_calendario_calificaciones_docentes::findOrFail($id);
 
         try {
             if ($bachiller_cch_calendario_calificaciones_docentes->delete()) {
                 alert('Escuela Modelo', 'Las fechas calendario examen se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose(5000);
             } else {
                 alert()->error('Error...', 'No se puedo eliminar las fechas de calendario examen')->showConfirmButton();
             }
         } catch (QueryException $e) {
             $errorCode = $e->errorInfo[1];
             $errorMessage = $e->errorInfo[2];
             alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
         }
 
 
         return redirect('bachiller_calendario_examen_cch');
     }
}
