<?php

namespace App\Http\Models\Preescolar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Preescolar_rubricas extends Model
{
    protected $table = 'preescolar_rubricas';


    protected $fillable = [
        'periodo_id',
        'programa_id',
        'preescolar_rubricas_tipo_id',
        'tipo',
        'grado',
        'trimestre1',
        'trimestre2',
        'trimestre3',
        'rubrica',
        'aplica',
        'nivel_aprovechamiento',
        'orden_impresion'       
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
}
