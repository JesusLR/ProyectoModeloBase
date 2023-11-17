<?php

namespace App\Http\Models\Primaria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Primaria_expediente_seguimiento_escolar extends Model
{
    use SoftDeletes;

    protected $table = 'primaria_expediente_seguimiento_escolar';

    protected $guarded = ['id'];

    protected $fillable = [
        'curso_id',
        'fechaEntrevista',
        'perAsistieronEntrevista',
        'entrevistaPeticion',
        'motivoEntrevista',
        'comentarioPadres',
        'acuerdosCompromisos',
        'observacionesEntrevista',
        'proximaEntrevista',
        'perAsistieron1NombreCompleto',
        'perAsistieron2NombreCompleto',
        'primaria_empleado_id_docente',
        'primaria_empleado_id_psicologa',
        'primaria_empleado_directora',
        'perNombreExtra'
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

    // public function alumno()
    // {
    //     return $this->belongsTo(Alumno::class);
    // }
}
