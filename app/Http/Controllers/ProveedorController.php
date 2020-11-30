<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Persona;
use DB;
use Carbon\Carbon;


class ProveedorController extends Controller
{
    
    public function index(Request $request)
    {   
         if(!$request->ajax()){
        return redirect('/');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){
            $proveedor = Proveedor::with('persona')->orderBy('id', 'DESC')->paginate(10);
         }else{ 
            $proveedor = Proveedor::with('persona')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
         }
        return [
            'pagination' => [
                //numero total de registro
                'total'         => $proveedor->total(),
                //Obtenga el número de página actual.
                'current_page'  => $proveedor->currentPage(),
                //El número de elementos que se mostrarán por página.
                'per_page'      => $proveedor->perPage(),
              //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                'last_page'     => $proveedor->lastPage(),
                //desde la pagina
                'from'          => $proveedor->firstItem(),
                //hasta la pagina
                'to'            => $proveedor->lastItem(),
            ],
            'proveedor' => $proveedor
        ];
    }

    //seleccionar proveedor desde la vista ingreso para hacer una compra
    public function SelectProveedor(Request $request){

   //   if(!$request->ajax()){
     //   return redirect('/');
      //  }
      

        $filtro=$request->get('filtro');
        $proveedores=DB::table('proveedores as prov')
        ->join('persona as persona','persona.id','=','prov.id') 
        ->where('persona.nombre', 'like', '%'.$filtro.'%')
        ->orwhere('persona.num_documento', 'like', '%'.$filtro.'%')
        ->select('persona.id','persona.nombre','persona.num_documento')
        ->orderBy('persona.nombre', 'asc')
        ->get();
  // return $proveedores;

        
  return ['proveedores' => $proveedores];

    }

    public function store(Request $request)
    {
       //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }

       try {
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

      } catch (ModelNotFoundException $e) {
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
       if(!$request->ajax()){
        return redirect('/');
       }
       try{

        $proveedor = Proveedor::findOrFail($request->id);
        $persona = Persona::findOrFail($proveedor->id);


        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->update();
        

        $proveedor->contacto = $request->contacto;
        $proveedor->telefono_contacto = $request->telefono_contacto;
        $proveedor->update();
    

      }catch (ModelNotFoundException $e) {
        DB::rollBack();
      }


    }

}
