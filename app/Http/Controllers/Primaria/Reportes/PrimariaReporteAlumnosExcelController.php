<?php

namespace App\Http\Controllers\Primaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PrimariaReporteAlumnosExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        # code...
        $periodos = Periodo::select('periodos.id', 'periodos.perNumero', 'periodos.perAnioPago')
        ->where('departamento_id', 14)
        ->where('perNumero', 0)
        ->orderBy('perAnioPago', 'DESC')->get();

        return view('primaria.alumnosExcel.show-list', [
            'periodos' => $periodos
        ]);
    }

    public function reporteAlumnos()
    {
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('primaria.alumnosExcel.show-list-eduardo', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function getAlumnosCursosEduardo(Request $request)
    {

        

        if(!empty($request->periodo_id))
        {
            $resultado_array =  DB::select("call procAlumnosExcelTodosLosNivelesEduardo(" . $request->periodo_id . ")");
            $resultado_collection = collect($resultado_array);
      
              
        }else{
            $resultado_array =  DB::select("call procAlumnosExcelTodosLosNivelesEduardo(0)");
            $resultado_collection = collect($resultado_array);
        }


        return DataTables::of($resultado_collection)->make(true);
    }

    public function getAlumnosCursos(Request $request)
    {

        $referencias = DB::table('view_alumnos_primaria_excel')->select(
        'view_alumnos_primaria_excel.id',
        'view_alumnos_primaria_excel.aluClave',
        'view_alumnos_primaria_excel.perNombre',
        'view_alumnos_primaria_excel.perApellido1',
        'view_alumnos_primaria_excel.perApellido2',
        'view_alumnos_primaria_excel.perCurp',
        'view_alumnos_primaria_excel.perAnioPago',
        'view_alumnos_primaria_excel.cgtGradoSemestre',
        'view_alumnos_primaria_excel.cgtGrupo',
        'view_alumnos_primaria_excel.cgtTurno',
        'view_alumnos_primaria_excel.curTipoBeca',
        'view_alumnos_primaria_excel.bcaNombre',
        'view_alumnos_primaria_excel.curPorcentajeBeca',
        'view_alumnos_primaria_excel.curObservacionesBeca',
        'view_alumnos_primaria_excel.perTelefono1',
        'view_alumnos_primaria_excel.perTelefono2',
        'view_alumnos_primaria_excel.perCorreo1',
        'view_alumnos_primaria_excel.tutorResponsable',
        'view_alumnos_primaria_excel.celularTutor',
        'view_alumnos_primaria_excel.curEstado',
        'view_alumnos_primaria_excel.ubiNombre')
    
        ->where(function($query) use($request)
        {

            if(!empty($request->perAnioPago))
            {
                $query->where('view_alumnos_primaria_excel.perAnioPago', '=', $request->perAnioPago);
            }
            else {
                $query->where('view_alumnos_primaria_excel.perAnioPago', '=', 0);
            }
            
            
        })

        ->orderBy("view_alumnos_primaria_excel.cgtGradoSemestre", "asc")
        ->orderBy("view_alumnos_primaria_excel.cgtGrupo", "asc")
        ->orderBy("view_alumnos_primaria_excel.perApellido1", "asc")
        ->orderBy("view_alumnos_primaria_excel.perApellido2", "asc")
        ->orderBy("view_alumnos_primaria_excel.perNombre", "asc");


        return DataTables::of($referencias)->make(true);
    }


}
