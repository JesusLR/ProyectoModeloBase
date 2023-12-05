<?php

namespace App\Http\Controllers;

use Lang;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use App\Models\ReciboPago;
use App\Models\ConceptoPago;
use App\Models\Cuota;
use App\Models\Curso;
use App\Models\User;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use DB;
use Auth;

class ReciboPagoController extends Controller
{

    public function __contruct(){
        $this->middleware('auth');
        $this->middleware('permisos:r_constancia_inscripcion');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('recibo_pago.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conceptosPago = ConceptoPago::whereNotIn('conpClave', ['90', '91', '92', '93', '94', '95', '96', '97', '98'])
            ->orderBy('conpClave')->get();

        $conceptosReferencia=  DB::select("SELECT * FROM conceptosreferenciaubicacion WHERE depClave is not null");

        return view('recibo_pago.create', [
            "conceptosPago" => $conceptosPago,
            "conceptosReferencia" => $conceptosReferencia,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bancoSeleccionado = $request->banco;
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

        


        $ficha['clave_pago']       = $clave_pago;
        $ficha['nombreAlumno']     = $curso->alumno->persona->perApellido1 . " " . $curso->alumno->persona->perApellido2 . " " . $curso->alumno->persona->perNombre;
        $ficha['progNombre']       = $curso->cgt->plan->programa->progNombre;
        $ficha['gradoSemestre']    = $curso->cgt->cgtGradoSemestre;
        $ficha['ubicacion']        = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
        $ficha['cuoNumeroCuenta']  = "cuota->cuoNumeroCuenta";
        $ficha['cursoEscolar']     = $perAnio . "-" . ($perAnio + 1);
        $ficha['cuoImporteInscripcion1']     = Utils::convertMoney($request->importeNormal);
        $ficha['cuoFechaLimiteInscripcion1'] = $fechaVencimientoPago;
        $ficha['nomConcepto'] = strtoupper($request->nomConcepto);

        $idReciboPago = ReciboPago::create([
            'alumno_id' => $alumno_id,
            'aluClave' => $aluClave,
            'conpClave' => $concepto,
            'concepto' => $request->nomConcepto,
            'importe' => $request->importeNormal,
            'fecha' =>  Carbon::now()->format("Y-m-d"),
            'hora' => Carbon::now()->format("h:i:s"),
            'reciboEstado' => 'Pagado'
        ])->id;

        $ficha['idReciboPago'] = $idReciboPago;

        $ficha['nombreCompleto'] = '';
        if(Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
            $ficha['nombreCompleto'] = $user->empleado->persona->perNombre." ".$user->empleado->persona->perApellido1." ".$user->empleado->persona->perApellido2;
        }

        return $this->generatePDF_HSBC($ficha);
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

    private function generatePDF_HSBC($ficha)
    {
        //valores de celdas
        //curso escolar
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
        // $pago1Referencia = "";

        $pago1Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago1Importe = $ficha['cuoImporteInscripcion1'];
        // $pago1Referencia = $ficha['referencia1'];

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
        // $vencimiento = $ficha['vencimientoFicha'];

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
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("FOLIO DEL RECIBO"), 1, 0, 'L', 1);

            //Nombre del alumno
            $pdf->SetXY($columna1, $fila2[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "Nombre del Alumno", 1, 0, 'L', 1);

            //Concepto de pago
            $pdf->SetXY($columna1, $fila3[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("Descripción"), 1, 0, 'L', 1);

            //Fecha límite
            $pdf->SetXY($columna1, $fila35[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaMedia, utf8_decode("Fecha"), 1, 0, 'C', 1);

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
            $pdf->Cell($cursoW, $cursoH, utf8_decode("RECIBO DE PAGO REALIZADO EN EFECTIVO"), 0, 0, 'C');
            $pdf->SetTextColor(0);


            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            // $pdf->Cell(80, -25, "HSBC", 0, 0, "C");

            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetFont('Arial','B',10);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['idReciboPago'], 1, 0);
            $pdf->SetTextColor(0);
            //nombre del alumno
            $pdf->SetFont('Arial','',10);
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
            $pdf->Cell($anchoMedio, $filaH, $ficha['nombreCompleto'], 1, 1);

            // $pdf->SetX($columna1);
            // $pdf->Cell($anchoCorto, $filaH, $pago2Fecha, 1, 0);
            // $pdf->Cell($anchoCorto, $filaH, $pago2Importe, 1, 0);
            // $pdf->Cell($anchoMedio, $filaH, $pago2Referencia, 1, 1);

            //fecha de vencimiento y fecha de impresión

            // $pdf->SetX($columna1);
            // $pdf->SetFont('Arial', '', 12);
            // $pdf->Cell($anchoMedio, $filaH, utf8_decode("Usuario que generó: ".$ficha['nombreCompleto']), 0, 0);
            // $pdf->SetFont('Arial', 'B', '10');
            // $pdf->SetX($vencimientoX);
            // $pdf->Cell($vencimientoW, $filaH, , 0, 0);

            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

            $pdf->SetY(100);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("Este recibo de pago no es válido sin el sello y firma de la persona que realizó el cobro del pago."), 0, 0);

            $pdf->SetY(106);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("En caso de que esté pago ampare una solicitud de examen o curso recuperativo tramitado"), 0, 0);

            $pdf->SetY(112);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("en el portal de alumnos, favor de presentar este comprobante de pago a la coordinación de tu"), 0, 0);

            $pdf->SetY(118);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("escuela correspondiente."), 0, 0);

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reciboPago = ReciboPago::select(
            'recibosdepago.id',
            'recibosdepago.fecha',
            'recibosdepago.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'recibosdepago.conpClave',
            'recibosdepago.importe',
            'recibosdepago.reciboEstado')
        ->join('alumnos', 'recibosdepago.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('recibosdepago.id', $id)
        ->first();

        return view('recibo_pago.show', compact('reciboPago'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reciboPago = ReciboPago::select(
            'recibosdepago.id',
            'recibosdepago.fecha',
            'recibosdepago.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'recibosdepago.conpClave',
            'recibosdepago.importe',
            'recibosdepago.reciboEstado')
        ->join('alumnos', 'recibosdepago.alumno_id', '=', 'alumnos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->where('recibosdepago.id', $id)
        ->first();

        return view('recibo_pago.edit', compact('reciboPago'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reciboPago = ReciboPago::findOrFail($id);


        DB::beginTransaction();
        try {

            $reciboPago->update([
                'reciboEstado' => $request->reciboEstado
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit(); #TEST.
        return redirect('recibo_pago');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $reciboPago = ReciboPago::findOrFail($id);
        $reciboPago->delete();

    }

    /*
    * Envía los datos a la vista tutores.show-list.
    *
    */
    public function list()
    {
        $recibos = ReciboPago::select(
                'recibosdepago.id',
                'recibosdepago.fecha',
                'recibosdepago.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'recibosdepago.conpClave',
                'recibosdepago.importe',
                'recibosdepago.reciboEstado')
            ->join('alumnos', 'recibosdepago.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id');

        return DataTables::eloquent($recibos)
        ->addColumn('action', function (ReciboPago $recibos) {
            return '<div class="row">
                        <div class="col s1">
                        <a href="recibo_pago/'.$recibos->id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                        <i class="material-icons">visibility</i>
                        </a>
                        </div>
                        <div class="col s1">
                        <a href="recibo_pago/'.$recibos->id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        </div>
                    </div>';
        })
        ->toJson();

    }

}
