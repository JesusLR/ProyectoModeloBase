<?php
namespace App\clases\alumno_expediente;

use App\Http\Models\Bachiller\Bachiller_alumnos_historia_clinica;
use App\Http\Models\Preescolar\Preescolar_alumnos_historia_clinica;
use App\Http\Models\Primaria\Primaria_expediente_entrevista_inicial;
use App\Http\Models\Secundaria\Secundaria_alumnos_historia_clinica;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class ExpedienteAlumno
{

 
    public static function buscaPersonasAutirizadas ($nivel_curso, $alumno_id) {
        
        if($nivel_curso == "MAT" || $nivel_curso == "PRE"){
            // traemos los datos de las personas autorizadas para cualquier tramite
            $expediente = Preescolar_alumnos_historia_clinica::select('preescolar_alumnos_historia_clinica_familiares.famAutorizado1','preescolar_alumnos_historia_clinica_familiares.famAutorizado2')
            ->join('preescolar_alumnos_historia_clinica_familiares', 'preescolar_alumnos_historia_clinica.id', '=', 'preescolar_alumnos_historia_clinica_familiares.historia_id')
            ->where('preescolar_alumnos_historia_clinica.alumno_id', $alumno_id)
            ->first();
        }
        
        if($nivel_curso == "PRI"){
            // traemos los datos de las personas autorizadas para cualquier tramite
            $expediente = Primaria_expediente_entrevista_inicial::select('perAutorizada1', 'perAutorizada2')
            ->where('alumno_id', $alumno_id)
            ->first();
        }

        if($nivel_curso == "SEC"){
            // traemos los datos de las personas autorizadas para cualquier tramite
            $expediente = Secundaria_alumnos_historia_clinica::select('secundaria_alumnos_historia_clinica_familiares.famAutorizado1','secundaria_alumnos_historia_clinica_familiares.famAutorizado2')
            ->join('secundaria_alumnos_historia_clinica_familiares', 'secundaria_alumnos_historia_clinica.id', '=', 'secundaria_alumnos_historia_clinica_familiares.historia_id')
            ->where('secundaria_alumnos_historia_clinica.alumno_id', $alumno_id)
            ->first();
        }

        if($nivel_curso == "BAC"){
            // traemos los datos de las personas autorizadas para cualquier tramite
            $expediente = Bachiller_alumnos_historia_clinica::select('bachiller_alumnos_historia_clinica_familiares.famAutorizado1','bachiller_alumnos_historia_clinica_familiares.famAutorizado2')
            ->join('bachiller_alumnos_historia_clinica_familiares', 'bachiller_alumnos_historia_clinica.id', '=', 'bachiller_alumnos_historia_clinica_familiares.historia_id')
            ->where('bachiller_alumnos_historia_clinica.alumno_id', $alumno_id)
            ->first();
        }
         // Validamos que la consulta no este vacia 
        if($expediente != ""){

            if($nivel_curso == "MAT" || $nivel_curso == "PRE"){
                $personaAutorizada1 = $expediente->famAutorizado1;
                $personaAutorizada2 = $expediente->famAutorizado2;
            }

            if($nivel_curso == "PRI"){
                $personaAutorizada1 = $expediente->perAutorizada1;
                $personaAutorizada2 = $expediente->perAutorizada2;
            }

            if($nivel_curso == "SEC"){
                $personaAutorizada1 = $expediente->famAutorizado1;
                $personaAutorizada2 = $expediente->famAutorizado2;
            }

            if($nivel_curso == "BAC"){
                $personaAutorizada1 = $expediente->famAutorizado1;
                $personaAutorizada2 = $expediente->famAutorizado2;
            }
            
            
        }else{
            $personaAutorizada1 = "";
            $personaAutorizada2 = "";
        }

        $collect = collect([$personaAutorizada1, $personaAutorizada2]);

        return $collect;
    }

}
