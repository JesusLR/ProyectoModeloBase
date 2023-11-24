<?php

namespace App\Http\Controllers\Bachiller\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Estado;
use App\Models\Minutario;
use App\Models\Municipio;
use App\Models\Periodo;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Luecano\NumeroALetras\NumeroALetras;
use PDF;

class BachillerConstanciaComputoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {

        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        $anioActual = Carbon::now('America/Merida')->year;


        return view('bachiller.reportes.constancia_computo.create', [
            "ubicaciones" => $ubicaciones,
            "anioActual" => $anioActual
        ]);
    }

    public function imprimir(Request $request)
    {



        if ($request->grado == 3) {
            $arraySemestre = [6, 5];
        }
        if ($request->grado == 2) {
            $arraySemestre = [4, 3];
        }
        if ($request->grado == 1) {
            $arraySemestre = [2, 1];
        }


        $cursos = Curso::select(
            'cursos.id',
            'alumnos.id as alumno_id',
            'alumnos.aluClave',
            'alumnos.aluMatricula',
            'personas.perApellido1',
            'personas.perApellido2',
            'personas.perNombre',
            'periodos.perAnio',
            'periodos.perNumero',
            'periodos.perAnioPago',
            'departamentos.depClave',
            'departamentos.depNombre',
            'departamentos.depClaveOficial',
            'departamentos.depNombreOficial',
            'departamentos.depTituloDoc',
            'departamentos.depNombreDoc',
            'departamentos.depPuestoDoc',
            'departamentos.depIncorporadoA',
            'ubicacion.id as ubicacion_id',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre',
            'planes.id as plan_id',
            'planes.planClave',
            'programas.progClave',
            'programas.progNombre',
            'cgt.cgtGradoSemestre'
        )
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->where('ubicacion.id', $request->ubicacion_id)
            ->where('programas.id', $request->programa_id)
            ->where('periodos.id', $request->periodo_id)
            // ->where('cursos.curEstado', '!=', 'B')
            ->whereIn('cgt.cgtGradoSemestre', $arraySemestre)
            // ->whereIn('bachiller_materias.matClave', ['TIC1', 'TIC2'])
            ->where(static function ($query) use ($request) {


                if ($request->aluClave) {
                    $query->where('alumnos.aluClave', $request->aluClave);
                }

                if ($request->aluMatricula) {
                    $query->where('alumnos.aluMatricula', $request->aluMatricula);
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
            ->whereNull('periodos.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('ubicacion.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->whereNull('planes.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('cursos.deleted_at')
            ->orderBy('personas.perApellido1', 'ASC')
            ->orderBy('personas.perApellido2', 'ASC')
            ->orderBy('personas.perNombre', 'ASC')
            ->get();


        if (count($cursos) > 0) {

            $arrayAlumnoId = [];
            $arrayPlanId = [];


            foreach ($cursos as $curso) {
                $arrayAlumnoId[] = $curso->alumno_id;

                $arrayPlanId[] = $curso->plan_id;
            }
        }else{
            alert()->warning('Upss', " No se encontró datos con la información proporcionada.")->showConfirmButton();
            return back()->withInput();
        }


        if (count($arrayAlumnoId) > 0 && count($arrayPlanId) > 0) {


            $bachiller_historico = Bachiller_historico::select(
                'bachiller_historico.alumno_id',
                'alumnos.aluClave',
                'alumnos.aluMatricula',
                'personas.perApellido1',
                'personas.perApellido2',
                'personas.perNombre',
                'personas.perSexo',
                'bachiller_historico.plan_id',
                'bachiller_historico.bachiller_materia_id',
                'bachiller_historico.periodo_id',
                'bachiller_historico.histComplementoNombre',
                'bachiller_historico.histPeriodoAcreditacion',
                'bachiller_historico.histCalificacion',
                'bachiller_historico.histTipoAcreditacion',
                'bachiller_historico.histFechaExamen',
                'bachiller_historico.histFolio',
                'bachiller_historico.hisActa',
                'bachiller_historico.histLibro',
                'bachiller_materias.matClave',
                'bachiller_materias.matNombre',
                'periodos.perAnio',
                'periodos.perNumero',
                'periodos.perAnioPago',
                'departamentos.depClave',
                'departamentos.depNombre',
                'departamentos.depClaveOficial',
                'departamentos.depNombreOficial',
                'departamentos.depTituloDoc',
                'departamentos.depNombreDoc',
                'departamentos.depPuestoDoc',
                'departamentos.depIncorporadoA',
                'ubicacion.id as ubicacion_id',
                'ubicacion.ubiClave',
                'ubicacion.ubiNombre',
                'planes.planClave',
                'programas.progClave',
                'programas.progNombre'
            )
                ->join('bachiller_materias', 'bachiller_historico.bachiller_materia_id', '=', 'bachiller_materias.id')
                ->join('periodos', 'bachiller_historico.periodo_id', '=', 'periodos.id')
                ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
                ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
                ->join('alumnos', 'bachiller_historico.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('planes', 'bachiller_historico.plan_id', '=', 'planes.id')
                ->join('programas', 'planes.programa_id', '=', 'programas.id')
                ->whereIn('alumnos.id', $arrayAlumnoId)
                ->whereIn('planes.id', $arrayPlanId)
                ->whereIn('bachiller_materias.matClave', ['TIC1', 'TIC2'])
                ->whereNull('bachiller_historico.deleted_at')
                ->whereNull('bachiller_materias.deleted_at')
                ->whereNull('periodos.deleted_at')
                ->whereNull('departamentos.deleted_at')
                ->whereNull('ubicacion.deleted_at')
                ->whereNull('alumnos.deleted_at')
                ->whereNull('personas.deleted_at')
                ->whereNull('planes.deleted_at')
                ->whereNull('programas.deleted_at')
                ->orderBy('personas.perApellido1', 'ASC')
                ->orderBy('personas.perApellido2', 'ASC')
                ->orderBy('personas.perNombre', 'ASC')
                ->orderBy('bachiller_materias.matClave', 'ASC')
                ->get();

            if (count($bachiller_historico) < 1) {
                alert()->warning('Error...', " No se encontró datos con la información proporcionada.")->showConfirmButton();
                return back()->withInput();
            }

            $primerRegistro = $bachiller_historico[0];
            $parametroClaveEscuela = $primerRegistro->depClaveOficial;
            $parametroNombreTitulo = $primerRegistro->depTituloDoc;
            $parametroNombreSecretaria = $primerRegistro->depNombreDoc;
            $parametroPuesto = $primerRegistro->depPuestoDoc;
            $parametroUbicacion = $primerRegistro->ubiClave;
            $parametroPerAnioPago = $primerRegistro->perAnioPago;


            $parametroPuestoMayus = "LA " . mb_strtoupper($parametroPuesto);
            $parametroNombreTituloMayus = mb_strtoupper($parametroNombreTitulo);
            $parametroNombreSecretariaMayus = mb_strtoupper($parametroNombreSecretaria);

            $agrupamosPorAluclave = $bachiller_historico->groupBy('aluClave');
            // return count($agrupamosPorAluclave);


            $ubicacion = Ubicacion::find($primerRegistro->ubicacion_id);
            $municipio = Municipio::find($ubicacion->municipio_id);
            $estado = Estado::find($municipio->estado_id);

            $parametro_NombreArchivo = "pdf_bachiller_constancia_computo";

            $munitario = self::crear_minutario($agrupamosPorAluclave);

            // return self::fecha_texto_constancia();

            // view('reportes.pdf.bachiller.constancias.pdf_bachiller_constancia_computo');
            $pdf = PDF::loadView('reportes.pdf.bachiller.constancias.' . $parametro_NombreArchivo, [
                "parametroClaveEscuela" => $parametroClaveEscuela,
                "parametroNombreTitulo" => $parametroNombreTitulo,
                "parametroNombreSecretaria" => $parametroNombreSecretaria,
                "parametroPuesto" => $parametroPuesto,
                "parametroUbicacion" => $parametroUbicacion,
                "agrupamosPorAluclave" => $agrupamosPorAluclave,
                "bachiller_historico" => $bachiller_historico,
                "fechaDeHoy" => self::fecha_texto_constancia(),
                "municipio" => $municipio,
                "estado" => $estado,
                "parametroPuestoMayus" => $parametroPuestoMayus,
                "parametroNombreSecretariaMayus" => $parametroNombreSecretariaMayus,
                "parametroNombreTituloMayus" => $parametroNombreTituloMayus
            ]);


            $pdf->defaultFont = 'Calibri';

            return $pdf->stream($parametro_NombreArchivo . '.pdf');
            return $pdf->download($parametro_NombreArchivo  . '.pdf');
        }
    }

    private static function fecha_texto_constancia()
    {
        $fechaActual = Carbon::now('America/Merida');
        $fechaDia = $fechaActual->format('d');
        $fechaMes = strtolower(Utils::num_meses_string($fechaActual->month));
        $fechaAnio = $fechaActual->format('Y');

        $numeroLetras = str_replace(" CON 00/100", "", NumeroALetras::convert($fechaAnio));
        $minusculas = strtolower($numeroLetras);

        if($minusculas == "dos mil veintitres"){
            $minusculas = " dos mil veintitrés";
        }

        if ($fechaDia > 9) {
            $alos = "a los";
        } else {
            $alos = "";
        }


        return "a los {$fechaDia} días del mes de {$fechaMes} de {$minusculas}";
    }

    private static function crear_minutario($agrupamosPorAluclave)
    {

        $contador = 1;
        foreach ($agrupamosPorAluclave as $aluClave => $valores) {
            foreach ($valores as $item) {
                if ($item->aluClave == $aluClave && $contador++ == 1) {
                    Minutario::create([
                        'minAnio' => $item->perAnioPago,
                        'minClavePago' => $item->aluClave,
                        'minDepartamento' => $item->depClave,
                        'minTipo' => 'CU',
                        'minNombreDocumento' => "CONSTANCIA DE COMPUTO",
                        'minFecha' => Carbon::now('America/Merida')->format('Y-m-d'),
                        'created_at' => Carbon::now('America/Merida')->format('Y-m-d H:i:s')
                    ]);
                }
            }

            $contador = 1;
        }
    }
}
