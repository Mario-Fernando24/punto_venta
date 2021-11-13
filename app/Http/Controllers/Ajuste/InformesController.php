<?php

namespace App\Http\Controllers\Ajuste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Venta;
use App\DetalleVenta;
use App\Articulo;
use App\Persona;
use DB;
use Carbon\Carbon;


class InformesController extends Controller
{
    
    


    public function ventaPorFecha(Request $request)
    {

        $start = $request->star;
        $end = $request->endl;
        
      if($start!='' && $end!='' ){

        $InformVentaActiva=Venta::where('estado','registrado')
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)
        ->sum('total');

        $InformVentaAnulada=Venta::where('estado','anulado')
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)
        ->sum('total');

        $arrayVenta=Venta::with('cliente_persona','usuario_hizola_venta','formaspago','DetalleVenta.articulo_Detalle_Venta')->where('estado','registrado')->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=',  $end)
        ->get();
         
     }else{

        $InformVentaActiva=Venta::where('estado','registrado')
        ->sum('total');
        $InformVentaAnulada=Venta::where('estado','anulado')
        ->sum('total');
        $arrayVenta=Venta::with('cliente_persona','usuario_hizola_venta','formaspago','DetalleVenta.articulo_Detalle_Venta')->where('estado','registrado')
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
        $idCliente=$request->idcliente;
        $idProducto=$request->idproducto;
        
        $ventadetalle = Venta::with('cliente_persona','usuario_hizola_venta','formaspago','DetalleVenta.articulo_Detalle_Venta')->where('estado','registrado')->where('id_cliente',$idCliente)->orderBy('id', 'DESC')->paginate(10);
        
        return response()->json([
            'status' => true,
            'ventadetalle' => $ventadetalle,
            'idProducto' => $idProducto
          ], 200);
    }


    public function ListarArticuloVenta(Request $request)
    {
      $articulos = Articulo::with('categoria')->orderBy('nombre', 'asc')->get();
      $clietes   = Persona::orderBy('nombre', 'asc')->get();

      return response()->json([
        'status' => true,
        'articulos' => $articulos,
        'clietes' => $clietes
      ], 200);
    }
}
