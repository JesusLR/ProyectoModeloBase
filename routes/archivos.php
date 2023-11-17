<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE ARCHIVOS
|--------------------------------------------------------------------------
|
*/


//Grupo
Route::get('archivo/grupo','Archivos\AgrupoController@generar');
Route::post('archivo/grupo/descargar','Archivos\AgrupoController@descargar');

//Inscripcion
Route::get('archivo/inscripcion','Archivos\AinscripcionController@generar');
Route::post('archivo/inscripcion/descargar','Archivos\AinscripcionController@descargar');

//Ordinario
Route::get('archivo/ordinario','Archivos\AordinarioController@generar');
Route::post('archivo/ordinario/descargar','Archivos\AordinarioController@descargar');

//Extraordinario
Route::get('archivo/extraordinario','Archivos\AextraordinarioController@generar');
Route::post('archivo/extraordinario/descargar','Archivos\AextraordinarioController@descargar');


Route::get('archivo/control_estados','Archivos\ControlEstadosController@index');
Route::post('archivo/control_estados/update','Archivos\ControlEstadosController@updateControlEstados')->name('controlestados.update');