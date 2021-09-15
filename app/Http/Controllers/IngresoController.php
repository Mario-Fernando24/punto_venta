<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Ingreso;
use App\Venta;
use App\DetalleIngreso;
use App\Articulo;
use App\Categoria;
use App\Perfil;
use App\ModelInventario\AjusteCompra;
use App\Caja;
use App\Persona;
use DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class IngresoController extends Controller
{

   public function showNotificacion(Request $request)
   {

      // if(!$request->ajax()){return redirect('/');}
            $fechaActual=date('Y-m-d');
            $numIngresos = Ingreso::whereDate('created_at',$fechaActual)->count();
            $numVentas = Venta::whereDate('created_at',$fechaActual)->count();


            $arregloDatos= [
                'ingresos' => [
                  'numero'=> $numIngresos,
                  'msj' => 'Compras'
                ],
                'ventas' => [
                     'numero'=> $numVentas,
                     'msj' => 'Ventas'
                ]
            ];
            return response()->json(['status' => 'ok','arregloDatos' => $arregloDatos, ], 200);

   }
    
    public function index(Request $request)
    {   
         if(!$request->ajax()){return redirect('/');}

        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){
            $ingreso = Ingreso::with('usuario','proveedor','proveedoress','persona')->orderBy('id', 'DESC')->paginate(10);

         }else{ 
            $ingreso = Ingreso::with('usuario','proveedor','proveedoress','persona')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
         }


        return [
            'pagination' => [
                'total'         => $ingreso->total(),
                'current_page'  => $ingreso->currentPage(),
                'per_page'      => $ingreso->perPage(),
                'last_page'     => $ingreso->lastPage(),
                'from'          => $ingreso->firstItem(),
                'to'            => $ingreso->lastItem(),
            ],
            'ingreso' => $ingreso
        ];
    }


    public function getObjetoDetalleIngreso(Request $request)
    {
      
      if(!$request->ajax()){return redirect('/'); }

        $id = $request->id;
        $ObjetoDetalleIngreso = Ingreso::with('proveedor','proveedoress','usuario','persona','usuario_anulo_ingreso')
        ->where('id',$id)->orderBy('id', 'DESC')->take(1)->get();


        return ['ObjetoDetalleIngreso' => $ObjetoDetalleIngreso];
  
    }

    public function getArrayDetalleIngreso(Request $request)
    {

      if(!$request->ajax()){return redirect('/'); }

        $id = $request->id;
        $ArrayDetalleIng = DetalleIngreso::with('articulodetalle')
        ->where('idingreso',$id)->orderBy('id', 'ASC')->get();
        return ['ArrayDetalleIng' => $ArrayDetalleIng];  
      
    }


    public function ListarArticuloIngreso(Request $request)
    {   
        
        if(!$request->ajax()){return redirect('/');}

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
      if(!$request->ajax()){return redirect('/');}

       $mytime=Carbon::now('America/Bogota');

       $id_caja_users=DB::table('caja')
       ->where('id_vendedor',\Auth::user()->id)
       ->where('Cajaactual','abierto')->first();


       if($id_caja_users==false){
         
       }

       //pendiente validación si false consulta pasar parametro con laravel

       try{

          $ingreso = Ingreso::create([
            'idproveedor' => $request->get('idproveedor'),
            'idusuario' => \Auth::user()->id,
            'id_apertura_caja_usuario'=>$id_caja_users->idcaja,
            'tipo_comprobante' => $request->get('tipo_comprobante'),
            'serie_comprobante' => $request->get('serie_comprobante'),
            'num_comprobante' => $request->get('num_comprobante'),
            'fecha_hora' => $mytime->toDateString(),
            'impuesto' => $request->get('impuesto'),
            'forma_pago'=> $request->get('forma_pago_compra'),
            'total' => $request->get('total'),
            'estado' => 'registrado',
          ]);


          AjusteCompra::create([
            'id_compra' => $ingreso->id,
            'id_caja' => $ingreso->id_apertura_caja_usuario,
            'id_users' => $ingreso->idusuario,
            'credito'=> $request->get('credito'),
            'efectivo'=> $request->get('efectivo'),
            'abono' => 0,
          ]);


            //array de deatalle
            $detalles=$request->data; 

            //recorro todos los elementos
           foreach($detalles as $ep=>$det)
            {
                DetalleIngreso::create([
                    'idingreso' => $ingreso->id,
                    'idarticulo' => $det['idarticulo'],
                    'cantidad' => $det['cantidad'],
                    'precio' => $det['precio'],
                    'preciocompra' => $det['preciocompra'],
                ]);
            }


            foreach($detalles as $ep=>$det)
            {
              $update_price_articulo = Articulo::findOrFail($det['idarticulo']);
              $update_price_articulo->precio_venta=$det['precio'];
              $update_price_articulo->update();
            }

            //===============================================================//
            

      }catch (ModelNotFoundException $e) {
        DB::rollBack();
      }

    }

      //function para desactivar una user
      public function anularIngreso(Request $request)
      {
         if(!$request->ajax()){return redirect('/');}
  
          $ingreso = Ingreso::findOrFail($request->get('id'));
          $ingreso->estado='anulado';
          $ingreso->id_anulo_ingreso=\Auth::user()->id;
          $ingreso->update();
      }

      
      public function pdfIngreso(Request $request, $id){

        $Perfil = Perfil::with('GetUser')->first();

        $ObjetoDetalleIngreso = Ingreso::with('proveedor','proveedoress','usuario','persona','usuario_anulo_ingreso')
        ->where('id',$id)->orderBy('id', 'DESC')->first();

        $ArrayDetalleIng = DetalleIngreso::with('articulodetalle')
        ->where('idingreso',$id)->orderBy('id', 'ASC')->get();
        $mytime=Carbon::now('America/Bogota');

        $image='img/company/'.$Perfil->image_perfil;

        $pdf = PDF::loadView('pdf.ingreso',compact('ObjetoDetalleIngreso','ArrayDetalleIng','Perfil','image'));
        
        return $pdf->download('compra-'.$ObjetoDetalleIngreso->id.'-'.$mytime);   
      }




       public function showComprasId(Request $request){

              $showDeudaCompra = Ingreso::with('AjusteCompra','detalleCompraArticulos','detalleCompraArticulos.articulodetalle')
              ->where('id',$request->get('id'),)->orderBy('id', 'DESC')->first();

              return response()->json([ 'status' => 'ok','ObjetoDetalleAjuste'=>$showDeudaCompra], 200);

       }


       public function registrarAbonoCompra(Request $request)
       {

            $id_caja_users=DB::table('caja')
            ->where('id_vendedor',\Auth::user()->id)
            ->where('Cajaactual','abierto')->first();

            AjusteCompra::create([
              'id_compra' => $request->get('id_compra'),
              'id_caja' => $id_caja_users->idcaja,
              'id_users' => \Auth::user()->id,
              'abono' => $request->get('abono'),
              'observacionFormaPago' => $request->get('observacionFormaPago'),
            ]);

            return response()->json([ 'status' => true], 200);
            
       }



       public function descargaComprobantePago(Request $request){

              $Perfil = Perfil::with('GetUser')->first();
              $mytime=Carbon::now('America/Bogota');

              // $proveedoress = Persona::where('idproveedor',$resq->idproveedor)->first();
              $showDeudaCompra = Ingreso::with('AjusteCompra','detalleCompraArticulos','detalleCompraArticulos.articulodetalle')
              ->where('id',$request->get('id'))->orderBy('id', 'DESC')->first();

              $arrayAbonooooo=AjusteCompra::where('id_compra',$showDeudaCompra->id)->get();
              $proveedoress = Persona::findOrFail($showDeudaCompra->idproveedor);

               $pdf = PDF::loadView('pdf.comprobantePago',compact('Perfil','proveedoress','arrayAbonooooo','showDeudaCompra','mytime'));
        
               return $pdf->download('comprobante de pago  -   '.$mytime);   
      
       }

}




