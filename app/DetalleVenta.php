<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    
    protected $table = 'detalle_ventas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_venta',
        'id_articulo',
        'cantidad',
        'forma_pago',
        'precio',
        'descuento',
    ];

    public $timestamps=false;

}
