<?php

namespace App\Http\Models\Primaria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Primaria_horarios_categorias extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'primaria_horarios_categorias';


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
        'categoria'
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
        if (Auth::check()) {
            static::saving(function ($table) {
                $table->usuario_at = Auth::user()->id;
            });

            static::updating(function ($table) {
                $table->usuario_at = Auth::user()->id;
            });

            static::deleting(function ($table) {
                $table->usuario_at = Auth::user()->id;
            });
        }
    }


  
}
