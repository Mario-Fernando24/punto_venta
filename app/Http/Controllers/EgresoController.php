<?php

namespace App\Http\Controllers;
use App\Egreso;
use App\Caja;
use App\Perfil;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class EgresoController extends Controller
{

    public function index(Request $request)
    {
      if(!$request->ajax()){return redirect('/');}


      $buscar = $request->buscar;
      $criterio = $request->criterio;

       if($buscar==''){
          $GetEgreso = Egreso::with('GetUser')->orderBy('idegreso', 'DESC')->paginate(10);
       }else{
          $GetEgreso = Egreso::with('GetUser')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('idegreso', 'desc')->paginate(10);
       }

      return [
        'pagination' => [
            'total'         => $GetEgreso->total(),
            'current_page'  => $GetEgreso->currentPage(),
            'per_page'      => $GetEgreso->perPage(),
            'last_page'     => $GetEgreso->lastPage(),
            'from'          => $GetEgreso->firstItem(),
            'to'            => $GetEgreso->lastItem(),
        ],
        'GetEgreso' => $GetEgreso
    ];


    
    } 

    public function registerDocumentoCaja(Request $request)
    {
        
       if(!$request->ajax()){return redirect('/');}
        $cajaOpen = Caja::with('apertura_vendedor')->where('id_vendedor',\Auth::user()->id)->where('Cajaactual','abierto')->orderBy('idcaja', 'desc')->first();

        $caja = Egreso::create([
        'id_caja' => $cajaOpen->idcaja,
        'id_users' => \Auth::user()->id,
        'tipo_egreso' => $request->get('tipo_egreso'),
        'valor_egreso' => $request->get('valor_egreso'),
        'motivo_egreso' => $request->get('motivo_egreso'),
        ]);

        return response()->json([
          'status' => 'ok',
          'message' => "add",
        ], 200);

    }

    public function ValidateOpenCaja()
    {
     $cajaOpen = Caja::with('apertura_vendedor')->where('id_vendedor',\Auth::user()->id)->where('Cajaactual','abierto')->orderBy('idcaja', 'desc')->first();

     if(!empty($cajaOpen)){
      return response()->json([
          'status' => 'ok',
          'cajaOpen' => $cajaOpen,
      ], 200);
      }else{

        return response()->json([
          'status' => 'error',
          'message' => "No encontramos caja abierta",
      ], 200);


      }

    }


       public function AnularDocumentoCaja(Request $request)
       {
          if(!$request->ajax()){
           return redirect('/');
          }
   
           $egreso = Egreso::findOrFail($request->id);
           $egreso->estado='0';
           $egreso->update();

           return response()->json([
            'status' => 'ok',
            'message' => "remove exit",
           ], 200);

       }


       public function pdfEgreso(Request $request, $id)
       {


        $egreso = Egreso::findOrFail($request->id);

        $mytime=Carbon::now('America/Bogota');

        $Perfil = Perfil::with('GetUser')->first();
        $image='img/company/'.$Perfil->image_perfil;
        
        $pdf = PDF::loadView('pdf.egresoimprimir',compact('egreso','Perfil','image','mytime'));
        return $pdf->download('EGRESO-'.$egreso->id.'-'.$mytime);   
      
       }
   


}
