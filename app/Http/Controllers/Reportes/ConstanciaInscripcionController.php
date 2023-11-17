<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Models\Curso;
use App\Http\Models\Firmante;
use App\Http\Models\Inscrito;
use App\Http\Models\Minutario;
use App\Http\Models\Ubicacion;

use PDF;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class ConstanciaInscripcionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:r_constancia_inscripcion');
    }

    public function reporte()
    {

        $materia_periodo =[
            'S' => 'SI',
            'N' => 'NO',
        ];
        $ubicaciones = Ubicacion::sedes()->get();
        $anioActual = Carbon::now('America/Merida')->year;

        return View('reportes/constancia_inscripcion.create', compact('materia_periodo','ubicaciones', 'anioActual'));
    }

    public function imprimir(Request $request)
    {
        $curso = Curso::with('periodo', 'cgt.plan.programa.escuela.departamento.ubicacion', 'alumno.persona')
        ->whereHas('periodo', function($query) use ($request)  {
            if ($request->perNumero)
                $query->where('perNumero', $request->perNumero);
            if ($request->perAnio)
                $query->where('perAnio', $request->perAnio);
        })
        ->whereHas('alumno.persona', function($query) use ($request)  {
            $columna_filtro = $request->buscar_por == 'clave' ? 'aluClave' : 'aluMatricula';
            $query->where($columna_filtro,  $request->clave_matricula);

            $query->where('perApellido1', 'like', '%' . $request->perApellido1 . '%');
            $query->where('perApellido2', 'like', '%' . $request->perApellido2 . '%');
            $query->where('perNombre', 'like', '%' . $request->perNombre . '%');
        })
        ->whereHas('cgt.plan.programa.escuela.departamento', function($query) use ($request)  {
            $query->where('ubicacion_id', $request->ubicaciones);
            if ($request->depClave)
                $query->where('depClave', $request->depClave);
            if ($request->progClave)
                $query->where('progClave', $request->progClave);
            if($request->cgtGradoSemestre)
                $query->where('cgtGradoSemestre', $request->cgtGradoSemestre);
            if($request->cgtGrupo)
                $query->where('cgtGrupo', $request->cgtGrupo);
        })
        ->first();


        if (!$curso) {
            alert()->error('Error...', " No se encontró un curso. Favor de filtrar bien la información.")->showConfirmButton();
            return back()->withInput();
        }

        $materias = new Collection;
        if ($request->matPeriodo == "S") {
            $materias = Inscrito::with(["grupo.materia", "grupo.optativa"])
            ->where("curso_id", "=", $curso->id)
            ->get()
            ->sortBy(static function($inscrito) {
                return $inscrito->grupo->materia->matOrdenVisual.'-'.$inscrito->grupo->materia->matNombreOficial;
            });
        }


        $minutario = Minutario::create([
            "minAnio"         => $curso->periodo->perAnioPago,
            "minClavePago"    => $request->aluClave,
            "minDepartamento" => $curso->periodo->departamento->depClave,
            "minTipo"         => "CI",
            "minFecha"        => Carbon::now('America/Merida')->format("Y-m-d"),
        ]);

        $fechaActual = Carbon::now('America/Merida');
        $nombreArchivo = $request->matPeriodo == 'N' ?
            'pdf_constancia_inscripcion_sin_materia' :
            'pdf_constancia_inscripcion_con_materia';

        $firmante = Firmante::where("id", "=", $request->firmante)->first();
        return PDF::loadView('reportes.pdf.'. $nombreArchivo, [
            "minutario"     => $minutario->id,
            "curso"         => $curso,
            "materias"      => $materias,
            "nombreArchivo" => $nombreArchivo,
            "fechaActual"   => $fechaActual,
            "horaActual"    => $fechaActual->toTimeString(),
            "firmante"      => $firmante
        ])->stream($nombreArchivo . '.pdf');
    }

}
