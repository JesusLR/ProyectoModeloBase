<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class CalendarioExamen extends Model
{
    //

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'calendarioexamen';


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
        'periodo_id',
        'calexInicioParcial1',
        'calexFinParcial1',
        'calexInicioParcial2',
        'calexFinParcial2',
        'calexInicioParcial3',
        'calexFinParcial3',
        'calexInicioOrdinario',
        'calexFinOrdinario',
        'calexInicioExtraordinario',
        'calexFinExtraordinario',
        'calexInicioExtraordinario2',
        'calexFinExtraordinario2',
        'usuario_at'
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
            
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);

            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);

            $table->usuario_at = Auth::user()->id;
        });
    }
   }


   public function periodo() {
   	return $this->belongsTo(Periodo::class);
   }







}
