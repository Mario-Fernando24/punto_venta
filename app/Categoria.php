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

     //relacion de 1 a n plural 
    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }


    protected $guarded = [

    ];



}
