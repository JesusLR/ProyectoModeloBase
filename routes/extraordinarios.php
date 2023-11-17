<?php


/*
|--------------------------------------------------------------------------
| RUTAS PARA MÓDULOS DE EXTRAORDINARIOS.
|--------------------------------------------------------------------------
|
*/

//Módulo Preinscritos Extraordinarios.
Route::get('api/preinscrito_extraordinario', 'PreinscritoExtraordinarioController@list')->name('api/preinscrito_extraordinario');
Route::post('preinscrito_extraordinario/{preinscrito_id}/inscribir', 'PreinscritoExtraordinarioController@inscribir');
Route::post('preinscrito_extraordinario/cancelar/{preinscrito_id}', 'PreinscritoExtraordinarioController@cancelar');
Route::resource('preinscrito_extraordinario', 'PreinscritoExtraordinarioController');