<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{

    protected $table = 'detalle_ingresos';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'idingreso',
        'idarticulo',
        'cantidad',
        'precio',
    ];

}
