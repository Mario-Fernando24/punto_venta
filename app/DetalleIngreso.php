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
        'preciocompra',

    ];

    
    public function articulodetalle()
    {
        return $this->belongsTo(Articulo::class,'idarticulo','id');
        
    }

}
