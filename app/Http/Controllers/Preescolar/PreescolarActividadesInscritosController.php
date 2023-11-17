<?php

namespace App\Http\Controllers\Preescolar;

use App\clases\departamentos\MetodosDepartamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Actividades;
use App\Http\Models\Actividades_inscritos;
use App\Http\Models\Alumno;
use App\Http\Models\Beca;
use App\Http\Models\Curso;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class PreescolarActividadesInscritosController extends Controller
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
        return view('preescolar.actividades_inscritos.show-list');
    }

    public function list()
    {      
        $actividad_inscrito = Actividades_inscritos::select('actividades_inscritos.id',
        'actividades_inscritos.alumno_id',
        'actividades_inscritos.actividad_id',
        'actividades_inscritos.aeiTipoBeca',
        'actividades_inscritos.aeiPorcentajeBeca',
        'actividades_inscritos.aeiObservacionesBeca',
        'actividades_inscritos.aeiFechaRegistro',
        'actividades_inscritos.aeiFechaBaja',
        'actividades_inscritos.aeiEstado',
        'actividades.actGrupo',
        'actividades.actDescripcion',
        'alumnos.aluClave',
        'personas.perApellido1',
        'personas.perApellido2',
        'personas.perNombre',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnioPago',
        'periodos.perFechaInicial',
        'periodos.perFechaFinal',
        'departamentos.id  as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre')
        ->join('actividades', 'actividades_inscritos.actividad_id', '=', 'actividades.id')
        ->join('alumnos', 'actividades_inscritos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('periodos', 'actividades.periodo_id', '=', 'periodos.id')
        ->join('programas', 'actividades.programa_id', '=', 'programas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('empleados', 'actividades.empleado_id', '=', 'empleados.id')
        ->leftJoin('personas as personaEmpleado', 'empleados.persona_id', '=', 'personaEmpleado.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->whereIn('departamentos.depclave', ['AEX'])
        ->orderBy('actividades_inscritos.id', 'DESC');



        //->where('periodos.id', $perActual)


        $acciones = '';
        return DataTables::of($actividad_inscrito)

            ->filterColumn('actividad_grupo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(actGrupo) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('actividad_grupo', function ($query) {
                return $query->actGrupo;
            })

            ->filterColumn('actividad_descrip', function ($query, $keyword) {
                $query->whereRaw("CONCAT(actDescripcion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('actividad_descrip', function ($query) {
                return $query->actDescripcion;
            })

            ->filterColumn('alumno_clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('alumno_clave', function ($query) {
                return $query->aluClave;
            })

            ->filterColumn('alumno_nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('alumno_nombre', function ($query) {
                return $query->perNombre;
            })

            ->filterColumn('alumno_apellido1', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('alumno_apellido1', function ($query) {
                return $query->perApellido1;
            })

            ->filterColumn('alumno_apellido2', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('alumno_apellido2', function ($query) {
                return $query->perApellido2;
            })

            ->filterColumn('escuela_clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(escNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('escuela_clave', function ($query) {
                return $query->escNombre;
            })

            ->filterColumn('periodo_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_pago', function ($query) {
                return $query->perAnioPago;
            })
            
            ->filterColumn('periodo_numero', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('periodo_numero', function ($query) {
                return $query->perNumero;
            })

            ->filterColumn('programa_clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(progClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('programa_clave', function ($query) {
                return $query->progClave;
            })
            ->filterColumn('programa_nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('programa_nombre', function ($query) {
                return $query->progNombre;
            })
            ->filterColumn('departamento_clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(depClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('departamento_clave', function ($query) {
                return $query->depClave;
            })

            ->filterColumn('departamento_nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(depNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('departamento_nombre', function ($query) {
                return $query->depNombre;
            })

            ->filterColumn('ubicacion_clave', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion_clave', function ($query) {
                return $query->ubiClave;
            })

            ->filterColumn('ubicacion_nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion_nombre', function ($query) {
                return $query->ubiNombre;
            })


            ->addColumn('action', function ($actividad_inscrito) {

                $cursos = Curso::select('cursos.id as curso_id', 'cursos.curTipoBeca', 'cursos.curPorcentajeBeca',
                'alumnos.aluClave', 'alumnos.id as alumno_id', 'alumnos.aluEstado', 'alumnos.aluMatricula', 'personas.perNombre',
                'personas.perApellido1', 'personas.perApellido2', 'periodos.id as periodo_id',
                'periodos.perNumero', 'periodos.perAnio',
                'periodos.perAnioPago', 'cursos.curEstado', 'cursos.curTipoIngreso', 'cursos.curFechaBaja',
                'cgt.cgtGradoSemestre', 'cgt.cgtGrupo', 'planes.id as plan_id', 'planes.planClave', 'programas.id as programa_id',
                'programas.progNombre', 'programas.progClave',
                'escuelas.escNombre', 'escuelas.escClave',
                'departamentos.depNombre', 'departamentos.depClave',
                'ubicacion.ubiNombre', 'ubicacion.ubiClave')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->where('cursos.alumno_id', $actividad_inscrito->alumno_id)
                ->where('cursos.periodo_id', $actividad_inscrito->periodo_id)
                ->whereIn('depClave', ['AEX'])->get();
                
                $btnHistorial = "";
                $btnListaActividades = "";
                if(count($cursos) > 0){
                    foreach($cursos as $c){
                        $btnHistorial = '<a href="#modalHistorialPagosAluPreescolar" data-nombres="' . $actividad_inscrito->perNombre." ".$actividad_inscrito->perApellido1." ".$actividad_inscrito->perApellido2 .
                        '" data-aluclave="'. $c->aluClave .'"  data-curso-id="' . $c->curso_id . '" class="modal-trigger btn-modal-historial-pagos-preescolar button button--icon js-button js-ripple-effect" title="Historial Pagos">
                        <i class="material-icons">attach_money</i>
                        </a>';
                    }
                }else{
                    $btnHistorial = '<a href="#modalHistorialPagosAluPreescolar" data-nombres="' . $actividad_inscrito->perNombre." ".$actividad_inscrito->perApellido1." ".$actividad_inscrito->perApellido2 .
                    '" data-aluclave="'. $actividad_inscrito->aluClave .'"  class="modal-trigger btn-modal-historial-pagos-preescolar button button--icon js-button js-ripple-effect" title="Historial Pagos">
                    <i class="material-icons">attach_money</i>
                    </a>';
                }

                $btnFichaPago = '<a href="/preescolar_pagos/ficha_general/'.$actividad_inscrito->aluClave.'/'.$actividad_inscrito->perAnioPago.'/'.$actividad_inscrito->programa_id.'" target="_blank" class="button button--icon js-button js-ripple-effect" title="Ficha de pago">
                <i class="material-icons">local_atm</i>
                </a>';

                $btnListaActividades = '<a href="preescolar_actividades_inscritos/imprimir/' . $actividad_inscrito->id . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Listado de inscritos" >
                        <i class="material-icons">picture_as_pdf</i>
                        </a>';

                $acciones = '<div class="row">'                   

                    .$btnHistorial
                    
                    .$btnFichaPago.

                    '<a href="preescolar_actividades_inscritos/' . $actividad_inscrito->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>

                    <a href="preescolar_actividades_inscritos/' . $actividad_inscrito->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>

                    <form id="delete_' . $actividad_inscrito->id . '" action="preescolar_actividades_inscritos/baja_actividad_inscrito/' . $actividad_inscrito->id . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $actividad_inscrito->id . '" class="button button--icon js-button js-ripple-effect confirm-baja" title="Baja">
                            <i class="material-icons">archive</i>
                        </a>
                    </form>

                    '
                    .$btnListaActividades;
                
                return $acciones;
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
        $alumno = null;
        // Mostrar solo Mérida y valladolid 
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $becas = Beca::get();

        $alumnoNew = "";

        return view('preescolar.actividades_inscritos.create',[
            'alumno' => $alumno,
            'ubicaciones' => $ubicaciones,
            'becas' => $becas,
            'alumnoNew' => $alumnoNew
        ]);
    }

    public function getActividades(Request $request, $periodo_id, $programa_id)
    {
        if($request->ajax()){

            $actividades = DB::select("SELECT actividades.*, personas.perApellido1,
            personas.perApellido2, personas.perNombre
            FROM actividades AS actividades
            LEFT JOIN empleados AS empleados ON empleados.id = actividades.empleado_id
            LEFT JOIN personas AS personas ON personas.id = empleados.persona_id
            WHERE actividades.periodo_id = $periodo_id
            AND actividades.programa_id = $programa_id
            AND actividades.actEstado <> 'B'");

            return response()->json($actividades);
        }
    }

    public function getPeriodos(Request $request, $departamento_id)
    {
        $fecha = Carbon::now('CDT');
      

        $departamento = Departamento::where("id", "=", $departamento_id)->first();
        $perActual = $departamento->perActual;
        $perSiguiente = $departamento->perSig;

        if ($departamento->depClave == "AEX")
        {
            if ((Auth::user()->departamento_control_escolar == 1))
            {
                $periodos = Periodo::where('departamento_id',$departamento_id)
                    ->where('perNumero', '=', 0)
                    ->whereIn('id', [$perActual, $perSiguiente])
                    ->orderBy('id', 'desc')->get();
            }
            else
            {
                $periodos = Periodo::where('departamento_id',$departamento_id)
                    ->where('perNumero', '=', 0)
                    ->orderBy('id', 'desc')->get();
            }

        }
        else
        {
            if ((Auth::user()->departamento_control_escolar == 1))
            {
                $periodos = Periodo::where('departamento_id',$departamento_id)
                    ->whereIn('id', [$perActual, $perSiguiente])
                    ->orderBy('id', 'desc')->get();
            }
            else
            {
                $periodos = Periodo::where('departamento_id',$departamento_id)
                    ->orderBy('id', 'desc')->get();
            }

        }



        /*
        * Si $request posee una variable llamada 'field'.
        * retorna un "distinct" de los valores.
        * (creada para selects perNumero o perAnio).
        */
        if($request->field && $request->field == 'perNumero') {
            $periodos = $periodos->sortBy('perNumero')->pluck('perNumero')->unique();
        } elseif ($request->field && $request->field == 'perAnio') {
            $periodos = $periodos->pluck('perAnio')->unique();
        }

        if ($request->ajax()) {
            return response()->json($periodos);
        }
    }

    public function getDepartamentos(Request $request, $id)
    {
        if($request->ajax()){
            // $departamentos = Departamento::with('ubicacion')->where('ubicacion_id','=',$id)
            // ->whereIn('depClave', ['SUP', 'POS'])->get();

            $depClaveUsuario = Auth::user()->empleado->escuela->departamento->depClave;
            $depMAT = 'XXX';
            $depPRE = 'XXX';
            $depPRI = 'XXX';
            $depSEC = 'XXX';
            $depBAC = 'XXX';
            $depSUP = 'XXX';
            $depPOS = 'XXX';
            $depDIP = 'XXX';
            $depAEX = 'XXX';


            if (   (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
                || (Auth::user()->educontinua == 1) )
            {
                $depSUP = 'SUP';
                $depPOS = 'POS';
                $depDIP = 'DIP';
            }

            if (Auth::user()->bachiller == 1)
            {
                $depBAC = 'BAC';
            }

            if (Auth::user()->secundaria == 1)
            {
                $depSEC = 'SEC';
            }

            if (Auth::user()->primaria == 1)
            {
                $depAEX = 'AEX';
            }

            if ( (Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1) )
            {
                $depAEX = 'AEX';
            }

            $departamentos = null;

            // $departamentos = MetodosDepartamentos::buscarSoloAcademicos($id,
            //     [$depMAT, $depPRE, $depPRI, $depSEC, $depBAC, $depSUP, $depPOS, $depDIP]);
                $departamentos = MetodosDepartamentos::buscarAEX(1, ['AEX'])->unique("depClave");


  
            return response()->json($departamentos);
        }
    }

    public function getEscuelas(Request $request)
    {

        if($request->ajax()){
            $escuelas = Escuela::where('departamento_id','=',$request->id)
                ->where(function($query) use ($request) {
                    $query->where("escNombre", "like", "ESCUELA%");
                    $query->orWhere('escNombre', "like", "POSGRADOS%");
                    $query->orWhere('escNombre', "like", "MAESTRIAS%");
                    $query->orWhere('escNombre', "like", "ESPECIALIDADES%");
                    $query->orWhere('escNombre', "like", "DOCTORADOS%");
                    $query->orWhere('escNombre', "like", "PRESCOLAR%");
                    $query->orWhere('escNombre', "like", "PRIMARIA%");
                    $query->orWhere('escNombre', "like", "MATERNAL%");
                    $query->orWhere('escNombre', "like", "SECUNDARIA%");
                    $query->orWhere('escNombre', "like", "BACHILLERATO%");
                    $query->orWhere('escNombre', "like", "DEPORTES%");
                    $query->orWhere('escNombre', "like", "INSTITUTO DE IDIOMAS DE LA ESCUELA MODELO%");
                    $query->orWhere('escNombre', "like", "SERVICIOS COMPLEMENTARIOS%");


                    if ($request->otro == "diplomados") {
                        $query->orWhere('escNombre', "like", "DIPLOMADOS%");
                    }
                })
            ->get();

            return response()->json($escuelas);
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
                'alumno_id'  => 'required',
                'actividad_id'  => 'required',
                // 'aeiTipoBeca'  => 'required',
                // 'aeiPorcentajeBeca'  => 'required'
                
            ],
            [
                'alumno_id.required' => 'El campo Alumno es obligatorio.',
                'actividad_id.required' => 'El campo Actividad es obligatorio',
                // 'aeiTipoBeca.required' => 'El campo Beca es obligatorio',
                // 'aeiPorcentajeBeca.required' => 'El campo Porcentaje beca es obligatorio'
                
            ]
        );

        if ($validator->fails()) {
            return redirect('preescolar_actividades_inscritos/create')->withErrors($validator)->withInput();
        } else {
            try {

                $fechaActual = Carbon::now('America/Merida');

                $actividad_inscrito = Actividades_inscritos::create([
                    'alumno_id' => $request->alumno_id,
                    'actividad_id' => $request->actividad_id,
                    'aeiTipoBeca' => $request->aeiTipoBeca,
                    'aeiPorcentajeBeca' => $request->aeiPorcentajeBeca,
                    'aeiObservacionesBeca' => $request->aeiObservacionesBeca,
                    'aeiFechaRegistro' => $fechaActual->format('Y-m-d'),
                    'aeiEstado' => 'R'
                ]);


                alert('Escuela Modelo', 'La actividad del inscrito se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('preescolar.preescolar_actividades_inscritos.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('preescolar_actividades_inscritos/create')->withInput();
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
        

        $actividad_inscrito = Actividades_inscritos::select('actividades_inscritos.id',
        'actividades_inscritos.alumno_id',
        'actividades_inscritos.actividad_id',
        'actividades_inscritos.aeiTipoBeca',
        'actividades_inscritos.aeiPorcentajeBeca',
        'actividades_inscritos.aeiObservacionesBeca',
        'actividades_inscritos.aeiFechaRegistro',
        'actividades_inscritos.aeiFechaBaja',
        'actividades_inscritos.aeiEstado',
        'actividades.actGrupo',
        'actividades.actDescripcion',
        'alumnos.aluClave',
        'personas.perApellido1',
        'personas.perApellido2',
        'personas.perNombre',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnioPago',
        'periodos.perFechaInicial',
        'periodos.perFechaFinal',
        'departamentos.id  as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre',
        'personasEmpleados.perApellido1 as empApellido1',
        'personasEmpleados.perApellido2 as empApellido2',
        'personasEmpleados.perNombre as empNombre')
        ->join('actividades', 'actividades_inscritos.actividad_id', '=', 'actividades.id')
        ->join('alumnos', 'actividades_inscritos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('periodos', 'actividades.periodo_id', '=', 'periodos.id')
        ->join('programas', 'actividades.programa_id', '=', 'programas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('empleados', 'actividades.empleado_id', '=', 'empleados.id')
        ->leftJoin('personas as personasEmpleados', 'actividades.empleado_id', '=', 'personasEmpleados.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->findOrFail($id);

        $becas = Beca::where('bcaClave', $actividad_inscrito->aeiTipoBeca)->first();

        return view('preescolar.actividades_inscritos.show',[
            'becas' => $becas,
            'actividad_inscrito' => $actividad_inscrito
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
        $becas = Beca::get();

        $actividad_inscrito = Actividades_inscritos::select('actividades_inscritos.id',
        'actividades_inscritos.alumno_id',
        'actividades_inscritos.actividad_id',
        'actividades_inscritos.aeiTipoBeca',
        'actividades_inscritos.aeiPorcentajeBeca',
        'actividades_inscritos.aeiObservacionesBeca',
        'actividades_inscritos.aeiFechaRegistro',
        'actividades_inscritos.aeiFechaBaja',
        'actividades_inscritos.aeiEstado',
        'actividades.actGrupo',
        'actividades.actDescripcion',
        'alumnos.aluClave',
        'personas.perApellido1',
        'personas.perApellido2',
        'personas.perNombre',
        'periodos.id as periodo_id',
        'periodos.perNumero',
        'periodos.perAnioPago',
        'periodos.perFechaInicial',
        'periodos.perFechaFinal',
        'departamentos.id  as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'escuelas.id as escuela_id',
        'escuelas.escClave',
        'escuelas.escNombre')
        ->join('actividades', 'actividades_inscritos.actividad_id', '=', 'actividades.id')
        ->join('alumnos', 'actividades_inscritos.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('periodos', 'actividades.periodo_id', '=', 'periodos.id')
        ->join('programas', 'actividades.programa_id', '=', 'programas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('empleados', 'actividades.empleado_id', '=', 'empleados.id')
        ->leftJoin('personas as personasEmpleados', 'actividades.empleado_id', '=', 'personasEmpleados.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->findOrFail($id);

        return view('preescolar.actividades_inscritos.edit',[
            'becas' => $becas,
            'actividad_inscrito' => $actividad_inscrito
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
                'alumno_id'  => 'required',
                'actividad_id'  => 'required',
                // 'aeiTipoBeca'  => 'required',
                // 'aeiPorcentajeBeca'  => 'required'
                
            ],
            [
                'alumno_id.required' => 'El campo Alumno es obligatorio.',
                'actividad_id.required' => 'El campo Actividad es obligatorio',
                // 'aeiTipoBeca.required' => 'El campo Beca es obligatorio',
                // 'aeiPorcentajeBeca.required' => 'El campo Porcentaje beca es obligatorio'
                
            ]
        );

        if ($validator->fails()) {
            return redirect('preescolar_actividades_inscritos/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $fechaActual = Carbon::now('America/Merida');
                $actividad_inscrito = Actividades_inscritos::findOrFail($id);

                $actividad_inscrito->update([
                    'alumno_id' => $request->alumno_id,
                    'actividad_id' => $request->actividad_id,
                    'aeiTipoBeca' => $request->aeiTipoBeca,
                    'aeiPorcentajeBeca' => $request->aeiPorcentajeBeca,
                    'aeiObservacionesBeca' => $request->aeiObservacionesBeca,
                    'aeiFechaRegistro' => $fechaActual->format('Y-m-d'),
                    'aeiEstado' => 'R'
                ]);


                alert('Escuela Modelo', 'La actividad del inscrito se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                // return redirect()->route('preescolar.preescolar_actividades_inscritos.index');
                return back();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('preescolar_actividades_inscritos/'.$id.'/edit')->withInput();
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function baja_actividad_inscrito($id)
    {
        $actividad_inscrito = Actividades_inscritos::findOrFail($id);
        
        $fechaActual = Carbon::now('America/Merida');
        

        $actividad_inscrito->update([
            'aeiFechaBaja' => $fechaActual->format('Y-m-d'),
            'aeiEstado' => "B",
            'updated_at' => $fechaActual->format('Y-m-d H:i:s')
        ]);

        alert('Escuela Modelo', 'La actividad del inscrito se dio de baja con éxito','success')->showConfirmButton();
        return redirect('preescolar_actividades_inscritos');

        
    }

    public function listadoInscritos($id)
    {
       $inscritoActividad = Actividades_inscritos::findOrFail($id);

        $inscritosActividades = Actividades_inscritos::select('actividades_inscritos.id',
       'actividades_inscritos.alumno_id',
       'actividades_inscritos.actividad_id',
       'actividades_inscritos.aeiTipoBeca',
       'actividades_inscritos.aeiPorcentajeBeca',
       'actividades_inscritos.aeiObservacionesBeca',
       'actividades_inscritos.aeiFechaRegistro',
       'actividades_inscritos.aeiFechaBaja',
       'actividades_inscritos.aeiEstado',
       'actividades.periodo_id',
       'actividades.programa_id',
       'actividades.actGrupo',
       'actividades.actDescripcion',
       'actividades.empleado_id',
       'actividades.actImporte',
       'actividades.actNumeroPagos',
       'actividades.actEstado',
       'actividades.actCupo',
       'actividades.actTotal',
       'actividades.actInscritos',
       'actividades.actPreinscritos',
       'alumnos.aluClave',
       'personasAlumno.perApellido1',
       'personasAlumno.perApellido2',
       'personasAlumno.perNombre',
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
       'ubicacion.ubiNombre',
       'personasEmpleado.perApellido1 as apellido1Docente',
       'personasEmpleado.perApellido2 as apellido2Docente',
       'personasEmpleado.perNombre as nombreDocente',
       'conceptospago_aex.conc_pago1',
       'conceptospago_aex.conc_pago2',
       'conceptospago_aex.conc_pago3',
       'conceptospago_aex.conc_pago4',
       'conceptospago_aex.conc_pago5',
       'conceptospago_aex.conc_pago6',
       'conceptospago_aex.conc_pago7',
       'conceptospago_aex.conc_pago8',
       'conceptospago_aex.conc_pago9',
       'conceptospago_aex.conc_pago10')
       ->join('actividades', 'actividades_inscritos.actividad_id', '=', 'actividades.id')
       ->join('alumnos', 'actividades_inscritos.alumno_id', '=', 'alumnos.id')
       ->join('personas as personasAlumno', 'alumnos.persona_id', '=', 'personasAlumno.id')
       ->join('periodos', 'actividades.periodo_id', '=', 'periodos.id')
       ->join('programas', 'actividades.programa_id', '=', 'programas.id')
       ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
       ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
       ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
       ->leftJoin('empleados', 'actividades.empleado_id', '=', 'empleados.id')
       ->leftJoin('personas as personasEmpleado', 'empleados.persona_id', '=', 'personasEmpleado.id')
       ->leftJoin('conceptospago_aex', 'conceptospago_aex.programa_id', '=', 'programas.id')
       ->where('actividades_inscritos.actividad_id', $inscritoActividad->actividad_id)
       ->get();

       if(count($inscritosActividades) < 1){
            alert()->warning('Sin coincidencias', 'No existen inscritos actividades relacionados a su busqueda')->showConfirmButton();
            return back();
       }
       
       $parametroAnio = $inscritosActividades[0]->perAnioPago;
       $parametro_NombreArchivo = "pdf_listado_de_inscritos_actividades";

       $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');        // En windows
        setlocale(LC_TIME, 'spanish');


       $pdf = PDF::loadView('actividades_inscritos.pdf.' . $parametro_NombreArchivo, [
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "inscritosActividades" => $inscritosActividades   
        ]);

        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo .'_'. $parametroAnio . '.pdf');
        return $pdf->download($parametro_NombreArchivo .'_'. $parametroAnio . '.pdf');
    }
}
