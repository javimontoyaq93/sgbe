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
Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home']);
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
Route::get('puestos', ['uses' => 'BolsaEmpleo\PuestoController@index', 'middleware' => 'auth', 'as' => 'puestos']);
Route::get('puesto', ['uses' => 'BolsaEmpleo\PuestoController@crear', 'middleware' => 'auth', 'as' => 'crear-puesto']);
Route::get('puesto/{id}', ['uses' => 'BolsaEmpleo\PuestoController@show', 'middleware' => 'auth', 'as' => 'show-puesto']);
Route::post('guardar-puesto', ['uses' => 'BolsaEmpleo\PuestoController@guardar', 'middleware' => 'auth', 'as' => 'guardar-puesto']);
Route::post('borrar-puesto', array('uses' => 'BolsaEmpleo\PuestoController@borrar', 'middleware' => 'auth', 'as' => 'borrar-puesto'));
Route::get('ofertasEmpleo', ['uses' => 'BolsaEmpleo\OfertaEmpleoController@index', 'as' => 'ofertasEmpleo']);
Route::get('ofertaEmpleo', ['uses' => 'BolsaEmpleo\OfertaEmpleoController@crear', 'as' => 'crear-ofertaEmpleo']);
Route::get('ofertaEmpleo/{id}', ['uses' => 'BolsaEmpleo\OfertaEmpleoController@show', 'as' => 'show-ofertaEmpleo']);
Route::post('guardar-ofertaEmpleo', ['uses' => 'BolsaEmpleo\OfertaEmpleoController@guardar', 'as' => 'guardar-ofertaEmpleo']);
Route::post('borrar-ofertaEmpleo', array('uses' => 'BolsaEmpleo\OfertaEmpleoController@borrar', 'as' => 'borrar-ofertaEmpleo'));
Route::get('crear-vacante\{oferta_empleo_id}', ['uses' => 'BolsaEmpleo\VacanteController@crear', 'as' => 'crear-vacante']);
Route::post('guardar-vacante', ['uses' => 'BolsaEmpleo\VacanteController@guardar', 'as' => 'guardar-vacante']);
Route::get('vacante/{id}', ['uses' => 'BolsaEmpleo\VacanteController@show', 'as' => 'show-vacante']);
Route::get('puesto-por-id/{puesto_id}', ['uses' => 'BolsaEmpleo\PuestoController@puestoPorId', 'as' => 'puesto-por-id']);
