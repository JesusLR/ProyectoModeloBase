<?php

namespace App\Http\Controllers;

use Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\Alumno;
use App\Http\Models\PreinscritoExtraordinario;
use App\Http\Helpers\Utils;

use RealRashid\SweetAlert\Facades\Alert;
use Codedge\Fpdf\Fpdf\Fpdf;
use Yajra\DataTables\Facades\DataTables;

class FichaPreinscritoExtraordinarioController extends Controller
{
    public function __construct() {
    	$this->middleware('auth');
    }

    public function vista() {
    	return view('fichas_preinscritos_extraordinarios.show-alumnos');
    }

    public function list() {
   //  	$raw = DB::raw("SELECT max(preinscritosextraordinarios.id) AS id,
			// preinscritosextraordinarios.folioFichaPagoBBVA AS folioFichaPagoBBVA,
			// preinscritosextraordinarios.folioFichaPagoHSBC AS folioFichaPagoHSBC,
			// preinscritosextraordinarios.alumno_id AS alumno_id,
			// preinscritosextraordinarios.created_at AS created_at,
			// sum(preinscritosextraordinarios.extPago) AS extPago 
			// from preinscritosextraordinarios 
			// where (preinscritosextraordinarios.folioFichaPagoBBVA is not null) 
			// group by preinscritosextraordinarios.folioFichaPagoBBVA,preinscritosextraordinarios.folioFichaPagoHSBC,preinscritosextraordinarios.created_at");
   //  	$query = DB::statement($raw);

    	/**
    	 * Presentaba un error en el Laravel ya que QueryBuilder no permite utilizar Group By, Max, Min, ni funciones para agrupar.
    	 * Para funcionar, requería cambiar en config/databases.php la connection de mysql['strict'] a false. (No es recomendable).
    	 * Por lo que mejor se creó este procedure.
    	 */
    	$query = DB::select("call procFichasPreinscritoExtraordinarioGeneral()");

    	return DataTables::of($query)
    	->addColumn('action', static function($query) {
    		return '<div class="row">'
    					// .Utils::btn_show($query->id, 'alumno')
    					.'<a target="_blank" href="fichas_preinscritos_extraordinarios/reimprime/'.$query->id.
	                    '" class="button modal-trigger button--icon js-button js-ripple-effect" title="Ficha de Pago">
	                        <i class="material-icons">local_atm</i>
	                    </a>'.
    			   '</div>';
    	})
    	->make(true);
    }

    public function reimprime($preinscrito_id)
    {
        $preinscritos = PreinscritoExtraordinario::findOrFail($preinscrito_id);

        $ficha['clave_pago']       = $preinscritos->aluClave;
        $ficha['nombreAlumno']     = $preinscritos->aluNombre;
        $ficha['progNombre']       = $preinscritos->progNombre;
        $ficha['ubicacion']        = $preinscritos->ubiNombre;
        $ficha['folioFichaPagoBBVA']     = $preinscritos->folioFichaPagoBBVA;
        $ficha['folioFichaPagoHSBC']  = $preinscritos->folioFichaPagoHSBC;
        $ficha['nomConcepto'] = strtoupper('Derecho de Examen(es) ExtraOrdinario(s)');
        $ficha['convenioBBVA']= "0679569";
        $ficha['cursoEscolar'] = "2020-2021";
        $ficha['convenioHSBC'] = "021180550300090224";

        $fechaCreacionPago = $preinscritos->created_at;
        $fechaCreacionPagoFicha = $preinscritos->created_at;

        $fechaVencimientoPago = $fechaCreacionPago->addDays(2);
        $fechaVencimientoPagoImprime = $fechaVencimientoPago->day . "/" . Utils::num_meses_corto_string($fechaVencimientoPago->month) . "/" . $fechaVencimientoPago->year;

        $fechaVencimientoFicha = $fechaCreacionPagoFicha->addDays(3);
        $fechaVencimientoFichaImprime = $fechaVencimientoFicha->day . "/" . Utils::num_meses_corto_string($fechaVencimientoFicha->month) . "/" . $fechaVencimientoFicha->year;

        //dd( $fechaVencimientoPago , $fechaVencimientoPagoImprime, $fechaVencimientoFichaImprime);

        $ficha['vencimientoPago'] = $fechaVencimientoPagoImprime;
        $ficha['vencimientoFicha'] = $fechaVencimientoFichaImprime;


        // $alumnos = Auth::user()->username;
        $alumnos = $preinscritos->aluClave;
        $alumno = Alumno::where('aluClave', $alumnos)->first();
        $alumnoid = $alumno->id;
        $fichas = DB::select('call procFichasPreinscritoExtraordinario(?)', array($alumnoid));
        $query = collect($fichas);
        if(!$query || $query->isEmpty()) {
        	alert('Ficha caducada', 'Esta ficha pertenece a un período de extraordinarios anterior.', 'warning')->showConfirmButton();
        	return redirect()->back();
        }
        $ficha['importeFichas'] = $query->first()->extPago;

        //valores de celdas
        //curso escolar
        $talonarios = ['bbva', 'hsbc', 'modelo'];

        $logoX = 150;
        $logoY['bbva'] = 12;
        $logoY['hsbc'] = 105;
        $logoY['modelo'] = 198;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['bbva'] = 20;
        $cursoY['hsbc'] = 112;
        $cursoY['modelo'] = 204;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['bbva'] = 15;
        $escuelaModeloY['hsbc'] = 107;
        $escuelaModeloY['modelo'] = 199;

        //Ficha de Deposito
        $fichaDepositoY['bbva'] = 25;
        $fichaDepositoY['hsbc'] = 117;
        $fichaDepositoY['modelo'] = 210;

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
        $fila1['bbva'] = 35;
        $fila1['hsbc'] = 128;
        $fila1['modelo'] = 220;

        //fila2
        $fila2['bbva'] = 44;
        $fila2['hsbc'] = 137;
        $fila2['modelo'] = 226;

        //fila3
        $fila3['bbva'] = 53;
        $fila3['hsbc'] = 146;
        $fila3['modelo'] = 239;

        //fila3.5
        $fila35['bbva'] = 65;
        $fila35['hsbc'] = 158;
        $fila35['modelo'] = 251;

        //fila4
        $fila4['bbva'] = 70;
        $fila4['hsbc'] = 163;
        $fila4['modelo'] = 256;

        //fila5
        $fila5['bbva'] = 79;
        $fila5['hsbc'] = 172;
        $fila5['modelo'] = 265;

        //Clave de pago

        //Número de convenio

        //Nombre del Alumno
        $nombreC = utf8_decode($ficha['nombreAlumno']);
        $nombreC = strtoupper($nombreC);

        //ubicación
        $ubicacionC = "($ficha[ubicacion])";
        //concepto
        $conceptoC = $ficha['nomConcepto'];
        $conceptoC = utf8_decode($conceptoC);

        //pago1
        $pago1Fecha = "";
        $pago1Importe = "";
        $pago1Referencia = "";

        $pago1Fecha = $ficha['vencimientoPago'];
        $pago1Importe = $ficha['importeFichas'];
        $pago1Referencia = $ficha['folioFichaPagoBBVA'];

        //pago2
        $pago2Fecha = "";
        $pago2Importe = "";
        $pago2Referencia = "";

        $pago2Fecha = $ficha['vencimientoPago'];
        $pago2Importe = $ficha['importeFichas'];
        $pago2Referencia = $ficha['folioFichaPagoHSBC'];

        //pago3
        $pago3Fecha = "";
        $pago3Importe = "";
        $pago3Referencia = "";

        $pago3Fecha = $ficha['vencimientoPago'];
        $pago3Importe = $ficha['importeFichas'];
        $pago3Referencia = $ficha['folioFichaPagoBBVA'];

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimientoFicha'];
        $vencimientohsbc = $ficha['vencimientoFicha'];
        $vencimientomodelo = $ficha['vencimientoFicha'];

        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: ") . Carbon::now("CDT")->format("d/m/Y h:i");
        $pdf = new \App\Http\Controllers\Pagos\EFEPDF('P','mm','Letter');
        $pdf->SetTitle("Ficha de pago | SCEM");
        $pdf->AliasNbPages();
        $pdf->AddPage();

        foreach ($talonarios as $talonarioInd)
        {
            if ($talonarioInd == "bbva")
            {
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
                $pdf->Cell($cursoW, $cursoH, "FICHA DE PAGO REFERENCIADO", 0, 0, 'C');
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
                $pdf->Cell($anchoCorto, $filaH,$ficha['convenioBBVA'], 1, 0);
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

                $pdf->SetY(84);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell($anchoMedio, $filaH, "                      * * * PARA PAGO EXCLUSIVO EN CAJA O CAJERO EN BBVA * * *", 0, 0);

                $pdf->SetY(88);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "UTILIZAR SIEMPRE LA REFERENCIA DE PAGO CORRESPONDIENTE", 0, 0);

                $pdf->SetY(92);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "NO EFECTUAR TRANSFERENCIAS EN BBVA YA QUE NO SE REGISTRAN", 0, 0);


            }

            if ($talonarioInd == "hsbc")
            {
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
                $pdf->Cell($cursoW, $cursoH, "PAGO POR TRANSFERENCIA ELECTRONICA SPEI", 0, 0, 'C');
                $pdf->SetTextColor(0);

                $pdf->SetFont('Arial','',30);
                $pdf->SetXY(140,  $fila1[$talonarioInd]);
                $pdf->Cell(80, -25, "HSBC", 0, 0, "C");

                $pdf->SetFont('Arial','',10);
                //clave de pago
                $pdf->SetXY($columna2, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH,$ficha['clave_pago'], 1, 0);
                //numero de cuenta convenio
                $pdf->SetXY($columna4, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaH,$ficha['convenioHSBC'], 1, 0);
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
                $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
                $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);

                /*
                $pdf->SetX($columna1);
                $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
                $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);
                */

                //fecha de vencimiento y fecha de impresión

                $pdf->SetX($columna2);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell($anchoMedio, $filaH, "Esta ficha se invalida a partir del:", 0, 0);
                $pdf->SetFont('Arial', 'B', '10');
                $pdf->SetX($vencimientoX);
                // $pdf->SetX($columna2);
                $pdf->Cell($vencimientoW, $filaH, $vencimientohsbc, 0, 0);

                $pdf->SetFont('Arial', 'I', '8');
                $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

                $pdf->SetY(177);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell($anchoMedio, $filaH, "                *** PARA PAGO EXCLUSIVO POR TRANSFERENCIA EN HSBC ***", 0, 0);

                $pdf->SetY(182);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "SI PAGA DE HSBC A HSBC, PAGAR COMO SERVICIO 9022", 0, 0);

                $pdf->SetY(186);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "DESDE OTRO BANCO A HSBC (SPEI), USAR LA CLABE INTERBANCARIA 021180550300090224", 0, 0);

            }

            if ($talonarioInd == "modelo")
            {
                //$pdf->Image(URL::to('images/bbva.png'),$logoX, $logoY[$talonarioInd]);
                //imprimir encabezados
                $pdf->SetFillColor(180, 190, 210);
                $pdf->SetFont('Arial', '', 10);

                //Fecha límite
                $pdf->SetXY($columna1, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);

                //Importe
                $pdf->SetXY($columna2, $fila1[$talonarioInd]);
                $pdf->Cell($anchoCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

                //Referencia
                $pdf->SetXY($columna3, $fila1[$talonarioInd]);
                $pdf->Cell($anchoMedio, $filaMedia, "Referencia de Pago", 1, 0, 'C', 1);

                $pdf->SetFont('Arial','B', 12);
                $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');

                $pdf->SetXY($logoX,  $logoY[$talonarioInd]);
                $pdf->Cell($logoW, $logoH,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, 'C');

                $pdf->SetTextColor(40, 65, 110);
                $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
                $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
                $pdf->Cell($cursoW, $cursoH, "PAGO EN EFECTIVO / OFICINAS DE UNIVERSIDAD", 0, 0, 'C');
                $pdf->SetTextColor(0);

                //importes y fechas
                $pdf->SetFont('Arial','',10);
                $pdf->SetY($fila2[$talonarioInd]);
                $pdf->SetX($columna1);
                $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0);
                $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0);
                $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1);

                $pdf->SetY(235);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell($anchoMedio, $filaH, "* * * PARA PAGO EXCLUSIVO EN VENTANILLA DE SECRETARIA ADMINISTRATIVA * * *", 0, 0);
                $pdf->SetY(243);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "PUEDE REALIZAR EL PAGO EN EFECTIVO DIRECTAMENTE EN LA VENTANILLA DE CAJA", 0, 0);

                $pdf->SetY(247);
                $pdf->SetX($columna1);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($anchoMedio, $filaH, "DE LA SECRETARIA ADMINISTRATIVA DE LA UNIVERSIDAD", 0, 0);
            }
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
