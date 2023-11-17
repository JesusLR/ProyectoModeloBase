<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use App\Http\Helpers\GenerarLogs;


class Grupo extends Model
{
    use SoftDeletes;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grupos';


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
        'materia_id',
        'plan_id',
        'periodo_id',
        'gpoSemestre',
        'gpoClave',
        'gpoTurno',
        'empleado_id',
        'empleado_sinodal_id',
        'gpoMatClaveComplementaria',
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
        'gpoExtraCurr'
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
            foreach ($table->inscritos()->get() as $inscrito) {
            $inscrito->delete();
            }
            foreach ($table->horarios()->get() as $horario) {
                $horario->delete();
            }
            foreach ($table->paquetes_detalle()->get() as $paquete_detalle) {
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

    public function optativa()
    {
        return $this->belongsTo(Optativa::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function inscritos()
    {
        return $this->hasMany(Inscrito::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function paquetes_detalle()
    {
        return $this->hasMany(Paquete_detalle::class);
    }

    public function equivalentes()
    {
        return $this->hasMany(Grupo::class, 'id', 'grupo_equivalente_id');
    }

    public function sinodal()
    {
        return $this->belongsTo(Empleado::class, 'empleado_sinodal_id');
    }
}

