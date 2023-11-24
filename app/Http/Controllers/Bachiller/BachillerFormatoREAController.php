<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Cgt;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use Exception;
use Carbon\Carbon;

class BachillerFormatoREAController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bachiller.CGT.show-list');
    }

    /**
     * Show user list.
     *
     */
    public function list()
    {
        $cgts = Cgt::select('cgt.id as cgt_id','cgt.cgtGradoSemestre','cgt.cgtGrupo','cgt.cgtTurno',
            'periodos.perNumero','periodos.perAnio','planes.planClave','programas.progNombre',
            'escuelas.escNombre','departamentos.depNombre','ubicacion.ubiNombre')
        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('departamentos.depClave', 'BAC');

        

        return DataTables::of($cgts)->addColumn('action',function($query) {

            $btnCambioMatricula = "";
            $btnEditar = "";
            $btnBorrar = "";
            

            $departamento_control_escolar = Auth::user()->departamento_control_escolar;
            $departamento_sistemas = Auth::user()->departamento_sistemas;


            if($departamento_control_escolar == 1 || $departamento_sistemas == 1){
                
                $btnCambioMatricula = '<a href="bachiller_cambiar_matriculas_cgt/'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect" title="Cambiar matrículas de alumnos">
                    <i class="material-icons">supervisor_account</i>
                </a>';

                $btnEditar = '<a href="bachiller_cgt/'.$query->cgt_id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>';

                $btnBorrar = '<form id="delete_'.$query->cgt_id.'" action="bachiller_cgt/'.$query->cgt_id.'" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <a href="#" data-id="'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            }else{
                $btnCambioMatricula = "";
                $btnEditar = "";
                $btnBorrar = "";
            }


            

            return '
            '.$btnCambioMatricula.'
            <a href="bachiller_cgt/'.$query->cgt_id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                <i class="material-icons">visibility</i>
            </a>
            
            '.$btnEditar
            .$btnBorrar.'
            ';
        }) ->make(true);
    }

    public function getCgts(Request $request, $plan_id,$periodo_id)
    {
        if ($request->ajax()) {
            $cgts = Cgt::where([
                ['plan_id', $plan_id],
                ['periodo_id', $periodo_id]
            ])
            ->orderBy('cgtGradoSemestre', 'ASC')
            ->orderBy('cgtGrupo', 'ASC')
            ->get();
            return response()->json($cgts);
        }
    }
     /**
     * Show cgts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCgtsSinN(Request $request, $plan_id,$periodo_id)
    {
        if ($request->ajax()) {
            $cgts = Cgt::where([
                ['plan_id', $plan_id],
                ['periodo_id', $periodo_id],
                ['cgtGrupo', '!=', 'N']
            ])
            ->orderBy('cgtGradoSemestre', 'ASC')
            ->orderBy('cgtGrupo', 'ASC')
            ->get();
            return response()->json($cgts);
        }
    }


    /**
     * Show cgts semestre.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCgtsSemestre(Request $request, $plan, $periodo, $semestre)
    {
        if($request->ajax()){
            $grupos = Bachiller_grupos::with('bachiller_materia', 'bachiller_empleado')
                ->where([
                    ['plan_id', '=', $plan],
                    ['periodo_id', '=', $periodo],
                    ['gpoSemestre', '=', $semestre]
                ])
            ->get();

            return response()->json($grupos);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();
        $empleados = Bachiller_empleados::get();

        return view('bachiller.formatos.create', [
            'ubicaciones' => $ubicaciones,
            'empleados' => $empleados
        ]);
    }

    public function reporteREA(Request $request)
    {
        $periodo = Periodo::where('id', $request->periodo_id)->first();
        $ubicacion = Ubicacion::where('id', $request->ubicacion_id)->first();
        $programa = Programa::where('id', $request->programa_id)->first();
        
        $rows =  DB::select("call procBachillerFormatoREA(".$periodo->perNumero.", ".$periodo->perAnio.", '".$ubicacion->ubiClave."', '".$programa->progClave."', '".$request->cgtGradoSemestre."', '".$request->cgtGrupo."')");
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle('Hoja1');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(8.43);
        $sheet->getColumnDimension('B')->setWidth(24.43);
        $sheet->getColumnDimension('C')->setWidth(17);
        $sheet->getColumnDimension('D')->setWidth(27);
        $sheet->getColumnDimension('E')->setWidth(8.43);
        $sheet->getColumnDimension('F')->setWidth(8.43);
        $sheet->getColumnDimension('G')->setWidth(8.43);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(19.71);
        $sheet->getColumnDimension('J')->setWidth(12.43);
        $sheet->getColumnDimension('K')->setWidth(10.29);

        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial Narrow')->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('A1', 'Clave:');

        $sheet->getStyle('B1')->getFont()->setName('Arial Narrow')->setSize(10);
        // $sheet->setCellValue('B1', '0031');
        $sheet->setCellValueExplicit("B1", '0031', DataType::TYPE_NUMERIC);

        $sheet->getStyle('C1')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->mergeCells('C1:D1');
        $sheet->setCellValue('C1', '* Se deben capturar los 4 dígitos de la clave de la escuela');

        $sheet->getStyle('I1')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('I1')->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('I1', 'Curso Escolar:');

        $sheet->getStyle('J1')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('J1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('J1:K1');
        $sheet->setCellValue('J1', '2020-2021');

        $sheet->getStyle('A2')->getFont()->setBold(true)->setName('Arial Narrow')->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('A2', 'Escuela:');

        $sheet->getStyle('B2')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->mergeCells('B2:G2');
        $sheet->setCellValue('B2', 'Preparatoria "Escuela Modelo"');

        $sheet->getStyle('I2')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('I2')->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('I2', 'Fecha:');

        $sheet->getStyle('J2')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('J2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('J2:K2');
        $sheet->setCellValue('J2', Carbon::now()->format('d/m/Y'));

        $sheet->getStyle('A4:k4')->getFont()->setBold(true)->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('A4:k4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4:K4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->setCellValueByColumnAndRow(1, 4, 'Matrícula');
        $sheet->setCellValueByColumnAndRow(2, 4, 'Primer apellido');
        $sheet->setCellValueByColumnAndRow(3, 4, 'Segundo apellido');
        $sheet->setCellValueByColumnAndRow(4, 4, 'Nombres');
        $sheet->setCellValueByColumnAndRow(5, 4, 'Curso');
        $sheet->setCellValueByColumnAndRow(6, 4, 'Gpo');
        $sheet->setCellValueByColumnAndRow(7, 4, 'Turno');
        $sheet->setCellValueByColumnAndRow(8, 4, 'Fecha_Nacimiento');
        $sheet->setCellValueByColumnAndRow(9, 4, 'CURP');
        $sheet->setCellValueByColumnAndRow(10, 4, 'Sexo');
        $sheet->setCellValue('K4', "Presenta\nMEPT");
        $sheet->getStyle('K4')->getAlignment()->setWrapText(true);
        // $sheet->setCellValueByColumnAndRow(11, 4, 'Presenta'.PHP_EOL.'MEPT');

        $fila = 5;
        foreach($rows as $row) {
            $sheet->getStyle("A$fila:k$fila")->getFont()->setName('Arial Narrow')->setSize(10);
            $sheet->getStyle("E$fila:H$fila")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("J$fila:k$fila")->getAlignment()->setHorizontal('center');
            $sheet->setCellValueExplicit("A{$fila}", $row->Matricula, $row->Matricula == '' ? DataType::TYPE_STRING: DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit("B{$fila}", $row->perApellido1, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$fila}", $row->perApellido2, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $row->perNombre, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E{$fila}", $row->grado, DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit("F{$fila}", $row->Gpo, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("G{$fila}", $row->turno, DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit("H{$fila}", $row->fechaNac, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("I{$fila}", $row->perCurp, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J{$fila}", $row->perSexo, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("K{$fila}", $row->presenta, DataType::TYPE_STRING);
            $fila++;
        }

        $fileName = 'REA Escuela Modelo 2020-2021';
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path($fileName.'.xlsx'));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path($fileName.'.xlsx'))->deleteFileAfterSend(true);
    }

    public function reporteGBU(Request $request)
    {
        $periodo = Periodo::where('id', $request->periodo_id)->first();
        $ubicacion = Ubicacion::where('id', $request->ubicacion_id)->first();
        $programa = Programa::where('id', $request->programa_id)->first();
        
        $rows =  DB::select("call procBachillerFormatoREA(".$periodo->perNumero.", ".$periodo->perAnio.", '".$ubicacion->ubiClave."', '".$programa->progClave."', '".$request->cgtGradoSemestre."', '".$request->cgtGrupo."')");
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle('Calificaciones');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(8.43);
        $sheet->getColumnDimension('B')->setWidth(24.43);
        $sheet->getColumnDimension('C')->setWidth(17);
        $sheet->getColumnDimension('D')->setWidth(27);
        $sheet->getColumnDimension('E')->setWidth(8.43);
        $sheet->getColumnDimension('F')->setWidth(8.43);
        $sheet->getColumnDimension('G')->setWidth(8.43);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(12.43);
        $sheet->getColumnDimension('K')->setWidth(10.29);

        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial Narrow')->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('A1', 'Clave:');

        $sheet->getStyle('B1')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->setCellValue('B1', '0031');

        $sheet->getStyle('A2')->getFont()->setBold(true)->setName('Arial Narrow')->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('A2', 'Escuela:');

        $sheet->getStyle('B2')->getFont()->setName('Arial Narrow')->setSize(10);
        $sheet->mergeCells('B2:I2');
        $sheet->setCellValue('B2', 'Escuela Modelo');

        $sheet->getStyle('A4:k4')->getFont()->setBold(true)->setName('Arial Narrow')->setSize(10);
        $sheet->getStyle('A4:k4')->getAlignment()->setHorizontal('center');

        $sheet->setCellValueByColumnAndRow(1, 4, 'Matrícula');
        $sheet->setCellValueByColumnAndRow(2, 4, 'Primer apellido');
        $sheet->setCellValueByColumnAndRow(3, 4, 'Segundo apellido');
        $sheet->setCellValueByColumnAndRow(4, 4, 'Nombres');
        $sheet->setCellValueByColumnAndRow(5, 4, 'Curso');
        $sheet->setCellValueByColumnAndRow(6, 4, 'Gpo');
        $sheet->setCellValueByColumnAndRow(7, 4, 'Turno');
        $sheet->setCellValueByColumnAndRow(8, 4, 'TipoEvaluacion');
        $sheet->setCellValueByColumnAndRow(9, 4, 'Clave_Asig');
        $sheet->setCellValueByColumnAndRow(10, 4, 'Fecha_EvalP');
        $sheet->setCellValueByColumnAndRow(11, 4, 'Calif_Final');

        $fila = 5;
        foreach($rows as $row) {
            $sheet->setCellValueExplicit("A{$fila}", $row->Matricula, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B{$fila}", $row->perApellido1, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$fila}", $row->perApellido2, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $row->perNombre, DataType::TYPE_STRING);
            $fila++;
        }

        $fileName = '0031_Escuela Modelo - BGU Resultados 2021[39]';
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save(storage_path($fileName.'.xlsx'));
        } catch (Exception $e) {
            alert('Ha ocurrido un problema', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return response()->download(storage_path($fileName.'.xlsx'))->deleteFileAfterSend(true);
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
        $validator = Validator::make($request->all(),
            [
                'plan_id' => 'required|unique:cgt,plan_id,NULL,id,periodo_id,' . $request->input('periodo_id')
                    . ',cgtGradoSemestre,' . $request->input('cgtGradoSemestre') . ',cgtGrupo,' . $request->input('cgtGrupo')
                    . ',cgtTurno,'.$request->input('cgtTurno').',deleted_at,NULL',
                'periodo_id' => 'required',
                'cgtGradoSemestre' => 'required',
                'cgtGrupo'  => 'required|max:3',
            ],
            [
                'plan_id.unique' => "El cgt ya existe",
            ]
        );

        if ($validator->fails()) {
            if($request->ajax()) {
                return response()->json($validator->errors(), 400);
            }else {
                return redirect ('bachiller_cgt/create')->withErrors($validator)->withInput();
            }
        } 
        
        $programa_id = $request->input('programa_id');
        if (Utils::validaPermiso('cgt',$programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect()->to('bachiller_cgt/create');
        }


        //control estados 
        $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=", $request->periodo_id)->where("fecha1", "=", 1)->first();
        if ($existeRestriccion) {
            return json_encode([
                "error" => "true",
                "errorMsg" => "Por el momento, el módulo se encuentra deshabilitado para este período."
            ]);

        }


        try {
            $cgt = Cgt::create([
                'plan_id'           => $request->input('plan_id'),
                'periodo_id'        => $request->input('periodo_id'),
                'cgtGradoSemestre'  => $request->input('cgtGradoSemestre'),
                'cgtGrupo'          => $request->input('cgtGrupo'),
                'cgtTurno'          => $request->input('cgtTurno'),
                'cgtDescripcion'    => $request->input('cgtDescripcion'),
                'cgtCupo'           => Utils::validaEmpty($request->input('cgtCupo')),
                'empleado_id'       => 0,
                'cgtEstado'         => 'A'
            ]);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            if($request->ajax()) {
                return response()->json([$errorCode, $errorMessage],400);
            }else{     
                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('bachiller_cgt/create')->withInput();
            }
        }

        if($request->ajax()) {
            return json_encode($cgt);
        }else{
            return redirect('bachiller_cgt/create');
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
        $cgt = Cgt::select('cgt.id as cgt_id','cgt.cgtGradoSemestre','cgt.cgtGrupo','cgt.cgtTurno',
        'periodos.perNumero','periodos.perAnio','planes.planClave','programas.progNombre',
        'escuelas.escNombre','departamentos.depNombre','ubicacion.ubiNombre', 'bachiller_empleados.empNombre', 'bachiller_empleados.empApellido1',
        'bachiller_empleados.empApellido2')
        ->leftJoin('bachiller_empleados', 'cgt.empleado_id', '=', 'bachiller_empleados.id')
        ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
        ->join('planes', 'cgt.plan_id', '=', 'planes.id')
        ->join('programas', 'planes.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        ->where('departamentos.depClave', 'BAC')
        ->findOrFail($id);

        

        return view('bachiller.CGT.show', [
            'cgt' => $cgt
        ]);
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
        $empleados = Bachiller_empleados::get();
        $cgt      = Cgt::with('plan', 'periodo', 'bachiller_empleado')->findOrFail($id);
        $periodos  = Periodo::where('departamento_id', $cgt->plan->programa->escuela->departamento_id)->get();
        $programas = Programa::with('bachiller_empleado', 'escuela')->where('escuela_id', $cgt->plan->programa->escuela_id)->get();
        $planes    = Plan::with('programa')->where('programa_id', $cgt->plan->programa->id)->get();



        //VALIDA PERMISOS EN EL PROGRAMA
        if (Utils::validaPermiso('cgt',$cgt->plan->programa_id)) {
            alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
            return redirect('bachiller_cgt');
        } else {
            return view('bachiller.CGT.edit', [
                'cgt' => $cgt,
                'empleados' => $empleados,
                'periodos' => $periodos,
                'programas' => $programas,
                'planes' => $planes
            ]);
        }
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
        $validator = Validator::make($request->all(),
            [
                'plan_id'           => 'required',
                'cgtGradoSemestre'  => 'required|max:6',
                'cgtGrupo'          => 'required|max:3',
                'cgtTurno'          => 'required|max:1',
                'cgtDescripcion'    => 'max:30',
                'cgtCupo'           => 'max:6'
            ]
        );


        if ($validator->fails()) {
            return redirect ('bachiller_cgt/' . $id . '/edit')->withErrors($validator)->withInput();
        } else {
            try {
                $cgt = Cgt::with('plan','periodo','bachiller_empleado')->findOrFail($id);

                if ($cgt->cgtEstado == "C") {
                    alert()->error('Ups...', 'La modificación del CGT no se encuentra inactiva')->showConfirmButton()->autoClose(5000);
                    return redirect()->back()->withInput();
                }

                $cgt->plan_id           = $request->input('plan_id');
                $cgt->periodo_id        = $request->input('periodo_id');
                $cgt->cgtGradoSemestre  = $request->input('cgtGradoSemestre');
                $cgt->cgtGrupo          = $request->input('cgtGrupo');
                $cgt->cgtTurno          = $request->input('cgtTurno');
                $cgt->cgtDescripcion    = $request->input('cgtDescripcion');
                $cgt->cgtCupo           = Utils::validaEmpty($request->input('cgtCupo'));
                $cgt->empleado_id       = 0;
                $cgt->save();

                alert('Escuela Modelo', 'El cgt se ha actualizado con éxito','success')->showConfirmButton()->autoClose(5000);
                return redirect()->back()->withInput();
            } catch (QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMessage = $e->errorInfo[2];

                alert()->error('Error...' . $errorCode, $errorMessage)->showConfirmButton();
                return redirect('bachiller_cgt/' . $id . '/edit')->withInput();
            }
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
        $cgt = Cgt::findOrFail($id);


    //control estados 
    $existeRestriccion = DB::table("control_estados")->where("periodo_id", "=",$cgt->periodo_id)->where("fecha1", "=", 1)->first();
    if ($existeRestriccion) {
        alert()->error('Ups...', "Por el momento, el módulo se encuentra deshabilitado para este período.")->showConfirmButton()->autoClose(5000);
        return redirect()->back()->withInput();
    }

        if ($cgt->cgtEstado == "C") {
            alert()->error('Ups...', 'La modificación del CGT no se encuentra inactiva')->showConfirmButton()->autoClose(5000);
            return redirect()->back()->withInput();
        }

        try {
            $programa_id = $cgt->plan->programa_id;
            if (Utils::validaPermiso('cgt',$programa_id)) {
                alert()->error('Ups...', 'Sin privilegios en el programa!')->showConfirmButton()->autoClose(5000);
                return redirect('bachiller_cgt');
            }
            if ($cgt->delete()) {
                alert('Escuela Modelo', 'El cgt se ha eliminado con éxito','success')->showConfirmButton();
            }else{
                alert()->error('Error...', 'No se puedo eliminar el cgt')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode,$errorMessage)->showConfirmButton();
        }
        return redirect('bachiller_cgt');
    }
}
