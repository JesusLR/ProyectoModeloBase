<?php

namespace App\Http\Models\Primaria;

use App\Http\Models\Plan;
use App\Http\Models\Primaria\Primaria_grupo;
use App\Http\Helpers\PrimariaGenerarLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Primaria_materia extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'primaria_materias';


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
        'matClave',
        'matNombre',
        'matNombreCorto',
        'matSemestre',
        'matCreditos',
        'matClasificacion',
        'matEspecialidad',
        'matTipoAcreditacion',
        'matPorcentajeParcial',
        'matPorcentajeOrdinario',
        'matNombreOficial',
        'matOrdenVisual',
        'matVigentePlanPeriodoActual',
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

            PrimariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'nuevo_registro',
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {

            PrimariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_actualizado',
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {

            PrimariaGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_eliminado',
            ]);

            $table->usuario_at = Auth::user()->id;
            foreach ($table->primaria_grupos()->get() as $grupo) {
            $grupo->delete();
            }
        });
    }
   }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function primaria_grupos()
    {
        return $this->hasMany(Primaria_grupo::class);
    }


}
