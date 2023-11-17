<?php

namespace App\Http\Models\Bachiller;

use App\Http\Models\Curso;
use App\Http\Helpers\BachillerCCHGenerarLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Bachiller_cch_inscritos extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bachiller_cch_inscritos';


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
        'curso_id',
        'bachiller_grupo_id', 
        'preparatoria_historico_id',
        'insCalificacionOrdinarioParcial1',
        'insFaltasOrdinarioParcial1',
        'insAproboParcial1',
        'insCalificacionOrdinarioParcial2',
        'insFaltasOrdinarioParcial2',
        'insAproboParcial2',
        'insCalificacionOrdinarioParcial3',
        'insFaltasOrdinarioParcial3',
        'insAproboParcial3',
        'insCalificacionOrdinarioParcial4',
        'insFaltasOrdinarioParcial4',
        'insAproboParcial4',
        'insPromedioOrdinario4Parciales',
        'insCantidadReprobadasOrdinarioParciales',
        'insCalificacionRecuperativoParcial1',
        'insCalificacionRecuperativoParcial2',
        'insCalificacionRecuperativoParcial3',
        'insCalificacionRecuperativoParcial4',
        'insCantidadReprobadasRecuperativos',
        'insCalificacionExtraOrdinarioParcial1',
        'insCalificacionExtraOrdinarioParcial2',
        'insCalificacionExtraOrdinarioParcial3',
        'insCalificacionExtraOrdinarioParcial4',
        'insCantidadReprobadasExtraOrdinario',
        'insRecursaraComoRepetidor',
        'insCalificacionEspecial',
        'insCalificacionFinalParcial1',
        'insCalificacionFinalParcial2',
        'insCalificacionFinalParcial3',
        'insCalificacionFinalParcial4',
        'insCalificacionFinalPromedio',
        'inscFaltasInjSep',
        'inscFaltasInjOct',
        'inscFaltasInjNov',
        'inscFaltasInjDic',
        'inscFaltasInjEne',
        'inscFaltasInjFeb',
        'inscFaltasInjMar',
        'inscFaltasInjAbr',
        'inscFaltasInjMay',
        'inscFaltasInjJun',
        'inscFaltasJusSep',
        'inscFaltasJusOct',
        'inscFaltasJusNov',
        'inscFaltasJusDic',
        'inscFaltasJusEne',
        'inscFaltasJusFeb',
        'inscFaltasJusMar',
        'inscFaltasJusAbr',
        'inscFaltasJusMay',
        'inscFaltasJusJun'
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
            // $haycalificaciones = Bachiller_cch_calificaciones::where('bachiller_cch_inscrito_id', "=", $table->id)->get();
            // //dd($haycalificaciones->isEmpty(), !empty($haycalificaciones));
            // if(!$haycalificaciones->isEmpty()) {
            //     $table->bachiller_calificacion->where("bachiller_cch_inscrito_id", "=", $table->id)->delete();
            // }

        });
    }
   }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function bachiller_cch_grupo()
    {
        return $this->belongsTo(Bachiller_cch_grupos::class, 'bachiller_grupo_id');
    }

    public function bachiller_calificacion()
    {
        return $this->hasOne(Bachiller_cch_calificaciones::class, 'bachiller_cch_inscrito_id');
    }

    public function bachiller_materia()
    {
        return $this->hasOne(Bachiller_materias::class);
    }

}
