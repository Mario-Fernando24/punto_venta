<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    
    protected $table = 'articulos';
    protected $primaryKey = 'id';

     
    protected $fillable = [
        'id',
        'idcategoria',
        'codigo',
        'nombre',
        'precio_venta',
        'stock',
        'descripcion',
        'condicion',
        'avatar'
    ];
    //1 articulor pertenece a una categoria
    public function categoria(){
        return $this->belongsTo(Categoria::class,'idcategoria');

    }

    public function comprashas(){
        return $this->belongsTo(DetalleIngreso::class,'id','idarticulo');

    }


    
}
