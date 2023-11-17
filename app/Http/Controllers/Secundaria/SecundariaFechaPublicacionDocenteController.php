<?php

namespace App\Http\Controllers\Secundaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use App\Http\Models\Secundaria\Secundaria_calendario_calificaciones_alumnos;
use App\Http\Models\Secundaria\Secundaria_calendario_calificaciones_docentes;
use App\Http\Models\Secundaria\Secundaria_mes_evaluaciones;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class SecundariaFechaPublicacionDocenteController extends Controller
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
        return view('secundaria.fecha_publicacion_docente.show-list');
    }

    public function list()
    {
        $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::select(
            'secundaria_calendario_calificaciones_docentes.id',
            'secundaria_calendario_calificaciones_docentes.periodo_id',
            'secundaria_calendario_calificaciones_docentes.plan_id',
            'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id',
            'secundaria_calendario_calificaciones_docentes.calInicioCaptura',
            'secundaria_calendario_calificaciones_docentes.calFinCaptura',
            'secundaria_calendario_calificaciones_docentes.calInicioRevision',
            'secundaria_calendario_calificaciones_docentes.calFinRevision',
            'periodos.perAnioPago',
            'planes.planClave',
            'secundaria_mes_evaluaciones.mes',
            'programas.progClave',
            'programas.progNombre',
            'ubicacion.ubiNombre')
        ->join('periodos', 'secundaria_calendario_calificaciones_docentes.periodo_id', '=', 'periodos.id')
        ->join('planes', 'secundaria_calendario_calificaciones_docentes.plan_id', '=', 'planes.id')
        ->join('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_docentes.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->orderBy('periodos.perAnio', 'ASC')
        ->orderBy('secundaria_mes_evaluaciones.numero_evaluacion', 'ASC')
        ->orderBy('ubicacion.ubiClave', 'ASC');


        return DataTables::of($secundaria_calendario_calificaciones_docentes)

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
            $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('anio_pago',function($query){
            return $query->perAnioPago;
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
            return '<a href="secundaria_fecha_publicacion_calificacion_docente/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        

        return view('secundaria.fecha_publicacion_docente.create', [
            'ubicaciones' => $ubicaciones,
        ]);
    }

    public function getMesEvaluaciones(Request $request, $departamento_id)
    {
        if($request->ajax()){

            $secundaria_mes_evaluaciones = Secundaria_mes_evaluaciones::where('departamento_id', $departamento_id)->get();

            return response()->json($secundaria_mes_evaluaciones);
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
                'secundaria_mes_evaluaciones_id' => 'required'             
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'calInicioCaptura.requerid' => 'El campo Fecha inicio de captura es obligatorio.',
                'calFinCaptura.requerid' => 'El campo Fecha de inicio de captura es obligatorio.',
                'calInicioRevision.requerid' => 'El campo Fecha inicio de revisión es obligatorio.',
                'calFinRevision.requerid' => 'El campo Fecha fin de revisión es obligatorio.',
                'secundaria_mes_evaluaciones_id.requerid' => 'El campo Mes evaluación es obligatorio.'        
            ]
        );

        if ($validator->fails()) {
            return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withErrors($validator)->withInput();
        } else {
            try {

                $departamento = Departamento::findOrFail(14);
                $periodo = Periodo::findOrFail($request->periodo_id);

                // validaciones de acuerdo a la fechas del inicio y fin del ciclo 
                if($request->calInicioCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }           
                
                if($request->calFinCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }   

                if($request->calInicioRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                if($request->calFinRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                $secundaria_calendario_calificaciones_docentes_validaion = Secundaria_calendario_calificaciones_docentes::where('periodo_id', '=', $request->periodo_id)
                ->where('plan_id', '=', $request->plan_id)
                ->where('secundaria_mes_evaluaciones_id', '=', $request->secundaria_mes_evaluaciones_id)
                ->get();

                // validamos si hay registros con los mismos datos 
                if(count($secundaria_calendario_calificaciones_docentes_validaion) > 0){
                    alert('Escuela Modelo', 'Ya existe fechas guardadas para el ciclo escolar, el plan y mes de evalución seleccionado, ingrese a editar si así lo requiere', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }

                Secundaria_calendario_calificaciones_docentes::create([
                    'periodo_id' => $request->periodo_id,
                    'plan_id' => $request->plan_id,
                    'secundaria_mes_evaluaciones_id' => $request->secundaria_mes_evaluaciones_id,
                    'calInicioCaptura' => $request->calInicioCaptura,
                    'calFinCaptura' => $request->calFinCaptura,
                    'calInicioRevision' => $request->calInicioRevision,
                    'calFinRevision' => $request->calFinRevision
                ]);

                alert('Escuela Modelo', 'Las fechas de publicación de calificaciones se han creado con éxito', 'success')->showConfirmButton()->autoClose('7000');
                return redirect()->route('secundaria.secundaria_fecha_publicacion_calificacion_docente.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
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

        $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::findOrFail($id);

        $planes = Plan::findOrFail($secundaria_calendario_calificaciones_docentes->plan_id);
        $programa = Programa::findOrFail($planes->programa_id);
        $periodo = Periodo::findOrFail($secundaria_calendario_calificaciones_docentes->periodo_id);
        $departamento = Departamento::findOrFail($periodo->departamento_id);
        $ubicaciones = Ubicacion::findOrFail($departamento->ubicacion_id);
        $escuela = Escuela::findOrFail($programa->escuela_id);
        $secundaria_mes_evaluaciones = Secundaria_mes_evaluaciones::where('departamento_id', $departamento->id)->get();



        return view('secundaria.fecha_publicacion_docente.edit', [
            'secundaria_calendario_calificaciones_docentes' => $secundaria_calendario_calificaciones_docentes,
            'ubicaciones' => $ubicaciones,
            'planes' => $planes,
            'programa' => $programa,
            'periodo' => $periodo,
            'departamento' => $departamento,
            'escuela' => $escuela,
            'secundaria_mes_evaluaciones' => $secundaria_mes_evaluaciones
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
                'secundaria_mes_evaluaciones_id' => 'required'             
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'calInicioCaptura.requerid' => 'El campo Fecha inicio de captura es obligatorio.',
                'calFinCaptura.requerid' => 'El campo Fecha de inicio de captura es obligatorio.',
                'calInicioRevision.requerid' => 'El campo Fecha inicio de revisión es obligatorio.',
                'calFinRevision.requerid' => 'El campo Fecha fin de revisión es obligatorio.',
                'secundaria_mes_evaluaciones_id.requerid' => 'El campo Mes evaluación es obligatorio.'        
            ]
        );

        if ($validator->fails()) {
            return redirect('secundaria_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $departamento = Departamento::findOrFail($request->departamento_id);
                $periodo = Periodo::findOrFail($request->periodo_id);

                // validaciones de acuerdo a la fechas del inicio y fin del ciclo 
                if($request->calInicioCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }           
                
                if($request->calFinCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }   

                if($request->calInicioRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                if($request->calFinRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('secundaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                $secundaria_calendario_calificaciones_docentes_validaion = Secundaria_calendario_calificaciones_docentes::where('periodo_id', '=', $request->periodo_id)
                ->where('plan_id', '=', $request->plan_id)
                ->where('secundaria_mes_evaluaciones_id', '=', $request->secundaria_mes_evaluaciones_id)
                ->first();

                // validamos si hay registros con los mismos datos 
                if($secundaria_calendario_calificaciones_docentes_validaion != ""){
                    if($secundaria_calendario_calificaciones_docentes_validaion->id != $id){
                        alert('Escuela Modelo', 'Ya existe fechas guardadas para el ciclo escolar, el plan y mes de evalución seleccionado', 'warning')->showConfirmButton()->autoClose('7000');
                        return redirect('secundaria_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
                    }
                    
                }


                // return $request->secundaria_mes_evaluaciones_id;
                $meses_eva = Secundaria_mes_evaluaciones::where('id', $request->secundaria_mes_evaluaciones_id)->first();
                $secundaria_calendario_calificaciones_alumnos = Secundaria_calendario_calificaciones_alumnos::select('secundaria_calendario_calificaciones_alumnos.*',
                'secundaria_mes_evaluaciones.mes')
                ->join('secundaria_mes_evaluaciones', 'secundaria_calendario_calificaciones_alumnos.secundaria_mes_evaluaciones_id', '=', 'secundaria_mes_evaluaciones.id')
                ->where('periodo_id', $request->periodo_id)
                ->where('plan_id', $request->plan_id)
                ->where('secundaria_mes_evaluaciones.mes', $meses_eva->mes)
                ->first();

                if($secundaria_calendario_calificaciones_alumnos != ""){
                    if($request->calFinRevision > $secundaria_calendario_calificaciones_alumnos->calPublicacion){
                        alert('Escuela Modelo', 'La fecha de revisión de calificaciones no puede ser mayor a la fecha de publicación para alumnos', 'warning')->showConfirmButton()->autoClose('7000');
                        return redirect('secundaria_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
                    }
    
                }
                
                $secundaria_calendario_calificaciones_docentes = Secundaria_calendario_calificaciones_docentes::findOrFail($id);
                $secundaria_calendario_calificaciones_docentes->update([
                    'periodo_id' => $request->periodo_id,
                    'plan_id' => $request->plan_id,
                    'secundaria_mes_evaluaciones_id' => $request->secundaria_mes_evaluaciones_id,
                    'calInicioCaptura' => $request->calInicioCaptura,
                    'calFinCaptura' => $request->calFinCaptura,
                    'calInicioRevision' => $request->calInicioRevision,
                    'calFinRevision' => $request->calFinRevision
                ]);
           

                alert('Escuela Modelo', 'Las fechas de publicación de calificaciones se han actualizado con éxito', 'success')->showConfirmButton()->autoClose('7000');
                return redirect()->route('secundaria.secundaria_fecha_publicacion_calificacion_docente.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('secundaria_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
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
