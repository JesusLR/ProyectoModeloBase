<?php
namespace App\clases\alumnos;

use Illuminate\Support\Facades\DB;

use App\Models\Alumno;
use App\Models\User;
use App\Http\Helpers\Utils;
use App\clases\SCEM\Mailer;
use App\clases\personas\MetodosPersonas;

class Notificacion {

	public $departamento;
	public $ubicacion;
	public $alumno;
	public $persona;
	public $mail;

	public function __construct(Alumno $alumno)
	{
		$this->alumno = $alumno->load('persona');
		$this->departamento = auth()->user()->empleado->escuela->departamento;
		$this->ubicacion = $this->departamento->ubicacion;
		$this->persona = $this->alumno->persona;
	}

	public function registro_eliminado()
	{
		$this->mail = new Mailer([
			'username_email' => 'bajas@modelo.edu.mx', // 'bajas@unimodelo.com',
			'password_email' => 'Caf28347',
			'to_email' => 'luislara@modelo.edu.mx',
			'to_name' => '',
			'cc_email' => '',
			'subject' => 'Importante! Se ha eliminado un registro de Alumno.',
			'body' => $this->armar_mensaje_registro_eliminado(),
		]);
		// $this->mail->agregar_destinatario('jmanuel.lopez@modelo.edu.mx'); #TEST
		$director_campus = 'cesauri@modelo.edu.mx';
		$coordinador_secretaria_academica = 'sil_bar@modelo.edu.mx';
		if($this->ubicacion->ubiClave == 'CCH') {
			$director_campus = 'mduch@modelo.edu.mx';
			$coordinador_secretaria_academica = 'jpereira@modelo.edu.mx';
		} else if($this->ubicacion->ubiClave == 'CVA') {
			$director_campus = 'ppineda@modelo.edu.mx'; // 'aime@modelo.edu.mx';
		} 
		/*else if($this->ubicacion->ubiClave == 'CME') {
			$this->mail->agregar_destinatario('@modelo.edu.mx');
		}*/

		$this->mail->agregar_destinatario('eail@modelo.edu.mx');
		$this->mail->agregar_destinatario($director_campus);
		$this->mail->agregar_destinatario($coordinador_secretaria_academica);
		
		$this->mail->enviar();
	}

	/**
	* @param App\Models\Baja
	*/
	private function armar_mensaje_registro_eliminado()
	{
		$usuario = auth()->user();
		$usuario_creador = User::find($this->alumno->getOriginal()['usuario_at']); 
		$nombre_empleado = MetodosPersonas::nombreCompleto($usuario->empleado->persona);
		$nombre_alumno = MetodosPersonas::nombreCompleto($this->persona);

		return "<p>{$nombre_empleado} ({$usuario->username}) ha eliminado el siguiente registro de Alumno:</p>
		<br>
		<p><b>Clave de pago: </b> {$this->alumno->aluClave}</p>
		<p><b>Alumno: </b> {$nombre_alumno}</p>
		<p><b>Campus: </b> {$this->ubicacion->ubiClave} - {$this->ubicacion->ubiNombre}</p>
		<p><b>Fecha de registro: </b> ".Utils::fecha_string($this->alumno->aluFechaIngr, 'mesCorto')."</p>
		<p><b>Creado por: </b> ".($usuario_creador ? $usuario_creador->username : '')."</p>
		<br>
		<p><b>Fecha de eliminación: </b> ".Utils::fecha_string($this->alumno->deleted_at, 'mesCorto')."</p>
		<br>
		<p>Favor de no responder a este correo automatizado.</p>
		";
	}
}