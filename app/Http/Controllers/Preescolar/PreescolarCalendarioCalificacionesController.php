<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Preescolar\Preescolar_calendario_calificaciones;
use App\Http\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class PreescolarCalendarioCalificacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('preescolar.calendario_calificaciones.show-list');
    }


    public function list()
    {
        $preescolar_calificaciones_fechas = Preescolar_calendario_calificaciones::select(
            'preescolar_calendario_calificaciones.id',
            'preescolar_calendario_calificaciones.plan_id',
            'preescolar_calendario_calificaciones.periodo_id',
            'preescolar_calendario_calificaciones.trimestre1_docente_inicio',
            'preescolar_calendario_calificaciones.trimestre1_docente_fin',
            'preescolar_calendario_calificaciones.trimestre1_administrativo_edicion',
            'preescolar_calendario_calificaciones.trimestre1_alumnos_publicacion',
            'preescolar_calendario_calificaciones.trimestre2_docente_inicio',
            'preescolar_calendario_calificaciones.trimestre2_docente_fin',
            'preescolar_calendario_calificaciones.trimestre2_administrativo_edicion',
            'preescolar_calendario_calificaciones.trimestre2_alumnos_publicacion',
            'preescolar_calendario_calificaciones.trimestre3_docente_fin',
            'preescolar_calendario_calificaciones.trimestre3_docente_inicio',
            'preescolar_calendario_calificaciones.trimestre3_administrativo_edicion',
            'preescolar_calendario_calificaciones.trimestre3_alumnos_publicacion',
            'planes.planClave',
            'periodos.perNumero',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre')
        ->join('planes', 'preescolar_calendario_calificaciones.plan_id', '=', 'planes.id')
        ->join('periodos', 'preescolar_calendario_calificaciones.periodo_id', '=', 'periodos.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');

        return DataTables::of($preescolar_calificaciones_fechas)
        
        ->filterColumn('ubicacion', function($query, $keyword) {
            $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubicacion', function($query) {
            return $query->ubiNombre;
        })

        ->filterColumn('plan', function($query, $keyword) {
            $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('plan', function($query) {
            return $query->planClave;
        })

        ->filterColumn('year', function($query, $keyword) {
            $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('year', function($query) {
            return $query->perAnioPago;
        })

        ->filterColumn('programa', function($query, $keyword) {
            $query->whereRaw("CONCAT(progClave, ' ', progNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('programa', function($query) {
            return $query->progClave."-".$query->progNombre;
        })

        ->filterColumn('departamento', function($query, $keyword) {
            $query->whereRaw("CONCAT(depClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('departamento', function($query) {
            return $query->depClave;
        })
       
        ->addColumn('action',function($query){
            return '<a href="preescolar_calendario_calificaciones/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="preescolar_calendario_calificaciones/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>

           ';
        })->make(true);
    }

    public function create()
    {
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $departamento = Departamento::select()->whereIn('depClave', ['PRE'])->get();

        return view('preescolar.calendario_calificaciones.create', [
            'ubicaciones' => $ubicaciones,
            'departamento' => $departamento
        ]);

    }

    public function store(Request $request)
    {
        $plan_id = $request->plan_id;
        $periodo_id = $request->periodo_id;
        $trimestre1_docente_inicio = $request->trimestre1_docente_inicio;
        $trimestre1_docente_fin = $request->trimestre1_docente_fin;
        $trimestre1_administrativo_edicion = $request->trimestre1_administrativo_edicion;
        $trimestre1_alumnos_publicacion = $request->trimestre1_alumnos_publicacion;
        $trimestre2_docente_inicio = $request->trimestre2_docente_inicio;
        $trimestre2_docente_fin = $request->trimestre2_docente_fin;
        $trimestre2_administrativo_edicion = $request->trimestre2_administrativo_edicion;
        $trimestre2_alumnos_publicacion = $request->trimestre2_alumnos_publicacion;
        $trimestre3_docente_inicio = $request->trimestre3_docente_inicio;
        $trimestre3_docente_fin = $request->trimestre3_docente_fin;
        $trimestre3_administrativo_edicion = $request->trimestre3_administrativo_edicion;
        $trimestre3_alumnos_publicacion = $request->trimestre3_alumnos_publicacion;

        $validator = Validator::make(
            $request->all(),
            [
                'plan_id' => 'required',
                'periodo_id' => 'required'
            ],
            [
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'periodo_id.required' => 'El campo Período es obligatorio.'
            ]
        );

        if ($validator->fails()) {
            return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
        }
        try {

            $exist = Preescolar_calendario_calificaciones::where('plan_id', $plan_id)->where('periodo_id', $periodo_id)->first();
            $periodo = Periodo::findOrFail($periodo_id);
            $plan = Plan::findOrFail($plan_id);

            $periodo->perFechaInicial;


            if ($exist) {
                alert('Escuela Modelo', 'El período ' . $periodo->perAnioPago . ' y el plan ' . $plan->planClave . ' ya se encuentra registrado', 'warning')->showConfirmButton()->autoClose('6000');
                return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
            }

            // validaciones para el trimestre 1 
            if ($trimestre1_docente_inicio > $periodo->perFechaInicial && $trimestre1_docente_inicio < $periodo->perFechaFinal) {
                if ($trimestre1_docente_fin > $trimestre1_docente_inicio) {
                    if ($trimestre1_administrativo_edicion > $trimestre1_docente_inicio && $trimestre1_administrativo_edicion < $trimestre1_docente_fin) {
                        if ($trimestre1_alumnos_publicacion > $trimestre1_docente_inicio && $trimestre1_alumnos_publicacion < $trimestre1_docente_fin && $trimestre1_alumnos_publicacion > $trimestre1_administrativo_edicion) {
                            $trimestreUno = "Todo Bien";
                        } else {
                            alert('Escuela Modelo', 'La fecha de publicación del trimestre 1 no puede ser menor a la fecha de edición ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                            return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                        }
                    } else {
                        alert('Escuela Modelo', 'La fecha de edición del trimestre 1 no puede ser menor a la fecha de inicio ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                        return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                    }
                } else {
                    alert('Escuela Modelo', 'La fecha de fin del trimestre 1 no puede ser menor a la fecha de inicio', 'warning')->showConfirmButton();
                    return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                }
            } else {
                alert('Escuela Modelo', 'La fecha de inicio del trimestre 1 no puede ser menor a la fecha de inicio del período seleccionado ni mayor a la fecha de fin del período seleccionado', 'warning')->showConfirmButton();
                return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
            }


            // validaciones para el trimestre 2 
            if ($trimestre2_docente_inicio > $trimestre1_docente_fin || $trimestre2_docente_fin < $periodo->perFechaFinal) {
                if ($trimestre2_docente_fin > $trimestre2_docente_inicio) {
                    if ($trimestre2_administrativo_edicion > $trimestre2_docente_inicio && $trimestre2_administrativo_edicion < $trimestre2_docente_fin) {
                        if ($trimestre2_alumnos_publicacion > $trimestre2_docente_inicio && $trimestre2_alumnos_publicacion < $trimestre2_docente_fin && $trimestre2_alumnos_publicacion > $trimestre2_administrativo_edicion) {
                            $trimestreDos = "Todo Bien";
                        } else {
                            alert('Escuela Modelo', 'La fecha de publicación del trimestre 2 no puede ser menor a la fecha de edición ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                            return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                        }
                    } else {
                        alert('Escuela Modelo', 'La fecha de edición del trimestre 2 no puede ser menor a la fecha de inicio ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                        return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                    }
                } else {
                    alert('Escuela Modelo', 'La fecha de fin del trimestre 2 no puede ser menor a la fecha de inicio', 'warning')->showConfirmButton();
                    return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                }
            } else {
                alert('Escuela Modelo', 'La fecha de inicio del trimestre 2 no puede ser menor a la fecha de fin del trimestre 1', 'warning')->showConfirmButton();
                return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
            }


            // validaciones para el trimestre  
            if ($trimestre3_docente_inicio > $trimestre2_docente_fin) {
                if ($trimestre3_docente_fin > $trimestre3_docente_inicio || $trimestre3_docente_fin < $periodo->perFechaFinal) {
                    if ($trimestre3_administrativo_edicion > $trimestre3_docente_inicio && $trimestre3_administrativo_edicion < $trimestre3_docente_fin) {
                        if ($trimestre3_alumnos_publicacion > $trimestre3_docente_inicio && $trimestre3_alumnos_publicacion < $trimestre3_docente_fin && $trimestre3_alumnos_publicacion > $trimestre3_administrativo_edicion) {
                            $trimestreTres = "Todo Bien";
                        } else {
                            alert('Escuela Modelo', 'La fecha de publicación del trimestre 3 no puede ser menor a la fecha de edición ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                            return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                        }
                    } else {
                        alert('Escuela Modelo', 'La fecha de edición del trimestre 3 no puede ser menor a la fecha de inicio ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                        return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                    }
                } else {
                    alert('Escuela Modelo', 'La fecha de fin del trimestre 3 no puede ser menor a la fecha de inicio', 'warning')->showConfirmButton();
                    return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
                }
            } else {
                alert('Escuela Modelo', 'La fecha de inicio del trimestre 3 no puede ser menor a la fecha de fin del trimestre 2', 'warning')->showConfirmButton();
                return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
            }

            if ($trimestreUno = "Todo Bien" && $trimestreDos = "Todo Bien" && $trimestreTres = "Todo Bien") {
                Preescolar_calendario_calificaciones::create([
                    'plan_id' => $plan_id,
                    'periodo_id' => $periodo_id,
                    'trimestre1_docente_inicio' => $trimestre1_docente_inicio,
                    'trimestre1_docente_fin' => $trimestre1_docente_fin,
                    'trimestre1_administrativo_edicion' => $trimestre1_administrativo_edicion,
                    'trimestre1_alumnos_publicacion' => $trimestre1_alumnos_publicacion,
                    'trimestre2_docente_inicio' => $trimestre2_docente_inicio,
                    'trimestre2_docente_fin' => $trimestre2_docente_fin,
                    'trimestre2_administrativo_edicion' => $trimestre2_administrativo_edicion,
                    'trimestre2_alumnos_publicacion' => $trimestre2_alumnos_publicacion,
                    'trimestre3_docente_inicio' => $trimestre3_docente_inicio,
                    'trimestre3_docente_fin' => $trimestre3_docente_fin,
                    'trimestre3_administrativo_edicion' => $trimestre3_administrativo_edicion,
                    'trimestre3_alumnos_publicacion' => $trimestre3_alumnos_publicacion,
                ]);
            } else {
                alert('Escuela Modelo', 'No se pudo guardar la información, intente nuevamente', 'error')->showConfirmButton();
                return redirect('preescolar_calendario_calificaciones/create')->withErrors($validator)->withInput();
            }
            
            alert('Escuela Modelo', 'Las fechas de calificaciones se han creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
            return redirect()->route('preescolar.preescolar_calendario_calificaciones.index');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
                ->error('Ups...' . $errorCode, $errorMessage)
                ->showConfirmButton();
            return redirect('preescolar_calendario_calificaciones/create')->withInput();
        }
    
    }

    public function edit($id)
    {
        $preescolar_calificaciones_fechas = Preescolar_calendario_calificaciones::select(
            'Preescolar_calendario_calificaciones.id',
            'Preescolar_calendario_calificaciones.plan_id',
            'Preescolar_calendario_calificaciones.periodo_id',
            'Preescolar_calendario_calificaciones.trimestre1_docente_inicio',
            'Preescolar_calendario_calificaciones.trimestre1_docente_fin',
            'Preescolar_calendario_calificaciones.trimestre1_administrativo_edicion',
            'Preescolar_calendario_calificaciones.trimestre1_alumnos_publicacion',
            'Preescolar_calendario_calificaciones.trimestre2_docente_inicio',
            'Preescolar_calendario_calificaciones.trimestre2_docente_fin',
            'Preescolar_calendario_calificaciones.trimestre2_administrativo_edicion',
            'Preescolar_calendario_calificaciones.trimestre2_alumnos_publicacion',
            'Preescolar_calendario_calificaciones.trimestre3_docente_fin',
            'Preescolar_calendario_calificaciones.trimestre3_docente_inicio',
            'Preescolar_calendario_calificaciones.trimestre3_administrativo_edicion',
            'Preescolar_calendario_calificaciones.trimestre3_alumnos_publicacion',
            'planes.planClave',
            'periodos.perNumero',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre')
        ->join('planes', 'Preescolar_calendario_calificaciones.plan_id', '=', 'planes.id')
        ->join('periodos', 'Preescolar_calendario_calificaciones.periodo_id', '=', 'periodos.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->findOrFail($id);

        return view('preescolar.fechas_calificaciones.edit', [
            "preescolar_calificaciones_fechas" => $preescolar_calificaciones_fechas
        ]);

    }

    public function update(Request $request, $id)
    {
        $preescolar_calificaciones_fechas = Preescolar_calendario_calificaciones::findOrFail($id);

        $plan_id = $request->plan_id;
        $periodo_id = $request->periodo_id;
        $trimestre1_docente_inicio = $request->trimestre1_docente_inicio;
        $trimestre1_docente_fin = $request->trimestre1_docente_fin;
        $trimestre1_administrativo_edicion = $request->trimestre1_administrativo_edicion;
        $trimestre1_alumnos_publicacion = $request->trimestre1_alumnos_publicacion;
        $trimestre2_docente_inicio = $request->trimestre2_docente_inicio;
        $trimestre2_docente_fin = $request->trimestre2_docente_fin;
        $trimestre2_administrativo_edicion = $request->trimestre2_administrativo_edicion;
        $trimestre2_alumnos_publicacion = $request->trimestre2_alumnos_publicacion;
        $trimestre3_docente_inicio = $request->trimestre3_docente_inicio;
        $trimestre3_docente_fin = $request->trimestre3_docente_fin;
        $trimestre3_administrativo_edicion = $request->trimestre3_administrativo_edicion;
        $trimestre3_alumnos_publicacion = $request->trimestre3_alumnos_publicacion;

        $validator = Validator::make(
            $request->all(),
            [
                'plan_id' => 'required',
                'periodo_id' => 'required'
            ],
            [
                'plan_id.required' => 'El campo Plan es obligatorio.',
                'periodo_id.required' => 'El campo Período es obligatorio.'
            ]
        );

        if ($validator->fails()) {
            return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $exist = Preescolar_calendario_calificaciones::where('plan_id', $plan_id)->where('periodo_id', $periodo_id)->first();
                $periodo = Periodo::findOrFail($periodo_id);
                $plan = Plan::findOrFail($plan_id);


                if ($exist->id == $id) {
                    // validaciones para el trimestre 1 
                    if ($trimestre1_docente_inicio > $periodo->perFechaInicial && $trimestre1_docente_inicio < $periodo->perFechaFinal) {
                        if ($trimestre1_docente_fin > $trimestre1_docente_inicio) {
                            if ($trimestre1_administrativo_edicion > $trimestre1_docente_inicio && $trimestre1_administrativo_edicion < $trimestre1_docente_fin) {
                                if ($trimestre1_alumnos_publicacion > $trimestre1_docente_inicio && $trimestre1_alumnos_publicacion < $trimestre1_docente_fin && $trimestre1_alumnos_publicacion > $trimestre1_administrativo_edicion) {
                                    $trimestreUno = "Todo Bien";
                                } else {
                                    alert('Escuela Modelo', 'La fecha de publicación del trimestre 1 no puede ser menor a la fecha de edición ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                                    return redirect('preescolar_fecha_de_calificaciones/create')->withErrors($validator)->withInput();
                                }
                            } else {
                                alert('Escuela Modelo', 'La fecha de edición del trimestre 1 no puede ser menor a la fecha de inicio ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                                return redirect('preescolar_fecha_de_calificaciones/create')->withErrors($validator)->withInput();
                            }
                        } else {
                            alert('Escuela Modelo', 'La fecha de fin del trimestre 1 no puede ser menor a la fecha de inicio', 'warning')->showConfirmButton();
                            return redirect('preescolar_fecha_de_calificaciones/create')->withErrors($validator)->withInput();
                        }
                    } else {
                        alert('Escuela Modelo', 'La fecha de inicio del trimestre 1 no puede ser menor a la fecha de inicio del período seleccionado ni mayor a la fecha de fin del período seleccionado', 'warning')->showConfirmButton();
                        return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                    }


                    // validaciones para el trimestre 2 
                    if ($trimestre2_docente_inicio > $trimestre1_docente_fin || $trimestre2_docente_fin < $periodo->perFechaFinal) {
                        if ($trimestre2_docente_fin > $trimestre2_docente_inicio) {
                            if ($trimestre2_administrativo_edicion > $trimestre2_docente_inicio && $trimestre2_administrativo_edicion < $trimestre2_docente_fin) {
                                if ($trimestre2_alumnos_publicacion > $trimestre2_docente_inicio && $trimestre2_alumnos_publicacion < $trimestre2_docente_fin && $trimestre2_alumnos_publicacion > $trimestre2_administrativo_edicion) {
                                    $trimestreDos = "Todo Bien";
                                } else {
                                    alert('Escuela Modelo', 'La fecha de publicación del trimestre 2 no puede ser menor a la fecha de edición ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                                    return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                                }
                            } else {
                                alert('Escuela Modelo', 'La fecha de edición del trimestre 2 no puede ser menor a la fecha de inicio ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                                return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                            }
                        } else {
                            alert('Escuela Modelo', 'La fecha de fin del trimestre 2 no puede ser menor a la fecha de inicio', 'warning')->showConfirmButton();
                            return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                        }
                    } else {
                        alert('Escuela Modelo', 'La fecha de inicio del trimestre 2 no puede ser menor a la fecha de fin del trimestre 1', 'warning')->showConfirmButton();
                        return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                    }


                    // validaciones para el trimestre  
                    if ($trimestre3_docente_inicio > $trimestre2_docente_fin) {
                        if ($trimestre3_docente_fin > $trimestre3_docente_inicio || $trimestre3_docente_fin < $periodo->perFechaFinal) {
                            if ($trimestre3_administrativo_edicion > $trimestre3_docente_inicio && $trimestre3_administrativo_edicion < $trimestre3_docente_fin) {
                                if ($trimestre3_alumnos_publicacion > $trimestre3_docente_inicio && $trimestre3_alumnos_publicacion < $trimestre3_docente_fin && $trimestre3_alumnos_publicacion > $trimestre3_administrativo_edicion) {
                                    $trimestreTres = "Todo Bien";
                                } else {
                                    alert('Escuela Modelo', 'La fecha de publicación del trimestre 3 no puede ser menor a la fecha de edición ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                                    return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                                }
                            } else {
                                alert('Escuela Modelo', 'La fecha de edición del trimestre 3 no puede ser menor a la fecha de inicio ni mayor a la fecha de fin', 'warning')->showConfirmButton();
                                return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                            }
                        } else {
                            alert('Escuela Modelo', 'La fecha de fin del trimestre 3 no puede ser menor a la fecha de inicio', 'warning')->showConfirmButton();
                            return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                        }
                    } else {
                        alert('Escuela Modelo', 'La fecha de inicio del trimestre 3 no puede ser menor a la fecha de fin del trimestre 2', 'warning')->showConfirmButton();
                        return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                    }

                    if ($trimestreUno = "Todo Bien" && $trimestreDos = "Todo Bien" && $trimestreTres = "Todo Bien") {
                        $preescolar_calificaciones_fechas->update([
                            'plan_id' => $plan_id,
                            'periodo_id' => $periodo_id,
                            'trimestre1_docente_inicio' => $trimestre1_docente_inicio,
                            'trimestre1_docente_fin' => $trimestre1_docente_fin,
                            'trimestre1_administrativo_edicion' => $trimestre1_administrativo_edicion,
                            'trimestre1_alumnos_publicacion' => $trimestre1_alumnos_publicacion,
                            'trimestre2_docente_inicio' => $trimestre2_docente_inicio,
                            'trimestre2_docente_fin' => $trimestre2_docente_fin,
                            'trimestre2_administrativo_edicion' => $trimestre2_administrativo_edicion,
                            'trimestre2_alumnos_publicacion' => $trimestre2_alumnos_publicacion,
                            'trimestre3_docente_inicio' => $trimestre3_docente_inicio,
                            'trimestre3_docente_fin' => $trimestre3_docente_fin,
                            'trimestre3_administrativo_edicion' => $trimestre3_administrativo_edicion,
                            'trimestre3_alumnos_publicacion' => $trimestre3_alumnos_publicacion,
                        ]);
                    } else {
                        alert('Escuela Modelo', 'No se pudo guardar la información, intente nuevamente', 'error')->showConfirmButton();
                        return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();

                    }
                }
                else{
                    if ($exist != "") {
                        alert('Escuela Modelo', 'El período ' . $periodo->perAnioPago . ' y el plan ' . $plan->planClave . ' ya se encuentra registrado', 'warning')->showConfirmButton()->autoClose('6000');
                        return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withErrors($validator)->withInput();
                    }
                }

               




                alert('Escuela Modelo', 'Las fechas de calificaciones se han actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                // return redirect()->route('preescolar.preescolar_fecha_de_calificaciones.index');
                return back();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('preescolar_fecha_de_calificaciones/' . $id . '/edit')->withInput();
            }
        }
    }
    
    public function show($id)
    {
        $preescolar_calificaciones_fechas = Preescolar_calendario_calificaciones::select(
            'Preescolar_calendario_calificaciones.id',
            'Preescolar_calendario_calificaciones.plan_id',
            'Preescolar_calendario_calificaciones.periodo_id',
            'Preescolar_calendario_calificaciones.trimestre1_docente_inicio',
            'Preescolar_calendario_calificaciones.trimestre1_docente_fin',
            'Preescolar_calendario_calificaciones.trimestre1_administrativo_edicion',
            'Preescolar_calendario_calificaciones.trimestre1_alumnos_publicacion',
            'Preescolar_calendario_calificaciones.trimestre2_docente_inicio',
            'Preescolar_calendario_calificaciones.trimestre2_docente_fin',
            'Preescolar_calendario_calificaciones.trimestre2_administrativo_edicion',
            'Preescolar_calendario_calificaciones.trimestre2_alumnos_publicacion',
            'Preescolar_calendario_calificaciones.trimestre3_docente_fin',
            'Preescolar_calendario_calificaciones.trimestre3_docente_inicio',
            'Preescolar_calendario_calificaciones.trimestre3_administrativo_edicion',
            'Preescolar_calendario_calificaciones.trimestre3_alumnos_publicacion',
            'planes.planClave',
            'periodos.perNumero',
            'periodos.perAnioPago',
            'periodos.perFechaInicial',
            'periodos.perFechaFinal',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre')
        ->join('planes', 'Preescolar_calendario_calificaciones.plan_id', '=', 'planes.id')
        ->join('periodos', 'Preescolar_calendario_calificaciones.periodo_id', '=', 'periodos.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->findOrFail($id);

        return view('preescolar.fechas_calificaciones.show', [
            "preescolar_calificaciones_fechas" => $preescolar_calificaciones_fechas
        ]);
    }
}
