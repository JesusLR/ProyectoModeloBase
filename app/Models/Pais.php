<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Pais extends Model
{

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paises';

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
        'paisNombre',
        'paisAbrevia',
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
             $table->usuario_at = Auth::user()->id;
            foreach ($table->estados()->get() as $estado) {
                $estado->delete();
            }
         });
     }
   }

    public function estados()
    {
        return $this->hasMany(Estado::class);
    }
}