<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;
use App\Models\Periodo;
use App\Exports\ResumenDeudoresExport;

use DB;
use Excel;

class ResumenDeudoresController extends Controller
{
    public function __construct() {
    	$this->middleware(['auth', 'permisos:r_plantilla_profesores']);
    }

    public function reporte()
    {
    	return view('reportes/resumen_deudores.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
    	$periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);
    	$usuario = auth()->user();

		return Excel::download(new ResumenDeudoresExport($usuario, $periodo), 'ResumenDeudores.xlsx');
    }
}
