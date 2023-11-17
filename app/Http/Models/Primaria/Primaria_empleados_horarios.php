<?php

namespace App\Http\Models\Primaria;

use App\Http\Models\Periodo;
use App\Http\Models\Primaria\Primaria_empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Primaria_empleados_horarios extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'primaria_empleados_horarios';


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
        'periodo_id',
        'primaria_empleado_id',
        'primaria_horario_categoria_id',
        'hDia',
        'hHoraInicio',
        'gMinInicio',
        'hFinal',
        'gMinFinal'
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

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function primaria_empleado()
    {
        return $this->belongsTo(Primaria_empleado::class, "primaria_empleado_id");
    }

    public function primaria_horario_categoria()
    {
        return $this->belongsTo(Primaria_horarios_categorias::class, "primaria_horario_categoria_id");
    }
  
}
