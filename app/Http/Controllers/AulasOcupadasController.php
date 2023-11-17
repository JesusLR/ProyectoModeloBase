<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Ubicacion;
use App\Http\Models\Horario;

use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use PDF;

class AulasOcupadasController extends Controller
{
    //
    public function __contruct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_constancia_inscripcion');
    }

    public function reporte(){
    	$horas = array(
    		8 => '8 a.m.',
    		9 => '9 a.m.',
    		10 => '10 a.m.',
    		11 => '11 a.m.',
    		12 => '12 p.m.',
    		13 => '1 p.m.',
    		14 => '2 p.m.',
    		15 => '3 p.m.',
    		16 => '4 p.m.',
    		17 => '5 p.m.',
    		18 => '6 p.m.',
    		19 => '7 p.m.',
    		20 => '8 p.m.',
    		21 => '9 p.m.',
    		22 => '10 p.m.',
    	);

        $ubicaciones = Ubicacion::where('ubiClave', '<>', '000')->get();

    	$fechaActual = Carbon::now('America/Merida');

    	return view('prefecteo/aulas_ocupadas.create',
            compact('horas','ubicaciones','fechaActual'));
    }// function reporte.

     public function imprimir(Request $request){

        $fechaActual = Carbon::now('America/Merida');

        $fechaRevision = $fechaActual->format('d/m/Y');

        $horarios = Horario::with('aula.ubicacion',
            'grupo.periodo.departamento',
            'grupo.plan.programa.escuela')
        ->whereHas('aula.ubicacion', function($query) use($request){
            if($request->ubicacion_id){
                $query->where('ubicacion_id',$request->ubicacion_id);
            }
        })
        ->whereHas('grupo.periodo.departamento',function($query) use($request){
            if($request->departamento_id){
                $query->where('departamento_id',$request->departamento_id);
            }
            if($request->periodo_id){
                $query->where('periodo_id',$request->periodo_id);
            }
        })
        ->whereHas('grupo.plan.programa.escuela',function($query) use($request){
            if($request->escuela_id){
                $query->where('escuela_id',$request->escuela_id);
            }
            if($request->programa_id){
                $query->where('programa_id',$request->programa_id);
            }
        })
        ->where(function($query) use($request){
            if($request->horas1 && $request->horas2){
                $query->whereBetween('ghInicio',[$request->horas1,$request->horas2]);
            }
            if($request->fecharev){
                $fechaRevision = $request->fecharev;
                $dia = Carbon::parse($fechaRevision)->dayOfWeek;
                $query->where('ghDia',$dia);
            }
        })->get();

        if($horarios->isEmpty()){
            alert()->warning('Ups...','No se han encontrado registros que coincidan con la
                información proporcionada');
            return back()->withInput();
        }

        $data = collect([]);

        foreach ($horarios as $key => $horario) {
            $ubiClave = $horario->aula->ubicacion->ubiClave;
            $ubiNombre = $horario->aula->ubicacion->ubiNombre;
            $aulaClave = $horario->aula->aulaClave;
            $aulaDescripcion = $horario->aula->aulaDescripcion;
            $aulaUbicacion = $horario->aula->aulaUbicacion;
            $progClave = $horario->grupo->plan->programa->progClave;
            $escClave = $horario->grupo->plan->programa->escuela->escClave;

            //Información del profesor / empleado.
            $empleado_id = $horario->grupo->empleado->id;
            $persona = $horario->grupo->empleado->persona;
            $perApellido1 = $persona->perApellido1;
            $perApellido2 = $persona->perApellido2;
            $perNombre = $persona->perNombre;
            $nombreCompleto = $perNombre.' '.$perApellido1;

            $data->push([
                'horario' => $horario,
                'ghInicio' => $horario->ghInicio,
                'ghFinal' => $horario->ghFinal,
                'ubicacion' => $ubiClave.' '.$ubiNombre,
                'aulaClave' => $aulaClave,
                'aulaDescripcion' => $aulaDescripcion,
                'aulaUbicacion' => $aulaUbicacion,
                'progClave' => $progClave,
                'escClave' => $escClave,
                'empleado_id' => $empleado_id,
                'nombreCompleto' => $nombreCompleto,
            ]);
        }// foreach horario.

        $data = $data->sortBy('aulaUbicacion')->groupBy('ghInicio')->sortKeys();

        // Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_aulas_ocupadas";
        //Cargar vista del PDF
        $pdf = PDF::loadView("prefecteo.pdf.pdf_aulas_ocupadas",[
        "data" => $data,
        "fechaActual" => $fechaActual->format('d/m/Y'),
        "horaActual" => $fechaActual->format('H:i:s'),
        "fechaRevision" => $fechaRevision,
        "nombreArchivo" => $nombreArchivo
        ]);

        return $pdf->stream($nombreArchivo.'.pdf');
     }// function imprimir.

}// Controller Class.
