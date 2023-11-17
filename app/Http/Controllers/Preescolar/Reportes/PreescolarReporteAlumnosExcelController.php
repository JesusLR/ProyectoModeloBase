<?php

namespace App\Http\Controllers\Preescolar\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Curso;
use App\Http\Models\Periodo;
use App\Http\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PreescolarReporteAlumnosExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        # code...
        $periodos = DB::table('periodos')->select('perNumero', 'perAnioPago')
        ->whereIn('departamento_id', [11, 13])
        ->where('perNumero', 0)
        ->orderBy('perAnioPago', 'DESC')
        ->distinct()->get();

        return view('preescolar.alumnosExcel.show-list', [
            'periodos' => $periodos
        ]);
    }

    public function reporteAlumnos()
    {
        // $ubicaciones = Ubicacion::all();
        $ubicaciones = Ubicacion::whereIn('id', [1])->get();


        return view('preescolar.alumnosExcel.show-list-eduardo', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function getAlumnosCursos(Request $request)
    {

        $referencias = DB::table('view_alumnos_maternal_preescolar_excel')->select(
        'view_alumnos_maternal_preescolar_excel.perAnioPago',
        'view_alumnos_maternal_preescolar_excel.ubiClave',
        'view_alumnos_maternal_preescolar_excel.escClave',
        'view_alumnos_maternal_preescolar_excel.progClave',
        'view_alumnos_maternal_preescolar_excel.progNombre',
        'view_alumnos_maternal_preescolar_excel.aluClave',
        'view_alumnos_maternal_preescolar_excel.perNombreCompleto',
        'view_alumnos_maternal_preescolar_excel.cgtGradoSemestre',
        'view_alumnos_maternal_preescolar_excel.cgtGrupo',
        'view_alumnos_maternal_preescolar_excel.telefonos',
        'view_alumnos_maternal_preescolar_excel.perCorreo1')
       
        ->where(function($query) use($request)
        {

            if(!empty($request->perAnioPago))
            {
                $query->where('view_alumnos_maternal_preescolar_excel.perAnioPago', '=', $request->perAnioPago);
                
              
            }
            else {
                $query->where('view_alumnos_maternal_preescolar_excel.perAnioPago', '=', 0);
            }
            
            
        })

        ->orderBy("view_alumnos_maternal_preescolar_excel.escClave", "ASC")
        ->orderBy("view_alumnos_maternal_preescolar_excel.cgtGradoSemestre", "ASC")
        ->orderBy("view_alumnos_maternal_preescolar_excel.cgtGrupo", "ASC")
        ->orderBy("view_alumnos_maternal_preescolar_excel.perNombreCompleto", "ASC");
        
        


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
