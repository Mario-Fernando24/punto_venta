<?php

namespace App\Http\Controllers\Ajuste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Venta;
use App\DetalleVenta;
use DB;
use Carbon\Carbon;

class InformesController extends Controller
{
    
    public function showInformeVentas(Request $request)
    {


        $start = $request->start;
        $end = $request->end;
        
      if($start=='' || $end=='' ){

        $InformVentaActiva=Venta::where('estado','registrado')->sum('total');
        $InformVentaAnulada=Venta::where('estado','anulado')->sum('total');
        $arrayVenta=Venta::get();

      }else{

        $InformVentaActiva=Venta::where('estado','registrado')
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)
        ->sum('total');
        $InformVentaAnulada=Venta::where('estado','anulado')
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)
        ->sum('total');
        $arrayVenta=Venta::whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)->get();
      }

      return response()->json([
        'status' => true,
        'InformVentaActiva' => $InformVentaActiva,
        'InformVentaAnulada' => $InformVentaAnulada,
        'arrayVenta' => $arrayVenta

      ], 200);
     
    }


    public function ventaPorCliente(Request $request)
    {
        $idCliente = $request->idCliente;
        $start = $request->start;
        $end = $request->end;
        
      if($start=='' || $end=='' ){
        
        $InformVentaActiva=Venta::where('estado','registrado')
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)
        ->where('id_cliente',$idCliente)
        ->sum('total');

        $InformVentaAnulada=Venta::where('estado','anulado')
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)
        ->where('id_cliente',$idCliente)
        ->sum('total');

        $arrayVenta=Venta::whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)
        ->where('id_cliente',$idCliente)
        ->get();
         
     }else{


        $InformVentaActiva=Venta::where('estado','registrado')
        ->where('id_cliente',2)
        ->sum('total');
        $InformVentaAnulada=Venta::where('estado','anulado')
        ->where('id_cliente',2)
        ->sum('total');
        $arrayVenta=Venta::where('id_cliente',2)
        ->get();
        }


      return response()->json([
        'status' => true,
        'InformVentaActiva' => $InformVentaActiva,
        'InformVentaAnulada' => $InformVentaAnulada,
        'arrayVenta' => $arrayVenta

      ], 200);

    }



    public function ventasPorProducto(Request $request)
    {
      $idCliente=2;
      $idProducto=2;

        $ventadetalle = Venta::with('cliente_persona','usuario_hizola_venta','formaspago','DetalleVenta')->where('estado','registrado')->where('id_cliente',$idCliente)->orderBy('id', 'DESC')->paginate(10);
        
        return response()->json([
            'status' => true,
            'ventadetalle' => $ventadetalle,
            'idProducto' => $idProducto
          ], 200);
    }
}
