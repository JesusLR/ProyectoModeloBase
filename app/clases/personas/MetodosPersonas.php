<?php
namespace App\clases\personas;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Alumno;
use App\Http\Models\Bachiller\Bachiller_empleados;
use App\Http\Models\Empleado;
use App\Http\Models\Primaria\Primaria_empleado;
use App\Http\Models\Secundaria\Secundaria_empleados;

class MetodosPersonas
{

    public static function existeAlumno($request) {
        $alumno = Alumno::with('persona')
        ->whereHas('persona', static function ($query) use ($request) {
            if($request->perNombre) {
                $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
            }
            if($request->perApellido1) {
                $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
            }
            if($request->perApellido2) {
                $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
            }
            if($request->perCurp) {
                $query->where('perCurp', $request->perCurp);
            }
        })->first();

        return $alumno;
    }//existeAlumno.

    public static function existeAlumnoSecundaria($request) {
        $alumno = Alumno::with('persona')
        ->whereHas('persona', static function ($query) use ($request) {
            if($request->empNombre) {
                $query->where('perNombre', 'like', '%'.$request->empNombre.'%');
            }
            if($request->empApellido1) {
                $query->where('perApellido1', 'like', '%'.$request->empApellido1.'%');
            }
            if($request->empApellido2) {
                $query->where('perApellido2', 'like', '%'.$request->empApellido2.'%');
            }
            if($request->empCURP) {
                $query->where('perCurp', $request->empCURP);
            }
        })->first();

        return $alumno;
    }//existeAlumno

    public static function existeEmpleado($request) {
        $empleado = Empleado::with('persona')
        ->whereHas('persona', static function ($query) use ($request) {
            if($request->perNombre) {
                $query->where('perNombre', 'like', '%'.$request->perNombre.'%');
            }
            if($request->perApellido1) {
                $query->where('perApellido1', 'like', '%'.$request->perApellido1.'%');
            }
            if($request->perApellido2) {
                $query->where('perApellido2', 'like', '%'.$request->perApellido2.'%');
            }
            if($request->perCurp) {
                $query->where('perCurp', $request->perCurp);
            }
        })->first();

        return $empleado;
    }//existeEmpleado.


    public static function existePrimariaEmpleado($request) {
        $empleado = Primaria_empleado::where('empNombre', 'like', '%'.$request->perNombre.'%')
        ->where('empApellido1', 'like', '%'.$request->perApellido1.'%')
        ->where('empApellido2', 'like', '%'.$request->perApellido2.'%')
        ->where('empCURP', $request->perCurp)
        ->first();

        return $empleado;
    }//existeEmpleado.

    public static function existeSecundariaEmpleado($request) {
        $empleado = Secundaria_empleados::where('empNombre', 'like', '%'.$request->empNombre.'%')
        ->where('empApellido1', 'like', '%'.$request->empApellido1.'%')
        ->where('empApellido2', 'like', '%'.$request->empApellido2.'%')
        ->where('empCURP', $request->empCURP)
        ->first();

        return $empleado;
    }//existeEmpleado.


    public static function existeBachillerEmpleado($request) {
        $empleado = Bachiller_empleados::where('empNombre', 'like', '%'.$request->perNombre.'%')
        ->where('empApellido1', 'like', '%'.$request->perApellido1.'%')
        ->where('empApellido2', 'like', '%'.$request->perApellido2.'%')
        ->where('empCURP', $request->perCurp)
        ->first();

        return $empleado;
    }//existeEmpleado.
    

    public static function nombreCompleto($persona, $invertido = false) {
        $nombre = $persona->perNombre;
        $apellidos = $persona->perApellido1.' '.$persona->perApellido2;
        return $invertido ? $apellidos.' '.$nombre : $nombre.' '.$apellidos;
    }//nombreCompleto.

    public static function soloApellidos($persona) {
        $nombre = $persona->perNombre;
        $apellidos = $persona->perApellido1.' '.$persona->perApellido2;
        if ($persona->perApellido2 == '') {
            $apellidos = $persona->perApellido1;
        }
        return $apellidos;
    }//nombreCompleto.

    
    public static function PrimariaNombreCompleto($persona, $invertido = false) {
        $nombre = $persona->empNombre;
        $apellidos = $persona->empApellido1.' '.$persona->empApellido2;
        return $invertido ? $apellidos.' '.$nombre : $nombre.' '.$apellidos;
    }//nombreCompleto.

    public static function SecundariaNombreCompleto($persona, $invertido = false) {
        $nombre = $persona->empNombre;
        $apellidos = $persona->empApellido1.' '.$persona->empApellido2;
        return $invertido ? $apellidos.' '.$nombre : $nombre.' '.$apellidos;
    }//nombreCompleto.

    public static function BachillerNombreCompleto($persona, $invertido = false) {
        $nombre = $persona->empNombre;
        $apellidos = $persona->empApellido1.' '.$persona->empApellido2;
        return $invertido ? $apellidos.' '.$nombre : $nombre.' '.$apellidos;
    }//nombreCompleto.




}//MetodosPersonas.