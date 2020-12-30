<?php

namespace App\Http\Controllers;
use App\Caja;
use DB;
use Carbon\Carbon;


use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function aperturaCaja(Request $request)
    {

       //validar seguridad por HTTP si la peticion que se envia es diferente a una peticion ajax
       if(!$request->ajax()){
        return redirect('/');
       }


       $mytime=Carbon::now('America/Bogota');
        
       //return $request->get('dinero_inicial');
        $caja = Caja::create([
        'id_vendedor' => \Auth::user()->id,
        'Cajainicial' => $request->get('Cajainicial'),
        'Fecha' => $mytime,
        'Cajaactual' => 'abierto',
        'obs_apertura' => $request->get('obs_apertura'),
        'obs_final' => 'no cerrado',
        'dinero_inicial' => json_encode($request->get('dinero_inicial')),
        'dinero_final' => '0',
        ]);
    }  

}
