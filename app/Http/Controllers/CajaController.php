<?php

namespace App\Http\Controllers;
use App\Caja;
use App\Venta;
use App\Egreso;
use App\DetalleVenta;
use App\AbonoCredito;
use App\Perfil;
use App\ModelInventario\AjusteVenta;
use DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;


use Illuminate\Http\Request;

class CajaController extends Controller
{

    public function index(Request $request)
    {        
        if(!$request->ajax()){  return redirect('/');}

        $listaCaja = Caja::with('apertura_vendedor')->orderBy('idcaja', 'DESC')->paginate(10);
      
       return [
        'pagination' => [
            //numero total de registro
            'total'         => $listaCaja->total(),
            //Obtenga el número de página actual.
            'current_page'  => $listaCaja->currentPage(),
            //El número de elementos que se mostrarán por página.
            'per_page'      => $listaCaja->perPage(),
          //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
            'last_page'     => $listaCaja->lastPage(),
            //desde la pagina
            'from'          => $listaCaja->firstItem(),
            //hasta la pagina
            'to'            => $listaCaja->lastItem(),
        ],
        'listaCaja' => $listaCaja
    ];




    }


    public function ShowCajaUser()
    {
        $cajaOpen = Caja::with('apertura_vendedor')
        ->where('id_vendedor',\Auth::user()->id)->orderBy('idcaja', 'desc')->first();

        $Efectivo_de_Ventas = AjusteVenta::where('id_users', \Auth::user()->id)
        ->where('id_caja', $cajaOpen->idcaja)
        ->where('estado',1)
        ->where('efectivo','>',0)
        ->get()->sum('efectivo');


        $transferencia_ventas = AjusteVenta::where('id_users', \Auth::user()->id)
        ->where('id_caja', $cajaOpen->idcaja)
        ->where('estado',1)
        ->where('tranferencia','>',0)
        ->get()->sum('tranferencia');



        
        $datafono_Ventas = AjusteVenta::where('id_users', \Auth::user()->id)
        ->where('id_caja', $cajaOpen->idcaja)
        ->where('estado',1)
        ->where('datafono','>',0)
        ->get()->sum('datafono');


        $Credito = AjusteVenta::where('id_users', \Auth::user()->id)
        ->where('id_caja', $cajaOpen->idcaja)
        ->where('estado',1)
        ->where('credito','>',0)
        ->get()->sum('credito');



        $Egreso = Egreso::where('id_users', \Auth::user()->id)
        ->where('id_caja', $cajaOpen->idcaja)
        ->where('estado',1)
        ->get()->sum('valor_egreso');

        $IngresoAbonoCredito = AbonoCredito::where('idusers', \Auth::user()->id)
        ->where('id_caja', $cajaOpen->idcaja)
        ->get()->sum('montoAbonar');


        if(!empty($cajaOpen)){
       
        return response()->json([
            'status' => 'ok',
            'cajaOpen' => $cajaOpen,
            'Efectivo_de_Ventas'=>$Efectivo_de_Ventas,
            'transferencia_ventas'=>$transferencia_ventas,
            'datafono_Ventas'=>$datafono_Ventas,
            'Egreso'=>$Egreso,
            'Credito'=>$Credito,
            'IngresoAbonoCredito'=>$IngresoAbonoCredito,
        ], 200);
        }else{

        return response()->json([
            'status' => 'primera apertura caja',
            'cajaOpen' => 'new',
            'Efectivo_de_Ventas'=>'0',
            'transferencia_ventas'=>'0',
            'datafono_Ventas'=>'0',
            'Egreso'=>'0',
            'Credito'=>'0',
            'IngresoAbonoCredito'=>'0',
        ], 404);

        }

    }  
 


    public function aperturaCaja(Request $request)
    {
       if(!$request->ajax()){
        return redirect('/');
       }
       $mytime=Carbon::now('America/Bogota');
        
       //return $request->get('dinero_inicial');
        $caja = Caja::create([
        'id_vendedor' => \Auth::user()->id,
        'Cajainicial' => $request->get('Cajainicial'),
        'Fecha' => $mytime,
        'Cajaactual' => 'abierto',
        'obs_apertura' => $request->get('obs_apertura'),
        'obs_final' => 'no cerrado',
        'dinero_inicial' => json_encode($request->get('dinero_inicial')),
        'dinero_final' => '0',
        ]);
    }  
   
    public function cerrarCaja()
    {

      $cajaOpen = Caja::with('apertura_vendedor')
      ->where('id_vendedor',\Auth::user()->id)->orderBy('idcaja', 'desc')->first();

      $cajaUpdate = Caja::findOrFail($cajaOpen->idcaja);
      $cajaUpdate->Cajaactual='cerrado';
      $cajaUpdate->update();

        return response()->json([
            'status' => 'ok'], 200);
        

    }

    public function imprimircerrarCaja()
    {
       
      //  if(!$request->ajax()){
      //  return redirect('/');
      // }

      $mytime=Carbon::now('America/Bogota');

      $cajaOpen = Caja::with('apertura_vendedor')
      ->where('id_vendedor',\Auth::user()->id)->orderBy('idcaja', 'desc')->first();




      //# numero de facturas por arqueos
      $numFacArqueosRegistrado=DB::table('ventas')
      ->select(DB::raw('count(*) as total'))
      ->where('id_apertura_caja_usuario',$cajaOpen->idcaja)
      ->where('estado','registrado')
      ->first();

      $numFacArqueosAnulado=DB::table('ventas')
      ->select(DB::raw('count(*) as total'))
      ->where('id_apertura_caja_usuario',$cajaOpen->idcaja)
      ->where('estado','anulado')
      ->first();

      

      //Ingreso // =========================================
      $nomina = Egreso::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','nomina')
      ->get()->sum('valor_egreso');


      $Cortesia = Egreso::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','cortesia')
      ->get()->sum('valor_egreso');



      $GastoAdministrativo = Egreso::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','gastoadmin')
      ->get()->sum('valor_egreso');
      

      //Ingreso end // =========================================


      $Credito = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('credito','>',0)
      ->get()->sum('credito');

      //end Credito ============================================

      //======== datafono and transferencia ====================

             
      $Transferencia = AjusteVenta::where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tranferencia','>',0)
      ->get();



      $Datafono = AjusteVenta::where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('datafono','>',0)
      ->get();

      //======================star 


      $efectivo_de_Ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('efectivo','>',0)
      ->get()->sum('efectivo');


      $transferencia_ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tranferencia','>',0)
      ->get()->sum('tranferencia');

      $datafono_Ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('datafono','>',0)
      ->get()->sum('datafono');




      //=================== end ==============

      
      $IngresoAbonoCredito = AbonoCredito::where('idusers', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->get()->sum('montoAbonar');


      $Egreso = Egreso::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->get()->sum('valor_egreso');

      //profile of company
        
      $Perfil = Perfil::with('GetUser')->first();


      //end of company
      


  

      //======== end datafono and transferencia ================
      $pdf = PDF::loadView('pdf.cierrecaja',compact('cajaOpen','numFacArqueosRegistrado','numFacArqueosAnulado','nomina','Cortesia','GastoAdministrativo','Credito','Transferencia','Datafono','efectivo_de_Ventas','transferencia_ventas','datafono_Ventas','IngresoAbonoCredito','Egreso','Perfil'));
      return $pdf->download('caja cerrada-'.$mytime);   

       
    }


    public function informeCaja(Request $request)
    {
       
      //  if(!$request->ajax()){
      //  return redirect('/');
      // }

      $mytime=Carbon::now('America/Bogota');

      $cajaOpen = Caja::with('apertura_vendedor')
      ->where('id_vendedor',\Auth::user()->id)->orderBy('idcaja', 'desc')->first();


      //# numero de facturas por arqueos
      $numFacArqueosRegistrado=DB::table('ventas')
      ->select(DB::raw('count(*) as total'))
      ->where('id_apertura_caja_usuario',$cajaOpen->idcaja)
      ->where('estado','registrado')
      ->first();

      $numFacArqueosAnulado=DB::table('ventas')
      ->select(DB::raw('count(*) as total'))
      ->where('id_apertura_caja_usuario',$cajaOpen->idcaja)
      ->where('estado','anulado')
      ->first();

      

      //Ingreso // =========================================
      $nomina = Egreso::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','nomina')
      ->get()->sum('valor_egreso');


      $Cortesia = Egreso::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','cortesia')
      ->get()->sum('valor_egreso');



      $GastoAdministrativo = Egreso::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','gastoadmin')
      ->get()->sum('valor_egreso');
      

      //Ingreso end // =========================================


      //Credito ================================================

      $Credito = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('credito','>',0)
      ->get()->sum('credito');


      //end Credito ============================================

      //======== datafono and transferencia ====================

      $Transferencia = AjusteVenta::where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tranferencia','>',0)
      ->get();


      $Datafono = AjusteVenta::where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('datafono','>',0)
      ->get();

      //======================star 

      $efectivo_de_Ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('efectivo','>',0)
      ->get()->sum('efectivo');


      $transferencia_ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tranferencia','>',0)
      ->get()->sum('tranferencia');

      $datafono_Ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('datafono','>',0)
      ->get()->sum('datafono');
      // end

      
      $IngresoAbonoCredito = AbonoCredito::where('idusers', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->get()->sum('montoAbonar');


      $Egreso = Egreso::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->get()->sum('valor_egreso');

      //profile of company
        
      $Perfil = Perfil::with('GetUser')->first();


      //end of company

      //======== end datafono and transferencia ================
      $pdf = PDF::loadView('pdf.cierrecaja',compact('cajaOpen','numFacArqueosRegistrado','numFacArqueosAnulado','nomina','Cortesia','GastoAdministrativo','Credito','Transferencia','Datafono','efectivo_de_Ventas','transferencia_ventas','datafono_Ventas','IngresoAbonoCredito','Egreso','Perfil'));
      return $pdf->download('InformeDecaja-'.$mytime);   

       
    }  




    public function detalleinformeCajaImpresa(Request $request)
    {

        

      $cajaId=$request->idcaja;
      $vendedorId=$request->idvendedor;


      $mytime=Carbon::now('America/Bogota');

      $cajaOpen = Caja::with('apertura_vendedor')
      ->where('idcaja',$cajaId)->first();



      //# numero de facturas por arqueos
      $numFacArqueosRegistrado=DB::table('ventas')
      ->select(DB::raw('count(*) as total'))
      ->where('id_apertura_caja_usuario',$cajaOpen->idcaja)
      ->where('estado','registrado')
      ->first();

      $numFacArqueosAnulado=DB::table('ventas')
      ->select(DB::raw('count(*) as total'))
      ->where('id_apertura_caja_usuario',$cajaOpen->idcaja)
      ->where('estado','anulado')
      ->first();

      

      //Ingreso // =========================================
      $nomina = Egreso::where('id_users', $vendedorId)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','nomina')
      ->get()->sum('valor_egreso');


      $Cortesia = Egreso::where('id_users', $vendedorId)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','cortesia')
      ->get()->sum('valor_egreso');



      $GastoAdministrativo = Egreso::where('id_users', $vendedorId)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tipo_egreso','gastoadmin')
      ->get()->sum('valor_egreso');
      

      //Ingreso end // =========================================


      //Credito ================================================

      $Credito = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('credito','>',0)
      ->get()->sum('credito');

      //end Credito ============================================

      //======== datafono and transferencia ====================

             
      $Transferencia = AjusteVenta::where('id_users', $vendedorId)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tranferencia','>',0)
      ->get();



      $Datafono = AjusteVenta::where('id_users', $vendedorId)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('datafono','>',0)
      ->get();

      //======================star 


      $efectivo_de_Ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('efectivo','>',0)
      ->get()->sum('efectivo');


      $transferencia_ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('tranferencia','>',0)
      ->get()->sum('tranferencia');

      $datafono_Ventas = AjusteVenta::where('id_users', \Auth::user()->id)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->where('datafono','>',0)
      ->get()->sum('datafono');




      // end

      
      $IngresoAbonoCredito = AbonoCredito::where('idusers', $vendedorId)
      ->where('id_caja', $cajaOpen->idcaja)
      ->get()->sum('montoAbonar');


      $Egreso = Egreso::where('id_users', $vendedorId)
      ->where('id_caja', $cajaOpen->idcaja)
      ->where('estado',1)
      ->get()->sum('valor_egreso');

      //profile of company
        
      $Perfil = Perfil::with('GetUser')->first();


      //end of company

      //======== end datafono and transferencia ================
      $pdf = PDF::loadView('pdf.cierrecaja',compact('cajaOpen','numFacArqueosRegistrado','numFacArqueosAnulado','nomina','Cortesia','GastoAdministrativo','Credito','Transferencia','Datafono','efectivo_de_Ventas','transferencia_ventas','datafono_Ventas','IngresoAbonoCredito','Egreso','Perfil'));
      return $pdf->download('InformeDecaja-'.$mytime.'-'.\Auth::user()->id);   

    } 
    
    




    









}
