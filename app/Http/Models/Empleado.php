<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;


class Empleado extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empleados';


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
        'persona_id',
        'escuela_id',
        'empHorasCon',
        'empCredencial',
        'empNomina',
        'empRfc',
        'empImss',
        'empEstado',
        'empFechaRegistro',
        'empFechaBaja',
        'empCausaBaja',
        'empCorreo1',
        'puesto_id',
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
            foreach ($table->grupos()->get() as $grupo) {
                $grupo->delete();
            }
            foreach ($table->extraordinarios()->get() as $extraordinario) {
                $extraordinario->delete();
            }
            foreach ($table->claves_profesores()->get() as $clave_profesor) {
                $clave_profesor->delete();
            }
        });
    }
   }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class);
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function user_docente()
    {
        return $this->hasOne(User_docente::class);
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }

    public function extraordinarios()
    {
        return $this->hasMany(Extraordinario::class);
    }

    public function escuelas()
    {
        return $this->hasMany(Escuela::class);
    }

    public function programas()
    {
        return $this->hasMany(Programa::class);
    }

    public function cgts()
    {
        return $this->hasMany(Cgt::class);
    }

    public function claves_profesores()
    {
        return $this->hasMany(ClaveProfesor::class);
    }

    public function horariosadmivos()
    {
        return $this->hasMany(HorarioAdmivo::class);
    }

    public function escolaridades()
    {
        return $this->hasMany(Escolaridad::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    // SCOPES ------------------------------------------

    public function scopeActivos($query)
    {
        return $query->where('empEstado', 'A');
    }
}