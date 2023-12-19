<?php

namespace App\Models\Bachiller;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Bachiller_justificacion extends Model
{
    use SoftDeletes;

    protected $table = 'bachiller_justificaciones';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    protected $fillable = [
        'curso_id',
        'jusRazonFalta',
        'jusFechaInicio',
        'jusFechaFin' ,
        'JustNumeroJustificacion',
        'jusFechaSolicitud',
        'jusEstado'
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

    public function curso()
    {
        return $this->belongsTo(Curso::class, "curso_id");
    }
}
