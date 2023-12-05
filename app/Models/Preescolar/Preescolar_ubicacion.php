<?php

namespace App\Models\Preescolar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Preescolar_ubicacion extends Model
{
    protected $table = 'ubicacion';


    protected $fillable = [
        'ubiClave',
        'ubiNombre',
        'ubiCalle',
        'ubiCP',
        'municipio_id',
        'usuario_at'     
    ];

    public function municipios()
    {
        return $this->belongsTo('App\municipios', 'ubicacion_id', 'id');
    }

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
