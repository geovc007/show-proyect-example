<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors']], function () {
    //Rutas a las que se permitirá acceso
    Route::post('/formulario/pesados', 'FormularioController@pesados'); // Form Pesados
    Route::post('/formulario/repuestos', 'FormularioController@repuestos'); // Form Repuestos
    // Core Routes
    Route::get('/repuestos/ciudades/{estado}', 'API\CoreController@ciudades_repuestos_hyundai');
    Route::get('/ciudades/{estado}/{tipo}/{marca}', 'API\CoreController@ciudades');
    Route::get('/concesionarios/{estado}/{tipo}/{marca}/{ciudad}', 'API\CoreController@concesionarios');
    Route::get('/concesionario_informacion/{tipo}/{empresa}/{almacen}', 'API\CoreController@concesionario_informacion');
    // Cotizador Route
    Route::post('/cotizador/ingresar', 'CotizadorController@create');

    // Route::get('/vin/{vin}', 'API\CoreController@obtener_vin');
    
    // Route::get('/repuestos/modelos/{estado}', 'API\CoreController@modelos_repuestos');
    // Route::post('/posventa/ingresar', 'CotizadorController@posventa');
    // // Rutas Cotizador
    // Route::get('/versiones/{estado}/{modelo}', 'API\CoreController@versiones_cotizador');
    
    // 
    // Route::get('/modelo_colores/{modelo}/{version}', 'API\CoreController@modelo_colores_cotizador');
    
    
    // // Rutas Cotizador Empresa
    // Route::get('/ciudades_empresa/{estado}/{tipos}/{empresa}', 'API\CoreController@ciudades_cotizador_empresa');
    // Route::get('/concesionarios_empresa/{estado}/{tipos}/{ciudad}/{empresa}', 'API\CoreController@concesionarios_cotizador_empresa');
});
