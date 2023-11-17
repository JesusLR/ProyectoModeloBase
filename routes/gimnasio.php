<?php 

/*
* --------------------------------------------------------------------------
* RUTAS DE GIMNASIO.
* --------------------------------------------------------------------------
*/

Route::get('api/usuariogim', 'UsuarioGimController@list')->name('api/usuariogim');
Route::get('api/usuariogim/buscar_clave/{aluClave}', 'UsuarioGimController@buscar_alumno')
	->name('api/usuariogim/buscar_clave/{aluClave}');
Route::get('api/usuariogim/{usuariogim_id}/pagos', 'UsuarioGimController@usuariogim_pagos_list')
	->name('api/usuariogim/{usuariogim_id}/pagos');
Route::post('usuariogim/{usuariogim_id}/generar_ficha', 'UsuarioGimController@generar_ficha')
	->name('usuariogim/{usuariogim_id}/generar_ficha');
Route::resource('usuariogim', 'UsuarioGimController');

/**
* REPORTES DE GIMNASIO
*/

Route::get('reporte/gimnasio_pagos_aplicados', 'Reportes\GimnasioPagosAplicadosController@reporte');
Route::post('reporte/gimnasio_pagos_aplicados/imprimir', 'Reportes\GimnasioPagosAplicadosController@imprimir');