<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_evidencias;
use App\Http\Models\Bachiller\Bachiller_inscritos_evidencias;
use App\Http\Models\Bachiller\Bachiller_materias;
use App\Http\Models\Departamento;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerEvidenciasController extends Controller
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
        return view('bachiller.evidencias.show-list');
    }

    public function list()
    {
        $bachiller_evidencias = Bachiller_evidencias::select(
            'bachiller_evidencias.id',
            'bachiller_evidencias.periodo_id',
            'bachiller_evidencias.bachiller_materia_id',
            'bachiller_evidencias.eviNumero',
            'bachiller_evidencias.eviDescripcion',
            'bachiller_evidencias.eviFechaEntrega',
            'bachiller_evidencias.eviPuntos',
            'bachiller_evidencias.eviTipo',
            'bachiller_evidencias.eviFaltas',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'bachiller_materias.matNombre',
            'bachiller_materias.matClave',
            'bachiller_materias.matSemestre',
            'planes.planClave',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'programas.progClave',
            'bachiller_materias_acd.gpoMatComplementaria'
        )
            ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('periodos', 'bachiller_evidencias.periodo_id', '=', 'periodos.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_evidencias.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->orderBy('bachiller_materias.matSemestre', 'ASC')
            ->orderBy('bachiller_materias.matClave', 'ASC')
            ->orderBy('bachiller_materias_acd.gpoMatComplementaria', 'ASC')
            ->orderBy('bachiller_evidencias.eviNumero', 'ASC');


        return DataTables::of($bachiller_evidencias)
            ->filterColumn('numero_periodo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('numero_periodo', function ($query) {
                return $query->perNumero;
            })

            ->filterColumn('anio_periodo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('anio_periodo', function ($query) {
                return $query->perAnio;
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

            ->filterColumn('grado_materia', function ($query, $keyword) {
                $query->whereRaw("CONCAT(matSemestre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('grado_materia', function ($query) {
                return $query->matSemestre;
            })

            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiClave;
            })

            ->filterColumn('departamento', function ($query, $keyword) {
                $query->whereRaw("CONCAT(depClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('departamento', function ($query) {
                return $query->depClave;
            })

            ->filterColumn('escuela', function ($query, $keyword) {
                $query->whereRaw("CONCAT(escClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('escuela', function ($query) {
                return $query->escClave;
            })

            ->filterColumn('programa_', function ($query, $keyword) {
                $query->whereRaw("CONCAT(progClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('programa_', function ($query) {
                return $query->progClave;
            })

            ->filterColumn('plan', function ($query, $keyword) {
                $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('plan', function ($query) {
                return $query->planClave;
            })

            ->filterColumn('materia_acd', function ($query, $keyword) {
                $query->whereRaw("CONCAT(gpoMatComplementaria) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('materia_acd', function ($query) {
                return $query->gpoMatComplementaria;
            })

            ->filterColumn('fecha_entrega', function ($query, $keyword) {
                $query->whereRaw("CONCAT(eviFechaEntrega) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('fecha_entrega', function ($query) {
                return Utils::fecha_string($query->eviFechaEntrega, $query->eviFechaEntrega);
            })


            ->addColumn('action', function ($query) {

                $btnEditar = "";
                $btnEliminar = "";

                $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;
                $sistemas = Auth::user()->departamento_sistemas;

                if ($ubicacion == $query->ubiClave || $sistemas == 1) {
                    $btnEditar = '<a href="/bachiller_evidencias/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';

                    $btnEliminar = '<form id="delete_' . $query->id . '" action="bachiller_evidencias/' . $query->id . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';
                }

                return '<a href="/bachiller_evidencias/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                    . $btnEditar
                    . $btnEliminar;
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
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();


        return view('bachiller.evidencias.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function copiar()
    {
        // Mostrar el conmbo solo las ubicaciones correspondientes 
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();


        return view('bachiller.evidencias.copiar', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function getMateriasACD(Request $request, $periodo_id, $plan_id, $bachiller_materia_id)
    {
        if ($request->ajax()) {

            $bachiller_materias_acd = DB::select("SELECT acd.* FROM bachiller_materias_acd acd
            INNER JOIN bachiller_materias bm ON (bm.id = acd.bachiller_materia_id)
            AND acd.deleted_at IS NULL
            WHERE bm.deleted_at IS NULL
            AND acd.periodo_id=$periodo_id
            AND acd.plan_id=$plan_id
            AND bachiller_materia_id=$bachiller_materia_id");

            return response()->json($bachiller_materias_acd);
        }
    }

    public function getMateriasACDDestino(Request $request, $periodo_id, $plan_id, $bachiller_materia_id, $materia_acd_id)
    {
        if ($request->ajax()) {

            $bachiller_materias_acd = DB::select("SELECT acd.* FROM bachiller_materias_acd acd
            INNER JOIN bachiller_materias bm ON (bm.id = acd.bachiller_materia_id)
            AND acd.deleted_at IS NULL
            WHERE bm.deleted_at IS NULL
            AND acd.periodo_id=$periodo_id
            AND acd.plan_id=$plan_id
            AND bachiller_materia_id=$bachiller_materia_id
            AND acd.id <> $materia_acd_id");

            return response()->json($bachiller_materias_acd);
        }
    }
    public function getMateriasEvidencias(Request $request, $plan_id, $programa_id, $matSemestre)
    {
        if ($request->ajax()) {
            $Materia = Bachiller_materias::select('bachiller_materias.*')
                ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->where('bachiller_materias.plan_id', $plan_id)
                ->where('programas.id', $programa_id)
                ->where('bachiller_materias.matSemestre', $matSemestre)
                ->get();

            return response()->json($Materia);
        }
    }

    public function getMateriasEvidenciasPeriodo(Request $request, $periodo_id, $bachiller_materia_id, $matSemestre)
    {
        if ($request->ajax()) {

            $Materia = Bachiller_evidencias::where('bachiller_evidencias.periodo_id', $periodo_id)
                ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->where('bachiller_evidencias.bachiller_materia_id', $bachiller_materia_id)
                ->where('bachiller_materias.matSemestre', $matSemestre)
                ->get();

            return response()->json($Materia);
        }
    }

    public function getMateriasEvidenciasPeriodoACD(Request $request, $periodo_id, $bachiller_materia_id, $matSemestre, $bachiller_materia_acd_id)
    {
        if ($request->ajax()) {

            $Materia = Bachiller_evidencias::where('bachiller_evidencias.periodo_id', $periodo_id)
                ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->where('bachiller_evidencias.bachiller_materia_id', $bachiller_materia_id)
                ->where('bachiller_materias.matSemestre', $matSemestre)
                ->where('bachiller_evidencias.bachiller_materia_acd_id', $bachiller_materia_acd_id)
                ->get();

            return response()->json($Materia);
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

        DB::beginTransaction();
        try {

            $materias = $request->materiasEvidencias;
            $materia_primer_id = explode('~', $materias[0]);
            $bachiller_materia_id = $materia_primer_id[1];

            foreach ($materias as $key => $materia) {
                $materia = explode('~', $materia);

                if ($materia[11] == "NULL") {
                    $nuevoValorACD = NULL;
                } else {
                    $nuevoValorACD = $materia[11];
                }
                Bachiller_evidencias::create([
                    'periodo_id'                => $materia[0],
                    'bachiller_materia_id'      => $materia[1],
                    'bachiller_materia_acd_id'  => $nuevoValorACD,
                    'eviNumero'                 => $materia[4],
                    'eviDescripcion'            => $materia[5],
                    'eviFechaEntrega'           => \Carbon\Carbon::parse($materia[6])->format('Y-m-d'),
                    'eviPuntos'                 => $materia[7],
                    'eviTipo'                   => $materia[8],
                    'eviFaltas'                 => $materia[9]
                ]);
            }


            $dep_cme = Departamento::find(7);
            $dep_cva = Departamento::find(17);
            DB::select("call procBachillerEvidenciasAcumuladoPorMateriaPeriodo(" . $dep_cme->perActual . ", " . $dep_cva->perActual . ", " . $bachiller_materia_id . ")");
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La(s) evidencias materias se ha creado con éxito', 'success')->showConfirmButton()->autoClose(5000);
        return redirect()->back();
    }

    public function storeCopiar(Request $request)
    {


        $perNumero = $request->perNumero;
        $perAnio = $request->perAnio;
        $ubicacion_id = $request->ubicacion_id;
        $semestre = 0;
        $periodo_id = $request->periodo_id;
        $usuario_at = auth()->user()->id;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;

        $periodo = Periodo::find($periodo_id);

        DB::beginTransaction();
        try {

            if($perNumero != $periodo->perNumero){
                alert('Escuela Modelo', 'El número de periodo que desea copiar es diferente al número del período actual', 'warning')->showConfirmButton()->autoClose(5000);
                return redirect()->back()->withInput();
            }

            if($perAnio >= $periodo->perAnio){
                alert('Escuela Modelo', 'El año del periodo que desea copiar es mayor al año del período actual', 'warning')->showConfirmButton()->autoClose(5000);
                return redirect()->back()->withInput();
            }

            $procBachillerCopiarEvidencia = DB::select("call procBachillerCopiarEvidencia(" . $perNumero . ", " . $perAnio . ", " . $ubicacion_id . ", " . $semestre . ", " . $periodo_id . ", " . $usuario_at . ", " . $programa_id . ", " . $plan_id . ")");

            // $procBachillerCopiarEvidenciaACD = DB::select("call procBachillerCopiarEvidenciaACD(" . $perNumero . ", " . $perAnio . ", " . $ubicacion_id . ", " . $semestre . ", " . $periodo_id . ", " . $usuario_at . ", " . $programa_id . ", " . $plan_id . ")");
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La(s) evidencias materias se han copiado con éxito', 'success')->showConfirmButton()->autoClose(5000);
        return redirect()->back();
    }

    public function storeCopiarSemestre(Request $request)
    {


        $perNumero = $request->perNumero;
        $perAnio = $request->perAnio;
        $ubicacion_id = $request->ubicacion_id;
        $semestre = 0;
        $periodo_id = $request->periodo_id;
        $usuario_at = auth()->user()->id;
        $programa_id = $request->programa_id;
        $plan_id = $request->plan_id;
        $materia_id = $request->materia_id;
        $materia_acd_id = $request->materia_acd_id;
        $materia_acd_id_destino = $request->materia_acd_id_destino;

        

        DB::beginTransaction();
        try {

            // if($materia_acd_id != ""){

            //     $bachiller_evidencias = Bachiller_evidencias::where('periodo_id', $periodo_id)
            //     ->where('bachiller_materia_id', $materia_id)
            //     ->where('bachiller_materia_acd_id', $materia_acd_id)
            //     ->whereNull('deleted_at')
            //     ->orderBy('eviNumero', 'ASC')
            //     ->get();


            //     if(count($bachiller_evidencias) > 0){

            //         foreach($bachiller_evidencias as $evidencia){

            //             $buscarEvidencia = Bachiller_evidencias::where('periodo_id', $periodo_id)
            //             ->where('bachiller_materia_id', $materia_id)
            //             ->where('bachiller_materia_acd_id', $materia_acd_id_destino)
            //             ->where('eviNumero', $evidencia->eviNumero)
            //             ->whereNull('deleted_at')
            //             ->first();

            //             if($buscarEvidencia == ""){

            //                 $creamosEvidencia = Bachiller_evidencias::create([
            //                     'periodo_id' => $periodo_id,
            //                     'bachiller_materia_id' => $materia_id,
            //                     'bachiller_materia_acd_id' => $materia_acd_id_destino,
            //                     'eviNumero' => $evidencia->eviNumero,
            //                     'eviDescripcion'  => $evidencia->eviDescripcion,
            //                     'eviFechaEntrega'  => $evidencia->eviFechaEntrega,
            //                     'eviPuntos'  => $evidencia->eviPuntos,
            //                     'eviTipo'  => $evidencia->eviTipo,
            //                     'eviFaltas'  => $evidencia->eviFaltas,
            //                     'usuario_at' => auth()->user()->id
            //                 ]);

            //             }

                        
            //         }                   

            //     }else{

            //         alert('Escuela Modelo', 'La materia asignatura origen seleccionada no tiene evidencias (ADAS) capturadas', 'info')->showConfirmButton()->autoClose(5000);
            //         return redirect()->back()->withInput();
            //     }

            // }

            if($materia_acd_id_destino != ""){

                if($materia_acd_id != ""){
    
                    $bachiller_evidencias = Bachiller_evidencias::where('periodo_id', $periodo_id)
                    ->where('bachiller_materia_id', $materia_id)
                    ->where('bachiller_materia_acd_id', $materia_acd_id)
                    ->whereNull('deleted_at')
                    ->orderBy('eviNumero', 'ASC')
                    ->get();
    
                    if(count($bachiller_evidencias) > 0){
    
                        foreach($bachiller_evidencias as $evidencia){
    
                            for($i = 0; $i < count($materia_acd_id_destino); $i++){               
    
                                $buscarEvidencia = Bachiller_evidencias::where('periodo_id', $periodo_id)
                                ->where('bachiller_materia_id', $materia_id)
                                ->where('bachiller_materia_acd_id', $materia_acd_id_destino[$i])
                                ->where('eviNumero', $evidencia->eviNumero)
                                ->whereNull('deleted_at')
                                ->first();
    
    
                                if($buscarEvidencia == ""){
    
                                    $creamosEvidencia = Bachiller_evidencias::create([
                                        'periodo_id' => $periodo_id,
                                        'bachiller_materia_id' => $materia_id,
                                        'bachiller_materia_acd_id' => $materia_acd_id_destino[$i],
                                        'eviNumero' => $evidencia->eviNumero,
                                        'eviDescripcion'  => $evidencia->eviDescripcion,
                                        'eviFechaEntrega'  => $evidencia->eviFechaEntrega,
                                        'eviPuntos'  => $evidencia->eviPuntos,
                                        'eviTipo'  => $evidencia->eviTipo,
                                        'eviFaltas'  => $evidencia->eviFaltas,
                                        'usuario_at' => auth()->user()->id
                                    ]);
        
                                }
    
                            }
    
                        }                   
    
                    }else{
    
                        alert('Escuela Modelo', 'La materia asignatura origen seleccionada no tiene evidencias (ADAS) capturadas', 'info')->showConfirmButton()->autoClose(5000);
                        return back();
                    }
    
                }
    
                
            }else{
                alert('Escuela Modelo', 'No se ha seleccionado materias asignaturas destino', 'info')->showConfirmButton()->autoClose(5000);
                return back();
            }


            // $procBachillerCopiarEvidencia = DB::select("call procBachillerCopiarEvidencia(" . $perNumero . ", " . $perAnio . ", " . $ubicacion_id . ", " . $semestre . ", " . $periodo_id . ", " . $usuario_at . ", " . $programa_id . ", " . $plan_id . ")");

            // $procBachillerCopiarEvidenciaACD = DB::select("call procBachillerCopiarEvidenciaACD(" . $perNumero . ", " . $perAnio . ", " . $ubicacion_id . ", " . $semestre . ", " . $periodo_id . ", " . $usuario_at . ", " . $programa_id . ", " . $plan_id . ")");
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
        DB::commit();
        alert('Escuela Modelo', 'La(s) evidencias (ADAS) del grupo origen seleccionado se han copiado con éxito', 'success')->showConfirmButton()->autoClose(5000);
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bachiller_evidencias = Bachiller_evidencias::select(
            'bachiller_evidencias.id',
            'bachiller_evidencias.periodo_id',
            'bachiller_evidencias.bachiller_materia_id',
            'bachiller_evidencias.eviNumero',
            'bachiller_evidencias.eviDescripcion',
            'bachiller_evidencias.eviFechaEntrega',
            'bachiller_evidencias.eviPuntos',
            'bachiller_evidencias.eviTipo',
            'bachiller_evidencias.eviFaltas',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'bachiller_materias.matNombre',
            'bachiller_materias.matClave',
            'planes.id as plan_id',
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
            'programas.progNombre',
            'bachiller_materias_acd.gpoMatComplementaria'
        )
            ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('periodos', 'bachiller_evidencias.periodo_id', '=', 'periodos.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_evidencias.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->where('bachiller_evidencias.id', $id)
            ->first();

        return view('bachiller.evidencias.show', [
            "bachiller_evidencias" => $bachiller_evidencias
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
        $bachiller_evidencias = Bachiller_evidencias::select(
            'bachiller_evidencias.id',
            'bachiller_evidencias.periodo_id',
            'bachiller_evidencias.bachiller_materia_id',
            'bachiller_evidencias.bachiller_materia_acd_id',
            'bachiller_evidencias.eviNumero',
            'bachiller_evidencias.eviDescripcion',
            'bachiller_evidencias.eviFechaEntrega',
            'bachiller_evidencias.eviPuntos',
            'bachiller_evidencias.eviTipo',
            'bachiller_evidencias.eviFaltas',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'bachiller_materias.matNombre',
            'bachiller_materias.matClave',
            'bachiller_materias.matSemestre',
            'planes.id as plan_id',
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
            'programas.progNombre',
            'bachiller_materias_acd.gpoMatComplementaria'
        )
            ->join('bachiller_materias', 'bachiller_evidencias.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->join('periodos', 'bachiller_evidencias.periodo_id', '=', 'periodos.id')
            ->join('planes', 'bachiller_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->leftJoin('bachiller_materias_acd', 'bachiller_evidencias.bachiller_materia_acd_id', '=', 'bachiller_materias_acd.id')
            ->where('bachiller_evidencias.id', $id)
            ->first();

        return view('bachiller.evidencias.edit', [
            "bachiller_evidencias" => $bachiller_evidencias
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
                'eviNumero'  => 'required',
                'eviDescripcion'  => 'required',
                'eviFechaEntrega'  => 'required',
                'eviTipo'  => 'required',
                'eviFaltas'  => 'required'
            ],
            [
                'eviNumero.required' => 'El campo Número evidencia es obligatorio.',
                'eviDescripcion.required' => 'El campo Descripción evidencia es obligatorio.',
                'eviFechaEntrega.required' => 'El campo Fecha entrega es obligatorio.',
                'eviPuntos.required' => 'El campo Puntos evidencia es obligatorio.',
                'eviTipo.required' => 'El campo Tipo evidencia es obligatorio.',
                'eviFaltas.required' => 'El campo Faltas evidencia es obligatorio.'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            try {


                // validamos si los puntajes no revasan a 100 
                $suma = 0;
                $Bachiller_evidencias_contar = "";

                if ($request->materia_acd_id != "null") {
                    $Bachiller_evidencias_contar = Bachiller_evidencias::where("bachiller_materia_id", "=", $request->materia_id)
                        ->where("bachiller_materia_acd_id", "=", $request->materia_acd_id)
                        ->where("periodo_id", "=", $request->periodo_id)
                        ->get();
                } else {
                    $Bachiller_evidencias_contar = Bachiller_evidencias::where("bachiller_materia_id", "=", $request->materia_id)
                        ->where("periodo_id", "=", $request->periodo_id)
                        ->get();
                }

                if (count($Bachiller_evidencias_contar) > 0) {
                    foreach ($Bachiller_evidencias_contar as $values) {
                        if ($id != $values->id) {
                            $suma = $suma + $values->eviPuntos;
                        }
                    }
                    $suma2 = $request->eviPuntos + $suma;
                    if ($suma2 > 100) {
                        alert()->error('Ups... Total de puntos con la información agregada actualmente "' . $suma2 . '"', "La suma de los puntos no puede ser mayor a 100")->showConfirmButton()->autoClose(6000);
                        return back()->withInput();
                    }
                }

                $fechaActual = Carbon::now('America/Merida');
                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_ALL, 'es_MX', 'es', 'ES');
                $fechaHoy = $fechaActual->format('Y-m-d H:i:s');


                // Si los puntajes no revasan a 100 se puede actualizar 
                $bachiller_evidencias = Bachiller_evidencias::findOrFail($id);

                $bachiller_evidencias->update([
                    'bachiller_materia_acd_id' => $request->materia_acd_id,
                    'eviNumero'       => $request->eviNumero,
                    'eviDescripcion'  => $request->eviDescripcion,
                    'eviFechaEntrega' => $request->eviFechaEntrega,
                    'eviPuntos'       => $request->eviPuntos,
                    'eviTipo'         => $request->eviTipo,
                    'eviFaltas'       => $request->eviFaltas,
                    'updated_at'      => $fechaHoy
                ]);


                $dep_cme = Departamento::find(7);
                $dep_cva = Departamento::find(17);
                DB::select("call procBachillerEvidenciasAcumuladoPorMateriaPeriodo(" . $dep_cme->perActual . ", " . $dep_cva->perActual . ", " . $request->materia_id . ")");

                alert('Escuela Modelo', 'La evidencia materia actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect('bachiller_evidencias');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('bachiller_evidencias/' . $id . '/edit')->withInput();
            }
        }
    }

    public function copiarEvidenciasSemestre()
    {
        // Mostrar el conmbo solo las ubicaciones correspondientes 
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();


        return view('bachiller.evidencias.copiarSemestre', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bachiller_evidencias = Bachiller_evidencias::findOrFail($id);

        $bachiller_inscritos_evidencias = Bachiller_inscritos_evidencias::where('evidencia_id', $id)->whereNotNull('ievPuntos')->get();

        if (count($bachiller_inscritos_evidencias) > 0) {
            alert()->warning('Error...', 'No se puedo eliminar la evidencia materia debido que ya se han calificado algunos alumnos')->showConfirmButton();
            return redirect()->back();
        } else {
            try {

                if ($bachiller_evidencias->delete()) {

                    alert('Escuela Modelo', 'La evidencia materia se ha eliminado con éxito', 'success')->showConfirmButton();

                    $dep_cme = Departamento::find(7);
                    $dep_cva = Departamento::find(17);
                    DB::select("call procBachillerEvidenciasAcumuladoPorMateriaPeriodo(" . $dep_cme->perActual . ", " . $dep_cva->perActual . ", " . $bachiller_evidencias->bachiller_materia_id . ")");
                } else {

                    alert()->error('Error...', 'No se puedo eliminar la evidencia materia')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            }

            return redirect()->back();
        }
    }
}