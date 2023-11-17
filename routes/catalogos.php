<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE CATÁLOGOS
|--------------------------------------------------------------------------
|
*/

// Ubicacion Route
Route::resource('ubicacion','UbicacionController');
Route::get('api/ubicacion','UbicacionController@list')->name('api/ubicacion');

// Departamento Route
Route::resource('departamento','DepartamentoController');
Route::get('api/departamento','DepartamentoController@list')->name('api/departamento');
Route::get('api/departamentos/{id}','DepartamentoController@getDepartamentos');
Route::get('api/get_departamentos_lista_completa/{ubicacion_id}','DepartamentoController@getDepartamentosListaCompleta');

// Escuela Route
Route::resource('escuela','EscuelaController');
Route::get('api/escuela','EscuelaController@list')->name('api/escuela');
Route::get('api/escuelas/{id}/{otro?}','EscuelaController@getEscuelas');
Route::get('api/get_escuelas_lista_completa/{departamento_id}','EscuelaController@getEscuelasListaCompleta');

// Programa Route
Route::resource('programa','ProgramaController');
Route::get('api/programa','ProgramaController@list')->name('api/programa');
Route::get('api/programas/{escuela_id}','ProgramaController@getProgramas');
Route::get('api/programa/{programa_id}','ProgramaController@getPrograma');

// Plan Route
Route::resource('plan','PlanController');
Route::get('api/plan','PlanController@list')->name('api/plan');
Route::get('api/planes/{id}','PlanController@getPlanes');
Route::get('api/planes_federales/{id}','PlanController@getPlanesFederales');
Route::get('api/get_plan/{plan_id}', 'PlanController@getPlan')->name('api/get_plan/{plan_id}');
Route::get('api/plan/semestre/{id}','PlanController@getSemestre');
Route::post('api/plan/cambiarPlanEstado', 'PlanController@cambiarPlanEstado')->name('api/plan/cambiarPlanEstado');

// Periodo Route
Route::resource('periodo','PeriodoController');
Route::get('api/periodo','PeriodoController@list')->name('api/periodo');
Route::get('api/periodos/{departamento_id}','PeriodoController@getPeriodos');
Route::get('api/periodo/{id}','PeriodoController@getPeriodo');
Route::get('api/periodo/{departamento_id}/posteriores', 'PeriodoController@getPeriodos_afterDate')->name('api/periodo/{departamento_id}/posteriores');
Route::get('api/periodoByDepartamento/{departamentoId}','PeriodoController@getPeriodosByDepartamento');

// Materia Route
Route::resource('materia','MateriaController');
Route::get('materia/prerequisitos/{id}','MateriaController@prerequisitos');
Route::get('api/materia/prerequisitos/{id}','MateriaController@listPreRequisitos');
Route::post('materia/agregarPreRequisitos','MateriaController@agregarPreRequisitos')->name('materia/agregarPreRequisitos');
Route::get('materia/eliminarPrerequisito/{id}/{materia_id}','MateriaController@eliminarPrerequisito');
Route::get('api/materia','MateriaController@list')->name('api/materia');
Route::get('api/getMateriasByPlan/{plan}','MateriaController@getMateriasByPlan');
Route::get('api/materias/{semestre}/{planId}','MateriaController@getMaterias');
Route::get('api/materiasOptativas/{plan_id}','MateriaController@getMateriasOptativas');

// Acuerdo Route
Route::resource('acuerdo','AcuerdoController');
Route::get('api/acuerdo','AcuerdoController@list')->name('api/acuerdo');

// Optativa Route
Route::resource('optativa','OptativaController');
Route::get('api/optativa','OptativaController@list')->name('api/optativa');
Route::get('api/optativas/{materia_id}','OptativaController@getOptativas');

// Estado Route
Route::get('api/estados/{id}','EstadoController@getEstados');

// Municipio Route
Route::get('api/municipios/{id}','MunicipioController@getMunicipios');

// Aula Route
Route::resource('aula','AulaController');
Route::get('api/aula','AulaController@list')->name('api/aula');
Route::get('api/aulas/{ubicacion_id}','AulaController@getAulas')->name('api/aulas');

// Profesion Anteriores
Route::resource('profesion','ProfesionController');
Route::get('api/profesion','ProfesionController@list')->name('api/profesion');

// Abreviatura Anteriores
Route::resource('abreviatura','AbreviaturaController');
Route::get('api/abreviatura','AbreviaturaController@list')->name('api/abreviatura');



// Beca Route
Route::resource('beca','BecaController');
Route::get('api/beca','BecaController@list')->name('api/beca');

// Concepto baja Route
Route::resource('concepto_baja','ConceptoBajaController');
Route::get('api/concepto_baja','ConceptoBajaController@list')->name('api/concepto_baja');

// Concepto baja Route
Route::resource('concepto_titulacion','ConceptoTitulacionController');
Route::get('api/concepto_titulacion','ConceptoTitulacionController@list')->name('api/concepto_titulacion');

// Paises Route
Route::resource('paises','PaisesController');
Route::get('api/paises','PaisesController@list')->name('api/paises');

// Estados Route
Route::resource('estados','EstadoController');
Route::get('api/estados','EstadoController@list')->name('api/estados');

// Municipios Route
Route::resource('municipios','MunicipioController');
Route::get('api/municipios','MunicipioController@list')->name('api/municipios');

// Preparatorias Route
Route::resource('preparatorias','PreparatoriaController');
Route::get('api/preparatorias','PreparatoriaController@list')->name('api/preparatorias');

//Registro - Responsable de registro / certificación.
Route::resource('registro', 'RegistroController');
Route::get('api/registro', 'RegistroController@list')->name('api/registro');

Route::resource('puestos', 'PuestoController');
Route::get('api/puestos', 'PuestoController@list');