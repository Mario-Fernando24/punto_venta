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

    //controller categories
    Route::prefix('categoria')->group(function() {
        Route::get('index', 'CategoriaController@index');
        Route::post('registrar', 'CategoriaController@store');
        Route::put('actualizar', 'CategoriaController@update');
        Route::put('desactivar', 'CategoriaController@desactivar');
        Route::put('activar', 'CategoriaController@activar');
        Route::get('mostrarCategoriaActivas', 'CategoriaController@mostrarCategoriaActivas');
    });


    //contoller articles
    Route::prefix('articulo')->group(function() {
        Route::get('index', 'ArticuloContoller@index');
        Route::post('registrar', 'ArticuloContoller@store');
        Route::put('actualizar', 'ArticuloContoller@update');
        Route::put('desactivar', 'ArticuloContoller@desactivar');
        Route::put('activar', 'ArticuloContoller@activar');
    });

    //controller client
    Route::prefix('cliente')->group(function() {
        Route::get('index', 'ClienteController@index');
        Route::post('registrar', 'ClienteController@store');
        Route::put('actualizar', 'ClienteController@update');
    });

    //controller proveedor
    Route::prefix('proveedor')->group(function() {
        Route::get('index', 'ProveedorController@index');
        Route::post('registrar', 'ProveedorController@store');
        Route::put('actualizar', 'ProveedorController@update');
        
    });

    //controller rol
    Route::prefix('rol')->group(function() {
        Route::get('showroles', 'ContollerRol@showroles');
        Route::get('select_rol', 'ContollerRol@select_rol');
    });


    //controller users
    Route::prefix('user')->group(function() {
        Route::get('index', 'UserController@index');
        Route::post('registrar', 'UserController@store');
        Route::put('actualizar', 'UserController@update');
        Route::put('desactivar', 'UserController@desactivar');
        Route::put('activar', 'UserController@activar');
    });


    

