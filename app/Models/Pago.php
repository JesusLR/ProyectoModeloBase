<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Pago extends Model
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pagos';


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
        'pagClaveAlu',
        'pagAnioPer',
        'pagConcPago',
        'pagFechaPago',
        'pagImpPago',
        'pagRefPago',
        'pagDigVer',
        'pagEstado',
        'pagObservacion',
        'pagFormaAplico',
        'pagComentario'
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

   public function concepto() {
    return $this->belongsTo(ConceptoPago::class, 'pagConcPago', 'conpClave');
   }

   public function alumno() {
    return $this->belongsTo(Alumno::class, 'pagClaveAlu', 'aluClave');
   }

   public function usuario() {
    return $this->belongsTo('App\Models\User', 'usuario_at');
   }


   // SCOPE -------------------------------------------------

   public function scopeDeEducacionContinua($query)
   {
      return $query->whereIn('pagConcPago', ['90', '91', '92', '93', '94', '95',]);
   }

   public function scopeDeAlumno($query, $clave)
   {
      return $query->where('pagClaveAlu', $clave);
   }

   public function scopeInscripciones_Colegiaturas($query)
   {
      return $query->whereIn('pagConcPago', [
        '99', '01', '02', '03', '04', '05', '00', 
        '06', '07', '08', '09', '10', '11', '12'
      ]);
   }

   public function scopeInscripciones($query)
   {
        return $query->whereIn('pagConcPago', ['99', '00']);
   }

   public function scopeColegiaturas($query)
   {
        return $query->whereIn('pagConcPago', [
          '01', '02', '03', '04', '05', '06',
          '07', '08', '09', '10', '11', '12',
        ]);
   }

   public function scopeUltimoPagoAutomatico($query)
   {
        return $query->where('pagFormaAplico', 'A')->latest('pagFechaPago')->first();
   }

}