<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;



class Convenio extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'convenios';


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
        'convNumero',
        'convNumeroCuenta',
        'convDescripcion',
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

    public function departamento()
    {
      return $this->belongsTo(Departamento::class);
    }

    // SCOPES ------------------------------------------ 

    public function scopeDelDepartamento($query, $departamento_id)
    {
        return $query->where('departamento_id', $departamento_id);
    }
}