<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class ServicioSocial extends Model
{
    //
    use SoftDeletes;

    protected $table = 'serviciosocial';

    protected $guarded = 'id';

    protected $fillable = [
    	'alumno_id',
    	'progClave',
    	'ssLugar',
    	'ssDireccion',
    	'ssTelefono',
    	'ssJefeSuperior',
    	'ssHorarioLunes',
    	'ssHorarioMartes',
    	'ssHorarioMiercoles',
    	'ssHorarioJueves',
    	'ssHorarioViernes',
    	'ssHorarioSabado',
    	'ssHorarioDomingo',
    	'ssClasificacion',
    	'ssFechaInicio',
    	'ssNumeroPeriodoInicio',
    	'ssAnioPeriodoInicio',
    	'ssNumeroAsignacion',
    	'ssFechaLiberacion',
    	'ssNumeroPeriodoLiberacion',
    	'ssAnioPeriodoLiberacion',
    	'ssEstadoActual',
    	'ssFechaReporte1',
    	'ssFechaReporte2',
    	'ssFechaReporte3',
    	'ssFechaReporte4',
        'alcance_regional',
    	'usuario_at'
    ];

    protected $dates = [
    	'deleted_at'
    ];

    protected static function boot(){
    	parent::boot();

     if(Auth::check()){
        static::saving(function($table) {
            
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);

            $table->usuario_at = Auth::user()->id;
        });
      }
    }

    public function alumno(){
    	return $this->belongsTo(Alumno::class);
    }
}
