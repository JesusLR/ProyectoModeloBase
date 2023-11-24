<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Alumno;
use App\Models\Bachiller\Bachiller_justificacion;
use App\Models\Cgt;
use App\Models\Curso;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Persona;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use PDF;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class BachillerJustificacionesController extends Controller
{
    use Exportable;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bachiller.reportes.justificaciones.show-list');
    }


    public function list()
    {
        $bachiller_justificacion = Bachiller_justificacion::select(
            'bachiller_justificaciones.*',
            'cursos.id as curso_id',
            'alumnos.id as alumn_id',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'periodos.id as period_id',
            'periodos.perAnio',
            'periodos.perNumero',
            'departamentos.id as departament_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
            ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id');

        return DataTables::of($bachiller_justificacion)

            ->filterColumn('ubicacion', function ($query, $keyword) {
                $query->whereRaw("CONCAT(ubiClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('ubicacion', function ($query) {
                return $query->ubiClave;
            })

            ->filterColumn('numero_periodo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNumero) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('numero_periodo', function ($query) {
                return $query->perNumero;
            })

            ->filterColumn('anio', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perAnio) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('anio', function ($query) {
                return $query->perAnio;
            })

            ->filterColumn('semestre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(cgtGradoSemestre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('semestre', function ($query) {
                return $query->cgtGradoSemestre;
            })

            ->filterColumn('grupo', function ($query, $keyword) {
                $query->whereRaw("CONCAT(cgtGrupo) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('grupo', function ($query) {
                return $query->cgtGrupo;
            })

            ->filterColumn('clave_pago', function ($query, $keyword) {
                $query->whereRaw("CONCAT(aluClave) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('clave_pago', function ($query) {
                return $query->aluClave;
            })

            ->filterColumn('nombre', function ($query, $keyword) {
                $query->whereRaw("CONCAT(perNombre) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('nombre', function ($query) {
                return $query->perNombre;
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

            ->filterColumn('jusFechaSolicitud', function ($query, $keyword) {
                $query->whereRaw("CONCAT(jusFechaSolicitud) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('jusFechaSolicitud', function ($query) {
                return Utils::fecha_string($query->jusFechaSolicitud, 'fechaCorta');
            })


            ->addColumn('action', function ($query) {

                return '
                <a href="/bachiller_justificaciones/cambiar_estado/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Cambiar Estado">
                <i class="material-icons">swap_horiz</i>
                </a>
                <a href="bachiller_justificaciones/' . $query->id . '" class="button button--icon js-button js-ripple-effect" title="Ver">
                  <i class="material-icons">visibility</i>
                </a>
                <a href="bachiller_justificaciones/' . $query->id . '/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                    <i class="material-icons">edit</i>
                </a>
                <a href="reporte/bachiller_justificaciones/imprimir/' . $query->id . '" target="_blank" class="button button--icon js-button js-ripple-effect" title="Justificación" >
                    <i class="material-icons">picture_as_pdf</i>
                </a>
                <form id="delete_' . $query->id . '" action="bachiller_justificaciones/' . $query->id . '" method="POST" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a href="#" data-id="'  . $query->id . '" class="button button--icon js-button js-ripple-effect confirm-delete" title="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </form>';
            })
            ->make(true);
    }

    public function create()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.justificaciones.create', [
            "ubicaciones" => $ubicaciones
        ]);
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

            $contador = Bachiller_justificacion::where('curso_id', $request->curso_id)->whereNull('deleted_at')->count();

            // if($contador >= 3){
            //     alert()->warning('Ups...', 'El alumno ya cuenta con 3 justificaciones solicitadas')->showConfirmButton();
            //     return back()->withInput();
            // }

            $nuevo_contador = $contador + 1;

            $bachiller_pago_certificado = Bachiller_justificacion::create([
                'curso_id' => $request->curso_id,
                'jusRazonFalta' => $request->razonFalta,
                'jusFechaInicio' => $request->fechaInicio,
                'jusFechaFin' => $request->fechaFin,
                'JustNumeroJustificacion' => $nuevo_contador,
                'jusFechaSolicitud' => $fechaActual
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

    public function getAlumnosCurso(Request $request, $periodo_id, $plan_id)
    {
        if ($request->ajax()) {

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
                ->whereNull('periodos.deleted_at')
                ->whereNull('cgt.deleted_at')
                ->whereNull('planes.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->get();

            return response()->json($cursos);
        }
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

    public function imprimir2($id)
    {

        $bachiller_justificacion = Bachiller_justificacion::select(
            'bachiller_justificaciones.*',
            'cursos.id as curso_id',
            'alumnos.id as alumn_id',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'personas.perSexo',
            'periodos.id as period_id',
            'periodos.perAnio',
            'periodos.perNumero',
            'departamentos.id as departament_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'ubicacion.municipio_id',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
            ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->where('bachiller_justificaciones.id', $id)
            ->first();

        $fechaActual = Carbon::now('America/Merida');


        $nombreAlumno = $bachiller_justificacion->perApellido1 . ' ' . $bachiller_justificacion->perApellido2 . ' ' . $bachiller_justificacion->perNombre;
        $genero = $bachiller_justificacion->perSexo;
        $semestre = $bachiller_justificacion->cgtGradoSemestre;
        $grupo = $bachiller_justificacion->cgtGrupo;

        $municipio = Municipio::find($bachiller_justificacion->municipio_id);
        $estado = Estado::find($municipio->estado_id);

        if ($genero == "M") {
            $generoAlumno = "que el alumno";
        } else {
            $generoAlumno = "que la alumna";
        }

        if ($semestre == 1) {
            $semestreLetras = 'Primer';
        }

        if ($semestre == 2) {
            $semestreLetras = 'Segundo';
        }

        if ($semestre == 3) {
            $semestreLetras = 'Tercer';
        }

        if ($semestre == 4) {
            $semestreLetras = 'Cuarto';
        }

        if ($semestre == 5) {
            $semestreLetras = 'Quinto';
        }

        if ($semestre == 6) {
            $semestreLetras = 'Sexto';
        }

        $mesInicio =  \Carbon\Carbon::parse($bachiller_justificacion->jusFechaInicio)->format('m');
        $mesFin =  \Carbon\Carbon::parse($bachiller_justificacion->jusFechaFin)->format('m');

        $anioInicio =  \Carbon\Carbon::parse($bachiller_justificacion->jusFechaInicio)->format('Y');
        $anioFin =  \Carbon\Carbon::parse($bachiller_justificacion->jusFechaFin)->format('Y');


        if ($mesInicio == $mesFin) {

            if ($bachiller_justificacion->jusFechaInicio == $bachiller_justificacion->jusFechaFin) {
                $fechaFalta = "el día " . Utils::fecha_string($bachiller_justificacion->jusFechaFin);
            } else {
                $fechaFalta = "los días del " . \Carbon\Carbon::parse($bachiller_justificacion->jusFechaInicio)->format('d') . " al " . Utils::fecha_string($bachiller_justificacion->jusFechaFin);
            }
        } else {
            // los días del 30 de Agosto al 3 de Septiembre de 2022
            $fechaFalta = "los días del " . Utils::fecha_string($bachiller_justificacion->jusFechaInicio) . " al " . Utils::fecha_string($bachiller_justificacion->jusFechaFin);
        }


        if ($bachiller_justificacion->jusRazonFalta == "Enfermedad") {
            $faltopor = "enfermedad";
        } else {
            $faltopor = "motivos personales";
        }


        $fechaActual = Carbon::now('America/Merida');


        $parametro_NombreArchivo = "pdf_bachiller_justificacion";


        //     $validandoSiHayEltxt = File::exists(storage_path('app/ajustificacion' . $curso->periodo_id . '.txt'));


        //     $contador = "0";
        //     if ($validandoSiHayEltxt) {
        //         $buscarArchivo = File::get(storage_path('app/ajustificacion' . $curso->periodo_id . '.txt'));

        //         // return $buscarArchivo+1;

        //         Storage::disk('local')->put('ajustificacion' . $curso->periodo_id . '.txt', $buscarArchivo + 1);

        //         $buscarArchivoYaSumado = File::get(storage_path('app/ajustificacion' . $curso->periodo_id . '.txt'));
        //     } else {
        //         Storage::disk('local')->put('ajustificacion' . $curso->periodo_id . '.txt', '1');

        //         $buscarArchivoYaSumado = File::get(storage_path('app/ajustificacion' . $curso->periodo_id . '.txt'));
        //     }


        // view('reportes.pdf.bachiller.justificaciones.pdf_bachiller_justificacion');
        $pdf = PDF::loadView('reportes.pdf.bachiller.justificaciones.' . $parametro_NombreArchivo, [
            "nombreAlumno" => $nombreAlumno,
            "generoAlumno" => $generoAlumno,
            "semestre" => $semestreLetras,
            "grupo" => $grupo,
            "fechaFalta" => $fechaFalta,
            "faltopor" => $faltopor,
            "municipio" => $municipio->munNombre,
            "estado" => $estado->edoNombre,
            "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d')),
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }

    public function show($id)
    {

        $bachiller_justificacion = Bachiller_justificacion::select(
            'bachiller_justificaciones.*',
            'cursos.id as curso_id',
            'alumnos.id as alumn_id',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'personas.perSexo',
            'periodos.id as period_id',
            'periodos.perAnio',
            'periodos.perNumero',
            'departamentos.id as departament_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'ubicacion.municipio_id',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
            ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->where('bachiller_justificaciones.id', $id)
            ->first();

        return view('bachiller.reportes.justificaciones.show', [
            'bachiller_justificacion' => $bachiller_justificacion
        ]);
    }

    public function edit($id)
    {

        $bachiller_justificacion = Bachiller_justificacion::select(
            'bachiller_justificaciones.*',
            'cursos.id as curso_id',
            'alumnos.id as alumn_id',
            'alumnos.aluClave',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'personas.perSexo',
            'periodos.id as periodo_id',
            'periodos.perAnio',
            'periodos.perNumero',
            'departamentos.id as departamento_id',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'ubicacion.municipio_id',
            'cgt.cgtGradoSemestre',
            'cgt.cgtGrupo',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.id as programa_id',
            'programas.progClave',
            'programas.progNombre',
            'escuelas.id as escuela_id',
            'escuelas.escClave',
            'escuelas.escNombre'
        )
            ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->where('bachiller_justificaciones.id', $id)
            ->first();

        return view('bachiller.reportes.justificaciones.edit', [
            'bachiller_justificacion' => $bachiller_justificacion
        ]);
    }

    public function update($id, Request $request)
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

            $bachiller_justificacion = Bachiller_justificacion::find($id);
            $contador = $bachiller_justificacion->JustNumeroJustificacion;

            if ($request->curso_id_viejo != $request->curso_id) {

                $contador = Bachiller_justificacion::where('curso_id', $request->curso_id)->whereNull('deleted_at')->count();


                // if($contador >= 3){
                //     alert()->warning('Ups...', 'El alumno ya cuenta con 3 justificaciones solicitadas')->showConfirmButton();
                //     return back()->withInput();
                // }else{
                //     $contador = $contador+1;
                // }
            }


            $bachiller_justificacion->update([
                'curso_id' => $request->curso_id,
                'jusRazonFalta' => $request->razonFalta,
                'jusFechaInicio' => $request->fechaInicio,
                'jusFechaFin' => $request->fechaFin,
                'jusEstado' => $request->jusEstado
            ]);


            // retornamos a la view para obtener el id nuevo 
            session()->flash('msg', $id);
            return redirect()->back()->with('success', 'El registro de pago de certificado se ha actualizado con éxito');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];


            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
            return back()->withInput();
        }
    }

    public function cambiar_estado($id)
    {
        $bachiller_justificacion = Bachiller_justificacion::where('id', $id)->first();

        // return $bachiller_justificacion->jusEstado;

        if ($bachiller_justificacion->jusEstado == "NO") {

            $bachiller_justificacion->update([
                'jusEstado' => "SI"
            ]);
        }else{

            $bachiller_justificacion->update([
                'jusEstado' => "NO"
            ]);
            
            
        }

        
        alert('Escuela Modelo', 'El estado de la justificación se ha cambiado con éxito', 'success')->showConfirmButton();
        return back();
    }

    public function destroy($id)
    {
        $bachiller_justificacion = Bachiller_justificacion::find($id);

        try {

            if ($bachiller_justificacion->delete()) {
                alert('Escuela Modelo', 'El registro de justificación se ha eliminado con éxito', 'success')->showConfirmButton();
            } else {
                alert()->error('Error...', 'No se puedo eliminar el registro de justificación')->showConfirmButton();
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            alert()->error('Ups...' . $errorCode, $errorMessage)->showConfirmButton();
        }
        return redirect('bachiller_justificaciones');
    }

    public function contarRegistros(Request $request, $curso_id)
    {
        if ($request->ajax()) {

            $contador = Bachiller_justificacion::where('curso_id', $curso_id)->count();

            return response()->json($contador);
        }
    }

    public function reporte()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('bachiller.reportes.justificaciones.reporte', [
            "ubicaciones" => $ubicaciones
        ]);
    }

    public function imprimir_reporte(Request $request)
    {
        $bachiller_justificaciones = Bachiller_justificacion::select(
            'cursos.id as curso_id'
        )
            ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->where('periodos.id', $request->periodo_id)
            ->where('planes.id', $request->plan_id)
            ->where(static function ($query) use ($request) {

                if ($request->cgtGradoSemestre) {
                    $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestre);
                }

                if ($request->cgtGrupo) {
                    $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                }

                if ($request->aluClave) {
                    $query->where('alumnos.aluClave', $request->aluClave);
                }

                if ($request->perApellido1) {
                    $query->where('personas.perApellido1', $request->perApellido1);
                }
                if ($request->perApellido2) {
                    $query->where('personas.perApellido2', $request->perApellido2);
                }
                if ($request->perNombre) {
                    $query->where('personas.perNombre', $request->perNombre);
                }
            })
            ->whereNull('bachiller_justificaciones.deleted_at')
            ->distinct()
            ->get();

        if (count($bachiller_justificaciones) <= 0) {

            alert()->warning('Sin coincidencias', 'No se han encontrado resultados con la información proporcioada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }

        // return count($bachiller_justificaciones);

        if ($request->numero_justifaciones === "TODAS") {

            $mostrarLeyenda = "Se muestra todos los alumnos con justificaciones solictadas";

            $resultado = Bachiller_justificacion::select(
                'bachiller_justificaciones.*',
                'cursos.id as curso_id',
                'alumnos.id as alumn_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'personas.perSexo',
                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perNumero',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.id as departamento_id',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.id as ubicacion_id',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'ubicacion.municipio_id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'planes.id as plan_id',
                'planes.planClave',
                'programas.id as programa_id',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.id as escuela_id',
                'escuelas.escClave',
                'escuelas.escNombre'
            )
                ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->where('periodos.id', $request->periodo_id)
                ->where('planes.id', $request->plan_id)
                ->where(static function ($query) use ($request) {

                    if ($request->cgtGradoSemestre) {
                        $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestre);
                    }

                    if ($request->cgtGrupo) {
                        $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                    }

                    if ($request->aluClave) {
                        $query->where('alumnos.aluClave', $request->aluClave);
                    }

                    if ($request->perApellido1) {
                        $query->where('personas.perApellido1', $request->perApellido1);
                    }
                    if ($request->perApellido2) {
                        $query->where('personas.perApellido2', $request->perApellido2);
                    }
                    if ($request->perNombre) {
                        $query->where('personas.perNombre', $request->perNombre);
                    }
                })
                ->orderBy('cgt.cgtGradoSemestre')
                ->orderBy('cgt.cgtGrupo')
                ->orderBy('personas.perApellido1')
                ->orderBy('personas.perApellido2')
                ->orderBy('personas.perNombre')
                ->orderBy('bachiller_justificaciones.jusFechaInicio')
                ->orderBy('bachiller_justificaciones.jusFechaSolicitud')
                ->get();
        }

        if ($request->numero_justifaciones === "-3") {

            $mostrarLeyenda = "Se muestra los alumnos con justificaciones menores a 3 solictadas";

            $cursos = array();

            foreach ($bachiller_justificaciones as $key => $value) {
                $contador = Bachiller_justificacion::where('curso_id', $value->curso_id)->whereNull('deleted_at')->count();

                if ($contador < 3) {
                    $cursos[] = $value->curso_id;
                }
            }

            $resultado = Bachiller_justificacion::select(
                'bachiller_justificaciones.*',
                'cursos.id as curso_id',
                'alumnos.id as alumn_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'personas.perSexo',
                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perNumero',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.id as departamento_id',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.id as ubicacion_id',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'ubicacion.municipio_id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'planes.id as plan_id',
                'planes.planClave',
                'programas.id as programa_id',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.id as escuela_id',
                'escuelas.escClave',
                'escuelas.escNombre'
            )
                ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->where('periodos.id', $request->periodo_id)
                ->where('planes.id', $request->plan_id)
                ->whereIn('cursos.id', $cursos)
                ->where(static function ($query) use ($request) {

                    if ($request->cgtGradoSemestre) {
                        $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestre);
                    }

                    if ($request->cgtGrupo) {
                        $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                    }

                    if ($request->aluClave) {
                        $query->where('alumnos.aluClave', $request->aluClave);
                    }

                    if ($request->perApellido1) {
                        $query->where('personas.perApellido1', $request->perApellido1);
                    }
                    if ($request->perApellido2) {
                        $query->where('personas.perApellido2', $request->perApellido2);
                    }
                    if ($request->perNombre) {
                        $query->where('personas.perNombre', $request->perNombre);
                    }
                })
                ->orderBy('cgt.cgtGradoSemestre')
                ->orderBy('cgt.cgtGrupo')
                ->orderBy('personas.perApellido1')
                ->orderBy('personas.perApellido2')
                ->orderBy('personas.perNombre')
                ->orderBy('bachiller_justificaciones.jusFechaInicio')
                ->orderBy('bachiller_justificaciones.jusFechaSolicitud')
                ->get();
        }

        if ($request->numero_justifaciones === "3") {

            $mostrarLeyenda = "Se muestra los alumnos con 3 justificaciones solictadas";

            $cursos = array();

            foreach ($bachiller_justificaciones as $key => $value) {
                $contador = Bachiller_justificacion::where('curso_id', $value->curso_id)->whereNull('deleted_at')->count();

                if ($contador == 3) {
                    $cursos[] = $value->curso_id;
                }
            }

            $resultado = Bachiller_justificacion::select(
                'bachiller_justificaciones.*',
                'cursos.id as curso_id',
                'alumnos.id as alumn_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'personas.perSexo',
                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perNumero',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.id as departamento_id',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.id as ubicacion_id',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'ubicacion.municipio_id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'planes.id as plan_id',
                'planes.planClave',
                'programas.id as programa_id',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.id as escuela_id',
                'escuelas.escClave',
                'escuelas.escNombre'
            )
                ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->where('periodos.id', $request->periodo_id)
                ->where('planes.id', $request->plan_id)
                ->whereIn('cursos.id', $cursos)
                ->where(static function ($query) use ($request) {

                    if ($request->cgtGradoSemestre) {
                        $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestre);
                    }

                    if ($request->cgtGrupo) {
                        $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                    }

                    if ($request->aluClave) {
                        $query->where('alumnos.aluClave', $request->aluClave);
                    }

                    if ($request->perApellido1) {
                        $query->where('personas.perApellido1', $request->perApellido1);
                    }
                    if ($request->perApellido2) {
                        $query->where('personas.perApellido2', $request->perApellido2);
                    }
                    if ($request->perNombre) {
                        $query->where('personas.perNombre', $request->perNombre);
                    }
                })
                ->orderBy('cgt.cgtGradoSemestre')
                ->orderBy('cgt.cgtGrupo')
                ->orderBy('personas.perApellido1')
                ->orderBy('personas.perApellido2')
                ->orderBy('personas.perNombre')
                ->orderBy('bachiller_justificaciones.jusFechaInicio')
                ->orderBy('bachiller_justificaciones.jusFechaSolicitud')
                ->get();
        }

        if ($request->numero_justifaciones === "+3") {

            $mostrarLeyenda = "Se muestra los alumnos con más de 3 justificaciones solictadas";

            $cursos = array();


            foreach ($bachiller_justificaciones as $key => $value) {
                $contador = Bachiller_justificacion::where('curso_id', $value->curso_id)->whereNull('deleted_at')->count();

                if ($contador > 3) {
                    $cursos[] = $value->curso_id;
                }
            }

            $resultado = Bachiller_justificacion::select(
                'bachiller_justificaciones.*',
                'cursos.id as curso_id',
                'alumnos.id as alumn_id',
                'alumnos.aluClave',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'personas.perSexo',
                'periodos.id as periodo_id',
                'periodos.perAnio',
                'periodos.perNumero',
                'periodos.perFechaInicial',
                'periodos.perFechaFinal',
                'departamentos.id as departamento_id',
                'departamentos.depClave',
                'departamentos.depNombre',
                'ubicacion.id as ubicacion_id',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'ubicacion.municipio_id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'planes.id as plan_id',
                'planes.planClave',
                'programas.id as programa_id',
                'programas.progClave',
                'programas.progNombre',
                'escuelas.id as escuela_id',
                'escuelas.escClave',
                'escuelas.escNombre'
            )
                ->join('cursos', 'bachiller_justificaciones.curso_id', '=', 'cursos.id')
                ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
                ->join('planes', 'cgt.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
                ->where('periodos.id', $request->periodo_id)
                ->where('planes.id', $request->plan_id)
                ->whereIn('cursos.id', $cursos)
                ->where(static function ($query) use ($request) {

                    if ($request->cgtGradoSemestre) {
                        $query->where('cgt.cgtGradoSemestre', $request->cgtGradoSemestre);
                    }

                    if ($request->cgtGrupo) {
                        $query->where('cgt.cgtGrupo', $request->cgtGrupo);
                    }

                    if ($request->aluClave) {
                        $query->where('alumnos.aluClave', $request->aluClave);
                    }

                    if ($request->perApellido1) {
                        $query->where('personas.perApellido1', $request->perApellido1);
                    }
                    if ($request->perApellido2) {
                        $query->where('personas.perApellido2', $request->perApellido2);
                    }
                    if ($request->perNombre) {
                        $query->where('personas.perNombre', $request->perNombre);
                    }
                })
                ->orderBy('cgt.cgtGradoSemestre')
                ->orderBy('cgt.cgtGrupo')
                ->orderBy('personas.perApellido1')
                ->orderBy('personas.perApellido2')
                ->orderBy('personas.perNombre')
                ->orderBy('bachiller_justificaciones.jusFechaInicio')
                ->orderBy('bachiller_justificaciones.jusFechaSolicitud')
                ->get();
        }


        if (count($resultado) <= 0) {

            alert()->warning('Sin coincidencias', 'No se han encontrado resultados con la información proporcioada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }



        $fechaActual = Carbon::now('America/Merida');


        $parametro_NombreArchivo = "pdf_justificaciones_solicitadas";

        $cicloEscolar = Utils::fecha_string($resultado[0]->perFechaInicial, $resultado[0]->perFechaInicial) . '-' . Utils::fecha_string($resultado[0]->perFechaFinal, $resultado[0]->perFechaFinal);
        $planClave = $resultado[0]->planClave;
        $ubicacion = $resultado[0]->ubiClave . '-' . $resultado[0]->ubiNombre;
        $nivel = $resultado[0]->depClave . ' (' . $planClave . ') ' . $resultado[0]->progNombre;


        // view('reportes.pdf.bachiller.justificaciones.pdf_justificaciones_solicitadas');
        $pdf = PDF::loadView('reportes.pdf.bachiller.justificaciones.' . $parametro_NombreArchivo, [
            "resultado" => $resultado,
            "fechaActual" => Utils::fecha_string($fechaActual->format('Y-m-d'), 'fechaCorta'),
            "cicloEscolar" => $cicloEscolar,
            "planClave" => $planClave,
            "horaActual" => $fechaActual->format('H:i:s'),
            "ubicacion" => $ubicacion,
            "nivel" => $nivel,
            "mostrarLeyenda" => $mostrarLeyenda
        ]);

        $pdf->defaultFont = 'Calibri';

        return $pdf->stream($parametro_NombreArchivo . '.pdf');
        return $pdf->download($parametro_NombreArchivo  . '.pdf');
    }
}
