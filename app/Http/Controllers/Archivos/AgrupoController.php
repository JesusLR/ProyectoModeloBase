<?php

namespace App\Http\Controllers\Archivos;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Models\Grupo;
use App\Models\ClaveProfesor;

use Maatwebsite\Excel\Facades\Excel;

class AgrupoController extends Controller
{

    protected $periodo;
    protected $departamento;
    protected $ubicacion;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:a_grupo');
    }

    public function generar()
    {
        $ubicaciones = Ubicacion::sedes()->get();
        return View('archivo/grupo.create', compact('ubicaciones'));
    }

    public function descargar(Request $request)
    {
        $this->periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
        $this->departamento = $this->periodo->departamento;
        $this->ubicacion = $this->departamento->ubicacion;

        $grupos = self::buscarGrupos($this->periodo, $request->tipo_registro);

        $columnas = ['CLAVE_ASIGNATURA', 'GRUPO', 'TURNO', 'CLAVE_OPTATIVA', 'MAESTRO_ID'];

        $grupos->groupBy('plan_id')
        ->each(function($plan_grupos) use ($columnas) {   
            $plan = $plan_grupos->first()->plan;
            $archivo = $this->generar_nombre_csv($plan);
            fputs($archivo, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(',', $columnas)) . PHP_EOL);
            $this->agregar_grupos($archivo, $plan_grupos);
            fclose($archivo);
        });

        return redirect()->back();

    }


    public static function buscarGrupos($periodo, $tipo_registro)
    {
        return Grupo::with(['plan.programa', 'optativa.materia', 'materia', 'empleado.persona'])
        ->whereHas('plan', static function ($query) use ($tipo_registro) {
            $query->where('planRegistro', $tipo_registro);
        })
        ->where('periodo_id', $periodo->id)
        ->where('gpoExtraCurr', 'N')
        ->where('inscritos_gpo', '>', 0)
        //->whereNotIn('gpoClave', ['X', 'Y', 'Z'])
        ->get();
    }


    public function generar_nombre_csv($plan)
    {
        $programa = $plan->programa;
        $departamento_folder = $this->departamento->depClave == 'POS' ? '02_Grupos_Pos' : '01_Grupos_Sup';
        $nombreArchivo = "gpos"
            . "_{$this->periodo->perNumero}"
            . "_{$this->periodo->perAnio}"
            . "_{$programa->progClave}"
            . "_{$plan->planClave}"
            . "_{$this->ubicacion->ubiClave}"
            . ".csv";

        return fopen(base_path() . "/temp/{$departamento_folder}/Pendientes/{$nombreArchivo}", "w");
        //Usar la siguiente url para TEST.
        // return fopen(storage_path("/temp/{$departamento_folder}/Pendientes/{$nombreArchivo}"), "w");
    }


    public function agregar_grupos($archivo, $grupos)
    {
        $grupos->each(function($grupo) use ($archivo) {
            $this->agregar_linea($archivo, $grupo);
        });
    }


    public function agregar_linea($archivo, $grupo)
    {
        $materia = $grupo->materia;
        $info['matClave'] = $materia->matClaveEquivalente ?: $materia->matClave;
       
        $optativa = $grupo->optativa;
        /*
        if($optativa && $optativa->optClaveGenerica) {
            $info['matClave'] = $optativa->optClaveGenerica;
        }*/
        $info['gpoClave'] = $grupo->gpoClave;
        $info['gpoTurno'] = $grupo->gpoTurno;
        $info['clave_optativa'] = $optativa ? $optativa->optClaveEspecifica : '';
        $info['clave_segey'] = $this->definir_clave_segey($grupo);
        fputs($archivo, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(',', $info)) . PHP_EOL);
    }

    public function definir_clave_segey($grupo)
    {
        $empleado_id = $grupo->empleado_id;
        if($grupo->empleado_sinodal_id && $grupo->empleado_sinodal_id != 0) {
            $empleado_id = $grupo->empleado_sinodal_id;
        }
        $clave = ClaveProfesor::deEmpleado($empleado_id)->deUbicacion($this->ubicacion->id)->first();
        return $clave ? $clave->cpClaveSegey : '';
    }

}