<?php

namespace App\Http\Controllers\Archivos;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Escuela;
use App\Models\Plan;
use App\Models\Grupo;
use App\Models\Inscrito;
use App\Models\Calificacion;
use App\clases\personas\MetodosPersonas;
use App\clases\calificaciones\MetodosCalificaciones;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AordinarioController extends Controller
{
    protected $ubicacion;
    protected $departamento;
    protected $periodo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:a_ordinario');

        set_time_limit(8000000);
    }

    public function generar(){
        $ubicaciones = Ubicacion::all();
        $tipos = [
            'S' => 'olicitud',
            'I' => 'nscripción',
            'C' => 'alificación',
        ];

        return View('archivo/ordinario.create', compact('ubicaciones', 'tipos'));
    }

    public function descargar(Request $request)
    {
        $this->periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $this->departamento = $this->periodo->departamento;
        $this->ubicacion = $this->departamento->ubicacion;

        if ($request->tipo == "S") {
            $this->_archivoSolicitud($request);
        }
        if ($request->tipo == "I") {
            $this->_archivoInscripcion($request);
        }
        if ($request->tipo == "C") {
            $this->_archivoCalificacion($request);
        }


        return redirect()->back()->withInput();
    }

    /**
    * @param Illuminate\Http\Request
    */
    public function _archivoSolicitud($request)
    {
        $grupos = Grupo::with(["materia", "empleado.persona"])
        ->where('periodo_id', $this->periodo->id)
        ->whereHas('plan.programa.escuela', function($query) use ($request) {
            $query->where('departamento_id', $this->departamento->id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('plan', function ($query) use ($request) {
            $query->where('planRegistro', $request->tipo_registro);
        })
        ->where('gpoExtraCurr', "=", "N")
        ->has('inscritos')
        ->get();

        if($grupos->isEmpty())
            return self::alert_verificacion();

        $grupos->groupBy('plan_id')->each(function($grupos_plan, $plan_id) {
            $info = $grupos_plan->first()->load('plan.programa.escuela');
            $plan = $info->plan;
            $programa = $plan->programa;
            $escuela = $programa->escuela;

            $file_name = "sol_ord_{$this->periodo->perNumero}_{$this->periodo->perAnio}_{$this->ubicacion->ubiClave}_{$programa->progClave}_{$plan->planClave}.csv";
            $path = base_path() . "/temp/";
            if($this->departamento->depClave == "SUP") {
                $path .= "07_Sol_Ord_Sup/Pendientes/";
            }
            if($this->departamento->depClave == "POS") {
                $path .= "09_Sol_Ord_Pos/Pendientes/";
            }

            $file = fopen($path . $file_name, 'w');
            $columns = ['CLAVE_ASIGNATURA', 'ESCUELA', 'PERIODO_LECTIVO', 'TIPO_SOLICITUD', 'ASIGNATURA', 'MAESTRO', 'GRUPO', 'TURNO', 'FECHA_EXAMEN', 'HORA_EXAMEN'];
            fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $columns)) . PHP_EOL);

            $grupos_plan->each(static function($grupo) use ($file) {
                $grupo->update(["clave_actv" => "SO"]);
                $info = self::info_esencial_grupo($grupo);
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $info)) . PHP_EOL);
            });

            fclose($file);
        });
    }

    /**
    * @param App\Models\Grupo
    */
    private static function info_esencial_grupo($grupo) 
    {
        $gpoTurno     = ($grupo->gpoTurno ?: '');
        $fecha_examen = ($grupo->gpoFechaExamenOrdinario ? Carbon::parse($grupo->gpoFechaExamenOrdinario)->format("d/m/Y") : '');
        $hora_examen  = ($grupo->gpoHoraExamenOrdinario ?: '');
        $optativa     = ($grupo->optativa ? " - " . strtoupper($grupo->optativa->optNombre): '');
        $matClave = $grupo->materia->matClaveEquivalente ?: $grupo->materia->matClave;
        if ($grupo->optativa) {
            $matClave = $grupo->optativa->optClaveEspecifica;
        }
        $nombreAsignatura = str_replace(',',' ', ($grupo->materia->matNombre . $optativa));

        return [
            $matClave, '', '', 
            'OR', 
            $nombreAsignatura,
            MetodosPersonas::nombreCompleto($grupo->empleado->persona, true),
            $grupo->gpoClave,
            $gpoTurno,
            $fecha_examen,
            $hora_examen
        ];
    }

    /**
    * @param Illuminate\Http\Request
    */
    public function _archivoInscripcion($request)
    {
        $inscritos = Inscrito::with(['grupo.materia.plan.programa', 'curso.alumno'])
        ->whereHas('grupo.materia.plan.programa', function($query) use ($request) {
            $query->where('periodo_id', $this->periodo->id);
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('grupo.materia.plan', function ($query) use ($request) {
            $query->where('planRegistro', $request->tipo_registro);
        })
        ->get();

        if($inscritos->isEmpty())
            return self::alert_verificacion();

        $inscritos = $inscritos->sortBy(function ($inscrito, $key) {
            return $inscrito->grupo_id;
        });
        $inscritos->groupBy(static function($inscrito) {
            $cgt = $inscrito->curso->cgt;
            $plan = $cgt->plan;

            return "{$plan->programa->progClave}-{$plan->planClave}-{$cgt->cgtGradoSemestre}";
        })->each(function($inscritos_semestre) use ($request) {
            $inscritos_semestre->pluck('grupo')->unique()->each(static function($grupo) {
                $grupo->update(['clave_actv' => 'IN']); 
            });
            $cgt = $inscritos_semestre->first()->curso->cgt;
            $plan = $cgt->plan;
            $programa = $plan->programa;

            $file_name = "insc_ord_{$this->periodo->perNumero}_{$this->periodo->perAnio}_{$this->ubicacion->ubiClave}_{$programa->progClave}_{$plan->planClave}_" . sprintf("%02d", $cgt->cgtGradoSemestre);
            $path = base_path() . "/temp/";
            if($this->departamento->depClave == "SUP") {
                $path .= "08_Ins_Ord_Sup/Pendientes/";
            }
            if($this->departamento->depClave == "POS") {
                $path .= "10_Ins_Ord_Pos/Pendientes/";
            }

            $columns = ['CLAVEIES', 'CLAVEIESOPT', 'TIPO_EXAMEN', 'FECHA_EXAMEN', 'HORA_EXAMEN', 'GRUPO', 'ALUMNO', 'DERECHO', 'OBSERVACIONES', 'ASIGNATURA', 'TURNO', 'ESTADO'];

            $chunk = 1;
            $inscritos_semestre = $inscritos_semestre->chunk(($request->chunk ?: 100));
            foreach($inscritos_semestre as $inscritos) {
                $file = fopen($path . $file_name . "_" . (sprintf("%02d", $chunk)) . ".csv", 'w');
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $columns)) . PHP_EOL);

                $inscritos->each(static function($inscrito) use ($file) {
                    $info = self::info_esencial_inscrito($inscrito);
                    fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $info)) . PHP_EOL);
                });

                fclose($file);
                $chunk++;
            }
        });
    }

    /**
    * @param App\Models\Inscrito
    */
    private static function info_esencial_inscrito($inscrito)
    {
        $grupo = $inscrito->grupo;
        $materia = $grupo->materia;
        $fecha_examen = ($grupo->gpoFechaExamenOrdinario ? Carbon::parse($grupo->gpoFechaExamenOrdinario)->format("d/m/Y") : '');
        $hora_examen  = ($grupo->gpoHoraExamenOrdinario  ? $grupo->gpoHoraExamenOrdinario : '');
        $optativa     = ($grupo->optativa ? " - " . strtoupper($grupo->optativa->optNombre): '');
        $matClave = $materia->matClaveEquivalente ?: $materia->matClave;
        if ($grupo->optativa) {
            $matClave = $grupo->optativa->optClaveEspecifica;
        }
        $nombreAsignatura = str_replace(',',' ', ($materia->matNombre . $optativa));

        return [
            $matClave,
            "N/A",
            "OR",
            $fecha_examen,
            $hora_examen,
            $grupo->gpoClave,
            $inscrito->curso->alumno->aluMatricula,
            "SI",
            "",
            $nombreAsignatura,
            $grupo->gpoTurno,
            "I",
        ];
    }

    /**
    * @param Illuminate\Http\Request
    */
    public function _archivoCalificacion($request)
    {
        $calificaciones = new Collection;
        Calificacion::with(['inscrito.grupo.materia.plan.programa', 'inscrito.curso.alumno.persona'])
        ->whereHas('inscrito.grupo.plan.programa', function($query) use ($request) {
            $query->where('periodo_id', $this->periodo->id)
                ->where('estado_act', 'C');
            if($request->programa_id)
                $query->where('programa_id', $request->programa_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })->whereHas('inscrito.grupo.materia', function($query) use ($request) {
            if($request->tipo_acreditacion != 'T')
                $query->where('matTipoAcreditacion', $request->tipo_acreditacion);
        })->whereHas('inscrito.grupo.materia.plan', function ($query) use ($request) {
            $query->where('planRegistro', $request->tipo_registro);
        })->chunk(150, static function($registros) use ($calificaciones) {
            if($registros->isEmpty())
                return false;

            $registros->pluck('inscrito.grupo')->unique()->each(static function($grupo) {
                $grupo->update(['clave_actv' => 'SO']);
            });

            $registros->each(static function($calificacion) use ($calificaciones) {
                $calificaciones->push(self::info_esencial_calificacion($calificacion));
            });
        });

        if($calificaciones->isEmpty())
            return self::alert_verificacion();

        $calificaciones->sortBy('matClave')
        ->groupBy(static function($calificacion) {

            return "{$calificacion['agrupacion']}";
        })->each(function($calificacion_semestre) {
            $info = $calificacion_semestre->first();
            $clave_inicial = "{$this->periodo->perNumero}_{$this->periodo->perAnio}_{$this->ubicacion->ubiClave}";
            $file_name = "cal_ord_{$clave_inicial}_{$info['agrupacion']}";
            
            $path = base_path() . '/temp/';
            if($this->departamento->depClave == 'SUP') {
                $path .= '11_Cal_Ord_Sup/Pendientes/';
            }
            if($this->departamento->depClave == 'POS') {
                $path .= '12_Cal_Ord_Pos/Pendientes/';
            }

            $columns = [
                'CLAVE_ASIGNATURA', 'TIPO_SOLICITUD', 'ASIGNATURA', 'GRUPO', 'MATRICULA', 'ALUMNO', 'CALIFICACION', 'FECHA', 'HORA',
            ];

            $file = fopen($path . $file_name . ".csv", 'w');
            fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $columns)) . PHP_EOL);

            $calificacion_semestre->each(static function($calificacion) use ($file) {
                unset($calificacion['agrupacion']);
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $calificacion)) . PHP_EOL);
            });

            fclose($file);
        });
    }

    /**
    * @param App\Models\Calificacion
    */
    private static function info_esencial_calificacion($calificacion)
    {
        $inscrito = $calificacion->inscrito;
        $grupo = $inscrito->grupo;
        $materia = $grupo->materia;
        $plan = $materia->plan;
        $programa = $plan->programa;
        $alumno = $inscrito->curso->alumno;

        $matClave = $materia->matClaveEquivalente ?: $materia->matClave;
        if ($grupo->optativa) {
            $matClave = $grupo->optativa->optClaveEspecifica;
        }

        $optativa = ($grupo->optativa ? " - " . strtoupper($grupo->optativa->optNombre) : '');

        $calificacionFinal = $calificacion->incsCalificacionFinal;
        if($materia->esAlfabetica()) {
            $calificacionFinal = $calificacion->incsCalificacionFinal == 0 ? 'A' : 'NA' ;
        }

        return [
            'agrupacion' => "{$programa->progClave}_{$plan->planClave}_" . sprintf("%02d", $grupo->gpoSemestre),
            'matClave' => $matClave,
            'tipo_examen' => 'OR',
            'asignatura' => str_replace(',',' ', ($materia->matNombre . $optativa)),
            'gpoClave' => $grupo->gpoClave,
            'aluMatricula' => $alumno->aluMatricula,
            'alumno' => MetodosPersonas::nombreCompleto($alumno->persona, true),
            'calificacion'  => $calificacionFinal,
            'fecha_examen' => ($grupo->gpoFechaExamenOrdinario ? Carbon::parse($grupo->gpoFechaExamenOrdinario)->format("d/m/Y") : ''),
            'hora_examen' => ($grupo->gpoHoraExamenOrdinario  ?: ''),
        ];
    }



    private static function alert_verificacion()
    {
        alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.', 'warning')->showConfirmButton();
        return back()->withInput();
    }


}