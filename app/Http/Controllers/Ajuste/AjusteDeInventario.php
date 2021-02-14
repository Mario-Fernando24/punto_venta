<?php

namespace App\Http\Controllers\Ajuste;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ModelInventario\AjusteInventario;
use App\ModelInventario\DetalleAjusteInventario;
use App\Caja;
use App\Perfil;
use DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class AjusteDeInventario extends Controller
{
    
    public function index(Request $request)
    {
            
            if(!$request->ajax()){return redirect('/');}
            $buscar = $request->buscar;
            $criterio = $request->criterio;
            
            if($buscar==''){
                $ajuste = AjusteInventario::with('usuario_hizo_el_ajuste','usuario_anulo_el_ajuste')->orderBy('id', 'DESC')->paginate(10);
            }else{
                $ajuste = AjusteInventario::with('usuario_hizo_el_ajuste','usuario_anulo_el_ajuste')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
            }
            
            if(!empty($ajuste)){
                return response()->json([
                    'pagination' => [
                        'total'         => $ajuste->total(),
                        'current_page'  => $ajuste->currentPage(),
                        'per_page'      => $ajuste->perPage(),
                        'last_page'     => $ajuste->lastPage(),
                        'from'          => $ajuste->firstItem(),
                        'to'            => $ajuste->lastItem(),
                    ],
                    'ajuste' => $ajuste
                ], 200);

            }else{  
                return response()->json(['status' => 'error','message' => "No encontramos Ningun dato", ], 401);
                }


    }

    public function ajusteInventarioEntra(Request $request)
    {

        $mytime=Carbon::now('America/Bogota');
        $id_caja_users=DB::table('caja')
        ->where('id_vendedor',\Auth::user()->id)
        ->where('Cajaactual','abierto')->first();

        try{

                $addAjusteInventario = AjusteInventario::create([
                    'id_usuario' => \Auth::user()->id,
                    'id_apertura_caja_usuario' => $id_caja_users->idcaja,
                    'tipo_ajuste' => 'ENTRA',
                    'motivo' => $request->get('motivo'),
                    'impuesto'=> (($request->get('total')*$request->get('impuesto'))/100),
                    'total' => $request->get('total'),
                    ]);

                    //array de deatalle
                   $detalles=$request->get('data'); 

                    foreach($detalles as $ep=>$det)
                    {
                        $ajusteDetalles=DetalleAjusteInventario::create([
                            'id_ajusteinventario' => $addAjusteInventario->id,
                            'id_articulo' => $det['idarticulo'],
                            'tipo_ajuste'=>'ENTRA',
                            'precio' => $det['precio'],
                            'cantidad_existencia' => $det['stock'],
                            'cantidad_entran' => $det['cantidad'],
                            'cantidad_quedan' => $det['stock']+$det['cantidad'],
                        ]);
                    }

                    



                    if(!empty($ajusteDetalles)){
                    return response()->json([ 'status' => 'ok',], 200);
                    }else{
                    return response()->json([ 'status' => 'error',], 401);
                    }



        }catch (ModelNotFoundException $e) {
            DB::rollBack();
        }

    }
    public function ajusteInventarioSale(Request $request)
    {
        $mytime=Carbon::now('America/Bogota');
        $id_caja_users=DB::table('caja')
        ->where('id_vendedor',\Auth::user()->id)
        ->where('Cajaactual','abierto')->first();

        try{

                $addAjusteInventario = AjusteInventario::create([
                    'id_usuario' => \Auth::user()->id,
                    'id_apertura_caja_usuario' => $id_caja_users->idcaja,
                    'tipo_ajuste' => 'SALE',
                    'motivo' => $request->get('motivo'),
                    'impuesto'=> (($request->get('total')*$request->get('impuesto'))/100),
                    'total' => $request->get('total'),
                    ]);

                    //array de deatalle
                   $detalles=$request->get('data'); 

                    foreach($detalles as $ep=>$det)
                    {
                        $ajusteDetalles=DetalleAjusteInventario::create([
                            'id_ajusteinventario' => $addAjusteInventario->id,
                            'id_articulo' => $det['idarticulo'],
                            'tipo_ajuste'=>'SALE',
                            'precio' => $det['precio'],
                            'cantidad_existencia' => $det['stock'],
                            'cantidad_entran' => $det['cantidad'],
                            'cantidad_quedan' =>$det['stock']-$det['cantidad'],
                        ]);
                    }
                    if(!empty($ajusteDetalles)){
                    return response()->json([ 'status' => 'ok',], 200);
                    }else{
                    return response()->json([ 'status' => 'error',], 401);
                    }



        }catch (ModelNotFoundException $e) {
            DB::rollBack();
        }

    }

    public function getObjetoDetalleAjuste(Request $request)
    {
      
       if(!$request->ajax()){return redirect('/'); }

        $id = $request->id;
        $ObjetoDetalleAjuste = AjusteInventario::with('usuario_hizo_el_ajuste','usuario_anulo_el_ajuste')
        ->where('id',$id)->orderBy('id', 'DESC')->first();

        return response()->json([ 'status' => 'ok','ObjetoDetalleAjuste'=>$ObjetoDetalleAjuste], 200);
  
    }


    public function getArrayDetalleAjuste(Request $request)
    {

        // if(!$request->ajax()){return redirect('/'); }

         $id = $request->id;
        $DetalleAjusteArray = DetalleAjusteInventario::with('articulo_Detalle_Ajuste')
        ->where('id_ajusteinventario',$id)->orderBy('id', 'ASC')->get();
        
        return response()->json([ 'status' => 'ok','DetalleAjusteArray'=>$DetalleAjusteArray], 200);
      
    }

    public function ajusteInventarioPdf($id)
    {

        $ObjetoDetalleAjuste = AjusteInventario::with('usuario_hizo_el_ajuste','usuario_anulo_el_ajuste')
        ->where('id',$id)->orderBy('id', 'DESC')->first();

        $DetalleAjusteArray = DetalleAjusteInventario::with('articulo_Detalle_Ajuste')
        ->where('id_ajusteinventario',$id)->orderBy('id', 'ASC')->get();
        
        $mytime=Carbon::now('America/Bogota');

        $Perfil = Perfil::with('GetUser')->first();
        $image='img/company/'.$Perfil->image_perfil;
        
        $pdf = PDF::loadView('pdf.ajusteInventario',compact('ObjetoDetalleAjuste','DetalleAjusteArray','Perfil','image','mytime'));
        return $pdf->download('AjusteInventario-'.$ObjetoDetalleAjuste->id.'-'.$mytime);   
      
    }


}
