<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class Conceptospago_aex extends Model
{
    // use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conceptospago_aex';


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
        'programa_id',
        'progClave',
        'conc_pago1',
        'conc_pago2',
        'conc_pago3',
        'conc_pago4',
        'conc_pago5',
        'conc_pago6',
        'conc_pago7',
        'conc_pago8',
        'conc_pago9',
        'conc_pago10'
    ];

    // protected $dates = [
    //     'deleted_at',
    // ];

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
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
}
