<?php

namespace App\Http\Models\Idiomas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;


class Idiomas_resumen_calificacion extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'idiomas_resumen_calificaciones';


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
        'idiomas_curso_id',
        'rcReporte1',
        'rcReporte1Ponderado',
        'rcReporte2',
        'rcReporte2Ponderado',
        'rcMidTerm',
        'rcMidTermPonderado',
        'rcProject1',
        'rcProject1Ponderado',
        'rcReporte3',
        'rcReporte3Ponderado',
        'rcReporte4',
        'rcReporte4Ponderado',
        'rcFinalExam',
        'rcFinalExamPonderado',
        'rcProject2',
        'rcProject2Ponderado',
        'rcFinalScore'
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