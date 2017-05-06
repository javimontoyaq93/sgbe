<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', ['uses' => 'Seguridad\LoginController@index', 'as' => 'login']);
Route::post('autenticar', ['uses' => 'Seguridad\LoginController@autenticar', 'as' => 'autenticar']);
Route::post('logout', ['uses' => 'Seguridad\LoginController@logout', 'as' => 'logout']);
Route::get('empleadores', ['uses' => 'BolsaEmpleo\EmpleadorController@index', 'middleware' => 'auth', 'as' => 'empleadores']);
Route::get('empleador', ['uses' => 'BolsaEmpleo\EmpleadorController@crear', 'middleware' => 'auth', 'as' => 'crear-empleador']);
Route::get('empleador/{id}', ['uses' => 'BolsaEmpleo\EmpleadorController@show', 'middleware' => 'auth', 'as' => 'show-empleador']);
Route::post('guardar-empleador', ['uses' => 'BolsaEmpleo\EmpleadorController@guardar', 'middleware' => 'auth', 'as' => 'guardar-empleador']);
Route::post('borrar-empleador', array('uses' => 'BolsaEmpleo\EmpleadorController@borrar', 'middleware' => 'auth', 'as' => 'borrar-empleador'));
Route::post('confirmar-borrado-empleador', ['uses' => 'BolsaEmpleo\EmpleadorController@confirmarBorrado', 'as' => 'confirmar-borrado-empleador']);
Route::get('crear-direccion-empleador\{empleador_id}', ['uses' => 'BolsaEmpleo\DireccionEmpleadorController@crear', 'middleware' => 'auth', 'as' => 'crear-direccion-empleador']);
Route::post('guardar-direccion', ['uses' => 'BolsaEmpleo\DireccionEmpleadorController@guardar', 'middleware' => 'auth', 'as' => 'guardar-direccion-empleador']);
Route::get('direccion-empleador/{id}', ['uses' => 'BolsaEmpleo\DireccionEmpleadorController@show', 'middleware' => 'auth', 'as' => 'show-direccion-empleador']);
Route::get('provincias/{pais_id}', ['uses' => 'Core\DireccionController@provincias', 'middleware' => 'auth', 'as' => 'provincias']);
Route::get('ciudades/{pais_id}', ['uses' => 'Core\DireccionController@ciudades', 'middleware' => 'auth', 'as' => 'ciudades']);
Route::get('sendbasicemail', 'Core\MailController@basic_email');
