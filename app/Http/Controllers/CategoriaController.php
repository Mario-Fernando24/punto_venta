<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
//Paginating Query Builder Results
//use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       //if(!$request->ajax()){
        //return redirect('/');
      // }
        $categorias= Categoria::paginate(10);
        return [
            'pagination' => [
                //numero total de registro
                'total'         => $categorias->total(),
                //Obtenga el número de página actual.
                'current_page'  => $categorias->currentPage(),
                //El número de elementos que se mostrarán por página.
                'per_page'      => $categorias->perPage(),
              //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                'last_page'     => $categorias->lastPage(),
                //desde la pagina
                'from'          => $categorias->firstItem(),
                //hasta la pagina
                'to'            => $categorias->lastItem(),
            ],
            'categorias' => $categorias
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }
        $categoria = Categoria::create([
        'nombre' => $request->get('nombre'),
        'descripcion' => $request->get('descripcion'),
        'condicion' => '1',
        ]);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }

        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    }

       //function para desactivar una categoria
    public function desactivar(Request $request)
    {
        //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }

        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion='0';
        $categoria->update();
    }

    
    //function para activar una categoria
    public function activar(Request $request)
    {
        //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }

        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion='1';
        $categoria->update();
    }

}
