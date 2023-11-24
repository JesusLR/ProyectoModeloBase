<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;
use App\Models\Bachiller\Bachiller_historico;
use App\Models\Bachiller\Bachiller_resumenacademico;
use App\Models\Bachiller\SecundariaProcedencia;

class Alumno extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumnos';


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
        'persona_id',
        'aluClave',
        'aluEstado',
        'aluFechaIngr',
        'aluNivelIngr',
        'aluGradoIngr',
        'aluMatricula',
        'preparatoria_id',
        'candidato_id',
        'sec_tipo_escuela',
        'sec_nombre_ex_escuela',
        'secundaria_id',
        'usuario_at'
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected $casts = [
        'aluClave' => 'integer',
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

            $table->usuario_at = Auth::user()->id;
            foreach ($table->cursos()->get() as $curso) {
                $curso->delete();
            }
            foreach ($table->referencias()->get() as $referencia) {
                $referencia->delete();
            }

            foreach ($table->matriculas_anteriores()->get() as $matricula_anterior) {
                $matricula_anterior->delete();
            }
            foreach ($table->tutores()->get() as $tutor) {
                $tutor->delete();
            }
        });
    }
   }

   public function candidato()
   {
       return $this->belongsTo(Candidato::class);
   }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function preparatoria()
    {
        return $this->belongsTo(PreparatoriaProcedencia::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function referencias()
    {
        return $this->hasMany(Referencia::class);
    }

    public function usuarios_gim()
    {
        return $this->hasMany(UsuaGim::class);
    }

    public function matriculas_anteriores()
    {
        return $this->hasMany(MatriculaAnterior::class);
    }

    public function historico()
    {
        return $this->hasMany(Historico::class);
    }

    public function bachiller_historico()
    {
        return $this->hasMany(Bachiller_historico::class);
    }

    public function egresado(){
        return $this->hasMany(Egresado::class);
    }
    
    public function tutores(){
        return $this->hasMany(TutorAlumno::class);
    }

    public function resumenesAcademicos() {
        return $this->hasMany(ResumenAcademico::class);
    }

    public function bachillerresumenesAcademicos() {
        return $this->hasMany(Bachiller_resumenacademico::class);
    }

    // public function secundaria() {
    //     return $this->hasMany(SecundariaProcedencia::class, "secundaria_id");
    // }

    public function secundariaProcedencia()
    {
        return $this->belongsTo(SecundariaProcedencia::class, 'secundaria_id');
    }



}