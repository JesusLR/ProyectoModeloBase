<?php 

/*
|--------------------------------------------------------------------------
| RUTAS DE MÓDULOS PARA ALUMNOS
|--------------------------------------------------------------------------
|
*/

Route::resource('inscribirse_extraordinario', 'Alumnos\InscribirseExtraordinarioController')->only('store');
Route::get('inscribirse_extraordinario/{alumno_id}', 'Alumnos\InscribirseExtraordinarioController@view_datatable')->name('inscribirse_extraordinario/{alumno_id}');
Route::get('api/inscribirse_extraordinario/{alumno_id}', 'Alumnos\InscribirseExtraordinarioController@list')->name('api/inscribirse_extraordinario/{alumno_id}');