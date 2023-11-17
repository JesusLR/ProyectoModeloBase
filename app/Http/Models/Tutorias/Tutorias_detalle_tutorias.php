<?php

namespace App\Http\Models\Tutorias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Tutorias_detalle_tutorias extends Model
{
    use SoftDeletes;

    protected $table = 'tutorias_detalle_tutorias';

    protected $primaryKey = "DetalleTutoriaID";


    protected $fillable = [
        'TutoriaID',
        'AlumnoID',
        'CategoriaID',
        'NombreCategoria',
        'DescripcionCategoria',
        'Semaforizacion',
        'Comentario',
        'Conclucion'
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
