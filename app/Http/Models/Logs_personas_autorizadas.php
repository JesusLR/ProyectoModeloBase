<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Logs_personas_autorizadas extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs_personas_autorizadas';


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
        'curso_id',
        'alumno_id',
        'ip_emitente',
        'tipo_accion',
        'fecha_hora_movimiento',
        'usuario_at'
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
    if(Auth::check()){
       static::saving(function($table) {
           $table->usuario_at = Auth::user()->id;
       });

       static::updating(function($table) {
           $table->usuario_at = Auth::user()->id;
       });

       static::deleting(function($table) {
         if ($table->calificacion) {
           $table->usuario_at = Auth::user()->id;
         }
       });
     }
  }
}