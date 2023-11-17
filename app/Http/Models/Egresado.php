<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class Egresado extends Model
{
    //
    use SoftDeletes;

    protected $table = 'egresados';

    protected $guarded = ['id'];

    protected $fillable = [
        'periodo_id',
        'alumno_id',
        'plan_id',
        'egrPrimerPeriodo',
        'egrUltimoPeriodo',
        'egrUltimoMesPago',
        'egrUltimoAnioPago',
        'egrCreditosPlan',
        'egrCreditosCursados',
        'egrPeriodoTitulacion',
        'egrFechaExamenProfesional',
        'egrFechaExpedicionTitulo',
        'egrOpcionTitulo',
        'egrModoTituloSegey',
        'egrDesempenioSegey',
        'egrTipoDesempenioSegey',
        'egrTipoBecaSegey',
        'usuario_at',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'deleted_at',
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

    public function periodo(){
    	return $this->belongsTo(Periodo::class);
    }

    public function alumno(){
    	return $this->belongsTo(Alumno::class);
    }

    public function plan(){
    	return $this->belongsTo(Plan::class);
    }

    public function periodoTitulacion(){
        return $this->belongsTo(Periodo::class,'egrPeriodoTitulacion');
    }

    public function ultimoPeriodo(){
        return $this->belongsTo(Periodo::class, 'egrUltimoPeriodo');
    }


}
