<?php

/* -------------------------- Modulo de empleado ------------------------- */

use Illuminate\Support\Facades\Route;

Route::get('primaria_api/obtenerNumerosGrado/{periodo_id}','Primaria\PrimariaFuncionesGeneralesController@obtenerNumerosGrado');
Route::get('primaria_api/departamentos/{id}','Primaria\PrimariaFuncionesGeneralesController@getDepartamentos');



Route::get('/primaria_empleado', 'Primaria\PrimariaEmpleadoController@index')->name('primaria_empleado.index');
Route::get('/primaria_empleado/create', 'Primaria\PrimariaEmpleadoController@create')->name('primaria_empleado.create');
Route::get('/primaria_empleado/list', 'Primaria\PrimariaEmpleadoController@list')->name('primaria_empleado.list');
Route::get('primaria_empleado/cambio-estado', 'Primaria\PrimariaEmpleadoController@cambioEstado')->name('primaria_empleado.cambio-estado');
Route::get('api/primaria_empleado/{escuela?}','Primaria\PrimariaEmpleadoController@listEmpleados');
Route::get('primaria_empleado/verificar_persona', 'Primaria\PrimariaEmpleadoController@verificarExistenciaPersona')->name('primaria_empleado/verificar_persona');
Route::get('primaria_empleado/{id}','Primaria\PrimariaEmpleadoController@show')->name('primaria_empleado.show');
Route::get('primaria_empleado/{id}/edit','Primaria\PrimariaEmpleadoController@edit')->name('primaria_empleado.edit');
Route::get('primaria_empleado/verificar_delete/{empleado_id}', 'Primaria\PrimariaEmpleadoController@puedeSerEliminado')->name('primaria_empleado/verificar_delete/{empleado_id}');
Route::post('primaria_empleado/reactivar_empleado/{empleado_id}','Primaria\PrimariaEmpleadoController@reactivarEmpleado')->name('primaria_empleado/reactivar_empleado/{empleado_id}');
Route::post('primaria_empleado/registrar_alumno/{alumno_id}', 'Primaria\PrimariaEmpleadoController@alumno_crearEmpleado')->name('primaria_empleado/registrar_alumno/{alumno_id}');
Route::post('primaria_empleado','Primaria\PrimariaEmpleadoController@store')->name('primaria_empleado.store');
Route::post('primaria_empleado/darBaja/{empleado_id}', 'Primaria\PrimariaEmpleadoController@darDeBaja')->name('primaria_empleado/darBaja/{empleado_id}');
Route::post('primaria_cambiar_status_empleado/actualizar_lista', 'Primaria\PrimariaEmpleadoController@cambiarMultiplesStatusEmpleados');
Route::put('primaria_empleado/{id}','Primaria\PrimariaEmpleadoController@update')->name('primaria_empleado.update');
Route::delete('primaria_empleado/{id}','Primaria\PrimariaEmpleadoController@destroy')->name('primaria_empleado.destroy');


/* ---------------------------- Módulo de Alumnos --------------------------- */
Route::get('/primaria_alumno', 'Primaria\PrimariaAlumnoController@index')->name('primaria_alumno.index');
Route::get('primaria_alumno/list','Primaria\PrimariaAlumnoController@list')->name('primaria_alumno.list');
Route::get('primaria_alumno/create','Primaria\PrimariaAlumnoController@create')->name('primaria_alumno.create');
Route::post('primaria_alumno','Primaria\PrimariaAlumnoController@store')->name('primaria_alumno.store');
Route::get('primaria_alumno/verificar_persona', 'Primaria\PrimariaAlumnoController@verificarExistenciaPersona')->name('primaria_alumno.verificar_persona');
Route::get('primaria_alumno/{id}/edit','Primaria\PrimariaAlumnoController@edit')->name('primaria_alumno.edit');
Route::put('primaria_alumno/{id}','Primaria\PrimariaAlumnoController@update')->name('primaria_alumno.update');
Route::get('primaria_alumno/{id}','Primaria\PrimariaAlumnoController@show')->name('primaria_alumno.show');
Route::get('primaria_alumno/ultimo_curso/{alumno_id}', 'Primaria\PrimariaAlumnoController@ultimoCurso')->name('primaria_alumno/ultimo_curso/{alumno_id}');
Route::get('primaria_alumno/alumnoById/{alumnoId}','Primaria\PrimariaAlumnoController@getAlumnoById');
Route::post('primaria_alumno/api/getMultipleAlumnosByFilter','Primaria\PrimariaAlumnoController@getMultipleAlumnosByFilter');
Route::get('primaria_alumno/listHistorialPagosAluclave/{aluClave}','Primaria\PrimariaAlumnoController@listHistorialPagosAluclave')->name('primaria_alumno.listHistorialPagosAluclave');
Route::get('primaria_alumno/conceptosBaja','Primaria\PrimariaAlumnoController@conceptosBaja')->name('primaria_alumno.conceptosBaja');
Route::post('primaria_alumno/cambiarEstatusAlumno','Primaria\PrimariaAlumnoController@cambiarEstatusAlumno')->name("primaria_alumno.cambiarEstatusAlumno");
Route::post('primaria_alumno/rehabilitar_alumno/{alumno_id}','Primaria\PrimariaAlumnoController@rehabilitarAlumno')->name('Primaria\PrimariaAlumnoController/rehabilitar_alumno/{alumno_id}');
Route::post('primaria_alumno/registrar_empleado/{empleado_id}', 'Primaria\PrimariaAlumnoController@empleado_crearAlumno')->name('Primaria\PrimariaAlumnoController/registrar_empleado/{empleado_id}');
Route::post('primaria_alumno/tutores/nuevo_tutor','Primaria\PrimariaAlumnoController@crearTutor')->name('primaria_alumno.tutores.nuevo_tutor');
Route::delete('primaria_alumno/{id}','Primaria\PrimariaAlumnoController@destroy')->name('primaria_alumno.destroy');

Route::get('primaria_alumno/change_password/{alumnoId}','Primaria\PrimariaAlumnoController@changePassword');
Route::post('primaria_alumno/changed_password/{alumnoId}','Primaria\PrimariaAlumnoController@changePasswordUpdate');


/* ------------------------------ Módulo cursos ----------------------------- */
//Route::get('/home', 'Primaria\PrimariaCursoController@index')->name('primaria_curso.index');
Route::get('/primaria_curso', 'Primaria\PrimariaCursoController@index')->name('primaria_curso.index');
Route::get('primaria_curso/{curso_id}/constancia_beca/','Primaria\PrimariaCursoController@constanciaBeca')->name('.primaria_curso.constanciaBeca');
Route::get('primaria_curso/listGruposAlumno/{aluClave}','Primaria\PrimariaCursoController@listGruposAlumno');
Route::get('primaria_curso/grupos_alumno/{id}','Primaria\PrimariaCursoController@viewCalificaciones');
Route::get('primaria_curso/api/cursos/{cgt_id}','Primaria\PrimariaCursoController@getCursos');
Route::get('/primaria_curso/create', 'Primaria\PrimariaCursoController@create')->name('primaria_curso.create');
Route::get('primaria_curso/list','Primaria\PrimariaCursoController@list')->name('primaria_curso.list');
Route::get('primaria_curso/conceptosBaja','Primaria\PrimariaCursoController@conceptosBaja')->name('primaria_curso.conceptosBaja');
Route::get('primaria_curso/{id}','Primaria\PrimariaCursoController@show')->name('primaria_curso.show');
Route::get('primaria_curso/{id}/edit','Primaria\PrimariaCursoController@edit')->name('primaria_curso.edit');
Route::put('primaria_curso/{id}','Primaria\PrimariaCursoController@update')->name('primaria_curso.update');
Route::post('/primaria_curso', 'Primaria\PrimariaCursoController@store')->name('primaria_curso.store');
Route::get('primaria_curso/listHistorialPagos/{curso_id}','Primaria\PrimariaCursoController@listHistorialPagos')->name('primaria_curso.listHistorialPagos');
Route::get('primaria_curso/api/curso/{curso_id}','Primaria\PrimariaCursoController@listPreinscritoDetalle')->name('primaria_curso/api/listPreinscritoDetalle');
Route::get('primaria_curso/{curso_id}/historial_calificaciones_alumno/','Primaria\PrimariaCursoController@historialCalificacionesAlumno')->name('primaria_curso.historialCalificacionesAlumno');
Route::get('primaria_curso/api/curso/{curso_id}/listHistorialCalifAlumnos/','Primaria\PrimariaCursoController@listHistorialCalifAlumnos')->name('primaria_curso.listHistorialCalifAlumnos');
Route::get('primaria_curso/api/curso/{curso}/verificar_materias_cargadas', 'Primaria\PrimariaCursoController@verificar_materias_cargadas');
Route::get('primaria_curso/api/curso/infoBaja/{curso_id}','Primaria\PrimariaCursoController@infoBaja')->name('primaria_curso.api.infoBaja');
Route::get('primaria_curso/listPosiblesHermanos/{curso_id}','Primaria\PrimariaCursoController@listPosiblesHermanos')->name('primaria_curso.listPosiblesHermanos');
Route::post('primaria_curso/bajaCurso','Primaria\PrimariaCursoController@bajaCurso')->name('primaria_curso.bajaCurso');
Route::get('primaria_curso/observaciones/{curso_id}/', 'Primaria\PrimariaCursoController@observaciones')->name('primaria_curso.observaciones');
Route::post('primaria_curso/storeObservaciones','Primaria\PrimariaCursoController@storeObservaciones')->name('primaria_curso.storeObservacionesCurso');
Route::post('primaria_curso/curso/altaCurso','Primaria\PrimariaCursoController@altaCurso')->name('primaria_curso.altaCurso');
Route::get('primaria_curso/curso_archivo_observaciones/{curso_id}','Primaria\PrimariaCursoController@cursoArchivoObservaciones')->name('primaria_curso.curso_archivo_observaciones');
Route::get('primaria_curso/crearReferencia/{curso_id}/{tienePagoCeneval}','Primaria\PrimariaCursoController@crearReferenciaBBVA')->name('primaria_curso.crearReferencia');
Route::get('primaria_curso/crearReferenciaHSBC/{curso_id}/{tienePagoCeneval}','Primaria\PrimariaCursoController@crearReferenciaHSBC')->name('primaria_curso.crearReferenciaHSBC');
Route::get('primaria_curso/listMateriasFaltantes/{curso_id}/','Primaria\PrimariaCursoController@listMateriasFaltantes')->name('primaria_curso.listMateriasFaltantes');
Route::get('primaria_curso/getDepartamentosListaCompleta/{ubicacion_id}/','Primaria\PrimariaCursoController@getDepartamentosListaCompleta')->name('primaria_curso.getDepartamentosListaCompleta');
Route::get('primaria_curso/grupos_alumno/ajustar_calificacion/{id}/{aluClave}/{curso_id}','Primaria\PrimariaCursoController@ajustar_calificacion');
Route::get('primaria_curso/getCalificacionUnicoAlumno/{id}/{grupoId}/{aluClave}','Primaria\PrimariaCursoController@getCalificacionUnicoAlumno');
Route::patch('primaria_curso/getCalificacionUnicoAlumno/{id}','Primaria\PrimariaCursoController@ajustar_calificacion_update')->name('primaria_curso.ajustar_calificacion_update');

Route::get('primaria_curso_images/{filename}/{folder}/{folderCampus}', function ($filename, $folder, $folderCampus)
{
    //$path = app_path('upload') . '/' . $filename;

    $path = storage_path(env("PRIMARIA_IMAGEN_CURSO_PATH") . $folder ."/".$folderCampus."/".$filename);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::delete('primaria_curso/delete/{id}','Primaria\PrimariaCursoController@destroy');




/* ----------------------- Módulo de historia clinica ----------------------- */
Route::get('primaria_historia_clinica', 'Primaria\PrimariaAlumnosHistoriaClinicaController@index')->name('primaria_historia_clinica.index');
Route::get('primaria_historia_clinica/list', 'Primaria\PrimariaAlumnosHistoriaClinicaController@list')->name('primaria_historia_clinica.list');
Route::get('primaria_historia_clinica/{id}', 'Primaria\PrimariaAlumnosHistoriaClinicaController@show')->name('primaria_historia_clinica.show');
Route::get('primaria_historia_clinica/{id}/edit', 'Primaria\PrimariaAlumnosHistoriaClinicaController@edit')->name('primaria_historia_clinica.edit');
Route::put('primaria_historia_clinica/{historia}', 'Primaria\PrimariaAlumnosHistoriaClinicaController@update')->name('primaria_historia_clinica.update');



/* -------------------------- Módulo de calendario -------------------------- */
Route::resource('primaria_calendario', 'Primaria\PrimariaAgendaController');
Route::get('/primaria_calendario', 'Primaria\PrimariaAgendaController@index')->name('primaria_calendario.index');
Route::get('/primaria_calendario/show', 'Primaria\PrimariaAgendaController@show')->name('primaria_calendario.show');

/* ------------------------ Módulo entrevista inicial ----------------------- */
Route::get('primaria_entrevista_inicial', 'Primaria\PrimariaAlumnosEntrevistaInicialController@index')->name('primaria.primaria_entrevista_inicial.index');
Route::get('primaria_entrevista_inicial/list', 'Primaria\PrimariaAlumnosEntrevistaInicialController@list');
Route::get('primaria_entrevista_inicial/getDatosAlumno/{id}', 'Primaria\PrimariaAlumnosEntrevistaInicialController@getDatosAlumno');
Route::get('primaria_entrevista_inicial/create', 'Primaria\PrimariaAlumnosEntrevistaInicialController@agregarEntrevista')->name('primaria.primaria_entrevista_inicial.agregarEntrevista');
Route::get('primaria_entrevista_inicial/{id}/edit', 'Primaria\PrimariaAlumnosEntrevistaInicialController@edit');
Route::get('primaria_entrevista_inicial/{id}', 'Primaria\PrimariaAlumnosEntrevistaInicialController@show');
Route::get('primaria_entrevista_inicial/imprimir/{id}', 'Primaria\PrimariaAlumnosEntrevistaInicialController@imprimir');
Route::get('primaria_entrevista_inicial/formato_de_salida/imprimir', 'Primaria\PrimariaAlumnosEntrevistaInicialController@imprimir_formato_de_salida')->name('primaria_entrevista_inicial.formato_de_salida.imprimir');
Route::post('primaria_entrevista_inicial', 'Primaria\PrimariaAlumnosEntrevistaInicialController@guardarEntrevista')->name('primaria.primaria_entrevista_inicial.guardarEntrevista');
Route::put('primaria_entrevista_inicial/{id}', 'Primaria\PrimariaAlumnosEntrevistaInicialController@update')->name('primaria.primaria_entrevista_inicial.update');
Route::delete('primaria_entrevista_inicial/{id}', 'Primaria\PrimariaAlumnosEntrevistaInicialController@destroy');

// Route::post('primaria_entrevista_inicial', 'Primaria\PrimariaAlumnosEntrevistaInicialController@store')->name('primaria.primaria_entrevista_inicial.store');



/* ---------------------------- Módulo de grupos ---------------------------- */
Route::get('primaria_grupo', 'Primaria\PrimariaGrupoController@index')->name('primaria_grupo.index');
Route::get('primaria_grupo/list', 'Primaria\PrimariaGrupoController@list')->name('primaria_grupo.list');
Route::get('primaria_grupo/create', 'Primaria\PrimariaGrupoController@create')->name('primaria_grupo.create');
Route::post('primaria_grupo', 'Primaria\PrimariaGrupoController@store')->name('primaria_grupo.store');
Route::get('primaria_grupo/{id}/edit', 'Primaria\PrimariaGrupoController@edit')->name('primaria_grupo.edit');
Route::put('primaria_grupo/{id}', 'Primaria\PrimariaGrupoController@update')->name('primaria_grupo.update');
Route::get('primaria_grupo/{id}', 'Primaria\PrimariaGrupoController@show')->name('primaria_grupo.show');
Route::get('primaria_grupo/materias/{semestre}/{planId}','Primaria\PrimariaGrupoController@getPrimariaMaterias');
Route::get('primaria_grupo/materiaComplementaria/{primaria_materia_id}/{plan_id}/{periodo_id}/{grado}','Primaria\PrimariaGrupoController@materiaComplementaria');
Route::get('primaria_grupo/api/departamentos/{id}','Primaria\PrimariaGrupoController@getDepartamentos');
Route::get('primaria_grupo/api/escuelas/{id}/{otro?}','Primaria\PrimariaGrupoController@getEscuelas');
Route::get('primaria_grupo/{id}/evidencia','Primaria\PrimariaGrupoController@evidenciaTable')->name('primaria_grupo.evidenciaTable');
Route::get('primaria_grupo/api/grupoEquivalente/{periodo_id}','Primaria\PrimariaGrupoController@listEquivalente')->name('primaria_grupo/api/grupoEquivalente');
Route::get('primaria_grupo/getGrupos/{id}','Primaria\PrimariaGrupoController@getGrupos');
Route::get('primaria_grupo/getMaterias/{id}','Primaria\PrimariaGrupoController@getMaterias');
Route::get('primaria_grupo/getMesEvidencias/{id}','Primaria\PrimariaGrupoController@getMesEvidencias'); //Get evidencias mes
Route::post('primaria_grupo/evidencias','Primaria\PrimariaGrupoController@guardar_actualizar_evidencia')->name('primaria_grupo.guardar_actualizar_evidencia');
Route::get('primaria_calificacion/getMeses/{mes}','Primaria\PrimariaGrupoController@getMeses');
Route::get('primaria_calificacion/getNumeroEvaluacionCreate/{grupo_id}','Primaria\PrimariaGrupoController@getNumeroEvaluacionCreate');
Route::get('primaria_calificacion/getNumeroEvaluacion/{mes}','Primaria\PrimariaGrupoController@getNumeroEvaluacion');
Route::get('api/getEvidencias/{id_grupo}/{id}','Primaria\PrimariaGrupoController@getEvidencias');
Route::delete('primaria_grupo/{id}', 'Primaria\PrimariaGrupoController@destroy')->name('primaria_grupo.destroy');



/* ------------------------ Módulo de asignar grupos ------------------------ */
Route::get('/primaria_asignar_grupo', 'Primaria\PrimariaAsignarGrupoController@index')->name('primaria_asignar_grupo.index');
Route::get('/primaria_asignar_grupo/list', 'Primaria\PrimariaAsignarGrupoController@list')->name('primaria_asignar_grupo.list');
Route::get('/primaria_asignar_grupo/create', 'Primaria\PrimariaAsignarGrupoController@create')->name('primaria_asignar_grupo.create');
Route::post('/primaria_asignar_grupo', 'Primaria\PrimariaAsignarGrupoController@store')->name('primaria_asignar_grupo.store');
Route::get('primaria_asignar_grupo/{id}/edit', 'Primaria\PrimariaAsignarGrupoController@edit')->name('primaria_asignar_grupo.edit');
Route::put('primaria_asignar_grupo/{id}', 'Primaria\PrimariaAsignarGrupoController@update')->name('primaria_asignar_grupo.update');
Route::get('primaria_asignar_grupo/{id}', 'Primaria\PrimariaAsignarGrupoController@show')->name('primaria_asignar_grupo.show');
Route::delete('primaria_asignar_grupo/{id}', 'Primaria\PrimariaAsignarGrupoController@destroy')->name('primaria_asignar_grupo.destroy');
Route::get('primaria_asignar_grupo/cambiar_grupo/{inscritoId}', 'Primaria\PrimariaAsignarGrupoController@cambiarGrupo')->name('primaria_asignar_grupo.cambiar_grupo');
Route::post('primaria_asignar_grupo/postCambiarGrupo', 'Primaria\PrimariaAsignarGrupoController@postCambiarGrupo')->name('primaria_asignar_grupo.postCambiarGrupo');
Route::get('primaria_asignar_grupo/grupos/{curso_id}','Primaria\PrimariaAsignarGrupoController@getGrupos');
Route::get('primaria_asignar_grupo/getDepartamentos/{id}','Primaria\PrimariaAsignarGrupoController@getDepartamentos');
Route::get('primaria_asignar_grupo/getEscuelas/{id}/{otro?}','Primaria\PrimariaAsignarGrupoController@getEscuelas');




/* --------------------------- Módulo de inscritos -------------------------- */
Route::get('primaria_inscritos/list/{grupo_id}','Primaria\PrimariaInscritosController@list')->name('api/primaria_inscritos/{grupo_id}');
Route::get('primaria_inscritos/{grupo_id}', 'Primaria\PrimariaInscritosController@index')->name('primaria_inscritos/{grupo_id}');
Route::get('primaria_inscritos/calificaciones/primerreporte/{inscrito_id}/{persona_id}/{grado}/{grupo}', 'Primaria\PrimariaCalificacionesController@reporteTrimestre');
Route::get('primaria_inscritos/pase_lista/{grupo_id}', 'Primaria\PrimariaInscritosController@pase_de_lista')->name('primaria_inscritos/pase_lista/{grupo_id}');
Route::get('primaria_inscritos/obtenerAlumnosPaseLista/{grupo_id}/{fecha}', 'Primaria\PrimariaInscritosController@obtenerAlumnosPaseLista');
Route::post('primaria_inscritos/asistencia_alumnos/', 'Primaria\PrimariaInscritosController@asistencia_alumnos')->name('primaria.primaria_inscritos.asistencia_alumnos');
Route::post('primaria_inscritos/pase_lista/', 'Primaria\PrimariaInscritosController@guardarPaseLista')->name('primaria_inscritos.guardarPaseLista');


/* ------------------------ Módulo de calificaciones ------------------------ */
Route::resource('primaria_calificacion','Primaria\PrimariaCalificacionesController');
Route::get('primaria_calificacion/{inscrito_id}/{grupo_id}', 'Primaria\PrimariaCalificacionesController@index');
Route::get('primaria_calificacion/create', 'Primaria\PrimariaCalificacionesController@create')->name('primaria_calificacion.create');
Route::get('api/getAlumnos/{id}','Primaria\PrimariaCalificacionesController@getAlumnos');
Route::get('api/getGrupos/{id}','Primaria\PrimariaCalificacionesController@getGrupos');
Route::get('api/getMaterias2/{id}','Primaria\PrimariaCalificacionesController@getMaterias2');
Route::get('api/primaria_calificacion/obtenerDatosEvidencia/{id}','Primaria\PrimariaCalificacionesController@obtenerDatosEvidencia');

Route::get('primaria_calificacion/grupo/{id}/edit','Primaria\PrimariaCalificacionesController@edit_calificacion')->name('primaria_grupo.calificaciones.edit_calificacion');
Route::get('api/getCalificacionesAlumnos/{id}/{grupoId}','Primaria\PrimariaCalificacionesController@getCalificacionesAlumnos');
//Route::get('api/newCalificacionesAlumnos/{id}/{grupoId}','Primaria\PrimariaCalificacionesController@newCalificacionesAlumnos');
Route::post('primaria_calificacion/guardarCalificacion', 'Primaria\PrimariaCalificacionesController@guardarCalificacion')->name('primaria_calificacion.guardarCalificacion');
Route::post('primaria_calificacion/calificaciones','Primaria\PrimariaCalificacionesController@update_calificacion')->name('primaria_calificacion.calificaciones.update_calificacion');
Route::get('boletaAlumnoCurso/{curso_id}','Primaria\PrimariaCalificacionesController@boletadesdecurso')->name('boletadesdecurso');


// Calificaciones generales
Route::get('primaria_calificacion_general','Primaria\PrimariaCalificacionesGeneralesController@viewCalificacionGeneral')->name('primaria.primaria_calificacion_general.viewCalificacionGeneral');
Route::get('datos/primaria_calificacion_general/lista_de_alumnos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}','Primaria\PrimariaCalificacionesGeneralesController@getAlumnosCalificaciones');
Route::get('calificaciones/primaria_calificacion_general/{curso_id}','Primaria\PrimariaCalificacionesGeneralesController@obtenerListaMateriaCalificaciones');
Route::post('primaria_calificacion_general','Primaria\PrimariaCalificacionesGeneralesController@guardarCalificaciones')->name('primaria.primaria_calificacion_general.guardarCalificaciones');


/* --------------------------- Modulo asignar CGT --------------------------- */
Route::get('primaria_asignar_cgt/create', 'Primaria\PrimariaAsignarCGTController@edit')->name('primaria_asignar_cgt.edit');
Route::get('primaria_asignar_cgt/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Primaria\PrimariaAsignarCGTController@getGradoGrupo');
Route::get('primaria_asignar_cgt/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Primaria\PrimariaAsignarCGTController@getAlumnosGrado');
Route::get('primaria_asignar_cgt/getPrimariaInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Primaria\PrimariaAsignarCGTController@getPrimariaInscritoCursos');
Route::post('primaria_asignar_cgt/create', 'Primaria\PrimariaAsignarCGTController@update')->name('primaria_asignar_cgt.update');

/* --------------------------- Modulo Cambiar CGT --------------------------- */
Route::get('primaria_cambiar_cgt/create', 'Primaria\PrimariaCambiarCGTController@edit')->name('primaria.primaria_cambiar_cgt.edit');
Route::get('primaria_cambiar_cgt/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Primaria\PrimariaCambiarCGTController@getGradoGrupo');
Route::get('primaria_cambiar_cgt/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Primaria\PrimariaCambiarCGTController@getAlumnosGrado');
Route::get('primaria_cambiar_cgt/getPrimariaInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Primaria\PrimariaCambiarCGTController@getPrimariaInscritoCursos');
Route::post('primaria_cambiar_cgt/create', 'Primaria\PrimariaCambiarCGTController@update')->name('primaria.primaria_cambiar_cgt.update');

// Cambiar contraseña docente
Route::get('primaria_cambiar_contrasenia', 'Primaria\PrimariaCambiarContraseniaController@index')->name('primaria.primaria_cambiar_contrasenia.index');
Route::get('primaria_cambiar_contrasenia/list', 'Primaria\PrimariaCambiarContraseniaController@list');
Route::get('primaria_cambiar_contrasenia/getEmpleadoCorreo/{id}', 'Primaria\PrimariaCambiarContraseniaController@getEmpleadoCorreo');
Route::get('primaria_cambiar_contrasenia/create', 'Primaria\PrimariaCambiarContraseniaController@create')->name('primaria.primaria_cambiar_contrasenia.create');
Route::get('primaria_cambiar_contrasenia/{id}/edit', 'Primaria\PrimariaCambiarContraseniaController@edit');
Route::get('primaria_cambiar_contrasenia/{id}', 'Primaria\PrimariaCambiarContraseniaController@show');
Route::post('primaria_cambiar_contrasenia', 'Primaria\PrimariaCambiarContraseniaController@store')->name('primaria.primaria_cambiar_contrasenia.store');
Route::put('primaria_cambiar_contrasenia/{id}', 'Primaria\PrimariaCambiarContraseniaController@update')->name('primaria.primaria_cambiar_contrasenia.update');


//Cargar Materias a inscrito
Route::get('primaria_materias_inscrito', 'Primaria\PrimariaMateriasInscritoController@index')->name('primaria.primaria_materias_inscrito.index');
Route::get('primaria_materias_inscrito/ultimo_curso/{alumno_id}', 'Primaria\PrimariaMateriasInscritoController@ultimoCurso');
Route::post('primaria_materias_inscrito/api/getMultipleAlumnosByFilter','Primaria\PrimariaMateriasInscritoController@getMultipleAlumnosByFilter');
Route::post('primaria_materias_inscrito', 'Primaria\PrimariaMateriasInscritoController@store')->name('primaria.primaria_materias_inscrito.store');

/* -------------------------------------------------------------------------- */
/*                            Submenu de Catalogos                            */
/* -------------------------------------------------------------------------- */

// Programas
Route::get('primaria_programa','Primaria\PrimariaProgramasController@index')->name('primaria.primaria_programa.index');
Route::get('api/primaria_programa/list','Primaria\PrimariaProgramasController@list');
Route::get('primaria_programa/create','Primaria\PrimariaProgramasController@create')->name('primaria.primaria_programa.create');
Route::get('primaria_programa/{id}/edit','Primaria\PrimariaProgramasController@edit')->name('primaria.primaria_programa.edit');
Route::get('primaria_programa/{id}','Primaria\PrimariaProgramasController@show')->name('primaria.primaria_programa.show');
Route::get('primaria_programa/api/programas/{escuela_id}','Primaria\PrimariaProgramasController@getProgramas');
Route::get('api/primaria_programa/{escuela_id}','Primaria\PrimariaProgramasController@getProgramas');
Route::get('primaria_programa/api/programa/{programa_id}','Primaria\PrimariaProgramasController@getPrograma');
Route::get('api/primaria_programa/{programa_id}','Primaria\PrimariaProgramasController@getPrograma');
Route::post('primaria_programa','Primaria\PrimariaProgramasController@store')->name('primaria.primaria_programa.store');
Route::put('primaria_programa/{id}','Primaria\PrimariaProgramasController@update')->name('primaria.primaria_programa.update');
Route::delete('primaria_programa/{id}','Primaria\PrimariaProgramasController@destroy')->name('primaria.primaria_programa.destroy');

// Plan
Route::get('primaria_plan','Primaria\PrimariaPlanesController@index')->name('primaria.primaria_plan.index');
Route::get('primaria_plan/list','Primaria\PrimariaPlanesController@list');
Route::get('primaria_plan/plan/semestre/{id}','Primaria\PrimariaPlanesController@getSemestre');
Route::get('primaria_plan/api/planes/{id}','Primaria\PrimariaPlanesController@getPlanes');
Route::get('primaria_plan/create','Primaria\PrimariaPlanesController@create')->name('primaria.primaria_plan.create');
Route::get('primaria_plan/{id}/edit','Primaria\PrimariaPlanesController@edit')->name('primaria.primaria_plan.edit');
Route::get('primaria_plan/{id}','Primaria\PrimariaPlanesController@show')->name('primaria.primaria_plan.show');
Route::get('primaria_plan/get_plan/{plan_id}', 'Primaria\PrimariaPlanesController@getPlan');
Route::post('primaria_plan','Primaria\PrimariaPlanesController@store')->name('primaria.primaria_plan.store');
Route::post('primaria_plan/cambiarPlanEstado', 'Primaria\PrimariaPlanesController@cambiarPlanEstado');
Route::put('primaria_plan/{id}','Primaria\PrimariaPlanesController@update')->name('primaria.primaria_plan.update');
Route::delete('primaria_plan/{id}','Primaria\PrimariaPlanesController@destroy')->name('primaria.primaria_plan.destroy');

// periodos
Route::get('primaria_periodo','Primaria\PrimariaPeriodosController@index')->name('primaria.primaria_periodo.index');
Route::get('primaria_periodo/list','Primaria\PrimariaPeriodosController@list');
Route::get('primaria_periodo/api/periodos/{departamento_id}','Primaria\PrimariaPeriodosController@getPeriodos');
Route::get('primaria_periodo/todos/periodos/{departamento_id}','Primaria\PrimariaPeriodosController@getPeriodosTodos');
Route::get('primaria_periodo/api/periodo/{id}','Primaria\PrimariaPeriodosController@getPeriodo');
Route::get('primaria_periodo/api/periodo/{departamento_id}/posteriores', 'Primaria\PrimariaPeriodosController@getPeriodos_afterDate');
Route::get('primaria_periodo/create','Primaria\PrimariaPeriodosController@create')->name('primaria.primaria_periodo.create');
Route::get('primaria_periodo/{id}/edit','Primaria\PrimariaPeriodosController@edit')->name('primaria.primaria_periodo.edit');
Route::get('primaria_periodo/{id}','Primaria\PrimariaPeriodosController@show')->name('primaria.primaria_periodo.show');
Route::post('primaria_periodo', 'Primaria\PrimariaPeriodosController@store')->name('primaria.primaria_periodo.store');
Route::put('primaria_periodo/{id}', 'Primaria\PrimariaPeriodosController@update')->name('primaria.primaria_periodo.update');
Route::delete('primaria_periodo/{id}', 'Primaria\PrimariaPeriodosController@destroy')->name('primaria.primaria_periodo.destroy');

// materias
Route::get('primaria_materia','Primaria\PrimariaMateriasController@index')->name('primaria.primaria_materia.index');
Route::get('primaria_materia/list','Primaria\PrimariaMateriasController@list');
Route::get('primaria_materia/acd/{materia_id}/{plan_id}','Primaria\PrimariaMateriasController@index_acd')->name('primaria.primaria_materia.index_acd');
Route::get('primaria_materia/listACD/{materia_id}/{plan_id}','Primaria\PrimariaMateriasController@listACD')->name('primaria.primaria_materia.listACD');
Route::get('primaria_materia/create','Primaria\PrimariaMateriasController@create')->name('primaria.primaria_materia.create');
Route::get('primaria_materia_acd/create_acd/{materia_id}','Primaria\PrimariaMateriasController@create_acd')->name('primaria.primaria_materia_acd.create_acd');
Route::get('primaria_materia/{id}/edit','Primaria\PrimariaMateriasController@edit')->name('primaria.primaria_materia.edit');
Route::get('primaria_materia_acd/{id}/edit_acd','Primaria\PrimariaMateriasController@edit_acd')->name('primaria.primaria_materia.edit_acd');
Route::get('primaria_materia/{id}','Primaria\PrimariaMateriasController@show')->name('primaria.primaria_materia.show');
Route::get('primaria_materia_acd/{id}','Primaria\PrimariaMateriasController@show_acd')->name('primaria.primaria_materia.show_acd');
Route::get('primaria_materia/prerequisitos/{id}','Primaria\PrimariaMateriasController@prerequisitos');
Route::get('primaria_materia/materia/prerequisitos/{id}','Primaria\PrimariaMateriasController@listPreRequisitos');
Route::get('primaria_materia/eliminarPrerequisito/{id}/{materia_id}','Primaria\PrimariaMateriasController@eliminarPrerequisito');
Route::get('primaria_materia/materias/{semestre}/{planId}','Primaria\PrimariaMateriasController@getMaterias');
Route::get('primaria_materia/getMateriasByPlan/{plan}/','Primaria\PrimariaMateriasController@getMateriasByPlan')->name('primaria_materia.getMateriasByPlan');
Route::post('primaria_materia','Primaria\PrimariaMateriasController@store')->name('primaria.primaria_materia.store');
Route::post('primaria_materia_acd','Primaria\PrimariaMateriasController@store_acd')->name('primaria.primaria_materia.store_acd');
Route::post('primaria_materia/agregarPreRequisitos','Primaria\PrimariaMateriasController@agregarPreRequisitos')->name('primaria.primaria_materia.agregarPreRequisitos');
Route::put('primaria_materia/{id}','Primaria\PrimariaMateriasController@update')->name('primaria.primaria_materia.update');
Route::put('primaria_materia_acd/{id}','Primaria\PrimariaMateriasController@update_acd')->name('primaria.primaria_materia_acd.update_acd');
Route::delete('primaria_materia/{id}','Primaria\PrimariaMateriasController@destroy')->name('primaria.primaria_materia.destroy');
Route::delete('primaria_materia_acd/{id}','Primaria\PrimariaMateriasController@destroy_acd')->name('primaria.primaria_materia_acd.destroy_acd');


// Materias Asignaturas
Route::get('primaria_materias_asignaturas','Primaria\PrimariaMateriasAsignaturasController@index')->name('primaria.primaria_materias_asignaturas.index');
Route::get('primaria_materias_asignaturas/list','Primaria\PrimariaMateriasAsignaturasController@list');
Route::get('primaria_materias_asignaturas/create','Primaria\PrimariaMateriasAsignaturasController@create')->name('primaria.primaria_materias_asignaturas.create');
Route::get('primaria_materias_asignaturas/getMateriasConAsignatura/{plan_id}/{grado}','Primaria\PrimariaMateriasAsignaturasController@getMateriasConAsignatura');
Route::get('primaria_materias_asignaturas/{id}/edit','Primaria\PrimariaMateriasAsignaturasController@edit');
Route::get('primaria_materias_asignaturas/{id}','Primaria\PrimariaMateriasAsignaturasController@show');
Route::post('primaria_materias_asignaturas','Primaria\PrimariaMateriasAsignaturasController@store')->name('primaria.primaria_materias_asignaturas.store');
Route::put('primaria_materias_asignaturas/{id}','Primaria\PrimariaMateriasAsignaturasController@update')->name('primaria.primaria_materias_asignaturas.update');



//Migrar Inscritos ACD
Route::get('primaria_migrar_inscritos_acd','Primaria\PrimariaMigrarInscritosACDController@index')->name('primaria.primaria_migrar_inscritos_acd.index');
Route::get('primaria_migrar_inscritos_acd/api/getDepartamentosPorUbiClave/{id}','Primaria\PrimariaMigrarInscritosACDController@getDepartamentosPorUbiClave');
Route::post('primaria_migrar_inscritos_acd','Primaria\PrimariaMigrarInscritosACDController@store')->name('primaria.primaria_migrar_inscritos_acd.store');

// CGT
Route::get('primaria_cgt','Primaria\PrimariaCGTController@index')->name('primaria.primaria_cgt.index');
Route::get('primaria_cgt/list','Primaria\PrimariaCGTController@list');
Route::get('primaria_cgt/create','Primaria\PrimariaCGTController@create')->name('primaria.primaria_cgt.create');
Route::get('primaria_cgt/{id}/edit','Primaria\PrimariaCGTController@edit')->name('primaria.primaria_cgt.edit');
Route::get('primaria_cgt/api/cgts/{plan_id}/{periodo_id}','Primaria\PrimariaCGTController@getCgts');
Route::get('primaria_cgt/{id}','Primaria\PrimariaCGTController@show')->name('primaria.primaria_cgt.show');
Route::get('primaria_cgt/api/cgts_sin_n/{plan_id}/{periodo_id}','Primaria\PrimariaCGTController@getCgtsSinN');
Route::get('primaria_cgt/apiss/cgts/{plan_id}/{periodo_id}/{semestre}','Primaria\PrimariaCGTController@getCgtsSemestre');
Route::post('primaria_cgt','Primaria\PrimariaCGTController@store')->name('primaria.primaria_cgt.store');
Route::put('primaria_cgt/{id}','Primaria\PrimariaCGTController@update')->name('primaria.primaria_cgt.update');
Route::delete('primaria_cgt/{id}','Primaria\PrimariaCGTController@destroy')->name('primaria.primaria_cgt.destroy');

// Cambiar matrículas de alumnos (de un cgt).
Route::get('primaria_cambiar_matriculas_cgt/{cgt_id}', 'Primaria\PrimariaCambiarMatriculasController@lista_alumnos');
Route::get('primaria_cambiar_matriculas_cgt/{cgt_id}/buscar_alumno/{alumno_id}', 'Primaria\PrimariaCambiarMatriculasController@buscarAlumnoEnCgt');
Route::post('primaria_cambiar_matriculas_cgt/{cgt_id}/actualizar/{alumno_id}', 'Primaria\PrimariaCambiarMatriculasController@cambiarMatricula');
Route::post('primaria_cambiar_matriculas_cgt/{cgt_id}/actualizar_lista', 'Primaria\PrimariaCambiarMatriculasController@cambiarMultiplesMatriculas');

// CGT Materias
Route::get('primaria_cgt_materias','Primaria\PrimariaCGTMateriasController@index')->name('primaria.primaria_cgt_materias.index');
Route::get('primaria_cgt_materias/obtenerMaterias/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Primaria\PrimariaCGTMateriasController@obtenerMaterias');
Route::post('primaria_cgt_materias','Primaria\PrimariaCGTMateriasController@store')->name('primaria.primaria_cgt_materias.store');

//Asignar docente CGT
Route::get('primaria_asignar_docente_presencial','Primaria\PrimariaAsignarDocenteCGTController@index')->name('primaria.primaria.primaria_asignar_docente_presencial.index');
Route::get('primaria_asignar_docente_virtual','Primaria\PrimariaAsignarDocenteCGTController@indexVirtual')->name('primaria.primaria.primaria_asignar_docente_virtual.indexVirtual');
Route::get('primaria_asignar_docente/obtenerGrupos/{periodo_id}/{plan_id}/{gpoGrado}/{gpoGrupo}/{tipoEmpleado}', 'Primaria\PrimariaAsignarDocenteCGTController@obtenerGrupos');
Route::post('primaria_asignar_docente','Primaria\PrimariaAsignarDocenteCGTController@store')->name('primaria.primaria_asignar_docente.store');

//Cambio de programa
Route::get('primaria_cambio_programa','Primaria\PrimariaCambioDeProgramaController@index')->name('primaria.primaria.primaria_cambio_programa.index');
Route::get('primaria_cambio_programa/getAlumnoPrograma/api/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}/{aluClave}','Primaria\PrimariaCambioDeProgramaController@getAlumnoPrograma');
Route::get('primaria_cambio_programa/getANombrePrograma/api/{programa_id}','Primaria\PrimariaCambioDeProgramaController@getANombrePrograma');
Route::post('primaria_cambio_programa/store','Primaria\PrimariaCambioDeProgramaController@store')->name('primaria.primaria_cambio_programa.store');

// Inscrito Modalidad
Route::get('primaria_inscrito_modalidad','Primaria\PrimariaInscritoModalidadController@index')->name('primaria.primaria.primaria_inscrito_modalidad.index');
Route::get('primaria_inscrito_modalidad/getMateriasAsignaturas/{periodo_id}/{plan_id}','Primaria\PrimariaInscritoModalidadController@getMateriasAsignaturas');
Route::post('primaria_inscrito_modalidad/getAlumnosMateriasAsignaturas','Primaria\PrimariaInscritoModalidadController@getAlumnosMateriasAsignaturas')->name('primaria.primaria.primaria_inscrito_modalidad.getAlumnosMateriasAsignaturas');
Route::post('primaria_inscrito_modalidad/guardarInscritosModalidad','Primaria\PrimariaInscritoModalidadController@guardarInscritosModalidad')->name('primaria.primaria.primaria_inscrito_modalidad.guardarInscritosModalidad');

// Docente modalidad
Route::get('primaria_docente_inscrito_modalidad','Primaria\PrimariaDocenteModalidadController@index')->name('primaria.primaria_docente_inscrito_modalidad.index');
Route::post('primaria_docente_inscrito_modalidad/getAlumnoMateriasAsignaturas','Primaria\PrimariaDocenteModalidadController@getAlumnoMateriasAsignaturas')->name('primaria.primaria_docente_inscrito_modalidad.getAlumnoMateriasAsignaturas');
Route::post('primaria_docente_inscrito_modalidad/store','Primaria\PrimariaDocenteModalidadController@store')->name('primaria.primaria_docente_inscrito_modalidad.store');




// observaciones boleta
Route::get('primaria_obs_boleta','Primaria\PrimariaObservacionesBoletaController@index')->name('primaria.primaria.primaria_obs_boleta.index');
Route::get('primaria_obs_boleta/obtenerObsBoleta/{plan_id}/{periodo_id}/{cgt_id}/{mes}','Primaria\PrimariaObservacionesBoletaController@obtenerObsBoleta');
Route::post('primaria_obs_boleta/','Primaria\PrimariaObservacionesBoletaController@guardar')->name('primaria.primaria.primaria_obs_boleta.guardar');


// modulo perfil
Route::get('primaria_perfil','Primaria\PrimariaPerfilController@index')->name('primaria.primaria_perfil.index');
Route::get('primaria_perfil/list','Primaria\PrimariaPerfilController@list')->name('primaria.primaria_perfil.list');
Route::get('primaria_perfil/{id}/edit','Primaria\PrimariaPerfilController@edit')->name('primaria.primaria_perfil.edit');
Route::get('primaria_perfil/{id}','Primaria\PrimariaPerfilController@show')->name('primaria.primaria_perfil.show');
Route::get('primaria_perfil/imprimir/{id}','Primaria\PrimariaPerfilController@imprimir')->name('primaria.primaria_perfil.imprimir');
Route::post('primaria_perfil','Primaria\PrimariaPerfilController@update')->name('primaria.primaria_perfil.update');

// modulo contenidos fundamentales
Route::get('primaria_contenido_fundamental','Primaria\PrimariaPerfilContenidosFundamentalesController@index')->name('primaria.primaria_contenido_fundamental.index');
Route::get('primaria_contenido_fundamental/list','Primaria\PrimariaPerfilContenidosFundamentalesController@list');
Route::get('primaria_contenido_fundamental/create','Primaria\PrimariaPerfilContenidosFundamentalesController@create')->name('primaria.primaria_contenido_fundamental.create');
Route::get('primaria_contenido_fundamental/{id}/edit','Primaria\PrimariaPerfilContenidosFundamentalesController@edit');
Route::get('primaria_contenido_fundamental/{id}','Primaria\PrimariaPerfilContenidosFundamentalesController@show');
Route::post('primaria_contenido_fundamental','Primaria\PrimariaPerfilContenidosFundamentalesController@store')->name('primaria.primaria_contenido_fundamental.store');
Route::put('primaria_contenido_fundamental/{id}','Primaria\PrimariaPerfilContenidosFundamentalesController@update')->name('primaria.primaria_contenido_fundamental.update');
Route::delete('primaria_contenido_fundamental/{id}','Primaria\PrimariaPerfilContenidosFundamentalesController@destroy')->name('primaria.primaria_contenido_fundamental.destroy');


// modulo de categoria contenidos
Route::get('primaria_categoria_contenido','Primaria\PrimariaCategoriaContenidosController@index')->name('primaria.primaria_categoria_contenido.index');
Route::get('primaria_categoria_contenido/list','Primaria\PrimariaCategoriaContenidosController@list');
Route::get('primaria_categoria_contenido/create','Primaria\PrimariaCategoriaContenidosController@create')->name('primaria.primaria_categoria_contenido.create');
Route::get('primaria_categoria_contenido/{id}/edit','Primaria\PrimariaCategoriaContenidosController@edit');
Route::get('primaria_categoria_contenido/{id}','Primaria\PrimariaCategoriaContenidosController@show');
Route::post('primaria_categoria_contenido','Primaria\PrimariaCategoriaContenidosController@store')->name('primaria.primaria_categoria_contenido.store');
Route::put('primaria_categoria_contenido/{id}','Primaria\PrimariaCategoriaContenidosController@update')->name('primaria.primaria_categoria_contenido.update');
Route::delete('primaria_categoria_contenido/{id}','Primaria\PrimariaCategoriaContenidosController@destroy')->name('primaria.primaria_categoria_contenido.destroy');

// modulo de calificadores del perfil
Route::get('primaria_calificador','Primaria\PrimariaCalificadoresContenidosController@index')->name('primaria.primaria_calificador.index');
Route::get('primaria_calificador/list','Primaria\PrimariaCalificadoresContenidosController@list');
Route::get('primaria_calificador/create','Primaria\PrimariaCalificadoresContenidosController@create')->name('primaria.primaria_calificador.create');
Route::get('primaria_calificador/{id}/edit','Primaria\PrimariaCalificadoresContenidosController@edit');
Route::get('primaria_calificador/{id}','Primaria\PrimariaCalificadoresContenidosController@show');
Route::post('primaria_calificador','Primaria\PrimariaCalificadoresContenidosController@store')->name('primaria.primaria_calificador.store');
Route::put('primaria_calificador/{id}','Primaria\PrimariaCalificadoresContenidosController@update')->name('primaria.primaria_calificador.update');
Route::delete('primaria_calificador/{id}','Primaria\PrimariaCalificadoresContenidosController@destroy')->name('primaria.primaria_calificador.destroy');


// Modulo de seguimiento escolar
Route::get('primaria_seguimiento_escolar','Primaria\PrimariaSeguimientoEscolarController@index')->name('primaria.primaria_seguimiento_escolar.index');
Route::get('primaria_seguimiento_escolar/list','Primaria\PrimariaSeguimientoEscolarController@list');
Route::get('primaria_seguimiento_escolar/create','Primaria\PrimariaSeguimientoEscolarController@create')->name('primaria.primaria_seguimiento_escolar.create');
Route::get('primaria_seguimiento_escolar/{id}/edit','Primaria\PrimariaSeguimientoEscolarController@edit');
Route::get('primaria_seguimiento_escolar/{id}','Primaria\PrimariaSeguimientoEscolarController@show');
Route::get('primaria_seguimiento_escolar/imprimir/{id}','Primaria\PrimariaSeguimientoEscolarController@imprimir');
Route::post('primaria_seguimiento_escolar','Primaria\PrimariaSeguimientoEscolarController@store')->name('primaria.primaria_seguimiento_escolar.store');
Route::put('primaria_seguimiento_escolar/{id}','Primaria\PrimariaSeguimientoEscolarController@update')->name('primaria.primaria_seguimiento_escolar.update');
Route::delete('primaria_seguimiento_escolar/{id}','Primaria\PrimariaSeguimientoEscolarController@destroy');

// Modulo de paneacion docente
Route::get('primaria_planeacion_docente','Primaria\PrimariaPlaneacionEscolarController@index')->name('primaria.primaria_planeacion_docente.index');
Route::get('primaria_planeacion_docente/list','Primaria\PrimariaPlaneacionEscolarController@list');
Route::get('primaria_planeacion_docente/create','Primaria\PrimariaPlaneacionEscolarController@create')->name('primaria.primaria_planeacion_docente.create');
Route::get('primaria_planeacion_docente/getGrupo/{periodo_id}/{programa_id}/{plan_id}/{grado}','Primaria\PrimariaPlaneacionEscolarController@getGrupo');
Route::get('primaria_planeacion_docente/{id}/edit','Primaria\PrimariaPlaneacionEscolarController@edit');
Route::get('primaria_planeacion_docente/{id}','Primaria\PrimariaPlaneacionEscolarController@show');
Route::get('primaria_planeacion_docente/imprimir/{id}','Primaria\PrimariaPlaneacionEscolarController@imprimir');
Route::post('primaria_planeacion_docente','Primaria\PrimariaPlaneacionEscolarController@store')->name('primaria.primaria_planeacion_docente.store');
Route::put('primaria_planeacion_docente/{id}','Primaria\PrimariaPlaneacionEscolarController@update')->name('primaria.primaria_planeacion_docente.update');
Route::delete('primaria_planeacion_docente/{id}','Primaria\PrimariaPlaneacionEscolarController@destroy');


// Modulo de ahorro de alumnos
Route::get('primaria_ahorro_escolar','Primaria\PrimariaAhorroAlumnosController@index')->name('primaria.primaria_ahorro_escolar.index');
Route::get('primaria_ahorro_escolar/list','Primaria\PrimariaAhorroAlumnosController@list');
Route::get('primaria_ahorro_escolar/create','Primaria\PrimariaAhorroAlumnosController@create')->name('primaria.primaria_ahorro_escolar.create');
Route::get('primaria_ahorro_escolar/create/alumno/{empleado_id}/{curso_id}','Primaria\PrimariaAhorroAlumnosController@create');
Route::get('primaria_ahorro_escolar/getGrupo/{periodo_id}/{programa_id}/{plan_id}/{grado}','Primaria\PrimariaAhorroAlumnosController@getGrupo');
Route::get('primaria_ahorro_escolar/mostrarSaldoEnCuenta/{curso_id}','Primaria\PrimariaAhorroAlumnosController@mostrarSaldoEnCuenta');
Route::get('primaria_ahorro_escolar/{id}','Primaria\PrimariaAhorroAlumnosController@show');
// Route::get('primaria_ahorro_escolar/imprimir/{id}','Primaria\PrimariaAhorroAlumnosController@imprimir');
Route::post('primaria_ahorro_escolar','Primaria\PrimariaAhorroAlumnosController@store')->name('primaria.primaria_ahorro_escolar.store');

// Horarios libres
Route::get('primaria_horarios_libres','Primaria\PrimariaHorariosLibresController@index')->name('primaria.primaria_horarios_libres.index');
Route::get('primaria_horarios_libres/list','Primaria\PrimariaHorariosLibresController@list');
Route::get('primaria_horarios_libres/create','Primaria\PrimariaHorariosLibresController@create')->name('primaria.primaria_horarios_libres.create');
Route::get('primaria_horarios_libres/{id}/edit','Primaria\PrimariaHorariosLibresController@edit');
Route::get('primaria_horarios_libres/{id}','Primaria\PrimariaHorariosLibresController@show');
Route::post('primaria_horarios_libres','Primaria\PrimariaHorariosLibresController@store')->name('primaria.primaria_horarios_libres.store');
Route::put('primaria_horarios_libres/{id}','Primaria\PrimariaHorariosLibresController@update')->name('primaria.primaria_horarios_libres.update');
Route::delete('primaria_horarios_libres/{id}','Primaria\PrimariaHorariosLibresController@destroy');


//Fecha publicacion Docente
Route::get('primaria_fecha_publicacion_calificacion_docente','Primaria\PrimariaFechaPublicacionDocenteController@index')->name('primaria.primaria_fecha_publicacion_calificacion_docente.index');
Route::get('primaria_fecha_publicacion_calificacion_docente/list','Primaria\PrimariaFechaPublicacionDocenteController@list');
Route::get('primaria_fecha_publicacion_calificacion_docente/create','Primaria\PrimariaFechaPublicacionDocenteController@create')->name('primaria.primaria_fecha_publicacion_calificacion_docente.create');
Route::get('primaria_fecha_publicacion_calificacion_docente/getMesEvaluacion/{departamento_id}','Primaria\PrimariaFechaPublicacionDocenteController@getMesEvaluacion');
Route::get('primaria_fecha_publicacion_calificacion_docente/{id}/edit','Primaria\PrimariaFechaPublicacionDocenteController@edit')->name('primaria.primaria_fecha_publicacion_calificacion_docente.edit');
Route::post('primaria_fecha_publicacion_calificacion_docente','Primaria\PrimariaFechaPublicacionDocenteController@store')->name('primaria.primaria_fecha_publicacion_calificacion_docente.store');
Route::put('primaria_fecha_publicacion_calificacion_docente/{id}','Primaria\PrimariaFechaPublicacionDocenteController@update')->name('primaria.primaria_fecha_publicacion_calificacion_docente.update');

// Fecha publicacion Alumno
Route::get('primaria_fecha_publicacion_calificacion_alumno','Primaria\PrimariaFechaPublicacionAlumnoController@index')->name('primaria.primaria_fecha_publicacion_calificacion_alumno.index');
Route::get('primaria_fecha_publicacion_calificacion_alumno/list','Primaria\PrimariaFechaPublicacionAlumnoController@list');
Route::get('primaria_fecha_publicacion_calificacion_alumno/create','Primaria\PrimariaFechaPublicacionAlumnoController@create')->name('primaria.primaria_fecha_publicacion_calificacion_alumno.create');
Route::get('primaria_fecha_publicacion_calificacion_alumno/{id}/edit','Primaria\PrimariaFechaPublicacionAlumnoController@edit')->name('primaria.primaria_fecha_publicacion_calificacion_alumno.edit');
Route::post('primaria_fecha_publicacion_calificacion_alumno','Primaria\PrimariaFechaPublicacionAlumnoController@store')->name('primaria.primaria_fecha_publicacion_calificacion_alumno.store');
Route::put('primaria_fecha_publicacion_calificacion_alumno/{id}','Primaria\PrimariaFechaPublicacionAlumnoController@update')->name('primaria.primaria_fecha_publicacion_calificacion_alumno.update');


// Generar promedios trimestrales
Route::get('primaria_generar_promedios', 'Primaria\PrimariaGenerarPromediosController@index')->name('primaria.primaria_generar_promedios.index');
Route::post('primaria_generar_promedios', 'Primaria\PrimariaGenerarPromediosController@generarPromedio')->name('primaria.primaria_generar_promedios.generarPromedio');


// campos formativos
Route::get('primaria_campos_formativos', 'Primaria\PrimariaCamposFormativosController@index')->name('primaria.primaria_campos_formativos.index');
Route::get('primaria_campos_formativos/list', 'Primaria\PrimariaCamposFormativosController@list');
Route::get('primaria_campos_formativos/create', 'Primaria\PrimariaCamposFormativosController@create')->name('primaria.primaria_campos_formativos.create');
Route::get('primaria_campos_formativos/{id}/edit', 'Primaria\PrimariaCamposFormativosController@edit')->name('primaria.primaria_campos_formativos.edit');
Route::get('primaria_campos_formativos/{id}', 'Primaria\PrimariaCamposFormativosController@show')->name('primaria.primaria_campos_formativos.show');
Route::post('primaria_campos_formativos', 'Primaria\PrimariaCamposFormativosController@store')->name('primaria.primaria_campos_formativos.store');
Route::put('primaria_campos_formativos/{id}','Primaria\PrimariaCamposFormativosController@update')->name('primaria.primaria_campos_formativos.update');
Route::delete('primaria_campos_formativos/{id}','Primaria\PrimariaCamposFormativosController@destroy')->name('primaria.primaria_campos_formativos.destroy');

// campos formativos observaciones
Route::get('primaria_campos_formativos_observaciones', 'Primaria\PrimariaCamposFormativosObservacionesController@index')->name('primaria.primaria_campos_formativos_observaciones.index');
Route::get('primaria_campos_formativos_observaciones/list', 'Primaria\PrimariaCamposFormativosObservacionesController@list');
Route::get('primaria_campos_formativos_observaciones/create', 'Primaria\PrimariaCamposFormativosObservacionesController@create')->name('primaria.primaria_campos_formativos_observaciones.create');
Route::get('primaria_campos_formativos_observaciones/{id}/edit', 'Primaria\PrimariaCamposFormativosObservacionesController@edit')->name('primaria.primaria_campos_formativos_observaciones.edit');
Route::get('primaria_campos_formativos_observaciones/{id}', 'Primaria\PrimariaCamposFormativosObservacionesController@show')->name('primaria.primaria_campos_formativos_observaciones.show');
Route::post('primaria_campos_formativos_observaciones', 'Primaria\PrimariaCamposFormativosObservacionesController@store')->name('primaria.primaria_campos_formativos_observaciones.store');
Route::put('primaria_campos_formativos_observaciones/{id}','Primaria\PrimariaCamposFormativosObservacionesController@update')->name('primaria.primaria_campos_formativos_observaciones.update');
Route::delete('primaria_campos_formativos_observaciones/{id}','Primaria\PrimariaCamposFormativosObservacionesController@destroy')->name('primaria.primaria_campos_formativos_observaciones.destroy');


// campos formativos materias
Route::get('primaria_campos_formativos_materias', 'Primaria\PrimariaCamposFormativosMateriasController@index')->name('primaria.primaria_campos_formativos_materias.index');
Route::get('primaria_campos_formativos_materias/list', 'Primaria\PrimariaCamposFormativosMateriasController@list');
Route::get('primaria_campos_formativos_materias/obtenerMaterias/{programa_id}/{plan_id}/{grado}', 'Primaria\PrimariaCamposFormativosMateriasController@obtenerMaterias');
Route::get('primaria_campos_formativos_materias/create', 'Primaria\PrimariaCamposFormativosMateriasController@create')->name('primaria.primaria_campos_formativos_materias.create');
Route::get('primaria_campos_formativos_materias/{id}/edit', 'Primaria\PrimariaCamposFormativosMateriasController@edit')->name('primaria.primaria_campos_formativos_materias.edit');
Route::get('primaria_campos_formativos_materias/{id}', 'Primaria\PrimariaCamposFormativosMateriasController@show')->name('primaria.primaria_campos_formativos_materias.show');
Route::post('primaria_campos_formativos_materias', 'Primaria\PrimariaCamposFormativosMateriasController@store')->name('primaria.primaria_campos_formativos_materias.store');
Route::put('primaria_campos_formativos_materias/{id}','Primaria\PrimariaCamposFormativosMateriasController@update')->name('primaria.primaria_campos_formativos_materias.update');
Route::delete('primaria_campos_formativos_materias/{id}','Primaria\PrimariaCamposFormativosMateriasController@destroy')->name('primaria.primaria_campos_formativos_materias.destroy');



/* --------------------------------------------------------------------------------------- */
/*  Apartir de Aquí son rutas del modulo de reporte, los cuales se dividen por submodulos  */
/* --------------------------------------------------------------------------------------- */

//Historial de Pagos de Alumno.
Route::get('primaria_reporte/historial_pagos_alumno', 'Primaria\Reportes\PrimariaHistorialPagosAlumnoController@reporte');
Route::post('primaria_reporte/historial_pagos_alumno/imprimir', 'Primaria\Reportes\PrimariaHistorialPagosAlumnoController@imprimir');

//generar PDF de todos los alumnos
Route::get('primaria_calificacion/calificacionesgrupo/primerreporte/{grupo_id}/{trimestre_a_evaluar}', 'Primaria\PrimariaCalificacionesController@reporteTrimestretodos');


// Controller para generar reporte de calificaciones
Route::get('primaria_reporte/calificaciones_grupo', 'Primaria\Reportes\PrimariaCalificacionPorGrupoController@Reporte')->name('primaria_reporte.calificaciones_grupo.reporte');
Route::post('primaria_reporte/boleta_calificaciones/imprimir', 'Primaria\Reportes\PrimariaCalificacionPorGrupoController@imprimirCalificaciones')->name('primaria_reporte.boleta_calificaciones.imprimir');


// Controller para generar reporte de expediente de alumnos
Route::get('primaria_reporte/expediente_alumnos', 'Primaria\Reportes\PrimariaExpedienteAlumnosController@index')->name('primaria_reporte.expediente_alumnos.index');
Route::post('primaria_reporte/expediente_alumnos/imprimir', 'Primaria\Reportes\PrimariaExpedienteAlumnosController@imprimirExpediente')->name('primaria_reporte.expediente_alumnos.imprimir');

// controller para generar ficha tecnica
Route::get('primaria_reporte/ficha_tecnica', 'Primaria\Reportes\PrimariaRepoteFichaTecnicaController@index')->name('primaria_reporte.ficha_tecnica.index');
Route::post('primaria_reporte/ficha_tecnica/imprimir', 'Primaria\Reportes\PrimariaRepoteFichaTecnicaController@imprimirFicha')->name('primaria_reporte.ficha_tecnica.imprimir');


// Controller para generar constancias
Route::get('primaria_reporte/carta_conducta/imprimir/{id_curso}/{foto}', 'Primaria\Reportes\PrimariaConstanciasController@imprimirCartaConducta');
Route::get('primaria_reporte/constancia_estudio/imprimir/{id_curso}/{foto}', 'Primaria\Reportes\PrimariaConstanciasController@imprimirConstanciaEstudio');
Route::get('primaria_reporte/constancia_no_adeudo/imprimir/{id_curso}/{foto}', 'Primaria\Reportes\PrimariaConstanciasController@imprimirConstanciaNoAdeudo');
Route::get('primaria_reporte/constancia_de_cupo/imprimir/{id_curso}', 'Primaria\Reportes\PrimariaConstanciasController@imprimirConstanciaCupo');
Route::get('primaria_reporte/constancia_pasaporte_ingles/imprimir/{id_curso}/{foto}', 'Primaria\Reportes\PrimariaConstanciasController@constanciaPasaporteIngles');
Route::get('primaria_reporte/constancia_pasaporte/imprimir/{id_curso}/{foto}', 'Primaria\Reportes\PrimariaConstanciasController@constanciaPasaporte');



//Controller para generar reporte de alumnos becados
Route::get('primaria_reporte/alumnos_becados', 'Primaria\Reportes\PrimariaAlumnosBecadosController@reporte')->name('primaria_reporte.primaria_alumnos_becados.reporte');
Route::post('primaria_reporte/alumnos_becados/imprimir', 'Primaria\Reportes\PrimariaAlumnosBecadosController@imprimir')->name('primaria_reporte.primaria_alumnos_becados.imprimir');


//Relación Maestros Escuela
Route::get('primaria_reporte/relacion_grupo_maestro', 'Primaria\Reportes\PrimariaRelacionMaestrosEscuelaController@reporte')->name('primaria_relacion_maestros_escuela.reporte');
Route::post('primaria_reporte/relacion_grupo_maestro/imprimir', 'Primaria\Reportes\PrimariaRelacionMaestrosEscuelaController@imprimir')->name('primaria_relacion_maestros_escuela.imprimir');

//Relación Maestros ACD
Route::get('primaria_reporte/relacion_maestros_acd', 'Primaria\Reportes\PrimariaRelacionMaestrosACDController@reporte')->name('primaria_reporte.relacion_maestros_acd.reporte');
Route::post('primaria_reporte/relacion_maestros_acd/imprimir', 'Primaria\Reportes\PrimariaRelacionMaestrosACDController@imprimir')->name('primaria_reporte.relacion_maestros_acd.imprimir');

//Reporte de calificacion de grupo por materia
Route::get('primaria_reporte/calificacion_por_materia', 'Primaria\Reportes\PrimariaCalificacionPorMateriaController@reporte')->name('primaria_reporte.calificacion_por_materia.reporte');
Route::get('primaria_reporte/calificacion_por_materia/getGrupos/{programa_id}/{plan_id}/{periodo_id}', 'Primaria\Reportes\PrimariaCalificacionPorMateriaController@getGrupos');
Route::post('primaria_reporte/calificacion_por_materia/imprimir', 'Primaria\Reportes\PrimariaCalificacionPorMateriaController@imprimir')->name('primaria_reporte.calificacion_por_materia.imprimir');

//Reporte para imprimir la lista de asistencia de los grupos
Route::get('primaria_reporte/lista_de_asistencia', 'Primaria\Reportes\PrimariaListaDeAsistenciaController@reporte')->name('primaria_reporte.lista_de_asistencia.reporte');
Route::post('primaria_reporte/lista_de_asistencia/imprimir', 'Primaria\Reportes\PrimariaListaDeAsistenciaController@imprimir')->name('primaria_reporte.lista_de_asistencia.imprimir');

//Reporte para imprimir la lista de asistencia de faltas por grupos
Route::get('primaria_reporte/lista_de_faltas', 'Primaria\Reportes\PrimariaListaDeFaltasController@reporte')->name('primaria_reporte.lista_de_faltas.reporte');
Route::get('primaria_reporte/getGruposGrado/{periodo_id}/{plan_id}/{grado}', 'Primaria\Reportes\PrimariaListaDeFaltasController@getGruposGrado');
Route::post('primaria_reporte/lista_de_faltas/imprimir', 'Primaria\Reportes\PrimariaListaDeFaltasController@imprimir')->name('primaria_reporte.lista_de_faltas.imprimir');


// crear lista de asistencia de alumnos desde grupos
Route::get('primaria_inscritos/lista_de_asistencia/grupo/{grupo_id}', 'Primaria\Reportes\PrimariaListaDeAsistenciaController@imprimirListaAsistencia');

//lista de asistencia ACD
Route::get('primaria_reporte/lista_de_asistencia_ACD', 'Primaria\Reportes\PrimariaListaDeAsistenciaController@reporteACD')->name('primaria_reporte.lista_de_asistencia_ACD.reporteACD');
Route::get('primaria_reporte/lista_de_asistencia_ACD/getGruposACD/{programa_id}/{plan_id}/{perAnioPago}', 'Primaria\Reportes\PrimariaListaDeAsistenciaController@getGruposACD');
Route::post('primaria_reporte/lista_de_asistencia_ACD/imprimir', 'Primaria\Reportes\PrimariaListaDeAsistenciaController@imprimirACD')->name('primaria_reporte.lista_de_asistencia_ACD.imprimirACD');

//Reporte de Inscritos y Preinscritos
Route::get('primaria_reporte/primaria_inscrito_preinscrito', 'Primaria\Reportes\PrimariaInscritosPreinscritosController@reporte')->name('primaria_inscrito_preinscrito.reporte');
Route::post('primaria_reporte/primaria_preinscrito/imprimir', 'Primaria\Reportes\PrimariaInscritosPreinscritosController@imprimir')->name('primaria_inscrito_preinscrito.imprimir');

// Relacion de deudores
Route::get('reporte/primaria_relacion_deudores', 'Primaria\Reportes\PrimariaRelDeudoresController@reporte')->name('primaria_relacion_deudores.reporte');
Route::post('reporte/primaria_relacion_deudores/imprimir', 'Primaria\Reportes\PrimariaRelDeudoresController@imprimir')->name('primaria_relacion_deudores.imprimir');

// Relacion de deuda individual de un alumno
Route::get('reporte/primaria_relacion_deudas', 'Primaria\Reportes\PrimariaRelDeudasController@reporte')->name('primaria_relacion_deudas.reporte');
Route::post('reporte/primaria_relacion_deudas/imprimir', 'Primaria\Reportes\PrimariaRelDeudasController@imprimir')->name('primaria_relacion_deudas.imprimir');


// Calificacion de materias en ingles
Route::get('reporte/primaria_calificacion_materia_ingles', 'Primaria\Reportes\PrimariaCalificacionesIngresController@index')->name('primaria_calificacion_materia_ingles.index');
Route::post('reporte/primaria_calificacion_materia_ingles/imprimir', 'Primaria\Reportes\PrimariaCalificacionesIngresController@imprimir')->name('primaria_calificacion_materia_ingles.imprimir');

// Boleta de calificaciones
Route::get('reporte/primaria_boleta_de_calificaciones', 'Primaria\Reportes\PrimariaBoletaDeCalificacionesController@reporteBoleta')->name('primaria.primaria_boleta_de_calificaciones.reporteBoleta');
Route::post('reporte/primaria_boleta_de_calificaciones/imprimir', 'Primaria\Reportes\PrimariaBoletaDeCalificacionesController@boletadesdecurso')->name('primaria_boleta_de_calificaciones.imprimir.boletadesdecurso');

// Boleta de calificaciones ACD
Route::get('reporte/primaria_boleta_de_calificaciones_acd', 'Primaria\Reportes\PrimariaCalificacionesACDController@reporteBoleta')->name('primaria.primaria_boleta_de_calificaciones_acd.reporteBoleta');
Route::get('reporte/primaria_boleta_de_calificaciones_acd/{curso_id}', 'Primaria\Reportes\PrimariaCalificacionesACDController@boletadesdecurso')->name('primaria.primaria_boleta_de_calificaciones_acd.boletadesdecurso');
Route::post('reporte/primaria_boleta_de_calificaciones_acd/imprimir', 'Primaria\Reportes\PrimariaCalificacionesACDController@imprimir')->name('primaria.primaria_boleta_de_calificaciones_acd.imprimir');

//APLICAR PAGOS MANUALES
Route::get('primaria/pagos/aplicar_pagos','Primaria\PrimariaAplicarPagosController@index');
Route::get('primaria/api/pagos/listadopagos','Primaria\PrimariaAplicarPagosController@list');
Route::get('primaria/pagos/aplicar_pagos/create','Primaria\PrimariaAplicarPagosController@create');
Route::get('primaria/pagos/aplicar_pagos/edit/{id}','Primaria\PrimariaAplicarPagosController@edit');
Route::post('primaria/pagos/aplicar_pagos/update','Primaria\PrimariaAplicarPagosController@update')->name("primariaAplicarPagos.update");
Route::post('primaria/pagos/aplicar_pagos/existeAlumnoByClavePago','Primaria\PrimariaAplicarPagosController@existeAlumnoByClavePago')->name("primariaAplicarPagos.existeAlumnoByClavePago");
Route::post('primaria/pagos/aplicar_pagos/store','Primaria\PrimariaAplicarPagosController@store')->name("primariaAplicarPagos.store");
Route::delete('primaria/pagos/aplicar_pagos/delete/{id}','Primaria\PrimariaAplicarPagosController@destroy')->name("primariaAplicarPagos.destroy");
Route::get('primaria/pagos/aplicar_pagos/detalle/{pagoId}','Primaria\PrimariaAplicarPagosController@detalle')->name("primariaAplicarPagos.detalle");
Route::post('primaria/api/pagos/verificarExistePago/','Primaria\PrimariaAplicarPagosController@verificarExistePago')->name("primariaAplicarPagos.verificarExistePago");
Route::get('primaria/api/aplicar_pagos/buscar_inscripciones_educacion_continua/{pagClaveAlu}', 'Primaria\PrimariaAplicarPagosController@getInscripcionesEducacionContinua');


//Relación de bajas por periodo.
Route::get('reporte/primaria_relacion_bajas_periodo','Primaria\Reportes\PrimariaRelacionBajasPeriodoController@reporte')->name('primaria.primaria_relacion_bajas_periodo.reporte');
Route::post('reporte/primaria_relacion_bajas_periodo/imprimir', 'Primaria\Reportes\PrimariaRelacionBajasPeriodoController@imprimir')->name('primaria.primaria_relacion_bajas_periodo.imprimir');


// historial academico de alumnos
Route::get('reporte/primaria_historial_alumno', 'Primaria\Reportes\PrimariaHistorialAlumnoController@reporte')->name('primaria.primaria_historial_alumno.reporte');
Route::get('primaria_historial_alumno/imprimir/{plan_id}/{aluClave}', 'Primaria\Reportes\PrimariaHistorialAlumnoController@imprimirDesdCurso')->name('primaria.primaria_historial_alumno.imprimirDesdCurso');

Route::post('reporte/primaria_historial_alumno/imprimir', 'Primaria\Reportes\PrimariaHistorialAlumnoController@imprimir')->name('primaria.primaria_historial_alumno.imprimir');
Route::get('primaria_historial_alumno/obtenerProgramasClave/{aluClave}', 'Primaria\Reportes\PrimariaHistorialAlumnoController@obtenerProgramasClave');
Route::get('primaria_historial_alumno/obtenerProgramasMatricula/{aluMatricula}', 'Primaria\Reportes\PrimariaHistorialAlumnoController@obtenerProgramasMatricula');

// reporte de perfiles
Route::get('reporte/primaria_perfil_alumno', 'Primaria\Reportes\PrimariaPerfilesController@index')->name('primaria.primaria_perfil_alumno.index');
Route::post('reporte/primaria_perfil_alumno', 'Primaria\Reportes\PrimariaPerfilesController@imprimir')->name('primaria.primaria_perfil_alumno.imprimir');

// Reporte de planeacion docente
Route::get('reporte/planeacion_docente', 'Primaria\Reportes\PrimariaPlaneacionDocenteController@index')->name('primaria.reporte.planeacion_docente.index');
Route::get('reporte/primaria_planeacion_docente/getGrupoReporte/{periodo_id}/{programa_id}/{plan_id}','Primaria\Reportes\PrimariaPlaneacionDocenteController@getGrupoReporte');
Route::post('reporte/planeacion_docente', 'Primaria\Reportes\PrimariaPlaneacionDocenteController@imprimir')->name('primaria.reporte.planeacion_docente.imprimir');


//Reporte para mostrar ahorros de los alumnos
Route::get('reporte/ahorro_escolar', 'Primaria\Reportes\PrimariaAhorroDeAlumnosController@index')->name('primaria.reporte.ahorro_escolar.index');
Route::get('reporte/ahorro_escolar/desde_grupo/imprimir/{programa_id}/{plan_id}/{periodo_id}/{grado}/{grupo}/{clave_pago}', 'Primaria\Reportes\PrimariaAhorroDeAlumnosController@imprimir')->name('primaria.reporte.ahorro_escolar.imprimir');
Route::post('reporte/ahorro_escolar/imprimir', 'Primaria\Reportes\PrimariaAhorroDeAlumnosController@imprimir')->name('primaria.reporte.ahorro_escolar.imprimir');

//Grupos por grados
Route::get('reporte/primaria_relacion_tutores', 'Primaria\Reportes\PrimariaRelacionPadresTutoresController@index')->name('primaria.primaria_relacion_tutores.index');
Route::post('reporte/primaria_relacion_tutores/imprimir', 'Primaria\Reportes\PrimariaRelacionPadresTutoresController@imprimir')->name('primaria.primaria_relacion_tutores.imprimir');


// reporte de lista de edades
Route::get('reporte/primaria_lista_edades', 'Primaria\Reportes\PrimariaReporteCalculoEdadesController@index')->name('primaria.primaria_lista_edades.index');
Route::post('reporte/primaria_lista_edades/imprimir', 'Primaria\Reportes\PrimariaReporteCalculoEdadesController@imprimir')->name('primaria.primaria_lista_edades.imprimir');


// Resumen de inscritos
Route::get('reporte/primaria_resumen_inscritos', 'Primaria\Reportes\PrimariaResumenInscritosController@reporte');
Route::get('reporte/primaria_resumen_inscritos/imprimir', 'Primaria\Reportes\PrimariaResumenInscritosController@imprimir');
Route::get('reporte/primaria_resumen_inscritos/exportarExcel', 'Primaria\Reportes\PrimariaResumenInscritosController@exportarExcel');


Route::get('reporte/primaria_alumnos_excel', 'Primaria\Reportes\PrimariaReporteAlumnosExcelController@index')->name('primaria.primaria_alumnos_excel');
Route::get('reporte/primaria_alumnos_excel/getAlumnosCursos', 'Primaria\Reportes\PrimariaReporteAlumnosExcelController@getAlumnosCursos');
Route::get('reporte/primaria_datos_completos_alumno', 'Primaria\Reportes\PrimariaReporteAlumnosExcelController@reporteAlumnos')->name('primaria.primaria_datos_completos_alumno.reporteAlumnos');
Route::get('reporte/primaria_datos_completos_alumno/getAlumnosCursosEduardo/primaria', 'Primaria\Reportes\PrimariaReporteAlumnosExcelController@getAlumnosCursosEduardo');

// Controller para generar reporte de calificaciones faltantes
Route::get('primaria_reporte/calificaciones_faltantes', 'Primaria\Reportes\PrimariaCalificacionFaltanteController@Reporte')->name('primaria_reporte.calificaciones_faltantes.reporte');
Route::post('primaria_reporte/calificacion_faltante/imprimir', 'Primaria\Reportes\PrimariaCalificacionFaltanteController@imprimirCalificacionesFaltantes')->name('primaria_reporte.calificacion_faltante.imprimir');

//Reporte para imprimir la lista de asistencia de los grupos
Route::get('primaria_reporte/lista_de_asistencia_virtual_presencial', 'Primaria\Reportes\PrimariaListaDeAsistenciaVirPresController@reporte')->name('primaria_reporte.lista_de_asistencia_virtual_presencial.reporte');
Route::post('primaria_reporte/lista_de_asistencia_virtual_presencial/imprimir', 'Primaria\Reportes\PrimariaListaDeAsistenciaVirPresController@imprimir')->name('primaria_reporte.lista_de_asistencia_virtual_presencial.imprimir');

//Reporte para imprimir la lista de asistencia de los grupos
Route::get('primaria_reporte/constancia_cupo', 'Primaria\Reportes\PrimariaContanciaCupoController@reporte')->name('primaria_reporte.constancia_cupo.reporte');
Route::post('primaria_reporte/constancia_cupo/imprimir', 'Primaria\Reportes\PrimariaContanciaCupoController@imprimir')->name('primaria_reporte.constancia_cupo.imprimir');

//Reporte para imprimir la lista de asistencia de los grupos
Route::get('primaria_reporte/constancia_estudio', 'Primaria\Reportes\PrimariaContanciaEstudioController@reporte')->name('primaria_reporte.constancia_estudio.reporte');
Route::post('primaria_reporte/constancia_estudio/imprimir', 'Primaria\Reportes\PrimariaContanciaEstudioController@imprimir')->name('primaria_reporte.constancia_estudio.imprimir');

//Reporte para imprimir constancia de pasaporte
Route::get('primaria_reporte/constancia_pasaporte', 'Primaria\Reportes\PrimariaContanciaPasaporteController@reporte')->name('primaria_reporte.constancia_pasaporte.reporte');
Route::post('primaria_reporte/constancia_pasaporte/imprimir', 'Primaria\Reportes\PrimariaContanciaPasaporteController@imprimir')->name('primaria_reporte.constancia_pasaporte.imprimir');


Route::get('primaria_reporte/no_adeudo', 'Primaria\Reportes\PrimariaConstanciaNoAdeudoController@reporte')->name('primaria_reporte.no_adeudo.reporte');
Route::post('primaria_reporte/no_adeudo/imprimir', 'Primaria\Reportes\PrimariaConstanciaNoAdeudoController@imprimir')->name('primaria_reporte.no_adeudo.imprimir');

//Listas de Asistencia por Grupo
Route::get('reporte/primaria_asistencia_grupo', 'Primaria\Reportes\PrimariaAsistenciaGrupoController@reporte')->name('primaria.primaria_asistencia_grupo.reporte');
Route::post('reporte/primaria_asistencia_grupo/imprimir', 'Primaria\Reportes\PrimariaAsistenciaGrupoController@imprimir')->name('primaria.primaria_asistencia_grupo.imprimir');

//Grupos por Materia
Route::get('reporte/primaria_grupo_materia', 'Primaria\Reportes\PrimariaGrupoMateriaController@reporte')->name('primaria.primaria_grupo_materia.reporte');
Route::post('reporte/primaria_grupo_materia/imprimir', 'Primaria\Reportes\PrimariaGrupoMateriaController@imprimir')->name('primaria.primaria_grupo_materia.imprimir');


Route::get('reporte/primaria_buena_conducta', 'Primaria\Reportes\PrimariaConstanciaBuenaConductaController@reporte')->name('primaria.primaria_buena_conducta.reporte');
Route::post('reporte/primaria_buena_conducta/imprimir', 'Primaria\Reportes\PrimariaConstanciaBuenaConductaController@imprimir')->name('primaria.primaria_buena_conducta.imprimir');

//Resumen de inscritos por sexo
Route::get('primaria_reporte/primaria_inscritos_sexo','Primaria\Reportes\PrimariaResumenInscritosSexoController@reporte')->name('primaria.primaria_inscritos_sexo.reporte');
Route::post('primaria_reporte/primaria_inscritos_sexo/imprimir','Primaria\Reportes\PrimariaResumenInscritosSexoController@imprimir')->name('primaria.primaria_inscritos_sexo.imprimir');

Route::get('reporte/primaria_estatus_preescolar', 'Primaria\Reportes\PrimariaEstudiaronPreescolarController@reporte')->name('primaria.primaria_estatus_preescolar.reporte');
Route::post('reporte/primaria_estatus_preescolar/imprimir', 'Primaria\Reportes\PrimariaEstudiaronPreescolarController@imprimir')->name('primaria.primaria_estatus_preescolar.imprimir');

// Resumen de mejores promedios
Route::get('reporte/primaria_mejores_promedios', 'Primaria\Reportes\PrimariaMejoresPromediosController@reporte')->name('primaria.primaria_mejores_promedios.reporte');
Route::post('reporte/primaria_mejores_promedios/imprimir', 'Primaria\Reportes\PrimariaMejoresPromediosController@imprimir')->name('primaria.primaria_mejores_promedios.imprimir');


//Listas de faltas
Route::get('reporte/primaria_faltas', 'Primaria\Reportes\PrimariaFaltasController@reporte')->name('primaria.primaria_faltas.reporte');
Route::post('reporte/primaria_faltas/imprimir', 'Primaria\Reportes\PrimariaFaltasController@imprimir')->name('primaria.primaria_faltas.imprimir');

// calificaciones campos formativos
Route::get('reporte/calificaciones_grupo_campos_formativos', 'Primaria\Reportes\PrimariaCalificacionCamposFormativosGrupoController@reporte')->name('primaria.calificaciones_grupo_campos_formativos.reporte');
Route::post('reporte/calificaciones_grupo_campos_formativos/imprimir', 'Primaria\Reportes\PrimariaCalificacionCamposFormativosGrupoController@imprimir')->name('primaria.calificaciones_grupo_campos_formativos.imprimir');
