<?php

namespace App\ModelInventario;

use Illuminate\Database\Eloquent\Model;

class DetalleAjusteInventario extends Model
{
    
    protected $table = 'detalle_ventas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_ajusteinventario',
        'id_articulo',
        'precio',
        'cantidad_existencia',
        'cantidad_entran',
        'cantidad_quedan'
    ];

    public function articulo_Detalle_Ajuste()
    {
        return $this->belongsTo(Articulo::class,'id_articulo','id');
        
    }

}
