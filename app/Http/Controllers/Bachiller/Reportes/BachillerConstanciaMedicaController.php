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

class BachillerConstanciaMedicaController extends Controller
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

        return view('bachiller.reportes.constancia_medica.create', compact('materia_periodo','ubicaciones', 'anioActual'));
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

     

        $minutario = Minutario::create([
            "minAnio"         => $curso->periodo->perAnioPago,
            "minClavePago"    => $request->aluClave,
            "minDepartamento" => $curso->periodo->departamento->depClave,
            "minTipo"         => "CI",
            "minFecha"        => Carbon::now('America/Merida')->format("Y-m-d"),
        ]);

        $periodo_vacional = Bachiller_periodos_vacaciones::select('bachiller_periodos_vacaciones.*')
        ->join('periodos', 'bachiller_periodos_vacaciones.periodo_id', '=', 'periodos.id')
        ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
        ->where('periodos.perAnio',  $curso->periodo->perAnio)
        ->where('periodos.perNumero',  $curso->periodo->perNumero)
        ->where('departamentos.ubicacion_id',  $curso->cgt->plan->programa->escuela->departamento->ubicacion->id)
        // ->where('bachiller_periodos_vacaciones.pvTipo', $request->tipoVacacion)
        ->get();

        if (!$periodo_vacional) {
            alert()->error('Error...', " No se encontró un fechas vacacionales. Favor de agregar la información.")->showConfirmButton();
            return back()->withInput();
        }

        $periodoPrimavera = "";
        $periodoVerano= "";
        $periodoInvierno = "";
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

        // $fechaVacion = "";
        // if($periodo_vacional->pvTipo == "I"){
        //     $fechaVacion = 'invierno del '. Utils::fecha_string($periodo_vacional->pvInicio) .' al '.Utils::fecha_string($periodo_vacional->pvFinal);
        // }
        // if($periodo_vacional->pvTipo == "P"){
        //     $fechaVacion = 'primavera del '. Utils::fecha_string($periodo_vacional->pvInicio) .' al '.Utils::fecha_string($periodo_vacional->pvFinal);
        // }
        // if($periodo_vacional->pvTipo == "V"){
        //     $fechaVacion = 'verano del ' . Utils::fecha_string($periodo_vacional->pvInicio) .' al '.Utils::fecha_string($periodo_vacional->pvFinal);
        // }


        $fechaActual = Carbon::now('America/Merida');

        if($request->ubicaciones == 1 || $request->ubicaciones == 2){
            $nombreArchivo = 'pdf_constancia_medica_cme';
        }

        

        // $firmante = Firmante::where("id", "=", $request->firmante)->first();
        // view('reportes.pdf.bachiller.constancia_medica.pdf_constancia_medica_cme');
        return PDF::loadView('reportes.pdf.bachiller.constancia_medica.'. $nombreArchivo, [
            "minutario"     => $minutario->id,
            "curso"         => $curso,
            "nombreArchivo" => $nombreArchivo,
            "fechaActual"   => $fechaActual,
            "horaActual"    => $fechaActual->toTimeString(),
            "leyenda" => $request->leyenda,
            "periodo_vacional" => $periodo_vacional,
            "periodoPrimavera" => $periodoPrimavera,
            "periodoVerano" => $periodoVerano,
            "periodoInvierno" => $periodoInvierno,
            "perNumero" => $request->perNumero
        ])->stream($nombreArchivo . '.pdf');
    }

}
