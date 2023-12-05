<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Primaria\Primaria_empleado;
use Auth;

class Escuela extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuelas';


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
        'departamento_id',
        'empleado_id',
        'academico_empleado_id',
        'administrativo_empleado_id',
        'escClave',
        'escNombre',
        'escNombreCorto',
        'escPorcExaPar',
        'escPorcExaOrd',
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
            foreach ($table->programas()->get() as $programa) {
                $programa->delete();
            }
        });
    }
   }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function programas()
    {
        return $this->hasMany(Programa::class);
    }



}