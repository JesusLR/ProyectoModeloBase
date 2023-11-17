<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Alumno;
use App\Http\Models\Bachiller\Bachiller_historico;
use App\Http\Models\Bachiller\Bachiller_materias;
use App\Http\Models\Bachiller\Bachiller_resumenacademico;
use App\Http\Models\Bachiller\Bachiller_UsuarioLog;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerHistoricoAlumnoController extends Controller
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
        return view('bachiller.historico_alumno.show-list');
    }

    public function list()
    {
        $bachiller_historico = Bachiller_historico::select(
            'bachiller_historico.id',
            'bachiller_historico.alumno_id',
            'bachiller_historico.plan_id',
            'bachiller_historico.bachiller_materia_id',
            'bachiller_historico.periodo_id',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histFolio',
            'bachiller_historico.hisActa',
            'bachiller_historico.histLibro',
            'bachiller_historico.histNombreOficial',
            'planes.planClave',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'periodos.perAnio',
            'periodos.perNumero',
            'alumnos.aluClave',
            'personas.perNombre',
            'personas.perApellido1',
            'personas.perApellido2',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'bachiller_materias.matSemestre',
            'periodoReprobado.perAnio as perAnioRepro',
            'periodoReprobado.perNumero as perNumeroRepro'
        )
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->leftJoin('periodos as periodoReprobado', 'bachiller_historico.periodo_id_ficticio', '=', 'periodoReprobado.id')
            //->where('periodos.perAnio', '>=', 2020)
            ->whereIn('planes.id', [94, 103])
            ->whereNull('bachiller_historico.deleted_at')
            ->orderBy('bachiller_historico.id', 'DESC');



        return DataTables::of($bachiller_historico)
            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiNombre;
            })

            ->filterColumn('periodoAnio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(periodos.perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodoAnio', function ($query) {
                return $query->perAnio;
            })

            ->filterColumn('periodoAnioRepro', function ($query, $keyword) {
                $query->whereRaw("CONCAT(periodoReprobado.perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodoAnioRepro', function ($query) {
                return $query->perAnioRepro;
            })

            ->filterColumn('periodoNumero', function ($query, $keyword) {
                $query->whereRaw("CONCAT(periodos.perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodoNumero', function ($query) {
                return $query->perNumero;
            })

            ->filterColumn('periodoNumeroRepro', function ($query, $keyword) {
                $query->whereRaw("CONCAT(periodoReprobado.perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodoNumeroRepro', function ($query) {
                return $query->perNumeroRepro;
            })

            ->filterColumn('plan', function ($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('plan', function ($query) {
                return $query->planClave;
            })

            ->filterColumn('clave_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_materia', function ($query) {
                return $query->matClave;
            })

            ->filterColumn('nombre_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_materia', function ($query) {
                return $query->matNombre;
            })


            ->filterColumn('fecha_examen', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histFechaExamen) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('fecha_examen', function ($query) {

                if($query->histFechaExamen != "0000-00-00"){
                    return Utils::fecha_string($query->histFechaExamen, $query->histFechaExamen);
                }else{
                    return "";
                }
                
            })

            ->filterColumn('clave_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_pago', function ($query) {

                return $query->aluClave;
            })

            ->filterColumn('perApellido_pat', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('perApellido_pat', function ($query) {
                return $query->perApellido1;
            })


            ->filterColumn('perApellido_mat', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('perApellido_mat', function ($query) {
                return $query->perApellido2;
            })

            ->filterColumn('nombre_al', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_al', function ($query) {

                return $query->perNombre;
            })

            ->filterColumn('periodo_acred', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histPeriodoAcreditacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_acred', function ($query) {
                return $query->histPeriodoAcreditacion;
            })

            ->filterColumn('tipo_acred', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histTipoAcreditacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('tipo_acred', function ($query) {
                return $query->histTipoAcreditacion;
            })

            ->filterColumn('califi', function ($query, $keyword) {
                $query->whereRaw("CONCAT(histCalificacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('califi', function ($query) {
                return $query->histCalificacion;
            })

            ->filterColumn('semestre_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matSemestre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('semestre_materia', function ($query) {
                return $query->matSemestre;
            })

            ->addColumn('action', function ($query) {


                $btnEditar = "";
                $btnEliminar = "";

                $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;
                $sistemas = Auth::user()->departamento_sistemas;

                if($ubicacion == $query->ubiClave || $sistemas == 1){
                    $btnEditar = '<a href="/bachiller_historial_academico/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';
                    $btnEliminar = '<form id="delete_' . $query->id . '" action="bachiller_historial_academico/' . $query->id . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                }

                return '<a href="/bachiller_historial_academico/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        return view('bachiller.historico_alumno.create', [
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

        // dd($request->alumno_id, $request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'alumno_id'               => 'required',
                'plan_id'                 => 'required',
                'materia_id'              => 'required',
                'periodo_id'              => 'required',
                'histPeriodoAcreditacion' => 'required',
                'histTipoAcreditacion'    => 'required',
                // 'histFechaExamen'         => 'required',
            ]
            // [
            //     'c.unique' => "La abreviatura ya existe",
            // ]
        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {

            if ($request->histPeriodoAcreditacion == "RV" || $request->histPeriodoAcreditacion == "CP" || $request->histPeriodoAcreditacion == "RC") {
                $bachiller_historico_consulta = Bachiller_historico::where('alumno_id', $request->alumno_id)
                    ->where('plan_id', $request->plan_id)
                    ->where('bachiller_materia_id', $request->materia_id)
                    ->where('periodo_id', $request->periodo_id)
                    ->first();


                // validamos si existe algun registro 
                if (!is_null($bachiller_historico_consulta)) {
                    alert('Upss...', 'La información proporcionada ya se encuentra registrada', 'warning')->showConfirmButton();

                    return redirect('bachiller_historial_academico/create')->withInput();
                }
            }



            $nuevo_registro_historico = Bachiller_historico::create([
                'alumno_id'               => $request->alumno_id,
                'plan_id'                 => $request->plan_id,
                'bachiller_materia_id'    => $request->materia_id,
                'periodo_id'              => $request->periodo_id,
                'histComplementoNombre'   => $request->histComplementoNombre,
                'histPeriodoAcreditacion' => $request->histPeriodoAcreditacion,
                'histTipoAcreditacion'    => $request->histTipoAcreditacion,
                'histFechaExamen'         => $request->histFechaExamen,
                'histCalificacion'        => $request->histCalificacion,
                'histNombreOficial'       => $request->histNombreOficial,
            ]);


            $resumenAcademico = Bachiller_resumenacademico::where("alumno_id", "=", $request->alumno_id)
                ->where("plan_id", "=", $request->plan_id);


            $historicoAlumno = DB::table("vwbachillerhistoricoaprobados as t1")
                ->where("alumno_id", "=", $request->alumno_id)
                ->where("t1.plan_id", "=", $request->plan_id)
                ->join("bachiller_materias as t2", "t2.id", "=", "t1.bachiller_materia_id")
                ->get();


            $materiasAlumno = $historicoAlumno
                ->sortByDesc("histFechaExamen")->unique("bachiller_materia_id")
                ->where("matTipoAcreditacion", "=", "N");


            $materiasAlumno = $materiasAlumno->map(function ($item, $key) {
                if ($item->histCalificacion == -1) {
                    $item->histCalificacion = 0;
                }
                return $item;
            });


            $resCreditosCursados = $materiasAlumno->sum("matCreditos");
            $resCreditosAprobados = $materiasAlumno->where("aprobado", "=", "A")->sum("matCreditos");


            $resPromedioAcumulado = $materiasAlumno->sum("histCalificacion") / $materiasAlumno->count();
            $resPromedioAcumulado = number_format($resPromedioAcumulado, 4);


            $materiasCreditos = Bachiller_materias::where("plan_id", "=", $request->plan_id)->get()->sum("matCreditos");
            $resAvanceAcumulado = ($resCreditosAprobados / $materiasCreditos) * 100;
            $resAvanceAcumulado = number_format($resAvanceAcumulado, 2);


            if ($resumenAcademico->first()) {
                Bachiller_resumenacademico::where("alumno_id", "=", $request->alumno_id)->where("plan_id", "=", $request->plan_id)
                    ->update([
                        "resPeriodoUltimo"     => $request->periodo_id,
                        "resClaveEspecialidad" => null,
                        "resCreditosCursados"  => $resCreditosCursados,
                        "resCreditosAprobados" => $resCreditosAprobados,
                        "resAvanceAcumulado"   => $resAvanceAcumulado,
                        "resPromedioAcumulado" => $resPromedioAcumulado,
                    ]);
            }

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            Bachiller_UsuarioLog::create([
                'alumno_id' => $request->alumno_id,
                'nombre_tabla' => 'bachiller_historico',
                'registro_id' => $nuevo_registro_historico->id,
                'nombre_controlador_accion' => 'App\Http\Controllers\Bachiller\BachillerHistoricoAlumnoController@store',
                'tipo_accion' => 'nuevo_registro por '.auth()->user()->username,
                'fecha_hora_movimiento' => $fechaActual->format('Y-m-d H:i:s')
            ]);

            alert('Escuela Modelo', 'El historico se ha creado con éxito', 'success')->showConfirmButton();
            return back()->withInput();
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];


            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
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

        if(Auth::user()->campus_cme == 1){
            $departameto_id = 7;
        }

        if(Auth::user()->campus_cva == 1){
            $departameto_id = 17;
        }

        $periodos = DB::select("SELECT p.* FROM periodos as p
        INNER JOIN departamentos d ON d.id = p.departamento_id
        WHERE p.deleted_at IS NULL
        AND p.perAnio NOT IN (9018, 9017, 9016, 9015, 9014, 9013, 9012, 9011, 9010, 9009)
        AND d.id = $departameto_id
        ORDER BY p.perAnio DESC, p.perNumero DESC");

        $historico = Bachiller_historico::select(
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'planes.planClave',
            'planes.id as plan_id',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histNombreOficial',
            'bachiller_historico.id'
        )
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('bachiller_historico.id', $id)
            ->first();


        return view('bachiller.historico_alumno.show', compact('historico', 'periodos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if(Auth::user()->campus_cme == 1){
            $departameto_id = 7;
        }

        if(Auth::user()->campus_cva == 1){
            $departameto_id = 17;
        }

        $periodos = DB::select("SELECT p.* FROM periodos as p
        INNER JOIN departamentos d ON d.id = p.departamento_id
        WHERE p.deleted_at IS NULL
        AND p.perAnio NOT IN (9018, 9017, 9016, 9015, 9014, 9013, 9012, 9011, 9010, 9009)
        AND d.id = $departameto_id
        ORDER BY p.perAnio DESC, p.perNumero DESC");

        $historico = Bachiller_historico::select(
            'alumnos.aluClave',
            'alumnos.id as alumno_id',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'planes.planClave',
            'planes.id as plan_id',
            'bachiller_materias.id as bachiller_materia_id',
            'bachiller_materias.matClave',
            'bachiller_materias.matNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'bachiller_historico.histComplementoNombre',
            'bachiller_historico.histPeriodoAcreditacion',
            'bachiller_historico.histTipoAcreditacion',
            'bachiller_historico.histFechaExamen',
            'bachiller_historico.histCalificacion',
            'bachiller_historico.histNombreOficial',
            'bachiller_historico.id'
        )
            ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
            ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('bachiller_historico.id', $id)
            ->first();


        return view('bachiller.historico_alumno.edit', compact('historico', 'periodos'));
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
        try {
            $historico = Bachiller_historico::findOrFail($id);
            $historico->periodo_id              = $request->periodo_id;
            $historico->histComplementoNombre   = $request->histComplementoNombre;
            // $historico->histPeriodoAcreditacion = $request->histPeriodoAcreditacion;
            // $historico->histTipoAcreditacion    = $request->histTipoAcreditacion;
            $historico->histFechaExamen         = $request->histFechaExamen;
            $historico->histCalificacion        = $request->histCalificacion;
            $historico->histNombreOficial       = $request->histNombreOficial;
            $historico->save();


            $resumenAcademico = Bachiller_resumenacademico::where("alumno_id", "=", $request->alumno_id)
                ->where("plan_id", "=", $request->plan_id);


            $historicoAlumno = DB::table("vwbachillerhistoricoaprobados as t1")
                ->where("alumno_id", "=", $request->alumno_id)
                ->where("t1.plan_id", "=", $request->plan_id)
                ->join("bachiller_materias as t2", "t2.id", "=", "t1.bachiller_materia_id")
                ->get();


            $materiasAlumno = $historicoAlumno
                ->sortByDesc("histFechaExamen")->unique("bachiller_materia_id")
                ->where("matTipoAcreditacion", "=", "N");


            $materiasAlumno = $materiasAlumno->map(function ($item, $key) {
                if ($item->histCalificacion == -1) {
                    $item->histCalificacion = 0;
                }
                return $item;
            });



            $resCreditosCursados = $materiasAlumno->sum("matCreditos");
            $resCreditosAprobados = $materiasAlumno->where("aprobado", "=", "A")->sum("matCreditos");


            $resPromedioAcumulado = $materiasAlumno->sum("histCalificacion") / $materiasAlumno->count();
            $resPromedioAcumulado = number_format($resPromedioAcumulado, 4);





            $materiasCreditos = Bachiller_materias::where("plan_id", "=", $request->plan_id)->get()->sum("matCreditos");
            $resAvanceAcumulado = ($resCreditosAprobados / $materiasCreditos) * 100;
            $resAvanceAcumulado = number_format($resAvanceAcumulado, 2);



            if ($resumenAcademico->first()) {
                Bachiller_resumenacademico::where("alumno_id", "=", $request->alumno_id)->where("plan_id", "=", $request->plan_id)
                    ->update([
                        "resPeriodoUltimo"     => $request->periodo_id,
                        "resClaveEspecialidad" => null,
                        "resCreditosCursados"  => $resCreditosCursados,
                        "resCreditosAprobados" => $resCreditosAprobados,
                        "resAvanceAcumulado"   => $resAvanceAcumulado,
                        "resPromedioAcumulado" => $resPromedioAcumulado,
                    ]);
            }


            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            Bachiller_UsuarioLog::create([
                'alumno_id' => $request->alumno_id,
                'nombre_tabla' => 'bachiller_historico',
                'registro_id' => $id,
                'nombre_controlador_accion' => 'App\Http\Controllers\Bachiller\BachillerHistoricoAlumnoController@update',
                'tipo_accion' => 'registro_actualizado por '.auth()->user()->username,
                'fecha_hora_movimiento' => $fechaActual->format('Y-m-d H:i:s')
            ]);



            alert('Escuela Modelo', 'El histórico se ha actualizado con éxito', 'success')->showConfirmButton();
            return redirect('bachiller_historial_academico');
        } catch (QueryException $e) {
            $errorCode    = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            alert()->error('Error' . $errorCode, $errorMessage)->showConfirmButton();
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

        // if (User::permiso("abreviatura") == "A" || User::permiso("abreviatura") == "B") {
        $historico = Bachiller_historico::findOrFail($id);


        $histAlumnoId = $historico->alumno_id;
        $histPlanId   = $historico->plan_id;


        try {

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');
            
            Bachiller_UsuarioLog::create([
                'alumno_id' => $historico->alumno_id,
                'nombre_tabla' => 'bachiller_historico',
                'registro_id' => $historico->id,
                'nombre_controlador_accion' => 'App\Http\Controllers\Bachiller\BachillerHistoricoAlumnoController@destroy',
                'tipo_accion' => 'registro_borrado por '.auth()->user()->username,
                'fecha_hora_movimiento' => $fechaActual->format('Y-m-d H:i:s')
            ]);

            if ($historico->delete()) {

                $resumenAcademico = Bachiller_resumenacademico::where("alumno_id", "=", $histAlumnoId)
                    ->where("plan_id", "=", $histPlanId)->first();

                if ($resumenAcademico) {
                    $historicoAlumno = DB::table("vwbachillerhistoricoaprobados as t1")
                        ->select("*", "t1.id")
                        ->where("alumno_id", "=", $histAlumnoId)
                        ->where("t1.plan_id", "=", $histPlanId)
                        ->join("bachiller_materias as t2", "t2.id", "=", "t1.bachiller_materia_id")
                        ->get();

                    $materiasAlumno = $historicoAlumno
                        ->sortByDesc("histFechaExamen")->unique("bachiller_materia_id")
                        ->where("matTipoAcreditacion", "=", "N");

                    $materiasAlumno = $materiasAlumno->map(function ($item, $key) {
                        if ($item->histCalificacion == -1) {
                            $item->histCalificacion = 0;
                        }
                        return $item;
                    });



                    $resCreditosCursados = $materiasAlumno->sum("matCreditos");

                    $resCreditosAprobados = $materiasAlumno->where("aprobado", "=", "A")->sum("matCreditos");


                    $resPromedioAcumulado = $materiasAlumno->sum("histCalificacion") / $materiasAlumno->count();
                    $resPromedioAcumulado = number_format($resPromedioAcumulado, 4);


                    $materiasCreditos = Bachiller_materias::where("plan_id", "=", $histPlanId)->get()->sum("matCreditos");
                    $resAvanceAcumulado = ($resCreditosAprobados / $materiasCreditos) * 100;
                    $resAvanceAcumulado = number_format($resAvanceAcumulado, 2);



                    Bachiller_resumenacademico::where("alumno_id", "=", $histAlumnoId)
                        ->where("plan_id", "=", $histPlanId)
                        ->update([
                            "resClaveEspecialidad" => null,
                            "resCreditosCursados"  => $resCreditosCursados,
                            "resCreditosAprobados" => $resCreditosAprobados,
                            "resAvanceAcumulado"   => $resAvanceAcumulado,
                            "resPromedioAcumulado" => $resPromedioAcumulado,
                        ]);
                }

                alert('Escuela Modelo', 'El histórico se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el historico')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('error' . $errorCode, $errorMessage)->showConfirmButton();
        }
        // } else {
        //     alert()->error('Error', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        // }

        return redirect()->back();
    }
}
