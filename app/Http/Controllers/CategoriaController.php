<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //listamos todas las categoria
        $category= Categoria::all();
        return $category;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->condicion='1';
        $categoria->update();

    }

       //function para desactivar una categoria
    public function desactivar(Request $request)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->condicion='0';
        $categoria->update();
    }

    
    //function para activar una categoria
    public function activar(Request $request)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->condicion='1';
        $categoria->update();
    }

}
