<?php

namespace App\Http\Controllers;
use App\Caja;
use DB;
use Carbon\Carbon;


use Illuminate\Http\Request;

class CajaController extends Controller
{


    public function ShowCajaUser()
    {
        $cajaOpen = Caja::with('apertura_vendedor')
        ->where('id_vendedor',\Auth::user()->id)->where('Cajaactual','abierto')->take(1)->get();
       
        return response()->json([
            'status' => 'ok',
            'cajaOpen' => $cajaOpen,
        ], 200);


    }  


    public function aperturaCaja(Request $request)
    {
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


    public function cerrarCaja(Request $request)
    {
       
        if(!$request->ajax()){
        return redirect('/');
       }

        $mytime=Carbon::now('America/Bogota');        
        $cajaUpdate = Caja::findOrFail($request->id);
        $cajaUpdate->Cajaactual='abierto';
        $cajaUpdate->obs_final=$request->get('obs_final');
        $cajaUpdate->dinero_final=json_encode($request->get('dinero_final'));
        $cajaUpdate->updated_at=$mytime;
        $cajaUpdate->update();
    }  





}
