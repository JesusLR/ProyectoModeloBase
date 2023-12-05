<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class Puesto extends Model
{
    use SoftDeletes;

   	protected $table = 'puestos';

   	protected $fillable = [
   		'puesNombre',
   	];

   	protected $dates = [
   		'deleted_at',
   	];

   	protected static function boot()
   	{
   		parent::boot();
   		if(Auth::check()) {
   			static::saving(function($table) {

   				GenerarLogs::crearLogs((Object) [
   					"nombreTabla" => $table->getTable(),
   					"registroId" => $table->id,
   				]);

   				$table->usuario_at = Auth::user()->id;

   			});

   			static::updating(function($table) {
   				GenerarLogs::crearLogs((Object) [
   					"nombreTabla" => $table->getTable(),
   					"registroId" => $table->id,
   				]);

   				$table->usuario_at = Auth::user()->id;
   			});

   			static::deleting(function($table) {
   				GenerarLogs::crearLogs((Object) [
   					"nombreTabla" => $table->getTable(),
   					"registroId" => $table->id,
   				]);

   				$table->usuario_at = Auth::user()->id;
   			});
   		}
   	}

   	public function empleados()
   	{
   		return $this->hasMany(Empleado::class);
   	}
}
