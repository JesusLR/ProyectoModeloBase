<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE REPORTES
|--------------------------------------------------------------------------
|
*/


use App\Http\Middleware\VerificarNull;
//Inscritos y Preinscritos
Route::get('reporte/inscrito_preinscrito', 'Reportes\InscritoPreinscritoController@reporte');
Route::post('reporte/inscrito_preinscrito/imprimir', 'Reportes\InscritoPreinscritoController@imprimir');

//Historico inscripciones
Route::get('reporte/historico_inscripciones', 'Reportes\HistoricoInscripcionController@reporte');
Route::post('reporte/historico_inscripciones/imprimir', 'Reportes\HistoricoInscripcionController@imprimir');

//Primer Ingreso
Route::get('reporte/primer_ingreso', 'Reportes\PrimerIngresoController@reporte');
Route::post('reporte/primer_ingreso/imprimir', 'Reportes\PrimerIngresoController@imprimir');


//Listas de Asistencia por Grupo
Route::get('reporte/asistencia_grupo', 'Reportes\AsistenciaGrupoController@reporte');
Route::post('reporte/asistencia_grupo/imprimir', 'Reportes\AsistenciaGrupoController@imprimir');

//Constancia de Inscripción
Route::get('reporte/constancia_inscripcion', 'Reportes\ConstanciaInscripcionController@reporte');
Route::post('reporte/constancia_inscripcion/imprimir', 'Reportes\ConstanciaInscripcionController@imprimir');

//Tarjeta de Pago
Route::get('reporte/tarjeta_pago', 'Reportes\TarjetaPagoController@reporte');
Route::post('reporte/tarjeta_pago/imprimir', 'Reportes\TarjetaPagoController@imprimir');

//Grupos por Materia
Route::get('reporte/grupo_materia', 'Reportes\GrupoMateriaController@reporte');
Route::post('reporte/grupo_materia/imprimir', 'Reportes\GrupoMateriaController@imprimir');

//Actas Pendientes
Route::get('reporte/actas_pendientes', 'Reportes\ActasPendientesController@reporte');
Route::post('reporte/actas_pendientes/imprimir', 'Reportes\ActasPendientesController@imprimir');

//Grupos por Semestre
Route::get('reporte/grupo_semestre', 'Reportes\GrupoSemestreController@reporte');
Route::post('reporte/grupo_semestre/imprimir', 'Reportes\GrupoSemestreController@imprimir');

//Alumnos becados
Route::get('reporte/alumnos_becados', 'Reportes\AlumnosBecadosController@reporte');
Route::post('reporte/alumnos_becados/imprimir', 'Reportes\AlumnosBecadosController@imprimir');


//Relacion de planes de estudio
Route::get('reporte/planes_estudio', 'Reportes\PlanesEstudioController@reporte');
Route::post('reporte/planes_estudio/imprimir', 'Reportes\PlanesEstudioController@imprimir');


//Plantilla de profesores
Route::get('reporte/plantilla_profesores', 'Reportes\PlantillaProfesoresController@reporte');
Route::post('reporte/plantilla_profesores/imprimir', 'Reportes\PlantillaProfesoresController@imprimir');


//Resumen grupos por alumno
Route::get('reporte/resumen_grupos_alumno', 'Reportes\ResumenGruposAlumnoController@reporte');
Route::post('reporte/resumen_grupos_alumno/imprimir', 'Reportes\ResumenGruposAlumnoController@imprimir');
Route::get('api/resumen_grupos_alumno/getGrados/{periodo_id}', 'Reportes\ResumenGruposAlumnoController@getGrados')->name('api/resumen_grupos_alumno/getGrados/{periodo_id}');


//Relación Maestros Escuela
Route::get('reporte/relacion_maestros_escuela', 'Reportes\RelacionMaestrosEscuelaController@reporte');
Route::post('reporte/relacion_maestros_escuela/imprimir', 'Reportes\RelacionMaestrosEscuelaController@imprimir');


//Calendario examenes ordinarios
Route::get('reporte/calendario_examenes_ordinarios', 'Reportes\CalendarioExamenesOrdinariosController@reporte');
Route::post('reporte/calendario_examenes_ordinarios/imprimir', 'Reportes\CalendarioExamenesOrdinariosController@imprimir');


//Relacion de alumnos con matriculas
Route::get('reporte/rel_alumnos_matriculas', 'Reportes\RelAlumnosMatriculasController@reporte');
Route::post('reporte/rel_alumnos_matriculas/imprimir', 'Reportes\RelAlumnosMatriculasController@imprimir');


// listas para evaluacion parcial
Route::get('reporte/listas_evaluacion_parcial', 'Reportes\ListasEvaluacionParcialController@reporte');
Route::post('reporte/listas_evaluacion_parcial/imprimir', 'Reportes\ListasEvaluacionParcialController@imprimir');


// listas para evaluacion ordinaria
Route::get('reporte/listas_evaluacion_ordinaria', 'Reportes\ListasEvaluacionOrdinariaController@reporte');
Route::post('reporte/listas_evaluacion_ordinaria/imprimir', 'Reportes\ListasEvaluacionOrdinariaController@imprimir');


// horario personal de maestros
Route::get('reporte/horario_personal_maestros', 'Reportes\HorarioPersonalMaestrosController@reporte');
Route::post('reporte/horario_personal_maestros/imprimir', 'Reportes\HorarioPersonalMaestrosController@imprimir');


// relacion de grupos
Route::get('reporte/relacion_grupos', 'Reportes\RelacionGruposController@reporte');
Route::post('reporte/relacion_grupos/imprimir', 'Reportes\RelacionGruposController@imprimir');


// carga grupos maestro
Route::get('reporte/carga_grupos_maestro', 'Reportes\CargaGruposMaestroController@reporte');
Route::post('reporte/carga_grupos_maestro/imprimir', 'Reportes\CargaGruposMaestroController@imprimir');



// materias adeudadas por alumnos
Route::get('reporte/materias_adeudadas_alumnos', 'Reportes\MateriasAdeudadasAlumnoController@reporte');
Route::post('reporte/materias_adeudadas_alumnos/imprimir', 'Reportes\MateriasAdeudadasAlumnoController@imprimir');


// tarjetas pago alumnos CON STORE PROCEDURE
Route::get('reporte/tarjetas_pago_alumnos', 'Reportes\TarjetasPagoAlumnosSPController@reporte');
Route::post('reporte/tarjetas_pago_alumnos/imprimir', 'Reportes\TarjetasPagoAlumnosSPController@imprimir');
// tarjetas pago alumnos
//Route::get('reporte/tarjetas_pago_alumnos', 'Reportes\TarjetasPagoAlumnosController@reporte');
//Route::post('reporte/tarjetas_pago_alumnos/imprimir', 'Reportes\TarjetasPagoAlumnosController@imprimir');



// tarjetas pago alumnos
//Route::get('reporte/tarjetas_pago_alumnos_test', 'Reportes\TarjetasPagoAlumnosControllerTest@reporte');
//Route::post('reporte/tarjetas_pago_alumnos_test/imprimir', 'Reportes\TarjetasPagoAlumnosControllerTest@imprimir');



// segey - registro de alumnos
Route::get('reporte/segey/registro_alumnos', 'Reportes\Segey\RegistroAlumnosController@reporte');
Route::post('reporte/segey/registro_alumnos/imprimir', 'Reportes\Segey\RegistroAlumnosController@imprimir');


// becas por campus, carrera, escuela
Route::get('reporte/becas_campus_carrera_escuela', 'Reportes\BecasController@reporte');
Route::post('reporte/becas_campus_carrera_escuela/imprimir', 'Reportes\BecasController@imprimir');

// boleta de calificaciones
Route::get('reporte/boleta_calificaciones', 'Reportes\BoletaCalificacionesController@reporte');
Route::post('reporte/boleta_calificaciones/imprimir', 'Reportes\BoletaCalificacionesController@imprimir');

// materias por plan
Route::get('reporte/materias_plan', 'Reportes\MateriasPlanController@reporte');
Route::post('reporte/materias_plan/imprimir', 'Reportes\MateriasPlanController@imprimir');

// historial academico de alumnos
Route::get('reporte/historial_alumno', 'Reportes\HistorialAlumnoController@reporte');
Route::post('reporte/historial_alumno/imprimir', 'Reportes\HistorialAlumnoController@imprimir');
Route::get('historial_alumno/obtenerProgramasClave/{aluClave}', 'Reportes\HistorialAlumnoController@obtenerProgramasClave');
Route::get('historial_alumno/obtenerProgramasMatricula/{aluMatricula}', 'Reportes\HistorialAlumnoController@obtenerProgramasMatricula');

//Relación de Datos personales.
Route::get('reporte/rel_datos_generales','Reportes\DatosGeneralesController@reporte');
Route::post('reporte/rel_datos_generales/imprimir','Reportes\DatosGeneralesController@imprimir');

//Relación de posibles bajas por reprobación.
Route::get('reporte/rel_pos_bajas','Reportes\PosiblesBajasController@reporte');
Route::post('reporte/rel_pos_bajas/imprimir','Reportes\PosiblesBajasController@imprimir');


//Cumpleaños de empleados
Route::get('reporte/cumple_empleados','Reportes\CumpleEmpleadosController@reporte');
Route::post('reporte/cumple_empleados/imprimir','Reportes\CumpleEmpleadosController@imprimir');

//Alumnos Servicio social
Route::get('reporte/servicio_social', 'Reportes\ServicioSocialController@reporte');
Route::post('reporte/servicio_social/imprimir','Reportes\ServicioSocialController@imprimir');

//Aulas por escuela
Route::get('reporte/aulas_escuela', 'Reportes\AulasEscuelaController@reporte');
Route::post('reporte/aulas_escuela/imprimir', 'Reportes\AulasEscuelaController@imprimir');


//Relación de posibles egresados
Route::get('reporte/rel_pos_egresados','Reportes\PosiblesEgresadosController@reporte');
Route::post('reporte/rel_pos_egresados/imprimir','Reportes\PosiblesEgresadosController@imprimir');

// Aulas ocupadas por escuela
Route::get('reporte/aulas_ocupadas_escuela', 'Reportes\AulasOcupadasEscuelaController@reporte');
Route::post('reporte/aulas_ocupadas_escuela/imprimir', 'Reportes\AulasOcupadasEscuelaController@imprimir');

// Relación de alumnos foráneos
Route::get('reporte/alumnos_foraneos', 'Reportes\AlumnosForaneosController@reporte');
Route::post('reporte/alumnos_foraneos/imprimir', 'Reportes\AlumnosForaneosController@imprimir');

// Relacion de optativas del periodo
Route::get('reporte/optativas_periodo', 'Reportes\OptativasPeriodoController@reporte');
Route::post('reporte/optativas_periodo/imprimir', 'Reportes\OptativasPeriodoController@imprimir');

// Relacion de CGTs
Route::get('reporte/relacion_cgt', 'Reportes\RelacionCgtController@reporte');
Route::post('reporte/relacion_cgt/imprimir', 'Reportes\RelacionCgtController@imprimir');

//Relación de Egresados.
Route::get('reporte/rel_egresados','Reportes\RelEgresadosController@reporte');
Route::post('reporte/rel_egresados/imprimir','Reportes\RelEgresadosController@imprimir');

//Resumen de Egresados.
Route::get('reporte/res_egresados','Reportes\ResEgresadosController@reporte');
Route::post('reporte/res_egresados/imprimir','Reportes\ResEgresadosController@imprimir');

//Porcentaje de aprobación
Route::get('reporte/porcentaje_aprobacion', 'Reportes\PorcentajeAprobacionController@reporte');
Route::post('reporte/porcentaje_aprobacion/imprimir', 'Reportes\PorcentajeAprobacionController@imprimir');

//Resumen de calificación por grupo
//Route::get('reporte/calificacion_grupo', 'Reportes\CalificacionGrupoController@reporte');
//Route::post('reporte/calificacion_grupo/imprimir', 'Reportes\CalificacionGrupoController@imprimir');

//Constancia de buena conducta
Route::get('reporte/buena_conducta', 'Reportes\BuenaConductaController@reporte');
Route::post('reporte/buena_conducta/imprimir', 'Reportes\BuenaConductaController@imprimir');

//Relación de Cambios de Carrera (Programa).
Route::get('reporte/rel_cambios_carrera','Reportes\RelCambiosCarreraController@reporte');
Route::post('reporte/rel_cambios_carrera/imprimir','Reportes\RelCambiosCarreraController@imprimir');

//Programación de examenes extraordinarios
Route::get('reporte/programacion_examenes', 'Reportes\ProgramacionExamenesController@reporte');
Route::post('reporte/programacion_examenes/imprimir', 'Reportes\ProgramacionExamenesController@imprimir');

// Resumen de pagos de colegiaturas (alias el economico)
Route::get('reporte/colegiaturas', 'Reportes\ColegiaturasController@reporte');
Route::post('reporte/colegiaturas/imprimir', 'Reportes\ColegiaturasController@imprimir');

// Resumen de mejores promedios
Route::get('reporte/mejores_promedios', 'Reportes\MejoresPromediosController@reporte');
Route::post('reporte/mejores_promedios/imprimir', 'Reportes\MejoresPromediosController@imprimir');

// Relacion de deudores
Route::get('reporte/relacion_deudores', 'Reportes\RelDeudoresController@reporte');
Route::post('reporte/relacion_deudores/imprimir', 'Reportes\RelDeudoresController@imprimir');

// Relacion de deuda individual de un alumno
Route::get('reporte/relacion_deudas', 'Reportes\RelDeudasController@reporte');
Route::post('reporte/relacion_deudas/imprimir', 'Reportes\RelDeudasController@imprimir');

// acta de examen extraordinario
Route::get('reporte/acta_extraordinario', 'Reportes\ActaExtraordinarioController@reporte');
Route::post('reporte/acta_extraordinario/imprimir', 'Reportes\ActaExtraordinarioController@imprimir');


// Relacion de deudores lagunas
Route::get('reporte/relacion_deudores_lagunas', 'Reportes\RelDeudoresLagunasController@reporte');
Route::post('reporte/relacion_deudores_lagunas/imprimir', 'Reportes\RelDeudoresLagunasController@imprimir');

// Relacion de deudores historico
Route::get('reporte/relacion_deudores_historico', 'Reportes\RelDeudoresHistoricoController@reporte');
Route::post('reporte/relacion_deudores_historico/imprimir', 'Reportes\RelDeudoresHistoricoController@imprimir');

//Constancia de Solicitud de Beca.
Route::get('reporte/solicitud_beca','Reportes\SolicitudBecaController@reporte');
Route::post('reporte/solicitud_beca/imprimir','Reportes\SolicitudBecaController@imprimir');
Route::post('reporte/buscar/{ubicacion_id}','Reportes\SolicitudBecaController@getFirmantes')->name('reporte/buscar/{ubicacion_id}');


//Certificado completo
Route::get('reporte/certificado_completo','Reportes\CertificadoCompletoController@reporte');
Route::post('reporte/certificado_completo/imprimir','Reportes\CertificadoCompletoController@imprimir');

//Constancia de calificaciones finales
Route::get('reporte/calificacion_final','Reportes\CalificacionFinalController@reporte');
Route::post('reporte/calificacion_final/imprimir','Reportes\CalificacionFinalController@imprimir');
Route::post('reporte/calificacion_final/cambiarFirmante/{ubicacion_id}','Reportes\CalificacionFinalController@cambiarFirmante')->name('reporte/calificacion_final/cambiarFirmante/{ubicacion_id}');

//Constancia de calificaciones finales (de toda la carrera)
Route::get('reporte/calificacion_carrera','Reportes\CalificacionCarreraController@reporte');
Route::post('reporte/calificacion_carrera/imprimir','Reportes\CalificacionCarreraController@imprimir');
Route::post('reporte/calificacion_carrera/cambiarFirmante/{ubicacion_id}','Reportes\CalificacionCarreraController@cambiarFirmante')->name('reporte/calificacion_carrera/cambiarFirmante/{ubicacion_id}');

//Constancia de calificaciones parciales
Route::get('reporte/calificacion_parcial','Reportes\CalificacionParcialController@reporte');
Route::post('reporte/calificacion_parcial/imprimir','Reportes\CalificacionParcialController@imprimir');
Route::post('reporte/calificacion_parcial/cambiarFirmante/{ubicacion_id}','Reportes\CalificacionParcialController@cambiarFirmante')->name('reporte/calificacion_parcial/cambiarFirmante/{ubicacion_id}');

// Relacion de deudores pagos recibidos o con montos desconocidos
Route::get('reporte/relacion_deudores_pagos_anuales', 'Reportes\RelDeudoresPagosAnualesController@reporte');
Route::post('reporte/relacion_deudores_pagos_anuales/imprimir', 'Reportes\RelDeudoresPagosAnualesController@imprimir');

//Resumen de Titulados.
Route::get('reporte/resumen_titulados','Reportes\ResumenTituladosController@reporte');
Route::post('reporte/resumen_titulados/imprimir','Reportes\ResumenTituladosController@imprimir');

//Resumen calificacion por grupo
Route::get('reporte/resumen_cal_grupos','Reportes\ResumenCalificacionPorGrupo@reporte');
Route::post('reporte/resumen_cal_grupos/imprimir','Reportes\ResumenCalificacionPorGrupo@imprimir');

//Relación de materias faltantes
Route::get('reporte/indice_reprobacion','Reportes\IndiceReprobacionController@reporte');
Route::post('reporte/indice_reprobacion/imprimir','Reportes\IndiceReprobacionController@imprimir')->middleware(VerificarNull::class);

//Relación de titulados y pasantes
Route::get('reporte/titulados_pasantes','Reportes\RelTituladosPasantesController@reporte');
Route::post('reporte/titulados_pasantes/imprimir','Reportes\RelTituladosPasantesController@imprimir');

//Relación de asistentes (oyentes)
Route::get('reporte/alumnos_asistentes','Reportes\RelAlumnosAsistentesController@reporte');
Route::post('reporte/alumnos_asistentes/imprimir','Reportes\RelAlumnosAsistentesController@imprimir');

//Total de egresados y titulados por año escolar
Route::get('reporte/total_egresados_tit','Reportes\TotalEgresadosTituladosController@reporte');
Route::post('reporte/total_egresados_tit/imprimir','Reportes\TotalEgresadosTituladosController@imprimir');

//Resumen de inscritos por sexo
Route::get('reporte/inscritos_sexo','Reportes\ResumenInscritosSexoController@reporte');
Route::post('reporte/inscritos_sexo/imprimir','Reportes\ResumenInscritosSexoController@imprimir');
// Relación posibles hermanos.
Route::get('reporte/posibles_hermanos', 'Reportes\PosiblesHermanosController@reporte');
Route::post('reporte/posibles_hermanos/imprimir', 'Reportes\PosiblesHermanosController@imprimir');

// Relación cumpleaños de alumnos
Route::get('reporte/rel_cumple_alumnos', 'Reportes\RelCumpleAlumnosController@reporte');
Route::post('reporte/rel_cumple_alumnos/imprimir', 'Reportes\RelCumpleAlumnosController@imprimir');

// Número de exámenes ordinarios y extraordinarios
Route::get('reporte/numero_examenes', 'Reportes\NumeroExamenesController@reporte');
Route::post('reporte/numero_examenes/imprimir', 'Reportes\NumeroExamenesController@imprimir');
//Validación de fechas de examen Ordinario.
Route::get('reporte/validar_fechas_ordinarios','Reportes\ValidarFechasOrdinariosController@reporte');
Route::post('reporte/validar_fechas_ordinarios/imprimir','Reportes\ValidarFechasOrdinariosController@imprimir');

//Validación de fechas de examen Ordinario.
Route::get('reporte/rel_grupos_equivalentes','Reportes\RelGruposEquivalentesController@reporte');
Route::post('reporte/rel_grupos_equivalentes/imprimir','Reportes\RelGruposEquivalentesController@imprimir');

//Resumen de antiguedad de preinscritos
Route::get('reporte/res_antiguedad_preinscritos','Reportes\ResAntiguedadPreinscritosController@reporte');
Route::post('reporte/res_antiguedad_preinscritos/imprimir','Reportes\ResAntiguedadPreinscritosController@imprimir');
Route::get('obtenerDepartamento/{id}','Reportes\ResAntiguedadPreinscritosController@obtenerDepartamento');
Route::get('obtenerPeriodos/{id}','Reportes\ResAntiguedadPreinscritosController@obtenerPeriodos');
Route::get('obtenerFechas/{id}','Reportes\ResAntiguedadPreinscritosController@obtenerFechas');

// Relacion de nuevo ingreso validando exani y pago de inscripcion
Route::get('reporte/relacion_nuevo_ingreso_exani', 'Reportes\RelNvoIngresoExaniController@reporte');
Route::post('reporte/relacion_nuevo_ingreso_exani/imprimir', 'Reportes\RelNvoIngresoExaniController@imprimir');

// Resumen de inscritos
Route::get('reporte/resumen_inscritos', 'Reportes\ResumenInscritosController@reporte');
Route::post('reporte/resumen_inscritos/imprimir', 'Reportes\ResumenInscritosController@imprimir');
Route::get('reporte/resumen_inscritos/exportarExcel', 'Reportes\ResumenInscritosController@exportarExcel');

//Obtener datos via ajax
Route::get('obtenerFirmantes/{ubicacion_id}','Procesos\ObtenerDatosController@obtenerFirmantes');

//Obtener datos via ajax a traves de claves
Route::get('datos/obtenerDepartamento/{ubiClave}','Procesos\ObtenerDatosController@obtenerDepartamento');
Route::get('datos/obtenerEscuelas/{ubiClave}/{depClave}','Procesos\ObtenerDatosController@obtenerEscuelas');
Route::get('datos/obtenerProgramas/{ubiClave}/{depClave}/{escClave}','Procesos\ObtenerDatosController@obtenerProgramas');
Route::get('datos/obtenerPlanes/{ubiClave}/{depClave}/{escClave}/{progClave}','Procesos\ObtenerDatosController@obtenerPlanes');
Route::get('datos/obtenerMaterias/{ubiClave}/{depClave}/{escClave}/{progClave}/{planClave}','Procesos\ObtenerDatosController@obtenerMaterias');
Route::get('datos/obtenerPeriodos/{depClave}','Procesos\ObtenerDatosController@obtenerPeriodos');

Route::get('datos/obtenerFechas/{id}','Procesos\ObtenerDatosController@obtenerFechas');


//horario de clases
Route::get('reporte/horario_por_grupo','Reportes\HorarioPorGrupoController@reporte');
Route::post('reporte/horario_por_grupo/imprimir','Reportes\HorarioPorGrupoController@imprimir');


// Actas de examen Ordinario.
Route::get('reporte/acta_examen_ordinario', 'Reportes\ActaExamenOrdinarioController@reporte');
Route::post('reporte/acta_examen_ordinario/imprimir', 'Reportes\ActaExamenOrdinarioController@imprimir');

//resumen de promedios
Route::get('reporte/resumen_promedios','Reportes\ResumenPromediosController@reporte');
Route::post('reporte/resumen_promedios/imprimir','Reportes\ResumenPromediosController@imprimir');
Route::get('resumen_promedios/obtenerProgramas/{ubiClave}','Reportes\ResumenPromediosController@obtenerProgramas');
Route::get('resumen_promedios/obtenerPlanes/{programa_id}','Reportes\ResumenPromediosController@obtenerPlanes');

//acreditaciones (excel)
Route::get('reporte/acreditaciones','Reportes\AcreditacionesController@reporte');
Route::post('reporte/acreditaciones/exportarExcel','Reportes\AcreditacionesController@exportarExcel');

//resumen de alumnos no inscritos
Route::get('reporte/res_alumnos_no_inscritos','Reportes\ResAlumnosNoInscritosController@reporte');
Route::post('reporte/res_alumnos_no_inscritos/imprimir','Reportes\ResAlumnosNoInscritosController@imprimir');

//Obtener datos via ajax a traves de ids
Route::get('datosId/obtenerDepartamento/{ubicacion_id}','Procesos\ObtenerDatosController@obtenerDepartamentoId');
Route::get('datosId/obtenerEscuelas/{departamento_id}','Procesos\ObtenerDatosController@obtenerEscuelasId');
Route::get('datosId/obtenerProgramas/{escuela_id}','Procesos\ObtenerDatosController@obtenerProgramasId');
Route::get('datosId/obtenerPlanes/{programa_id}','Procesos\ObtenerDatosController@obtenerPlanesId');
Route::get('datosId/obtenerMaterias/{plan_id}','Procesos\ObtenerDatosController@obtenerMateriasId');
Route::get('datosId/obtenerPeriodos/{departamento_id}','Procesos\ObtenerDatosController@obtenerPeriodosId');
Route::get('datosId/obtenerCgts/{plan_id}/{periodo_id}','Procesos\ObtenerDatosController@obtenerCgtsId');

//Relación de bajas por periodo.
Route::get('reporte/relacion_bajas_periodo','Reportes\RelacionBajasPeriodoController@reporte');
Route::post('reporte/relacion_bajas_periodo/imprimir', 'Reportes\RelacionBajasPeriodoController@imprimir');

//Relación de alumnos reprobados.
Route::get('reporte/rel_alumnos_reprobados','Reportes\RelAlumnosReprobadosController@reporte');
Route::post('reporte/rel_alumnos_reprobados/imprimir', 'Reportes\RelAlumnosReprobadosController@imprimir');

//Estado de cuenta.
Route::get('reporte/estado_cuenta', 'Reportes\EstadoDeCuentaController@reporte');
Route::post('reporte/estado_cuenta/imprimir','Reportes\EstadoDeCuentaController@imprimir');

//Relación de condicionados.
Route::get('reporte/relacion_condicionados', 'Reportes\RelCondicionadosController@reporte');
Route::post('reporte/relacion_condicionados/imprimir', 'Reportes\RelCondicionadosController@imprimir');

//Relación de pagos capturados por usuario.
Route::get('reporte/rel_pagos_capturados_usuario', 'Reportes\RelPagosCapturadosUsuarioController@reporte');
Route::post('reporte/rel_pagos_capturados_usuario/imprimir', 'Reportes\RelPagosCapturadosUsuarioController@imprimir');

Route::get('reporte/pagos_duplicados', 'Reportes\PagosDuplicadosController@reporte');
Route::post('reporte/pagos_duplicados/imprimir', 'Reportes\PagosDuplicadosController@imprimir');


//Relación de candidatos
Route::get('reporte/relacion_candidatos', 'Reportes\RelacionCandidatosController@reporte');
Route::post('reporte/relacion_candidatos/imprimir', 'Reportes\RelacionCandidatosController@imprimir');

//Mejores Promedios Total.
Route::get('reporte/mejor_promedio_total', 'Reportes\MejorPromedioTotalController@reporte');
Route::post('reporte/mejor_promedio_total/imprimir', 'Reportes\MejorPromedioTotalController@imprimir');

//Listas para Estadísticas.
Route::get('reporte/listas_para_estadisticas', 'Reportes\ListasParaEstadisticasController@reporte');
Route::post('reporte/listas_para_estadisticas/imprimir', 'Reportes\ListasParaEstadisticasController@imprimir');

//Historial de Pagos de Alumno.
Route::get('reporte/historial_pagos_alumno', 'Reportes\HistorialPagosAlumnoController@reporte');
Route::post('reporte/historial_pagos_alumno/imprimir', 'Reportes\HistorialPagosAlumnoController@imprimir');

Route::get('reporte/rel_correos_alumnos_padres', 'Reportes\RelCorreosAlumnosPadresController@reporte');
Route::post('reporte/rel_correos_alumnos_padres/imprimir', 'Reportes\RelCorreosAlumnosPadresController@imprimir');

//Pagos - Errores al aplicar
Route::get('reporte/pagos_errores_al_aplicar', 'Reportes\PagosErroresAlAplicarController@reporte');
Route::post('reporte/pagos_errores_al_aplicar/imprimir', 'Reportes\PagosErroresAlAplicarController@imprimir');

// Deudores Curso Anterior (Alumnos que adeudan curso anterior).
Route::get('reporte/deudores_curso_anterior', 'Reportes\DeudoresCursoAnteriorController@reporte');
Route::post('reporte/deudores_curso_anterior/imprimir', 'Reportes\DeudoresCursoAnteriorController@imprimir');

// Resumen de pronto pago
Route::get('reporte/resumen_pronto_pago', 'Reportes\ResumenProntoPagoController@reporte');
Route::post('reporte/resumen_pronto_pago/imprimir', 'Reportes\ResumenProntoPagoController@imprimir');

// Cambios de plan de pago
Route::get('reporte/cambio_plan_pago', 'Reportes\CambioPlanPagoController@reporte');
Route::post('reporte/cambio_plan_pago/imprimir', 'Reportes\CambioPlanPagoController@imprimir');

/**
* Reportes de Estadísticas del INEGI --------------------------------------------------------------
*/

// Estadísticas Estatales Licenciatura
Route::get('reporte/estadistica_estatal_licenciatura', 'Reportes\EstadisticaLicenciaturaController@reporte');
Route::post('reporte/estadistica_estatal_licenciatura/imprimir', 'Reportes\EstadisticaLicenciaturaController@imprimir');

// Estadísticas Estatales Educacion Continua
Route::get('reporte/estadistica_estatal_educacion_continua', 'Reportes\EstadisticaEducacionContinuaController@reporte');
Route::post('reporte/estadistica_estatal_educacion_continua/imprimir', 'Reportes\EstadisticaEducacionContinuaController@imprimir');

// Estadísticas Estatales de Maestros
Route::get('reporte/estadistica_estatal_maestros', 'Reportes\EstadisticaMaestrosController@reporte');
Route::post('reporte/estadistica_estatal_maestros/imprimir', 'Reportes\EstadisticaMaestrosController@imprimir');

// Recordatorio de pagos
Route::get('reporte/recordatorio_pagos', 'Reportes\RecordatorioPagosController@reporte');
Route::post('reporte/recordatorio_pagos/imprimir', 'Reportes\RecordatorioPagosController@imprimir');
Route::post('reporte/recordatorio_pagos/enviar_correo/{curso_id}', 'Reportes\RecordatorioPagosController@enviar_correo');

// Constancia Docente
Route::get('reporte/constancia_docente', 'Reportes\ConstanciaDocenteController@reporte');
Route::post('reporte/constancia_docente/imprimir', 'Reportes\ConstanciaDocenteController@imprimir');

// Pagos - Resumen de Deudores
Route::get('reporte/resumen_deudores', 'Reportes\ResumenDeudoresController@reporte');
Route::post('reporte/resumen_deudores/imprimir', 'Reportes\ResumenDeudoresController@imprimir');

// Docentes - Conteo Empleados
Route::get('reporte/conteo_empleados', 'Reportes\ConteoEmpleadosController@reporte');
Route::post('reporte/conteo_empleados/imprimir', 'Reportes\ConteoEmpleadosController@imprimir');

// Alumnos - Relacion Inscritos Primero
Route::get('reporte/relacion_inscritos_primero', 'Reportes\RelacionInscritosPrimeroController@reporte');
Route::post('reporte/relacion_inscritos_primero/imprimir', 'Reportes\RelacionInscritosPrimeroController@imprimir');

// Estadísticas - Resumen inscritos y preinscritos
Route::get('reporte/resumen_inscritos_preinscritos', 'Reportes\ResumenInscritosPreinscritosController@reporte');
Route::post('reporte/resumen_inscritos_preinscritos/imprimir', 'Reportes\ResumenInscritosPreinscritosController@imprimir');

// Pagos - Fichas de cobranza.
Route::get('reporte/fichas_de_cobranza', 'Reportes\FichasDeCobranzaController@reporte');
Route::post('reporte/fichas_de_cobranza/imprimir', 'Reportes\FichasDeCobranzaController@imprimir');

// Pagos - Fichas generales.
Route::get('reporte/fichas_generales', 'Reportes\FichasGeneralesController@reporte');
Route::post('reporte/fichas_generales/imprimir', 'Reportes\FichasGeneralesController@imprimir');

// Alumnos - Lista por tipo de ingreso
Route::get('reporte/lista_por_tipo_ingreso', 'Reportes\ListaPorTipoIngresoController@reporte');
Route::post('reporte/lista_por_tipo_ingreso/imprimir', 'Reportes\ListaPorTipoIngresoController@imprimir');

// Estadísticas - Resumen de antigüedad
Route::get('reporte/resumen_antiguedad', 'Reportes\ResumenAntiguedadController@reporte');
Route::post('reporte/resumen_antiguedad/imprimir', 'Reportes\ResumenAntiguedadController@imprimir');

// Alumno - Alumnos de último grado
Route::get('reporte/alumnos_ultimo_grado', 'Reportes\AlumnosUltimoGradoController@reporte');
Route::post('reporte/alumnos_ultimo_grado/imprimir', 'Reportes\AlumnosUltimoGradoController@imprimir');

// Pagos - Cuotas Registradas.
Route::get('reporte/cuotas_registradas', 'Reportes\CuotasRegistradasController@reporte');
Route::post('reporte/cuotas_registradas/imprimir', 'Reportes\CuotasRegistradasController@imprimir');

// Pagos - Becas con Observaciones.
Route::get('reporte/becas_con_observaciones', 'Reportes\BecasConObservacionesController@reporte');
Route::post('reporte/becas_con_observaciones/imprimir', 'Reportes\BecasConObservacionesController@imprimir');

// Pagos - Becas con Observaciones.
Route::get('reporte/listas_pagos_lagunas', 'Reportes\ListaPagoLagunaController@reporte');
Route::post('reporte/listas_pagos_lagunas/imprimir', 'Reportes\ListaPagoLagunaController@imprimir');

// Alumnos - Alumnos Encuestados.
Route::get('reporte/alumnos_encuestados', 'Reportes\AlumnosEncuestadosController@reporte');
Route::post('reporte/alumnos_encuestados/imprimir', 'Reportes\AlumnosEncuestadosController@imprimir');

// Alumnos - Resumen Alumnos Encuestados.
Route::get('reporte/resumen_alumnos_encuestados', 'Reportes\ResumenAlumnosEncuestadosController@reporte');
Route::post('reporte/resumen_alumnos_encuestados/imprimir', 'Reportes\ResumenAlumnosEncuestadosController@imprimir');

// Docentes - Resumen Docentes Encuestados.
Route::get('reporte/resumen_docentes_encuestados', 'Reportes\ResumenDocentesEncuestadosController@reporte');
Route::post('reporte/resumen_docentes_encuestados/imprimir', 'Reportes\ResumenDocentesEncuestadosController@imprimir');

//  Docentes - Docentes Encuestados.
Route::get('reporte/docentes_encuestados', 'Reportes\DocentesEncuestadosController@reporte');
Route::post('reporte/docentes_encuestados/imprimir', 'Reportes\DocentesEncuestadosController@imprimir');

// Alumnos - Deudores Económico Académico.
Route::get('reporte/deudores_economico_academico', 'Reportes\DeudoresEconomicoAcademicoController@reporte');
Route::post('reporte/deudores_economico_academico/imprimir', 'Reportes\DeudoresEconomicoAcademicoController@imprimir');

// Alumnos - Alumnos Regulares Sin Curso.
Route::get('reporte/alumnos_regulares_sin_curso', 'Reportes\AlumnosRegularesSinCursoController@reporte');
Route::post('reporte/alumnos_regulares_sin_curso/imprimir', 'Reportes\AlumnosRegularesSinCursoController@imprimir');

// Extraordinarios - Resumen de Inscritos
Route::get('reporte/resumen_inscritos_extraordinario', 'Reportes\ResumenInscritosExtraordinarioController@reporte');
Route::post('reporte/resumen_inscritos_extraordinario/imprimir', 'Reportes\ResumenInscritosExtraordinarioController@imprimir');

// Extraordinarios - Relación de Inscritos
Route::get('reporte/relacion_inscritos_extraordinario', 'Reportes\RelacionInscritosExtraordinarioController@reporte');
Route::post('reporte/relacion_inscritos_extraordinario/imprimir', 'Reportes\RelacionInscritosExtraordinarioController@imprimir');

// Extraordinarios - Relación de Solicitudes.
Route::get('reporte/relacion_solicitudes_extraordinario', 'Reportes\RelacionSolicitudesExtraordinarioController@reporte');
Route::post('reporte/relacion_solicitudes_extraordinario/imprimir', 'Reportes\RelacionSolicitudesExtraordinarioController@imprimir');

// Cursos - Ocupación de Aulas.
Route::get('reporte/ocupacion_de_aula', 'Reportes\OcupacionDeAulaController@reporte');
Route::post('reporte/ocupacion_de_aula/imprimir', 'Reportes\OcupacionDeAulaController@imprimir');

// Calificaciones - Historicos por Escuela.
Route::get('reporte/historicos_por_escuela', 'Reportes\HistoricosPorEscuelaController@reporte');
Route::post('reporte/historicos_por_escuela/imprimir', 'Reportes\HistoricosPorEscuelaController@imprimir');

// Acreditaciones - Lista de cursos y egresos.
Route::get('reporte/lista_cursos_egresos', 'Reportes\ListaCursoEgresoController@reporte');
Route::post('reporte/lista_cursos_egresos/imprimir', 'Reportes\ListaCursoEgresoController@imprimir');

// Cursos - Carga de Alumnos por Aula.
Route::get('reporte/carga_alumnos_aula', 'Reportes\CargaDeAlumnosPorAulaController@reporte');
Route::post('reporte/carga_alumnos_aula/imprimir', 'Reportes\CargaDeAlumnosPorAulaController@imprimir');

// Pagos - Alumnos sin renovación de beca.
Route::get('reporte/alumnos_sin_renovacion_beca', 'Reportes\AlumnosSinRenovacionDeBecaController@reporte');
Route::post('reporte/alumnos_sin_renovacion_beca/imprimir', 'Reportes\AlumnosSinRenovacionDeBecaController@imprimir');

// Servicio Social - Lista de Servicio Social
Route::get('reporte/lista_servicio_social', 'Reportes\ListaServicioSocialController@reporte');
Route::post('reporte/lista_servicio_social/imprimir', 'Reportes\ListaServicioSocialController@imprimir');

// Alumnos - Reprobados por parciales.
Route::get('reporte/alumnos_reprobados_parciales', 'Reportes\AlumnosReprobadosParcialesController@reporte');
Route::post('reporte/alumnos_reprobados_parciales/imprimir', 'Reportes\AlumnosReprobadosParcialesController@imprimir');

// Docentes - Directorio de Empleados.
Route::get('reporte/directorio_empleados', 'Reportes\DirectorioEmpleadosController@reporte');
Route::post('reporte/directorio_empleados/imprimir', 'Reportes\DirectorioEmpleadosController@imprimir');

// Pagos - Relación de Pagos Completos.
Route::get('reporte/relacion_pagos_completos', 'Reportes\RelacionPagosCompletosController@reporte');
Route::post('reporte/relacion_pagos_completos/imprimir', 'Reportes\RelacionPagosCompletosController@imprimir');

// Pagos - Relación de Pagos Completos.
Route::get('reporte/relacion_pagos_año_completos', 'Reportes\RelacionPagosAñoCompletosController@reporte');
Route::post('reporte/relacion_pagos_año_completos/imprimir', 'Reportes\RelacionPagosAñoCompletosController@imprimir');

// Pagos - Movimientos de Becas.
Route::get('reporte/movimiento_becas', 'Reportes\MovimientoBecasController@reporte');
Route::post('reporte/movimiento_becas/imprimir', 'Reportes\MovimientoBecasController@imprimir');

// Alumnos - Conteo Servicio Social.
Route::get('reporte/conteo_servicio_social', 'Reportes\ConteoServicioSocialController@reporte');
Route::post('reporte/conteo_servicio_social/imprimir', 'Reportes\ConteoServicioSocialController@imprimir');

// Estadísticas - Histórico Matrícula.
Route::get('reporte/historico_matricula', 'Reportes\HistoricoMatriculaController@reporte');
Route::post('reporte/historico_matricula/imprimir', 'Reportes\HistoricoMatriculaController@imprimir');

// Estadísticas - CIBIES Nuevo Ingreso.
Route::get('reporte/cibies_nuevo_ingreso', 'Reportes\CIBIESNuevoIngresoController@reporte');
Route::post('reporte/cibies_nuevo_ingreso/imprimir', 'Reportes\CIBIESNuevoIngresoController@imprimir');

// Estadísticas - CIBIES Reincorporados.
Route::get('reporte/cibies_reincorporados', 'Reportes\CIBIESReincorporadosController@reporte');
Route::post('reporte/cibies_reincorporados/imprimir', 'Reportes\CIBIESReincorporadosController@imprimir');

// Estadísticas - CIBIES Docentes.
Route::get('reporte/cibies_docentes', 'Reportes\CIBIESDocentesController@reporte');
Route::post('reporte/cibies_docentes/imprimir', 'Reportes\CIBIESDocentesController@imprimir');

// Egresados - Resumen egresados (Excel).
Route::get('reporte/resumen_egresados_excel', 'Reportes\ResumenEgresadosExcelController@reporte');
Route::post('reporte/resumen_egresados_excel/imprimir', 'Reportes\ResumenEgresadosExcelController@imprimir');

// Estadísticas - CIBIES Administrativos.
Route::get('reporte/cibies_administrativos', 'Reportes\CIBIESAdministrativosController@reporte');
Route::post('reporte/cibies_administrativos/imprimir', 'Reportes\CIBIESAdministrativosController@imprimir');

// Docentes - Horarios personales excel.
Route::get('reporte/horarios_personales_excel', 'Reportes\HorariosPersonalesExcelController@reporte');
Route::post('reporte/horarios_personales_excel/imprimir', 'Reportes\HorariosPersonalesExcelController@imprimir');

Route::get('reporte/horarios_administrativos', 'Reportes\HorariosAdministrativosController@reporte');
Route::post('reporte/horarios_administrativos/imprimir', 'Reportes\HorariosAdministrativosController@imprimir');


Route::get('reporte/resumen_escuelas', 'Reportes\ResEscuelasController@reporte');
Route::post('reporte/resumen_escuelas/imprimir', 'Reportes\ResEscuelasController@imprimir');

// Cardex Academico
Route::get('reporte/kardex_academico', 'Reportes\KardexAcademicoController@reporte');
Route::post('reporte/kardex_academico/imprimir', 'Reportes\KardexAcademicoController@imprimir');

// reporte CIBIES Sustentantes
Route::get('reporte/cibies_sustentantes', 'Reportes\CIBIESSustentantesController@reporte');
Route::post('reporte/cibies_sustentantes/imprimir', 'Reportes\CIBIESSustentantesController@imprimir');

// reporte CIBIES Datos
Route::get('reporte/cibies_datos', 'Reportes\CIBIESDatosController@reporte');
Route::post('reporte/cibies_datos/imprimir', 'Reportes\CIBIESDatosController@imprimir');
