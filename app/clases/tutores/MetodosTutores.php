<?php
namespace App\clases\tutores;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Models\Tutor;
use App\Models\Alumno;
use App\Models\TutorAlumno;

class MetodosTutores
{

    /*
    * Vincula cada uno de los alumnos al tutor.
    *
    * @param Model Alumno.
    * @param Model Tutor.
    */
    public static function vincularAlumnos($alumnos = null,$tutor) {

        if($alumnos) {
            $tutor->alumnos()->whereNotIn('alumno_id', $alumnos->pluck('id'))->delete();

            $alumnos->each(function ($item, $key) use ($tutor) {
                $tutorAlumno = $item->tutores()->where('tutor_id', $tutor->id)->first();
                if(!$tutorAlumno){
                    $tutorAlumno = TutorAlumno::create([
                        'alumno_id' => $item->id,
                        'tutor_id' => $tutor->id
                    ]);
                }
            });
        }
    }//vincularAlumnos.



}