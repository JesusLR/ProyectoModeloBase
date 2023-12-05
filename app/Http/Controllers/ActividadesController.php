<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Actividades;
use App\Models\Empleado;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class ActividadesController extends Controller
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
        return view('actividades.show-list');
    }

    
    public function list()
    {

      
        $actividad = Actividades::select('actividades.id',
        'actividades.periodo_id',
        'actividades.programa_id',
        'actividades.actGrupo',
        'actividades.actDescripcion',
        'actividades.empleado_id',
        'actividades.actImporte',
        'actividades.actNumeroPagos',
        'actividades.actEstado',
        'actividades.actCupo',
        'actividades.actTotaL',
        'actividades.actInscritos',
        'actividades.actPreinscritos',
        'actividades.actBajas',
        'actividades.actOtros',
        'periodos.perAnioPago',
        'periodos.perNumero',
        'programas.progClave',
        'programas.progNombre',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'escuelas.escClave', 
        'escuelas.escNombre',
        'personas.perNombre',
        'personas.perApellido1',
        'personas.perApellido2')
        ->join('periodos', 'actividades.periodo_id', '=', 'periodos.id')
        ->join('programas', 'actividades.programa_id', '=', 'programas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('empleados', 'actividades.empleado_id', '=', 'empleados.id')
        ->leftJoin('personas', 'empleados.persona_id', '=', 'personas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->whereIn('departamentos.depClave', ['SUP', 'POS', 'DIP', 'AEX'])
        ->orderBy('actividades.id', 'DESC');


        //->where('periodos.id', $perActual)


        $acciones = '';
        return DataTables::of($actividad)

            ->filterColumn('nombreCompletoDocente',function($query,$keyword) {
                $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombreCompletoDocente',function($query) {
                return $query->perNombre." ".$query->perApellido1." ".$query->perApellido2;
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


            ->addColumn('action', function ($actividad) {
                $acciones = '<div class="row">                   

                    <a href="actividades/' . $actividad->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>

                    <a href="actividades/' . $actividad->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                    </a>

                    ';
                
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
        $ubicaciones = Ubicacion::whereIn('id', [1,2,3,4])->get();

        $empleados = Empleado::select('empleados.id', 'personas.perApellido1','personas.perApellido2', 'personas.perNombre')
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        // ->whereIn('empleados.escuela_id', [19, 80])
        ->where('empEstado', '<>', 'B')->get();

        return view('actividades.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados
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
                'programa_id'  => 'required',
                'actGrupo'  => 'required',

                
            ],
            [
                'periodo_id.required' => 'El campo Perído es obligatorio.',
                'programa_id.required' => 'El campo Programa es obligatorio.',
                'actGrupo.required'  => 'El campo Actividad es obligatorio.',                
            ]
        );

        if ($validator->fails()) {
            return redirect('actividades/create')->withErrors($validator)->withInput();
        } else {
            try {

                $actividades = Actividades::create([
                    'periodo_id' => $request->periodo_id,
                    'programa_id' => $request->programa_id,
                    'actGrupo' => $request->actGrupo,
                    'actDescripcion' => $request->actDescripcion,
                    'empleado_id' => $request->empleado_id,
                    'actImporte' => $request->actImporte,
                    'actNumeroPagos' => $request->actNumeroPagos,
                    'actEstado' => "A",
                    'actCupo' => $request->actCupo,
                    'actTotal' => NULL,
                    'actInscritos' => NULL,
                    'actPreinscritos' => NULL,
                    'actBajas' => NULL,
                    'actOtros' => NULL
                ]);

                alert('Escuela Modelo', 'El seguimiento escolar se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('universidad.universidad_actividades.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('actividades/create')->withInput();
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
        $actividad = Actividades::select('actividades.id',
        'actividades.periodo_id',
        'actividades.programa_id',
        'actividades.actGrupo',
        'actividades.actDescripcion',
        'actividades.empleado_id',
        'actividades.actImporte',
        'actividades.actNumeroPagos',
        'actividades.actEstado',
        'actividades.actCupo',
        'actividades.actTotaL',
        'actividades.actInscritos',
        'actividades.actPreinscritos',
        'actividades.actBajas',
        'actividades.actOtros',
        'periodos.id as periodo_id',
        'periodos.perAnioPago',
        'periodos.perNumero',
        'periodos.perFechaInicial',
        'periodos.perFechaFinal',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'escuelas.id as escuela_id',
        'escuelas.escClave', 
        'escuelas.escNombre',
        'personas.perNombre',
        'personas.perApellido1',
        'personas.perApellido2')
        ->join('periodos', 'actividades.periodo_id', '=', 'periodos.id')
        ->join('programas', 'actividades.programa_id', '=', 'programas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('empleados', 'actividades.empleado_id', '=', 'empleados.id')
        ->leftJoin('personas', 'empleados.persona_id', '=', 'personas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->where('actividades.id', $id)
        ->first();

        return view('actividades.show', [
            'actividad' => $actividad
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
        $empleados = Empleado::select('empleados.id', 'personas.perApellido1','personas.perApellido2', 'personas.perNombre')
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        // ->whereIn('empleados.escuela_id', [19, 80])
        ->where('empEstado', '<>', 'B')->get();

        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();


        $actividad = Actividades::select('actividades.id',
        'actividades.periodo_id',
        'actividades.programa_id',
        'actividades.actGrupo',
        'actividades.actDescripcion',
        'actividades.empleado_id',
        'actividades.actImporte',
        'actividades.actNumeroPagos',
        'actividades.actEstado',
        'actividades.actCupo',
        'actividades.actTotaL',
        'actividades.actInscritos',
        'actividades.actPreinscritos',
        'actividades.actBajas',
        'actividades.actOtros',
        'periodos.id as periodo_id',
        'periodos.perAnioPago',
        'periodos.perNumero',
        'periodos.perFechaInicial',
        'periodos.perFechaFinal',
        'programas.id as programa_id',
        'programas.progClave',
        'programas.progNombre',
        'departamentos.id as departamento_id',
        'departamentos.depClave',
        'departamentos.depNombre',
        'ubicacion.id as ubicacion_id',
        'ubicacion.ubiClave',
        'ubicacion.ubiNombre',
        'escuelas.id as escuela_id',
        'escuelas.escClave', 
        'escuelas.escNombre',
        'personas.perNombre',
        'personas.perApellido1',
        'personas.perApellido2')
        ->join('periodos', 'actividades.periodo_id', '=', 'periodos.id')
        ->join('programas', 'actividades.programa_id', '=', 'programas.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->leftJoin('empleados', 'actividades.empleado_id', '=', 'empleados.id')
        ->leftJoin('personas', 'actividades.empleado_id', '=', 'personas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->where('actividades.id', $id)
        ->first();

        return view('actividades.edit', [
            'empleados' => $empleados,
            'actividad' => $actividad,
            'ubicaciones' => $ubicaciones
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
                'programa_id'  => 'required',
                'actGrupo'  => 'required',

                
            ],
            [
                'periodo_id.required' => 'El campo Perído es obligatorio.',
                'programa_id.required' => 'El campo Programa es obligatorio.',
                'actGrupo.required'  => 'El campo Actividad es obligatorio.',                
            ]
        );

        if ($validator->fails()) {
            return redirect('actividades/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            try {

                $actividades = Actividades::findOrFail($id);

                $actividades->update([
                    'periodo_id' => $request->periodo_id,
                    'programa_id' => $request->programa_id,
                    'actGrupo' => $request->actGrupo,
                    'actDescripcion' => $request->actDescripcion,
                    'empleado_id' => $request->empleado_id,
                    'actImporte' => $request->actImporte,
                    'actNumeroPagos' => $request->actNumeroPagos,
                    'actEstado' => "A",
                    'actCupo' => $request->actCupo,
                    'actTotal' => NULL,
                    'actInscritos' => NULL,
                    'actPreinscritos' => NULL,
                    'actBajas' => NULL,
                    'actOtros' => NULL
                ]);

                alert('Escuela Modelo', 'El seguimiento escolar se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('universidad.universidad_actividades.index');

            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('actividades/'.$id.'/edit')->withInput();
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
