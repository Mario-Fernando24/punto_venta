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
  Route::get('/', 'Auth\LoginController@ShowLoginForm');


    //en este middleware entran los usuario invitado
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/', 'Auth\LoginController@ShowLoginForm');
        Route::post('login', 'Auth\LoginController@login');
         
    });

    //middleware para los usuario autenticados
   Route::group(['middleware' => ['auth']], function () {

    Route::post('logout', 'Auth\LoginController@logout')->name('logout'); 

        //middleware para los usuario rol almacenero
        Route::group(['middleware' => ['Almacenero']], function () {
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

                //controller proveedor
                Route::prefix('proveedor')->group(function() {
                Route::get('index', 'ProveedorController@index');
                Route::get('SelectProveedor', 'ProveedorController@SelectProveedor');
                Route::post('registrar', 'ProveedorController@store');
                Route::put('actualizar', 'ProveedorController@update');    
                });


                //controller ingresos
                Route::prefix('ingresos')->group(function() {
                Route::get('index', 'IngresoController@index');
                Route::post('registrar', 'IngresoController@store');
                Route::put('desactivar', 'IngresoController@desactivar');
                });

          });//and middleware almacenero



        //middleware para los usuario rol almacenero
        Route::group(['middleware' => ['Vendedor']], function () {
                
               //controller client
                Route::prefix('cliente')->group(function() {
                Route::get('index', 'ClienteController@index');
                Route::post('registrar', 'ClienteController@store');
                Route::put('actualizar', 'ClienteController@update');
                });

        });     //and middleware Vendedor



     Route::group(['middleware' => ['Administrador']], function () {

        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');

        //contoller articles
        Route::prefix('articulo')->group(function() {
            Route::get('index', 'ArticuloContoller@index');
            Route::get('buscarArticuloBarra', 'ArticuloContoller@buscarArticuloBarra');
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
            Route::get('selectProveedor', 'ProveedorController@selectProveedor');
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



        //controller ingresos
        Route::prefix('ingresos')->group(function() {
            Route::get('index', 'IngresoController@index');
            Route::get('ListarArticuloIngreso', 'IngresoController@ListarArticuloIngreso');
            Route::get('getObjetoDetalleIngreso', 'IngresoController@getObjetoDetalleIngreso');
            Route::get('getArrayDetalleIngreso', 'IngresoController@getArrayDetalleIngreso');
            Route::post('registrar', 'IngresoController@store');
            Route::put('anularIngreso', 'IngresoController@anularIngreso');
        });
        
         //controller ingresos
         Route::prefix('ventas')->group(function() {
            Route::get('index', 'VentaController@index');
            Route::get('getObjetoDetalleVenta', 'VentaController@getObjetoDetalleVenta');
            Route::get('getArrayDetalleVenta', 'VentaController@getArrayDetalleVenta');
            Route::get('ListarArticuloVenta', 'VentaController@ListarArticuloVenta');
            Route::get('selectCliente', 'VentaController@selectCliente');

            
        });

             
    });  //and middleware administrador


  });
    //and middleware auth








    

