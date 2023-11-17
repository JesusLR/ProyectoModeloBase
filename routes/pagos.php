<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE PAGOS
|--------------------------------------------------------------------------
|
*/


//FICHA GENERAL
// Route::resource('pagos','Pagos\FichaGeneralController');
Route::get('pagos/ficha_general','Pagos\FichaGeneralController@index');
Route::post('pagos/ficha_general/store','Pagos\FichaGeneralController@store')->name('storeFichaGeneral');
Route::get('pagos/ficha_general/obtenerCuotaConcepto/{cuoConcepto}','Pagos\FichaGeneralController@obtenerCuotaConcepto')->name('pagos/ficha_general/obtenerCuotaConcepto');
Route::get('pagos/ficha_general/obtenerAnualidadImporte/{aluClaves}/{cuoAnio}','Pagos\FichaGeneralController@obtenerAnualidadImporte')->name('pagos/ficha_general/obtenerAnualidadImporte');
Route::post('pagos/ficha_general/ficha_alumno','Pagos\FichaAlumnoController@store')->name('fichaAlumno');
Route::get('pagos/ficha_general/check/{cuoConcepto}/{aluClave}/{cuoAnio}','Pagos\FichaGeneralController@check');


Route::get('pagos/aplicar_pagos','Pagos\AplicarPagosController@index');
Route::get('api/pagos/listadopagos','Pagos\AplicarPagosController@list');
Route::get('pagos/aplicar_pagos/create','Pagos\AplicarPagosController@create');
Route::get('pagos/aplicar_pagos/edit/{id}','Pagos\AplicarPagosController@edit');
Route::post('pagos/aplicar_pagos/update','Pagos\AplicarPagosController@update')->name("aplicarPagos.update");
Route::post('pagos/aplicar_pagos/existeAlumnoByClavePago','Pagos\AplicarPagosController@existeAlumnoByClavePago')->name("aplicarPagos.existeAlumnoByClavePago");


Route::post('pagos/aplicar_pagos/store','Pagos\AplicarPagosController@store')->name("aplicarPagos.store");
Route::delete('pagos/aplicar_pagos/delete/{id}','Pagos\AplicarPagosController@destroy')->name("aplicarPagos.destroy");
Route::get('pagos/aplicar_pagos/detalle/{pagoId}','Pagos\AplicarPagosController@detalle')->name("aplicarPagos.detalle");
Route::post('api/pagos/verificarExistePago/','Pagos\AplicarPagosController@verificarExistePago')->name("aplicarPagos.verificarExistePago");
Route::get('api/aplicar_pagos/buscar_inscripciones_educacion_continua/{pagClaveAlu}', 'Pagos\AplicarPagosController@getInscripcionesEducacionContinua');



// Ubicacion Route
Route::get('pagos/registro_cuotas','Pagos\RegistroCuotasController@index');
Route::get('api/pagos/listado_cuotas','Pagos\RegistroCuotasController@list');
Route::get('pagos/registro_cuotas/create','Pagos\RegistroCuotasController@create');
Route::post('pagos/registro_cuotas/store','Pagos\RegistroCuotasController@store')->name("registroCuotas.store");
Route::get('pagos/registro_cuotas/edit/{id}','Pagos\RegistroCuotasController@edit');
Route::delete('pagos/registro_cuotas/delete/{id}','Pagos\RegistroCuotasController@destroy')->name("registroCuotas.destroy");
Route::post('pagos/registro_cuotas/update','Pagos\RegistroCuotasController@update')->name("registroCuotas.update");
Route::get('pagos/registro_cuotas/{cuota_id}/cuota_descuento', 'Pagos\RegistroCuotasController@cuota_descuento');


Route::get('api/registro_cuotas','Pagos\RegistroCuotasController@list')->name('api/registro_cuotas');




// Referencia Route
// Route::resource('pago','Pagos\PagoController');
// Route::get('api/cuota/{cuoConcepto}','Pagos\PagoController@obtenerCuotaConcepto')->name('api/cuota');


//DataTable Consulta de Fichas.
Route::get('pagos/consulta_fichas', 'Pagos\ConsultaFichasController@fichas');
Route::get('api/consulta_fichas', 'Pagos\ConsultaFichasController@list')->name('api/consulta_fichas');

// CRUD - Conceptos de Pago.
Route::resource('/concepto_pago', 'Pagos\ConceptoPagoController');
Route::get('api/concepto_pago', 'Pagos\ConceptoPagoController@list')->name('api/concepto_pago');

// CRUD Cuotas Descuentos.
Route::get('api/pagos/cuota_descuento', 'Pagos\CuotaDescuentoController@list');
Route::get('pagos/cuota_descuento/{cuota_id}/agregar_descuento', 'Pagos\CuotaDescuentoController@agregar_descuento');
Route::resource('pagos/cuota_descuento', 'Pagos\CuotaDescuentoController');