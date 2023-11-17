<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RelDeudoresCursoAnteriorExport;

class DeudoresCursoAnteriorController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    }

    public function reporte() {
        $anioActual = Carbon::now();

        $aluEstado = [
            'R' => 'REGULARES',
            'P' => 'PREINSCRITOS',
            'C' => 'CONDICIONADO',
            'A' => 'CONDICIONADO 2',
            'B' => 'BAJA',
            'T' => 'TODOS',
        ];

        return View('reportes/rel_deudores_curso_anterior.create', [
            "aluEstado" => $aluEstado,
            "anioActual"=>$anioActual
        ]);
    }

    public function imprimir(Request $request) {

        $userId = Auth::id();

        $tipoReporte = $request->tipoReporte;
        $parametro_NombreArchivo = "";
        $parametro_Titulo = "";
        $parametro_Mes = "";
        $parametro_Ubicacion = "";
        $parametro_Periodo = "";
        $parametro_Semestre_Inicio = 1;
        $parametro_Semestre_Fin = 15;
        $parametro_Semestre_Filtro_Inicio = 1;
        $parametro_Semestre_Filtro_Fin = 15;

        # Curso Estado Año adeudado
        $parametro_curEstadoR = "R";
        $parametro_curEstadoC = "C";
        $parametro_curEstadoA = "A";
        $parametro_curEstadoP = "P";
        $parametro_curEstadoB = "B";

        if ($request->curEstados == "B")
        {
            $parametro_curEstadoR = "B";
            $parametro_curEstadoC = "B";
            $parametro_curEstadoA = "B";
            $parametro_curEstadoP = "B";
        }
        if ($request->curEstados == "RPCA")
        {
            $parametro_curEstadoB = "R";
        }

        # Curso Estado Actual ...
        $parametro_curEstadoActualR = "R";
        $parametro_curEstadoActualC = "C";
        $parametro_curEstadoActualA = "A";
        $parametro_curEstadoActualP = "P";
        $parametro_curEstadoActualB = "B";

        if ($request->curEstadosActuales == "B")
        {
            $parametro_curEstadoActualR = "B";
            $parametro_curEstadoActualC = "B";
            $parametro_curEstadoActualA = "B";
            $parametro_curEstadoActualP = "B";
        }
        if ($request->curEstadosActuales == "R")
        {
            $parametro_curEstadoActualR = "R";
            $parametro_curEstadoActualC = "R";
            $parametro_curEstadoActualA = "R";
            $parametro_curEstadoActualP = "R";
            $parametro_curEstadoActualB = "R";
        }
        if ($request->curEstadosActuales == "P")
        {
            $parametro_curEstadoActualR = "P";
            $parametro_curEstadoActualC = "P";
            $parametro_curEstadoActualA = "P";
            $parametro_curEstadoActualP = "P";
            $parametro_curEstadoActualB = "P";
        }
        if ($request->curEstadosActuales == "C")
        {
            $parametro_curEstadoActualR = "C";
            $parametro_curEstadoActualC = "C";
            $parametro_curEstadoActualA = "C";
            $parametro_curEstadoActualP = "C";
            $parametro_curEstadoActualB = "C";
        }
        if ($request->curEstadosActuales == "A")
        {
            $parametro_curEstadoActualR = "A";
            $parametro_curEstadoActualC = "A";
            $parametro_curEstadoActualA = "A";
            $parametro_curEstadoActualP = "A";
            $parametro_curEstadoActualB = "A";
        }
        if ($request->curEstadosActuales == "CA")
        {
            $parametro_curEstadoActualR = "C";
            $parametro_curEstadoActualP = "C";
            $parametro_curEstadoActualB = "C";
        }
        if ($request->curEstadosActuales == "RPCA")
        {
            $parametro_curEstadoActualB = "R";
        }

        // $call = "call procColeAlumnosDepto_AnioAnterior("
        //     .$userId
        //     .",".$request->perAnio
        //     .",'".$request->ubiClave
        //     ."','".$request->depClave
        //     ."',".$request->mesPago
        //     .",".$parametro_Semestre_Inicio
        //     .",".$parametro_Semestre_Fin
        //     .",".$parametro_Semestre_Filtro_Inicio
        //     .",".$parametro_Semestre_Filtro_Fin
        //     .",'I"
        //     ."','X"
        //     ."','".$parametro_curEstadoR
        //     ."','".$parametro_curEstadoA
        //     ."','".$parametro_curEstadoC
        //     ."','".$parametro_curEstadoP
        //     ."','".$parametro_curEstadoB
        //     ."','".$parametro_curEstadoActualR
        //     ."','".$parametro_curEstadoActualA
        //     ."','".$parametro_curEstadoActualC
        //     ."','".$parametro_curEstadoActualP
        //     ."','".$parametro_curEstadoActualB
        //     ."','table_name')";
        //     dd($call);


        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        // Output: 54esmdr0qf
        $temporary_table_name = "_" . substr(str_shuffle($permitted_chars), 0, 15);

        $parametro_NombreArchivo = 'excel_deudores_curso_anterior';
        $result =  DB::select("call procColeAlumnosDepto_AnioAnterior("
            .$userId
            .",".$request->perAnio
            .",'".$request->ubiClave
            ."','".$request->depClave
            ."',".$request->mesPago
            .",".$parametro_Semestre_Inicio
            .",".$parametro_Semestre_Fin
            .",".$parametro_Semestre_Filtro_Inicio
            .",".$parametro_Semestre_Filtro_Fin
            .",'I"
            ."','X"
            ."','".$parametro_curEstadoR
            ."','".$parametro_curEstadoA
            ."','".$parametro_curEstadoC
            ."','".$parametro_curEstadoP
            ."','".$parametro_curEstadoB
            ."','".$parametro_curEstadoActualR
            ."','".$parametro_curEstadoActualA
            ."','".$parametro_curEstadoActualC
            ."','".$parametro_curEstadoActualP
            ."','".$parametro_curEstadoActualB
            ."','".$temporary_table_name."')");

        $pagos_deudores_array = DB::select('select * from '.$temporary_table_name);
        $pagos_deudores_collection = collect( $pagos_deudores_array );

        //dd($pagos_deudores_collection);
        $anio_anterior = $request->perAnio - 1;

        switch ($request->mesPago) {
            case 1:
                $parametro_Mes = "SEPTIEMBRE";
                break;
            case 2:
                $parametro_Mes = "OCTUBRE";
                break;
            case 3:
                $parametro_Mes = "NOVIEMBRE";
                break;
            case 4:
                $parametro_Mes = "DICIEMBRE";
                break;
            case 5:
                $parametro_Mes = "ENERO";
                break;
            case 6:
                $parametro_Mes = "FEBRERO";
                break;
            case 7:
                $parametro_Mes = "MARZO";
                break;
            case 8:
                $parametro_Mes = "ABRIL";
                break;
            case 9:
                $parametro_Mes = "MAYO";
                break;
            case 10:
                $parametro_Mes = "JUNIO";
                break;
            case 11:
                $parametro_Mes = "JULIO";
                break;
            case 12:
                $parametro_Mes = "AGOSTO";
                break;
            default:
                $parametro_Mes = "SEPTIEMBRE";
        }

        //$parametro_Mes     = "Pagos registrados hasta el: ". $result[0]->_return_fecha_hasta;
        $parametro_Mes     = "Pagos limitados hasta el mes/año: " . $parametro_Mes . "/" .$request->perAnio;
        $parametro_Periodo = "Años escolares: ". $anio_anterior . " - " . $request->perAnio;//"Período: ".$result[0]->_return_periodo_inicio." - ".$result[0]->_return_periodo_fin;
        //$parametro_Periodo = $parametro_Periodo . " | SI incluye BAJAS (posibles cambios de carrera)";
        $parametro_Ubicacion = "Ubicación: ".$result[0]->_return_ubicacion." - Nivel: ".$request->depClave;
        //$parametro_Titulo = "RELACIÓN DE ALUMNOS QUE DEBEN EL AÑO ESCOLAR ANTERIOR, POR ESCUELA: ".$result[0]->_return_escuela;
        $parametro_Titulo = "RELACIÓN DE ALUMNOS QUE DEBEN EL AÑO ESCOLAR ANTERIOR";
        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );


        if($pagos_deudores_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay registros que coincidan con la información proporcionada.')->showConfirmButton();
            return back()->withInput();
        }

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fechaActual = Carbon::now("CDT");
        $horaActual = $fechaActual->format("H:i:s");

        return Excel::download(new RelDeudoresCursoAnteriorExport(
            $pagos_deudores_collection,
            $fechaActual->toDateString(),
            $horaActual,
            $parametro_Titulo,
            $parametro_Mes,
            $parametro_Ubicacion,
            $request->ubiClave,
            $request->depClave,
            $parametro_Periodo
        ),
            $parametro_NombreArchivo.'.xlsx');

    }


}
