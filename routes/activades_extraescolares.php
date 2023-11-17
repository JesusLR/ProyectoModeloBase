<?php 

/*
|--------------------------------------------------------------------------
| RUTAS DE MÓDULOS PARA EXTRAESCOLARES
|--------------------------------------------------------------------------
|
*/
//Actividades
Route::get('actividades','ActividadesController@index')->name('universidad.universidad_actividades.index');
Route::get('actividades/list','ActividadesController@list');
Route::get('actividades/create','ActividadesController@create')->name('universidad.universidad_actividades.create');
Route::get('actividades/{id}/edit','ActividadesController@edit')->name('universidad.universidad_actividades.edit');
Route::get('actividades/{id}','ActividadesController@show')->name('universidad.universidad_actividades.show');
Route::post('actividades','ActividadesController@store')->name('universidad.universidad_actividades.store');
Route::put('actividades/{id}','ActividadesController@update')->name('universidad.universidad_actividades.update');

//Actividades inscritos
Route::get('actividades_inscritos','ActividadesInscritosController@index')->name('universidad.universidad_actividades_inscritos.index');
Route::get('actividades_inscritos/list','ActividadesInscritosController@list');
Route::get('actividades_inscritos/create','ActividadesInscritosController@create')->name('universidad.universidad_actividades_inscritos.create');
Route::get('actividades_inscritos/getActividades/{periodo_id}/{programa_id}','ActividadesInscritosController@getActividades');
Route::get('actividades_inscritos/api/periodos/{departamento_id}','ActividadesInscritosController@getPeriodos');
Route::get('actividades_inscritos/api/departamentos/{id}','ActividadesInscritosController@getDepartamentos');
Route::get('actividades_inscritos/api/escuelas/{id}/{otro?}','ActividadesInscritosController@getEscuelas');
Route::get('actividades_inscritos/{id}/edit','ActividadesInscritosController@edit')->name('universidad.universidad_actividades_inscritos.edit');
Route::get('actividades_inscritos/{id}','ActividadesInscritosController@show')->name('universidad.universidad_actividades_inscritos.show');
Route::get('actividades_inscritos/imprimir/{id}','ActividadesInscritosController@listadoInscritos')->name('universidad.universidad_actividades_inscritos.listadoInscritos');
Route::post('actividades_inscritos','ActividadesInscritosController@store')->name('universidad.universidad_actividades_inscritos.store');
Route::delete('actividades_inscritos/baja_actividad_inscrito/{id}','ActividadesInscritosController@baja_actividad_inscrito')->name('universidad.universidad_actividades_inscritos.baja_actividad_inscrito');
Route::put('actividades_inscritos/{id}','ActividadesInscritosController@update')->name('universidad.universidad_actividades_inscritos.update');

//Nuevo Externo
Route::get('nuevo_externo','NuevoExternoController@create')->name('universidad.universidad_nuevo_externo.create');
Route::post('nuevo_externo','NuevoExternoController@store')->name('universidad.universidad_nuevo_externo.store');


Route::get('/aex_pagos/ficha_general/{aluClave}/{perAnioPago}/{programa_id}/{ubiNombre}/{perNumero}/{actividad_id}','FichaGeneralActividadesController@index');
Route::post('aex_pagos/ficha_general/store','FichaGeneralActividadesController@store')->name('aex_pagos.storeFichaGeneral');
Route::get('aex_pagos/ficha_general/obtenerCuotaConcepto/{cuoConcepto}','FichaGeneralActividadesController@obtenerCuotaConcepto');
Route::get('aex_pagos/ficha_general/obtenerAnualidadImporte/{aluClaves}/{cuoAnio}','FichaGeneralActividadesController@obtenerAnualidadImporte')->name('aex_pagos/ficha_general/obtenerAnualidadImporte');
// Route::post('aex_pagos/ficha_general/ficha_alumno','Preescolar\FichaAlumnoController@store')->name('aex_pagos.fichaAlumno');