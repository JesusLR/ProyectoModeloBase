<?php

namespace App\Http\Models\Tutorias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Tutorias_pregunta_respuestas extends Model
{
    use SoftDeletes;

    protected $table = 'tutorias_pregunta_respuestas';

    protected $primaryKey = "PreguntaRespuestaID";

    protected $fillable = [
        'Tipo',
        'RespuestaID',
        'Respuesta',
        'PreguntaID',
        'AlumnoID',
        'Porcentaje',
        'Disponible',
        'FormularioID',
        'Parcial',
        'CarreraID',
        'ClaveCarrera',
        'Carrera',
        'EscuelaID',
        'ClaveEscuela',
        'Escuela',
        'UniversidadID',
        'ClaveUniversidad',
        'Universidad',
        'Semaforizacion',
        'CategoriaID',
        'NombreCategoria',
        'DescripcionCategoria'

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


    public function tutorias_alumno()
    {
        return $this->belongsTo(Tutorias_alumnos::class);
    }
  
}
