<?php

namespace App\Http\Controllers\Ajuste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ModelInventario\AjusteInventario;
use App\Caja;


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

        $cajaOpen = Caja::with('apertura_vendedor')
        ->where('id_vendedor',\Auth::user()->id)->orderBy('idcaja', 'desc')->first();


        $addAjusteInventario = AjusteInventario::create([
            'id_usuario' => \Auth::user()->id,
            'id_apertura_caja_usuario' => $cajaOpen->idcaja,
            'tipo_ajuste' => $request->get('tipo_ajuste'),
            'motivo' => $request->get('motivo'),
            'impuesto' => $request->get('impuesto'),
            'total' => $request->get('total'),
            ]);

    }
    public function ajusteInventarioSale(Request $request)
    {

    }


}
