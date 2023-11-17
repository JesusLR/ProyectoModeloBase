<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Models\Curso;
use App\Http\Models\Municipio;
use App\Http\Models\Ubicacion;
use App\Http\Models\Programa;
use App\Http\Models\Periodo;

use Carbon\Carbon;
use PDF;
use DB;

class DatosGeneralesController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('permisos:r_plantilla_profesores');
    	set_time_limit(8000000);
    }

    public function reporte(){
    	//Filtra por Alumnos preinscritos, inscritos, todos
    	$aluPIT = [
    		"P" => 'PREINSCRITO', #Incluye Condicionados y asistentes.
    		"I" => "INSCRITO",
    		"T" => "TODOS"
    	];
    	//Filtra Alumnos por Nuevo ingreso, reingreso y todos
    	$aluNRT = [
    		"N" => "NUEVO INGRESO",
    		"R" => "REINGRESO",
    		"T" => "TODOS"
    	];

    	return view('reportes/rel_datos_generales.create',[
    		'aluPIT' => $aluPIT,
    		'aluNRT' => $aluNRT,
            'ubicaciones' => Ubicacion::where('ubiClave', '<>', '000')->get()
    		]);
    }//FIN function reporte

    public function dateDMY($fecha){
    	if($fecha){
    	$f = Carbon::parse($fecha)->format('d/m/Y');
    	return $f;
    	}
    }//FIN functiondateDMY

    public function obtenerRecursos($request){

    	$periodo = Periodo::findOrFail($request->periodo_id);
    	$ubicacion = $periodo->departamento->ubicacion;
        $programa = Programa::findOrFail($request->programa_id);

    	$cursos = Curso::with('cgt.plan.programa.escuela.departamento.ubicacion','periodo','alumno.persona')
    	  ->where(function($query) use ($request){
    	  	if($request->aluPIT){
    	  		if($request->aluPIT == 'P'){
    	  			$query->where('curEstado',$request->aluPIT)
    	  			      ->orWhere('curEstado','A')
    	  				  ->orWhere('curEstado','C');
    	  		}
    	  		if($request->aluPIT == 'I'){
    	  			$query->where('curEstado','R');
    	  		}
    	  	}
            $query->where('periodo_id', $request->periodo_id);
    	  })

    	  ->whereHas('cgt.plan.programa.escuela.departamento.ubicacion',function($query) use ($request){
			$query->where('programa_id', $request->programa_id);
			if($request->cgtGradoSemestre){
				$query->where('cgtGradoSemestre',$request->cgtGradoSemestre);
			}
			if($request->cgtGrupo){
				$query->where('cgtGrupo',$request->cgtGrupo);
			}
    	  })
    	  ->whereHas('alumno.persona',function($query) use ($request){
    	  	if($request->aluMatricula){
    	  		$query->where('aluMatricula',$request->aluMatricula);
    	  	}
    	  	if($request->aluNRT){
    	  		if($request->aluNRT == 'N'){
    	  			$query->where('aluEstado',$request->aluNRT);
    	  		}
    	  		if($request->aluNRT == 'R'){
    	  			$query->where('aluEstado',$request->aluNRT);
    	  		}
    	  	}
    	  	if($request->perApellido1){
    	  		$query->where('perApellido1',$request->perApellido1);
    	  	}
    	  	if($request->perApellido2){
    	  		$query->where('perApellido2',$request->perApellido2);
    	  	}
    	  	if($request->perNombre){
    	  		$query->where('perNombre',$request->perNombre);
    	  	}
    	  })
    	  ->get();

          if($cursos->isEmpty()) {
            return false;
          }

    	  $recursos = [
    	  	'cursos'    => $cursos,
    	  	'periodo' => $periodo,
    	  	'programa' => $programa,
    	  	'ubicacion' => $ubicacion
    	  ];

    	  return $recursos;
    }//FIN function obtenerRecursos

    public function datosGenerales($recursos){
    	$datos = collect([]);
    	$fechaActual = Carbon::now('CDT');
    	$horaActual = $fechaActual->format('H:i:s');
    	$cursos = $recursos['cursos']; 
    	$periodo = $recursos['periodo'];
    	$programa = $recursos['programa'];
    	$ubicacion = $recursos['ubicacion'];

    	$cursos = $cursos->map(function($item,$key){
    		return $item->id;
    	});

    	foreach($cursos as $curso_id){
    		$curso = Curso::where('id', $curso_id)->first();
    		$ubiClave = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave;
    		$ubiNombre = $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre;
    		$progClave = $curso->cgt->plan->programa->progClave;
    		$progNombre = $curso->cgt->plan->programa->progNombre;
    		$aluClave = $curso->alumno->aluClave;
    		$aluMatricula = $curso->alumno->aluMatricula;
    		$aluAp1 = $curso->alumno->persona->perApellido1;
    		$aluAp2 = $curso->alumno->persona->perApellido2;
    		$aluNom = $curso->alumno->persona->perNombre;
    		$nomCompleto = $aluAp1.' '.$aluAp2.' '.$aluNom;
    		$aluGrado = $curso->cgt->cgtGradoSemestre;
    		$aluGrupo = $curso->cgt->cgtGrupo;
    		$aluSexo = $curso->alumno->persona->perSexo;
    		$aluFechaIngr = $curso->alumno->aluFechaIngr; #Fecha de Ingreso
    		$aluNac = $curso->alumno->persona->perFechaNac; #Nacimiento
    		$aluEdad = Carbon::parse($aluNac)->age; #Obtener edad de Alumno
    		$aluEstado = $curso->alumno->aluEstado;
    		$curEstado = $curso->curEstado;

    		//Cambiar Formato de fechas.
    		$aluFechaIngr = $this->dateDMY($aluFechaIngr);
    		$aluNac = $this->dateDMY($aluNac);

    		//Obtener lugar de Nacimiento
    		$munId = $curso->alumno->persona->municipio_id;
    		$munId = Municipio::where('id',$munId)->first();
    		$munNombre = $munId->munNombre;
    		$edoNombre = $munId->estado->edoNombre;
    		$paisNombre = $munId->estado->pais->paisNombre;
    		$paisId = $munId->estado->pais->id; # MexicoID = 1
    		//Si el alumno es extranjero, se muestra "Estado, Pais"
    		if($paisId == 1){
    			$lugarNac = $munNombre.', '.$edoNombre; #Municipio, Estado.
    		}else{
    			$lugarNac = $edoNombre.', '.$paisNombre; #Estado, Pais.
    		}

    		//Obtener preparatoria de procedencia.
    		$prepId = $curso->alumno->preparatoria_id;
    		$prepa = DB::table('preparatorias')
    			->where('id',$prepId)
    			->value('prepNombre');

    		//Variable para ordenar Items de $datos([])
    		$aluOrden = $ubiClave.$progClave.$aluGrado.$aluGrupo.$nomCompleto;

    		$datos->push([
    			"ubiClave" => $ubiClave,
    			"ubiNombre" => $ubiNombre,
    			"progClave" => $progClave,
    			"progNombre" => $progNombre,
    			"aluClave" => $aluClave,
    			"aluMatricula" => $aluMatricula,
    			"aluAp1" => $aluAp1,
    			"aluAp2" => $aluAp2,
    			"aluNom" => $aluNom,
    			"nomCompleto" => $nomCompleto,
    			"aluGrado" => $aluGrado,
    			"aluGrupo" => $aluGrupo,
    			"gradoGrupo" => 'Grado: '.$aluGrado.' Grupo: '.$aluGrupo,
    			"aluSexo" => $aluSexo,
    			"aluFechaIngr" => $aluFechaIngr,
    			"aluNac" => $aluNac,
    			"aluEdad" => $aluEdad,
    			"lugarNac" => $lugarNac,
    			"aluNac" => $aluNac,
    			"prepa" => $prepa,
    			"curEstado" => $curEstado,
    			"aluEstado" => $aluEstado,
    			"aluOrden" => $aluOrden
    		]);
    	}//FIN foreach cursos

    	//Ordenar Items de $datos.
    	$datos = $datos->sortBy('aluOrden');

    	//Info de Periodo
    	$perFechaI = $this->dateDMY($periodo->perFechaInicial);
    	$perFechaF = $this->dateDMY($periodo->perFechaFinal);
    	$perNumero = $periodo->perNumero;
    	$perAnio = $periodo->perAnio;
    	$perDatos = $perFechaI.' - '.$perFechaF.' ('.$perNumero.'/'.$perAnio.')';

    	// Unix
		setlocale(LC_TIME, 'es_ES.UTF-8');
		// En windows
		setlocale(LC_TIME, 'spanish');
    	//Nombre del archivo PDF de descarga
    	$nombreArchivo = "pdf_datos_generales";
		//Cargar vista del PDF
		$pdf = PDF::loadView("reportes.pdf.pdf_datos_generales", [
		"datos" => $datos,
		"periodo" => $periodo,
		"perDatos" => $perDatos,
		"programa" => $programa,
		"ubicacion" => $ubicacion,
        "perAnio" => $perAnio,
        "perNumero" => $perNumero,
      	"fechaActual" => $this->dateDMY($fechaActual),
      	"horaActual" => $horaActual,
      	"anio" => $fechaActual->format('Y'),
      	"nombreArchivo" => $nombreArchivo.'.pdf'
    	]);
		$pdf->setPaper('letter', 'portrait');
		$pdf->defaultFont = 'Times Sans Serif';
		return $pdf->stream($nombreArchivo.'.pdf');
		return $pdf->download($nombreArchivo.'.pdf');
    }//FIN function datosGenerales

    public function imprimir(Request  $request){
    	$recursos = $this->obtenerRecursos($request);

        if(!$recursos) {
            alert()->warning('Sin datos', 'No hay registros que coincidan con la información proporcionada. Favor de verificar.')->showConfirmButton();
            return back()->withInput();
        }
    	return $this->datosGenerales($recursos);
    }//FIN function imprimir
}//FIN Controller class
