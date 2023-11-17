<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use App\Http\Helpers\GenerarLogs;

class TutorAlumno extends Model
{
    //

    use SoftDeletes;

    protected $table = 'tutoresalumnos';

    protected $guarded = ['id'];

   	protected $fillable = [
   		'alumno_id',
   		'tutor_id',
   		'usuario_at'
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

        });
    }

   }//boot.

   public function alumno(){
   		return $this->belongsTo(Alumno::class);
   }

   public function tutor(){
   		return $this->belongsTo(Tutor::class);
   }



}
