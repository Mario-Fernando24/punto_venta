<?php

namespace App\ModelInventario;

use Illuminate\Database\Eloquent\Model;

class AjusteCompra extends Model
{
    protected $table = 'ajuste_compras';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_compra',
        'id_caja',
        'id_users',
        'efectivo',
        'credito',
        'abono',
        'estado',
    ];
}
