<?php

namespace App\Http\Models\Secundaria;

use App\Http\Models\Plan;
use App\Http\Models\Secundaria\Secundaria_grupos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Secundaria_materias_acd extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'secundaria_materias_acd';


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
        'secundaria_materia_id',
        'plan_id',
        'periodo_id',
        'gpoGrado',
        'gpoMatComplementaria'
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
            // foreach ($table->secundaria_grupos()->get() as $grupo) {
            // $grupo->delete();
            // }
        });
    }
   }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // public function secundaria_grupos()
    // {
    //     return $this->hasMany(Secundaria_grupos::class, 'empleado_id_docente');
    // }


}
