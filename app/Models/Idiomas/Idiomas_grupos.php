<?php

namespace App\Models\Idiomas;

use App\Models\Idiomas\Idiomas_materias;
use App\Models\Idiomas\Idiomas_inscritos;
use App\Models\Optativa;
use App\Models\Periodo;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Idiomas_grupos extends Model
{
    use SoftDeletes;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'idiomas_grupos';


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
        'gpoGrado',
        'gpoClave',
        'gpoDescripcion',
        'gpoCupo',
        'idiomas_empleado_id',
        'gpoHoraInicioLunes',
        'gpoHoraFinLunes',
        'gpoAulaLunes',
        'gpoHoraInicioMartes',
        'gpoHoraFinMartes',
        'gpoAulaMartes',
        'gpoHoraInicioMiercoles',
        'gpoHoraFinMiercoles',
        'gpoAulaMiercoles',
        'gpoHoraInicioJueves',
        'gpoHoraFinJueves',
        'gpoAulaJueves',
        'gpoHoraInicioViernes',
        'gpoHoraFinViernes',
        'gpoAulaViernes',
        'gpoHoraInicioSabado',
        'gpoHoraFinSabado',
        'gpoAulaSabado'
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
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            $table->usuario_at = Auth::user()->id;
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

    public function idiomas_materia()
    {
        return $this->belongsTo(Idiomas_materias::class);
    }

    public function idiomas_empleado()
    {
        return $this->belongsTo(Idiomas_empleados::class, 'idiomas_empleado_id');
    }

    public function idiomas_inscrito()
    {
        return $this->hasMany(Idiomas_inscritos::class, 'idiomas_grupo_id');
    }

    public function idiomas_horarios()
    {
        return $this->hasMany(Idiomas_horarios::class);
    }

    public function equivalentes()
    {
        return $this->hasMany(Idiomas_grupos::class, 'id', 'grupo_equivalente_id');
    }

    public function optativa()
    {
        return $this->belongsTo(Optativa::class);
    }
}