<?php

namespace App\Http\Controllers\Ajuste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\ModelInventario\AjusteInventario;
use App\ModelInventario\DetalleAjusteInventario;
use App\Caja;

use DB;
use Carbon\Carbon;

class AjusteDeInventario extends Controller
{
    
    public function index(Request $request)
    {
     //   $example=DetalleAjusteInventario::all();

     //   return $example;
            
            if(!$request->ajax()){return redirect('/');}
            $buscar = $request->buscar;
            $criterio = $request->criterio;
            
            if($buscar==''){
                $ajuste = AjusteInventario::with('usuario_hizo_el_ajuste','usuario_anulo_el_ajuste')->orderBy('id', 'DESC')->paginate(10);
            }else{
                $ajuste = AjusteInventario::with('usuario_hizo_el_ajuste','usuario_anulo_el_ajuste')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('idegreso', 'desc')->paginate(10);
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


                   $detallesss=DetalleAjusteInventario::create([
                            'id_ajusteinventario' => 68,
                            'id_articulo' => 6,
                            'precio' => 1,
                            'cantidad_existencia' => 1,
                            'cantidad_entran' => 1,
                            'cantidad_quedan' => 1,
                        ]);
                    


        }catch (ModelNotFoundException $e) {
            DB::rollBack();
        }

    }
    public function ajusteInventarioSale(Request $request)
    {

    }


}
