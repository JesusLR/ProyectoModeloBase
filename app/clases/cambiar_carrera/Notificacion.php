<?php 
namespace App\clases\cambiar_carrera;

use App\Models\Curso;
use App\clases\SCEM\Mailer;
use App\clases\personas\MetodosPersonas;

use Exception;

class Notificacion
{
	protected $mail;
	protected $curso;
	protected $alumno;
	protected $persona;
	protected $cgt;
	protected $plan;
	protected $programa;
	protected $escuela;
	protected $departamento;
	protected $ubicacion;
	protected $periodo;

	public function __construct(Curso $curso)
	{
		$this->curso = $curso;
		$this->alumno = $this->curso->alumno;
		$this->persona = $this->alumno->persona;
		$this->cgt = $this->curso->cgt;
		$this->plan = $this->cgt->plan;
		$this->programa = $this->plan->programa;
		$this->escuela = $this->programa->escuela;
		$this->departamento = $this->escuela->departamento;
		$this->ubicacion = $this->departamento->ubicacion;
		$this->periodo = $this->curso->periodo;
	}

	/**
	* @param App\Models\Curso $curso_anterior;
	*/
	public function cambioRealizado(Curso $curso_anterior)
	{
		$this->mail = new Mailer([
			'username_email' => 'bajas@modelo.edu.mx', // 'bajas@unimodelo.com',
			'password_email' => 'Caf28347',
			'to_email' => 'luislara@modelo.edu.mx',
			'to_name' => '',
			'cc_email' => '',
			'subject' => 'Importante! Se ha realizado un proceso de cambio de curso.',
			'body' => $this->armarMensajeDeCambio($curso_anterior),
		]);

		// $this->mail->agregar_destinatario('jmanuel.lopez@modelo.edu.mx'); # TEST
		$director_campus = 'cesauri@modelo.edu.mx';
		$coordinador_secretaria_academica = 'sil_bar@modelo.edu.mx';
		if($this->ubicacion->ubiClave == 'CCH') {
			$director_campus = 'mduch@modelo.edu.mx';
			$coordinador_secretaria_academica = 'jpereira@modelo.edu.mx';
		} else if($this->ubicacion->ubiClave == 'CVA') {
			$director_campus = ''; // 'aime@modelo.edu.mx';
			$this->mail->agregar_destinatario('mtuz@modelo.edu.mx');
		} 
		/*else if($this->ubicacion->ubiClave == 'CME') {
			$this->mail->agregar_destinatario('sil_bar@modelo.edu.mx');
		}*/

		$this->mail->agregar_destinatario('eail@modelo.edu.mx');
		$this->mail->agregar_destinatario($director_campus);
		$this->mail->agregar_destinatario($coordinador_secretaria_academica);
		
		$this->mail->enviar();
	}

	/**
	* @param App\Models\Curso $curso_anterior
	*/
	public function armarMensajeDeCambio(Curso $curso_anterior)
	{
		$usuario = auth()->user();
		$nombre_empleado = MetodosPersonas::nombreCompleto($usuario->empleado->persona);
		$nombre_alumno = MetodosPersonas::nombreCompleto($this->persona);

		$cgt_anterior = $curso_anterior->cgt;
		$plan_anterior = $cgt_anterior->plan;
		$programa_anterior = $plan_anterior->programa;
		$escuela_anterior = $programa_anterior->escuela;

		return "<p>{$nombre_empleado} ({$usuario->username}) ha realizado un cambio de cursos:</p>
		<h3><b>Alumno: </b> </h3>
		<p><b>Clave de pago: </b> {$this->alumno->aluClave}</p>
		<p><b>Alumno: </b> {$nombre_alumno}</p>
		<p><b>Campus: </b> {$this->ubicacion->ubiClave} - {$this->ubicacion->ubiNombre}</p>
		<p><b>Periodo y Año: </b> {$this->periodo->perNumero} / {$this->periodo->perAnio}</p>
		<br>
		<h3><b>Curso Anterior</b></h3>
		<p><b>Escuela: </b> {$escuela_anterior->escClave} - {$escuela_anterior->escNombre}</p>
		<p><b>Programa: </b> {$programa_anterior->progClave} ({$plan_anterior->planClave}) - {$programa_anterior->progNombre}</p>
		<p><b>Grupo: </b> {$cgt_anterior->cgtGradoSemestre} - {$cgt_anterior->cgtGrupo}</p>
		<br>
		<h3><b>Nuevo Curso </b> </h3>
		<p><b>Escuela: </b> {$this->escuela->escClave} - {$this->escuela->escNombre}</p>
		<p><b>Programa: </b> {$this->programa->progClave} ({$this->plan->planClave}) - {$this->programa->progNombre}</p>
		<p><b>Grupo: </b> {$this->cgt->cgtGradoSemestre} - {$this->cgt->cgtGrupo}</p>
		<br>
		<p>Favor de no responder a este correo automatizado.</p>
		";
	}
}