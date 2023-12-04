<?php

namespace App\Models\Primaria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Primaria_UsuarioLog extends Model
{

    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'primaria_usuarioslog';


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
        'nombre_tabla',
        'registro_id',
        'nombre_controlador_accion',
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
    if (Auth::check()) {
       static::saving(function($table) {
           $table->usuario_at = Auth::user()->id;
       });
    }
  }

}