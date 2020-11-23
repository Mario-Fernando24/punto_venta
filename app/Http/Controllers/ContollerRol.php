<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Roles;

class ContollerRol extends Controller
{
    public function showroles(Request $request){

        //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
        if(!$request->ajax()){
            return redirect('/');
            }
    
            $buscar = $request->buscar;
            $criterio = $request->criterio;
    
             if($buscar==''){
                $roles = Roles::orderBy('id', 'DESC')->paginate(10);
             }else{
                $roles = Roles::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
             }
            return [
                'pagination' => [
                    //numero total de registro
                    'total'         => $roles->total(),
                    //Obtenga el número de página actual.
                    'current_page'  => $roles->currentPage(),
                    //El número de elementos que se mostrarán por página.
                    'per_page'      => $roles->perPage(),
                  //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                    'last_page'     => $roles->lastPage(),
                    //desde la pagina
                    'from'          => $roles->firstItem(),
                    //hasta la pagina
                    'to'            => $roles->lastItem(),
                ],
                'roles' => $roles
            ];
    }

    //select rol
    public function select_rol(){
        
        $roles=Roles::where('condicion','1')->orderBy('nombre','asc')->get();

        return ['roles'=>$roles];
        
    }


}
