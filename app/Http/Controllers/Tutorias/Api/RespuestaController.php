<?php

namespace App\Http\Controllers\Tutorias\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tutorias\Tutorias_respuestas;

class RespuestaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function respuestas(Request $request)
    {
        $respuestas = Tutorias_respuestas::where(static function($query) use ($request) {
            $query->whereNull('deleted_at');
            if($request->PreguntaID)
                $query->where('PreguntaID', $request->PreguntaID);
        })->get();

        return response()->json($respuestas);
    }
}
