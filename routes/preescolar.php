<?php


//PREESCOLAR
// modulo de cursos preinscritos
Route::get('/preescolar_curso', 'Preescolar\PreescolarCursoController@index')->name('curso_preescolar.index');
Route::get('preescolar_curso/list', 'Preescolar\PreescolarCursoController@list')->name('curso_preescolar.list');
Route::get('preescolar_curso/create', 'Preescolar\PreescolarCursoController@create')->name('curso_preescolar.create');
Route::post('preescolar_curso', 'Preescolar\PreescolarCursoController@store')->name('curso_preescolar.store');
Route::get('preescolar_curso/{id}', 'Preescolar\PreescolarCursoController@show')->name('curso_preescolar.show');
Route::get('preescolar_curso/{id}/edit', 'Preescolar\PreescolarCursoController@edit')->name('curso_preescolar.edit');
Route::put('preescolar_curso/{id}', 'Preescolar\PreescolarCursoController@update')->name('curso_preescolar.update');
Route::get('preescolar_curso/observaciones/{curso_id}/', 'Preescolar\PreescolarCursoController@observaciones')->name('curso_preescolar.observaciones');
Route::post('preescolar_curso/storeObservaciones','Preescolar\PreescolarCursoController@storeObservaciones')->name('curso_preescolar.storeObservacionesCurso');
Route::post('preescolar_curso/bajaCurso','Preescolar\PreescolarCursoController@bajaCurso')->name('curso_preescolar.bajaCurso');
Route::get('api/preescolar_curso/listHistorialPagos/{curso_id}','Preescolar\PreescolarCursoController@listHistorialPagos')->name('api.preescolar_curso.listHistorialPagos');
Route::get('preescolar_curso/crearReferencia/{curso_id}/{tienePagoCeneval}','Preescolar\PreescolarCursoController@crearReferenciaBBVA')->name('preescolar_curso.crearReferencia');
Route::get('preescolar_curso/crearReferenciaHSBC/{curso_id}/{tienePagoCeneval}','Preescolar\PreescolarCursoController@crearReferenciaHSBC')->name('preescolar_curso.crearReferenciaHSBC');
Route::delete('preescolar_curso/eliminar/{id}','Preescolar\PreescolarCursoController@destroy')->name('preescolar_curso.destroy');
Route::get('api/preescolar_curso/conceptosBaja','Preescolar\PreescolarCursoController@conceptosBaja');


// Modulo de alumnos
Route::get('preescolar_alumnos','Preescolar\PreescolarAlumnoController@index')->name('preescolar_alumnos.index');
Route::get('preescolar_alumnos/list','Preescolar\PreescolarAlumnoController@list')->name('preescolar_alumnos.list');
Route::get('preescolar_alumnos/create','Preescolar\PreescolarAlumnoController@create')->name('preescolar_alumnos.create');
Route::post('preescolar_alumnos','Preescolar\PreescolarAlumnoController@store')->name('preescolar_alumnos.store');
Route::post('preescolar_alumnos/tutores/nuevo_tutor','Preescolar\PreescolarAlumnoController@crearTutor')->name('preescolar_alumnos.tutores.nuevo_tutor');
Route::get('preescolar_alumno/ultimo_curso/{alumno_id}', 'Preescolar\PreescolarAlumnoController@ultimoCurso')->name('preescolar_alumno/ultimo_curso/{alumno_id}');
Route::get('preescolar_alumnos/verificar_persona', 'Preescolar\PreescolarAlumnoController@verificarExistenciaPersona')->name('preescolar_alumnos.verificar_persona');
Route::post('preescolar_alumno/api/getMultipleAlumnosByFilter','Preescolar\PreescolarAlumnoController@getMultipleAlumnosByFilter');
Route::post('preescolar_alumnos/rehabilitar_alumno/{alumno_id}','Preescolar\PreescolarAlumnoController@rehabilitarAlumno')->name('Preescolar\PreescolarAlumnoController/rehabilitar_alumno/{alumno_id}');
Route::post('preescolar_alumnos/registrar_empleado/{empleado_id}', 'Preescolar\PreescolarAlumnoController@empleado_crearAlumno')->name('Preescolar\PreescolarAlumnoController/registrar_empleado/{empleado_id}');
Route::get('preescolar_alumnos/{alumnoId}','Preescolar\PreescolarAlumnoController@show')->name('preescolar_alumnos.show');
Route::get('preescolar_alumnos/{alumnoId}/edit','Preescolar\PreescolarAlumnoController@edit')->name('preescolar_alumnos.edit');
Route::put('preescolar_alumnos/{id}','Preescolar\PreescolarAlumnoController@update')->name("preescolar_alumnos.update");

Route::get('preescolar_alumnos/alumnoById/{alumnoId}','Preescolar\PreescolarAlumnoController@getAlumnoById');
Route::get('preescolar_alumnos/listHistorialPagosAluclave/{aluClave}','Preescolar\PreescolarAlumnoController@listHistorialPagosAluclave')->name('preescolar_alumnos.listHistorialPagosAluclave');
Route::get('preescolar_alumnos/cambiar_matricula/{alumnoId}','Preescolar\PreescolarAlumnoController@cambiarMatricula')->name("preescolar_alumnos.cambiarMatricula");
Route::post('preescolar_alumnos/cambiar_matricula/edit','Preescolar\PreescolarAlumnoController@postCambiarMatricula')->name("preescolar_alumnos.cambiarMatricula");

Route::get('preescolar_alumnos/change_password/{alumnoId}','Preescolar\PreescolarAlumnoController@changePassword');
Route::post('preescolar_alumnos/changed_password/{alumnoId}','Preescolar\PreescolarAlumnoController@changePasswordUpdate');


// Modulo de empleados
Route::get('preescolar_empleado','Preescolar\PreescolarEmpleadosController@index')->name('preescolar_empleado.index');
Route::get('preescolar_empleado/list','Preescolar\PreescolarEmpleadosController@list')->name('preescolar_empleado.list');
Route::get('preescolar_empleado/cambio-estado', 'Preescolar\PreescolarEmpleadosController@cambioEstado')->name('preescolar_empleado.cambio-estado');
Route::get('api/preescolar_empleado/{escuela?}','Preescolar\PreescolarEmpleadosController@listEmpleados');
Route::get('preescolar_empleado/create','Preescolar\PreescolarEmpleadosController@create')->name('preescolar_empleado.create');
Route::post('preescolar_empleado/api/empleado/reactivar_empleado/{empleado_id}','Preescolar\PreescolarEmpleadosController@reactivarEmpleado');
Route::post('preescolar_empleado/api/empleado/registrar_alumno/{alumno_id}', 'Preescolar\PreescolarEmpleadosController@alumno_crearEmpleado');
Route::post('preescolar_empleado','Preescolar\PreescolarEmpleadosController@store')->name('preescolar_empleado.store');
Route::get('preescolar_empleado/{id}','Preescolar\PreescolarEmpleadosController@show')->name('preescolar_empleado.show');
Route::get('preescolar_empleado/{id}/edit','Preescolar\PreescolarEmpleadosController@edit')->name('preescolar_empleado.edit');
Route::put('preescolar_empleado/{id}','Preescolar\PreescolarEmpleadosController@update')->name('preescolar_empleado.update');
Route::post('preescolar_empleado/darBaja/{empleado_id}', 'Preescolar\PreescolarEmpleadosController@darDeBaja')->name('preescolar_empleado/darBaja/{empleado_id}');
Route::post('preescolar_cambiar_status_empleado/actualizar_lista', 'Preescolar\PreescolarEmpleadosController@cambiarMultiplesStatusEmpleados');
Route::get('preescolar_empleado/verificar_delete/{empleado_id}', 'Preescolar\PreescolarEmpleadosController@puedeSerEliminado')->name('preescolar_empleado/verificar_delete/{empleado_id}');
Route::delete('preescolar_empleado/{id}','Preescolar\PreescolarEmpleadosController@destroy')->name('preescolar_empleado.destroy');

/* --------------------------- Modulo Cambiar CGT --------------------------- */
Route::get('preescolar_cambiar_cgt/create', 'Preescolar\PreescolarCambiarCGTController@edit')->name('preescolar.preescolar_cambiar_cgt.edit');
Route::get('preescolar_cambiar_cgt/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Preescolar\PreescolarCambiarCGTController@getGradoGrupo');
Route::get('preescolar_cambiar_cgt/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Preescolar\PreescolarCambiarCGTController@getAlumnosGrado');
Route::get('preescolar_cambiar_cgt/getPreescolarInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Preescolar\PreescolarCambiarCGTController@getPreescolarInscritoCursos');
Route::post('preescolar_cambiar_cgt/create', 'Preescolar\PreescolarCambiarCGTController@update')->name('preescolar.preescolar_cambiar_cgt.update');


// CGT Materias
Route::get('preescolar_cgt_materias','Preescolar\PreescolarCGTMateriasController@index')->name('preescolar.preescolar_cgt_materias.index');
Route::get('preescolar_cgt_materias/obtenerMaterias/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Preescolar\PreescolarCGTMateriasController@obtenerMaterias');
Route::post('preescolar_cgt_materias','Preescolar\PreescolarCGTMateriasController@store')->name('preescolar.preescolar_cgt_materias.store');


// grupo rubricas 
Route::get('preescolar_grupo_rubricas','Preescolar\PreescolarGruposRubricaController@index')->name('preescolar.preescolar_grupo_rubricas.index');
Route::get('preescolar_grupo_rubricas/obtenerMaterias/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Preescolar\PreescolarGruposRubricaController@obtenerMaterias');
Route::post('preescolar_grupo_rubricas','Preescolar\PreescolarGruposRubricaController@store')->name('preescolar.preescolar_grupo_rubricas.store');


//Route::resource('preescolar/inscritos', 'CursoController');
//Route::get('preescolar/inscritos','CursoPreescolarController@index')->name('preescolar/inscritos');


Route::get('api/preescolarinscritos/{grupo_id}','Preescolar\PreescolarInscritosController@list')->name('api/preescolarinscritos/{grupo_id}');
// crear lista de asistencia de alumnos
Route::get('preescolarinscritos/listaAsistencia/grupo/{grupo_id}', 'Preescolar\PreescolarCalificacionesController@imprimirListaAsistencia');
//mostrar lista de alumnos de un grupo
Route::get('preescolarinscritos/{grupo_id}/{materia_id}/{peraniopago}', 'Preescolar\PreescolarInscritosController@index')->name('preescolarinscritos/{grupo_id}/{materia_id}/{peraniopago}');

Route::resource('preescolarcalificaciones','Preescolar\PreescolarCalificacionesController');
Route::get('preescolarcalificaciones/{inscrito_id}/{grupo_id}/{materia_id}/{peraniopago}/{trimestre}', 'Preescolar\PreescolarCalificacionesController@index');
//generar PDF SOLO DE UN alumno
Route::get('preescolarinscritos/calificaciones/reporte/{inscrito_id}/{persona_id}/{grado}/{grupo}/{peraniopago}/{trimestre_a_evaluar}', 'Preescolar\PreescolarCalificacionesController@reporteTrimestre');
//generar PDF de todos los alumnos
Route::get('preescolarinscritos/calificacionesgrupo/reporte/{grupo_id}/{trimestre_a_evaluar}', 'Preescolar\PreescolarCalificacionesController@reporteTrimestretodos')->name('preescolarinscritos.calificacionesgrupo.reporte');


// modulo preescolar . calendario
Route::resource('calendario', 'Preescolar\PreescolarAgendaController');
Route::get('calendario', 'Preescolar\PreescolarAgendaController@index')->name('calendario');
Route::get('/calendario/show', 'Preescolar\PreescolarAgendaController@show')->name('eventos');


/* ---------------------- modulo de entrevista inicial ---------------------- */
Route::get('/entrevista', 'Preescolar\PreescolarAlumnosEntrevistaController@create')->name('entrevista.create');
Route::post('/entrevista', 'Preescolar\PreescolarAlumnosEntrevistaController@store')->name('entrevista.store');


/* --------------- modulo preescolar_alumnos_historia_clinica --------------- */
Route::get('/clinica', 'Preescolar\PreescolarAlumnosHistoriaClinicaController@index')->name('clinica.index');
Route::get('clinica/list', 'Preescolar\PreescolarAlumnosHistoriaClinicaController@list')->name('clinica.list');
Route::get('/clinica/create', 'Preescolar\PreescolarAlumnosHistoriaClinicaController@create')->name('clinica.create');
Route::get('/clinica/{id}', 'Preescolar\PreescolarAlumnosHistoriaClinicaController@show')->name('clinica.show');
Route::get('/clinica/{id}/edit', 'Preescolar\PreescolarAlumnosHistoriaClinicaController@edit')->name('clinica.edit');
Route::put('/clinica/{id}', 'Preescolar\PreescolarAlumnosHistoriaClinicaController@update')->name('clinica.update');


// modulo de asignar grupos
Route::get('/inscritosMateria', 'Preescolar\PreescolarAsignarGrupoController@index')->name('PreescolarInscritos.index');
Route::get('/inscritosMateria/list', 'Preescolar\PreescolarAsignarGrupoController@list')->name('PreescolarInscritos.list');
Route::get('/inscritosMateria/create', 'Preescolar\PreescolarAsignarGrupoController@create')->name('PreescolarInscritos.create');
Route::post('/inscritosMateria', 'Preescolar\PreescolarAsignarGrupoController@store')->name('PreescolarInscritos.store');
Route::get('inscritosMateria/{id}/edit', 'Preescolar\PreescolarAsignarGrupoController@edit')->name('PreescolarInscritos.edit');
Route::put('inscritosMateria/{id}', 'Preescolar\PreescolarAsignarGrupoController@update')->name('PreescolarInscritos.update');
Route::get('inscritosMateria/{id}', 'Preescolar\PreescolarAsignarGrupoController@show')->name('PreescolarInscritos.show');
Route::delete('inscritosMateria/{id}', 'Preescolar\PreescolarAsignarGrupoController@destroy')->name('PreescolarInscritos.destroy');
Route::get('inscritosMateria/cambiar_grupo/{inscritoId}', 'Preescolar\PreescolarAsignarGrupoController@cambiarGrupo')->name('PreescolarInscritos.cambiar_grupo');
Route::post('inscritosMateria/postCambiarGrupo', 'Preescolar\PreescolarAsignarGrupoController@postCambiarGrupo')->name('PreescolarInscritos.postCambiarGrupo');
Route::get('inscritosMateria/grupos/{curso_id}','Preescolar\PreescolarAsignarGrupoController@getGrupos');





// modulo de grupo preescolar
// Route::resource('preescolar_grupo','Preescolar\PreescolarGrupoController');
Route::get('preescolar_grupo', 'Preescolar\PreescolarGrupoController@index')->name('preescolar_grupo.index');
Route::get('preescolar_grupo/list', 'Preescolar\PreescolarGrupoController@list')->name('preescolar_grupo.list');
Route::get('/preescolar_grupo/create', 'Preescolar\PreescolarGrupoController@create')->name('preescolar_grupo.create');
Route::post('/preescolar_grupo', 'Preescolar\PreescolarGrupoController@store')->name('preescolar_grupo.store');
Route::get('obtener/materias/{semestre}/{planId}','Preescolar\PreescolarGrupoController@getPreescolarMaterias');
Route::get('/preescolar_grupo/{id}/edit', 'Preescolar\PreescolarGrupoController@edit')->name('preescolar_grupo.edit');
Route::put('/preescolar_grupo/{id}', 'Preescolar\PreescolarGrupoController@update')->name('preescolar_grupo.update');
Route::get('preescolar_grupo/{id}', 'Preescolar\PreescolarGrupoController@show')->name('preescolar_grupo.show');
Route::delete('preescolar_grupo/{id}', 'Preescolar\PreescolarGrupoController@destroy')->name('preescolar_grupo.destroy');


//Reporte de Inscritos y Preinscritos
Route::get('reporte/preescolar_inscrito_preinscrito', 'Preescolar\Reportes\PreescolarInscritosPreinscritosController@reporte')->name('preescolar_inscrito_preinscrito.create');
Route::post('reporte/preescolar_inscrito_preinscrito/imprimir', 'Preescolar\Reportes\PreescolarInscritosPreinscritosController@imprimir')->name('preescolar_inscrito_preinscrito.imprimir');


// Relacion de deudores
Route::get('reporte/preescolar_relacion_deudores', 'Preescolar\Reportes\PreescolarRelDeudoresController@reporte');
Route::post('reporte/preescolar_relacion_deudores/imprimir', 'Preescolar\Reportes\PreescolarRelDeudoresController@imprimir');

// Relacion de deuda individual de un alumno
Route::get('reporte/preescolar_relacion_deudas', 'Preescolar\Reportes\PreescolarRelDeudasController@reporte');
Route::post('reporte/preescolar_relacion_deudas/imprimir', 'Preescolar\Reportes\PreescolarRelDeudasController@imprimir');


Route::get('preescolar/pagos/aplicar_pagos','Preescolar\PreescolarAplicarPagosController@index');
Route::get('preescolar/api/pagos/listadopagos','Preescolar\PreescolarAplicarPagosController@list');
Route::get('preescolar/pagos/aplicar_pagos/create','Preescolar\PreescolarAplicarPagosController@create');
Route::get('preescolar/pagos/aplicar_pagos/edit/{id}','Preescolar\PreescolarAplicarPagosController@edit');
Route::post('preescolar/pagos/aplicar_pagos/update','Preescolar\PreescolarAplicarPagosController@update')->name("preescolarAplicarPagos.update");
Route::post('preescolar/pagos/aplicar_pagos/existeAlumnoByClavePago','Preescolar\PreescolarAplicarPagosController@existeAlumnoByClavePago')->name("preescolarAplicarPagos.existeAlumnoByClavePago");
Route::post('preescolar/pagos/aplicar_pagos/store','Preescolar\PreescolarAplicarPagosController@store')->name("preescolarAplicarPagos.store");
Route::delete('preescolar/pagos/aplicar_pagos/delete/{id}','Preescolar\PreescolarAplicarPagosController@destroy')->name("preescolarAplicarPagos.destroy");
Route::get('preescolar/pagos/aplicar_pagos/detalle/{pagoId}','Preescolar\PreescolarAplicarPagosController@detalle')->name("preescolarAplicarPagos.detalle");
Route::post('preescolar/api/pagos/verificarExistePago/','Preescolar\PreescolarAplicarPagosController@verificarExistePago')->name("preescolarAplicarPagos.verificarExistePago");
Route::get('preescolar/api/aplicar_pagos/buscar_inscripciones_educacion_continua/{pagClaveAlu}', 'Preescolar\PreescolarAplicarPagosController@getInscripcionesEducacionContinua');


Route::get('preescolar_grupo/api/departamentos/{id}','Preescolar\PreescolarGrupoController@getDepartamentos');
Route::get('preescolar_curso/getDepartamentosListaCompleta/{ubicacion_id}/','Preescolar\PreescolarCursoController@getDepartamentosListaCompleta')->name('preescolar_curso.getDepartamentosListaCompleta');
Route::get('preescolar_grupo/getEscuelas/{id}/{otro?}','Preescolar\PreescolarGrupoController@getEscuelas');
Route::get('preescolar_curso/getMateriasByPlan/{plan}/','Preescolar\PreescolarCursoController@getMateriasByPlan')->name('preescolar_curso.getMateriasByPlan');




/* -------------------------------------------------------------------------- */
/*                            Submenu de Catalogos                            */
/* -------------------------------------------------------------------------- */

// Ubicacion
Route::get('preescolar_ubicacion', 'Preescolar\PreescolarUbicacionController@index')->name('preescolar.preescolar_ubicacion.index');
Route::get('preescolar_ubicacion/list','Preescolar\PreescolarUbicacionController@list');
Route::get('preescolar_ubicacion/create','Preescolar\PreescolarUbicacionController@create')->name('preescolar.preescolar_ubicacion.create');
Route::get('preescolar_ubicacion/{id}','Preescolar\PreescolarUbicacionController@show')->name('preescolar.preescolar_ubicacion.show');
Route::get('preescolar_ubicacion/{id}/edit','Preescolar\PreescolarUbicacionController@edit')->name('preescolar.preescolar_ubicacion.edit');
Route::post('preescolar_ubicacion','Preescolar\PreescolarUbicacionController@store')->name('preescolar.preescolar_ubicacion.store');
Route::put('preescolar_ubicacion/{id}','Preescolar\PreescolarUbicacionController@update')->name('preescolar.preescolar_ubicacion.update');

// Departamento
Route::get('preescolar_departamento', 'Preescolar\PreescolarDepartamentoController@index')->name('preescolar.preescolar_departamento.index');
Route::get('preescolar_departamento/list','Preescolar\PreescolarDepartamentoController@list');
Route::get('preescolar_departamento/create','Preescolar\PreescolarDepartamentoController@create')->name('preescolar.preescolar_departamento.create');
Route::get('preescolar_departamento/{id}','Preescolar\PreescolarDepartamentoController@show')->name('preescolar.preescolar_departamento.show');
Route::get('preescolar_departamento/{id}/edit','Preescolar\PreescolarDepartamentoController@edit')->name('preescolar.preescolar_departamento.edit');
Route::post('preescolar_departamento','Preescolar\PreescolarDepartamentoController@store')->name('preescolar.preescolar_departamento.store');
Route::put('preescolar_departamento/{id}','Preescolar\PreescolarDepartamentoController@update')->name('preescolar.preescolar_departamento.update');

// Escuela
Route::get('preescolar_escuela', 'Preescolar\PreescolarEscuelaController@index')->name('preescolar.preescolar_escuela.index');
Route::get('preescolar_escuela/list','Preescolar\PreescolarEscuelaController@list');
Route::get('preescolar_escuela/create','Preescolar\PreescolarEscuelaController@create')->name('preescolar.preescolar_escuela.create');
Route::get('preescolar_escuela/{id}','Preescolar\PreescolarEscuelaController@show')->name('preescolar.preescolar_escuela.show');
Route::get('preescolar_escuela/{id}/edit','Preescolar\PreescolarEscuelaController@edit')->name('preescolar.preescolar_escuela.edit');
Route::get('preescolar_escuela/api/escuelas/{id}/{otro?}','Preescolar\PreescolarEscuelaController@getEscuelas');
Route::post('preescolar_escuela','Preescolar\PreescolarEscuelaController@store')->name('preescolar.preescolar_escuela.store');
Route::put('preescolar_escuela/{id}','Preescolar\PreescolarEscuelaController@update')->name('preescolar.preescolar_escuela.update');

// Programas
Route::get('preescolar_programa','Preescolar\PreescolarProgramasController@index')->name('preescolar.preescolar_programa.index');
Route::get('api/preescolar_programa/list','Preescolar\PreescolarProgramasController@list');
Route::get('preescolar_programa/create','Preescolar\PreescolarProgramasController@create')->name('preescolar.preescolar_programa.create');
Route::get('preescolar_programa/{id}/edit','Preescolar\PreescolarProgramasController@edit')->name('preescolar.preescolar_programa.edit');
Route::get('preescolar_programa/{id}','Preescolar\PreescolarProgramasController@show')->name('preescolar.preescolar_programa.show');

Route::get('api/preescolar_programa/{escuela_id}','Preescolar\PreescolarProgramasController@getProgramas');
Route::get('api/preescolar_programa/{programa_id}','Preescolar\PreescolarProgramasController@getPrograma');
Route::post('preescolar_programa','Preescolar\PreescolarProgramasController@store')->name('preescolar.preescolar_programa.store');
Route::put('preescolar_programa/{id}','Preescolar\PreescolarProgramasController@update')->name('preescolar.preescolar_programa.update');
Route::delete('preescolar_programa/{id}','Preescolar\PreescolarProgramasController@destroy')->name('preescolar.preescolar_programa.destroy');

// Plan
Route::get('preescolar_plan','Preescolar\PreescolarPlanesController@index')->name('preescolar.preescolar_plan.index');
Route::get('preescolar_plan/list','Preescolar\PreescolarPlanesController@list');
Route::get('preescolar_plan/create','Preescolar\PreescolarPlanesController@create')->name('preescolar.preescolar_plan.create');
Route::get('preescolar_plan/{id}/edit','Preescolar\PreescolarPlanesController@edit')->name('preescolar.preescolar_plan.edit');
Route::get('preescolar_plan/{id}','Preescolar\PreescolarPlanesController@show')->name('preescolar.preescolar_plan.show');
Route::get('preescolar_plan/api/planes/{id}','Preescolar\PreescolarPlanesController@getPlanes');
Route::get('preescolar_plan/get_plan/{plan_id}', 'Preescolar\PreescolarPlanesController@getPlan');
Route::get('preescolar_plan/plan/semestre/{id}','Preescolar\PreescolarPlanesControlle@getSemestre');

Route::post('preescolar_plan','Preescolar\PreescolarPlanesController@store')->name('preescolar.preescolar_plan.store');
Route::post('preescolar_plan/cambiarPlanEstado', 'Preescolar\PreescolarPlanesController@cambiarPlanEstado');
Route::put('preescolar_plan/{id}','Preescolar\PreescolarPlanesController@update')->name('preescolar.preescolar_plan.update');
Route::delete('preescolar_plan/{id}','Preescolar\PreescolarPlanesController@destroy')->name('preescolar.preescolar_plan.destroy');

// periodos
Route::get('preescolar_periodo','Preescolar\PreescolarPeriodosController@index')->name('preescolar.preescolar_periodo.index');
Route::get('preescolar_periodo/list','Preescolar\PreescolarPeriodosController@list');
Route::get('preescolar_periodo/create','Preescolar\PreescolarPeriodosController@create')->name('preescolar.preescolar_periodo.create');
Route::get('preescolar_periodo/{id}/edit','Preescolar\PreescolarPeriodosController@edit')->name('preescolar.preescolar_periodo.edit');
Route::get('preescolar_periodo/{id}','Preescolar\PreescolarPeriodosController@show')->name('preescolar.preescolar_periodo.show');
Route::get('preescolar_periodo/periodo/{id}','Preescolar\PreescolarPeriodosController@getPeriodo');
Route::get('preescolar_periodo/api/periodos/{departamento_id}','Preescolar\PreescolarPeriodosController@getPeriodos');


Route::post('preescolar_periodo', 'Preescolar\PreescolarPeriodosController@store')->name('preescolar.preescolar_periodo.store');
Route::put('preescolar_periodo/{id}', 'Preescolar\PreescolarPeriodosController@update')->name('preescolar.preescolar_periodo.update');
Route::delete('preescolar_periodo/{id}', 'Preescolar\PreescolarPeriodosController@destroy')->name('preescolar.preescolar_periodo.destroy');

// materias
Route::get('preescolar_materia','Preescolar\PreescolarMateriasController@index')->name('preescolar.preescolar_materia.index');
Route::get('preescolar_materia/list','Preescolar\PreescolarMateriasController@list');
Route::get('preescolar_materia/create','Preescolar\PreescolarMateriasController@create')->name('preescolar.preescolar_materia.create');
Route::get('preescolar_materia/{id}/edit','Preescolar\PreescolarMateriasController@edit')->name('preescolar.preescolar_materia.edit');
Route::get('preescolar_materia/{id}','Preescolar\PreescolarMateriasController@show')->name('preescolar.preescolar_materia.show');
Route::get('preescolar_materia/prerequisitos/{id}','Preescolar\PreescolarMateriasController@prerequisitos');
Route::get('preescolar_materia/materia/prerequisitos/{id}','Preescolar\PreescolarMateriasController@listPreRequisitos');
Route::get('preescolar_materia/eliminarPrerequisito/{id}/{materia_id}','Preescolar\PreescolarMateriasController@eliminarPrerequisito');
Route::get('preescolar_materia/api/materias/{semestre}/{planId}','Preescolar\PreescolarMateriasController@getMaterias');
Route::post('preescolar_materia','Preescolar\PreescolarMateriasController@store')->name('preescolar.preescolar_materia.store');
Route::post('preescolar_materia/agregarPreRequisitos','Preescolar\PreescolarMateriasController@agregarPreRequisitos')->name('preescolar.preescolar_materia.agregarPreRequisitos');
Route::put('preescolar_materia/{id}','Preescolar\PreescolarMateriasController@update')->name('preescolar.preescolar_materia.update');
Route::delete('preescolar_materia/{id}','Preescolar\PreescolarMateriasController@destroy')->name('preescolar.preescolar_materia.destroy');

// CGT
Route::get('preescolar_cgt','Preescolar\PreescolarCGTController@index')->name('preescolar.preescolar_cgt.index');
Route::get('preescolar_cgt/list','Preescolar\PreescolarCGTController@list');
Route::get('preescolar_cgt/create','Preescolar\PreescolarCGTController@create')->name('preescolar.preescolar_cgt.create');
Route::get('preescolar_cgt/{id}/edit','Preescolar\PreescolarCGTController@edit')->name('preescolar.preescolar_cgt.edit');
Route::get('preescolar_cgt/{id}','Preescolar\PreescolarCGTController@show')->name('preescolar.preescolar_cgt.show');
Route::get('preescolar_cgt/api/cgts/{plan_id}/{periodo_id}','Preescolar\PreescolarCGTController@getCgtsSinN');
Route::post('preescolar_cgt','Preescolar\PreescolarCGTController@store')->name('preescolar.preescolar_cgt.store');
Route::put('preescolar_cgt/{id}','Preescolar\PreescolarCGTController@update')->name('preescolar.preescolar_cgt.update');
Route::delete('preescolar_cgt/{id}','Preescolar\PreescolarCGTController@destroy')->name('preescolar.preescolar_cgt.destroy');

// Cambiar matrículas de alumnos (de un cgt).
Route::get('preescolar_cambiar_matriculas_cgt/{cgt_id}', 'Preescolar\PreescolarCambiarMatriculasController@lista_alumnos');
Route::get('preescolar_cambiar_matriculas_cgt/{cgt_id}/buscar_alumno/{alumno_id}', 'Preescolar\PreescolarCambiarMatriculasController@buscarAlumnoEnCgt');
Route::post('preescolar_cambiar_matriculas_cgt/{cgt_id}/actualizar/{alumno_id}', 'Preescolar\PreescolarCambiarMatriculasController@cambiarMatricula');
Route::post('preescolar_cambiar_matriculas_cgt/{cgt_id}/actualizar_lista', 'Preescolar\PreescolarCambiarMatriculasController@cambiarMultiplesMatriculas');


// Resumen de inscritos
Route::get('reporte/preescolar_resumen_inscritos', 'Preescolar\Reportes\PreescolarResumenInscritosController@reporte');
Route::get('reporte/preescolar_resumen_inscritos/imprimir', 'Preescolar\Reportes\PreescolarResumenInscritosController@imprimir');
Route::get('reporte/preescolar_resumen_inscritos/exportarExcel', 'Preescolar\Reportes\PreescolarResumenInscritosController@exportarExcel');

// Asignar CGT
Route::get('preescolar_asignar_cgt','Preescolar\PreescolarAsignarCGTController@index')->name('preescolar.preescolar_asignar_cgt.index');
Route::get('preescolar_asignar_cgt/getGradoGrupo/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Preescolar\PreescolarAsignarCGTController@getGradoGrupo');
Route::get('preescolar_asignar_cgt/getAlumnosGrado/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Preescolar\PreescolarAsignarCGTController@getAlumnosGrado');
Route::get('preescolar_asignar_cgt/getPreescolarInscritoCursos/{periodo_id}/{programa_id}/{plan_id}/{cgt_id}', 'Preescolar\PreescolarAsignarCGTController@getPreescolarInscritoCursos');
Route::post('preescolar_asignar_cgt','Preescolar\PreescolarAsignarCGTController@update')->name('preescolar.preescolar_asignar_cgt.update');


// Rubicas
Route::get('preescolar_tipo_rubricas','Preescolar\PreescolarTipoRubricasController@index')->name('preescolar.preescolar_tipo_rubricas.index');
Route::get('preescolar_tipo_rubricas/list','Preescolar\PreescolarTipoRubricasController@list');
Route::get('preescolar_tipo_rubricas/create','Preescolar\PreescolarTipoRubricasController@create')->name('preescolar.preescolar_tipo_rubricas.create');
Route::get('preescolar_tipo_rubricas/{id}','Preescolar\PreescolarTipoRubricasController@show')->name('preescolar.preescolar_tipo_rubricas.show');
Route::get('preescolar_tipo_rubricas/{id}/edit','Preescolar\PreescolarTipoRubricasController@edit')->name('preescolar.preescolar_tipo_rubricas.edit');
Route::post('preescolar_tipo_rubricas','Preescolar\PreescolarTipoRubricasController@store')->name('preescolar.preescolar_tipo_rubricas.store');
Route::put('preescolar_tipo_rubricas/{id}','Preescolar\PreescolarTipoRubricasController@update')->name('preescolar.preescolar_tipo_rubricas.update');

// Rubicas
Route::get('preescolar_rubricas','Preescolar\PreescolarRubricasController@index')->name('preescolar.preescolar_rubricas.index');
Route::get('preescolar_rubricas/list','Preescolar\PreescolarRubricasController@list');
Route::get('preescolar_rubricas/create','Preescolar\PreescolarRubricasController@create')->name('preescolar.preescolar_rubricas.create');
Route::get('preescolar_rubricas/getDepartamentosPre/{id}','Preescolar\PreescolarRubricasController@getDepartamentosPre');
Route::get('preescolar_rubricas/getRubricasPre/{programa}/{grado}','Preescolar\PreescolarRubricasController@getRubricasPre');
Route::get('preescolar_rubricas/getRubrica/{programa_id}','Preescolar\PreescolarRubricasController@getRubrica');
Route::get('preescolar_rubricas/{id}','Preescolar\PreescolarRubricasController@show')->name('preescolar.preescolar_rubricas.show');
Route::get('preescolar_rubricas/{id}/edit','Preescolar\PreescolarRubricasController@edit')->name('preescolar.preescolar_rubricas.edit');
Route::post('preescolar_rubricas','Preescolar\PreescolarRubricasController@store')->name('preescolar.preescolar_rubricas.store');
Route::put('preescolar_rubricas/{id}','Preescolar\PreescolarRubricasController@update')->name('preescolar.preescolar_rubricas.update');

// Fechas de Calificaciones
Route::get('preescolar_fecha_de_calificaciones','Preescolar\PreescolarFechaCalificacionesController@index')->name('preescolar.preescolar_fecha_de_calificaciones.index');
Route::get('preescolar_fecha_de_calificaciones/list','Preescolar\PreescolarFechaCalificacionesController@list');
Route::get('preescolar_fecha_de_calificaciones/create','Preescolar\PreescolarFechaCalificacionesController@create')->name('preescolar.preescolar_fecha_de_calificaciones.create');
Route::get('preescolar_fecha_de_calificaciones/{id}/edit','Preescolar\PreescolarFechaCalificacionesController@edit')->name('preescolar.preescolar_fecha_de_calificaciones.edit');
Route::get('preescolar_fecha_de_calificaciones/{id}','Preescolar\PreescolarFechaCalificacionesController@show')->name('preescolar.preescolar_fecha_de_calificaciones.show');

Route::post('preescolar_fecha_de_calificaciones','Preescolar\PreescolarFechaCalificacionesController@store')->name('preescolar.preescolar_fecha_de_calificaciones.store');
Route::put('preescolar_fecha_de_calificaciones/{id}','Preescolar\PreescolarFechaCalificacionesController@update')->name('preescolar.preescolar_fecha_de_calificaciones.update');



// Cambiar contraseña docente
Route::get('preescolar_cambiar_contrasenia', 'Preescolar\PreescolarCambiarContraseniaController@index')->name('preescolar.preescolar_cambiar_contrasenia.index');
Route::get('preescolar_cambiar_contrasenia/list', 'Preescolar\PreescolarCambiarContraseniaController@list');
Route::get('preescolar_cambiar_contrasenia/getEmpleadoCorreo/{id}', 'Preescolar\PreescolarCambiarContraseniaController@getEmpleadoCorreo');
Route::get('preescolar_cambiar_contrasenia/create', 'Preescolar\PreescolarCambiarContraseniaController@create')->name('preescolar.preescolar_cambiar_contrasenia.create');
Route::get('preescolar_cambiar_contrasenia/{id}/edit', 'Preescolar\PreescolarCambiarContraseniaController@edit');
Route::get('preescolar_cambiar_contrasenia/{id}', 'Preescolar\PreescolarCambiarContraseniaController@show');
Route::post('preescolar_cambiar_contrasenia', 'Preescolar\PreescolarCambiarContraseniaController@store')->name('preescolar.preescolar_cambiar_contrasenia.store');
Route::put('preescolar_cambiar_contrasenia/{id}', 'Preescolar\PreescolarCambiarContraseniaController@update')->name('preescolar.preescolar_cambiar_contrasenia.update');

// ajustar plantilla rubricas 
Route::get('preescolar_modificar_plantilla_calificaciones', 'Preescolar\PreescolarCambiarPlantillaController@index')->name('preescolar.preescolar_modificar_plantilla_calificaciones.index');
Route::post('preescolar_modificar_plantilla_calificaciones', 'Preescolar\PreescolarCambiarPlantillaController@actualizar_plantilla')->name('preescolar.preescolar_modificar_plantilla_calificaciones.actualizar_plantilla');



// Reporte de rúbricas

Route::get('reporte/preescolar_rubricas', 'Preescolar\Reportes\PreescolarReporteRubricasController@reporte')->name('reporte.preescolar_rubricas.reporte');
Route::get('reporte/getMaterias/{programa_id}/{plan_id}', 'Preescolar\Reportes\PreescolarReporteRubricasController@getMaterias');
Route::post('reporte/preescolar_rubricas/imprimir', 'Preescolar\Reportes\PreescolarReporteRubricasController@imprimir')->name('reporte.preescolar_rubricas.imprimir');


Route::get('reporte/preescolar_alumnos_excel', 'Preescolar\Reportes\PreescolarReporteAlumnosExcelController@index')->name('preescolar.preescolar_alumnos_excel');
Route::get('reporte/preescolar_alumnos_excel/getAlumnosCursos', 'Preescolar\Reportes\PreescolarReporteAlumnosExcelController@getAlumnosCursos');
Route::get('reporte/datos_completos_alumno', 'Preescolar\Reportes\PreescolarReporteAlumnosExcelController@reporteAlumnos')->name('preescolar.datos_completos_alumno.reporteAlumnos');
Route::get('reporte/datos_completos_alumno/getAlumnosCursosEduardo/preescolar', 'Preescolar\Reportes\PreescolarReporteAlumnosExcelController@getAlumnosCursosEduardo');

//Controller para generar reporte de alumnos becados
Route::get('preescolar_reporte/alumnos_becados', 'Preescolar\Reportes\PreescolarAlumnosBecadosController@reporte')->name('preescolar_reporte.preescolar_alumnos_becados.reporte');
Route::post('preescolar_reporte/alumnos_becados/imprimir', 'Preescolar\Reportes\PreescolarAlumnosBecadosController@imprimir')->name('preescolar_reporte.preescolar_alumnos_becados.imprimir');


//Historial de Pagos de Alumno.
Route::get('preescolar_reporte/preescolar_historial_pagos_alumno', 'Preescolar\Reportes\PreescolarHistorialPagosAlumnoController@reporte');
Route::post('preescolar_reporte/preescolar_historial_pagos_alumno/imprimir', 'Preescolar\Reportes\PreescolarHistorialPagosAlumnoController@imprimir');

//Resumen de inscritos por sexo
Route::get('preescolar_reporte/preescolar_inscritos_sexo','Preescolar\Reportes\PreescolarResumenInscritosSexoController@reporte')->name('preescolar.preescolar_inscritos_sexo.reporte');
Route::post('preescolar_reporte/preescolar_inscritos_sexo/imprimir','Preescolar\Reportes\PreescolarResumenInscritosSexoController@imprimir')->name('preescolar.preescolar_inscritos_sexo.imprimir');

// Calendario calificaciones
// Route::resource('preescolar_calendario_calificaciones','Preescolar\PreescolarCalendarioCalificacionesController');
// Route::get('api/preescolar_calendario_calificaciones/list','Preescolar\PreescolarCalendarioCalificacionesController@list');

Route::get('preescolar_calendario_calificaciones','Preescolar\PreescolarCalendarioCalificacionesController@index')->name('preescolar.preescolar_calendario_calificaciones.index');
Route::get('preescolar_calendario_calificaciones/list','Preescolar\PreescolarCalendarioCalificacionesController@list');
Route::get('preescolar_calendario_calificaciones/create','Preescolar\PreescolarCalendarioCalificacionesController@create')->name('preescolar.preescolar_calendario_calificaciones.create');
Route::get('preescolar_calendario_calificaciones/{id}/edit','Preescolar\PreescolarCalendarioCalificacionesController@edit')->name('preescolar.preescolar_calendario_calificaciones.edit');
Route::get('preescolar_calendario_calificaciones/{id}','Preescolar\PreescolarCalendarioCalificacionesController@show')->name('preescolar.preescolar_calendario_calificaciones.show');

Route::post('preescolar_calendario_calificaciones','Preescolar\PreescolarCalendarioCalificacionesController@store')->name('preescolar.preescolar_calendario_calificaciones.store');
Route::put('preescolar_calendario_calificaciones/{id}','Preescolar\PreescolarCalendarioCalificacionesController@update')->name('preescolar.preescolar_calendario_calificaciones.update');

