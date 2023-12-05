<?php

namespace App\Models\Idiomas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

// comentario test
class Idiomas_calificaciones_materia extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'idiomas_calificaciones_materia';


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
        'idiomas_resumen_calificaciones_id',
        'idiomas_materia_id',
        'cmReporte1',
        'cmReporte2',
        'cmMidTerm',
        'cmProject1',
        'cmReporte3',
        'cmReporte4',
        'cmFinalExam',
        'cmProject2'
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

    public function inscrito()
    {
        return $this->belongsTo(Inscrito::class);
    }

}