<?php

namespace App\Models;

use App\Models\Idiomas\Idiomas_empleados;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Primaria\Primaria_empleado;
use App\Models\Secundaria\Secundaria_empleados;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Programa extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'programas';


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
        'escuela_id',
        'empleado_id',
        'progClave',
        'progNombre',
        'progNombreCorto',
        'progClaveSegey',
        'progClaveEgre',
        'progTituloOficial',
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
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            $table->usuario_at = Auth::user()->id;
            foreach ($table->planes()->get() as $plan) {
                $plan->delete();
            }
            foreach ($table->permisos()->get() as $permiso) {
                $permiso->delete();
            }
            foreach ($table->referencias()->get() as $referencia) {
                $referencia->delete();
            }
            foreach ($table->matriculas_anteriores()->get() as $matricula_anterior) {
                $matricula_anterior->delete();
            }
        });
    }
   }

   public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class);
    }

    public function planes()
    {
        return $this->hasMany(Plan::class);
    }

    public function permisos()
    {
        return $this->hasMany(Permiso_programa_user::class);
    }

    public function referencias()
    {
        return $this->hasMany(Referencia::class);
    }

    public function matriculas_anteriores()
    {
        return $this->hasMany(MatriculaAnterior::class);
    }

    public function primaria_empleado()
    {
        return $this->belongsTo(Primaria_empleado::class, 'empleado_id_docente');
    }

    public function secundaria_empleado()
    {
        return $this->belongsTo(Secundaria_empleados::class, 'empleado_id_docente');
    }

    public function bachiller_empleado()
    {
        return $this->belongsTo(Bachiller_empleados::class, 'empleado_id_docente');
    }

    public function idiomas_empleado()
    {
        return $this->belongsTo(Idiomas_empleados::class, 'empleado_id_docente');
    }
}