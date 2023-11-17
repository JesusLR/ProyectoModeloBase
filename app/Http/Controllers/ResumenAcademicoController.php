<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\ResumenAcademico;
use App\Http\Models\Ubicacion;
use App\Http\Helpers\Utils;

use Yajra\DataTables\Facades\DataTables;

class ResumenAcademicoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permisos:resumen_academico']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('resumen_academico.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resumen_academico.create', [
            'ubicaciones' => Ubicacion::sedes()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect('resumen_academico');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ResumenAcademico $resumenAcademico)
    {
        $plan = $resumenAcademico->plan;
        $programa = $plan->programa;
        $escuela = $programa->escuela;
        $departamento = $escuela->departamento;
        $ubicacion = $departamento->ubicacion;
        $alumno = $resumenAcademico->alumno;
        $persona = $alumno->persona;
        $periodoIngreso = $resumenAcademico->periodoIngreso;
        $periodoUltimo = $resumenAcademico->periodoUltimo;
        $periodoEgreso = $resumenAcademico->periodoEgreso;

        return view('resumen_academico.show', compact(
            'resumenAcademico', 'plan', 'programa', 
            'escuela', 'departamento', 'ubicacion', 
            'alumno', 'persona', 'periodoIngreso',
            'periodoUltimo', 'periodoEgreso'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ResumenAcademico $resumenAcademico)
    {
        return view('resumen_academico.edit', [
            'ubicaciones' => Ubicacion::sedes()->get(),
            'resumenAcademico' => $resumenAcademico
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResumenAcademico $resumenAcademico)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect('resumen_academico');
    }

    public function list() {

        $resumenes = ResumenAcademico::select('resumenacademico.id AS resumen_id', 'alumnos.aluClave', 
            'personas.perNombre', 'personas.perApellido1', 'personas.perApellido2',
            DB::raw("CONCAT_WS(' ', perApellido1, perApellido2, perNombre) AS nombreCompleto"), 
            'ubicacion.ubiClave', 'departamentos.depClave', 'escuelas.escClave',
            'programas.progClave', 'planes.planClave', 'planes.planNumCreditos', 'periodos.perNumero', 'periodos.perAnio',
            'resumenacademico.resUltimoGrado', 'resumenacademico.resCreditosCursados', 'resumenacademico.resCreditosAprobados',
            'resumenacademico.resAvanceAcumulado', 'resumenacademico.resPromedioAcumulado', 'resumenacademico.resEstado'
        )
        ->join('alumnos', 'alumnos.id', 'resumenacademico.alumno_id')
        ->join('personas', 'personas.id', 'alumnos.persona_id')
        ->join('periodos', 'periodos.id', 'resumenacademico.resPeriodoIngreso')
        ->join('planes', 'planes.id', 'resumenacademico.plan_id')
        ->join('programas', 'programas.id', 'planes.programa_id')
        ->join('escuelas', 'escuelas.id', 'programas.escuela_id')
        ->join('departamentos', 'departamentos.id', 'escuelas.departamento_id')
        ->join('ubicacion', 'ubicacion.id', 'departamentos.ubicacion_id');

        return DataTables::of($resumenes)
        ->filterColumn('nombreCompleto', static function($query, $keyword) {
            $query->where("perNombre", 'like', "%{$keyword}%")
                ->orWhere("perApellido1", 'like', "%{$keyword}%")
                ->orWhere("perApellido2", 'like', "%{$keyword}%");
        })
        ->addColumn('action', static function($resumen) {

            return '<div class="row">'
                . Utils::btn_show($resumen->resumen_id, 'resumen_academico') .
                // . Utils::btn_edit($resumen->resumen_id, 'resumen_academico')
                // . Utils::btn_delete($resumen->resumen_id, 'resumen_academico') .
                '</div>';
        })->make(true);
    }
}
