<?php

namespace App\Models\Preescolar;

use App\Models\Empleado;
use App\Models\Periodo;
use App\Models\Plan;
use App\Http\Helpers\PreescolarGenerarLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Preescolar_grupo extends Model
{
    use SoftDeletes;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preescolar_grupos';


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
        'preescolar_materia_id',
        'plan_id',
        'periodo_id',
        'gpoGrado',
        'gpoClave',
        'gpoTurno',
        'empleado_id_docente',
        'empleado_id_auxiliar',
        'gpoMatClaveComplementaria',
        'gpoFechaExamenOrdinario',
        'gpoHoraExamenOrdinario',
        'gpoCupo',
        'gpoNumeroFolio',
        'gpoNumeroActa',
        'gpoNumeroLibro',
        'inscritos_gpo'     
        
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

            PreescolarGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'nuevo_registro',
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {

            PreescolarGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_actualizado',
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {

            PreescolarGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_eliminado',
            ]);

            $table->usuario_at = Auth::user()->id;
            foreach ($table->preescolar_inscritos()->get() as $inscrito) {
            $inscrito->delete();
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

    public function preescolar_materia()
    {
        return $this->belongsTo(Preescolar_materia::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id_docente');
    }

    public function preescolar_inscritos()
    {
        return $this->hasMany(Preescolar_inscrito::class);
    }



}

