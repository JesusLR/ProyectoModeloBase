<?php

namespace App\Models\Bachiller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\BachillerCCHGenerarLogs;
use App\Models\Periodo;

class Bachiller_cch_calendario_calificaciones_docentes extends Model
{
    //

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bachiller_cch_calendario_calificaciones_docentes';


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
        'plan_id',
        'periodo_id',
        'calexInicioParcial1',
        'calexFinParcial1',
        'calexInicioParcial2',
        'calexFinParcial2',
        'calexInicioParcial3',
        'calexFinParcial3',
        'calexInicioParcial4',
        'calexFinParcial4',
        'calexInicioRecuperacion',
        'calexFinRecuperacion',
        'calexInicioExtraordinario',
        'calexFinExtraordinario',
        'calexInicioEspecial',
        'calexFinEspecial',
        'calexUsuarioMod',
        'calexFechaMod',
        'calexHoraMod'
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
            
            BachillerCCHGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'nuevo_registro',
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            
            BachillerCCHGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_actualizado',
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            
            BachillerCCHGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_eliminado',
            ]);

            $table->usuario_at = Auth::user()->id;
        });
    }
   }


   public function periodo() {
   	return $this->belongsTo(Periodo::class);
   }


}
