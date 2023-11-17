<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ClavePagoSufijo extends Model
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clavepagosufijos';


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
      'cpsIdentificador',
      'cpsSufijo'
    ];


   /**
   * Override parent boot and Call deleting event
   *
   * @return void
   */
   protected static function boot()
   {
     parent::boot();

    //  if (Auth::check()) {
    //     static::saving(function($table) {
    //         $table->usuario_at = Auth::user()->id;
    //     });

    //     static::updating(function($table) {
    //         $table->usuario_at = Auth::user()->id;
    //     });

    //     static::deleting(function($table) {
    //         $table->usuario_at = Auth::user()->id;
    //         foreach ($table->cursos()->get() as $curso) {
    //             $curso->delete();
    //         }
    //     });
    // } 
   }

}