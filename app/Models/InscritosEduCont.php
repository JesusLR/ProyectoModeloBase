<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;


class InscritosEduCont extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inscritoseducont';


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
        'alumno_id',
        'educacioncontinua_id',
        'iecGrupo',
        'iecFechaRegistro',
        'iecFechaBaja',
        'iecEstado',
        'iecImporteInscripcion',
        'iecFechaProcesoRegistro',
        'iecBajaUsuario_id',
        'iecFechaProcesoBaja',
        'iecNumeroInscritos',
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
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);
            $table->usuario_at = Auth::user()->id;
        });

        static::updating(function($table) {
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);
            $table->usuario_at = Auth::user()->id;
        });

        static::deleting(function($table) {
            GenerarLogs::crearLogs((Object) [
                "nombreTabla" => $table->getTable(),
                "registroId"  => $table->id,
            ]);
        });
    }
   }


    public function alumno()
    {
      return $this->belongsTo(Alumno::class);
    }

    public function educacioncontinua()
    {
      return $this->belongsTo(EducacionContinua::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    //SCOPES ------------------------------------------

    public function scopeRegulares($query)
    {
        return $query->where('iecEstado', 'R');
    }

    public function scopePreinscritos($query)
    {
        return $query->where('iecEstado', 'P');
    }
}