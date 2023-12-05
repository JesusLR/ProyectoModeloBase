<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\User;
use App\Models\Materia;
use Illuminate\Http\Request;
use App\Models\Historico;

use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use App\Models\ResumenAcademico;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;


class HistoricoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('permisos:historico',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('historico.show-list');
    }


    

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $historico = Historico::select('historico.id',
            'alumnos.aluClave', 'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2',
            'planes.planClave', 'materias.matClave', 'materias.matNombreOficial as matNombre',
            'ubicacion.ubiClave', 'programas.progClave',
            'periodos.perNumero', 'periodos.perAnio',
            'historico.histComplementoNombre','historico.histPeriodoAcreditacion','historico.histTipoAcreditacion',
            'historico.histFechaExamen', 'historico.histCalificacion')
            ->join("alumnos", "alumnos.id", "=", "historico.alumno_id")
                ->join("personas", "personas.id", "=", "alumnos.persona_id")
            ->join("planes", "planes.id", "=", "historico.plan_id")
                ->join("programas", "programas.id", "=", "planes.programa_id")
            ->join("materias", "materias.id", "=", "historico.materia_id")
            ->join("periodos", "periodos.id", "=", "historico.periodo_id")
            ->join("departamentos", "departamentos.id", "periodos.departamento_id")
            ->join("ubicacion", "ubicacion.id", "departamentos.ubicacion_id")
            ->latest('historico.created_at');


        return Datatables::of($historico)
            ->filterColumn('nombreCompleto', function($query, $keyword) {
                return $query->whereRaw("CONCAT(perNombre, ' ', perApellido1, ' ', perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombreCompleto', function($query) {
                return $query->perNombre . " " . $query->perApellido1 . " " . $query->perApellido2;
            })


            ->filterColumn('acrPeriTipo', function($query, $keyword) {
                return $query->whereRaw("CONCAT(histPeriodoAcreditacion,'-',histTipoAcreditacion) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('acrPeriTipo', function($query) {
                return $query->histPeriodoAcreditacion . "-" . $query->histTipoAcreditacion;
            })

            ->filterColumn('matNombre', function($query, $keyword) {
                return $query->whereRaw("CONCAT(matNombre,' - ',histComplementoNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('matNombre', function($query) {
                return $query->matNombre . ($query->histComplementoNombre ? ("-" . $query->histComplementoNombre) : '');
            })

            ->addColumn('action', function($query) {
                return 
                // '<a href="/historico/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                //     <i class="material-icons">visibility</i>
                // </a>'.
                '<a href="/historico/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>' .

                '<form id="delete_' . $query->id . '" action="historico/' . $query->id . '" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="' . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            })
        ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $historico = Historico::findOrFail($id);


        // dd($historico);

        // return view('historico.show',compact('historico'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (User::permiso("historico") == "A" || User::permiso("historico") == "B") {
            $ubicaciones = Ubicacion::all();
            return View('historico.create', compact('ubicaciones'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('historico');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->alumno_id, $request->all());

        $validator = Validator::make($request->all(),
            [
                'alumno_id'               => 'required',
                'plan_id'                 => 'required',
                'materia_id'              => 'required',
                'periodo_id'              => 'required',
                'histPeriodoAcreditacion' => 'required',
                'histTipoAcreditacion'    => 'required',
                'histFechaExamen'         => 'required',
            ]
            // [
            //     'c.unique' => "La abreviatura ya existe",
            // ]
        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            Historico::create([
                'alumno_id'               => $request->alumno_id,
                'plan_id'                 => $request->plan_id,
                'materia_id'              => $request->materia_id,
                'periodo_id'              => $request->periodo_id,
                'histComplementoNombre'   => $request->histComplementoNombre,
                'histPeriodoAcreditacion' => $request->histPeriodoAcreditacion,
                'histTipoAcreditacion'    => $request->histTipoAcreditacion,
                'histFechaExamen'         => $request->histFechaExamen,
                'histCalificacion'        => $request->histCalificacion,
                'histNombreOficial'       => $request->histNombreOficial,
            ]);


            $resumenAcademico = ResumenAcademico::where("alumno_id", "=", $request->alumno_id)
                ->where("plan_id", "=", $request->plan_id);


            $historicoAlumno = DB::table("vwhistoricoaprobados as t1")
                ->where("alumno_id", "=", $request->alumno_id)
                ->where("t1.plan_id", "=", $request->plan_id)
                ->join("materias as t2", "t2.id", "=", "t1.materia_id")
            ->get();


            $materiasAlumno = $historicoAlumno
                ->sortByDesc("histFechaExamen")->unique("materia_id")
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


            $materiasCreditos = Materia::where("plan_id", "=", $request->plan_id)->get()->sum("matCreditos");
            $resAvanceAcumulado = ($resCreditosAprobados / $materiasCreditos) * 100;
            $resAvanceAcumulado = number_format($resAvanceAcumulado, 2);


            if ($resumenAcademico->first()) {
                ResumenAcademico::where("alumno_id", "=", $request->alumno_id)->where("plan_id", "=", $request->plan_id)
                ->update([
                    "resPeriodoUltimo"     => $request->periodo_id,
                    "resClaveEspecialidad" => null,
                    "resCreditosCursados"  => $resCreditosCursados,
                    "resCreditosAprobados" => $resCreditosAprobados,
                    "resAvanceAcumulado"   => $resAvanceAcumulado,
                    "resPromedioAcumulado" => $resPromedioAcumulado,
                ]);
            }


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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (User::permiso("historico") == "A" || User::permiso("historico") == "B") {
            $historico = Historico::findOrFail($id);
            return view('historico.edit',compact('historico'));
        } else {
            alert()->error('Ups...', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
            return redirect('historico');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $historico = Historico::findOrFail($id);

            $historico->histComplementoNombre   = $request->histComplementoNombre;
            $historico->histPeriodoAcreditacion = $request->histPeriodoAcreditacion;
            $historico->histTipoAcreditacion    = $request->histTipoAcreditacion;
            $historico->histFechaExamen         = $request->histFechaExamen;
            $historico->histCalificacion        = $request->histCalificacion;
            $historico->histNombreOficial       = $request->histNombreOficial;
            $historico->save();

            
            $resumenAcademico = ResumenAcademico::where("alumno_id", "=", $request->alumno_id)
                ->where("plan_id", "=", $request->plan_id);


            $historicoAlumno = DB::table("vwhistoricoaprobados as t1")
                ->where("alumno_id", "=", $request->alumno_id)
                ->where("t1.plan_id", "=", $request->plan_id)
                ->join("materias as t2", "t2.id", "=", "t1.materia_id")
            ->get();


            $materiasAlumno = $historicoAlumno
                ->sortByDesc("histFechaExamen")->unique("materia_id")
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





            $materiasCreditos = Materia::where("plan_id", "=", $request->plan_id)->get()->sum("matCreditos");
            $resAvanceAcumulado = ($resCreditosAprobados / $materiasCreditos) * 100;
            $resAvanceAcumulado = number_format($resAvanceAcumulado, 2);


 
            if ($resumenAcademico->first()) {
                ResumenAcademico::where("alumno_id", "=", $request->alumno_id)->where("plan_id", "=", $request->plan_id)
                ->update([
                    "resPeriodoUltimo"     => $request->periodo_id,
                    "resClaveEspecialidad" => null,
                    "resCreditosCursados"  => $resCreditosCursados,
                    "resCreditosAprobados" => $resCreditosAprobados,
                    "resAvanceAcumulado"   => $resAvanceAcumulado,
                    "resPromedioAcumulado" => $resPromedioAcumulado,
                ]);
            }





            alert('Escuela Modelo', 'El histórico se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('historico');
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        
        // if (User::permiso("abreviatura") == "A" || User::permiso("abreviatura") == "B") {
            $historico = Historico::findOrFail($id);


            $histAlumnoId = $historico->alumno_id;
            $histPlanId   = $historico->plan_id;


            try {


                if ($historico->delete()) {

                    $resumenAcademico = ResumenAcademico::where("alumno_id", "=", $histAlumnoId)
                    ->where("plan_id", "=", $histPlanId)->first();

                    if ($resumenAcademico) {
                        $historicoAlumno = DB::table("vwhistoricoaprobados as t1")
                            ->select( "*", "t1.id")
                            ->where("alumno_id", "=", $histAlumnoId)
                            ->where("t1.plan_id", "=", $histPlanId)
                            ->join("materias as t2", "t2.id", "=", "t1.materia_id")
                        ->get();

                        $materiasAlumno = $historicoAlumno
                            ->sortByDesc("histFechaExamen")->unique("materia_id")
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
                        

                        $materiasCreditos = Materia::where("plan_id", "=", $histPlanId)->get()->sum("matCreditos");
                        $resAvanceAcumulado = ($resCreditosAprobados / $materiasCreditos) * 100;
                        $resAvanceAcumulado = number_format($resAvanceAcumulado, 2);



                        ResumenAcademico::where("alumno_id", "=", $histAlumnoId)
                        ->where("plan_id", "=", $histPlanId)
                        ->update([
                            "resClaveEspecialidad" => null,
                            "resCreditosCursados"  => $resCreditosCursados,
                            "resCreditosAprobados" => $resCreditosAprobados,
                            "resAvanceAcumulado"   => $resAvanceAcumulado,
                            "resPromedioAcumulado" => $resPromedioAcumulado,
                        ]);
                    }

                    alert('Escuela Modelo', 'El histórico se ha eliminado con éxito','success')->showConfirmButton();
                } else {
                    alert()->error('Error...', 'No se puedo eliminar el historico')->showConfirmButton();
                }
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()->error('error' . $errorCode,$errorMessage)->showConfirmButton();
            }
        // } else {
        //     alert()->error('Error', 'Sin privilegios para esta acción!')->showConfirmButton()->autoClose(5000);
        // }

        return redirect()->back();
    }

}