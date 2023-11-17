<?php

namespace App\Http\Models\Idiomas;

use App\Http\Models\Cgt;
use App\Http\Models\ClaveProfesor;
use App\Http\Models\Escolaridad;
use App\Http\Models\Escuela;
use App\Http\Models\Extraordinario;
use App\Http\Models\HorarioAdmivo;
use App\Http\Models\Municipio;
use App\Http\Models\Programa;
use App\Models\User_docente;
use App\Http\Models\Idiomas\Idiomas_grupos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Idiomas_empleados extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'idiomas_empleados';


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
        'empCURP',
        'empRFC',
        'empNSS',
        'empNomina',
        'empCredencial',
        'empApellido1',
        'empApellido2',
        'empNombre',
        'escuela_id',
        'empHoras'  ,
        'empDireccionCalle',
        'empDireccionNumero',
        'empDireccionColonia',
        'empDireccionCP',
        'municipio_id',
        'empTelefono',
        'empFechaNacimiento',
        'empCorreo1',
        'puesto_id',
        'empSexo',
        'empEstado',
        'empFechaIngreso',
        'empCausaBaja',
        'empFechaBaja',
        'empObservaciones'
        
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

   public function escuela()
    {
        return $this->belongsTo(Escuela::class);
    }

    
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function user_docente()
    {
        return $this->hasOne(User_docente::class);
    }

    public function idiomas_grupos()
    {
        return $this->hasMany(Idiomas_grupos::class, 'idiomas_empleado_id');
    }

    public function Idiomas_cch_grupos()
    {
        return $this->hasMany(Idiomas_cch_grupos::class, 'idiomas_empleado_id');
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


    // SCOPES ------------------------------------------

    public function scopeActivos($query)
    {
        return $query->where('empEstado', 'A');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

}
