<?php

namespace App\Http\Controllers;

use App\Venta;
use App\DetalleVenta;
use App\Articulo;
use App\Persona;
use DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {   
         if(!$request->ajax()){return redirect('/');}

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

    //search article from code of barra
    public function buscarArticuloVentaBarra(Request $request){
      if(!$request->ajax()){
          return redirect('/');
     }
          $filtro=$request->get('filtro');
          $buscarBarra=Articulo::where('codigo',$filtro)
          ->select('id','nombre','stock','precio_venta','condicion')->orderBy('nombre','asc')
          ->where('stock','>','0')
          ->take(1)->get();

          return ['buscarBarra' => $buscarBarra];
   }

   public function ListarArticuloVenta(Request $request)
   {   

       //if(!$request->ajax()){ return redirect('/');}
       $buscar = $request->buscar;
       $criterio = $request->criterio;

        if($buscar==''){

         $listarticulos = Articulo::with('categoria')->where('stock','>','0')->orderBy('id', 'desc')->paginate(10);

        }else{

           $listarticulos = Articulo::with('categoria')->where('stock','>','0')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
        }


       return ['listarticulos' => $listarticulos];
   }


    public function selectCliente(Request $request){

      if(!$request->ajax()){return redirect('/'); }

        $filtro=$request->get('filtro');


        $cliente = Persona::orderBy('id', 'DESC')
        ->where('nombre', 'like', '%'.$filtro.'%')
        ->orwhere('num_documento', 'like', '%'.$filtro.'%')
        ->get();
        
        return ['cliente' => $cliente];
      
    }


    public function getObjetoDetalleVenta(Request $request)
    {
      
      if(!$request->ajax()){return redirect('/'); }

        $id = $request->id;
        $ObjetoDetalleVent = Venta::with('cliente_persona','usuario_hizola_venta','usuario_anulo_venta')
        ->where('id',$id)->orderBy('id', 'DESC')->take(1)->get();

 
        return ['ObjetoDetalleVent' => $ObjetoDetalleVent];
  
    }
    
    
    public function getArrayDetalleVenta(Request $request)
    {

      // if(!$request->ajax()){return redirect('/'); }

        $id = $request->id;
        $ArrayDetalleVenta = DetalleVenta::with('articulo_Detalle_Venta')
        ->where('id_venta',$id)->orderBy('id', 'ASC')->get();

        return ['ArrayDetalleVenta' => $ArrayDetalleVenta];  
      
      }


    
    
      



    public function store(Request $request)
    {
       if(!$request->ajax()){
        return redirect('/');
       }
       $mytime=Carbon::now('America/Bogota');

       try{






          $venta = Venta::create([
            'id_cliente' => $request->get('idcliente'),
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
                    'id_articulo' => $det['idarticulo'],
                    'cantidad' => $det['cantidad'],
                    'precio' => $det['precio'],
                    'descuento' => $det['descuento'],
                ]);
            }

            return ['id' => $venta->id];



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
          $venta->id_anulo_venta=\Auth::user()->id;
          $venta->update();
      }


       public function pdfVenta(Request $request, $id){


        $ObjetoDetalleVent = Venta::with('cliente_persona','usuario_hizola_venta','usuario_anulo_venta')
        ->where('id',$id)->orderBy('id', 'DESC')->first();
        
        $ArrayDetalleVenta = DetalleVenta::with('articulo_Detalle_Venta')
        ->where('id_venta',$id)->orderBy('id', 'ASC')->get(); 
        $mytime=Carbon::now('America/Bogota');
         


        $pdf = PDF::loadView('pdf.ventas',compact('ObjetoDetalleVent','ArrayDetalleVenta'));
        return $pdf->download('venta-'.$ObjetoDetalleVent->id.'-'.$mytime);   
      
      }



}
