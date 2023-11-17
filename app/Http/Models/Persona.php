<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;
use App\clases\personas\MetodosPersonas;

use Carbon\Carbon;

class Persona extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personas';


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
        'perCurp',
        'perApellido1',
        'perApellido2',
        'perNombre',
        'perFechaNac',
        'municipio_id',
        'perSexo',
        'perCorreo1',
        'perTelefono1',
        'perTelefono2',
        'perDirCP',
        'perDirCalle',
        'perDirNumInt',
        'perDirNumExt',
        'perDirColonia',
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
        });
    }
   }
   
    public function empleado()
    {
        return $this->hasOne(Empleado::class);
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    // SCOPES -----------------------------------------------

    public function scopeWhereNombreCompleto($query, $value)
    {
        return $query->whereRaw("CONCAT_WS(' ',perNombre,perApellido1,perApellido2) LIKE ?", "%{$value}%");
    }

    public function scopeWhereApellidos($query, $value)
    {
        return $query->whereRaw("CONCAT_WS(' ',perApellido1,perApellido2) LIKE ?", "%{$value}%");
    }


    // AUXILIARES --------------------------------------------

    public function esHombre()
    {
        return $this->perSexo == 'M';
    }

    public function esMujer()
    {
        return $this->perSexo == 'F';
    }

    public function edad()
    {   $fecha = Carbon::parse($this->perFechaNac);
        return $fecha->age;
    }

    public function nombreCompleto($inverted = false)
    {
        return MetodosPersonas::nombreCompleto($this, $inverted);
    }



}