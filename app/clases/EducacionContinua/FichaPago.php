<?php 
namespace App\clases\EducacionContinua;

use Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use App\Http\Models\EducacionContinua;
use App\Http\Models\InscritosEduCont;
use App\Http\Models\Ficha;
use App\Http\Models\Referencia;
use App\Http\Models\Convenio;
use App\Http\Helpers\GenerarReferencia;
use App\clases\personas\MetodosPersonas;

use Exception;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use RealRashid\SweetAlert\Facades\Alert;

/**
* Genera y manipula fichas de pago para Educacion Continua, dentro de sus
* funciones se encuentra generar Referencias de pago.
*
* PASOS:
* - $instancia = new FichaPago($inscrito, $concepto, $banco);
* - return $instancia->generarFicha();
*/
class FichaPago
{
	protected $ficha_pago;
	protected $inscrito;
	protected $alumno;
	protected $nombre_alumno;
	protected $programa;
	protected $periodo;
	protected $ubicacion;
	protected $concepto;
	protected $concepto_descripcion;
	protected $importe;
	protected $fecha_vencimiento;
	protected $expiracion_ficha;
	protected $referencia;
	protected $convenio;
	protected $fecha_impresion;
	protected $banco;
	protected $clabe_HSBC = '021180550300090224';
	protected $clabe_BBVA = '012914002018521323';

	/**
	* @param App\Http\Models\InscritosEduCont
	* @param string $concepto
	* @param string $banco
	* @param int | float $importe (opcional)
	* @param string $vencimiento (opcional)
	*/
	public function __construct(InscritosEduCont $inscrito, $concepto, $banco, $importe = null, $vencimiento = null)
	{
		$this->inscrito = $inscrito;
		$this->alumno = $inscrito->alumno;
		$this->nombre_alumno = MetodosPersonas::nombreCompleto($this->alumno->persona, true);
		$this->programa = $inscrito->educacioncontinua;
		$this->ubicacion = $this->programa->ubicacion;
		$this->periodo = $this->programa->periodo;
		$this->concepto = $concepto;
		$this->concepto_descripcion = $this->describir_concepto($concepto);
		$this->importe = number_format($importe ?: $this->definir_importe($concepto), 2, '.', '');
		$this->fecha_vencimiento = $vencimiento ?: $this->definir_vencimiento($concepto);
		$this->expiracion_ficha = Carbon::parse($this->fecha_vencimiento)->addDays(1);
		// $this->convenio = Convenio::delDepartamento($this->periodo->departamento->id)->first()->convNumero;
		$this->convenio = '1852132';
		$this->fecha_impresion = Carbon::now('America/Merida')->format("d/m/Y H:i");
		$this->banco = $banco;
	}

	public function generarFicha()
	{
		DB::beginTransaction();
		try {
			$this->ficha_pago = $this->registrarFicha();
			$this->referencia = $this->generarReferencia($this->banco);
			$this->ficha_pago = $this->actualizar_ficha($this->referencia);
		} catch (Exception $e) {
			DB::rollBack();
			alert('Ups... ', $e->getMessage(), 'error')->showConfirmButton();
			return redirect()->back();
		}
		DB::commit();

		return $this->generatePDF();
	}


	/**
	* Crea un App\Http\Models\Ficha y manipula $ficha_pago
	*/
	public function registrarFicha()
	{
		try {
			$this->ficha_pago = Ficha::create($this->obtener_datos_ficha());
		} catch (Exception $e) {
			throw $e;
		}
		return $this->ficha_pago;
	}


	/**
	* Registra una referencia y genera la cadena de caracteres.
	*/
	public function generarReferencia($banco)
	{
		$cadena_inicial = $this->generarCadenaInicial();
		$conpRefClave = $this->obtenerConpRefClave($this->ubicacion->ubiClave);
		$refNum = $this->obtenerRefNum();
		$registroReferencia = $this->registrarReferencia($refNum); #registra en tabla 'referencias'
		
		$referencia = new GenerarReferencia;

		if($banco == 'BBVA') {
			return $referencia->crearBBVA($cadena_inicial, $this->fecha_vencimiento, $this->importe, $conpRefClave, $registroReferencia->refNum);
		} else {
			return $referencia->crearHSBC($cadena_inicial, $this->fecha_vencimiento, $this->importe, $conpRefClave, $registroReferencia->refNum);
		}
	}


	/**
	* aluClave 8 dígitos. perAnioPago en 2 dígitos y el concepto 2 dígitos.
	*/
	public function generarCadenaInicial()
	{
		$aluClave = str_pad($this->alumno->aluClave, 8, '0', STR_PAD_LEFT);
		$anio = substr(strval($this->periodo->perAnioPago), -2);
		// return '9999'.str_pad($this->ficha_pago->id, 8, '0', STR_PAD_LEFT);
		return $aluClave . $anio . $this->concepto;
	}


	public function obtenerConpRefClave($ubiClave)
	{
		return DB::table('conceptosreferenciaubicacion')
		->where('ubiClave', $ubiClave)
		->where('depClave', 'POS')->where('escClave', 'DIP')->first()->conpRefClave;
	}

	/**
	 * Busca el refNum máximo buscando por alumno_id, año de pago y concepto.
	 * Si es mayor a 9999, lo reinicia a 0001.
	 */
	public function obtenerRefNum() {
		$ultimaReferencia = Referencia::where([
			['alumno_id', '=', $this->alumno->id],
			['refAnioPer', '=', $this->periodo->perAnioPago],
			['refConcPago', '=', $this->concepto]
		])->orderByDesc('refNum')->first();

		$refNum = $ultimaReferencia ? (intval($ultimaReferencia->refNum) + 1) : 1;

		return $refNum > 9999 ? '0001' : str_pad($refNum, 4, '0', STR_PAD_LEFT);
	}

	private function registrarReferencia($refNum) {

		return Referencia::create([
			'alumno_id'     => $this->alumno->id,
			'programa_id'   => null,
			'educacioncontinua_id'   => $this->programa->id,
			'refNum'        => $refNum,
			'refAnioPer'    => $this->periodo->perAnioPago,
			'refConcPago'   => $this->concepto,
			'refFechaVenc'  => $this->fecha_vencimiento,
			'refImpTotal'   => $this->importe,
			'refImpConc'    => $this->importe,
			'refImpBeca'    => 0,
			'refImpPP'      => 0,
			'refImpAntCred' => 0,
			'refImpRecar'    => 0,
			'refUsuarioAplico' => NULL,
			'refFechaAplico'   => NULL,
			'refEstado'        => "P",
			'banco_id'		=> $this->banco == 'BBVA' ? 4 : 7,
	    ]);
	}

	/**
	* @param string $referencia
	*/
	public function actualizar_ficha($referencia)
	{	
		try {
			$this->ficha_pago->update(['fhcRef1' => $referencia]);
		} catch (Exception $e) {
			throw $e;
		}
		return $this->ficha_pago;
	}


	/**
	* Mapea la info de $inscrito, devuelve un array listo para crear un App\Http\Models\Ficha.
	*/
	public function obtener_datos_ficha(): array
	{
		$programa = $this->programa;
		$periodo = $programa->periodo;
		$fecha = Carbon::now('America/Merida');

		return [
			'fchNumPer' => $periodo->perNumero,
			'fchAnioPer' => $periodo->perAnio,
			'fchClaveAlu' => $this->alumno->aluClave,
			'fchClaveCarr' => NULL,
			'fchClaveProgAct' => $programa->id,
			'fchGradoSem' => NULL,
			'fchGrupo' => NULL,
			'fchFechaImpr' => $fecha->format('Y-m-d'),
			'fchHoraImpr' => $fecha->format('H:i:s'),
			'fchUsuaImpr' => Auth::user()->id,
			'fchTipo' => NULL,
			'fchConc' => $this->concepto,
			'fchFechaVenc1' => $this->fecha_vencimiento,
			'fhcImp1' => $this->importe,
			'fhcRef1' => NULL,
			'fchFechaVenc2' => NULL,
			'fhcImp2' => NULL,
			'fhcRef2' => NULL,
			'fchEstado' => 'P',
		];
	}

	/**
	* @param string $concepto
	*/
	public function describir_concepto($concepto)
	{
		$nombre_programa = $this->programa->ecNombre;
		$tipo = 'PAGO';
		switch ($concepto) {
			case '90':
				$tipo = 'INSCRIP.';
				break;
			case '91':
				$tipo = 'PAGO 1';
				break;
			case '92':
				$tipo = 'PAGO 2';
				break;
			case '93':
				$tipo = 'PAGO 3';
				break;
			case '94':
				$tipo = 'PAGO 4';
				break;
			case '95':
				$tipo = 'PAGO 5';
				break;
			case '96':
				$tipo = 'PAGO 6';
				break;
			case '97':
				$tipo = 'PAGO 7';
				break;
			case '98':
				$tipo = 'PAGO 8';
				break;
		}
		return "{$tipo} {$nombre_programa}";
	}

	/**
	* @param string $concepto
	*/
	public function definir_importe($concepto)
	{	
		$result = null;
		switch ($concepto) {
			case '90':
				$result = $this->inscrito->iecImporteInscripcion ?: $this->programa->ecImporteInscripcion;
				break;
			case '91':
				$result = $this->programa->ecImportePago1;
				break;
			case '92':
				$result = $this->programa->ecImportePago2;
				break;
			case '93':
				$result = $this->programa->ecImportePago3;
				break;
			case '94':
				$result = $this->programa->ecImportePago4;
				break;
			case '95':
				$result = $this->programa->ecImportePago5;
				break;
			case '96':
				$result = $this->programa->ecImportePago6;
				break;
			case '97':
				$result = $this->programa->ecImportePago7;
				break;
			case '98':
				$result = $this->programa->ecImportePago8;
				break;
		}

		return $result;
	}

	/**
	* @param string $concepto
	*/
	public function definir_vencimiento($concepto)
	{
		$result = Carbon::now('America/Merida')->format('Y-m-d');
		switch ($concepto) {
			case '90':
				$result = $this->programa->ecVencimientoInscripcion;
				break;
			case '91':
				$result = $this->programa->ecVencimientoPago1;
				break;
			case '92':
				$result = $this->programa->ecVencimientoPago2;
				break;
			case '93':
				$result = $this->programa->ecVencimientoPago3;
				break;
			case '94':
				$result = $this->programa->ecVencimientoPago4;
				break;
			case '95':
				$result = $this->programa->ecVencimientoPago5;
				break;
			case '96':
				$result = $this->programa->ecVencimientoPago6;
				break;
			case '97':
				$result = $this->programa->ecVencimientoPago7;
				break;
			case '98':
				$result = $this->programa->ecVencimientoPago8;
				break;
		}

		if(self::esFechaPasada($result)) {
			$result = Carbon::now('America/Merida')->addDays(3)->format('Y-m-d');
		}

		return $result;
	}


	/**
	* @param string $fecha 'Y-m-d'
	*/
	public static function esFechaPasada($fecha): bool
	{
		return Carbon::now('America/Merida')->gt($fecha);
	}


	// 	CONFIGURACIÓN E IMPRESIÓN DE PDF ---------------------------------

	public function generatePDF() {
        //valores de celdas
        //curso escolar
        // $talonarios = $this->banco == "BBVA" ? ['banco', 'alumno'] : ['banco'];
        $talonarios = ['banco'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 10;
        $logoY['alumno'] = 100;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['banco'] = 20;
        $cursoY['alumno'] = 117;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['banco'] = 15;
        $escuelaModeloY['alumno'] = 112;

        //Ficha de Deposito
        $fichaDepositoY['banco'] = 25;
        $fichaDepositoY['alumno'] = 122;

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
        $fila1['alumno'] = 133;
        //fila2
        $fila2['banco'] = 44;
        $fila2['alumno'] = 142;
        //fila3
        $fila3['banco'] = 53;
        $fila3['alumno'] = 151;
        //fila3.5
        $fila35['banco'] = 65;
        $fila35['alumno'] = 163;
        //fila4
        $fila4['banco'] = 70;
        $fila4['alumno'] = 168;
        //fila5
        $fila5['banco'] = 90;
        $fila5['alumno'] = 188;
        //fila5
        $fila6['banco'] = 95;
        $fila6['alumno'] = 193;
        //fila5
        $fila7['banco'] = 100;
        $fila7['alumno'] = 198;
        //fila8
        $fila8['banco'] = 105;
        $fila8['alumno'] = 203;
        //fila9
        $fila9['banco'] = 115;
        $fila9['alumno'] = 213;
        //fila10
        $fila10['banco'] = 120;
        $fila10['alumno'] = 218;
        //fila11
        $fila11['banco'] = 125;
        $fila11['alumno'] = 223;


        $this->nombre_alumno = strtoupper(utf8_decode($this->nombre_alumno));
        $curso_escolar = $this->periodo->perAnio.' - '.($this->periodo->perAnio + 1);
        $this->concepto_descripcion = utf8_decode($this->concepto_descripcion);
        $tituloFicha = $this->banco == "BBVA" ? "PAGO CON REFERENCIA BANCARIA" : "PAGO POR TRANSFERENCIA ELECTRONICA SPEI";

        $convenio_clabe_texto = 'CLABE INTERBANCARIA';
        $convenio_clabe_num = $this->banco == 'BBVA' ? $this->clabe_BBVA : $this->clabe_HSBC;

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;

        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: {$this->fecha_impresion}");
        $pdf = new EFEPDF('P','mm','Letter');
        $pdf->SetTitle("Ficha de pago | SCEM");
    	$pdf->AliasNbPages();
        $pdf->AddPage();

        foreach ($talonarios as $talonarioInd) {
            //imprimir encabezados
            $pdf->SetFillColor(180, 190, 210);
            $pdf->SetFont('Arial', '', 10);

            //clave del alumno
            $pdf->SetXY($columna1, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, Lang::get('fichas/FichaPago.aluclave'), 1, 0, 'L', 1);

            //convenio
            $pdf->SetXY($columna3, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("{$convenio_clabe_texto}"), 1, 0, 'L', 1);

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


            $pdf->SetXY(0,  $fila1[$talonarioInd]);
            $pdf->Cell(60, -25,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, 12, 20), 0, 0, "C");


            $pdf->SetFont('Arial','B', 12);
            $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$curso_escolar, 0, 0,'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, $fichaDepositoY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, $tituloFicha, 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "{$this->banco}", 0, 0, "C");


            
            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, $this->alumno->aluClave, 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, $convenio_clabe_num, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH, $this->nombre_alumno, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,"({$this->ubicacion->ubiClave})", 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$this->concepto_descripcion, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);
            $pdf->SetX($columna1);
            $pdf->Cell($anchoCorto, $filaH, Carbon::parse($this->fecha_vencimiento)->format('d/m/Y'), 1, 0);
            $pdf->Cell($anchoCorto, $filaH, '$'.number_format($this->importe, 2, '.', ','), 1, 0);
            $pdf->Cell($anchoMedio, $filaH, $this->referencia, 1, 1);


            //fecha de vencimiento y fecha de impresión
            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            // $pdf->Cell($anchoMedio, $filaH, "Esta ficha se invalida a partir del:", 0, 0); // título de la invalidación
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->Cell($vencimientoW, $filaH, $this->expiracion_ficha->format('d/m/Y'), 0, 0); // fecha de invalidación
            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $this->fecha_impresion, 0, 1);

            if($this->banco != 'BBVA') {
            	$pdf->SetY($fila5[$talonarioInd]);
            	$pdf->SetFont('Arial','B', 12);
            	// $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            	$pdf->Cell($cursoW, $cursoH,'** PARA PAGO EXCLUSIVO POR TRANSFERENCIA EN HSBC **', 0, 0,'C');

            	$pdf->SetX($columna1);
            	$pdf->SetY($fila6[$talonarioInd]);
            	$pdf->SetFont('Arial', 'B', 10);
            	$pdf->Cell($anchoMedio, $filaH, "SI PAGA DE HSBC A HSBC, PAGAR COMO SERVICIO 9022", 0, 0);
            	$pdf->SetX($columna1);
            	$pdf->SetY($fila7[$talonarioInd]);
            	$pdf->SetFont('Arial', 'B', 10);
            	$pdf->Cell($anchoMedio, $filaH, "DESDE OTRO BANCO A HSBC (SPEI), USAR LA CLABE INTERBANCARIA {$this->clabe_HSBC}", 0, 0);
            } else {
            	$pdf->SetY($fila5[$talonarioInd]);
            	$pdf->SetFont('Arial','B', 12);
            	// $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            	$pdf->Cell($cursoW, $cursoH,'INSTRUCCIONES DE PAGO:', 0, 0);

            	$pdf->SetY($fila6[$talonarioInd]);
            	$pdf->SetFont('Arial', 'B', 10);
            	$pdf->Cell($cursoW, $cursoH, "I. PAGO DIRECTO EN SUCURSAL BANCARIA BBVA:", 0, 0);

            	$pdf->SetY($fila7[$talonarioInd]);
            	$pdf->SetFont('Arial', 'B', 9);
            	$pdf->Cell($cursoW, $cursoH, "1- SI PAGA EN VENTANILLA DE SUCURSAL BANCARIA BBVA, UTILICE EL CONVENIO {$this->convenio}", 0, 0);

            	$pdf->SetY($fila8[$talonarioInd]);
            	$pdf->SetFont('Arial', 'B', 9);
            	$pdf->Cell($cursoW, $cursoH, utf8_decode("2- SI PAGA EN CAJERO AUTOMÁTICO BBVA, SELECCIONE PAGO DE SERVICIO CON EL CONVENIO {$this->convenio}"), 0, 0);

            	$pdf->SetY($fila9[$talonarioInd]);
            	$pdf->SetFont('Arial', 'B', 10);
            	$pdf->Cell($cursoW, $cursoH, utf8_decode("II. PAGO EN LÍNEA (APLICACIÓN O PORTAL WEB BANCARIO):"), 0, 0);

            	$pdf->SetY($fila10[$talonarioInd]);
            	$pdf->SetFont('Arial', 'B', 9);
            	$pdf->Cell($cursoW, $cursoH, "A) SI PAGA DE BBVA A BBVA (DESDE SU PORTAL BANCARIO BBVA), UTILICE PAGO DE SERVICIO CON EL CONVENIO {$this->convenio}", 0, 0);

            	$pdf->SetY($fila11[$talonarioInd]);
            	$pdf->SetFont('Arial', 'B', 9);
            	$pdf->Cell($cursoW, $cursoH, "B) DESDE OTRO BANCO A BBVA (SPEI), USAR LA CLABE INTERBANCARIA {$this->clabe_BBVA}", 0, 0);
            }

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    } #generatePDF.


}

// Clase auxiliar para generatePDF.

class EFEPDF extends Fpdf {

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}