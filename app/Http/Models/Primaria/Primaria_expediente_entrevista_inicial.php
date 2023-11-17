<?php

namespace App\Http\Models\Primaria;

use App\Http\Models\Alumno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Primaria_expediente_entrevista_inicial extends Model
{
    use SoftDeletes;

    protected $table = 'primaria_expediente_entrevista_inicial';

    protected $guarded = ['id'];

    protected $fillable = [
        'alumno_id',
        'gradoInscrito',
        'tiempoResidencia',
        'apellido1Padre',
        'apellido2Padre',
        'nombrePadre',
        'curpPadre',
        'celularPadre',
        'edadPadre',
        'ocupacionPadre',
        'direccionPadre',
        'empresaPadre',
        'correoPadre',
        'apellido1Madre',
        'apellido2Madre',
        'nombreMadre',
        'curpMadre',
        'celularMadre',
        'edadMadre',
        'ocupacionMadre',
        'direccionMadre',
        'empresaMadre',
        'correoMadre',
        'estadoCivilPadres',
        'religion',
        'observaciones',
        'condicionFamiliar',
        'tutorResponsable',
        'celularTutor',
        'accidenteLlamar',
        'celularAccidente',
        'perAutorizada1',
        'perAutorizada2',
        'integrante1',
        'relacionIntegrante1',
        'edadintegrante1',
        'ocupacionIntegrante1',
        'integrante2',
        'relacionIntegrante2',
        'edadintegrante2',
        'ocupacionIntegrante2',
        'integrante3',
        'relacionIntegrante3',
        'edadintegrante3',
        'ocupacionIntegrante3',
        'integrante4',
        'relacionIntegrante4',
        'edadintegrante4',
        'ocupacionIntegrante4',
        'integrante5',
        'relacionIntegrante5',
        'edadintegrante5',
        'ocupacionIntegrante5',
        'integrante6',
        'relacionIntegrante6',
        'edadintegrante6',
        'ocupacionIntegrante6',
        'integrante7',
        'relacionIntegrante7',
        'edadintegrante7',
        'ocupacionIntegrante7',
        'conQuienViveAlumno',
        'direccionViviendaAlumno',
        'situcionLegal',
        'descripcionNinio',
        'apoyoTarea',
        'escuelaAnterior',
        'aniosEstudiados',
        'motivosCambioEscuela',
        'kinder',
        'observacionEscolar',
        'estudioPreescolar',
        'preescolar1',
        'preescolar2',
        'preescolar3',
        'promedio1',
        'promedio2',
        'promedio3',
        'promedio4',
        'promedio5',
        'promedio6',
        'recursamientoGrado',
        'deportes',
        'apoyoPedagogico',
        'obsPedagogico',
        'terapiaLenguaje',
        'obsTerapiaLenguaje',
        'tratamientoMedico',
        'obsTratamientoMedico',
        'hemofilia',
        'obsHemofilia',
        'obsEpilepsia',        
        'epilepsia',
        'kawasaqui',
        'obsKawasaqui',
        'asma',
        'obsAsma',
        'diabetes',
        'obsDiabetes',
        'cardiaco',
        'obsCardiaco',
        'dermatologico',
        'obsDermatologico',
        'alergias',
        'tipoAlergias',
        'otroTratamiento',
        'tomaMedicamento',
        'cuidadoEspecifico',
        'tratimientoNeurologico',
        'obsTratimientoNeurologico',
        'tratamientoPsicologico',
        'obsTratimientoPsicologico',
        'medicoTratante',
        'llevarAlNinio',
        'motivoInscripcionEscuela',
        'conocidoEscuela1',
        'conocidoEscuela2',
        'conocidoEscuela3',
        'referencia1',
        'celularReferencia1',
        'referencia2',
        'celularReferencia2',
        'referencia3',
        'celularReferencia3',
        'obsGenerales',
        'entrevistador',
        'obsHemofilia',
        'estatus_edicion'
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        if(Auth::check()){
            static::saving(function($table) {
                $table->usuario_at = Auth::user()->id;
            });

            static::updating(function($table) {
                $table->usuario_at = Auth::user()->id;
            });

            static::deleting(function($table) {
                $table->usuario_at = Auth::user()->id;
            });
        }
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
