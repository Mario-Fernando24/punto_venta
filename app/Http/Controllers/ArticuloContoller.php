<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Categoria;


class ArticuloContoller extends Controller
{
    
    public function index(Request $request)
    {   
        
        if(!$request->ajax()){
           return redirect('/');
           }
        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){

          $articulos = Articulo::with('categoria')->orderBy('id', 'desc')->paginate(10);

         }else{

            $articulos = Articulo::with('categoria')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
         }
        return [
            'pagination' => [
                //numero total de registro
                'total'         => $articulos->total(),
                //Obtenga el número de página actual.
                'current_page'  => $articulos->currentPage(),
                //El número de elementos que se mostrarán por página.
                'per_page'      => $articulos->perPage(),
              //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                'last_page'     => $articulos->lastPage(),
                //desde la pagina
                'from'          => $articulos->firstItem(),
                //hasta la pagina
                'to'            => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

    


    public function store(Request $request)
    {
       //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }
        $articulo = Articulo::create([
        'idcategoria' => $request->get('idcategoria'),
        'codigo' => $request->get('codigo'),
        'nombre' =>  $request->get('nombre'),
        'precio_venta' => $request->get('precio_venta'),
        'stock' => $request->get('stock'),
        'descripcion' => $request->get('descripcion'),
        'condicion' => '1',

        ]);

    }


    public function update(Request $request)
    {
        //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }

        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }

       //function para desactivar una categoria
    public function desactivar(Request $request)
    {
        //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion='0';
        $articulo->update();
    }

    
    //function para activar una categoria
    public function activar(Request $request)
    {
        //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion='1';
        $articulo->update();
    }


}
