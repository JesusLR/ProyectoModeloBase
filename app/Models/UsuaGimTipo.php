<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class UsuaGimTipo extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuagimtipos';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tugClave',
        'tugDescripcion',
        'tugImporte',
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
