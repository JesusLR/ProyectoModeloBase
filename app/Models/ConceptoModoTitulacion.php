<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ConceptoModoTitulacion extends Model
{
	use SoftDeletes;
    //
    protected $table = 'conceptosmodotitulacion';

    protected $guarded = ['id'];

    protected $fillable = [
    	'conmClave',
    	'conmNombre',
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


}
