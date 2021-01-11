<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EgresoController extends Controller
{
    public function registerDocumentoCaja(Request $request)
    {
        
    //   if(!$request->ajax()){
    //    return redirect('/');
     //  }
       $mytime=Carbon::now('America/Bogota');
        
        $caja = Egreso::create([
        'id_caja' => $request->get('id_caja'),
        'id_users' => $request->get('id_users'),
        'tipo_egreso' => $request->get('tipo_egreso'),
        'valor_egreso' => $request->get('valor_egreso'),
        'motivo_egreso' => $request->get('motivo_egreso'),
        
        ]);
    }
}
