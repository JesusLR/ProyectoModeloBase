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

class PrimariaFechaPublicacionAlumnoController extends Controller
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
        return view('primaria.fecha_publicacion_alumno.show-list');
    }

    public function list()
    {
        $primaria_calendario_calificaciones_alumnos = Primaria_calendario_calificaciones_alumnos::select(
            'primaria_calendario_calificaciones_alumnos.id',
            'primaria_calendario_calificaciones_alumnos.periodo_id',
            'primaria_calendario_calificaciones_alumnos.plan_id',
            'primaria_calendario_calificaciones_alumnos.primaria_mes_evaluaciones_id',
            'primaria_calendario_calificaciones_alumnos.calPublicacion',
            'periodos.perAnioPago',
            'planes.planClave',
            'primaria_mes_evaluaciones.mes',
            'programas.progClave',
            'programas.progNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre')
        ->join('periodos', 'primaria_calendario_calificaciones_alumnos.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('planes', 'primaria_calendario_calificaciones_alumnos.plan_id', '=', 'planes.id')
        ->join('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_alumnos.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id');


        return DataTables::of($primaria_calendario_calificaciones_alumnos)


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

        ->filterColumn('calPublicacion',function($query,$keyword){
            $query->whereRaw("CONCAT(mes) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('calPublicacion',function($query){
            return Utils::fecha_string($query->calPublicacion, $query->calPublicacion);
        })
        ->addColumn('action',function($query){
            return '<a href="primaria_fecha_publicacion_calificacion_alumno/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
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

        return view('primaria.fecha_publicacion_alumno.create', [
            'ubicaciones' => $ubicaciones,
            'primaria_mes_evaluaciones' => $primaria_mes_evaluaciones
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
                'calPublicacion'  => 'required',
                'primaria_mes_evaluaciones_id' => 'required'             
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'calPublicacion.requerid' => 'El campo Fecha publicación calificación es obligatorio.',                
                'primaria_mes_evaluaciones_id.requerid' => 'El campo Mes evaluación es obligatorio.'        
            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_fecha_publicacion_calificacion_alumno/create')->withErrors($validator)->withInput();
        } else {
            try {

                $departamento = Departamento::findOrFail($request->departamento_id);
                $periodo = Periodo::findOrFail($departamento->perActual);

                // validaciones de acuerdo a la fechas del inicio y fin del ciclo 
                if($request->calPublicacion < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha publicación calificación no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_alumno/create')->withInput();
                }               
                if($request->calPublicacion > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha publicación calificación no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_alumno/create')->withInput();
                }           
                
                

                $primaria_calendario_calificaciones_alumnos_validacion = Primaria_calendario_calificaciones_alumnos::where('periodo_id', '=', $request->periodo_id)
                ->where('plan_id', '=', $request->plan_id)
                ->where('primaria_mes_evaluaciones_id', '=', $request->primaria_mes_evaluaciones_id)
                ->get();

                // validamos si hay registros con los mismos datos 
                if(count($primaria_calendario_calificaciones_alumnos_validacion) > 0){
                    alert('Escuela Modelo', 'Ya existe fechas guardadas para el ciclo escolar, el plan y mes de evalución seleccionado, ingrese a editar si así lo requiere', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_alumno/create')->withInput();
                }

                Primaria_calendario_calificaciones_alumnos::create([
                    'periodo_id' => $request->periodo_id,
                    'plan_id' => $request->plan_id,
                    'primaria_mes_evaluaciones_id' => $request->primaria_mes_evaluaciones_id,
                    'calPublicacion' => $request->calPublicacion
                ]);

                alert('Escuela Modelo', 'Las fecha de publicación de calificación se han creado con éxito', 'success')->showConfirmButton()->autoClose('7000');
                return redirect()->route('primaria.primaria_fecha_publicacion_calificacion_alumno.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('primaria_fecha_publicacion_calificacion_alumno/create')->withInput();
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

        $primaria_calendario_calificaciones_alumnos = Primaria_calendario_calificaciones_alumnos::findOrFail($id);

        $planes = Plan::findOrFail($primaria_calendario_calificaciones_alumnos->plan_id);
        $programa = Programa::findOrFail($planes->programa_id);
        $periodo = Periodo::findOrFail($primaria_calendario_calificaciones_alumnos->periodo_id);
        $departamento = Departamento::findOrFail($periodo->departamento_id);
        $ubicaciones = Ubicacion::findOrFail($departamento->ubicacion_id);
        $escuela = Escuela::findOrFail($programa->escuela_id);
        $primaria_mes_evaluaciones = Primaria_mes_evaluaciones::where('departamento_id', $periodo->departamento_id)->get();



        return view('primaria.fecha_publicacion_alumno.edit', [
            'primaria_calendario_calificaciones_alumnos' => $primaria_calendario_calificaciones_alumnos,
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
                'calPublicacion'  => 'required',
                'primaria_mes_evaluaciones_id' => 'required'             
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'calPublicacion.requerid' => 'El campo Fecha publicación calificación es obligatorio.',                
                'primaria_mes_evaluaciones_id.requerid' => 'El campo Mes evaluación es obligatorio.'        
            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_fecha_publicacion_calificacion_alumno/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $departamento = Departamento::findOrFail(14);
                $periodo = Periodo::findOrFail($departamento->perActual);

                // validaciones de acuerdo a la fechas del inicio y fin del ciclo 
                if($request->calPublicacion < $periodo->perFechaInicial){
                    alert('Escuela Modelo', 'La Fecha publicación calificación no puede ser menor a la fecha de inicio del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_alumno/create')->withInput();
                }               
                if($request->calPublicacion > $periodo->perFechaFinal){
                    alert('Escuela Modelo', 'La Fecha publicación calificación no puede ser mayor a la fecha de final del ciclo', 'warning')->showConfirmButton()->autoClose('7000');
                    return redirect('primaria_fecha_publicacion_calificacion_alumno/create')->withInput();
                }           
                

                $primaria_calendario_calificaciones_alumnos_validacion = Primaria_calendario_calificaciones_alumnos::where('periodo_id', '=', $request->periodo_id)
                ->where('plan_id', '=', $request->plan_id)
                ->where('primaria_mes_evaluaciones_id', '=', $request->primaria_mes_evaluaciones_id)
                ->first();

                // validamos si hay registros con los mismos datos 
                if($primaria_calendario_calificaciones_alumnos_validacion != ""){
                    if($primaria_calendario_calificaciones_alumnos_validacion->id != $id){
                        alert('Escuela Modelo', 'Ya existe fecha guardada para el ciclo escolar, el plan y mes de evalución seleccionado', 'warning')->showConfirmButton()->autoClose('7000');
                        return redirect('primaria_fecha_publicacion_calificacion_alumno/'.$id.'/edit')->withInput();
                    }
                    
                }

                // return $request->primaria_mes_evaluaciones_id;
                $meses_eva = Primaria_mes_evaluaciones::where('id', $request->primaria_mes_evaluaciones_id)->first();

                $primaria_calendario_calificaciones_docentes = Primaria_calendario_calificaciones_docentes::select('primaria_calendario_calificaciones_docentes.*',
                'primaria_mes_evaluaciones.mes')
                ->join('primaria_mes_evaluaciones', 'primaria_calendario_calificaciones_docentes.primaria_mes_evaluaciones_id', '=', 'primaria_mes_evaluaciones.id')
                ->where('periodo_id', $request->periodo_id)
                ->where('plan_id', $request->plan_id)
                ->where('primaria_mes_evaluaciones.mes', $meses_eva->mes)
                ->first();

                if($primaria_calendario_calificaciones_docentes != ""){
                    if($request->calPublicacion < $primaria_calendario_calificaciones_docentes->calFinRevision){
                        alert('Escuela Modelo', 'La fecha de revisión de calificaciones no puede ser mayor a la fecha de publicación para alumnos', 'warning')->showConfirmButton()->autoClose('7000');
                        return redirect('primaria_fecha_publicacion_calificacion_alumno/'.$id.'/edit')->withInput();
                    }
                }
                

                $primaria_calendario_calificaciones_alumnos = Primaria_calendario_calificaciones_alumnos::findOrFail($id);
                $primaria_calendario_calificaciones_alumnos->update([
                    'periodo_id' => $request->periodo_id,
                    'plan_id' => $request->plan_id,
                    'primaria_mes_evaluaciones_id' => $request->primaria_mes_evaluaciones_id,
                    'calPublicacion' => $request->calPublicacion                    
                ]);
           

                alert('Escuela Modelo', 'Las fechas de publicación de calificaciones se han actualizado con éxito', 'success')->showConfirmButton()->autoClose('7000');
                return redirect()->route('primaria.primaria_fecha_publicacion_calificacion_alumno.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('primaria_fecha_publicacion_calificacion_alumno/'.$id.'/edit')->withInput();
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
