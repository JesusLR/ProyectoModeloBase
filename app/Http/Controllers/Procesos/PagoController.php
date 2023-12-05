<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Helpers\Utils;
use Carbon\Carbon;
use Debugbar;
use File;
use Auth;
use DB;
use Storage;



use App\Models\Curso;
use App\Models\Edocta;
use App\Models\Alumno;
use App\Models\Ficha;
use App\Models\Referencia;
use App\Models\UsuaGim;
use App\Models\Idioma;
use App\Models\InscProg;
use App\Models\Aextra;
use App\Models\ConcAextra;
use App\Models\Pago;

class PagoController extends Controller
{

    protected $leidos;
    protected $descar;
    protected $aplicad;
    protected $repetid;
    protected $yaproc;
    protected $invalid;
    protected $buenos;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permisos:p_pago');
        $this->leidos = 0;
        $this->descar = 0;
        $this->aplicad = 0;
        $this->repetid = 0;
        $this->yaproc = 0;
        $this->invalid = 0;
        $this->buenos = 0;
    }

    public function subir(){

        $aplicar = false;
        return View('procesos/pago.upload',compact('aplicar'));
    }

    public function aplicar(Request $request){
        if($request->post('upload')){
            //OBTIENE INFORMACIÓN DEL ARCHIVO
            $file = $request->file('filePagos');
            //SUBIENDO ARCHIVO
            if($file == null){
                alert()
                ->error('Ups...',"Selecione al menos un archivo")
                ->showConfirmButton();
                return redirect('proceso/pago')->withInput();
            }
            $ext = $file->getClientOriginalExtension();
            //VALIDANDO EXTENSIÓN
            if($ext != "exp"){
                alert()
                ->error('Ups...',"Archivo no válido")
                ->showConfirmButton();
                return redirect('proceso/pago')->withInput();
            }
            //SUBE EL ARCHIVO A LA CARPETA
            $file->move('uploads','pagos.exp');


            //PRODUCCION
             //$path = public_path()."\uploads\pagos.exp";

            $path = public_path()."/uploads/pagos.exp";
            //LOCALHOST
            
            //$path = 'C:/wamp64/www/scem_administrativo/public/uploads/pagos.exp';
            //$path = 'D:/Web/WWW/scem_administrativo/public/uploads/pagos.exp';

            // dd("LOAD DATA LOCAL INFILE '".$path."' INTO TABLE edocta_temp character set 'latin1' FIELDS TERMINATED BY '\\t' LINES TERMINATED BY '\\n'");
            // return;

            //HACE UN TRUNCATE A LA TABLA EDOCTA TEMP
            DB::connection()->getPdo()->exec("truncate table edocta_temp");
            //SUBE EL ARCHIVO A LA TABLA EDOCTA TEMP
            $query = "LOAD DATA LOCAL INFILE '" . $path . "' INTO TABLE edocta_temp character set 'latin1' FIELDS TERMINATED BY '\\t' LINES TERMINATED BY '\\n'";
            DB::connection()->getPdo()->exec($query);
            alert('Escuela Modelo', 'El archivo se subio con éxito','success')->autoclose(2000);
            $aplicar = true;
            return view('procesos/pago.upload',compact('aplicar'));
        }else{
            $aplicar = false;
            $userId = Auth::id();
            $result = DB::select('call procEdocta('.$userId.')');



            $descar     = $result[0]->descartados;
            $leidos     = $result[0]->leidos;
            $buenos     = $result[0]->buenos;
            $invalid    = $result[0]->invalidos;
            $yaproc     = $result[0]->yaprocesados;
            $aplicad    = $result[0]->aplicados;
            $repetid    = $result[0]->repetidos;


            // $descar     = 0;
            // $leidos     = 0;
            // $buenos     = 0;
            // $invalid    = 0;
            // $yaproc     = 0;
            // $aplicad    = 0;
            // $repetid    = 0;



            alert('Escuela Modelo', 'Los pagos se aplicaron con éxito','success')->autoclose(2000);
            return View('procesos/pago.upload',compact('leidos','descar','aplicad','repetid','yaproc','invalid','buenos','aplicar'));
        }
    }

    private function agregarEstadoDeCuenta($linearray){
        $fecha      = $linearray[0];
        try {
            $fecha = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        }
        catch (Exception $err) {
            //dd($linearray);
            //dd($err);
        }
        $refer      = substr($linearray[1], 2,20);
        $cvepag     = substr($refer, 0,8);
        $numref     = substr($refer, 8,4);
        $cargo      = $linearray[2];
        //INICIAR VARIABLES DEL CAMPO ESTADO DE CUENTA TABLA EDOCTA
        $edoFechaOper   =  "";
        $edoAnioPago    =  "";
        $edoClaveAlu    =  "";
        $edoMesPago     =  "";
        $edoDigPago     =  "";
        $edoDescripcion =  "";
        $edoImpAbono    =  0;
        $edoImpCargo    =  0;
        $edoEstado      =  "";

        //////////// VERIFICA SI LA REFERENCIA SE ENCUENTRA EN LA TABLA REFERENCIAS ////////////
        //////////// SI ES ASÍ PONE LOS DATOS DEL PAGO EN ESA TABLA ////////////
        $referencia = Referencia::with('alumno')
                    ->whereHas('alumno', function($query) use ($cvepag) {
                        $query->where('aluClave',$cvepag);
                    })
                    ->where('refNum',$numref)
                    ->first();
        if($referencia){
            // SETEA LAS VARIABLES CON VALORES
            $edoAnioPago = $referencia->refAnioPer;
            $edoClaveAlu = $referencia->alumno->aluClave;
            $edoMesPago = $referencia->refConcPago;
            $edoDigPago = "";
            $edoDescripcion = "#".$numref;
        }else{
            //////////// LOS DATOS DE PAGO ESTAN EN EL REGISTRO DE FICHAS ////////////
            if(substr($refer, 0,4) == '9999'){
                $folio_ficha = substr($refer, 4,8);
                $ficha = Ficha::where('id',$folio_ficha)->first();
                if($ficha){
                    // SETEA LAS VARIABLES CON VALORES
                    $edoAnioPago = $ficha->fchAnioPer;
                    $edoClaveAlu = $ficha->fchClaveAlu;
                    $edoMesPago = $ficha->fchConc;
                    $edoDigPago = "";
                    $edoDescripcion = $ficha->fchClaveProgAct." (ProEdCon)";
                }
            }else{
                // SETEA LAS VARIABLES CON VALORES
                $edoAnioPago = "20" . substr($refer, 8,2);
                $edoClaveAlu = substr($refer, 0,8);
                $edoMesPago = substr($refer, 10,2);
                $edoDigPago = "";
                $edoDescripcion = "Refer: " . substr($refer,   12,8);
            }
        }
        // SETEA LAS VARIABLES CON VALORES
        $edoImpAbono    = 0;
        $edoImpCargo    = $cargo;
        $edoFechaOper   = $fecha;

        //////////// VALIDA SI ES UN USUARIO DE GYMNASIO ////////////
        if(substr($refer, 0,4) == '0000'){
            if(UsuaGim::where('id',$cvepag)->exists()){
                $edoEstado = "V";
                $this->buenos++;
            }else{
                $edoEstado = "N";
                $this->invalid++;
            }
        }else{
            if(Alumno::where('aluClave',$cvepag)->exists()){
                $edoEstado = "V";
                $this->buenos++;
            }else{
                $edoEstado = "N";
                $this->invalid++;
            }
        }
        //////////// INSERTAR REGISTRO EN ESTADO DE CUENTA TABLA EDOCTA ////////////
        try{
            Edocta::create([
                'edoFechaOper'      => $edoFechaOper,
                'edoAnioPago'       => $edoAnioPago,
                'edoClaveAlu'       => $edoClaveAlu,
                'edoMesPago'        => $edoMesPago,
                'edoDigPago'        => $edoDigPago,
                'edoDescripcion'    => $edoDescripcion,
                'edoImpAbono'       => Utils::convertNumber($edoImpAbono),
                'edoImpCargo'       => Utils::convertNumber($edoImpCargo),
                'edoEstado'         => $edoEstado
            ]);
        }catch(QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                //REGISTRO DUPLICADO O YA PROCESADO
                $this->yaproc++;
            }
        }
    }//TERMINA LECTURA DEL ESTADO DE CUENTA Y ALMACENAMIENTO EN EDOCTA



    private function agregarPagos(){

        $edoctas = Edocta::where('edoEstado','V')->orWhere('edoEstado','R')->get();
        foreach ($edoctas as $edocta) {
            $pagClaveAlu = $edocta->edoClaveAlu;
            $pagAnioPer = $edocta->edoAnioPago;
            $pagConcPago = $edocta->edoMesPago;
            $pagFechaPago = $edocta->edoFechaOper;
            $pagImpPago = $edocta->edoImpCargo;

            if(substr($edocta->edoDescripcion, 0,1) == '#'){
                $pagRefPago = substr($edocta->edoDescripcion, 0,5);
            }else{
                if((int)$pagConcPago >= 90 && (int)$pagConcPago <= 98){
                    $pagRefPago = substr($edocta->edoDescripcion, 0,4);
                }else{
                    $pagRefPago = substr($edocta->edoAnioPago, 2,4).$edocta->edoMesPago;
                }
            }
            $pagDigVer = "";
            $pagEstado = "A";
            $pagObservacion = "P";
            $pagFormaAplico = "A";
            $pagComentario = "";
            //Solo para pagos del gimnasio que se pueden recontraduplicar
            if(substr($pagClaveAlu, 0,4) == "0000"){
                if(UsuaGim::where('id',$pagClaveAlu)->exists()){
                    try{
                        Pago::create([
                            'pagClaveAlu'       => $pagClaveAlu,
                            'pagAnioPer'        => Utils::convertNumber($pagAnioPer),
                            'pagConcPago'       => $pagConcPago,
                            'pagFechaPago'      => $pagFechaPago,
                            'pagImpPago'        => Utils::convertNumber($pagImpPago),
                            'pagRefPago'        => $pagRefPago,
                            'pagDigVer'         => $pagDigVer,
                            'pagEstado'         => $pagEstado,
                            'pagObservacion'    => $pagObservacion,
                            'pagFormaAplico'    => $pagFormaAplico,
                            'pagComentario'     => $pagComentario
                        ]);
                        $edocta->edoEstado = "A";
                        $this->aplicad++;
                    }catch(QueryException $e){
                        $errorCode = $e->errorInfo[1];
                        if($errorCode == 1062){
                            //REGISTRO DUPLICADO O YA PAGADO
                            $edocta->edoEstado = "R";
                            $this->repetid++;
                        }
                    }
                }
            }else{
                ///////////////////FALLA
                $pago = true;
                # Busca si pagó el programa indicado en ref_pago_pag
                if((int)$pagConcPago >= 90 && (int)$pagConcPago <= 98){
                    $pago = Pago::where('pagClaveAlu',$pagClaveAlu)
                    ->where('pagAnioPer',Utils::convertNumber($pagAnioPer))
                    ->where('pagConcPago',$pagConcPago)
                    ->where('pagFechaPago',$pagFechaPago)
                    ->where('pagImpPago',Utils::convertNumber($pagImpPago))
                    ->where('pagRefPago',$pagRefPago)->exists();
                }else{
                    $pago = Pago::where('pagClaveAlu',$pagClaveAlu)
                    ->where('pagAnioPer',Utils::convertNumber($pagAnioPer))
                    ->where('pagConcPago',$pagConcPago)
                    ->where('pagFechaPago',$pagFechaPago)
                    ->where('pagImpPago',Utils::convertNumber($pagImpPago))->exists();
                }
                if($pago){
                    //REGISTRO DUPLICADO O YA PAGADO
                    $edocta->edoEstado = "R";
                    $this->repetid++;
                }else{
                    if(Alumno::where('aluClave','like',$pagClaveAlu)->exists()){
                        try{
                            Pago::create([
                                'pagClaveAlu'       => $pagClaveAlu,
                                'pagAnioPer'        => Utils::convertNumber($pagAnioPer),
                                'pagConcPago'       => $pagConcPago,
                                'pagFechaPago'      => $pagFechaPago,
                                'pagImpPago'        => Utils::convertNumber($pagImpPago),
                                'pagRefPago'        => $pagRefPago,
                                'pagDigVer'         => $pagDigVer,
                                'pagEstado'         => $pagEstado,
                                'pagObservacion'    => $pagObservacion,
                                'pagFormaAplico'    => $pagFormaAplico,
                                'pagComentario'     => $pagComentario
                            ]);
                            $edocta->edoEstado = "A";
                            $this->aplicad++;
                        }catch(QueryException $e){
                            $errorCode = $e->errorInfo[1];
                            if($errorCode == 1062){
                                //REGISTRO DUPLICADO O YA PAGADO
                                $edocta->edoEstado = "R";
                                $this->repetid++;
                            }
                        }
                    }
                }
            }
            //ACTUALIZA LOS CAMBIOS DE ESTADO EN EDOCTA
            $edocta->save();
            if($edocta->edoEstado == "A"){
                if(substr($edocta->edoDescripcion, 0,1) == "#"){
                    //ACTUALIZAR EL ESTADO DE LA REFERENCIA
                    $cvepag = $pagClaveAlu;
                    $numref = substr($pagRefPago, 1,5);
                    Referencia::with('alumno')
                    ->whereHas('alumno', function($query) use ($cvepag) {
                        $query->where('aluClave',$cvepag);
                    })->where('refNum',$numref)
                    ->update(['refUsuarioAplico' => Auth::user()->id,'refFechaAplico' => Carbon::now(),'refEstado' => 'A']);
                    //ELIMINA LOS ESTADO DE REFERENCIA CON ESTADO P
                    Referencia::with('alumno')
                    ->whereHas('alumno', function($query) use ($cvepag) {
                        $query->where('aluClave',$cvepag);
                    })
                    ->where('refAnioPer',$pagAnioPer)
                    ->where('refConcPago',$pagConcPago)
                    ->where('refEstado','P')->delete();
                }//TERMINA DE VALIDAR REFERENCIA
                switch ($pagConcPago) {
                    case "49":
                        //ACTUALIZA EL ESTADO IDIOMAS A REGULAR EN PERIODO 3
                        Idioma::where('curClaveAlu',$pagClaveAlu)
                        ->where('curAnioPer',$pagAnioPer)
                        ->where('curNumPer',3)->update(['curEstado' => 'R']);
                        break;
                    case "50":
                        //ACTUALIZA EL ESTADO IDIOMAS A REGULAR EN PERIODO 1
                        Idioma::where('curClaveAlu',$pagClaveAlu)
                        ->where('curAnioPer',$pagAnioPer + 1)
                        ->where('curNumPer',1)->update(['curEstado' => 'R']);
                        break;
                    case "90":
                        //ACTUALIZA EL ESTADO DE INSCRITO PROGRAMA A REGULAR
                        InscProg::where('inscClaveAlu',$pagClaveAlu)
                        ->where('inscNumIdProg',$pagRefPago)->update(['inscEstado' => 'R']);
                        break;
                    case "99":
                        $cvepag = $pagClaveAlu;
                        $pagAnioPer = $pagAnioPer;
                        //ACTUALIZA EL ESTADO DEL CURSO A REGULAR
                        $curso = Curso::with('alumno','periodo')
                        ->whereHas('alumno', function($query) use ($cvepag) {
                            $query->where('aluClave',$cvepag);
                        })
                        ->whereHas('periodo', function($query) use ($pagAnioPer) {
                            $query->where('PerNumero',0)->orWhere('perNumero',3);
                            $query->where('PerAnio',$pagAnioPer);
                        })->first();
                        if($curso){
                            $curso->curEstado = 'R';
                            //ACTUALIZA EL ESTADO DEL ALUMNO A REGULAR
                            if($curso->alumno->aluEstado == 'E'){
                                $curso->alumno->aluEstado = 'R';
                            }
                            $curso->save();
                        }
                        break;
                    case "00":
                        $cvepag = $pagClaveAlu;
                        $pagAnioPer = $pagAnioPer;
                        //ACTUALIZA EL ESTADO DEL CURSO A REGULAR
                        $curso = Curso::with('alumno','periodo')
                        ->whereHas('alumno', function($query) use ($cvepag) {
                            $query->where('aluClave',$cvepag);
                        })
                        ->whereHas('periodo', function($query) use ($pagAnioPer) {
                            $query->where('PerNumero',1);
                            $query->where('PerAnio',$pagAnioPer + 1);
                        })->first();
                        if($curso){
                            $curso->curEstado = 'R';
                            //ACTUALIZA EL ESTADO DEL ALUMNO A REGULAR
                            if($curso->alumno->aluEstado == 'E'){
                                $curso->alumno->aluEstado = 'R';
                            }
                            $curso->save();
                        }
                        break;
                    case "05":
                        $cvepag = $pagClaveAlu;
                        $pagAnioPer = $pagAnioPer;
                        //ACTUALIZA EL ESTADO DEL CURSO A REGULAR
                        $curso = Curso::with('alumno','periodo')
                        ->whereHas('alumno', function($query) use ($cvepag) {
                            $query->where('aluClave',$cvepag);
                        })
                        ->whereHas('periodo', function($query) use ($pagAnioPer) {
                            $query->where('PerNumero',2);
                            $query->where('PerAnio',$pagAnioPer);
                        })->first();
                        #
                        # En 2016 se anexaron las opciones de 11 pagos (CCH) y 12 pagos (CVA)
                        # que incluyen el prorrateo de la inscripci�n de Enero.
                        # Se aplica cuando se procese el pago de Enero
                        #
                        if($curso){
                            if($curso->curPlanPago == 'A' || $curso->curPlanPago == 'O' || $curso->curPlanPago == 'D'){
                                Curso::with('alumno','periodo')
                                ->whereHas('alumno', function($query) use ($cvepag) {
                                    $query->where('aluClave',$cvepag);
                                })
                                ->whereHas('periodo', function($query) use ($pagAnioPer) {
                                    $query->where('PerNumero',1);
                                    $query->where('PerAnio',$pagAnioPer + 1);
                                })->update(['curEstado' => 'R']);
                                # Agrega registro del pago de inscripción de Enero
                                $encontroPago = Pago::where('pagClaveAlu',$cvepag)
                                ->where('pagAnioPer',$pagAnioPer)
                                ->where('pagConcPago','00')->exists();
                                if($encontroPago){
                                    try{
                                        Pago::create([
                                            'pagDigVer'         => "",
                                            'pagEstado'         => "A",
                                            'pagObservacion'    => "P",
                                            'pagFormaAplico'    => "A",
                                            'pagComentario'     => "Inscripción prorrateada.",
                                            'pagRefPago'        => "PRORR",
                                            'pagConcPago'       => "00",
                                            'pagImpPago'        => 0
                                        ]);
                                    }catch(QueryException $e){
                                        $errorCode = $e->errorInfo[1];
                                    }
                                }
                            }
                        }
                        break;
                    # Nueva forma de actualizar el estado
                    # Se basa en la tabla de claves de conceptos de actividades extraescolares
                    case "31":
                        $this->act_aextra($pagClaveAlu,$pagAnioPer,"NAT",0);
                        break;
                    case "32":
                        $this->act_aextra($pagClaveAlu,$pagAnioPer + 1,"NAT",1);
                        break;
                    case "33":
                        $this->act_aextra($pagClaveAlu,$pagAnioPer,"NAT",2);
                        break;
                    case "34":
                        $this->act_aextra($pagClaveAlu,$pagAnioPer,"NAT",3);
                        break;
                    default:
                        $caext = ConcAextra::select('aextClave')->where('aextConcP1',$pagConcPago)->first();
                        if($caext){
                            $this->act_aextra($pagClaveAlu,$pagAnioPer,$caext,0);
                            $this->act_aextra($pagClaveAlu,$pagAnioPer,$caext,3);
                        }else{
                            $this->act_aextra($pagClaveAlu,$pagAnioPer,$caext,1);
                        }
                        break;
                }//TERMINAN LOS CASOS
            }
        }
    }

    private function act_aextra($clave_pago,$anio_per,$caext,$num_per){

        Aextra::where('curClaveAlu',$clave_pago)
        ->where('curAnioPer',$anio_per)
        ->where('curClaveCarrera',$caext)
        ->where('curNumPer',$num_per)
        ->update(['curEstado' => 'R']);
    }

}