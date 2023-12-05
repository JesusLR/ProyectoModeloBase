<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ubicacion;

use App\Models\Periodo;
use App\Exports\RelacionInscritosPrimeroExport;
use Excel;

class RelacionInscritosPrimeroController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:relacion_inscritos_primero']);
    }

    public function reporte()
    {
    	return view('reportes/relacion_inscritos_primero.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
    	$periodo = Periodo::with('departamento.ubicacion')->findOrFail($request->periodo_id);

    	return Excel::download(new RelacionInscritosPrimeroExport($periodo), "RelacionInscritosPrimero.xlsx");
    }
}
