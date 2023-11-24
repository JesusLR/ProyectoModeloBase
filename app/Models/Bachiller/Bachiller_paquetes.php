<?php

namespace App\Models\Bachiller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\BachillerGenerarLogs;
use App\Models\Cgt;
use App\Models\Periodo;
use App\Models\Plan;

class Bachiller_paquetes extends Model
{
    use SoftDeletes;
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bachiller_paquetes';


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
        'periodo_id',
        'plan_id',
        'cgt_id',
        'semestre',
        'consecutivo',
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
            BachillerGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'nuevo_registro',
            ]);
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            BachillerGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_actualizado',
            ]);
            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            BachillerGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_eliminado',
            ]);
            $table->usuario_at = Auth::user()->id;
            foreach ($table->bachiller_paquetes_detalle()->get() as $paquete_detalle) {
                $paquete_detalle->delete();
            }
        });
    }
   }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function bachiller_paquetes_detalle()
    {
        return $this->hasMany(Bachiller_paquete_detalle::class, "bachiller_paquete_id");
    }

    public function cgt()
    {
        return $this->belongsTo(Cgt::class);
    }
}