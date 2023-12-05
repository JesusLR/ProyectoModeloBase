<?php

namespace App\Models\Tutorias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Tutorias_permisos extends Model
{
    use SoftDeletes;

    protected $table = 'tutorias_permisos';

    protected $primaryKey = "";


    protected $fillable = []; 

   
    // protected $dates = [
    //     'deleted_at',
    // ];


    // protected static function boot()
    // {
    //     parent::boot();

    //     if(Auth::check()){
    //         static::saving(function($table) {
    //             $table->usuario_at = Auth::user()->id;
    //         });

    //         static::updating(function($table) {
    //             $table->usuario_at = Auth::user()->id;
    //         });

    //         static::deleting(function($table) {
    //             $table->usuario_at = Auth::user()->id;
    //         });
    //     }
    // }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
