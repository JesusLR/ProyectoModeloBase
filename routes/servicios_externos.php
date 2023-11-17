<?php 

/*
|--------------------------------------------------------------------------
| RUTAS DE SERVICIOS EXTERNOS.
|--------------------------------------------------------------------------
|
*/

// Hurra Alumnos
Route::get('hurra_alumnos', 'ServiciosExternos\HurraAlumnosController@reporte');
Route::post('hurra_alumnos/generar', 'ServiciosExternos\HurraAlumnosController@generar');

// Hurra Maestros
Route::get('hurra_maestros', 'ServiciosExternos\HurraMaestrosController@reporte');
Route::post('hurra_maestros/generar', 'ServiciosExternos\HurraMaestrosController@generar');

// Hurra Ordinarios
Route::get('hurra_ordinarios', 'ServiciosExternos\HurraOrdinariosController@reporte');
Route::post('hurra_ordinarios/generar', 'ServiciosExternos\HurraOrdinariosController@generar');

// Hurra Horarios
Route::get('hurra_horarios', 'ServiciosExternos\HurraHorariosController@reporte');
Route::post('hurra_horarios/generar', 'ServiciosExternos\HurraHorariosController@generar');

// Hurra Calificaciones
Route::get('hurra_calificaciones', 'ServiciosExternos\HurraCalificacionesController@reporte');
Route::post('hurra_calificaciones/generar', 'ServiciosExternos\HurraCalificacionesController@generar');

// Hurra Extraordinarios
Route::get('hurra_extraordinarios', 'ServiciosExternos\HurraExtraordinariosController@reporte');
Route::post('hurra_extraordinarios/generar', 'ServiciosExternos\HurraExtraordinariosController@generar');

// Manuales
Route::get('manuales', 'ManualController@index');