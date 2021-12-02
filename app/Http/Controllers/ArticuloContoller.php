<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Categoria;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ArticuloContoller extends Controller
{
    
    public function index(Request $request)
    {   
        if(!$request->ajax()){return redirect('/');}

        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){

          $articulos = Articulo::with('categoria')->orderBy('idcategoria', 'desc')->paginate(10);

         }else{

            $articulos = Articulo::with('categoria')->where($criterio, 'like', '%'.$buscar.'%')->orderBy('idcategoria', 'desc')->paginate(10);
         }
        return [
            'pagination' => [
                //numero total de registro
                'total'         => $articulos->total(),
                //Obtenga el número de página actual.
                'current_page'  => $articulos->currentPage(),
                //El número de elementos que se mostrarán por página.
                'per_page'      => $articulos->perPage(),
              //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                'last_page'     => $articulos->lastPage(),
                //desde la pagina
                'from'          => $articulos->firstItem(),
                //hasta la pagina
                'to'            => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }


    public function buscarArticuloBarra(Request $request){
       
        if(!$request->ajax()){return redirect('/');}

           $filtro=$request->get('filtro');
           $buscarBarra=Articulo::where('codigo',$filtro)
           ->select('id','nombre','stock','precio_venta','condicion')->orderBy('nombre','asc')
           ->take(1)->get();

           return ['buscarBarra' => $buscarBarra];
    }

    public function validateCodeBarra(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}

        $codigo=$request->get('filtro');
        $buscarBarra=Articulo::where('codigo',$codigo)
        ->first();
        
        if($buscarBarra){
            return ['validate' => true];
        }

        return ['validate' => false];
        
    }
    


    public function store(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}

        $articulo = Articulo::create([
        'idcategoria' => $request->get('idcategoria'),
        'codigo' => $request->get('codigo'),
        'nombre' =>  $request->get('nombre'),
        'precio_venta' => $request->get('precio_venta'),
        'stock' => $request->get('stock'),
        'descripcion' => $request->get('descripcion'),
        'condicion' => '1',

        ]);

    }


    public function update(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}

        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }


    public function editarImagen(Request $request)
    {

        try 
       {
                   $hora=Carbon::now('America/Bogota');
                   $hora = str_replace(":", "-", $hora);
                if ($request->hasFile('editarProductImagen')) {      
                    $file=$request->file('editarProductImagen');
                    $file->move(base_path().'/public/img/productos',str_replace(" ", "_",$hora.$file->getClientOriginalName()));
                    $imageName= str_replace(" ", "_",$hora.$file->getClientOriginalName());
                    $products = Articulo::findOrFail($request->get('articulo_id'));
                    $products->avatar =$imageName; 
                    $products->update();
                return response()->json([ 'status' => true,], 200);
                 }else{
                   $imageName='no-image.png';
                    return response()->json([ 'status' => false,], 200);
                }
        } catch (\Exception $exception) {
            return response()->json([$exception->getMessage()], 401);
        }    


    }


       //function para desactivar una categoria
    public function desactivar(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion='0';
        $articulo->update();
    }

    
    //function para activar una categoria
    public function activar(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}

        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion='1';
        $articulo->update();
    }

    public function ListarPdfInventario()
    {

        
        $inventariopdf = Articulo::with('categoria','comprashas')->orderBy('idcategoria', 'asc')->get();


        //cantidad de articulos que tenemos en nuestra entidad articulo 
        $cantidad=Articulo::count();


        $pdf = PDF::loadView('pdf.articuloInventario',['inventariopdf'=>$inventariopdf,'cantidad'=>$cantidad]);
        $mytime=Carbon::now('America/Bogota');


        return $pdf->download('inventario_articulos-'.$mytime);  


    }


}
