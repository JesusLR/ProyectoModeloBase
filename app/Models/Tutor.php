<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class Tutor extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tutores';

    protected $guarded = ['id'];

   	protected $fillable = [
   		'tutNombre',
   		'tutCalle',
   		'tutColonia',
   		'tutCodigoPostal',
   		'tutPoblacion',
   		'tutEstado',
   		'tutTelefono',
   		'tutCorreo',
   	];

   	protected $dates = [
        'deleted_at',
    ];

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
            
            foreach ($table->alumnos()->get() as $alumno) {
                $alumno->delete();
            }

        });
    }

   }//boot.

    public function alumnos(){
    	return $this->hasMany(TutorAlumno::class);
    }







}
