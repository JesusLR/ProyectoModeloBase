<?php

namespace App\Http\Models\Gimnasio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Models\Gimnasio\Gimnasio_tipos_usuario;
use App\Http\Models\Alumno;
use Auth;

class Gimnasio_usuarios extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gimnasio_usuarios';


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
        'id',
        'alumno_id',
        'gimApellidoPaterno',
        'gimApellidoMaterno',
        'gimNombre',
        'gimTipo'
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

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Gimnasio_tipos_usuario::class, 'gimTipo', 'tugClave');
    }

}
