<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;


class InscritosRechazados extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inscritos_rechazados';


    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alumno_id',
        'aluClave',
        'perNombre',
        'perApellido1',
        'perApellido2',
        'curso_id',
        'ubicacion_id',
        'ubiClave',
        'ubiNombre',
        'departamento_id',
        'depNivel',
        'depClave',
        'depNombre',
        'escuela_id',
        'escNombre',
        'programa_id',
        'progNombre',
        'periodo_id',
        'perNumero',
        'perAnio',
        'cgt_id',
        'grupo_id',
        'materia_id',
        'matClave',
        'matNombre',
        'plan_id',
        'planClave',
        'gpoSemestre',
        'gpoClave',
        'gpoTurno',
        'rechazadoInscrito',
    ];

    protected $dates = [
        'deleted_at',
    ];
    
    /**
   * Override parent boot and Call deleting event
   *
   * @return void
   */
   protected static function boot()
   {
     parent::boot();
     
   }
}