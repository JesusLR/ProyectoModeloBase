<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE PROCESOS
|--------------------------------------------------------------------------
|
*/

//Pagos
Route::get('proceso/pago','Procesos\PagoController@subir');
Route::post('proceso/pago/aplicar','Procesos\PagoController@aplicar');

// Alumno Route
Route::resource('contabilidad/alumnos','Procesos\ContabilidadAlumnosController');
Route::get('api/contabilidad/alumnos','Procesos\ContabilidadAlumnosController@list')->name('api/contabilidad/alumnos');

// Fichas Route
Route::resource('contabilidad/fichas','Procesos\ContabilidadFichasController');
Route::get('api/contabilidad/fichas','Procesos\ContabilidadFichasController@list')->name('api/contabilidad/fichas');

// Referencias Route
Route::resource('contabilidad/referencias','Procesos\ContabilidadReferenciasController');
Route::get('api/contabilidad/referencias','Procesos\ContabilidadReferenciasController@list')->name('api/contabilidad/referencias');

// Excel Pagos
Route::get('proceso/excel_pagos', 'Procesos\ExcelPagosController@reporte');
Route::post('proceso/excel_pagos/descargar', 'Procesos\ExcelPagosController@descargar');




