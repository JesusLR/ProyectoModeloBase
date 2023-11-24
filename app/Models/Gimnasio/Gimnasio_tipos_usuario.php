<?php

namespace App\Models\Gimnasio;

use App\Models\Cgt;
use App\Models\ClaveProfesor;
use App\Models\Escolaridad;
use App\Models\Escuela;
use App\Models\Extraordinario;
use App\Models\HorarioAdmivo;
use App\Models\Municipio;
use App\Models\Programa;
use App\Models\User_docente;
use App\Models\Idiomas\Idiomas_grupos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Gimnasio_tipos_usuario extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gimnasio_tipos_usuario';


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
        'tugClave',
        'tugDescripcion',
        'tugImporte',
        'tugVigente'
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
}
