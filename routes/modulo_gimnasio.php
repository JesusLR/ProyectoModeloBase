<?php

// Usuarios
Route::get('gimnasio_usuario', 'Gimnasio\GimnasioUsuarioController@index')->name('gimnasio.gimnasio_usuario.index');
Route::get('gimnasio_usuario/list', 'Gimnasio\GimnasioUsuarioController@list')->name('gimnasio.gimnasio_usuario.list');
Route::get('gimnasio_usuario/api/programas/{escuela_id}','Gimnasio\GimnasioUsuarioController@getProgramas');
Route::get('gimnasio_usuario/api/programa/{programa_id}','Gimnasio\GimnasioUsuarioController@getPrograma');
Route::get('gimnasio_usuario/create', 'Gimnasio\GimnasioUsuarioController@create')->name('gimnasio.gimnasio_usuario.create');
Route::get('gimnasio_usuario/{id}/edit', 'Gimnasio\GimnasioUsuarioController@edit')->name('gimnasio.gimnasio_usuario.edit');
Route::get('gimnasio_usuario/{id}', 'Gimnasio\GimnasioUsuarioController@show')->name('gimnasio.gimnasio_usuario.show');
Route::post('gimnasio_usuario', 'Gimnasio\GimnasioUsuarioController@store')->name('gimnasio.gimnasio_usuario.store');
Route::put('gimnasio_usuario/{id}', 'Gimnasio\GimnasioUsuarioController@update')->name('gimnasio.gimnasio_usuario.update');
Route::delete('gimnasio_usuario/{id}', 'Gimnasio\GimnasioUsuarioController@destroy')->name('gimnasio.gimnasio_usuario.destroy');

Route::get('api/gimnasio_usuario/buscar_clave/{aluClave}', 'Gimnasio\GimnasioUsuarioController@buscar_alumno')->name('api/gimnasio_usuario/buscar_clave/{aluClave}');
Route::post('gimnasio_usuario/{usuariogim_id}/generar_ficha', 'Gimnasio\GimnasioUsuarioController@generar_ficha')->name('gimnasio_usuario/{usuariogim_id}/generar_ficha');
Route::post('gimnasio_usuario/{usuariogim_id}/generar_ficha_hsbc', 'Gimnasio\GimnasioUsuarioController@generar_ficha_hsbc')->name('gimnasio_usuario/{usuariogim_id}/generar_ficha_hsbc');

// Tipos de Usuario
Route::get('gimnasio_tipo_usuario', 'Gimnasio\GimnasioTipoUsuarioController@index')->name('gimnasio.gimnasio_tipo_usuario.index');
Route::get('gimnasio_tipo_usuario/list', 'Gimnasio\GimnasioTipoUsuarioController@list')->name('gimnasio.gimnasio_tipo_usuario.list');;
Route::get('gimnasio_tipo_usuario/create', 'Gimnasio\GimnasioTipoUsuarioController@create')->name('gimnasio.gimnasio_tipo_usuario.create');
Route::get('gimnasio_tipo_usuario/{id}/edit', 'Gimnasio\GimnasioTipoUsuarioController@edit')->name('gimnasio.gimnasio_tipo_usuario.edit');
Route::get('gimnasio_tipo_usuario/{id}', 'Gimnasio\GimnasioTipoUsuarioController@show')->name('gimnasio.gimnasio_tipo_usuario.show');
Route::post('gimnasio_tipo_usuario', 'Gimnasio\GimnasioTipoUsuarioController@store')->name('gimnasio.gimnasio_tipo_usuario.store');
Route::put('gimnasio_tipo_usuario/{id}', 'Gimnasio\GimnasioTipoUsuarioController@update')->name('gimnasio.gimnasio_tipo_usuario.update');
Route::delete('gimnasio_tipo_usuario/{id}', 'Gimnasio\GimnasioTipoUsuarioController@destroy')->name('gimnasio.gimnasio_tipo_usuario.destroy');

// Alumno Route
Route::resource('gimnasio_alumno','Gimnasio\GimnasioAlumnoController');
Route::get('gimnasio_alumno/cambiar_matricula/{alumnoId}','Gimnasio\GimnasioAlumnoController@cambiarMatricula')->name("cambiarMatricula");
Route::post('gimnasio_alumno/cambiar_matricula/edit','Gimnasio\GimnasioAlumnoController@postCambiarMatricula')->name("cambiarMatricula");
Route::get('api/gimnasio_alumno/list','Gimnasio\GimnasioAlumnoController@list')->name('list');
Route::get('gimnasio_alumno/getAlumnos','Gimnasio\GimnasioAlumnoController@getAlumnos');
Route::get('gimnasio_alumno/alumnoById/{alumnoId}','Gimnasio\GimnasioAlumnoController@getAlumnoById');
Route::get('gimnasio_alumno/getAlumnosByFilter/{nombreAlumno}','Gimnasio\GimnasioAlumnoController@getAlumnosByFilter');
Route::get('gimnasio_alumno/buscar_alumno/{aluClave}','Gimnasio\GimnasioAlumnoController@getAlumnoByClave');
Route::post('gimnasio_alumno/getMultipleAlumnosByFilter','Gimnasio\GimnasioAlumnoController@getMultipleAlumnosByFilter');
Route::get('gimnasio_alumno/ultimo_curso/{alumno_id}', 'Gimnasio\GimnasioAlumnoController@ultimoCurso')->name('api/gimnasio_alumno/ultimo_curso/{alumno_id}');
Route::get('gimnasio_alumno/conceptosBaja','Gimnasio\GimnasioAlumnoController@conceptosBaja')->name('api/gimnasio_alumno/conceptosBaja');
Route::get('api/gimnasio_alumno/verificar_persona', 'Gimnasio\GimnasioAlumnoController@verificarExistenciaPersona')->name('api/gimnasio_alumno/verificar_persona');
Route::get('api/gimnasio_alumno/listHistorialPagosAluclave/{aluClave}','Gimnasio\GimnasioAlumnoController@listHistorialPagosAluclave');