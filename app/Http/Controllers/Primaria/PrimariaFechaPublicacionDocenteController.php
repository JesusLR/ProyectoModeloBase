<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Primaria\Primaria_calendario_calificaciones_alumnos;
use App\Http\Models\Primaria\Primaria_calendario_calificaciones_docentes;
use App\Http\Models\Primaria\Primaria_mes_evaluaciones;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class PrimariaFechaPublicacionDocenteController extends Controller
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
        return view('primaria.fecha_publicacion_docente.show-list');
    }

    public function list()
    {
        $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select(
            'primaria_calendario_calificaciones_docentes.id',
            'primaria_calendario_calificaciones_docentes.periodo_id',
            'primaria_calendario_calificaciones_docentes.plan_id',
            'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id',
            'primaria_calendario_calificaciones_docentes.calInicioCaptura',
            'primaria_calendario_calificaciones_docentes.calFinCaptura',
            'primaria_calendario_calificaciones_docentes.calInicioRevision',
            'primaria_calendario_calificaciones_docentes.calFinRevision',
            'periodos.perAnioPago',
            'planes.planClave',
            'primaria_mes_evaluaciones.mes',
            'programas.progClave',
            'programas.progNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre')
        ->join('periodos', 'primaria_calendario_calificaciones_docentes.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('planes', 'primaria_calendario_calificaciones_docentes.plan_id', '=', 'planes.id')
        ->join('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id');


        return DataTables::of($primaria_calendario_calificaciones_docentes)

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

        ->filterColumn('calInicioCaptura',function($query,$keyword){
            $query->whereRaw("CONCAT(calInicioCaptura) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('calInicioCaptura',function($query){
            return Utils::fecha_string($query->calInicioCaptura, $query->calInicioCaptura);
        })

        ->filterColumn('calFinCaptura',function($query,$keyword){
            $query->whereRaw("CONCAT(calFinCaptura) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('calFinCaptura',function($query){
            return Utils::fecha_string($query->calFinCaptura, $query->calFinCaptura);
        })

        ->filterColumn('calInicioRevision',function($query,$keyword){
            $query->whereRaw("CONCAT(calInicioRevision) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('calInicioRevision',function($query){
            return Utils::fecha_string($query->calInicioRevision, $query->calInicioRevision);
        })

        ->filterColumn('calFinRevision',function($query,$keyword){
            $query->whereRaw("CONCAT(calFinRevision) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('calFinRevision',function($query){
            return Utils::fecha_string($query->calFinRevision, $query->calFinRevision);
        })

        ->addColumn('action',function($query){
            return '<a href="primaria_fecha_publicacion_calificacion_docente/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
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
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();

        $primaria_mes_evaluaciones = Primaria_mes_evaluaciones::get();

        return view('primaria.fecha_publicacion_docente.create', [
            'ubicaciones' => $ubicaciones,
            'primaria_mes_evaluaciones' => $primaria_mes_evaluaciones
        ]);
    }

    public function getMesEvaluacion(Request $request, $departamento_id)
    {
        if($request->ajax()){
            $primaria_mes_evaluaciones = Primaria_mes_evaluaciones::where('departamento_id', $departamento_id)
            ->where('mes', '<>', 'DICIEMBRE')
            ->get();

            return response()->json($primaria_mes_evaluaciones);
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
                'primaria_mes_evaluaciones_id' => 'required'             
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'calInicioCaptura.requerid' => 'El campo Fecha inicio de captura es obligatorio.',
                'calFinCaptura.requerid' => 'El campo Fecha de inicio de captura es obligatorio.',
                'calInicioRevision.requerid' => 'El campo Fecha inicio de revisión es obligatorio.',
                'calFinRevision.requerid' => 'El campo Fecha fin de revisión es obligatorio.',
                'primaria_mes_evaluaciones_id.requerid' => 'El campo Mes evaluación es obligatorio.'        
            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withErrors($validator)->withInput();
        } else {
            try {

                $departamento = Departamento::findOrFail($request->departamento_id);
                $periodo = Periodo::findOrFail($departamento->perActual);

                // validaciones de acuerdo a la fechas del inicio y fin del ciclo 
                if($request->calInicioCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }           
                
                if($request->calFinCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }   

                if($request->calInicioRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                if($request->calFinRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                $primaria_calendario_calificaciones_docentes_validaion = Primaria_calendario_calificaciones_docentes::where('periodo_id', '=', $request->periodo_id)
                ->where('plan_id', '=', $request->plan_id)
                ->where('primaria_mes_evaluaciones_id', '=', $request->primaria_mes_evaluaciones_id)
                ->get();

                // validamos si hay registros con los mismos datos 
                if(count($primaria_calendario_calificaciones_docentes_validaion) > 0){
                    alert('Escuela Modelo', 'Ya existe fechas guardadas para el ciclo escolar, el plan y mes de evalución seleccionado, ingrese a editar si así lo requiere', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }

                Primaria_calendario_calificaciones_docentes::create([
                    'periodo_id' => $request->periodo_id,
                    'plan_id' => $request->plan_id,
                    'primaria_mes_evaluaciones_id' => $request->primaria_mes_evaluaciones_id,
                    'calInicioCaptura' => $request->calInicioCaptura,
                    'calFinCaptura' => $request->calFinCaptura,
                    'calInicioRevision' => $request->calInicioRevision,
                    'calFinRevision' => $request->calFinRevision
                ]);

                alert('Escuela Modelo', 'Las fechas de publicación de calificaciones se han creado con éxito', 'success')->showConfirmButton()->autoClose('7000');
                return redirect()->route('primaria.primaria_fecha_publicacion_calificacion_docente.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
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

        $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::findOrFail($id);

        $planes = Plan::findOrFail($primaria_calendario_calificaciones_docentes->plan_id);
        $programa = Programa::findOrFail($planes->programa_id);
        $periodo = Periodo::findOrFail($primaria_calendario_calificaciones_docentes->periodo_id);
        $departamento = Departamento::findOrFail($periodo->departamento_id);
        $ubicaciones = Ubicacion::findOrFail($departamento->ubicacion_id);
        $escuela = Escuela::findOrFail($programa->escuela_id);
        $primaria_mes_evaluaciones = Primaria_mes_evaluaciones::where('departamento_id', $periodo->departamento_id)->where('mes', '<>', 'DICIEMBRE')->get();



        return view('primaria.fecha_publicacion_docente.edit', [
            'primaria_calendario_calificaciones_docentes' => $primaria_calendario_calificaciones_docentes,
            'ubicaciones' => $ubicaciones,
            'planes' => $planes,
            'programa' => $programa,
            'periodo' => $periodo,
            'departamento' => $departamento,
            'escuela' => $escuela,
            'primaria_mes_evaluaciones' => $primaria_mes_evaluaciones
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
                'primaria_mes_evaluaciones_id' => 'required'             
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'calInicioCaptura.requerid' => 'El campo Fecha inicio de captura es obligatorio.',
                'calFinCaptura.requerid' => 'El campo Fecha de inicio de captura es obligatorio.',
                'calInicioRevision.requerid' => 'El campo Fecha inicio de revisión es obligatorio.',
                'calFinRevision.requerid' => 'El campo Fecha fin de revisión es obligatorio.',
                'primaria_mes_evaluaciones_id.requerid' => 'El campo Mes evaluación es obligatorio.'        
            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $departamento = Departamento::findOrFail($request->departamento_id);
                $periodo = Periodo::findOrFail($departamento->perActual);

                // validaciones de acuerdo a la fechas del inicio y fin del ciclo 
                if($request->calInicioCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }           
                
                if($request->calFinCaptura < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinCaptura > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha de inicio de captura no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }   

                if($request->calInicioRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calInicioRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha inicio de revisión no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                if($request->calFinRevision < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }               
                if($request->calFinRevision > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha fin de revisión trimestres no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_docente/create')->withInput();
                }  

                $primaria_calendario_calificaciones_docentes_validaion = Primaria_calendario_calificaciones_docentes::where('periodo_id', '=', $request->periodo_id)
                ->where('plan_id', '=', $request->plan_id)
                ->where('primaria_mes_evaluaciones_id', '=', $request->primaria_mes_evaluaciones_id)
                ->first();

                // validamos si hay registros con los mismos datos 
                if($primaria_calendario_calificaciones_docentes_validaion != ""){
                    if($primaria_calendario_calificaciones_docentes_validaion->id != $id){
                        alert('Escuela Modelo', 'Ya existe fechas guardadas para el ciclo escolar, el plan y mes de evalución seleccionado', 'warning')->showConfirmButton()->autoClose('7000');
                        return redirect('primaria_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
                    }
                    
                }

                // return $request->primaria_mes_evaluaciones_id;
                $meses_eva = Primaria_mes_evaluaciones::where('id', $request->primaria_mes_evaluaciones_id)->first();
                $primaria_calendario_calificaciones_alumnos = Primaria_calendario_calificaciones_alumnos::select('primaria_calendario_calificaciones_alumnos.*',
                'primaria_mes_evaluaciones.mes')
                ->join('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_alumnos.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $request->periodo_id)
                ->where('plan_id', $request->plan_id)
                ->where('primaria_mes_evaluaciones.mes', $meses_eva->mes)
                ->first();

                if($primaria_calendario_calificaciones_alumnos != ""){
                    if($request->calFinRevision > $primaria_calendario_calificaciones_alumnos->calPublicacion){
                        alert('Escuela Modelo', 'La fecha de revisión de calificaciones no puede ser mayor a la fecha de publicación para alumnos', 'warning')->showConfirmButton()->autoClose('7000');
                        return redirect('primaria_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
                    }
                }

                

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::findOrFail($id);
                $primaria_calendario_calificaciones_docentes->update([
                    'periodo_id' => $request->periodo_id,
                    'plan_id' => $request->plan_id,
                    'primaria_mes_evaluaciones_id' => $request->primaria_mes_evaluaciones_id,
                    'calInicioCaptura' => $request->calInicioCaptura,
                    'calFinCaptura' => $request->calFinCaptura,
                    'calInicioRevision' => $request->calInicioRevision,
                    'calFinRevision' => $request->calFinRevision
                ]);
           

                alert('Escuela Modelo', 'Las fechas de publicación de calificaciones se han actualizado con éxito', 'success')->showConfirmButton()->autoClose('7000');
                return redirect()->route('primaria.primaria_fecha_publicacion_calificacion_docente.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('primaria_fecha_publicacion_calificacion_docente/'.$id.'/edit')->withInput();
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
