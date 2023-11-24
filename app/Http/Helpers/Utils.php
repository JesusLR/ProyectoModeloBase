<?php
namespace App\Http\Helpers;

use Carbon\Carbon;
use Akaunting\Money\Money;
use Auth;
use App\Models\Modules;
use App\Models\Permission_module_user;
use App\Models\Permission;
use App\Models\Permiso_programa_user;
use DateTime;

class Utils
{
    public static function validaPermiso($controlador,$programa_id,$accion = "") {
        $user = Auth::user();
        $modulo = Modules::where('slug',$controlador)->first();
        //OBTENER EL PERMISO DEL MODULO
        $permisos = Permission_module_user::where('user_id',$user->id)->where('module_id',$modulo->id)->first();
        //OBTENER EL NOMBRE DEL PERMISO
        $permiso = Permission::find($permisos->permission_id)->name;
        //VALIDA SI TIENE PERMISOS
        if($permiso == 'A' || $permiso == 'B' || $permiso == 'E'){
            return false;
        }else if($permiso == 'C'){
            $programa = Permiso_programa_user::where([['user_id',$user->id],['programa_id',$programa_id]])->exists();
            if($programa){
                return false;
            }else{
                return true;
            }
        }else if($permiso == 'P' && $accion == "editar"){
            return false;
        }else{
            return true;
        }
    }

    public static function validaEmpty($input) {
        if($input == ''){
            return null;
        }else{
            return $input;
        }
    }

    public static function diaSemana($dia) {
        switch($dia){
            case 1:
                return "Lunes";
            break;
            case 2:
                return "Martes";
            break;
            case 3:
                return "Miércoles";
            break;
            case 4:
                return "Jueves";
            break;
            case 5:
                return "Viernes";
            break;
            case 6:
                return "Sábado";
            break;
            case 7:
                return "Domingo";
            break;
            default:
                return $dia;
            break;
        }
    }

    public static function convertMoney($number) {
        return Money::MXN($number,true);
    }

    public static function convertNumber($number) {
        if($number == ''){
            return 0;
        }else{
            $number = str_replace(',', '', $number);
            return $number;
        }
    }

    public static function convertDateMonth($date) {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d/M/Y');
    }

    public static function estadoGrupo($estado){
        switch($estado){
            case 'A':
                return "ABIERTO SIN CALIFICAR";
            break;
            case 'B':
                return "ABIERTO CON CALIFICACIÓN";
            break;
            case 'C':
                return "CERRADO";
            break;
            default:
                return $estado;
            break;
        }
    }

    public static function nivel_profesion($valor) {
        switch ($valor) {
            case 'L':
                return 'LICENCIATURA';
                break;
            case 'E':
                return 'ESPECIALIDAD';
                break;
            case 'M':
                return 'MAESTRIA';
                break;
            case 'D':
                return 'DOCTORADO';
                break;
            default:
                return 'NINGUNO';
        }
    }

    public static function semestres_numeracion_ordinal($number) {
        switch ($number) {
            case 1:
                return 'PRIMERO';
                break;
            case 2:
                return 'SEGUNDO';
                break;
            case 3:
                return 'TERCERO';
                break;
            case 4:
                return 'CUARTO';
                break;
            case 5:
                return 'QUINTO';
                break;
            case 6:
                return 'SEXTO';
                break;
            case 7:
                return 'SEPTIMO';
                break;
            case 8:
                return 'OCTAVO';
                break;
            case 9:
                return 'NOVENO';
                break;
            case 10:
                return 'DECIMO';
                break;
            case 11:
                return 'ONCEAVO';
                break;
            case 12:
                return 'DOCEAVO';
                break;
        }
    }

    public static function grados_numeracion_ordinal($number) {
        switch ($number) {
            case 1:
                return 'PRIMER';
                break;
            case 2:
                return 'SEGUNDO';
                break;
            case 3:
                return 'TERCER';
                break;
            case 4:
                return 'CUARTO';
                break;
            case 5:
                return 'QUINTO';
                break;
            case 6:
                return 'SEXTO';
                break;
            case 7:
                return 'SEPTIMO';
                break;
            case 8:
                return 'OCTAVO';
                break;
            case 9:
                return 'NOVENO';
                break;
            case 10:
                return 'DECIMO';
                break;
            case 11:
                return 'ONCEAVO';
                break;
            case 12:
                return 'DOCEAVO';
                break;
        }
    }

    public static function num_meses_corto_string($number) {
        switch ($number) {
            case 1:
                return 'Ene';
                break;
            case 2:
                return 'Feb';
                break;
            case 3:
                return 'Mar';
                break;
            case 4:
                return 'Abr';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'Jun';
                break;
            case 7:
                return 'Jul';
                break;
            case 8:
                return 'Ago';
                break;
            case 9:
                return 'Sep';
                break;
            case 10:
                return 'Oct';
                break;
            case 11:
                return 'Nov';
                break;
            case 12:
                return 'Dic';
                break;
        }
    }

    
    public static function num_meses_string($number) {
        switch ($number) {
            case 1:
                return 'enero';
                break;
            case 2:
                return 'febrero';
                break;
            case 3:
                return 'marzo';
                break;
            case 4:
                return 'abril';
                break;
            case 5:
                return 'mayo';
                break;
            case 6:
                return 'junio';
                break;
            case 7:
                return 'julio';
                break;
            case 8:
                return 'agosto';
                break;
            case 9:
                return 'septiembre';
                break;
            case 10:
                return 'octubre';
                break;
            case 11:
                return 'noviembre';
                break;
            case 12:
                return 'diciembre';
                break;
        }
    }

    public static function fecha_string($fecha,$tipoMes = null, $tipoAnio = null){
        $fechaString = null;
        if($fecha){
            $dia = Carbon::parse($fecha)->format('d');
            $mes = Carbon::parse($fecha)->format('m');
            if($tipoMes == NULL){
            $mes = ucwords(Utils::num_meses_string($mes));
            $anio = Carbon::parse($fecha)->format('Y');
            $fechaString = $dia.' de '.$mes.' del '.$anio;
            }else{
            $mes = ucwords(Utils::num_meses_corto_string($mes));
            $anio = Carbon::parse($fecha)->format('Y');
            $fechaString = $dia.'/'.$mes.'/'.$anio;
            }
            if($tipoAnio == 'y') {
                $anio = substr($anio, 2);
                $fechaString = $dia.'/'.$mes.'/'.$anio;
            }
        }

        return $fechaString;
    }

     public static function obtenerMesEscolar($mesAnual){
        $mesEscolar = null;
        switch ($mesAnual) {
            case '01':
                $mesEscolar = '05';
                break;
            case '02':
                $mesEscolar = '06';
                break;
            case '03':
                $mesEscolar = '07';
                break;
            case '04':
                $mesEscolar = '08';
                break;
            case '05':
                $mesEscolar = '09';
                break;
            case '06':
                $mesEscolar = '10';
                break;
            case '07':
                $mesEscolar = '11';
                break;
            case '08':
                $mesEscolar = '12';
                break;
            case '09':
                $mesEscolar = '01';
                break;
            case '10':
                $mesEscolar = '02';
                break;
            case '11':
                $mesEscolar = '03';
                break;
            case '12':
                $mesEscolar = '04';
                break;
            default:
                $mesEscolar = '01';
                break;
        }
        return $mesEscolar;
     }

     public static function obtenerMesAnual($mesEscolar){
        $mesAnual = null;
        
        if(is_int($mesEscolar)) {
            $mesEscolar = str_pad($mesEscolar, 2, '0', STR_PAD_LEFT);
        }

        switch ($mesEscolar) {
            case '01':
                $mesAnual = '09';
                break;
            case '02':
                $mesAnual = '10';
                break;
            case '03':
                $mesAnual = '11';
                break;
            case '04':
                $mesAnual = '12';
                break;
            case '05':
                $mesAnual = '01';
                break;
            case '06':
                $mesAnual = '02';
                break;
            case '07':
                $mesAnual = '03';
                break;
            case '08':
                $mesAnual = '04';
                break;
            case '09':
                $mesAnual = '05';
                break;
            case '10':
                $mesAnual = '06';
                break;
            case '11':
                $mesAnual = '07';
                break;
            case '12':
                $mesAnual = '08';
                break;
            default:
                $mesAnual = '01';
                break;
        }
        return $mesAnual;
     }

     /**
     * Retorna los conceptos de pagos mensuales por medio de curPlanPago.
     * - Incluye inscripciones.
     *
     * @param string
     */
     public static function mensualidadesDeCurso ($curPlanPago){
        $conceptos = [
            '99', '01', '02', '03', '04', '05', '00', 
            '06', '07', '08', '09', '10', '11', '12',
        ]; 

        if ($curPlanPago == 'A' || $curPlanPago == 'N') {
            unset($conceptos[12], $conceptos[13]);
        }

        if ($curPlanPago == 'O') {
            unset($conceptos[13], $conceptos[6]);
        }

        if($curPlanPago == 'D') {
            unset($conceptos[6]);
        }

        return $conceptos;
     }

     public static function meses(){
        
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];

        return $meses;
     }
     public static function meses_key_int(){
        
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return $meses;
     }
     public static function meses_orden_escolar() {

        return [
            '01' => 'Septiembre',
            '02' => 'Octubre',
            '03' => 'Noviembre',
            '04' => 'Diciembre',
            '05' => 'Enero',
            '5.5' => 'Insc. Ene',
            '06' => 'Febrero',
            '07' => 'Marzo',
            '08' => 'Abril',
            '09' => 'Mayo',
            '10' => 'Junio',
            '11' => 'Julio',
            '11.5' => 'Insc. Ago',
            '12' => 'Agosto',
        ];
     }
    
    // Saca la diferencia de días entre dos fechas
    public static function diferenciaDias($fecha1, $fecha2){
        $fechaInicial = new DateTime($fecha1);
        $fechaFinal = new DateTime($fecha2);
        $diferencia = $fechaInicial->diff($fechaFinal);
        $diferenciaDias = $diferencia->format('%a');
        return $diferenciaDias;
    }

    /*
    * Las tres funciones siguientes sirven para generar opciones en la columna de "action"
    * de los DataTables.
    *
    * - action_url recibe la url general del Controlador, ejemplo 'alumno'.
    * La función agrega las diagonales y complementos, dependiendo de la acción.
    */

    public static function btn_show($id, $action_url) {
        return  '<div class="col s1">
                    <a href="'.$action_url.'/'.$id.'" class="button button--icon js-button js-ripple-effect" title="Ver">
                    <i class="material-icons">visibility</i>
                    </a>
                </div>';
    }//btn_show.

    public static function btn_edit($id, $action_url) {
        return '<div class="col s1">
                    <a href="'.$action_url.'/'.$id.'/edit" class="button button--icon js-button js-ripple-effect" title="Editar">
                        <i class="material-icons">edit</i>
                    </a>
                </div>';
    }//btn_edit.

    public static function btn_delete($id, $action_url) {
        return '<div class="col s1">
                    <form id="delete_' . $id . '" action="'.$action_url.'/'. $id . '" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a href="#" data-id="' . $id . '" class="button button--icon js-button js-ripple-effect btn-borrar" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </form>
                </div>';
    }//actionDelete.

    //Función para quitar acentos, eñes y diéresis de las palabras.
    public static function quitarAcentos($cadena)
    {       
        $letrasAcento = ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ'];
        $letrasNormal = ['a', 'e', 'i', 'o', 'u', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'U', 'N'];

        $resul = str_replace($letrasAcento, $letrasNormal, $cadena);

        return $resul;
    }

}//Utils class.