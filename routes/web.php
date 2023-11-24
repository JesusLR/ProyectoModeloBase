<?php

use App\Models\User;
use App\Models\User_docente;
use App\Models\Empleado;
use App\Models\Escuela;
use App\Models\Departamento;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes
Auth::routes();

/*
Route::get('/', function(){
    if (Auth::user()->empleado->escuela->departamento->depClave == "SUP"  ||
        Auth::user()->empleado->escuela->departamento->depClave == "POS" ||
        Auth::user()->empleado->escuela->departamento->depClave == "DIP" )
    {
        Route::get('/','CursoController@index')->name('home');
    } else {
        if (Auth::user()->empleado->escuela->departamento->depClave == "PRE")
        {
            Route::get('/','CursoPreescolarController@index')->name('home');
        }
    }
});

Route::get('/home', function(){
    if (Auth::user()->empleado->escuela->departamento->depClave == "SUP"  ||
        Auth::user()->empleado->escuela->departamento->depClave == "POS" ||
        Auth::user()->empleado->escuela->departamento->depClave == "DIP" )
    {
        Route::get('/home','CursoController@index')->name('home');
    } else {
        if (Auth::user()->empleado->escuela->departamento->depClave == "PRE")
        {
            Route::get('/home','CursoPreescolarController@index')->name('home');
        }
    }
});
*/

// Home Route
Route::get('/','CursoController@index')->name('home');
Route::get('/home','CursoController@index')->name('home');

// Login Route
Route::get('login','LoginController@index')->name('login');
Route::post('auth','LoginController@auth')->name('auth');
Route::get('logout','LoginController@logout')->name('logout');


Route::get('cambiar_contraseña','CuentaController@cambiarPassword')->name('cambiar_contraseña');
Route::post('cambiar_contraseña','CuentaController@passwordUpdate')->name('password.update');

Route::get('procMateriasAdeudadas', 'ProcMateriasAdeudadasController@vista');
Route::get('procMateriasAdeudadas/alumnos', 'ProcMateriasAdeudadasController@alumnos');
Route::get('procMateriasAdeudadas/alumnos/{alumno}', 'ProcMateriasAdeudadasController@alumno');
Route::get('procMateriasAdeudadas/alumnos/{alumno}/list', 'ProcMateriasAdeudadasController@list');

Route::get('fichas_preinscritos_extraordinarios', 'FichaPreinscritoExtraordinarioController@vista');
Route::get('fichas_preinscritos_extraordinarios/list', 'FichaPreinscritoExtraordinarioController@list');
Route::get('fichas_preinscritos_extraordinarios/reimprime/{preinscrito_id}', 'FichaPreinscritoExtraordinarioController@reimprime');


Route::post('guardarPersonasResponsables','PersonasAutorizadasLogsController@guardarResponsables')->name('guardarResponsables');


require (__DIR__ . '/control_escolar.php');

require (__DIR__ . '/catalogos.php');

require (__DIR__ . '/reportes.php');

require (__DIR__ . '/reportes-federal.php');

require (__DIR__ . '/procesos.php');

require (__DIR__ . '/pagos.php');


require (__DIR__ . '/archivos.php');

require (__DIR__ . '/administracion.php');

require (__DIR__ . '/portal_configuracion.php');

require (__DIR__ . '/prefecteo.php');

require (__DIR__ . '/language.php');

require (__DIR__ . '/educacion_continua.php');

require (__DIR__ . '/alumnos.php');

require (__DIR__ . '/extraordinarios.php');

require (__DIR__ . '/gimnasio.php');

require (__DIR__ . '/preescolar.php');

require (__DIR__ . '/primaria.php');

require (__DIR__ . '/tutorias.php');

require (__DIR__ . '/secundaria.php');

require (__DIR__ . '/bachiller.php');

require (__DIR__ . '/modulo_idiomas.php');
require (__DIR__ . '/modulo_gimnasio.php');
require (__DIR__ . '/modulo_natacion.php');

require (__DIR__ . '/servicios_externos.php');

require (__DIR__ . '/activades_extraescolares.php');
