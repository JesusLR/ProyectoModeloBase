<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class ConceptoPago extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conceptospago';


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
        'conpClave',
        'conpNombre',
        'conpAbreviatura',
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
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
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


   // SCOPES ---------------------------------------------

   public function scopeInscripciones_Colegiaturas($query)
   {
    
    return $query->whereIn('conpClave', [
        '99', '01', '02', '03', '04', '05', '00', 
        '06', '07', '08', '09', '10', '11', '12'
      ]);
   }



}