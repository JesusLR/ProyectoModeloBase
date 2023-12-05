<?php

namespace App\Http\Controllers\Reportes;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Egresado;
use App\Models\Ubicacion;

use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

//Modificado 29.01.2020 jmanuel.lopez
class ResumenTituladosController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){
    	$fechaActual = Carbon::now('CDT');

        //Departamentos permitidos por este módulo.
        $departamentos = [
            'SUP' => 'SUP',
            'POS' => 'POS',
            'T' => 'TODOS (SUP, POS)'
        ];

        $ubicaciones = Ubicacion::where('ubiClave','<>','000')
            ->pluck('ubiNombre','ubiClave');

    	return view('reportes/resumen_titulados.create',
    			compact('fechaActual','departamentos','ubicaciones'));
    }//function reporte.

    public function dateDMY($fecha){
        if($fecha){
        $f = Carbon::parse($fecha)->format('d/m/Y');
        return $f;
        }
    }//FIN function dateDMY

    public function imprimir(Request $request){

        $data = collect([]);
    	$fechaActual = Carbon::now('CDT');
        $tipoReporte = 'P';
        if($request->tipoReporte && $request->tipoReporte == 'E'){
            $tipoReporte = 'E';
        }

        $titulados = Egresado::with('periodoTitulacion.departamento.ubicacion',
            'plan.programa.escuela')
        ->whereHas('periodoTitulacion.departamento.ubicacion',function($query) use($request){
            if($request->ubiClave){
                $query->where('ubiClave',$request->ubiClave);
            }
            if($request->depClave){
                if($request->depClave != 'T'){
                    $query->where('depClave',$request->depClave);
                }else{
                    $query->whereIn('depClave',['SUP','POS']);
                }
            }
            if($request->perAnio){
                $query->where('perAnio',$request->perAnio);
            }
            if($request->perNumero){
                $query->where('perNumero',$request->perNumero);
            }
        })
        ->whereHas('plan.programa.escuela',function($query) use($request){
            if($request->progClave){
                $query->where('progClave',$request->progClave);
            }
        })
        ->get();

        $total = count($titulados);
        if($total < 1){
            alert()->warning('Ups...','No hay registros que coincidan con la
                información proporcionada. Favor de verificar.');
            return back()->withInput();
        }

        $registro1 = $titulados->first();
        $ubicacion = $registro1->periodoTitulacion->departamento->ubicacion;

        $escuelas = $titulados->mapToGroups(function($item,$key) use($titulados){
            $escClave = $item->plan->programa->escuela->escClave;
            $periodoTitulacion = $item->periodoTitulacion;
            $programa = $item->plan->programa;
            $total = $titulados->filter(function($item,$key) use($programa){
                return $item->plan->programa->progClave == $programa->progClave;
            })->count();

            return [$escClave => [
                'perNumero' => $periodoTitulacion->perNumero,
                'perAnio' => $periodoTitulacion->perAnio,
                'progClave' => $programa->progClave,
                'progNombre' => $programa->progNombre,
                'total' => $total
            ]];
        })->map(function($item,$key){
            return $item->unique('progClave');
        });


    	// Unix
        setlocale(LC_TIME, 'es_ES.UTF-8');
        // En windows
        setlocale(LC_TIME, 'spanish');
        //Nombre del archivo PDF de descarga
        $nombreArchivo = "pdf_resumen_titulados.pdf";
        //Cargar vista del PDF
        $pdf = PDF::loadView("reportes.pdf.pdf_resumen_titulados", [
        "escuelas" => $escuelas,
        "total" => $total,
        "ubicacion" => $ubicacion->ubiClave.' '.$ubicacion->ubiNombre,
        "tipoReporte" => $tipoReporte,
        "fechaActual" => $this->dateDMY($fechaActual),
        "horaActual" => $fechaActual->format('H:i:s'),
        "nombreArchivo" => $nombreArchivo
        ]);
        $pdf->setPaper('letter', 'portrait');
        $pdf->defaultFont = 'Times Sans Serif';
        return $pdf->stream($nombreArchivo);
        return $pdf->download($nombreArchivo);
    }//function imprimir.
} //Controller class.
