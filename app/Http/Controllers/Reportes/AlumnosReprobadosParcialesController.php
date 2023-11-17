<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\clases\Recolectores\AlumnosReprobadosParcialesRecolector;

use Exception;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AlumnosReprobadosParcialesController extends Controller
{
    protected static $calificacionMinima;

    public function __construct() {
        $this->middleware(['auth', 'permisos:alumnos_reprobados_parciales']);
    }

    public function reporte() {

        return view('reportes/alumnos_reprobados_parciales.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    public function imprimir(Request $request) {

        $recolector = new AlumnosReprobadosParcialesRecolector([
            'aluClave' => $request->aluClave,
            'matClave' => $request->matClave,
            'plan_id' => $request->plan_id,
            'programa_id' => $request->programa_id,
            'escuela_id' => $request->escuela_id,
            'periodo_id' => $request->periodo_id,
            'semestre' => $request->semestre,
            'grupo' => $request->grupo,
            'etapa_calificacion' => $request->etapa_calificacion,
        ]);

        if($recolector->reprobados->isEmpty()) {
            alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.', 'warning')->showConfirmButton();
            return back()->withInput();
        }

        $fecha_cadena = Carbon::now('America/Merida')->format('YmdHisu');

        try {
            $recolector->generarExcel("AlumnosReprobadosParciales{$fecha_cadena}.xlsx");
        } catch (Exception $e) {
            alert('Error', $e->getMessage(), 'error')->showConfirmButton();
            return back()->withInput();
        }

        return $recolector->descargarExcel();
    }
}
