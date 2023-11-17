<?php
namespace App\clases\alumnos;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Alumno;
use App\Http\Models\Bachiller\Bachiller_historico;
use App\Http\Models\Historico;
use App\Http\Models\TutorAlumno;

class MetodosAlumnos
{

    /*
    * Retorna apellidos con y sin tildes (de requerirse)
    * parámetro : Instancia de App\Persona.
    */
    public static function filtrarApellidos ($persona) {
        $conTilde = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'];
        $sinTilde = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];

        $apellido1 = $persona->perApellido1;
        $apellido2 = $persona->perApellido2;

        $nombre1 = str_replace($conTilde, $sinTilde, $apellido1.' '.$apellido2);
        $nombre2 = $apellido1.' '.$apellido2;
        $nombre3 = str_replace($conTilde, $sinTilde, $apellido1).' '.$apellido2;
        $nombre4 = $apellido1.' '.str_replace($conTilde, $sinTilde, $apellido2);

        /* Ejemplo: López Velázquez.
        * -> arr[0] = Lopez Velazquez
        * -> arr[1] = López Velázquez <---- Sin Modificación.
        * -> arr[2] = López Velazquez
        * -> arr[3] = Lopez Velázquez
        */

        $collect = collect([$nombre1, $nombre2, $nombre3, $nombre4]);

        return $collect;
    }//filtrarApellidos.




    /*
    * el parametro debe ser array.
    *
    * Esta función se hizo para trabajar en conjunto con filtrarApellidos().
    */
    public static function posiblesHermanos ($apellidos) {

        $hermanos = Alumno::with('persona')
        ->whereHas('persona', static function ($query) use ($apellidos) {
          $sql = DB::raw("CONCAT(perApellido1,' ',perApellido2)");

            $query->whereIn($sql, $apellidos);

        }); // ->get();

        return $hermanos;
    }//posiblesHermanos.


    /**
    * Vincula cada uno de los alumnos al tutor.
    *
    * @param Model Alumno.
    * @param Model Tutor(collection).
    */
    public static function vincularTutores($tutores = null,$alumno) {

        if($tutores) {
            $alumno->tutores()->whereNotIn('tutor_id', $tutores->pluck('id'))->delete();

            $tutores->each(function ($item, $key) use ($alumno, $tutores) {
                $tutorAlumno = $item->alumnos()->where('alumno_id', $alumno->id)->first();
                if(!$tutorAlumno){
                    $tutorAlumno = TutorAlumno::create([
                        'alumno_id' => $alumno->id,
                        'tutor_id' => $item->id
                    ]);
                }
            });
        }
    }//vincularTutores.



    /**
    * @param int
    */
    public static function esDeudor($aluClave): bool
    {
        $user_id = Auth::id();
        $result =  DB::select("call procValidaDeudorAlumno("
            .$user_id
            .",".$aluClave
            .",'I')");

        return ($result[0]->_return_esdeudor == "SI") ? true : false;
    }

    /**
    * @param int
    */
    public static function esDeudorElegirMeses($aluClave): bool
    {
        $user_id = Auth::id();
        $result =  DB::select("call procValidaDeudorAlumnoElegirMeses("
            .$user_id
            .",".$aluClave
            .",'I')");

        return ($result[0]->_return_esdeudor == "SI") ? true : false;
    }


    private function esDeudorCOVID($idAlumno, $perAnioPago): bool
    {
        $user_id = Auth::id();
        $resultado_OUT_MySQL = "resultado_OUT_MySQL";
        $tipodeResumen = "'I'";

        $para1 = $user_id; $para2 = $perAnioPago; $para3 = $idAlumno;
        $para4 = $tipodeResumen;

        DB::statement('CALL procValidaDeudorCOVID(?, ?, ?, ?, @resultado);',
            array(
                $para1,
                $para2,
                $para3,
                $para4
            )
        );

        $results = DB::select('select @resultado as _para_EsDeudor');

        //dd($results[0]->_para_EsDeudor);

        return ($results[0]->_para_EsDeudor == "SI") ? true : false;
    }


    public static function esDeudorPreescolarCOVID($idAlumno, $perAnioPago): bool
    {
        $user_id = Auth::id();
        $resultado_OUT_MySQL = "resultado_OUT_MySQL";
        $tipodeResumen = "'I'";

        $para1 = $user_id; $para2 = $perAnioPago; $para3 = $idAlumno;
        $para4 = $tipodeResumen;

        DB::statement('CALL procPreescolarValidaDeudorCOVID(?, ?, ?, ?, @resultado);',
            array(
                $para1,
                $para2,
                $para3,
                $para4
            )
        );

        $results = DB::select('select @resultado as _para_EsDeudor');

        //dd($results[0]->_para_EsDeudor);

        return ($results[0]->_para_EsDeudor == "SI") ? true : false;
    }

    public static function esDeudorPrimariaCOVID($idAlumno, $perAnioPago): bool
    {
        $user_id = Auth::id();
        $resultado_OUT_MySQL = "resultado_OUT_MySQL";
        $tipodeResumen = "'I'";

        $para1 = $user_id; $para2 = $perAnioPago; $para3 = $idAlumno;
        $para4 = $tipodeResumen;

        DB::statement('CALL procPrimariaValidaDeudorCOVID(?, ?, ?, ?, @resultado);',
            array(
                $para1,
                $para2,
                $para3,
                $para4
            )
        );

        $results = DB::select('select @resultado as _para_EsDeudor');

        //dd($results[0]->_para_EsDeudor);

        return ($results[0]->_para_EsDeudor == "SI") ? true : false;
    }

    public static function esDeudorSecundariaCOVID($idAlumno, $perAnioPago): bool
    {
        $user_id = Auth::id();
        $resultado_OUT_MySQL = "resultado_OUT_MySQL";
        $tipodeResumen = "'I'";

        $para1 = $user_id; $para2 = $perAnioPago; $para3 = $idAlumno;
        $para4 = $tipodeResumen;

        DB::statement('CALL procSecundariaValidaDeudorCOVID(?, ?, ?, ?, @resultado);',
            array(
                $para1,
                $para2,
                $para3,
                $para4
            )
        );

        $results = DB::select('select @resultado as _para_EsDeudor');

        //dd($results[0]->_para_EsDeudor);

        return ($results[0]->_para_EsDeudor == "SI") ? true : false;
    }

    public static function esDeudorBachillerCOVID($idAlumno, $perAnioPago): bool
    {
        $user_id = Auth::id();
        $resultado_OUT_MySQL = "resultado_OUT_MySQL";
        $tipodeResumen = "'I'";

        $para1 = $user_id; $para2 = $perAnioPago; $para3 = $idAlumno;
        $para4 = $tipodeResumen;

        DB::statement('CALL procBachillerValidaDeudorCOVID(?, ?, ?, ?, @resultado);',
            array(
                $para1,
                $para2,
                $para3,
                $para4
            )
        );

        $results = DB::select('select @resultado as _para_EsDeudor');

        //dd($results[0]->_para_EsDeudor);

        return ($results[0]->_para_EsDeudor == "SI") ? true : false;
    }

    public static function esAlumnoDeudorNivelActual($aluClave, $ubiClave, $depaClave, $cveConcepto, $perAnioPago): bool
    {
        $user_id = Auth::id();
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        // Output: 54esmdr0qf
        $temporary_table_name = "_" . substr(str_shuffle($permitted_chars), 0, 15);

        $result =  DB::select("call procDeudasAlumnoCualquierNivel("
            .$user_id
            .",'".$aluClave
            ."','".$ubiClave
            ."','".$depaClave
            ."','".$temporary_table_name
            ."','I','".$cveConcepto
            ."',".$perAnioPago
            .")");

        $pagos_deudores_array = DB::select('select * from '.$temporary_table_name);
        $pagos_deudores_collection = collect( $pagos_deudores_array );

        DB::statement( 'DROP TABLE IF EXISTS '.$temporary_table_name );

        /*
        if($pagos_deudores_collection->isEmpty()) {
            alert()->warning('Sin coincidencias', 'No hay datos que coincidan con la información proporcionada.')->showConfirmButton();
            return back()->withInput();
        }*/
        return ($pagos_deudores_collection->isEmpty()) ? false : true;
    }

    /**
    * Recibe el aluClave de un alumno y devuelve sus materias reprobadas.
    */
    public static function materias_reprobadas($aluClave)
    {
        $reprobadas = DB::select("call procReprobadasAlumno({$aluClave})");

        return collect($reprobadas);
    }

    public static function bachiller_materias_reprobadas($aluClave)
    {
        $reprobadas = DB::select("call procBachillerReprobadasAlumno({$aluClave})");

        return collect($reprobadas);
    }
    /**
     * Devuelve las materias que el alumno no ha cursado, es decir, que no tiene registros en hisróricos.
     *
     * @param App\Http\Models\Alumno $alumno
     * @param App\Http\Models\Plan $plan
     */
    public static function materiasFaltantes($alumno, $plan): Collection {
        $materias_plan = $plan->materias;
        $materias_cursadas = Historico::where('alumno_id', $alumno->id)
        ->where('plan_id', $plan->id)
        ->oldest('histFechaExamen')
        ->get()
        ->keyBy('materia_id');

        return $materias_plan->whereNotIn('materia_id', $materias_cursadas->keys());
    }

    public static function BachillerMateriasFaltantes($alumno, $plan): Collection {
        $materias_plan = $plan->bachiller_materias;
        $materias_cursadas = Bachiller_historico::where('alumno_id', $alumno->id)
        ->where('plan_id', $plan->id)
        ->oldest('histFechaExamen')
        ->get()
        ->keyBy('bachiller_materia_id');

        return $materias_plan->whereNotIn('bachiller_materia_id', $materias_cursadas->keys());
    }
    /**
     * Utiliza procReprobadasAlumno para obtener los ids de las materias, y devolver la lista de materias reprobadas
     * desde Eloquent, para conservar los atributos y propiedades de App\Http\Models\Materia
     *
     * @param App\Http\Models\Alumno $alumno
     * @param App\Http\Models\Plan $plan
     */
    public static function materiasReprobadasEloquent($alumno, $plan) : Collection {
        $reprobadas = self::materias_reprobadas($alumno->aluClave);

        return $plan->materias()->whereIn('id', $reprobadas->pluck('materia_id'))->get()->keyBy('id');
    }

    public static function BachillerMateriasReprobadasEloquent($alumno, $plan) : Collection {
        $reprobadas = self::bachiller_materias_reprobadas($alumno->aluClave);

        return $plan->bachiller_materias()->whereIn('id', $reprobadas->pluck('bachiller_materia_id'))->get()->keyBy('id');
    }



}
