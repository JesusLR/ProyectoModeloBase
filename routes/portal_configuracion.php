<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRACIÓN
|--------------------------------------------------------------------------
|
*/

// portal configuracion Route
Route::resource('portal-configuracion','PortalConfiguracionController');
Route::get('api/portal-configuracion','PortalConfiguracionController@list')->name('api/portal-configuracion');
Route::get('api/portal-configuracion/toggleactive/{id}/','PortalConfiguracionController@toggleActive');
