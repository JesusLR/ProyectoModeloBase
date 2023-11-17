<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Auth;
use Validator;

use App\Http\Models\ServicioSocial;
use App\Http\Models\Alumno;
use App\Http\Models\Curso;
use App\Http\Models\Ubicacion;
use App\Http\Models\ResumenAcademico;
use App\Http\Helpers\Utils;
use App\clases\serviciosocial\MetodosServicioSocial as Servicios;
use App\clases\personas\MetodosPersonas as Personas;

use PDF;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class ServicioSocialController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('permisos:servicio_social',['except' => ['index','show','list']]);
        set_time_limit(8000000);
    }

    public function dateDMY($fecha){
        if($fecha){
        $f = Carbon::parse($fecha)->format('d/m/Y');
        return $f;
        }
    }//FIN function dateDMY
    public function dateYMD($fecha){
        $f = null;
        if($fecha){
            $f = Carbon::parse($fecha)->format('Y-m-d');
        }
        return $f;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('serviciosocial.show-list');
    }

    /*
    * Show ServicioSocial list..
    */

    public function list() {
        /*
        $servicios = new Collection;
        ServicioSocial::with('alumno.persona')->latest('ssFechaInicio')
        ->chunk(100, static function($registros) use ($servicios) {

            if($registros->isEmpty()) return false;

            $cursos = Curso::with(['periodo.departamento.ubicacion', 'cgt'])
            ->whereIn('alumno_id', $registros->pluck('alumno_id'))
            ->whereHas('periodo', static function($query) use ($registros) {
                $query->whereIn('perAnio', $registros->pluck('ssAnioPeriodoInicio'))
                      ->whereIn('perNumero', $registros->pluck('ssNumeroPeriodoInicio'));
            })
            ->oldest('curFechaRegistro')->get()->keyBy('alumno_id');

            $registros->each(static function($servicio) use ($servicios, $cursos) {
                $alumno = $servicio->alumno;
                $curso = $cursos->get($alumno->id);
                $ubicacion = $curso ? $curso->periodo->departamento->ubicacion : null;
                $cgt =  $curso ? $curso->cgt : null;

                $servicios->push([
                    'servicio_id' => $servicio->id,
                    'aluClave' => $alumno->aluClave,
                    'nombreCompleto' => Personas::nombreCompleto($alumno->persona, true),
                    'progClave' => $servicio->progClave,
                    'ssLugar' => $servicio->ssLugar,
                    'ssFechaInicio' => $servicio->ssFechaInicio,
                    'ssTelefono' => $servicio->ssTelefono,
                    'ssNumeroPeriodoInicio' => $servicio->ssNumeroPeriodoInicio,
                    'ssAnioPeriodoInicio' => $servicio->ssAnioPeriodoInicio,
                    'ssEstadoActual' => $servicio->ssEstadoActual,
                    'ubiClave' => $ubicacion ? $ubicacion->ubiClave : '',
                    'grado' =>  $cgt ? $cgt->cgtGradoSemestre : '',
                    // 'grupo' =>  $cgt ? $cgt->cgtGrupo : '',
                ]);
            });
        });

        return DataTables::of($servicios)
        ->addColumn('action', static function($servicio) {
            return '<div class="row">
                        <div class="col s1">
                        <a href="serviciosocial/'.$servicio['servicio_id'].'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                        </a>
                        </div>
                        <div class="col s1">
                        <a href="serviciosocial/'.$servicio['servicio_id'].'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        </div>
                    </div>';
        })->toJson();
        */
        $servicios_array =  DB::select("call procServicioSocial()");
        $servicios = collect( $servicios_array );

        return DataTables::of($servicios)
        ->addColumn('action', static function($servicio) {
            return '<div class="row">
                        <div class="col s1">
                        <a href="serviciosocial/'.$servicio->servicio_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                        </a>
                        </div>
                        <div class="col s1">
                        <a href="serviciosocial/'.$servicio->servicio_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        </div>
                    </div>';
        })->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('serviciosocial.create', [
            'anioActual' => Carbon::now('America/Merida')->year,
            'clasificacion' => Servicios::clasificaciones(),
            'estadoActual' => Servicios::estados(),
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
        $fechaActual = Carbon::now('CDT')->format('d/m/Y');
        $messages = [
            'date_format' => 'El formato de fecha debe ser día/mes/año, \n
                              ejemplo: '.$fechaActual.'. \n
                              Revisar el campo :attribute'
        ];
        $validator = Validator::make($request->all(),[
            'aluClave' => 'nullable',
            // 'progClave' => 'required',
            'ssLugar' => 'required',
            'ssClasificacion' => 'required',
            'ssFechaInicio' => 'required',
            'ssNumeroPeriodoInicio' => 'required',
            'ssAnioPeriodoInicio' => 'required',
            'ssEstadoActual' => 'required',
            'ssFechaLiberacion' => 'nullable',
            'ssFechaReporte1' => 'nullable',
            'ssFechaReporte2' => 'nullable',
            'ssFechaReporte3' => 'nullable',
            'ssFechaReporte4' => 'nullable',
            // 'alcance_regional' => 'required',
        ],$messages);


        
        if($validator->fails()){
            return redirect('serviciosocial/create')->withErrors($validator)
                ->withInput();
        }

        /*
        * Verificar que el alumno existe(aluClave).
        */
        // $alumno = Alumno::with("persona")->where('id','=',$request->alumno_id)->first();
        $resumen = ResumenAcademico::with(['alumno.persona', 'plan.programa'])->findOrFail($request->resumen_id);
        $alumno = $resumen->alumno;

        if (!$alumno) {
            alert()->error('Ups.. No existe alumno con la clave '.$request->aluClave.'.
                \n Favor de verificar los datos ingresados!');
            return back()->withInput();
        }

        /*
        * Veificar que el alumno no tenga servicio social 'Activo'.
        */
        $estaEnServ = ServicioSocial::where('alumno_id','=',$alumno->id)
            ->where('ssEstadoActual','=','A')->first();
        if($estaEnServ){
            alert()->error('Ups.. El Alumno con la clave '.$request->aluClave.
                ' tiene registrado un Servicio Social 
                con estado Activo.');
            return back()->withInput();
        }

        try{
            $serviciosocial = ServicioSocial::create([
                'alumno_id' => $alumno->id,
                'progClave' => $resumen->plan->programa->progClave,
                'ssLugar' => $request->input('ssLugar'),
                'ssDireccion' => $request->input('ssDireccion'),
                'ssTelefono' => $request->input('ssTelefono'),
                'ssJefeSuperior' => $request->input('ssJefeSuperior'),
                'ssHorarioLunes' => $request->input('ssHorarioLunes'),
                'ssHorarioMartes' => $request->input('ssHorarioMartes'),
                'ssHorarioMiercoles' => $request->input('ssHorarioMiercoles'),
                'ssHorarioJueves' => $request->input('ssHorarioJueves'),
                'ssHorarioViernes' => $request->input('ssHorarioViernes'),
                'ssHorarioSabado' => $request->input('ssHorarioSabado'),
                'ssHorarioDomingo' => $request->input('ssHorarioDomingo'),
                'ssClasificacion' => $request->get('ssClasificacion'),
                'ssFechaInicio' => $this->dateYMD($request->input('ssFechaInicio')),
                'ssNumeroPeriodoInicio' => $request->input('ssNumeroPeriodoInicio'),
                'ssAnioPeriodoInicio' => $request->input('ssAnioPeriodoInicio'),
                'ssNumeroAsignacion' => $request->input('ssNumeroAsignacion'),
                'ssFechaLiberacion' => $this->dateYMD($request->input('ssFechaLiberacion')),
                'ssNumeroPeriodoLiberacion' => $request->input('ssNumeroPeriodoLiberacion'),
                'ssAnioPeriodoLiberacion' => $request->input('ssAnioPeriodoLiberacion'),
                'ssEstadoActual' => $request->get('ssEstadoActual'),
                'ssFechaReporte1' => $this->dateYMD($request->input('ssFechaReporte1')),
                'ssFechaReporte2' => $this->dateYMD($request->input('ssFechaReporte2')),
                'ssFechaReporte3' => $this->dateYMD($request->input('ssFechaReporte3')),
                'ssFechaReporte4' => $this->dateYMD($request->input('ssFechaReporte4')),
                'alcance_regional' => null,
            ]);

        }catch(QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        alert('Universidad Modelo','El Servicio Social se ha creado con éxito',
            'success')->showConfirmButton();
        return redirect('serviciosocial');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('serviciosocial.show',[
            'serviciosocial' => ServicioSocial::findOrFail($id),
            'clasificacion' => Servicios::clasificaciones(),
            'estadoActual' => Servicios::estados(),
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
        return view('serviciosocial.edit', [
            'serviciosocial' => ServicioSocial::findOrFail($id),
            'anioActual' => Carbon::now('America/Merida')->year,
            'clasificacion' => Servicios::clasificaciones(),
            'estadoActual' => Servicios::estados(),
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
        
        $fechaActual = Carbon::now('CDT')->format('d/m/Y');

        $messages = [
            'date_format' => 'El formato de fecha debe ser día/mes/año, \n
                              ejemplo: '.$fechaActual.'. \n
                              Revisar el campo :attribute'
        ];
        $validator = Validator::make($request->all(),[
            'aluClave' => 'required',
            'progClave' => 'required',
            'ssLugar' => 'required',
            'ssClasificacion' => 'required',
            // 'ssFechaInicio' => 'required|date_format:d/m/Y',
            'ssNumeroPeriodoInicio' => 'required',
            'ssAnioPeriodoInicio' => 'required',
            'ssEstadoActual' => 'required',
            'ssFechaLiberacion' => 'nullable',
            'ssFechaReporte1' => 'nullable',
            'ssFechaReporte2' => 'nullable',
            'ssFechaReporte3' => 'nullable',
            'ssFechaReporte4' => 'nullable',
            // 'alcance_regional' => 'required',
        ],$messages);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        /*
        * La clave del alumno no se debe cambiar durante una actualización.
        * -> Se busca el servicio social.
        * -> Se verifica que la aluClave sea la misma.
        */
        $serv = ServicioSocial::find($id);
        if($serv->alumno->aluClave != $request->aluClave){
            alert()->error('Ups.. La clave del alumno no se puede cambiar...');
            return back()->withInput();
        }

        try{
            $servsocial = ServicioSocial::findOrFail($id);
            $servsocial->progClave = $request->progClave;
            $servsocial->ssLugar = $request->ssLugar;
            $servsocial->ssDireccion = Utils::validaEmpty($request->ssDireccion);
            $servsocial->ssTelefono = Utils::validaEmpty($request->ssTelefono);
            $servsocial->ssJefeSuperior = Utils::validaEmpty($request->ssJefeSuperior);
            $servsocial->ssHorarioLunes = Utils::validaEmpty($request->ssHorarioLunes);
            $servsocial->ssHorarioMartes = Utils::validaEmpty($request->ssHorarioMartes);
            $servsocial->ssHorarioMiercoles = Utils::validaEmpty($request->ssHorarioMiercoles);
            $servsocial->ssHorarioJueves = Utils::validaEmpty($request->ssHorarioJueves);
            $servsocial->ssHorarioViernes = Utils::validaEmpty($request->ssHorarioViernes);
            $servsocial->ssHorarioSabado = Utils::validaEmpty($request->ssHorarioSabado);
            $servsocial->ssHorarioDomingo = Utils::validaEmpty($request->ssHorarioDomingo);
            $servsocial->ssClasificacion = $request->ssClasificacion;
            $servsocial->ssFechaInicio = $this->dateYMD($request->ssFechaInicio);
            $servsocial->ssNumeroPeriodoInicio = $request->ssNumeroPeriodoInicio;
            $servsocial->ssAnioPeriodoInicio = $request->ssAnioPeriodoInicio;
            $servsocial->ssNumeroAsignacion = Utils::validaEmpty($request->ssNumeroAsignacion);
            $servsocial->ssFechaLiberacion = $this->dateYMD($request->ssFechaLiberacion);
            $servsocial->ssNumeroPeriodoLiberacion = $request->ssNumeroPeriodoLiberacion;
            $servsocial->ssAnioPeriodoLiberacion = $request->ssAnioPeriodoLiberacion;
            $servsocial->ssEstadoActual = $request->ssEstadoActual;
            $servsocial->ssFechaReporte1 = $this->dateYMD($request->ssFechaReporte1);
            $servsocial->ssFechaReporte2 = $this->dateYMD($request->ssFechaReporte2);
            $servsocial->ssFechaReporte3 = $this->dateYMD($request->ssFechaReporte3);
            $servsocial->ssFechaReporte4 = $this->dateYMD($request->ssFechaReporte4);
            $servsocial->alcance_regional = null;
            $servsocial->save();
        }catch(QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...'.$errorCode,$errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        alert('Universidad Modelo','El Servicio Social se ha actualizado con
            éxito','success')->showConfirmButton();
        return redirect('serviciosocial');
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
        $servsocial = ServicioSocial::findOrFail($id);
        try{
            if($servsocial->delete()){
                alert('Universidad Modelo','El Servicio Social se ha eliminado
                    con éxito','success');
            }else{
                alert()
                ->error('Error...','No se puede eliminar el Servicio Social')
                ->showConfirmButton();
            }
        }catch(QueryException $e){
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()
            ->error('Ups...'.$errorCode,$errorMessage)
            ->showConfirmButton();
        }
        return redirect('serviciosocial');
    }


    /**
    * imprime la información mostrada en la vista de detalle del CRUD
    */
    public function imprimir_detalles(Request $request)
    {
        $fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = 'imprimir_detalles_serviciosocial';
        return PDF::loadView('serviciosocial.pdf.'. $nombreArchivo, [
            "servicio" => ServicioSocial::findOrFail($request->serviciosocial_id),
            "info" => $request,
            "fechaActual" => $fechaActual->format('d/m/Y'),
            "horaActual" => $fechaActual->format('H:i:s'),
            "nombreArchivo" => $nombreArchivo,
        ])->stream($nombreArchivo.'.pdf');
    }

    public function filtrar_alumnos(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);

        $resumenes = ResumenAcademico::select('resumenacademico.id AS resumen_id', 'alumnos.id AS alumno_id', 'alumnos.aluClave',
            DB::raw("CONCAT_WS(' ', personas.perApellido1, personas.perApellido2, personas.perNombre) AS nombreCompleto"),
            'planes.planClave', 'programas.progClave', 'periodos.perNumero', 'periodos.perAnio',
            'ubicacion.ubiClave', 'departamentos.depClave'
        )
        ->join('alumnos', 'alumnos.id', 'resumenacademico.alumno_id')
        ->join('personas', 'personas.id', 'alumnos.persona_id')
        ->join('planes', 'planes.id', 'resumenacademico.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('periodos', 'periodos.id', 'resumenacademico.resPeriodoIngreso')
        ->join('departamentos', 'departamentos.id', 'periodos.departamento_id')
        ->join('ubicacion', 'ubicacion.id', 'departamentos.ubicacion_id')
        ->whereIn('depClave', ['SUP', 'POS'])
        ->whereHas('alumno.persona', static function($query) use ($request) {
            $query->where('aluEstado', '!=', 'B')
                ->whereIn('aluEstado', ['E','R', 'N'])
                ->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$request->nombreAlumno}%"]);
            if ($request->aluClave)
                $query->where('aluClave', '=', $request->aluClave);
        })->get();
        
        return response()->json($resumenes);
    }
}
