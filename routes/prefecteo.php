<?php 

/*
* --------------------------------------------------------------------------
* RUTAS DE PREFECTEO.
* --------------------------------------------------------------------------
*/

//Prefecteo
Route::get('api/prefecteo', 'PrefecteoController@list');
Route::resource('prefecteo', 'PrefecteoController');

//PrefecteoDetalle
Route::get('api/prefecteo/{prefecteo_id}/detalles', 'PrefecteoController@listDetalles')->name('api/prefecteo/{prefecteo_id}/detalles');
Route::resource('prefecteodetalle', 'PrefecteoDetalleController')->only(['edit', 'update']);

/**
* REPORTES DE PREFECTEO
*/

//Aulas Ocupadas por Escuelas.
Route::get('aulas/ocupadas','AulasOcupadasController@reporte');
Route::post('aulas/ocupadas/imprimir','AulasOcupadasController@imprimir');

Route::get('aulas_en_clase', 'Reportes\AulasEnClaseController@reporte');
Route::post('aulas_en_clase/imprimir', 'Reportes\AulasEnClaseController@imprimir');