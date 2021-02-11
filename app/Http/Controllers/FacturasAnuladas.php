<?php

namespace App\Http\Controllers;
use App\Venta;
use App\Ingreso;

use Illuminate\Http\Request;

class FacturasAnuladas extends Controller
{
    public function VentasAnuladas(Request $request){
        
       // if(!$request->ajax()){return redirect('/'); }
            $buscar = $request->buscar;
            $criterio = $request->criterio;

            if($buscar==''){
                $ventaAnuladas = Venta::with('cliente_persona','usuario_hizola_venta','usuario_anulo_venta')->where('estado','anulado')->orderBy('id', 'DESC')->paginate(100);
    
             }else{ 
                $ventaAnuladas = Venta::with('cliente_persona','usuario_hizola_venta','usuario_anulo_venta')->where('estado','anulado')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(100);
             }
            return [
                'pagination' => [
                    //numero total de registro
                    'total'         => $ventaAnuladas->total(),
                    //Obtenga el número de página actual.
                    'current_page'  => $ventaAnuladas->currentPage(),
                    //El número de elementos que se mostrarán por página.
                    'per_page'      => $ventaAnuladas->perPage(),
                  //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                    'last_page'     => $ventaAnuladas->lastPage(),
                    //desde la pagina
                    'from'          => $ventaAnuladas->firstItem(),
                    //hasta la pagina
                    'to'            => $ventaAnuladas->lastItem(),
                ],
                'ventaAnuladas' => $ventaAnuladas
            ];
    }

    public function ComprasAnuladas(Request $request)
    {
        
        // if(!$request->ajax()){return redirect('/'); }
             $buscar = $request->buscar;
             $criterio = $request->criterio;
 
             if($buscar==''){
                $ingresoAnulados = Ingreso::with('usuario','proveedor','proveedoress','persona')->where('estado','anulado')->orderBy('id', 'DESC')->paginate(200);
    
             }else{ 
                $ingresoAnulados = Ingreso::with('usuario','proveedor','proveedoress','persona')->where('estado','anulado')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(200);
             }
             return [
                 'pagination' => [
                     //numero total de registro
                     'total'         => $ingresoAnulados->total(),
                     //Obtenga el número de página actual.
                     'current_page'  => $ingresoAnulados->currentPage(),
                     //El número de elementos que se mostrarán por página.
                     'per_page'      => $ingresoAnulados->perPage(),
                   //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                     'last_page'     => $ingresoAnulados->lastPage(),
                     //desde la pagina
                     'from'          => $ingresoAnulados->firstItem(),
                     //hasta la pagina
                     'to'            => $ingresoAnulados->lastItem(),
                 ],
                 'ingresoAnulados' => $ingresoAnulados
             ];
     }
}
