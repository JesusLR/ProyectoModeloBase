<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;


class Escolaridad extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escolaridad';


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
        'empleado_id',
        'profesion_id',
        'abreviaturaTitulo_id',
        'escoGraduado',
        'escoTipoDocumento',
        'escoFolio',
        'escoFechaDocumento',
        'escoObservaciones',
        'escoUltimoGrado',
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
        return $this->belongsTo(Empleado::class);
    }

    public function profesion()
    {
        return $this->belongsTo(Profesion::class);
    }

    public function abreviatura()
    {
        return $this->belongsTo(Abreviatura::class,'abreviaturaTitulo_id');
    }

}