<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_inscritos;
use App\Http\Models\Bachiller\Bachiller_periodos_vacaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Models\Curso;
use App\Http\Models\Firmante;
use App\Http\Models\Inscrito;
use App\Http\Models\Minutario;
use App\Http\Models\Ubicacion;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class BachillerConstanciaInscripcionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:r_constancia_inscripcion');
    }

    public function reporte()
    {

        $materia_periodo =[
            'S' => 'SI',
            'N' => 'NO',
        ];
        $ubicaciones = Ubicacion::whereIn('id', [1, 2, 3])->get();
        $anioActual = Carbon::now('America/Merida')->year;

        return view('bachiller.reportes.constancia_inscripcion.create', compact('materia_periodo','ubicaciones', 'anioActual'));
    }

    public function imprimir(Request $request)
    {
        $curso = Curso::with('periodo', 'cgt.plan.programa.escuela.departamento.ubicacion', 'alumno.persona')
        ->whereHas('periodo', function($query) use ($request)  {
            if ($request->perNumero)
                $query->where('perNumero', $request->perNumero);
            if ($request->perAnio)
                $query->where('perAnio', $request->perAnio);
        })
        ->whereHas('alumno.persona', function($query) use ($request)  {
            $columna_filtro = $request->buscar_por == 'clave' ? 'aluClave' : 'aluMatricula';
            $query->where($columna_filtro,  $request->clave_matricula);

            $query->where('perApellido1', 'like', '%' . $request->perApellido1 . '%');
            $query->where('perApellido2', 'like', '%' . $request->perApellido2 . '%');
            $query->where('perNombre', 'like', '%' . $request->perNombre . '%');
        })
        ->whereHas('cgt.plan.programa.escuela.departamento', function($query) use ($request)  {
            $query->where('ubicacion_id', $request->ubicaciones);
            if ($request->depClave)
                $query->where('depClave', $request->depClave);
            if ($request->progClave)
                $query->where('progClave', $request->progClave);
            if($request->cgtGradoSemestre)
                $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
            if($request->cgtGrupo)
                $query->where('cgtGrupo', $request->cgtGrupo);
        })
        ->first();


        if (!$curso) {
            alert()->error('Error...', " No se encontró un curso. Favor de filtrar bien la información.")->showConfirmButton();
            return back()->withInput();
        }

        $materias = new Collection;
        if ($request->matPeriodo == "S") {
            // $materias = Bachiller_inscritos::with(["bachiller_grupo.bachiller_materia"])
            // ->where("curso_id", "=", $curso->id)       
            // ->get() 
            
            $materias = Bachiller_inscritos::select(
                'bachiller_materias.id',
                'bachiller_materias.matOrdenVisual',
                'bachiller_materias.matNombre'
            )
            ->join('bachiller_grupos', 'bachiller_inscritos.bachiller_grupo_id', '=', 'bachiller_grupos.id')
            ->join('bachiller_materias', 'bachiller_grupos.bachiller_materia_id', '=', 'bachiller_materias.id')
            ->where('bachiller_inscritos.curso_id', '=', $curso->id) 
            ->groupBy('bachiller_materias.id') 
            ->groupBy('bachiller_materias.matOrdenVisual') 
            ->groupBy('bachiller_materias.matNombre')   
            ->get()  

            ->sortBy(static function($inscrito) {
                return $inscrito->matOrdenVisual.'-'.$inscrito->matNombre;
            });
        }

        // $unique = $collection->unique();



        $minutario = Minutario::create([
            "minAnio"         => $curso->periodo->perAnioPago,
            "minClavePago"    => $request->aluClave,
            "minDepartamento" => $curso->periodo->departamento->depClave,
            "minTipo"         => "CI",
            "minFecha"        => Carbon::now('America/Merida')->format("Y-m-d"),
        ]);

        $periodoPrimavera = "";
        $periodoVerano= "";
        $periodoInvierno = "";
        
        if($request->matPeriodo == "S"){
            $periodo_vacional = Bachiller_periodos_vacaciones::select('bachiller_periodos_vacaciones.*')
            ->join('periodos', 'bachiller_periodos_vacaciones.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->where('periodos.perAnio',  $curso->periodo->perAnio)
            ->where('periodos.perNumero',  $curso->periodo->perNumero)
            ->where('departamentos.ubicacion_id',  $curso->cgt->plan->programa->escuela->departamento->ubicacion->id)
            ->get();
    
            if (!$periodo_vacional) {
                alert()->error('Error...', " No se encontró un fechas vacacionales. Favor de agregar la información.")->showConfirmButton();
                return back()->withInput();
            }



           
            foreach($periodo_vacional as $vacaciones){
                if($vacaciones->pvTipo == "I"){
                    $periodoInvierno = 'invierno del ' . Utils::fecha_string($vacaciones->pvInicio) .' al '.Utils::fecha_string($vacaciones->pvFinal);
                }
                if($vacaciones->pvTipo == "P"){
                    $periodoPrimavera = 'primavera del ' . Utils::fecha_string($vacaciones->pvInicio) .' al '.Utils::fecha_string($vacaciones->pvFinal);
                }else{
                    if($vacaciones->pvTipo == "V"){
                        $periodoVerano = 'verano del ' . Utils::fecha_string($vacaciones->pvInicio) .' al '.Utils::fecha_string($vacaciones->pvFinal);
                    }else{
                        if($vacaciones->pvTipo == "I"){
                            $periodoInvierno = 'invierno del ' . Utils::fecha_string($vacaciones->pvInicio) .' al '.Utils::fecha_string($vacaciones->pvFinal);
                        }
                    }
                }
            }


        }else{
            $periodo_vacional = "";
        }
        

        
        $fechaActual = Carbon::now('America/Merida');

        if($request->ubicaciones == 1){
            $nombreArchivo = $request->matPeriodo == 'N' ?
            'pdf_constancia_inscripcion_sin_materia_cme' :
            'pdf_constancia_inscripcion_con_materia_cme';
        }

        if($request->ubicaciones == 2){
            $nombreArchivo = $request->matPeriodo == 'N' ?
            'pdf_constancia_inscripcion_sin_materia_cva' :
            'pdf_constancia_inscripcion_con_materia_cva';
        }
        

        // $firmante = Firmante::where("id", "=", $request->firmante)->first();
        // view('reportes.pdf.bachiller.constancia_inscripcion.pdf_constancia_inscripcion_sin_materia_cme')
        return PDF::loadView('reportes.pdf.bachiller.constancia_inscripcion.'. $nombreArchivo, [
            "minutario"     => $minutario->id,
            "curso"         => $curso,
            "materias"      => $materias,
            "nombreArchivo" => $nombreArchivo,
            "fechaActual"   => $fechaActual,
            "horaActual"    => $fechaActual->toTimeString(),
            // "firmante"      => $firmante
            "leyenda" => $request->leyenda,
            "periodo_vacional" => $periodo_vacional,
            "periodoPrimavera" => $periodoPrimavera,
            "periodoVerano" => $periodoVerano,
            "periodoInvierno" => $periodoInvierno,
            "perNumero" => $request->perNumero
        ])->stream($nombreArchivo . '.pdf');
    }

}
