<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Bachiller\Bachiller_calendario_calificaciones_alumnos;
use App\Models\Bachiller\Bachiller_calendario_calificaciones_docentes;
use App\Models\Bachiller\Bachiller_mes_evaluaciones;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerFechaPublicacionControllerDocente extends Controller
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
        return view('bachiller.fecha_publicacion_docente.show-list');
    }

    public function list()
    {
        $bachiller_calendario_calificaciones_docentes = Bachiller_calendario_calificaciones_docentes::select(
            'bachiller_calendario_calificaciones_docentes.id',
            'bachiller_calendario_calificaciones_docentes.periodo_id',
            'bachiller_calendario_calificaciones_docentes.plan_id',
            'bachiller_calendario_calificaciones_docentes.bachiller_mes_evaluaciones_id',
            'bachiller_calendario_calificaciones_docentes.calInicioCaptura',
            'bachiller_calendario_calificaciones_docentes.calFinCaptura',
            'bachiller_calendario_calificaciones_docentes.calInicioRevision',
            'bachiller_calendario_calificaciones_docentes.calFinRevision',
            'periodos.perAnioPago',
            'periodos.perAnio',
            'periodos.perNumero',
            'planes.planClave',
            'bachiller_mes_evaluaciones.mes',
            'programas.progClave',
            'programas.progNombre',
            'ubicacion.ubiNombre')
        ->join('periodos', 'bachiller_calendario_calificaciones_docentes.periodo_id', '=', 'periodos.id')
        ->join('planes', 'bachiller_calendario_calificaciones_docentes.plan_id', '=', 'planes.id')
        ->join('bachiller_mes_evaluaciones', 'bachiller_calendario_calificaciones_docentes.bachiller_mes_evaluaciones_id', '=', 'bachiller_mes_evaluaciones.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');


        return DataTables::of($bachiller_calendario_calificaciones_docentes)

        ->filterColumn('periodo_numero', function ($query, $keyword) {
            $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('periodo_numero', function ($query) {
            return $query->perNumero;
        })

        ->filterColumn('ubicacion',function($query,$keyword){
            $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubicacion',function($query){
            return $query->ubiNombre;
        })

        ->filterColumn('programa',function($query,$keyword){
            $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('programa',function($query){
            return $query->progNombre;
        })
        // perAnioPAgo 
        ->filterColumn('anio_pago',function($query,$keyword){
            $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('anio_pago',function($query){
            return $query->perAnio;
        })
  
        // plan 
        ->filterColumn('plan',function($query,$keyword){
            $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('plan',function($query){
            return $query->planClave;
        })

        ->filterColumn('mes_eva',function($query,$keyword){
            $query->whereRaw("CONCAT(mes) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('mes_eva',function($query){
            return $query->mes;
        })
        ->addColumn('action',function($query){
            return '<a href="bachiller_fecha_publicacion_calificacion_docente/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
           ';
        })->make(true);
     

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();

        

        return view('bachiller.fecha_publicacion_docente.create', [
            'ubicaciones' => $ubicaciones,
        ]);
    }

    public function getMesEvaluaciones(Request $request, $departamento_id)
    {
        if($request->ajax()){

            $bachiller_mes_evaluaciones = Bachiller_mes_evaluaciones::where('departamento_id', $departamento_id)->get();

            return response()->json($bachiller_mes_evaluaciones);
        }

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
                'calInicioCaptura'  => 'required',
                'calFinCaptura'  => 'required',
                'calInicioRevision'  => 'required',
                'calFinRevision'  => 'required',
                'bachiller_mes_evaluaciones_id' => 'required'             
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'calInicioCaptura.requerid' => 'El campo Fecha inicio de captura es obligatorio.',
                'calFinCaptura.requerid' => 'El campo Fecha de inicio de captura es obligatorio.',
                'calInicioRevision.requerid' => 'El campo Fecha inicio de revisión es obligatorio.',
                'calFinRevision.requerid' => 'El campo Fecha fin de revisión es obligatorio.',
                'bachiller_mes_evaluaciones_id.requerid' => 'El campo Mes evaluación es obligatorio.'        
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withErrors($validator)->withInput();
        } else {
            try {

                $departamento = Departamento::findOrFail($request->departamento_id);
                $periodo = Periodo::findOrFail($departamento->perActual);

                // validaciones de acuerdo a la fechas del inicio y fin del ciclo 
                if($request->calInicioCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }           
                
                if($request->calFinCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }   

                if($request->calInicioRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                if($request->calFinRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                $bachiller_calendario_calificaciones_docentes_validaion = Bachiller_calendario_calificaciones_docentes::where('periodo_id', '=', $request->periodo_id)
                ->where('plan_id', '=', $request->plan_id)
                ->where('bachiller_mes_evaluaciones_id', '=', $request->bachiller_mes_evaluaciones_id)
                ->get();

                // validamos si hay registros con los mismos datos 
                if(count($bachiller_calendario_calificaciones_docentes_validaion) > 0){
                    alert('Escuela Modelo', 'Ya existe fechas guardadas para el ciclo escolar, el plan y mes de evalución seleccionado, ingrese a editar si así lo requiere', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }

                Bachiller_calendario_calificaciones_docentes::create([
                    'departamento_id' => $request->departamento_id,
                    'periodo_id' => $request->periodo_id,
                    'plan_id' => $request->plan_id,
                    'bachiller_mes_evaluaciones_id' => $request->bachiller_mes_evaluaciones_id,
                    'calInicioCaptura' => $request->calInicioCaptura,
                    'calFinCaptura' => $request->calFinCaptura,
                    'calInicioRevision' => $request->calInicioRevision,
                    'calFinRevision' => $request->calFinRevision
                ]);

                alert('Escuela Modelo', 'Las fechas de publicación de calificaciones se han creado con éxito', 'success')->showConfirmButton()->autoClose('7000');
                return redirect()->route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $bachiller_calendario_calificaciones_docentes = Bachiller_calendario_calificaciones_docentes::findOrFail($id);

        $planes = Plan::findOrFail($bachiller_calendario_calificaciones_docentes->plan_id);
        $programa = Programa::findOrFail($planes->programa_id);
        $periodo = Periodo::findOrFail($bachiller_calendario_calificaciones_docentes->periodo_id);
        $departamento = Departamento::findOrFail($periodo->departamento_id);
        $ubicaciones = Ubicacion::findOrFail($departamento->ubicacion_id);
        $escuela = Escuela::findOrFail($programa->escuela_id);
        $bachiller_mes_evaluaciones = Bachiller_mes_evaluaciones::where('departamento_id', $departamento->id)->get();



        return view('bachiller.fecha_publicacion_docente.edit', [
            'bachiller_calendario_calificaciones_docentes' => $bachiller_calendario_calificaciones_docentes,
            'ubicaciones' => $ubicaciones,
            'planes' => $planes,
            'programa' => $programa,
            'periodo' => $periodo,
            'departamento' => $departamento,
            'escuela' => $escuela,
            'bachiller_mes_evaluaciones' => $bachiller_mes_evaluaciones
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
                'calInicioCaptura'  => 'required',
                'calFinCaptura'  => 'required',
                'calInicioRevision'  => 'required',
                'calFinRevision'  => 'required',
                'bachiller_mes_evaluaciones_id' => 'required'             
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'calInicioCaptura.requerid' => 'El campo Fecha inicio de captura es obligatorio.',
                'calFinCaptura.requerid' => 'El campo Fecha de inicio de captura es obligatorio.',
                'calInicioRevision.requerid' => 'El campo Fecha inicio de revisión es obligatorio.',
                'calFinRevision.requerid' => 'El campo Fecha fin de revisión es obligatorio.',
                'bachiller_mes_evaluaciones_id.requerid' => 'El campo Mes evaluación es obligatorio.'        
            ]
        );

        if ($validator->fails()) {
            return redirect('bachiller_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $departamento = Departamento::findOrFail($request->departamento_id);
                $periodo = Periodo::findOrFail($departamento->perActual);

                // validaciones de acuerdo a la fechas del inicio y fin del ciclo 
                if($request->calInicioCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }           
                
                if($request->calFinCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }   

                if($request->calInicioRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                if($request->calFinRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('bachiller_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                $bachiller_calendario_calificaciones_docentes_validaion = Bachiller_calendario_calificaciones_docentes::where('periodo_id', '=', $request->periodo_id)
                ->where('plan_id', '=', $request->plan_id)
                ->where('bachiller_mes_evaluaciones_id', '=', $request->bachiller_mes_evaluaciones_id)
                ->first();

                // validamos si hay registros con los mismos datos 
                if($bachiller_calendario_calificaciones_docentes_validaion != ""){
                    if($bachiller_calendario_calificaciones_docentes_validaion->id != $id){
                        alert('Escuela Modelo', 'Ya existe fechas guardadas para el ciclo escolar, el plan y mes de evalución seleccionado', 'warning')->showConfirmButton()->autoClose('7000');
                        return redirect('bachiller_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
                    }
                    
                }


                // return $request->bachiller_mes_evaluaciones_id;
                $meses_eva = Bachiller_mes_evaluaciones::where('id', $request->bachiller_mes_evaluaciones_id)->first();
                $bachiller_calendario_calificaciones_alumnos = Bachiller_calendario_calificaciones_alumnos::select('bachiller_calendario_calificaciones_alumnos.*',
                'bachiller_mes_evaluaciones.mes')
                ->join('bachiller_mes_evaluaciones', 'bachiller_calendario_calificaciones_alumnos.bachiller_mes_evaluaciones_id', '=', 'bachiller_mes_evaluaciones.id')
                ->where('periodo_id', $request->periodo_id)
                ->where('plan_id', $request->plan_id)
                ->where('bachiller_mes_evaluaciones.mes', $meses_eva->mes)
                ->first();

                if($bachiller_calendario_calificaciones_alumnos != ""){
                    if($request->calFinRevision > $bachiller_calendario_calificaciones_alumnos->calPublicacion){
                        alert('Escuela Modelo', 'La fecha de revisión de calificaciones no puede ser mayor a la fecha de publicación para alumnos', 'warning')->showConfirmButton()->autoClose('7000');
                        return redirect('bachiller_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
                    }
                }

                $bachiller_calendario_calificaciones_docentes = Bachiller_calendario_calificaciones_docentes::findOrFail($id);
                $bachiller_calendario_calificaciones_docentes->update([
                    'periodo_id' => $request->periodo_id,
                    'plan_id' => $request->plan_id,
                    'bachiller_mes_evaluaciones_id' => $request->bachiller_mes_evaluaciones_id,
                    'calInicioCaptura' => $request->calInicioCaptura,
                    'calFinCaptura' => $request->calFinCaptura,
                    'calInicioRevision' => $request->calInicioRevision,
                    'calFinRevision' => $request->calFinRevision
                ]);
           

                alert('Escuela Modelo', 'Las fechas de publicación de calificaciones se han actualizado con éxito', 'success')->showConfirmButton()->autoClose('7000');
                return redirect()->route('bachiller.bachiller_fecha_publicacion_calificacion_docente.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('bachiller_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
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
        //
    }
}
