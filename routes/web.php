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
Route::get('empleadores', ['uses' => 'BolsaEmpleo\EmpleadorController@index', 'as' => 'empleadores']);
Route::get('empleador', ['uses' => 'BolsaEmpleo\EmpleadorController@crear', 'as' => 'crear-empleador']);
Route::get('empleador/{id}', ['uses' => 'BolsaEmpleo\EmpleadorController@show', 'as' => 'show-empleador']);
Route::post('guardar-empleador', ['uses' => 'BolsaEmpleo\EmpleadorController@guardar', 'as' => 'guardar-empleador']);
Route::post('borrar-empleador', ['uses' => 'BolsaEmpleo\EmpleadorController@borrar', 'as' => 'borrar-empleador']);
