<?php

namespace App\Http\Controllers;

use App\clases\bachiller\Actualiza_inscritos_gpo;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use URL;
use Validator;
use Debugbar;

use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function index(){
        return view('auth.login');
    }

     /**
     * Esta funciona es creada para validar el usuario y contraseña.
     *
     * @param \Illuminate\Http\Request $request
     *
     */
    public function auth(Request $request)
    {


        if(EN_MANTENIMIENTO)
        {
            alert()
                ->error('Escuela Modelo', 'Estamos en labores de mantenimiento, regresamos el
                Miércoles 29 de Diciembre de 2021, 9:00 a.m.')
                ->autoClose(15000);
            return redirect()->route('login')->withInput();
        }




        $this->validate($request,
            [
                'username' => 'required|string',
                'password' => 'required|string',
            ]
        );
        $credentials = $request->only('username','password');
        if (Auth::attempt($credentials))
        {
            $ruta = '/home';
            /*
            if (Auth::user()->empleado->escuela->departamento->depClave == "SUP" ||
                Auth::user()->empleado->escuela->departamento->depClave == "POS" ||
                Auth::user()->empleado->escuela->departamento->depClave == "DIP" ||
                Auth::user()->empleado->escuela->departamento->depClave == "AEX" ||
                Auth::user()->empleado->escuela->departamento->depClave == "IDI")
            */
            if (   (Auth::user()->superior == 1)  || (Auth::user()->posgrado == 1)
                || (Auth::user()->educontinua == 1) )
            {
                $ruta = '/home';
            }



            if (Auth::user()->bachiller == 1)
            {
                $ruta = '/bachiller_curso';

                //$para_actualizar_el_total = Actualiza_inscritos_gpo::total_inscritos();
            }

            //if (Auth::user()->empleado->escuela->departamento->depClave == "SEC")
            if (Auth::user()->secundaria == 1)
            {
                $ruta = '/secundaria_curso';
            }

            //if (Auth::user()->empleado->escuela->departamento->depClave == "PRI")
            if (Auth::user()->primaria == 1)
            {
                //PISICOLOGAS
                if ((Auth::user()->username == "MONICAEGLE") || (Auth::user()->username == "IVONNEVERA")
            || (Auth::user()->username == "ANGELINAMICHELL"))
                {
                    $ruta = '/primaria_entrevista_inicial';
                }
                else
                {
                    $ruta = '/primaria_curso';
                }

            }


            //if (Auth::user()->empleado->escuela->departamento->depClave == "PRE")
            if ( (Auth::user()->maternal == 1 ) || (Auth::user()->preescolar == 1) )
            {
                $ruta = '/preescolar_curso';
            }

            // idiomas_gimnasio_natacion
            if ( Auth::user()->idiomas == 1  )
            {
                $ruta = '/idiomas_curso';
            }
            if ( Auth::user()->gimnasio == 1  )
            {
                $ruta = '/gimnasio_usuario';
            }
            if ( Auth::user()->natacion == 1  )
            {
                $ruta = '/natacion_ficha_pago';
            }



            //return redirect()->intended('home');
            return redirect($ruta);
        }else{
            alert()
            ->error('Ups...', 'Usuario y/o contraseña invalidos')
            ->showConfirmButton()
            ->autoClose(5000);

            return redirect()->route('login')->withInput();
        }

    }

    /**
     * Esta funcion es para salir y eliminar la sesion
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

}
