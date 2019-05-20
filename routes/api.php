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


Route::group(['middleware' => ['cors']], function() {

    Route::post('/sistema/token', [
      'uses'      => 'Api\TokenApiController@index'
      ,'as'       => 'sistema.token'
    ]);
    Route::put('/sistema/token', [
      'uses'      => 'Api\TokenApiController@index'
      ,'as'       => 'sistema.token'
    ]);

    Route::get('sistema/clientes{?}','Api\ClientesApiController@index');
    Route::get('sistema/clientes','Api\ClientesApiController@index');
    Route::post('sistema/clientes','Api\ClientesApiController@index');
    Route::put('sistema/clientes','Api\ClientesApiController@index');
    Route::delete('sistema/clientes','Api\ClientesApiController@index');

    Route::get('sistema/notification{?}','Api\NotificationApiController@index');
    Route::get('sistema/notification','Api\NotificationApiController@index');
    Route::post('sistema/notification','Api\NotificationApiController@index');
    Route::put('sistema/notification','Api\NotificationApiController@index');
    Route::delete('sistema/notification','Api\NotificationApiController@index');

    Route::post('login/user','Auth\AuthController@authLogin');
    Route::get('products','Administracion\Configuracion\ProductosController@all');


});
