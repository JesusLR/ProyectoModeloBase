<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Curso;
use App\Http\Models\Alumno;
use App\Http\Models\Periodo;
use App\Http\Models\Cgt;
use App\Http\Models\Plan;
use App\Http\Models\Programa;
use App\Http\Models\Escuela;
use App\Http\Models\Departamento;
use App\Http\Models\Ubicacion;
use App\Http\Models\Cuota;
use Auth;

use Carbon\Carbon;

use PDF;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class ColegiaturasController extends Controller
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

      return View('reportes/colegiaturas.create', [
        "aluEstado" => $aluEstado,
        "anioActual"=>$anioActual
      ]);
  }


  public function imprimir(Request $request)
    {
        /*
        foreach ($cursoIds as $curso_id)
        {
        }
        */

        $userId = Auth::id();



        $tipoReporte = $request->tipoReporte;
        $parametro_NombreArchivo = "";
        $parametro_Titulo = "";
        $parametro_Mes = "";
        $parametro_Ubicacion = "";
        $parametro_Periodo = "";
        $parametro_EstadoCurso = "Regular, Condicionado (C, A), Preinscrito, Baja";
        $parametro_EstadosCurso = "";
        $parametro_Departamento = "";
        //$aplicaProntoPago = $request->tipoAplica;

        $parametro_curEstadoR = "R";
        $parametro_curEstadoC = "C";
        $parametro_curEstadoA = "A";
        $parametro_curEstadoP = "P";
        $parametro_curEstadoB = "B";

        if ($request->curEstados == "R")
        {
            $parametro_curEstadoR = "R";
            $parametro_curEstadoC = "R";
            $parametro_curEstadoA = "R";
            $parametro_curEstadoP = "R";
            $parametro_curEstadoB = "R";
            $parametro_EstadoCurso = "Regular";
        }
        if ($request->curEstados == "B")
        {
            $parametro_curEstadoR = "B";
            $parametro_curEstadoC = "B";
            $parametro_curEstadoA = "B";
            $parametro_curEstadoP = "B";
            $parametro_curEstadoB = "B";
            $parametro_EstadoCurso = "Baja";
        }
        if ($request->curEstados == "RPCA")
        {
            $parametro_curEstadoB = "R";
            $parametro_EstadoCurso = "Regular, Condicionado (C, A), Preinscrito";
        }
        if ($request->curEstados == "P")
        {
            $parametro_curEstadoR = "P";
            $parametro_curEstadoC = "P";
            $parametro_curEstadoA = "P";
            $parametro_curEstadoP = "P";
            $parametro_curEstadoB = "P";
            $parametro_EstadoCurso = "Preinscrito";
        }
        if ($request->curEstados == "CA")
        {
            $parametro_curEstadoR = "C";
            $parametro_curEstadoC = "C";
            $parametro_curEstadoA = "A";
            $parametro_curEstadoP = "C";
            $parametro_curEstadoB = "C";
            $parametro_EstadoCurso = "Condicionado (C, A)";
        }


        if($tipoReporte == "campus" && in_array($request->depClave, ['SUP', 'POS']))
        {

            $parametro_NombreArchivo = 'pdf_colegiaturas_nivel';
            $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (GENERAL POR NIVEL)";
            $result =  DB::select("call procColeNivel("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','SI','"
                .$request->tipoResumen
                ."','".$parametro_curEstadoR
                ."','".$parametro_curEstadoA
                ."','".$parametro_curEstadoC
                ."','".$parametro_curEstadoP
                ."','".$parametro_curEstadoB
                ."')");

            $pagos_nivel_array = DB::select('select * from _pagos_nivel_temp');
            $pagos_nivel_collection = collect( $pagos_nivel_array );
            //dd($pagos_nivel_collection);
            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
            $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";

        }elseif($tipoReporte == "carrera")
        {
            if(in_array($request->depClave, ['MAT', 'PRE', 'SEC'])) {
                alert()->warning('Sin datos', 'El filtro de reporte "POR PROGRAMA" es solo para Nivel Primaria, Superior ó Posgrado. Favor de verificar sus opciones seleccionadas')->showConfirmButton();
                return back()->withInput();
            }
            if(in_array($request->depClave, ['PRI'])) {
                $parametro_NombreArchivo = 'pdf_colegiaturas_programa';
                $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (NIVEL PRIMARIA POR PROGRAMA)";
                $parametro_Departamento = "Escuela Modelo Primaria";
                $result =  DB::select("call procColeProgramaPri("
                    .$userId
                    .",".$request->perAnio
                    .",'".$request->ubiClave
                    ."','SI','"
                    .$request->tipoResumen
                    ."','"
                    .$request->depClave
                    ."','".$parametro_curEstadoR
                    ."','".$parametro_curEstadoA
                    ."','".$parametro_curEstadoC
                    ."','".$parametro_curEstadoP
                    ."','".$parametro_curEstadoB
                    ."')");

                $pagos_nivel_array = DB::select('select * from _pagos_programa_temp');
                $pagos_nivel_collection = collect( $pagos_nivel_array );
                //dd($pagos_nivel_collection);
                $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
                $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
                $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
                $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";

            }
            if(in_array($request->depClave, ['SUP', 'POS'])) {
                $parametro_NombreArchivo = 'pdf_colegiaturas_programa';
                $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (NIVEL SUPERIOR POR PROGRAMA Ó CARRERA)";
                $result =  DB::select("call procColePrograma("
                    .$userId
                    .",".$request->perAnio
                    .",'".$request->ubiClave
                    ."','SI','"
                    .$request->tipoResumen
                    ."','"
                    .$request->depClave
                    ."','".$parametro_curEstadoR
                    ."','".$parametro_curEstadoA
                    ."','".$parametro_curEstadoC
                    ."','".$parametro_curEstadoP
                    ."','".$parametro_curEstadoB
                    ."')");

                $pagos_nivel_array = DB::select('select * from _pagos_programa_temp');
                $pagos_nivel_collection = collect( $pagos_nivel_array );
                //dd($pagos_nivel_collection);
                $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
                $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
                $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
                $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";

                if ($request->depClave == "SUP")
                {
                    $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (NIVEL SUPERIOR POR PROGRAMA)";
                    $parametro_Departamento = "SUP Universidad Modelo";
                }
                else
                {
                    $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (NIVEL POSGRADO POR PROGRAMA)";
                    $parametro_Departamento = "POS Universidad Modelo";
                }
            }


        }elseif($tipoReporte == "escuela" )
        {
            if(!in_array($request->depClave, ['SUP', 'POS'])) {
                alert()->warning('Sin datos', 'El filtro de reporte "POR ESCUELA" es solo para Nivel Superior ó Posgrado. Favor de verificar sus opciones seleccionadas')->showConfirmButton();
                return back()->withInput();
            }
            $parametro_NombreArchivo = 'pdf_colegiaturas_escuela';
            $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (NIVEL SUPERIOR POR ESCUELA)";

            $result =  DB::select("call procColeEscuela("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','SI','"
                .$request->tipoResumen
                ."','"
                .$request->depClave
                ."','".$parametro_curEstadoR
                ."','".$parametro_curEstadoA
                ."','".$parametro_curEstadoC
                ."','".$parametro_curEstadoP
                ."','".$parametro_curEstadoB
                ."')");

            $pagos_nivel_array = DB::select('select * from _pagos_escuela_temp');
            $pagos_nivel_collection = collect( $pagos_nivel_array );
            //dd($pagos_nivel_collection);
            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
            $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";

            if ($request->depClave == "SUP")
            {
                $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (NIVEL SUPERIOR POR ESCUELA)";
                $parametro_Departamento = "SUP Universidad Modelo";
            }
            else
            {
                $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (NIVEL POSGRADO POR ESCUELA)";
                $parametro_Departamento = "POS Universidad Modelo";
            }
        }
        elseif ($tipoReporte == 'campus' && $request->depClave == 'MAT') {
            $parametro_NombreArchivo = 'pdf_colegiaturas_nivel_MAT';
            $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (GENERAL DE NIVEL MATERNAL)";
            $result =  DB::select("call procColeNivelMat("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','SI','"
                .$request->tipoResumen
                ."','".$parametro_curEstadoR
                ."','".$parametro_curEstadoA
                ."','".$parametro_curEstadoC
                ."','".$parametro_curEstadoP
                ."','".$parametro_curEstadoB
                ."')");

            $pagos_nivel_array = DB::select('select * from _pagos_nivel_temp');
            $pagos_nivel_collection = collect( $pagos_nivel_array );
            // dd($pagos_nivel_collection);
            // dd($result);
            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
            $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";
        }
        elseif ($tipoReporte == 'campus' && $request->depClave == 'PRE') {
            $parametro_NombreArchivo = 'pdf_colegiaturas_nivel_PRE';
            $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (GENERAL DE NIVEL PREESCOLAR)";
            $result =  DB::select("call procColeNivelPre("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','SI','"
                .$request->tipoResumen
                ."','".$parametro_curEstadoR
                ."','".$parametro_curEstadoA
                ."','".$parametro_curEstadoC
                ."','".$parametro_curEstadoP
                ."','".$parametro_curEstadoB
                ."')");

            $pagos_nivel_array = DB::select('select * from _pagos_nivel_temp');
            $pagos_nivel_collection = collect( $pagos_nivel_array );
            // dd($pagos_nivel_collection);
            // dd($result);
            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
            $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";
        }
        elseif ($tipoReporte == 'campus' && $request->depClave == 'PRI') {
            $parametro_NombreArchivo = 'pdf_colegiaturas_nivel_PRI';
            $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (GENERAL DE NIVEL PRIMARIA)";
            $result =  DB::select("call procColeNivelPri("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','SI','"
                .$request->tipoResumen
                ."','".$parametro_curEstadoR
                ."','".$parametro_curEstadoA
                ."','".$parametro_curEstadoC
                ."','".$parametro_curEstadoP
                ."','".$parametro_curEstadoB
                ."')");

            $pagos_nivel_array = DB::select('select * from _pagos_nivel_temp');
            $pagos_nivel_collection = collect( $pagos_nivel_array );
            // dd($pagos_nivel_collection);
            // dd($result);
            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
            $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";
        }
        elseif ($tipoReporte == 'campus' && $request->depClave == 'SEC') {
            $parametro_NombreArchivo = 'pdf_colegiaturas_nivel_SEC';
            $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (GENERAL DE NIVEL SECUNDARIA)";
            $result =  DB::select("call procColeNivelSec("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','SI','"
                .$request->tipoResumen
                ."','".$parametro_curEstadoR
                ."','".$parametro_curEstadoA
                ."','".$parametro_curEstadoC
                ."','".$parametro_curEstadoP
                ."','".$parametro_curEstadoB
                ."')");

            $pagos_nivel_array = DB::select('select * from _pagos_nivel_temp');
            $pagos_nivel_collection = collect( $pagos_nivel_array );
            // dd($pagos_nivel_collection);
            // dd($result);
            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
            $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";
        }
        elseif ($tipoReporte == 'campus' && $request->depClave == 'BAC') {
            $parametro_NombreArchivo = 'pdf_colegiaturas_nivel_BAC';
            $parametro_Titulo = "RESUMEN DE PAGOS DE COLEGIATURAS (GENERAL DE NIVEL BACHILLER)";
            $result =  DB::select("call procColeNivelBac("
                .$userId
                .",".$request->perAnio
                .",'".$request->ubiClave
                ."','SI','"
                .$request->tipoResumen
                ."','".$parametro_curEstadoR
                ."','".$parametro_curEstadoA
                ."','".$parametro_curEstadoC
                ."','".$parametro_curEstadoP
                ."','".$parametro_curEstadoB
                ."')");

            $pagos_nivel_array = DB::select('select * from _pagos_nivel_temp');
            $pagos_nivel_collection = collect( $pagos_nivel_array );
            // dd($pagos_nivel_collection);
            // dd($result);
            $parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
            $parametro_Periodo = "Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
            $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion;
            $parametro_EstadosCurso ="Estado del Curso: ". $parametro_EstadoCurso .".  También se aplicó descuento por pronto pago y beca.";
        }

        //$datos = collect([]);

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaActual = Carbon::now("CDT");
        $horaActual = $fechaActual->format("H:i:s");

        if($pagos_nivel_collection->isEmpty()) {
            alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar')->showConfirmButton();
            return back()->withInput();
        }

        $pdf = PDF::loadView('reportes.pdf.'. $parametro_NombreArchivo, [
            "pagos" => $pagos_nivel_collection,
            "fechaActual" => $fechaActual->toDateString(),
            "horaActual" => $horaActual,
            "nombreArchivo" => $parametro_NombreArchivo.'.pdf',
            "elTitulo" => $parametro_Titulo,
            "elMes" => $parametro_Mes,
            "laUbicacion" => $parametro_Ubicacion,
            "ubiClave" => $request->ubiClave,
            "depClave" =>$request->depClave,
            "elPeriodo" => $parametro_Periodo,
            "elEstadoCurso" => $parametro_EstadosCurso,
        ]);

        if($tipoReporte == "campus")
        {
            $pdf->setPaper('letter', 'portrait');
        }
        else
        {
            $pdf->setPaper('letter', 'landscape');
        }


        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo.'.pdf');
        return $pdf->download($parametro_NombreArchivo.'.pdf');


    }

}
