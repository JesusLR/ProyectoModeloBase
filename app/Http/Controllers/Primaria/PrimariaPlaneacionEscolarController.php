<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Escuela;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;
use App\Http\Models\Primaria\Primaria_empleado;
use App\Http\Models\Primaria\Primaria_grupo;
use App\Http\Models\Primaria\Primaria_grupos_planeaciones;
use App\Http\Models\Primaria\Primaria_grupos_planeaciones_temas;
use App\Http\Models\Primaria\Primaria_materia;
use App\Http\Models\Programa;
use App\Http\Models\Ubicacion;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PDF;
use Validator;

class PrimariaPlaneacionEscolarController extends Controller
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
        return view('primaria.planeacion_docente.show-list');
    }

    public function list()
    {
        $departamentoCME = Departamento::with('ubicacion')->findOrFail(14);
        $perActualCME = $departamentoCME->perActual;

        $departamentoCVA = Departamento::with('ubicacion')->findOrFail(26);
        $perActualCVA = $departamentoCVA->perActual;

        $ubicacion_clave = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;

        $usuario_sistema =  auth()->user()->departamento_sistemas;

        if (Auth::user()->primaria == 1) {
            $primaria_grupos_planeaciones = Primaria_grupos_planeaciones::select(
                'primaria_grupos_planeaciones.id',
                'primaria_grupos_planeaciones.semana_inicio',
                'primaria_grupos_planeaciones.semana_fin',
                'ubicacion.ubiNombre',
                'periodos.perAnioPago',
                'planes.planClave',
                'programas.progNombre',
                'primaria_materias.matClave',
                'primaria_materias.matNombre',
                'primaria_empleados.empNombre',
                'primaria_empleados.empApellido1',
                'primaria_empleados.empApellido2',
                'primaria_grupos.gpoGrado',
                'primaria_grupos.gpoClave'
            )
            ->join('primaria_grupos', 'primaria_grupos_planeaciones.primaria_grupo_id', '=', 'primaria_grupos.id')
            ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
            ->join('planes', 'primaria_materias.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('primaria_empleados', 'primaria_grupos.empleado_id_docente', '=', 'primaria_empleados.id')
            ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
            ->where('departamentos.depClave', 'PRI')
            ->where(static function ($query) use ($usuario_sistema, $perActualCME, $perActualCVA, $ubicacion_clave) {

                if ($usuario_sistema != 1) {
                    // $query->whereIn('periodos.id', [$perActualCME, $perActualCVA]);
                    $query->where('ubicacion.ubiClave', $ubicacion_clave);
                }
    
            });

        }

        

        return DataTables::of($primaria_grupos_planeaciones)

        ->filterColumn('ubiNombre',function($query,$keyword){
            $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('ubiNombre',function($query){
            return $query->ubiNombre;
        })

        ->filterColumn('perAnioPago',function($query,$keyword){
            $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('perAnioPago',function($query){
            return $query->perAnioPago;
        })


        ->filterColumn('planClave',function($query,$keyword){
            $query->whereRaw("CONCAT(planClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('planClave',function($query){
            return $query->planClave;
        })

        ->filterColumn('progNombre',function($query,$keyword){
            $query->whereRaw("CONCAT(progNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('progNombre',function($query){
            return $query->progNombre;
        })

        ->filterColumn('matClave',function($query,$keyword){
            $query->whereRaw("CONCAT(matClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('matClave',function($query){
            return $query->matClave;
        })

        ->filterColumn('matNombre',function($query,$keyword){
            $query->whereRaw("CONCAT(matNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('matNombre',function($query){
            return $query->matNombre;
        })

        ->filterColumn('empNombre',function($query,$keyword){
            $query->whereRaw("CONCAT(empNombre) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('empNombre',function($query){
            return $query->empNombre;
        })


        ->filterColumn('empApellido1',function($query,$keyword){
            $query->whereRaw("CONCAT(empApellido1) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('empApellido1',function($query){
            return $query->empApellido1;
        })

        ->filterColumn('empApellido2',function($query,$keyword){
            $query->whereRaw("CONCAT(empApellido2) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('empApellido2',function($query){
            return $query->empApellido2;
        })

        ->filterColumn('gpoGrado',function($query,$keyword){
            $query->whereRaw("CONCAT(gpoGrado) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('gpoGrado',function($query){
            return $query->gpoGrado;
        })

        ->filterColumn('gpoClave',function($query,$keyword){
            $query->whereRaw("CONCAT(gpoClave) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('gpoClave',function($query){
            return $query->gpoClave;
        })

        ->filterColumn('semana_inicio',function($query,$keyword){
            $query->whereRaw("CONCAT(semana_inicio) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('semana_inicio',function($query){
            return $query->semana_inicio;
        })

        ->filterColumn('semana_fin',function($query,$keyword){
            $query->whereRaw("CONCAT(semana_fin) like ?", ["%{$keyword}%"]);
        })
        ->addColumn('semana_fin',function($query){
            return $query->semana_fin;
        })

        ->addColumn('action',function($query){
            return '<a href="primaria_planeacion_docente/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            <a href="primaria_planeacion_docente/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                <i class="material-icons">edit</i>
            </a>
            
            <a href="primaria_planeacion_docente/imprimir/' . $query->id . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Imprimir perfil" >
                <i class="material-icons">picture_as_pdf</i>
            </a>';
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
        return view('primaria.planeacion_docente.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function getGrupo(Request $request, $periodo_id, $programa_id, $plan_id, $grado)
    {

        if ($request->ajax()) {
            $grupos = Primaria_grupo::select(
                'primaria_grupos.id', 
                'primaria_grupos.gpoGrado', 
                'primaria_grupos.gpoClave',
                'primaria_grupos.gpoTurno',
                'primaria_materias.matClave',
                'primaria_materias.matNombre'
            )
            ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'primaria_grupos.plan_id', '=', 'planes.id')
            ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('periodos.id', '=', $periodo_id)
            ->where('programas.id', '=', $programa_id)
            ->where('planes.id', '=', $plan_id)
            ->where('primaria_grupos.gpoGrado', '=', $grado)
            ->orderBy('primaria_grupos.gpoClave', 'ASC')
            ->get();


            return response()->json($grupos);
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
        // dd($request->periodo_id,$request->programa_id, $request->plan_id);

        $validator = Validator::make(
            $request->all(),
            [
                'gpoGrado'  => 'required',
                'primaria_grupo_id' => 'required',
                'mes' => 'required',
                'frase_mes' => 'required',
                'valor_mes' => 'required',
                'norma_urbanidad' => 'required',
                'objetivo_general' => 'required',
                'objetivo_particular' => 'required',
                'bloque' => 'required',
                'notas_observaciones' => 'required',
                'semana_inicio' => 'required',
                'semana_fin' => 'required'             
            
            
            ],
            [
                'gpoGrado.required' => 'El campo Grado es obligatorio.',
                'primaria_grupo_id.required' => 'El campo Grupo es obligatorio.',
                'mes.required' => 'El campo Mes es obligatorio.',
                'frase_mes.required' => 'El campo Frase del mes es obligatorio.',
                'valor_mes.required' => 'El campo Valor del mes es obligatorio.',
                'norma_urbanidad.required' => 'El campo Norma de urbanidad es obligatorio.',
                'objetivo_general.required' => 'El campo Objetivo general es obligatorio.',
                'objetivo_particular.required' => 'El campo Objetivo particular es obligatorio.',
                'bloque.required' => 'El campo Bloque es obligatorio.',
                'notas_observaciones.required' => 'El campo Notas/Observaciones es obligatorio.',             
                'semana_inicio.required' => 'El campo Semama inicio es obligatorio.',              
                'notas_observaciones.required' => 'El campo Semana fin es obligatorio.'                


            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_planeacion_docente/create')->withErrors($validator)->withInput();
        } else {
            try {

                $mesInicio = \Carbon\Carbon::parse($request->semana_inicio)->format('m');

                /* --------------------------- Calcular Bimestres --------------------------- */
                // Calculo de bimestre 1 
                if($mesInicio == "09" || $mesInicio == "10"){
                    $bimestre = "Bimestre I";
                }
                // Calculo de bimestre 2
                if($mesInicio == "11" || $mesInicio == "12"){
                    $bimestre = "Bimestre II";
                }
                // Calculo de bimestre 3
                if($mesInicio == "01" || $mesInicio == "02"){
                    $bimestre = "Bimestre II";
                }
                // Calculo de bimestre 4
                if($mesInicio == "03" || $mesInicio == "04"){
                    $bimestre = "Bimestre IV";
                }
                // Calculo de bimestre 5
                if($mesInicio == "05" || $mesInicio == "06"){
                    $bimestre = "Bimestre V";
                }

                if($mesInicio == "07" || $mesInicio == "08"){
                    $bimestre = "";
                }

                /* --------------------------- Calcular Trimestres -------------------------- */
                // Trimestre 1 
                if($mesInicio == "09" || $mesInicio == "10" || $mesInicio == "11" || $mesInicio == "12"){
                    $trimestre = "Trimestre I";
                }
                // Trimestre 2 
                if($mesInicio == "01" || $mesInicio == "02" || $mesInicio == "03"){
                    $trimestre = "Trimestre II";
                }

                if($mesInicio == "04" || $mesInicio == "05" || $mesInicio == "06"){
                    $trimestre = "Trimestre III";
                }


                if($mesInicio == "07" || $mesInicio == "08"){
                    $trimestre = "";
                }



                $primaria_grupos_planeaciones = Primaria_grupos_planeaciones::create([
                    'primaria_grupo_id'         => $request->primaria_grupo_id,
                    'semana_inicio'             => $request->semana_inicio,
                    'semana_fin'                => $request->semana_fin,
                    'bimestre'                  => $bimestre,
                    'trimestre'                 => $trimestre,
                    'mes'                       => $request->mes,
                    'frase_mes'                 => $request->frase_mes,
                    'valor_mes'                 => $request->valor_mes,
                    'norma_urbanidad'           => $request->norma_urbanidad,
                    'objetivo_general'          => $request->objetivo_general,
                    'bloque'                    => $request->bloque,
                    'objetivo_particular'       => $request->objetivo_particular,
                    'notas_observaciones'       => $request->notas_observaciones
                ]);


                for ($i = 0; $i < count($request->tema); $i++) {
            
                    $primaria_grupos_planeaciones_temas = array();
                    $primaria_grupos_planeaciones_temas = new Primaria_grupos_planeaciones_temas();
                    $primaria_grupos_planeaciones_temas['primaria_grupos_planeaciones_id'] = $primaria_grupos_planeaciones->id;
                    $primaria_grupos_planeaciones_temas['tema'] = $request->tema[$i];
                    $primaria_grupos_planeaciones_temas['objetivo'] = $request->objetivo[$i];
                    $primaria_grupos_planeaciones_temas['estrategias'] = $request->estrategias[$i];
                    $primaria_grupos_planeaciones_temas['libros'] = $request->libro[$i];
                    $primaria_grupos_planeaciones_temas['habilidad'] = $request->habilidad[$i];
                    $primaria_grupos_planeaciones_temas['evaluacion'] = $request->evaluacion[$i];

                    $primaria_grupos_planeaciones_temas->save();
                }
      
                


                alert('Escuela Modelo', 'La planeacion docente se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('primaria.primaria_planeacion_docente.index');


            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('primaria_planeacion_docente/create')->withInput();
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
            $primaria_grupos_planeaciones = Primaria_grupos_planeaciones::findOrFail($id);
    
            $ubicaciones = Ubicacion::whereIn('id', [1])->get();
    
            $grupo = Primaria_grupo::where('id', $primaria_grupos_planeaciones->primaria_grupo_id)->first();
            $plan_grupo = Plan::where('id', $grupo->plan_id)->first();
            $programa_grupo = Programa::where('id', $plan_grupo->programa_id)->first();
            $periodo_grupo = Periodo::where('id', $grupo->periodo_id)->first();
            $departamento_grupo = Departamento::where('id', $periodo_grupo->departamento_id)->first();
            $escuela_grupo = Escuela::where('id', $programa_grupo->escuela_id)->first();
            $ubicacion_grupo = Ubicacion::where('id', $departamento_grupo->ubicacion_id)->first();
            $primaria_materia = Primaria_materia::where('id', $grupo->primaria_materia_id)->first();
    
            $primaria_grupos_planeaciones_temas = Primaria_grupos_planeaciones_temas::where('primaria_grupos_planeaciones_id', $primaria_grupos_planeaciones->id)->get();
    
    
            $grupos = Primaria_grupo::select(
                'primaria_grupos.id', 
                'primaria_grupos.gpoGrado', 
                'primaria_grupos.gpoClave',
                'primaria_grupos.gpoTurno',
                'primaria_materias.matClave',
                'primaria_materias.matNombre'
            )
            ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'primaria_grupos.plan_id', '=', 'planes.id')
            ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->where('periodos.id', '=', $periodo_grupo->id)
            ->where('programas.id', '=', $programa_grupo->id)
            ->where('planes.id', '=', $plan_grupo->id)
            ->where('primaria_grupos.gpoGrado', '=', $grupo->gpoGrado)
            ->orderBy('primaria_grupos.gpoClave', 'ASC')
            ->get();
    
    
            return view('primaria.planeacion_docente.show', [
                "ubicaciones" => $ubicaciones,
                "primaria_grupos_planeaciones" => $primaria_grupos_planeaciones,
                "grupo" => $grupo,
                "plan_grupo" => $plan_grupo,
                "programa_grupo" => $programa_grupo,
                "periodo_grupo" => $periodo_grupo,
                "grupos" => $grupos,
                "departamento_grupo" => $departamento_grupo,
                "escuela_grupo" => $escuela_grupo,
                "ubicacion_grupo" => $ubicacion_grupo,
                "primaria_grupos_planeaciones_temas" => $primaria_grupos_planeaciones_temas,
                "primaria_materia" => $primaria_materia
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
        $primaria_grupos_planeaciones = Primaria_grupos_planeaciones::findOrFail($id);

        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $grupo = Primaria_grupo::where('id', $primaria_grupos_planeaciones->primaria_grupo_id)->first();
        $plan_grupo = Plan::where('id', $grupo->plan_id)->first();
        $programa_grupo = Programa::where('id', $plan_grupo->programa_id)->first();
        $periodo_grupo = Periodo::where('id', $grupo->periodo_id)->first();
        $departamento_grupo = Departamento::where('id', $periodo_grupo->departamento_id)->first();
        $escuela_grupo = Escuela::where('id', $programa_grupo->escuela_id)->first();
        $ubicacion_grupo = Ubicacion::where('id', $departamento_grupo->ubicacion_id)->first();

        $primaria_grupos_planeaciones_temas = Primaria_grupos_planeaciones_temas::where('primaria_grupos_planeaciones_id', $primaria_grupos_planeaciones->id)->get();

   
        $grupos = Primaria_grupo::select(
            'primaria_grupos.id', 
            'primaria_grupos.gpoGrado', 
            'primaria_grupos.gpoClave',
            'primaria_grupos.gpoTurno',
            'primaria_materias.matClave',
            'primaria_materias.matNombre'
        )
        ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
        ->join('planes', 'primaria_grupos.plan_id', '=', 'planes.id')
        ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->where('periodos.id', '=', $periodo_grupo->id)
        ->where('programas.id', '=', $programa_grupo->id)
        ->where('planes.id', '=', $plan_grupo->id)
        ->where('primaria_grupos.gpoGrado', '=', $grupo->gpoGrado)
        ->orderBy('primaria_grupos.gpoClave', 'ASC')
        ->get();


        return view('primaria.planeacion_docente.edit', [
            "ubicaciones" => $ubicaciones,
            "primaria_grupos_planeaciones" => $primaria_grupos_planeaciones,
            "grupo" => $grupo,
            "plan_grupo" => $plan_grupo,
            "programa_grupo" => $programa_grupo,
            "periodo_grupo" => $periodo_grupo,
            "grupos" => $grupos,
            "departamento_grupo" => $departamento_grupo,
            "escuela_grupo" => $escuela_grupo,
            "ubicacion_grupo" => $ubicacion_grupo,
            "primaria_grupos_planeaciones_temas" => $primaria_grupos_planeaciones_temas
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
        // dd($request->periodo_id,$request->programa_id, $request->plan_id);

        $validator = Validator::make(
            $request->all(),
            [
                'gpoGrado'  => 'required',
                'primaria_grupo_id' => 'required',
                'mes' => 'required',
                'frase_mes' => 'required',
                'valor_mes' => 'required',
                'norma_urbanidad' => 'required',
                'objetivo_general' => 'required',
                'objetivo_particular' => 'required',
                'bloque' => 'required',
                'notas_observaciones' => 'required',
                'semana_inicio' => 'required',
                'semana_fin' => 'required'             
            
            
            ],
            [
                'gpoGrado.required' => 'El campo Grado es obligatorio.',
                'primaria_grupo_id.required' => 'El campo Grupo es obligatorio.',
                'mes.required' => 'El campo Mes es obligatorio.',
                'frase_mes.required' => 'El campo Frase del mes es obligatorio.',
                'valor_mes.required' => 'El campo Valor del mes es obligatorio.',
                'norma_urbanidad.required' => 'El campo Norma de urbanidad es obligatorio.',
                'objetivo_general.required' => 'El campo Objetivo general es obligatorio.',
                'objetivo_particular.required' => 'El campo Objetivo particular es obligatorio.',
                'bloque.required' => 'El campo Bloque es obligatorio.',
                'notas_observaciones.required' => 'El campo Notas/Observaciones es obligatorio.',             
                'semana_inicio.required' => 'El campo Semama inicio es obligatorio.',              
                'notas_observaciones.required' => 'El campo Semana fin es obligatorio.'                


            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            try {

                $primaria_grupos_planeaciones = Primaria_grupos_planeaciones::where('id', $id)->first();

                $mesInicio = \Carbon\Carbon::parse($request->semana_inicio)->format('m');

                /* --------------------------- Calcular Bimestres --------------------------- */
                // Calculo de bimestre 1 
                if($mesInicio == "09" || $mesInicio == "10"){
                    $bimestre = "Bimestre I";
                }
                // Calculo de bimestre 2
                if($mesInicio == "11" || $mesInicio == "12"){
                    $bimestre = "Bimestre II";
                }
                // Calculo de bimestre 3
                if($mesInicio == "01" || $mesInicio == "02"){
                    $bimestre = "Bimestre II";
                }
                // Calculo de bimestre 4
                if($mesInicio == "03" || $mesInicio == "04"){
                    $bimestre = "Bimestre IV";
                }
                // Calculo de bimestre 5
                if($mesInicio == "05" || $mesInicio == "06"){
                    $bimestre = "Bimestre V";
                }
                if($mesInicio == "07" || $mesInicio == "08"){
                    $bimestre = "";
                }
                /* --------------------------- Calcular Trimestres -------------------------- */
                // Trimestre 1 
                if($mesInicio == "09" || $mesInicio == "10" || $mesInicio == "11" || $mesInicio == "12"){
                    $trimestre = "Trimestre I";
                }
                // Trimestre 2 
                if($mesInicio == "01" || $mesInicio == "02" || $mesInicio == "03"){
                    $trimestre = "Trimestre II";
                }

                if($mesInicio == "04" || $mesInicio == "05" || $mesInicio == "06"){
                    $trimestre = "Trimestre III";
                }

                if($mesInicio == "07" || $mesInicio == "08"){
                    $trimestre = "";
                }

                $primaria_grupos_planeaciones->update([
                    'primaria_grupo_id'         => $request->primaria_grupo_id,
                    'semana_inicio'             => $request->semana_inicio,
                    'semana_fin'                => $request->semana_fin,
                    'bimestre'                  => $bimestre,
                    'trimestre'                 => $trimestre,
                    'mes'                       => $request->mes,
                    'frase_mes'                 => $request->frase_mes,
                    'valor_mes'                 => $request->valor_mes,
                    'norma_urbanidad'           => $request->norma_urbanidad,
                    'objetivo_general'          => $request->objetivo_general,
                    'bloque'                    => $request->bloque,
                    'objetivo_particular'       => $request->objetivo_particular,
                    'notas_observaciones'       => $request->notas_observaciones
                ]);


                $fechaActual = Carbon::now('America/Merida');
                setlocale(LC_TIME, 'es_ES.UTF-8');
                // En windows
                setlocale(LC_TIME, 'spanish');
                $hoy = $fechaActual->format('Y-m-d H:i:s');

                if($request->planeacion_id != ""){
                    for ($i = 0; $i < count($request->planeacion_id); $i++) {

                        DB::table('primaria_grupos_planeaciones_temas')
                        ->where('id', $request->planeacion_id[$i])
                            ->update([
                                'primaria_grupos_planeaciones_id' => $primaria_grupos_planeaciones->id,
                                'tema' => $request->tema[$i],
                                'objetivo' => $request->objetivo[$i],
                                'estrategias' => $request->estrategias[$i],
                                'libros' => $request->libro[$i],
                                'habilidad' => $request->habilidad[$i],
                                'evaluacion' => $request->evaluacion[$i],
                                'usuario_at' => auth()->id(),
                                'updated_at' => $hoy
                            ]);
                    }
                } 


                if($request->tema2 != ""){
                    for ($i = 0; $i < count($request->tema2); $i++) {
            
                        $primaria_grupos_planeaciones_temas = array();
                        $primaria_grupos_planeaciones_temas = new Primaria_grupos_planeaciones_temas();
                        $primaria_grupos_planeaciones_temas['primaria_grupos_planeaciones_id'] = $primaria_grupos_planeaciones->id;
                        $primaria_grupos_planeaciones_temas['tema'] = $request->tema2[$i];
                        $primaria_grupos_planeaciones_temas['objetivo'] = $request->objetivo2[$i];
                        $primaria_grupos_planeaciones_temas['estrategias'] = $request->estrategias2[$i];
                        $primaria_grupos_planeaciones_temas['libros'] = $request->libro2[$i];
                        $primaria_grupos_planeaciones_temas['habilidad'] = $request->habilidad2[$i];
                        $primaria_grupos_planeaciones_temas['evaluacion'] = $request->evaluacion2[$i];

                        $primaria_grupos_planeaciones_temas->save();
                    }
                }


                alert('Escuela Modelo', 'La planeacion docente se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('primaria.primaria_planeacion_docente.index');


            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return back()->withInput();
            }
        }

    }

    public function imprimir($id)
    {
        $primaria_grupos_planeaciones = Primaria_grupos_planeaciones::select(
            'primaria_grupos_planeaciones.id',
            'primaria_grupos_planeaciones.semana_inicio',
            'primaria_grupos_planeaciones.semana_fin',
            'primaria_grupos_planeaciones.mes',
            'primaria_grupos_planeaciones.frase_mes',
            'primaria_grupos_planeaciones.valor_mes',
            'primaria_grupos_planeaciones.norma_urbanidad',
            'primaria_grupos_planeaciones.objetivo_general',
            'primaria_grupos_planeaciones.bloque',
            'primaria_grupos_planeaciones.objetivo_particular',
            'primaria_grupos_planeaciones.notas_observaciones',
            'primaria_grupos_planeaciones.bimestre',
            'primaria_grupos_planeaciones.trimestre',
            'ubicacion.ubiNombre',
            'periodos.perAnioPago',
            'planes.planClave',
            'programas.progNombre',
            'primaria_materias.matClave',
            'primaria_materias.matNombre',
            'primaria_empleados.empNombre',
            'primaria_empleados.empApellido1',
            'primaria_empleados.empApellido2',
            'primaria_empleados.empSexo',
            'primaria_grupos.gpoGrado',
            'primaria_grupos.gpoClave'
        )
        ->join('primaria_grupos', 'primaria_grupos_planeaciones.primaria_grupo_id', '=', 'primaria_grupos.id')
        ->join('primaria_materias', 'primaria_grupos.primaria_materia_id', '=', 'primaria_materias.id')
        ->join('planes', 'primaria_materias.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->join('primaria_empleados', 'primaria_grupos.empleado_id_docente', '=', 'primaria_empleados.id')
        ->join('periodos', 'primaria_grupos.periodo_id', '=', 'periodos.id')
        ->where('primaria_grupos_planeaciones.id', $id)
        ->first();
      

        $primaria_grupos_planeaciones_temas = Primaria_grupos_planeaciones_temas::where('primaria_grupos_planeaciones_id', $primaria_grupos_planeaciones->id)->get();



        //parametros
        $anio = $primaria_grupos_planeaciones->perAnioPago;
        $anio_siguiente = $primaria_grupos_planeaciones->perAnioPago+1;
        $ciclo_escolar = $anio.'-'.$anio_siguiente;
        $empleado = $primaria_grupos_planeaciones->empApellido1.' '.$primaria_grupos_planeaciones->empApellido2.' '.$primaria_grupos_planeaciones->empNombre;

        if($primaria_grupos_planeaciones->empSexo == "F"){
           $maestro =  "Maestra: $empleado";
        }else{
            $maestro =  "Maestro: $empleado";
        }

        $parametro_NombreArchivo = "pdf_primaria_planeacion_docente";
        $pdf = PDF::loadView('reportes.pdf.primaria.planeacion_docente.' . $parametro_NombreArchivo, [
            "ciclo_escolar" => $ciclo_escolar,
            "docente" => $maestro,
            "primaria_grupos_planeaciones" => $primaria_grupos_planeaciones,
            "primaria_grupos_planeaciones_temas" => $primaria_grupos_planeaciones_temas
        ]);


        $pdf->setPaper('letter', 'landscape');
        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
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
