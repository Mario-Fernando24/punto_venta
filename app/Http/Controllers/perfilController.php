<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perfil;
use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;




class perfilController extends Controller
{
    public function index(Request $request)
    {
        $Perfil = Perfil::with('GetUser')->first();

        if(!empty($Perfil)){
        return response()->json(['status' => 'ok','Perfil' => $Perfil, ], 200);
        }else{
        return response()->json(['status' => 'error', 'Perfil' => 'vacio',], 200);
        }
    }
  
    public function updateImage(Request $request)
    {
            try {

                $hora=Carbon::now('America/Bogota');
                $file = $request->file('image'); // guardamos la imagen en la variable file
                $imageName = $hora.$file->getClientOriginalName();
                $request->image->move(public_path('img/company'), $imageName);

                $ImageCompany = Perfil::findOrFail($request->id);
                $ImageCompany->image_perfil = $imageName;
                $ImageCompany->save();
                return response()->json([ 'status' => 'ok',], 200);


             } catch (ModelNotFoundException $exception) {
              return response()->json($exception->getMessage(), 400);
            }

    }

    public function register(Request $request)
    {


        if(!$request->ajax()){
            return redirect('/');
           }

           try {
           $company = Perfil::findOrFail($request->id);
           $company->id_admin = \Auth::user()->id;
           $company->razon_social=$request->get('razon_social');
           $company->telefono = $request->get('telefono');
           $company->direccion = $request->get('direccion');
           $company->impuesto = $request->get('impuesto');
           $company->nit = $request->get('nit');
           $company->correo = $request->get('correo');
           $company->codigo_postal = $request->get('codigo_postal');
           $company->propietario = $request->get('propietario');
           $company->ciudad = $request->get('ciudad');
           $company->save();
           return response()->json([ 'status' => 'ok',], 200);

        } catch (ModelNotFoundException $exception) {
            return response()->json($exception->getMessage(), 400);
        }


           


    }
}

