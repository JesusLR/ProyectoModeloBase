<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE EDUCACION CONTINUA
|--------------------------------------------------------------------------
|
*/



// edu continua Route
Route::resource('progeducontinua','EducacionContinua\ProgEduContinuaController');
Route::get('api/progeducontinua','EducacionContinua\ProgEduContinuaController@list')->name('api/progeducontinua');

Route::resource('tiposProgEduContinua','EducacionContinua\TiposProgEduContinuaController');
Route::get('api/tiposProgEduContinua','EducacionContinua\TiposProgEduContinuaController@list')->name('api/tiposProgEduContinua');


Route::resource('inscritosEduContinua','EducacionContinua\InscritosEduContinuaController');
Route::get('api/inscritosEduContinua','EducacionContinua\InscritosEduContinuaController@list')->name('api/inscritosEduContinua');
Route::get('api/eduContPagosList/{id}', 'EducacionContinua\InscritosEduContinuaController@eduContPagosList')->name("api/eduContPagosList");
Route::get('inscritosEduContinua/{inscrito_id}/realizar_pago', 'EducacionContinua\InscritosEduContinuaController@realizar_pago');
Route::post('inscritosEduContinua/{inscrito_id}/ficha_pago/{concepto}/{banco}', 'EducacionContinua\InscritosEduContinuaController@fichaPago');


// Route::get('fichaPagoEduContinua/{inscrito_id}/{concepto}','EducacionContinua\InscritosEduContinuaController@fichaPago')->name('fichaPago');



Route::get('reporte/relacion_educontinua','EducacionContinua\Reportes\RelEduconController@reporte');
Route::post('reporte/relacion_educontinua/imprimir','EducacionContinua\Reportes\RelEduconController@imprimir');


Route::get('reporte/rel_pagos_educontinua','EducacionContinua\Reportes\RelPagosEduconController@reporte');
Route::post('reporte/rel_pagos_educontinua/imprimir','EducacionContinua\Reportes\RelPagosEduconController@imprimir');


Route::get('reporte/rel_aluprog_educontinua','EducacionContinua\Reportes\RelAluProgEduconController@reporte');
Route::post('reporte/rel_aluprog_educontinua/imprimir','EducacionContinua\Reportes\RelAluProgEduconController@imprimir');

// Educación Continua - Fichas Incorrectas.
Route::get('reporte/fichas_incorrectas_edu_continua', 'EducacionContinua\Reportes\FichasIncorrectasEduContinuaController@reporte');
Route::post('reporte/fichas_incorrectas_edu_continua/imprimir', 'EducacionContinua\Reportes\FichasIncorrectasEduContinuaController@imprimir');
