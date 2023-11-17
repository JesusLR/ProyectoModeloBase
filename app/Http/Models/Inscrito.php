<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use App\Http\Helpers\GenerarLogs;


class Inscrito extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inscritos';


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
        'curso_id',
        'grupo_id'
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
            $table->calificacion->delete();
        });
    }
   }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function calificacion()
    {
        return $this->hasOne(Calificacion::class);
    }

    public function historico(){
        return $this->belongsTo(Historico::class);
    }


}