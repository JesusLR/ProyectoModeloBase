<?php

namespace App\Models\Bachiller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\BachillerGenerarLogs;
use App\Models\Bachiller\Bachiller_empleados;
use App\Models\Bachiller\Bachiller_materias;
use App\Models\Periodo;

class Bachiller_extraordinarios extends Model
{
    use SoftDeletes;

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bachiller_extraordinarios';


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
        'periodo_id',
        'bachiller_materia_id',
        'bachiller_fecha_regularizacion_id',
        'extTipo',
        'extFecha',
        'extHora',
        'extLugar',
        'bachiller_empleado_id',
        'bachiller_empleado_sinodal_id',
        'extNumeroFolio',
        'extNumeroActa',
        'extNumeroLibro',
        'extPago',
        'extAlumnosInscritos',
        'extGrupo',
        'extHoraInicioLunes',
        'extHoraFinLunes',
        'extAulaLunes',
        'extHoraInicioMartes',
        'extHoraFinMartes',
        'extAulaMartes',
        'extHoraInicioMiercoles',
        'extHoraFinMiercoles',
        'extAulaMiercoles',
        'extHoraInicioJueves',
        'extHoraFinJueves',
        'extAulaJueves',
        'extHoraInicioViernes',
        'extHoraFinViernes',
        'extAulaViernes',
        'extHoraInicioSabado',
        'extHoraFinSabado',
        'extAulaSabado',
        'extFechaSesion01',
        'extFechaSesion02',
        'extFechaSesion03',
        'extFechaSesion04',
        'extFechaSesion05',
        'extFechaSesion06',
        'extFechaSesion07',
        'extFechaSesion08',
        'extFechaSesion09',
        'extFechaSesion10',
        'extFechaSesion11',
        'extFechaSesion12',
        'extFechaSesion13',
        'extFechaSesion14',
        'extFechaSesion15',
        'extFechaSesion16',
        'extFechaSesion17',
        'extFechaSesion18',
        'extHoraInicioSesion01',
        'extHoraInicioSesion02',
        'extHoraInicioSesion03',
        'extHoraInicioSesion04',
        'extHoraInicioSesion05',
        'extHoraInicioSesion06',
        'extHoraInicioSesion07',
        'extHoraInicioSesion08',
        'extHoraInicioSesion09',
        'extHoraInicioSesion10',
        'extHoraInicioSesion11',
        'extHoraInicioSesion12',
        'extHoraInicioSesion13',
        'extHoraInicioSesion14',
        'extHoraInicioSesion15',
        'extHoraInicioSesion16',
        'extHoraInicioSesion17',
        'extHoraInicioSesion18',
        'extHoraFinSesion01',
        'extHoraFinSesion02',
        'extHoraFinSesion03',
        'extHoraFinSesion04',
        'extHoraFinSesion05',
        'extHoraFinSesion06',
        'extHoraFinSesion07',
        'extHoraFinSesion08',
        'extHoraFinSesion09',
        'extHoraFinSesion10',
        'extHoraFinSesion11',
        'extHoraFinSesion12',
        'extHoraFinSesion13',
        'extHoraFinSesion14',
        'extHoraFinSesion15',
        'extHoraFinSesion16',
        'extHoraFinSesion17',
        'extHoraFinSesion18',
        'extMinutoInicioLunes',
        'extMinutoFinLunes',
        'extMinutoInicioMartes',
        'extMinutoFinMartes',
        'extMinutoInicioMiercoles',
        'extMinutoFinMiercoles',
        'extMinutoInicioJueves',
        'extMinutoFinJueves',
        'extMinutoInicioViernes',
        'extMinutoFinViernes',
        'extMinutoInicioSabado',
        'extMinutoFinSabado',
        'extMinutoInicioSesion01',
        'extMinutoInicioSesion02',
        'extMinutoInicioSesion03',
        'extMinutoInicioSesion04',
        'extMinutoInicioSesion05',
        'extMinutoInicioSesion06',
        'extMinutoInicioSesion07',
        'extMinutoInicioSesion08',
        'extMinutoInicioSesion09',
        'extMinutoInicioSesion10',
        'extMinutoInicioSesion11',
        'extMinutoInicioSesion12',
        'extMinutoInicioSesion13',
        'extMinutoInicioSesion14',
        'extMinutoInicioSesion15',
        'extMinutoInicioSesion16',
        'extMinutoInicioSesion17',
        'extMinutoInicioSesion18',
        'extMinutoFinSesion01',
        'extMinutoFinSesion02',
        'extMinutoFinSesion03',
        'extMinutoFinSesion04',
        'extMinutoFinSesion05',
        'extMinutoFinSesion06',
        'extMinutoFinSesion07',
        'extMinutoFinSesion08',
        'extMinutoFinSesion09',
        'extMinutoFinSesion10',
        'extMinutoFinSesion11',
        'extMinutoFinSesion12',
        'extMinutoFinSesion13',
        'extMinutoFinSesion14',
        'extMinutoFinSesion15',
        'extMinutoFinSesion16',
        'extMinutoFinSesion17',
        'extMinutoFinSesion18'

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
            BachillerGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'nuevo_registro',
            ]);
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            BachillerGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_actualizado',
            ]);
            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            BachillerGenerarLogs::crearLogs((Object) [
                'curso_id' => $table->curso_id,
                'alumno_id' => $table->alumno_id,
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
                'tipo_accion' => 'registro_eliminado',
            ]);
            $table->usuario_at = Auth::user()->id;
        });
    }
   }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function bachiller_materia()
    {
        return $this->belongsTo(Bachiller_materias::class, "bachiller_materia_id");
    }

    // public function aula()
    // {
    //     return $this->belongsTo(Aula::class);
    // }

    // public function optativa()
    // {
    //     return $this->belongsTo(Optativa::class);
    // }

    public function bachiller_empleado()
    {
        return $this->belongsTo(Bachiller_empleados::class);
    }

    public function bachiller_empleadoSinodal()
    {
        return $this->belongsTo(Bachiller_empleados::class, "bachiller_empleado_sinodal_id");
    }

    public function bachiller_inscritos(){
        return $this->hasMany(Bachiller_inscritosextraordinarios::class, "extraordinario_id");
    }

    public function bachiller_preinscritos() 
    {
        return $this->hasMany(Bachiller_preinscritosextraordinarios::class, "bachiller_extraordinario_id");
    }
}