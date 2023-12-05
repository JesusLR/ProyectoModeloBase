<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class Mensaje extends Model
{
    use SoftDeletes;

    protected $table = 'mensajes';

    protected $fillable = [
    	'msjModulo',
    	'msjMensaje',
    ];

    protected $dates = [
    	'deleted_at',
    ];

    protected static function boot()
    {
    	parent::boot();
    	if(Auth::check()) {
    		static::saving(function($table) {
    			$table->usuario_at = Auth::user()->id;
    		});

    		static::updating(function($table) {
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

    //SCOPES -------------------------------------------

    public function scopeDelModulo($query, $value)
    {
    	return $query->where('msjModulo', $value);
    }

}
