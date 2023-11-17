<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;
use App\Http\Models\Bachiller\Bachiller_empleados;
use App\Http\Models\Primaria\Primaria_empleado;
use App\Http\Models\Secundaria\Secundaria_empleados;

class Cgt extends Model
{

    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cgt';


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
        'cgtGradoSemestre',
        'cgtGrupo',
        'cgtTurno',
        'cgtDescripcion',
        'cgtEstado',
        'cgtCupo',
        'empleado_id',
        'cgtTotalRegistrados',
        'cgtInscritos',
        'cgtPreinscritos',
        'cgtBaja',
        'cgtOtros'
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
            foreach ($table->cursos()->get() as $curso) {
                $curso->delete();
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

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
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
}