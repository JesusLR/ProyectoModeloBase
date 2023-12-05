<?php

namespace App\Models\Tutorias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Tutorias_usuario extends Model
{
    use SoftDeletes;

    protected $table = 'tutorias_usuarios';

    protected $fillable = [
        'Nombre',
        'ApellidoPaterno',
        'ApellidoMaterno',
        'NombreUsuario',
        'Correo',
        'Contrasena',
        'ContrasenaDes',
        'Estatus',
        'TokenApp',
        'Foto',
        'RolID',
        'Eliminado',
        'MunicipioID',
        'Notificacion',
        'Intentos'

    ]; 

    protected $primaryKey = "UsuarioID";


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

    public function tutorias_rol()
    {
        return $this->belongsTo(Tutorias_roles::class);
    }
}
