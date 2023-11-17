<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Curso;
use App\Http\Models\Ubicacion;
use App\Http\Models\Periodo;
use App\Http\Models\ServicioSocial;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas as Personas;
use App\clases\cgts\MetodosCgt;

use DB;
use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class ServicioSocialController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){
    	$anioActual = Carbon::now();
    	return view('reportes/servicio_social.create',[
            'anioActual'=>$anioActual,
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request){
    	$cursos = Curso::with('cgt')
        ->where('periodo_id', $request->periodo_id)
        ->whereHas('cgt.plan.programa', function($query) use ($request) {
            if($request->escuela_id) {
                $query->where('escuela_id', $request->escuela_id);
            }
            if($request->programa_id) {
                $query->where('programa_id', $request->programa_id);
            }
        })->oldest('curFechaRegistro')->get()->keyBy('alumno_id');

        if($cursos->isEmpty()) return self::alert_verificacion();
        # -----------------------------------------------------------------
        $periodo =  $cursos->first()->periodo;
        $servicios = ServicioSocial::with('alumno.persona')
        ->whereIn('alumno_id', $cursos->pluck('alumno_id'))
        ->where('ssAnioPeriodoInicio', $periodo->perAnio)
        ->where(static function($query) use ($request) {
            if($request->alcance_regional)
                $query->where('alcance_regional', $request->alcance_regional);
        })
        ->get();

        if($servicios->isEmpty()) return self::alert_verificacion();
        # ----------------------------------------------------------------
        $servicios->transform(static function($servicio) use ($cursos) {
            $alumno = $servicio->alumno;
            $curso = $cursos->get($alumno->id);
            $cgt = $curso->cgt;
            $orden_cgt = MetodosCgt::stringOrden($cgt->cgtGradoSemestre, $cgt->cgtGrupo);
            $nombreCompleto = Personas::nombreCompleto($alumno->persona, true);

            return collect([
                'aluClave' => $alumno->aluClave,
                'nombreCompleto' => $nombreCompleto,
                'progClave' => $servicio->progClave,
                'grado' => $cgt->cgtGradoSemestre,
                'grupo' => $cgt->cgtGrupo,
                'servicio_estado' => $servicio->ssEstadoActual,
                'numero_asignacion' => $servicio->ssNumeroAsignacion,
                'lugar' => $servicio->ssLugar,
                'fecha_inicio' => Utils::fecha_string($servicio->ssFechaInicio, 'mesCorto'),
                'fecha_reporte1' => Utils::fecha_string($servicio->ssFechaReporte1, 'mesCorto'),
                'fecha_reporte2' => Utils::fecha_string($servicio->ssFechaReporte2, 'mesCorto'),
                'fecha_reporte3' => Utils::fecha_string($servicio->ssFechaReporte3, 'mesCorto'),
                'fecha_reporte4' => Utils::fecha_string($servicio->ssFechaReporte4, 'mesCorto'),
                'fecha_liberacion' => Utils::fecha_string($servicio->ssFechaLiberacion, 'mesCorto'),
                'orden' => $orden_cgt.$nombreCompleto,
            ]);
        });

        $fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_servicio_social.pdf";
        return PDF::loadView("reportes.pdf.pdf_servicio_social", [
        "alumnos" => $servicios->sortBy('orden')->groupBy('progClave')->sortKeys(),
        "fechaActual" => $fechaActual->format('d/m/Y'),
        "horaActual" => $fechaActual->format('H:i:s'),
        "alcance_regional" => $request->alcance_regional ? ucfirst($request->alcance_regional) : '',
        "nombreArchivo" => $nombreArchivo
        ])
        ->setPaper('letter', 'landscape')
        ->stream($nombreArchivo.'.pdf');
    }# imprimir

    public static function alert_verificacion() {
        alert('Sin coincidencias', 'No se encontraron datos con la información proporcionada.', 'warning')->showConfirmButton();
        return back()->withInput();
    }
}//FIN class Controller
