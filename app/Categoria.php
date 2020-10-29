<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
  //  public $timestamps = false;
    
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'condicion',
    ];

    protected $guarded = [

    ];



}
