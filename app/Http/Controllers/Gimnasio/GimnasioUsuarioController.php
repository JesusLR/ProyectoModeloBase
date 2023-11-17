<?php

namespace App\Http\Controllers\Gimnasio;

use Lang;
use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\User_docente;
use App\Http\Models\Persona;
use App\Http\Models\Idiomas\Idiomas_grupos;
use App\Http\Models\Alumno;
use App\Http\Models\Pais;
use App\Http\Models\Estado;
use App\Http\Models\Idiomas\Idiomas_empleados;
use App\Http\Models\Gimnasio\Gimnasio_usuarios;
use App\Http\Models\Gimnasio\Gimnasio_tipos_usuario;
use App\Http\Models\Municipio;
use App\Http\Models\Ubicacion;
use App\Http\Models\Puesto;
use App\Http\Helpers\Utils;
use App\clases\personas\MetodosPersonas;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Models\Curso;
use App\Http\Models\Pago;
use PDF;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Helpers\GenerarReferencia;


class GimnasioUsuarioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permisos:empleado',['except' => ['index','show','list']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registroUltimoPago = Pago::where("pagFormaAplico", "=", "A")->latest()->first();
        $registroUltimoPago = Carbon::parse($registroUltimoPago->pagFechaPago)->day
        . "/" . Utils::num_meses_corto_string(Carbon::parse($registroUltimoPago->pagFechaPago)->month)
        . "/" . Carbon::parse($registroUltimoPago->pagFechaPago)->year;

        return View('gimnasio.usuarios.show-list', [
            "registroUltimoPago" => $registroUltimoPago
        ]);
    }

    /**
     * Show empleado list.
     *
     */
    public function list()
    {
        $usuarios = Gimnasio_usuarios::with('tipo')
        ->select('gimnasio_usuarios.*', 'alumnos.aluClave')
        ->leftJoin('alumnos', 'gimnasio_usuarios.alumno_id', '=', 'alumnos.id')
        ->latest('gimnasio_usuarios.created_at');

        return DataTables::eloquent($usuarios)
        ->addColumn('action', static function(Gimnasio_usuarios $usuarios) {

            $btnHistorialPagos   = "";
            if (User::permiso("alumno") == "A" || User::permiso("alumno") == "B"
                || User::permiso("alumno") == "C") {
                $btnHistorialPagos = '<a href="#modalHistorialPagosAlu" data-nombres="' . $usuarios->gimNombre . " " . $usuarios->gimApellidoPaterno . " " . $usuarios->gimApellidoMaterno .
                    '" data-aluClave="' . $usuarios->aluClave . '" data-alumno-id="'.$usuarios->alumno_id.'" class="modal-trigger btn-modal-historial-pagos button button--icon js-button js-ripple-effect" title="Historial Pagos">
                    <i class="material-icons">attach_money</i>
                </a>';
            }
            
            $url = 'gimnasio_usuario';
            if ($usuarios->aluClave) {
                $btn_generar_ficha_bbva = '<div class="col s1">
                    <form id="generar_ficha_' . $usuarios->id . '" action="gimnasio_usuario/' . $usuarios->id . '/generar_ficha" method="POST" target="_blank">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $usuarios->id . '" class="button button--icon js-button js-ripple-effect btn-generar-ficha" title="Generar ficha de pago BBVA">
                            <i class="material-icons">local_atm</i>
                        </a>
                    </form>
                </div>';
    
                $btn_generar_ficha_hsbc = '<div class="col s1">
                    <form id="generar_ficha_hsbc_' . $usuarios->id . '" action="gimnasio_usuario/' . $usuarios->id . '/generar_ficha_hsbc" method="POST" target="_blank">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $usuarios->id . '" class="button button--icon js-button js-ripple-effect btn-generar-ficha_hsbc" title="Generar ficha de pago HSBC">
                            <i class="material-icons">description</i>
                        </a>
                    </form>
                </div>';
            } else {
                $btn_generar_ficha_bbva = '';
                $btn_generar_ficha_hsbc = '';
            }

            return '<div>'
                        .Utils::btn_show($usuarios->id, $url)
                        .Utils::btn_edit($usuarios->id, $url)
                        .$btn_generar_ficha_bbva
                        .$btn_generar_ficha_hsbc
                        . $btnHistorialPagos
                   .'</div>';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = Gimnasio_tipos_usuario::where('tugVigente', 'S')->get();
        return view('gimnasio.usuarios.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alumno = $request->alumno_id ? Alumno::findOrFail($request->alumno_id) : null;

        $validator = Validator::make($request->all(),
            [
                'gimId'              => 'required',
                'gimApellidoPaterno' => 'required',
                // 'gimApellidoMaterno' => 'required',
                'gimNombre'          => 'required',
                'gimTipo'            => 'required',
                'alumno_id'          => 'unique:gimnasio_usuarios'
            ]
        );

        if ($validator->fails()) {
            return redirect ('gimnasio_usuario/create')->withErrors($validator)->withInput();
        }

        try {
            if ($request->gimId) {
                $usuario = Gimnasio_usuarios::create([
                    'id' => $request->gimId,
                    'alumno_id' => $alumno ? $alumno->id : null,
                    'gimApellidoPaterno' => $request->gimApellidoPaterno,
                    'gimApellidoMaterno' => $request->gimApellidoMaterno,
                    'gimNombre' => $request->gimNombre,
                    'gimTipo' => $request->gimTipo,
                ]);
            } else {
                $usuario = Gimnasio_usuarios::create([
                    'alumno_id' => $alumno ? $alumno->id : null,
                    'gimApellidoPaterno' => $request->gimApellidoPaterno,
                    'gimApellidoMaterno' => $request->gimApellidoMaterno,
                    'gimNombre' => $request->gimNombre,
                    'gimTipo' => $request->gimTipo,
                ]);
            }
            
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema', $e->getMessage())->showConfirmButton();
            return back()->withInput();
        }
        alert()->success('Registro exitoso!', 'El usuario ha sido registrado. Su Número de usuario es: '.$usuario->id)->showConfirmButton();
        return redirect('gimnasio_usuario');
    }

    /**
    * función para la vista de create.
    */
    public function buscar_alumno(Request $request, $aluClave) {
        $alumno = Alumno::with('persona')
        ->whereHas('persona', static function($query) use ($aluClave) {
            $query->where('aluClave', $aluClave);
        })->first();

        if($request->ajax()) {
            return response()->json($alumno);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuariogim = Gimnasio_usuarios::select('gimnasio_usuarios.id AS dimnasio_usuario_id', 'gimnasio_usuarios.*', 'gimnasio_tipos_usuario.*')
        ->join('gimnasio_tipos_usuario', 'gimnasio_usuarios.gimTipo', '=', 'gimnasio_tipos_usuario.tugClave')
        ->where('gimnasio_usuarios.id', $id)
        ->first();
        if (!$usuariogim) {
            alert('Ups!', 'Este identificador ya no existe o ha sido modificado', 'error')->showConfirmButton();
            return redirect('gimnasio_usuario');
        }
        $pago = $this->buscarPagos($id)->first();
        $gimUltimoPago = $pago ? Utils::fecha_string($pago->pagFechaPago, 'mesCorto') : '';
        return view('gimnasio.usuarios.show', compact('usuariogim', 'gimUltimoPago'));
    }

    public function buscarPagos($usuagim_id)
    {
        $clave_usuario = '99'.substr(str_repeat(0, 6).$usuagim_id, - 6);
        return Pago::with('concepto')->where('pagClaveAlu', $clave_usuario)->latest('pagFechaPago');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuariogim = Gimnasio_usuarios::select('gimnasio_usuarios.*')
        ->join('gimnasio_tipos_usuario', 'gimnasio_usuarios.gimTipo', '=', 'gimnasio_tipos_usuario.tugClave')
        ->where('gimnasio_usuarios.id', $id)
        ->first();
        if (!$usuariogim) {
            alert('Ups!', 'Este identificador ya no existe o ha sido modificado', 'error')->showConfirmButton();
            return redirect('gimnasio_usuario');
        }
        $tipos = Gimnasio_tipos_usuario::where('tugVigente', 'S')->get();
        $pago = $this->buscarPagos($id)->first();
        $gimUltimoPago = $pago ? Utils::fecha_string($pago->pagFechaPago, 'mesCorto') : '';
        return view('gimnasio.usuarios.edit', compact('tipos', 'usuariogim', 'gimUltimoPago'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $alumno = $request->alumno_id ? Alumno::findOrFail($request->alumno_id) : null;

        $validator = Validator::make($request->all(),
            [
                'gimId'              => 'required',
                'gimApellidoPaterno' => 'required',
                // 'gimApellidoMaterno' => 'required',
                'gimNombre'          => 'required',
                'gimTipo'            => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect ('gimnasio_usuario/create')->withErrors($validator)->withInput();
        }

        try {
            $usuariogim = Gimnasio_usuarios::findOrFail($id);

            $usuariogim->update([
                'id' => $request->gimId,
                'alumno_id' => $alumno ? $alumno->id : null,
                'gimApellidoPaterno' => $request->gimApellidoPaterno,
                'gimApellidoMaterno' => $request->gimApellidoMaterno,
                'gimNombre' => $request->gimNombre,
                'gimTipo' => $request->gimTipo,
            ]);

            alert('Escuela Modelo', 'El usuario se ha actualizado con éxito','success')->showConfirmButton();
            return redirect('gimnasio_usuario');
        } catch (QueryException $e) {
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();

            return redirect('gimnasio_usuario/' . $id . '/edit')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if(!auth()->user()->isAdmin('empleado')) {
            alert('Ups!', 'Sin privilegios para esta acción', 'error')->showConfirmButton();
            return back();
        // }

        $empleado = Idiomas_empleados::findOrFail($id);
        try {
            $empleado->delete();
        } catch (QueryException $e) {
            alert()->error('Ups...' . $e->errorInfo[1], $e->errorInfo[2])->showConfirmButton();
            return back();
        }

        alert('Escuela Modelo', 'El empleado se ha eliminado con éxito', 'success')->showConfirmButton();
        return redirect('idiomas_empleado');
    }


    /**
    * @param int 
    */
    public function generar_ficha($usuariogim_id)
    {
        $usuariogim = Gimnasio_usuarios::findOrFail($usuariogim_id);
        $alumno = Alumno::findOrFail($usuariogim->alumno_id);
        $clave_pago = $alumno->aluClave;
        try {
            $referencia = $this->generar_referencia($usuariogim, $clave_pago);
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema', $e->getMessage())->showConfirmButton();
            return redirect()->back();  
        }
        $fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_gimnasio_ficha_pago";

        $ficha = [
            'clave_usuario' => $usuariogim_id,
            'clave_pago' => $clave_pago,
            'curso' => 'curso', //$curso, // pendiente
            'nombreAlumno' => $this->nombreCompleto($usuariogim, true),
            'conceptoPago' => $usuariogim->tipo->tugDescripcion,
            'cuoImporteInscripcion1' => number_format($usuariogim->tipo->tugImporte, 2),
            'cuoFechaLimiteInscripcion1' => Utils::fecha_string(Carbon::now('America/Merida')->addDays(7), 'mesCorto'),
            'referencia1' => $referencia,
            'vencimiento' => Utils::fecha_string(Carbon::now('America/Merida')->addDays(8), 'mesCorto'),
            'impresion' => Utils::fecha_string(Carbon::now('America/Merida'), 'mesCorto')
        ];

        return $this->generatePDF_BBVA($ficha);
    }

    /**
    * @param int 
    */
    public function generar_ficha_hsbc($usuariogim_id)
    {
        $usuariogim = Gimnasio_usuarios::findOrFail($usuariogim_id);
        $alumno = Alumno::findOrFail($usuariogim->alumno_id);
        $clave_pago = $alumno->aluClave;
        try {
            $referencia = $this->generar_referencia($usuariogim, $clave_pago);
        } catch (Exception $e) {
            alert()->error('Ha ocurrido un problema', $e->getMessage())->showConfirmButton();
            return redirect()->back();  
        }
        $fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = "pdf_gimnasio_ficha_pago";

        $ficha = [
            'clave_usuario' => $usuariogim_id,
            'clave_pago' => $clave_pago,
            'curso' => 'curso', //$curso, // pendiente
            'nombreAlumno' => $this->nombreCompleto($usuariogim, true),
            'conceptoPago' => $usuariogim->tipo->tugDescripcion,
            'cuoImporteInscripcion1' => number_format($usuariogim->tipo->tugImporte, 2),
            'cuoFechaLimiteInscripcion1' => Utils::fecha_string(Carbon::now('America/Merida')->addDays(7), 'mesCorto'),
            'referencia1' => $referencia,
            'vencimiento' => Utils::fecha_string(Carbon::now('America/Merida')->addDays(8), 'mesCorto'),
            'impresion' => Utils::fecha_string(Carbon::now('America/Merida'), 'mesCorto')
        ];

        return $this->generatePDF_HSBC($ficha);
    }

    private function generatePDF_BBVA($ficha) {
        //valores de celdas
        //curso escolar
        $talonarios = ['banco'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
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

        //Nombre del Alumno
        $nombreC = utf8_decode($ficha['nombreAlumno']);
        $nombreC = strtoupper($nombreC);

        //concepto
        $conceptoC = "GIMNASIO $ficha[conceptoPago]";
        $conceptoC = utf8_decode($conceptoC);

        // datos para la tabla
        $pago1Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago1Importe = '$'.$ficha['cuoImporteInscripcion1'];
        $pago1Referencia = $ficha['referencia1'];

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimiento'];

        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: $ficha[impresion]");
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
            $pdf->Cell($anchoCorto, $filaH, "Clave del Usuario", 1, 0, 'L', 1);

            //convenio
            $pdf->SetXY($columna3, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("CLABE INTERBANCARIA"), 1, 0, 'L', 1);

            //Nombre del alumno
            $pdf->SetXY($columna1, $fila2[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "Nombre del Usuario", 1, 0, 'L', 1);

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
            $pdf->Cell(60, -25,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, "C");


            $pdf->SetFont('Arial','B', 12);
            // $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            // $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, 20); // $fichaDepositoY[$talonarioInd]
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO CON REFERENCIA BANCARIA"), 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "BBVA", 0, 0, "C");



            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['clave_usuario'].' - '.$ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,"012914002018521323", 1, 0, 'C');
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$nombreC, 1, 0);

            //ubicación
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,'(CME)', 1, 0, 'R');
            
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);

            $ultimaFecha = "";


            // aqui va la tabla de fecha, importe y referencia
            $pdf->SetX($columna1);
            $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0, 'C');
            $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0, 'C');
            $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1, 'C');

            $pdf->SetX($columna1);

            //fecha de vencimiento y fecha de impresión

            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0);
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0);

            $pdf->SetFont('Arial', 'I', '8');
            $pdf->Cell($impresionW, $filaH, $impresion, 0, 1);

            $pdf->SetY(93);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell($anchoMedio, $filaH, "INSTRUCCIONES DE PAGO:", 0, 0);

            $pdf->SetY(100);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, "I. PAGO DIRECTO EN SUCURSAL BANCARIA BBVA:", 0, 0);

            $pdf->SetY(105);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, "1-SI PAGA EN VENTANILLA DE SUCURSAL BANCARIA BBVA, UTILICE EL CONVENIO 1852132", 0, 0);

            $pdf->SetY(110);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("2-SI PAGA EN CAJERO AUTOMÁTICO BBVA, SELECCIONE PAGO DE SERVICIO CON EL CONVENIO 1852132"), 0, 0);

            $pdf->SetY(120);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("II. PAGO EN LÍNEA (APLICACIÓN ó PORTAL WEB BANCARIO):"), 0, 0);

            $pdf->SetY(125);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("A) SI PAGA DE BBVA A BBVA (DESDE SU PORTAL BANCARIO BBVA), UTILICE PAGO DE SERVICIO"), 0, 0);

            $pdf->SetY(130);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("    CON EL CONVENIO 1852132"), 0, 0);

            $pdf->SetY(135);
            $pdf->SetX($columna1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell($anchoMedio, $filaH, "B) DESDE OTRO BANCO A BBVA (SPEI), USAR LA CLABE INTERBANCARIA 012914002018521323", 0, 0);

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    private function generatePDF_HSBC($ficha) {
        //valores de celdas
        //curso escolar
        $talonarios = ['banco'];
        //logo de bancomer
        $logoX = 150;
        $logoY['banco'] = 12;
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

        //Nombre del Alumno
        $nombreC = utf8_decode($ficha['nombreAlumno']);
        $nombreC = strtoupper($nombreC);

        //concepto
        $conceptoC = "GIMNASIO $ficha[conceptoPago]";
        $conceptoC = utf8_decode($conceptoC);

        // datos para la tabla
        $pago1Fecha = $ficha['cuoFechaLimiteInscripcion1'];
        $pago1Importe = '$'.$ficha['cuoImporteInscripcion1'];
        $pago1Referencia = $ficha['referencia1'];

        //fecha de vencimiento
        $vencimientoX = 135;
        $vencimientoW = 25;
        $vencimiento = $ficha['vencimiento'];

        //fecha de impresión
        $impresionW = 40;
        $impresion = utf8_decode("Impreso: $ficha[impresion]");
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
            $pdf->Cell($anchoCorto, $filaH, "Clave del Usuario", 1, 0, 'L', 1);

            //convenio
            $pdf->SetXY($columna3, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, utf8_decode("CLABE INTERBANCARIA"), 1, 0, 'L', 1);

            //Nombre del alumno
            $pdf->SetXY($columna1, $fila2[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH, "Nombre del Usuario", 1, 0, 'L', 1);

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
            $pdf->Cell(60, -25,  $pdf->Image(public_path() . "/images/logo-pago.jpg", 35, $logoY[$talonarioInd], 20), 0, 0, "C");


            $pdf->SetFont('Arial','B', 12);
            // $pdf->SetXY($cursoX, $cursoY[$talonarioInd]);
            // $pdf->Cell($cursoW, $cursoH,'CURSO ESCOLAR: '.$ficha['cursoEscolar'], 0, 0,'C');

            $pdf->SetTextColor(40, 65, 110);
            $pdf->SetXY($cursoX, $escuelaModeloY[$talonarioInd]);
            $pdf->Cell($cursoW, $cursoH, "ESCUELA MODELO S.C.P.", 0, 0, 'C');
            $pdf->SetXY($cursoX, 20);
            $pdf->Cell($cursoW, $cursoH, utf8_decode("PAGO POR TRANSFERENCIA ELECTRÓNICA SPEI"), 0, 0, 'C');


            // $pdf->SetTextColor(50, 65, 110);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial','',30);
            $pdf->SetXY(140,  $fila1[$talonarioInd]);
            $pdf->Cell(80, -25, "HSBC", 0, 0, "C");



            $pdf->SetFont('Arial','',10);
            //clave de pago
            $pdf->SetXY($columna2, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,$ficha['clave_usuario'].' - '.$ficha['clave_pago'], 1, 0);
            //numero de cuenta convenio
            $pdf->SetXY($columna4, $fila1[$talonarioInd]);
            $pdf->Cell($anchoCorto, $filaH,"021180550300090224", 1, 0,'C');
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$nombreC, 1, 0);
            //nombre del alumno
            $pdf->SetXY($columna2, $fila2[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,'(CME)', 1, 0, 'R');
            //concepto de pago
            $pdf->SetXY($columna2, $fila3[$talonarioInd]);
            $pdf->Cell($anchoLargo, $filaH,$conceptoC, 1, 0);

            //importes y fechas
            $pdf->SetY($fila4[$talonarioInd]);

            $ultimaFecha = "";

            // aqui va la tabla de fecha, importe y referencia
            $pdf->SetX($columna1);
            $pdf->Cell($anchoCorto, $filaH, $pago1Fecha, 1, 0, 'C');
            $pdf->Cell($anchoCorto, $filaH, $pago1Importe, 1, 0, 'C');
            $pdf->Cell($anchoMedio, $filaH, $pago1Referencia, 1, 1, 'C');

            //fecha de vencimiento y fecha de impresión

            $pdf->SetX($columna2);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell($anchoMedio, $filaH, utf8_decode("Esta ficha se inválida a partir del:"), 0, 0);
            $pdf->SetFont('Arial', 'B', '10');
            $pdf->SetX($vencimientoX);
            // $pdf->SetX($columna2);
            $pdf->Cell($vencimientoW, $filaH, $vencimiento, 0, 0);

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

        }
        $pdf->Ln();
        $pdf->Output();
        exit;
    }

    /**
    * @param App\Http\Models\UsuaGim $usuariogim
    * @param boolean $invertido
    */
    public function nombreCompleto($usuariogim, $invertido = false): String
    {
        $nombre = $usuariogim->gimNombre;
        $apellidos = $usuariogim->gimApellidoPaterno.' '.$usuariogim->gimApellidoMaterno;

        return $invertido ? $apellidos.' '.$nombre : $nombre.' '.$apellidos;
    }

    /**
    * @param App\Http\Models\UsuaGim
    */
    public function generar_referencia($usuariogim, $clave_pago)
    {
        // $clave_pago = '99'.substr(str_repeat(0, 6).$usuariogim->id, - 6);
        $carbon_now = Carbon::now('America/Merida');
        $anio = $carbon_now->format('y');
        $mes = $carbon_now->format('m');
        $fecha = $carbon_now->addDays(7)->format('Y-m-d');
        $tugImporte = $usuariogim->tipo->tugImporte;
        $importeReferencia = number_format(ceil($tugImporte), 2, '.', '');
        // $referenciaParcial = $clave_pago.$anio.$mes;
        $referenciaParcial = $clave_pago . (sprintf("%02d", substr( $anio, -2) % 100)). '39';
        try {
            $generarReferencia = new GenerarReferencia;
            $importeRef = sprintf("%0.2f",$usuariogim->tipo->tugImporte);

            $refNum = $generarReferencia->generarRegistroReferenciaBBVA(
                $usuariogim->alumno_id,
                0,
                $anio,
                '39', 
                $fecha,
                $importeRef, 
                null,null, null, null, null, null,null, "P");
            $referencia = $generarReferencia->crearBBVA($referenciaParcial,$fecha, $importeRef,
                '07', $refNum);
        } catch (Exception $e) {
            throw new Exception("Error procesando referencia: {$e->getMessage()}", 1);
        }

        return $referencia;
    }

    public function crear($concepto, $fecha, $importe)
    {
        //separar fecha
        $arrayDate = explode('-',$fecha);
        $dia = $arrayDate[2];
        $mes = $arrayDate[1];
        $anio = $arrayDate[0];
        //valores fijos para concentrado de importe
        $fijosImporte = array (7, 3, 1);
        $fijosVerifica = array (11, 13, 17, 19, 23);

        //concentrado de fecha
        $conAnio = ($anio - 2014) * 372;
        $conMes = ($mes - 1) * 31;
        $conDia = $dia -1;
        $conFecha = $conAnio + $conMes + $conDia;
        $conFecha = sprintf ("%04d", $conFecha);

        //concentrado de importe
        $importeSeparado = explode (".", $importe);
        $importeSinPunto = $importeSeparado[0].$importeSeparado[1];
        $arregloImporte = str_split ($importeSinPunto);
        $arregloImporte = array_reverse ($arregloImporte);
        $conImporte = 0;

        foreach ($arregloImporte as $k => $v) {

        // if (!is_numeric($v) || !is_numeric($k)){
        //   dd($v, $k, gettype($v), gettype($k), $arregloImporte, $importe, $concepto);
        // }

        $conImporte += $v * $fijosImporte[$k % 3];
        }
        $conImporte = $conImporte % 10;

        //resultado final
        $referencia = $concepto .'070000'. $conFecha . $conImporte . 2; //el 2 al final es fijo
        $arregloReferencia = str_split ($referencia);
        $arregloReferencia = array_reverse ($arregloReferencia);
        $verificador = 0;


        foreach ($arregloReferencia as $k => $v) {
        $verificador += $v * $fijosVerifica[$k % 5];
        }

        $verificador = $verificador % 97;
        $verificador++;
        $verificador = sprintf ("%02d", $verificador);
        $referencia .= $verificador;

        return $referencia;
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