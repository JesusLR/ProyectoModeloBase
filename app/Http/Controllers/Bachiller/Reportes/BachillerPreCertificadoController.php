<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use App\clases\historicos\MetodosHistoricos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Http\Models\Bachiller\Bachiller_historico;
use App\Http\Models\Curso;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Collection;

use PDF;

class BachillerPreCertificadoController extends Controller
{
    protected $alumno;
    protected $bachiller_materias;

    public function __construct()
    {
        $this->middleware('auth');

        $this->bachiller_materias = new Collection;
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.pre-certificado.create', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir(Request $request)
    {
        $curso = self::buscarCurso($request);
        if (!$curso) return self::alert_verificacion();

        $this->alumno = $curso->alumno;
        $plan = $curso->cgt->plan;
        $bachiller_historicos = $this->buscarHistoricos($plan);

        $cursos = $this->buscarCursosDeAlumno($plan);
        if($bachiller_historicos->isEmpty()) return self::alert_verificacion();
    
        $this->bachiller_materias = $this->info_por_semestre_cursado($bachiller_historicos, $cursos);

        $periodo = $curso->periodo;
        $departamento = $periodo->departamento;
        $planNumCreditos = $curso->cgt->plan->planNumCreditos;


        $nombreArchivo = 'pdf_precertificado';



        $fechaActual = Carbon::now('America/Merida'); 
        $fechaHoy = $fechaActual->format('Y-m-d');

        $fechaDeHoy = Utils::fecha_string($fechaHoy, $fechaHoy);
        $horaDeHoy = $fechaActual->format('H:i:s');
        $fechaIngreso = Utils::fecha_string(\Carbon\Carbon::parse($curso->alumno->aluFechaIngr)->format('Y-m-d'), \Carbon\Carbon::parse($curso->alumno->aluFechaIngr)->format('Y-m-d'));

        // view('reportes.pdf.bachiller.pre-certificado.pdf_precertificado_cme');
        return PDF::loadView('reportes.pdf.bachiller.pre-certificado.' . $nombreArchivo, [
            "fechaDeHoy" => $fechaDeHoy,
            "horaDeHoy" => $horaDeHoy,
            "curso" => $curso,
            "fechaIngreso" => $fechaIngreso,
            "semestres" => $this->bachiller_materias->sortByDesc('histFechaExamen')->groupBy('grado')->sortKeys(),
            "departamento" => $departamento,
            "planNumCreditos" => $planNumCreditos
        ])->stream($nombreArchivo . '.pdf');
    }

    public static function buscarCurso($request)
    {
        return Curso::with(['alumno.persona', 'periodo.departamento.ubicacion', 'cgt.plan.programa'])
            ->whereHas('alumno', static function ($query) use ($request) {
                $query->where('aluClave', $request->aluClave);


                if($request->aluMatricula){
                    $query->where('aluMatricula', $request->aluMatricula);
                }
            })

            ->whereHas('alumno.persona', static function ($query) use ($request) {

                if($request->perApellido1){
                    $query->where('perApellido1', $request->perApellido1);
                }

                if($request->perApellido2){
                    $query->where('perApellido2', $request->perApellido2);
                }

                if($request->perNombre){
                    $query->where('perNombre', $request->perNombre);
                }
            })

            ->whereHas('periodo.departamento.ubicacion', static function ($query) use ($request) {
                $query->where('ubicacion_id', $request->ubicacion_id);
            })

            ->whereHas('periodo.departamento', static function ($query) {
                $query->where('depClave', 'BAC');
            })

            ->latest('curFechaRegistro')->first();
    }

    public static function alert_verificacion()
    {
        alert('Sin Coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar', 'warning')->showConfirmButton();
        return back()->withInput();
    }

    public function buscarHistoricos($plan): Collection
    {
      return Bachiller_historico::with(['bachiller_materia', 'periodo'])
      ->where('alumno_id', $this->alumno->id)->where('plan_id', $plan->id)
      ->whereNull('deleted_at')
      ->whereHas('bachiller_materia', static function($query) {
        $query->where('matTipoGrupoMateria', '!=', 'COMPLEMENTARIA');
      })
      ->oldest('histFechaExamen')
      ->get()->keyBy('bachiller_materia_id');
    }

    public function buscarCursosDeAlumno($plan): Collection
    {
        return Curso::with('cgt')
        ->where('alumno_id', $this->alumno->id)
        ->whereHas('cgt', static function($query) use ($plan) {
        $query->where('plan_id', $plan->id);
        })
        ->oldest('curFechaRegistro')
        ->get()->keyBy('periodo_id');
    }

    public function info_por_semestre_cursado($bachiller_historicos, $cursos)
    {
      $bachiller_historicos->groupBy('periodo_id')->each(function($bachiller_historicos_periodo, $periodo_id) use ($cursos) {
        $curso = $cursos->pull($periodo_id);
  
        $bachiller_historicos_periodo->each(function($bachiller_historico) use ($curso) {
          $bachiller_materia = $this->info_materia_cursada($bachiller_historico, $curso);
          $this->bachiller_materias->push($bachiller_materia);
        });
  
      });
  
      return $this->bachiller_materias;
    }

    private function info_materia_cursada($bachiller_historico, $curso = null): array
    {
      $cgt = $curso ? $curso->cgt : null;
      $periodo = $curso ? $curso->periodo : $bachiller_historico->periodo;
      $bachiller_materia = $bachiller_historico->bachiller_materia;
      $grado = $cgt ? $cgt->cgtGradoSemestre : $bachiller_materia->matSemestre;
  
      return [
        'materia_id' => $bachiller_materia->id,
        'matClave' => $bachiller_materia->matClave,
        'matNombre' => $bachiller_materia->matNombre,
        'matCreditos' => $bachiller_materia->matCreditos,
        'matTipoAcreditacion' => $bachiller_materia->matTipoAcreditacion,
        'matSemestre' => $bachiller_materia->matSemestre,
        'grado' => $grado,
        'histCalificacion' => MetodosHistoricos::definirCalificacion($bachiller_historico, $bachiller_materia),
        'histFechaExamen' => $bachiller_historico->histFechaExamen,
        'cicloSemestre' => Utils::fecha_string($periodo->perFechaInicial).' - '.Utils::fecha_string($periodo->perFechaFinal),
        'orden_materia' => $bachiller_historico->histFechaExamen,
        'es_revalidacion' => $bachiller_historico->histTipoAcreditacion,
        'periodoNumero' => $periodo->perNumero.'-'.$periodo->perAnio,
        'histPeriodoAcreditacion' => $bachiller_historico->histPeriodoAcreditacion,
        'histTipoAcreditacion' => $bachiller_historico->histTipoAcreditacion,
        'histLibro' => $bachiller_historico->histLibro,
        'hisActa' => $bachiller_historico->hisActa,
        'histFolio' => $bachiller_historico->histFolio
      ];
    }
   
}
