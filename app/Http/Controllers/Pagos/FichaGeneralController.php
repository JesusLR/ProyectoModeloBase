<?php

namespace App\Http\Controllers\Pagos;

use Lang;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pago\StoreFichaGeneralRequest;
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
use App\Models\ConceptoReferenciaUbicacion;

use App\Http\Helpers\GenerarReferencia;



use App\Http\Helpers\Referencia;


use Codedge\Fpdf\Fpdf\Fpdf;



class FichaGeneralController extends Controller
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
        $conceptosPago = ConceptoPago::whereNotIn('conpClave', ['90', '91', '92', '93', '94', '95', '96', '97', '98'])
            ->orderBy('conpClave')->get();

        $conceptosReferencia=  DB::select("SELECT * FROM conceptosreferenciaubicacion WHERE depClave is not null");

        return View('pagos.ficha_general.create', [
            "conceptosPago" => $conceptosPago,
            "conceptosReferencia" => $conceptosReferencia,
        ]);
    }

    public function obtenerReferenciaConcepto(Request $request)
    {
        $conpRefClave = $request->conpRefClave;
        $conceptoReferencia = ConceptoReferenciaUbicacion::where("conpClave", "=", $conpRefClave)->first();

        return $conceptoReferencia ? $conceptoReferencia->toJson(): collect([])->toJson();
    }

    public function obtenerCuotaConcepto(Request $request)
    {
        $cuoConcepto = $request->cuoConcepto;
        $conceptoPago = ConceptoPago::where("conpClave", "=", $cuoConcepto)->first();

        return $conceptoPago ? $conceptoPago->toJson(): collect([])->toJson();
    }

    public function check($aluClave, $cuoConcepto, $cuoAnio)
    {
        if($cuoConcepto == '84' || $cuoConcepto == '86') {
            $curso = Curso::with("alumno.persona", "periodo", "cgt.plan.programa.escuela.departamento.ubicacion")
            ->whereHas('alumno', function($query) use ($aluClave) {
                $query->where('aluClave', $aluClave);
            })
            ->whereHas('periodo', function($query) use ($cuoAnio) {
                $query->where('perAnioPago', $cuoAnio);
            })
            ->get()->sortBy("periodo.perAnio")->last();
            return response()->json([
                'warning' => $curso->alumno->aluEstado != 'E'
            ]);
        }
        return response()->json([
            'warning' => false
        ]);
    }

    public function store(StoreFichaGeneralRequest $request)
    {

        // $bancoSeleccionado = $request->banco;
        //$conReferenciaPagoSeleccionado = $request->conReferenciaPago;
        $aluClave         = $request->aluClave;
        $cuoAnio          = $request->cuoAnio;
        $concepto         = $request->cuoConcepto;
        $cuotaAnio          = $request->cuoAnio;
        $cuotaConcepto         = $request->cuoConcepto;

        $fechaVencimiento = Carbon::parse($request->cuoFechaVenc);
        $fechaVencimientoPago = $fechaVencimiento;

        $fechaFormato = $fechaVencimiento;
        $fechaFormatoSql = Carbon::parse($fechaFormato)->format("Y-m-d");

        $fechaVencimientoPago = $fechaVencimiento->day . "/" . Utils::num_meses_corto_string($fechaVencimiento->month) . "/" . $fechaVencimiento->year;

        $fechaVencimientoFicha = $fechaVencimiento->addDays(1);
        $fechaVencimientoFicha = $fechaVencimiento->day . "/" . Utils::num_meses_corto_string($fechaVencimiento->month) . "/" . $fechaVencimiento->year;

        if(in_array($concepto, ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '99'])) {
            //datos del Alumno y método de pago
            $perNumeros = self::definirPerNumerosABuscar($concepto);
            $curso = self::buscarCurso($request, $perNumeros);
            //Si no lo encuentra a la primera, intenta buscar curso con el periodo anterior.
            if(!$curso) {
                $perNumeros = self::definirPerNumerosABuscar($concepto, true);
                $curso = self::buscarCurso($request, $perNumeros);
            }
        } else {
            $curso = self::buscarCurso($request);
        }

        if (!$curso) {
            alert()->error('Error...', "No existe curso para este alumno")->showConfirmButton();
            return back()->withInput();
        }


        $clave_pago = $curso->alumno->aluClave;
        $perAnio = $curso->cgt->periodo->perAnio;
        //$perAnioPago = $curso->periodo->perAnioPago;
        $alumno_id = $curso->alumno->id;
        $programa_id = $curso->cgt->plan->programa->id;

        //INSCRIPCION SIEMPRE VA POR LA CUOTA ACTUAL
        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $departamentoId = $curso->cgt->plan->programa->escuela->departamento->id;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escuelaId = $curso->cgt->plan->programa->escuela->id;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $programaId = $curso->cgt->plan->programa->id;
        $perAnioPago = $curso->periodo->perAnioPago;

        $cuotaDep  = Cuota::where([['cuoTipo', 'D'], ['dep_esc_prog_id', $departamentoId], ['cuoAnio', $perAnioPago]])->first();
        $cuotaEsc  = Cuota::where([['cuoTipo', 'E'], ['dep_esc_prog_id', $escuelaId], ['cuoAnio', $perAnioPago]])->first();
        $cuotaProg = Cuota::where([['cuoTipo', 'P'], ['dep_esc_prog_id', $programaId], ['cuoAnio', $perAnioPago]])->first();

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

        $conpRefClaveArray =  DB::select("SELECT DISTINCT conpRefClave FROM conceptosreferenciaubicacion WHERE ubiClave = '".
            $ubiClave."' AND depClave = '". $depClave ."' AND escClave = '". $escClave ."'");
        //dd($conpRefClave);
        //
        $conpRefClave =  $conpRefClaveArray[0]->conpRefClave;

        // if ($bancoSeleccionado == "BBVA") {
            $generarReferencia = new GenerarReferencia;
            $importeRef = sprintf("%0.2f",$request->importeNormal);

            $refNumBBVA = $generarReferencia->generarRegistroReferenciaBBVA(
                $alumno_id, $programa_id, $cuotaAnio,
                $cuotaConcepto, $fechaFormatoSql, $importeRef, null,
                null, null, null, null, null,
                null, "P");
            $referenciaBBVA = $generarReferencia->crearBBVA($conceptoRef,$fechaFormatoSql, $importeRef,
                $conpRefClave, $refNumBBVA);

            //$referencia = $generarReferencia->crear($conceptoRef, $fechaFormatoSql, $importeRef);
        // }
        // if ($bancoSeleccionado == "HSBC") {
            // $generarReferencia = new GenerarReferencia;
            // $importeRef = sprintf("%0.2f",$request->importeNormal);
            $refNumHSBC = $generarReferencia->generarRegistroReferenciaHSBC(
                $alumno_id, $programa_id, $cuotaAnio,
                $cuotaConcepto, $fechaFormatoSql, $importeRef, null,
                null, null, null, null, null,
                null, "P");
            $referenciaHSBC = $generarReferencia->crearHSBC($conceptoRef, $fechaFormatoSql, $importeRef,
                $conpRefClave, $refNumHSBC);
        // }


        $ficha['clave_pago']       = $clave_pago;
        $ficha['nombreAlumno']     = $curso->alumno->persona->perApellido1 . " " . $curso->alumno->persona->perApellido2 . " " . $curso->alumno->persona->perNombre;
        $ficha['progNombre']       = $curso->cgt->plan->programa->progNombre;
        $ficha['gradoSemestre']    = $curso->cgt->cgtGradoSemestre;
        $ficha['ubicacion']        = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $ficha['cuoNumeroCuenta']  = "cuota->cuoNumeroCuenta";
        $ficha['cursoEscolar']     = $perAnio . "-" . ($perAnio + 1);

        $ficha['cuoNumeroCuenta']  = sprintf("%07s\n", $cuotaActual->cuoNumeroCuenta);
        $ficha['vencimientoFicha'] = $fechaVencimientoFicha;

        $ficha['cuoImporteInscripcion1']     = Utils::convertMoney($request->importeNormal);
        $ficha['cuoFechaLimiteInscripcion1'] = $fechaVencimientoPago;
        $ficha['referencia1'] = $referenciaBBVA;
        $ficha['referencia2'] = $referenciaHSBC;


        $ficha['nomConcepto'] = strtoupper($request->nomConcepto);

        if ($concepto == "99" || $concepto == "00") {
            $ficha['nomConcepto'] = strtoupper($request->nomConcepto) . " " . $ficha['gradoSemestre'] . ' DE ' . $ficha['progNombre'];
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
            "fhcRef1"         => $referenciaBBVA,
            "fhcRef2"         => $referenciaHSBC,
            "fchEstado"       => "P"
        ]);

        return $this->generatePDF($ficha);

        // if ($bancoSeleccionado == "BBVA") {
        //     return $this->generatePDF_BBVA($ficha);
        // }

        // if ($bancoSeleccionado == "HSBC") {
        //     return $this->generatePDF_HSBC($ficha);
        // }

    }

    private static function buscarCurso($request, $perNumeros = []) {

        return Curso::with("alumno.persona", "periodo", "cgt.plan.programa.escuela.departamento.ubicacion")
            ->whereHas('alumno', function($query) use ($request) {
                $query->where('aluClave', $request->aluClave);
            })
            ->whereHas('periodo', function($query) use ($request, $perNumeros) {
                $query->where('perAnioPago', $request->cuoAnio);
                if(!empty($perNumeros))
                    $query->whereIn('perNumero', $perNumeros);
            })
        ->get()->sortBy("periodo.perAnio")->last();
    }

    private static function definirPerNumerosABuscar($concepto, $buscarPeriodosPrevios = false) {
        $conceptosPeriodo_0_1_4 = ['00', '06', '07', '08'];
        $conceptosPeriodo_0_3_6 = ['99', '01', '02', '03', '04', '05'];
        $conceptosPeriodo_0_1_5 = ['09', '10', '11', '12'];

        if(in_array($concepto, $conceptosPeriodo_0_1_4)) {

            return $buscarPeriodosPrevios ? [0, 3, 6] : [0, 1, 4];
        }else if (in_array($concepto, $conceptosPeriodo_0_3_6)) {

            return [0, 3, 6];
        }else if(in_array($concepto, $conceptosPeriodo_0_1_5)) {

            return $buscarPeriodosPrevios ? [0, 1, 3, 4, 6] : [0, 1, 5];
        } else {
            return [100];
        }
    }

    public function obtenerAnualidadImporte($aluClaves, $cuoAnio)
    {
        $perNumeros = [];

        $curso = Curso::with("alumno.persona", "periodo", "cgt.plan.programa.escuela.departamento.ubicacion")
            ->whereHas('alumno', function($query) use ($aluClaves, $cuoAnio) {
                $query->where('aluClave', $aluClaves);
            })
            ->whereHas('periodo', function($query) use ($cuoAnio, $perNumeros) {
                $query->where('perAnioPago', $cuoAnio);
                if(!empty($perNumeros))
                    $query->whereIn('perNumero', $perNumeros);
            })
            ->get()->sortBy("periodo.perAnio")->last();

        $perNumero = $curso->periodo->perNumero;
        $perAnio   = $curso->periodo->perAnio;
        $ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $depClave = $curso->cgt->plan->programa->escuela->departamento->depClave;
        $escClave = $curso->cgt->plan->programa->escuela->escClave;
        $aluClave = $curso->alumno->aluClave;
        $importeanualidad = 0.0;
        $aplicaAnualidad = 'SI';

        if (($depClave == "MAT") || ($depClave == "PRE"))
        {
            $procLibretaPago = DB::select('call procLibretaPagoCOVIDPre("'
                .$perNumero.'", "'
                .$perAnio.'", "'
                .$ubiClave.'", "'
                .$depClave.'", "'
                .$escClave.'", "", "", "", "", "", "", "", "", "", "'
                .$aluClave.'", "")');
        }
        if ($depClave == "PRI")
        {
            $procLibretaPago = DB::select('call procLibretaPagoCOVIDPri("'
                .$perNumero.'", "'
                .$perAnio.'", "'
                .$ubiClave.'", "'
                .$depClave.'", "'
                .$escClave.'", "", "", "", "", "", "", "", "", "", "'
                .$aluClave.'", "")');
        }

        if ($depClave == "SEC")
        {
            $procLibretaPago = DB::select('call procLibretaPagoCOVIDSec("'
                .$perNumero.'", "'
                .$perAnio.'", "'
                .$ubiClave.'", "'
                .$depClave.'", "'
                .$escClave.'", "", "", "", "", "", "", "", "", "", "'
                .$aluClave.'", "")');
        }

        if ($depClave == "SUP" || $depClave == "POS")
        {
            $procLibretaPago = DB::select('call procLibretaPagoCOVID("'
                .$perNumero.'", "'
                .$perAnio.'", "'
                .$ubiClave.'", "'
                .$depClave.'", "'
                .$escClave.'", "", "", "", "", "", "", "", "", "", "'
                .$aluClave.'", "")');
        }


        $procLibretaPago = collect($procLibretaPago);

        $procLibretaPago->each(function ($item, $key) use ($curso, &$importeanualidad, &$aplicaAnualidad)
        {
            if ( $item->concepto == '00' || $item->concepto == '01' || $item->concepto == '02'
                || $item->concepto == '03' || $item->concepto == '04' || $item->concepto == '05'
                || $item->concepto == '06' || $item->concepto == '07' || $item->concepto == '08'
                || $item->concepto == '09' || $item->concepto == '10' || $item->concepto == '11'
                || $item->concepto == '12')
            {
                if($item->estado == "DEBE")
                {
                    if (!is_null($item->importe1)) {
                        $importeanualidad = $importeanualidad + doubleval($item->importe1);
                    }

                }
                else
                {
                    $aplicaAnualidad = 'NO';
                }
            }
        });

        if ($aplicaAnualidad == 'NO')
        {
            $importeanualidad = -1;
        }

        return $importeanualidad;

    }


    private function generatePDF($ficha)
    {
        //valores de celdas
        //curso escolar
        //$talonarios = ['banco', 'alumno'];
        $talonarios = ['banco'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
        //$logoY['alumno'] = 105;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['banco'] = 20;
        //$cursoY['alumno'] = 112;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['banco'] = 15;
        //$escuelaModeloY['alumno'] = 107;

        //Ficha de Deposito
        $fichaDepositoY['banco'] = 25;
        //$fichaDepositoY['alumno'] = 117;

        //alto de filas
        $filaH = 9;
        $filaMedia = 5;

        //inicio de filas
        $columna1 = 24;
        $columna2 = 69;
        $columna3 = 114;
        $columna4 = 159;
        $col1 = 24;
        $col2 = 54;
        $col3 = 84;
        $col4 = 114;
        $col5 = 144;
        //ancho de filas
        $anchoExtraCorto = 30;
        $anchoCorto = 45;
        $anchoMedioMedio = 60;
        $anchoMedio = 90;
        $anchoLargo = 135;

        //fila1
        $fila1['banco'] = 35;
        //$fila1['alumno'] = 128;

        //fila2
        $fila2['banco'] = 44;
        //$fila2['alumno'] = 137;

        //fila3
        $fila3['banco'] = 53;
        //$fila3['alumno'] = 146;

        //fila3.5
        $fila35['banco'] = 65;
        //$fila35['alumno'] = 158;

        //fila4
        $fila4['banco'] = 70;
        //$fila4['alumno'] = 163;

        //fila5
        $fila5['banco'] = 79;
        //$fila5['alumno'] = 172;

        $fila6['banco'] = 88;
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

        $pago2Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago2Importe = $ficha['cuoImporteInscripcion1'];
        $pago2Referencia = $ficha['referencia2'];

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimientoFicha'];

        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: ") . Carbon::now("CDT")->format("d/m/Y h:i");
        $pdf = new EFEPDF('P','mm','Letter');
        $pdf->SetTitle("Datos de pago SPEI | SCEM");
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
            // $pdf->SetXY($columna3, $fila1[$talonarioInd]);
            // $pdf->Cell($anchoCorto, $filaH, utf8_decode("CLABE INTERBANCARIA"), 1, 0, 'L', 1);

            //Nombre del alumno
            $pdf->SetXY($columna1, $fila2[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "Nombre del Alumno", 1, 0, 'L', 1);

            //Concepto de pago
            $pdf->SetXY($columna1, $fila3[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("Descripción"), 1, 0, 'L', 1);

            //Fecha límite
            $pdf->SetXY($col1, $fila35[$talonarioInd]);
            $pdf->Cell($anchoExtraCorto, $filaMedia, "Banco", 1, 0, 'C', 1);

            //Importe
            $pdf->SetXY($col2, $fila35[$talonarioInd]);
            $pdf->Cell($anchoExtraCorto, $filaMedia, utf8_decode("Fecha Límite"), 1, 0, 'C', 1);

            //Referencia
            $pdf->SetXY($col3, $fila35[$talonarioInd]);
            $pdf->Cell($anchoExtraCorto, $filaMedia, "Importe", 1, 0, 'C', 1);

            //Referencia
            // $pdf->SetXY($col4, $fila35[$talonarioInd]);
            // $pdf->Cell($anchoExtraCorto, $filaMedia, "Convenio", 1, 0, 'C', 1);

            //Referencia
            $pdf->SetXY($col4, $fila35[$talonarioInd]);
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
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO CON REFERENCIA BANCARIA"), 0, 0, 'C');
            $pdf->SetTextColor(0);


            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25,"" /*"BBVA"*/, 0, 0, "C");

            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            // $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            // $pdf->Cell($anchoCorto, $filaH,"012914002018521323", 1, 0, 'C');
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
            $pdf->Cell($anchoExtraCorto, $filaH, "BBVA", 1, 0,'C');
            $pdf->Cell($anchoExtraCorto, $filaH, $pago1Fecha, 1, 0,'C');
            $pdf->Cell($anchoExtraCorto, $filaH, $pago1Importe, 1, 0,'C');
            // $pdf->Cell($anchoExtraCorto, $filaH, '1852132', 1, 0,'C');
            $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1,'C');

            $pdf->SetX($columna1);
            $pdf->Cell($anchoExtraCorto, $filaH, "HSBC", 1, 0,'C');
            $pdf->Cell($anchoExtraCorto, $filaH, $pago2Fecha, 1, 0,'C');
            $pdf->Cell($anchoExtraCorto, $filaH, $pago2Importe, 1, 0,'C');
            // $pdf->Cell($anchoExtraCorto, $filaH, 'Servicio 9022', 1, 0,'C');
            $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1,'C');

            //fecha de vencimiento y fecha de impresión

            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            // $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0); // título de la invalidación
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0); // fecha de invalidación

            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

            $pdf->SetY(103);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell($anchoMedio, $filaH, "INSTRUCCIONES DE PAGO:", 0, 0);

            $pdf->SetY(110);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, "BBVA:", 0, 0);

            $pdf->SetY(115);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, "I. PAGO DIRECTO EN SUCURSAL BANCARIA BBVA:", 0, 0);

            $pdf->SetY(120);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("1-SI PAGA EN VENTANILLA O CAJERO AUTOMÁTICO DE SUCURSAL BANCARIA BBVA, SELECCIONE PAGO DE"), 0, 0);

            $pdf->SetY(125);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("    SERVICIO CON EL CONVENIO 1852132"), 0, 0);

            $pdf->SetY(135);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("II. PAGO EN LÍNEA (APLICACIÓN Ó PORTAL WEB BANCARIO):"), 0, 0);

            $pdf->SetY(140);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("A) SI PAGA DE BBVA A BBVA (DESDE SU PORTAL BANCARIO BBVA), UTILICE PAGO DE SERVICIO"), 0, 0);

            $pdf->SetY(145);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("    CON EL CONVENIO 1852132"), 0, 0);

            $pdf->SetY(155);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, "B) DESDE OTRO BANCO A BBVA (SPEI), USAR LA CLABE INTERBANCARIA 012914002018521323", 0, 0);

            $pdf->SetY(165);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, "HSBC:", 0, 0);

            $pdf->SetY(170);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoMedio, $filaH, "I. SI PAGA DE HSBC A HSBC, PAGAR COMO SERVICIO 9022", 0, 0);

            $pdf->SetY(175);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoMedio, $filaH, "II. DESDE OTRO BANCO A HSBC (SPEI), USAR LA CLABE INTERBANCARIA 021180550300090224", 0, 0);

            $pdf->SetY(185);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("NOTA: EN CUALQUIER OPERACIÓN DE PAGO DEBERÁ INGRESARSE LOS 26 DIGITOS"), 0, 0);

            $pdf->SetY(190);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("DEL CONCEPTO DE PAGO O REFERENCIA"), 0, 0);


        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    private function generatePDF_BBVA($ficha)
    {
        //valores de celdas
        //curso escolar
        //$talonarios = ['banco', 'alumno'];
        $talonarios = ['banco'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
        //$logoY['alumno'] = 105;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['banco'] = 20;
        //$cursoY['alumno'] = 112;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['banco'] = 15;
        //$escuelaModeloY['alumno'] = 107;

        //Ficha de Deposito
        $fichaDepositoY['banco'] = 25;
        //$fichaDepositoY['alumno'] = 117;

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
        //$fila1['alumno'] = 128;

        //fila2
        $fila2['banco'] = 44;
        //$fila2['alumno'] = 137;

        //fila3
        $fila3['banco'] = 53;
        //$fila3['alumno'] = 146;

        //fila3.5
        $fila35['banco'] = 65;
        //$fila35['alumno'] = 158;

        //fila4
        $fila4['banco'] = 70;
        //$fila4['alumno'] = 163;

        //fila5
        $fila5['banco'] = 79;
        //$fila5['alumno'] = 172;

        $fila6['banco'] = 88;
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
        $pdf->SetTitle("Datos de pago SPEI | SCEM");
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
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("CLABE INTERBANCARIA"), 1, 0, 'L', 1);

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
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO CON REFERENCIA BANCARIA"), 0, 0, 'C');
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
            $pdf->Cell($anchoCorto, $filaH,"012914002018521323", 1, 0, 'C');
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
            $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0,'C');
            $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0,'C');
            $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1,'C');

            $pdf->SetX($columna1);
            $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0,'C');
            $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0,'C');
            $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1,'C');

            //fecha de vencimiento y fecha de impresión

            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            // $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0); // título de la invalidación
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0); // fecha de invalidación

            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

            $pdf->SetY(103);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell($anchoMedio, $filaH, "INSTRUCCIONES DE PAGO:", 0, 0);

            $pdf->SetY(110);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, "I. PAGO DIRECTO EN SUCURSAL BANCARIA BBVA:", 0, 0);

            $pdf->SetY(115);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, "1-SI PAGA EN VENTANILLA DE SUCURSAL BANCARIA BBVA, UTILICE EL CONVENIO 1852132", 0, 0);

            $pdf->SetY(120);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("2-SI PAGA EN CAJERO AUTOMÁTICO BBVA, SELECCIONE PAGO DE SERVICIO CON EL CONVENIO 1852132"), 0, 0);

            $pdf->SetY(130);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("II. PAGO EN LÍNEA (APLICACIÓN ó PORTAL WEB BANCARIO):"), 0, 0);

            $pdf->SetY(135);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("A) SI PAGA DE BBVA A BBVA (DESDE SU PORTAL BANCARIO BBVA), UTILICE PAGO DE SERVICIO"), 0, 0);

            $pdf->SetY(140);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("    CON EL CONVENIO 1852132"), 0, 0);

            $pdf->SetY(145);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, "B) DESDE OTRO BANCO A BBVA (SPEI), USAR LA CLABE INTERBANCARIA 012914002018521323", 0, 0);


        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    private function generatePDF_HSBC($ficha)
    {
        //valores de celdas
        //curso escolar
        //$talonarios = ['banco', 'alumno'];
        $talonarios = ['banco'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
        //$logoY['alumno'] = 105;
        $logoW = 0;
        $logoH = 10;

        //Curso escolar
        $cursoX = 20;
        $cursoY['banco'] = 20;
        //$cursoY['alumno'] = 112;
        $cursoW = 180;
        $cursoH = 5;

        //Escuela Modelo
        $escuelaModeloY['banco'] = 15;
        //$escuelaModeloY['alumno'] = 107;

        //Ficha de Deposito
        $fichaDepositoY['banco'] = 25;
        //$fichaDepositoY['alumno'] = 117;

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
        //$fila1['alumno'] = 128;

        //fila2
        $fila2['banco'] = 44;
        //$fila2['alumno'] = 137;

        //fila3
        $fila3['banco'] = 53;
        //$fila3['alumno'] = 146;

        //fila3.5
        $fila35['banco'] = 65;
        //$fila35['alumno'] = 158;

        //fila4
        $fila4['banco'] = 70;
        //$fila4['alumno'] = 163;

        //fila5
        $fila5['banco'] = 79;
        //$fila5['alumno'] = 172;

        $fila6['banco'] = 88;
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
        $pdf->SetTitle("Datos de pago SPEI | SCEM");
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
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("CLABE INTERBANCARIA"), 1, 0, 'L', 1);

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
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO POR TRANSFERENCIA ELECTRÓNICA SPEI"), 0, 0, 'C');
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
            $pdf->Cell($anchoCorto, $filaH,"021180550300090224", 1, 0);
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
            // $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0); // título de la invalidación
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0); // fecha de invalidación

            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

            $pdf->SetY(100);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell($anchoMedio, $filaH, "         *** PARA PAGO EXCLUSIVO POR TRANSFERENCIA EN HSBC ***", 0, 0);

            $pdf->SetY(110);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoMedio, $filaH, "SI PAGA DE HSBC A HSBC, PAGAR COMO SERVICIO 9022", 0, 0);

            $pdf->SetY(116);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell($anchoMedio, $filaH, "DESDE OTRO BANCO A HSBC (SPEI), USAR LA CLABE INTERBANCARIA 021180550300090224", 0, 0);
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
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
