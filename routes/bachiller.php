<?php

/* -------------------------------------------------------------------------- */
/*                           rutas nivel bachiller                           */
/* -------------------------------------------------------------------------- */
// Funciones genericas
Route::get('bachiller_api/escuelas/{id}','Bachiller\BachillerFuncionesGenericasController@getEscuelasBac');
Route::get('bachiller_api/departamentos/{id}','Bachiller\BachillerFuncionesGenericasController@getDepartamentos');
Route::get('bachiller_api/api/planes/{id}','Bachiller\BachillerFuncionesGenericasController@getPlanesEspesificos');
Route::get('bachiller_api/api/planesTodos/{id}','Bachiller\BachillerFuncionesGenericasController@getPlanesTodos');
Route::get('bachiller_api/get_departamentos_lista_completa/{ubicacion_id}','Bachiller\BachillerFuncionesGenericasController@getDepartamentosListaCompleta');
Route::get('bachiller_api/obtenerNumerosSemestre/{periodo_id}','Bachiller\BachillerFuncionesGenericasController@obtenerNumerosSemestre');
Route::get('bachiller_api/obtenerLetrasSemestre/{periodo_id}','Bachiller\BachillerFuncionesGenericasController@obtenerLetrasSemestre');



// Programas
Route::get('bachiller_programa', 'Bachiller\BachillerProgramasController@index')->name('bachiller.bachiller_programa.index');
Route::get('bachiller_programa/list', 'Bachiller\BachillerProgramasController@list')->name('bachiller.bachiller_programa.list');
Route::get('bachiller_programa/api/programas/{escuela_id}','Bachiller\BachillerProgramasController@getProgramas');
Route::get('bachiller_programa/api/programa/{programa_id}','Bachiller\BachillerProgramasController@getPrograma');
Route::get('bachiller_programa/create', 'Bachiller\BachillerProgramasController@create')->name('bachiller.bachiller_programa.create');
Route::get('bachiller_programa/{id}/edit', 'Bachiller\BachillerProgramasController@edit')->name('bachiller.bachiller_programa.edit');
Route::get('bachiller_programa/{id}', 'Bachiller\BachillerProgramasController@show')->name('bachiller.bachiller_programa.show');
Route::post('bachiller_programa', 'Bachiller\BachillerProgramasController@store')->name('bachiller.bachiller_programa.store');
Route::put('bachiller_programa/{id}', 'Bachiller\BachillerProgramasController@update')->name('bachiller.bachiller_programa.update');
Route::delete('bachiller_programa/{id}', 'Bachiller\BachillerProgramasController@destroy')->name('bachiller.bachiller_programa.destroy');

// planes
Route::get('bachiller_plan', 'Bachiller\BachillerPlanesController@index')->name('bachiller.bachiller_plan.index');
Route::get('bachiller_plan/list', 'Bachiller\BachillerPlanesController@list')->name('bachiller.bachiller_plan.list');
Route::get('bachiller_plan/api/planes/{id}','Bachiller\BachillerPlanesController@getPlanes');
Route::get('bachiller_plan/create', 'Bachiller\BachillerPlanesController@create')->name('bachiller.bachiller_plan.create');
Route::get('bachiller_plan/{id}/edit', 'Bachiller\BachillerPlanesController@edit')->name('bachiller.bachiller_plan.edit');
Route::get('bachiller_plan/{id}', 'Bachiller\BachillerPlanesController@show')->name('bachiller.bachiller_plan.show');
Route::get('bachiller_plan/get_plan/{plan_id}', 'Bachiller\BachillerPlanesController@getPlan');
Route::get('bachiller_plan/plan/semestre/{id}','Bachiller\BachillerPlanesController@getSemestre');
Route::post('bachiller_plan', 'Bachiller\BachillerPlanesController@store')->name('bachiller.bachiller_plan.store');
Route::post('bachiller_plan/cambiarPlanEstado', 'Bachiller\BachillerPlanesController@cambiarPlanEstado');
Route::put('bachiller_plan/{id}', 'Bachiller\BachillerPlanesController@update')->name('bachiller.bachiller_plan.update');
Route::delete('bachiller_plan/{id}', 'Bachiller\BachillerPlanesController@destroy')->name('bachiller.bachiller_plan.destroy');

// Periodos
Route::get('bachiller_periodo', 'Bachiller\BachillerPeriodosController@index')->name('bachiller.bachiller_periodo.index');
Route::get('bachiller_periodo/list', 'Bachiller\BachillerPeriodosController@list')->name('bachiller.bachiller_periodo.list');
Route::get('bachiller_periodo/api/periodos/{departamento_id}','Bachiller\BachillerPeriodosController@getPeriodos');
Route::get('bachiller_periodo/todos/periodos/{departamento_id}','Bachiller\BachillerPeriodosController@getPeriodosTodos');
Route::get('bachiller_periodo/curso/periodos/{departamento_id}','Bachiller\BachillerPeriodosController@getPeriodosCurso');
Route::get('bachiller_periodo/getPeriodoAnteActuSig/periodos/{departamento_id}','Bachiller\BachillerPeriodosController@getPeriodoAnteActuSig');
Route::get('bachiller_periodo/api/periodo/{id}','Bachiller\BachillerPeriodosController@getPeriodo');
Route::get('bachiller_periodo/api/periodoPerAnioPago/{id}','Bachiller\BachillerPeriodosController@getPeriodoPerAnioPago');
Route::get('bachiller_periodo/api/periodo/{departamento_id}/posteriores', 'Bachiller\BachillerPeriodosController@getPeriodos_afterDate');
Route::get('bachiller_periodo/create', 'Bachiller\BachillerPeriodosController@create')->name('bachiller.bachiller_periodo.create');
Route::get('bachiller_periodo/{id}/edit', 'Bachiller\BachillerPeriodosController@edit')->name('bachiller.bachiller_periodo.edit');
Route::get('bachiller_periodo/{id}', 'Bachiller\BachillerPeriodosController@show')->name('bachiller.bachiller_periodo.show');
Route::get('bachiller_periodo/api/periodoByDepartamento/{departamentoId}','Bachiller\BachillerPeriodosController@getPeriodosByDepartamento');
Route::post('bachiller_periodo', 'Bachiller\BachillerPeriodosController@store')->name('bachiller.bachiller_periodo.store');
Route::put('bachiller_periodo/{id}', 'Bachiller\BachillerPeriodosController@update')->name('bachiller.bachiller_periodo.update');
Route::delete('bachiller_periodo/{id}', 'Bachiller\BachillerPeriodosController@destroy')->name('bachiller.bachiller_periodo.destroy');

// materias
Route::get('bachiller_materia','Bachiller\BachillerMateriasController@index')->name('bachiller.bachiller_materia.index');
Route::get('bachiller_materia/list','Bachiller\BachillerMateriasController@list');
Route::get('bachiller_materia/create','Bachiller\BachillerMateriasController@create')->name('bachiller.bachiller_materia.create');
Route::get('bachiller_materia/{id}/edit','Bachiller\BachillerMateriasController@edit')->name('bachiller.bachiller_materia.edit');
Route::get('bachiller_materia/{id}','Bachiller\BachillerMateriasController@show')->name('bachiller.bachiller_materia.show');
Route::get('bachiller_materia/prerequisitos/{id}','Bachiller\BachillerMateriasController@prerequisitos');
Route::get('bachiller_materia/materia/prerequisitos/{id}','Bachiller\BachillerMateriasController@listPreRequisitos');
Route::get('bachiller_materia/eliminarPrerequisito/{id}/{materia_id}','Bachiller\BachillerMateriasController@eliminarPrerequisito');
Route::get('bachiller_materia/materias/{semestre}/{planId}','Bachiller\BachillerMateriasController@getMaterias');
Route::get('bachiller_materia/getMateriasByPlan/{plan}/','Bachiller\BachillerMateriasController@getMateriasByPlan')->name('bachiller.bachiller_materia.getMateriasByPlan');
Route::get('bachiller_materia/acd/{materia_id}/{plan_id}','Bachiller\BachillerMateriasController@index_acd')->name('bachiller.bachiller_materia.index_acd');
Route::get('bachiller_materia/listACD/{materia_id}/{plan_id}','Bachiller\BachillerMateriasController@listACD')->name('bachiller.bachiller_materia.listACD');
Route::get('bachiller_materia_acd/create_acd/{materia_id}','Bachiller\BachillerMateriasController@create_acd')->name('bachiller.bachiller_materia_acd.create_acd');
Route::get('bachiller_materia_acd/{id}/edit_acd','Bachiller\BachillerMateriasController@edit_acd')->name('bachiller.bachiller_materia.edit_acd');
Route::get('bachiller_materia_acd/{id}','Bachiller\BachillerMateriasController@show_acd')->name('bachiller.bachiller_materia.show_acd');
Route::post('bachiller_materia','Bachiller\BachillerMateriasController@store')->name('bachiller.bachiller_materia.store');
Route::post('bachiller_materia_acd','Bachiller\BachillerMateriasController@store_acd')->name('bachiller.bachiller_materia.store_acd');
Route::post('bachiller_materia/agregarPreRequisitos','Bachiller\BachillerMateriasController@agregarPreRequisitos')->name('bachiller.bachiller_materia.agregarPreRequisitos');
Route::put('bachiller_materia/{id}','Bachiller\BachillerMateriasController@update')->name('bachiller.bachiller_materia.update');
Route::put('bachiller_materia_acd/{id}','Bachiller\BachillerMateriasController@update_acd')->name('bachiller.bachiller_materia_acd.update_acd');
Route::delete('bachiller_materia/{id}','Bachiller\BachillerMateriasController@destroy');
Route::delete('bachiller_materia_acd/{id}','Bachiller\BachillerMateriasController@destroy_acd')->name('bachiller.bachiller_materia_acd.destroy_acd');


// CGT
Route::get('bachiller_cgt','Bachiller\BachillerCGTController@index')->name('bachiller.bachiller_cgt.index');
Route::get('bachiller_cgt/list','Bachiller\BachillerCGTController@list');
Route::get('bachiller_cgt/create','Bachiller\BachillerCGTController@create')->name('bachiller.bachiller_cgt.create');
Route::get('bachiller_cgt/{id}/edit','Bachiller\BachillerCGTController@edit')->name('bachiller.bachiller_cgt.edit');
Route::get('bachiller_cgt/{id}','Bachiller\BachillerCGTController@show')->name('bachiller.bachiller_cgt.show');
Route::get('bachiller_cgt/apiss/cgts/{plan_id}/{periodo_id}/{semestre}','Bachiller\BachillerCGTController@getCgtsSemestre');
Route::get('bachiller_cgt/api/cgts/{plan_id}/{periodo_id}','Bachiller\BachillerCGTController@getCgts');
Route::get('bachiller_cgt/api/cgts_sin_N/{plan_id}/{periodo_id}','Bachiller\BachillerCGTController@getCgtsSinN');
Route::post('bachiller_cgt','Bachiller\BachillerCGTController@store')->name('bachiller.bachiller_cgt.store');
Route::put('bachiller_cgt/{id}','Bachiller\BachillerCGTController@update')->name('bachiller.bachiller_cgt.update');
Route::delete('bachiller_cgt/{id}','Bachiller\BachillerCGTController@destroy')->name('bachiller.bachiller_cgt.destroy');

// Cambiar matrículas de alumnos (de un cgt).
Route::get('bachiller_cambiar_matriculas_cgt/{cgt_id}', 'Bachiller\BachillerCambiarMatriculasController@lista_alumnos');
Route::get('bachiller_cambiar_matriculas_cgt/{cgt_id}/buscar_alumno/{alumno_id}', 'Bachiller\BachillerCambiarMatriculasController@buscarAlumnoEnCgt');
Route::post('bachiller_cambiar_matriculas_cgt/{cgt_id}/actualizar/{alumno_id}', 'Bachiller\BachillerCambiarMatriculasController@cambiarMatricula');
Route::post('bachiller_cambiar_matriculas_cgt/{cgt_id}/actualizar_lista', 'Bachiller\BachillerCambiarMatriculasController@cambiarMultiplesMatriculas');

// Porcentaje
Route::get('bachiller_porcentaje','Bachiller\BachillerPorcentajeController@index')->name('bachiller.bachiller_porcentaje.index');
Route::get('bachiller_porcentaje/list','Bachiller\BachillerPorcentajeController@list');
Route::get('bachiller_porcentaje/create','Bachiller\BachillerPorcentajeController@create')->name('bachiller.bachiller_porcentaje.create');
Route::get('bachiller_porcentaje/{id}/edit','Bachiller\BachillerPorcentajeController@edit')->name('bachiller.bachiller_porcentaje.edit');
Route::get('bachiller_porcentaje/{id}','Bachiller\BachillerPorcentajeController@show')->name('bachiller.bachiller_porcentaje.show');
Route::post('bachiller_porcentaje','Bachiller\BachillerPorcentajeController@store')->name('bachiller.bachiller_porcentaje.store');
Route::put('bachiller_porcentaje/{id}','Bachiller\BachillerPorcentajeController@update')->name('bachiller.bachiller_porcentaje.update');
Route::delete('bachiller_porcentaje/{id}','Bachiller\BachillerPorcentajeController@destroy')->name('bachiller.bachiller_porcentaje.destroy');



/* ---------------------------- Módulo de Alumnos --------------------------- */
Route::get('/bachiller_alumno', 'Bachiller\BachillerAlumnosController@index')->name('bachiller.bachiller_alumno.index');
Route::get('bachiller_alumno/list','Bachiller\BachillerAlumnosController@list')->name('bachiller.bachiller_alumno.list');
Route::get('api/bachiller_alumno/tutores/buscar_tutor/{tutNombre}/{tutTelefono}', 'Bachiller\BachillerAlumnosController@buscarTutor');
Route::get('api/bachiller_alumno/tutores/{alumno_id}', 'Bachiller\BachillerAlumnosController@tutores_alumno')->name('api/bachiller_alumno/tutores/{alumno_id}');
Route::get('bachiller_alumno/create','Bachiller\BachillerAlumnosController@create')->name('bachiller.bachiller_alumno.create');
Route::get('bachiller_alumno/conceptosBaja','Bachiller\BachillerAlumnosController@conceptosBaja')->name('bachiller.bachiller_alumno.conceptosBaja');
Route::get('bachiller_alumno/preparatoriaProcedencia/{municipio_id}','Bachiller\BachillerAlumnosController@preparatoriaProcedencia')->name('bachiller_alumno.preparatoriaProcedencia');
Route::post('bachiller_alumno','Bachiller\BachillerAlumnosController@store')->name('bachiller.bachiller_alumno.store');
Route::get('bachiller_alumno/verificar_persona', 'Bachiller\BachillerAlumnosController@verificarExistenciaPersona')->name('bachiller.bachiller_alumno.verificar_persona');
Route::get('bachiller_alumno/{id}/edit','Bachiller\BachillerAlumnosController@edit')->name('bachiller.bachiller_alumno.edit');
Route::get('bachiller_alumno/{id}','Bachiller\BachillerAlumnosController@show')->name('bachiller.bachiller_alumno.show');
Route::get('bachiller_alumno/ultimo_curso/{alumno_id}', 'Bachiller\BachillerAlumnosController@ultimoCurso')->name('bachiller/bachiller_alumno/ultimo_curso/{alumno_id}');
Route::post('bachiller_alumno/api/getMultipleAlumnosByFilter','Bachiller\BachillerAlumnosController@getMultipleAlumnosByFilter');
Route::get('bachiller_alumno/listHistorialPagosAluclave/{aluClave}','Bachiller\BachillerAlumnosController@listHistorialPagosAluclave')->name('bachiller.bachiller_alumno.listHistorialPagosAluclave');

Route::get('bachiller_alumno/cambiar_matricula/{alumnoId}','Bachiller\BachillerAlumnosController@cambiarMatricula')->name("preescolar_alumnos.cambiarMatricula");
Route::get('bachiller_alumno/api/secundariaProcedencia/{municipio_id}','Bachiller\BachillerAlumnosController@secundariaProcedencia')->name('bachiller_alumno/api/secundariaProcedencia');
Route::get('bachiller_alumno/alumnoById/{alumnoId}','Bachiller\BachillerAlumnosController@getAlumnoById');
Route::post('bachiller_alumno/cambiarEstatusAlumno','Bachiller\BachillerAlumnosController@cambiarEstatusAlumno')->name("bachiller.bachiller_alumno.cambiarEstatusAlumno");
Route::post('bachiller_alumno/cambiar_matricula/edit','Bachiller\BachillerAlumnosController@postCambiarMatricula')->name("bachiller.bachiller_alumno.cambiarMatricula");
Route::post('bachiller_alumno/rehabilitar_alumno/{alumno_id}','Bachiller\BachillerAlumnosController@rehabilitarAlumno')->name('Bachiller\BachillerAlumnosController/rehabilitar_alumno/{alumno_id}');
Route::post('bachiller_alumno/registrar_empleado/{empleado_id}', 'Bachiller\BachillerAlumnosController@empleado_crearAlumno')->name('Bachiller\BachillerAlumnosController/registrar_empleado/{empleado_id}');
Route::post('bachiller_alumno/tutores/nuevo_tutor','Bachiller\BachillerAlumnosController@crearTutor')->name('bachiller.bachiller_alumno.tutores.nuevo_tutor');
Route::put('bachiller_alumno/{id}','Bachiller\BachillerAlumnosController@update')->name('bachiller.bachiller_alumno.update');
Route::delete('bachiller_alumno/{id}','Bachiller\BachillerAlumnosController@destroy')->name('bachiller.bachiller_alumno.destroy');
Route::post('bachiller_alumno/quitarTutor','Bachiller\BachillerAlumnosController@quitarTutor')->name('bachiller.bachiller_alumno.quitarTutor');
Route::post('bachiller_alumno/vincularTutor','Bachiller\BachillerAlumnosController@vincularTutor')->name('bachiller.bachiller_alumno.vincularTutor');
Route::post('bachiller_alumno/crearNuevoTutor','Bachiller\BachillerAlumnosController@crearNuevoTutor')->name('bachiller.bachiller_alumno.crearNuevoTutor');

Route::get('bachiller_alumno/change_password/{alumnoId}','Bachiller\BachillerAlumnosController@changePassword');
Route::post('bachiller_alumno/changed_password/{alumnoId}','Bachiller\BachillerAlumnosController@changePasswordUpdate');



/* ------------------------------ Módulo cursos ----------------------------- */
//Route::get('/home', 'Bachiller\BachillerCursoController@index')->name('Bachiller_curso.index');
Route::get('/bachiller_curso', 'Bachiller\BachillerCursoController@index')->name('bachiller.bachiller_curso.index');
Route::get('bachiller_curso/{curso_id}/constancia_beca/','Bachiller\BachillerCursoController@constanciaBeca')->name('bachiller.bachiller_curso.constanciaBeca');
Route::get('bachiller_curso/listGruposAlumno/{aluClave}','Bachiller\BachillerCursoController@listGruposAlumno');
Route::get('bachiller_curso/grupos_alumno/{id}','Bachiller\BachillerCursoController@viewCalificaciones');
Route::get('/bachiller_curso/create', 'Bachiller\BachillerCursoController@create')->name('bachiller.bachiller_curso.create');
Route::get('bachiller_curso/list','Bachiller\BachillerCursoController@list')->name('bachiller.bachiller_curso.list');
Route::get('bachiller_curso/conceptosBaja','Bachiller\BachillerCursoController@conceptosBaja')->name('bachiller.bachiller_curso.conceptosBaja');
Route::get('bachiller_curso/{id}','Bachiller\BachillerCursoController@show')->name('bachiller.bachiller_curso.show');
Route::get('bachiller_curso/{id}/edit','Bachiller\BachillerCursoController@edit')->name('bachiller.bachiller_curso.edit');
Route::get('bachiller_curso/api/cursos/{cgt_id}','Bachiller\BachillerCursoController@getCursos');
Route::get('bachiller_curso/api/curso/alumno/{aluClave}/{cuoAnio}','Bachiller\BachillerCursoController@getCursoAlumno');
Route::put('bachiller_curso/{id}','Bachiller\BachillerCursoController@update')->name('bachiller.bachiller_curso.update');
Route::post('/bachiller_curso', 'Bachiller\BachillerCursoController@store')->name('bachiller.bachiller_curso.store');
Route::get('bachiller_curso/listHistorialPagos/{curso_id}','Bachiller\BachillerCursoController@listHistorialPagos')->name('bachiller.bachiller_curso.listHistorialPagos');
Route::get('bachiller_curso/api/curso/{curso_id}','Bachiller\BachillerCursoController@listPreinscritoDetalle')->name('bachiller_curso/api/listPreinscritoDetalle');
Route::get('bachiller_curso/{curso_id}/historial_calificaciones_alumno/','Bachiller\BachillerCursoController@historialCalificacionesAlumno')->name('bachiller.bachiller_curso.historialCalificacionesAlumno');
Route::get('bachiller_curso/api/curso/{curso_id}/listHistorialCalifAlumnos/','Bachiller\BachillerCursoController@listHistorialCalifAlumnos')->name('bachiller.bachiller_curso.listHistorialCalifAlumnos');
Route::get('bachiller_curso/api/curso/{curso}/verificar_materias_cargadas', 'Bachiller\BachillerCursoController@verificar_materias_cargadas');
Route::get('bachiller_curso/api/curso/infoBaja/{curso_id}','Bachiller\BachillerCursoController@infoBaja')->name('bachiller.bachiller_curso.api.infoBaja');
Route::get('bachiller_curso/listPosiblesHermanos/{curso_id}','Bachiller\BachillerCursoController@listPosiblesHermanos')->name('bachiller.bachiller_curso.listPosiblesHermanos');
Route::post('bachiller_curso/bajaCurso','Bachiller\BachillerCursoController@bajaCurso')->name('bachiller.bachiller_curso.bajaCurso');
Route::get('bachiller_curso/observaciones/{curso_id}/', 'Bachiller\BachillerCursoController@observaciones')->name('bachiller.bachiller_curso.observaciones');
Route::post('bachiller_curso/storeObservaciones','Bachiller\BachillerCursoController@storeObservaciones')->name('bachiller.bachiller_curso.storeObservacionesCurso');
Route::post('bachiller_curso/curso/altaCurso','Bachiller\BachillerCursoController@altaCurso')->name('bachiller.bachiller_curso.altaCurso');
Route::get('bachiller_curso/curso_archivo_observaciones/{curso_id}','Bachiller\BachillerCursoController@cursoArchivoObservaciones')->name('bachiller.bachiller_curso.curso_archivo_observaciones');
Route::get('bachiller_curso/crearReferencia/{curso_id}/{tienePagoCeneval}','Bachiller\BachillerCursoController@crearReferenciaBBVA')->name('bachiller.bachiller_curso.crearReferencia');
Route::get('bachiller_curso/crearReferenciaHSBC/{curso_id}/{tienePagoCeneval}','Bachiller\BachillerCursoController@crearReferenciaHSBC')->name('bachiller.bachiller_curso.crearReferenciaHSBC');
Route::get('bachiller_curso/listMateriasFaltantes/{curso_id}/','Bachiller\BachillerCursoController@listMateriasFaltantes')->name('bachiller.bachiller_curso.listMateriasFaltantes');
Route::get('bachiller_curso/getDepartamentosListaCompleta/{ubicacion_id}/','Bachiller\BachillerCursoController@getDepartamentosListaCompleta')->name('bachiller.bachiller_curso.getDepartamentosListaCompleta');
Route::get('bachiller_curso/grupos_alumno/ajustar_calificacion/{id}/{aluClave}/{curso_id}','Bachiller\BachillerCursoController@ajustar_calificacion');
Route::get('bachiller_curso/getCalificacionUnicoAlumno/{id}/{grupoId}/{aluClave}','Bachiller\BachillerCursoController@getCalificacionUnicoAlumno');
Route::patch('bachiller_curso/getCalificacionUnicoAlumno/{id}','Bachiller\BachillerCursoController@ajustar_calificacion_update')->name('bachiller.bachiller_curso.ajustar_calificacion_update');

Route::get('bachiller_curso_images/{filename}/{folder}/{folderCampus}', function ($filename, $folder, $folderCampus)
{
    //$path = app_path('upload') . '/' . $filename;

    $path = storage_path(env("Bachiller_IMAGEN_CURSO_PATH") . $folder ."/".$folderCampus."/".$filename);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::delete('bachiller_curso/delete/{id}','Bachiller\BachillerCursoController@destroy');


/* ----------------------- Módulo de historia clinica ----------------------- */
Route::get('bachiller_historia_clinica', 'Bachiller\BachillerAlumnosHistoriaClinicaController@index')->name('bachiller.bachiller_historia_clinica.index');
Route::get('bachiller_historia_clinica/list', 'Bachiller\BachillerAlumnosHistoriaClinicaController@list')->name('bachiller.bachiller_historia_clinica.list');
Route::get('bachiller_historia_clinica/api/estados/{id}','Bachiller\BachillerAlumnosHistoriaClinicaController@getEstados');
Route::get('bachiller_historia_clinica/api/municipios/{id}','Bachiller\BachillerAlumnosHistoriaClinicaController@getMunicipios');
Route::get('bachiller_historia_clinica/create', 'Bachiller\BachillerAlumnosHistoriaClinicaController@create')->name('bachiller.bachiller_historia_clinica.create');
Route::get('bachiller_historia_clinica/{id}', 'Bachiller\BachillerAlumnosHistoriaClinicaController@show')->name('bachiller.bachiller_historia_clinica.show');
Route::get('bachiller_historia_clinica/{id}/edit', 'Bachiller\BachillerAlumnosHistoriaClinicaController@edit')->name('bachiller.bachiller_historia_clinica.edit');
Route::post('bachiller_historia_clinica/', 'Bachiller\BachillerAlumnosHistoriaClinicaController@store')->name('bachiller.bachiller_historia_clinica.store');
Route::put('bachiller_historia_clinica/{historia}', 'Bachiller\BachillerAlumnosHistoriaClinicaController@update')->name('bachiller.bachiller_historia_clinica.update');



/* --------------------------- Modulo asignar CGT --------------------------- */
Route::get('bachiller_asignar_cgt/create', 'Bachiller\BachillerAsignarCGTController@edit')->name('bachiller.bachiller_asignar_cgt.edit');
Route::get('bachiller_asignar_cgt/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerAsignarCGTController@getGradoGrupo');
Route::get('bachiller_asignar_cgt/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerAsignarCGTController@getAlumnosGrado');
Route::get('bachiller_asignar_cgt/getBachillerInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerAsignarCGTController@getBachillerInscritoCursos');
Route::post('bachiller_asignar_cgt/create', 'Bachiller\BachillerAsignarCGTController@update')->name('bachiller.bachiller_asignar_cgt.update');

/* --------------------------- Modulo Cambiar CGT --------------------------- */
Route::get('bachiller_cambiar_cgt_cch/create', 'Bachiller\BachillerCambiarCGTSEQController@edit')->name('bachiller.bachiller_cambiar_cgt_cch.edit');
Route::get('bachiller_cambiar_cgt_cch/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerCambiarCGTSEQController@getGradoGrupo');
Route::get('bachiller_cambiar_cgt_cch/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerCambiarCGTSEQController@getAlumnosGrado');
Route::get('bachiller_cambiar_cgt_cch/getBachillerInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerCambiarCGTSEQController@getBachillerInscritoCursos');
Route::post('bachiller_cambiar_cgt_cch/create', 'Bachiller\BachillerCambiarCGTSEQController@update')->name('bachiller.bachiller_cambiar_cgt_cch.update');


/* --------------------------- Modulo Cambiar CGT --------------------------- */
Route::get('bachiller_cambiar_cgt_yucatan/create', 'Bachiller\BachillerCambiarCGTYucatanController@edit')->name('bachiller.bachiller_cambiar_cgt_yucatan.edit');
Route::get('bachiller_cambiar_cgt_yucatan/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerCambiarCGTYucatanController@getGradoGrupo');
Route::get('bachiller_cambiar_cgt_yucatan/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerCambiarCGTYucatanController@getAlumnosGrado');
Route::get('bachiller_cambiar_cgt_yucatan/getBachillerInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerCambiarCGTYucatanController@getBachillerInscritoCursos');
Route::post('bachiller_cambiar_cgt_yucatan/create', 'Bachiller\BachillerCambiarCGTYucatanController@update')->name('bachiller.bachiller_cambiar_cgt_yucatan.update');


/* ---------------------------- Módulo de grupos Mérida - Valladolid---------------------------- */
Route::get('bachiller_grupo_uady', 'Bachiller\BachillerGrupoUADYController@index')->name('bachiller.bachiller_grupo_uady.index');
Route::get('bachiller_grupo_uady/list', 'Bachiller\BachillerGrupoUADYController@list')->name('bachiller.bachiller_grupo_uady.list');
Route::get('bachiller_grupo_uady/create', 'Bachiller\BachillerGrupoUADYController@create')->name('bachiller.bachiller_grupo_uady.create');
Route::post('bachiller_grupo_uady', 'Bachiller\BachillerGrupoUADYController@store')->name('bachiller.bachiller_grupo_uady.store');
Route::get('bachiller_grupo_uady/{id}/edit', 'Bachiller\BachillerGrupoUADYController@edit')->name('bachiller.bachiller_grupo_uady.edit');
Route::put('bachiller_grupo_uady/{id}', 'Bachiller\BachillerGrupoUADYController@update')->name('bachiller.bachiller_grupo_uady.update');
Route::get('bachiller_grupo_uady/{id}', 'Bachiller\BachillerGrupoUADYController@show')->name('bachiller.bachiller_grupo_uady.show');
Route::get('bachiller_grupo_uady/api/grupoEquivalente/{periodo_id}','Bachiller\BachillerGrupoUADYController@listEquivalente')->name('bachiller_grupo_uady/api/grupoEquivalente');
Route::get('bachiller_grupo_uady/materias/{semestre}/{planId}','Bachiller\BachillerMateriasController@getBachillerMaterias');
Route::get('api/bachiller_grupo_uady/infoEstado/{grupo_id}','Bachiller\BachillerGrupoUADYController@infoEstado');

Route::get('bachiller_grupo_uady/materiaComplementaria/{bachiller_materia_id}/{plan_id}/{periodo_id}/{grado}','Bachiller\BachillerGrupoUADYController@materiaComplementaria');
Route::get('bachiller_grupo_uady/api/departamentos/{id}','Bachiller\BachillerGrupoUADYController@getDepartamentos');
Route::get('bachiller_grupo_uady/api/escuelas/{id}/{otro?}','Bachiller\BachillerGrupoUADYController@getEscuelas');
Route::get('bachiller_grupo_uady/{id}/evidencia','Bachiller\BachillerGrupoUADYController@evidenciaTable')->name('bachiller.bachiller_grupo_uady.evidenciaTable');
Route::get('bachiller_grupo_uady/getGrupo/{id}','Bachiller\BachillerGrupoUADYController@getGrupo');
Route::get('bachiller_grupo_uady/getGrupos/{id}','Bachiller\BachillerGrupoUADYController@getGrupos');
Route::get('bachiller_grupo_uady/getMaterias/{id}','Bachiller\BachillerGrupoUADYController@getMaterias');
Route::get('bachiller_grupo_uady/getMesEvidencias/{id}','Bachiller\BachillerGrupoUADYController@getMesEvidencias'); //Get evidencias mes
Route::get('bachiller_grupo_uady/horario/{id}','Bachiller\BachillerGrupoUADYController@horario')->name('bachiller_grupo_uady.horario');
Route::get('bachiller_grupo_uady/eliminarHorario/{id}/{idGrupo}','Bachiller\BachillerGrupoUADYController@eliminarHorario');
Route::get('api/bachiller_grupo_uady/horario/{id}','Bachiller\BachillerGrupoUADYController@listHorario');
Route::get('api/bachiller_grupo_uady/horario_admin/{empleado_id}/{periodo_id}','Bachiller\BachillerGrupoUADYController@listHorarioAdmin');
Route::get('bachiller_grupo_uady/cambiarEstado/{id}/{estado_act}','Bachiller\BachillerGrupoUADYController@cambiarEstado');

Route::post('bachiller_grupo_uady/agregarHorario','Bachiller\BachillerGrupoUADYController@agregarHorario')->name('bachiller_grupo_uady.agregarHorario');
Route::post('bachiller_grupo_uady/verificarHorasRepetidas','Bachiller\BachillerGrupoUADYController@verificarHorasRepetidas');
Route::post('bachiller_grupo_uady/evidencias','Bachiller\BachillerGrupoUADYController@guardar_actualizar_evidencia')->name('bachiller.bachiller_grupo_uady.guardar_actualizar_evidencia');
Route::post('bachiller_grupo_uady/estadoGrupo','Bachiller\BachillerGrupoUADYController@estadoGrupo')->name('bachiller.estadoGrupo');

Route::get('bachiller_calificacion/getMeses/{mes}','Bachiller\BachillerGrupoUADYController@getMeses');
Route::get('bachiller_calificacion/getNumeroEvaluacion/{mes}','Bachiller\BachillerGrupoUADYController@getNumeroEvaluacion');
Route::get('bachiller_calificacion/api/getEvidencias/{id_grupo}/{id}','Bachiller\BachillerGrupoUADYController@getEvidencias');
Route::delete('bachiller_grupo_uady/{id}', 'Bachiller\BachillerGrupoUADYController@destroy')->name('bachiller.bachiller_grupo_uady.destroy');
Route::delete('bachiller_grupo_uady/ocultarGrupo/{id}', 'Bachiller\BachillerGrupoUADYController@ocultarGrupo')->name('bachiller.bachiller_grupo_uady.ocultarGrupo');


/* ---------------------------- Módulo de grupos Chetumal---------------------------- */
Route::get('bachiller_grupo_seq', 'Bachiller\BachillerGrupoSEQController@index')->name('bachiller.bachiller_grupo_seq.index');
Route::get('bachiller_grupo_seq/list', 'Bachiller\BachillerGrupoSEQController@list')->name('bachiller.bachiller_grupo_seq.list');
Route::get('bachiller_grupo_seq/create', 'Bachiller\BachillerGrupoSEQController@create')->name('bachiller.bachiller_grupo_seq.create');
Route::post('bachiller_grupo_seq', 'Bachiller\BachillerGrupoSEQController@store')->name('bachiller.bachiller_grupo_seq.store');
Route::get('bachiller_grupo_seq/{id}/edit', 'Bachiller\BachillerGrupoSEQController@edit')->name('bachiller.bachiller_grupo_seq.edit');
Route::put('bachiller_grupo_seq/{id}', 'Bachiller\BachillerGrupoSEQController@update')->name('bachiller.bachiller_grupo_seq.update');
Route::get('bachiller_grupo_seq/{id}', 'Bachiller\BachillerGrupoSEQController@show')->name('bachiller.bachiller_grupo_seq.show');
Route::get('bachiller_grupo_seq/api/grupoEquivalente/{periodo_id}','Bachiller\BachillerGrupoSEQController@listEquivalente')->name('bachiller_grupo_seq/api/grupoEquivalente');
Route::get('bachiller_grupo_seq/materias/{semestre}/{planId}','Bachiller\BachillerMateriasController@getBachillerMaterias');
Route::get('bachiller_grupo_seq/materiaComplementaria/{bachiller_materia_id}/{plan_id}/{periodo_id}/{grado}','Bachiller\BachillerGrupoSEQController@materiaComplementaria');
Route::get('bachiller_grupo_seq/api/departamentos/{id}','Bachiller\BachillerGrupoSEQController@getDepartamentos');
Route::get('bachiller_grupo_seq/api/escuelas/{id}/{otro?}','Bachiller\BachillerGrupoSEQController@getEscuelas');
Route::get('bachiller_grupo_seq/{id}/evidencia','Bachiller\BachillerGrupoSEQController@evidenciaTable')->name('bachiller.bachiller_grupo_seq.evidenciaTable');
Route::get('bachiller_grupo_seq/getGrupo/{id}','Bachiller\BachillerGrupoSEQController@getGrupo');
Route::get('bachiller_grupo_seq/getGrupos/{id}','Bachiller\BachillerGrupoSEQController@getGrupos');
Route::get('bachiller_grupo_seq/getMaterias/{id}','Bachiller\BachillerGrupoSEQController@getMaterias');
Route::get('bachiller_grupo_seq/getMesEvidencias/{id}','Bachiller\BachillerGrupoSEQController@getMesEvidencias'); //Get evidencias mes
Route::get('bachiller_grupo_seq/horario/{id}','Bachiller\BachillerGrupoSEQController@horario')->name('bachiller_grupo_seq.horario');
Route::get('bachiller_grupo_seq/eliminarHorario/{id}/{idGrupo}','Bachiller\BachillerGrupoSEQController@eliminarHorario');
Route::get('api/bachiller_grupo_seq/horario/{id}','Bachiller\BachillerGrupoSEQController@listHorario');
Route::get('api/bachiller_grupo_seq/horario_admin/{empleado_id}/{periodo_id}','Bachiller\BachillerGrupoSEQController@listHorarioAdmin');
Route::post('bachiller_grupo_seq/agregarHorario','Bachiller\BachillerGrupoSEQController@agregarHorario')->name('bachiller_grupo_seq.agregarHorario');
Route::post('bachiller_grupo_seq/verificarHorasRepetidas','Bachiller\BachillerGrupoSEQController@verificarHorasRepetidas');
Route::post('bachiller_grupo_seq/evidencias','Bachiller\BachillerGrupoSEQController@guardar_actualizar_evidencia')->name('bachiller.bachiller_grupo_seq.guardar_actualizar_evidencia');
Route::get('bachiller_calificacion_seq/getMeses/{mes}','Bachiller\BachillerGrupoSEQController@getMeses');
Route::get('bachiller_calificacion_seq/getNumeroEvaluacion/{mes}','Bachiller\BachillerGrupoSEQController@getNumeroEvaluacion');
Route::get('bachiller_calificacion_seq/api/getEvidencias/{id_grupo}/{id}','Bachiller\BachillerGrupoSEQController@getEvidencias');
Route::delete('bachiller_grupo_seq/{id}', 'Bachiller\BachillerGrupoSEQController@destroy')->name('bachiller.bachiller_grupo_seq.destroy');

/* ------------------------ Módulo de asignar grupos Mérida - Valladolid------------------------ */
Route::get('/bachiller_asignar_grupo', 'Bachiller\BachillerAsignarGrupoController@index')->name('bachiller.bachiller_asignar_grupo.index');
Route::get('/bachiller_asignar_grupo/list', 'Bachiller\BachillerAsignarGrupoController@list')->name('bachiller.bachiller_asignar_grupo.list');
Route::get('/bachiller_asignar_grupo/create', 'Bachiller\BachillerAsignarGrupoController@create')->name('bachiller.bachiller_asignar_grupo.create');
Route::get('/bachiller_asignar_grupo/create_por_grupo', 'Bachiller\BachillerAsignarGrupoController@create_por_grupo')->name('bachiller.bachiller_asignar_grupo.create_por_grupo');

Route::post('/bachiller_asignar_grupo', 'Bachiller\BachillerAsignarGrupoController@store')->name('bachiller.bachiller_asignar_grupo.store');
Route::get('bachiller_asignar_grupo/{id}/edit', 'Bachiller\BachillerAsignarGrupoController@edit')->name('bachiller.bachiller_asignar_grupo.edit');
Route::put('bachiller_asignar_grupo/{id}', 'Bachiller\BachillerAsignarGrupoController@update')->name('bachiller.bachiller_asignar_grupo.update');
Route::get('bachiller_asignar_grupo/{id}', 'Bachiller\BachillerAsignarGrupoController@show')->name('bachiller.bachiller_asignar_grupo.show');
Route::delete('bachiller_asignar_grupo/{id}', 'Bachiller\BachillerAsignarGrupoController@destroy')->name('bachiller.bachiller_asignar_grupo.destroy');
Route::get('bachiller_asignar_grupo/cambiar_grupo/{inscritoId}', 'Bachiller\BachillerAsignarGrupoController@cambiarGrupo')->name('bachiller.bachiller_asignar_grupo.cambiar_grupo');
Route::post('bachiller_asignar_grupo/postCambiarGrupo', 'Bachiller\BachillerAsignarGrupoController@postCambiarGrupo')->name('bachiller.bachiller_asignar_grupo.postCambiarGrupo');
// Route::get('api/grupos/{curso_id}','Bachiller\BachillerAsignarGrupoController@getGrupos');
Route::get('bachiller_asignar_grupo/obtener_grupos/{curso_id}','Bachiller\BachillerAsignarGrupoController@ObtenerGrupos');
Route::get('bachiller_asignar_grupo/cgt_actual/{curso_id}','Bachiller\BachillerAsignarGrupoController@cargaCGTActual');
Route::get('bachiller_asignar_grupo/obtener_grupos_materias/{curso_id}','Bachiller\BachillerAsignarGrupoController@ObtenerGruposMaterias');
Route::get('bachiller_asignar_grupo/obtener_grupos_materias_acd_ingles/{curso_id}','Bachiller\BachillerAsignarGrupoController@ObtenerGruposMateriasACDIngles');
Route::get('bachiller_asignar_grupo/obtener_grupos_materias_optativas/{curso_id}','Bachiller\BachillerAsignarGrupoController@ObtenerGruposMateriasOptativas');
Route::get('bachiller_asignar_grupo/obtener_grupos_materias_ocupacionales/{curso_id}','Bachiller\BachillerAsignarGrupoController@ObtenerGruposMateriasOcupacinales');
Route::get('bachiller_asignar_grupo/obtener_grupos_materias_complementaria/{curso_id}','Bachiller\BachillerAsignarGrupoController@ObtenerGruposMateriasComplementaria');
Route::get('bachiller_asignar_grupo/obtener_grupos_materias_extra/{curso_id}','Bachiller\BachillerAsignarGrupoController@ObtenerGruposMateriasExtra');
Route::get('bachiller_asignar_grupo/obtener_grupos_materias_competencias/{curso_id}','Bachiller\BachillerAsignarGrupoController@ObtenerGruposMateriasCompetencias');


Route::get('bachiller_asignar_grupo/getDepartamentos/{id}','Bachiller\BachillerAsignarGrupoController@getDepartamentos');
Route::get('bachiller_asignar_grupo/getEscuelas/{id}/{otro?}','Bachiller\BachillerAsignarGrupoController@getEscuelas');
Route::get('bachiller_asignar_grupo/cgts_destino/{plan_id}/{periodo_id}/{semestre}','Bachiller\BachillerAsignarGrupoController@getCgtsDestino');
Route::get('bachiller_asignar_grupo/api/cursos/{periodo_id}/{semestre}','Bachiller\BachillerAsignarGrupoController@getCursosSemestre');
Route::post('/bachiller_asignar_grupo/por_grupo', 'Bachiller\BachillerAsignarGrupoController@store_por_grupo')->name('bachiller.bachiller_asignar_grupo.store_por_grupo');


//APLICAR PAGOS MANUALES
Route::get('bachiller/pagos/aplicar_pagos','Bachiller\BachillerAplicarPagosController@index');
Route::get('bachiller/api/pagos/listadopagos','Bachiller\BachillerAplicarPagosController@list');
Route::get('bachiller/pagos/aplicar_pagos/create','Bachiller\BachillerAplicarPagosController@create');
Route::get('bachiller/pagos/aplicar_pagos/edit/{id}','Bachiller\BachillerAplicarPagosController@edit');
Route::post('bachiller/pagos/aplicar_pagos/update','Bachiller\BachillerAplicarPagosController@update')->name("bachillerAplicarPagos.update");
Route::post('bachiller/pagos/aplicar_pagos/existeAlumnoByClavePago','Bachiller\BachillerAplicarPagosController@existeAlumnoByClavePago')->name("bachillerAplicarPagos.existeAlumnoByClavePago");
Route::post('bachiller/pagos/aplicar_pagos/store','Bachiller\BachillerAplicarPagosController@store')->name("bachillerAplicarPagos.store");
Route::delete('bachiller/pagos/aplicar_pagos/delete/{id}','Bachiller\BachillerAplicarPagosController@destroy')->name("bachillerAplicarPagos.destroy");
Route::get('bachiller/pagos/aplicar_pagos/detalle/{pagoId}','Bachiller\BachillerAplicarPagosController@detalle')->name("bachillerAplicarPagos.detalle");
Route::post('bachiller/api/pagos/verificarExistePago/','Bachiller\BachillerAplicarPagosController@verificarExistePago')->name("bachillerAplicarPagos.verificarExistePago");
Route::get('bachiller/api/aplicar_pagos/buscar_inscripciones_educacion_continua/{pagClaveAlu}', 'Bachiller\BachillerAplicarPagosController@getInscripcionesEducacionContinua');

/* ------------------------ Módulo de asignar grupos Chetumal------------------------ */
Route::get('/bachiller_asignar_grupo_seq', 'Bachiller\BachillerAsignarGrupoSEQController@index')->name('bachiller.bachiller_asignar_grupo_seq.index');
Route::get('/bachiller_asignar_grupo_seq/list', 'Bachiller\BachillerAsignarGrupoSEQController@list')->name('bachiller.bachiller_asignar_grupo_seq.list');
Route::get('/bachiller_asignar_grupo_seq/create', 'Bachiller\BachillerAsignarGrupoSEQController@create')->name('bachiller.bachiller_asignar_grupo_seq.create');
Route::get('/bachiller_asignar_grupo_seq/create_por_grupo', 'Bachiller\BachillerAsignarGrupoSEQController@create_por_grupo')->name('bachiller.bachiller_asignar_grupo_seq.create_por_grupo');
Route::get('bachiller_asignar_grupo_seq/create_inscrito_recuperacion', 'Bachiller\BachillerAsignarGrupoSEQController@create_inscrito_recuperacion')->name('bachiller.bachiller_asignar_grupo_seq.create_inscrito_recuperacion');

Route::get('bachiller_asignar_grupo_seq/api/cursos/{periodo_id}/{semestre}','Bachiller\BachillerAsignarGrupoSEQController@getCursosSemestre');
Route::get('bachiller_asignar_grupo_seq/cgt_actual/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@cargaCGTActual');
Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMaterias');
Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias_paraescolar/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMateriasParaEscolar');
Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias_extra/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMateriasExtra');

// Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias_acd_ingles/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMateriasACDIngles');
// Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias_optativas/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMateriasOptativas');
// Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias_ocupacionales/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMateriasOcupacinales');
// Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias_complementaria/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMateriasComplementaria');
Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias_competencias/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMateriasCompetencias');
Route::get('bachiller_asignar_grupo_seq/obtener_grupos_materias_especialidad/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposMateriasEspecialidad');

Route::post('/bachiller_asignar_grupo_seq', 'Bachiller\BachillerAsignarGrupoSEQController@store')->name('bachiller.bachiller_asignar_grupo_seq.store');
Route::get('bachiller_asignar_grupo_seq/{id}/edit', 'Bachiller\BachillerAsignarGrupoSEQController@edit')->name('bachiller.bachiller_asignar_grupo_seq.edit');
Route::put('bachiller_asignar_grupo_seq/{id}', 'Bachiller\BachillerAsignarGrupoSEQController@update')->name('bachiller.bachiller_asignar_grupo_seq.update');
Route::get('bachiller_asignar_grupo_seq/{id}', 'Bachiller\BachillerAsignarGrupoSEQController@show')->name('bachiller.bachiller_asignar_grupo_seq.show');
Route::delete('bachiller_asignar_grupo_seq/{id}', 'Bachiller\BachillerAsignarGrupoSEQController@destroy')->name('bachiller.bachiller_asignar_grupo_seq.destroy');
Route::get('bachiller_asignar_grupo_seq/cambiar_grupo/{inscritoId}', 'Bachiller\BachillerAsignarGrupoSEQController@cambiarGrupo')->name('bachiller.bachiller_asignar_grupo_seq.cambiar_grupo');
Route::post('bachiller_asignar_grupo_seq/postCambiarGrupo', 'Bachiller\BachillerAsignarGrupoSEQController@postCambiarGrupo')->name('bachiller.bachiller_asignar_grupo_seq.postCambiarGrupo');
// Route::get('api/grupos/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@getGrupos');
Route::get('bachiller_asignar_grupo_seq/obtener_grupos/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGrupos');
Route::get('bachiller_asignar_grupo_seq/obtener_grupos_recuperacion/{curso_id}','Bachiller\BachillerAsignarGrupoSEQController@ObtenerGruposRecuperacion');

Route::get('bachiller_asignar_grupo_seq/getDepartamentos/{id}','Bachiller\BachillerAsignarGrupoSEQController@getDepartamentos');
Route::get('bachiller_asignar_grupo_seq/getEscuelas/{id}/{otro?}','Bachiller\BachillerAsignarGrupoSEQController@getEscuelas');
Route::post('/bachiller_asignar_grupo_seq/por_grupo', 'Bachiller\BachillerAsignarGrupoSEQController@store_por_grupo')->name('bachiller.bachiller_asignar_grupo_seq.store_por_grupo');


/* --------------------------- Módulo de inscritos -------------------------- */
Route::get('bachiller_inscritos/list/{grupo_id}','Bachiller\BachillerInscritosController@list')->name('api/bachiller_inscritos/{grupo_id}');
Route::get('bachiller_inscritos/{grupo_id}', 'Bachiller\BachillerInscritosController@index')->name('bachiller.bachiller_inscritos/{grupo_id}');
// Route::get('bachiller_inscritos/calificaciones/primerreporte/{inscrito_id}/{persona_id}/{grado}/{grupo}', 'Bachiller\BachillerCalificacionesController@reporteTrimestre');
Route::get('bachiller_inscritos/pase_lista/{grupo_id}', 'Bachiller\BachillerInscritosController@pase_de_lista')->name('bachiller.bachiller_inscritos/pase_lista/{grupo_id}');
Route::get('bachiller_inscritos/obtenerAlumnosPaseLista/{grupo_id}/{fecha}', 'Bachiller\BachillerInscritosController@obtenerAlumnosPaseLista');
Route::post('bachiller_inscritos/asistencia_alumnos/', 'Bachiller\BachillerInscritosController@asistencia_alumnos')->name('bachiller.bachiller_inscritos.asistencia_alumnos');
Route::post('bachiller_inscritos/pase_lista/', 'Bachiller\BachillerInscritosController@guardarPaseLista')->name('bachiller.bachiller_inscritos.guardarPaseLista');

/* --------------------------- Módulo de inscritos Chetumal-------------------------- */
Route::get('bachiller_inscritos_seq/list/{grupo_id}','Bachiller\BachillerInscritosSEQController@list')->name('api/bachiller_inscritos_seq/{grupo_id}');
Route::get('bachiller_inscritos_seq/{grupo_id}', 'Bachiller\BachillerInscritosSEQController@index')->name('bachiller.bachiller_inscritos_seq/{grupo_id}');
Route::get('bachiller_inscritos_seq/calificaciones/primerreporte/{inscrito_id}/{persona_id}/{grado}/{grupo}', 'Bachiller\BachillerCalificacionesSEQController@reporteTrimestre');
Route::get('bachiller_inscritos_seq/pase_lista/{grupo_id}', 'Bachiller\BachillerInscritosSEQController@pase_de_lista')->name('bachiller.bachiller_inscritos_seq/pase_lista/{grupo_id}');
Route::get('bachiller_inscritos_seq/obtenerAlumnosPaseLista/{grupo_id}/{fecha}', 'Bachiller\BachillerInscritosSEQController@obtenerAlumnosPaseLista');
Route::post('bachiller_inscritos_seq/asistencia_alumnos/', 'Bachiller\BachillerInscritosSEQController@asistencia_alumnos')->name('bachiller.bachiller_inscritos_seq.asistencia_alumnos');
Route::post('bachiller_inscritos_seq/pase_lista/', 'Bachiller\BachillerInscritosSEQController@guardarPaseLista')->name('bachiller.bachiller_inscritos_seq.guardarPaseLista');

/* ------------------------ Módulo de calificaciones ------------------------ */
Route::resource('bachiller_calificacion_seq','Bachiller\BachillerCalificacionesSEQController');
Route::get('bachiller_calificacion_seq/{inscrito_id}/{grupo_id}', 'Bachiller\BachillerCalificacionesSEQController@index');
Route::get('bachiller_calificacion_seq/create', 'Bachiller\BachillerCalificacionesSEQController@create')->name('bachiller.bachiller_calificacion_seq.create');
Route::get('bachiller_calificacion_seq/api/getAlumnos/{id}','Bachiller\BachillerCalificacionesSEQController@getAlumnos');
Route::get('bachiller_calificacion_seq/api/getGrupos/{id}','Bachiller\BachillerCalificacionesSEQController@getGrupos');
Route::get('bachiller_calificacion_seq/api/getMaterias2/{id}','Bachiller\BachillerCalificacionesSEQController@getMaterias2');
Route::get('bachiller_calificacion_seq/grupo/{id}/edit','Bachiller\BachillerCalificacionesSEQController@edit_calificacion')->name('bachiller.bachiller_grupo.calificaciones.edit_calificacion');
Route::get('bachiller_calificacion_seq/getCalificacionesAlumnosCCH/{bachiller_cch_grupo_id}/{que_calificar}','Bachiller\BachillerCalificacionesSEQController@getCalificacionesAlumnosCCH');

Route::post('bachiller_calificacion_seq/guardarCalificacion', 'Bachiller\BachillerCalificacionesSEQController@guardarCalificacion')->name('bachiller.bachiller_calificacion_seq.guardarCalificacion');
Route::post('bachiller_calificacion_seq/calificaciones_ordinarias','Bachiller\BachillerCalificacionesSEQController@update_calificacion_ordinarios')->name('bachiller.bachiller_calificacion_seq.calificaciones.update_calificacion_ordinarios');
Route::post('bachiller_calificacion_seq/calificaciones_recuperativos','Bachiller\BachillerCalificacionesSEQController@update_calificacion_recuperativos')->name('bachiller.bachiller_calificacion_seq.calificaciones.update_calificacion_recuperativos');
Route::post('bachiller_calificacion_seq/calificaciones_extraregular','Bachiller\BachillerCalificacionesSEQController@update_calificacion_extraregular')->name('bachiller.bachiller_calificacion_seq.calificaciones.update_calificacion_extraregular');
Route::post('bachiller_calificacion_seq/calificaciones_especial','Bachiller\BachillerCalificacionesSEQController@update_calificacion_especial')->name('bachiller.bachiller_calificacion_seq.calificaciones.update_calificacion_especial');

Route::get('bachiller/boletaAlumnoCurso/{curso_id}','Bachiller\BachillerCalificacionesSEQController@boletadesdecurso')->name('bachiller.boletadesdecurso');


//Cargar Materias a inscrito
Route::get('bachiller_materias_inscrito', 'Bachiller\BachillerMateriasInscritoDController@index')->name('bachiller.bachiller_materias_inscrito.index');
Route::get('bachiller_materias_inscrito/ultimo_curso/{alumno_id}', 'Bachiller\BachillerMateriasInscritoDController@ultimoCurso');
Route::post('bachiller_materias_inscrito/api/getMultipleAlumnosByFilter','Bachiller\BachillerMateriasInscritoDController@getMultipleAlumnosByFilter');
Route::post('bachiller_materias_inscrito', 'Bachiller\BachillerMateriasInscritoDController@store')->name('bachiller.bachiller_materias_inscrito.store');

// CGT Materias
Route::get('bachiller_cgt_materias','Bachiller\BachillerCGTMateriasController@index')->name('bachiller.bachiller_cgt_materias.index');
Route::get('bachiller_cgt_materias/obtenerMaterias/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerCGTMateriasController@obtenerMaterias');
Route::post('bachiller_cgt_materias','Bachiller\BachillerCGTMateriasController@store')->name('bachiller.bachiller_cgt_materias.store');


//Asignar docente CGT
Route::get('bachiller_asignar_docente','Bachiller\BachillerAsignarDocenteCGTController@index')->name('bachiller.bachiller_asignar_docente.index');
Route::get('bachiller_asignar_docente/obtenerGrupos/get/{ubicacion}/{periodo_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerAsignarDocenteCGTController@obtenerGrupos');
Route::post('bachiller_asignar_docente','Bachiller\BachillerAsignarDocenteCGTController@store')->name('bachiller.bachiller_asignar_docente.store');

// Empleados
Route::get('/bachiller_empleado', 'Bachiller\BachillerEmpleadoController@index')->name('bachiller.bachiller_empleado.index');
Route::get('/bachiller_empleado/create', 'Bachiller\BachillerEmpleadoController@create')->name('bachiller.bachiller_empleado.create');
Route::get('/bachiller_empleado/list', 'Bachiller\BachillerEmpleadoController@list')->name('bachiller.bachiller_empleado.list');
Route::get('bachiller_empleado/cambio-estado', 'Bachiller\BachillerEmpleadoController@cambioEstado')->name('bachiller_empleado.cambio-estado');
Route::get('api/bachiller_empleado/{escuela?}','Bachiller\BachillerEmpleadoController@listEmpleados');
Route::get('bachiller_empleado/verificar_persona', 'Bachiller\BachillerEmpleadoController@verificarExistenciaPersona');
Route::get('bachiller_empleado/{id}','Bachiller\BachillerEmpleadoController@show')->name('bachiller.bachiller_empleado.show');
Route::get('bachiller_empleado/{id}/edit','Bachiller\BachillerEmpleadoController@edit')->name('bachiller.bachiller_empleado.edit');
Route::get('bachiller_empleado/verificar_delete/{empleado_id}', 'Bachiller\BachillerEmpleadoController@puedeSerEliminado')->name('bachiller.bachiller_empleado/verificar_delete/{empleado_id}');

Route::put('bachiller_empleado/{id}','Bachiller\BachillerEmpleadoController@update')->name('bachiller.bachiller_empleado.update');
Route::post('bachiller_empleado/reactivar_empleado/{empleado_id}','Bachiller\BachillerEmpleadoController@reactivarEmpleado')->name('bachiller.bachiller_empleado/reactivar_empleado/{empleado_id}');
Route::post('bachiller_empleado/registrar_alumno/{alumno_id}', 'Bachiller\BachillerEmpleadoController@alumno_crearEmpleado')->name('bachiller.bachiller_empleado/registrar_alumno/{alumno_id}');
Route::post('bachiller_empleado','Bachiller\BachillerEmpleadoController@store')->name('bachiller.bachiller_empleado.store');
Route::post('bachiller_empleado/darBaja/{empleado_id}', 'Bachiller\BachillerEmpleadoController@darDeBaja')->name('bachiller.bachiller_empleado/darBaja/{empleado_id}');
Route::post('bachiller_cambiar_status_empleado/actualizar_lista', 'Bachiller\BachillerEmpleadoController@cambiarMultiplesStatusEmpleados');
Route::delete('bachiller_empleado/{id}','Bachiller\BachillerEmpleadoController@destroy')->name('bachiller.bachiller_empleado.destroy');


// Cambiar contraseña docente
Route::get('bachiller_cambiar_contrasenia', 'Bachiller\BachillerCambiarContraseniaController@index')->name('bachiller.bachiller_cambiar_contrasenia.index');
Route::get('bachiller_cambiar_contrasenia/list', 'Bachiller\BachillerCambiarContraseniaController@list');
Route::get('bachiller_cambiar_contrasenia/getEmpleadoCorreo/{id}', 'Bachiller\BachillerCambiarContraseniaController@getEmpleadoCorreo');
Route::get('bachiller_cambiar_contrasenia/create', 'Bachiller\BachillerCambiarContraseniaController@create')->name('bachiller.bachiller_cambiar_contrasenia.create');
Route::get('bachiller_cambiar_contrasenia/{id}/edit', 'Bachiller\BachillerCambiarContraseniaController@edit');
Route::get('bachiller_cambiar_contrasenia/{id}', 'Bachiller\BachillerCambiarContraseniaController@show');
Route::post('bachiller_cambiar_contrasenia', 'Bachiller\BachillerCambiarContraseniaController@store')->name('bachiller.bachiller_cambiar_contrasenia.store');
Route::put('bachiller_cambiar_contrasenia/{id}', 'Bachiller\BachillerCambiarContraseniaController@update')->name('bachiller.bachiller_cambiar_contrasenia.update');


/* -------------------------- Módulo de calendario -------------------------- */
Route::resource('bachiller_calendario', 'Bachiller\BachillerAgendaController');
Route::get('/bachiller_calendario', 'Bachiller\BachillerAgendaController@index')->name('bachiller.bachiller_calendario.index');
Route::get('/bachiller_calendario/show', 'Bachiller\BachillerAgendaController@show')->name('bachiller.bachiller_calendario.show');


//Fecha publicacion Docente
Route::get('bachiller_fecha_publicacion_calificacion_docente','Bachiller\BachillerFechaPublicacionControllerDocente@index')->name('bachiller.bachiller_fecha_publicacion_calificacion_docente.index');
Route::get('bachiller_fecha_publicacion_calificacion_docente/list','Bachiller\BachillerFechaPublicacionControllerDocente@list');
Route::get('bachiller_fecha_publicacion_calificacion_docente/create','Bachiller\BachillerFechaPublicacionControllerDocente@create')->name('bachiller.bachiller_fecha_publicacion_calificacion_docente.create');
Route::get('bachiller_fecha_publicacion_calificacion_docente/{id}/edit','Bachiller\BachillerFechaPublicacionControllerDocente@edit')->name('bachiller.bachiller_fecha_publicacion_calificacion_docente.edit');
Route::get('bachiller_fecha_publicacion_calificacion_docente/getMesEvaluaciones/{departamento_id}','Bachiller\BachillerFechaPublicacionControllerDocente@getMesEvaluaciones');
Route::post('bachiller_fecha_publicacion_calificacion_docente','Bachiller\BachillerFechaPublicacionControllerDocente@store')->name('bachiller.bachiller_fecha_publicacion_calificacion_docente.store');
Route::put('bachiller_fecha_publicacion_calificacion_docente/{id}','Bachiller\BachillerFechaPublicacionControllerDocente@update')->name('bachiller.bachiller_fecha_publicacion_calificacion_docente.update');

// Fecha publicacion Alumno
Route::get('bachiller_fecha_publicacion_calificacion_alumno','Bachiller\BachillerFechaPublicacionControllerAlumno@index')->name('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index');
Route::get('bachiller_fecha_publicacion_calificacion_alumno/list','Bachiller\BachillerFechaPublicacionControllerAlumno@list');
Route::get('bachiller_fecha_publicacion_calificacion_alumno/create','Bachiller\BachillerFechaPublicacionControllerAlumno@create')->name('bachiller.bachiller_fecha_publicacion_calificacion_alumno.create');
Route::get('bachiller_fecha_publicacion_calificacion_alumno/{id}/edit','Bachiller\BachillerFechaPublicacionControllerAlumno@edit')->name('bachiller.bachiller_fecha_publicacion_calificacion_alumno.edit');
Route::post('bachiller_fecha_publicacion_calificacion_alumno','Bachiller\BachillerFechaPublicacionControllerAlumno@store')->name('bachiller.bachiller_fecha_publicacion_calificacion_alumno.store');
Route::put('bachiller_fecha_publicacion_calificacion_alumno/{id}','Bachiller\BachillerFechaPublicacionControllerAlumno@update')->name('bachiller.bachiller_fecha_publicacion_calificacion_alumno.update');

// observaciones boleta
Route::get('bachiller_obs_boleta','Bachiller\BachillerObservacionesBoletaController@index')->name('bachiller.bachiller_obs_boleta.index');
Route::get('bachiller_obs_boleta/obtenerObsBoleta/{plan_id}/{periodo_id}/{cgt_id}/{mes}','Bachiller\BachillerObservacionesBoletaController@obtenerObsBoleta');
Route::post('bachiller_obs_boleta/','Bachiller\BachillerObservacionesBoletaController@guardar')->name('bachiller.bachiller_obs_boleta.guardar');


// Horarios administrativos
Route::get('bachiller_horarios_administrativos','Bachiller\BachillerHorariosAdministrativosController@index')->name('bachiller.bachiller_horarios_administrativos');
Route::get('api/bachiller_horarios_administrativos','Bachiller\BachillerHorariosAdministrativosController@list')->name('api/bachiller_horarios_administrativos');
Route::get('bachiller_horarios_administrativos/{claveMaestro}/{periodoId}/calendario','Bachiller\BachillerHorariosAdministrativosController@horariosAdministrativos');
Route::get('api/bachiller_horarios_administrativos/horario/{claveMaestro}/{periodoId}','Bachiller\BachillerHorariosAdministrativosController@listHorario');
Route::get('api/bachiller_horarios_administrativos/horario_gpo/{claveMaestro}/{periodoId}','Bachiller\BachillerHorariosAdministrativosController@listHorarioGpo');
Route::get('bachiller_horarios_administrativos/eliminarHorario/{id}','Bachiller\BachillerHorariosAdministrativosController@eliminarHorario');
Route::post('bachiller_horarios_administrativos/agregarHorarios','Bachiller\BachillerHorariosAdministrativosController@agregarHorarios');


// Horarios administrativos
Route::get('bachiller_horarios_administrativos_seq','Bachiller\BachillerHorariosAdministrativosSEQController@index')->name('bachiller.bachiller_horarios_administrativos_seq');
Route::get('api/bachiller_horarios_administrativos_seq','Bachiller\BachillerHorariosAdministrativosSEQController@list')->name('api/bachiller_horarios_administrativos_seq');
Route::get('bachiller_horarios_administrativos_seq/{claveMaestro}/{periodoId}/calendario','Bachiller\BachillerHorariosAdministrativosSEQController@horariosAdministrativos');
Route::get('api/bachiller_horarios_administrativos_seq/horario/{claveMaestro}/{periodoId}','Bachiller\BachillerHorariosAdministrativosSEQController@listHorario');
Route::get('api/bachiller_horarios_administrativos_seq/horario_gpo/{claveMaestro}/{periodoId}','Bachiller\BachillerHorariosAdministrativosSEQController@listHorarioGpo');
Route::get('bachiller_horarios_administrativos_seq/eliminarHorario/{id}','Bachiller\BachillerHorariosAdministrativosSEQController@eliminarHorario');
Route::post('bachiller_horarios_administrativos_seq/agregarHorarios','Bachiller\BachillerHorariosAdministrativosSEQController@agregarHorarios');

Route::post('bachiller_recuperativos/cambio_estado_pago','Bachiller\BachillerExtraordinarioController@cambio_estado_pago')->name('bachiller_recuperativos.cambio_estado_pago');
Route::get('bachiller_recuperativos/imprimirComprobante/{ids}', 'Bachiller\BachillerExtraordinarioController@imprimirComprobante');

//Solicitud de ExtraOrdinarios
Route::get('recibo/bachiller_solicitud/{id}','Bachiller\BachillerExtraordinarioController@solicitudRecibo')->name('recibo.bachiller_solicitud');
// Extraordinario Route
Route::get('bachiller_recuperativos/crearReporte', 'Bachiller\BachillerExtraordinarioController@crearReporte');
Route::get('bachiller_recuperativos/pago_recuperativo','Bachiller\BachillerExtraordinarioController@pago_extras')->name('bachiller_recuperativos.pago_recuperativo');
Route::get('bachiller_recuperativos/pago_recuperativo/extras_cargadas/{periodo_id}/{plan_id}/{alumno_id}','Bachiller\BachillerExtraordinarioController@extras_cargadas');
Route::get('bachiller_recuperativos/getAlumnosCursoRecu/{periodo_id}/{plan_id}', 'Bachiller\BachillerExtraordinarioController@getAlumnosCurso');
Route::post('bachiller_recuperativos/generarReporte', 'Bachiller\BachillerExtraordinarioController@generarReporte')->name('bachiller.bachiller_recuperativos.generarReporte');
Route::resource('bachiller_recuperativos','Bachiller\BachillerExtraordinarioController');
Route::get('api/bachiller_recuperativos','Bachiller\BachillerExtraordinarioController@list')->name('api/bachiller_recuperativos');
Route::get('api/bachiller_recuperativos/{extraordinario_id}','Bachiller\BachillerExtraordinarioController@getExtraordinario');
Route::get('api/solicitud/bachiller_recuperativos','Bachiller\BachillerExtraordinarioController@list_solicitudes')->name('api.solicitud.bachiller_recuperativos');
Route::get('api/bachiller_recuperativos/getAlumnosByFolioExtraordinario/{extraordinario_id}',
  'Bachiller\BachillerExtraordinarioController@getAlumnosByFolioExtraordinario')->name('api/bachiller_recuperativos/getAlumnosByFolioExtraordinario/{extraordinario_id}');
Route::get('api/bachiller_recuperativos/validarAlumnoPresentaExtra/{folioExt}/{alumno}',
  'Bachiller\BachillerExtraordinarioController@validarAlumnoPresentaExtra')->name('api/bachiller_recuperativos/validarAlumnoPresentaExtra');
Route::get('bachiller_calificacion/agregarextra/{extraordinario_id}','Bachiller\BachillerExtraordinarioController@agregarExtra');
Route::get('bachiller_calificacion/getFechasRegularizacion/{periodo_id}/{plan_id}/{extTipo}','Bachiller\BachillerExtraordinarioController@getFechasRegularizacion');
Route::get('bachiller_recuperativos/{id}/edit_docente', 'Bachiller\BachillerExtraordinarioController@editar_docente');
Route::get('solicitudes/bachiller_recuperativos','Bachiller\BachillerExtraordinarioController@solicitudes');
Route::get('create/bachiller_solicitud','Bachiller\BachillerExtraordinarioController@solicitudCreate');
Route::post('store/bachiller_solicitud','Bachiller\BachillerExtraordinarioController@solicitudStore')->name('store.bachiller_solicitud');
Route::get('edit/bachiller_solicitud/{id}','Bachiller\BachillerExtraordinarioController@solicitudEdit')->name('edit.bachiller_solicitud');
Route::get('bachiller_solicitud/pagos/ficha_general','Bachiller\BachillerExtraordinarioController@fecha_general_index')->name('bachiller.bachiller_recuperativos.fecha_general_index');
Route::get('bachiller_extraordinario/api/curso/alumno/{aluClave}/{cuoAnio}','Bachiller\BachillerExtraordinarioController@getCursoAlumno');
Route::put('update/bachiller_solicitud/{id}','Bachiller\BachillerExtraordinarioController@solicitudUpdate')->name('update.bachiller_solicitud');
Route::put('bachiller_recuperativos/update_docente/{id}','Bachiller\BachillerExtraordinarioController@update_docente')->name('bachiller.bachiller_recuperativos.update_docente');
Route::get('show/bachiller_solicitud/{id}','Bachiller\BachillerExtraordinarioController@solicitudShow')->name('show.bachiller_solicitud');
Route::get('cancelar/bachiller_solicitud/{id}','Bachiller\BachillerExtraordinarioController@solicitudCancelar')->name('cancelar.bachiller_solicitud');
Route::post('bachiller_recuperativos/actaexamen/{extraordinario_id}','Bachiller\BachillerExtraordinarioController@actaExamen');
Route::get('api/bachiller_recuperativos/validarAlumno/{aluClave}','Bachiller\BachillerExtraordinarioController@validarAlumno')->name('api/bachiller_recuperativos/validarAlumno');
Route::get('bachiller_recuperativos/getDebeRecuperativos/{aluClave}/{perAnio}/{perNumero}','Bachiller\BachillerExtraordinarioController@getDebeRecuperativos');

Route::post('bachiller_recuperativos/pagos/ficha_general/store','Bachiller\BachillerFichaGeneralExtraordinarioController@store')->name('bachiller.bachiller_recuperativos.storePagoExtra');


//Route::get('bachiller_recuperativos/pagos/ficha_general/imprimebbva','Bachiller\BachillerFichaGeneralExtraordinarioController@imprimebbva')->name('bachiller.bachiller_recuperativos.imprimefichaBBVA');

//Ruta para imprimir acta de examen extraordinario en el datatable
// Route::post('extraordinario/actaexamen/{extraordinario_id}','Bachiller\BachillerExtraordinarioController@actaExamen');
Route::post('bachiller_recuperativos/extraStore','Bachiller\BachillerExtraordinarioController@extraStore')->name('bachiller.bachiller_recuperativos.extraStore');

Route::post('bachiller_recuperativos/updateEstadoPago','Bachiller\BachillerExtraordinarioController@updateEstadoPago')->name('bachiller.updateEstadoPago');

Route::get('bachiller_recuperativos/abrirElActaRecuperativo/{extraordinario_id}','Bachiller\BachillerExtraordinarioController@abrirElActaRecuperativo');



//Solicitud de curso recuperativo
Route::get('recibo/bachiller_curso_recuperativo/{id}','Bachiller\BachillerCursoRecuperativoController@solicitudRecibo')->name('recibo.bachiller_curso_recuperativo');
// curso recuperativo Route
Route::resource('bachiller_curso_recuperativo','Bachiller\BachillerCursoRecuperativoController');
Route::get('api/bachiller_curso_recuperativo','Bachiller\BachillerCursoRecuperativoController@list')->name('api/bachiller_curso_recuperativo');
Route::get('api/bachiller_curso_recuperativo/{extraordinario_id}','Bachiller\BachillerCursoRecuperativoController@getExtraordinario');
Route::get('api/solicitud/bachiller_curso_recuperativo','Bachiller\BachillerCursoRecuperativoController@list_solicitudes')->name('api.solicitud.bachiller_curso_recuperativo');
Route::get('api/bachiller_curso_recuperativo/getAlumnosByFolioExtraordinario/{extraordinario_id}',
  'Bachiller\BachillerCursoRecuperativoController@getAlumnosByFolioExtraordinario')->name('api/bachiller_curso_recuperativo/getAlumnosByFolioExtraordinario/{extraordinario_id}');
Route::get('api/bachiller_curso_recuperativo/validarAlumnoPresentaExtra/{folioExt}/{alumno}',
  'Bachiller\BachillerCursoRecuperativoController@validarAlumnoPresentaExtra')->name('api/bachiller_curso_recuperativo/validarAlumnoPresentaExtra');
// Route::get('bachiller_calificacion/agregarextra/{extraordinario_id}','Bachiller\BachillerCursoRecuperativoController@agregarExtra');
Route::get('solicitudes/bachiller_curso_recuperativo','Bachiller\BachillerCursoRecuperativoController@solicitudes');
Route::get('create/bachiller_curso_recuperativo','Bachiller\BachillerCursoRecuperativoController@solicitudCreate');
Route::post('store/bachiller_curso_recuperativo','Bachiller\BachillerCursoRecuperativoController@solicitudStore')->name('store.bachiller_curso_recuperativo');
Route::get('edit/bachiller_curso_recuperativo/{id}','Bachiller\BachillerCursoRecuperativoController@solicitudEdit')->name('edit.bachiller_curso_recuperativo');
// Route::put('update/bachiller_solicitud/{id}','Bachiller\BachillerCursoRecuperativoController@solicitudUpdate')->name('update.bachiller_curso_recuperativo');
Route::get('show/bachiller_curso_recuperativo/{id}','Bachiller\BachillerCursoRecuperativoController@solicitudShow')->name('show.bachiller_curso_recuperativo');
Route::get('cancelar/bachiller_curso_recuperativo/{id}','Bachiller\BachillerCursoRecuperativoController@solicitudCancelar')->name('cancelar.bachiller_curso_recuperativo');
Route::post('bachiller_curso_recuperativo/actaexamen/{extraordinario_id}','Bachiller\BachillerCursoRecuperativoController@actaExamen');
Route::get('api/bachiller_curso_recuperativo/validarAlumno/{aluClave}','Bachiller\BachillerCursoRecuperativoController@validarAlumno')->name('api/bachiller_curso_recuperativo/validarAlumno');
Route::post('bachiller_curso_recuperativo/extraStore','Bachiller\BachillerCursoRecuperativoController@extraStore')->name('bachiller.bachiller_curso_recuperativo.extraStore');

// Evidencias
Route::get('bachiller_evidencias','Bachiller\BachillerEvidenciasController@index')->name('bachiller.bachiller_evidencias.index');
Route::get('bachiller_evidencias/list','Bachiller\BachillerEvidenciasController@list')->name('bachiller.bachiller_evidencias.list');
Route::get('bachiller_evidencias/create','Bachiller\BachillerEvidenciasController@create')->name('bachiller.bachiller_evidencias.create');
Route::get('bachiller_evidencias/copiar','Bachiller\BachillerEvidenciasController@copiar')->name('bachiller.bachiller_evidencias.copiar');
Route::get('bachiller_evidencias/copiarPorSemestre','Bachiller\BachillerEvidenciasController@copiarEvidenciasSemestre')->name('bachiller.bachiller_evidencias.copiarPorSemestre');

Route::get('bachiller_evidencias/getMateriasEvidencias/{plan_id}/{programa_id}/{matSemestre}','Bachiller\BachillerEvidenciasController@getMateriasEvidencias');
Route::get('bachiller_evidencias/getMateriasACD/{periodo_id}/{plan_id}/{bachiller_materia_id}','Bachiller\BachillerEvidenciasController@getMateriasACD');
Route::get('bachiller_evidencias/getMateriasACDDestino/{periodo_id}/{plan_id}/{bachiller_materia_id}/{materia_acd_id}','Bachiller\BachillerEvidenciasController@getMateriasACDDestino');
Route::get('bachiller_evidencias/sinACDgetMateriasEvidenciasPeriodo/{periodo_id}/{bachiller_materia_id}/{matSemestre}','Bachiller\BachillerEvidenciasController@getMateriasEvidenciasPeriodo');

Route::get('bachiller_evidencias/getMateriasEvidenciasPeriodoACD/{periodo_id}/{bachiller_materia_id}/{matSemestre}/{bachiller_materia_acd_id}','Bachiller\BachillerEvidenciasController@getMateriasEvidenciasPeriodoACD');
Route::get('bachiller_evidencias/{id}/edit','Bachiller\BachillerEvidenciasController@edit')->name('bachiller.bachiller_evidencias.edit');
Route::get('bachiller_evidencias/{id}','Bachiller\BachillerEvidenciasController@show')->name('bachiller.bachiller_evidencias.show');
Route::post('bachiller_evidencias/store','Bachiller\BachillerEvidenciasController@store')->name('bachiller.bachiller_evidencias.store');
Route::post('bachiller_evidencias/storeCopiar','Bachiller\BachillerEvidenciasController@storeCopiar')->name('bachiller.bachiller_evidencias.storeCopiar');
Route::post('bachiller_evidencias/storeCopiarSemestre','Bachiller\BachillerEvidenciasController@storeCopiarSemestre')->name('bachiller.bachiller_evidencias.storeCopiarSemestre');
Route::put('bachiller_evidencias/{id}','Bachiller\BachillerEvidenciasController@update')->name('bachiller.bachiller_evidencias.update');
Route::delete('bachiller_evidencias/{id}','Bachiller\BachillerEvidenciasController@destroy')->name('bachiller.bachiller_evidencias.destroy');

// Evidencias inscritos
Route::get('bachiller_evidencias_inscritos/{grupo_id}/{periodo_id}/{materia_id}/{materia_acd_id}/captura_materia_complementaria','Bachiller\BachillerEvidenciasInscritosController@capturaEvidencia');
Route::get('bachiller_evidencias_inscritos/{grupo_id}/{periodo_id}/{materia_id}/captura','Bachiller\BachillerEvidenciasInscritosController@capturaEvidencia');
Route::get('bachiller_evidencias_inscritos/capturas_realizadas/{grupo_id}/{evidencia_id}','Bachiller\BachillerEvidenciasInscritosController@getMateriasEvidencias');
Route::post('bachiller_evidencias_inscritos','Bachiller\BachillerEvidenciasInscritosController@store')->name('bachiller.bachiller_evidencias_inscritos.store');


//Fechas de regularización
Route::get('bachiller_fechas_regularizacion','Bachiller\BachillerFechasRegularizacionController@index')->name('bachiller.bachiller_fechas_regularizacion.index');
Route::get('bachiller_fechas_regularizacion/list','Bachiller\BachillerFechasRegularizacionController@list')->name('bachiller.bachiller_fechas_regularizacion.list');
Route::get('bachiller_fechas_regularizacion/create','Bachiller\BachillerFechasRegularizacionController@create')->name('bachiller.bachiller_fechas_regularizacion.create');
Route::get('bachiller_fechas_regularizacion/{id}/edit','Bachiller\BachillerFechasRegularizacionController@edit')->name('bachiller.bachiller_fechas_regularizacion.edit');
Route::get('bachiller_fechas_regularizacion/{id}','Bachiller\BachillerFechasRegularizacionController@show')->name('bachiller.bachiller_fechas_regularizacion.show');
Route::post('bachiller_fechas_regularizacion','Bachiller\BachillerFechasRegularizacionController@store')->name('bachiller.bachiller_fechas_regularizacion.store');
Route::put('bachiller_fechas_regularizacion/{id}','Bachiller\BachillerFechasRegularizacionController@update')->name('bachiller.bachiller_fechas_regularizacion.update');
Route::delete('bachiller_fechas_regularizacion/{id}','Bachiller\BachillerFechasRegularizacionController@destroy')->name('bachiller.bachiller_fechas_regularizacion.destroy');

//Fechas de calendario de axamen
Route::get('bachiller_calendario_examen','Bachiller\BachillerFechasCalendariaExamenController@index')->name('bachiller.bachiller_calendario_examen.index');
Route::get('bachiller_calendario_examen/list','Bachiller\BachillerFechasCalendariaExamenController@list')->name('bachiller.bachiller_calendario_examen.list');
Route::get('bachiller_calendario_examen/create','Bachiller\BachillerFechasCalendariaExamenController@create')->name('bachiller.bachiller_calendario_examen.create');
Route::get('bachiller_calendario_examen/{id}/edit','Bachiller\BachillerFechasCalendariaExamenController@edit')->name('bachiller.bachiller_calendario_examen.edit');
Route::get('bachiller_calendario_examen/{id}','Bachiller\BachillerFechasCalendariaExamenController@show')->name('bachiller.bachiller_calendario_examen.show');
Route::post('bachiller_calendario_examen','Bachiller\BachillerFechasCalendariaExamenController@store')->name('bachiller.bachiller_calendario_examen.store');
Route::put('bachiller_calendario_examen/{id}','Bachiller\BachillerFechasCalendariaExamenController@update')->name('bachiller.bachiller_calendario_examen.update');
Route::delete('bachiller_calendario_examen/{id}','Bachiller\BachillerFechasCalendariaExamenController@destroy')->name('bachiller.bachiller_calendario_examen.destroy');


//Fechas de calendario de axamen
Route::get('bachiller_calendario_examen_cch','Bachiller\BachillerFechasCalendariaExamenSEQController@index')->name('bachiller.bachiller_calendario_examen_cch.index');
Route::get('bachiller_calendario_examen_cch/list','Bachiller\BachillerFechasCalendariaExamenSEQController@list')->name('bachiller.bachiller_calendario_examen_cch.list');
Route::get('bachiller_calendario_examen_cch/create','Bachiller\BachillerFechasCalendariaExamenSEQController@create')->name('bachiller.bachiller_calendario_examen_cch.create');
Route::get('bachiller_calendario_examen_cch/{id}/edit','Bachiller\BachillerFechasCalendariaExamenSEQController@edit')->name('bachiller.bachiller_calendario_examen_cch.edit');
Route::get('bachiller_calendario_examen_cch/{id}','Bachiller\BachillerFechasCalendariaExamenSEQController@show')->name('bachiller.bachiller_calendario_examen_cch.show');
Route::post('bachiller_calendario_examen_cch','Bachiller\BachillerFechasCalendariaExamenSEQController@store')->name('bachiller.bachiller_calendario_examen_cch.store');
Route::put('bachiller_calendario_examen_cch/{id}','Bachiller\BachillerFechasCalendariaExamenSEQController@update')->name('bachiller.bachiller_calendario_examen_cch.update');
Route::delete('bachiller_calendario_examen_cch/{id}','Bachiller\BachillerFechasCalendariaExamenSEQController@destroy')->name('bachiller.bachiller_calendario_examen_cch.destroy');


// Paquete Route
Route::get('bachiller_paquete','Bachiller\BachillerPaqueteController@index')->name('bachiller.bachiller_paquete.index');
Route::get('api/bachiller_paquete','Bachiller\BachillerPaqueteController@list');
Route::get('bachiller_paquete/create','Bachiller\BachillerPaqueteController@create')->name('bachiller.bachiller_paquete.create');
Route::get('bachiller_paquete/{id}/edit','Bachiller\BachillerPaqueteController@edit')->name('bachiller.bachiller_paquete.edit');
Route::get('bachiller_paquete/{id}','Bachiller\BachillerPaqueteController@show')->name('bachiller.bachiller_paquete.show');
Route::get('api/bachiller_paquete/{curso_id}','Bachiller\BachillerPaqueteController@getPaquetes');
Route::get('bachiller_paquete/apiss/cgts/{plan_id}/{periodo_id}/{cgt_id}','Bachiller\BachillerPaqueteController@getCgtsGrupos');
Route::get('bachiller_paquete/todos/getCgtsGruposTodos/{plan_id}/{periodo_id}/{cgt_id}','Bachiller\BachillerPaqueteController@getCgtsGruposTodos');
Route::get('api/bachiller_paquete/detalle/{bachiller_paquete_id}','Bachiller\BachillerPaqueteController@getPaqueteDetalle');
Route::post('bachiller_paquete','Bachiller\BachillerPaqueteController@store')->name('bachiller.bachiller_paquete.store');
Route::put('bachiller_paquete/{id}','Bachiller\BachillerPaqueteController@update')->name('bachiller.bachiller_paquete.update');
Route::delete('bachiller_paquete/{id}','Bachiller\BachillerPaqueteController@destroy')->name('bachiller.bachiller_paquete.destroy');


Route::get('bachiller_inscrito_paquete','Bachiller\BachillerPaquetesInscritosController@index')->name('bachiller.bachiller_inscrito_paquete.index');
Route::get('bachiller_inscrito_paquete/obtenerListaAlumnosCurso/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerPaquetesInscritosController@obtenerListaAlumnosCurso');
Route::get('bachiller_inscrito_paquete/obtenerPaquetes/{periodo_id}/{plan_id}/{cgt_id}', 'Bachiller\BachillerPaquetesInscritosController@obtenerPaquetes');
Route::get('bachiller_inscrito_paquete/validarSiExisteInscrito/{curso_id}', 'Bachiller\BachillerPaquetesInscritosController@validarSiExisteInscrito');
Route::post('bachiller_inscrito_paquete','Bachiller\BachillerPaquetesInscritosController@store')->name('bachiller.bachiller_inscrito_paquete.store');



//Resumen academico
Route::get('bachiller_resumen_academico', 'Bachiller\BachillerResumenAcademicoController@index')->name('bachiller.bachiller_resumen_academico.index');
Route::get('bachiller_resumen_academico/list', 'Bachiller\BachillerResumenAcademicoController@list');
Route::get('bachiller_resumen_academico/{id}', 'Bachiller\BachillerResumenAcademicoController@show');


//bachiller_periodos_vacacionales
Route::get('bachiller_periodos_vacacionales', 'Bachiller\BachillerPeriodosVacacionalesController@index')->name('bachiller.bachiller_periodos_vacacionales.index');
Route::get('bachiller_periodos_vacacionales/list', 'Bachiller\BachillerPeriodosVacacionalesController@list');
Route::get('bachiller_periodos_vacacionales/create', 'Bachiller\BachillerPeriodosVacacionalesController@create')->name('bachiller.bachiller_periodos_vacacionales.create');
Route::get('bachiller_periodos_vacacionales/{id}/edit', 'Bachiller\BachillerPeriodosVacacionalesController@edit')->name('bachiller.bachiller_periodos_vacacionales.edit');
Route::get('bachiller_periodos_vacacionales/{id}', 'Bachiller\BachillerPeriodosVacacionalesController@show')->name('bachiller.bachiller_periodos_vacacionales.show');
Route::post('bachiller_periodos_vacacionales', 'Bachiller\BachillerPeriodosVacacionalesController@store')->name('bachiller.bachiller_periodos_vacacionales.store');
Route::put('bachiller_periodos_vacacionales/{id}', 'Bachiller\BachillerPeriodosVacacionalesController@update')->name('bachiller.bachiller_periodos_vacacionales.update');
Route::delete('bachiller_periodos_vacacionales/{id}', 'Bachiller\BachillerPeriodosVacacionalesController@destroy')->name('bachiller.bachiller_periodos_vacacionales.destroy');

// Historial academico
Route::get('bachiller_historial_academico', 'Bachiller\BachillerHistoricoAlumnoController@index')->name('bachiller.bachiller_historial_academico.index');
Route::get('bachiller_historial_academico/list', 'Bachiller\BachillerHistoricoAlumnoController@list');
Route::get('bachiller_historial_academico/create', 'Bachiller\BachillerHistoricoAlumnoController@create')->name('bachiller.bachiller_historial_academico.create');
Route::get('bachiller_historial_academico/{id}/edit', 'Bachiller\BachillerHistoricoAlumnoController@edit')->name('bachiller.bachiller_historial_academico.edit');
Route::get('bachiller_historial_academico/{id}', 'Bachiller\BachillerHistoricoAlumnoController@show')->name('bachiller.bachiller_historial_academico.show');
Route::post('bachiller_historial_academico', 'Bachiller\BachillerHistoricoAlumnoController@store')->name('bachiller.bachiller_historial_academico.store');
Route::put('bachiller_historial_academico/{id}', 'Bachiller\BachillerHistoricoAlumnoController@update')->name('bachiller.bachiller_historial_academico.update');
Route::delete('bachiller_historial_academico/{id}', 'Bachiller\BachillerHistoricoAlumnoController@destroy')->name('bachiller.bachiller_historial_academico.destroy');

// Revalidaciones
Route::get('bachiller_revalidaciones', 'Bachiller\BachillerRevalidacionesController@index')->name('bachiller.bachiller_revalidaciones.index');
Route::get('bachiller_revalidaciones/list', 'Bachiller\BachillerRevalidacionesController@list')->name('bachiller.bachiller_revalidaciones.list');
Route::get('bachiller_revalidaciones/create', 'Bachiller\BachillerRevalidacionesController@create')->name('bachiller.bachiller_revalidaciones.create');
Route::get('bachiller_revalidaciones/alumno/{aluClave}', 'Bachiller\BachillerRevalidacionesController@buscaNombreAlumno');
Route::get('bachiller_revalidaciones/{id}', 'Bachiller\BachillerRevalidacionesController@show')->name('bachiller.bachiller_revalidaciones.show');
Route::get('bachiller_revalidaciones_materias_rc/{que_semestres_cursos_buscar}/{plan_id}', 'Bachiller\BachillerRevalidacionesController@buscaMaterias');
Route::get('bachiller_revalidaciones/{id}/edit', 'Bachiller\BachillerRevalidacionesController@edit')->name('bachiller.bachiller_revalidaciones.edit');
Route::get('bachiller_revalidaciones/obtienePeriodo/{periodo_id}', 'Bachiller\BachillerRevalidacionesController@obtienePeriodo');
Route::post('bachiller_revalidaciones', 'Bachiller\BachillerRevalidacionesController@store')->name('bachiller.bachiller_revalidaciones.store');
Route::put('bachiller_revalidaciones/{id}', 'Bachiller\BachillerRevalidacionesController@update')->name('bachiller.bachiller_revalidaciones.update');
Route::delete('bachiller_revalidaciones/{id}', 'Bachiller\BachillerRevalidacionesController@destroy')->name('bachiller.bachiller_revalidaciones.destroy');



// Revalidaciones.
Route::get('api/bachiller_certificados_parciales', 'Bachiller\BachillerCertificadosParcialesController@list');
Route::get('api/bachiller_certificados_parciales/{resumen_id}/materias_faltantes', 'Bachiller\BachillerCertificadosParcialesController@materias_faltantes');
Route::get('bachiller_certificados_parciales/{resumen_id}/agregar/{materia_id}', 'Bachiller\BachillerCertificadosParcialesController@agregar')->name('bachiller_certificados_parciales.agregar');
Route::post('bachiller_certificados_parciales/{resumen_id}/revalidar/{materia_id}', 'Bachiller\BachillerCertificadosParcialesController@revalidar')->name('bachiller_certificados_parciales.revalidar');
Route::resource('bachiller_certificados_parciales', 'Bachiller\BachillerCertificadosParcialesController')->only(['index', 'edit']);

// Cambiar Carrera o Cgt.
Route::get('bachiller_cambiar_cgt_preinscrito/{curso}', 'Bachiller\BachillerCambiarCarreraController@vista');
Route::post('bachiller_cambiar_cgt_preinscrito/{curso}/cambiar', 'Bachiller\BachillerCambiarCarreraController@cambiar')->name('bachiller.bachiller_cambiar_cgt_preinscrito.cambiar');



// Registro de Egresados / Titulados.
Route::get('bachiller_registro_egresados','Bachiller\BachillerEgresadoController@filtro')->name('bachiller.egregados.filtro');
Route::post('bachiller_registro_egresados/procesar','Bachiller\BachillerEgresadoController@procesar')->name('bachiller.egregados.procesar');
Route::post('bachiller_registro_egresados/buscar/{aluClave}','Bachiller\BachillerEgresadoController@getAlumnoByClave')->name('bachiller.registro_egresados.buscar');

// Egresados CRUD.
Route::resource('bachiller_egresados','Bachiller\BachillerEgresadoController');
Route::get('api/bachiller_egresados','Bachiller\BachillerEgresadoController@list')->name('api/bachiller_egresados');
Route::post('departamento/periodos/{ubiClave}/{depClave}','Bachiller\BachillerEgresadoController@obtenerPeriodos')
	->name('departamento/periodos/{ubiClave}/{depClave}');
Route::post('bachiller_egresados/buscar_alumno/{aluClave}','Bachiller\BachillerEgresadoController@buscarAlumno')
	->name('bachiller_egresados/buscar_alumno/{aluClave}');




  //Migrar Inscritos
Route::get('bachiller_migrar_inscritos_acd','Bachiller\BachillerMigrarInscritosController@index')->name('bachiller.bachiller_migrar_inscritos_acd.index');
Route::get('bachiller_migrar_inscritos_acd/api/getDepartamentosPorUbiClave/{id}','Bachiller\BachillerMigrarInscritosController@getDepartamentosPorUbiClave');
Route::get('bachiller_migrar_inscritos_acd/api/ObtenerGrupoOrigen/{plan_id}/{periodo_id}/{gpoGrado}','Bachiller\BachillerMigrarInscritosController@ObtenerGrupoOrigen');
Route::get('bachiller_migrar_inscritos_acd/api/getGrupoDestino/{plan_id}/{periodo_id}/{gradoDestino}','Bachiller\BachillerMigrarInscritosController@getGrupoDestino');
Route::get('bachiller_migrar_inscritos_acd/api/ObtenerPeriodoSiguiente/{periodo_id}','Bachiller\BachillerMigrarInscritosController@ObtenerPeriodoSiguiente');
Route::get('bachiller_migrar_inscritos_acd/api/ObtenerGrupoDestino/{plan_id}/{periodo_id}/{gpoGrado}','Bachiller\BachillerMigrarInscritosController@ObtenerGrupoDestino');
Route::post('bachiller_migrar_inscritos_acd','Bachiller\BachillerMigrarInscritosController@store')->name('bachiller.bachiller_migrar_inscritos_acd.store');


  //Copiar Inscritos ACD
  Route::get('bachiller_copiar_inscritos','Bachiller\BachillerCopiarInscritosController@index')->name('bachiller.bachiller_copiar_inscritos.index');
  Route::get('bachiller_copiar_inscritos/api/getDepartamentosPorUbiClave/{id}','Bachiller\BachillerCopiarInscritosController@getDepartamentosPorUbiClave');
  Route::get('bachiller_copiar_inscritos/api/ObtenerGrupoOrigen/{plan_id}/{periodo_id}/{gpoGrado}','Bachiller\BachillerCopiarInscritosController@ObtenerGrupoOrigen');
  Route::get('bachiller_copiar_inscritos/api/getGrupoDestino/{plan_id}/{periodo_id}/{gradoDestino}/{grupo_origen_id}','Bachiller\BachillerCopiarInscritosController@getGrupoDestino');
  Route::get('bachiller_copiar_inscritos/api/ObtenerPeriodoSiguiente/{periodo_id}','Bachiller\BachillerCopiarInscritosController@ObtenerPeriodoSiguiente');
  Route::get('bachiller_copiar_inscritos/api/ObtenerGrupoDestino/{plan_id}/{periodo_id}/{gpoGrado}','Bachiller\BachillerCopiarInscritosController@ObtenerGrupoDestino');
  Route::get('bachiller_copiar_inscritos/api/getAlumnosDelGrupo/{bachiller_grupo_id}','Bachiller\BachillerCopiarInscritosController@getAlumnosDelGrupo');
  Route::post('bachiller_copiar_inscritos','Bachiller\BachillerCopiarInscritosController@store')->name('bachiller.bachiller_copiar_inscritos.store');


Route::get('bachiller-portal-configuracion','Bachiller\BachillerConfiguracionPortal@index')->name('bachiller.bachiller-portal-configuracion.index');
Route::get('bachiller-portal-configuracion/list','Bachiller\BachillerConfiguracionPortal@list');
Route::get('bachiller-portal-configuracion/toggleactive/{id}/','Bachiller\BachillerConfiguracionPortal@toggleActive');

// copiar horarios
Route::get('bachiller_copiar_horario','Bachiller\BachillerCopiarHorariosController@index')->name('bachiller.bachiller_copiar_horario.index');
Route::get('bachiller_copiar_horario/api/getDepartamentosPorUbiClave/{id}','Bachiller\BachillerCopiarHorariosController@getDepartamentosPorUbiClave');
Route::get('bachiller_copiar_horario/api/ObtenerGrupoOrigen/{plan_id}/{periodo_id}/{gpoGrado}','Bachiller\BachillerCopiarHorariosController@ObtenerGrupoOrigen');
Route::get('bachiller_copiar_horario/api/getGrupoDestino/{plan_id}/{periodo_id}/{gradoDestino}/{grupo_origen_id}','Bachiller\BachillerCopiarHorariosController@getGrupoDestino');
Route::get('bachiller_copiar_horario/api/getAlumnosDelGrupo/{bachiller_grupo_id}','Bachiller\BachillerCopiarHorariosController@getAlumnosDelGrupo');
Route::get('bachiller_copiar_horario/api/ObtenerPeriodoSiguiente/{periodo_id}','Bachiller\BachillerCopiarHorariosController@ObtenerPeriodoSiguiente');
Route::get('bachiller_copiar_horario/api/ObtenerGrupoDestino/{plan_id}/{periodo_id}/{gpoGrado}','Bachiller\BachillerCopiarHorariosController@ObtenerGrupoDestino');
Route::post('bachiller_copiar_horario','Bachiller\BachillerCopiarHorariosController@store')->name('bachiller.bachiller_copiar_horario.store');


// lista negra
Route::get('/bachiller_alumnos_restringidos', 'Bachiller\BachillerListaNegraController@index')->name('bachiller.bachiller_alumnos_restringidos.index');
Route::get('/bachiller_alumnos_restringidos/create', 'Bachiller\BachillerListaNegraController@create')->name('bachiller.bachiller_alumnos_restringidos.create');
Route::get('/bachiller_alumnos_restringidos/list', 'Bachiller\BachillerListaNegraController@list')->name('bachiller.bachiller_alumnos_restringidos.list');
Route::get('bachiller_alumnos_restringidos/{id}','Bachiller\BachillerListaNegraController@show')->name('bachiller.bachiller_alumnos_restringidos.show');
Route::get('bachiller_alumnos_restringidos/{id}/edit','Bachiller\BachillerListaNegraController@edit')->name('bachiller.bachiller_alumnos_restringidos.edit');
Route::post('bachiller_alumnos_restringidos','Bachiller\BachillerListaNegraController@store')->name('bachiller.bachiller_alumnos_restringidos.store');
Route::put('bachiller_alumnos_restringidos/{id}','Bachiller\BachillerListaNegraController@update')->name('bachiller.bachiller_alumnos_restringidos.update');
Route::post('bachiller_alumnos_restringidos/darBaja/{empleado_id}', 'Bachiller\BachillerListaNegraController@darDeBaja')->name('bachiller.bachiller_alumnos_restringidos/darBaja/{empleado_id}');
Route::delete('bachiller_alumnos_restringidos/{id}','Bachiller\BachillerListaNegraController@destroy')->name('bachiller.bachiller_alumnos_restringidos.destroy');



Route::get('bachiller_pago_certificado', 'Bachiller\BachillerPagoCertificadoController@index')->name('bachiller.bachiller_pago_certificado.index');
Route::get('bachiller_pago_certificado/list', 'Bachiller\BachillerPagoCertificadoController@list');
Route::get('bachiller_pago_certificado/create', 'Bachiller\BachillerPagoCertificadoController@create')->name('bachiller.bachiller_pago_certificado.create');
Route::get('bachiller_pago_certificado/getAlumnosCurso/{periodo_id}/{plan_id}', 'Bachiller\BachillerPagoCertificadoController@getAlumnosCurso');
Route::get('bachiller_pago_certificado/{id}/edit', 'Bachiller\BachillerPagoCertificadoController@edit')->name('bachiller.bachiller_pago_certificado.edit');
Route::get('bachiller_pago_certificado/{id}', 'Bachiller\BachillerPagoCertificadoController@show')->name('bachiller.bachiller_pago_certificado.show');
Route::post('bachiller_pago_certificado/imprimir', 'Bachiller\BachillerPagoCertificadoController@imprimir')->name('bachiller.bachiller_pago_certificado.imprimir');
Route::get('bachiller_pago_certificado/imprimir/{id}', 'Bachiller\BachillerPagoCertificadoController@imprimir2')->name('bachiller.bachiller_pago_certificado.imprimir2');


Route::post('bachiller_pago_certificado/store', 'Bachiller\BachillerPagoCertificadoController@store')->name('bachiller.bachiller_pago_certificado.store');
Route::put('bachiller_pago_certificado/{id}', 'Bachiller\BachillerPagoCertificadoController@update')->name('bachiller.bachiller_pago_certificado.update');
Route::delete('bachiller_pago_certificado/{id}', 'Bachiller\BachillerPagoCertificadoController@destroy')->name('bachiller.bachiller_pago_certificado.destroy');






/* -------------------------------------------------------------------------- */
/*                              Rutas de Reportes                             */
/* -------------------------------------------------------------------------- */

//Reporte de Inscritos y Preinscritos
Route::get('bachiller_reporte/bachiller_inscrito_preinscrito', 'Bachiller\Reportes\BachillerInscritosPreinscritosController@reporte')->name('bachiller_inscrito_preinscrito.reporte');
Route::post('bachiller_reporte/bachiller_preinscrito/imprimir', 'Bachiller\Reportes\BachillerInscritosPreinscritosController@imprimir')->name('bachiller_inscrito_preinscrito.imprimir');

// Relacion de deudores
Route::get('reporte/bachiller_relacion_deudores', 'Bachiller\Reportes\BachillerRelDeudoresController@reporte')->name('bachiller_relacion_deudores.reporte');
Route::post('reporte/bachiller_relacion_deudores/imprimir', 'Bachiller\Reportes\BachillerRelDeudoresController@imprimir')->name('bachiller_relacion_deudores.imprimir');

// Relacion de deuda individual de un alumno
Route::get('reporte/bachiller_relacion_deudas', 'Bachiller\Reportes\BachillerRelDeudasController@reporte')->name('bachiller_relacion_deudas.reporte');
Route::post('reporte/bachiller_relacion_deudas/imprimir', 'Bachiller\Reportes\BachillerRelDeudasController@imprimir')->name('bachiller_relacion_deudas.imprimir');

// Resumen de inscritos
Route::get('reporte/bachiller_resumen_inscritos', 'Bachiller\Reportes\BachillerResumenInscritosController@reporte')->name('bachiller.bachiller_resumen_inscritos.reporte');
Route::get('reporte/bachiller_resumen_inscritos/imprimir', 'Bachiller\Reportes\BachillerResumenInscritosController@imprimir')->name('bachiller.bachiller_resumen_inscritos.imprimir');
Route::get('reporte/bachiller_resumen_inscritos/exportarExcel', 'Bachiller\Reportes\BachillerResumenInscritosController@exportarExcel');


// crear lista de asistencia de alumnos desde grupos
Route::get('bachiller_inscritos_yuc/lista_de_asistencia/grupo/{grupo_id}', 'Bachiller\Reportes\BachillerListaDeAsistenciaController@imprimirListaAsistenciaYuc');
Route::get('bachiller_inscritos_seq/lista_de_asistencia/grupo/{grupo_id}', 'Bachiller\Reportes\BachillerListaDeAsistenciaController@imprimirListaAsistenciaChe');
Route::get('reporte/lista_de_asistencia', 'Bachiller\Reportes\BachillerListaDeAsistenciaController@reporte')->name('bachiller.lista_de_asistencia.reporte');
Route::post('reporte/lista_de_asistencia', 'Bachiller\Reportes\BachillerListaDeAsistenciaController@imprimir')->name('bachiller.lista_de_asistencia.imprimir');

// // Controller para generar reporte de expediente de alumnos
// Route::get('bachiller_reporte/expediente_alumnos', 'Bachiller\Reportes\BachillerExpedienteAlumnosController@index')->name('bachiller_reporte.expediente_alumnos.index');
// Route::post('bachiller_reporte/expediente_alumnos/imprimir', 'Bachiller\Reportes\BachillerExpedienteAlumnosController@imprimirExpediente')->name('bachiller_reporte.expediente_alumnos.imprimir');

//Controller para generar reporte de alumnos becados
Route::get('bachiller_reporte/alumnos_becados', 'Bachiller\Reportes\BachillerAlumnosBecadosController@reporte')->name('bachiller_reporte.bachiller_alumnos_becados.reporte');
Route::post('bachiller_reporte/alumnos_becados/imprimir', 'Bachiller\Reportes\BachillerAlumnosBecadosController@imprimir')->name('bachiller_reporte.bachiller_alumnos_becados.imprimir');

//Relación de bajas por periodo.
Route::get('reporte/bachiller_relacion_bajas_periodo','Bachiller\Reportes\BachillerRelacionBajasPeriodoController@reporte')->name('bachiller.bachiller_relacion_bajas_periodo.reporte');
Route::post('reporte/bachiller_relacion_bajas_periodo/imprimir', 'Bachiller\Reportes\BachillerRelacionBajasPeriodoController@imprimir')->name('bachiller.bachiller_relacion_bajas_periodo.imprimir');


//horario de clases
Route::get('reporte/bachiller_horario_por_grupo','Bachiller\Reportes\BachillerHorarioPorGrupoController@reporte')->name('bachiller.bachiller_horario_por_grupo.reporte');
Route::post('reporte/bachiller_horario_por_grupo/imprimir','Bachiller\Reportes\BachillerHorarioPorGrupoController@imprimir')->name('bachiller.bachiller_horario_por_grupo.imprimir');

//Grupos por Semestre
Route::get('reporte/bachiller_grupo_semestre', 'Bachiller\Reportes\BachillerGrupoSemestreController@reporte')->name('bachiller.bachiller_grupo_semestre.reporte');
Route::post('reporte/bachiller_grupo_semestre/imprimir', 'Bachiller\Reportes\BachillerGrupoSemestreController@imprimir')->name('bachiller.bachiller_grupo_semestre.imprimir');

// Controller para generar constancias
Route::get('bachiller_reporte/carta_conducta/imprimir/{id_curso}', 'Bachiller\Reportes\BachillerConstanciasController@imprimirCartaConducta');
Route::get('bachiller_reporte/constancia_estudio/imprimir/{id_curso}', 'Bachiller\Reportes\BachillerConstanciasController@imprimirConstanciaEstudio');
Route::get('bachiller_reporte/constancia_no_adeudo/imprimir/{id_curso}', 'Bachiller\Reportes\BachillerConstanciasController@imprimirConstanciaNoAdeudo');
Route::get('bachiller_reporte/constancia_de_cupo/imprimir/{id_curso}/{tipoContancia}', 'Bachiller\Reportes\BachillerConstanciasController@imprimirConstanciaCupo');
Route::get('bachiller_reporte/constancia_de_promedio_final/imprimir/{id_curso}/{tipoContancia}', 'Bachiller\Reportes\BachillerConstanciasController@imprimirConstanciaPromedioFinal');
Route::get('bachiller_reporte/constancia_de_artes_talleres/imprimir/{id_curso}/{tipoContancia}', 'Bachiller\Reportes\BachillerConstanciasController@imprimirConstanciaArtesTalleres');
Route::get('bachiller_reporte/constancia_de_inscripcion_anual/imprimir/{id_curso}/{tipoContancia}', 'Bachiller\Reportes\BachillerConstanciasController@imprimirConstanciaInscripcion');
Route::get('bachiller_reporte/constancia_de_escolaridad/imprimir/{id_curso}/{tipoContancia}', 'Bachiller\Reportes\BachillerConstanciasController@imprimirConstanciaEscolaridad');

//Relación Maestros Escuela
Route::get('bachiller_reporte/relacion_grupo_maestro', 'Bachiller\Reportes\BachillerRelacionMaestrosEscuelaController@reporte')->name('bachiller_relacion_maestros_escuela.reporte');
Route::post('bachiller_reporte/relacion_grupo_maestro/imprimir', 'Bachiller\Reportes\BachillerRelacionMaestrosEscuelaController@imprimir')->name('bachiller_relacion_maestros_escuela.imprimir');


// carga grupos maestro
Route::get('reporte/bachiller_carga_grupos_maestro', 'Bachiller\Reportes\BachillerCargaGruposMaestroController@reporte')->name('bachiller.bachiller_carga_grupos_maestro.reporte');
Route::post('reporte/bachiller_carga_grupos_maestro/imprimir', 'Bachiller\Reportes\BachillerCargaGruposMaestroController@imprimir')->name('bachiller.bachiller_carga_grupos_maestro.imprimir');



// Avance de calificaciones
Route::get('reporte/bachiller_avance_calificaciones', 'Bachiller\Reportes\BachillerAvanceCalificacionesController@reporte')->name('bachiller.bachiller_avance_calificaciones.reporte');
Route::post('reporte/bachiller_avance_calificaciones/imprimir', 'Bachiller\Reportes\BachillerAvanceCalificacionesController@imprimir')->name('bachiller.bachiller_avance_calificaciones.imprimir');

// Calificacion final
Route::get('reporte/bachiller_calificacion_final', 'Bachiller\Reportes\BachillerCalificacionFinalController@reporte')->name('bachiller.bachiller_calificacion_final.reporte');
Route::post('reporte/bachiller_calificacion_final/imprimir', 'Bachiller\Reportes\BachillerCalificacionFinalController@imprimir')->name('bachiller.bachiller_calificacion_final.imprimir');

// Controller para generar reporte de calificaciones
Route::get('bachiller_reporte/calificaciones_grupo', 'Bachiller\Reportes\BachillerCalificacionPorGrupoController@Reporte')->name('bachiller_reporte.calificaciones_grupo.reporte');
Route::post('bachiller_reporte/boleta_calificaciones/imprimir', 'Bachiller\Reportes\BachillerCalificacionPorGrupoController@imprimirCalificaciones')->name('bachiller_reporte.boleta_calificaciones.imprimir');

// acta de examen extraordinario
Route::get('reporte/bachiller_acta_extraordinario', 'Bachiller\Reportes\BachillerActaExtraordinarioController@reporte')->name('bachiller.bachiller_acta_extraordinario.reporte');
Route::post('reporte/bachiller_acta_extraordinario/imprimir', 'Bachiller\Reportes\BachillerActaExtraordinarioController@imprimir')->name('bachiller.bachiller_acta_extraordinario.imprimir');

// Extraordinarios - Resumen de Inscritos
Route::get('reporte/bachiller_resumen_inscritos_extraordinario', 'Bachiller\Reportes\BachillerResumenInscritosExtraordinarioController@reporte')->name('bachiller.bachiller_resumen_inscritos_extraordinario.reporte');
Route::post('reporte/bachiller_resumen_inscritos_extraordinario/imprimir', 'Bachiller\Reportes\BachillerResumenInscritosExtraordinarioController@imprimir')->name('bachiller.bachiller_resumen_inscritos_extraordinario.imprimir');

// Resumen de evidencias
Route::get('reporte/bachiller_resumen_evidencias', 'Bachiller\Reportes\BachillerResumenEvidenciasController@reporte')->name('bachiller.bachiller_resumen_evidencias.reporte');
Route::get('reporte/bachiller_detalle_evidencia/{plan_id}/{grado}', 'Bachiller\Reportes\BachillerResumenEvidenciasController@getMateriaGradoPlan');
Route::get('reporte/bachiller_detalle_evidencia/getMateriasACD/{periodo_id}/{plan_id}/{bachiller_materia_id}','Bachiller\Reportes\BachillerResumenEvidenciasController@getMateriasACD');
Route::post('reporte/bachiller_resumen_evidencias/imprimir', 'Bachiller\Reportes\BachillerResumenEvidenciasController@imprimir')->name('bachiller.bachiller_resumen_evidencias.imprimir');


Route::get('bachiller_reporte/programacion_examenes', 'Bachiller\Reportes\BachillerProgramacionExamenesController@reporte')->name('bachiller.programacion_examenes.reporte');
Route::post('bachiller_reporte/programacion_examenes/imprimir', 'Bachiller\Reportes\BachillerProgramacionExamenesController@imprimir')->name('bachiller.programacion_examenes.imprimir');


Route::get('reporte/bachiller_avance_por_grupo', 'Bachiller\Reportes\BachillerAvancePorGrupoController@reporte')->name('bachiller.bachiller_avance_por_grupo.reporte');
Route::post('reporte/bachiller_avance_por_grupo/imprimir', 'Bachiller\Reportes\BachillerAvancePorGrupoController@imprimir')->name('bachiller.bachiller_avance_por_grupo.imprimir');

Route::get('bachiller_formatos', 'Bachiller\BachillerFormatoREAController@create');
Route::post('bachiller_formatos/reporte', 'Bachiller\BachillerFormatoREAController@reporteREA')->name('bachiller.bachiller_formatos.reporte');

// Materias aprobadas
Route::get('reporte/bachiller_materias_aprobadas', 'Bachiller\Reportes\BachillerMateriasReprobadasController@reporte')->name('bachiller.bachiller_materias_aprobadas.reporte');
Route::post('reporte/bachiller_materias_aprobadas/imprimir', 'Bachiller\Reportes\BachillerMateriasReprobadasController@imprimir')->name('bachiller.bachiller_materias_aprobadas.imprimir');


// Extraordinarios - Relación de Inscritos
Route::get('reporte/bachiller_relacion_inscritos_recuperativos', 'Bachiller\Reportes\BachillerRelacionInscritosExtraordinarioController@reporte')->name('bachiller.bachiller_relacion_inscritos_extraordinario.reporte');
Route::post('reporte/bachiller_relacion_inscritos_recuperativos/imprimir', 'Bachiller\Reportes\BachillerRelacionInscritosExtraordinarioController@imprimir')->name('bachiller.bachiller_relacion_inscritos_extraordinario.imprimir');

// Extraordinarios - Resumen de Inscritos
Route::get('reporte/bachiller_resumen_inscritos_recuperativos', 'Bachiller\Reportes\BachillerResumenInscritosExtraordinarioController@reporte')->name('bachiller.bachiller_resumen_inscritos_recuperativos.reporte');
Route::post('reporte/bachiller_resumen_inscritos_recuperativos/imprimir', 'Bachiller\Reportes\BachillerResumenInscritosExtraordinarioController@imprimir')->name('bachiller.bachiller_resumen_inscritos_recuperativos.imprimir');


// Lista de alumnos de recuperativos
Route::get('reporte/bachiller_alumnos_recuperativos', 'Bachiller\Reportes\BachillerListaAlumnosRecuperativosController@reporte')->name('bachiller.bachiller_alumnos_recuperativos.reporte');
Route::get('reporte/getRecuperativos/bachiller_alumnos_recuperativos/{periodo_id}/{plan_id}', 'Bachiller\Reportes\BachillerListaAlumnosRecuperativosController@getRecuperativos');
Route::post('reporte/bachiller_alumnos_recuperativos/imprimir', 'Bachiller\Reportes\BachillerListaAlumnosRecuperativosController@imprimir')->name('bachiller.bachiller_alumnos_recuperativos.imprimir');


// immprimir alumnos a excel
Route::get('reporte/bachiller_alumnos_excel', 'Bachiller\Reportes\BachillerReporteAlumnosExcelController@index')->name('bachiller.bachiller_alumnos_excel.index');
Route::get('reporte/bachiller_alumnos_excel/getAlumnosCursos', 'Bachiller\Reportes\BachillerReporteAlumnosExcelController@getAlumnosCursos');
Route::get('reporte/bachiller_datos_completos_alumno', 'Bachiller\Reportes\BachillerReporteAlumnosExcelController@reporteAlumnos')->name('bachiller.bachiller_datos_completos_alumno.reporteAlumnos');
Route::get('reporte/bachiller_datos_completos_alumno/getAlumnosCursosEduardo/bachiller', 'Bachiller\Reportes\BachillerReporteAlumnosExcelController@getAlumnosCursosEduardo');


// Preinscripcion automatica
//Route::get('bachiller_preinscripcion_automatica','Bachiller\BachillerPreinscripcionAutomaticaController@create')->name('bachiller.bachiller_preinscripcion_automatica.create');


//Preinscripción Automática.
Route::get('bachiller_preinscripcion_auto','Bachiller\BachillerPreinscripcionAutomaticaController@create')->name('bachiller.bachiller_preinscripcion_automatica.create');
Route::post('bachiller_preinscripcion_auto/preinscribir','Bachiller\BachillerPreinscripcionAutomaticaController@preinscribir');


//Cierre de actas.
Route::get('bachiller_cierre_actas','Bachiller\BachillerCierreActasUADYController@filtro')->name('bachiller.bachiller_cierre_actas.filtro');
Route::post('bachiller_cierre_actas/realizar','Bachiller\BachillerCierreActasUADYController@cierreActas')->name('bachiller.bachiller_cierre_actas.cierreActas');


//Cierre de actas(extraordinarios).
Route::get('bachiller_cierre_extras','Bachiller\BachillerCierreExtrasYucatanController@filtro')->name('bachiller.bachiller_cierre_extras.filtro');
Route::get('bachiller_evidencias/getMateriasEvidencias/{plan_id}/{programa_id}','Bachiller\BachillerCierreExtrasYucatanController@getMateriasEvidencias');
Route::post('bachiller_cierre_extras/realizar','Bachiller\BachillerCierreExtrasYucatanController@cierreExtras')->name('bachiller.bachiller_cierre_extras.cierreExtras');

//Actas Pendientes
Route::get('reporte/bachiller_actas_pendientes', 'Bachiller\Reportes\BachillerActasPendientesYucatanController@reporte')->name('bachiller.bachiller_actas_pendientes.reporte');
Route::post('reporte/bachiller_actas_pendientes/imprimir', 'Bachiller\Reportes\BachillerActasPendientesYucatanController@imprimir')->name('bachiller.bachiller_actas_pendientes.imprimir');


// Reporte de constancias
//Constancia de calificaciones finales (de toda la carrera)
Route::get('reporte/bachiller_calificacion_carrera','Bachiller\Reportes\BachillerCalificacionCarreraController@reporte')->name('bachiller.bachiller_calificacion_carrera.index');
Route::post('reporte/bachiller_calificacion_carrera/imprimir','Bachiller\Reportes\BachillerCalificacionCarreraController@imprimir')->name('bachiller.bachiller_calificacion_carrera.imprimir');

//Constancia de calificaciones parciales
Route::get('reporte/bachiller_calificacion_parcial','Bachiller\Reportes\BachillerCalificacionesParcialesController@reporte')->name('bachiller.bachiller_calificacion_parcial.index');
Route::post('reporte/bachiller_calificacion_parcial/imprimir','Bachiller\Reportes\BachillerCalificacionesParcialesController@imprimir')->name('bachiller.bachiller_calificacion_parcial.imprimir');


//Constancia de Inscripción
Route::get('reporte/bachiller_constancia_inscripcion', 'Bachiller\Reportes\BachillerConstanciaInscripcionController@reporte')->name('bachiller.bachiller_constancia_inscripcion.reporte');
Route::post('reporte/bachiller_constancia_inscripcion/imprimir', 'Bachiller\Reportes\BachillerConstanciaInscripcionController@imprimir')->name('bachiller.bachiller_constancia_inscripcion.imprimir');

//Constancia medica
Route::get('reporte/bachiller_constancia_medica', 'Bachiller\Reportes\BachillerConstanciaMedicaController@reporte')->name('bachiller.bachiller_constancia_medica.reporte');
Route::post('reporte/bachiller_constancia_medica/imprimir', 'Bachiller\Reportes\BachillerConstanciaMedicaController@imprimir')->name('bachiller.bachiller_constancia_medica.imprimir');

// Horario de clases del alumno
Route::get('reporte/bachiller_horario_clases_alumno', 'Bachiller\Reportes\BachillerHorarioDeClasesAlumnoController@reporte')->name('bachiller.bachiller_horario_clases_alumno.reporte');
Route::post('reporte/bachiller_horario_clases_alumno/imprimir', 'Bachiller\Reportes\BachillerHorarioDeClasesAlumnoController@imprimir')->name('bachiller.bachiller_horario_clases_alumno.imprimir');

//Constancia de buena conducta
Route::get('reporte/bachiller_buena_conducta', 'Bachiller\Reportes\BachillerBuenaConductaController@reporte')->name('bachiller.bachiller_buena_conducta.reporte');
Route::post('reporte/bachiller_buena_conducta/imprimir', 'Bachiller\Reportes\BachillerBuenaConductaController@imprimir')->name('bachiller.bachiller_buena_conducta.imprimir');


//Certificado completo
Route::get('reporte/bachiller_certificado_completo','Bachiller\Reportes\BachillerCertificadoCompletoController@reporte')->name('bachiller.bachiller_certificado_completo.reporte');
Route::post('reporte/bachiller_certificado_completo/imprimir','Bachiller\Reportes\BachillerCertificadoCompletoController@imprimir')->name('bachiller.bachiller_certificado_completo.imprimir');

//Puntos perdidos
Route::get('reporte/bachiller_puntos_perdidos','Bachiller\Reportes\BachillerPuntosPerdidosController@reporte')->name('bachiller.bachiller_puntos_perdidos.reporte');
Route::post('reporte/bachiller_puntos_perdidos/imprimir','Bachiller\Reportes\BachillerPuntosPerdidosController@imprimir')->name('bachiller.bachiller_puntos_perdidos.imprimir');

Route::get('bachiller_calificacion_evidencias/{grupo_id}','Bachiller\Reportes\BachillerCalificacionEvidenciaController@imprimir_reporte')->name('bachiller.bachiller_calificacion_evidencias.imprimir_reporte');



//Puntos perdidos
Route::get('reporte/bachiller_precertificado','Bachiller\Reportes\BachillerPreCertificadoController@reporte')->name('bachiller.bachiller_precertificado.reporte');
Route::post('reporte/bachiller_precertificado/imprimir','Bachiller\Reportes\BachillerPreCertificadoController@imprimir')->name('bachiller.bachiller_precertificado.imprimir');

Route::get('reporte/bachiller_historial_alumno', 'Bachiller\Reportes\BachillerHistorialAlumnoController@reporte')->name('bachiller.bachiller_historial_alumno.reporte');
Route::get('bachiller_historial_alumno/obtenerProgramasClave/{aluClave}', 'Bachiller\Reportes\BachillerHistorialAlumnoController@obtenerProgramasClave');
Route::get('bachiller_historial_alumno/obtenerProgramasMatricula/{aluMatricula}', 'Bachiller\Reportes\BachillerHistorialAlumnoController@obtenerProgramasMatricula');
Route::post('reporte/bachiller_historial_alumno/imprimir', 'Bachiller\Reportes\BachillerHistorialAlumnoController@imprimir')->name('bachiller.bachiller_historial_alumno.imprimir');


//Grupos por Materia
Route::get('reporte/bachiller_grupo_materia', 'Bachiller\Reportes\BachillerGrupoMateriaController@reporte')->name('bachiller.bachiller_grupo_materia.reporte');
Route::get('get/reporte/bachiller_grupo_materia/{periodo_id}/{plan_id}', 'Bachiller\Reportes\BachillerGrupoMateriaController@getGruposVigentes');

Route::post('reporte/bachiller_grupo_materia/imprimir', 'Bachiller\Reportes\BachillerGrupoMateriaController@imprimir')->name('bachiller.bachiller_grupo_materia.imprimir');


//Listas de Asistencia por Grupo
Route::get('reporte/bachiller_asistencia_grupo', 'Bachiller\Reportes\BachillerAsistenciaGrupoController@reporte')->name('bachiller.bachiller_asistencia_grupo.reporte');
Route::post('reporte/bachiller_asistencia_grupo/imprimir', 'Bachiller\Reportes\BachillerAsistenciaGrupoController@imprimir')->name('bachiller.bachiller_asistencia_grupo.imprimir');

//Grupos por Materia
Route::get('reporte/bachiller_grupo_materia_cch', 'Bachiller\Reportes\BachillerGrupoMateriaCCHController@reporte')->name('bachiller.bachiller_grupo_materia_cch.reporte');
Route::post('reporte/bachiller_grupo_materia_cch/imprimir', 'Bachiller\Reportes\BachillerGrupoMateriaCCHController@imprimir')->name('bachiller.bachiller_grupo_materia_cch.imprimir');

// Relacion de extraordinarios
Route::get('reporte/bachiller_rel_extraordinarios', 'Bachiller\Reportes\BachillerRelacionExtraordinarioController@reporte')->name('bachiller.bachiller_rel_extraordinarios.reporte');
Route::post('reporte/bachiller_rel_extraordinarios/imprimir', 'Bachiller\Reportes\BachillerRelacionExtraordinarioController@imprimir')->name('bachiller.bachiller_rel_extraordinarios.imprimir');


// Relacion de extraordinarios
Route::get('reporte/bachiller_boleta_final', 'Bachiller\Reportes\BachillerBoletaFinalController@reporte')->name('bachiller.bachiller_boleta_final.reporte');
Route::post('reporte/bachiller_boleta_final/imprimir', 'Bachiller\Reportes\BachillerBoletaFinalController@imprimir')->name('bachiller.bachiller_boleta_final.imprimir');


// Resumen de calificaciones por grupo
Route::get('reporte/bachiller_resumen_calificaciones_grupo', 'Bachiller\Reportes\BachillerResumenCalificacionGrupoController@reporte')->name('bachiller.bachiller_resumen_calificaciones_grupo.reporte');
Route::post('reporte/bachiller_resumen_calificaciones_grupo/imprimir', 'Bachiller\Reportes\BachillerResumenCalificacionGrupoController@imprimir')->name('bachiller.bachiller_resumen_calificaciones_grupo.imprimir');

// Resumen de calificaciones por grupo
Route::get('reporte/bachiller_puntos_cualitativos', 'Bachiller\Reportes\BachillerPuntosCualitativosController@reporte')->name('bachiller.bachiller_puntos_cualitativos.reporte');
Route::post('reporte/bachiller_puntos_cualitativos/imprimir', 'Bachiller\Reportes\BachillerPuntosCualitativosController@imprimir')->name('bachiller.bachiller_puntos_cualitativos.imprimir');

// evidencias faltantes
Route::get('reporte/bachiller_evidencias_faltantes', 'Bachiller\Reportes\BachillerEvidenciasFaltantesController@reporte')->name('bachiller.bachiller_evidencias_faltantes.reporte');
Route::get('api/reporte/bachiller_evidencias_faltantes/{periodo_id}/{plan_id}/{semestre?}', 'Bachiller\Reportes\BachillerEvidenciasFaltantesController@getMateriasVigentes');
Route::post('reporte/bachiller_evidencias_faltantes/imprimir', 'Bachiller\Reportes\BachillerEvidenciasFaltantesController@imprimir')->name('bachiller.bachiller_evidencias_faltantes.imprimir');


//Mejores Promedios Total.
Route::get('reporte/bachiller_mejor_promedio_total', 'Bachiller\Reportes\BachillerMejorPromedioTotalController@reporte')->name('bachiller.bachiller_mejor_promedio_total.reporte');
Route::post('reporte/bachiller_mejor_promedio_total/imprimir', 'Bachiller\Reportes\BachillerMejorPromedioTotalController@imprimir')->name('bachiller.bachiller_mejor_promedio_total.imprimir');

// Resumen de mejores promedios
Route::get('reporte/bachiller_mejores_promedios', 'Bachiller\Reportes\BachillerMejoresPromediosController@reporte')->name('bachiller.bachiller_mejores_promedios.reporte');
Route::post('reporte/bachiller_mejores_promedios/imprimir', 'Bachiller\Reportes\BachillerMejoresPromediosController@imprimir')->name('bachiller.bachiller_mejores_promedios.imprimir');

//Registro de alumnos REA
Route::get('reporte/bachiller_REA', 'Bachiller\Reportes\BachillerREAController@reporte')->name('bachiller.bachiller_REA.reporte');
Route::post('reporte/bachiller_REA/imprimir', 'Bachiller\Reportes\BachillerREAController@imprimir')->name('bachiller.bachiller_REA.imprimir');

//SOCA
Route::get('reporte/bachiller_SOCA', 'Bachiller\Reportes\BachillerSOCAController@reporte')->name('bachiller.bachiller_SOCA.reporte');
Route::post('reporte/bachiller_SOCA/imprimir', 'Bachiller\Reportes\BachillerSOCAController@imprimir')->name('bachiller.bachiller_SOCA.imprimir');

//SOCA
Route::get('reporte/bachiller_SOCA_ACO', 'Bachiller\Reportes\BachillerSOCAACOController@reporte')->name('bachiller.bachiller_SOCA_ACO.reporte');
Route::post('reporte/bachiller_SOCA_ACO/imprimir', 'Bachiller\Reportes\BachillerSOCAACOController@imprimir')->name('bachiller.bachiller_SOCA_ACO.imprimir');

Route::get('reporte/bachiller_BGU_Resultados', 'Bachiller\Reportes\BachillerBGUResultadosController@reporte')->name('bachiller.bachiller_BGU_Resultados.reporte');
Route::post('reporte/bachiller_BGU_Resultados/imprimir', 'Bachiller\Reportes\BachillerBGUResultadosController@imprimir')->name('bachiller.bachiller_BGU_Resultados.imprimir');

//Constancia Computo
Route::get('reporte/bachiller_constancia_computo', 'Bachiller\Reportes\BachillerConstanciaComputoController@reporte')->name('bachiller.bachiller_constancia_computo.reporte');
Route::post('reporte/bachiller_constancia_computo/imprimir', 'Bachiller\Reportes\BachillerConstanciaComputoController@imprimir')->name('bachiller.bachiller_constancia_computo.imprimir');

// Justificaciones
Route::get('bachiller_justificaciones', 'Bachiller\Reportes\BachillerJustificacionesController@index')->name('bachiller.bachiller_justificaciones.index');
Route::get('bachiller_justificaciones/list', 'Bachiller\Reportes\BachillerJustificacionesController@list')->name('bachiller.bachiller_justificaciones.list');
Route::get('bachiller_justificaciones/create', 'Bachiller\Reportes\BachillerJustificacionesController@create')->name('bachiller.bachiller_justificaciones.create');
Route::get('bachiller_justificaciones/{id}', 'Bachiller\Reportes\BachillerJustificacionesController@show')->name('bachiller.bachiller_justificaciones.show');
Route::get('bachiller_justificaciones/{id}/edit', 'Bachiller\Reportes\BachillerJustificacionesController@edit')->name('bachiller.bachiller_justificaciones.edit');
Route::get('reporte/getAlumnosCurso/{periodo_id}/{plan_id}', 'Bachiller\Reportes\BachillerJustificacionesController@getAlumnosCurso');
Route::get('reporte/contarRegistros/{curso_id}', 'Bachiller\Reportes\BachillerJustificacionesController@contarRegistros');
Route::get('reporte/bachiller_justificaciones/imprimir/{id}', 'Bachiller\Reportes\BachillerJustificacionesController@imprimir2')->name('bachiller.bachiller_justificaciones.imprimir2');
Route::get('reporte/bachiller_justificaciones', 'Bachiller\Reportes\BachillerJustificacionesController@reporte')->name('bachiller.bachiller_justificaciones.reporte');
Route::get('bachiller_justificaciones/cambiar_estado/{id}/','Bachiller\Reportes\BachillerJustificacionesController@cambiar_estado')->name('bachiller.bachiller_justificaciones.cambiar_estado');
Route::post('bachiller_justificaciones', 'Bachiller\Reportes\BachillerJustificacionesController@store')->name('bachiller.bachiller_justificaciones.store');
Route::post('reporte/bachiller_justificaciones/imprimir', 'Bachiller\Reportes\BachillerJustificacionesController@imprimir')->name('bachiller.bachiller_justificaciones.imprimir');
Route::post('reporte/bachiller_justificaciones/imprimir_reporte', 'Bachiller\Reportes\BachillerJustificacionesController@imprimir_reporte')->name('bachiller.bachiller_justificaciones.imprimir_reporte');
Route::put('bachiller_justificaciones/{id}', 'Bachiller\Reportes\BachillerJustificacionesController@update')->name('bachiller.bachiller_justificaciones.update');
Route::delete('bachiller_justificaciones/{id}', 'Bachiller\Reportes\BachillerJustificacionesController@destroy')->name('bachiller.bachiller_justificaciones.destroy');


// Conteo de edades 911
Route::get('reporte/bachiller_resumen_edades', 'Bachiller\Reportes\BachillerResumenEdades911Controller@reporte')->name('bachiller.bachiller_resumen_edades.reporte');
Route::post('reporte/bachiller_resumen_edades/imprimir', 'Bachiller\Reportes\BachillerResumenEdades911Controller@imprimir')->name('bachiller.bachiller_resumen_edades.imprimir');

// ADAS que falntan por capturar
Route::get('reporte/bachiller_adas_faltantes', 'Bachiller\Reportes\BachillerADASFaltantesCalificarController@reporte')->name('bachiller.bachiller_adas_faltantes.reporte');
Route::post('reporte/bachiller_adas_faltantes/imprimir', 'Bachiller\Reportes\BachillerADASFaltantesCalificarController@imprimir')->name('bachiller.bachiller_adas_faltantes.imprimir');

//Resumen de inscritos por sexo
Route::get('bachiller_reporte/bachiller_inscritos_sexo','Bachiller\Reportes\BachillerResumenInscritosSexoController@reporte')->name('bachiller.bachiller_inscritos_sexo.reporte');
Route::post('bachiller_reporte/bachiller_inscritos_sexo/imprimir','Bachiller\Reportes\BachillerResumenInscritosSexoController@imprimir')->name('bachiller.bachiller_inscritos_sexo.imprimir');

// alumnos fieles
Route::get('bachiller_reporte/bachiller_lealtad_alumnos','Bachiller\Reportes\BachillerAlumnosFidelidadController@reporte')->name('bachiller.bachiller_lealtad_alumnos.reporte');
Route::post('bachiller_reporte/bachiller_lealtad_alumnos/imprimir','Bachiller\Reportes\BachillerAlumnosFidelidadController@imprimir')->name('bachiller.bachiller_lealtad_alumnos.imprimir');

// Escuela de procedencia
Route::get('bachiller_reporte/bachiller_escuela_procedencia','Bachiller\Reportes\BachillerEscuelaProcedenciaController@reporte')->name('bachiller.bachiller_escuela_procedencia.reporte');
Route::post('bachiller_reporte/bachiller_escuela_procedencia/imprimir','Bachiller\Reportes\BachillerEscuelaProcedenciaController@imprimir')->name('bachiller.bachiller_escuela_procedencia.imprimir');


// reporte de certificados pagados
Route::get('bachiller_reporte/bachiller_certificados_pagados','Bachiller\Reportes\BachillerReciboCertificadoController@reporte')->name('bachiller.bachiller_certificados_pagados.reporte');
Route::post('bachiller_reporte/bachiller_certificados_pagados/imprimir','Bachiller\Reportes\BachillerReciboCertificadoController@imprimir')->name('bachiller.bachiller_certificados_pagados.imprimir');


//Historico inscripciones
Route::get('reporte/bachiller_historico_inscripciones', 'Bachiller\Reportes\BachillerHistoricoInscripcionController@reporte')->name('bachiller.bachiller_historico_inscripciones.reporte');
Route::post('reporte/bachiller_historico_inscripciones/imprimir', 'Bachiller\Reportes\BachillerHistoricoInscripcionController@imprimir')->name('bachiller.bachiller_historico_inscripciones.imprimir');


// Resumen de mejores promedios
Route::get('reporte/bachiller_mejores_promedios_anuales', 'Bachiller\Reportes\BachillerMejoresPromediosAnualesController@reporte')->name('bachiller.bachiller_mejores_promedios_anuales.reporte');
Route::post('reporte/bachiller_mejores_promedios_anuales/imprimir', 'Bachiller\Reportes\BachillerMejoresPromediosAnualesController@imprimir')->name('bachiller.bachiller_mejores_promedios_anuales.imprimir');
Route::get('reporte/getPerAnioPago/{departamento_id}', 'Bachiller\Reportes\BachillerMejoresPromediosAnualesController@getPerAnioPago');

Route::get('reporte/bachiller_horarios_administrativos', 'Bachiller\Reportes\BachillerHorariosAdministrativosController@reporte')->name('bachiller.bachiller_horarios_administrativos.reporte');
Route::post('reporte/bachiller_horarios_administrativos/imprimir', 'Bachiller\Reportes\BachillerHorariosAdministrativosController@imprimir')->name('bachiller.bachiller_horarios_administrativos.imprimir');
