<?php

namespace App\Http\Controllers\EducacionContinua\Reportes;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Http\Models\Ubicacion;
use App\Http\Models\EducacionContinua;
use App\Http\Models\Ficha;
use App\Exports\FichasIncorrectasEduContinuaExport;

use Carbon\Carbon;
use Excel;

class FichasIncorrectasEduContinuaController extends Controller
{
    public $fichas;

    public function __construct()
    {
    	$this->middleware(['auth', 'permisos:fichas_incorrectas_edu_continua']);
        $this->fichas = new Collection;
    }

    public function reporte()
    {
    	return view('reportes/fichas_incorrectas_edu_continua.create', [
    		'ubicaciones' => Ubicacion::sedes()->get(),
    	]);
    }

    public function imprimir(Request $request)
    {
        $programas = EducacionContinua::with(['periodo', 'escuela.departamento', 'ubicacion'])
        ->whereHas('escuela.departamento', static function($query) use ($request) {
            if($request->departamento_id)
                $query->where('departamento_id', $request->departamento_id);
            if($request->escuela_id)
                $query->where('escuela_id', $request->escuela_id);
        })
        ->whereHas('ubicacion', static function($query) use ($request) {
            $query->where('ubicacion_id', $request->ubicacion_id);
        })
        ->get()
        ->keyBy('id');

        if($programas->isEmpty()) return self::alert_verificacion();

        Ficha::whereIn('fchClaveProgAct', $programas->keys())
        ->where(static function($query) use ($request) {
            if($request->rango1)
                $query->whereDate('fchFechaImpr', '>=', $request->rango1);
            if($request->rango2)
                $query->whereDate('fchFechaImpr', '<=', $request->rango2);
        })
        ->chunk(200, function($fichas) use ($programas) {
            if($fichas->isEmpty())
                return false;

            $fichas->each(function($ficha) use ($programas) {
                $fecha_impresion = Carbon::parse($ficha->fchFechaImpr);
                $ficha->programa = $programas->get($ficha->fchClaveProgAct);

                if($fecha_impresion->gt($ficha->programa->periodo->perFechaFinal))
                    $this->fichas->push($ficha);
            });
        });

        if($this->fichas->isEmpty()) return self::alert_verificacion();

        return Excel::download(new FichasIncorrectasEduContinuaExport($this->fichas), 'PosiblesFichasIncorrectasEducacionContinua.xlsx');
    }

    public static function alert_verificacion()
    {
        alert('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada. Favor de verificar.', 'warning')->showConfirmButton();
        return back()->withInput();
    }
}
