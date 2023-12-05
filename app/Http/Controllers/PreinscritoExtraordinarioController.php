<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PreinscritoExtraordinario;
use App\Models\InscritoExtraordinario;
use App\Models\Materia;
use App\Models\Plan;
use App\Http\Helpers\Utils;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use DB;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

class PreinscritoExtraordinarioController extends Controller
{
    public function __construct() {
        //$this->middleware(['auth', 'permisos:preinscrito_extraordinario']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('preinscrito_extraordinario.show-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('preinscrito_extraordinario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return view('preinscrito_extraordinario.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $pexEstados = ['P' => 'Pagado', 'A' => 'Adeudado'];
        $preinscrito = PreinscritoExtraordinario::findOrFail($id);
        $materia = Materia::findOrFail($preinscrito->materia_id);
        $plan = Plan::findOrFail($materia->plan_id);
        return view('preinscrito_extraordinario.show', compact('preinscrito', 'pexEstados', 'plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $preinscrito = PreinscritoExtraordinario::findOrFail($id);
        return view('preinscrito_extraordinario.edit', compact('preinscrito'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return view('preinscrito_extraordinario.show-list');
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
        // $preinscrito->delete();
        return view('inscrito_extraordinario.show-list');
    }

    public function list() {
        $preinscritos = PreinscritoExtraordinario::with(['materia.plan', 'extraordinario.periodo'])->select('preinscritosextraordinarios.*')
        ->where('pexEstado', 'A')
        ->whereDate('extFecha', '>=', Carbon::now('America/Merida')->format('Y-m-d'));

        $user = auth()->user();

        return DataTables::eloquent($preinscritos)
        ->editColumn('extFecha', static function(PreinscritoExtraordinario $preinscrito) {
          return Utils::fecha_string($preinscrito->extFecha, 'mesCorto');
        })
        ->addColumn('action', static function(PreinscritoExtraordinario $preinscrito) use ($user) {

            $action_url = 'preinscrito_extraordinario';

            $btn_cancelar = '';
            if($user->username == 'DESARROLLO' || $user->permiso('preinscrito_extraordinario') == 'A') {
                $btn_cancelar = '<div class="col s1">
                                    <form id="cancelar_' . $preinscrito->id . '" action="preinscrito_extraordinario/cancelar/' . $preinscrito->id . '" method="POST">
                                        <input type="hidden" name="_method" value="POST">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <a href="#" data-id="' . $preinscrito->id . '" class="button button--icon js-button js-ripple-effect btn-cancelar" title="Cancelar preinscripción">
                                            <i class="material-icons">cancel</i>
                                        </a>
                                    </form>
                                </div>';
            }

            $btn_inscribir = '<div class="col s1">
                                <form id="inscribir_' . $preinscrito->id . '" action="preinscrito_extraordinario/' . $preinscrito->id . '/inscribir" method="POST">
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <a href="#" data-id="' . $preinscrito->id . '" class="button button--icon js-button js-ripple-effect btn-inscribir" title="Inscribir a Extraordinario">
                                        <i class="material-icons">forward</i>
                                    </a>
                                </form>
                            </div>';

            return '<div class="row">'
                        .Utils::btn_show($preinscrito->id, $action_url)
                        .$btn_inscribir
                        .$btn_cancelar.
                        // .Utils::btn_edit($preinscrito->id, $action_url)
                        // .Utils::btn_delete($preinscrito->id, $action_url).
                   '</div';
        })->make();
    }

    /**
    * Registra el preinscrito en la tabla inscritosextraordinarios.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function inscribir($id) {

        /*
        
        //CUANDO JUNIOR QUIERA TERMINAR EL PERIODO DE EXTRAS

        if(in_array(auth()->user()->permiso('preinscrito_extraordinario'), ['A', 'B', 'C'])) {
            alert('Ups...', 'No tienes permisos para realizar esta acción', 'warning')->showConfirmButton();
            return back()->withInput();
        }
        */

        $preinscrito = PreinscritoExtraordinario::findOrFail($id);
        if($preinscrito->pexEstado == 'P') {
          alert()->warning('No es posible la acción', 'El alumno ya aparece como Inscrito a este extraordinario. Favor de verificar')->showConfirmButton();
          return redirect()->back();
        }

        $yaestainscrito = InscritoExtraordinario::where('alumno_id',$preinscrito->alumno_id)
        ->where('extraordinario_id',$preinscrito->extraordinario_id)->get();
        if(count($yaestainscrito) > 0) {
          alert()->warning('No es posible la acción', 'El alumno ya aparece como Inscrito a este extraordinario. Favor de verificar')->showConfirmButton();
          return redirect()->back();
        }

        $fechaOcupada = InscritoExtraordinario::where('alumno_id', $preinscrito->alumno_id)
        ->whereDate('iexFecha', '=', $preinscrito->extFecha)->get();
        if($fechaOcupada->isNotEmpty()) {
          alert()->warning('No es posible la acción', 'El alumno ya tiene un examen para esta misma fecha.')->showConfirmButton();
          return redirect()->back();
        }

        DB::beginTransaction();
        try {

            $preinscrito->update(['pexEstado' => 'P']);

            $inscrito = InscritoExtraordinario::create([
                'alumno_id' => $preinscrito->alumno_id,
                'extraordinario_id' => $preinscrito->extraordinario_id,
                'extOportunidad_DentroDelPeriodo' => $preinscrito->extOportunidad_DentroDelPeriodo,
                'iexFecha' => $preinscrito->extFecha,
                'iexCalificacion' => null,
                'iexEstado' => 'P',
                'iexModoRegistro' => 'B',
                'iexFolioHistorico' => null
            ]);

            $actualizarConteo =  DB::select("call procActualizarExtraInsc()");

            // $this->notificar($preinscrito);

        } catch (Exception $e) {
            DB::rollBack();
            alert()->error('Error', 'Ha ocurrido un error. Favor de intentar nuevamente.')->showConfirmButton();
            return back();
        }
        DB::commit();
        alert()->success('Realizado', 'se ha realizado la inscripción exitosamente! En breve se le enviará al alumno, un correo de confirmación a la inscripción de este exámen.')->showConfirmButton();
        return redirect('preinscrito_extraordinario');

    }

    /**
     * @param int $preinscrito_id
     */
    public function cancelar($preinscrito_id) {
        if(!auth()->user()->permiso('preinscrito_extraordinario') == 'A' || !auth()->user()->username == 'DESARROLLO') {
            alert('Ups...', 'No tiene permisos para realizar esta opción', 'warning')->showConfirmButton();
            return redirect()->back();
        }
        $preinscrito = PreinscritoExtraordinario::findOrFail($preinscrito_id);

        try {
            PreinscritoExtraordinario::where('folioFichaPagoBBVA', $preinscrito->folioFichaPagoBBVA)
            ->where('folioFichaPagoHSBC', $preinscrito->folioFichaPagoHSBC)
            ->where('pexEstado', '<>', 'C')
            ->update(['pexEstado' => 'C']);
        } catch (Exception $e) {
            alert('Error', $e->getMessage(), 'error')->showConfirmButton();
            return redirect()->back();
        }

        alert('Realizado', 'Se ha cancelado la preinscripción a extraordinario', 'success')->showConfirmButton();
        return redirect()->back();
    }

    /**
    * Envía la notifiación por mail cuando el alumno ha sido inscrito a Extraordinario.
    *
    * @param App\Models\PreinscritoExtraordinario $preinscrito
    * @return \Illuminate\Http\Response
    */
    public function notificar($preinscrito) {

        $contacto = DB::table('preinscritosextraordinarios_notificar')->where('aluClave', $preinscrito->aluClave)->first();
        if(!is_null($contacto)) {

                $to_email = $contacto->aluCorreo;
                $to_name = $preinscrito->aluNombre;

        }
        else
        {
            $to_email = "aosorio@modelo.edu.mx";
            $to_name = "aosorio@modelo.edu.mx";
        }

        //$to_email = $contacto->aluCorreo;
        //$to_name = $preinscrito->aluNombre;
        
        //CORREO EXTRAORDINARIOS
        $username_email = "extraordinarios@modelo.edu.mx"; // "extraordinarios@unimodelo.com";
        $password_email = "qtXYJ9w3e8"; // "Vox40316";

        $mail = new PHPMailer(true);
        // Server settings
        $mail->CharSet = "UTF-8";
        $mail->Encoding = 'base64';

        $mail->SMTPDebug = 0; //3;                           // Enable verbose debug output
        $mail->isSMTP();                                // Set mailer to use SMTP
        $mail->Host = 'smtp.office365.com'; //'mail.unimodelo.com';             // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                         // Enable SMTP authentication
        $mail->Username = $username_email; // SMTP username
        $mail->Password = $password_email;                   // SMTP password
        $mail->SMTPSecure = 'tls'; //'ssl';                      // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // 465;                              // TCP port to connect to
        $mail->setFrom($username_email, 'Universidad Modelo');

        $mail->addAddress($to_email, $to_name);
        $mail->isHTML(true);                          // Set email format to HTML
        $mail->Subject = "Inscripción a Extraordinario de ".$preinscrito->matNombre;


        $body = "
        <p>Estimado: ".$preinscrito->aluNombre."</p>
        <p>Ha sido inscrito al siguiente examen extraordinario: </p>
        <p>Materia: " .$preinscrito->matNombre."</p>
        <p>Fecha: ".Utils::fecha_string($preinscrito->extFecha, 'mesCorto', 'y')."</p>
        <p>Hora: ".Carbon::parse($preinscrito->extHora)->format('H:i')." hrs.</p>
        <p>Docente: ".$preinscrito->empNombre."</p>".
        "<p><b><i>Este es un correo automatizado, favor de no responder a esta cuenta de correo electrónico.</i></b></p>";

        $mail->Body  = $body;
        try {
          $enviado = $mail->send();
        } catch (MailerException $e) {
          throw new Exception("Error al enviar Notificación, Verificar conexión a internet e intentar nuevamente", 1);
        }
    }//notificar.


}
