<?php

namespace App\Http\Controllers\Preescolar\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Departamento;
use App\Http\Models\Preescolar\Preescolar_rubricas;
use App\Http\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use PDF;

class PreescolarReporteRubricasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte()
    {
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();

        $departamento = Departamento::select()->whereIn('depClave', ['PRE'])->get();

        return view('preescolar.reporte_rubricas.create', [
            "ubicaciones" => $ubicaciones,
            "departamento" => $departamento
        ]);
    }

    public function getMaterias(Request $request, $programa_id, $plan_id)
    {
        if($request->ajax()){

            $materias = DB::select("SELECT preescolar_materias.id, preescolar_materias.matNombre 
            FROM preescolar_rubricas_tipo
            INNER JOIN preescolar_materias ON preescolar_materias.id = preescolar_rubricas_tipo.preescolar_materia_id
            INNER JOIN planes ON planes.id = preescolar_materias.plan_id
            WHERE preescolar_rubricas_tipo.programa_id = $programa_id
            AND planes.id=$plan_id
            GROUP BY preescolar_materias.id, preescolar_materias.matNombre");
            
            return response()->json($materias);

        }
    }

    public function imprimir(Request $request)
    {
        $rubricas = Preescolar_rubricas::select(
            'preescolar_rubricas.id',
            'preescolar_rubricas.grado',
            'preescolar_rubricas.trimestre1',
            'preescolar_rubricas.trimestre2',
            'preescolar_rubricas.trimestre3',
            'preescolar_rubricas.rubrica',
            'preescolar_rubricas.aplica',
            'preescolar_rubricas.orden_impresion',
            'preescolar_rubricas_tipo.tipo',            
            'programas.progClave',
            'programas.progNombre',
            'escuelas.escClave',
            'escuelas.escNombre',
            'departamentos.depClave',
            'departamentos.depNombre',
            'ubicacion.ubiClave',
            'ubicacion.ubiNombre')
        ->join('preescolar_rubricas_tipo', 'preescolar_rubricas.preescolar_rubricas_tipo_id', '=', 'preescolar_rubricas_tipo.id')
        ->join('preescolar_materias', 'preescolar_rubricas_tipo.preescolar_materia_id', '=', 'preescolar_materias.id')
        ->join('programas', 'preescolar_rubricas.programa_id', '=', 'programas.id')
        ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
        ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
        ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
        // ->join('periodos', 'preescolar_rubricas.periodo_id', '=', 'periodos.id')
        ->whereIn('departamentos.depClave', ['MAT', 'PRE'])
        // ->where('periodos.id', $request->periodo_id)
        ->where('programas.id', $request->programa_id)
        ->where('preescolar_rubricas.grado', $request->grado)
        ->where(static function ($query) use ($request) {

            if ($request->aplica != "AMBOS") {
                $query->where('preescolar_rubricas.aplica', $request->aplica);
            }

            if ($request->trimestre == "1") {
                $query->whereNotNull('preescolar_rubricas.trimestre1');
            }

            if ($request->trimestre == "2") {
                $query->whereNotNull('preescolar_rubricas.trimestre2');
            }

            if ($request->trimestre == "3") {
                $query->whereNotNull('preescolar_rubricas.trimestre3');
            }

            if ($request->preescolar_materia_id != "") {
                $query->where('preescolar_materias.id', $request->preescolar_materia_id);
            }

            
        })        
        ->orderBy('preescolar_rubricas.orden_impresion', 'ASC')
        ->whereNull('preescolar_rubricas_tipo.deleted_at')
        ->whereNull('preescolar_materias.deleted_at')
        ->whereNull('programas.deleted_at')
        ->whereNull('escuelas.deleted_at')
        ->whereNull('departamentos.deleted_at')
        ->whereNull('ubicacion.deleted_at')
        ->get();


        if(count($rubricas) == 0){
            alert('Escuela Modelo', 'No se encontro datos con la información proporcionada','warning')->showConfirmButton()->autoClose(5000);
            return back();
        }

        $AnoActual = $rubricas[0]->perAnioPago;
        $AnoSiguiente = $rubricas[0]->perAnioPago + 1;

        $cicloEscolar = $AnoActual.'-'.$AnoSiguiente;

        // view('reportes.pdf.preescolar.rubricas.pdf_preescolar_rubricas');
        $parametro_NombreArchivo = "pdf_preescolar_rubricas";
        $pdf = PDF::loadView('reportes.pdf.preescolar.rubricas.'. $parametro_NombreArchivo, [
            "cicloEscolar" => $cicloEscolar,
            "rubricas" => $rubricas,
            "trimestre" => $request->trimestre  
        ]);

    
        $pdf->setPaper('letter', 'portrait');
        

        $pdf->defaultFont = 'Times Sans Serif';

        return $pdf->stream($parametro_NombreArchivo.'.pdf');
        return $pdf->download($parametro_NombreArchivo.'.pdf');
    }
}
