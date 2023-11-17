<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ClaveProfesor extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clavesprofesores';


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
        'ubicacion_id',
        'empleado_id',
        'cpClaveSegey'
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

   public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }



    // SCOPES --------------------------------------------

    public function scopeDeEmpleado($query, $empleado_id)
    {
        return $query->where('empleado_id', $empleado_id);
    }

    public function scopeDeUbicacion($query, $ubicacion_id)
    {
        return $query->where('ubicacion_id', $ubicacion_id);
    }

}