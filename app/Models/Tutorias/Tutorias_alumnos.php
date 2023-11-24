<?php

namespace App\Models\Tutorias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Tutorias_alumnos extends Model
{
    use SoftDeletes;

    protected $table = 'tutorias_alumnos';

    protected $primaryKey = "AlumnoID";


    protected $fillable = [
        'AlumnoIDExterno',
        'AlumnoIDSCEM',
        'CursoID',
        'Nombre',
        'ApellidoPaterno',
        'ApellidoMaterno',
        'Correo',
        'Matricula',
        'CarreraID',
        'CarreraIDSCEM',
        'ClaveCarrera',
        'Carrera',
        'Parcial',
        'Foto',
        'EscuelaID',
        'EscuelaIDSCEM',
        'ClaveEscuela',
        'Escuela',
        'UniversidadID',
        'UniversidadIDSCEM',
        'ClaveUniversidad',
        'Universidad',
        'Estatus',
        'Eliminado',
        'Semestre'
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

}
