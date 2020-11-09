<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'condicion',
    ];

     //relacion de 1 a n plural  1 categoria tiene varios articulos
    public function articulos()
    {
        return $this->hasMany(Articulo::class,'idcategoria');
        
    }

}
