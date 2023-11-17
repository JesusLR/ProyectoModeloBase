<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class UsuarioLog extends Model
{

    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuariosLog';


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
        'nombre_tabla',
        'registro_id',
        'nombre_controlador_accion',
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