<?php

namespace App\Models\Secundaria;

use App\Models\Curso;
use App\Models\Secundaria\Secundaria_grupos;
use App\Models\Secundaria\Secundaria_calificaciones;
use App\Http\Helpers\SecundariaGenerarLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Secundaria_inscritos extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'secundaria_inscritos';


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
        'id',
        'curso_id',
        'grupo_id',
        'inscCalificacionSep',
        'inscCalificacionOct',
        'inscCalificacionNov',
        'inscCalificacionDic',
        'inscCalificacionEne',
        'inscCalificacionFeb',
        'inscCalificacionMar',
        'inscCalificacionAbr',
        'inscCalificacionMay',
        'inscCalificacionJun',
        'inscPromedioPorMeses',
        'inscPromedioBimestre1',
        'inscPromedioBimestre2',
        'inscPromedioBimestre3',
        'inscPromedioBimestre4',
        'inscPromedioBimestre5',
        'inscPromedioPorBimestre',
        'inscTrimestre1',
        'inscTrimestre2',
        'inscTrimestre3',
        'inscRecuperativoTrimestre1',
        'inscRecuperativoTrimestre2',
        'inscRecuperativoTrimestre3',
        'inscPromedioTrim',
        'inscCalificacionFinalModelo',
        'inscCalificacionFinalSEP',
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
        'inscFaltasJusJun',
        'inscConductaSep',
        'inscConductaOct',
        'inscConductaNov',
        'inscConductaDic',
        'inscConductaEne',
        'inscConductaFeb',
        'inscConductaMar',
        'inscConductaAbr',
        'inscConductaMay',
        'inscConductaJun',
        'inscParticipacionSep',
        'inscParticipacionOct',
        'inscParticipacionNov',
        'inscParticipacionDic',
        'inscParticipacionEne',
        'inscParticipacionFeb',
        'inscParticipacionMar',
        'inscParticipacionAbr',
        'inscParticipacionMay',
        'inscParticipacionJun',
        'inscConvivenciaSep',
        'inscConvivenciaOct',
        'inscConvivenciaNov',
        'inscConvivenciaDic',
        'inscConvivenciaEne',
        'inscConvivenciaFeb',
        'inscConvivenciaMar',
        'inscConvivenciaAbr',
        'inscConvivenciaMay',
        'inscConvivenciaJun',
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

            SecundariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'nuevo_registro',
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {

            SecundariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_actualizado',
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {

            SecundariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_eliminado',
            ]);

            $table->usuario_at = Auth::user()->id;
            // $haycalificaciones = Secundaria_calificaciones::where('secundaria_inscrito_id', "=", $table->id)->get();
            //dd($haycalificaciones->isEmpty(), !empty($haycalificaciones));
            // if(!$haycalificaciones->isEmpty()) {
            //     $table->secundaria_calificacion->where("secundaria_inscrito_id", "=", $table->id)->delete();
            // }

        });
    }
   }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function secundaria_grupo()
    {
        return $this->belongsTo(Secundaria_grupos::class, 'grupo_id');
    }

    public function secundaria_calificacion()
    {
        return $this->hasOne(Secundaria_calificaciones::class, 'secundaria_inscrito_id');
    }

    public function secundaria_materia()
    {
        return $this->hasOne(Secundaria_materias::class);
    }

}
