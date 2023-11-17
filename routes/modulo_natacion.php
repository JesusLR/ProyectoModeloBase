<?php

// Usuarios
Route::get('natacion_ficha_pago', 'Natacion\FichaGeneralController@index')->name('natacion.natacion_ficha_pago.index');
Route::post('natacion_ficha_pago/store','Natacion\FichaGeneralController@store')->name('natacion.storeFichaGeneral');
Route::get('natacion_ficha_pago/getCursoAlumno/{aluClave}/{cuoAnio}','Natacion\FichaGeneralController@getCursoAlumno');

// Alumno Route
Route::resource('natacion_alumno','Natacion\NatacionAlumnoController');
Route::get('natacion_alumno/cambiar_matricula/{alumnoId}','Natacion\NatacionAlumnoController@cambiarMatricula')->name("cambiarMatricula");
Route::post('natacion_alumno/cambiar_matricula/edit','Natacion\NatacionAlumnoController@postCambiarMatricula')->name("cambiarMatricula");
Route::get('api/natacion_alumno/list','Natacion\NatacionAlumnoController@list')->name('list');
Route::get('natacion_alumno/getAlumnos','Natacion\NatacionAlumnoController@getAlumnos');
Route::get('natacion_alumno/alumnoById/{alumnoId}','Natacion\NatacionAlumnoController@getAlumnoById');
Route::get('natacion_alumno/getAlumnosByFilter/{nombreAlumno}','Natacion\NatacionAlumnoController@getAlumnosByFilter');
Route::get('natacion_alumno/buscar_alumno/{aluClave}','Natacion\NatacionAlumnoController@getAlumnoByClave');
Route::post('natacion_alumno/getMultipleAlumnosByFilter','Natacion\NatacionAlumnoController@getMultipleAlumnosByFilter');
Route::get('natacion_alumno/ultimo_curso/{alumno_id}', 'Natacion\NatacionAlumnoController@ultimoCurso')->name('api/natacion_alumno/ultimo_curso/{alumno_id}');
Route::get('natacion_alumno/conceptosBaja','Natacion\NatacionAlumnoController@conceptosBaja')->name('api/natacion_alumno/conceptosBaja');
Route::get('api/natacion_alumno/verificar_persona', 'Natacion\NatacionAlumnoController@verificarExistenciaPersona')->name('api/natacion_alumno/verificar_persona');
Route::get('api/natacion_alumno/listHistorialPagosAluclave/{aluClave}','Natacion\NatacionAlumnoController@listHistorialPagosAluclave');