<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Ubicacion;
use App\Exports\ConteoEmpleadosExport;

use Excel;

class ConteoEmpleadosController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:conteo_empleados']);
    }

    public function reporte()
    {
    	return view('reportes/conteo_empleados.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
    	return Excel::download(new ConteoEmpleadosExport($request), 'ConteoEmpleados.xlsx');
    }
}
