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
    ];
    //1 articulor pertenece a una categoria
    public function categoria(){
        return $this->belongsTo('App\Categoria');

    }
}
