<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    
    public function index(Request $request)
    {   
         if(!$request->ajax()){
        return redirect('/');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){
            $user = User::with('personas','rol')->orderBy('id', 'DESC')->paginate(10);

         }else{ 
            $user = User::with('personas','rol')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
         }
        return [
            'pagination' => [
                'total'         => $user->total(),
                'current_page'  => $user->currentPage(),
                'per_page'      => $user->perPage(),
                'last_page'     => $user->lastPage(),
                'from'          => $user->firstItem(),
                'to'            => $user->lastItem(),
            ],
            'user' => $user
        ];
    }



    public function store(Request $request)
    {
       if(!$request->ajax()){
        return redirect('/');
       }

       try {
        $condicion=1;

            $persona = Persona::create([
            'nombre' => $request->get('nombre'),
            'tipo_documento' => $request->get('tipo_documento'),
            'num_documento' => $request->get('num_documento'),
            'direccion' => $request->get('direccion'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            ]);

            $user = User::create([
            'usuario' => $request->get('usuario'),
            'password' => Hash::make($request->get('password')),
            'condicion' => $condicion,
            'idrol' => $request->get('idrol'),
            'id' => $persona->id,
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

        $users = User::findOrFail($request->id);
        $persona = Persona::findOrFail($users->id);


        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->update();
        

        $users->usuario=$request->get('usuario');
        $users->usuario= Hash::make($request->get('password'));
        $users->condicion='1';
        $users->idrol=$request->get('idrol');
        $users->update();
    

      }catch (ModelNotFoundException $e) {
        DB::rollBack();
      }


    }


      //function para desactivar una user
      public function desactivar(Request $request)
      {
         if(!$request->ajax()){
          return redirect('/');
         }
  
          $user = User::findOrFail($request->id);
          $user->condicion='0';
          $user->update();
      }

  
      
      //function para activar una user
      public function activar(Request $request)
      {
         if(!$request->ajax()){
          return redirect('/');
         }

          $user = User::findOrFail($request->id);
          $user->condicion='1';
          $user->update();
      }


}
