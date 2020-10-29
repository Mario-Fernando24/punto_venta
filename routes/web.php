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

Route::get('/', function () {
    return view('contenido/contenido');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//controlador categoria
Route::prefix('categoria')->group(function() {
    Route::get('index', 'CategoriaController@index');
    Route::post('registrar', 'CategoriaController@store');
    Route::put('actualizar', 'CategoriaController@update');
    Route::put('desactivar', 'CategoriaController@desactivar');
    Route::put('activar', 'CategoriaController@activar');
});

