<?php
namespace App\clases\cambiar_carrera\idiomas;

use App\Models\Idiomas\Idiomas_cursos;
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

	public function __construct($curso)
	{
		$this->curso = Idiomas_cursos::select(
			'alumnos.aluClave',
			'personas.perNombre',
			'personas.perApellido1',
			'personas.perApellido2',
			'idiomas_grupos.gpoGrado',
			'idiomas_grupos.gpoClave',
			'idiomas_grupos.gpoDescripcion',
			'planes.planClave',
			'programas.progClave',
			'programas.progNombre',
			'escuelas.escClave',
			'escuelas.escNombre',
			'ubicacion.ubiClave',
			'ubicacion.ubiNombre',
			'periodos.perNumero',
			'periodos.perAnio'
		)
		->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
		->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
		->join('programas', 'planes.programa_id', '=', 'programas.id')
		->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
		->join('periodos', 'idiomas_cursos.periodo_id', '=', 'periodos.id')
		->join('departamentos', 'escuelas.departamento_id', '=', 'departamentos.id')
		->join('ubicacion', 'departamentos.ubicacion_id', '=', 'ubicacion.id')
		->join('alumnos', 'idiomas_cursos.alumno_id', '=', 'alumnos.id')
		->join('personas', 'alumnos.persona_id', '=', 'personas.id')
		->where('idiomas_cursos.id', $curso)
		->first();
	}

	/**
	* @param App\Models\Idiomas_cursos $curso_anterior;
	*/
	public function cambioRealizado(Idiomas_cursos $curso_anterior)
	{
		$this->mail = new Mailer([
			'username_email' => 'bajas@modelo.edu.mx', // 'bajas@unimodelo.com',
			'password_email' => 'c1IcMH4OoY39',
			'to_email' => 'luislara@modelo.edu.mx',
			'to_name' => '',
			'cc_email' => '',
			'subject' => 'Importante! Se ha realizado un proceso de cambio de curso.',
			'body' => $this->armarMensajeDeCambio($curso_anterior),
		]);

		// $this->mail->agregar_destinatario('jmanuel.lopez@modelo.edu.mx'); # TEST
		// $director_campus = 'cesauri@modelo.edu.mx';
		// $coordinador_secretaria_academica = 'cquintal@modelo.edu.mx';
		// if($this->curso->ubiClave == 'CCH') {
		// 	$director_campus = 'mduch@modelo.edu.mx';
		// 	$coordinador_secretaria_academica = 'jpereira@modelo.edu.mx';
		// } else if($this->curso->ubiClave == 'CVA') {
		// 	$director_campus = 'aime@modelo.edu.mx';
		// 	$this->mail->agregar_destinatario('mtuz@modelo.edu.mx');
		// } else if($this->curso->ubiClave == 'CME') {
		// 	$this->mail->agregar_destinatario('sil_bar@modelo.edu.mx');
		// }

		// $this->mail->agregar_destinatario('eail@modelo.edu.mx');
		// $this->mail->agregar_destinatario($director_campus);
		// $this->mail->agregar_destinatario($coordinador_secretaria_academica);

		$this->mail->enviar();
	}

	/**
	* @param App\Models\Idiomas_cursos $curso_anterior
	*/
	public function armarMensajeDeCambio(Idiomas_cursos $curso_anterior)
	{
		$usuario = auth()->user();
		$nombre_empleado = MetodosPersonas::nombreCompleto($usuario->empleado->persona);
		$nombre_alumno = $this->curso->perNombre.' '.$this->curso->perApellido1.' '.$this->curso->perApellido2;

		$curso_old = $curso_anterior->select(
			'idiomas_grupos.gpoGrado',
			'idiomas_grupos.gpoClave',
			'idiomas_grupos.gpoDescripcion',
			'planes.planClave',
			'programas.progClave',
			'programas.progNombre',
			'escuelas.escClave',
			'escuelas.escNombre'
		)
		->join('idiomas_grupos', 'idiomas_cursos.grupo_id', '=', 'idiomas_grupos.id')
		->join('planes', 'idiomas_grupos.plan_id', '=', 'planes.id')
		->join('programas', 'planes.programa_id', '=', 'programas.id')
		->join('escuelas', 'programas.escuela_id', '=', 'escuelas.id')
		->first();

		return "<p>{$nombre_empleado} ({$usuario->username}) ha realizado un cambio de cursos:</p>
		<h3><b>Alumno: </b> </h3>
		<p><b>Clave de pago: </b> {$this->curso->aluClave}</p>
		<p><b>Alumno: </b> {$nombre_alumno}</p>
		<p><b>Campus: </b> {$this->curso->ubiClave} - {$this->curso->ubiNombre}</p>
		<p><b>Periodo y Año: </b> {$this->curso->perNumero} / {$this->curso->perAnio}</p>
		<br>
		<h3><b>Curso Anterior</b></h3>
		<p><b>Escuela: </b> {$curso_old->escClave} - {$curso_old->escNombre}</p>
		<p><b>Programa: </b> {$curso_old->progClave} ({$curso_old->planClave}) - {$curso_old->progNombre}</p>
		<p><b>Grupo: </b> {$curso_old->gpoGrado} - {$curso_old->gpoClave} - {$curso_old->gpoDescripcion}</p>
		<br>
		<h3><b>Nuevo Curso </b> </h3>
		<p><b>Escuela: </b> {$this->curso->escClave} - {$this->curso->escNombre}</p>
		<p><b>Programa: </b> {$this->curso->progClave} ({$this->curso->planClave}) - {$this->curso->progNombre}</p>
		<p><b>Grupo: </b> {$this->curso->gpoGrado} - {$this->curso->gpoClave} - {$this->curso->gpoDescripcion}</p>
		<br>
		<p>Favor de no responder a este correo automatizado.</p>
		";
	}
}
