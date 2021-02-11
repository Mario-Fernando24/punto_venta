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
        'precio',
        'descuento',
    ];


    public function articulo_Detalle_Venta()
    {
        return $this->belongsTo(Articulo::class,'id_articulo','id');
        
    }

   

    public $timestamps=false;

}
