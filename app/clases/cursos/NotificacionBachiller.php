<?php
namespace App\clases\cursos;

use Illuminate\Support\Facades\DB;

use App\Models\Curso;
use App\Models\Baja;
use App\Http\Helpers\Utils;
use App\clases\SCEM\Mailer;
use App\clases\personas\MetodosPersonas;
use App\clases\SCEM\MailerBAC;

class NotificacionBachiller {

	public $curso;
	public $cgt;
	public $plan;
	public $programa;
	public $escuela;
	public $periodo;
	public $departamento;
	public $ubicacion;
	public $alumno;
	public $persona;
	public $mail;

	public function __construct(Curso $curso)
	{
		$this->curso = $curso->load(['alumno.persona', 'periodo.departamento.ubicacion', 'cgt.plan.programa.escuela']);
		$this->cgt = $this->curso->cgt;
		$this->plan = $this->cgt->plan;
		$this->programa = $this->plan->programa;
		$this->escuela = $this->programa->escuela;
		$this->periodo = $this->curso->periodo;
		$this->departamento = $this->periodo->departamento;
		$this->ubicacion = $this->departamento->ubicacion;
		$this->alumno = $this->curso->alumno;
		$this->persona = $this->alumno->persona;
	}

	public function baja_realizada(Baja $baja)
	{
		$this->mail = new MailerBAC([
			'username_email' => 'bajas@modelo.edu.mx', // 'bajas@unimodelo.com',
			'password_email' => 'Caf28347',
			'to_email' => 'luislara@modelo.edu.mx',
			'to_name' => '',
			'cc_email' => '',
			'subject' => 'Importante! Se ha realizado un proceso de baja de curso',
			'body' => $this->armar_mensaje_de_baja($baja),
		]);

		$director_campus = '';
		$coordinador_secretaria_academica = '';
		

		if($this->ubicacion->ubiClave == 'CCH') {
			$director_campus = 'mduch@modelo.edu.mx';
			$coordinador_secretaria_academica = 'rrios@modelo.edu.mx';
			$this->mail->agregar_destinatario('srivero@modelo.edu.mx');

		} else if($this->ubicacion->ubiClave == 'CVA') {
			$director_campus = 'amartinez@modelo.edu.mx';
			$this->mail->agregar_destinatario('mtuz@modelo.edu.mx');
		} else if($this->ubicacion->ubiClave == 'CME') {
			$director_campus = 'msauri@modelo.edu.mx';
			$coordinador_secretaria_academica = 'a.aviles@modelo.edu.mx';
			$this->mail->agregar_destinatario('arubio@modelo.edu.mx');

		}

		$this->mail->agregar_destinatario('eail@modelo.edu.mx');
		$this->mail->agregar_destinatario('flopezh@modelo.edu.mx');
		$this->mail->agregar_destinatario($director_campus);
		$this->mail->agregar_destinatario($coordinador_secretaria_academica);

		$director_carrera = $this->escuela->empleado;
		$coordinador_carrera = $this->programa->empleado;

		// if($director_carrera && $director_carrera->empCorreo1)
		// 	$this->mail->agregar_destinatario($director_carrera->empCorreo1);

		// if($coordinador_carrera && $coordinador_carrera->empCorreo1)
		// 	$this->mail->agregar_destinatario($coordinador_carrera->empCorreo1);
		
		if(!$director_carrera || !$coordinador_carrera)
			$this->mail->agregar_destinatario('aosorio@modelo.edu.mx');
		
		$this->mail->enviar();
	}

	/**
	* @param App\Models\Baja
	*/
	private function armar_mensaje_de_baja($baja)
	{
		$usuario = auth()->user();
		$nombre_empleado = MetodosPersonas::nombreCompleto($usuario->empleado->persona);
		$nombre_alumno = MetodosPersonas::nombreCompleto($this->persona);

		return "<p>{$nombre_empleado} ({$usuario->username}) ha realizado la baja del siguiente curso:</p>
		<br>
		<p><b>Clave de pago: </b> {$this->alumno->aluClave}</p>
		<p><b>Alumno: </b> {$nombre_alumno}</p>
		<p><b>Grupo: </b> {$this->cgt->cgtGradoSemestre} - {$this->cgt->cgtGrupo}</p>
		<p><b>Programa: </b> {$this->programa->progClave} ({$this->plan->planClave}) - {$this->programa->progNombre}</p>
		<p><b>Escuela: </b> {$this->escuela->escClave} - {$this->escuela->escNombre}</p>
		<p><b>Campus: </b> {$this->ubicacion->ubiClave} - {$this->ubicacion->ubiNombre}</p>
		<p><b>Periodo y Año: </b> {$this->periodo->perNumero} / {$this->periodo->perAnio}</p>
		<br>
		<p><b>Fecha de baja: </b> ".Utils::fecha_string($baja->bajFechaBaja, 'mesCorto')."</p>
		<p><b>Motivo de baja: </b> {$baja->conceptoBaja->conbNombre}</p>
		<br>
		<p>Favor de no responder a este correo automatizado.</p>
		";
	}
}