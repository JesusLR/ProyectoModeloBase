<?php

// Empleados
Route::get('idiomas_empleado', 'Idiomas\IdiomasEmpleadoController@index')->name('idiomas.idiomas_empleado.index');
Route::get('idiomas_empleado/list', 'Idiomas\IdiomasEmpleadoController@list')->name('idiomas.idiomas_empleado.list');
Route::get('idiomas_empleado/api/programas/{escuela_id}','Idiomas\IdiomasEmpleadoController@getProgramas');
Route::get('idiomas_empleado/api/programa/{programa_id}','Idiomas\IdiomasEmpleadoController@getPrograma');
Route::get('idiomas_empleado/create', 'Idiomas\IdiomasEmpleadoController@create')->name('idiomas.idiomas_empleado.create');
Route::get('idiomas_empleado/{id}/edit', 'Idiomas\IdiomasEmpleadoController@edit')->name('idiomas.idiomas_empleado.edit');
Route::get('idiomas_empleado/{id}', 'Idiomas\IdiomasEmpleadoController@show')->name('idiomas.idiomas_empleado.show');
Route::post('idiomas_empleado', 'Idiomas\IdiomasEmpleadoController@store')->name('idiomas.idiomas_empleado.store');
Route::put('idiomas_empleado/{id}', 'Idiomas\IdiomasEmpleadoController@update')->name('idiomas.idiomas_empleado.update');
Route::delete('idiomas_empleado/{id}', 'Idiomas\IdiomasEmpleadoController@destroy')->name('idiomas.idiomas_empleado.destroy');

Route::get('api_idiomas_empleado/verificar_persona', 'Idiomas\IdiomasEmpleadoController@verificarExistenciaPersona');

// Cursos
Route::get('/idiomas_curso', 'Idiomas\IdiomasCursoController@index')->name('curso_idiomas.index');
Route::get('idiomas_curso/list', 'Idiomas\IdiomasCursoController@list')->name('curso_idiomas.list');
Route::get('idiomas_curso/create', 'Idiomas\IdiomasCursoController@create')->name('curso_idiomas.create');
Route::post('idiomas_curso', 'Idiomas\IdiomasCursoController@store')->name('curso_idiomas.store');
Route::get('idiomas_curso/{id}', 'Idiomas\IdiomasCursoController@show')->name('curso_idiomas.show');
Route::get('idiomas_curso/{id}/edit', 'Idiomas\IdiomasCursoController@edit')->name('curso_idiomas.edit');
Route::put('idiomas_curso/{id}', 'Idiomas\IdiomasCursoController@update')->name('curso_idiomas.update');
Route::get('idiomas_curso/observaciones/{curso_id}/', 'Idiomas\IdiomasCursoController@observaciones')->name('curso_idiomas.observaciones');
Route::post('idiomas_curso/storeObservaciones','Idiomas\IdiomasCursoController@storeObservaciones')->name('curso_idiomas.storeObservacionesCurso');
Route::post('idiomas_curso/bajaCurso','Idiomas\IdiomasCursoController@bajaCurso')->name('curso_idiomas.bajaCurso');
Route::post('idiomas_curso/altaCurso','Idiomas\IdiomasCursoController@altaCurso')->name('curso_idiomas.altaCurso');
Route::get('api/idiomas_curso/listHistorialPagos/{curso_id}','Idiomas\IdiomasCursoController@listHistorialPagos')->name('api.idiomas_curso.listHistorialPagos');
Route::post('api/idiomasGetMultipleAlumnosByFilter','Idiomas\IdiomasCursoController@getMultipleAlumnosByFilter');
Route::get('api/idiomasUltimo_curso/{alumno_id}', 'Idiomas\IdiomasCursoController@ultimoCurso');
Route::get('idiomas_curso/crearReferencia/{curso_id}/{tienePagoCeneval}','Idiomas\IdiomasCursoController@crearReferenciaBBVA')->name('idiomas_curso.crearReferencia');
Route::get('idiomas_curso/crearReferenciaHSBC/{curso_id}/{tienePagoCeneval}','Idiomas\IdiomasCursoController@crearReferenciaHSBC')->name('idiomas_curso.crearReferenciaHSBC');

Route::get('idiomas_curso/api/departamentos/{id}','Idiomas\IdiomasGrupoController@getDepartamentos');
Route::get('idiomas_curso/api/escuelas/{id}','Idiomas\IdiomasCursoController@getEscuelas');
Route::get('api/idiomas_curso/infoBaja/{curso_id}','Idiomas\IdiomasCursoController@infoBaja')->name('api/infoBaja');
Route::get('idiomas_alumnos/listHistorialPagosAluclave/{id}','Idiomas\IdiomasCursoController@listHistorialPagosAluclave');
Route::get('api/idiomas_curso/listPosiblesHermanos/{curso_id}','Idiomas\IdiomasCursoController@listPosiblesHermanos')->name('api/listPosiblesHermanos');
Route::get('api/idiomas_curso/conceptosBaja','Idiomas\IdiomasCursoController@conceptosBaja');
Route::get('api/idiomas_curso/infoBaja/{curso_id}','Idiomas\IdiomasCursoController@infoBaja');
Route::get('api/idiomas_curso/{curso}/verificar_materias_cargadas', 'Idiomas\IdiomasCursoController@verificar_materias_cargadas');

Route::get('tarjetaPagoAlumnoIdi/{curso_id}/{bancoSeleccionado}','Idiomas\TarjetasPagoAlumnosSPController@imprimirdesdecurso');

// Historial de calificaciones por alumno
Route::get('idiomas_curso/{curso_id}/historial_calificaciones_alumno/','Idiomas\IdiomasCursoController@historialCalificacionesAlumno')->name('historialCalificacionesAlumno');
Route::get('api/idiomas_curso/{curso_id}/listHistorialCalifAlumnos/','Idiomas\IdiomasCursoController@listHistorialCalifAlumnos')->name('listHistorialCalifAlumnos');
Route::get('api/idiomas_curso/{curso_id}/listHistorialCalifAlumnosResumen/','Idiomas\IdiomasCursoController@listHistorialCalifAlumnosResumen')->name('listHistorialCalifAlumnosResumen');

// Cambiar Carrera o Cgt.
Route::get('idiomas_cambiar_carrera/{curso}', 'Idiomas\CambiarCarreraController@vista');
Route::post('idiomas_cambiar_carrera/{curso}/cambiar', 'Idiomas\CambiarCarreraController@cambiar');

// Grupos
Route::get('idiomas_grupo', 'Idiomas\IdiomasGrupoController@index')->name('idiomas.idiomas_grupo.index');
Route::get('idiomas_grupo/list', 'Idiomas\IdiomasGrupoController@list')->name('idiomas.idiomas_grupo.list');
Route::get('idiomas_grupo/api/programas/{escuela_id}','Idiomas\IdiomasGrupoController@getProgramas');
Route::get('idiomas_grupo/api/programa/{programa_id}','Idiomas\IdiomasGrupoController@getPrograma');
Route::get('idiomas_grupo/create', 'Idiomas\IdiomasGrupoController@create')->name('idiomas.idiomas_grupo.create');
Route::get('idiomas_grupo/{id}/edit', 'Idiomas\IdiomasGrupoController@edit')->name('idiomas.idiomas_grupo.edit');
Route::get('idiomas_grupo/{id}', 'Idiomas\IdiomasGrupoController@show')->name('idiomas.idiomas_grupo.show');
Route::post('idiomas_grupo', 'Idiomas\IdiomasGrupoController@store')->name('idiomas.idiomas_grupo.store');
Route::put('idiomas_grupo/{id}', 'Idiomas\IdiomasGrupoController@update')->name('idiomas.idiomas_grupo.update');
Route::delete('idiomas_grupo/{id}', 'Idiomas\IdiomasGrupoController@destroy')->name('idiomas.idiomas_grupo.destroy');
Route::get('api/idiomas_grupos/{plan_id}/{periodo_id}','Idiomas\IdiomasGrupoController@getGrupos');

// Calificaciones
Route::get('idiomas_calificacion/grupo/{id}/edit','Idiomas\IdiomasCalificacionesController@edit_calificacion')->name('idiomas_grupo.calificaciones.edit_calificacion');
Route::post('idiomas_calificacion/calificaciones','Idiomas\IdiomasCalificacionesController@update_calificacion')->name('idiomas_calificacion.calificaciones.update_calificacion');
Route::get('idiomas_calificacion/getCalificacionesAlumnos/{id}/{grupoId}','Idiomas\IdiomasCalificacionesController@getCalificacionesAlumnos');

// listas para evaluacion parcial
Route::get('idiomas_listas_evaluacion', 'Idiomas\ListasEvaluacionParcialController@reporte');
Route::post('idiomas_listas_evaluacion/imprimir', 'Idiomas\ListasEvaluacionParcialController@imprimir');

// Programas
Route::get('idiomas_programa', 'Idiomas\IdiomasProgramasController@index')->name('idiomas.idiomas_programa.index');
Route::get('idiomas_programa/list', 'Idiomas\IdiomasProgramasController@list')->name('idiomas.idiomas_programa.list');
Route::get('idiomas_programa/api/programas/{escuela_id}','Idiomas\IdiomasProgramasController@getProgramas');
Route::get('idiomas_programa/api/programa/{programa_id}','Idiomas\IdiomasProgramasController@getPrograma');
Route::get('idiomas_programa/create', 'Idiomas\IdiomasProgramasController@create')->name('idiomas.idiomas_programa.create');
Route::get('idiomas_programa/{id}/edit', 'Idiomas\IdiomasProgramasController@edit')->name('idiomas.idiomas_programa.edit');
Route::get('idiomas_programa/{id}', 'Idiomas\IdiomasProgramasController@show')->name('idiomas.idiomas_programa.show');
Route::post('idiomas_programa', 'Idiomas\IdiomasProgramasController@store')->name('idiomas.idiomas_programa.store');
Route::put('idiomas_programa/{id}', 'Idiomas\IdiomasProgramasController@update')->name('idiomas.idiomas_programa.update');
Route::delete('idiomas_programa/{id}', 'Idiomas\IdiomasProgramasController@destroy')->name('idiomas.idiomas_programa.destroy');

// Niveles
Route::get('idiomas_nivel', 'Idiomas\IdiomasNivelController@index')->name('idiomas.idiomas_nivel.index');
Route::get('idiomas_nivel/list', 'Idiomas\IdiomasNivelController@list')->name('idiomas.idiomas_nivel.list');
Route::get('idiomas_nivel/create', 'Idiomas\IdiomasNivelController@create')->name('idiomas.idiomas_nivel.create');
Route::get('idiomas_nivel/{id}/edit', 'Idiomas\IdiomasNivelController@edit')->name('idiomas.idiomas_nivel.edit');
Route::get('idiomas_nivel/{id}', 'Idiomas\IdiomasNivelController@show')->name('idiomas.idiomas_nivel.show');
Route::post('idiomas_nivel', 'Idiomas\IdiomasNivelController@store')->name('idiomas.idiomas_nivel.store');
Route::put('idiomas_nivel/{id}', 'Idiomas\IdiomasNivelController@update')->name('idiomas.idiomas_nivel.update');
Route::delete('idiomas_nivel/{id}', 'Idiomas\IdiomasNivelController@destroy')->name('idiomas.idiomas_nivel.destroy');
Route::get('idiomas_nivel/planes/{id}', 'Idiomas\IdiomasNivelController@getPlanes');
Route::get('idiomas_nivel/niveles/{id}', 'Idiomas\IdiomasNivelController@getNiveles');

// Materias
Route::get('idiomas_materia', 'Idiomas\IdiomasMateriaController@index')->name('idiomas.idiomas_materia.index');
Route::get('idiomas_materia/list', 'Idiomas\IdiomasMateriaController@list')->name('idiomas.idiomas_materia.list');
Route::get('idiomas_materia/create', 'Idiomas\IdiomasMateriaController@create')->name('idiomas.idiomas_materia.create');
Route::get('idiomas_materia/{id}/edit', 'Idiomas\IdiomasMateriaController@edit')->name('idiomas.idiomas_materia.edit');
Route::get('idiomas_materia/{id}', 'Idiomas\IdiomasMateriaController@show')->name('idiomas.idiomas_materia.show');
Route::post('idiomas_materia', 'Idiomas\IdiomasMateriaController@store')->name('idiomas.idiomas_materia.store');
Route::put('idiomas_materia/{id}', 'Idiomas\IdiomasMateriaController@update')->name('idiomas.idiomas_materia.update');
Route::delete('idiomas_materia/{id}', 'Idiomas\IdiomasMateriaController@destroy')->name('idiomas.idiomas_materia.destroy');

// Cuotas
Route::get('idiomas_cuota', 'Idiomas\IdiomasCuotaController@index')->name('idiomas.idiomas_cuota.index');
Route::get('idiomas_cuota/list', 'Idiomas\IdiomasCuotaController@list')->name('idiomas.idiomas_cuota.list');
Route::get('idiomas_cuota/create', 'Idiomas\IdiomasCuotaController@create')->name('idiomas.idiomas_cuota.create');
Route::get('idiomas_cuota/{id}/edit', 'Idiomas\IdiomasCuotaController@edit')->name('idiomas.idiomas_cuota.edit');
Route::get('idiomas_cuota/{id}', 'Idiomas\IdiomasCuotaController@show')->name('idiomas.idiomas_cuota.show');
Route::post('idiomas_cuota', 'Idiomas\IdiomasCuotaController@store')->name('idiomas.idiomas_cuota.store');
Route::put('idiomas_cuota/{id}', 'Idiomas\IdiomasCuotaController@update')->name('idiomas.idiomas_cuota.update');
Route::delete('idiomas_cuota/{id}', 'Idiomas\IdiomasCuotaController@destroy')->name('idiomas.idiomas_cuota.destroy');

// Alumno Route
Route::resource('idiomas_alumno','Idiomas\IdiomasAlumnoController');
Route::get('idiomas_alumnos/{alumnoId}/constancia/','Idiomas\IdiomasAlumnoController@constancia');
Route::get('idiomas_alumno/cambiar_matricula/{alumnoId}','Idiomas\IdiomasAlumnoController@cambiarMatricula')->name("cambiarMatricula");
Route::post('idiomas_alumno/cambiar_matricula/edit','Idiomas\IdiomasAlumnoController@postCambiarMatricula')->name("cambiarMatricula");
Route::get('api/idiomas_alumno/list','Idiomas\IdiomasAlumnoController@list')->name('list');
Route::get('idiomas_alumno/getAlumnos','Idiomas\IdiomasAlumnoController@getAlumnos');
Route::get('idiomas_alumno/alumnoById/{alumnoId}','Idiomas\IdiomasAlumnoController@getAlumnoById');
Route::get('idiomas_alumno/getAlumnosByFilter/{nombreAlumno}','Idiomas\IdiomasAlumnoController@getAlumnosByFilter');
Route::get('idiomas_alumno/buscar_alumno/{aluClave}','Idiomas\IdiomasAlumnoController@getAlumnoByClave');
Route::post('idiomas_alumno/getMultipleAlumnosByFilter','Idiomas\IdiomasAlumnoController@getMultipleAlumnosByFilter');
Route::get('idiomas_alumno/ultimo_curso/{alumno_id}', 'Idiomas\IdiomasAlumnoController@ultimoCurso')->name('api/idiomas_alumno/ultimo_curso/{alumno_id}');
Route::get('idiomas_alumno/conceptosBaja','Idiomas\IdiomasAlumnoController@conceptosBaja')->name('api/idiomas_alumno/conceptosBaja');
Route::get('api/idiomas_alumno/verificar_persona', 'Idiomas\IdiomasAlumnoController@verificarExistenciaPersona')->name('api/idiomas_alumno/verificar_persona');

// Funciones genericas 
Route::get('idiomas_api/escuelas/{id}','Idiomas\IdiomasFuncionesGenericasController@getEscuelasIdi');
Route::get('idiomas_api/departamentos/{id}','Idiomas\IdiomasFuncionesGenericasController@getDepartamentos');
Route::get('idiomas_api/api/planes/{id}','Idiomas\IdiomasFuncionesGenericasController@getPlanesEspesificos');
Route::get('idiomas_api/api/planesTodos/{id}','Idiomas\IdiomasFuncionesGenericasController@getPlanesTodos');
Route::get('idiomas_api/get_departamentos_lista_completa/{ubicacion_id}','Idiomas\IdiomasFuncionesGenericasController@getDepartamentosListaCompleta');

// Periodos
Route::get('idiomas_periodo', 'Idiomas\IdiomasPeriodosController@index')->name('idiomas.idiomas_periodo.index');
Route::get('idiomas_periodo/list', 'Idiomas\IdiomasPeriodosController@list')->name('idiomas.idiomas_periodo.list');
Route::get('idiomas_periodo/api/periodos/{departamento_id}','Idiomas\IdiomasPeriodosController@getPeriodos');
Route::get('idiomas_periodo/todos/periodos/{departamento_id}','Idiomas\IdiomasPeriodosController@getPeriodosTodos');
Route::get('idiomas_periodo/curso/periodos/{departamento_id}','Idiomas\IdiomasPeriodosController@getPeriodosCurso');
Route::get('idiomas_periodo/getPeriodoAnteActuSig/periodos/{departamento_id}','Idiomas\IdiomasPeriodosController@getPeriodoAnteActuSig');
Route::get('idiomas_periodo/api/periodo/{id}','Idiomas\IdiomasPeriodosController@getPeriodo');
Route::get('idiomas_periodo/api/periodoPerAnioPago/{id}','Idiomas\IdiomasPeriodosController@getPeriodoPerAnioPago');
Route::get('idiomas_periodo/api/periodo/{departamento_id}/posteriores', 'Idiomas\IdiomasPeriodosController@getPeriodos_afterDate');
Route::get('idiomas_periodo/create', 'Idiomas\IdiomasPeriodosController@create')->name('idiomas.idiomas_periodo.create');
Route::get('idiomas_periodo/{id}/edit', 'Idiomas\IdiomasPeriodosController@edit')->name('idiomas.idiomas_periodo.edit');
Route::get('idiomas_periodo/{id}', 'Idiomas\IdiomasPeriodosController@show')->name('idiomas.idiomas_periodo.show');
Route::get('idiomas_periodo/api/periodoByDepartamento/{departamentoId}','Idiomas\IdiomasPeriodosController@getPeriodosByDepartamento');
Route::post('idiomas_periodo', 'Idiomas\IdiomasPeriodosController@store')->name('idiomas.idiomas_periodo.store');
Route::put('idiomas_periodo/{id}', 'Idiomas\IdiomasPeriodosController@update')->name('idiomas.idiomas_periodo.update');
Route::delete('idiomas_periodo/{id}', 'Idiomas\IdiomasPeriodosController@destroy')->name('idiomas.idiomas_periodo.destroy');

//Listas de Asistencia por Grupo
Route::get('idiomas_asistencia_grupo', 'Idiomas\AsistenciaGrupoController@reporte');
Route::post('idiomas_asistencia_grupo/imprimir', 'Idiomas\AsistenciaGrupoController@imprimir');

// Usuarios
Route::get('idiomas_ficha_pago', 'Idiomas\FichaGeneralController@index')->name('idiomas.idiomas_ficha_pago.index');
Route::post('idiomas_ficha_pago/store','Idiomas\FichaGeneralController@store')->name('idiomas.storeFichaGeneral');
Route::get('idiomas_ficha_pago/getCursoAlumno/{aluClave}/{cuoAnio}','Idiomas\FichaGeneralController@getCursoAlumno');

// boleta de calificaciones
Route::get('idiomas_boleta_calificaciones', 'Idiomas\BoletaCalificacionesController@reporte');
Route::post('idiomas_boleta_calificaciones/imprimir', 'Idiomas\BoletaCalificacionesController@imprimir');

// reporte listas pagos
Route::get('idiomas_listas_pagos', 'Idiomas\ListaPagoController@reporte');
Route::post('idiomas_listas_pagos/imprimir', 'Idiomas\ListaPagoController@imprimir');

//Calificacion final grupo
Route::get('idiomas_calificacion_final_grupo', 'Idiomas\CalificacionFinalGrupoController@reporte');
Route::post('idiomas_calificacion_final_grupo/imprimir', 'Idiomas\CalificacionFinalGrupoController@imprimir');