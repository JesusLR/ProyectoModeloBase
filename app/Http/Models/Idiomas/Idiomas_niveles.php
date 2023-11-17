<?php

namespace App\Http\Models\Idiomas;

use App\Http\Models\Cgt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Idiomas_niveles extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'idiomas_niveles';


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
        'plan_id',
        'nivGrado',
        'nivDescripcion',
        'nivPorcentajeReporte1',
        'nivPorcentajeReporte2',
        'nivPorcentajeMidterm',
        'nivPorcentajeProyecto1',
        'nivPorcentajeReporte3',
        'nivPorcentajeReporte4',
        'nivPorcentajeFinal',
        'nivPorcentajeProyecto2',
        
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
