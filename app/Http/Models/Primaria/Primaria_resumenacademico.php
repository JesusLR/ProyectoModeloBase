<?php

namespace App\Http\Models\Primaria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\PrimariaGenerarLogs;
use App\Http\Models\Alumno;
use App\Http\Models\Periodo;
use App\Http\Models\Plan;

class Primaria_resumenacademico extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'primaria_resumenacademico';


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
        'alumno_id',
        'plan_id',
        'resClaveEspecialidad',
        'resPeriodoIngreso',
        'resPeriodoEgreso',
        'resPeriodoUltimo',
        'resUltimoGrado',
        'resCreditosCursados',
        'resCreditosAprobados',
        'resAvanceAcumulado',
        'resPromedioAcumulado',
        'resEstado',
        'resFechaIngreso',
        'resFechaEgreso',
        'resFechaBaja',
        'resRazonBaja',
        'resObservaciones',
        'usuario_id',
        'created_at',
        'updated_at'
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
            PrimariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'nuevo_registro',
            ]);
            $table->usuario_id = Auth::user()->id;
        });

        static::updating(function($table) {
            PrimariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_actualizado',
            ]);
            $table->usuario_id = Auth::user()->id;
        });

        static::deleting(function($table) {
            PrimariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_eliminado',
            ]);
            $table->usuario_id = Auth::user()->id;
        });
    }
   }


    public function alumno()
    {
      return $this->belongsTo(Alumno::class);
    }

    public function plan()
    {
      return $this->belongsTo(Plan::class);
    }

    public function periodoIngreso(){
        return $this->belongsTo(Periodo::class, 'resPeriodoIngreso');
    }

    public function periodoEgreso(){
        return $this->belongsTo(Periodo::class,'resPeriodoEgreso');
    }

    public function periodoUltimo(){
        return $this->belongsTo(Periodo::class,'resPeriodoUltimo');
    }

}