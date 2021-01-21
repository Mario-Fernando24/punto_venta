<?php

namespace App\Http\Controllers;
use App\Caja;
use App\Venta;
use App\Egreso;
use App\DetalleVenta;
use App\AbonoCredito;
use DB;
use Carbon\Carbon;


use Illuminate\Http\Request;

class CajaController extends Controller
{


    public function ShowCajaUser()
    {
        $cajaOpen = Caja::with('apertura_vendedor')
        ->where('id_vendedor',\Auth::user()->id)->orderBy('idcaja', 'desc')->first();


        $Efectivo_de_Ventas = Venta::where('id_usuario', \Auth::user()->id)
        ->where('id_apertura_caja_usuario', $cajaOpen->idcaja)
        ->where('estado','registrado')
        ->where('forma_pago','efectivo')
        ->get()->sum('total');


        $transferencia_ventas = Venta::where('id_usuario', \Auth::user()->id)
        ->where('id_apertura_caja_usuario', $cajaOpen->idcaja)
        ->where('estado','registrado')
        ->where('forma_pago','transferencia')
        ->get()->sum('total');


        $datafono_Ventas = Venta::where('id_usuario', \Auth::user()->id)
        ->where('id_apertura_caja_usuario', $cajaOpen->idcaja)
        ->where('estado','registrado')
        ->where('forma_pago','datafono')
        ->get()->sum('total');


        $Credito = Venta::where('id_usuario', \Auth::user()->id)
        ->where('id_apertura_caja_usuario', $cajaOpen->idcaja)
        ->where('estado','registrado')
        ->where('forma_pago','credito')
        ->get()->sum('total');



        $Egreso = Egreso::where('id_users', \Auth::user()->id)
        ->where('id_caja', $cajaOpen->idcaja)
        ->where('estado',1)
        ->get()->sum('valor_egreso');

        $IngresoAbonoCredito = AbonoCredito::where('idusers', \Auth::user()->id)
        ->where('id_caja', $cajaOpen->idcaja)
        ->get()->sum('montoAbonar');


        if(!empty($cajaOpen)){
       
        return response()->json([
            'status' => 'ok',
            'cajaOpen' => $cajaOpen,
            'Efectivo_de_Ventas'=>$Efectivo_de_Ventas,
            'transferencia_ventas'=>$transferencia_ventas,
            'datafono_Ventas'=>$datafono_Ventas,
            'Egreso'=>$Egreso,
            'Credito'=>$Credito,
            'IngresoAbonoCredito'=>$IngresoAbonoCredito,
        ], 200);
        }else{

        return response()->json([
            'status' => 'primera apertura caja',
            'cajaOpen' => 'new',
            'Efectivo_de_Ventas'=>'0',
            'transferencia_ventas'=>'0',
            'datafono_Ventas'=>'0',
            'Egreso'=>'0',
            'Credito'=>'0',
            'IngresoAbonoCredito'=>'0',
        ], 404);

        }

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
        $cajaUpdate->Cajaactual='cerrado';
        $cajaUpdate->obs_final=$request->get('obs_final');
        $cajaUpdate->dinero_final=json_encode($request->get('dinero_final'));
        $cajaUpdate->updated_at=$mytime;
        $cajaUpdate->update();
    }  





}
