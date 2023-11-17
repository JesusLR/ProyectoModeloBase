<?php


use Illuminate\Support\Facades\Route;

/* --------------------- Módulo de bitacora electronica --------------------- */

Route::get('tutorias_bitacora_electronica', 'Tutorias\TutoriasBitacoraElectronicaController@index')->name('tutorias_bitacora_electronica.index');


/* --------------------------- Módulo de usuarios --------------------------- */
Route::get('/tutorias_usuario', 'Tutorias\TutoriasUsuariosController@index')->name('tutorias_usuario.index');
Route::get('tutorias_usuario/list', 'Tutorias\TutoriasUsuariosController@list');
Route::get('/tutorias_usuario/create', 'Tutorias\TutoriasUsuariosController@create')->name('tutorias_usuario.create');
Route::get('/tutorias_usuario/{UsuarioID}/edit', 'Tutorias\TutoriasUsuariosController@edit')->name('tutorias_usuario.edit');
Route::get('/tutorias_usuario/{UsuarioID}', 'Tutorias\TutoriasUsuariosController@show')->name('tutorias_usuario.show');
Route::post('/tutorias_usuario', 'Tutorias\TutoriasUsuariosController@store')->name('tutorias_usuario.store');


/* ----------------------------- Módulo de roles ---------------------------- */
Route::get('/tutorias_rol', 'Tutorias\TutoriasRolesController@index')->name('tutorias_rol.index');
Route::get('/tutorias_rol/list', 'Tutorias\TutoriasRolesController@list')->name('tutorias_rol.list');
Route::get('/tutorias_rol/create', 'Tutorias\TutoriasRolesController@create')->name('tutorias_rol.create');
Route::post('/tutorias_rol', 'Tutorias\TutoriasRolesController@store')->name('tutorias_rol.store');
Route::get('tutorias_rol/{RolID}/edit', 'Tutorias\TutoriasRolesController@edit')->name('tutorias_rol.edit');
Route::put('tutorias_rol/{RolID}', 'Tutorias\TutoriasRolesController@update')->name('tutorias_rol.update');
Route::get('tutorias_rol/{RolID}', 'Tutorias\TutoriasRolesController@show')->name('tutorias_rol.show');

/* ---------------------------- Modulo de alumnos --------------------------- */

Route::get('/tutorias_encuestas', 'Tutorias\TutoriasEncuestasController@index')->name('tutorias_encuestas.index');
Route::get('/tutorias_encuestas/list', 'Tutorias\TutoriasEncuestasController@list')->name('tutorias_encuestas.list');
Route::get('/tutorias_encuestas/create', 'Tutorias\TutoriasEncuestasController@create_alumnos')->name('tutorias_encuestas.create_alumnos');
Route::get('/tutorias_encuestas/encuestas_disponibles/{AlumnoID}/{curso_id}', 'Tutorias\TutoriasEncuestasController@encuestas_disponibles')->name('tutorias_encuestas.encuestas');
Route::get('/tutorias_encuestas/encuesta/{FormularioID}/{AlumnoID}', 'Tutorias\TutoriasEncuestasController@encuesta')->name('tutorias_encuestas.encuesta');
Route::get('/tutorias_encuestas/encuesta_covid/{FormularioID}/{AlumnoID}', 'Tutorias\TutoriasEncuestasController@encuesta_covid')->name('tutorias_encuestas.Covid');

Route::post('/tutorias_encuestas/', 'Tutorias\TutoriasEncuestasController@store')->name('tutorias_encuestas.store');
Route::post('/tutorias_encuestas/covid', 'Tutorias\TutoriasEncuestasController@storeCovid')->name('tutorias_encuestas.storeCovid');
Route::post('tutorias_encuestas/storeAlumno', 'Tutorias\TutoriasEncuestasController@storeAlumno')->name('tutorias_encuestas.storeAlumno');





/* ---------------------- Modulo de categoria preguntas --------------------- */
Route::get('/tutorias_categoria_pregunta', 'Tutorias\TutoriasCategoriaPreguntasController@index')->name('tutorias_categoria_pregunta.index');
Route::get('/tutorias_categoria_pregunta/list', 'Tutorias\TutoriasCategoriaPreguntasController@list')->name('tutorias_categoria_pregunta.list');
Route::get('/tutorias_categoria_pregunta/{categotiapregunta}/edit', 'Tutorias\TutoriasCategoriaPreguntasController@edit')->name('tutorias_categoria_pregunta.create');
Route::get('/tutorias_categoria_pregunta/create', 'Tutorias\TutoriasCategoriaPreguntasController@create')->name('tutorias_categoria_pregunta.create');
Route::get('/tutorias_categoria_pregunta/{categotiapregunta}', 'Tutorias\TutoriasCategoriaPreguntasController@show')->name('tutorias_categoria_pregunta.show');
Route::post('/tutorias_categoria_pregunta', 'Tutorias\TutoriasCategoriaPreguntasController@store')->name('tutorias_categoria_pregunta.store');
Route::put('/tutorias_categoria_pregunta/{CategoriaPreguntaID}', 'Tutorias\TutoriasCategoriaPreguntasController@update')->name('tutorias_categoria_pregunta.update');
Route::delete('tutorias_categoria_pregunta/{CategoriaPreguntaID}', 'Tutorias\TutoriasCategoriaPreguntasController@destroy')->name('tutorias_categoria_pregunta.destroy');


/* ----------------------- Módulo de crear formulario ----------------------- */

Route::get('/tutorias_formulario', 'Tutorias\TutoriasFormularioController@index')->name('tutorias_formulario.index');
Route::get('/tutorias_formulario/list', 'Tutorias\TutoriasFormularioController@list')->name('tutorias_formulario.list');
Route::get('/tutorias_formulario/create', 'Tutorias\TutoriasFormularioController@create')->name('tutorias_formulario.create');
Route::post('/tutorias_formulario', 'Tutorias\TutoriasFormularioController@store')->name('tutorias_formulario.store');
Route::get('/tutorias_formulario/{FormularioID}/edit', 'Tutorias\TutoriasFormularioController@edit')->name('tutorias_formulario.edit');
Route::put('/tutorias_formulario/{FormularioID}', 'Tutorias\TutoriasFormularioController@update')->name('tutorias_formulario.update');
Route::put('/tutorias_formulario/{FormularioID}/actulizarEstatus', 'Tutorias\TutoriasFormularioController@actulizarEstatus')->name('tutorias_formulario.actulizarEstatus');
Route::delete('/tutorias_formulario/{FormularioID}', 'Tutorias\TutoriasFormularioController@destroy')->name('tutorias_formulario.destroy');


/* -------------------- Modulo de preguntas y respuestas -------------------- */
Route::get('/tutorias_formulario_preguntas/{FormularioID}', 'Tutorias\TutoriasRespuestasFormularioController@index')->name('tutorias_formulario_preguntas.index');
Route::get('/tutorias_formulario_preguntas/lista_preguntas/{FormularioID}', 'Tutorias\TutoriasRespuestasFormularioController@lista_preguntas')->name('tutorias_formulario_preguntas.lista_preguntas');
Route::get('tutorias_formulario_preguntas/respuesta_pregunta/{PreguntaID}','Tutorias\TutoriasRespuestasFormularioController@getPreguntaID');
Route::get('tutorias_formulario_preguntas/create_pregunta/{FormularioID}','Tutorias\TutoriasRespuestasFormularioController@crearPregunta')->name('tutorias_formulario_preguntas/create_pregunta/{FormularioID}');
Route::post('tutorias_formulario_preguntas/create_pregunta','Tutorias\TutoriasRespuestasFormularioController@guardarPregunta')->name('tutorias_formulario_preguntas.guardarPregunta');
Route::post('tutorias_formulario_preguntas/AjaxGuardarCategoria','Tutorias\TutoriasRespuestasFormularioController@AjaxGuardarCategoria')->name('tutorias_formulario_preguntas.AjaxGuardarCategoria');

Route::get('/tutorias_formulario_preguntas/{PreguntaID}/crear_respuesta', 'Tutorias\TutoriasRespuestasFormularioController@create')->name('tutorias_formulario_preguntas/{PreguntaID}/crear_respuesta');
Route::put('/tutorias_formulario_preguntas/{PreguntaID}', 'Tutorias\TutoriasRespuestasFormularioController@store')->name('tutorias_formulario_preguntas.store');
Route::get('/tutorias_formulario_preguntas/{PreguntaID}/edit', 'Tutorias\TutoriasRespuestasFormularioController@edit')->name('tutorias_formulario_preguntas.edit');
Route::put('/tutorias_formulario_preguntas/{PreguntaID}/update', 'Tutorias\TutoriasRespuestasFormularioController@update')->name('tutorias_formulario_preguntas.update');
Route::delete('/tutorias_formulario_preguntas/delete/{PreguntaID}/{FormularioID}', 'Tutorias\TutoriasRespuestasFormularioController@destroy')->name('tutorias_formulario_preguntas.destroy');



/* ---------------------- Modulo de factores de riesgo ---------------------- */
Route::get('/tutorias_factores_riesgo', 'Tutorias\TutoriasFactoresDeRiesgoController@index')->name('tutorias_factores_riesgo.index');
Route::get('/tutorias_factores_riesgo/list', 'Tutorias\TutoriasFactoresDeRiesgoController@list')->name('tutorias_factores_riesgo.list');
Route::get('/tutorias_factores_riesgo/{AlumnoID}/respuestas', 'Tutorias\TutoriasFactoresDeRiesgoController@showRespuestas')->name('tutorias_factores_riesgo.respuestas');
Route::put('/tutorias_factores_riesgo/edit/{PreguntaRespuestaID}', 'Tutorias\TutoriasFactoresDeRiesgoController@update');
Route::get('/tutorias_tutorias/{AlumnoID}/create', 'Tutorias\TutoriasTutoriasController@create');
Route::post('/tutorias_tutorias', 'Tutorias\TutoriasTutoriasController@store')->name('tutorias_tutorias.store');

/* ---------------------- API'S PARA LLENAR LOS SELECTS EN LAS VISTAS ---------------------- */
Route::get('api/tutorias/preguntas', 'Tutorias\Api\PreguntaController@preguntas');
Route::get('api/tutorias/respuestas', 'Tutorias\Api\RespuestaController@respuestas');



/*
* ------------------------ REPORTES DE TUTORIAS --------------------------------
*/

// Tutorías - Reportes - Reporte por tipo respuestas.
Route::get('reporte/tutorias/reporte_por_tipo_respuesta', 'Tutorias\Reportes\ReportePorTipoRespuestaController@reporte');
Route::post('reporte/tutorias/reporte_por_tipo_respuesta/imprimir', 'Tutorias\Reportes\ReportePorTipoRespuestaController@imprimir');

// Tutorías - Reportes - Reporte por tipo respuestas cuantitativo.
Route::get('reporte/tutorias/reporte_cuantitativo_respuesta', 'Tutorias\Reportes\ReporteCuantitativoRespuestaController@reporte');
Route::post('reporte/tutorias/reporte_cuantitativo_respuesta/imprimir', 'Tutorias\Reportes\ReporteCuantitativoRespuestaController@imprimir');

// Tutorías - Reportes - Alumnos Faltantes Encuesta.
Route::get('reporte/tutorias/alumnos_faltantes_encuesta', 'Tutorias\Reportes\AlumnosFaltantesEncuestaController@reporte');
Route::post('reporte/tutorias/alumnos_faltantes_encuesta/imprimir', 'Tutorias\Reportes\AlumnosFaltantesEncuestaController@imprimir');























