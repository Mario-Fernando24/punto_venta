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
    public function update(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    }

       //function para desactivar una categoria
    public function desactivar(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion='0';
        $categoria->update();
    }

    
    //function para activar una categoria
    public function activar(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion='1';
        $categoria->update();
    }

}
