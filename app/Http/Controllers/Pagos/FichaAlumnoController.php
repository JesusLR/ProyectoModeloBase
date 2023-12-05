<?php

namespace App\Http\Controllers\Pagos;

use Lang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
use Debugbar;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Cuota;
use App\Models\ConceptoPago;
use App\Models\Ficha;


use App\Http\Helpers\GenerarReferencia;



use App\Http\Helpers\Referencia;


use Codedge\Fpdf\Fpdf\Fpdf;



class FichaAlumnoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
       // $this->middleware('permisos:pago',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conceptosPago = ConceptoPago::get();

        return View('pagos.ficha_general.create', [
            "conceptosPago" => $conceptosPago
        ]);
    }




    public function obtenerCuotaConcepto(Request $request)
    {
        $cuoConcepto = $request->cuoConcepto;
        $conceptoPago = ConceptoPago::where("conpClave", "=", $cuoConcepto)->first();

        return $conceptoPago ? $conceptoPago->toJson(): collect([])->toJson();
    }



    public function store(Request $request)
    {

        $aluClave         = $request->aluClave;
        $cuoAnio          = $request->cuoAnio;
        $concepto         = $request->cuoConcepto;

        $fechaVencimiento = Carbon::now();
        $fechaVencimientoPago = $fechaVencimiento;

        $fechaFormato = $fechaVencimiento;
        $fechaFormatoSql = Carbon::parse($fechaFormato)->format("Y-m-d");

        $fechaVencimientoPago = $fechaVencimiento->day . "/" . Utils::num_meses_corto_string($fechaVencimiento->month) . "/" . $fechaVencimiento->year;

        $fechaVencimientoFicha = $fechaVencimiento;
        $fechaVencimientoFicha = $fechaVencimiento->day . "/" . Utils::num_meses_corto_string($fechaVencimiento->month) . "/" . $fechaVencimiento->year;

        //datos del Alumno y método de pago
        $curso = Curso::with("alumno.persona", "periodo", "cgt.plan.programa.escuela.departamento")
            ->whereHas('alumno', function($query) use ($request) {
                $query->where('aluClave', $request->aluClave);
            })
            ->whereHas('periodo', function($query) use ($request) {
                $query->where('perAnioPago', $request->cuoAnio);
            })
        ->get()->sortBy("periodo.perAnio")->last();




        if (!$curso) {
            alert()->error('Error...', "No existe curso para este alumno");
            return back()->withInput();
        }


        $clave_pago = $curso->alumno->aluClave;
        $perAnio = $curso->cgt->periodo->perAnio;
        $perAnioPago = $curso->periodo->perAnioPago;


        //INSCRIPCION SIEMPRE VA POR LA CUOTA ACTUAL
        $departamentoId = $curso->cgt->plan->programa->escuela->departamento->id;
        $escuelaId = $curso->cgt->plan->programa->escuela->id;
        $programaId = $curso->cgt->plan->programa->id;
        $perAnioPago = $curso->periodo->perAnioPago;


        $cuotaDep  = Cuota::where([['cuoTipo', 'D'], ['dep_esc_prog_id', $departamentoId], ['cuoAnio', $perAnioPago]])->first();
        $cuotaEsc  = Cuota::where([['cuoTipo', 'E'], ['dep_esc_prog_id', $escuelaId], ['cuoAnio', $perAnioPago]])->first();
        $cuotaProg = Cuota::where([['cuoTipo', 'P'], ['dep_esc_prog_id', $programaId], ['cuoAnio', $perAnioPago]])->first();

        $cuotaActual = "";
        if ($cuotaDep) {
            $cuotaActual = $cuotaDep;
        }
        if ($cuotaEsc) {
            $cuotaActual = $cuotaEsc;
        }
        if ($cuotaProg) {
            $cuotaActual = $cuotaProg;
        }


        if (!$cuotaActual) {
            alert()->error('Error...', "No existe cuota para este alumno");
            return back()->withInput();
        }


        $conceptoRef = $clave_pago . (sprintf("%02d",$request->cuoAnio % 100)) . $concepto;
        $generarReferencia = new GenerarReferencia;
        $importeRef = sprintf("%0.2f",$request->importeNormal);
        $referencia = $generarReferencia->crear($conceptoRef, $fechaFormatoSql, $importeRef);


        $ficha['clave_pago']       = $clave_pago;
        $ficha['nombreAlumno']     = $curso->alumno->persona->perApellido1 . " " . $curso->alumno->persona->perApellido2 . " " . $curso->alumno->persona->perNombre;
        $ficha['progNombre']       = $curso->cgt->plan->programa->progNombreCorto;
        $ficha['gradoSemestre']    = $curso->cgt->cgtGradoSemestre;
        $ficha['ubicacion']        = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $ficha['cuoNumeroCuenta']  = "cuota->cuoNumeroCuenta";
        $ficha['cursoEscolar']     = $perAnio . "-" . ($perAnio + 1);

        $ficha['cuoNumeroCuenta']  = sprintf("%07s\n", $request->convNumero);
        $ficha['vencimientoFicha'] = $fechaVencimientoFicha;

        $ficha['cuoImporteInscripcion1']     = Utils::convertMoney($request->importeNormal);
        $ficha['cuoFechaLimiteInscripcion1'] = $fechaVencimientoPago;
        $ficha['referencia1'] = $referencia;


        $ficha['nomConcepto'] = strtoupper($request->nomConcepto);

        if ($concepto == "99" || $concepto == "00") {
            $ficha['nomConcepto'] = strtoupper($request->nomConcepto) . " " . $request->perNumero;
        }




        Ficha::create([
            "fchNumPer"       => $curso->periodo->perNumero,
            "fchAnioPer"      => $perAnio,
            "fchClaveAlu"     => $clave_pago,
            "fchClaveCarr"    => $curso->cgt->plan->programa->progClave,
            "fchClaveProgAct" => NULL,
            "fchGradoSem"     => $curso->cgt->cgtGradoSemestre,
            "fchGrupo"        => $curso->cgt->cgtGrupo,
            "fchFechaImpr"    => Carbon::now()->format("Y-m-d"),
            "fchHoraImpr"     => Carbon::now()->format("h:i:s"),
            "fchUsuaImpr"     => auth()->user()->id,
            "fchTipo"         => $curso->alumno->aluEstado,

            "fchConc"         => $concepto,
            "fchFechaVenc1"   => $fechaFormatoSql,
            "fhcImp1"         => $importeRef,
            "fhcRef1"         => $referencia,

            "fchEstado"       => "P"
        ]);







        return $this->generatePDF($ficha);
    }


    private function generatePDF($ficha)
    {
        //valores de celdas
        //curso escolar
        $talonarios = ['banco', 'alumno'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
        $logoY['alumno'] = 105;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['banco'] = 20;
        $cursoY['alumno'] = 112;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['banco'] = 15;
        $escuelaModeloY['alumno'] = 107;

        //Ficha de Deposito
        $fichaDepositoY['banco'] = 25;
        $fichaDepositoY['alumno'] = 117;

        //alto de filas
        $filaH = 9;
        $filaMedia = 5;

        //inicio de filas
        $columna1 = 24;
        $columna2 = 69;
        $columna3 = 114;
        $columna4 = 159;
        //ancho de filas
        $anchoCorto = 45;
        $anchoMedio = 90;
        $anchoLargo = 135;

        //fila1
        $fila1['banco'] = 35;
        $fila1['alumno'] = 128;

        //fila2
        $fila2['banco'] = 44;
        $fila2['alumno'] = 137;

        //fila3
        $fila3['banco'] = 53;
        $fila3['alumno'] = 146;

        //fila3.5
        $fila35['banco'] = 65;
        $fila35['alumno'] = 158;

        //fila4
        $fila4['banco'] = 70;
        $fila4['alumno'] = 163;

        //fila5
        $fila5['banco'] = 79;
        $fila5['alumno'] = 172;


        //Clave de pago

        //Número de convenio

        //Nombre del Alumno
        $nombreC = utf8_decode($ficha['nombreAlumno']);
        $nombreC = strtoupper($nombreC);

        //ubicación
        $ubicacionC = "($ficha[ubicacion])";
        //concepto
        $conceptoC = $ficha['nomConcepto']; //"INSCRIPCIÓN AL SEMESTRE $ficha[gradoSemestre] DE $ficha[progNombre]";
        $conceptoC = utf8_decode($conceptoC);

        //pago1
        $pago1Fecha = "";
        $pago1Importe = "";
        $pago1Referencia = "";

        $pago1Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago1Importe = $ficha['cuoImporteInscripcion1'];
        $pago1Referencia = $ficha['referencia1'];

        //pago2
        $pago2Fecha = "";
        $pago2Importe = "";
        $pago2Referencia = "";

        $pago2Fecha = "";
        $pago2Importe = "";
        $pago2Referencia = "";

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimientoFicha'];

        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: ") . Carbon::now("CDT")->format("d/m/Y h:i");
        $pdf = new EFEPDF('P','mm','Letter');
        $pdf->SetTitle("Ficha de pago | SCEM");
    	$pdf->AliasNbPages();
        $pdf->AddPage();

        foreach ($talonarios as $talonarioInd) {
            //$pdf->Image(URL::to('images/bbva.png'),$logoX, $logoY[$talonarioInd]);
            //imprimir encabezados
            $pdf->SetFillColor(180, 190, 210);
            $pdf->SetFont('Arial', '', 10);

            //clave del alumno
            $pdf->SetXY($columna1, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, Lang::get('fichas/FichaPago.aluclave'), 1, 0, 'L', 1);

            //convenio
            $pdf->SetXY($columna3, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("Número de Convenio"), 1, 0, 'L', 1);

            //Nombre del alumno
            $pdf->SetXY($columna1, $fila2[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "Nombre del Alumno", 1, 0, 'L', 1);

            //Concepto de pago
            $pdf->SetXY($columna1, $fila3[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("Descripción"), 1, 0, 'L', 1);

            //Fecha límite
            $pdf->SetXY($columna1, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);
            
            //Importe
            $pdf->SetXY($columna2, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

            //Referencia
            $pdf->SetXY($columna3, $fila35[$talonarioInd]);
            $pdf->Cell($anchoMedio, $filaMedia, Lang::get('fichas/FichaPago.referencia'), 1, 0, 'C', 1);

            $pdf->SetFont('Arial','B', 12);
            $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');




            $pdf->SetXY($logoX,  $logoY[$talonarioInd]);
            $pdf->Cell($logoW, $logoH,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, 'C');



            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "FICHA DE DEPOSITO", 0, 0, 'C');
            $pdf->SetTextColor(0);


            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "BBVA", 0, 0, "C");
            
            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['cuoNumeroCuenta'], 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$nombreC, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$ubicacionC, 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);
            $pdf->SetX($columna1);
            $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
            $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
            $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1);

            $pdf->SetX($columna1);
            $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
            $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
            $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);

            //fecha de vencimiento y fecha de impresión

            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, "Esta ficha se invalida a partir del:", 0, 0);
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->SetX($columna2);
            $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0);

            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

            // if ($ficha['cuoFechaLimiteInscripcion3'] != null) {
            //     $pdf->SetX($columna1);
            //     $pdf->Cell($anchoCorto, $filaH, $pago3Fecha, 0, 0);
            //     $pdf->Cell($anchoCorto, $filaH, $pago3Importe, 0, 0);
            //     $pdf->Cell($anchoCorto, $filaH, $pago3Referencia, 0, 1);
            // }

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }


}


class EFEPDF extends Fpdf {
    public function Header() {
        //$this->SetFont('Arial','B',15);
        //$this->Cell(80);
        //$this->Cell(30,10,'Title',1,0,'C');
        //$this->Ln(20);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}