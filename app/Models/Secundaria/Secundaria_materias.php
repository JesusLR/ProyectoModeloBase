<?php

namespace App\Models\Secundaria;

use App\Models\Plan;
use App\Models\Secundaria\Secundaria_grupos;
use App\Http\Helpers\SecundariaGenerarLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Secundaria_materias extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'secundaria_materias';


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
            foreach ($table->secundaria_grupos()->get() as $grupo) {
            $grupo->delete();
            }
        });
    }
   }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function secundaria_grupos()
    {
        return $this->hasMany(Secundaria_grupos::class, 'empleado_id_docente');
    }


}
