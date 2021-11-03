<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use App\DetalleVenta;
use App\Articulo;
use App\Persona;
use App\Caja;
use App\User;
use App\Credito;
use App\Perfil;
use App\ModelInventario\AjusteVenta;
use DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;


class ControllerBodega extends Controller
{
    public function index(Request $request)
    {   

        //if(!$request->ajax()){return redirect('/');}
        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){
            $venta = Venta::with('cliente_persona','usuario_hizola_venta','formaspago')->where('caba','si')->orderBy('id', 'DESC')->paginate(10);

         }else{ 
            $venta = Venta::with('cliente_persona','usuario_hizola_venta','formaspago')->where('caba','si')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
         }

        return [
            'pagination' => [
                'total'         => $venta->total(),
                'current_page'  => $venta->currentPage(),
                'per_page'      => $venta->perPage(),
                'last_page'     => $venta->lastPage(),
                'from'          => $venta->firstItem(),
                'to'            => $venta->lastItem(),
            ],
            'venta' => $venta
        ];
    }


    public function devolucioncaba(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}
           $mytime=Carbon::now('America/Bogota');
            $venta = Venta::findOrFail($request->get('id'));
            $venta->caba='no';
            $venta->fechaentregacaba=$mytime;
            $venta->update();
      }
}
