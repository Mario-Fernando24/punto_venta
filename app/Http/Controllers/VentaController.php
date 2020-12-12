<?php

namespace App\Http\Controllers;

use App\Venta;
use App\DetalleVenta;
use App\Articulo;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {   
       //  if(!$request->ajax()){return redirect('/');}

        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){
            $venta = Venta::with('cliente_persona','usuario_hizola_venta')->orderBy('id', 'DESC')->paginate(10);

         }else{ 
            $venta = Venta::with('cliente_persona','usuario_hizola_venta')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
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

    public function getObjetoDetalleVenta(Request $request)
    {
      
      if(!$request->ajax()){return redirect('/'); }

        $id = $request->id;
        $ObjetoDetalleVenta = Venta::with('cliente_persona','usuario_hizola_venta')
        ->where('id',$id)->orderBy('id', 'DESC')->take(1)->get();


        return ['ObjetoDetalleVenta' => $ObjetoDetalleVenta];
  
    }
    
    
    public function getArrayDetalleVenta(Request $request)
    {

       if(!$request->ajax()){return redirect('/'); }

        $id = $request->id;
        $ArrayDetalleVenta = DetalleVenta::with('articulo_Detalle_Venta')
        ->where('id_venta',$id)->orderBy('id', 'ASC')->get();

        return ['ArrayDetalleVenta' => $ArrayDetalleVenta];  
      
      }


    
    
      public function ListarArticuloVenta(Request $request)
      {
        
        if(!$request->ajax()){ return redirect('/');}

        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){
          $listarticulos = Articulo::with('categoria')->orderBy('id', 'desc')->paginate(10);
         }else{
          $listarticulos = Articulo::with('categoria')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
         }

        return ['listarticulos' => $listarticulos];
      }



    public function store(Request $request)
    {
       if(!$request->ajax()){
        return redirect('/');
       }
       $mytime=Carbon::now('America/Bogota');

       try{

          $venta = Venta::create([
            'id_cliente' => $request->get('id_cliente'),
            'id_usuario' => \Auth::user()->id,
            'tipo_comprobante' => $request->get('tipo_comprobante'),
            'forma_pago' => $request->get('forma_pago'),
            'num_comprobante_pago' => $request->get('num_comprobante_pago'),
            'fecha_hora' => $mytime->toDateString(),
            'impuesto' => $request->get('impuesto'),
            'total' => $request->get('total'),
            'estado' => 'registrado',
          ]);

            //array de deatalle
            $detalles=$request->data; 

            //recorro todos los elementos
           foreach($detalles as $ep=>$det)
            {
              DetalleVenta::create([
                    'id_venta' => $venta->id,
                    'id_articulo' => $det['id_articulo'],
                    'cantidad' => $det['cantidad'],
                    'precio' => $det['precio'],
                    'descuento' => $det['descuento'],
                ]);
            }


      }catch (ModelNotFoundException $e) {
        DB::rollBack();
      }

    }



      //function para desactivar una user
      public function anularVenta(Request $request)
      {
         if(!$request->ajax()){
          return redirect('/');
         }
  
          $venta = Venta::findOrFail($request->get('id'));
          $venta->estado='anulado';
          $venta->update();
      }



}
