<?php

namespace App\Http\Controllers\Bachiller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Cgt;
use App\Http\Models\Curso;
use App\Http\Models\Departamento;
use App\Http\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BachillerCambiarCGTSEQController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $ubicaciones = Ubicacion::whereIn('id', [3])->get();

        return view('bachiller.cambiar_cgt_cch.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function getGradoGrupo(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::findOrFail($cgt_id);


            $gruposClave = Cgt::select(
                'cgt.id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo', 'periodos.id as periodo_id',
                'programas.id as programa_id',
                'planes.id as plan_id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->where('departamentos.depClave', 'BAC')
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.cgtGradoSemestre', $cgt->cgtGradoSemestre)
            ->where('cgt.cgtGrupo', '!=', 'N')
            ->whereNull('planes.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->get();

            return response()->json($gruposClave);
        }
    }

    public function getAlumnosGrado(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::findOrFail($cgt_id);

            $gruposClave = Curso::select(
                'cursos.id',
                'cgt.cgtGradoSemestre',
                'cgt.cgtGrupo',
                'periodos.id as periodo_id',
                'planes.id as plan_id',
                'programas.id as programa_id',
                'alumnos.id as alumno_id',
                'alumnos.aluClave',
                'personas.id as persona_id',
                'personas.perApellido1 as apellido_paterno',
                'personas.perApellido2 as apellido_materno',
                'personas.perNombre as nombres')
            ->join('cgt', 'cursos.cgt_id', '=', 'cgt.id')
            ->join('periodos', 'cursos.periodo_id', '=', 'periodos.id')
            ->join('planes', 'cgt.plan_id', '=', 'planes.id')
            ->join('programas', 'planes.programa_id', '=', 'programas.id')
            ->join('alumnos', 'cursos.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
            ->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
            ->where('departamentos.depClave', 'BAC')
            ->where('periodos.id', $periodo_id)
            ->where('programas.id', $programa_id)
            ->where('planes.id', $plan_id)
            ->where('cgt.id', $cgt->id)
            ->whereIn('cursos.curEstado', ['R', 'A', 'C', 'P'])
            ->whereNull('planes.deleted_at')
            ->whereNull('programas.deleted_at')
            ->whereNull('periodos.deleted_at')
            ->whereNull('departamentos.deleted_at')
            ->whereNull('cursos.deleted_at')
            ->whereNull('alumnos.deleted_at')
            ->whereNull('personas.deleted_at')
            ->orderBy('personas.perApellido1', 'asc')
            ->get();


            return response()->json($gruposClave);
        }
    }

    public function getBachillerInscritoCursos(Request $request, $periodo_id, $programa_id, $plan_id, $cgt_id)
    {
        if($request->ajax()){

            $cgt = Cgt::select('cgt.*', 'ubicacion.id as ubicacion_id')
            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('cgt.id', $cgt_id)
            ->first();


            if($cgt->ubicacion_id == 1 || $cgt->ubicacion_id == 2){
                // llama al procedure
                $resultado_array =  DB::select("call procBachillerInscritoHayDatosMontejo(".$periodo_id.", ".$programa_id.", '".$plan_id."', ".$cgt_id.",".$cgt->cgtGradoSemestre.",'".$cgt->cgtGrupo."')");
            }else{
                 // llama al procedure
                $resultado_array =  DB::select("call procBachillerInscritoHayDatosChetumal(".$periodo_id.", ".$programa_id.", '".$plan_id."', ".$cgt_id.",".$cgt->cgtGradoSemestre.",'".$cgt->cgtGrupo."')");
            }
           

            $resultado_collection = collect($resultado_array);


            return response()->json($resultado_collection);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request->cgt_id;
        $fechaActual = Carbon::now('America/Merida');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');

        $fecha = $fechaActual->format('Y-m-d');
        $hora = $fechaActual->format('H:i:s');

        $fecha_hora = $fecha . ' ' . $hora;

        $curso_id = $request->curso_id;
        $grupo_perteneciente = $request->grupo_perteneciente;
        $collectionRespuesta = collect($grupo_perteneciente);
        $cgt_id = $collectionRespuesta->values();

        $cgt = Cgt::select('cgt.*', 'ubicacion.id as ubicacion_id')
            ->join('periodos', 'cgt.periodo_id', '=', 'periodos.id')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
            ->where('cgt.id', $request->cgt_id)
            ->first();

        if (!empty($cgt_id)) {
            $contar = count($cgt_id);
            for ($i = 0; $i < $contar; $i++) {

                DB::table('cursos')
                ->where('id', $curso_id[$i])
                    ->update([
                        'cgt_id' => $cgt_id[$i],
                        'updated_at' => $fecha_hora
                    ]);

                // if($cgt->ubicacion_id == 1 || $cgt->ubicacion_id == 2){
                //     $resultado =  DB::select("call procBachillerAlumnoCambioCGTMontejo(".$curso_id[$i].", ".$cgt_id[$i].")");
                // }else{
                //     $resultado =  DB::select("call procBachillerAlumnoCambioCGTChetumal(".$curso_id[$i].", ".$cgt_id[$i].")");
                // }
            }

            alert('Escuela Modelo', 'Se realizo el cambio de grupo con éxito', 'success')->showConfirmButton();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
