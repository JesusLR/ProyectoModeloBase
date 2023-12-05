<?php

namespace App\Http\Controllers\Primaria;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Periodo;
use App\Models\Primaria\Primaria_empleado;
use App\Models\Primaria\Primaria_empleados_horarios;
use App\Models\Primaria\Primaria_horarios_categorias;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class PrimariaHorariosLibresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('primaria.horarios_libres.show-list');
    }

    public function list()
    {
        if (Auth::user()->primaria == 1){

            $horarios_libres = Primaria_empleados_horarios::select(
                'primaria_empleados_horarios.id',
                'primaria_empleados_horarios.periodo_id',
                'primaria_empleados_horarios.primaria_empleado_id',
                'primaria_empleados.empNombre',
                'primaria_empleados.empApellido1',
                'primaria_empleados.empApellido2',
                'primaria_empleados_horarios.primaria_horario_categoria_id',
                'primaria_empleados_horarios.hDia',
                'primaria_empleados_horarios.hHoraInicio',
                'primaria_empleados_horarios.gMinInicio',
                'primaria_empleados_horarios.hFinal',
                'primaria_empleados_horarios.gMinFinal',
                'primaria_horarios_categorias.categoria',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'periodos.perAnioPago'
            )
            ->join('primaria_horarios_categorias', 'primaria_empleados_horarios.primaria_horario_categoria_id', '=', 'primaria_horarios_categorias.id')
            ->join('periodos', 'primaria_empleados_horarios.periodo_id', '=', 'periodos.id')
            ->join('primaria_empleados', 'primaria_empleados_horarios.primaria_empleado_id', '=', 'primaria_empleados.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('departamentos.depClave', 'PRI');


            return DataTables::of($horarios_libres)

            ->filterColumn('anio_pago',function($query,$keyword){
                $query->whereRaw("CONCAT(perAnioPago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('anio_pago',function($query){
                return $query->perAnioPago;
            })

            ->filterColumn('ubicacion',function($query,$keyword){
                $query->whereRaw("CONCAT(ubiNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion',function($query){
                return $query->ubiNombre;
            })

            ->filterColumn('departamento',function($query,$keyword){
                $query->whereRaw("CONCAT(depNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('departamento',function($query){
                return $query->depNombre;
            })

            ->filterColumn('categoria_vigente',function($query,$keyword){
                $query->whereRaw("CONCAT(categoria) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('categoria_vigente',function($query){
                return $query->categoria;
            })

            ->filterColumn('dia_inicio',function($query,$keyword){
                $query->whereRaw("CONCAT(hDia) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('dia_inicio',function($query){
                if($query->hDia == 1){
                    return "LUNES";
                }
                if($query->hDia == 2){
                    return "MARTES";
                }
                if($query->hDia == 3){
                    return "MIERCOLES";
                }
                if($query->hDia == 4){
                    return "JUEVES";
                }
                if($query->hDia == 5){
                    return "VIERNES";
                }
                if($query->hDia == 6){
                    return "SÁBADO";
                }
                if($query->hDia == 7){
                    return "DOMIMGO";
                }
                
            })

            ->filterColumn('hora_inicio',function($query,$keyword){
                $query->whereRaw("CONCAT(hHoraInicio, ' ', gMinInicio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('hora_inicio',function($query){
                if($query->hHoraInicio < 10){
                    return "0".$query->hHoraInicio.':'.$query->gMinInicio;
                }else{
                    return $query->hHoraInicio.':'.$query->gMinInicio;
                }
                
            })

        
            ->filterColumn('hora_fin',function($query,$keyword){
                $query->whereRaw("CONCAT(hFinal, ':', gMinFinal) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('hora_fin',function($query){
                if($query->hFinal < 10){
                    return "0".$query->hFinal.':'.$query->gMinFinal;
                }else{
                    return $query->hFinal.':'.$query->gMinFinal;
                }
                
            })

            ->filterColumn('apellido_paterno',function($query,$keyword){
                $query->whereRaw("CONCAT(empApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido_paterno',function($query){
                return $query->empApellido1;
            })

            ->filterColumn('apellido_materno',function($query,$keyword){
                $query->whereRaw("CONCAT(empApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido_materno',function($query){
                return $query->empApellido2;
            })

            ->filterColumn('nombre_empleado',function($query,$keyword){
                $query->whereRaw("CONCAT(empNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_empleado',function($query){
                return $query->empNombre;
            })

            ->addColumn('action',function($query){
                return '<a href="primaria_horarios_libres/'.$query->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>
                <a href="primaria_horarios_libres/'.$query->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>          
    
                <form id="delete_' . $query->id . '" action="primaria_horarios_libres/' . $query->id . '" method="POST" style="display:inline;">
                     <input type="hidden" name="_method" value="DELETE">
                   <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                         <i class="material-icons">delete</i>
                     </a>
                </form>';
            })->make(true);

        }

    }

    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();
        $departamento = Departamento::select()->findOrFail(13);

        $primaria_empleados = Primaria_empleado::where('empEstado', '!=', 'B')->get();

        $horario_categorias = Primaria_horarios_categorias::get();

        return view('primaria.horarios_libres.create', [
            "ubicaciones" => $ubicaciones,
            "departamento" => $departamento,
            "primaria_empleados" => $primaria_empleados,
            "horario_categorias" => $horario_categorias
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id'  => 'required',
                'primaria_empleado_id'  => 'required',
                'primaria_horario_categoria_id'  => 'required',
                'hDia'  => 'required',
                'hHoraInicio'  => 'required',
                'gMinInicio'  => 'required',
                'hFinal'  => 'required',
                'gMinFinal'  => 'required',


            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'primaria_empleado_id.required' => 'El campo Docente es obligatorio.',
                'primaria_horario_categoria_id.required' => 'El campo Categoría es obligatorio.',
                'hDia.required' => 'El campo Día es obligatorio.',
                'hHoraInicio.required' => 'El campo Hora de inicio es obligatorio.',
                'gMinInicio.required' => 'El campo Minuto de inicio es obligatorio.',
                'hFinal.required' => 'El campo Hora de fin es obligatorio.',
                'gMinFinal.required' => 'El campo Minuto de fin es obligatorio.',

            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_horarios_libres/create')->withErrors($validator)->withInput();
        } else {
            try {

                if ($request->hFinal <  $request->hHoraInicio) {
                    alert('Upss', 'La hora final no puede ser menor a la hora inicial', 'warning')->showConfirmButton()->autoClose('5000');
                    return redirect('primaria_horarios_libres/create')->withErrors($validator)->withInput();
                }

                if ($request->hFinal ==  $request->hHoraInicio) {
                    if ($request->gMinFinal <= $request->gMinInicio) {
                        alert('Upss', 'El minuto final no puede ser menor o igual al minuto incial inicial', 'warning')->showConfirmButton()->autoClose('5000');
                        return redirect('primaria_horarios_libres/create')->withErrors($validator)->withInput();
                    }
                }


                $horaMinInicio = $request->hHoraInicio . $request->gMinInicio;
                $horaMinFinal  = $request->hFinal . $request->gMinFinal;

                //VALIDA SI ESTA DENTRO DE LA FECHA INICIO Y FECHA FINAL DE UN MAESTRO
                $maestroOcupadoAdmin = Primaria_empleados_horarios::where('primaria_empleado_id', '=', $request->primaria_empleado_id)
                    ->select("periodo_id", "hDia", "hHoraInicio", "gMinFinal")
                    ->where('periodo_id', '=', $request->periodo_id)
                    ->where('hDia', '=', $request->hDia)
                    ->where(DB::raw('CONVERT(CONCAT(hFinal, gMinFinal), SIGNED)'), '>', (int) $horaMinInicio)
                    ->where(DB::raw('CONVERT(CONCAT(hHoraInicio, gMinInicio), SIGNED)'), '<', (int) $horaMinFinal)
                    ->first();


                if ($maestroOcupadoAdmin) {
                    alert()->error('Ups...', "Horario de maestro no disponible")->showConfirmButton();
                    return back()->withInput();
                }


                Primaria_empleados_horarios::create([
                    'periodo_id' => $request->periodo_id,
                    'primaria_empleado_id' => $request->primaria_empleado_id,
                    'primaria_horario_categoria_id' => $request->primaria_horario_categoria_id,
                    'hDia' => $request->hDia,
                    'hHoraInicio' => $request->hHoraInicio,
                    'gMinInicio' => $request->gMinInicio,
                    'hFinal' => $request->hFinal,
                    'gMinFinal' => $request->gMinFinal
                ]);

                alert('Escuela Modelo', 'El horario se ha creado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('primaria.primaria_horarios_libres.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('primaria_horarios_libres/create')->withInput();
            }
        }
    }

    public function show($id)
    {
        # code...
        $ubicaciones = Ubicacion::get();
        $departamento = Departamento::select()->findOrFail(13);

        $primaria_empleados = Primaria_empleado::where('empEstado', '!=', 'B')->get();

        $horario_categorias = Primaria_horarios_categorias::get();

        $primaria_empleados_horarios = Primaria_empleados_horarios::with('primaria_empleado.escuela', 
        'primaria_horario_categoria', 'periodo.departamento.ubicacion')->findOrFail($id);

        $escuela = Escuela::where('departamento_id', $primaria_empleados_horarios->periodo->departamento->id)->first();



        return view('primaria.horarios_libres.show', [
            "ubicaciones" => $ubicaciones,
            "departamento" => $departamento,
            "primaria_empleados" => $primaria_empleados,
            "horario_categorias" => $horario_categorias,
            "primaria_empleados_horarios" => $primaria_empleados_horarios,
            "escuela" => $escuela
        ]); 
    }

    public function edit($id)
    {
        $ubicaciones = Ubicacion::get();
        $departamento = Departamento::select()->findOrFail(13);

        $primaria_empleados = Primaria_empleado::where('empEstado', '!=', 'B')->get();

        $horario_categorias = Primaria_horarios_categorias::get();

        $primaria_empleados_horarios = Primaria_empleados_horarios::with('primaria_empleado.escuela', 
        'primaria_horario_categoria', 'periodo.departamento.ubicacion')->findOrFail($id);

        return view('primaria.horarios_libres.edit', [
            "ubicaciones" => $ubicaciones,
            "departamento" => $departamento,
            "primaria_empleados" => $primaria_empleados,
            "horario_categorias" => $horario_categorias,
            "primaria_empleados_horarios" => $primaria_empleados_horarios
        ]); 
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'periodo_id'  => 'required',
                'primaria_empleado_id'  => 'required',
                'primaria_horario_categoria_id'  => 'required',
                'hDia'  => 'required',
                'hHoraInicio'  => 'required',
                'gMinInicio'  => 'required',
                'hFinal'  => 'required',
                'gMinFinal'  => 'required',

                
            ],
            [
                'periodo_id.required' => 'El campo Período es obligatorio.',
                'primaria_empleado_id.required' => 'El campo Docente es obligatorio.',
                'primaria_horario_categoria_id.required' => 'El campo Categoría es obligatorio.',
                'hDia.required' => 'El campo Día es obligatorio.',
                'hHoraInicio.required' => 'El campo Hora de inicio es obligatorio.',
                'gMinInicio.required' => 'El campo Minuto de inicio es obligatorio.',
                'hFinal.required' => 'El campo Hora de fin es obligatorio.',
                'gMinFinal.required' => 'El campo Minuto de fin es obligatorio.',

            ]
        );

        if ($validator->fails()) {
            return redirect('primaria_horarios_libres/create')->withErrors($validator)->withInput();
        } else {
            try {

                if($request->hFinal <  $request->hHoraInicio){
                    alert('Upss', 'La hora final no puede ser menor a la hora inicial', 'warning')->showConfirmButton()->autoClose('5000');
                    return redirect('primaria_horarios_libres/create')->withErrors($validator)->withInput();
                }

                if($request->hFinal ==  $request->hHoraInicio){
                    if($request->gMinFinal <= $request->gMinInicio){
                        alert('Upss', 'El minuto final no puede ser menor o igual al minuto incial inicial', 'warning')->showConfirmButton()->autoClose('5000');
                        return redirect('primaria_horarios_libres/create')->withErrors($validator)->withInput();
                    }                    
                }
                
                $primaria_empleados_horarios = Primaria_empleados_horarios::findOrFail($id); 

                $primaria_empleados_horarios->update([
                    'periodo_id' => $request->periodo_id,
                    'primaria_empleado_id' => $request->primaria_empleado_id,
                    'primaria_horario_categoria_id' => $request->primaria_horario_categoria_id,
                    'hDia' => $request->hDia,
                    'hHoraInicio' => $request->hHoraInicio,
                    'gMinInicio' => $request->gMinInicio,
                    'hFinal' => $request->hFinal,
                    'gMinFinal' => $request->gMinFinal
                ]);

                alert('Escuela Modelo', 'El horario se ha actualizado con éxito', 'success')->showConfirmButton()->autoClose('5000');
                return redirect()->route('primaria.primaria_horarios_libres.index');
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];
                alert()
                    ->error('Ups...' . $errorCode, $errorMessage)
                    ->showConfirmButton();
                return redirect('primaria_horarios_libres/'.$id.'/edit')->withInput();
            }
        }
    }

    public function destroy($id)
    {
        # code...
        $primaria_empleados_horarios = Primaria_empleados_horarios::findOrFail($id);
        try {
            if ($primaria_empleados_horarios->delete()) {
                alert('Escuela Modelo', 'El horario libre se ha eliminado con éxito', 'success')->showConfirmButton()->autoClose('5000');
            } else {
                alert()->error('Error...', 'No se puedo eliminar el horario libre')->showConfirmButton()->autoClose('5000');
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }

        return redirect('primaria_horarios_libres');
    }
}
