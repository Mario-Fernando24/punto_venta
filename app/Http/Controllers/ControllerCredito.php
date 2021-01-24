<?php

namespace App\Http\Controllers;
use App\Credito;
use App\AbonoCredito;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ControllerCredito extends Controller
{
    public function index(Request $request)
    {

     // if(!$request->ajax()){return redirect('/');}

      $buscar = $request->buscar;
      $criterio = $request->criterio;

       if($buscar==''){
          $credito = Credito::with('ventaCredito','clienteCredito','detallesVentaCredito','AbonoCredito.UserIngresado')->orderBy('idCredito', 'DESC')->paginate(10);
       }else{
          $credito = Credito::with('ventaCredito','clienteCredito','detallesVentaCredito','AbonoCredito.UserIngresado')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('idCredito', 'desc')->paginate(10);
       }

      return [
        'pagination' => [
            'total'         => $credito->total(),
            'current_page'  => $credito->currentPage(),
            'per_page'      => $credito->perPage(),
            'last_page'     => $credito->lastPage(),
            'from'          => $credito->firstItem(),
            'to'            => $credito->lastItem(),
        ],
        'credito' => $credito
    ];
    
    } 

    public function abonarCredito(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}

        try {
          $estado=$request->get('estado');  

            $id_caja_users=DB::table('caja')
            ->where('id_vendedor',\Auth::user()->id)
            ->where('Cajaactual','abierto')->first();

            $AbonoCredito = AbonoCredito::create([
            'id_Credito' => $request->get('credito_id'),
            'idusers' => \Auth::user()->id,
            'id_caja'=>$id_caja_users->idcaja,
            'montoAbonar' => $request->get('montoAbonar'),
            'observacion' => $request->get('observacionAbono'),

            ]);

            if($estado==1){
                $credito = Credito::findOrFail($request->get('credito_id'));
                $credito->estado='1';
                $credito->update();
            }

        return response()->json([
            'status' => 'ok',
            'AbonoCredito' => $AbonoCredito,
        ], 200);

        } catch (\Exception $exception) {
            return redirect()->route('main');
        }




    }

}
