<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use Carbon\Carbon;
use App\Models\Curso;
use App\Models\Estado;
use App\Models\Ubicacion;
use App\Models\Alumno;
use App\Models\Persona;
use App\Models\Bachiller\Bachiller_pago_certificado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Validator;

class BachillerPagoCertificadoController extends Controller
{
    use Exportable;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bachiller.certificados.show-list');
    }

    public function list()
    {
        $bachiller_pago_certificado = Bachiller_pago_certificado::select(
            'bachiller_pago_certificado.id',
            'bachiller_pago_certificado.curso_id',
            'bachiller_pago_certificado.concepto_pago',
            'bachiller_pago_certificado.monto_pago',
            'bachiller_pago_certificado.fecha_pago',
            'bachiller_pago_certificado.estatus_pago',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.depClave',
            'departamentos.depNombre'
        )
            ->join('cursos', 'bachiller_pago_certificado.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id');



        return DataTables::of($bachiller_pago_certificado)
            ->filterColumn('numero_periodo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('numero_periodo', function ($query) {
                return $query->perNumero;
            })

            ->filterColumn('anio_periodo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('anio_periodo', function ($query) {
                return $query->perAnio;
            })

            ->filterColumn('apellido1', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido1) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido1', function ($query) {
                return $query->perApellido1;
            })

            ->filterColumn('apellido2', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perApellido2) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('apellido2', function ($query) {
                return $query->perApellido2;
            })

            ->filterColumn('nombre_alumno', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre_alumno', function ($query) {
                return $query->perNombre;
            })

            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiClave;
            })

            ->filterColumn('departamento', function ($query, $keyword) {
                $query->whereRaw("CONCAT(depClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('departamento', function ($query) {
                return $query->depClave;
            })

            ->filterColumn('clave_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_pago', function ($query) {
                return $query->aluClave;
            })

            ->filterColumn('date_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(fecha_pago) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('date_pago', function ($query) {
                return Utils::fecha_string($query->fecha_pago, $query->fecha_pago);
            })

            ->addColumn('action', function ($query) {

                $btnEditar = "";
                $btnEliminar = "";
                $btnPDF = "";

                $ubicacion = Auth::user()->empleado->escuela->departamento->ubicacion->ubiClave;
                // $sistemas = Auth::user()->departamento_sistemas;

                if ($ubicacion == $query->ubiClave) {
                    $btnEditar = '<a href="/bachiller_pago_certificado/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>';

                    $btnEliminar = '<form id="delete_' . $query->id . '" action="bachiller_pago_certificado/' . $query->id . '" method="POST" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>';

                    $btnPDF = '<a href="/bachiller_pago_certificado/imprimir/' . $query->id . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Generar Recibo">
                    <i class="material-icons">picture_as_pdf</i>
                    </a>';
                }

                return '<a href="/bachiller_pago_certificado/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                </a>'
                    . $btnEditar
                    . $btnPDF
                    . $btnEliminar;
            })
            ->make(true);
    }

    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

        return view('bachiller.certificados.create', [
            "ubicaciones" => $ubicaciones,
            "fechaActual" => $fechaActual->format('Y-m-d')
        ]);
    }

    public function getAlumnosCurso(Request $request, $periodo_id, $plan_id)
    {
        if($request->ajax()){

            $cursos = Curso::select(
                'cursos.id',
                'alumnos.aluClave',
                'personas.id as persona_id',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre'
            )
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->where('periodos.id', $periodo_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.cgtGradoSemestre', 6)
            ->where('cursos.curEstado', '!=', 'B')
            ->whereNull('periodos.deleted_at')
            ->whereNull('cgt.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->orderBy('personas.perApellido1', 'ASC')
            ->orderBy('personas.perApellido2', 'ASC')
            ->orderBy('personas.perNombre', 'ASC')
            ->get();

            return response()->json($cursos);

        }

    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'curso_id'               => 'required',
                'periodo_id'                 => 'required',
            ],
            [
                'curso_id.required' => "Seleccione a un alumno",
            ]

        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {


            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $bachiller_pago_certificado = Bachiller_pago_certificado::create([
                'curso_id'               => $request->curso_id,
                'concepto_pago'          => $request->concepto_pago,
                'monto_pago'             => $request->monto_pago,
                'fecha_pago'             => $request->fecha_pago,
                'estatus_pago'           => 'PAGADO'
            ]);


            // retornamos a la view para obtener el id nuevo 
            session()->flash('msg', $bachiller_pago_certificado->id);
            return redirect()->back()->with('success', 'El registro de pago de certificado se ha creado con éxito');


        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];


            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
    }

    public function edit($id)
    {
        $bachiller_pago_certificado = Bachiller_pago_certificado::select(
            'bachiller_pago_certificado.id',
            'bachiller_pago_certificado.curso_id',
            'bachiller_pago_certificado.concepto_pago',
            'bachiller_pago_certificado.monto_pago',
            'bachiller_pago_certificado.fecha_pago',
            'bachiller_pago_certificado.estatus_pago',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
            ->join('cursos', 'bachiller_pago_certificado.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->first();

        return view('bachiller.certificados.edit', [
            "bachiller_pago_certificado" => $bachiller_pago_certificado
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'curso_id'               => 'required',
                'periodo_id'             => 'required',
                'fecha_pago'             => 'required',
            ],
            [
                'fecha_pago.require' => "La fecha de pago es obligatorio",
            ]

        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {

            $bachiller_pago_certificado = Bachiller_pago_certificado::find($id);

            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            $bachiller_pago_certificado->update([
                'curso_id'               => $request->curso_id,
                'concepto_pago'          => $request->concepto_pago,
                'monto_pago'             => $request->monto_pago,
                'fecha_pago'             => $fechaActual->format('Y-m-d'),
                'estatus_pago'           => 'PAGADO'
            ]);



            alert('Escuela Modelo', 'El registro de pago de certificado se ha actualizado con éxito', 'success')->showConfirmButton();
            return back();

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];


            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $bachiller_pago_certificado = Bachiller_pago_certificado::select(
            'bachiller_pago_certificado.id',
            'bachiller_pago_certificado.curso_id',
            'bachiller_pago_certificado.concepto_pago',
            'bachiller_pago_certificado.monto_pago',
            'bachiller_pago_certificado.fecha_pago',
            'bachiller_pago_certificado.estatus_pago',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'periodos.id as periodo_id',
            'periodos.perNumero',
            'periodos.perAnio',
            'periodos.perAnioPago',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
            ->join('cursos', 'bachiller_pago_certificado.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->first();

        return view('bachiller.certificados.show', [
            "bachiller_pago_certificado" => $bachiller_pago_certificado
        ]);
    }

    public function destroy($id)
    {
        $bachiller_pago_certificado = Bachiller_pago_certificado::findOrFail($id);


        try {

            if ($bachiller_pago_certificado->delete()) {

                alert('Escuela Modelo', 'El pago de certificado se ha eliminado con éxito', 'success')->showConfirmButton();

            } else {

                alert()->error('Error...', 'No se puedo eliminar el pago de certificado la evidencia materia')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }

        return redirect()->back();
    }

    public function imprimir(Request $request)
    {

        if ($request->ajax()) {
            

            $nuevo_id = $request->input("nuevo_id");

            return response()->json([
                'res' => $nuevo_id                
            ]);

            
                    
        }


    }

    // se ejecuta desde scritp en la view create 
    public function imprimir2($id)
    {            
        
        $bachiller_pago_certificado = bachiller_pago_certificado::find($id);
        $curso = Curso::find($bachiller_pago_certificado->curso_id);
        $alumno = Alumno::find($curso->alumno_id);
        $persona = Persona::find($alumno->persona_id);


        $fechaActual = Carbon::now('America/Merida');


        $parametro_NombreArchivo = "pdf_bachiller_certificado";





        // view('reportes.pdf.bachiller.certificado.pdf_bachiller_certificado');
        $pdf = PDF::loadView('reportes.pdf.bachiller.certificado.' . $parametro_NombreArchivo, [
            'bachiller_pago_certificado' => $bachiller_pago_certificado,
            'alumno' => $alumno,
            'persona' => $persona,
            'fecha_pago' => Utils::fecha_string($bachiller_pago_certificado->fecha_pago)
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '_'.$alumno->aluClave. '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}
