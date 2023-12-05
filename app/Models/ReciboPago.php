<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class ReciboPago extends Model
{
    use SoftDeletes;

    protected $table = 'recibosdepago';

    protected $guarded = ['id'];

   	protected $fillable = [
   		'alumno_id',
   		'aluClave',
   		'conpClave',
   		'concepto',
   		'importe',
   		'fecha',
   		'hora',
   		'reciboEstado',
        'inscritosextraordinarios_id'
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
}
