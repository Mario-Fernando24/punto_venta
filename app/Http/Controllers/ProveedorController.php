<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Persona;


class ProveedorController extends Controller
{
    
    public function index(Request $request)
    {   
      // if(!$request->ajax()){
      //  return redirect('/');
      //  }

        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){
            $persona = Proveedor::with('persona')->orderBy('id', 'DESC')->paginate(10);
         }else{ 
            $persona = Proveedor::with('persona')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
         }
        return [
            'pagination' => [
                //numero total de registro
                'total'         => $persona->total(),
                //Obtenga el número de página actual.
                'current_page'  => $persona->currentPage(),
                //El número de elementos que se mostrarán por página.
                'per_page'      => $persona->perPage(),
              //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                'last_page'     => $persona->lastPage(),
                //desde la pagina
                'from'          => $persona->firstItem(),
                //hasta la pagina
                'to'            => $persona->lastItem(),
            ],
            'persona' => $persona
        ];
    }

    public function store(Request $request)
    {
       //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }

       try{
         DB::beginTransaction();

            $persona = Persona::create([
            'nombre' => $request->get('nombre'),
            'tipo_documento' => $request->get('tipo_documento'),
            'num_documento' => $request->get('num_documento'),
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            ]);

             $proveedor = Proveedor::create([
            'id' => $persona->id,
            'contacto' => $request->get('contacto'),
            'telefono_contacto' => $request->get('telefono_contacto'),
            ]);

                DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }

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


       try{
        DB::beginTransaction();

        $proveedor = Proveedor::findOrFail($request->id);
        $persona = Persona::findOrFail($proveedor->id);

        
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->save();
        

        $proveedor->contacto = $request->contacto;
        $proveedor->telefono_contacto = $request->telefono_contacto;
        $proveedor->save();
    
        DB::commit();

       } catch (Exception $e) {
           DB::rollBack();
       }


    }

}
