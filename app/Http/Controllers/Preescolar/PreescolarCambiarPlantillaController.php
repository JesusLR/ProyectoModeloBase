<?php

namespace App\Http\Controllers\Preescolar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Ubicacion;

class PreescolarCambiarPlantillaController extends Controller
{
    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('preescolar.cambiarPlantilla.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }


    public function actualizar_plantilla(Request $request)
    {
        # code...
    }
}
