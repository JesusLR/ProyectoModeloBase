<?php

namespace App\Http\Models\Bachiller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Models\Periodo;
use Illuminate\Support\Facades\Auth;

class Bachiller_periodos_vacaciones extends Model
{
    use SoftDeletes;
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bachiller_periodos_vacaciones';


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
        'departamento_id',
        'periodo_id',
        'pvTipo',
        'pvInicio',
        'pvFinal',
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


    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

}