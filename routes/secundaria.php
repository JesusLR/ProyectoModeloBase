<?php

/* -------------------------------------------------------------------------- */
/*                           rutas nivel secundaria                           */
/* -------------------------------------------------------------------------- */

Route::get('secundaria_api/departamentos/{id}','Secundaria\SecundariaFuncionesGenericasController@getDepartamentos');
Route::get('secundaria_api/getPlanesEspecificos/{id}','Secundaria\SecundariaFuncionesGenericasController@getPlanesEspecificos');


// Programas
Route::get('secundaria_programa', 'Secundaria\SecundariaProgramasController@index')->name('secundaria.secundaria_programa.index');
Route::get('secundaria_programa/list', 'Secundaria\SecundariaProgramasController@list')->name('secundaria.secundaria_programa.list');
Route::get('secundaria_programa/api/programas/{escuela_id}','Secundaria\SecundariaProgramasController@getProgramas');
Route::get('secundaria_programa/api/programa/{programa_id}','Secundaria\SecundariaProgramasController@getPrograma');
Route::get('secundaria_programa/create', 'Secundaria\SecundariaProgramasController@create')->name('secundaria.secundaria_programa.create');
Route::get('secundaria_programa/{id}/edit', 'Secundaria\SecundariaProgramasController@edit')->name('secundaria.secundaria_programa.edit');
Route::get('secundaria_programa/{id}', 'Secundaria\SecundariaProgramasController@show')->name('secundaria.secundaria_programa.show');
Route::post('secundaria_programa', 'Secundaria\SecundariaProgramasController@store')->name('secundaria.secundaria_programa.store');
Route::put('secundaria_programa/{id}', 'Secundaria\SecundariaProgramasController@update')->name('secundaria.secundaria_programa.update');
Route::delete('secundaria_programa/{id}', 'Secundaria\SecundariaProgramasController@destroy')->name('secundaria.secundaria_programa.destroy');

// planes
Route::get('secundaria_plan', 'Secundaria\SecundariaPlanesController@index')->name('secundaria.secundaria_plan.index');
Route::get('secundaria_plan/list', 'Secundaria\SecundariaPlanesController@list')->name('secundaria.secundaria_plan.list');
Route::get('secundaria_plan/api/planes/{id}','Secundaria\SecundariaPlanesController@getPlanes');
Route::get('secundaria_plan/create', 'Secundaria\SecundariaPlanesController@create')->name('secundaria.secundaria_plan.create');
Route::get('secundaria_plan/{id}/edit', 'Secundaria\SecundariaPlanesController@edit')->name('secundaria.secundaria_plan.edit');
Route::get('secundaria_plan/{id}', 'Secundaria\SecundariaPlanesController@show')->name('secundaria.secundaria_plan.show');
Route::get('secundaria_plan/get_plan/{plan_id}', 'Secundaria\SecundariaPlanesController@getPlan');
Route::get('secundaria_plan/plan/semestre/{id}','Secundaria\SecundariaPlanesController@getSemestre');
Route::post('secundaria_plan', 'Secundaria\SecundariaPlanesController@store')->name('secundaria.secundaria_plan.store');
Route::post('secundaria_plan/cambiarPlanEstado', 'Secundaria\SecundariaPlanesController@cambiarPlanEstado');
Route::put('secundaria_plan/{id}', 'Secundaria\SecundariaPlanesController@update')->name('secundaria.secundaria_plan.update');
Route::delete('secundaria_plan/{id}', 'Secundaria\SecundariaPlanesController@destroy')->name('secundaria.secundaria_plan.destroy');

// Periodos
Route::get('secundaria_periodo', 'Secundaria\SecundariaPeriodosController@index')->name('secundaria.secundaria_periodo.index');
Route::get('secundaria_periodo/list', 'Secundaria\SecundariaPeriodosController@list')->name('secundaria.secundaria_periodo.list');
Route::get('secundaria_periodo/api/periodos/{departamento_id}','Secundaria\SecundariaPeriodosController@getPeriodos');
Route::get('secundaria_periodo/todos/periodos/{departamento_id}','Secundaria\SecundariaPeriodosController@getPeriodosTodos');
Route::get('secundaria_periodo/actual/periodos/{departamento_id}','Secundaria\SecundariaPeriodosController@getPeriodoActual');
Route::get('secundaria_periodo/api/periodo/{id}','Secundaria\SecundariaPeriodosController@getPeriodo');
Route::get('secundaria_periodo/api/periodoPerAnioPago/{id}','Secundaria\SecundariaPeriodosController@getPeriodoPerAnioPago');
Route::get('secundaria_periodo/api/periodo/{departamento_id}/posteriores', 'Secundaria\SecundariaPeriodosController@getPeriodos_afterDate');
Route::get('secundaria_periodo/create', 'Secundaria\SecundariaPeriodosController@create')->name('secundaria.secundaria_periodo.create');
Route::get('secundaria_periodo/{id}/edit', 'Secundaria\SecundariaPeriodosController@edit')->name('secundaria.secundaria_periodo.edit');
Route::get('secundaria_periodo/{id}', 'Secundaria\SecundariaPeriodosController@show')->name('secundaria.secundaria_periodo.show');
Route::post('secundaria_periodo', 'Secundaria\SecundariaPeriodosController@store')->name('secundaria.secundaria_periodo.store');
Route::put('secundaria_periodo/{id}', 'Secundaria\SecundariaPeriodosController@update')->name('secundaria.secundaria_periodo.update');
Route::delete('secundaria_periodo/{id}', 'Secundaria\SecundariaPeriodosController@destroy')->name('secundaria.secundaria_periodo.destroy');

// materias
Route::get('secundaria_materia','Secundaria\SecundariaMateriasController@index')->name('secundaria.secundaria_materia.index');
Route::get('secundaria_materia/list','Secundaria\SecundariaMateriasController@list');
Route::get('secundaria_materia/create','Secundaria\SecundariaMateriasController@create')->name('secundaria.secundaria_materia.create');
Route::get('secundaria_materia/{id}/edit','Secundaria\SecundariaMateriasController@edit')->name('secundaria.secundaria_materia.edit');
Route::get('secundaria_materia/{id}','Secundaria\SecundariaMateriasController@show')->name('secundaria.secundaria_materia.show');
Route::get('secundaria_materia/prerequisitos/{id}','Secundaria\SecundariaMateriasController@prerequisitos');
Route::get('secundaria_materia/materia/prerequisitos/{id}','Secundaria\SecundariaMateriasController@listPreRequisitos');
Route::get('secundaria_materia/eliminarPrerequisito/{id}/{materia_id}','Secundaria\SecundariaMateriasController@eliminarPrerequisito');
Route::get('secundaria_materia/materias/{semestre}/{planId}','Secundaria\SecundariaMateriasController@getMaterias');
Route::get('secundaria_materia/getMateriasByPlan/{plan}/','Secundaria\SecundariaMateriasController@getMateriasByPlan')->name('secundaria.secundaria_materia.getMateriasByPlan');
Route::get('secundaria_materia/acd/{materia_id}/{plan_id}','Secundaria\SecundariaMateriasController@index_acd')->name('secundaria.secundaria_materia.index_acd');
Route::get('secundaria_materia/listACD/{materia_id}/{plan_id}','Secundaria\SecundariaMateriasController@listACD')->name('secundaria.secundaria_materia.listACD');
Route::get('secundaria_materia_acd/create_acd/{materia_id}','Secundaria\SecundariaMateriasController@create_acd')->name('secundaria.secundaria_materia_acd.create_acd');
Route::get('secundaria_materia_acd/{id}/edit_acd','Secundaria\SecundariaMateriasController@edit_acd')->name('secundaria.secundaria_materia.edit_acd');
Route::get('secundaria_materia_acd/{id}','Secundaria\SecundariaMateriasController@show_acd')->name('secundaria.secundaria_materia.show_acd');
Route::post('secundaria_materia','Secundaria\SecundariaMateriasController@store')->name('secundaria.secundaria_materia.store');
Route::post('secundaria_materia_acd','Secundaria\SecundariaMateriasController@store_acd')->name('secundaria.secundaria_materia.store_acd');
Route::post('secundaria_materia/agregarPreRequisitos','Secundaria\SecundariaMateriasController@agregarPreRequisitos')->name('secundaria.secundaria_materia.agregarPreRequisitos');
Route::put('secundaria_materia/{id}','Secundaria\SecundariaMateriasController@update')->name('secundaria.secundaria_materia.update');
Route::put('secundaria_materia_acd/{id}','Secundaria\SecundariaMateriasController@update_acd')->name('secundaria.secundaria_materia_acd.update_acd');
Route::delete('secundaria_materia/{id}','Secundaria\SecundariaMateriasController@destroy');
Route::delete('secundaria_materia_acd/{id}','Secundaria\SecundariaMateriasController@destroy_acd')->name('secundaria.secundaria_materia_acd.destroy_acd');


// CGT
Route::get('secundaria_cgt','Secundaria\SecundariaCGTController@index')->name('secundaria.secundaria_cgt.index');
Route::get('secundaria_cgt/list','Secundaria\SecundariaCGTController@list');
Route::get('secundaria_cgt/create','Secundaria\SecundariaCGTController@create')->name('secundaria.secundaria_cgt.create');
Route::get('secundaria_cgt/{id}/edit','Secundaria\SecundariaCGTController@edit')->name('secundaria.secundaria_cgt.edit');
Route::get('secundaria_cgt/{id}','Secundaria\SecundariaCGTController@show')->name('secundaria.secundaria_cgt.show');
Route::get('secundaria_cgt/apiss/cgts/{plan_id}/{periodo_id}/{semestre}','Secundaria\SecundariaCGTController@getCgtsSemestre');
Route::get('secundaria_cgt/api/cgts/{plan_id}/{periodo_id}','Secundaria\SecundariaCGTController@getCgts');
Route::get('secundaria_cgt/api/cgts_sin_N/{plan_id}/{periodo_id}','Secundaria\SecundariaCGTController@getCgtsSinN');
Route::post('secundaria_cgt','Secundaria\SecundariaCGTController@store')->name('secundaria.secundaria_cgt.store');
Route::put('secundaria_cgt/{id}','Secundaria\SecundariaCGTController@update')->name('secundaria.secundaria_cgt.update');
Route::delete('secundaria_cgt/{id}','Secundaria\SecundariaCGTController@destroy')->name('secundaria.secundaria_cgt.destroy');

// Cambiar matrículas de alumnos (de un cgt).
Route::get('secundaria_cambiar_matriculas_cgt/{cgt_id}', 'Secundaria\SecundariaCambiarMatriculasController@lista_alumnos');
Route::get('secundaria_cambiar_matriculas_cgt/{cgt_id}/buscar_alumno/{alumno_id}', 'Secundaria\SecundariaCambiarMatriculasController@buscarAlumnoEnCgt');
Route::post('secundaria_cambiar_matriculas_cgt/{cgt_id}/actualizar/{alumno_id}', 'Secundaria\SecundariaCambiarMatriculasController@cambiarMatricula');
Route::post('secundaria_cambiar_matriculas_cgt/{cgt_id}/actualizar_lista', 'Secundaria\SecundariaCambiarMatriculasController@cambiarMultiplesMatriculas');

// Porcentaje
Route::get('secundaria_porcentaje','Secundaria\SecundariaPorcentajeController@index')->name('secundaria.secundaria_porcentaje.index');
Route::get('secundaria_porcentaje/list','Secundaria\SecundariaPorcentajeController@list');
Route::get('secundaria_porcentaje/create','Secundaria\SecundariaPorcentajeController@create')->name('secundaria.secundaria_porcentaje.create');
Route::get('secundaria_porcentaje/{id}/edit','Secundaria\SecundariaPorcentajeController@edit')->name('secundaria.secundaria_porcentaje.edit');
Route::get('secundaria_porcentaje/{id}','Secundaria\SecundariaPorcentajeController@show')->name('secundaria.secundaria_porcentaje.show');
Route::post('secundaria_porcentaje','Secundaria\SecundariaPorcentajeController@store')->name('secundaria.secundaria_porcentaje.store');
Route::put('secundaria_porcentaje/{id}','Secundaria\SecundariaPorcentajeController@update')->name('secundaria.secundaria_porcentaje.update');
Route::delete('secundaria_porcentaje/{id}','Secundaria\SecundariaPorcentajeController@destroy')->name('secundaria.secundaria_porcentaje.destroy');

//Migrar Inscritos ACD
Route::get('secundaria_migrar_inscritos_acd','Secundaria\SecundariaMigrarInscritosACDController@index')->name('secundaria.secundaria_migrar_inscritos_acd.index');
Route::get('secundaria_migrar_inscritos_acd/api/getDepartamentosPorUbiClave/{id}','Secundaria\SecundariaMigrarInscritosACDController@getDepartamentosPorUbiClave');
Route::get('secundaria_migrar_inscritos_acd/api/ObtenerGrupoOrigen/{plan_id}/{periodo_id}/{gpoGrado}','Secundaria\SecundariaMigrarInscritosACDController@ObtenerGrupoOrigen');
Route::get('secundaria_migrar_inscritos_acd/api/ObtenerPeriodoSiguiente/{periodo_id}','Secundaria\SecundariaMigrarInscritosACDController@ObtenerPeriodoSiguiente');
Route::get('secundaria_migrar_inscritos_acd/api/ObtenerGrupoDestino/{plan_id}/{periodo_id}/{gpoGrado}','Secundaria\SecundariaMigrarInscritosACDController@ObtenerGrupoDestino');
Route::post('secundaria_migrar_inscritos_acd','Secundaria\SecundariaMigrarInscritosACDController@store')->name('secundaria.secundaria_migrar_inscritos_acd.store');



/* ---------------------------- Módulo de Alumnos --------------------------- */
Route::get('/secundaria_alumno', 'Secundaria\SecundariaAlumnosController@index')->name('secundaria.secundaria_alumno.index');
Route::get('secundaria_alumno/list','Secundaria\SecundariaAlumnosController@list')->name('secundaria.secundaria_alumno.list');
Route::get('secundaria_empleado/cambio-estado', 'Secundaria\SecundariaEmpleadoController@cambioEstado')->name('secundaria_empleado.cambio-estado');
Route::get('api/secundaria_empleado/{escuela?}','Secundaria\SecundariaEmpleadoController@listEmpleados');
Route::get('secundaria_alumno/create','Secundaria\SecundariaAlumnosController@create')->name('secundaria.secundaria_alumno.create');
Route::post('secundaria_alumno','Secundaria\SecundariaAlumnosController@store')->name('secundaria.secundaria_alumno.store');
Route::get('secundaria_alumno/verificar_persona', 'Secundaria\SecundariaAlumnosController@verificarExistenciaPersona')->name('secundaria.secundaria_alumno.verificar_persona');
Route::get('secundaria_alumno/{id}/edit','Secundaria\SecundariaAlumnosController@edit')->name('secundaria.secundaria_alumno.edit');
Route::get('secundaria_alumno/{id}','Secundaria\SecundariaAlumnosController@show')->name('secundaria.secundaria_alumno.show');
Route::get('secundaria_alumno/ultimo_curso/{alumno_id}', 'Secundaria\SecundariaAlumnosController@ultimoCurso')->name('secundaria/secundaria_alumno/ultimo_curso/{alumno_id}');
Route::post('secundaria_alumno/api/getMultipleAlumnosByFilter','Secundaria\SecundariaAlumnosController@getMultipleAlumnosByFilter');
Route::get('secundaria_alumno/listHistorialPagosAluclave/{aluClave}','Secundaria\SecundariaAlumnosController@listHistorialPagosAluclave')->name('secundaria.secundaria_alumno.listHistorialPagosAluclave');
Route::get('secundaria_alumno/conceptosBaja','Secundaria\SecundariaAlumnosController@conceptosBaja')->name('secundaria.secundaria_alumno.conceptosBaja');
Route::get('secundaria_alumno/cambiar_matricula/{alumnoId}','Secundaria\SecundariaAlumnosController@cambiarMatricula')->name("preescolar_alumnos.cambiarMatricula");
Route::get('secundaria_alumno/alumnoById/{alumnoId}','Secundaria\SecundariaAlumnosController@getAlumnoById');
Route::post('secundaria_alumno/cambiarEstatusAlumno','Secundaria\SecundariaAlumnosController@cambiarEstatusAlumno')->name("secundaria.secundaria_alumno.cambiarEstatusAlumno");
Route::post('secundaria_alumno/cambiar_matricula/edit','Secundaria\SecundariaAlumnosController@postCambiarMatricula')->name("secundaria.secundaria_alumno.cambiarMatricula");
Route::post('secundaria_alumno/rehabilitar_alumno/{alumno_id}','Secundaria\SecundariaAlumnosController@rehabilitarAlumno')->name('Secundaria\SecundariaAlumnosController/rehabilitar_alumno/{alumno_id}');
Route::post('secundaria_alumno/registrar_empleado/{empleado_id}', 'Secundaria\SecundariaAlumnosController@empleado_crearAlumno')->name('Secundaria\SecundariaAlumnosController/registrar_empleado/{empleado_id}');
Route::post('secundaria_alumno/tutores/nuevo_tutor','Secundaria\SecundariaAlumnosController@crearTutor')->name('secundaria.secundaria_alumno.tutores.nuevo_tutor');
Route::post('secundaria_cambiar_status_empleado/actualizar_lista', 'Secundaria\SecundariaEmpleadoController@cambiarMultiplesStatusEmpleados');
Route::put('secundaria_alumno/{id}','Secundaria\SecundariaAlumnosController@update')->name('secundaria.secundaria_alumno.update');
Route::delete('secundaria_alumno/{id}','Secundaria\SecundariaAlumnosController@destroy')->name('secundaria.secundaria_alumno.destroy');

Route::get('secundaria_alumno/change_password/{alumnoId}','Secundaria\SecundariaAlumnosController@changePassword');
Route::post('secundaria_alumno/changed_password/{alumnoId}','Secundaria\SecundariaAlumnosController@changePasswordUpdate');


// Menú secundaria
/* ------------------------ Módulo entrevista inicial ----------------------- */
Route::get('secundaria_entrevista_inicial', 'Secundaria\SecundariaAlumnosEntrevistaInicialController@create')->name('secundaria_entrevista_inicial.create');
Route::post('secundaria_entrevista_inicial', 'Secundaria\SecundariaAlumnosEntrevistaInicialController@store')->name('secundaria_entrevista_inicial.store');



/* ------------------------------ Módulo cursos ----------------------------- */
//Route::get('/home', 'Secundaria\SecundariaCursoController@index')->name('Secundaria_curso.index');
Route::get('/secundaria_curso', 'Secundaria\SecundariaCursoController@index')->name('secundaria.secundaria_curso.index');
Route::get('secundaria_curso/{curso_id}/constancia_beca/','Secundaria\SecundariaCursoController@constanciaBeca')->name('secundaria.secundaria_curso.constanciaBeca');
Route::get('secundaria_curso/listGruposAlumno/{aluClave}','Secundaria\SecundariaCursoController@listGruposAlumno');
Route::get('secundaria_curso/grupos_alumno/{id}','Secundaria\SecundariaCursoController@viewCalificaciones');
Route::get('/secundaria_curso/create', 'Secundaria\SecundariaCursoController@create')->name('secundaria.secundaria_curso.create');
Route::get('secundaria_curso/list','Secundaria\SecundariaCursoController@list')->name('secundaria.secundaria_curso.list');
Route::get('secundaria_curso/conceptosBaja','Secundaria\SecundariaCursoController@conceptosBaja')->name('secundaria.secundaria_curso.conceptosBaja');
Route::get('secundaria_curso/{id}','Secundaria\SecundariaCursoController@show')->name('secundaria.secundaria_curso.show');
Route::get('secundaria_curso/{id}/edit','Secundaria\SecundariaCursoController@edit')->name('secundaria.secundaria_curso.edit');
Route::get('secundaria_curso/api/cursos/{cgt_id}','Secundaria\SecundariaCursoController@getCursos');
Route::put('secundaria_curso/{id}','Secundaria\SecundariaCursoController@update')->name('secundaria.secundaria_curso.update');
Route::post('/secundaria_curso', 'Secundaria\SecundariaCursoController@store')->name('secundaria.secundaria_curso.store');
Route::get('secundaria_curso/listHistorialPagos/{curso_id}','Secundaria\SecundariaCursoController@listHistorialPagos')->name('secundaria.secundaria_curso.listHistorialPagos');
Route::get('secundaria_curso/api/curso/{curso_id}','Secundaria\SecundariaCursoController@listPreinscritoDetalle')->name('secundaria_curso/api/listPreinscritoDetalle');
Route::get('secundaria_curso/{curso_id}/historial_calificaciones_alumno/','Secundaria\SecundariaCursoController@historialCalificacionesAlumno')->name('secundaria.secundaria_curso.historialCalificacionesAlumno');
Route::get('secundaria_curso/api/curso/{curso_id}/listHistorialCalifAlumnos/','Secundaria\SecundariaCursoController@listHistorialCalifAlumnos')->name('secundaria.secundaria_curso.listHistorialCalifAlumnos');
Route::get('secundaria_curso/api/curso/{curso}/verificar_materias_cargadas', 'Secundaria\SecundariaCursoController@verificar_materias_cargadas');
Route::get('secundaria_curso/api/curso/infoBaja/{curso_id}','Secundaria\SecundariaCursoController@infoBaja')->name('secundaria.secundaria_curso.api.infoBaja');
Route::get('secundaria_curso/listPosiblesHermanos/{curso_id}','Secundaria\SecundariaCursoController@listPosiblesHermanos')->name('secundaria.secundaria_curso.listPosiblesHermanos');
Route::post('secundaria_curso/bajaCurso','Secundaria\SecundariaCursoController@bajaCurso')->name('secundaria.secundaria_curso.bajaCurso');
Route::get('secundaria_curso/observaciones/{curso_id}/', 'Secundaria\SecundariaCursoController@observaciones')->name('secundaria.secundaria_curso.observaciones');
Route::post('secundaria_curso/storeObservaciones','Secundaria\SecundariaCursoController@storeObservaciones')->name('secundaria.secundaria_curso.storeObservacionesCurso');
Route::post('secundaria_curso/curso/altaCurso','Secundaria\SecundariaCursoController@altaCurso')->name('secundaria.secundaria_curso.altaCurso');
Route::get('secundaria_curso/curso_archivo_observaciones/{curso_id}','Secundaria\SecundariaCursoController@cursoArchivoObservaciones')->name('secundaria.secundaria_curso.curso_archivo_observaciones');
Route::get('secundaria_curso/crearReferencia/{curso_id}/{tienePagoCeneval}','Secundaria\SecundariaCursoController@crearReferenciaBBVA')->name('secundaria.secundaria_curso.crearReferencia');
Route::get('secundaria_curso/crearReferenciaHSBC/{curso_id}/{tienePagoCeneval}','Secundaria\SecundariaCursoController@crearReferenciaHSBC')->name('secundaria.secundaria_curso.crearReferenciaHSBC');
Route::get('secundaria_curso/listMateriasFaltantes/{curso_id}/','Secundaria\SecundariaCursoController@listMateriasFaltantes')->name('secundaria.secundaria_curso.listMateriasFaltantes');
Route::get('secundaria_curso/getDepartamentosListaCompleta/{ubicacion_id}/','Secundaria\SecundariaCursoController@getDepartamentosListaCompleta')->name('secundaria.secundaria_curso.getDepartamentosListaCompleta');
Route::get('secundaria_curso/grupos_alumno/ajustar_calificacion/{id}/{aluClave}/{curso_id}','Secundaria\SecundariaCursoController@ajustar_calificacion');
Route::get('secundaria_curso/getCalificacionUnicoAlumno/{id}/{grupoId}/{aluClave}','Secundaria\SecundariaCursoController@getCalificacionUnicoAlumno');
Route::patch('secundaria_curso/getCalificacionUnicoAlumno/{id}','Secundaria\SecundariaCursoController@ajustar_calificacion_update')->name('secundaria.secundaria_curso.ajustar_calificacion_update');

Route::get('secundaria_curso_images/{filename}/{folder}/{campus}', function ($filename, $folder, $campus)
{
    //$path = app_path('upload') . '/' . $filename;

    $path = storage_path(env("SECUNDARIA_IMAGEN_CURSO_PATH") . $folder ."/".$campus."/".$filename);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::delete('secundaria_curso/delete/{id}','Secundaria\SecundariaCursoController@destroy');


/* ----------------------- Módulo de historia clinica ----------------------- */
Route::get('secundaria_historia_clinica', 'Secundaria\SecundariaAlumnosHistoriaClinicaController@index')->name('secundaria.secundaria_historia_clinica.index');
Route::get('secundaria_historia_clinica/list', 'Secundaria\SecundariaAlumnosHistoriaClinicaController@list')->name('secundaria.secundaria_historia_clinica.list');
Route::get('secundaria_historia_clinica/api/estados/{id}','Secundaria\SecundariaAlumnosHistoriaClinicaController@getEstados');
Route::get('secundaria_historia_clinica/api/municipios/{id}','Secundaria\SecundariaAlumnosHistoriaClinicaController@getMunicipios');
Route::get('secundaria_historia_clinica/create', 'Secundaria\SecundariaAlumnosHistoriaClinicaController@create')->name('secundaria.secundaria_historia_clinica.create');
Route::get('secundaria_historia_clinica/{id}', 'Secundaria\SecundariaAlumnosHistoriaClinicaController@show')->name('secundaria.secundaria_historia_clinica.show');
Route::get('secundaria_historia_clinica/{id}/edit', 'Secundaria\SecundariaAlumnosHistoriaClinicaController@edit')->name('secundaria.secundaria_historia_clinica.edit');
Route::post('secundaria_historia_clinica/', 'Secundaria\SecundariaAlumnosHistoriaClinicaController@store')->name('secundaria.secundaria_historia_clinica.store');
Route::put('secundaria_historia_clinica/{historia}', 'Secundaria\SecundariaAlumnosHistoriaClinicaController@update')->name('secundaria.secundaria_historia_clinica.update');


/* --------------------------- Modulo asignar CGT --------------------------- */
Route::get('secundaria_asignar_cgt/create', 'Secundaria\SecundariaAsignarCGTController@edit')->name('secundaria.secundaria_asignar_cgt.edit');
Route::get('secundaria_asignar_cgt/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Secundaria\SecundariaAsignarCGTController@getGradoGrupo');
Route::get('secundaria_asignar_cgt/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Secundaria\SecundariaAsignarCGTController@getAlumnosGrado');
Route::get('secundaria_asignar_cgt/getSecundariaInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Secundaria\SecundariaAsignarCGTController@getSecundariaInscritoCursos');
Route::post('secundaria_asignar_cgt/create', 'Secundaria\SecundariaAsignarCGTController@update')->name('secundaria.secundaria_asignar_cgt.update');


/* --------------------------- Modulo Cambiar CGT --------------------------- */
Route::get('secundaria_cambiar_cgt/create', 'Secundaria\SecundariaCambiarCGTController@edit')->name('secundaria.secundaria_cambiar_cgt.edit');
Route::get('secundaria_cambiar_cgt/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Secundaria\SecundariaCambiarCGTController@getGradoGrupo');
Route::get('secundaria_cambiar_cgt/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Secundaria\SecundariaCambiarCGTController@getAlumnosGrado');
Route::get('secundaria_cambiar_cgt/getSecundariaInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Secundaria\SecundariaCambiarCGTController@getSecundariaInscritoCursos');
Route::post('secundaria_cambiar_cgt/create', 'Secundaria\SecundariaCambiarCGTController@update')->name('secundaria.secundaria_cambiar_cgt.update');

//Cargar Materias a inscrito
Route::get('secundaria_materias_inscrito', 'Secundaria\SecundariaMateriasInscritoDController@index')->name('secundaria.secundaria_materias_inscrito.index');
Route::get('secundaria_materias_inscrito/ultimo_curso/{alumno_id}', 'Secundaria\SecundariaMateriasInscritoDController@ultimoCurso');
Route::post('secundaria_materias_inscrito/api/getMultipleAlumnosByFilter','Secundaria\SecundariaMateriasInscritoDController@getMultipleAlumnosByFilter');
Route::post('secundaria_materias_inscrito', 'Secundaria\SecundariaMateriasInscritoDController@store')->name('secundaria.secundaria_materias_inscrito.store');


// CGT Materias
Route::get('secundaria_cgt_materias','Secundaria\SecundariaCGTMateriasController@index')->name('secundaria.secundaria_cgt_materias.index');
Route::get('secundaria_cgt_materias/obtenerMaterias/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Secundaria\SecundariaCGTMateriasController@obtenerMaterias');
Route::post('secundaria_cgt_materias','Secundaria\SecundariaCGTMateriasController@store')->name('secundaria.secundaria_cgt_materias.store');


//Asignar docente CGT
Route::get('secundaria_asignar_docente','Secundaria\SecundariaAsignarDocenteCGTController@index')->name('secundaria.secundaria_asignar_docente.index');
Route::get('secundaria_asignar_docente/obtenerGrupos/{periodo_id}/{plan_id}', 'Secundaria\SecundariaAsignarDocenteCGTController@obtenerGrupos');
Route::post('secundaria_asignar_docente','Secundaria\SecundariaAsignarDocenteCGTController@store')->name('secundaria.secundaria_asignar_docente.store');


/* ---------------------------- Módulo de grupos ---------------------------- */
Route::get('secundaria_grupo', 'Secundaria\SecundariaGrupoController@index')->name('secundaria.secundaria_grupo.index');
Route::get('secundaria_grupo/list', 'Secundaria\SecundariaGrupoController@list')->name('secundaria.secundaria_grupo.list');
Route::get('secundaria_grupo/create', 'Secundaria\SecundariaGrupoController@create')->name('secundaria.secundaria_grupo.create');
Route::post('secundaria_grupo', 'Secundaria\SecundariaGrupoController@store')->name('secundaria.secundaria_grupo.store');
Route::get('secundaria_grupo/{id}/edit', 'Secundaria\SecundariaGrupoController@edit')->name('secundaria.secundaria_grupo.edit');
Route::put('secundaria_grupo/{id}', 'Secundaria\SecundariaGrupoController@update')->name('secundaria.secundaria_grupo.update');
Route::get('secundaria_grupo/{id}', 'Secundaria\SecundariaGrupoController@show')->name('secundaria.secundaria_grupo.show');
Route::get('secundaria_grupo/api/grupoEquivalente/{periodo_id}','Secundaria\SecundariaGrupoController@listEquivalente')->name('secundaria_grupo/api/grupoEquivalente');
Route::get('secundaria_grupo/materias/{semestre}/{planId}','Secundaria\SecundariaGrupoController@getSecundariaMaterias');
Route::get('secundaria_grupo/materiaComplementaria/{secundaria_materia_id}/{plan_id}/{periodo_id}/{grado}','Secundaria\SecundariaGrupoController@materiaComplementaria');
Route::get('secundaria_grupo/api/departamentos/{id}','Secundaria\SecundariaGrupoController@getDepartamentos');
Route::get('secundaria_grupo/api/escuelas/{id}/{otro?}','Secundaria\SecundariaGrupoController@getEscuelas');
Route::get('secundaria_grupo/{id}/evidencia','Secundaria\SecundariaGrupoController@evidenciaTable')->name('secundaria.secundaria_grupo.evidenciaTable');
Route::get('secundaria_grupo/getGrupos/{id}','Secundaria\SecundariaGrupoController@getGrupos');
Route::get('secundaria_grupo/getMaterias/{id}','Secundaria\SecundariaGrupoController@getMaterias');
Route::get('secundaria_grupo/getMesEvidencias/{id}','Secundaria\SecundariaGrupoController@getMesEvidencias'); //Get evidencias mes
Route::post('secundaria_grupo/evidencias','Secundaria\SecundariaGrupoController@guardar_actualizar_evidencia')->name('secundaria.secundaria_grupo.guardar_actualizar_evidencia');
Route::get('secundaria_calificacion/getMeses/{mes}','Secundaria\SecundariaGrupoController@getMeses');
Route::get('secundaria_calificacion/getNumeroEvaluacion/{mes}','Secundaria\SecundariaGrupoController@getNumeroEvaluacion');
Route::get('secundaria_calificacion/api/getEvidencias/{id_grupo}/{id}','Secundaria\SecundariaGrupoController@getEvidencias');
Route::delete('secundaria_grupo/{id}', 'Secundaria\SecundariaGrupoController@destroy')->name('secundaria.secundaria_grupo.destroy');


//Cambio de programa
Route::get('secundaria_cambio_programa','Secundaria\SecundariaCambioDeProgramaController@index')->name('secundaria.secundaria_cambio_programa.index');
Route::get('secundaria_cambio_programa/getAlumnoPrograma/api/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}/{aluClave}','Secundaria\SecundariaCambioDeProgramaController@getAlumnoPrograma');
Route::get('secundaria_cambio_programa/getANombrePrograma/api/{programa_id}','Secundaria\SecundariaCambioDeProgramaController@getANombrePrograma');
Route::post('secundaria_cambio_programa/store','Secundaria\SecundariaCambioDeProgramaController@store')->name('secundaria.secundaria_cambio_programa.store');

// observaciones boleta
Route::get('secundaria_obs_boleta','Secundaria\SecundariaObservacionesBoletaController@index')->name('secundaria.secundaria_obs_boleta.index');
Route::get('secundaria_obs_boleta/obtenerObsBoleta/{plan_id}/{periodo_id}/{cgt_id}/{mes}','Secundaria\SecundariaObservacionesBoletaController@obtenerObsBoleta');
Route::post('secundaria_obs_boleta/','Secundaria\SecundariaObservacionesBoletaController@guardar')->name('secundaria.secundaria_obs_boleta.guardar');


// Empleados
Route::get('/secundaria_empleado', 'Secundaria\SecundariaEmpleadoController@index')->name('secundaria.secundaria_empleado.index');
Route::get('/secundaria_empleado/create', 'Secundaria\SecundariaEmpleadoController@create')->name('secundaria.secundaria_empleado.create');
Route::get('/secundaria_empleado/list', 'Secundaria\SecundariaEmpleadoController@list')->name('secundaria.secundaria_empleado.list');
Route::get('secundaria_empleado/verificar_persona', 'Secundaria\SecundariaEmpleadoController@verificarExistenciaPersona');
Route::get('secundaria_empleado/{id}','Secundaria\SecundariaEmpleadoController@show')->name('secundaria.secundaria_empleado.show');
Route::get('secundaria_empleado/{id}/edit','Secundaria\SecundariaEmpleadoController@edit')->name('secundaria.secundaria_empleado.edit');
Route::get('secundaria_empleado/verificar_delete/{empleado_id}', 'Secundaria\SecundariaEmpleadoController@puedeSerEliminado')->name('secundaria.secundaria_empleado/verificar_delete/{empleado_id}');

Route::put('secundaria_empleado/{id}','Secundaria\SecundariaEmpleadoController@update')->name('secundaria.secundaria_empleado.update');
Route::post('secundaria_empleado/reactivar_empleado/{empleado_id}','Secundaria\SecundariaEmpleadoController@reactivarEmpleado')->name('secundaria.secundaria_empleado/reactivar_empleado/{empleado_id}');
Route::post('secundaria_empleado/registrar_alumno/{alumno_id}', 'Secundaria\SecundariaEmpleadoController@alumno_crearEmpleado')->name('secundaria.secundaria_empleado/registrar_alumno/{alumno_id}');
Route::post('secundaria_empleado','Secundaria\SecundariaEmpleadoController@store')->name('secundaria.secundaria_empleado.store');
Route::post('secundaria_empleado/darBaja/{empleado_id}', 'Secundaria\SecundariaEmpleadoController@darDeBaja')->name('secundaria.secundaria_empleado/darBaja/{empleado_id}');
Route::delete('secundaria_empleado/{id}','Secundaria\SecundariaEmpleadoController@destroy')->name('secundaria.secundaria_empleado.destroy');

/* -------------------------- Módulo de calendario -------------------------- */
Route::resource('secundaria_calendario', 'Secundaria\SecundariaAgendaController');
Route::get('/secundaria_calendario', 'Secundaria\SecundariaAgendaController@index')->name('secundaria.secundaria_calendario.index');
Route::get('/secundaria_calendario/show', 'Secundaria\SecundariaAgendaController@show')->name('secundaria.secundaria_calendario.show');

/* --------------------------- Módulo de inscritos -------------------------- */
Route::get('secundaria_inscritos/list/{grupo_id}','Secundaria\SecundariaInscritosController@list')->name('api/secundaria_inscritos/{grupo_id}');
Route::get('secundaria_inscritos/{grupo_id}', 'Secundaria\SecundariaInscritosController@index')->name('secundaria.secundaria_inscritos/{grupo_id}');
Route::get('secundaria_inscritos/calificaciones/primerreporte/{inscrito_id}/{persona_id}/{grado}/{grupo}', 'Secundaria\SecundariaCalificacionesController@reporteTrimestre');
Route::get('secundaria_inscritos/pase_lista/{grupo_id}', 'Secundaria\SecundariaInscritosController@pase_de_lista')->name('secundaria.secundaria_inscritos/pase_lista/{grupo_id}');
Route::get('secundaria_inscritos/obtenerAlumnosPaseLista/{grupo_id}/{fecha}', 'Secundaria\SecundariaInscritosController@obtenerAlumnosPaseLista');
Route::post('secundaria_inscritos/asistencia_alumnos/', 'Secundaria\SecundariaInscritosController@asistencia_alumnos')->name('secundaria.secundaria_inscritos.asistencia_alumnos');
Route::post('secundaria_inscritos/pase_lista/', 'Secundaria\SecundariaInscritosController@guardarPaseLista')->name('secundaria.secundaria_inscritos.guardarPaseLista');


/* ------------------------ Módulo de calificaciones ------------------------ */
Route::resource('secundaria_calificacion','Secundaria\SecundariaCalificacionesController');
Route::get('secundaria_calificacion/{inscrito_id}/{grupo_id}', 'Secundaria\SecundariaCalificacionesController@index');
Route::get('secundaria_calificacion/create', 'Secundaria\SecundariaCalificacionesController@create')->name('secundaria.secundaria_calificacion.create');
Route::get('secundaria_calificacion/api/getAlumnos/{id}','Secundaria\SecundariaCalificacionesController@getAlumnos');
Route::get('secundaria_calificacion/api/getGrupos/{id}','Secundaria\SecundariaCalificacionesController@getGrupos');
Route::get('secundaria_calificacion/api/getMaterias2/{id}','Secundaria\SecundariaCalificacionesController@getMaterias2');
Route::get('secundaria_calificacion/grupo/{id}/edit','Secundaria\SecundariaCalificacionesController@edit_calificacion')->name('secundaria.secundaria_grupo.calificaciones.edit_calificacion');
Route::get('secundaria_calificacion/grupo/{id}/recuperativos','Secundaria\SecundariaCalificacionesController@recuperativos')->name('secundaria.secundaria_grupo.calificaciones.recuperativos');
Route::get('secundaria_calificacion/getCalificacionesAlumnos/{id}/{grupoId}','Secundaria\SecundariaCalificacionesController@getCalificacionesAlumnos');
Route::post('secundaria_calificacion/guardarCalificacion', 'Secundaria\SecundariaCalificacionesController@guardarCalificacion')->name('secundaria.secundaria_calificacion.guardarCalificacion');
Route::post('secundaria_calificacion/guardarCalificacionRecuperativo', 'Secundaria\SecundariaCalificacionesController@guardarCalificacionRecuperativo')->name('secundaria.secundaria_calificacion.guardarCalificacionRecuperativo');
Route::post('secundaria_calificacion/guardarCalificacionExtraordinario', 'Secundaria\SecundariaCalificacionesController@guardarCalificacionExtraordinario')->name('secundaria.secundaria_calificacion.guardarCalificacionExtraordinario');

Route::put('secundaria_calificacion/calificaciones/{id}','Secundaria\SecundariaCalificacionesController@update_calificacion')->name('secundaria.secundaria_calificacion.calificaciones.update_calificacion');
Route::get('secundaria/boletaAlumnoCurso/{curso_id}','Secundaria\SecundariaCalificacionesController@boletadesdecurso')->name('secundaria.boletadesdecurso');


/* ------------------------ Módulo de asignar grupos ------------------------ */
Route::get('/secundaria_asignar_grupo', 'Secundaria\SecundariaAsignarGrupoController@index')->name('secundaria.secundaria_asignar_grupo.index');
Route::get('/secundaria_asignar_grupo/list', 'Secundaria\SecundariaAsignarGrupoController@list')->name('secundaria.secundaria_asignar_grupo.list');
Route::get('/secundaria_asignar_grupo/create', 'Secundaria\SecundariaAsignarGrupoController@create')->name('secundaria.secundaria_asignar_grupo.create');
Route::post('/secundaria_asignar_grupo', 'Secundaria\SecundariaAsignarGrupoController@store')->name('secundaria.secundaria_asignar_grupo.store');
Route::get('secundaria_asignar_grupo/{id}/edit', 'Secundaria\SecundariaAsignarGrupoController@edit')->name('secundaria.secundaria_asignar_grupo.edit');
Route::put('secundaria_asignar_grupo/{id}', 'Secundaria\SecundariaAsignarGrupoController@update')->name('secundaria.secundaria_asignar_grupo.update');
Route::get('secundaria_asignar_grupo/{id}', 'Secundaria\SecundariaAsignarGrupoController@show')->name('secundaria.secundaria_asignar_grupo.show');
Route::delete('secundaria_asignar_grupo/{id}', 'Secundaria\SecundariaAsignarGrupoController@destroy')->name('secundaria.secundaria_asignar_grupo.destroy');
Route::get('secundaria_asignar_grupo/cambiar_grupo/{inscritoId}', 'Secundaria\SecundariaAsignarGrupoController@cambiarGrupo')->name('secundaria.secundaria_asignar_grupo.cambiar_grupo');
Route::post('secundaria_asignar_grupo/postCambiarGrupo', 'Secundaria\SecundariaAsignarGrupoController@postCambiarGrupo')->name('secundaria.secundaria_asignar_grupo.postCambiarGrupo');
// Route::get('api/grupos/{curso_id}','Secundaria\SecundariaAsignarGrupoController@getGrupos');
Route::get('secundaria_asignar_grupo/obtener_grupos/{curso_id}','Secundaria\SecundariaAsignarGrupoController@ObtenerGrupos');
Route::get('secundaria_asignar_grupo/getDepartamentos/{id}','Secundaria\SecundariaAsignarGrupoController@getDepartamentos');
Route::get('secundaria_asignar_grupo/getEscuelas/{id}/{otro?}','Secundaria\SecundariaAsignarGrupoController@getEscuelas');


//APLICAR PAGOS MANUALES
Route::get('secundaria/pagos/aplicar_pagos','Secundaria\SecundariaAplicarPagosController@index');
Route::get('secundaria/api/pagos/listadopagos','Secundaria\SecundariaAplicarPagosController@list');
Route::get('secundaria/pagos/aplicar_pagos/create','Secundaria\SecundariaAplicarPagosController@create');
Route::get('secundaria/pagos/aplicar_pagos/edit/{id}','Secundaria\SecundariaAplicarPagosController@edit');
Route::post('secundaria/pagos/aplicar_pagos/update','Secundaria\SecundariaAplicarPagosController@update')->name("secundariaAplicarPagos.update");
Route::post('secundaria/pagos/aplicar_pagos/existeAlumnoByClavePago','Secundaria\SecundariaAplicarPagosController@existeAlumnoByClavePago')->name("secundariaAplicarPagos.existeAlumnoByClavePago");
Route::post('secundaria/pagos/aplicar_pagos/store','Secundaria\SecundariaAplicarPagosController@store')->name("secundariaAplicarPagos.store");
Route::delete('secundaria/pagos/aplicar_pagos/delete/{id}','Secundaria\SecundariaAplicarPagosController@destroy')->name("secundariaAplicarPagos.destroy");
Route::get('secundaria/pagos/aplicar_pagos/detalle/{pagoId}','Secundaria\SecundariaAplicarPagosController@detalle')->name("secundariaAplicarPagos.detalle");
Route::post('secundaria/api/pagos/verificarExistePago/','Secundaria\SecundariaAplicarPagosController@verificarExistePago')->name("secundariaAplicarPagos.verificarExistePago");
Route::get('secundaria/api/aplicar_pagos/buscar_inscripciones_educacion_continua/{pagClaveAlu}', 'Secundaria\SecundariaAplicarPagosController@getInscripcionesEducacionContinua');

// Cambiar contraseña docente
Route::get('secundaria_cambiar_contrasenia', 'Secundaria\SecundariaCambiarContraseniaController@index')->name('secundaria.secundaria_cambiar_contrasenia.index');
Route::get('secundaria_cambiar_contrasenia/list', 'Secundaria\SecundariaCambiarContraseniaController@list');
Route::get('secundaria_cambiar_contrasenia/getEmpleadoCorreo/{id}', 'Secundaria\SecundariaCambiarContraseniaController@getEmpleadoCorreo');
Route::get('secundaria_cambiar_contrasenia/create', 'Secundaria\SecundariaCambiarContraseniaController@create')->name('secundaria.secundaria_cambiar_contrasenia.create');
Route::get('secundaria_cambiar_contrasenia/{id}/edit', 'Secundaria\SecundariaCambiarContraseniaController@edit');
Route::get('secundaria_cambiar_contrasenia/{id}', 'Secundaria\SecundariaCambiarContraseniaController@show');
Route::post('secundaria_cambiar_contrasenia', 'Secundaria\SecundariaCambiarContraseniaController@store')->name('secundaria.secundaria_cambiar_contrasenia.store');
Route::put('secundaria_cambiar_contrasenia/{id}', 'Secundaria\SecundariaCambiarContraseniaController@update')->name('secundaria.secundaria_cambiar_contrasenia.update');


//Resumen academico
Route::get('secundaria_resumen_academico', 'Secundaria\SecundariaResumenAcademico@index')->name('secundaria.secundaria_resumen_academico.index');
Route::get('secundaria_resumen_academico/list', 'Secundaria\SecundariaResumenAcademico@list');
Route::get('secundaria_resumen_academico/{id}', 'Secundaria\SecundariaResumenAcademico@show');


//Fecha publicacion Docente
Route::get('secundaria_fecha_publicacion_calificacion_docente','Secundaria\SecundariaFechaPublicacionDocenteController@index')->name('secundaria.secundaria_fecha_publicacion_calificacion_docente.index');
Route::get('secundaria_fecha_publicacion_calificacion_docente/list','Secundaria\SecundariaFechaPublicacionDocenteController@list');
Route::get('secundaria_fecha_publicacion_calificacion_docente/create','Secundaria\SecundariaFechaPublicacionDocenteController@create')->name('secundaria.secundaria_fecha_publicacion_calificacion_docente.create');
Route::get('secundaria_fecha_publicacion_calificacion_docente/{id}/edit','Secundaria\SecundariaFechaPublicacionDocenteController@edit')->name('secundaria.secundaria_fecha_publicacion_calificacion_docente.edit');
Route::get('secundaria_fecha_publicacion_calificacion_docente/getMesEvaluaciones/{departamento_id}','Secundaria\SecundariaFechaPublicacionDocenteController@getMesEvaluaciones');
Route::post('secundaria_fecha_publicacion_calificacion_docente','Secundaria\SecundariaFechaPublicacionDocenteController@store')->name('secundaria.secundaria_fecha_publicacion_calificacion_docente.store');
Route::put('secundaria_fecha_publicacion_calificacion_docente/{id}','Secundaria\SecundariaFechaPublicacionDocenteController@update')->name('secundaria.secundaria_fecha_publicacion_calificacion_docente.update');

// Fecha publicacion Alumno
Route::get('secundaria_fecha_publicacion_calificacion_alumno','Secundaria\SecundariaFechaPublicacionAlumnoController@index')->name('secundaria.secundaria_fecha_publicacion_calificacion_alumno.index');
Route::get('secundaria_fecha_publicacion_calificacion_alumno/list','Secundaria\SecundariaFechaPublicacionAlumnoController@list');
Route::get('secundaria_fecha_publicacion_calificacion_alumno/create','Secundaria\SecundariaFechaPublicacionAlumnoController@create')->name('secundaria.secundaria_fecha_publicacion_calificacion_alumno.create');
Route::get('secundaria_fecha_publicacion_calificacion_alumno/{id}/edit','Secundaria\SecundariaFechaPublicacionAlumnoController@edit')->name('secundaria.secundaria_fecha_publicacion_calificacion_alumno.edit');
Route::post('secundaria_fecha_publicacion_calificacion_alumno','Secundaria\SecundariaFechaPublicacionAlumnoController@store')->name('secundaria.secundaria_fecha_publicacion_calificacion_alumno.store');
Route::put('secundaria_fecha_publicacion_calificacion_alumno/{id}','Secundaria\SecundariaFechaPublicacionAlumnoController@update')->name('secundaria.secundaria_fecha_publicacion_calificacion_alumno.update');


//Cambiar grupo ACD
Route::get('secundaria_cambio_grupo_acd','Secundaria\SecundariaCambioGrupoACDController@index')->name('secundaria.secundaria_cambio_grupo_acd.index');
Route::get('secundaria_cambio_grupo_acd/cargar_grupos_actuales/{periodo_id}/{programa_id}/{plan_id}/{aluClave}','Secundaria\SecundariaCambioGrupoACDController@cargar_grupos_acd_actuales')->name('secundaria.secundaria_cambio_grupo_acd.cargar_grupos_acd_actuales');
Route::post('secundaria_cambio_grupo_acd','Secundaria\SecundariaCambioGrupoACDController@cambiar_grupo_acd')->name('secundaria.secundaria_cambio_grupo_acd.cambiar_grupo_acd');

// Generar promedios trimestrales
Route::get('secundaria_generar_promedios', 'Secundaria\SecundariaGenerarPromediosController@index')->name('secundaria.secundaria_generar_promedios.index');
Route::post('secundaria_generar_promedios', 'Secundaria\SecundariaGenerarPromediosController@generarPromedio')->name('secundaria.secundaria_generar_promedios.generarPromedio');


Route::get('secundaria_modificar_boleta', 'Secundaria\SecundariaModificarBoletaController@modificar')->name('secundaria.secundaria_modificar_boleta.modificar');
Route::post('secundaria_modificar_boleta', 'Secundaria\SecundariaModificarBoletaController@modificarpost')->name('secundaria.secundaria_modificar_boleta.modificarpost');
Route::post('secundaria/secundaria_modificar_boleta', 'Secundaria\SecundariaModificarBoletaController@actualizar_calificaciones')->name('secundaria.secundaria_modificar_boleta.actualizar_calificaciones');



// lista negra
Route::get('/secundaria_alumnos_restringidos', 'Secundaria\SecundariaListaNegraController@index')->name('secundaria.secundaria_alumnos_restringidos.index');
Route::get('/secundaria_alumnos_restringidos/create', 'Secundaria\SecundariaListaNegraController@create')->name('secundaria.secundaria_alumnos_restringidos.create');
Route::get('/secundaria_alumnos_restringidos/list', 'Secundaria\SecundariaListaNegraController@list')->name('secundaria.secundaria_alumnos_restringidos.list');
Route::get('secundaria_alumnos_restringidos/{id}','Secundaria\SecundariaListaNegraController@show')->name('secundaria.secundaria_alumnos_restringidos.show');
Route::get('secundaria_alumnos_restringidos/{id}/edit','Secundaria\SecundariaListaNegraController@edit')->name('secundaria.secundaria_alumnos_restringidos.edit');
Route::post('secundaria_alumnos_restringidos','Secundaria\SecundariaListaNegraController@store')->name('secundaria.secundaria_alumnos_restringidos.store');
Route::put('secundaria_alumnos_restringidos/{id}','Secundaria\SecundariaListaNegraController@update')->name('secundaria.secundaria_alumnos_restringidos.update');
Route::post('secundaria_alumnos_restringidos/darBaja/{empleado_id}', 'Secundaria\SecundariaListaNegraController@darDeBaja')->name('secundaria.secundaria_alumnos_restringidos/darBaja/{empleado_id}');
Route::delete('secundaria_alumnos_restringidos/{id}','Secundaria\SecundariaListaNegraController@destroy')->name('secundaria.secundaria_alumnos_restringidos.destroy');

/* -------------------------------------------------------------------------- */
/*                        Apartir de aquí puro reportes                       */
/* -------------------------------------------------------------------------- */

//Historial de Pagos de Alumno.
Route::get('secundaria_reporte/historial_pagos_alumno', 'Secundaria\Reportes\SecundariaHistorialPagosAlumnoController@reporte');
Route::post('secundaria_reporte/historial_pagos_alumno/imprimir', 'Secundaria\Reportes\SecundariaHistorialPagosAlumnoController@imprimir');

//generar PDF de todos los alumnos
Route::get('secundaria _calificacion/calificacionesgrupo/primerreporte/{grupo_id}/{trimestre_a_evaluar}', 'Secundaria\SecundariaCalificacionesController@reporteTrimestretodos');


// Controller para generar reporte de calificaciones
Route::get('secundaria_reporte/calificaciones_grupo', 'Secundaria\Reportes\SecundariaCalificacionPorGrupoController@Reporte')->name('secundaria_reporte.calificaciones_grupo.reporte');
Route::post('secundaria_reporte/boleta_calificaciones/imprimir', 'Secundaria\Reportes\SecundariaCalificacionPorGrupoController@imprimirCalificaciones')->name('secundaria_reporte.boleta_calificaciones.imprimir');


// Controller para generar reporte de expediente de alumnos
Route::get('secundaria_reporte/expediente_alumnos', 'Secundaria\Reportes\SecundariaExpedienteAlumnosController@index')->name('secundaria_reporte.expediente_alumnos.index');
Route::post('secundaria_reporte/expediente_alumnos/imprimir', 'Secundaria\Reportes\SecundariaExpedienteAlumnosController@imprimirExpediente')->name('secundaria_reporte.expediente_alumnos.imprimir');


// Controller para generar constancias
Route::get('secundaria_reporte/carta_conducta/imprimir/{id_curso}', 'Secundaria\Reportes\SecundariaConstanciasController@imprimirCartaConducta');
Route::get('secundaria_reporte/constancia_estudio/imprimir/{id_curso}/{tiene_foto}', 'Secundaria\Reportes\SecundariaConstanciasController@imprimirConstanciaEstudio');
Route::get('secundaria_reporte/constancia_no_adeudo/imprimir/{id_curso}', 'Secundaria\Reportes\SecundariaConstanciasController@imprimirConstanciaNoAdeudo');
Route::get('secundaria_reporte/constancia_de_cupo/imprimir/{id_curso}/{tipoContancia}', 'Secundaria\Reportes\SecundariaConstanciasController@imprimirConstanciaCupo');
Route::get('secundaria_reporte/constancia_de_promedio_final/imprimir/{id_curso}/{tipoContancia}', 'Secundaria\Reportes\SecundariaConstanciasController@imprimirConstanciaPromedioFinal');
Route::get('secundaria_reporte/constancia_de_artes_talleres/imprimir/{id_curso}/{tipoContancia}', 'Secundaria\Reportes\SecundariaConstanciasController@imprimirConstanciaArtesTalleres');
Route::get('secundaria_reporte/constancia_de_inscripcion/imprimir/{id_curso}/{tipoContancia}', 'Secundaria\Reportes\SecundariaConstanciasController@imprimirConstanciaInscripcion');
Route::get('secundaria_reporte/constancia_de_escolaridad/imprimir/{id_curso}/{tipoContancia}', 'Secundaria\Reportes\SecundariaConstanciasController@imprimirConstanciaEscolaridad');


//Controller para generar reporte de alumnos becados
Route::get('secundaria_reporte/alumnos_becados', 'Secundaria\Reportes\SecundariaAlumnosBecadosController@reporte')->name('secundaria_reporte.secundaria_alumnos_becados.reporte');
Route::post('secundaria_reporte/alumnos_becados/imprimir', 'Secundaria\Reportes\SecundariaAlumnosBecadosController@imprimir')->name('secundaria_reporte.secundaria_alumnos_becados.imprimir');


//Relación Maestros Escuela
Route::get('secundaria_reporte/relacion_grupo_maestro', 'Secundaria\Reportes\SecundariaRelacionMaestrosEscuelaController@reporte')->name('secundaria_relacion_maestros_escuela.reporte');
Route::post('secundaria_reporte/relacion_grupo_maestro/imprimir', 'Secundaria\Reportes\SecundariaRelacionMaestrosEscuelaController@imprimir')->name('secundaria_relacion_maestros_escuela.imprimir');

//Relación Maestros ACD
Route::get('secundaria_reporte/relacion_maestros_acd', 'Secundaria\Reportes\SecundariaRelacionMaestrosACDController@reporte')->name('secundaria_reporte.relacion_maestros_acd.reporte');
Route::post('secundaria_reporte/relacion_maestros_acd/imprimir', 'Secundaria\Reportes\SecundariaRelacionMaestrosACDController@imprimir')->name('secundaria_reporte.relacion_maestros_acd.imprimir');

//Reporte de calificacion de grupo por materia
Route::get('secundaria_reporte/calificacion_por_materia', 'Secundaria\Reportes\SecundariaCalificacionPorMateriaController@reporte')->name('secundaria_reporte.calificacion_por_materia.reporte');
Route::get('secundaria_reporte/calificacion_por_materia/getGrupos/{programa_id}/{plan_id}/{periodo_id}', 'Secundaria\Reportes\SecundariaCalificacionPorMateriaController@getGrupos');
Route::post('secundaria_reporte/calificacion_por_materia/imprimir', 'Secundaria\Reportes\SecundariaCalificacionPorMateriaController@imprimir')->name('secundaria_reporte.calificacion_por_materia.imprimir');

//Reporte para imprimir la lista de asistencia de los grupos
Route::get('secundaria_reporte/lista_de_asistencia', 'Secundaria\Reportes\SecundariaListaDeAsistenciaController@reporte')->name('secundaria_reporte.lista_de_asistencia.reporte');
Route::post('secundaria_reporte/lista_de_asistencia/imprimir', 'Secundaria\Reportes\SecundariaListaDeAsistenciaController@imprimir')->name('secundaria_reporte.lista_de_asistencia.imprimir');


// crear lista de asistencia de alumnos desde grupos
Route::get('secundaria_inscritos/lista_de_asistencia/grupo/{grupo_id}', 'Secundaria\Reportes\SecundariaListaDeAsistenciaController@imprimirListaAsistencia');

//lista de asistencia ACD
Route::get('secundaria_reporte/lista_de_asistencia_ACD', 'Secundaria\Reportes\SecundariaListaDeAsistenciaController@reporteACD')->name('secundaria_reporte.lista_de_asistencia_ACD.reporteACD');
Route::get('secundaria_reporte/lista_de_asistencia_ACD/getGruposACD/{programa_id}/{plan_id}/{perAnioPago}/{grado}', 'Secundaria\Reportes\SecundariaListaDeAsistenciaController@getGruposACD');
Route::get('secundaria_reporte/lista_de_asistencia_ACD/getMateriasComplementarias/{programa_id}/{plan_id}/{perAnioPago}', 'Secundaria\Reportes\SecundariaListaDeAsistenciaController@getMateriasComplementarias');

Route::post('secundaria_reporte/lista_de_asistencia_ACD/imprimir', 'Secundaria\Reportes\SecundariaListaDeAsistenciaController@imprimirACD')->name('secundaria_reporte.lista_de_asistencia_ACD.imprimirACD');

//Reporte de Inscritos y Preinscritos
Route::get('secundaria_reporte/secundaria_inscrito_preinscrito', 'Secundaria\Reportes\SecundariaInscritosPreinscritosController@reporte')->name('secundaria_inscrito_preinscrito.reporte');
Route::post('secundaria_reporte/secundaria_preinscrito/imprimir', 'Secundaria\Reportes\SecundariaInscritosPreinscritosController@imprimir')->name('secundaria_inscrito_preinscrito.imprimir');

// Relacion de deudores
Route::get('reporte/secundaria_relacion_deudores', 'Secundaria\Reportes\SecundariaRelDeudoresController@reporte')->name('secundaria_relacion_deudores.reporte');
Route::post('reporte/secundaria_relacion_deudores/imprimir', 'Secundaria\Reportes\SecundariaRelDeudoresController@imprimir')->name('secundaria_relacion_deudores.imprimir');

// Relacion de deuda individual de un alumno
Route::get('reporte/secundaria_relacion_deudas', 'Secundaria\Reportes\SecundariaRelDeudasController@reporte')->name('secundaria_relacion_deudas.reporte');
Route::post('reporte/secundaria_relacion_deudas/imprimir', 'Secundaria\Reportes\SecundariaRelDeudasController@imprimir')->name('secundaria_relacion_deudas.imprimir');


// Calificacion de materias en ingles
Route::get('reporte/secundaria_calificacion_materia_ingles', 'Secundaria\Reportes\SecundariaCalificacionesIngresController@index')->name('secundaria_calificacion_materia_ingles.index');
Route::post('reporte/secundaria_calificacion_materia_ingles/imprimir', 'Secundaria\Reportes\SecundariaCalificacionesIngresController@imprimir')->name('secundaria_calificacion_materia_ingles.imprimir');

// Boleta de calificaciones
Route::get('reporte/secundaria_boleta_de_calificaciones', 'Secundaria\Reportes\SecundariaBoletaDeCalificacionesController@reporteBoleta')->name('secundaria.secundaria_boleta_de_calificaciones.reporteBoleta');
Route::post('reporte/secundaria_boleta_de_calificaciones/imprimir', 'Secundaria\Reportes\SecundariaBoletaDeCalificacionesController@boletadesdecurso')->name('secundaria_boleta_de_calificaciones.imprimir.boletadesdecurso');

// Boleta de calificaciones ACD
Route::get('reporte/secundaria_boleta_de_calificaciones_acd', 'Secundaria\Reportes\SecundariaCalificacionesACDController@reporteBoleta')->name('secundaria.secundaria_boleta_de_calificaciones_acd.reporteBoleta');
Route::get('reporte/secundaria_boleta_de_calificaciones_acd/{curso_id}', 'Secundaria\Reportes\SecundariaCalificacionesACDController@boletadesdecurso')->name('secundaria.secundaria_boleta_de_calificaciones_acd.boletadesdecurso');
Route::post('reporte/secundaria_boleta_de_calificaciones_acd/imprimir', 'Secundaria\Reportes\SecundariaCalificacionesACDController@imprimir')->name('secundaria.secundaria_boleta_de_calificaciones_acd.imprimir');

// lista de calificaciones por grupo
Route::get('reporte/secundaria_resumen_de_calificaciones', 'Secundaria\Reportes\SecundariaResumenDeCalificacionesController@index')->name('secundaria.secundaria_resumen_de_calificaciones.index');
Route::post('reporte/secundaria_resumen_de_calificaciones/imprimir', 'Secundaria\Reportes\SecundariaResumenDeCalificacionesController@reporteResumenCalificacion')->name('secundaria.secundaria_resumen_de_calificaciones.reporteResumenCalificacion');

// lista de calificaciones por grupo trimestre
Route::get('reporte/secundaria_resumen_de_calificaciones_trim', 'Secundaria\Reportes\SecundariaCalificacionesTrimestralesController@index')->name('secundaria.secundaria_resumen_de_calificaciones_trim.index');
Route::post('reporte/secundaria_resumen_de_calificaciones_trim/imprimir', 'Secundaria\Reportes\SecundariaCalificacionesTrimestralesController@reporteResumenCalificacion')->name('secundaria.secundaria_resumen_de_calificaciones_trim.reporteResumenCalificacion');



// lista de inasistecia por grupo
Route::get('reporte/secundaria_resumen_inasistencias', 'Secundaria\Reportes\SecundariaResumenDeInasistenciasController@index')->name('secundaria.secundaria_resumen_inasistencias.index');
Route::post('reporte/secundaria_resumen_inasistencias/imprimir', 'Secundaria\Reportes\SecundariaResumenDeInasistenciasController@reporteResumenInasistencias')->name('secundaria.secundaria_resumen_inasistencias.reporteResumenInasistencias');

//Relación de bajas por periodo.
Route::get('reporte/secundaria_relacion_bajas_periodo','Secundaria\Reportes\SecundariaRelacionBajasPeriodoController@reporte')->name('secundaria.secundaria_relacion_bajas_periodo.reporte');
Route::post('reporte/secundaria_relacion_bajas_periodo/imprimir', 'Secundaria\Reportes\SecundariaRelacionBajasPeriodoController@imprimir')->name('secundaria.secundaria_relacion_bajas_periodo.imprimir');

//Grupos por grados
Route::get('reporte/secundaria_grupo_semestre', 'Secundaria\Reportes\SecundariaGrupoSemestreController@reporte')->name('secundaria.secundaria_grupo_semestre.reporte');
Route::post('reporte/secundaria_grupo_semestre/imprimir', 'Secundaria\Reportes\SecundariaGrupoSemestreController@imprimir')->name('secundaria.secundaria_grupo_semestre.imprimir');


//Grupos por grados
Route::get('reporte/secundaria_relacion_tutores', 'Secundaria\Reportes\SecundariaRelacionPadresTutoresController@index')->name('secundaria.secundaria_relacion_tutores.index');
Route::post('reporte/secundaria_relacion_tutores/imprimir', 'Secundaria\Reportes\SecundariaRelacionPadresTutoresController@imprimir')->name('secundaria.secundaria_relacion_tutores.imprimir');

// historial academico de alumnos
Route::get('reporte/secundaria_historial_alumno', 'Secundaria\Reportes\SecundariaHistorialAcademicoAlumnoController@reporte')->name('secundaria.secundaria_historial_alumno.reporte');
Route::post('reporte/secundaria_historial_alumno/imprimir', 'Secundaria\Reportes\SecundariaHistorialAcademicoAlumnoController@imprimir')->name('secundaria.secundaria_historial_alumno.imprimir');
Route::get('secundaria_historial_alumno/obtenerProgramasClave/{aluClave}', 'Secundaria\Reportes\SecundariaHistorialAcademicoAlumnoController@obtenerProgramasClave');
Route::get('secundaria_historial_alumno/obtenerProgramasMatricula/{aluMatricula}', 'Secundaria\Reportes\SecundariaHistorialAcademicoAlumnoController@obtenerProgramasMatricula');


// Resumen de inscritos
Route::get('reporte/secundaria_resumen_inscritos', 'Secundaria\Reportes\SecundariaResumenInscritosController@reporte');
Route::get('reporte/secundaria_resumen_inscritos/imprimir', 'Secundaria\Reportes\SecundariaResumenInscritosController@imprimir');
Route::get('reporte/secundaria_resumen_inscritos/exportarExcel', 'Secundaria\Reportes\SecundariaResumenInscritosController@exportarExcel');


// immprimir alumnos a excel
Route::get('reporte/secundaria_alumnos_excel', 'Secundaria\Reportes\SecundariaReporteAlumnosExcelController@index')->name('secundaria.secundaria_alumnos_excel.index');
Route::get('reporte/secundaria_alumnos_excel/getAlumnosCursos', 'Secundaria\Reportes\SecundariaReporteAlumnosExcelController@getAlumnosCursos');
Route::get('reporte/secundaria_datos_completos_alumno', 'Secundaria\Reportes\SecundariaReporteAlumnosExcelController@reporteAlumnos')->name('secundaria.secundaria_datos_completos_alumno.reporteAlumnos');
Route::get('reporte/secundaria_datos_completos_alumno/getAlumnosCursosEduardo/secundaria', 'Secundaria\Reportes\SecundariaReporteAlumnosExcelController@getAlumnosCursosEduardo');


// Reporte de alumnos sin ACD
Route::get('reporte/secundaria_alumnos_no_inscritos_materias', 'Secundaria\Reportes\SecundariaAlumnosNoInscritosMateriasController@index')->name('secundaria.secundaria_alumnos_no_inscritos_materias.index');
Route::get('reporte/secundaria_alumnos_no_inscritos_materias/getGrupoACDFiltro/{plan_id}/{periodo_id}/{grado}', 'Secundaria\Reportes\SecundariaAlumnosNoInscritosMateriasController@getGrupoACDFiltro');
Route::get('reporte/secundaria_alumnos_no_inscritos_materias/getGrupoMateriaFiltro/{plan_id}/{periodo_id}/{grado}', 'Secundaria\Reportes\SecundariaAlumnosNoInscritosMateriasController@getGrupoMateriaFiltro');
Route::post('reporte/secundaria_alumnos_no_inscritos_materias/imprimir', 'Secundaria\Reportes\SecundariaAlumnosNoInscritosMateriasController@imprimir')->name('secundaria.secundaria_alumnos_no_inscritos_materias.imprimir');

// Reporte de alumnos inscritos a dos ACD
Route::get('reporte/secundaria_alumnos_inscritos_acd', 'Secundaria\Reportes\SecundariaAlumnosIncritosDosACDController@index')->name('secundaria.secundaria_alumnos_inscritos_acd.index');
Route::get('reporte/secundaria_alumnos_inscritos_acd/getGrupoACDFiltro/{plan_id}/{periodo_id}/{grado}', 'Secundaria\Reportes\SecundariaAlumnosIncritosDosACDController@getGrupoACDFiltro');
Route::post('reporte/secundaria_alumnos_inscritos_acd/imprimir', 'Secundaria\Reportes\SecundariaAlumnosIncritosDosACDController@imprimir')->name('secundaria.secundaria_alumnos_inscritos_acd.imprimir');



// Controller para generar reporte de calificaciones faltantes
Route::get('secundaria_reporte/calificaciones_faltantes', 'Secundaria\Reportes\SecundariaCalificacionFaltanteController@Reporte')->name('secundaria_reporte.calificaciones_faltantes.reporte');
Route::post('secundaria_reporte/calificacion_faltante/imprimir', 'Secundaria\Reportes\SecundariaCalificacionFaltanteController@imprimirCalificacionesFaltantes')->name('secundaria_reporte.calificacion_faltante.imprimir');

//lista de interesados
Route::get('secundaria_lista_de_interasados','Secundaria\Reportes\SecundariaListaDeInteresadosController@index')->name('secundaria.secundaria_lista_de_interasados.index');
Route::post('secundaria_lista_de_interasados/imprimir','Secundaria\Reportes\SecundariaListaDeInteresadosController@imprimir')->name('secundaria.secundaria_lista_de_interasados.imprimir');


//Listas de alumnos no inscritos
Route::get('reporte/secundaria_no_inscritos', 'Secundaria\Reportes\SecundariaAlumnosNoInscritosMateriasNormalesController@reporte')->name('secundaria.secundaria_no_inscritos.reporte');
Route::post('reporte/secundaria_no_inscritos/imprimir', 'Secundaria\Reportes\SecundariaAlumnosNoInscritosMateriasNormalesController@imprimir')->name('secundaria.secundaria_no_inscritos.imprimir');


//Grupos por Materia
Route::get('reporte/secundaria_grupo_materia', 'Secundaria\Reportes\SecundariaGrupoMateriaController@reporte')->name('secundaria.secundaria_grupo_materia.reporte');
Route::post('reporte/secundaria_grupo_materia/imprimir', 'Secundaria\Reportes\SecundariaGrupoMateriaController@imprimir')->name('secundaria.secundaria_grupo_materia.imprimir');


//Listas de Asistencia por Grupo
Route::get('reporte/secundaria_asistencia_grupo', 'Secundaria\Reportes\SecundariaAsistenciaGrupoController@reporte')->name('secundaria.secundaria_asistencia_grupo.reporte');
Route::post('reporte/secundaria_asistencia_grupo/imprimir', 'Secundaria\Reportes\SecundariaAsistenciaGrupoController@imprimir')->name('secundaria.secundaria_asistencia_grupo.imprimir');


// Concentrado de recuperativos
Route::get('reporte/secundaria_recuperativos', 'Secundaria\Reportes\SecundariaConcentradoRecuperativosController@reporte')->name('secundaria.secundaria_recuperativos.reporte');
Route::post('reporte/secundaria_recuperativos/imprimir', 'Secundaria\Reportes\SecundariaConcentradoRecuperativosController@imprimir')->name('secundaria.secundaria_recuperativos.imprimir');

// constancia de buena conducta
Route::get('reporte/secundaria_constancia_buena_conducta', 'Secundaria\Reportes\SecundariaConstanciaBuenaConductaController@reporte')->name('secundaria.secundaria_constancia_buena_conducta.reporte');
Route::post('reporte/secundaria_constancia_buena_conducta/imprimir', 'Secundaria\Reportes\SecundariaConstanciaBuenaConductaController@imprimir')->name('secundaria.secundaria_constancia_buena_conducta.imprimir');


// Constancia de estudios
Route::get('reporte/secundaria_constancia_estudios', 'Secundaria\Reportes\SecundariaConstanciaEstudiosController@reporte')->name('secundaria.secundaria_constancia_estudios.reporte');
Route::post('reporte/secundaria_constancia_estudios/imprimir', 'Secundaria\Reportes\SecundariaConstanciaEstudiosController@imprimir')->name('secundaria.secundaria_constancia_estudios.imprimir');
//Resumen de inscritos por sexo
Route::get('secundaria_reporte/secundaria_inscritos_sexo','Secundaria\Reportes\SecundariaResumenInscritosSexoController@reporte')->name('secundaria.secundaria_inscritos_sexo.reporte');
Route::post('secundaria_reporte/secundaria_inscritos_sexo/imprimir','Secundaria\Reportes\SecundariaResumenInscritosSexoController@imprimir')->name('secundaria.secundaria_inscritos_sexo.imprimir');

Route::get('secundaria_reporte/secundaria_acd_faltantes','Secundaria\Reportes\SecundariaACDFaltantesController@reporte')->name('secundaria.secundaria_acd_faltantes.reporte');
Route::post('secundaria_reporte/secundaria_acd_faltantes/imprimir','Secundaria\Reportes\SecundariaACDFaltantesController@imprimir')->name('secundaria.secundaria_acd_faltantes.imprimir');

// Boleta de calificaciones
Route::get('reporte/secundaria_boleta_campos_formativos', 'Secundaria\Reportes\SecundariaBoletaCamposFormativosController@reporteBoleta')->name('secundaria.secundaria_boleta_campos_formativos.reporteBoleta');
Route::post('reporte/secundaria_boleta_campos_formativos/imprimir', 'Secundaria\Reportes\SecundariaBoletaCamposFormativosController@boletadesdecurso')->name('secundaria_boleta_campos_formativos.imprimir.boletadesdecurso');
