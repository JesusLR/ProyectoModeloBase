<?php

namespace App\Models;

use App\Models\Primaria\Primaria_materia;
use App\Models\Secundaria\Secundaria_materias;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Historico extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'historico';


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
        'grupo_id',
        'alumno_id',
        'plan_id',
        'materia_id',
        'periodo_id',
        'histComplementoNombre',
        'histPeriodoAcreditacion',
        'histTipoAcreditacion',
        'histFechaExamen',
        'histCalificacion',
        'histFolio',
        'hisActa',
        'histLibro',
        'histNombreOficial'
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
          if ($table->calificacion) {
            $table->usuario_at = Auth::user()->id;
            $table->calificacion->delete();
          }
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

    public function materia()
    {
      return $this->belongsTo(Materia::class);
    }

    public function periodo()
    {
      return $this->belongsTo(Periodo::class);
    }

    public function inscrito(){
      return $this->hasOne(Inscrito::class);
    }


    // para primaria 
    public function primaria_materia()
    {
      return $this->belongsTo(Primaria_materia::class, 'materia_id');
    }

    // para secundaria 
    public function secundaria_materia()
    {
      return $this->belongsTo(Secundaria_materias::class, 'materia_id');
    }


    // SCOPES -----------------------------------------------

    public function scopeExtraordinarios($query)
    {
        return $query->where('histPeriodoAcreditacion', 'EX');
    }

}