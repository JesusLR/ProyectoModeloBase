<?php

namespace App\Http\Controllers\Primaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Empleado;
use App\Models\Periodo;
use App\Models\Persona;
use App\Models\Primaria\Primaria_empleado;
use App\Models\Ubicacion;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

class PrimariaGenerarPromediosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1,2])->get();

        $departamento_sistemas = Auth::user()->departamento_sistemas;

        $perActual = Auth::user()->empleado->escuela->departamento->perActual;

        

        if($departamento_sistemas == 1){
            $periodo = Periodo::select('periodos.*')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->where('departamentos.depClave', 'PRI')
            ->get();
        }else{
            $periodo = Periodo::select('periodos.*')
            ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
            ->where('periodos.id', $perActual)
            ->where('departamentos.depClave', 'PRI')
            ->get();
        }


        return view('primaria.generar_promedio.create', [
            'ubicaciones' => $ubicaciones,
            'periodo' => $periodo
        ]);
    }

    public function generarPromedio(Request $request)
    {

        // Seleccionamos 
        $ubicacion = Ubicacion::findOrFail($request->ubicacion_id);
        $periodo = Periodo::findOrFail($request->periodo_id);

        $resultado_array =  DB::select("call procPrimariaPromediosTrimestres(" . $periodo->perAnioPago . ")");
        $resultado_collection = collect($resultado_array);

        // // Correos destino 
        // $to_email_luis = "luislara@modelo.edu.mx";
        // $to_name_luis = "Luis Lara";

        // $to_email_enrique = "ekoyoc@modelo.mx";
        // $to_name_enrique = "Enrique Koyoc";

        // $to_email_eduardo = "eail@modelo.edu.mx";
        // $to_name_eduardo = "Eduardo Iza";

        

        // if($ubicacion->ubiClave == "CME"){
        //     $to_email_directora = "trinidiaz@modelo.edu.mx";
        //     $to_name_directora = "María Trinidad Diaz Cervera";

        //     $to_email_gina = "ginalv@modelo.edu.mx";
        //     $to_name_gina = "Gina Esther Lizama Villegas";
        // }


        // if($ubicacion->ubiClave == "CVA"){
        //     $to_email_directora = "amartinez@modelo.edu.mx";
        //     $to_name_directora = "Arely Martinez Diaz";
        // }
        
        // $fechaActual = Carbon::now('America/Merida');
        // setlocale(LC_TIME, 'es_ES.UTF-8');
        // // En windows
        // setlocale(LC_TIME, 'spanish');
       
        // $usuario = User::findOrfail(auth()->id());
        // $empleado_primaria = Primaria_empleado::find($usuario->empleado_id);
        // if($empleado_primaria != ""){
        //     $ELUSUARIOQUECLICKEOELBOTONAZO = $empleado_primaria->empNombre." ".$empleado_primaria->empApellido1." ".$empleado_primaria->empApellido2;
        // }else{
        //     $empleado = Empleado::find($usuario->empleado_id);
        //     $persona = Persona::find($empleado->persona_id);

        //     $ELUSUARIOQUECLICKEOELBOTONAZO = $persona->perNombre." ".$persona->perApellido1." ".$persona->perApellido2;

        // }
        

        // //CORREO REMITENTE DE PROMEDIOS 
        // $username_email = "promedios@modelo.edu.mx"; // "promedios@unimodelo.com";
        // $password_email = "8k>QbEr.QC3v"; // "2AU8a7T5Cu";

        // $mail = new PHPMailer(true);
        // // Server settings
        // $mail->CharSet = "UTF-8";
        // $mail->Encoding = 'base64';

        // $mail->SMTPDebug = 0; //3;                           // Enable verbose debug output
        // $mail->isSMTP();                                // Set mailer to use SMTP
        // $mail->Host = 'smtp.office365.com'; //'mail.unimodelo.com';             // Specify main and backup SMTP servers
        // $mail->SMTPAuth = true;                         // Enable SMTP authentication
        // $mail->Username = $username_email; // SMTP username
        // $mail->Password = $password_email;                   // SMTP password
        // $mail->SMTPSecure = 'tls'; //'ssl';                      // Enable TLS encryption, `ssl` also accepted
        // $mail->Port = 587; // 465;                              // TCP port to connect to
        // $mail->setFrom($username_email, 'Primaria Modelo');

        // if($ubicacion->ubiClave == "CME"){
        //     $mail->addAddress($to_email_directora , $to_name_directora);
        //     $mail->addCC($to_email_gina, $to_name_gina);
        // }

        // if($ubicacion->ubiClave == "CME"){
        //     $mail->addAddress($to_email_directora , $to_name_directora);
        // }
        // $mail->addCC($to_email_luis, $to_name_luis);
        // $mail->addCC($to_email_eduardo , $to_name_eduardo);
        // $mail->addCC($to_email_enrique , $to_name_enrique);

        // $mail->isHTML(true);                          // Set email format to HTML
        // $mail->Subject = "Cálculo de promedios trimestrales de primaria";




        // $body = "
        // <p>Estimado (a) Director de primaria: ".$to_name_directora."</p>
        // <p>El presente correo es solo para notificar que se ha realizado el proceso de cálculo de promedios trimestrales del periodo en curso, dentro del sistema SCEM.</p>
        // <p>Es importante recordar, que cualquier ajuste en las calificaciones, deberán revisarse para que los promedios trimestrales en el SCEM y portal oficial de la SEP, sean iguales.</p>
        // <p>Fecha: ".Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto', 'y')."</p>
        // <p>Hora: ".Carbon::parse($fechaActual->format('H:i:s'))." hrs.</p>
        // <p>Usuario: ".$ELUSUARIOQUECLICKEOELBOTONAZO."</p>".
        // "<p><b><i>Este es un correo automatizado, favor de no responder a esta cuenta de correo electrónico.</i></b></p>";

        // $mail->Body  = $body;
        try {
        //   $enviado = $mail->send();

            alert('Escuela Modelo', 'El calculo de los promedios trimestrales se ha realizado con éxito','success')->showConfirmButton();
            return redirect()->back();
        } catch (MailerException $e) {
          throw new Exception("Error al enviar Notificación, Verificar conexión a internet e intentar nuevamente", 1);
        }

    }
}
