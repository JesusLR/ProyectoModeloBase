<?php

namespace App\Http\Controllers\Tutorias\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tutorias\Tutorias_preguntas;

class PreguntaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function preguntas(Request $request)
    {
        $preguntas = Tutorias_preguntas::where(static function($query) use ($request) {
            $query->whereNull('deleted_at');
            if($request->FormularioID)
                $query->where('FormularioID', $request->FormularioID);
            if($request->CategoriaPreguntaID)
                $query->where('CategoriaPreguntaID', $request->CategoriaPreguntaID);
        })->get();

        return response()->json($preguntas);
    }
}
