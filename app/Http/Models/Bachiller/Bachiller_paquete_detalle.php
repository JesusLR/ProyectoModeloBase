<?php

namespace App\Http\Models\Bachiller;

use App\Http\Models\Bachiller\Bachiller_grupos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Bachiller_paquete_detalle extends Model
{

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bachiller_paquete_detalle';

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
        'bachiller_paquete_id',
        'bachiller_grupo_id',
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
        });
    }
   }
   
    public function bachiller_paquete()
    {
        return $this->belongsTo(Bachiller_paquetes::class);
    }

    public function bachiller_grupo_yucatan()
    {
        return $this->belongsTo(Bachiller_grupos::class, "bachiller_grupo_id");
    }

}