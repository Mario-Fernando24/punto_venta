<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Ingreso;
use App\DetalleIngreso;
use App\Articulo;
use App\Categoria;
use DB;
use Carbon\Carbon;

class IngresoController extends Controller
{
    
    public function index(Request $request)
    {   
         if(!$request->ajax()){
        return redirect('/');
        }

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


    public function ListarArticuloIngreso(Request $request)
    {   
        
       // if(!$request->ajax()){
       //    return redirect('/');
       //    }
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

          $ingreso = Ingreso::create([
            'idproveedor' => $request->get('idproveedor'),
            'idusuario' => \Auth::user()->id,
            'tipo_comprobante' => $request->get('tipo_comprobante'),
            'serie_comprobante' => $request->get('serie_comprobante'),
            'num_comprobante' => $request->get('num_comprobante'),
            'fecha_hora' => $mytime->toDateString(),
            'impuesto' => $request->get('impuesto'),
            'total' => $request->get('total'),
            'estado' => 'Registrado',
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
                ]);
            }

          //  return $persona  

      }catch (ModelNotFoundException $e) {
        DB::rollBack();
      }

    }



      //function para desactivar una user
      public function desactivar(Request $request)
      {
         if(!$request->ajax()){
          return redirect('/');
         }
  
          $ingreso = Ingreso::findOrFail($request->id);
          $ingreso->estado='Anulado';
          $ingreso->update();
      }



}




