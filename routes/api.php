<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 *
 *
 *
Route::post('getasig', 'Api\AsignaturasController@store');
Route::post('postLogin', 'Api\LoginController@store');
Route::post('getord', 'Api\OrdinariosController@store');
Route::post('getcalifExtra', 'Api\CalifExtrasController@store');
Route::post('getcalif', 'Api\CalificacionesController@store');
Route::post('getext', 'Api\ExtraordinariosController@store');
Route::post('gethorario', 'Api\HorariosController@store');
Route::post('getcves4avisos', 'Api\CveAlumnosController@store');
Route::post('getcarrer1t4s', 'Api\ProgramasController@store');
Route::post('getpagos', 'Api\PagosController@store');

 */


//Agregamos nuestra ruta al controller de APIS
//Route::any('getasig', 'Api\AsignaturasController@store');
//Route::post('getasig', 'Api\AsignaturasController@store');
//Route::resource('getasig', 'Api\AsignaturasController',[ 'except'=>['index','create','show','edit','update','delete'] ]);
Route::resource('getasig', 'Api\AsignaturasController');

Route::resource('postLogin', 'Api\LoginController');

Route::resource('getord', 'Api\OrdinariosController');

Route::resource('getcalifExtra', 'Api\CalifExtrasController');

Route::resource('getcalif', 'Api\CalificacionesController');

Route::resource('getext', 'Api\ExtraordinariosController');

Route::resource('gethorario', 'Api\HorariosController');

Route::resource('getpagos', 'Api\PagosController');

Route::resource('getcves4avisos', 'Api\CveAlumnosController');

Route::resource('getcarrer1t4s', 'Api\ProgramasController');

Route::post('getcarrer2t4s', 'Api\ProgramasController@getGruposPorEscuela');

Route::resource('tut0ri4sun4lumn0', 'Api\TutoriasUnAlumnoController');

Route::resource('tut0ri4scarrer1t4s', 'Api\TutoriasCarrerasController');

Route::resource('tut0ri4stut0r3s', 'Api\TutoriasTutoresDocentesController');

Route::resource('tut0ri4sc4lif1', 'Api\TutoriasCalificacionController');

Route::resource('tut0ri4sapru3b4', 'Api\TutoriasMateriasAprobadasController');

Route::resource('tut0ri4srepru3b4', 'Api\TutoriasMateriasReprobadasController');

Route::resource('tut0ri4sc4mpus', 'Api\TutoriasCampusController');

Route::resource('tut0ri4s3scu3l4s', 'Api\TutoriasEscuelasController');

Route::resource('tut0ri4sc4rr3r1t4sEscuela', 'Api\TutoriasCarrerasEscuelasController');

Route::resource('tut0ri4stut0r3scarrer1t4s', 'Api\TutoriasTutoresCarrerasController');

Route::resource('tut0ri4slist4lumn0s', 'Api\TutoriasListaAlumnosController');

Route::resource('tut0ri4slistut0R3s', 'Api\TutoriasListaTutoresController');