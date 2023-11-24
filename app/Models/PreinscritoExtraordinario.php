<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class PreinscritoExtraordinario extends Model
{
    //
	use SoftDeletes;

	protected $table = 'preinscritosextraordinarios';

	protected $fillable = [
		'alumno_id',
		'extraordinario_id',
		'empleado_id',
		'materia_id',
		'aluClave',
		'aluNombre',
		'empNombre',
		'ubiClave',
		'ubiNombre',
		'progClave',
		'progNombre',
		'matClave',
		'matNombre',
		'extFecha',
		'extHora',
		'extPago',
		'folioFichaPago',
		'folioFichaPagoBBVA',
		'folioFichaPagoHSBC',
		'pexEstado',
	];

	protected $dates = [
		'deleted_at'
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
            $table->usuario_at = Auth::user()->id;
        });
    }
   }

   public function alumno() {
   	return $this->belongsTo(Alumno::class);
   }

   public function extraordinario() {
   	return $this->belongsTo(Extraordinario::class);
   }

   public function empleado() {
   	return $this->belongsTo(Empleado::class);
   }

   public function materia() {
   	return $this->belongsTo(Materia::class);
   }



}
