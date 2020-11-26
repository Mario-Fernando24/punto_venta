<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function ShowLoginForm(){
        return view('auth.login'); 
    }

    public function login(Request $request){
      
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
            ]);

           //validar si los datos que recibo por el request son == algun usuario que este registrado en la base de dato y que la condicion sea 1 "este activo"
            if(Auth::attempt(['usuario' => $request->usuario, 'password' => $request->password, 'condicion' => 1])){
                 return redirect()->route('main');
            }

            return back()->with('error','Estas credenciales no coinciden con nuestro registros'); 
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');


    }
}
