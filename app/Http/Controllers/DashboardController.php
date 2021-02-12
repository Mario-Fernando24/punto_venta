<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingreso;
use App\DetalleIngreso;
use App\Venta;
use App\DetalleVenta;
use App\Articulo;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //function invoke
    public function __invoke(Request $request)
    {
        $anio=date('Y');
        $ingresos=DB::table('ingresos as i')
        ->select(DB::raw('MONTH(i.fecha_hora) as mes'),
        DB::raw('YEAR(i.fecha_hora) as anio'),
        DB::raw('SUM(i.total) as total'))
        ->where('i.estado','registrado')
        ->whereYear('i.fecha_hora',$anio)
        ->groupBy(DB::raw('MONTH(i.fecha_hora)'),DB::raw('YEAR(i.fecha_hora)'))
        ->get();


        $ventas=DB::table('ventas as v')
        ->select(DB::raw('MONTH(v.fecha_hora) as mes'),
        DB::raw('YEAR(v.fecha_hora) as anio'),
        DB::raw('SUM(v.total) as total'))
        ->where('v.estado','registrado')
        ->whereYear('v.fecha_hora',$anio)
        ->groupBy(DB::raw('MONTH(v.fecha_hora)'),DB::raw('YEAR(v.fecha_hora)'))
        ->get();


       
      $TotalProductosVendidos = DB::table('detalle_ventas as d')
       ->join('articulos as art','art.id','=','d.id_articulo')
       ->join('ventas as v','v.id','=','d.id_venta')
      ->select(DB::raw('sum(d.precio) as Dinero'),'d.id_articulo','art.nombre')
      ->where('v.estado','registrado')
      ->groupBy('d.id_articulo')
      ->orderBy('Dinero', 'desc')
      ->take(5)
      ->get();


      $totallPorProductos = DB::table('detalle_ventas as d')
       ->join('articulos as art','art.id','=','d.id_articulo')
       ->join('ventas as v','v.id','=','d.id_venta')
      ->select(DB::raw('sum(d.cantidad) as total'),'d.id_articulo','art.nombre')
      ->where('v.estado','registrado')
      ->groupBy('d.id_articulo')
      ->orderBy('total', 'desc')
      ->take(5)
      ->get();


        return ['ingresos'=>$ingresos,'ventas'=>$ventas,'anio'=>$anio,'TotalProductosVendidos'=>$TotalProductosVendidos,'totallPorProductos'=>$totallPorProductos];      
 
    }

}
