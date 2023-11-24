<?php

namespace App\Http\Controllers\Archivos;

use DB;
use App\Models\Cgt;
use App\Models\Curso;
use Illuminate\Http\Request;
use App\Models\Inscrito;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AinscripcionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:a_inscripcion');
    }

    public function generar(){
        $ubicaciones = Ubicacion::sedes()->get();
        $tiposIngreso = array(
            'PI' => 'PRIMER INGRESO',
            'RI' => 'REINSCRIPCIÓN',
        );
        return View('archivo/inscripcion.create',compact('ubicaciones','tiposIngreso'));
    }



    public function generarArchivosPreinscritos($request, $departamento)
    {
        $cgtGrupo = Inscrito::with("curso.cgt.plan.programa", "grupo")
            ->whereHas('curso.periodo.departamento', static function ($query) use ($request) {
                $query->where('curTipoIngreso', "=", "PI");
                $query->whereIn("curEstado", ["R", "A", "C", "P"]);
                if ($request->departamento_id) {
                    $query->where('departamento_id', "=", $request->departamento_id);
                }

                if ($request->periodo_id) {
                    return $query->where('periodo_id', $request->periodo_id);
                }
            })
            ->whereHas('curso.cgt.plan.programa', static function($query) use ($request) {
                if($request->plan_id)
                    $query->where('plan_id', $request->plan_id);
                if($request->programa_id)
                    $query->where('programa_id', $request->programa_id);
                if($request->escuela_id)
                    $query->where('escuela_id', $request->escuela_id);
            })
            ->whereHas('curso.cgt.plan', static function ($query) use ($request) {
                $query->where('planRegistro', $request->tipo_registro);
            })
            ->whereHas('grupo', static function ($query) use ($request) {
                $query->where('gpoExtraCurr', "=", "N");
            })
        ->get();



        if ($departamento->depClave != "POS") {
            $cgtGrupo = $cgtGrupo->groupBy(function ($item, $key) {
                return $item->curso->cgt->id . "-" . $item->grupo->gpoClave . "-" . $item->grupo->gpoTurno;
            })->sortBy(function ($item, $key) {
                $cgt = explode( '-', trim($key) );
                $cgt = collect($cgt)->first();

                return $cgt;
            });
        }

        if ($departamento->depClave == "POS") {
            $cgtGrupo = $cgtGrupo->groupBy(function ($item, $key) {
                return $item->curso->cgt->id . "-" . $item->grupo->gpoClave . "-" . $item->grupo->gpoTurno . "-" . $item->curso->curOpcionTitulo;
            })->sortBy(function ($item, $key) {
                $cgt = explode( '-', trim($key) );
                $cgt = collect($cgt)->first();

                return $cgt;
            });
        }

        


        $folioIteradorSup = 0;
        $folioIteradorPos = 0;
        $folioIteradorPorDefecto = 0;
        $cgt   = "";
        $cgtId = "";
        foreach ($cgtGrupo as $grupos) {
            $cgt = $grupos->first();


            if ($cgt->curso->cgt->id != $cgtId) {
                $folioIteradorSup = 1;
                $folioIteradorPos = 1;
                $folioIteradorPorDefecto = 1;
            } else {
                $folioIteradorSup++;
                $folioIteradorPos++;
                $folioIteradorPorDefecto++;
            }
            $cgtId = $cgt->curso->cgt->id;


            $file = "";
            if ($cgt->curso->cgt->periodo->departamento->depClave == "SUP") {
                $filename = "insc_" . $cgt->curso->cgt->periodo->perNumero
                    . "_"    . $cgt->curso->cgt->periodo->perAnio
                    . "_PI_" . $cgt->curso->cgt->plan->programa->progClave
                    . "_"    . $cgt->curso->cgt->plan->planClave
                    . "_01"  . $cgt->curso->cgt->cgtGrupo
                    . "_"    . $cgt->curso->cgt->periodo->departamento->ubicacion->ubiClave
                    . "_mat" . str_pad($folioIteradorSup, 2, "0", STR_PAD_LEFT) . ".csv";

                $file = fopen(base_path().'/temp/03_Pre-Insc_Sup/Pendientes/' . $filename, 'w');

            

            } else if ($cgt->curso->cgt->periodo->departamento->depClave == "POS") {
                $curOpcionTitulo = ($cgt->curso->curOpcionTitulo == "N") ? "-ORD": "-TIT";


                $filename = "insc_" . $cgt->curso->cgt->periodo->perNumero
                    . "_"     . $cgt->curso->cgt->periodo->perAnio
                    . "_PI_"  . $cgt->curso->cgt->plan->programa->progClave
                    . "_"     . $cgt->curso->cgt->plan->planClave
                    . "_01"   . $cgt->curso->cgt->cgtGrupo
                    . "_"     . $cgt->curso->cgt->periodo->departamento->ubicacion->ubiClave
                    . "_mat"  . str_pad($folioIteradorPos, 2, "0", STR_PAD_LEFT) . $curOpcionTitulo . ".csv";

                $file = fopen(base_path().'/temp/04_Pre-Insc_Pos/Pendientes/' . $filename, 'w');
            } else {
                $filename = "insc_" . $cgt->curso->cgt->periodo->perNumero
                    . "_"    . $cgt->curso->cgt->periodo->perAnio
                    . "_PI_" . $cgt->curso->cgt->plan->programa->progClave
                    . "_"    . $cgt->curso->cgt->plan->planClave
                    . "_01"  . $cgt->curso->cgt->cgtGrupo
                    . "_"    . $cgt->curso->cgt->periodo->departamento->ubicacion->ubiClave
                    . "_mat" . str_pad($folioIteradorPorDefecto, 2, "0", STR_PAD_LEFT) . ".csv";

                $file = fopen(base_path() . '/temp/' . $filename, 'w');
            }


            $columns = [
                'CLAVE_ESCUELA', 'CLAVE_PLAN_ESTUDIO', 'NOMBRES',
                'APELLIDO_PATERNO', 'APELLIDO_MATERNO',
                'CURP', 'GRUPO', 'TURNO'
            ];
            if($cgt->curso->cgt->periodo->departamento->depClave == "POS") {
                $columns[] = 'TIPO_INGRESO';
            }
            

            // fputs($file, implode(",", $columns) . PHP_EOL);
            fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $columns)) . PHP_EOL);

            $inscritos = $grupos->unique("curso.id");
            
            foreach ($inscritos as $inscrito) {
                $ubicacion = "";
                if ($inscrito->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave == "CME") {
                    $ubicacion = 19;
                }
                if ($inscrito->curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave == "CVA") {
                    $ubicacion = 56;
                }

                # Si es POSGRADO, se agrega la columna tipo ingreso
                $campoTipoIngreso = "";
                if($inscrito->curso->periodo->departamento->depClave == "POS") {
                    $campoTipoIngreso = "," . ($inscrito->curso->curOpcionTitulo == 'N' ? 'INGRESO ORDINARIO' : 'OPCION DE TITULACION DE LICENCIATURA');
                }

                // si la curp tiene estos formatos se cambia por una cadena vacia para forzar un error
                $curp = (
                    $inscrito->curso->alumno->persona->perCurp == 'XEXX010101HNEXXXA4' 
                    || $inscrito->curso->alumno->persona->perCurp == 'XEXX010101HNEXXXA8'
                    || $inscrito->curso->alumno->persona->perCurp == 'XEXX010101MNEXXXA4'
                    || $inscrito->curso->alumno->persona->perCurp == 'XEXX010101MNEXXXA8'
                ) ? '' : $inscrito->curso->alumno->persona->perCurp;
                $row_info = $ubicacion
                    . "," . $inscrito->curso->cgt->plan->planClave
                    . "," . $inscrito->curso->alumno->persona->perNombre
                    . "," . $inscrito->curso->alumno->persona->perApellido1
                    . "," . $inscrito->curso->alumno->persona->perApellido2
                    . "," . $curp
                    . "," . $inscrito->grupo->gpoClave
                    . "," . $inscrito->grupo->gpoTurno
                    . $campoTipoIngreso; #Se agrega solo si es POSGRADO
                
                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $row_info) . PHP_EOL);
            }

            fclose($file);
        }
    }


    public function generarArchivosReinscritos($request, $departamento)
    {
        $cgtGrupo = Inscrito::with("curso.cgt.plan.programa", "grupo")
            ->whereHas('curso.periodo.departamento', function ($query) use ($request) {
                $query->where('curTipoIngreso', "=", "RI");
                $query->whereIn("curEstado", ["R", "A", "C", "P"]);
                if ($request->departamento_id) {
                    $query->where('departamento_id', "=", $request->departamento_id);
                }

                if ($request->periodo_id) {
                    return $query->where('periodo_id', $request->periodo_id);
                }
            })
            ->whereHas('curso.cgt.plan.programa', static function($query) use ($request) {
                if($request->plan_id)
                    $query->where('plan_id', $request->plan_id);
                if($request->programa_id)
                    $query->where('programa_id', $request->programa_id);
                if($request->escuela_id)
                    $query->where('escuela_id', $request->escuela_id);
            })
            ->whereHas('curso.cgt.plan', static function ($query) use ($request) {
                $query->where('planRegistro', $request->tipo_registro);
            })
            ->whereHas('grupo', function ($query) use ($request) {
                $query->where('gpoExtraCurr', "=", "N");
            })
        ->get();




        
        if ($departamento->depClave != "POS") {
            $cgtGrupo = $cgtGrupo->groupBy(function ($item, $key) {
                return $item->curso->cgt->id . "-" . $item->grupo->gpoClave . "-" . $item->grupo->gpoTurno;
            })->sortBy(function ($item, $key) {
                $cgt = explode( '-', trim($key) );
                $cgt = collect($cgt)->first();
    
                return $cgt;
            });
        }

        if ($departamento->depClave == "POS") {
            $cgtGrupo = $cgtGrupo->groupBy(function ($item, $key) {
                return $item->curso->cgt->id . "-" . $item->grupo->gpoClave . "-" . $item->grupo->gpoTurno . "-" . $item->curso->curOpcionTitulo;
            })->sortBy(function ($item, $key) {
                $cgt = explode( '-', trim($key) );
                $cgt = collect($cgt)->first();

                return $cgt;
            });
        }


        $folioIteradorSup = 0;
        $folioIteradorPos = 0;
        $folioIteradorPorDefecto = 0;
        $cgt   = "";
        $cgtId = "";
        foreach ($cgtGrupo as $grupos) {
            $cgt = $grupos->first();


            if ($cgt->curso->cgt->id != $cgtId) {
                $folioIteradorSup = 1;
                $folioIteradorPos = 1;
                $folioIteradorPorDefecto = 1;
            } else {
                $folioIteradorSup++;
                $folioIteradorPos++;
                $folioIteradorPorDefecto++;
            }

            $cgtId = $cgt->curso->cgt->id;


            $file = "";
            if ($cgt->curso->cgt->periodo->departamento->depClave == "SUP") {
                $filename = "insc_" . $cgt->curso->cgt->periodo->perNumero
                    . "_"    . $cgt->curso->cgt->periodo->perAnio
                    . "_RI_" . $cgt->curso->cgt->plan->programa->progClave
                    . "_"    . $cgt->curso->cgt->plan->planClave
                    . "_"    . str_pad($cgt->curso->cgt->cgtGradoSemestre, 2, "0", STR_PAD_LEFT) . $cgt->curso->cgt->cgtGrupo
                    . "_"    . $cgt->curso->cgt->periodo->departamento->ubicacion->ubiClave
                    . "_mat" . str_pad($folioIteradorSup, 2, "0", STR_PAD_LEFT)
                    . "_"    . $cgt->grupo->gpoClave . ".csv";

                $file = fopen(base_path() . '/temp/05_Re-Insc_Sup/Pendientes/' . $filename, 'w');
            } else if ($cgt->curso->cgt->periodo->departamento->depClave == "POS") {
                $curOpcionTitulo = ($cgt->curso->curOpcionTitulo == "N") ? "-ORD": "-TIT";


                $filename = "insc_" . $cgt->curso->cgt->periodo->perNumero
                    . "_"    . $cgt->curso->cgt->periodo->perAnio
                    . "_RI_" . $cgt->curso->cgt->plan->programa->progClave
                    . "_"    . $cgt->curso->cgt->plan->planClave
                    . "_"    . str_pad($cgt->curso->cgt->cgtGradoSemestre, 2, "0", STR_PAD_LEFT) . $cgt->curso->cgt->cgtGrupo
                    . "_"    . $cgt->curso->cgt->periodo->departamento->ubicacion->ubiClave
                    . "_mat" . str_pad($folioIteradorPos, 2, "0", STR_PAD_LEFT)
                    . "_"    . $cgt->grupo->gpoClave . ".csv";
                    // . "_mat" . $folioIteradorPos . $curOpcionTitulo . ".csv";

                $file = fopen(base_path() . '/temp/06_Re-Insc_Pos/Pendientes/' . $filename, 'w');

            } else {
                $filename = "insc_" . $cgt->curso->cgt->periodo->perNumero
                    . "_"    . $cgt->curso->cgt->periodo->perAnio
                    . "_RI_" . $cgt->curso->cgt->plan->programa->progClave
                    . "_"    . $cgt->curso->cgt->plan->planClave
                    . "_"    . str_pad($cgt->curso->cgt->cgtGradoSemestre, 2, "0", STR_PAD_LEFT) . $cgt->curso->cgt->cgtGrupo
                    . "_"    . $cgt->curso->cgt->periodo->departamento->ubicacion->ubiClave
                    . "_mat" . str_pad($folioIteradorPorDefecto, 2, "0", STR_PAD_LEFT)
                    . "_"    . $cgt->grupo->gpoClave . ".csv";

                $file = fopen(base_path() . '/temp/' . $filename, 'w');
            }


            $columns = [
                'MATRICULA', 'CURSO', 'GRUPO', 'TURNO'
            ];
            

            fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", implode(",", $columns)) . PHP_EOL);


            $inscritos = $grupos->unique("curso.id");
            
            foreach ($inscritos as $inscrito) {
                $row_info = $inscrito->curso->alumno->aluMatricula
                    . "," .  $inscrito->grupo->gpoSemestre
                    . "," .  $inscrito->grupo->gpoClave
                    . "," .  $inscrito->grupo->gpoTurno;

                fputs($file, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $row_info) . PHP_EOL);
            }

            fclose($file);
        }
    }



    public function descargar (Request $request)
    {
        $departamento = Departamento::where("id", "=", $request->departamento_id)->first();

        if ($request->tipo_ingreso == "PI") {
            $this->generarArchivosPreinscritos($request, $departamento);
        }

        if ($request->tipo_ingreso == "RI") {
            $this->generarArchivosReinscritos($request, $departamento);
        }

        return redirect()->back()->withInput();
    }



}