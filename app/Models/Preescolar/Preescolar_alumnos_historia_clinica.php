<?php

namespace App\Models\Preescolar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Preescolar_alumnos_historia_clinica extends Model
{
    protected $table = 'preescolar_alumnos_historia_clinica';

    protected $fillable = [
        'alumno_id',
        'hisEdadActualMeses',
        'hisTipoSangre',
        'hisAlergias',
        'hisEscuelaProcedencia',
        'hisUltimoGrado',
        'hisRecursado',
        'hisRecursadoDetalle'
    ];

    protected static function boot()
    {
        parent::boot();

        if (Auth::check()) {
            static::saving(function ($table) {
                $table->usuario_at = Auth::user()->id;
            });

            static::updating(function ($table) {
                $table->usuario_at = Auth::user()->id;
            });

            static::deleting(function ($table) {
                $table->usuario_at = Auth::user()->id;
            });
        }
    }
}
