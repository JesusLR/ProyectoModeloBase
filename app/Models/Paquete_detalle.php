<?php

namespace App\Models;

use App\Models\Bachiller\Bachiller_cch_grupos;
use App\Models\Bachiller\Bachiller_grupos;
use App\Models\Secundaria\Secundaria_grupos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Paquete_detalle extends Model
{

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paquete_detalle';

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
        'paquete_id',
        'grupo_id',
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
   
    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function secundaria_grupo()
    {
        return $this->belongsTo(Secundaria_grupos::class, "grupo_id");
    }

    public function bachiller_grupo_merida()
    {
        return $this->belongsTo(Bachiller_grupos::class, "grupo_id");
    }

    public function bachiller_grupo_chetumal()
    {
        return $this->belongsTo(Bachiller_cch_grupos::class, "grupo_id");
    }
}