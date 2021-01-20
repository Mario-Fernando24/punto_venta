<?php

namespace App\Http\Controllers;
use App\Credito;
use App\AbonoCredito;
use Illuminate\Http\Request;

class ControllerCredito extends Controller
{
    public function index(Request $request)
    {

     // if(!$request->ajax()){return redirect('/');}

      $buscar = $request->buscar;
      $criterio = $request->criterio;

      $credito = Credito::with('ventaCredito','clienteCredito','detallesVentaCredito','AbonoCredito')->orderBy('idCredito', 'DESC')->paginate(10);

       if($buscar==''){
          $credito = Credito::with('ventaCredito','clienteCredito','detallesVentaCredito','AbonoCredito')->orderBy('idCredito', 'DESC')->paginate(10);
       }else{
          $credito = Credito::with('ventaCredito','clienteCredito','detallesVentaCredito','AbonoCredito')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('idCredito', 'desc')->paginate(10);
       }

      return [
        'pagination' => [
            'total'         => $credito->total(),
            'current_page'  => $credito->currentPage(),
            'per_page'      => $credito->perPage(),
            'last_page'     => $credito->lastPage(),
            'from'          => $credito->firstItem(),
            'to'            => $credito->lastItem(),
        ],
        'credito' => $credito
    ];
    
    } 

}
