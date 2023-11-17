<?php

namespace App\Http\Controllers\ServiciosExternos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Curso;

use RealRashid\SweetAlert\Facades\Alert;

class HurraAlumnosController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'permisos:servicios_externos', 'permisos:hurra_alumnos']);
    }

    public function reporte() 
    {
        return view('hurra_alumnos.create');
    }

    public function generar(Request $request) 
    {
        if(!self::buscarCursos($request)->exists()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }
        
        $file = fopen(storage_path('HurraAlumnos.csv'), 'w');
        $columns = [
            'ubicacion', 'carrera', 'clave_pago', 'ape_pat', 'ape_mat',
            'nombres', 'semestre', 'grupo', 'pbeca', 'email_pt_alu', 'clave_pp_cur'
        ];
        $columns_string = implode(',', $columns);
        fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $columns_string) . "\r\n");

        self::buscarCursos($request)
        ->chunk(200, static function($registros) use ($file) {
            if($registros->isEmpty())
                return false;

            $registros->each(static function($curso) use ($file) {
                $info = implode(',', self::info_esencial($curso));
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info) . "\r\n");
            });
        });
        fclose($file);

        return response()->download(storage_path("HurraAlumnos.csv"));
    }

    /**
     * @param Illuminate\Http\Request
     */
    private static function buscarCursos($request) 
    {
        $query = Curso::with(['periodo.departamento.ubicacion', 'cgt.plan.programa.escuela', 'alumno.persona'])
        ->whereHas('periodo', static function($query) use ($request) {
            $query->where('perNumero', $request->perNumero)
                ->where('perAnio', $request->perAnio);
        });

        if ($request->curEstado == 'B') {
            $query->where('curEstado', '!=', $request->curEstado);
        }

        return $query;
    }

    /**
     * @param App\Http\Models\Curso
     */
    private static function info_esencial($curso): array {
        $cgt = $curso->cgt;
        $alumno = $curso->alumno;
        $persona = $alumno->persona;

        return [
            'ubiClave' => $curso->periodo->departamento->ubicacion->ubiClave,
            'progClave' => $cgt->plan->programa->progClave,
            'aluClave' => $alumno->aluClave,
            'perApellido1' => $persona->perApellido1,
            'perApellido2' => $persona->perApellido2,
            'perNombre' => $persona->perNombre,
            'grado' => $cgt->cgtGradoSemestre,
            'grupo' => $cgt->cgtGrupo,
            'curPorcentajeBeca' => $curso->curPorcentajeBeca,
            'perCorreo1' => str_replace(',', '', $persona->perCorreo1),
            'curPlanPago' => $curso->curPlanPago,
        ];
    }
}
