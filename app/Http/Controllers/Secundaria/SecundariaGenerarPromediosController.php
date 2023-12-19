<?php

namespace App\Http\Controllers\Secundaria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Utils;
use App\Models\Empleado;
use App\Models\Periodo;
use App\Models\Secundaria\Secundaria_empleados;
use App\Models\Ubicacion;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

class SecundariaGenerarPromediosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ubicaciones = Ubicacion::whereIn('id', [1, 2])->get();

        return view('secundaria.generar_promedio.create', [
            'ubicaciones' => $ubicaciones
        ]);
    }

    public function generarPromedio(Request $request)
    {

        // Seleccionamos
        $ubicacion = Ubicacion::findOrFail($request->ubicacion_id);
        $periodo = Periodo::findOrFail($request->periodo_id);

        $resultado_array =  DB::select("call procSecundariaPromediosTrimestres(" . $request->periodo_id . ")");
        $resultado_collection = collect($resultado_array);


        Empleado::select('personas.perApellido1', 'personas.perApellido2', 'personas.perNombre')
        ->join('personas', 'empleados.persona_id', '=', 'personas.id')
        ->where('empleados.id', auth()->user()->empleado_id)
        ->first();

        if ($resultado_collection) {

            // Correos destino
            $to_email_luis = "luislara@modelo.edu.mx";
            $to_name_luis = "Luis Lara";

            $to_email_enrique = "ekoyoc@modelo.mx";
            $to_name_enrique = "Enrique Koyoc";

            $to_email_eduardo = "eail@modelo.edu.mx";
            $to_name_eduardo = "Eduardo Iza";

            $to_email_Lourdes = "lourdesn.arce@modelo.edu.mx";
            $to_name_Lourdes = "Lourdes Arce Cira Novelo";

            if ($ubicacion->ubiClave == "CME") {
                $to_email_directora = "silviav.pool@modelo.edu.mx";
                $to_name_directora = "Silvia Violeta Pool Dorantes";
            }

            if ($ubicacion->ubiClave == "CVA") {
                $to_email_directora = "lcanche@modelo.edu.mx";
                $to_name_directora = "Lol-Há Canché Gómez";
            }


            $fechaActual = Carbon::now('America/Merida');
            setlocale(LC_TIME, 'es_ES.UTF-8');
            // En windows
            setlocale(LC_TIME, 'spanish');

            // $empleado = Secundaria_empleados::findOrFail($usuario->empleado_id);

            $empleado = Empleado::select('personas.perApellido1', 'personas.perApellido2', 'personas.perNombre')
            ->join('personas', 'empleados.persona_id', '=', 'personas.id')
            ->where('empleados.id', auth()->user()->empleado_id)
            ->first();


            $ELUSUARIOQUECLICKEOELBOTONAZO = $empleado->empNombre . " " . $empleado->empApellido1 . " " . $empleado->empApellido2;

            //CORREO REMITENTE DE PROMEDIOS
            $username_email = "promedios@modelo.edu.mx"; // "promedios@unimodelo.com";
            $password_email = "tcRl0TDr6ry3"; // "2AU8a7T5Cu";

            $mail = new PHPMailer(true);
            // Server settings
            $mail->CharSet = "UTF-8";
            $mail->Encoding = 'base64';

            $mail->SMTPDebug = 0; //3;                           // Enable verbose debug output
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host ='smtp.office365.com'; //'mail.unimodelo.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                         // Enable SMTP authentication
            $mail->Username = $username_email; // SMTP username
            $mail->Password = $password_email;                   // SMTP password
            $mail->SMTPSecure = 'tls'; //'ssl';                      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // 465;                              // TCP port to connect to
            $mail->setFrom($username_email, 'Secundaria Modelo');

            $mail->addAddress($to_email_directora, $to_name_directora);
            $mail->addCC($to_email_luis, $to_name_luis);
            $mail->addCC($to_email_eduardo , $to_name_eduardo);
            $mail->addCC($to_email_enrique , $to_name_enrique);

            // Para el envio
            if($ubicacion->ubiClave == "CME"){
                $mail->addCC($to_email_Lourdes , $to_name_Lourdes);
            }

            $mail->isHTML(true);                          // Set email format to HTML
            $mail->Subject = "Cálculo de promedios trimestrales de secundaria";




            $body = "
            <p>Estimado (a) Director de Secundaria: " . $to_name_directora . "</p>
            <p>El presente correo es solo para notificar que se ha realizado el proceso de cálculo de promedios trimestrales del periodo en curso, dentro del sistema SCEM.</p>
            <p>Es importante recordar, que cualquier ajuste en las calificaciones, deberán revisarse para que los promedios trimestrales en el SCEM y portal oficial de la SEP, sean iguales.</p>
            <p>Fecha: " . Utils::fecha_string($fechaActual->format('Y-m-d'), 'mesCorto', 'y') . "</p>
            <p>Hora: " . Carbon::parse($fechaActual->format('H:i:s')) . " hrs.</p>
            <p>Usuario: " . $ELUSUARIOQUECLICKEOELBOTONAZO . "</p>" .
            "<p><b><i>Este es un correo automatizado, favor de no responder a esta cuenta de correo electrónico.</i></b></p>";

            $mail->Body  = $body;
        }


        try {
            $enviado = $mail->send();

            alert('Escuela Modelo', 'El calculo de los promedios trimestrales se ha realizado con éxito', 'success')->showConfirmButton();
            return redirect()->back();
        } catch (MailerException $e) {
            throw new Exception("Error al enviar Notificación, Verificar conexión a internet e intentar nuevamente", 1);
        }
    }
}
