<?php

namespace App\Http\Controllers\Reportes;

use DB;
use PDF;
use Carbon\Carbon;
use App\Models\Cgt;
use App\Models\Plan;
use App\Models\Cuota;
use App\Models\Curso;
use App\Models\Alumno;
use App\Exports\BecasExport;
use App\Models\Escuela;
use App\Models\Periodo;
use Illuminate\Http\Request;

use App\Models\Programa;

use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class BecasController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('permisos:r_plantilla_profesores');
    set_time_limit(8000000);
  }

  public function reporte()
  {
    //obtener año actual para el filtro que genera el reporte del año de periodo
    $anioActual = Carbon::now();

    $aluEstado = [
        'R' => 'REGULARES',
        'P' => 'PREINSCRITOS',
        'C' => 'CONDICIONADO',
        'A' => 'CONDICIONADO 2',
        'B' => 'BAJA',
        'T' => 'TODOS',
    ];

      return View('reportes/becas_campus_carrera_escuela.create', [
        "aluEstado" => $aluEstado,
        "anioActual"=>$anioActual
      ]);
  }


  public function imprimir(Request $request)
    {


        $becas = Curso::with('alumno', 'periodo', 'cgt.plan.programa.escuela.departamento.ubicacion')


            ->whereHas('alumno', function($query) use ($request)
            {
                if ($request->aluEstado == 'T') {
                    $query->where('curEstado', '<>','B');//Trae todos los alumnos menos bajas
                }
                if ($request->aluEstado != 'T') {

                    $query->where('curEstado', '=', $request->aluEstado);//

                }
            })

            ->whereHas('periodo', function($query) use ($request)
            {
                if($request->tipoReporte == "campus")
                {
                    $query->whereIn('perNumero', [0, 3]);
                }
                else
                {
                    if($request->tipoReporte == "escuela")
                    {
                        if ($request->perNumero)
                        {
                            $query->where('perNumero', '=', $request->perNumero);
                        }
                        else
                        {
                            $query->whereIn('perNumero', [0, 3]);
                        }
                    }
                    if($request->tipoReporte == "carrera")
                    {
                        if ($request->perNumero)
                        {
                            $query->where('perNumero', '=', $request->perNumero);
                        }
                        else
                        {
                            $query->whereIn('perNumero', [0, 3]);
                        }
                    }
                }


                if ($request->perAnio)
                {
                    $query->where('perAnio', $request->perAnio);//
                }
                /*
                if ($request->tipoReporte) {//Tipo de reporte
                  $query->where('tipoReporte', '=', $request->tipoReporte);//
                }
                */
            })

            ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion', function($query) use ($request) {
                if ($request->ubiClave) {
                    $query->where('ubiClave', '=', $request->ubiClave);//
                }
                if ($request->depClave)
                {
                    $query->where('departamentos.depClave', '=', $request->depClave);//
                }
                else {
                        if($request->tipoReporte == "carrera")
                        {
                            $query->where('departamentos.depClave', '=', 'SUP')
                                ->orWhere('departamentos.depClave', '=', 'POS');
                        }
                }
                /*
                if ($request->progClave) {
                    $query->where('programas.progClave', '=', $request->progClave);//
                }
                */

            });



        $becas = $becas->get();

        if($becas->isEmpty()) {
            alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        //dd($becas);

        $cursoIds = $becas->map(function ($item, $key) {
            return $item->id;
        });

        $pagos = collect([]);
        $fechaActual = Carbon::now();
        $aluEstado = $request->aluEstado;
        $beca     = null;
        $numBeca = "";

        foreach ($cursoIds as $curso_id) {
            $curso = Curso::where('id', '=', $curso_id)->first();

            $cursoId = $curso->id;
            $progClave = $curso->cgt->plan->programa->progClave;
            $progNombre = $curso->cgt->plan->programa->progNombre;
            $escClave = $curso->cgt->plan->programa->escuela->escClave;
            $escNombre = $curso->cgt->plan->programa->escuela->escNombre;
            $ubicacionClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
            $ubicacionNombre = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre;
            $departamentoId = $curso->cgt->plan->programa->escuela->departamento->id;
            $escuelaId = $curso->cgt->plan->programa->escuela->id;
            $programaId = $curso->cgt->plan->programa->id;
            $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
            $depNombre = $curso->cgt->plan->programa->escuela->departamento->depNombre;
            $depNivel = $curso->cgt->plan->programa->escuela->departamento->depNivel;
            $alumnoId = $curso->alumno->id;
            //AÑO DE LA INSCRIPCION - PERIODO AÑO DE PAGO
            $perAnioPago = $curso->periodo->perAnioPago;
            $aluClave = $curso->alumno->aluClave;
            $cgtid = $curso->cgt->id;

            $cuotaImpDesc = 0;
            $cuotaImpMens10 = 0;
            $cuotaImpMens11 = 0;
            $cuotaImpMens12 = 0;
            $numMeses = 0;
            $cuotaActual = "";

            //$perAnioPagoInscripcion = $perAnioPago + 1;

            $cuotaDep  = Cuota::where([['cuoTipo', 'D'], ['dep_esc_prog_id', $departamentoId], ['cuoAnio', $perAnioPago]])->first();
            $cuotaEsc  = Cuota::where([['cuoTipo', 'E'], ['dep_esc_prog_id', $escuelaId], ['cuoAnio', $perAnioPago]])->first();
            $cuotaProg = Cuota::where([['cuoTipo', 'P'], ['dep_esc_prog_id', $programaId], ['cuoAnio', $perAnioPago]])->first();

            if ($cuotaProg)
            {
                //$cuotaActual = $cuotaProg;
                $cuotaActual = "Programa";
                $cuotaImpDesc = $cuotaProg->cuoImporteProntoPago;
                $cuotaImpMens10 = $cuotaProg->cuoImporteMensualidad10;
                $cuotaImpMens11 = $cuotaProg->cuoImporteMensualidad11;
                $cuotaImpMens12 = $cuotaProg->cuoImporteMensualidad12;
            }
            else
            {
                if ($cuotaEsc)
                {
                    //$cuotaActual = $cuotaEsc;
                    $cuotaActual = "Escuela";
                    $cuotaImpDesc = $cuotaEsc->cuoImporteProntoPago;
                    $cuotaImpMens10 = $cuotaEsc->cuoImporteMensualidad10;
                    $cuotaImpMens11 = $cuotaEsc->cuoImporteMensualidad11;
                    $cuotaImpMens12 = $cuotaEsc->cuoImporteMensualidad12;
                }
                else
                {
                    if ($cuotaDep)
                    {
                        //$cuotaActual = $cuotaDep;
                        $cuotaActual = "Departamento";
                        $cuotaImpDesc = $cuotaDep->cuoImporteProntoPago;
                        $cuotaImpMens10 = $cuotaDep->cuoImporteMensualidad10;
                        $cuotaImpMens11 = $cuotaDep->cuoImporteMensualidad11;
                        $cuotaImpMens12 = $cuotaDep->cuoImporteMensualidad12;

                    }
                }
            }


            //OBTENER CUOTA MENSUAL DEPENDIENDO EL PLAN DEL PAGO
            $curPlanPago = $curso->curPlanPago;

            if(($aluEstado == "T" && $curso->curEstado != "B" )
                || ($aluEstado != "T" && $curso->curEstado == $aluEstado))
            {

                //Aplica descuento de pronto pago
                if($cuotaImpDesc == NULL){
                    $cuotaImpDesc = 0;
                }
                if($cuotaImpMens10 == NULL){
                    $cuotaImpMens10 = 0;
                }
                if($cuotaImpMens11 == NULL){
                    $cuotaImpMens11 = 0;
                }
                if($cuotaImpMens12 == NULL){
                    $cuotaImpMens12 = 0;
                }

                //asigna valor a la mensualidad
                switch ($curPlanPago) {
                    case 'O':
                        $mensualidad  = $cuotaImpMens11 - $cuotaImpDesc;
                        $numMeses = 11;
                        break;
                    case 'D':
                        $mensualidad  = $cuotaImpMens12 - $cuotaImpDesc;
                        $numMeses = 12;
                        break;
                    case 'A':
                    case 'N':
                        $mensualidad = $cuotaImpMens10 - $cuotaImpDesc;
                        $numMeses = 10;
                        break;
                    default:
                        break;
                }
            }


            if ($curso->curPorcentajeBeca != "" || $curso->curPorcentajeBeca != null )
            {
                $beca = $curso->curPorcentajeBeca;
                $porBeca = $beca/100;
                $numBeca = strval($beca)."%";
                if ($porBeca < 1)
                {
                    $numBeca = "0".strval($beca)."%";
                }

                $pagos->push([
                    "cursoId"=> $cursoId,
                    "alumnoId" => $alumnoId,
                    "alumnoClave" => $aluClave,
                    "cgtid" =>$cgtid,
                    "departamentoid" =>$departamentoId,
                    "escuelaid" =>$escuelaId,
                    "programaid" =>$programaId,
                    "progClave" => $progClave,
                    "progNombre" => $progNombre,
                    "curPlanPago" => $curPlanPago,
                    "cuotaActual" => $cuotaActual,
                    "cuotaImpMens10" => $cuotaImpMens10,
                    "cuotaImpMens11" => $cuotaImpMens11,
                    "cuotaImpMens12" => $cuotaImpMens12,
                    "cuotaImpDesc" => $cuotaImpDesc,
                    "mensualidad" => $mensualidad,
                    "numMeses" => $numMeses,
                    "escClave" => $escClave,
                    "escNombre" => $escNombre,
                    "depClave" => $depClave,
                    "depNombre" => $depNombre,
                    "ubicacionClave"  => $ubicacionClave,
                    "ubicacionNombre"  => $ubicacionNombre,
                    "ubiClaveEscuela" => $ubicacionClave.$escNombre,
                    "ubiClavePrograma" => $ubicacionClave.$progNombre,
                    "ubiNivelProgramaBeca" => $ubicacionClave.strval($depNivel).$progNombre.$numBeca,
                    "ubiNivelEscuelaBeca" => $ubicacionClave.strval($depNivel).$escNombre.$numBeca,
                    "beca"    => $beca,
                    "porBeca" => $porBeca
                ]);

            }

        }


        //Determina el Layout del PDF de reporte
        $tipoReporte = $request->tipoReporte;
        $nombreArchivo = "";
        if($tipoReporte == "campus")
        {
            $nombreArchivo = 'pdf_becas_campus';
            $ordenado = $pagos->sortBy('ubiClaveEscuela');
            $agrupado = $ordenado->groupBy("ubiClaveEscuela");
        }elseif($tipoReporte == "carrera")
        {
            $nombreArchivo = 'pdf_becas_carreras';
            $ordenado =$pagos->sortBy('ubiNivelProgramaBeca');
            $agrupado = $ordenado->groupBy("ubiNivelProgramaBeca");
        }elseif($tipoReporte == "escuela")
        {
            $nombreArchivo = 'pdf_becas_escuelas';
            $ordenado =$pagos->sortBy('ubiNivelEscuelaBeca');
            $agrupado = $ordenado->groupBy("ubiNivelEscuelaBeca");
        }

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');





        //dd($agrupado);

        //$sumaPagos =$pagos->count();
        //$firstPago = $pagos->first();
        //"pagos" => $pagos->groupBy(["escClave","escNombre","mensualidad","ubicacionClave","beca"]),

        if ($request->tipoFormato == "PDF") {

            $pdf = PDF::loadView('reportes.pdf.'. $nombreArchivo, [
                "pagos" => $agrupado,
                "aluEstado" => $aluEstado,
                "fechaActual" => $fechaActual->toDateString(),
                "horaActual" => $fechaActual->toTimeString(),
                "nombreArchivo" => $nombreArchivo.'.pdf',
                "perAnio" => $request->perAnio,
                "perNumero" => $request->perNumero
            ]);


            $pdf->setPaper('letter', 'portrait');
            $pdf->defaultFont = 'Times Sans Serif';

            return $pdf->stream($nombreArchivo.'.pdf');
            return $pdf->download($nombreArchivo.'.pdf');
        }

        if ($request->tipoFormato == "EXCEL") {
            return Excel::download(new BecasExport(
                $agrupado,
                $aluEstado,
                $fechaActual->toDateString(),
                $fechaActual->toTimeString(),
                $nombreArchivo.'.xlsx',
                $request->perAnio,
                $request->perNumero), $nombreArchivo.'.xlsx');
        }

    }

}
