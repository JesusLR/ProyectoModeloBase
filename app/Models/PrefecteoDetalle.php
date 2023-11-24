<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class PrefecteoDetalle extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prefecteodetalle';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prefecteo_id',
        'grupo_id',
        'aula_id',
        'programa_id',
        'asistenciaObservaciones',
        'asistenciaEstado',
        'prefHora',
        'ghDia',
        'ghInicio',
        'ghFinal',
        'usuario_at',
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

   public function prefecteo()
   {
   		return $this->belongsTo(Prefecteo::class, 'prefecteo_id');
   }

   public function grupo()
   {
        return $this->belongsTo(Grupo::class);
   }

   public function aula()
   {
        return $this->belongsTo(Aula::class);
   }

   public function programa()
   {
        return $this->belongsTo(Programa::class);
   }


}
