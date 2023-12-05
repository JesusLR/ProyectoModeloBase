<?php

namespace App\Http\Controllers\ServiciosExternos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\Grupo;

use RealRashid\SweetAlert\Facades\Alert;

class HurraOrdinariosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:servicios_externos', 'permisos:hurra_ordinarios']);
    }

    public function reporte()
    {
        return view('hurra_ordinarios.create');
    }

    public function generar(Request $request) {

        if(!self::buscarOrdinarios($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $file = fopen(storage_path('HurraOrdinarios.csv'), 'w');
        $columns = [
            'clave_ubi', 'cvemateria', 'materia', 'apepat', 'apemat',
            'nombre', 'fecha', 'hora', 'lugar', 'cvecarr', 'carrera',
            'semestre', 'periodo', 'anio', 'cveplan', 'cvegpo'
        ];
        $columns_string = implode(',', $columns);
        fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $columns_string) . "\r\n");

        self::buscarOrdinarios($request)
        ->chunk(200, static function($registros) use ($file) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($grupo) use ($file) {
                $info = implode(',', self::info_esencial($grupo));
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info) . "\r\n");
            });
        });
        fclose($file);

        return response()->download(storage_path("HurraOrdinarios.csv"));
    }

    private static function buscarOrdinarios($request) {
        return Grupo::with(['materia.plan.programa.escuela', 'periodo.departamento.ubicacion:id,ubiClave', 'empleado.persona'])
        ->whereHas('periodo', static function($query) use ($request) {
            $query->where('perNumero', $request->perNumero)
                ->where('perAnio', $request->perAnio);
        });
    }

    /**
     * @param App\Models\Grupo
     */
    private static function info_esencial($grupo): array {
        $periodo = $grupo->periodo;
        $materia = $grupo->materia;
        $persona = $grupo->empleado->persona;
        $plan = $materia->plan;
        $programa = $plan->programa;

        return [
            'ubiClave' => $periodo->departamento->ubicacion->ubiClave,
            'matClave' => $materia->matClave,
            'matNombre' => str_replace(',', '', $materia->matNombreOficial),
            'perApellido1' => $persona->perApellido1,
            'perApellido2' => $persona->perApellido2,
            'perNombre' => $persona->perNombre,
            'gpoFechaExamenOrdinario' => $grupo->gpoFechaExamenOrdinario,
            'gpoHoraExamenOrdinario' => $grupo->gpoHoraExamenOrdinario,
            'lugar' => null,
            'progClave' => $programa->progClave,
            'progNombre' => $programa->progNombre,
            'gpoSemestre' => $grupo->gpoSemestre,
            'perNumero' => $periodo->perNumero,
            'perAnio' => $periodo->perAnio,
            'planClave' => $plan->planClave,
            'gpoClave' => $grupo->gpoClave,
        ];
    }
}
