<?php

namespace App\Http\Models\Idiomas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Idiomas_cuotas extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'idiomas_cuotas';


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
        'programa_id',
        'cuoAnioPago',
        'cuoDescuentoMensualidad',
        'cuoDescuentoInscripcion',
        'cuoImporteMensualidad',
        'cuoImporteInscripcion1',
        'cuoFechaInscripcion1',
        'cuoImporteInscripcion2',
        'cuoFechaInscripcion2',
        'cuoImporteInscripcion3',
        'cuoFechaInscripicion3',
        'cuoImporteVencimiento',
        'cuoNumeroCuenta',
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
