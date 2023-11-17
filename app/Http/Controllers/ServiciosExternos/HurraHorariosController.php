<?php

namespace App\Http\Controllers\ServiciosExternos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Grupo;

use RealRashid\SweetAlert\Facades\Alert;

class HurraHorariosController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'permisos:servicios_externos', 'permisos:hurra_horarios']);
    }

    public function reporte()
    {
        return view('hurra_horarios.create');
    }

    public function generar(Request $request) {

        if(!self::buscarHorarios($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $file = fopen(storage_path('HurraHorarios.csv'), 'w');
        $columns = [
            'ubicacion', 'carrera', 'semestre', 'grupo', 'clave_materia', 'materia', 'clave_maestro', 'empleado',
            'lunes', 'aula_lunes', 'martes', 'aula_martes', 'miercoles', 'aula_miercoles', 'jueves', 'aula_jueves', 'viernes', 'aula_viernes', 'sabado', 'aula_sabado', 
            'num_credencial',
        ];
        $columns_string = implode(',', $columns);
        fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $columns_string) . "\r\n");

        self::buscarHorarios($request)
        ->chunk(200, static function($registros) use ($file) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($grupo) use ($file) {
                $info = implode(',', self::info_esencial($grupo));
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info) . "\r\n");
            });
        });
        fclose($file);

        return response()->download(storage_path("HurraHorarios.csv"));
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarHorarios($request)
    {
        return Grupo::with(['materia.plan.programa.escuela.departamento.ubicacion', 'empleado.persona', 'horarios.aula'])
        ->whereHas('periodo', static function($query) use ($request) {
            $query->where('perNumero', $request->perNumero)
                ->where('perAnio', $request->perAnio);
        });
    }

    /**
     * @param App\Http\Models\Grupo
     */
    private static function info_esencial($grupo): array {
        $materia = $grupo->materia;
        $empleado = $grupo->empleado;
        $programa = $materia->plan->programa;
        $horarios = $grupo->horarios->keyBy('ghDia');
        $lunes = $horarios->get(1) ?: null;
        $martes = $horarios->get(2) ?: null;
        $miercoles = $horarios->get(3) ?: null;
        $jueves = $horarios->get(4) ?: null;
        $viernes = $horarios->get(5) ?: null;
        $sabado = $horarios->get(6) ?: null;

        return [
            'ubiClave' => $programa->escuela->departamento->ubicacion->ubiClave,
            'progClave' => $programa->progClave,
            'gpoSemestre' => $grupo->gpoSemestre,
            'gpoClave' => $grupo->gpoClave,
            'matClave' => $materia->matClave,
            'matNombre' => str_replace(',', '', $materia->matNombreOficial),
            'empleado_id' => $grupo->empleado_id,
            'empleado_nombre' => $empleado->persona->nombreCompleto(),
            'lunes' => $lunes ? "{$lunes->ghInicio}-{$lunes->ghFinal}" : null,
            'aula_lunes' => $lunes && $lunes->aula ? $lunes->aula->aulaClave : null,
            'martes' => $martes ? "{$martes->ghInicio}-{$martes->ghFinal}" : null,
            'aula_martes' => $martes && $martes->aula ? $martes->aula->aulaClave : null,
            'miercoles' => $miercoles ? "{$miercoles->ghInicio}-{$miercoles->ghFinal}" : null,
            'aula_miercoles' => $miercoles && $miercoles->aula ? $miercoles->aula->aulaClave : null,
            'jueves' => $jueves ? "{$jueves->ghInicio}-{$jueves->ghFinal}" : null,
            'aula_jueves' => $jueves && $jueves->aula ? $jueves->aula->aulaClave : null,
            'viernes' => $viernes ? "{$viernes->ghInicio}-{$viernes->ghFinal}" : null,
            'aula_viernes' => $viernes && $viernes->aula ? $viernes->aula->aulaClave : null,
            'sabado' => $sabado ? "{$sabado->ghInicio}-{$sabado->ghFinal}" : null,
            'aula_sabado' => $sabado && $sabado->aula ? $sabado->aula->aulaClave : null,
            'num_credencial' => $empleado->empCredencial,
        ];
    }
}
