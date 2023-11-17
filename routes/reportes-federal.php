<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE REPORTES FEDERALES
|--------------------------------------------------------------------------
|
*/

//Inscritos y Preinscritos
Route::get('reporte-federal/anexo-8', 'ReportesFederal\Anexo8Controller@reporte');
Route::post('reporte-federal/anexo-8/imprimir', 'ReportesFederal\Anexo8Controller@imprimir');

// acta de examen extraordinario
Route::get('reporte-federal/acta_extraordinario', 'ReportesFederal\ActaExtraordinarioController@reporte');
Route::post('reporte-federal/acta_extraordinario/imprimir', 'ReportesFederal\ActaExtraordinarioController@imprimir');

// Actas de examen Ordinario (Federales).
Route::get('reporte-federal/acta_examen_ordinario_federales', 'ReportesFederal\ActaExamenOrdinarioFederalesController@reporte');
Route::post('reporte-federal/acta_examen_ordinario_federales/imprimir', 'ReportesFederal\ActaExamenOrdinarioFederalesController@imprimir');

// segey - registro de alumnos
Route::get('reporte-federal/segey/registro_alumnos', 'ReportesFederal\Segey\RegistroAlumnosController@reporte');
Route::post('reporte-federal/segey/registro_alumnos/imprimir', 'ReportesFederal\Segey\RegistroAlumnosController@imprimir');