<?php

namespace App\Http\Models\Bachiller;

use App\Http\Models\Bachiller\Bachiller_materias;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Bachiller_materias_prereq extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bachiller_materias_prereq';


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
        'materia_id',
        'materia_prerequisito_id'
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

    public function bachiller_materia()
    {
        return $this->belongsTo(Bachiller_materias::class);
    }

    public function bachiller_prerequisito()
    {
        return $this->belongsTo(Bachiller_materias::class,'materia_prerequisito_id');
    }

}