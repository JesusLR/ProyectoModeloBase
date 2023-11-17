<?php

namespace App\Http\Controllers\Secundaria\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Curso;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SecundariaReporteAlumnosExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
     

        $periodos = DB::table('periodos')->select('perNumero', 'perAnioPago')
        ->whereIn('departamento_id', [15, 19])
        ->where('perNumero', 0)
        ->orderBy('perAnioPago', 'DESC')
        ->distinct()->get();

        return view('secundaria.alumnosExcel.show-list', [
            'periodos' => $periodos
        ]);
    }

    public function reporteAlumnos()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.alumnosExcel.show-list-eduardo', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function getAlumnosCursos(Request $request)
    {

        $referencias = DB::table('view_alumnos_secundaria_excel')->select(
        'view_alumnos_secundaria_excel.perAnioPago',
        'view_alumnos_secundaria_excel.ubiClave',
        'view_alumnos_secundaria_excel.escClave',
        'view_alumnos_secundaria_excel.progClave',
        'view_alumnos_secundaria_excel.progNombre',
        'view_alumnos_secundaria_excel.aluClave',
        'view_alumnos_secundaria_excel.perNombreCompleto',
        'view_alumnos_secundaria_excel.cgtGradoSemestre',
        'view_alumnos_secundaria_excel.cgtGrupo',
        'view_alumnos_secundaria_excel.telefonos',
        'view_alumnos_secundaria_excel.perCorreo1')
       
        ->where(function($query) use($request)
        {

            if(!empty($request->perAnioPago))
            {
                $query->where('view_alumnos_secundaria_excel.perAnioPago', '=', $request->perAnioPago);
                
              
            }
            else {
                $query->where('view_alumnos_secundaria_excel.perAnioPago', '=', 0);
            }
            
            
        })

        ->orderBy("view_alumnos_secundaria_excel.escClave", "ASC")
        ->orderBy("view_alumnos_secundaria_excel.cgtGradoSemestre", "ASC")
        ->orderBy("view_alumnos_secundaria_excel.cgtGrupo", "ASC")
        ->orderBy("view_alumnos_secundaria_excel.perNombreCompleto", "ASC");
        
        


        return DataTables::of($referencias)->make(true);
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

}
