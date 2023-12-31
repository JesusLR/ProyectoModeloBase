<?php

namespace App\Models\Secundaria;

use App\Models\Secundaria\Secundaria_materias;
use App\Models\Secundaria\secundaria_inscritos;
use App\Models\Periodo;
use App\Models\Plan;
use App\Http\Helpers\SecundariaGenerarLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Secundaria_grupos extends Model
{
    use SoftDeletes;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'secundaria_grupos';


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
        'secundaria_materia_id',
        'plan_id',
        'periodo_id',
        'gpoGrado',
        'gpoClave',
        'gpoTurno',
        'empleado_id_docente',
        'empleado_id_auxiliar',
        'gpoMatComplementaria',        
        'gpoFechaExamenOrdinario',
        'gpoHoraExamenOrdinario',
        'gpoCupo',
        'gpoNumeroFolio',
        'gpoNumeroActa',
        'gpoNumeroLibro',
        'grupo_equivalente_id',
        'optativa_id',
        'estado_act',
        'fecha_mov_ord_act',
        'clave_actv',
        'inscritos_gpo',
        'nombreAlternativo',
        'gpoExtraCurr',
        'gpoACD',
        'secundaria_materia_acd_id'
        
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
            foreach ($table->secundaria_inscrito()->get() as $inscrito) {
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

    public function secundaria_materia()
    {
        return $this->belongsTo(Secundaria_materias::class);
    }

    public function secundaria_empleado()
    {
        return $this->belongsTo(Secundaria_empleados::class, 'empleado_id_docente');
    }

    public function secundaria_inscrito()
    {
        return $this->hasMany(Secundaria_inscritos::class, 'grupo_id');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }


}