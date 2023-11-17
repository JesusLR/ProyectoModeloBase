<?php

namespace App\Http\Models\Tutorias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Tutorias_preguntas extends Model
{
    use SoftDeletes;

    protected $table = 'tutorias_preguntas';

    protected $primaryKey = "PreguntaID";


    protected $fillable = [
        'Nombre',
        'CategoriaPreguntaID',
        'TipoRespuesta',
        'FormularioID',
        'Porcentaje',
        'AtributoWS',
        'Estatus',
        'Eliminado',
        'totalRespuestas',
        'orden_visual_pregunta'
    ]; 

   
    protected $dates = [
        'deleted_at',
    ];


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

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
